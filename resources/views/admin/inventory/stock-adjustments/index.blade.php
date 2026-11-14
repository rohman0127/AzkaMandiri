@extends('layouts.admin')

@section('title', 'Penyesuaian Stok / Opname')
@section('breadcrumb', 'Inventaris & Stok / Penyesuaian Stok')

@section('content')
<div class="space-y-6" x-data="{ createModal: false }">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Penyesuaian Stok &amp; Stok Opname</h2>
            <p class="text-xs text-gray-500">Pencatatan koreksi stok fisik, material rusak/pecah, atau pemakaian bahan proyek</p>
        </div>
        <button type="button" 
                @click="createModal = true; $nextTick(() => { if (window.initSelect2) window.initSelect2($refs.createModalCard); });" 
                class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm shrink-0 cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Catat Penyesuaian</span>
        </button>
    </div>

    <!-- Data Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <!-- Search & Filter Bar -->
        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('admin.inventory.stock-adjustments.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <div class="sm:col-span-6 relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari kode penyesuaian atau nama produk..." 
                           class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-[#D6A84F] outline-none bg-white">
                </div>

                <div class="sm:col-span-3">
                    <select name="type" class="select2-luxury w-full" onchange="this.form.submit()">
                        <option value="">Semua Tipe</option>
                        <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>(+) Penambahan Stok</option>
                        <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>(-) Pengurangan Stok</option>
                    </select>
                </div>

                <div class="sm:col-span-3 flex items-center gap-2">
                    <button type="submit" class="w-full py-2 px-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'type', 'reason']))
                        <a href="{{ route('admin.inventory.stock-adjustments.index') }}" class="p-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition" title="Reset">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-slate-100 text-slate-700 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">Kode Penyesuaian</th>
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5">Produk / Material</th>
                        <th class="px-6 py-3.5 text-center">Tipe &amp; Jumlah</th>
                        <th class="px-6 py-3.5">Alasan Penyesuaian</th>
                        <th class="px-6 py-3.5">Dicatat Oleh</th>
                        <th class="px-6 py-3.5">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($adjustments as $adj)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4 font-mono font-bold text-xs text-[#172B4D]">
                                {{ $adj->adjustment_code }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">
                                {{ \Carbon\Carbon::parse($adj->date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#172B4D] text-sm block">{{ $adj->product->name ?? '-' }}</span>
                                <span class="font-mono text-[11px] text-gray-400">SKU: {{ $adj->product->sku ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($adj->type === 'in')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i> +{{ $adj->quantity }} {{ $adj->product->unit->symbol ?? '' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                        <i data-lucide="arrow-down-right" class="w-3.5 h-3.5"></i> -{{ $adj->quantity }} {{ $adj->product->unit->symbol ?? '' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $reasonLabels = [
                                        'stock_opname' => ['label' => 'Stok Opname Fisik', 'color' => 'bg-blue-50 text-blue-700 border-blue-200'],
                                        'damaged' => ['label' => 'Barang Rusak / Pecah', 'color' => 'bg-rose-50 text-rose-700 border-rose-200'],
                                        'project_usage' => ['label' => 'Terpakai Proyek', 'color' => 'bg-purple-50 text-purple-700 border-purple-200'],
                                        'return' => ['label' => 'Retur Konsumen', 'color' => 'bg-amber-50 text-amber-700 border-amber-200'],
                                        'other' => ['label' => 'Lain-lain', 'color' => 'bg-gray-50 text-gray-700 border-gray-200'],
                                    ];
                                    $rInfo = $reasonLabels[$adj->reason] ?? ['label' => $adj->reason, 'color' => 'bg-gray-100 text-gray-700'];
                                @endphp
                                <span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-semibold border {{ $rInfo['color'] }}">
                                    {{ $rInfo['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">
                                {{ $adj->user->name ?? 'Administrator' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 max-w-xs truncate">
                                {{ $adj->notes ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <i data-lucide="arrow-left-right" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                Belum ada riwayat penyesuaian stok. Klik tombol "Catat Penyesuaian" di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($adjustments->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $adjustments->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL CREATE ADJUSTMENT -->
    <div x-show="createModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div x-ref="createModalCard" @click.away="createModal = false" 
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 relative">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                <h3 class="text-base font-bold text-[#172B4D]">Catat Penyesuaian Stok (Opname)</h3>
                <button type="button" @click="createModal = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form action="{{ route('admin.inventory.stock-adjustments.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Pilih Produk / Material <span class="text-red-500">*</span></label>
                    <select name="product_id" required class="select2-luxury w-full">
                        <option value="">Pilih Produk...</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}">
                                {{ $prod->name }} (Sisa Stok: {{ $prod->stock }} {{ $prod->unit->symbol ?? '' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Jenis Penyesuaian <span class="text-red-500">*</span></label>
                        <select name="type" required class="select2-luxury w-full">
                            <option value="out">(-) Pengurangan Stok</option>
                            <option value="in">(+) Penambahan Stok</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Jumlah Kuantitas <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="quantity" required min="0.01" placeholder="1" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Alasan Penyesuaian <span class="text-red-500">*</span></label>
                        <select name="reason" required class="select2-luxury w-full">
                            <option value="stock_opname">Stok Opname Fisik</option>
                            <option value="damaged">Barang Rusak / Pecah</option>
                            <option value="project_usage">Terpakai Proyek</option>
                            <option value="return">Retur Konsumen</option>
                            <option value="other">Lain-lain</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Catatan Tambahan</label>
                    <textarea name="notes" rows="2" placeholder="Jelaskan rincian penyebab penyesuaian..." 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="createModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] transition">Simpan Penyesuaian</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

