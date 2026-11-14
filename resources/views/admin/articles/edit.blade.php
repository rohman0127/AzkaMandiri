@extends('layouts.admin')

@section('title', 'Edit Artikel')
@section('breadcrumb', 'Artikel / Edit ' . $article->title)

@section('content')
<div class="w-full space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Edit Artikel</h2>
            <p class="text-xs text-gray-500">Perbarui konten artikel, thumbnail, atau kategori</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Lihat Web</span>
            </a>
            <a href="{{ route('admin.articles.index') }}" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Konten Artikel</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="sm:col-span-2">
                    <label for="title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Judul Artikel *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Slug URL</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $article->slug) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Category -->
                <div>
                    <label for="article_category_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori Artikel</label>
                    <select id="article_category_id" name="article_category_id"
                            class="select2 w-full">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('article_category_id', $article->article_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Author -->
                <div>
                    <label for="author_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Penulis</label>
                    <input type="text" id="author_name" name="author_name" value="{{ old('author_name', $article->author_name) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Status Publikasi *</label>
                    <select id="status" name="status" required
                            class="select2 w-full">
                        <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Terbitkan (Published)</option>
                        <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>

            <!-- Thumbnail -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Thumbnail Saat Ini</label>
                @if($article->thumbnail)
                    <div class="mb-3">
                        <img src="{{ $article->thumbnail }}" alt="{{ $article->title }}" class="h-28 w-40 object-cover rounded-xl border border-gray-200">
                    </div>
                @endif
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white hover:file:bg-[#101D33] file:cursor-pointer">
                <span class="text-[11px] text-gray-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah thumbnail.</span>
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Ringkasan Singkat (Excerpt)</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('excerpt', $article->excerpt) }}</textarea>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Isi Konten Artikel *</label>
                <textarea id="content" name="content" rows="12" required
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition font-sans">{{ old('content', $article->content) }}</textarea>
            </div>
        </div>

        <!-- SEO -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Pengaturan SEO Artikel</h3>

            <div>
                <label for="meta_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Meta Title</label>
                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $article->meta_title) }}"
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>
            <div>
                <label for="meta_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Meta Description</label>
                <textarea id="meta_description" name="meta_description" rows="2"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('meta_description', $article->meta_description) }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.articles.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-sm flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Perbarui Artikel</span>
            </button>
        </div>
    </form>
</div>
@endsection

