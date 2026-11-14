@extends('layouts.admin')

@section('title', 'Laporan Pembelian & Restock')

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
                        <span class="text-[9px] font-bold uppercase tracking-wider block text-slate-500">Dokumen Inventaris &amp; Logistik</span>
                        <span class="text-xs font-black text-slate-900 uppercase">LAPORAN PEMBELIAN &amp; RESTOCK</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="flex justify-between items-end border-b border-slate-300 pb-2.5">
                <div>
                    <h2 class="text-base font-bold text-slate-900 uppercase tracking-wide">Rekapitulasi Pembelian Bahan Baku &amp; Restock Gudang</h2>
                    <p class="text-xs text-slate-700 mt-0.5">
                        Periode Faktur: <strong class="text-slate-900">{{ $startDate->translatedFormat('d F Y') }}</strong> s/d <strong class="text-slate-900">{{ $endDate->translatedFormat('d F Y') }}</strong>
                    </p>
                </div>
                <div class="text-right text-[10px] text-slate-600 space-y-0.5">
                    <p>Waktu Cetak: <strong class="text-slate-800">{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</strong></p>
                    <p>Operator Cetak: <strong class="text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</strong> ({{ auth()->user()->role_name ?? 'Admin' }})</p>
                    <p>Filter Status: <strong>{{ request('payment_status') ? ucfirst(request('payment_status')) : 'Semua Status' }}</strong> | Supplier: <strong>{{ request('supplier_id') ? ($suppliers->firstWhere('id', request('supplier_id'))->company_name ?? 'Supplier Terpilih') : 'Semua Vendor' }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Print-only KPI Summary Box -->
        <div class="grid grid-cols-4 gap-2 mb-4">
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Total Pengeluaran Belanja</span>
                <span class="text-sm font-bold text-slate-900 font-mono block mt-0.5">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">{{ $totalPurchasesCount }} Faktur PO</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Total Material Masuk</span>
                <span class="text-sm font-bold text-blue-800 font-mono block mt-0.5">{{ number_format($totalItemsQty, 0, ',', '.') }} Item/Batang</span>
                <span class="text-[8px] text-slate-500">Aluminium &amp; Kaca</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Belanja Lunas (Terbayar)</span>
                <span class="text-sm font-bold text-emerald-800 font-mono block mt-0.5">Rp {{ number_format($paidTotal, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">{{ $paidCount }} Faktur Lunas</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Hutang Belanja / Tempo</span>
                <span class="text-sm font-bold text-amber-800 font-mono block mt-0.5">Rp {{ number_format($unpaidTotal, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">{{ $unpaidCount + $partialCount }} Faktur Tempo/DP</span>
            </div>
        </div>
    </div>

    <!-- SCREEN-ONLY: Header & Action Buttons -->
    <div class="screen-only flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#172B4D]">Laporan Pembelian &amp; Restock</h1>
            <p class="text-xs text-slate-500 mt-1">
                Periode: <strong class="text-slate-700">{{ $startDate->translatedFormat('d M Y') }}</strong> s/d <strong class="text-slate-700">{{ $endDate->translatedFormat('d M Y') }}</strong>
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-xs transition">
                <i data-lucide="printer" class="w-4 h-4 text-slate-600"></i>
                <span>Cetak Dokumen</span>
            </button>
            <a href="{{ route('admin.reports.purchases.excel', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-emerald-300 hover:bg-emerald-50 text-emerald-800 font-semibold text-xs shadow-xs transition" title="Unduh File Excel Multi-Sheet (.xlsx)">
                <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                <span>Ekspor Excel (.xlsx)</span>
            </a>
            <a href="{{ route('admin.reports.purchases.csv', request()->query()) }}" class="inline-flex items-center gap-2 px-3 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-600 font-medium text-xs shadow-xs transition" title="Unduh Versi CSV">
                <i data-lucide="download" class="w-3.5 h-3.5 text-slate-500"></i>
                <span>CSV</span>
            </a>
            <a href="{{ route('admin.reports.purchases.pdf', request()->query()) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs shadow-xs transition">
                <i data-lucide="file-down" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Unduh PDF Resmi</span>
            </a>
            <a href="{{ route('admin.purchases.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs shadow-xs transition">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Input Belanja Baru</span>
            </a>
        </div>
    </div>

    <!-- SCREEN-ONLY: Filter Bar -->
    <div class="screen-only bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('admin.reports.purchases') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
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
                <label class="block text-xs font-semibold text-slate-700 mb-1">Supplier / Vendor</label>
                <select name="supplier_id" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#D6A84F] focus:border-[#D6A84F]">
                    <option value="">Semua Supplier</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>
                            {{ $sup->company_name ?: $sup->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Status Pembayaran</label>
                <select name="payment_status" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#D6A84F] focus:border-[#D6A84F]">
                    <option value="">Semua Status</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>DP / Sebagian</option>
                    <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                </select>
            </div>

            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>Terapkan</span>
                </button>
                <a href="{{ route('admin.reports.purchases') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition" title="Reset Bulan Ini">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- SCREEN-ONLY: Summary Stats Cards -->
    <div class="screen-only grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pengeluaran Belanja</p>
                <h3 class="text-2xl font-extrabold text-[#172B4D] mt-1 font-mono">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $totalPurchasesCount }} faktur pembelian</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-[#D6A84F] border border-amber-100 flex items-center justify-center shrink-0">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Material Masuk</p>
                <h3 class="text-2xl font-extrabold text-blue-700 mt-1 font-mono">{{ number_format($totalItemsQty, 0, ',', '.') }}</h3>
                <p class="text-xs text-blue-700 font-semibold mt-0.5">Total unit/batang masuk</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center shrink-0">
                <i data-lucide="package-check" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Belanja Lunas</p>
                <h3 class="text-2xl font-extrabold text-emerald-700 mt-1 font-mono">Rp {{ number_format($paidTotal, 0, ',', '.') }}</h3>
                <p class="text-xs text-emerald-700 font-semibold mt-0.5">{{ $paidCount }} faktur terbayar penuh</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center shrink-0">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Hutang Belanja / Tempo</p>
                <h3 class="text-2xl font-extrabold text-rose-700 mt-1 font-mono">Rp {{ number_format($unpaidTotal, 0, ',', '.') }}</h3>
                <p class="text-xs text-rose-700 font-semibold mt-0.5">{{ $unpaidCount + $partialCount }} faktur belum selesai</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-700 border border-rose-100 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- MAIN DATA TABLE (Responsive on Screen, Accounting-Grade on Print) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden print:border print:border-slate-400 print:rounded-none">
        <div class="screen-only p-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="table" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Rincian Faktur Pembelian &amp; Restock</span>
            </h3>
            <span class="text-xs font-semibold text-slate-600">{{ $purchases->count() }} Faktur Ditemukan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs print:text-[8pt]">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 text-slate-800 font-bold uppercase tracking-wider text-[11px] print:text-[7.5pt] print:bg-slate-200">
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2">No. Faktur PO</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2">Tanggal</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2">Supplier Vendor</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2">Rincian Barang &amp; Material Masuk</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Total Faktur</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">Status Bayar</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center screen-only">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($purchases as $purchase)
                    @php
                        $supName = $purchase->supplier ? ($purchase->supplier->company_name ?: $purchase->supplier->name) : 'Supplier Umum';
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors print:hover:bg-transparent">
                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 align-top">
                            <a href="{{ route('admin.purchases.show', $purchase->id) }}" class="font-bold text-[#172B4D] hover:text-[#D6A84F] font-mono">
                                {{ $purchase->invoice_number }}
                            </a>
                            @if($purchase->notes)
                                <div class="text-[10px] text-slate-500 italic mt-0.5 max-w-xs truncate print:max-w-none">
                                    {{ $purchase->notes }}
                                </div>
                            @endif
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 align-top text-slate-700 whitespace-nowrap">
                            {{ $purchase->purchase_date ? $purchase->purchase_date->format('d/m/Y') : '-' }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 align-top font-semibold text-slate-800">
                            <div>{{ $supName }}</div>
                            @if($purchase->supplier && $purchase->supplier->phone)
                                <span class="text-[10px] text-slate-500 font-normal block">{{ $purchase->supplier->phone }}</span>
                            @endif
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 align-top">
                            <div class="space-y-1">
                                @forelse($purchase->items as $it)
                                    @php
                                        $pName = $it->product ? $it->product->name : 'Item';
                                        $uSym = $it->product && $it->product->unit ? $it->product->unit->symbol : 'unit';
                                    @endphp
                                    <div class="text-[11px] text-slate-700 flex items-center justify-between gap-2 border-b border-slate-100 last:border-none pb-0.5 last:pb-0">
                                        <span class="font-medium truncate max-w-xs print:max-w-none">{{ $pName }}</span>
                                        <span class="font-mono text-slate-600 shrink-0">
                                            {{ (float)$it->quantity }} {{ $uSym }} &times; Rp {{ number_format($it->unit_cost, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @empty
                                    <span class="text-[10px] text-slate-400 italic">- Tidak ada rincian item -</span>
                                @endforelse
                            </div>
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 align-top text-right font-mono font-bold text-slate-900 whitespace-nowrap">
                            Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 align-top text-center whitespace-nowrap">
                            @if($purchase->payment_status === 'paid')
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    Lunas
                                </span>
                            @elseif($purchase->payment_status === 'partial')
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    DP / Sebagian
                                </span>
                            @else
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                    Belum Lunas
                                </span>
                            @endif
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 align-top text-center screen-only">
                            <a href="{{ route('admin.purchases.show', $purchase->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-[11px] transition" title="Lihat Faktur">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                <span>Detail</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <i data-lucide="inbox" class="w-10 h-10 text-slate-300 stroke-1 mb-2"></i>
                                <p class="text-sm font-semibold text-slate-600">Tidak ada faktur pembelian pada periode ini.</p>
                                <p class="text-xs text-slate-400 mt-1">Ubah rentang tanggal atau filter supplier di atas untuk melihat data lainnya.</p>
                                <a href="{{ route('admin.reports.purchases') }}" class="mt-3 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                                    Reset Filter
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($purchases->isNotEmpty())
                <tfoot class="bg-slate-50 border-t-2 border-slate-300 font-bold print:bg-slate-100">
                    <tr>
                        <td colspan="4" class="py-3 px-3.5 print:py-1.5 print:px-2 text-right uppercase tracking-wider text-slate-800 text-[11px] print:text-[8pt]">
                            Total Pengeluaran Periode Ini:
                        </td>
                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono text-sm print:text-[8.5pt] font-black text-slate-900 whitespace-nowrap">
                            Rp {{ number_format($totalAmount, 0, ',', '.') }}
                        </td>
                        <td colspan="2" class="py-3 px-3.5 print:py-1.5 print:px-2 text-center text-[10px] text-slate-600">
                            {{ $totalPurchasesCount }} Faktur Terpilih
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- PRINT-ONLY: LEMBAR PENGESAHAN DOKUMEN -->
    <div class="print-only mt-8">
        <table class="w-full text-center text-xs">
            <tr>
                <td style="width: 50%;">
                    <p class="text-slate-500 text-[10px] mb-1">Diverifikasi &amp; Disiapkan Oleh:</p>
                    <p class="font-bold text-slate-800">Petugas Logistik / Admin</p>
                    <div style="height: 60px;"></div>
                    <p class="font-bold text-slate-900 uppercase">({{ auth()->user()->name ?? 'Administrator' }})</p>
                    <p class="text-[9px] text-slate-500">Staff Gudang &amp; Inventaris</p>
                </td>
                <td style="width: 50%;">
                    <p class="text-slate-500 text-[10px] mb-1">Mengetahui &amp; Menyetujui:</p>
                    <p class="font-bold text-slate-800">Pimpinan AzkaMandiri</p>
                    <div style="height: 60px;"></div>
                    <p class="font-bold text-slate-900 uppercase">( Ir. H. Azka Pratama )</p>
                    <p class="text-[9px] text-slate-500">Direktur Operasional</p>
                </td>
            </tr>
        </table>
        <div class="border-t border-slate-300 mt-6 pt-2 flex justify-between text-[8px] text-slate-500">
            <span>Dicetak secara elektronik melalui Sistem Manajemen AzkaMandiri ERP</span>
            <span>Halaman 1 dari 1</span>
        </div>
    </div>

</div>
@endsection

