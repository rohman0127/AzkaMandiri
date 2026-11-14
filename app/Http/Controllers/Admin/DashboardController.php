<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\InventoryCategory;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DashboardController extends Controller
{
    /**
     * Compute comprehensive, real-time analytics data for the dashboard
     */
    private function getDashboardAnalyticsData(int $selectedYear): array
    {
        // 1. Available years from database
        $yearsFromDb = Transaction::selectRaw('YEAR(transaction_date) as y')
            ->distinct()
            ->pluck('y')
            ->filter()
            ->map(fn($y) => (int)$y)
            ->toArray();
        $availableYears = array_unique(array_merge([date('Y'), date('Y') - 1, date('Y') - 2], $yearsFromDb));
        rsort($availableYears);

        // 2. Monthly aggregates for selected year
        $monthlySalesRaw = Transaction::whereYear('transaction_date', $selectedYear)
            ->selectRaw('MONTH(transaction_date) as m, COUNT(*) as count, SUM(total_amount) as total, SUM(paid_amount) as paid')
            ->groupBy('m')
            ->get()
            ->keyBy('m');

        $monthlyItemsRaw = TransactionItem::whereHas('transaction', function ($q) use ($selectedYear) {
                $q->whereYear('transaction_date', $selectedYear);
            })
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->selectRaw('MONTH(transactions.transaction_date) as m, SUM(transaction_items.subtotal) as subtotal, SUM(transaction_items.quantity * transaction_items.cost_price) as cost')
            ->groupBy('m')
            ->get()
            ->keyBy('m');

        $monthlyPurchasesRaw = Purchase::whereYear('purchase_date', $selectedYear)
            ->selectRaw('MONTH(purchase_date) as m, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('m')
            ->get()
            ->keyBy('m');

        $chartCategories = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartSales = [];
        $chartProfit = [];
        $chartPurchases = [];
        $chartTrxCount = [];

        $annualTotalSales = 0;
        $annualTotalProfit = 0;
        $annualTotalTrx = 0;
        $annualTotalPurchases = 0;

        for ($m = 1; $m <= 12; $m++) {
            $sales = isset($monthlySalesRaw[$m]) ? (float)$monthlySalesRaw[$m]->paid : 0;
            $count = isset($monthlySalesRaw[$m]) ? (int)$monthlySalesRaw[$m]->count : 0;

            $itemSubtotal = isset($monthlyItemsRaw[$m]) ? (float)$monthlyItemsRaw[$m]->subtotal : 0;
            $itemCost = isset($monthlyItemsRaw[$m]) ? (float)$monthlyItemsRaw[$m]->cost : 0;
            $profit = max(0, $itemSubtotal - $itemCost);

            $purchases = isset($monthlyPurchasesRaw[$m]) ? (float)$monthlyPurchasesRaw[$m]->total : 0;

            $chartSales[] = (int) round($sales);
            $chartProfit[] = (int) round($profit);
            $chartPurchases[] = (int) round($purchases);
            $chartTrxCount[] = $count;

            $annualTotalSales += $sales;
            $annualTotalProfit += $profit;
            $annualTotalTrx += $count;
            $annualTotalPurchases += $purchases;
        }

        $avgMonthlySales = $annualTotalSales / 12;
        $annualProfitMargin = $annualTotalSales > 0 ? ($annualTotalProfit / $annualTotalSales) * 100 : 0;

        // 3. Order type breakdown for selected year
        $retailSales = (float) Transaction::whereYear('transaction_date', $selectedYear)
            ->where('order_type', 'retail')
            ->sum('total_amount');
        $customSales = (float) Transaction::whereYear('transaction_date', $selectedYear)
            ->where('order_type', 'custom')
            ->sum('total_amount');

        // 4. Real-time POS Cash & Receivables
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();
        $monthStart = Carbon::now()->startOfMonth()->startOfDay();
        $monthEnd = Carbon::now()->endOfMonth()->endOfDay();

        $todaySales = (float) Transaction::whereBetween('transaction_date', [$todayStart, $todayEnd])->sum('paid_amount');
        $todayTrxCount = (int) Transaction::whereBetween('transaction_date', [$todayStart, $todayEnd])->count();
        $monthSales = (float) Transaction::whereBetween('transaction_date', [$monthStart, $monthEnd])->sum('paid_amount');
        $monthTrxCount = (int) Transaction::whereBetween('transaction_date', [$monthStart, $monthEnd])->count();

        $totalReceivables = (float) (Transaction::where('payment_status', '!=', 'paid')
            ->selectRaw('SUM(total_amount - paid_amount) as sisa')
            ->value('sisa') ?? 0);

        // 5. Real-time Stock Valuation & Health
        $standardProducts = Product::with(['category', 'unit'])->where('type', 'standard')->get();
        $totalStockCostValue = (float) $standardProducts->sum(fn($p) => (float)$p->cost_price * (float)$p->stock);
        $totalStockRetailValue = (float) $standardProducts->sum(fn($p) => (float)$p->price * (float)$p->stock);
        $potentialStockProfit = max(0, $totalStockRetailValue - $totalStockCostValue);
        $potentialStockMargin = $totalStockRetailValue > 0 ? ($potentialStockProfit / $totalStockRetailValue) * 100 : 0;
        $totalPhysicalStockUnits = (float) $standardProducts->sum('stock');

        $safeStockCount = $standardProducts->filter(fn($p) => $p->stock > $p->min_stock)->count();
        $lowStockCount = $standardProducts->filter(fn($p) => $p->stock <= $p->min_stock && $p->stock > 0)->count();
        $outOfStockCount = $standardProducts->filter(fn($p) => $p->stock <= 0)->count();
        $criticalProducts = $standardProducts->filter(fn($p) => $p->stock <= $p->min_stock)->sortBy('stock')->take(6);

        // 6. Category Asset Breakdown for Highcharts
        $categoryBreakdown = InventoryCategory::with('products')->get()->map(function ($cat) {
            $std = $cat->products->where('type', 'standard');
            return [
                'name' => $cat->name,
                'count' => $std->count(),
                'asset_value' => (float) $std->sum(fn($p) => (float)$p->cost_price * (float)$p->stock),
                'retail_value' => (float) $std->sum(fn($p) => (float)$p->price * (float)$p->stock),
            ];
        })->filter(fn($c) => $c['asset_value'] > 0 || $c['count'] > 0)->values();

        // 7. Purchases & Restock
        $annualPurchasesCount = (int) Purchase::whereYear('purchase_date', $selectedYear)->count();
        $monthPurchasesTotal = (float) Purchase::whereBetween('purchase_date', [$monthStart, $monthEnd])->sum('total_amount');
        $unpaidPurchasesTotal = (float) Purchase::where('payment_status', '!=', 'paid')->sum('total_amount');

        // 8. General CMS stats
        $stats = [
            'total_services' => Service::count(),
            'total_portfolios' => Portfolio::count(),
            'total_articles' => Article::count(),
            'total_testimonials' => Testimonial::count(),
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::unread()->count(),
            'total_products' => Product::count(),
            // Real-time POS
            'today_sales' => $todaySales,
            'today_trx_count' => $todayTrxCount,
            'month_sales' => $monthSales,
            'month_trx_count' => $monthTrxCount,
            'total_receivables' => $totalReceivables,
            // Selected Year Analytics
            'selected_year' => $selectedYear,
            'annual_sales' => $annualTotalSales,
            'annual_profit' => $annualTotalProfit,
            'annual_profit_margin' => $annualProfitMargin,
            'annual_trx_count' => $annualTotalTrx,
            'avg_monthly_sales' => $avgMonthlySales,
            'retail_sales' => $retailSales,
            'custom_sales' => $customSales,
            // Stock Valuation
            'stock_cost_value' => $totalStockCostValue,
            'stock_retail_value' => $totalStockRetailValue,
            'potential_stock_profit' => $potentialStockProfit,
            'potential_stock_margin' => $potentialStockMargin,
            'total_stock_units' => $totalPhysicalStockUnits,
            'safe_stock_count' => $safeStockCount,
            'low_stock_count' => $lowStockCount,
            'out_of_stock_count' => $outOfStockCount,
            // Purchases
            'annual_purchases' => $annualTotalPurchases,
            'annual_purchases_count' => $annualPurchasesCount,
            'month_purchases' => $monthPurchasesTotal,
            'unpaid_purchases' => $unpaidPurchasesTotal,
        ];

        return compact(
            'selectedYear',
            'availableYears',
            'stats',
            'chartCategories',
            'chartSales',
            'chartProfit',
            'chartPurchases',
            'chartTrxCount',
            'retailSales',
            'customSales',
            'categoryBreakdown',
            'criticalProducts'
        );
    }

    /**
     * Display Main Dashboard with Centralized Real-time Reporting & Highcharts
     */
    public function index(Request $request): View
    {
        $selectedYear = (int) $request->input('year', date('Y'));
        $data = $this->getDashboardAnalyticsData($selectedYear);

        $recentTransactions = Transaction::with(['customer', 'items.product'])->latest('transaction_date')->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentPortfolios = Portfolio::latest()->take(4)->get();
        $recentArticles = Article::latest()->take(4)->get();

        return view('admin.dashboard.index', array_merge($data, compact(
            'recentTransactions',
            'recentMessages',
            'recentPortfolios',
            'recentArticles'
        )));
    }

    /**
     * Export Executive Dashboard Summary as Multi-Sheet Excel (.xlsx)
     */
    public function exportExcel(Request $request)
    {
        $selectedYear = (int) $request->input('year', date('Y'));
        $data = $this->getDashboardAnalyticsData($selectedYear);
        $stats = $data['stats'];

        $spreadsheet = new Spreadsheet();

        // -----------------------------------------------------------
        // SHEET 1: RINGKASAN EKSEKUTIF BI
        // -----------------------------------------------------------
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Ringkasan Eksekutif');

        // Kop
        $sheet1->setCellValue('A1', 'AZKAMANDIRI');
        $sheet1->getStyle('A1')->getFont()->setBold(true)->setSize(16)->getColor()->setARGB('FF172B4D');
        $sheet1->setCellValue('A2', 'PUSAT ANALISIS & LAPORAN TERPADU EKSEKUTIF (EXECUTIVE BI DASHBOARD)');
        $sheet1->getStyle('A2')->getFont()->setBold(true)->setSize(9)->getColor()->setARGB('FF475569');
        $sheet1->setCellValue('A3', 'Workshop & Kantor: Jl. Raya Mandiri Blok A No. 12, Jawa Timur | Telp/WA: 0812-3456-7890');
        $sheet1->getStyle('A3')->getFont()->setSize(8)->getColor()->setARGB('FF64748B');

        $sheet1->setCellValue('A5', 'LAPORAN KINERJA EKSEKUTIF TAHUN ' . $selectedYear);
        $sheet1->getStyle('A5')->getFont()->setBold(true)->setSize(11)->getColor()->setARGB('FF0F172A');
        $sheet1->setCellValue('C5', 'Waktu Cetak: ' . Carbon::now()->translatedFormat('d F Y - H:i') . ' WIB');
        $sheet1->getStyle('C5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet1->getStyle('C5')->getFont()->setSize(8)->getColor()->setARGB('FF64748B');

        // Metrik Utama
        $sheet1->setCellValue('A7', 'METRIK KEUANGAN & PENJUALAN (POS)');
        $sheet1->getStyle('A7')->getFont()->setBold(true)->setSize(10)->getColor()->setARGB('FF172B4D');
        $sheet1->setCellValue('A8', 'Indikator Kinerja');
        $sheet1->setCellValue('B8', 'Nilai (Rp) / Besaran');
        $sheet1->setCellValue('C8', 'Keterangan');
        $sheet1->getStyle('A8:C8')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet1->getStyle('A8:C8')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');

        $financials = [
            ['Total Omzet Penjualan (' . $selectedYear . ')', $stats['annual_sales'], 'Kas masuk tercatat'],
            ['Estimasi Laba Bersih (' . $selectedYear . ')', $stats['annual_profit'], 'Margin: ' . number_format($stats['annual_profit_margin'], 1) . '%'],
            ['Rata-rata Penjualan / Bulan', $stats['avg_monthly_sales'], 'Rerata 12 bulan berjalan'],
            ['Total Transaksi Selesai', $stats['annual_trx_count'], 'Nota transaksi kasir'],
            ['Sisa Piutang Berjalan Pelanggan', $stats['total_receivables'], 'Tagihan belum lunas saat ini'],
            ['Total Belanja Restock Bahan (' . $selectedYear . ')', $stats['annual_purchases'], $stats['annual_purchases_count'] . ' Faktur PO Restock'],
        ];

        $r = 9;
        foreach ($financials as $fin) {
            $sheet1->setCellValue('A' . $r, $fin[0]);
            $sheet1->setCellValue('B' . $r, $fin[1]);
            $sheet1->setCellValue('C' . $r, $fin[2]);
            $sheet1->getStyle('B' . $r)->getNumberFormat()->setFormatCode('#,##0');
            $sheet1->getStyle('B' . $r)->getFont()->setBold(true);
            $r++;
        }
        $sheet1->getStyle('A8:C' . ($r - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');

        // Valuasi & Inventaris
        $r++;
        $sheet1->setCellValue('A' . $r, 'VALUASI STOK & KESEHATAN GUDANG');
        $sheet1->getStyle('A' . $r)->getFont()->setBold(true)->setSize(10)->getColor()->setARGB('FF172B4D');
        $r++;

        $sheet1->setCellValue('A' . $r, 'Indikator Pergudangan');
        $sheet1->setCellValue('B' . $r, 'Nilai / Kuantitas');
        $sheet1->setCellValue('C' . $r, 'Status Evaluasi');
        $sheet1->getStyle('A' . $r . ':C' . $r)->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet1->getStyle('A' . $r . ':C' . $r)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');

        $startValRow = $r;
        $r++;
        $valuations = [
            ['Total Nilai Modal Persediaan (HPP)', $stats['stock_cost_value'], 'Aset modal tersimpan di gudang'],
            ['Total Nilai Jual Retail Gudang', $stats['stock_retail_value'], 'Potensi omzet eceran'],
            ['Potensi Keuntungan Bersih Stok', $stats['potential_stock_profit'], 'Margin potensi: ' . number_format($stats['potential_stock_margin'], 1) . '%'],
            ['Total Kuantitas Fisik Barang', $stats['total_stock_units'], 'Batang / lembar / unit aktif'],
            ['Varian Stok Aman', $stats['safe_stock_count'], 'Ketersediaan cukup'],
            ['Varian Stok Kritis / Menipis', $stats['low_stock_count'], $stats['low_stock_count'] > 0 ? 'Perlu Restock Segera!' : 'Aman'],
            ['Varian Stok Habis Total (0)', $stats['out_of_stock_count'], $stats['out_of_stock_count'] > 0 ? 'Barang Kosong' : 'Aman'],
        ];

        foreach ($valuations as $val) {
            $sheet1->setCellValue('A' . $r, $val[0]);
            $sheet1->setCellValue('B' . $r, $val[1]);
            $sheet1->setCellValue('C' . $r, $val[2]);
            $sheet1->getStyle('B' . $r)->getNumberFormat()->setFormatCode('#,##0');
            $sheet1->getStyle('B' . $r)->getFont()->setBold(true);
            $r++;
        }
        $sheet1->getStyle('A' . $startValRow . ':C' . ($r - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');

        foreach (range('A', 'C') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // -----------------------------------------------------------
        // SHEET 2: KINERJA BULANAN & TREN GRAFIK
        // -----------------------------------------------------------
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Kinerja Bulanan ' . $selectedYear);

        $sheet2->setCellValue('A1', 'AZKAMANDIRI - REKAPITULASI KINERJA 12 BULAN TAHUN ' . $selectedYear);
        $sheet2->getStyle('A1')->getFont()->setBold(true)->setSize(13)->getColor()->setARGB('FF172B4D');

        $sheet2->setCellValue('A3', 'Bulan');
        $sheet2->setCellValue('B3', 'Omzet Penjualan (Rp)');
        $sheet2->setCellValue('C3', 'Estimasi Laba Bersih (Rp)');
        $sheet2->setCellValue('D3', 'Belanja Bahan Baku (Rp)');
        $sheet2->setCellValue('E3', 'Margin Laba (%)');
        $sheet2->setCellValue('F3', 'Jumlah Transaksi (Nota)');
        $sheet2->getStyle('A3:F3')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet2->getStyle('A3:F3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');

        $r = 4;
        for ($i = 0; $i < 12; $i++) {
            $s = $data['chartSales'][$i];
            $p = $data['chartProfit'][$i];
            $b = $data['chartPurchases'][$i];
            $c = $data['chartTrxCount'][$i];
            $mrg = $s > 0 ? ($p / $s) : 0;

            $sheet2->setCellValue('A' . $r, $data['chartCategories'][$i]);
            $sheet2->setCellValue('B' . $r, $s);
            $sheet2->setCellValue('C' . $r, $p);
            $sheet2->setCellValue('D' . $r, $b);
            $sheet2->setCellValue('E' . $r, $mrg);
            $sheet2->setCellValue('F' . $r, $c);

            $sheet2->getStyle('B' . $r . ':D' . $r)->getNumberFormat()->setFormatCode('#,##0');
            $sheet2->getStyle('E' . $r)->getNumberFormat()->setFormatCode('0.0%');
            $sheet2->getStyle('F' . $r)->getNumberFormat()->setFormatCode('#,##0');
            $sheet2->getStyle('A' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet2->getStyle('F' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            if ($r % 2 == 0) {
                $sheet2->getStyle('A' . $r . ':F' . $r)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
            }
            $r++;
        }

        // Total
        $sheet2->setCellValue('A' . $r, 'TOTAL TAHUN ' . $selectedYear);
        $sheet2->setCellValue('B' . $r, $stats['annual_sales']);
        $sheet2->setCellValue('C' . $r, $stats['annual_profit']);
        $sheet2->setCellValue('D' . $r, $stats['annual_purchases']);
        $sheet2->setCellValue('E' . $r, $stats['annual_profit_margin'] / 100);
        $sheet2->setCellValue('F' . $r, $stats['annual_trx_count']);

        $sheet2->getStyle('A' . $r . ':F' . $r)->getFont()->setBold(true);
        $sheet2->getStyle('B' . $r . ':D' . $r)->getNumberFormat()->setFormatCode('#,##0');
        $sheet2->getStyle('E' . $r)->getNumberFormat()->setFormatCode('0.0%');
        $sheet2->getStyle('F' . $r)->getNumberFormat()->setFormatCode('#,##0');
        $sheet2->getStyle('A' . $r . ':F' . $r)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF1F5F9');
        $sheet2->getStyle('A3:F' . $r)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');
        $sheet2->getStyle('A' . $r . ':F' . $r)->getBorders()->getTop()->setBorderStyle(Border::BORDER_MEDIUM)->getColor()->setARGB('FF1E293B');

        foreach (range('A', 'F') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        // -----------------------------------------------------------
        // SHEET 3: VALUASI KATEGORI & STOK KRITIS
        // -----------------------------------------------------------
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Valuasi Kategori & Kritis');

        $sheet3->setCellValue('A1', 'DISTRIBUSI NILAI ASET PERSIS GUDANG PER KATEGORI');
        $sheet3->getStyle('A1')->getFont()->setBold(true)->setSize(11)->getColor()->setARGB('FF172B4D');

        $sheet3->setCellValue('A3', 'Kategori Persediaan');
        $sheet3->setCellValue('B3', 'Varian Item');
        $sheet3->setCellValue('C3', 'Total Nilai Modal HPP (Rp)');
        $sheet3->setCellValue('D3', 'Total Nilai Jual Eceran (Rp)');
        $sheet3->getStyle('A3:D3')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet3->getStyle('A3:D3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E293B');

        $r = 4;
        foreach ($data['categoryBreakdown'] as $cat) {
            $sheet3->setCellValue('A' . $r, $cat['name']);
            $sheet3->setCellValue('B' . $r, $cat['count']);
            $sheet3->setCellValue('C' . $r, $cat['asset_value']);
            $sheet3->setCellValue('D' . $r, $cat['retail_value']);

            $sheet3->getStyle('C' . $r . ':D' . $r)->getNumberFormat()->setFormatCode('#,##0');
            $sheet3->getStyle('B' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $r++;
        }
        $sheet3->getStyle('A3:D' . ($r - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');

        foreach (range('A', 'D') as $col) {
            $sheet3->getColumnDimension($col)->setAutoSize(true);
        }

        $spreadsheet->setActiveSheetIndex(0);

        $filename = 'ringkasan-eksekutif-dashboard-' . $selectedYear . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Export Executive Dashboard Summary as Official PDF
     */
    public function exportPdf(Request $request)
    {
        $selectedYear = (int) $request->input('year', date('Y'));
        $data = $this->getDashboardAnalyticsData($selectedYear);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $html = view('admin.dashboard.export_pdf', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'Ringkasan-Eksekutif-Dashboard-' . $selectedYear . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}
