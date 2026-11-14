@extends('layouts.admin')

@section('title', 'Pengaturan SEO & Meta')
@section('breadcrumb', 'Pengaturan / Optimasi Mesin Pencari (SEO)')

@section('content')
<div class="w-full space-y-6">
    <div>
        <h2 class="text-xl font-extrabold text-[#172B4D]">Pengaturan SEO &amp; Open Graph</h2>
        <p class="text-xs text-gray-500">Kelola metadata bawaan website untuk mesin pencari Google dan media sosial</p>
    </div>

    <form action="{{ route('admin.settings.seo.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Default Metadata Global</h3>

            <div>
                <label for="meta_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Default Meta Title *</label>
                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $settings['meta_title'] ?? '') }}" required
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                <span class="text-[11px] text-gray-400 mt-1 block">Rekomendasi panjang: 50–60 karakter.</span>
            </div>

            <div>
                <label for="meta_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Default Meta Description *</label>
                <textarea id="meta_description" name="meta_description" rows="3" required
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                <span class="text-[11px] text-gray-400 mt-1 block">Rekomendasi panjang: 150–160 karakter untuk snippet Google.</span>
            </div>

            <div>
                <label for="meta_keywords" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Keywords / Kata Kunci</label>
                <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}"
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                       placeholder="kusen aluminium, jendela aluminium, pintu aluminium, partisi kaca">
            </div>

            <div class="pt-4 border-t border-gray-100">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Gambar Open Graph (Social Share Preview)</label>
                @if(!empty($settings['og_image_path']))
                    <div class="mb-3">
                        <img src="{{ $settings['og_image_path'] }}" alt="OG Preview" class="h-28 w-48 object-cover rounded-xl border border-gray-200">
                    </div>
                @endif
                <input type="file" name="og_image" accept="image/*"
                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white hover:file:bg-[#101D33] file:cursor-pointer">
                <span class="text-[11px] text-gray-400 mt-1 block">Ukuran rekomendasi: 1200 x 630 piksel.</span>
            </div>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Sitemap &amp; Robots.txt</h3>

            <div class="space-y-2">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl text-xs">
                    <div>
                        <span class="font-bold text-gray-800">Sitemap XML Otomatis:</span>
                        <a href="{{ url('/sitemap.xml') }}" target="_blank" class="text-[#D6A84F] hover:underline font-mono ml-2">{{ url('/sitemap.xml') }}</a>
                    </div>
                    <a href="{{ url('/sitemap.xml') }}" target="_blank" class="text-gray-500 hover:text-gray-900">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl text-xs">
                    <div>
                        <span class="font-bold text-gray-800">Robots.txt Otomatis:</span>
                        <a href="{{ url('/robots.txt') }}" target="_blank" class="text-[#D6A84F] hover:underline font-mono ml-2">{{ url('/robots.txt') }}</a>
                    </div>
                    <a href="{{ url('/robots.txt') }}" target="_blank" class="text-gray-500 hover:text-gray-900">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <div>
                <label for="custom_robots_txt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kustomisasi Robots.txt (Opsional)</label>
                <textarea id="custom_robots_txt" name="custom_robots_txt" rows="5"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-mono text-gray-800 focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                          placeholder="Kosongkan untuk menggunakan aturan standar...">{{ old('custom_robots_txt', $settings['custom_robots_txt'] ?? '') }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-sm flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Simpan Pengaturan SEO</span>
            </button>
        </div>
    </form>
</div>
@endsection

