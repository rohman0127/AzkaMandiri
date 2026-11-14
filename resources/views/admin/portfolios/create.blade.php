@extends('layouts.admin')

@section('title', 'Tambah Portofolio Proyek')
@section('breadcrumb', 'Portofolio / Tambah Proyek Baru')

@section('content')
<div class="w-full max-w-5xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Tambah Portofolio Proyek</h2>
            <p class="text-xs text-gray-500">Unggah dokumentasi hasil pekerjaan aluminium atau kaca</p>
        </div>
        <a href="{{ route('admin.portfolios.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Informasi Proyek</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama / Judul Proyek *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="Contoh: Pemasangan Pintu Lipat Aluminium 6 Daun">
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Slug URL (Opsional)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="otomatis dari judul">
                </div>

                <!-- Category -->
                <div>
                    <label for="portfolio_category_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori Proyek</label>
                    <select id="portfolio_category_id" name="portfolio_category_id"
                            class="select2 w-full">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('portfolio_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Client Name -->
                <div>
                    <label for="client_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Klien / Pemilik</label>
                    <input type="text" id="client_name" name="client_name" value="{{ old('client_name') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="Contoh: Bpk. Hendra / PT Sinergi">
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Lokasi Pengerjaan</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="Contoh: Cluster Greenwich Park, BSD City">
                </div>

                <!-- Year -->
                <div>
                    <label for="completion_year" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tahun Selesai</label>
                    <input type="text" id="completion_year" name="completion_year" value="{{ old('completion_year', date('Y')) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Ringkasan Pekerjaan (Excerpt)</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('excerpt') }}</textarea>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi Lengkap Hasil Proyek</label>
                <textarea id="description" name="description" rows="5"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('description') }}</textarea>
            </div>
        </div>

        <!-- Images Section -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Foto Proyek</h3>

            <div>
                <label for="main_image" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Foto Utama Proyek</label>
                <input type="file" id="main_image" name="main_image" accept="image/*"
                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white hover:file:bg-[#101D33] file:cursor-pointer">
            </div>

            <div>
                <label for="gallery" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Galeri Foto Tambahan (Bisa Pilih Banyak)</label>
                <input type="file" id="gallery" name="gallery[]" multiple accept="image/*"
                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#D6A84F] file:text-[#101D33] hover:file:bg-[#c4963e] file:cursor-pointer">
            </div>
        </div>

        <!-- Settings & Status -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Status &amp; Tampilan</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="sort_order" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Urutan Tampil</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div class="flex items-center gap-3 pt-6">
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                        <span>Portofolio Aktif</span>
                    </label>
                </div>

                <div class="flex items-center gap-3 pt-6">
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                        <span>Proyek Unggulan (Beranda)</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <label for="meta_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Meta Title SEO</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
                <div>
                    <label for="meta_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Meta Description SEO</label>
                    <textarea id="meta_description" name="meta_description" rows="2"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.portfolios.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-sm flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Simpan Portofolio</span>
            </button>
        </div>
    </form>
</div>
@endsection

