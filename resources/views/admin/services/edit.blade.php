@extends('layouts.admin')

@section('title', 'Edit Layanan')
@section('breadcrumb', 'Katalog Layanan / Edit ' . $service->name)

@section('content')
<div class="w-full max-w-5xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Edit Layanan: {{ $service->name }}</h2>
            <p class="text-xs text-gray-500">Perbarui informasi, spesifikasi, atau foto galeri layanan</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Lihat Web</span>
            </a>
            <a href="{{ route('admin.services.index') }}" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Informasi Utama</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Layanan *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Slug URL</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $service->slug) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Category -->
                <div>
                    <label for="service_category_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori Layanan</label>
                    <select id="service_category_id" name="service_category_id"
                            class="select2 w-full">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('service_category_id', $service->service_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Info -->
                <div>
                    <label for="price_info" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Informasi Harga / Estimasi</label>
                    <input type="text" id="price_info" name="price_info" value="{{ old('price_info', $service->price_info) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Ringkasan Singkat (Excerpt)</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('excerpt', $service->excerpt) }}</textarea>
            </div>

            <!-- Full Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi Lengkap Layanan</label>
                <textarea id="description" name="description" rows="6"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('description', $service->description) }}</textarea>
            </div>

            <!-- Features -->
            @php
                $featuresText = is_array($service->features) ? implode("\n", $service->features) : $service->features;
            @endphp
            <div>
                <label for="features" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Fitur / Keunggulan (Pisahkan Tiap Baris)</label>
                <textarea id="features" name="features" rows="4"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition font-mono text-xs">{{ old('features', $featuresText) }}</textarea>
            </div>
        </div>

        <!-- Images Section -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Foto &amp; Galeri Layanan</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Thumbnail -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Thumbnail Saat Ini</label>
                    @if($service->thumbnail)
                        <div class="mb-3">
                            <img src="{{ $service->thumbnail }}" alt="{{ $service->name }}" class="h-24 w-32 object-cover rounded-xl border border-gray-200">
                        </div>
                    @endif
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white hover:file:bg-[#101D33] file:cursor-pointer">
                    <span class="text-[11px] text-gray-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah foto.</span>
                </div>

                <!-- Main Image -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Foto Utama Saat Ini</label>
                    @if($service->main_image)
                        <div class="mb-3">
                            <img src="{{ $service->main_image }}" alt="{{ $service->name }}" class="h-24 w-32 object-cover rounded-xl border border-gray-200">
                        </div>
                    @endif
                    <input type="file" id="main_image" name="main_image" accept="image/*"
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white hover:file:bg-[#101D33] file:cursor-pointer">
                    <span class="text-[11px] text-gray-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah foto.</span>
                </div>
            </div>

            <!-- Current Gallery -->
            @if($service->images->isNotEmpty())
                <div class="pt-4 border-t border-gray-100">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Galeri Foto Tersimpan</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach($service->images as $img)
                            <div class="relative group rounded-xl overflow-hidden border border-gray-200">
                                <img src="{{ $img->image_path }}" alt="Galeri" class="w-full h-28 object-cover">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <button type="button" 
                                            onclick="if(confirm('Hapus foto ini dari galeri?')) document.getElementById('delete-gal-{{ $img->id }}').submit();"
                                            class="p-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Add More Gallery Images -->
            <div class="pt-4 border-t border-gray-100">
                <label for="gallery" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tambah Foto Galeri Baru</label>
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
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Status Checkbox -->
                <div class="flex items-center gap-3 pt-6">
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                        <span>Layanan Aktif</span>
                    </label>
                </div>

                <!-- Featured Checkbox -->
                <div class="flex items-center gap-3 pt-6">
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                        <span>Tampilkan di Beranda (Unggulan)</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <label for="meta_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Custom Meta Title (SEO)</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $service->meta_title) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
                <div>
                    <label for="meta_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Custom Meta Description (SEO)</label>
                    <textarea id="meta_description" name="meta_description" rows="2"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('meta_description', $service->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-md flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Perbarui Layanan</span>
            </button>
        </div>
    </form>

    <!-- Hidden forms for single gallery deletions -->
    @foreach($service->images as $img)
        <form id="delete-gal-{{ $img->id }}" action="{{ route('admin.services.gallery.delete', $img->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
</div>
@endsection

