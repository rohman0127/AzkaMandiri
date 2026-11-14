<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with(['supplier', 'items.product'])->latest('purchase_date');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($sq) use ($search) {
                      $sq->where('company_name', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $purchases = $query->paginate(15)->withQueryString();
        $suppliers = Supplier::where('is_active', true)->orderBy('company_name')->get();

        return view('admin.purchases.index', compact('purchases', 'suppliers'));
    }

    public function create()
    {
        $suppliers = Supplier::where('is_active', true)->orderBy('company_name')->get();
        $products = Product::where('is_active', true)->with(['category', 'unit'])->orderBy('name')->get();

        // Generate automatic purchase invoice number
        $datePrefix = 'PO-' . date('Ym') . '-';
        $latestPo = Purchase::where('invoice_number', 'like', "{$datePrefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($latestPo) {
            $parts = explode('-', $latestPo->invoice_number);
            $lastSeq = end($parts);
            $nextNumber = intval($lastSeq) + 1;
        }
        $invoiceNumber = $datePrefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('admin.purchases.create', compact('suppliers', 'products', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        if (!$request->filled('invoice_number')) {
            $datePrefix = 'PO-' . date('Ym') . '-';
            $latestPo = Purchase::where('invoice_number', 'like', "{$datePrefix}%")
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = 1;
            if ($latestPo) {
                $parts = explode('-', $latestPo->invoice_number);
                $lastSeq = end($parts);
                $nextNumber = intval($lastSeq) + 1;
            }
            $request->merge(['invoice_number' => $datePrefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT)]);
        }

        // Map cost_price to unit_cost if passed
        if ($request->has('items') && is_array($request->items)) {
            $items = $request->items;
            foreach ($items as $k => $item) {
                if (!isset($item['unit_cost']) && isset($item['cost_price'])) {
                    $items[$k]['unit_cost'] = $item['cost_price'];
                }
            }
            $request->merge(['items' => $items]);
        }

        $validated = $request->validate([
            'invoice_number' => 'required|string|max:50|unique:purchases,invoice_number',
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'payment_status' => 'required|in:paid,partial,unpaid',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $totalAmount += floatval($item['quantity']) * floatval($item['unit_cost']);
            }

            $purchase = Purchase::create([
                'invoice_number' => $validated['invoice_number'],
                'supplier_id' => $validated['supplier_id'],
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => $totalAmount,
                'payment_status' => $validated['payment_status'],
                'notes' => $validated['notes'],
            ]);

            foreach ($validated['items'] as $item) {
                $subtotal = floatval($item['quantity']) * floatval($item['unit_cost']);

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ]);

                // Update product stock and optionally update last cost price
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->increment('stock', $item['quantity']);
                    if (floatval($item['unit_cost']) > 0) {
                        $product->update(['cost_price' => $item['unit_cost']]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.purchases.index')
                ->with('success', 'Transaksi restock pembelian barang berhasil disimpan dan stok otomatis bertambah.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memproses pembelian: ' . $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product.unit']);

        return view('admin.purchases.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        DB::beginTransaction();
        try {
            // Revert stock when purchase is cancelled / deleted
            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            $purchase->delete();

            DB::commit();

            return redirect()->route('admin.purchases.index')
                ->with('success', 'Data pembelian berhasil dihapus dan stok telah disesuaikan kembali.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus pembelian: ' . $e->getMessage());
        }
    }

    /**
     * Export Restock Purchases as CSV/Excel
     */
    public function exportCsv(Request $request)
    {
        $query = Purchase::with(['supplier', 'items.product'])->latest('purchase_date');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($sq) use ($search) {
                      $sq->where('company_name', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $purchases = $query->get();
        $filename = 'riwayat-restock-azkamandiri-' . date('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($purchases) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'Nomor PO / Faktur',
                'Tanggal Pembelian',
                'Nama Supplier / Toko',
                'Kontak Supplier',
                'Total Belanja (Rp)',
                'Status Pembayaran',
                'Jumlah Varian Item',
                'Catatan Restock',
            ]);

            $no = 1;
            foreach ($purchases as $p) {
                $supplierName = $p->supplier ? ($p->supplier->company_name ?: $p->supplier->name) : 'Supplier Umum';
                $supplierContact = $p->supplier && $p->supplier->phone ? $p->supplier->phone : '-';
                fputcsv($file, [
                    $no++,
                    $p->invoice_number,
                    $p->purchase_date ? $p->purchase_date->format('d/m/Y') : '-',
                    $supplierName,
                    $supplierContact,
                    (float) $p->total_amount,
                    $p->payment_status === 'paid' ? 'Lunas' : ($p->payment_status === 'partial' ? 'DP / Sebagian' : 'Belum Lunas'),
                    $p->items ? $p->items->count() : 0,
                    $p->notes ?: '',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
