@extends('layouts.admin')

@section('title', 'Dashboard Overview & Analitik Terpadu')
@section('breadcrumb', 'Pusat Analisis Eksekutif & Ringkasan Kinerja AzkaMandiri')

@section('content')
<div class="space-y-8">
    <!-- Top Action & Export Header Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl bg-[#101D33] text-[#D6A84F] flex items-center justify-center shadow-xs">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                </div>
                <div>
                    <h1 class="text-lg font-extrabold text-[#172B4D]">Executive Business Dashboard &amp; Analytics</h1>
                    <p class="text-xs text-slate-400">Ringkasan real-time penjualan, laba rugi, valuasi persediaan, dan kesehatan operasional</p>
                </div>
            </div>
        </div>

        <!-- Action Tools: Year Filter & Export Buttons -->
        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Dynamic Year Selector -->
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5 bg-slate-50 border border-slate-200/80 px-2.5 py-1.5 rounded-xl">
                <i data-lucide="calendar" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                <span class="text-xs font-semibold text-slate-500">Tahun:</span>
                <select name="year" onchange="this.form.submit()" 
                        class="bg-transparent text-xs font-extrabold text-[#172B4D] focus:outline-none cursor-pointer pr-1">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </form>

            <!-- Export to Excel (.xlsx) -->
            <a href="{{ route('admin.dashboard.export.excel', ['year' => $selectedYear]) }}" 
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-xs shadow-emerald-600/20 active:scale-95"
               title="Ekspor Ringkasan Eksekutif ke format Microsoft Excel Multi-Sheet">
                <i data-lucide="sheet" class="w-4 h-4"></i>
                <span>Ekspor Excel (.xlsx)</span>
            </a>

            <!-- Export to PDF -->
            <a href="{{ route('admin.dashboard.export.pdf', ['year' => $selectedYear]) }}" 
               target="_blank"
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-[#172B4D] hover:bg-[#101D33] text-white text-xs font-bold transition shadow-xs shadow-slate-900/20 active:scale-95"
               title="Cetak & Download Dokumen Laporan Eksekutif PDF Resmi">
                <i data-lucide="printer" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Cetak / PDF Resmi</span>
            </a>
        </div>
    </div>

    <!-- ROW 1: Real-time Cash & Daily Operations Stats -->
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                <i data-lucide="wallet" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>1. Arus Kas POS &amp; Piutang Berjalan (Real-Time)</span>
            </h2>
            <span class="text-[11px] text-slate-400">Sinkronisasi otomatis basis data kasir</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Penjualan Hari Ini -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between hover:border-emerald-300 transition">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kas Masuk Hari Ini</p>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1 font-mono">Rp {{ number_format($stats['today_sales'], 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $stats['today_trx_count'] }} transaksi selesai hari ini</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="banknote" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Omzet Bulan Ini -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between hover:border-blue-300 transition">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Omzet Bulan Berjalan</p>
                    <h3 class="text-2xl font-black text-[#172B4D] mt-1 font-mono">Rp {{ number_format($stats['month_sales'], 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $stats['month_trx_count'] }} nota lunas &amp; DP bulan ini</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <i data-lucide="coins" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Sisa Piutang / Pelanggan Belum Lunas -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between hover:border-amber-300 transition">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sisa Piutang Aktif</p>
                    <h3 class="text-2xl font-black text-amber-600 mt-1 font-mono">Rp {{ number_format($stats['total_receivables'], 0, ',', '.') }}</h3>
                    <p class="text-xs text-amber-700 font-medium mt-0.5">Sisa tagihan transaksi custom/kredit</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="clock-alert" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Belanja Restock Bulan Ini -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between hover:border-purple-300 transition">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengadaan Bulan Ini</p>
                    <h3 class="text-2xl font-black text-purple-600 mt-1 font-mono">Rp {{ number_format($stats['month_purchases'], 0, ',', '.') }}</h3>
                    <p class="text-xs text-purple-700 font-medium mt-0.5">Hutang supplier: Rp {{ number_format($stats['unpaid_purchases'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <i data-lucide="truck" class="w-6 h-6"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 2: Stock Valuation & Financial Performance Widget -->
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                <i data-lucide="boxes" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>2. Valuasi Aset Inventaris &amp; Kinerja Tahunan {{ $selectedYear }}</span>
            </h2>
            <span class="text-[11px] text-slate-400">Kalkulasi nilai buku modal (HPP) vs proyeksi pasar</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Valuasi Nilai Modal HPP -->
            <div class="bg-gradient-to-br from-[#101D33] to-[#172B4D] text-white p-5 rounded-2xl border border-white/10 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Aset Gudang (HPP Modal)</p>
                    <h3 class="text-2xl font-black text-[#D6A84F] mt-1 font-mono">Rp {{ number_format($stats['stock_cost_value'], 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-slate-300 mt-0.5">Nilai perolehan stok fisik aktif</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-white/10 text-[#D6A84F] flex items-center justify-center shrink-0">
                    <i data-lucide="package-check" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Nilai Jual Retail & Potensi Margin -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Valuasi Jual Retail</p>
                    <h3 class="text-2xl font-black text-blue-600 mt-1 font-mono">Rp {{ number_format($stats['stock_retail_value'], 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Potensi margin: <strong class="text-emerald-600 font-semibold">{{ number_format($stats['potential_stock_margin'], 1) }}%</strong></p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <i data-lucide="pie-chart" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Kinerja Omzet & Laba Bersih Tahunan -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Laba Kotor Tahun {{ $selectedYear }}</p>
                    <h3 class="text-2xl font-black text-[#D6A84F] mt-1 font-mono">Rp {{ number_format($stats['annual_profit'], 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Margin laba: <strong class="text-[#D6A84F] font-semibold">{{ number_format($stats['annual_profit_margin'], 1) }}%</strong> ({{ $stats['annual_trx_count'] }} order)</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-[#D6A84F] flex items-center justify-center shrink-0">
                    <i data-lucide="trending-up" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Kesehatan Stok & Peringatan Restock -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Stok Gudang</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xl font-black text-emerald-600 font-mono">{{ $stats['safe_stock_count'] }} Aman</span>
                        <span class="text-xs text-slate-300">|</span>
                        <span class="text-xl font-black {{ $stats['low_stock_count'] > 0 ? 'text-amber-600' : 'text-slate-400' }} font-mono">{{ $stats['low_stock_count'] }} Menipis</span>
                    </div>
                    <p class="text-xs mt-0.5 font-medium {{ $stats['out_of_stock_count'] > 0 ? 'text-rose-600' : 'text-slate-500' }}">
                        {{ $stats['out_of_stock_count'] }} varian habis &bull; {{ number_format($stats['total_stock_units'], 0, ',', '.') }} unit total
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl {{ $stats['low_stock_count'] > 0 || $stats['out_of_stock_count'] > 0 ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center shrink-0">
                    <i data-lucide="layers" class="w-6 h-6"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- HIGHCHARTS SECTION: Dual Visualizations & Interactive Filtering -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-6">
        <!-- Section Header with Dynamic Controls -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#D6A84F]/10 text-[#D6A84F] flex items-center justify-center">
                        <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                    </div>
                    <h2 class="text-base font-bold text-[#172B4D]">Grafik Tren Bisnis &amp; Finansial Highcharts</h2>
                </div>
                <p class="text-xs text-slate-400 mt-1">
                    Visualisasi omzet, estimasi laba kotor, dan belanja pengadaan material tahun <strong class="text-slate-700">{{ $selectedYear }}</strong>
                </p>
            </div>

            <!-- Quick Highcharts Export & Year Controls -->
            <div class="flex items-center gap-2">
                <button type="button" onclick="window.exportChartMain()" 
                        class="px-3 py-1.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-semibold flex items-center gap-1.5 transition">
                    <i data-lucide="download" class="w-3.5 h-3.5 text-slate-500"></i>
                    <span>Download Grafik</span>
                </button>
            </div>
        </div>

        <!-- Annual Summary KPI Badges for Selected Year -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 bg-slate-50/70 p-4 rounded-xl border border-slate-100">
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Total Omzet {{ $selectedYear }}</span>
                <span class="text-lg font-extrabold text-[#172B4D] font-mono block mt-0.5">Rp {{ number_format($stats['annual_sales'], 0, ',', '.') }}</span>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Estimasi Laba Kotor</span>
                <span class="text-lg font-extrabold text-[#D6A84F] font-mono block mt-0.5">Rp {{ number_format($stats['annual_profit'], 0, ',', '.') }}</span>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Belanja Pengadaan Material</span>
                <span class="text-lg font-extrabold text-purple-600 font-mono block mt-0.5">Rp {{ number_format($stats['annual_purchases'], 0, ',', '.') }}</span>
            </div>
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Total Transaksi Selesai</span>
                <span class="text-lg font-extrabold text-slate-700 font-mono block mt-0.5">{{ number_format($stats['annual_trx_count'], 0, ',', '.') }} Transaksi</span>
            </div>
        </div>

        <!-- Highcharts Visualizations (Grid 3:1) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
            <!-- Main Spline & Column Highchart (2 cols) -->
            <div class="lg:col-span-2">
                <div id="highcharts-sales-container"
                     class="w-full h-[360px]"
                     data-year="{{ $selectedYear }}"
                     data-categories="{{ json_encode($chartCategories) }}"
                     data-sales="{{ json_encode($chartSales) }}"
                     data-profit="{{ json_encode($chartProfit) }}"
                     data-purchases="{{ json_encode($chartPurchases) }}"
                     data-trx-count="{{ json_encode($chartTrxCount) }}"></div>
            </div>

            <!-- Donut Highchart for Order Type Composition (1 col) -->
            <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100 flex flex-col items-center">
                <h4 class="text-xs font-bold text-[#172B4D] uppercase tracking-wider mb-1 self-start flex items-center gap-1.5">
                    <i data-lucide="pie-chart" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>Komposisi Omzet Penjualan</span>
                </h4>
                <p class="text-[11px] text-slate-400 self-start mb-2">Perbandingan omzet ritel vs pesanan custom</p>
                <div id="highcharts-pie-container"
                     class="w-full h-[300px]"
                     data-retail="{{ (float)$retailSales ?: 0.01 }}"
                     data-custom="{{ (float)$customSales ?: 0.01 }}"></div>
            </div>
        </div>

        <!-- Highcharts Chart 3: Category Asset Valuation Column Chart -->
        <div class="pt-6 border-t border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-[#172B4D] uppercase tracking-wider flex items-center gap-1.5">
                    <i data-lucide="layers" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>Distribusi Valuasi Nilai Persediaan per Kategori Produk</span>
                </h3>
                <span class="text-[11px] text-slate-400">Total HPP Modal per kategori aktif</span>
            </div>
            @php
                $catNames = $categoryBreakdown->pluck('name')->toArray();
                $catCostValues = $categoryBreakdown->pluck('asset_value')->map(fn($v) => (float)$v)->toArray();
                $catRetailValues = $categoryBreakdown->pluck('retail_value')->map(fn($v) => (float)$v)->toArray();
            @endphp
            <div id="highcharts-category-container"
                 class="w-full h-[260px]"
                 data-categories="{{ json_encode($catNames) }}"
                 data-cost-values="{{ json_encode($catCostValues) }}"
                 data-retail-values="{{ json_encode($catRetailValues) }}"></div>
        </div>
    </div>

    <!-- ROW 3: Stock Alert & Restock Recommendations Grid -->
    @if($criticalProducts->count() > 0)
    <div class="bg-white rounded-2xl border border-rose-200 shadow-xs p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-rose-900">Peringatan Persediaan Kritis &amp; Rekomendasi Restock</h3>
                    <p class="text-xs text-rose-600">Produk berikut telah berada pada atau di bawah batas minimum stok aman</p>
                </div>
            </div>
            <a href="{{ route('admin.purchases.create') }}" class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-xs shadow-rose-600/20">
                <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                <span>Buat Pembelian / Restock</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($criticalProducts as $prod)
            <div class="p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <span class="font-mono text-[10px] text-slate-400 block">{{ $prod->code }}</span>
                    <h4 class="text-xs font-bold text-[#172B4D] mt-0.5 line-clamp-1">{{ $prod->name }}</h4>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Sisa: <strong class="{{ $prod->stock <= 0 ? 'text-rose-600' : 'text-amber-600' }}">{{ $prod->stock }} {{ $prod->unit->symbol ?? 'pcs' }}</strong> 
                        &bull; Min: {{ $prod->min_stock }} {{ $prod->unit->symbol ?? 'pcs' }}
                    </p>
                </div>
                <div>
                    @if($prod->stock <= 0)
                        <span class="px-2 py-1 rounded text-[10px] font-extrabold bg-rose-100 text-rose-700 uppercase">Habis</span>
                    @else
                        <span class="px-2 py-1 rounded text-[10px] font-extrabold bg-amber-100 text-amber-800 uppercase">Kritis</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- ROW 4: Recent POS Transactions Table -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="receipt" class="w-4 h-4 text-[#D6A84F]"></i>
                    <span>Transaksi Kasir POS Terbaru</span>
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">5 transaksi penjualan dan pesanan custom terkini</p>
            </div>
            <a href="{{ route('admin.pos.transactions') }}" class="text-xs font-semibold text-[#D6A84F] hover:underline flex items-center gap-1">
                <span>Lihat Semua Transaksi</span>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs font-semibold">
                        <th class="py-3 px-4">Invoice &amp; Jam</th>
                        <th class="py-3 px-4">Pelanggan</th>
                        <th class="py-3 px-4">Tipe Order</th>
                        <th class="py-3 px-4 text-right">Total Tagihan</th>
                        <th class="py-3 px-4 text-right">Terbayar</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentTransactions as $trx)
                    <tr class="hover:bg-slate-50/50">
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.pos.show', $trx->id) }}" class="font-mono text-xs font-bold text-primary hover:underline">
                                {{ $trx->invoice_code }}
                            </a>
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d/m/Y H:i') }}
                            </div>
                        </td>

                        <td class="py-3 px-4 font-medium text-slate-800">
                            {{ $trx->customer->name ?? 'Pelanggan Umum' }}
                        </td>

                        <td class="py-3 px-4">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $trx->order_type === 'project_custom' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $trx->order_type === 'project_custom' ? 'Custom' : 'Ritel' }}
                            </span>
                        </td>

                        <td class="py-3 px-4 text-right font-bold text-slate-800 font-mono">
                            Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-4 text-right font-semibold text-emerald-600 font-mono">
                            Rp {{ number_format($trx->paid_amount, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            @if($trx->payment_status === 'paid')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    Lunas
                                </span>
                            @elseif($trx->payment_status === 'partial')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                    DP / Sisa
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                    Belum Lunas
                                </span>
                            @endif
                        </td>

                        <td class="py-3 px-4 text-center">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.pos.show', $trx->id) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-primary hover:bg-slate-100 transition" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.pos.thermal-receipt', $trx->id) }}" target="_blank" class="p-1.5 rounded-lg text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 transition" title="Struk">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-slate-400 text-xs">
                            Belum ada transaksi POS.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ROW 5: Website & Content Stats Grid -->
    <div>
        <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Statistik Konten Website Publik &amp; Profil</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <!-- Services -->
            <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <i data-lucide="wrench" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase">Layanan</p>
                    <h3 class="text-xl font-bold text-[#172B4D] mt-0.5">{{ $stats['total_services'] }}</h3>
                </div>
            </div>

            <!-- Portfolios -->
            <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#D6A84F] flex items-center justify-center shrink-0">
                    <i data-lucide="images" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase">Portofolio</p>
                    <h3 class="text-xl font-bold text-[#172B4D] mt-0.5">{{ $stats['total_portfolios'] }}</h3>
                </div>
            </div>

            <!-- Articles -->
            <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <i data-lucide="newspaper" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase">Artikel</p>
                    <h3 class="text-xl font-bold text-[#172B4D] mt-0.5">{{ $stats['total_articles'] }}</h3>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <i data-lucide="quote" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase">Testimoni</p>
                    <h3 class="text-xl font-bold text-[#172B4D] mt-0.5">{{ $stats['total_testimonials'] }}</h3>
                </div>
            </div>

            <!-- Total Messages -->
            <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase">Total Pesan</p>
                    <h3 class="text-xl font-bold text-[#172B4D] mt-0.5">{{ $stats['total_messages'] }}</h3>
                </div>
            </div>

            <!-- Unread Messages -->
            <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl {{ $stats['unread_messages'] > 0 ? 'bg-red-50 text-red-600' : 'bg-gray-50 text-gray-400' }} flex items-center justify-center shrink-0">
                    <i data-lucide="mail-warning" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase">Pesan Baru</p>
                    <h3 class="text-xl font-bold {{ $stats['unread_messages'] > 0 ? 'text-red-600' : 'text-gray-400' }} mt-0.5">{{ $stats['unread_messages'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 6: Content Columns (Messages & Portfolios) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Messages (2 Columns) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-[#172B4D]">Pesan Masuk Terbaru</h2>
                    <p class="text-xs text-gray-500">Form kontak dari pengunjung website</p>
                </div>
                <a href="{{ route('admin.contact-messages.index') }}" class="text-xs font-semibold text-[#D6A84F] hover:underline flex items-center gap-1">
                    <span>Lihat Semua Pesan</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($recentMessages as $msg)
                    <div class="p-5 hover:bg-gray-50/80 transition flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm text-[#172B4D]">{{ $msg->name }}</span>
                                <span class="text-xs text-gray-400">&bull; {{ $msg->created_at->diffForHumans() }}</span>
                                @if($msg->status === 'unread')
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-700">Baru</span>
                                @elseif($msg->status === 'followed_up')
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-700">Ditindaklanjuti</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-gray-100 text-gray-600">Dibaca</span>
                                @endif
                            </div>
                            <p class="text-xs font-semibold text-gray-700">{{ $msg->subject }}</p>
                            <p class="text-xs text-gray-500 line-clamp-1">{{ Str::limit($msg->message, 90) }}</p>
                            <div class="text-[11px] text-gray-400 flex items-center gap-4 pt-1">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="phone" class="w-3 h-3 text-[#D6A84F]"></i>
                                    {{ $msg->phone_number }}
                                </span>
                                @if($msg->email)
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="mail" class="w-3 h-3"></i>
                                        {{ $msg->email }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('admin.contact-messages.show', $msg->id) }}" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition shrink-0">
                            <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                @empty
                    <div class="p-10 text-center text-gray-400">
                        <i data-lucide="inbox" class="w-10 h-10 mx-auto text-gray-300 mb-2"></i>
                        <p class="text-sm">Belum ada pesan masuk dari formulir kontak.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Portfolios Preview (1 Column) -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-[#172B4D]">Portofolio Terbaru</h3>
                    <a href="{{ route('admin.portfolios.index') }}" class="text-xs text-[#D6A84F] font-semibold hover:underline">Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse($recentPortfolios as $port)
                        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 transition">
                            <img src="{{ $port->main_image ?: asset('assets/brand/logo-icon.svg') }}" alt="{{ $port->title }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200 shrink-0 bg-gray-100">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold text-[#172B4D] truncate">{{ $port->title }}</p>
                                <p class="text-[11px] text-gray-400 truncate">{{ $port->location ?: 'Lokasi Proyek' }}</p>
                            </div>
                            <a href="{{ route('admin.portfolios.edit', $port->id) }}" class="text-gray-400 hover:text-[#172B4D] p-1">
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada portofolio.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@vite(['resources/js/admin/dashboard-charts.js'])
@endpush
