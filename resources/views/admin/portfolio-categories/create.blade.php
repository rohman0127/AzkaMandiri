@extends('layouts.admin')

@section('title', 'Tambah Kategori Portofolio')
@section('breadcrumb', 'Kategori Portofolio / Tambah Baru')

@section('content')
<div class="w-full max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Tambah Kategori Portofolio</h2>
            <p class="text-xs text-gray-500">Buat klasifikasi proyek baru</p>
        </div>
        <a href="{{ route('admin.portfolio-categories.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.portfolio-categories.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Kategori *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                   placeholder="Contoh: Residensial &amp; Cluster">
        </div>

        <div>
            <label for="slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Slug URL (Opsional)</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                   class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                   placeholder="residensial">
        </div>

        <div>
            <label for="description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi Kategori</label>
            <textarea id="description" name="description" rows="3"
                      class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 pt-2">
            <div>
                <label for="sort_order" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Urutan Tampil</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>

            <div class="flex items-center gap-3 pt-6">
                <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                    <span>Status Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.portfolio-categories.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-sm flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Simpan Kategori</span>
            </button>
        </div>
    </form>
</div>
@endsection

