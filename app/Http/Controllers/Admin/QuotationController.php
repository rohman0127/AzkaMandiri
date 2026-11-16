<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of quotations with filtering and statistics.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['q', 'status', 'start_date', 'end_date']);

        $query = Quotation::with(['customer', 'creator', 'convertedTransaction'])
            ->filter($filters)
            ->latest('date')
            ->latest('id');

        $quotations = $query->paginate(15)->withQueryString();

        // Calculate KPI Summary
        $stats = [
            'total' => Quotation::count(),
            'pending' => Quotation::where('status', 'sent')->count(),
            'accepted' => Quotation::where('status', 'accepted')->count(),
            'converted' => Quotation::where('status', 'converted')->count(),
            'total_value' => (float) Quotation::whereNotIn('status', ['rejected'])->sum('grand_total'),
        ];

        return view('admin.pos.quotations.index', compact('quotations', 'filters', 'stats'));
    }

    /**
     * Show the form for creating a new quotation.
     */
    public function create()
    {
        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)
            ->with(['unit', 'category'])
            ->orderBy('name')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'sku' => $p->sku,
                    'name' => $p->name,
                    'price' => (float) $p->price,
                    'unit' => $p->unit->symbol ?? $p->unit->name ?? 'unit',
                    'type' => $p->type,
                ];
            });

        $nextQuotationNumber = Quotation::generateNextNumber();
        $defaultDate = Carbon::today()->format('Y-m-d');
        $defaultValidUntil = Carbon::today()->addDays(14)->format('Y-m-d');

        $defaultTerms = "1. Harga penawaran berlaku selama 14 (empat belas) hari sejak tanggal penawaran diterbitkan.\n" .
            "2. Pembayaran Down Payment (DP) minimal 50% saat Surat Perintah Kerja (SPK) disetujui.\n" .
            "3. Pelunasan sisa 50% dilakukan sebelum atau saat barang / pekerjaan selesai terpasang di lokasi proyek.\n" .
            "4. Estimasi waktu fabrikasi dan perakitan adalah 7 s/d 14 hari kerja setelah pengukuran ulang dan DP diterima.\n" .
            "5. Garansi kebocoran silikon dan instalasi pemasangan berlaku selama 3 (tiga) bulan.";

        return view('admin.pos.quotations.create', compact(
            'customers',
            'products',
            'nextQuotationNumber',
            'defaultDate',
            'defaultValidUntil',
            'defaultTerms'
        ));
    }

    /**
     * Store a newly created quotation in database.
     */
    public function store(Request $request)
    {
        if ($request->has('customer_id') && ($request->customer_id === '' || $request->customer_id === 'null')) {
            $request->merge(['customer_id' => null]);
        }

        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string|max:150',
            'customer_phone' => 'nullable|string|max:50',
            'customer_company' => 'nullable|string|max:150',
            'customer_address' => 'nullable|string|max:500',
            'date' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:date',
            'status' => 'required|in:draft,sent,accepted,rejected',
            'order_type' => 'required|in:retail,project_custom',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:2000',
            'terms_conditions' => 'nullable|string|max:3000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.dimensions' => 'nullable|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_name' => 'nullable|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Calculate subtotal
            $subtotal = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $qty = (float) $item['quantity'];
                $price = (float) $item['unit_price'];
                $total = round($qty * $price, 2);
                $subtotal += $total;

                $itemsData[] = [
                    'product_id' => !empty($item['product_id']) ? $item['product_id'] : null,
                    'item_name' => trim($item['item_name']),
                    'dimensions' => !empty($item['dimensions']) ? trim($item['dimensions']) : null,
                    'quantity' => $qty,
                    'unit_name' => !empty($item['unit_name']) ? trim($item['unit_name']) : 'unit',
                    'unit_price' => $price,
                    'total_price' => $total,
                ];
            }

            $discount = (float) ($validated['discount'] ?? 0);
            $tax = (float) ($validated['tax'] ?? 0);
            $grandTotal = max(0, ($subtotal - $discount) + $tax);

            $quotationNumber = Quotation::generateNextNumber();

            // Create Quotation
            $quotation = Quotation::create([
                'quotation_number' => $quotationNumber,
                'customer_id' => $validated['customer_id'] ?? null,
                'customer_name' => $validated['customer_name'] ?? null,
                'customer_phone' => $validated['customer_phone'] ?? null,
                'customer_company' => $validated['customer_company'] ?? null,
                'customer_address' => $validated['customer_address'] ?? null,
                'date' => $validated['date'],
                'valid_until' => $validated['valid_until'],
                'status' => $validated['status'],
                'order_type' => $validated['order_type'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'notes' => $validated['notes'] ?? null,
                'terms_conditions' => $validated['terms_conditions'] ?? null,
                'created_by' => Auth::id(),
            ]);

            // Create Items
            foreach ($itemsData as $data) {
                $quotation->items()->create($data);
            }

            DB::commit();

            return redirect()->route('admin.pos.quotations.show', $quotation)
                ->with('success', "Surat Penawaran Harga {$quotation->quotation_number} berhasil dibuat!");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal membuat penawaran harga: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified quotation.
     */
    public function show(Quotation $quotation)
    {
        $quotation->load(['customer', 'creator', 'convertedTransaction', 'items.product.unit']);

        return view('admin.pos.quotations.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified quotation.
     */
    public function edit(Quotation $quotation)
    {
        if ($quotation->status === 'converted') {
            return redirect()->route('admin.pos.quotations.show', $quotation)
                ->with('error', 'Penawaran ini sudah dikonversi ke Transaksi/Invoice dan tidak dapat diubah.');
        }

        $quotation->load(['items.product']);
        $customers = Customer::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)
            ->with(['unit', 'category'])
            ->orderBy('name')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'sku' => $p->sku,
                    'name' => $p->name,
                    'price' => (float) $p->price,
                    'unit' => $p->unit->symbol ?? $p->unit->name ?? 'unit',
                    'type' => $p->type,
                ];
            });

        return view('admin.pos.quotations.edit', compact('quotation', 'customers', 'products'));
    }

    /**
     * Update the specified quotation in database.
     */
    public function update(Request $request, Quotation $quotation)
    {
        if ($quotation->status === 'converted') {
            return redirect()->route('admin.pos.quotations.show', $quotation)
                ->with('error', 'Penawaran ini sudah dikonversi ke Transaksi/Invoice dan tidak dapat diubah.');
        }

        if ($request->has('customer_id') && ($request->customer_id === '' || $request->customer_id === 'null')) {
            $request->merge(['customer_id' => null]);
        }

        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string|max:150',
            'customer_phone' => 'nullable|string|max:50',
            'customer_company' => 'nullable|string|max:150',
            'customer_address' => 'nullable|string|max:500',
            'date' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:date',
            'status' => 'required|in:draft,sent,accepted,rejected',
            'order_type' => 'required|in:retail,project_custom',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:2000',
            'terms_conditions' => 'nullable|string|max:3000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.dimensions' => 'nullable|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_name' => 'nullable|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $qty = (float) $item['quantity'];
                $price = (float) $item['unit_price'];
                $total = round($qty * $price, 2);
                $subtotal += $total;

                $itemsData[] = [
                    'product_id' => !empty($item['product_id']) ? $item['product_id'] : null,
                    'item_name' => trim($item['item_name']),
                    'dimensions' => !empty($item['dimensions']) ? trim($item['dimensions']) : null,
                    'quantity' => $qty,
                    'unit_name' => !empty($item['unit_name']) ? trim($item['unit_name']) : 'unit',
                    'unit_price' => $price,
                    'total_price' => $total,
                ];
            }

            $discount = (float) ($validated['discount'] ?? 0);
            $tax = (float) ($validated['tax'] ?? 0);
            $grandTotal = max(0, ($subtotal - $discount) + $tax);

            $quotation->update([
                'customer_id' => $validated['customer_id'] ?? null,
                'customer_name' => $validated['customer_name'] ?? null,
                'customer_phone' => $validated['customer_phone'] ?? null,
                'customer_company' => $validated['customer_company'] ?? null,
                'customer_address' => $validated['customer_address'] ?? null,
                'date' => $validated['date'],
                'valid_until' => $validated['valid_until'],
                'status' => $validated['status'],
                'order_type' => $validated['order_type'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'notes' => $validated['notes'] ?? null,
                'terms_conditions' => $validated['terms_conditions'] ?? null,
            ]);

            // Re-sync items
            $quotation->items()->delete();
            foreach ($itemsData as $data) {
                $quotation->items()->create($data);
            }

            DB::commit();

            return redirect()->route('admin.pos.quotations.show', $quotation)
                ->with('success', "Surat Penawaran Harga {$quotation->quotation_number} berhasil diperbarui!");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui penawaran: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified quotation from database.
     */
    public function destroy(Quotation $quotation)
    {
        if ($quotation->status === 'converted') {
            return back()->with('error', 'Penawaran ini sudah dikonversi ke transaksi dan tidak dapat dihapus.');
        }

        $number = $quotation->quotation_number;
        $quotation->delete();

        return redirect()->route('admin.pos.quotations.index')
            ->with('success', "Penawaran {$number} berhasil dihapus.");
    }

    /**
     * Quick status update (e.g. mark as sent, accepted, or rejected).
     */
    public function updateStatus(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,sent,accepted,rejected',
        ]);

        if ($quotation->status === 'converted') {
            return back()->with('error', 'Penawaran yang telah dikonversi tidak dapat diubah statusnya.');
        }

        $quotation->update(['status' => $validated['status']]);

        return back()->with('success', "Status penawaran berhasil diubah menjadi: " . $quotation->status_badge['label']);
    }

    /**
     * Convert an accepted quotation into an active POS Transaction / Sale.
     */
    public function convert(Quotation $quotation)
    {
        if ($quotation->status === 'converted' && $quotation->converted_transaction_id) {
            return redirect()->route('admin.pos.show', $quotation->converted_transaction_id)
                ->with('info', "Penawaran ini sudah pernah dikonversi ke Transaksi #{$quotation->convertedTransaction->invoice_code}.");
        }

        DB::beginTransaction();
        try {
            // Find or create default custom project product for line items without a specific stock product
            $defaultCustomProduct = Product::where('type', 'custom')->first();
            if (!$defaultCustomProduct) {
                $defaultCustomProduct = Product::first();
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

            // Create Transaction
            $transaction = Transaction::create([
                'invoice_code' => $invoiceCode,
                'customer_id' => $quotation->customer_id,
                'user_id' => Auth::id(),
                'transaction_date' => Carbon::now(),
                'order_type' => $quotation->order_type ?: 'project_custom',
                'subtotal' => $quotation->subtotal,
                'discount_amount' => $quotation->discount,
                'tax_amount' => $quotation->tax,
                'total_amount' => $quotation->grand_total,
                'paid_amount' => 0,
                'change_amount' => 0,
                'payment_type' => 'transfer',
                'payment_status' => 'unpaid',
                'due_date' => $quotation->valid_until ?: Carbon::now()->addDays(14),
                'notes' => "Dikonversi dari Surat Penawaran: {$quotation->quotation_number}" . ($quotation->notes ? " | {$quotation->notes}" : ''),
            ]);

            // Create Transaction Items
            foreach ($quotation->items as $qItem) {
                $productId = $qItem->product_id;
                $costPrice = 0;

                if ($productId) {
                    $prod = Product::find($productId);
                    $costPrice = $prod ? (float) $prod->cost_price : 0;
                    if ($prod && $prod->type === 'standard') {
                        $prod->decrement('stock', $qItem->quantity);
                    }
                } else {
                    $productId = $defaultCustomProduct ? $defaultCustomProduct->id : 1;
                }

                $specString = $qItem->item_name;
                if ($qItem->dimensions) {
                    $specString .= " ({$qItem->dimensions})";
                }

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $productId,
                    'quantity' => $qItem->quantity,
                    'unit_price' => $qItem->unit_price,
                    'cost_price' => $costPrice,
                    'subtotal' => $qItem->total_price,
                    'specification' => $specString,
                ]);
            }

            // Update Quotation Status to Converted
            $quotation->update([
                'status' => 'converted',
                'converted_transaction_id' => $transaction->id,
            ]);

            DB::commit();

            return redirect()->route('admin.pos.show', $transaction)
                ->with('success', "Penawaran {$quotation->quotation_number} berhasil dikonversi menjadi Transaksi Kasir #{$transaction->invoice_code}!");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengonversi penawaran: ' . $e->getMessage());
        }
    }

    /**
     * Generate and stream high-fidelity corporate A4 PDF Quotation.
     */
    public function pdf(Quotation $quotation)
    {
        $quotation->load(['customer', 'creator', 'items.product.unit']);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $html = view('admin.pos.quotations.pdf', compact('quotation'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $safeNum = str_replace(['/', '\\'], '-', $quotation->quotation_number);

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename=\"Penawaran-{$safeNum}.pdf\"",
        ]);
    }
}

