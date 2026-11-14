@extends('layouts.admin')

@section('title', 'Tambah Layanan Baru')
@section('breadcrumb', 'Katalog Layanan / Tambah Baru')

@section('content')
<div class="w-full space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Tambah Layanan Baru</h2>
            <p class="text-xs text-gray-500">Lengkapi form berikut untuk menambahkan layanan aluminium atau kaca</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Informasi Utama</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Layanan *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="Contoh: Kusen Aluminium Alexindo">
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Slug URL (Opsional)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="otomatis dari nama jika dikosongkan">
                </div>

                <!-- Category -->
                <div>
                    <label for="service_category_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori Layanan</label>
                    <select id="service_category_id" name="service_category_id"
                            class="select2 w-full">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('service_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Info -->
                <div>
                    <label for="price_info" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Informasi Harga / Estimasi</label>
                    <input type="text" id="price_info" name="price_info" value="{{ old('price_info') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="Contoh: Mulai Rp 120.000 / m lari">
                </div>
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Ringkasan Singkat (Excerpt)</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                          placeholder="Deskripsi singkat yang tampil pada kartu layanan di beranda...">{{ old('excerpt') }}</textarea>
            </div>

            <!-- Full Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi Lengkap Layanan</label>
                <textarea id="description" name="description" rows="6"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition font-sans"
                          placeholder="Tuliskan spesifikasi detail material, kelebihan, metode kerja, dan aplikasi ruangan...">{{ old('description') }}</textarea>
            </div>

            <!-- Features -->
            <div>
                <label for="features" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Fitur / Keunggulan (Pisahkan Tiap Baris)</label>
                <textarea id="features" name="features" rows="4"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition font-mono text-xs"
                          placeholder="Pilihan Profil 3&quot; dan 4&quot;&#10;Merek Alexindo &amp; YKK&#10;Anti Rayap &amp; Karat&#10;Garansi Pemasangan Rapi">{{ old('features') }}</textarea>
                <span class="text-[11px] text-gray-400 mt-1 block">Tulis 1 poin fitur per baris.</span>
            </div>
        </div>

        <!-- Images Section -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Foto &amp; Galeri Layanan</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Thumbnail -->
                <div>
                    <label for="thumbnail" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Thumbnail Kartu (JPG, PNG, WebP, SVG)</label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white hover:file:bg-[#101D33] file:cursor-pointer">
                </div>

                <!-- Main Image -->
                <div>
                    <label for="main_image" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Foto Utama Halaman Detail</label>
                    <input type="file" id="main_image" name="main_image" accept="image/*"
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white hover:file:bg-[#101D33] file:cursor-pointer">
                </div>
            </div>

            <!-- Gallery Images -->
            <div>
                <label for="gallery" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Upload Multiple Galeri Foto (Dapat Pilih Lebih dari 1 Foto)</label>
                <input type="file" id="gallery" name="gallery[]" multiple accept="image/*"
                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#D6A84F] file:text-[#101D33] hover:file:bg-[#c4963e] file:cursor-pointer">
            </div>
        </div>

        <!-- SEO & Status -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Pengaturan Tampilan &amp; SEO</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Urutan Tampil</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Status Checkbox -->
                <div class="flex items-center gap-3 pt-6">
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                        <span>Layanan Aktif</span>
                    </label>
                </div>

                <!-- Featured Checkbox -->
                <div class="flex items-center gap-3 pt-6">
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                        <span>Tampilkan di Beranda (Unggulan)</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <label for="meta_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Custom Meta Title (SEO)</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
                <div>
                    <label for="meta_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Custom Meta Description (SEO)</label>
                    <textarea id="meta_description" name="meta_description" rows="2"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-md flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Simpan Layanan</span>
            </button>
        </div>
    </form>
</div>
@endsection

