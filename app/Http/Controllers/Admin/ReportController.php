<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\StockAdjustment;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportController extends Controller
{
    /**
     * Compute sales report dataset
     */
    private function getSalesData(Request $request): array
    {
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth()->startOfDay();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfMonth()->endOfDay();

        $query = Transaction::with(['customer', 'user', 'items.product'])
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->latest('transaction_date');

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        $transactions = $query->get();

        $totalSubtotal = $transactions->sum('subtotal');
        $totalDiscount = $transactions->sum('discount_amount');
        $totalRevenue = $transactions->sum('total_amount');
        $totalPaid = $transactions->sum('paid_amount');
        $totalPiutang = max(0, $totalRevenue - $totalPaid);
        $totalCount = $transactions->count();

        // Payment type breakdown
        $cashTotal = $transactions->where('payment_type', 'cash')->sum('paid_amount');
        $transferTotal = $transactions->where('payment_type', 'transfer')->sum('paid_amount');
        $qrisTotal = $transactions->where('payment_type', 'qris')->sum('paid_amount');

        return compact(
            'transactions',
            'startDate',
            'endDate',
            'totalSubtotal',
            'totalDiscount',
            'totalRevenue',
            'totalPaid',
            'totalPiutang',
            'totalCount',
            'cashTotal',
            'transferTotal',
            'qrisTotal'
        );
    }

    /**
     * Display Sales Report Screen
     */
    public function sales(Request $request)
    {
        $data = $this->getSalesData($request);
        return view('admin.reports.sales', $data);
    }

    /**
     * Generate Official Sales Report PDF (A4 Landscape)
     */
    public function salesPdf(Request $request)
    {
        $data = $this->getSalesData($request);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $html = view('admin.reports.sales_pdf', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Laporan-Penjualan-POS-' . $data['startDate']->format('Ymd') . '-' . $data['endDate']->format('Ymd') . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    /**
     * Compute purchase report dataset
     */
    private function getPurchasesData(Request $request): array
    {
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth()->startOfDay();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfMonth()->endOfDay();

        $query = Purchase::with(['supplier', 'items.product.unit'])
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->latest('purchase_date');

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $purchases = $query->get();

        $totalAmount = (float) $purchases->sum('total_amount');
        $totalPurchasesCount = $purchases->count();
        $paidCount = $purchases->where('payment_status', 'paid')->count();
        $partialCount = $purchases->where('payment_status', 'partial')->count();
        $unpaidCount = $purchases->where('payment_status', 'unpaid')->count();

        $paidTotal = (float) $purchases->where('payment_status', 'paid')->sum('total_amount');
        $partialTotal = (float) $purchases->where('payment_status', 'partial')->sum('total_amount');
        $unpaidTotalOnly = (float) $purchases->where('payment_status', 'unpaid')->sum('total_amount');
        $unpaidTotal = (float) $purchases->where('payment_status', '!=', 'paid')->sum('total_amount');

        $totalItemsQty = 0;
        foreach ($purchases as $p) {
            foreach ($p->items as $item) {
                $totalItemsQty += (float)$item->quantity;
            }
        }

        $suppliers = Supplier::where('is_active', true)->orderBy('company_name')->get();

        return compact(
            'purchases',
            'suppliers',
            'startDate',
            'endDate',
            'totalAmount',
            'totalPurchasesCount',
            'paidCount',
            'partialCount',
            'unpaidCount',
            'paidTotal',
            'partialTotal',
            'unpaidTotalOnly',
            'unpaidTotal',
            'totalItemsQty'
        );
    }

    /**
     * Display Purchase Report Screen
     */
    public function purchases(Request $request)
    {
        $data = $this->getPurchasesData($request);
        return view('admin.reports.purchases', $data);
    }

    /**
     * Generate Official Purchase Report PDF (A4 Landscape)
     */
    public function purchasesPdf(Request $request)
    {
        $data = $this->getPurchasesData($request);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $html = view('admin.reports.purchases_pdf', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Laporan-Pembelian-Restock-' . $data['startDate']->format('Ymd') . '-' . $data['endDate']->format('Ymd') . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    /**
     * Export Purchase Report as Multi-Sheet Excel (.xlsx) Workbook
     */
    public function purchasesExcel(Request $request)
    {
        $data = $this->getPurchasesData($request);
        $purchases = $data['purchases'];

        $spreadsheet = new Spreadsheet();

        // -----------------------------------------------------------
        // TAB SHEET 1: RINGKASAN PEMBELIAN & RESTOCK
        // -----------------------------------------------------------
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Ringkasan Pembelian');

        // Kop
        $sheet1->setCellValue('A1', 'AZKAMANDIRI');
        $sheet1->getStyle('A1')->getFont()->setBold(true)->setSize(16)->getColor()->setARGB('FF172B4D');
        $sheet1->setCellValue('A2', 'SPESIALIS KUSEN ALUMINIUM, KACA TEMPERED, & PROYEK INTERIOR');
        $sheet1->getStyle('A2')->getFont()->setBold(true)->setSize(9)->getColor()->setARGB('FF475569');
        $sheet1->setCellValue('A3', 'Workshop & Kantor: Jl. Raya Mandiri Blok A No. 12, Jawa Timur | Telp/WA: 0812-3456-7890');
        $sheet1->getStyle('A3')->getFont()->setSize(8)->getColor()->setARGB('FF64748B');
        $sheet1->setCellValue('A4', 'Email: contact@azkamandiri.com | Website: azkamandiri.nichesite.org');
        $sheet1->getStyle('A4')->getFont()->setSize(8)->getColor()->setARGB('FF64748B');

        // Metadata
        $sheet1->setCellValue('A6', 'REKAPITULASI PEMBELIAN & RESTOCK BAHAN BAKU');
        $sheet1->getStyle('A6')->getFont()->setBold(true)->setSize(11)->getColor()->setARGB('FF0F172A');
        $sheet1->setCellValue('D6', 'Waktu Cetak: ' . Carbon::now()->translatedFormat('d F Y - H:i') . ' WIB');
        $sheet1->getStyle('D6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet1->getStyle('D6')->getFont()->setSize(8)->getColor()->setARGB('FF64748B');

        $sheet1->setCellValue('A7', 'Periode Transaksi: ' . $data['startDate']->translatedFormat('d F Y') . ' s/d ' . $data['endDate']->translatedFormat('d F Y'));
        $sheet1->getStyle('A7')->getFont()->setSize(8.5);

        $supName = request('supplier_id') ? ($data['suppliers']->firstWhere('id', request('supplier_id'))->company_name ?? 'Supplier Terpilih') : 'Semua Vendor';
        $filterStr = 'Operator: ' . (auth()->user()->name ?? 'Administrator') . ' (' . (auth()->user()->role_name ?? 'Super Admin') . ') | Filter: ' . (request('payment_status') ? ucfirst(request('payment_status')) : 'Semua Status') . ', ' . $supName;
        $sheet1->setCellValue('D7', $filterStr);
        $sheet1->getStyle('D7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet1->getStyle('D7')->getFont()->setSize(8)->getColor()->setARGB('FF64748B');

        // Seksi 1: Ringkasan Pembelian Utama
        $sheet1->setCellValue('A9', 'RINGKASAN PEMBELIAN & RESTOCK UTAMA');
        $sheet1->getStyle('A9')->getFont()->setBold(true)->setSize(10)->getColor()->setARGB('FF172B4D');

        $sheet1->setCellValue('A10', 'Metrik Belanja');
        $sheet1->setCellValue('B10', 'Nilai (Rp) / Keterangan');
        $sheet1->getStyle('A10:B10')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet1->getStyle('A10:B10')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');

        $metrics = [
            ['Total Pengeluaran Belanja', (float)$data['totalAmount'], 'FF0F172A'],
            ['Total Material Masuk (Item/Batang)', (float)$data['totalItemsQty'], 'FF2563EB'],
            ['Belanja Lunas (Terbayar)', (float)$data['paidTotal'], 'FF16A34A'],
            ['Hutang Belanja / Tempo', (float)$data['unpaidTotal'], 'FFDC2626'],
        ];

        $r = 11;
        foreach ($metrics as $m) {
            $sheet1->setCellValue('A' . $r, $m[0]);
            $sheet1->setCellValue('B' . $r, $m[1]);
            $sheet1->getStyle('B' . $r)->getNumberFormat()->setFormatCode('#,##0');
            $sheet1->getStyle('B' . $r)->getFont()->setBold(true)->getColor()->setARGB($m[2]);
            $r++;
        }
        $sheet1->getStyle('A10:B14')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');

        // Seksi 2: Distribusi Status Pembayaran Faktur
        $sheet1->setCellValue('A16', 'DISTRIBUSI STATUS PEMBAYARAN FAKTUR');
        $sheet1->getStyle('A16')->getFont()->setBold(true)->setSize(10)->getColor()->setARGB('FF172B4D');

        $sheet1->setCellValue('A17', 'Status Pembayaran');
        $sheet1->setCellValue('B17', 'Jumlah Faktur');
        $sheet1->setCellValue('C17', 'Total Belanja (Rp)');
        $sheet1->setCellValue('D17', 'Persentase (%)');
        $sheet1->getStyle('A17:D17')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet1->getStyle('A17:D17')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');

        $totAmt = (float)$data['totalAmount'];
        $pmRows = [
            ['Lunas (Terbayar Penuh)', $data['paidCount'] . ' Faktur', (float)$data['paidTotal'], $totAmt > 0 ? ($data['paidTotal'] / $totAmt) : 0, 'FF15803D'],
            ['DP / Sebagian (Tempo Aktif)', $data['partialCount'] . ' Faktur', (float)$data['partialTotal'], $totAmt > 0 ? ($data['partialTotal'] / $totAmt) : 0, 'FFB45309'],
            ['Belum Lunas (Hutang Dagang)', $data['unpaidCount'] . ' Faktur', (float)$data['unpaidTotalOnly'], $totAmt > 0 ? ($data['unpaidTotalOnly'] / $totAmt) : 0, 'FFB91C1C'],
        ];

        $r = 18;
        foreach ($pmRows as $pm) {
            $sheet1->setCellValue('A' . $r, $pm[0]);
            $sheet1->setCellValue('B' . $r, $pm[1]);
            $sheet1->setCellValue('C' . $r, $pm[2]);
            $sheet1->setCellValue('D' . $r, $pm[3]);
            $sheet1->getStyle('A' . $r)->getFont()->setBold(true)->getColor()->setARGB($pm[4]);
            $sheet1->getStyle('B' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet1->getStyle('C' . $r)->getNumberFormat()->setFormatCode('#,##0');
            $sheet1->getStyle('D' . $r)->getNumberFormat()->setFormatCode('0.0%');
            $r++;
        }
        $sheet1->getStyle('A17:D20')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');

        foreach (range('A', 'D') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // -----------------------------------------------------------
        // TAB SHEET 2: RINCIAN FAKTUR PO DETAIL
        // -----------------------------------------------------------
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Rincian Faktur PO');

        // Kop
        $sheet2->setCellValue('A1', 'AZKAMANDIRI');
        $sheet2->getStyle('A1')->getFont()->setBold(true)->setSize(16)->getColor()->setARGB('FF172B4D');
        $sheet2->setCellValue('A2', 'SPESIALIS KUSEN ALUMINIUM, KACA TEMPERED, & PROYEK INTERIOR');
        $sheet2->getStyle('A2')->getFont()->setBold(true)->setSize(9)->getColor()->setARGB('FF475569');

        $sheet2->setCellValue('A4', 'RINCIAN FAKTUR PEMBELIAN & RESTOCK PERIODE TERPILIH');
        $sheet2->getStyle('A4')->getFont()->setBold(true)->setSize(11)->getColor()->setARGB('FF0F172A');
        $sheet2->setCellValue('A5', 'Periode Transaksi: ' . $data['startDate']->translatedFormat('d F Y') . ' s/d ' . $data['endDate']->translatedFormat('d F Y') . ' | ' . $data['totalPurchasesCount'] . ' Faktur Ditemukan');
        $sheet2->getStyle('A5')->getFont()->setSize(8.5)->getColor()->setARGB('FF64748B');

        // Table Headers
        $headers = [
            'A7' => 'No. Faktur PO',
            'B7' => 'Tanggal Pembelian',
            'C7' => 'Supplier / Vendor',
            'D7' => 'No. Telepon',
            'E7' => 'Varian Item',
            'F7' => 'Total Qty Masuk',
            'G7' => 'Rincian Barang & Material Masuk',
            'H7' => 'Total Faktur (Rp)',
            'I7' => 'Status Pembayaran',
            'J7' => 'Catatan',
        ];

        foreach ($headers as $cell => $val) {
            $sheet2->setCellValue($cell, $val);
        }
        $sheet2->getStyle('A7:J7')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet2->getStyle('A7:J7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');
        $sheet2->getStyle('A7:J7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet2->getRowDimension(7)->setRowHeight(24);

        $rowIdx = 8;
        $totalVariantsCount = 0;
        foreach ($purchases as $p) {
            $supplierName = $p->supplier ? ($p->supplier->company_name ?: $p->supplier->name) : 'Supplier Umum';
            $supplierPhone = $p->supplier && $p->supplier->phone ? $p->supplier->phone : '-';

            $itemsSummary = [];
            $poQty = 0;
            foreach ($p->items as $it) {
                $prodName = $it->product ? $it->product->name : 'Item';
                $unitSymbol = $it->product && $it->product->unit ? $it->product->unit->symbol : 'unit';
                $itemsSummary[] = $prodName . ' (' . (float)$it->quantity . ' ' . $unitSymbol . ' @ Rp ' . number_format($it->unit_cost, 0, ',', '.') . ')';
                $poQty += (float)$it->quantity;
            }
            $totalVariantsCount += $p->items->count();

            $statusLabel = 'Lunas';
            if ($p->payment_status === 'partial') $statusLabel = 'DP / Sebagian';
            elseif ($p->payment_status === 'unpaid') $statusLabel = 'Belum Lunas';

            $sheet2->setCellValue('A' . $rowIdx, $p->invoice_number);
            $sheet2->setCellValue('B' . $rowIdx, $p->purchase_date ? $p->purchase_date->format('d/m/Y') : '-');
            $sheet2->setCellValue('C' . $rowIdx, $supplierName);
            $sheet2->setCellValue('D' . $rowIdx, $supplierPhone);
            $sheet2->setCellValue('E' . $rowIdx, $p->items->count());
            $sheet2->setCellValue('F' . $rowIdx, $poQty);
            $sheet2->setCellValue('G' . $rowIdx, implode('; ', $itemsSummary));
            $sheet2->setCellValue('H' . $rowIdx, (float)$p->total_amount);
            $sheet2->setCellValue('I' . $rowIdx, $statusLabel);
            $sheet2->setCellValue('J' . $rowIdx, $p->notes ?: '-');

            // Formats
            $sheet2->getStyle('A' . $rowIdx)->getFont()->setBold(true);
            $sheet2->getStyle('H' . $rowIdx)->getNumberFormat()->setFormatCode('#,##0');
            $sheet2->getStyle('H' . $rowIdx)->getFont()->setBold(true);
            $sheet2->getStyle('E' . $rowIdx . ':F' . $rowIdx)->getNumberFormat()->setFormatCode('#,##0');

            // Alignments
            $sheet2->getStyle('B' . $rowIdx)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet2->getStyle('E' . $rowIdx . ':F' . $rowIdx)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet2->getStyle('I' . $rowIdx)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            if ($rowIdx % 2 == 0) {
                $sheet2->getStyle('A' . $rowIdx . ':J' . $rowIdx)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
            }

            $rowIdx++;
        }

        // Total Row
        $sheet2->setCellValue('A' . $rowIdx, 'TOTAL PERIODE (' . $data['totalPurchasesCount'] . ' Faktur)');
        $sheet2->setCellValue('E' . $rowIdx, $totalVariantsCount . ' Item');
        $sheet2->setCellValue('F' . $rowIdx, (float)$data['totalItemsQty']);
        $sheet2->setCellValue('H' . $rowIdx, (float)$data['totalAmount']);
        $sheet2->setCellValue('I' . $rowIdx, $data['totalPurchasesCount'] . ' Faktur');

        $sheet2->getStyle('A' . $rowIdx . ':J' . $rowIdx)->getFont()->setBold(true);
        $sheet2->getStyle('F' . $rowIdx . ':H' . $rowIdx)->getNumberFormat()->setFormatCode('#,##0');
        $sheet2->getStyle('E' . $rowIdx . ':F' . $rowIdx)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('I' . $rowIdx)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('A' . $rowIdx . ':J' . $rowIdx)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF1F5F9');

        // Borders
        $sheet2->getStyle('A7:J' . $rowIdx)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');
        $sheet2->getStyle('A' . $rowIdx . ':J' . $rowIdx)->getBorders()->getTop()->setBorderStyle(Border::BORDER_MEDIUM)->getColor()->setARGB('FF1E293B');

        foreach (range('A', 'J') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        $spreadsheet->setActiveSheetIndex(0);

        $filename = 'laporan-pembelian-restock-' . $data['startDate']->format('Ymd') . '-' . $data['endDate']->format('Ymd') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Export Purchase Report as CSV/Excel
     */
    public function purchasesCsv(Request $request)
    {
        $data = $this->getPurchasesData($request);
        $purchases = $data['purchases'];
        $filename = 'laporan-pembelian-restock-' . $data['startDate']->format('Ymd') . '-' . $data['endDate']->format('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($purchases, $data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // KOP PERUSAHAAN (Padded to 10 cols)
            fputcsv($file, array_pad(['AZKAMANDIRI'], 10, ''));
            fputcsv($file, array_pad(['SPESIALIS KUSEN ALUMINIUM, KACA TEMPERED, & PROYEK INTERIOR'], 10, ''));
            fputcsv($file, array_pad(['Workshop & Kantor: Jl. Raya Mandiri Blok A No. 12, Jawa Timur | Telp/WA: 0812-3456-7890'], 10, ''));
            fputcsv($file, array_pad(['Email: contact@azkamandiri.com | Website: azkamandiri.nichesite.org'], 10, ''));
            fputcsv($file, array_pad([], 10, ''));

            // DOKUMEN META
            $waktuCetak = \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') . ' WIB';
            $operator = (auth()->user()->name ?? 'Administrator') . ' (' . (auth()->user()->role_name ?? 'Super Admin') . ')';
            $statusFilter = request('payment_status') ? ucfirst(request('payment_status')) : 'Semua Status';
            $supplierFilter = request('supplier_id') ? ($data['suppliers']->firstWhere('id', request('supplier_id'))->company_name ?? 'Supplier Terpilih') : 'Semua Vendor';
            $filterStr = "Operator: {$operator} | Filter: {$statusFilter}, {$supplierFilter}";

            fputcsv($file, array_pad(['REKAPITULASI PEMBELIAN & RESTOCK BAHAN BAKU', '', '', 'Waktu Cetak: ' . $waktuCetak], 10, ''));
            fputcsv($file, array_pad(['Periode Transaksi: ' . $data['startDate']->translatedFormat('d F Y') . ' s/d ' . $data['endDate']->translatedFormat('d F Y'), '', '', $filterStr], 10, ''));
            fputcsv($file, array_pad([], 10, ''));

            // === SHEET 1: RINGKASAN PEMBELIAN & RESTOCK UTAMA ===
            fputcsv($file, array_pad(['=== SHEET 1: RINGKASAN PEMBELIAN & RESTOCK UTAMA ==='], 10, ''));
            fputcsv($file, array_pad(['Metrik Belanja', 'Nilai (Rp) / Keterangan'], 10, ''));
            fputcsv($file, array_pad(['Total Pengeluaran Belanja', (float)$data['totalAmount']], 10, ''));
            fputcsv($file, array_pad(['Total Material Masuk (Item/Batang)', (float)$data['totalItemsQty']], 10, ''));
            fputcsv($file, array_pad(['Belanja Lunas (Terbayar)', (float)$data['paidTotal']], 10, ''));
            fputcsv($file, array_pad(['Hutang Belanja / Tempo', (float)$data['unpaidTotal']], 10, ''));
            fputcsv($file, array_pad([], 10, ''));

            // DISTRIBUSI STATUS PEMBAYARAN FAKTUR
            fputcsv($file, array_pad(['DISTRIBUSI STATUS PEMBAYARAN FAKTUR'], 10, ''));
            fputcsv($file, array_pad(['Status Pembayaran', 'Jumlah Faktur', 'Total Belanja (Rp)', 'Persentase (%)'], 10, ''));
            $totAmt = (float)$data['totalAmount'];
            $pctPaid = $totAmt > 0 ? number_format(($data['paidTotal'] / $totAmt) * 100, 1) . '%' : '0.0%';
            $pctPartial = $totAmt > 0 ? number_format(($data['partialTotal'] / $totAmt) * 100, 1) . '%' : '0.0%';
            $pctUnpaid = $totAmt > 0 ? number_format(($data['unpaidTotalOnly'] / $totAmt) * 100, 1) . '%' : '0.0%';
            fputcsv($file, array_pad(['Lunas', $data['paidCount'] . ' Faktur', (float)$data['paidTotal'], $pctPaid], 10, ''));
            fputcsv($file, array_pad(['DP / Sebagian', $data['partialCount'] . ' Faktur', (float)$data['partialTotal'], $pctPartial], 10, ''));
            fputcsv($file, array_pad(['Belum Lunas', $data['unpaidCount'] . ' Faktur', (float)$data['unpaidTotalOnly'], $pctUnpaid], 10, ''));
            fputcsv($file, array_pad([], 10, ''));

            // === SHEET 2: RINCIAN FAKTUR PEMBELIAN & RESTOCK PERIODE TERPILIH ===
            $dataFoundText = $data['totalPurchasesCount'] . ' Data Ditemukan';
            fputcsv($file, array_pad(['=== SHEET 2: RINCIAN FAKTUR PEMBELIAN & RESTOCK PERIODE TERPILIH ==='], 10, ''));
            fputcsv($file, array_pad(['Periode Transaksi: ' . $data['startDate']->translatedFormat('d F Y') . ' s/d ' . $data['endDate']->translatedFormat('d F Y') . ' | ' . $dataFoundText], 10, ''));
            fputcsv($file, array_pad([], 10, ''));

            fputcsv($file, [
                'No. Faktur PO',
                'Tanggal & Waktu',
                'Supplier / Vendor',
                'No. Telepon',
                'Varian Item',
                'Total Qty Masuk',
                'Rincian Barang & Material Masuk',
                'Total Faktur (Rp)',
                'Status Bayar',
                'Catatan',
            ]);

            $totalVariantsCount = 0;
            foreach ($purchases as $p) {
                $supplierName = $p->supplier ? ($p->supplier->company_name ?: $p->supplier->name) : 'Supplier Umum';
                $supplierPhone = $p->supplier && $p->supplier->phone ? $p->supplier->phone : '-';

                $itemsSummary = [];
                $poQty = 0;
                foreach ($p->items as $it) {
                    $prodName = $it->product ? $it->product->name : 'Item';
                    $unitSymbol = $it->product && $it->product->unit ? $it->product->unit->symbol : 'unit';
                    $itemsSummary[] = $prodName . ' (' . (float)$it->quantity . ' ' . $unitSymbol . ' @ Rp ' . number_format($it->unit_cost, 0, ',', '.') . ')';
                    $poQty += (float)$it->quantity;
                }
                $totalVariantsCount += $p->items->count();

                $statusLabel = 'Lunas';
                if ($p->payment_status === 'partial') $statusLabel = 'DP / Sebagian';
                elseif ($p->payment_status === 'unpaid') $statusLabel = 'Belum Lunas';

                fputcsv($file, [
                    $p->invoice_number,
                    $p->purchase_date ? $p->purchase_date->format('d/m/Y') : '-',
                    $supplierName,
                    $supplierPhone,
                    $p->items->count(),
                    $poQty,
                    implode('; ', $itemsSummary),
                    (float) $p->total_amount,
                    $statusLabel,
                    $p->notes ?: '',
                ]);
            }

            // TOTAL ROW
            fputcsv($file, [
                'TOTAL PERIODE (' . $data['totalPurchasesCount'] . ' Faktur)',
                '',
                '',
                '',
                $totalVariantsCount . ' Item',
                $data['totalItemsQty'],
                '',
                (float) $data['totalAmount'],
                '',
                $data['totalPurchasesCount'] . ' Faktur',
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Compute profit & loss dataset
     */
    private function getProfitLossData(Request $request): array
    {
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth()->startOfDay();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfMonth()->endOfDay();

        $items = TransactionItem::with(['product.category', 'transaction'])
            ->whereHas('transaction', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->get();

        $totalSales = 0;
        $totalCost = 0;

        foreach ($items as $item) {
            $totalSales += (float)$item->subtotal;
            $totalCost += (float)$item->cost_price * (float)$item->quantity;
        }

        $grossProfit = $totalSales - $totalCost;
        $profitMargin = $totalSales > 0 ? ($grossProfit / $totalSales) * 100 : 0;

        // Group by product for profitability table
        $productStats = [];
        foreach ($items as $item) {
            $prodName = $item->product->name ?? 'Produk Dihapus';
            $sku = $item->product->sku ?? '-';
            if (!isset($productStats[$sku])) {
                $productStats[$sku] = [
                    'name' => $prodName,
                    'sku' => $sku,
                    'category' => $item->product->category->name ?? 'Material Umum',
                    'unit' => $item->product->unit->symbol ?? 'pcs',
                    'qty' => 0,
                    'revenue' => 0,
                    'cost' => 0,
                    'profit' => 0,
                ];
            }
            $itemRev = (float)$item->subtotal;
            $itemCost = (float)$item->cost_price * (float)$item->quantity;

            $productStats[$sku]['qty'] += (float)$item->quantity;
            $productStats[$sku]['revenue'] += $itemRev;
            $productStats[$sku]['cost'] += $itemCost;
            $productStats[$sku]['profit'] += ($itemRev - $itemCost);
        }

        // Sort by highest profit
        usort($productStats, fn($a, $b) => $b['profit'] <=> $a['profit']);

        return compact(
            'startDate',
            'endDate',
            'totalSales',
            'totalCost',
            'grossProfit',
            'profitMargin',
            'productStats'
        );
    }

    /**
     * Display Profit & Loss Report Screen
     */
    public function profitLoss(Request $request)
    {
        $data = $this->getProfitLossData($request);
        return view('admin.reports.profit_loss', $data);
    }

    /**
     * Generate Official Profit & Loss Report PDF (A4 Portrait)
     */
    public function profitLossPdf(Request $request)
    {
        $data = $this->getProfitLossData($request);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $html = view('admin.reports.profit_loss_pdf', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Laporan-Laba-Rugi-' . $data['startDate']->format('Ymd') . '-' . $data['endDate']->format('Ymd') . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    /**
     * Compute stock valuation & movement dataset
     */
    private function getStockData(Request $request): array
    {
        $query = Product::with(['category', 'unit'])->orderBy('name');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->get('filter') === 'low') {
            $query->whereColumn('stock', '<=', 'min_stock');
        }

        $products = $query->get();

        $totalCostValue = 0;
        $totalRetailValue = 0;
        $totalItems = $products->count();
        $lowStockCount = 0;

        foreach ($products as $p) {
            $totalCostValue += (float)$p->cost_price * (float)$p->stock;
            $totalRetailValue += (float)$p->price * (float)$p->stock;
            if ((float)$p->stock <= (float)$p->min_stock) {
                $lowStockCount++;
            }
        }

        $categories = \App\Models\InventoryCategory::where('is_active', true)->orderBy('name')->get();

        return compact(
            'products',
            'categories',
            'totalCostValue',
            'totalRetailValue',
            'totalItems',
            'lowStockCount'
        );
    }

    /**
     * Display Stock Valuation Report Screen
     */
    public function stock(Request $request)
    {
        $data = $this->getStockData($request);
        return view('admin.reports.stock', $data);
    }

    /**
     * Generate Official Stock Valuation Report PDF (A4 Landscape)
     */
    public function stockPdf(Request $request)
    {
        $data = $this->getStockData($request);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $html = view('admin.reports.stock_pdf', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Laporan-Valuasi-Stok-' . date('Ymd-His') . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    /**
     * Export Sales Report as Multi-Sheet Excel (.xlsx) Workbook
     */
    public function salesExcel(Request $request)
    {
        $data = $this->getSalesData($request);
        $transactions = $data['transactions'];

        $spreadsheet = new Spreadsheet();

        // -----------------------------------------------------------
        // TAB SHEET 1: RINGKASAN KEUANGAN & METODE BAYAR
        // -----------------------------------------------------------
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Ringkasan Keuangan');

        // Kop Perusahaan
        $sheet1->setCellValue('A1', 'AZKAMANDIRI');
        $sheet1->getStyle('A1')->getFont()->setBold(true)->setSize(16)->getColor()->setARGB('FF172B4D');

        $sheet1->setCellValue('A2', 'SPESIALIS KUSEN ALUMINIUM, KACA TEMPERED, & PROYEK INTERIOR');
        $sheet1->getStyle('A2')->getFont()->setBold(true)->setSize(9)->getColor()->setARGB('FF475569');

        $sheet1->setCellValue('A3', 'Workshop & Kantor: Jl. Raya Mandiri Blok A No. 12, Jawa Timur | Telp/WA: 0812-3456-7890');
        $sheet1->getStyle('A3')->getFont()->setSize(8)->getColor()->setARGB('FF64748B');

        $sheet1->setCellValue('A4', 'Email: contact@azkamandiri.com | Website: azkamandiri.nichesite.org');
        $sheet1->getStyle('A4')->getFont()->setSize(8)->getColor()->setARGB('FF64748B');

        // Metadata Dokumen
        $sheet1->setCellValue('A6', 'REKAPITULASI PENJUALAN & KAS MASUK (POS)');
        $sheet1->getStyle('A6')->getFont()->setBold(true)->setSize(11)->getColor()->setARGB('FF0F172A');

        $sheet1->setCellValue('D6', 'Waktu Cetak: ' . Carbon::now()->translatedFormat('d F Y - H:i') . ' WIB');
        $sheet1->getStyle('D6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet1->getStyle('D6')->getFont()->setSize(8)->getColor()->setARGB('FF64748B');

        $sheet1->setCellValue('A7', 'Periode Transaksi: ' . $data['startDate']->translatedFormat('d F Y') . ' s/d ' . $data['endDate']->translatedFormat('d F Y'));
        $sheet1->getStyle('A7')->getFont()->setSize(8.5);

        $opStr = 'Operator: ' . (auth()->user()->name ?? 'Administrator') . ' (' . (auth()->user()->role_name ?? 'Super Admin') . ') | Filter: ' . (request('payment_status') ? ucfirst(request('payment_status')) : 'Semua Status') . ', ' . (request('payment_type') ? strtoupper(request('payment_type')) : 'Semua Metode');
        $sheet1->setCellValue('D7', $opStr);
        $sheet1->getStyle('D7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet1->getStyle('D7')->getFont()->setSize(8)->getColor()->setARGB('FF64748B');

        // Seksi 1: Ringkasan Keuangan Utama
        $sheet1->setCellValue('A9', 'RINGKASAN KEUANGAN UTAMA');
        $sheet1->getStyle('A9')->getFont()->setBold(true)->setSize(10)->getColor()->setARGB('FF172B4D');

        $sheet1->setCellValue('A10', 'Metrik Keuangan');
        $sheet1->setCellValue('B10', 'Nilai (Rp) / Keterangan');
        $sheet1->getStyle('A10:B10')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet1->getStyle('A10:B10')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');

        $metrics = [
            ['Total Omzet Penjualan', (float)$data['totalRevenue'], 'FF0F172A'],
            ['Kas Masuk (Terbayar)', (float)$data['totalPaid'], 'FF16A34A'],
            ['Piutang Berjalan', (float)$data['totalPiutang'], 'FFD97706'],
            ['Total Potongan Diskon', (float)$data['totalDiscount'], 'FFDC2626'],
        ];

        $r = 11;
        foreach ($metrics as $m) {
            $sheet1->setCellValue('A' . $r, $m[0]);
            $sheet1->setCellValue('B' . $r, $m[1]);
            $sheet1->getStyle('B' . $r)->getNumberFormat()->setFormatCode('#,##0');
            $sheet1->getStyle('B' . $r)->getFont()->setBold(true)->getColor()->setARGB($m[2]);
            $r++;
        }
        $sheet1->getStyle('A10:B14')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');

        // Seksi 2: Distribusi Metode Bayar
        $sheet1->setCellValue('A16', 'DISTRIBUSI PENERIMAAN BERDASARKAN METODE BAYAR');
        $sheet1->getStyle('A16')->getFont()->setBold(true)->setSize(10)->getColor()->setARGB('FF172B4D');

        $sheet1->setCellValue('A17', 'Metode Bayar');
        $sheet1->setCellValue('B17', 'Jumlah (Rp)');
        $sheet1->setCellValue('C17', 'Persentase (%)');
        $sheet1->getStyle('A17:C17')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet1->getStyle('A17:C17')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');

        $paidTotal = (float)$data['totalPaid'];
        $pmRows = [
            ['Tunai (Cash)', (float)$data['cashTotal'], $paidTotal > 0 ? ($data['cashTotal'] / $paidTotal) : 0],
            ['Transfer Bank', (float)$data['transferTotal'], $paidTotal > 0 ? ($data['transferTotal'] / $paidTotal) : 0],
            ['QRIS / E-Wallet', (float)$data['qrisTotal'], $paidTotal > 0 ? ($data['qrisTotal'] / $paidTotal) : 0],
        ];

        $r = 18;
        foreach ($pmRows as $pm) {
            $sheet1->setCellValue('A' . $r, $pm[0]);
            $sheet1->setCellValue('B' . $r, $pm[1]);
            $sheet1->setCellValue('C' . $r, $pm[2]);
            $sheet1->getStyle('B' . $r)->getNumberFormat()->setFormatCode('#,##0');
            $sheet1->getStyle('C' . $r)->getNumberFormat()->setFormatCode('0.0%');
            $r++;
        }
        $sheet1->getStyle('A17:C20')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');

        foreach (range('A', 'D') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // -----------------------------------------------------------
        // TAB SHEET 2: RINCIAN TRANSAKSI DETAIL
        // -----------------------------------------------------------
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Rincian Transaksi');

        // Kop
        $sheet2->setCellValue('A1', 'AZKAMANDIRI');
        $sheet2->getStyle('A1')->getFont()->setBold(true)->setSize(16)->getColor()->setARGB('FF172B4D');
        $sheet2->setCellValue('A2', 'SPESIALIS KUSEN ALUMINIUM, KACA TEMPERED, & PROYEK INTERIOR');
        $sheet2->getStyle('A2')->getFont()->setBold(true)->setSize(9)->getColor()->setARGB('FF475569');

        $sheet2->setCellValue('A4', 'RINCIAN TRANSAKSI PERIODE TERPILIH');
        $sheet2->getStyle('A4')->getFont()->setBold(true)->setSize(11)->getColor()->setARGB('FF0F172A');
        $sheet2->setCellValue('A5', 'Periode Transaksi: ' . $data['startDate']->translatedFormat('d F Y') . ' s/d ' . $data['endDate']->translatedFormat('d F Y') . ' | ' . $data['totalCount'] . ' Data Ditemukan');
        $sheet2->getStyle('A5')->getFont()->setSize(8.5)->getColor()->setARGB('FF64748B');

        // Table Headers
        $headers = [
            'A7' => 'No. Invoice',
            'B7' => 'Tanggal & Waktu',
            'C7' => 'Pelanggan',
            'D7' => 'No. Telepon',
            'E7' => 'Tipe',
            'F7' => 'Metode',
            'G7' => 'Subtotal (Rp)',
            'H7' => 'Diskon (Rp)',
            'I7' => 'Total Net (Rp)',
            'J7' => 'Terbayar (Rp)',
            'K7' => 'Sisa Piutang (Rp)',
            'L7' => 'Status',
        ];

        foreach ($headers as $cell => $val) {
            $sheet2->setCellValue($cell, $val);
        }
        $sheet2->getStyle('A7:L7')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet2->getStyle('A7:L7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');
        $sheet2->getStyle('A7:L7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet2->getRowDimension(7)->setRowHeight(24);

        $rowIdx = 8;
        foreach ($transactions as $t) {
            $phone = $t->customer && $t->customer->phone ? $t->customer->phone : '-';
            $orderType = $t->order_type === 'custom' ? 'Custom Proyek' : 'Ritel';
            $paymentMethod = strtoupper($t->payment_type);
            $subtotal = (float)$t->subtotal;
            $discount = (float)$t->discount_amount;
            $discountVal = $discount > 0 ? -$discount : 0;
            $totalNet = (float)$t->total_amount;
            $paid = (float)$t->paid_amount;
            $debt = max(0, $totalNet - $paid);
            $status = $t->payment_status === 'paid' ? 'Lunas' : ($t->payment_status === 'partial' ? 'DP / Sisa' : 'Belum Bayar');

            $sheet2->setCellValue('A' . $rowIdx, $t->invoice_code);
            $sheet2->setCellValue('B' . $rowIdx, $t->transaction_date ? $t->transaction_date->format('d/m/Y H:i') : '-');
            $sheet2->setCellValue('C' . $rowIdx, $t->customer ? $t->customer->name : 'Pelanggan Umum');
            $sheet2->setCellValue('D' . $rowIdx, $phone);
            $sheet2->setCellValue('E' . $rowIdx, $orderType);
            $sheet2->setCellValue('F' . $rowIdx, $paymentMethod);
            $sheet2->setCellValue('G' . $rowIdx, $subtotal);
            $sheet2->setCellValue('H' . $rowIdx, $discountVal);
            $sheet2->setCellValue('I' . $rowIdx, $totalNet);
            $sheet2->setCellValue('J' . $rowIdx, $paid);
            $sheet2->setCellValue('K' . $rowIdx, $debt);
            $sheet2->setCellValue('L' . $rowIdx, $status);

            // Number formats
            $sheet2->getStyle('G' . $rowIdx . ':K' . $rowIdx)->getNumberFormat()->setFormatCode('#,##0');
            $sheet2->getStyle('A' . $rowIdx)->getFont()->setBold(true);
            $sheet2->getStyle('I' . $rowIdx)->getFont()->setBold(true);
            $sheet2->getStyle('J' . $rowIdx)->getFont()->setBold(true)->getColor()->setARGB('FF16A34A');
            if ($debt > 0) {
                $sheet2->getStyle('K' . $rowIdx)->getFont()->setBold(true)->getColor()->setARGB('FFD97706');
            }

            // Alignments
            $sheet2->getStyle('B' . $rowIdx)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet2->getStyle('E' . $rowIdx)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet2->getStyle('F' . $rowIdx)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet2->getStyle('L' . $rowIdx)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Zebra striping
            if ($rowIdx % 2 == 0) {
                $sheet2->getStyle('A' . $rowIdx . ':L' . $rowIdx)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
            }

            $rowIdx++;
        }

        // Total Row
        $totDiscount = (float)$data['totalDiscount'] > 0 ? -(float)$data['totalDiscount'] : 0;
        $sheet2->setCellValue('A' . $rowIdx, 'TOTAL PERIODE (' . $data['totalCount'] . ' Nota)');
        $sheet2->setCellValue('G' . $rowIdx, (float)$data['totalSubtotal']);
        $sheet2->setCellValue('H' . $rowIdx, $totDiscount);
        $sheet2->setCellValue('I' . $rowIdx, (float)$data['totalRevenue']);
        $sheet2->setCellValue('J' . $rowIdx, (float)$data['totalPaid']);
        $sheet2->setCellValue('K' . $rowIdx, (float)$data['totalPiutang']);
        $sheet2->setCellValue('L' . $rowIdx, $data['totalCount'] . ' Nota');

        $sheet2->getStyle('A' . $rowIdx . ':L' . $rowIdx)->getFont()->setBold(true);
        $sheet2->getStyle('G' . $rowIdx . ':K' . $rowIdx)->getNumberFormat()->setFormatCode('#,##0');
        $sheet2->getStyle('J' . $rowIdx)->getFont()->getColor()->setARGB('FF16A34A');
        $sheet2->getStyle('K' . $rowIdx)->getFont()->getColor()->setARGB('FFD97706');
        $sheet2->getStyle('L' . $rowIdx)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('A' . $rowIdx . ':L' . $rowIdx)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF1F5F9');

        // Borders
        $sheet2->getStyle('A7:L' . $rowIdx)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');
        $sheet2->getStyle('A' . $rowIdx . ':L' . $rowIdx)->getBorders()->getTop()->setBorderStyle(Border::BORDER_MEDIUM)->getColor()->setARGB('FF1E293B');

        foreach (range('A', 'L') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        // Set Sheet 1 as active by default
        $spreadsheet->setActiveSheetIndex(0);

        $filename = 'laporan-penjualan-pos-' . $data['startDate']->format('Ymd') . '-' . $data['endDate']->format('Ymd') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Export Sales Report as CSV/Excel
     */
    public function salesCsv(Request $request)
    {
        $data = $this->getSalesData($request);
        $transactions = $data['transactions'];
        $filename = 'laporan-penjualan-pos-' . $data['startDate']->format('Ymd') . '-' . $data['endDate']->format('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($transactions, $data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // KOP PERUSAHAAN (Padded to 12 cols)
            fputcsv($file, array_pad(['AZKAMANDIRI'], 12, ''));
            fputcsv($file, array_pad(['SPESIALIS KUSEN ALUMINIUM, KACA TEMPERED, & PROYEK INTERIOR'], 12, ''));
            fputcsv($file, array_pad(['Workshop & Kantor: Jl. Raya Mandiri Blok A No. 12, Jawa Timur | Telp/WA: 0812-3456-7890'], 12, ''));
            fputcsv($file, array_pad(['Email: contact@azkamandiri.com | Website: azkamandiri.nichesite.org'], 12, ''));
            fputcsv($file, array_pad([], 12, ''));

            // DOKUMEN META
            $waktuCetak = \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') . ' WIB';
            $operator = (auth()->user()->name ?? 'Administrator') . ' (' . (auth()->user()->role_name ?? 'Super Admin') . ')';
            $statusFilter = request('payment_status') ? ucfirst(request('payment_status')) : 'Semua Status';
            $metodeFilter = request('payment_type') ? strtoupper(request('payment_type')) : 'Semua Metode';
            $filterStr = "Operator: {$operator} | Filter: {$statusFilter}, {$metodeFilter}";

            fputcsv($file, array_pad(['REKAPITULASI PENJUALAN & KAS MASUK (POS)', '', '', 'Waktu Cetak: ' . $waktuCetak], 12, ''));
            fputcsv($file, array_pad(['Periode Transaksi: ' . $data['startDate']->translatedFormat('d F Y') . ' s/d ' . $data['endDate']->translatedFormat('d F Y'), '', '', $filterStr], 12, ''));
            fputcsv($file, array_pad([], 12, ''));

            // === SHEET 1: RINGKASAN KEUANGAN UTAMA ===
            fputcsv($file, array_pad(['=== SHEET 1: RINGKASAN KEUANGAN UTAMA ==='], 12, ''));
            fputcsv($file, array_pad(['Metrik Keuangan', 'Nilai (Rp) / Keterangan'], 12, ''));
            fputcsv($file, array_pad(['Total Omzet Penjualan', (float)$data['totalRevenue']], 12, ''));
            fputcsv($file, array_pad(['Kas Masuk (Terbayar)', (float)$data['totalPaid']], 12, ''));
            fputcsv($file, array_pad(['Piutang Berjalan', (float)$data['totalPiutang']], 12, ''));
            fputcsv($file, array_pad(['Total Potongan Diskon', (float)$data['totalDiscount']], 12, ''));
            fputcsv($file, array_pad([], 12, ''));

            // DISTRIBUSI PENERIMAAN BERDASARKAN METODE BAYAR
            fputcsv($file, array_pad(['DISTRIBUSI PENERIMAAN BERDASARKAN METODE BAYAR'], 12, ''));
            fputcsv($file, array_pad(['Metode Bayar', 'Jumlah (Rp)', 'Persentase (%)'], 12, ''));
            $paidTotal = (float)$data['totalPaid'];
            $pctCash = $paidTotal > 0 ? number_format(($data['cashTotal'] / $paidTotal) * 100, 1) . '%' : '0.0%';
            $pctTransfer = $paidTotal > 0 ? number_format(($data['transferTotal'] / $paidTotal) * 100, 1) . '%' : '0.0%';
            $pctQris = $paidTotal > 0 ? number_format(($data['qrisTotal'] / $paidTotal) * 100, 1) . '%' : '0.0%';
            fputcsv($file, array_pad(['Tunai (Cash)', (float)$data['cashTotal'], $pctCash], 12, ''));
            fputcsv($file, array_pad(['Transfer Bank', (float)$data['transferTotal'], $pctTransfer], 12, ''));
            fputcsv($file, array_pad(['QRIS / E-Wallet', (float)$data['qrisTotal'], $pctQris], 12, ''));
            fputcsv($file, array_pad([], 12, ''));

            // === SHEET 2: RINCIAN TRANSAKSI PERIODE TERPILIH ===
            $dataFoundText = $data['totalCount'] . ' Data Ditemukan';
            fputcsv($file, array_pad(['=== SHEET 2: RINCIAN TRANSAKSI PERIODE TERPILIH ==='], 12, ''));
            fputcsv($file, array_pad(['Periode Transaksi: ' . $data['startDate']->translatedFormat('d F Y') . ' s/d ' . $data['endDate']->translatedFormat('d F Y') . ' | ' . $dataFoundText], 12, ''));
            fputcsv($file, array_pad([], 12, ''));

            fputcsv($file, [
                'No. Invoice',
                'Tanggal & Waktu',
                'Pelanggan',
                'No. Telepon',
                'Tipe',
                'Metode',
                'Subtotal (Rp)',
                'Diskon (Rp)',
                'Total Net (Rp)',
                'Terbayar (Rp)',
                'Sisa Piutang (Rp)',
                'Status',
            ]);

            foreach ($transactions as $t) {
                $phone = $t->customer && $t->customer->phone ? $t->customer->phone : '-';
                $orderType = $t->order_type === 'custom' ? 'Custom Proyek' : 'Ritel';
                $paymentMethod = strtoupper($t->payment_type);
                $subtotal = (float)$t->subtotal;
                $discount = (float)$t->discount_amount;
                $discountVal = $discount > 0 ? -$discount : 0;
                $totalNet = (float)$t->total_amount;
                $paid = (float)$t->paid_amount;
                $debt = max(0, $totalNet - $paid);
                $status = $t->payment_status === 'paid' ? 'Lunas' : ($t->payment_status === 'partial' ? 'DP / Sisa' : 'Belum Bayar');

                fputcsv($file, [
                    $t->invoice_code,
                    $t->transaction_date ? $t->transaction_date->format('d/m/Y H:i') : '-',
                    $t->customer ? $t->customer->name : 'Pelanggan Umum',
                    $phone,
                    $orderType,
                    $paymentMethod,
                    $subtotal,
                    $discountVal,
                    $totalNet,
                    $paid,
                    $debt,
                    $status,
                ]);
            }

            // TOTAL ROW
            $discountTotalVal = (float)$data['totalDiscount'] > 0 ? -(float)$data['totalDiscount'] : 0;
            fputcsv($file, [
                'TOTAL PERIODE (' . $data['totalCount'] . ' Nota)',
                '',
                '',
                '',
                '',
                '',
                (float)$data['totalSubtotal'],
                $discountTotalVal,
                (float)$data['totalRevenue'],
                (float)$data['totalPaid'],
                (float)$data['totalPiutang'],
                $data['totalCount'] . ' Nota',
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Profit & Loss Report as CSV/Excel
     */
    public function profitLossCsv(Request $request)
    {
        $data = $this->getProfitLossData($request);
        $products = $data['productStats'];
        $filename = 'laporan-laba-rugi-' . $data['startDate']->format('Ymd') . '-' . $data['endDate']->format('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($products, $data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['LAPORAN LABA RUGI PENJUALAN - AZKAMANDIRI']);
            fputcsv($file, ['Periode', $data['startDate']->format('d/m/Y') . ' s/d ' . $data['endDate']->format('d/m/Y')]);
            fputcsv($file, ['Total Omzet Penjualan (Rp)', (float)$data['totalSales']]);
            fputcsv($file, ['Total Modal / HPP (Rp)', (float)$data['totalCost']]);
            fputcsv($file, ['Laba Kotor Bersih (Rp)', (float)$data['grossProfit']]);
            fputcsv($file, ['Margin Keuntungan', number_format($data['profitMargin'], 2) . '%']);
            fputcsv($file, []);

            fputcsv($file, [
                'No',
                'SKU',
                'Nama Produk & Material',
                'Kategori',
                'Satuan',
                'Qty Terjual',
                'Total Omzet (Rp)',
                'Total Modal (Rp)',
                'Laba Kotor (Rp)',
                'Margin (%)',
            ]);

            $no = 1;
            foreach ($products as $p) {
                $marginPercent = $p['revenue'] > 0 ? (($p['profit'] / $p['revenue']) * 100) : 0;
                fputcsv($file, [
                    $no++,
                    $p['sku'],
                    $p['name'],
                    $p['category'],
                    $p['unit'],
                    $p['qty'],
                    (float) $p['revenue'],
                    (float) $p['cost'],
                    (float) $p['profit'],
                    number_format($marginPercent, 2) . '%',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Stock Valuation Report as CSV/Excel
     */
    public function stockCsv(Request $request)
    {
        $data = $this->getStockData($request);
        $products = $data['products'];
        $filename = 'laporan-valuasi-stok-' . date('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($products, $data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['LAPORAN VALUASI & SISA STOK - AZKAMANDIRI']);
            fputcsv($file, ['Tanggal Cetak', date('d/m/Y H:i')]);
            fputcsv($file, ['Total Varian Item', $data['totalItems']]);
            fputcsv($file, ['Total Nilai Modal (HPP)', (float)$data['totalCostValue']]);
            fputcsv($file, ['Total Nilai Jual Eceran', (float)$data['totalRetailValue']]);
            fputcsv($file, ['Item Stok Kritis / Menipis', $data['lowStockCount']]);
            fputcsv($file, []);

            fputcsv($file, [
                'No',
                'SKU / Kode',
                'Nama Produk Material',
                'Kategori',
                'Satuan',
                'Stok Fisik',
                'Stok Minimum',
                'Harga Beli/Modal (Rp)',
                'Harga Jual (Rp)',
                'Total Nilai Modal (Rp)',
                'Total Nilai Jual (Rp)',
                'Potensi Laba (Rp)',
                'Status Stok',
            ]);

            $no = 1;
            foreach ($products as $p) {
                $costVal = (float)$p->cost_price * (float)$p->stock;
                $retailVal = (float)$p->price * (float)$p->stock;
                $potentialProfit = $retailVal - $costVal;

                $status = 'Aman';
                if ($p->type === 'standard') {
                    if ($p->stock <= 0) $status = 'Habis';
                    elseif ($p->stock <= $p->min_stock) $status = 'Kritis / Menipis';
                } else {
                    $status = 'Custom / Jasa';
                }

                fputcsv($file, [
                    $no++,
                    $p->sku,
                    $p->name,
                    $p->category ? $p->category->name : 'Umum',
                    $p->unit ? $p->unit->symbol : 'unit',
                    $p->type === 'standard' ? (float)$p->stock : '-',
                    $p->type === 'standard' ? (float)$p->min_stock : '-',
                    (float) $p->cost_price,
                    (float) $p->price,
                    $costVal,
                    $retailVal,
                    $potentialProfit,
                    $status,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
