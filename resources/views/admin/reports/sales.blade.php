@extends('layouts.admin')

@section('title', 'Laporan Penjualan POS')

@section('content')
<div class="space-y-6">

    <!-- PRINT-ONLY: KOP SURAT RESMI & DOKUMEN HEADER -->
    <div class="print-only">
        <div class="border-b-2 border-slate-900 pb-3 mb-4">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-xl font-black tracking-tight text-slate-900 uppercase">AZKA<span class="text-amber-700">MANDIRI</span></h1>
                    <p class="text-xs font-bold text-slate-700 tracking-wider uppercase mt-0.5">Spesialis Kusen Aluminium, Kaca Tempered, &amp; Proyek Interior</p>
                    <p class="text-[10px] text-slate-600 mt-1">Workshop &amp; Kantor: Jl. Raya Mandiri Blok A No. 12, Jawa Timur | Telp/WA: 0812-3456-7890</p>
                    <p class="text-[10px] text-slate-600">Email: contact@azkamandiri.com | Website: azkamandiri.nichesite.org</p>
                </div>
                <div class="text-right">
                    <div class="inline-block border border-slate-800 px-3 py-1.5 rounded bg-slate-50">
                        <span class="text-[9px] font-bold uppercase tracking-wider block text-slate-500">Dokumen Keuangan</span>
                        <span class="text-xs font-black text-slate-900 uppercase">LAPORAN PENJUALAN</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="flex justify-between items-end border-b border-slate-300 pb-2.5">
                <div>
                    <h2 class="text-base font-bold text-slate-900 uppercase tracking-wide">Rekapitulasi Penjualan &amp; Kas Masuk (POS)</h2>
                    <p class="text-xs text-slate-700 mt-0.5">
                        Periode Transaksi: <strong class="text-slate-900">{{ $startDate->translatedFormat('d F Y') }}</strong> s/d <strong class="text-slate-900">{{ $endDate->translatedFormat('d F Y') }}</strong>
                    </p>
                </div>
                <div class="text-right text-[10px] text-slate-600 space-y-0.5">
                    <p>Waktu Cetak: <strong class="text-slate-800">{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</strong></p>
                    <p>Operator Cetak: <strong class="text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</strong> ({{ auth()->user()->role_name ?? 'Admin' }})</p>
                    <p>Filter Status: <strong>{{ request('payment_status') ? ucfirst(request('payment_status')) : 'Semua Status' }}</strong> | Metode: <strong>{{ request('payment_type') ? strtoupper(request('payment_type')) : 'Semua Metode' }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Print-only KPI Summary Box -->
        <div class="grid grid-cols-4 gap-2 mb-4">
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Total Omzet Penjualan</span>
                <span class="text-sm font-bold text-slate-900 font-mono block mt-0.5">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">{{ $totalCount }} Transaksi</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Penerimaan Kas (Terbayar)</span>
                <span class="text-sm font-bold text-emerald-800 font-mono block mt-0.5">Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">Kasir / Rekening Bank</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Sisa Piutang Berjalan</span>
                <span class="text-sm font-bold text-amber-800 font-mono block mt-0.5">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">Tagihan Belum Lunas</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Total Diskon / Potongan</span>
                <span class="text-sm font-bold text-slate-800 font-mono block mt-0.5">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">Kotor: Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- SCREEN-ONLY: Header & Action Buttons -->
    <div class="screen-only flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#172B4D]">Laporan Penjualan POS</h1>
            <p class="text-xs text-slate-500 mt-1">
                Periode: <strong class="text-slate-700">{{ $startDate->translatedFormat('d M Y') }}</strong> s/d <strong class="text-slate-700">{{ $endDate->translatedFormat('d M Y') }}</strong>
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-xs transition">
                <i data-lucide="printer" class="w-4 h-4 text-slate-600"></i>
                <span>Cetak Dokumen</span>
            </button>
            <a href="{{ route('admin.reports.sales.excel', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-emerald-300 hover:bg-emerald-50 text-emerald-800 font-semibold text-xs shadow-xs transition" title="Unduh File Excel Multi-Sheet (.xlsx)">
                <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                <span>Ekspor Excel (.xlsx)</span>
            </a>
            <a href="{{ route('admin.reports.sales.csv', request()->query()) }}" class="inline-flex items-center gap-2 px-3 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-600 font-medium text-xs shadow-xs transition" title="Unduh Versi CSV">
                <i data-lucide="download" class="w-3.5 h-3.5 text-slate-500"></i>
                <span>CSV</span>
            </a>
            <a href="{{ route('admin.reports.sales.pdf', request()->query()) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs shadow-xs transition">
                <i data-lucide="file-down" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Unduh PDF Resmi</span>
            </a>
            <a href="{{ route('admin.pos.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs shadow-xs transition">
                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                <span>Kasir POS</span>
            </a>
        </div>
    </div>

    <!-- SCREEN-ONLY: Filter Bar -->
    <div class="screen-only bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('admin.reports.sales') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#D6A84F] focus:border-[#D6A84F]">
            </div>

            <div class="md:col-span-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#D6A84F] focus:border-[#D6A84F]">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Status Bayar</label>
                <select name="payment_status" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#D6A84F] focus:border-[#D6A84F]">
                    <option value="">Semua Status</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>DP / Sebagian</option>
                    <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Metode Bayar</label>
                <select name="payment_type" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#D6A84F] focus:border-[#D6A84F]">
                    <option value="">Semua Metode</option>
                    <option value="cash" {{ request('payment_type') == 'cash' ? 'selected' : '' }}>Tunai</option>
                    <option value="transfer" {{ request('payment_type') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="qris" {{ request('payment_type') == 'qris' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>

            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>Terapkan</span>
                </button>
                <a href="{{ route('admin.reports.sales') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition" title="Bulan Ini">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- SCREEN-ONLY: Summary Stats Cards -->
    <div class="screen-only grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Omzet Penjualan</p>
                <h3 class="text-2xl font-extrabold text-[#172B4D] mt-1 font-mono">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $totalCount }} transaksi tercatat</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center shrink-0">
                <i data-lucide="coins" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Kas Masuk (Terbayar)</p>
                <h3 class="text-2xl font-extrabold text-emerald-700 mt-1 font-mono">Rp {{ number_format($totalPaid, 0, ',', '.') }}</h3>
                <p class="text-xs text-emerald-700 font-semibold mt-0.5">Sudah masuk rekening/kas</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Piutang Berjalan</p>
                <h3 class="text-2xl font-extrabold text-amber-700 mt-1 font-mono">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</h3>
                <p class="text-xs text-amber-700 font-semibold mt-0.5">Sisa tagihan pelanggan</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 border border-amber-100 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Potongan Diskon</p>
                <h3 class="text-2xl font-extrabold text-purple-700 mt-1 font-mono">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Kotor: Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 border border-purple-100 flex items-center justify-center shrink-0">
                <i data-lucide="tag" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- SCREEN-ONLY: Payment Methods Breakdown -->
    <div class="screen-only bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2">
            <i data-lucide="credit-card" class="w-4 h-4 text-[#D6A84F]"></i>
            <span>Distribusi Penerimaan Berdasarkan Metode Bayar</span>
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-bold text-slate-700 uppercase">Tunai (Cash)</span>
                    <span class="text-xs font-bold text-slate-900">
                        {{ $totalPaid > 0 ? number_format(($cashTotal / $totalPaid) * 100, 1) : 0 }}%
                    </span>
                </div>
                <div class="text-base font-extrabold text-slate-900 font-mono">Rp {{ number_format($cashTotal, 0, ',', '.') }}</div>
                <div class="w-full bg-slate-200 h-1.5 rounded-full mt-2 overflow-hidden">
                    <div class="bg-emerald-600 h-full rounded-full" style="width: {{ $totalPaid > 0 ? ($cashTotal / $totalPaid) * 100 : 0 }}%"></div>
                </div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-bold text-slate-700 uppercase">Transfer Bank</span>
                    <span class="text-xs font-bold text-slate-900">
                        {{ $totalPaid > 0 ? number_format(($transferTotal / $totalPaid) * 100, 1) : 0 }}%
                    </span>
                </div>
                <div class="text-base font-extrabold text-slate-900 font-mono">Rp {{ number_format($transferTotal, 0, ',', '.') }}</div>
                <div class="w-full bg-slate-200 h-1.5 rounded-full mt-2 overflow-hidden">
                    <div class="bg-blue-600 h-full rounded-full" style="width: {{ $totalPaid > 0 ? ($transferTotal / $totalPaid) * 100 : 0 }}%"></div>
                </div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-bold text-slate-700 uppercase">QRIS / E-Wallet</span>
                    <span class="text-xs font-bold text-slate-900">
                        {{ $totalPaid > 0 ? number_format(($qrisTotal / $totalPaid) * 100, 1) : 0 }}%
                    </span>
                </div>
                <div class="text-base font-extrabold text-slate-900 font-mono">Rp {{ number_format($qrisTotal, 0, ',', '.') }}</div>
                <div class="w-full bg-slate-200 h-1.5 rounded-full mt-2 overflow-hidden">
                    <div class="bg-purple-600 h-full rounded-full" style="width: {{ $totalPaid > 0 ? ($qrisTotal / $totalPaid) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN DATA TABLE (Responsive on Screen, Accounting-Grade on Print) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden print:border print:border-slate-400 print:rounded-none">
        <div class="screen-only p-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="table" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Rincian Transaksi Periode Terpilih</span>
            </h3>
            <span class="text-xs font-semibold text-slate-600">{{ $transactions->count() }} Data Ditemukan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs print:text-[8pt]">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 text-slate-800 font-bold uppercase tracking-wider text-[11px] print:text-[7.5pt] print:bg-slate-200">
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2">No. Invoice &amp; Tanggal</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2">Pelanggan</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">Tipe</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">Metode</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Subtotal</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Diskon</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Total Net</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Terbayar</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Sisa Piutang</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($transactions as $trx)
                    @php
                        $debt = max(0, (float)$trx->total_amount - (float)$trx->paid_amount);
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors print:hover:bg-transparent">
                        <td class="py-3 px-3.5 print:py-1.5 print:px-2">
                            <a href="{{ route('admin.pos.show', $trx->id) }}" class="font-bold text-[#172B4D] hover:text-[#D6A84F] font-mono">
                                {{ $trx->invoice_code }}
                            </a>
                            <div class="text-[10px] text-slate-500 font-medium mt-0.5">
                                {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d/m/Y H:i') }}
                            </div>
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 font-semibold text-slate-800">
                            {{ $trx->customer->name ?? 'Pelanggan Umum' }}
                            @if($trx->customer && $trx->customer->phone)
                                <span class="block text-[10px] text-slate-500 font-normal">{{ $trx->customer->phone }}</span>
                            @endif
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">
                            <span class="inline-block text-[10px] font-semibold px-2 py-0.5 rounded {{ $trx->order_type === 'custom' ? 'bg-purple-100 text-purple-800 border border-purple-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                                {{ $trx->order_type === 'custom' ? 'Custom' : 'Ritel' }}
                            </span>
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-center uppercase font-mono text-[10px] text-slate-600 font-semibold">
                            {{ $trx->payment_type }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono text-slate-700">
                            {{ number_format($trx->subtotal, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono text-slate-600">
                            {{ $trx->discount_amount > 0 ? '-' . number_format($trx->discount_amount, 0, ',', '.') : '-' }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono font-bold text-slate-900">
                            {{ number_format($trx->total_amount, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono font-bold text-emerald-700">
                            {{ number_format($trx->paid_amount, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono font-bold {{ $debt > 0 ? 'text-amber-700' : 'text-slate-400' }}">
                            {{ number_format($debt, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">
                            @if($trx->payment_status === 'paid')
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    Lunas
                                </span>
                            @elseif($trx->payment_status === 'partial')
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    DP / Sisa
                                </span>
                            @else
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                    Belum Bayar
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="py-8 text-center text-slate-400">
                            Tidak ada transaksi penjualan pada rentang tanggal yang dipilih.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($transactions->isNotEmpty())
                <tfoot>
                    <tr class="bg-slate-100 font-bold text-slate-900 border-t-2 border-slate-900 text-xs print:text-[8pt]">
                        <td colspan="4" class="py-3 px-3.5 print:py-2 print:px-2 text-right uppercase tracking-wider">TOTAL PERIODE:</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-right font-mono">Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-right font-mono text-slate-600">- Rp {{ number_format($totalDiscount, 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-right font-mono text-[#172B4D]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-right font-mono text-emerald-800">Rp {{ number_format($totalPaid, 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-right font-mono text-amber-800">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-center">{{ $totalCount }} Nota</td>
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
                <p class="text-[10px] text-slate-600">Dibuat &amp; Diverifikasi,</p>
                <p class="font-bold text-slate-900 mt-0.5">Kasir / Bagian Administrasi</p>
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
