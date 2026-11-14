@extends('layouts.admin')

@section('title', 'Inventaris Produk & Material')
@section('breadcrumb', 'Inventaris & Stok / Produk & Material')

@section('content')
<div class="space-y-6" x-data="{ 
    createModal: false, 
    editModal: false, 
    editData: { 
        id: '', 
        sku: '',
        barcode: '',
        name: '', 
        category_id: '',
        unit_id: '',
        cost_price: 0,
        price: 0,
        stock: 0,
        min_stock: 5,
        rack_location: '',
        type: 'standard',
        description: '',
        is_active: '1', 
        updateUrl: '' 
    },
    openEdit(item) {
        this.editData = {
            id: item.id,
            sku: item.sku,
            barcode: item.barcode || '',
            name: item.name,
            category_id: item.category_id,
            unit_id: item.unit_id,
            cost_price: item.cost_price,
            price: item.price,
            stock: item.stock,
            min_stock: item.min_stock,
            rack_location: item.rack_location || '',
            type: item.type || 'standard',
            description: item.description || '',
            is_active: item.is_active ? '1' : '0',
            updateUrl: item.updateUrl
        };
        this.editModal = true;
        this.$nextTick(() => {
            $('#edit_category_id').val(this.editData.category_id).trigger('change');
            $('#edit_unit_id').val(this.editData.unit_id).trigger('change');
            $('#edit_product_type').val(this.editData.type).trigger('change');
            $('#edit_product_active').val(this.editData.is_active).trigger('change');
            if (window.initSelect2) window.initSelect2(this.$refs.editModalCard);
        });
    }
}">
    <!-- Summary Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Item Produk</p>
                <p class="text-2xl font-extrabold text-[#172B4D] mt-1">{{ number_format($totalProducts) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="boxes" class="w-6 h-6"></i>
            </div>
        </div>

        <a href="{{ route('admin.inventory.products.index', ['stock_status' => 'low']) }}" 
           class="bg-white p-5 rounded-2xl border border-amber-200 shadow-xs flex items-center justify-between hover:bg-amber-50/30 transition">
            <div>
                <p class="text-xs font-semibold text-amber-700 uppercase tracking-wider">Stok Menipis (Alert)</p>
                <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ number_format($lowStockCount) }}</p>
                <span class="text-[10px] text-amber-600 font-medium">Klik untuk filter &rarr;</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            </div>
        </a>

        <a href="{{ route('admin.inventory.products.index', ['stock_status' => 'out']) }}" 
           class="bg-white p-5 rounded-2xl border border-red-200 shadow-xs flex items-center justify-between hover:bg-red-50/30 transition">
            <div>
                <p class="text-xs font-semibold text-red-600 uppercase tracking-wider">Stok Habis</p>
                <p class="text-2xl font-extrabold text-red-600 mt-1">{{ number_format($outOfStockCount) }}</p>
                <span class="text-[10px] text-red-500 font-medium">Perlu restock segera</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                <i data-lucide="package-x" class="w-6 h-6"></i>
            </div>
        </a>

        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori Aktif</p>
                <p class="text-2xl font-extrabold text-[#D6A84F] mt-1">{{ $categories->count() }}</p>
                <span class="text-[10px] text-gray-400 font-medium">{{ $units->count() }} Satuan terdaftar</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-[#D6A84F] flex items-center justify-center">
                <i data-lucide="shapes" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Katalog Produk &amp; Material</h2>
            <p class="text-xs text-gray-500">Kelola inventaris profil kusen aluminium, lembaran kaca, aksesoris, dan harga modal/jual</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.inventory.products.export', request()->query()) }}" 
               class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 font-semibold text-xs shadow-xs hover:bg-slate-50 transition flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i>
                <span>Ekspor Excel/CSV</span>
            </a>
            <a href="{{ route('admin.pos.index') }}" 
               class="px-4 py-2.5 rounded-xl bg-[#172B4D] hover:bg-[#101D33] text-white font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm">
                <i data-lucide="calculator" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Buka Kasir POS</span>
            </a>
            <button type="button" 
                    @click="createModal = true; $nextTick(() => { if (window.initSelect2) window.initSelect2($refs.createModalCard); });" 
                    class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm shrink-0 cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Produk</span>
            </button>
        </div>
    </div>

    <!-- Filter & Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <!-- Search & Filter Form -->
        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('admin.inventory.products.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <div class="sm:col-span-5 relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama produk, SKU, barcode..." 
                           class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-[#D6A84F] outline-none bg-white">
                </div>

                <div class="sm:col-span-3">
                    <select name="category_id" class="select2-luxury w-full" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <select name="stock_status" class="select2-luxury w-full" onchange="this.form.submit()">
                        <option value="">Semua Stok</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>⚠️ Stok Menipis</option>
                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>⛔ Stok Habis</option>
                    </select>
                </div>

                <div class="sm:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2 px-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'category_id', 'stock_status']))
                        <a href="{{ route('admin.inventory.products.index') }}" class="p-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition" title="Reset Filter">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Produk / Material</th>
                        <th class="px-6 py-3.5">Kategori &amp; Satuan</th>
                        <th class="px-6 py-3.5 text-right">Harga Modal</th>
                        <th class="px-6 py-3.5 text-right">Harga Jual</th>
                        <th class="px-6 py-3.5 text-center">Stok Fisik</th>
                        <th class="px-6 py-3.5 text-center">Lokasi Rak</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $p)
                        <tr class="hover:bg-gray-50/60 transition {{ (float)$p->stock <= (float)$p->min_stock ? 'bg-amber-50/20' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($p->image)
                                        <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200 shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 shrink-0">
                                            <i data-lucide="package" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="font-bold text-[#172B4D] text-sm block">{{ $p->name }}</span>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="font-mono text-[11px] px-1.5 py-0.2 bg-gray-100 rounded text-gray-600">{{ $p->sku }}</span>
                                            @if($p->type === 'custom_service')
                                                <span class="text-[10px] px-1.5 py-0.2 bg-purple-50 text-purple-700 rounded font-semibold">Custom</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-700 text-xs block">{{ $p->category->name ?? '-' }}</span>
                                <span class="text-[11px] text-gray-400">Satuan: <b>{{ $p->unit->symbol ?? 'pcs' }}</b></span>
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-xs text-gray-500">
                                Rp {{ number_format($p->cost_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-xs font-bold text-[#172B4D]">
                                Rp {{ number_format($p->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if((float)$p->stock <= 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> 0 {{ $p->unit->symbol }} (Habis)
                                    </span>
                                @elseif((float)$p->stock <= (float)$p->min_stock)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i> {{ $p->stock }} {{ $p->unit->symbol }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        {{ $p->stock }} {{ $p->unit->symbol }}
                                    </span>
                                @endif
                                <span class="block text-[10px] text-gray-400 mt-0.5">Min: {{ $p->min_stock }}</span>
                            </td>
                            <td class="px-6 py-4 text-center text-xs text-gray-600">
                                {{ $p->rack_location ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($p->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" 
                                            @click="openEdit({
                                                id: {{ $p->id }},
                                                sku: '{{ addslashes($p->sku) }}',
                                                barcode: '{{ addslashes($p->barcode ?? '') }}',
                                                name: '{{ addslashes($p->name) }}',
                                                category_id: '{{ $p->category_id }}',
                                                unit_id: '{{ $p->unit_id }}',
                                                cost_price: {{ $p->cost_price }},
                                                price: {{ $p->price }},
                                                stock: {{ $p->stock }},
                                                min_stock: {{ $p->min_stock }},
                                                rack_location: '{{ addslashes($p->rack_location ?? '') }}',
                                                type: '{{ $p->type }}',
                                                description: '{{ addslashes($p->description ?? '') }}',
                                                is_active: {{ $p->is_active ? 1 : 0 }},
                                                updateUrl: '{{ route('admin.inventory.products.update', $p->id) }}'
                                            })"
                                            class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-[#172B4D] hover:text-white text-slate-700 border border-slate-200 flex items-center justify-center transition cursor-pointer shadow-2xs"
                                            title="Edit Produk">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <form action="{{ route('admin.inventory.products.destroy', $p->id) }}" method="POST" class="inline form-delete" data-confirm="Hapus produk '{{ $p->name }}'? Riwayat transaksi terkait akan tetap tersimpan.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 border border-rose-200 flex items-center justify-center transition cursor-pointer delete-confirm shadow-2xs"
                                                title="Hapus Produk">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                <i data-lucide="box" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                Belum ada data produk inventaris sesuai pencarian. Klik "Tambah Produk" di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL CREATE PRODUCT -->
    <div x-show="createModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div x-ref="createModalCard" @click.away="createModal = false" 
             class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl border border-gray-100 relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4 sticky top-0 bg-white z-10">
                <h3 class="text-base font-bold text-[#172B4D]">Tambah Produk / Material Inventaris</h3>
                <button type="button" @click="createModal = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form action="{{ route('admin.inventory.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">SKU / Kode Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="sku" required placeholder="Contoh: ALU-KS3-01" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Barcode / Kode Batang (Opsional)</label>
                        <input type="text" name="barcode" placeholder="Contoh: 89912345678" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Produk / Material <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Kusen Aluminium 3 Inch Alexindo Hitam (6 Meter)" 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori Material <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="select2-luxury w-full">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Satuan Barang <span class="text-red-500">*</span></label>
                        <select name="unit_id" required class="select2-luxury w-full">
                            <option value="">Pilih Satuan</option>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->symbol }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Harga Modal / Beli (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="cost_price" required min="0" placeholder="0" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Harga Jual Ritel / Kasir (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="price" required min="0" placeholder="0" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Stok Awal <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="stock" required min="0" value="0" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Minimum Stok (Alert) <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="min_stock" required min="0" value="5" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Lokasi Rak / Gudang</label>
                        <input type="text" name="rack_location" placeholder="Rak A-01" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tipe Produk</label>
                        <select name="type" class="select2-luxury w-full">
                            <option value="standard" selected>Produk Fisik Standar (Potong Stok)</option>
                            <option value="custom_service">Jasa / Rakitan Custom</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Status Produk</label>
                        <select name="is_active" class="select2-luxury w-full">
                            <option value="1" selected>Aktif Dijual</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Foto Produk (Opsional)</label>
                    <input type="file" name="image" accept="image/*" 
                           class="w-full px-3 py-1.5 text-xs rounded-xl border border-gray-200 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Keterangan / Spesifikasi</label>
                    <textarea name="description" rows="2" placeholder="Catatan spesifikasi material..." 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="createModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] transition">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT PRODUCT -->
    <div x-show="editModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div x-ref="editModalCard" @click.away="editModal = false" 
             class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl border border-gray-100 relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4 sticky top-0 bg-white z-10">
                <h3 class="text-base font-bold text-[#172B4D]">Edit Data Produk Inventaris</h3>
                <button type="button" @click="editModal = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form :action="editData.updateUrl" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">SKU / Kode Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="sku" x-model="editData.sku" required 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Barcode</label>
                        <input type="text" name="barcode" x-model="editData.barcode" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Produk / Material <span class="text-red-500">*</span></label>
                    <input type="text" name="name" x-model="editData.name" required 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori Material <span class="text-red-500">*</span></label>
                        <select name="category_id" id="edit_category_id" required class="select2-luxury w-full">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Satuan Barang <span class="text-red-500">*</span></label>
                        <select name="unit_id" id="edit_unit_id" required class="select2-luxury w-full">
                            @foreach($units as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->symbol }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Harga Modal / Beli (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="cost_price" x-model="editData.cost_price" required min="0" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Harga Jual Ritel (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="price" x-model="editData.price" required min="0" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Stok Fisik <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="stock" x-model="editData.stock" required min="0" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Minimum Stok <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="min_stock" x-model="editData.min_stock" required min="0" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Lokasi Rak</label>
                        <input type="text" name="rack_location" x-model="editData.rack_location" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Tipe Produk</label>
                        <select name="type" id="edit_product_type" class="select2-luxury w-full">
                            <option value="standard">Produk Fisik Standar (Potong Stok)</option>
                            <option value="custom_service">Jasa / Rakitan Custom</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Status Produk</label>
                        <select name="is_active" id="edit_product_active" class="select2-luxury w-full">
                            <option value="1">Aktif Dijual</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Ganti Foto Produk (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="image" accept="image/*" 
                           class="w-full px-3 py-1.5 text-xs rounded-xl border border-gray-200 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Keterangan / Spesifikasi</label>
                    <textarea name="description" x-model="editData.description" rows="2" 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] transition">Perbarui Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

