@extends('layouts.admin')

@section('title', 'Edit Portofolio Proyek')
@section('breadcrumb', 'Portofolio / Edit ' . $portfolio->title)

@section('content')
<div class="w-full max-w-5xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Edit Portofolio: {{ $portfolio->title }}</h2>
            <p class="text-xs text-gray-500">Perbarui dokumentasi dan foto hasil proyek</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('portfolios.show', $portfolio->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Lihat Web</span>
            </a>
            <a href="{{ route('admin.portfolios.index') }}" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.portfolios.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Informasi Proyek</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama / Judul Proyek *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $portfolio->title) }}" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Slug URL</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $portfolio->slug) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Category -->
                <div>
                    <label for="portfolio_category_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori Proyek</label>
                    <select id="portfolio_category_id" name="portfolio_category_id"
                            class="select2 w-full">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('portfolio_category_id', $portfolio->portfolio_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Client Name -->
                <div>
                    <label for="client_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Klien / Pemilik</label>
                    <input type="text" id="client_name" name="client_name" value="{{ old('client_name', $portfolio->client_name) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Lokasi Pengerjaan</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $portfolio->location) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <!-- Year -->
                <div>
                    <label for="completion_year" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tahun Selesai</label>
                    <input type="text" id="completion_year" name="completion_year" value="{{ old('completion_year', $portfolio->completion_year) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Ringkasan Pekerjaan (Excerpt)</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('excerpt', $portfolio->excerpt) }}</textarea>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi Lengkap Hasil Proyek</label>
                <textarea id="description" name="description" rows="5"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('description', $portfolio->description) }}</textarea>
            </div>
        </div>

        <!-- Images Section -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Foto Proyek</h3>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Foto Utama Saat Ini</label>
                @if($portfolio->main_image)
                    <div class="mb-3">
                        <img src="{{ $portfolio->main_image }}" alt="{{ $portfolio->title }}" class="h-28 w-40 object-cover rounded-xl border border-gray-200">
                    </div>
                @endif
                <input type="file" id="main_image" name="main_image" accept="image/*"
                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white hover:file:bg-[#101D33] file:cursor-pointer">
                <span class="text-[11px] text-gray-400 mt-1 block">Biarkan kosong jika tidak ingin mengganti foto utama.</span>
            </div>

            <!-- Current Gallery -->
            @if($portfolio->images->isNotEmpty())
                <div class="pt-4 border-t border-gray-100">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Galeri Foto Tersimpan</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach($portfolio->images as $img)
                            <div class="relative group rounded-xl overflow-hidden border border-gray-200">
                                <img src="{{ $img->image_path }}" alt="Galeri" class="w-full h-28 object-cover">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <button type="button" 
                                            onclick="if(confirm('Hapus foto ini dari galeri?')) document.getElementById('delete-port-gal-{{ $img->id }}').submit();"
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

        <!-- Settings & Status -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Status &amp; Tampilan</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="sort_order" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Urutan Tampil</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $portfolio->sort_order) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div class="flex items-center gap-3 pt-6">
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $portfolio->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                        <span>Portofolio Aktif</span>
                    </label>
                </div>

                <div class="flex items-center gap-3 pt-6">
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                        <span>Proyek Unggulan (Beranda)</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <label for="meta_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Meta Title SEO</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $portfolio->meta_title) }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
                <div>
                    <label for="meta_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Meta Description SEO</label>
                    <textarea id="meta_description" name="meta_description" rows="2"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('meta_description', $portfolio->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.portfolios.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-sm flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Perbarui Portofolio</span>
            </button>
        </div>
    </form>

    <!-- Hidden forms for single gallery deletions -->
    @foreach($portfolio->images as $img)
        <form id="delete-port-gal-{{ $img->id }}" action="{{ route('admin.portfolios.gallery.delete', $img->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
</div>
@endsection

