@extends('layouts.admin')

@section('title', 'Edit Testimoni')
@section('breadcrumb', 'Testimoni / Edit ' . $testimonial->client_name)

@section('content')
<div class="w-full space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Edit Testimoni</h2>
            <p class="text-xs text-gray-500">Perbarui ulasan kepuasan pelanggan</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="client_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Pelanggan *</label>
                <input type="text" id="client_name" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>

            <div>
                <label for="client_role" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pekerjaan / Lokasi</label>
                <input type="text" id="client_role" name="client_role" value="{{ old('client_role', $testimonial->client_role) }}"
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Foto Saat Ini</label>
            @if($testimonial->photo)
                <div class="mb-3">
                    <img src="{{ $testimonial->photo }}" alt="{{ $testimonial->client_name }}" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                </div>
            @endif
            <input type="file" id="photo" name="photo" accept="image/*"
                   class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white hover:file:bg-[#101D33] file:cursor-pointer">
            <span class="text-[11px] text-gray-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah foto.</span>
        </div>

        <div>
            <label for="content" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Isi Testimoni / Ulasan *</label>
            <textarea id="content" name="content" rows="4" required
                      class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('content', $testimonial->content) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 pt-2">
            <div>
                <label for="rating" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Rating Bintang (1 - 5) *</label>
                <select id="rating" name="rating" required
                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>5 Bintang</option>
                    <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>4 Bintang</option>
                    <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>3 Bintang</option>
                    <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>2 Bintang</option>
                    <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>1 Bintang</option>
                </select>
            </div>

            <div>
                <label for="sort_order" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Urutan Tampil</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order) }}"
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>

            <div class="flex items-center gap-3 pt-6">
                <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-gray-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-[#D6A84F] focus:ring-[#D6A84F] border-gray-300">
                    <span>Tampilkan di Web</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.testimonials.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-sm flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Perbarui Testimoni</span>
            </button>
        </div>
    </form>
</div>
@endsection

