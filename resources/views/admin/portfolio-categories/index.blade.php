@extends('layouts.admin')

@section('title', 'Kategori Portofolio')
@section('breadcrumb', 'Portofolio / Kategori Proyek')

@section('content')
<div class="space-y-6" x-data="{ 
    createModal: false, 
    editModal: false, 
    editData: { 
        id: '', 
        name: '', 
        slug: '', 
        description: '', 
        sort_order: 0, 
        is_active: '1', 
        updateUrl: '' 
    },
    openEdit(item) {
        this.editData = {
            id: item.id,
            name: item.name,
            slug: item.slug,
            description: item.description || '',
            sort_order: item.sort_order || 0,
            is_active: item.is_active ? '1' : '0',
            updateUrl: item.updateUrl
        };
        this.editModal = true;
        this.$nextTick(() => {
            $('#edit_is_active_portfolio').val(this.editData.is_active).trigger('change');
            if (window.initSelect2) window.initSelect2(this.$refs.editModalCard);
        });
    }
}">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Kategori Portofolio</h2>
            <p class="text-xs text-gray-500">Kelompok kategori untuk filter showcase proyek di website</p>
        </div>
        <button type="button" 
                @click="createModal = true; $nextTick(() => { if (window.initSelect2) window.initSelect2($refs.createModalCard); });" 
                class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm shrink-0 cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Kategori</span>
        </button>
    </div>

    <!-- Data Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Nama Kategori</th>
                        <th class="px-6 py-3.5">Slug URL</th>
                        <th class="px-6 py-3.5">Jumlah Proyek</th>
                        <th class="px-6 py-3.5 text-center">Urutan</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#172B4D] text-sm">{{ $cat->name }}</span>
                                @if($cat->description)
                                    <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $cat->description }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                {{ $cat->slug }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full bg-amber-50 text-[#a97e2c] font-bold text-xs">
                                    {{ $cat->portfolios_count }} Proyek
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-xs font-semibold">
                                {{ $cat->sort_order }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($cat->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" 
                                            data-item="{{ json_encode([
                                                'id' => $cat->id,
                                                'name' => $cat->name,
                                                'slug' => $cat->slug,
                                                'description' => $cat->description ?? '',
                                                'sort_order' => $cat->sort_order,
                                                'is_active' => $cat->is_active ? 1 : 0,
                                                'updateUrl' => route('admin.portfolio-categories.update', $cat->id),
                                            ]) }}"
                                            @click="openEdit(JSON.parse($el.getAttribute('data-item')))"
                                            class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition cursor-pointer"
                                            title="Edit Kategori">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>

                                    <form action="{{ route('admin.portfolio-categories.destroy', $cat->id) }}" method="POST"
                                          data-confirm="Hapus kategori '{{ $cat->name }}'? Portofolio terkait akan diubah menjadi tanpa kategori." 
                                          class="inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition cursor-pointer delete-confirm" title="Hapus Kategori">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400 text-xs">
                                Belum ada kategori portofolio.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL: Tambah Kategori Portofolio -->
    <div x-show="createModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
         x-cloak>
        <div @click.outside="createModal = false" 
             x-ref="createModalCard"
             class="bg-white rounded-3xl border border-gray-200/90 shadow-2xl w-full max-w-lg overflow-hidden transform transition-all relative">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#172B4D] via-[#D6A84F] to-[#172B4D]"></div>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-[#D6A84F] flex items-center justify-center border border-amber-200/50">
                        <i data-lucide="folder-plus" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#172B4D] text-base">Tambah Kategori Portofolio</h3>
                        <p class="text-xs text-gray-500">Kelompok kategori untuk filter portofolio</p>
                    </div>
                </div>
                <button type="button" @click="createModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.portfolio-categories.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label for="p_create_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Kategori *</label>
                    <input type="text" id="p_create_name" name="name" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="Contoh: Residensial &amp; Rumah">
                </div>

                <div>
                    <label for="p_create_slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Slug URL</label>
                    <input type="text" id="p_create_slug" name="slug"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="residensial-rumah">
                </div>

                <div>
                    <label for="p_create_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                    <textarea id="p_create_description" name="description" rows="2"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="p_create_sort_order" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
                        <input type="number" id="p_create_sort_order" name="sort_order" value="0"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="p_create_is_active" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select id="p_create_is_active" name="is_active" class="select2 w-full">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="createModal = false" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition cursor-pointer">
                        Batalkan
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#c4963e] hover:from-[#e3ba63] text-[#101D33] text-xs font-extrabold shadow-sm transition cursor-pointer flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Simpan Kategori</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit Kategori Portofolio -->
    <div x-show="editModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
         x-cloak>
        <div @click.outside="editModal = false" 
             x-ref="editModalCard"
             class="bg-white rounded-3xl border border-gray-200/90 shadow-2xl w-full max-w-lg overflow-hidden transform transition-all relative">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#172B4D] via-[#D6A84F] to-[#172B4D]"></div>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-200/50">
                        <i data-lucide="edit" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#172B4D] text-base">Edit Kategori Portofolio</h3>
                        <p class="text-xs text-gray-500">Perbarui informasi kategori portofolio</p>
                    </div>
                </div>
                <button type="button" @click="editModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :action="editData.updateUrl" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="p_edit_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Kategori *</label>
                    <input type="text" id="p_edit_name" name="name" x-model="editData.name" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div>
                    <label for="p_edit_slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Slug URL</label>
                    <input type="text" id="p_edit_slug" name="slug" x-model="editData.slug"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div>
                    <label for="p_edit_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                    <textarea id="p_edit_description" name="description" rows="2" x-model="editData.description"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="p_edit_sort_order" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
                        <input type="number" id="p_edit_sort_order" name="sort_order" x-model="editData.sort_order"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="edit_is_active_portfolio" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select id="edit_is_active_portfolio" name="is_active" class="select2 w-full">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="editModal = false" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition cursor-pointer">
                        Batalkan
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#c4963e] hover:from-[#e3ba63] text-[#101D33] text-xs font-extrabold shadow-sm transition cursor-pointer flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Perbarui Kategori</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
