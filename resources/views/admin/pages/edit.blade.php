@extends('layouts.admin')

@section('title', 'Edit Halaman Statis')
@section('breadcrumb', 'Halaman Statis / Edit ' . $page->title)

@section('content')
<div class="w-full max-w-5xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Edit Halaman: {{ $page->title }}</h2>
            <p class="text-xs text-gray-500">Perbarui isi konten halaman statis</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Lihat Web</span>
            </a>
            <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Judul Halaman *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $page->title) }}" required
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>

            <div>
                <label for="slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Slug URL</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $page->slug) }}"
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>
        </div>

        <div>
            <label for="content" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Isi Dokumen / Konten *</label>
            <textarea id="content" name="content" rows="10" required
                      class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition font-sans">{{ old('content', $page->content) }}</textarea>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                <span>Halaman Aktif (Dapat Diakses Publik)</span>
            </label>
        </div>

        <div class="space-y-4 pt-4 border-t border-gray-100">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">SEO Halaman</h4>
            <div>
                <label for="meta_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Meta Title</label>
                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>
            <div>
                <label for="meta_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Meta Description</label>
                <textarea id="meta_description" name="meta_description" rows="2"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('meta_description', $page->meta_description) }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-sm flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Perbarui Halaman</span>
            </button>
        </div>
    </form>
</div>
@endsection

