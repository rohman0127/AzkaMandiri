@extends('layouts.admin')

@section('title', 'Kelola Layanan')
@section('breadcrumb', 'Daftar Layanan Aluminium & Kaca')

@section('content')
<div class="space-y-6" x-data="{ 
    createModal: false, 
    editModal: false, 
    editData: { 
        id: '', 
        name: '', 
        service_category_id: '',
        slug: '', 
        price_info: '',
        excerpt: '',
        description: '', 
        features: '',
        sort_order: 0, 
        is_active: '1', 
        is_featured: '0',
        updateUrl: '' 
    },
    openEdit(item) {
        this.editData = {
            id: item.id,
            name: item.name,
            service_category_id: item.service_category_id ? item.service_category_id.toString() : '',
            slug: item.slug,
            price_info: item.price_info || '',
            excerpt: item.excerpt || '',
            description: item.description || '',
            features: item.features || '',
            sort_order: item.sort_order || 0,
            is_active: item.is_active ? '1' : '0',
            is_featured: item.is_featured ? '1' : '0',
            updateUrl: item.updateUrl
        };
        this.editModal = true;
        this.$nextTick(() => {
            $('#edit_service_category_id').val(this.editData.service_category_id).trigger('change');
            $('#edit_service_is_active').val(this.editData.is_active).trigger('change');
            $('#edit_service_is_featured').val(this.editData.is_featured).trigger('change');
            if (window.initSelect2) window.initSelect2(this.$refs.editModalCard);
        });
    }
}">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Daftar Layanan</h2>
            <p class="text-xs text-gray-500">Kelola katalog layanan aluminium dan kaca yang tampil di website</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.service-categories.index') }}" class="px-4 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-semibold text-xs transition flex items-center gap-2">
                <i data-lucide="folder-tree" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Kategori Layanan</span>
            </a>
            <button type="button" 
                    @click="createModal = true; $nextTick(() => { if (window.initSelect2) window.initSelect2($refs.createModalCard); });" 
                    class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center gap-2 shadow-sm cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Layanan</span>
            </button>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.services.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama layanan atau deskripsi..."
                       class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>

            <div class="w-full sm:w-56">
                <select name="category_id" class="select2 w-full">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-5 py-2 rounded-xl bg-[#172B4D] text-white text-xs font-bold hover:bg-[#101D33] transition flex items-center justify-center gap-1.5 cursor-pointer">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['search', 'category_id']))
                <a href="{{ route('admin.services.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Layanan</th>
                        <th class="px-6 py-3.5">Kategori</th>
                        <th class="px-6 py-3.5">Estimasi Biaya</th>
                        <th class="px-6 py-3.5 text-center">Urutan</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($services as $srv)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    <img src="{{ $srv->thumbnail ?: ($srv->main_image ?: asset('assets/brand/logo-icon.svg')) }}" 
                                         alt="{{ $srv->name }}" 
                                         class="w-12 h-12 rounded-xl object-cover border border-gray-200 shrink-0 bg-gray-100">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[#172B4D] text-sm">{{ $srv->name }}</span>
                                            @if($srv->is_featured)
                                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-amber-100 text-[#a97e2c]">Unggulan</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $srv->excerpt ?: 'Belum ada ringkasan' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 text-xs font-medium">
                                    {{ $srv->category ? $srv->category->name : 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-gray-800">
                                {{ $srv->price_info ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-xs">
                                {{ $srv->sort_order }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($srv->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-600">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('services.show', $srv->slug) }}" target="_blank" title="Lihat di Web"
                                       class="p-2 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Edit Trigger Modal -->
                                    <button type="button" 
                                            data-item="{{ json_encode([
                                                'id' => $srv->id,
                                                'name' => $srv->name,
                                                'service_category_id' => (string) ($srv->service_category_id ?? ''),
                                                'slug' => $srv->slug,
                                                'price_info' => $srv->price_info ?? '',
                                                'excerpt' => $srv->excerpt ?? '',
                                                'description' => $srv->description ?? '',
                                                'features' => is_array($srv->features) ? implode("\n", $srv->features) : ($srv->features ?? ''),
                                                'sort_order' => $srv->sort_order,
                                                'is_active' => $srv->is_active ? 1 : 0,
                                                'is_featured' => $srv->is_featured ? 1 : 0,
                                                'updateUrl' => route('admin.services.update', $srv->id),
                                            ]) }}"
                                            @click="openEdit(JSON.parse($el.getAttribute('data-item')))"
                                            class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition cursor-pointer" 
                                            title="Edit Layanan">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>

                                    <!-- Delete Form Intercepted by SweetAlert2 -->
                                    <form action="{{ route('admin.services.destroy', $srv->id) }}" method="POST"
                                          data-confirm="Hapus layanan '{{ $srv->name }}'?" 
                                          class="inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Layanan" class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition cursor-pointer">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i data-lucide="wrench" class="w-10 h-10 mx-auto text-gray-300 mb-2"></i>
                                <p class="text-sm font-semibold">Belum ada layanan yang ditambahkan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $services->links() }}
            </div>
        @endif
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL: Tambah Layanan Baru                                                -->
    <!-- ========================================================================= -->
    <div x-show="createModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
         style="display: none;"
         x-cloak>
        <div @click.outside="createModal = false" 
             x-ref="createModalCard"
             class="bg-white rounded-3xl border border-gray-200/90 shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all relative my-8">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#172B4D] via-[#D6A84F] to-[#172B4D]"></div>
            
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-[#D6A84F] flex items-center justify-center border border-amber-200/50">
                        <i data-lucide="wrench" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#172B4D] text-base">Tambah Layanan Baru</h3>
                        <p class="text-xs text-gray-500">Katalog jasa pengerjaan aluminium &amp; kaca</p>
                    </div>
                </div>
                <button type="button" @click="createModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="srv_create_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Layanan *</label>
                        <input type="text" id="srv_create_name" name="name" required
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                               placeholder="Contoh: Kusen Aluminium 3&quot; &amp; 4&quot;">
                    </div>
                    <div>
                        <label for="srv_create_category" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kategori Layanan</label>
                        <select id="srv_create_category" name="service_category_id" class="select2 w-full">
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="srv_create_slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Slug URL (Opsional)</label>
                        <input type="text" id="srv_create_slug" name="slug"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                               placeholder="kusen-aluminium">
                    </div>
                    <div>
                        <label for="srv_create_price" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Estimasi Biaya / Harga</label>
                        <input type="text" id="srv_create_price" name="price_info"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                               placeholder="Contoh: Mulai Rp 120.000 / m'">
                    </div>
                </div>

                <div>
                    <label for="srv_create_excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Ringkasan Layanan</label>
                    <textarea id="srv_create_excerpt" name="excerpt" rows="2"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                              placeholder="Deskripsi ringkas untuk kartu layanan di beranda..."></textarea>
                </div>

                <div>
                    <label for="srv_create_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi Lengkap</label>
                    <textarea id="srv_create_description" name="description" rows="3"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                              placeholder="Rincian material, jenis pengerjaan, dan spesifikasi..."></textarea>
                </div>

                <div>
                    <label for="srv_create_features" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Fitur &amp; Keunggulan (1 baris per poin)</label>
                    <textarea id="srv_create_features" name="features" rows="2"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                              placeholder="Material Alexindo &amp; YKK&#10;Anti Rayap &amp; Karat&#10;Garansi Pemasangan"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="srv_create_is_active" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select id="srv_create_is_active" name="is_active" class="select2 w-full">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label for="srv_create_is_featured" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Highlight</label>
                        <select id="srv_create_is_featured" name="is_featured" class="select2 w-full">
                            <option value="0" selected>Standar</option>
                            <option value="1">Unggulan Beranda</option>
                        </select>
                    </div>
                    <div>
                        <label for="srv_create_sort" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Urutan</label>
                        <input type="number" id="srv_create_sort" name="sort_order" value="0"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label for="srv_create_thumbnail" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Foto Utama (Thumbnail)</label>
                    <input type="file" id="srv_create_thumbnail" name="thumbnail" accept="image/*"
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="createModal = false" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition cursor-pointer">
                        Batalkan
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#c4963e] hover:from-[#e3ba63] text-[#101D33] text-xs font-extrabold shadow-sm transition cursor-pointer flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Simpan Layanan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL: Edit Layanan                                                       -->
    <!-- ========================================================================= -->
    <div x-show="editModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
         style="display: none;"
         x-cloak>
        <div @click.outside="editModal = false" 
             x-ref="editModalCard"
             class="bg-white rounded-3xl border border-gray-200/90 shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all relative my-8">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#172B4D] via-[#D6A84F] to-[#172B4D]"></div>
            
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-200/50">
                        <i data-lucide="edit" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#172B4D] text-base">Edit Layanan</h3>
                        <p class="text-xs text-gray-500">Perbarui rincian spesifikasi &amp; data layanan</p>
                    </div>
                </div>
                <button type="button" @click="editModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :action="editData.updateUrl" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="srv_edit_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Layanan *</label>
                        <input type="text" id="srv_edit_name" name="name" x-model="editData.name" required
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="edit_service_category_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kategori Layanan</label>
                        <select id="edit_service_category_id" name="service_category_id" class="select2 w-full">
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="srv_edit_slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Slug URL</label>
                        <input type="text" id="srv_edit_slug" name="slug" x-model="editData.slug"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="srv_edit_price" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Estimasi Biaya / Harga</label>
                        <input type="text" id="srv_edit_price" name="price_info" x-model="editData.price_info"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label for="srv_edit_excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Ringkasan Layanan</label>
                    <textarea id="srv_edit_excerpt" name="excerpt" rows="2" x-model="editData.excerpt"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"></textarea>
                </div>

                <div>
                    <label for="srv_edit_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi Lengkap</label>
                    <textarea id="srv_edit_description" name="description" rows="3" x-model="editData.description"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"></textarea>
                </div>

                <div>
                    <label for="srv_edit_features" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Fitur &amp; Keunggulan (1 baris per poin)</label>
                    <textarea id="srv_edit_features" name="features" rows="2" x-model="editData.features"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="edit_service_is_active" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select id="edit_service_is_active" name="is_active" class="select2 w-full">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit_service_is_featured" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Highlight</label>
                        <select id="edit_service_is_featured" name="is_featured" class="select2 w-full">
                            <option value="0">Standar</option>
                            <option value="1">Unggulan Beranda</option>
                        </select>
                    </div>
                    <div>
                        <label for="srv_edit_sort" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Urutan</label>
                        <input type="number" id="srv_edit_sort" name="sort_order" x-model="editData.sort_order"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label for="srv_edit_thumbnail" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Ganti Foto Thumbnail</label>
                    <input type="file" id="srv_edit_thumbnail" name="thumbnail" accept="image/*"
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="editModal = false" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition cursor-pointer">
                        Batalkan
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#c4963e] hover:from-[#e3ba63] text-[#101D33] text-xs font-extrabold shadow-sm transition cursor-pointer flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Perbarui Layanan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
