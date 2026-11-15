@extends('layouts.app')

@section('meta_title', 'Hubungi Kami – Kontak AzkaMandiri Aluminium & Kaca')
@section('meta_description', 'Hubungi AzkaMandiri untuk survei lokasi dan estimasi harga jasa pembuatan kusen aluminium, pintu sliding, dan partisi kaca di Jabodetabek.')

@section('content')
<!-- Header Banner -->
<section class="bg-[#101D33] text-white py-14 lg:py-20 relative overflow-hidden">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 text-center relative z-10 space-y-4">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-[#D6A84F] font-bold text-xs uppercase tracking-wider border border-white/10">
            <i data-lucide="phone" class="w-3.5 h-3.5"></i>
            <span>Layanan Kontak</span>
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
            Hubungi AzkaMandiri
        </h1>
        <p class="text-sm sm:text-base text-gray-300 max-w-2xl mx-auto">
            Diskusikan kebutuhan proyek Anda secara langsung dengan tim kami. Kami siap melayani survei dan konsultasi di seluruh wilayah Jabodetabek.
        </p>
    </div>
</section>

<!-- Contact Form and Details Section -->
<section class="py-16 lg:py-20 bg-[#F5F6F8]">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left Contact Info Details -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <span class="text-xs font-bold text-[#D6A84F] uppercase tracking-widest">Informasi Kontak</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#172B4D] tracking-tight mt-1">
                        Mari Terhubung dengan Kami
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-600 mt-2 leading-relaxed">
                        Silakan hubungi kami melalui saluran berikut atau isi formulir pesan di samping. Tim kami akan merespons secepat mungkin.
                    </p>
                </div>

                <div class="space-y-4">
                    <!-- WhatsApp Direct Card -->
                    <a href="{{ wa_link('Halo AzkaMandiri, saya ingin konsultasi dari halaman kontak website.') }}" target="_blank"
                       class="p-5 rounded-2xl bg-white border border-gray-200/80 shadow-xs hover:border-emerald-500 hover:shadow-md transition flex items-center gap-4 group">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                            <i data-lucide="message-circle" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase">Chat WhatsApp Cepat</p>
                            <p class="text-base font-bold text-[#172B4D] group-hover:text-emerald-600 transition">{{ setting('phone_number', '+62 812-3456-7890') }}</p>
                            <span class="text-[11px] text-emerald-600 font-semibold">Respon cepat setiap hari &rarr;</span>
                        </div>
                    </a>

                    <!-- Email Card -->
                    <div class="p-5 rounded-2xl bg-white border border-gray-200/80 shadow-xs flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i data-lucide="mail" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase">Email Pertanyaan</p>
                            <p class="text-sm font-bold text-[#172B4D]">{{ setting('email', 'kontak@azkamandiri.com') }}</p>
                        </div>
                    </div>

                    <!-- Address Card -->
                    <div class="p-5 rounded-2xl bg-white border border-gray-200/80 shadow-xs flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-[#D6A84F] flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="map-pin" class="w-6 h-6"></i>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs text-gray-400 font-semibold uppercase">Alamat Workshop</p>
                            <p class="text-xs sm:text-sm font-medium text-gray-800 leading-relaxed">{{ setting('address') }}</p>
                        </div>
                    </div>

                    <!-- Service Areas Card -->
                    <div class="p-5 rounded-2xl bg-white border border-gray-200/80 shadow-xs flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="navigation" class="w-6 h-6"></i>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs text-gray-400 font-semibold uppercase">Jangkauan Area</p>
                            <p class="text-xs sm:text-sm font-medium text-gray-800 leading-relaxed">{{ setting('service_areas') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Interactive Contact Form -->
            <div class="lg:col-span-7">
                <div class="bg-white p-8 sm:p-10 rounded-3xl border border-gray-200 shadow-xl space-y-6">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200/60 text-[#a3792b] text-[11px] font-bold tracking-wide uppercase mb-2">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                            <span>Formulir Terlindungi &amp; Terverifikasi</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#172B4D]">Kirim Pesan / Permintaan Penawaran</h3>
                        <p class="text-xs text-gray-500 mt-1">Isi formulir di bawah ini dan tim kami akan segera merespons Anda.</p>
                    </div>

                    {{-- SweetAlert2 Auto-Trigger Hooks --}}
                    @if(session('success'))
                        <div data-flash-success="{{ session('success') }}"></div>
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3 shadow-xs">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5"></i>
                            <div>
                                <p class="font-bold">Pesan Berhasil Terkirim!</p>
                                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div data-flash-error="{{ $errors->first() }}"></div>
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                            <div class="flex items-center gap-2 font-bold mb-1.5">
                                <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
                                <span>Mohon perbaiki data input berikut:</span>
                            </div>
                            <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5" x-data="{ charCount: {{ strlen(old('message', '')) }} }">
                        @csrf

                        {{-- Anti-Bot Honeypot Field --}}
                        <div class="honeypot-field" aria-hidden="true">
                            <label for="website_hp">Website Field (Jangan Diisi)</label>
                            <input type="text" id="website_hp" name="website_hp" tabindex="-1" autocomplete="off" value="">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                       minlength="3" maxlength="60" pattern="[a-zA-Z\s\.\,\'\-]{3,60}"
                                       title="Nama lengkap hanya boleh memuat huruf, spasi, dan tanda baca nama standar (min. 3 karakter)"
                                       autocomplete="name"
                                       class="w-full px-3.5 py-2.5 bg-gray-50 border @error('name') border-rose-500 bg-rose-50/20 text-rose-900 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                                       placeholder="Nama Lengkap Anda">
                                @error('name')
                                    <p class="text-xs text-rose-600 mt-1.5 flex items-center gap-1 font-medium">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone_number" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                    Nomor WhatsApp / HP <span class="text-rose-500">*</span>
                                </label>
                                <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                                       minlength="9" maxlength="16" pattern="^(\+62|62|0)8[1-9][0-9]{6,11}$"
                                       inputmode="tel" autocomplete="tel"
                                       title="Format nomor Indonesia, contoh: 081234567890 atau +6281234567890"
                                       class="w-full px-3.5 py-2.5 bg-gray-50 border @error('phone_number') border-rose-500 bg-rose-50/20 text-rose-900 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                                       placeholder="Contoh: 081234567890">
                                @error('phone_number')
                                    <p class="text-xs text-rose-600 mt-1.5 flex items-center gap-1 font-medium">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Email (Opsional)</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                       maxlength="100" autocomplete="email"
                                       class="w-full px-3.5 py-2.5 bg-gray-50 border @error('email') border-rose-500 bg-rose-50/20 text-rose-900 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                                       placeholder="email@example.com">
                                @error('email')
                                    <p class="text-xs text-rose-600 mt-1.5 flex items-center gap-1 font-medium">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="subject" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                    Subjek Kebutuhan <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                       minlength="3" maxlength="120"
                                       class="w-full px-3.5 py-2.5 bg-gray-50 border @error('subject') border-rose-500 bg-rose-50/20 text-rose-900 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                                       placeholder="Contoh: Pemasangan Jendela &amp; Pintu Sliding">
                                @error('subject')
                                    <p class="text-xs text-rose-600 mt-1.5 flex items-center gap-1 font-medium">
                                        <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="message" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Pesan &amp; Spesifikasi Proyek <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-[11px] font-semibold text-gray-400" x-text="charCount + ' / 2.500 karakter'"></span>
                            </div>
                            <textarea id="message" name="message" rows="5" required
                                      minlength="10" maxlength="2500"
                                      @input="charCount = $el.value.length"
                                      class="w-full px-3.5 py-2.5 bg-gray-50 border @error('message') border-rose-500 bg-rose-50/20 text-rose-900 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                                      placeholder="Jelaskan kebutuhan Anda, estimasi ukuran, lokasi proyek, atau pertanyaan lainnya (teks murni tanpa kode/file lampiran)...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-xs text-rose-600 mt-1.5 flex items-center gap-1 font-medium">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#b88d3b] hover:from-[#e0b45b] hover:to-[#c79a45] text-[#101D33] font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-[#D6A84F]/20 flex items-center justify-center gap-2 cursor-pointer">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            <span>Kirim Pesan Sekarang</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Google Maps Embed Section (Section 5.F) -->
        @if(setting('google_maps_embed'))
            <div class="mt-16 space-y-4">
                <h3 class="text-xl font-bold text-[#172B4D]">Peta Lokasi &amp; Wilayah Kerja</h3>
                <div class="rounded-3xl overflow-hidden border border-gray-200 shadow-md h-96 bg-gray-200">
                    <iframe src="{{ setting('google_maps_embed') }}" 
                            class="w-full h-full border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

