@extends('layouts.admin')

@section('title', 'Halaman Statis')
@section('breadcrumb', 'Kelola Halaman Statis & Informasi Hukum')

@section('content')
<div class="space-y-6" x-data="{ 
    createModal: false, 
    editModal: false, 
    editData: { 
        id: '', 
        title: '', 
        slug: '', 
        content: '',
        meta_title: '',
        meta_description: '',
        is_active: '1', 
        updateUrl: '' 
    },
    openEdit(item) {
        this.editData = {
            id: item.id,
            title: item.title,
            slug: item.slug,
            content: item.content || '',
            meta_title: item.meta_title || '',
            meta_description: item.meta_description || '',
            is_active: item.is_active ? '1' : '0',
            updateUrl: item.updateUrl
        };
        this.editModal = true;
        this.$nextTick(() => {
            $('#edit_page_is_active').val(this.editData.is_active).trigger('change');
            if (window.initSelect2) window.initSelect2(this.$refs.editModalCard);
        });
    }
}">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Daftar Halaman Statis</h2>
            <p class="text-xs text-gray-500">Kelola dokumen informasi legal, syarat &amp; ketentuan, serta garansi pekerjaan</p>
        </div>
        <button type="button" 
                @click="createModal = true; $nextTick(() => { if (window.initSelect2) window.initSelect2($refs.createModalCard); });" 
                class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm shrink-0 cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Halaman</span>
        </button>
    </div>

    <!-- Data Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Judul Halaman</th>
                        <th class="px-6 py-3.5">Slug URL</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-center">Terakhir Diperbarui</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pages as $pg)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#172B4D] text-sm">{{ $pg->title }}</span>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                /halaman/{{ $pg->slug }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($pg->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-xs text-gray-400">
                                {{ $pg->updated_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('pages.show', $pg->slug) }}" target="_blank" class="p-2 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition" title="Lihat di Web">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>

                                    <button type="button" 
                                            data-item="{{ json_encode([
                                                'id' => $pg->id,
                                                'title' => $pg->title,
                                                'slug' => $pg->slug,
                                                'content' => $pg->content ?? '',
                                                'meta_title' => $pg->meta_title ?? '',
                                                'meta_description' => $pg->meta_description ?? '',
                                                'is_active' => $pg->is_active ? 1 : 0,
                                                'updateUrl' => route('admin.pages.update', $pg->id),
                                            ]) }}"
                                            @click="openEdit(JSON.parse($el.getAttribute('data-item')))"
                                            class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition cursor-pointer"
                                            title="Edit Halaman">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>

                                    <form action="{{ route('admin.pages.destroy', $pg->id) }}" method="POST"
                                          data-confirm="Hapus halaman statis '{{ $pg->title }}'?" 
                                          class="inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition cursor-pointer delete-confirm" title="Hapus Halaman">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 text-xs">
                                Belum ada halaman statis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL: Tambah Halaman Statis -->
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
                        <i data-lucide="file-plus" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#172B4D] text-base">Tambah Halaman Statis</h3>
                        <p class="text-xs text-gray-500">Buat dokumen hukum atau informasi profil website</p>
                    </div>
                </div>
                <button type="button" @click="createModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.pages.store') }}" method="POST" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="pg_create_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Judul Halaman *</label>
                        <input type="text" id="pg_create_title" name="title" required
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                               placeholder="Contoh: Garansi Pekerjaan">
                    </div>
                    <div>
                        <label for="pg_create_slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Slug URL</label>
                        <input type="text" id="pg_create_slug" name="slug"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                               placeholder="garansi-pekerjaan">
                    </div>
                </div>

                <div>
                    <label for="pg_create_content" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Isi Halaman *</label>
                    <textarea id="pg_create_content" name="content" rows="6" required
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                              placeholder="Tuliskan isi ketentuan atau dokumen di sini..."></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="pg_create_meta" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Meta Title SEO</label>
                        <input type="text" id="pg_create_meta" name="meta_title"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="pg_create_is_active" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select id="pg_create_is_active" name="is_active" class="select2 w-full">
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
                        <span>Simpan Halaman</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit Halaman Statis -->
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
                        <h3 class="font-extrabold text-[#172B4D] text-base">Edit Halaman Statis</h3>
                        <p class="text-xs text-gray-500">Perbarui isi konten halaman informasi</p>
                    </div>
                </div>
                <button type="button" @click="editModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :action="editData.updateUrl" method="POST" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="pg_edit_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Judul Halaman *</label>
                        <input type="text" id="pg_edit_title" name="title" x-model="editData.title" required
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="pg_edit_slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Slug URL</label>
                        <input type="text" id="pg_edit_slug" name="slug" x-model="editData.slug"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label for="pg_edit_content" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Isi Halaman *</label>
                    <textarea id="pg_edit_content" name="content" rows="6" x-model="editData.content" required
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="pg_edit_meta" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Meta Title SEO</label>
                        <input type="text" id="pg_edit_meta" name="meta_title" x-model="editData.meta_title"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="edit_page_is_active" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select id="edit_page_is_active" name="is_active" class="select2 w-full">
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
                        <span>Perbarui Halaman</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
