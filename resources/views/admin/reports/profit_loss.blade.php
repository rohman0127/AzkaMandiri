@extends('layouts.admin')

@section('title', 'Laporan Laba Rugi (Profit & Loss)')

@section('content')
<div class="space-y-6">

    <!-- PRINT-ONLY: KOP SURAT RESMI & DOKUMEN HEADER -->
    <div class="print-only">
        <div class="border-b-2 border-slate-900 pb-3 mb-4">
            <div class="flex justify-between items-start">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/brand/azka-logo-icon.png') }}" alt="Azka Mandiri Logo" class="h-12 w-auto object-contain">
                    <div>
                        <h1 class="text-xl font-serif font-black tracking-wider text-[#1b2e56] uppercase">AZKA MANDIRI</h1>
                        <p class="text-xs font-bold text-[#a81b3e] tracking-wider uppercase mt-0.5">Spesialis Kusen Aluminium, Kaca Tempered, &amp; Proyek Interior</p>
                        <p class="text-[10px] text-slate-600 mt-1">Workshop &amp; Kantor: Jl. Pondok Serut, Paku Jaya, Serpong Utara | Telp/WA: 0819-3273-5383</p>
                        <p class="text-[10px] text-slate-600">Email: kontak@azkamandiri.com | Website: azkamandiri.nichesite.org</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="inline-block border border-slate-800 px-3 py-1.5 rounded bg-slate-50">
                        <span class="text-[9px] font-bold uppercase tracking-wider block text-slate-500">Dokumen Keuangan</span>
                        <span class="text-xs font-black text-slate-900 uppercase">ANALISIS LABA RUGI</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="flex justify-between items-end border-b border-slate-300 pb-2.5">
                <div>
                    <h2 class="text-base font-bold text-slate-900 uppercase tracking-wide">Laporan Analisis Laba Kotor (Gross Profit &amp; Loss)</h2>
                    <p class="text-xs text-slate-700 mt-0.5">
                        Periode Analisis: <strong class="text-slate-900">{{ $startDate->translatedFormat('d F Y') }}</strong> s/d <strong class="text-slate-900">{{ $endDate->translatedFormat('d F Y') }}</strong>
                    </p>
                </div>
                <div class="text-right text-[10px] text-slate-600 space-y-0.5">
                    <p>Waktu Cetak: <strong class="text-slate-800">{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</strong></p>
                    <p>Operator Cetak: <strong class="text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</strong> ({{ auth()->user()->role_name ?? 'Admin' }})</p>
                    <p>Basis: <strong>Harga Jual Kasir vs Harga Pokok Penjualan (HPP Modal)</strong></p>
                </div>
            </div>
        </div>

        <!-- Print-only KPI Summary Box -->
        <div class="grid grid-cols-4 gap-2 mb-4">
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Total Omzet Penjualan</span>
                <span class="text-sm font-bold text-slate-900 font-mono block mt-0.5">Rp {{ number_format($totalSales, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">Penjualan Kotor</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Harga Pokok (HPP / Modal)</span>
                <span class="text-sm font-bold text-slate-800 font-mono block mt-0.5">Rp {{ number_format($totalCost, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">Biaya Bahan Baku</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Laba Kotor (Gross Profit)</span>
                <span class="text-sm font-bold text-emerald-800 font-mono block mt-0.5">Rp {{ number_format($grossProfit, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">Penjualan - HPP</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Margin Keuntungan Kotor</span>
                <span class="text-sm font-bold text-amber-800 font-mono block mt-0.5">{{ number_format($profitMargin, 1, ',', '.') }}%</span>
                <span class="text-[8px] text-slate-500">Rata-rata Margin</span>
            </div>
        </div>
    </div>

    <!-- SCREEN-ONLY: Header & Action Buttons -->
    <div class="screen-only flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#172B4D]">Laporan Laba Rugi (Gross Profit)</h1>
            <p class="text-xs text-slate-500 mt-1">
                Kalkulasi keuntungan kotor berdasarkan selisih harga jual dan harga pokok modal (HPP) per produk.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-xs transition">
                <i data-lucide="printer" class="w-4 h-4 text-slate-600"></i>
                <span>Cetak Dokumen</span>
            </button>
            <a href="{{ route('admin.reports.profit-loss.csv', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-xs transition">
                <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i>
                <span>Ekspor Excel/CSV</span>
            </a>
            <a href="{{ route('admin.reports.profit-loss.pdf', request()->query()) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs shadow-xs transition">
                <i data-lucide="file-down" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Unduh PDF Resmi</span>
            </a>
            <a href="{{ route('admin.reports.sales') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                <i data-lucide="trending-up" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Laporan Penjualan</span>
            </a>
        </div>
    </div>

    <!-- SCREEN-ONLY: Filter Bar -->
    <div class="screen-only bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('admin.reports.profit-loss') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-5">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#D6A84F] focus:border-[#D6A84F]">
            </div>

            <div class="md:col-span-5">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#D6A84F] focus:border-[#D6A84F]">
            </div>

            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>Terapkan</span>
                </button>
                <a href="{{ route('admin.reports.profit-loss') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition" title="Reset">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- SCREEN-ONLY: Key Metrics Cards -->
    <div class="screen-only grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Nilai Penjualan</p>
                <h3 class="text-2xl font-extrabold text-[#172B4D] mt-1 font-mono">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Nilai kotor item terjual</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center shrink-0">
                <i data-lucide="shopping-bag" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Harga Pokok (HPP / Modal)</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-1 font-mono">Rp {{ number_format($totalCost, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Biaya modal bahan baku</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 border border-slate-200 flex items-center justify-center shrink-0">
                <i data-lucide="package-minus" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Laba Kotor (Gross Profit)</p>
                <h3 class="text-2xl font-extrabold {{ $grossProfit >= 0 ? 'text-emerald-700' : 'text-rose-700' }} mt-1 font-mono">
                    Rp {{ number_format($grossProfit, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Penjualan dikurangi HPP</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center shrink-0">
                <i data-lucide="badge-dollar-sign" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Margin Keuntungan</p>
                <h3 class="text-2xl font-extrabold text-amber-700 mt-1 font-mono">{{ number_format($profitMargin, 1, ',', '.') }}%</h3>
                <p class="text-xs text-slate-500 mt-0.5">Persentase margin rata-rata</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 border border-amber-100 flex items-center justify-center shrink-0">
                <i data-lucide="pie-chart" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- MAIN DATA TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden print:border print:border-slate-400 print:rounded-none">
        <div class="screen-only p-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
            <div>
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="award" class="w-4 h-4 text-[#D6A84F]"></i>
                    <span>Analisis Profitabilitas Per Produk &amp; Material</span>
                </h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Diurutkan berdasarkan kontribusi laba kotor tertinggi</p>
            </div>
            <span class="text-xs font-semibold text-slate-600">{{ count($productStats) }} Produk Terjual</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs print:text-[8pt]">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 text-slate-800 font-bold uppercase tracking-wider text-[11px] print:text-[7.5pt] print:bg-slate-200">
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center w-[50px]">No</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2">Nama Produk / Material &amp; SKU</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">Volume Terjual</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Pendapatan Jual</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">HPP Modal</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Laba Kotor</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">Margin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($productStats as $index => $stat)
                    @php
                        $margin = $stat['revenue'] > 0 ? (($stat['profit'] / $stat['revenue']) * 100) : 0;
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors print:hover:bg-transparent">
                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-center text-slate-500 font-bold">
                            {{ $index + 1 }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2">
                            <div class="font-bold text-[#172B4D]">{{ $stat['name'] }}</div>
                            <div class="text-[10px] text-slate-500 font-mono mt-0.5">SKU: {{ $stat['sku'] }}</div>
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-center font-bold text-slate-800 font-mono">
                            {{ number_format($stat['qty'], 0) }} {{ $stat['unit'] ?? '' }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono text-slate-800 font-semibold">
                            Rp {{ number_format($stat['revenue'], 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono text-slate-700">
                            Rp {{ number_format($stat['cost'], 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-bold font-mono {{ $stat['profit'] >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                            Rp {{ number_format($stat['profit'], 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $margin >= 25 ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : ($margin >= 10 ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-amber-100 text-amber-800 border border-amber-200') }}">
                                {{ number_format($margin, 1, ',', '.') }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">
                            Belum ada data transaksi penjualan pada rentang tanggal ini untuk kalkulasi laba rugi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if(count($productStats) > 0)
                <tfoot>
                    <tr class="bg-slate-100 font-bold text-slate-900 border-t-2 border-slate-900 text-xs print:text-[8pt]">
                        <td colspan="3" class="py-3 px-3.5 print:py-2 print:px-2 text-right uppercase tracking-wider">TOTAL PERIODE:</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-right font-mono">Rp {{ number_format($totalSales, 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-right font-mono text-slate-700">Rp {{ number_format($totalCost, 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-right font-mono text-emerald-800">Rp {{ number_format($grossProfit, 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-center font-mono text-amber-800">{{ number_format($profitMargin, 1, ',', '.') }}%</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- PRINT-ONLY: LEMBAR PENGESAHAN DOKUMEN -->
    <div class="print-only break-inside-avoid mt-8 pt-4 border-t border-slate-300">
        <div class="flex justify-between text-xs text-slate-900">
            <div class="text-center w-56">
                <p class="text-[10px] text-slate-600">Dibuat &amp; Dianalisis,</p>
                <p class="font-bold text-slate-900 mt-0.5">Bagian Keuangan &amp; Akuntansi</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-900 underline">{{ auth()->user()->name ?? 'Administrator' }}</p>
                <p class="text-[9px] text-slate-500 mt-0.5">{{ auth()->user()->role_name ?? 'Staf Admin' }}</p>
            </div>
            <div class="text-center w-56">
                <p class="text-[10px] text-slate-600">Mengetahui &amp; Menyetujui,</p>
                <p class="font-bold text-slate-900 mt-0.5">Pimpinan / Direksi AzkaMandiri</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-900 underline">( .................................................... )</p>
                <p class="text-[9px] text-slate-500 mt-0.5">Direksi Perusahaan</p>
            </div>
        </div>
        <div class="text-center mt-6 text-[8px] text-slate-400">
            Dokumen cetak ini digenerate secara otomatis oleh Sistem Enterprise AzkaMandiri POS &amp; Inventory.
        </div>
    </div>

</div>
@endsection
