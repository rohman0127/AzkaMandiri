@extends('layouts.admin')

@section('title', 'Profil & Pengaturan Website')
@section('breadcrumb', 'Pengaturan / Profil & Informasi Usaha')

@section('content')
<div class="w-full max-w-5xl space-y-6">
    <div>
        <h2 class="text-xl font-extrabold text-[#172B4D]">Profil &amp; Informasi Website</h2>
        <p class="text-xs text-gray-500">Kelola identitas brand, kontak WhatsApp, alamat, dan narasi profil AzkaMandiri</p>
    </div>

    <form action="{{ route('admin.settings.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Brand Identity & Logo -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Identitas Usaha &amp; Logo</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="site_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Brand / Usaha *</label>
                    <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'AzkaMandiri') }}" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div>
                    <label for="brand_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Brand Title Lengkap *</label>
                    <input type="text" id="brand_title" name="brand_title" value="{{ old('brand_title', $settings['brand_title'] ?? 'AzkaMandiri – Jasa Aluminium & Kaca') }}" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div>
                    <label for="tagline" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tagline / Slogan</label>
                    <input type="text" id="tagline" name="tagline" value="{{ old('tagline', $settings['tagline'] ?? 'Solusi Aluminium & Kaca untuk Hunian dan Bangunan Anda') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div>
                    <label for="business_type" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jenis Bidang Usaha</label>
                    <input type="text" id="business_type" name="business_type" value="{{ old('business_type', $settings['business_type'] ?? 'Jasa Pemasangan & Pembuatan Aluminium, Kaca & Custom Bangunan') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
            </div>

            <!-- Logo Uploaders -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 border-t border-gray-100">
                <!-- Light Logo -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Logo (Background Terang)</label>
                    @if(!empty($settings['logo_path']))
                        <div class="p-3 bg-gray-100 rounded-xl mb-3 flex items-center justify-center border border-gray-200">
                            <img src="{{ $settings['logo_path'] }}" alt="Logo" class="h-10 max-w-full">
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white">
                </div>

                <!-- Dark Logo -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Logo (Background Gelap)</label>
                    @if(!empty($settings['logo_dark_path']))
                        <div class="p-3 bg-[#101D33] rounded-xl mb-3 flex items-center justify-center border border-gray-800">
                            <img src="{{ $settings['logo_dark_path'] }}" alt="Logo Dark" class="h-10 max-w-full">
                        </div>
                    @endif
                    <input type="file" name="logo_dark" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white">
                </div>

                <!-- Favicon -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Favicon Browser</label>
                    @if(!empty($settings['favicon_path']))
                        <div class="p-3 bg-gray-100 rounded-xl mb-3 flex items-center justify-center border border-gray-200">
                            <img src="{{ $settings['favicon_path'] }}" alt="Favicon" class="w-8 h-8">
                        </div>
                    @endif
                    <input type="file" name="favicon" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#172B4D] file:text-white">
                </div>
            </div>
        </div>

        <!-- Contact & Service Areas -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Kontak &amp; Wilayah Kerja</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="whatsapp_number" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nomor WhatsApp *</label>
                    <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '6281234567890') }}" required
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="Contoh: 6281234567890">
                    <span class="text-[11px] text-gray-400 mt-1 block">Gunakan kode negara (62...) tanpa tanda +.</span>
                </div>

                <div>
                    <label for="phone_number" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Telepon Tampilan</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $settings['phone_number'] ?? '+62 812-3456-7890') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="+62 812-3456-7890">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Email Usaha</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $settings['email'] ?? 'kontak@azkamandiri.com') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="address" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alamat Workshop / Kantor</label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('address', $settings['address'] ?? '') }}</textarea>
                </div>

                <div>
                    <label for="service_areas" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Area / Wilayah Layanan</label>
                    <textarea id="service_areas" name="service_areas" rows="3"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('service_areas', $settings['service_areas'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="business_hours" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jam Operasional</label>
                    <input type="text" id="business_hours" name="business_hours" value="{{ old('business_hours', $settings['business_hours'] ?? '') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div>
                    <label for="google_maps_embed" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Google Maps Embed URL</label>
                    <input type="text" id="google_maps_embed" name="google_maps_embed" value="{{ old('google_maps_embed', $settings['google_maps_embed'] ?? '') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="https://www.google.com/maps/embed?...">
                </div>
            </div>
        </div>

        <!-- Narasi Profil, Sejarah, Visi, Misi -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Profil, Sejarah, Visi &amp; Misi</h3>

            <div>
                <label for="about_short" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Ringkasan Profil (Tentang Kami)</label>
                <textarea id="about_short" name="about_short" rows="3"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('about_short', $settings['about_short'] ?? '') }}</textarea>
            </div>

            <div>
                <label for="business_history" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Sejarah Usaha</label>
                <textarea id="business_history" name="business_history" rows="4"
                          class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('business_history', $settings['business_history'] ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="vision" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Visi Usaha</label>
                    <textarea id="vision" name="vision" rows="4"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('vision', $settings['vision'] ?? '') }}</textarea>
                </div>

                <div>
                    <label for="mission" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Misi Usaha</label>
                    <textarea id="mission" name="mission" rows="4"
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">{{ old('mission', $settings['mission'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Tautan Media Sosial</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="instagram_url" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Instagram URL</label>
                    <input type="text" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div>
                    <label for="facebook_url" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Facebook URL</label>
                    <input type="text" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div>
                    <label for="tiktok_url" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">TikTok URL</label>
                    <input type="text" id="tiktok_url" name="tiktok_url" value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>

                <div>
                    <label for="youtube_url" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">YouTube URL</label>
                    <input type="text" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="px-7 py-3 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-md flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Simpan Seluruh Pengaturan Website</span>
            </button>
        </div>
    </form>
</div>
@endsection

