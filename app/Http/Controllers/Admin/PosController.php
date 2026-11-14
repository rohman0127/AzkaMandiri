<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\InventoryCategory;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $categories = InventoryCategory::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $customers = Customer::where('is_active', true)->orderBy('name')->get();

        $products = Product::where('is_active', true)
            ->with(['category', 'unit'])
            ->orderBy('name')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'sku' => $p->sku,
                    'barcode' => $p->barcode,
                    'name' => $p->name,
                    'category_id' => $p->category_id,
                    'category_name' => $p->category->name ?? '-',
                    'unit_name' => $p->unit->symbol ?? $p->unit->name ?? 'pcs',
                    'price' => (float) $p->price,
                    'cost_price' => (float) $p->cost_price,
                    'stock' => (float) $p->stock,
                    'min_stock' => (float) $p->min_stock,
                    'type' => $p->type,
                    'image' => $p->image,
                    'rack_location' => $p->rack_location,
                ];
            });

        // Generate next automatic invoice code
        $datePrefix = 'INV-' . date('Ym') . '-';
        $latest = Transaction::where('invoice_code', 'like', "{$datePrefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextSeq = 1;
        if ($latest) {
            $parts = explode('-', $latest->invoice_code);
            $lastSeq = end($parts);
            $nextSeq = intval($lastSeq) + 1;
        }
        $nextInvoiceCode = $datePrefix . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);

        return view('admin.pos.index', compact('categories', 'customers', 'products', 'nextInvoiceCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'order_type' => 'required|in:retail,project_custom',
            'payment_type' => 'required|in:cash,transfer,qris',
            'discount_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.specification' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Stock Validation
            foreach ($validated['items'] as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);
                if ($product->type === 'standard' && (float)$product->stock < (float)$item['quantity']) {
                    return back()->withInput()->with('error', "Stok untuk '{$product->name}' tidak mencukupi! Tersedia: {$product->stock} {$product->unit->symbol}, Diminta: {$item['quantity']}.");
                }
            }

            // 2. Calculate Totals
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $subtotal += (float)$item['quantity'] * (float)$item['unit_price'];
            }

            $discount = (float)($validated['discount_amount'] ?? 0);
            $totalAmount = max(0, $subtotal - $discount);
            $paidAmount = (float)$validated['paid_amount'];
            $changeAmount = max(0, $paidAmount - $totalAmount);

            // Determine Payment Status
            if ($paidAmount >= $totalAmount) {
                $paymentStatus = 'paid';
            } elseif ($paidAmount > 0) {
                $paymentStatus = 'partial';
            } else {
                $paymentStatus = 'unpaid';
            }

            // Generate sequential Invoice Code
            $datePrefix = 'INV-' . date('Ym') . '-';
            $latest = Transaction::where('invoice_code', 'like', "{$datePrefix}%")
                ->orderBy('id', 'desc')
                ->first();

            $nextSeq = 1;
            if ($latest) {
                $parts = explode('-', $latest->invoice_code);
                $lastSeq = end($parts);
                $nextSeq = intval($lastSeq) + 1;
            }
            $invoiceCode = $datePrefix . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);

            // 3. Create Transaction
            $transaction = Transaction::create([
                'invoice_code' => $invoiceCode,
                'customer_id' => $validated['customer_id'] ?? null,
                'user_id' => Auth::id(),
                'transaction_date' => Carbon::now(),
                'order_type' => $validated['order_type'],
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'tax_amount' => 0,
                'total_amount' => $totalAmount,
                'paid_amount' => min($paidAmount, $totalAmount), // record actual applied payment
                'change_amount' => $changeAmount,
                'payment_type' => $validated['payment_type'],
                'payment_status' => $paymentStatus,
                'due_date' => $validated['due_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // 4. Create Items & Deduct Stock
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $itemSubtotal = (float)$item['quantity'] * (float)$item['unit_price'];

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'cost_price' => $product->cost_price ?? 0,
                    'subtotal' => $itemSubtotal,
                    'specification' => $item['specification'] ?? null,
                ]);

                // Decrement physical stock (if not purely service)
                if ($product->type === 'standard') {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            // 5. Record Payment
            if ($paidAmount > 0) {
                Payment::create([
                    'transaction_id' => $transaction->id,
                    'payment_date' => Carbon::now(),
                    'amount' => min($paidAmount, $totalAmount),
                    'payment_type' => $validated['payment_type'],
                    'notes' => $paymentStatus === 'paid' ? 'Pembayaran Lunas Kasir' : 'Pembayaran Uang Muka (DP)',
                ]);
            }

            DB::commit();

            return redirect()->route('admin.pos.show', $transaction->id)
                ->with('success', "Transaksi berhasil diproses dengan nomor nota {$transaction->invoice_code}.")
                ->with('new_transaction_id', $transaction->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage());
        }
    }

    public function transactions(Request $request)
    {
        $query = Transaction::with(['customer', 'user', 'items.product'])->latest('transaction_date');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_code', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('order_type')) {
            $query->where('order_type', $request->order_type);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ]);
        }

        $transactions = $query->paginate(15)->withQueryString();

        $totalRevenue = Transaction::sum('paid_amount');
        $totalReceivable = Transaction::where('payment_status', '!=', 'paid')
            ->selectRaw('SUM(total_amount - paid_amount) as sisa')
            ->value('sisa') ?? 0;

        return view('admin.pos.transactions', compact('transactions', 'totalRevenue', 'totalReceivable'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'user', 'items.product.unit', 'payments']);

        return view('admin.pos.show', compact('transaction'));
    }

    public function addPayment(Request $request, Transaction $transaction)
    {
        $remaining = $transaction->remaining_debt;

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $remaining,
            'payment_type' => 'required|in:cash,transfer,qris',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            Payment::create([
                'transaction_id' => $transaction->id,
                'payment_date' => Carbon::now(),
                'amount' => $validated['amount'],
                'payment_type' => $validated['payment_type'],
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? 'Pelunasan piutang / cicilan bertahap',
            ]);

            $newPaidTotal = (float)$transaction->paid_amount + (float)$validated['amount'];
            $newStatus = ($newPaidTotal >= (float)$transaction->total_amount) ? 'paid' : 'partial';

            $transaction->update([
                'paid_amount' => $newPaidTotal,
                'payment_status' => $newStatus,
            ]);

            DB::commit();

            return redirect()->route('admin.pos.show', $transaction->id)
                ->with('success', 'Pembayaran sebesar Rp ' . number_format($validated['amount'], 0, ',', '.') . ' berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mencatat pembayaran: ' . $e->getMessage());
        }
    }

    public function thermalReceipt(Transaction $transaction)
    {
        $transaction->load(['customer', 'user', 'items.product.unit', 'payments']);

        return view('admin.pos.receipt_thermal', compact('transaction'));
    }

    public function invoicePdf(Transaction $transaction)
    {
        $transaction->load(['customer', 'user', 'items.product.unit', 'payments']);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $html = view('admin.pos.invoice_pdf', compact('transaction'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Invoice-' . $transaction->invoice_code . '.pdf"',
        ]);
    }

    /**
     * Export Transactions as CSV/Excel
     */
    public function exportCsv(Request $request)
    {
        $query = Transaction::with(['customer', 'user'])->latest('transaction_date');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_code', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('order_type')) {
            $query->where('order_type', $request->order_type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        $transactions = $query->get();
        $filename = 'transaksi-pos-azkamandiri-' . date('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'No Invoice',
                'Tanggal & Waktu',
                'Nama Pelanggan',
                'Telepon Pelanggan',
                'Tipe Pesanan',
                'Metode Pembayaran',
                'Subtotal (Rp)',
                'Diskon (Rp)',
                'Pajak (Rp)',
                'Total Tagihan (Rp)',
                'Jumlah Terbayar (Rp)',
                'Sisa Piutang (Rp)',
                'Status Pembayaran',
                'Kasir / Petugas',
                'Catatan',
            ]);

            $no = 1;
            foreach ($transactions as $t) {
                fputcsv($file, [
                    $no++,
                    $t->invoice_code,
                    $t->transaction_date ? $t->transaction_date->format('d/m/Y H:i') : '-',
                    $t->customer ? $t->customer->name : 'Pelanggan Umum (Walk-in)',
                    $t->customer && $t->customer->phone ? $t->customer->phone : '-',
                    $t->order_type === 'custom' ? 'Pesanan Custom' : 'Ritel Biasa',
                    strtoupper($t->payment_type),
                    (float) $t->subtotal,
                    (float) $t->discount_amount,
                    (float) $t->tax_amount,
                    (float) $t->total_amount,
                    (float) $t->paid_amount,
                    (float) $t->remaining_debt,
                    $t->payment_status === 'paid' ? 'Lunas' : ($t->payment_status === 'partial' ? 'DP / Piutang' : 'Belum Lunas'),
                    $t->user ? $t->user->name : 'Sistem',
                    $t->notes ?? '',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

