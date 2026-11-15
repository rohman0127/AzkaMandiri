@extends('layouts.admin')

@section('title', 'Kelola Artikel Blog')
@section('breadcrumb', 'Artikel & Tips Edukasi Aluminium Kaca')

@section('content')
<div class="space-y-6" x-data="{ 
    createModal: false, 
    editModal: false, 
    editData: { 
        id: '', 
        title: '', 
        article_category_id: '',
        slug: '', 
        author_name: '',
        status: 'published',
        excerpt: '',
        content: '', 
        updateUrl: '' 
    },
    openEdit(item) {
        this.editData = {
            id: item.id,
            title: item.title,
            article_category_id: item.article_category_id ? item.article_category_id.toString() : '',
            slug: item.slug,
            author_name: item.author_name || 'Admin AzkaMandiri',
            status: item.status || 'published',
            excerpt: item.excerpt || '',
            content: item.content || '',
            updateUrl: item.updateUrl
        };
        this.editModal = true;
        this.$nextTick(() => {
            $('#edit_article_category_id').val(this.editData.article_category_id).trigger('change');
            $('#edit_article_status').val(this.editData.status).trigger('change');
            if (window.initSelect2) window.initSelect2(this.$refs.editModalCard);
        });
    }
}">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Daftar Artikel Blog</h2>
            <p class="text-xs text-gray-500">Kelola konten edukasi, tips pemilihan, dan inspirasi desain untuk pembaca</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.article-categories.index') }}" class="px-4 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-semibold text-xs transition flex items-center gap-2">
                <i data-lucide="tag" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Kategori Artikel</span>
            </a>
            <button type="button" 
                    @click="createModal = true; $nextTick(() => { if (window.initSelect2) window.initSelect2($refs.createModalCard); });" 
                    class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center gap-2 shadow-sm cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tulis Artikel Baru</span>
            </button>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel atau konten..."
                       class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>

            <div class="w-full sm:w-48">
                <select name="category_id" class="select2 w-full">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-40">
                <select name="status" class="select2 w-full">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <button type="submit" class="px-5 py-2 rounded-xl bg-[#172B4D] text-white text-xs font-bold hover:bg-[#101D33] transition flex items-center justify-center gap-1.5 cursor-pointer">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['search', 'category_id', 'status']))
                <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center justify-center">
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
                        <th class="px-6 py-3.5">Artikel</th>
                        <th class="px-6 py-3.5">Kategori</th>
                        <th class="px-6 py-3.5">Penulis</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-center">Views</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($articles as $art)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    <img src="{{ $art->thumbnail ?: asset('assets/brand/logo-icon.svg') }}" 
                                         alt="{{ $art->title }}" 
                                         class="w-12 h-12 rounded-xl object-cover border border-gray-200 shrink-0 bg-gray-100">
                                    <div>
                                        <span class="font-bold text-[#172B4D] hover:text-[#D6A84F] transition text-sm line-clamp-1">{{ $art->title }}</span>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            {{ $art->published_at ? $art->published_at->format('d M Y') : 'Belum Terbit' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 text-xs font-medium">
                                    {{ $art->category ? $art->category->name : 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600 font-medium">
                                {{ $art->author_name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($art->status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-xs font-semibold text-gray-500">
                                {{ $art->views_count }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('articles.show', $art->slug) }}" target="_blank" title="Lihat di Web"
                                       class="p-2 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Edit Trigger Modal -->
                                    <button type="button" 
                                            data-item="{{ json_encode([
                                                'id' => $art->id,
                                                'title' => $art->title,
                                                'article_category_id' => (string) ($art->article_category_id ?? ''),
                                                'slug' => $art->slug,
                                                'author_name' => $art->author_name ?? '',
                                                'status' => $art->status,
                                                'excerpt' => $art->excerpt ?? '',
                                                'content' => $art->content ?? '',
                                                'updateUrl' => route('admin.articles.update', $art->id),
                                            ]) }}"
                                            @click="openEdit(JSON.parse($el.getAttribute('data-item')))"
                                            class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition cursor-pointer" 
                                            title="Edit Artikel">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>

                                    <!-- Delete Form Intercepted by SweetAlert2 -->
                                    <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST"
                                          data-confirm="Hapus artikel '{{ $art->title }}'?" 
                                          class="inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Artikel" class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition cursor-pointer delete-confirm">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i data-lucide="newspaper" class="w-10 h-10 mx-auto text-gray-300 mb-2"></i>
                                <p class="text-sm font-semibold">Belum ada artikel yang dibuat.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL: Tambah Artikel Baru                                                -->
    <!-- ========================================================================= -->
    <div x-show="createModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
         x-cloak>
        <div @click.outside="createModal = false" 
             x-ref="createModalCard"
             class="bg-white rounded-3xl border border-gray-200/90 shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all relative my-8">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#172B4D] via-[#D6A84F] to-[#172B4D]"></div>
            
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-200/50">
                        <i data-lucide="newspaper" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#172B4D] text-base">Tulis Artikel Baru</h3>
                        <p class="text-xs text-gray-500">Buat artikel edukasi &amp; tips seputar aluminium kaca</p>
                    </div>
                </div>
                <button type="button" @click="createModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="art_create_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Judul Artikel *</label>
                        <input type="text" id="art_create_title" name="title" required
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                               placeholder="Contoh: Tips Memilih Kusen Aluminium">
                    </div>
                    <div>
                        <label for="art_create_cat" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kategori Artikel</label>
                        <select id="art_create_cat" name="article_category_id" class="select2 w-full">
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="art_create_slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Slug URL</label>
                        <input type="text" id="art_create_slug" name="slug"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                               placeholder="tips-memilih-kusen">
                    </div>
                    <div>
                        <label for="art_create_author" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Penulis</label>
                        <input type="text" id="art_create_author" name="author_name" value="Admin AzkaMandiri"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="art_create_status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status Publikasi *</label>
                        <select id="art_create_status" name="status" class="select2 w-full" required>
                            <option value="published" selected>Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="art_create_excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Ringkasan Artikel</label>
                    <textarea id="art_create_excerpt" name="excerpt" rows="2"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                              placeholder="Ringkasan singkat isi artikel untuk tampilan kartu..."></textarea>
                </div>

                <div>
                    <label for="art_create_content" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Isi Konten Artikel *</label>
                    <textarea id="art_create_content" name="content" rows="5" required
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                              placeholder="Tuliskan isi artikel edukasi lengkap..."></textarea>
                </div>

                <div>
                    <label for="art_create_thumbnail" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Gambar Sampul / Thumbnail</label>
                    <input type="file" id="art_create_thumbnail" name="thumbnail" accept="image/*"
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="createModal = false" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition cursor-pointer">
                        Batalkan
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#c4963e] hover:from-[#e3ba63] text-[#101D33] text-xs font-extrabold shadow-sm transition cursor-pointer flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Terbitkan Artikel</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL: Edit Artikel                                                       -->
    <!-- ========================================================================= -->
    <div x-show="editModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
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
                        <h3 class="font-extrabold text-[#172B4D] text-base">Edit Artikel Blog</h3>
                        <p class="text-xs text-gray-500">Perbarui konten &amp; status publikasi artikel</p>
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
                        <label for="art_edit_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Judul Artikel *</label>
                        <input type="text" id="art_edit_title" name="title" x-model="editData.title" required
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="edit_article_category_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kategori Artikel</label>
                        <select id="edit_article_category_id" name="article_category_id" class="select2 w-full">
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="art_edit_slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Slug URL</label>
                        <input type="text" id="art_edit_slug" name="slug" x-model="editData.slug"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="art_edit_author" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Penulis</label>
                        <input type="text" id="art_edit_author" name="author_name" x-model="editData.author_name"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="edit_article_status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status Publikasi *</label>
                        <select id="edit_article_status" name="status" class="select2 w-full" required>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="art_edit_excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Ringkasan Artikel</label>
                    <textarea id="art_edit_excerpt" name="excerpt" rows="2" x-model="editData.excerpt"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"></textarea>
                </div>

                <div>
                    <label for="art_edit_content" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Isi Konten Artikel *</label>
                    <textarea id="art_edit_content" name="content" rows="5" x-model="editData.content" required
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"></textarea>
                </div>

                <div>
                    <label for="art_edit_thumbnail" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Ganti Gambar Sampul</label>
                    <input type="file" id="art_edit_thumbnail" name="thumbnail" accept="image/*"
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="editModal = false" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition cursor-pointer">
                        Batalkan
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#c4963e] hover:from-[#e3ba63] text-[#101D33] text-xs font-extrabold shadow-sm transition cursor-pointer flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Perbarui Artikel</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
