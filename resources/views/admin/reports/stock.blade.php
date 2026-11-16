@extends('layouts.admin')

@section('title', 'Laporan Valuasi & Inventaris Stok')

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
                        <span class="text-[9px] font-bold uppercase tracking-wider block text-slate-500">Dokumen Inventaris</span>
                        <span class="text-xs font-black text-slate-900 uppercase">VALUASI &amp; POSISI STOK</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="flex justify-between items-end border-b border-slate-300 pb-2.5">
                <div>
                    <h2 class="text-base font-bold text-slate-900 uppercase tracking-wide">Laporan Posisi Persediaan &amp; Valuasi Aset Stok Gudang</h2>
                    <p class="text-xs text-slate-700 mt-0.5">
                        Klasifikasi: <strong>Profil Aluminium, Kaca Lembaran, Aksesoris, &amp; Material Proyek</strong>
                    </p>
                </div>
                <div class="text-right text-[10px] text-slate-600 space-y-0.5">
                    <p>Waktu Cetak: <strong class="text-slate-800">{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</strong></p>
                    <p>Operator Cetak: <strong class="text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</strong> ({{ auth()->user()->role_name ?? 'Admin' }})</p>
                    <p>Kategori: <strong>{{ request('category_id') ? ($categories->firstWhere('id', request('category_id'))->name ?? 'Kategori Terpilih') : 'Semua Kategori' }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Print-only KPI Summary Box -->
        <div class="grid grid-cols-4 gap-2 mb-4">
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Total Item Barang</span>
                <span class="text-sm font-bold text-slate-900 font-mono block mt-0.5">{{ number_format($totalItems, 0) }} Item</span>
                <span class="text-[8px] text-slate-500">Material Aktif</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Total Valuasi Modal (HPP)</span>
                <span class="text-sm font-bold text-emerald-800 font-mono block mt-0.5">Rp {{ number_format($totalCostValue, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">Nilai Aset Modal Fisik</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Potensi Nilai Jual</span>
                <span class="text-sm font-bold text-slate-900 font-mono block mt-0.5">Rp {{ number_format($totalRetailValue, 0, ',', '.') }}</span>
                <span class="text-[8px] text-slate-500">Estimasi Omzet Retail</span>
            </div>
            <div class="p-2.5 border border-slate-400 bg-slate-50 rounded">
                <span class="text-[9px] font-bold text-slate-500 uppercase block">Stok Menipis / Kritis</span>
                <span class="text-sm font-bold text-rose-800 font-mono block mt-0.5">{{ $lowStockCount }} Item</span>
                <span class="text-[8px] text-slate-500">Perlu Segera Restock</span>
            </div>
        </div>
    </div>

    <!-- SCREEN-ONLY: Header & Action Buttons -->
    <div class="screen-only flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#172B4D]">Laporan Valuasi &amp; Inventaris Stok</h1>
            <p class="text-xs text-slate-500 mt-1">
                Nilai aset persediaan bahan baku, profil aluminium, kaca, aksesoris, dan status batas minimum stok.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-xs transition">
                <i data-lucide="printer" class="w-4 h-4 text-slate-600"></i>
                <span>Cetak Dokumen</span>
            </button>
            <a href="{{ route('admin.reports.stock.csv', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-xs transition">
                <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i>
                <span>Ekspor Excel/CSV</span>
            </a>
            <a href="{{ route('admin.reports.stock.pdf', request()->query()) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs shadow-xs transition">
                <i data-lucide="file-down" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Unduh PDF Resmi</span>
            </a>
            <a href="{{ route('admin.inventory.stock-adjustments.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                <i data-lucide="clipboard-check" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Stok Opname</span>
            </a>
            <a href="{{ route('admin.purchases.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs shadow-xs transition">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Restock Belanja</span>
            </a>
        </div>
    </div>

    <!-- SCREEN-ONLY: Summary Stats Cards -->
    <div class="screen-only grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Item Produk</p>
                <h3 class="text-2xl font-extrabold text-[#172B4D] mt-1 font-mono">{{ number_format($totalItems, 0) }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Material &amp; Jasa aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center shrink-0">
                <i data-lucide="layers" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Valuasi Modal (HPP)</p>
                <h3 class="text-2xl font-extrabold text-emerald-700 mt-1 font-mono">Rp {{ number_format($totalCostValue, 0, ',', '.') }}</h3>
                <p class="text-xs text-emerald-700 font-semibold mt-0.5">Nilai aset modal fisik</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center shrink-0">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Potensi Nilai Jual</p>
                <h3 class="text-2xl font-extrabold text-[#172B4D] mt-1 font-mono">Rp {{ number_format($totalRetailValue, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Estimasi omzet jika terjual</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 border border-amber-100 flex items-center justify-center shrink-0">
                <i data-lucide="tag" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Stok Menipis / Kritis</p>
                <h3 class="text-2xl font-extrabold text-rose-700 mt-1 font-mono">{{ $lowStockCount }}</h3>
                <p class="text-xs text-rose-700 font-semibold mt-0.5">Perlu segera restock</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-700 border border-rose-100 flex items-center justify-center shrink-0">
                <i data-lucide="alert-octagon" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- SCREEN-ONLY: Filter & Pills -->
    <div class="screen-only bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('admin.reports.stock') }}" class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <div class="w-64">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Kategori Material</label>
                    <select name="category_id" onchange="this.form.submit()" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#D6A84F] focus:border-[#D6A84F]">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2 pt-5">
                    <a href="{{ route('admin.reports.stock') }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ !request()->has('filter') ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Semua Barang
                    </a>
                    <a href="{{ route('admin.reports.stock', array_merge(request()->query(), ['filter' => 'low'])) }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ request('filter') === 'low' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200' }}">
                        Stok Menipis Saja ({{ $lowStockCount }})
                    </a>
                </div>
            </div>

            @if(request()->anyFilled(['category_id', 'filter']))
                <a href="{{ route('admin.reports.stock') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 pt-5">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset Filter
                </a>
            @endif
        </form>
    </div>

    <!-- MAIN DATA TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden print:border print:border-slate-400 print:rounded-none">
        <div class="screen-only p-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="boxes" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Daftar Stok Fisik &amp; Nilai Aset Gudang</span>
            </h3>
            <span class="text-xs font-semibold text-slate-600">{{ $products->count() }} Data Ditampilkan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs print:text-[8pt]">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-300 text-slate-800 font-bold uppercase tracking-wider text-[11px] print:text-[7.5pt] print:bg-slate-200">
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2">Nama Produk &amp; SKU</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2">Kategori</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">Stok Fisik</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">Batas Min</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Harga Beli (Modal)</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Harga Jual</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-right">Total Valuasi Modal</th>
                        <th class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($products as $p)
                    @php
                        $isLow = (float)$p->stock <= (float)$p->min_stock && $p->type === 'standard';
                        $subCost = (float)$p->cost_price * (float)$p->stock;
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors print:hover:bg-transparent {{ $isLow ? 'bg-rose-50/20' : '' }}">
                        <td class="py-3 px-3.5 print:py-1.5 print:px-2">
                            <div class="font-bold text-[#172B4D]">{{ $p->name }}</div>
                            <div class="text-[10px] text-slate-500 font-mono mt-0.5">
                                SKU: {{ $p->sku }}
                                @if($p->rack_location)
                                    • Rak: <span class="text-slate-700 font-semibold">{{ $p->rack_location }}</span>
                                @endif
                            </div>
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-slate-700 font-medium">
                            {{ $p->category->name ?? '-' }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">
                            @if($p->type === 'standard')
                                <span class="font-bold font-mono {{ $isLow ? 'text-rose-700' : 'text-slate-900' }}">
                                    {{ (float)$p->stock == (int)$p->stock ? number_format($p->stock, 0) : number_format($p->stock, 2) }}
                                </span>
                                <span class="text-[10px] text-slate-500 ml-0.5">{{ $p->unit->symbol ?? '' }}</span>
                            @else
                                <span class="text-[10px] text-purple-700 font-semibold">Layanan Jasa</span>
                            @endif
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-center text-slate-500 font-mono">
                            {{ $p->type === 'standard' ? number_format($p->min_stock, 0) . ' ' . ($p->unit->symbol ?? '') : '-' }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono text-slate-700">
                            Rp {{ number_format($p->cost_price, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono font-bold text-slate-900">
                            Rp {{ number_format($p->price, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-right font-mono font-bold text-emerald-700">
                            Rp {{ number_format($subCost, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-3.5 print:py-1.5 print:px-2 text-center">
                            @if($p->type === 'custom_service')
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                    Pre-Order / Jasa
                                </span>
                            @elseif($isLow)
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                    Stok Kritis
                                </span>
                            @else
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    Aman
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-slate-400">
                            Tidak ada data produk yang cocok dengan kriteria filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($products->isNotEmpty())
                <tfoot>
                    <tr class="bg-slate-100 font-bold text-slate-900 border-t-2 border-slate-900 text-xs print:text-[8pt]">
                        <td colspan="6" class="py-3 px-3.5 print:py-2 print:px-2 text-right uppercase tracking-wider">TOTAL VALUASI MODAL:</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-right font-mono text-emerald-800 font-bold text-sm">Rp {{ number_format($totalCostValue, 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 print:py-2 print:px-2 text-center">{{ $totalItems }} Item</td>
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
                <p class="text-[10px] text-slate-600">Dibuat &amp; Diverifikasi Fisik,</p>
                <p class="font-bold text-slate-900 mt-0.5">Kepala Gudang / Logistik</p>
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
