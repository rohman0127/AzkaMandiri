@extends('layouts.app')

@section('meta_title', 'Tentang Kami – Profil AzkaMandiri Jasa Aluminium & Kaca')
@section('meta_description', setting('meta_description', 'Mengenal profil AzkaMandiri, sejarah pengerjaan, visi, misi, dan nilai kerja kami sebagai spesialis pemasangan aluminium dan kaca.'))

@section('content')
<!-- Header Banner -->
<section class="bg-[#101D33] text-white py-16 lg:py-24 relative overflow-hidden">
    <div class="absolute inset-0 opacity-15 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-[#D6A84F]/30 blur-3xl"></div>
    </div>
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 text-center relative z-10 space-y-4">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-[#D6A84F] font-bold text-xs uppercase tracking-wider border border-white/10">
            <i data-lucide="info" class="w-3.5 h-3.5"></i>
            <span>Mengenal AzkaMandiri</span>
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
            Tentang AzkaMandiri
        </h1>
        <p class="text-sm sm:text-base text-gray-300 max-w-2xl mx-auto">
            Dedikasi pada kerapian, ketahanan material, dan presisi arsitektural aluminium &amp; kaca di Jabodetabek.
        </p>
    </div>
</section>

<!-- Company Profile Content -->
<section class="py-20 bg-white">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 space-y-20">
        <!-- Main Story -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-6">
                <span class="text-xs font-bold text-[#D6A84F] uppercase tracking-widest">Profil Usaha Mandiri</span>
                <h2 class="text-3xl font-extrabold text-[#172B4D] tracking-tight leading-tight">
                    Pengalaman &amp; Ketelitian dalam Setiap Sambungan Aluminium
                </h2>
                <div class="prose prose-sm text-gray-600 leading-relaxed space-y-4">
                    <p>
                        {{ setting('about_short') }}
                    </p>
                    <p>
                        {{ setting('business_history') }}
                    </p>
                    <p>
                        Kami melayani berbagai segmen pelanggan mulai dari pemilik rumah tinggal yang menginginkan tampilan modern minimalis, kontraktor interior, pemilik ruko komersial, hingga arsitek proyek gedung perkantoran.
                    </p>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <a href="{{ wa_link('Halo AzkaMandiri, saya membaca profil usaha Anda dan ingin berkonsultasi proyek.') }}" target="_blank"
                       class="px-6 py-3.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Konsultasi WhatsApp</span>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="rounded-3xl overflow-hidden border border-gray-200 shadow-xl bg-gray-100">
                    <img src="{{ asset('assets/images/services/jendela-aluminium.svg') }}" alt="Pengerjaan Aluminium AzkaMandiri" class="w-full h-96 object-cover">
                </div>
            </div>
        </div>

        <!-- Vision and Mission Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Visi -->
            <div class="bg-[#F5F6F8] p-8 sm:p-10 rounded-3xl border border-gray-200/80 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-[#172B4D] text-[#D6A84F] flex items-center justify-center font-bold">
                    <i data-lucide="eye" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-bold text-[#172B4D]">Visi Kami</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ setting('vision') }}
                </p>
            </div>

            <!-- Misi -->
            <div class="bg-[#F5F6F8] p-8 sm:p-10 rounded-3xl border border-gray-200/80 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-[#172B4D] text-[#D6A84F] flex items-center justify-center font-bold">
                    <i data-lucide="target" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-bold text-[#172B4D]">Misi Kami</h3>
                <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                    {{ setting('mission') }}
                </div>
            </div>
        </div>

        <!-- Work Values & Strengths -->
        <div class="space-y-10">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="text-xs font-bold text-[#D6A84F] uppercase tracking-widest">Standar Mutu</span>
                <h2 class="text-3xl font-extrabold text-[#172B4D]">Nilai &amp; Prinsip Kerja AzkaMandiri</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 bg-white rounded-2xl border border-gray-200 shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#D6A84F] flex items-center justify-center">
                        <i data-lucide="crosshair" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-[#172B4D]">Presisi Akurat</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Pengukuran berulang sebelum fabrikasi menjamin hasil fitting kusen tanpa celah kasar.</p>
                </div>

                <div class="p-6 bg-white rounded-2xl border border-gray-200 shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-[#172B4D]">Integritas Material</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Kami hanya menggunakan profil aluminium dan kaca bersertifikasi resmi tanpa menurunkan grade pesanan.</p>
                </div>

                <div class="p-6 bg-white rounded-2xl border border-gray-200 shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i data-lucide="circle-dollar-sign" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-[#172B4D]">Transparansi Biaya</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Penawaran RAB terperinci per meter lari atau unit sehingga pelanggan memahami alokasi anggaran.</p>
                </div>

                <div class="p-6 bg-white rounded-2xl border border-gray-200 shadow-xs space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <i data-lucide="phone-call" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-sm text-[#172B4D]">Layanan Responsif</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Respons cepat melalui chat WhatsApp setiap hari untuk memfasilitasi kebutuhan mendesak Anda.</p>
                </div>
            </div>
        </div>

        <!-- Sample Works Preview -->
        @if($sampleProjects->isNotEmpty())
            <div class="space-y-8 pt-8 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-[#172B4D]">Dokumentasi Lapangan</h3>
                        <p class="text-xs text-gray-500">Beberapa hasil instalasi terkini oleh tim teknisi kami</p>
                    </div>
                    <a href="{{ route('portfolios.index') }}" class="text-xs font-bold text-[#D6A84F] hover:underline flex items-center gap-1">
                        <span>Lihat Semua Proyek</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($sampleProjects as $proj)
                        <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-xs group">
                            <img src="{{ $proj->main_image ?: asset('assets/brand/logo-icon.svg') }}" alt="{{ $proj->title }}" class="w-full h-40 object-cover group-hover:scale-105 transition duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Bottom CTA -->
<section class="py-16 bg-[#172B4D] text-white text-center">
    <div class="max-w-4xl mx-auto px-4 space-y-6">
        <h2 class="text-3xl font-extrabold text-white">Ingin Mengetahui Lebih Jauh atau Menjadwalkan Survei?</h2>
        <p class="text-sm text-gray-300">Hubungi langsung teknisi kami melalui WhatsApp untuk konsultasi cepat dan estimasi harga.</p>
        <div>
            <a href="{{ wa_link('Halo AzkaMandiri, saya ingin berkonsultasi mengenai jasa aluminium dan kaca.') }}" target="_blank"
               class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs uppercase tracking-wider transition shadow-lg">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                <span>Hubungi Kami via WhatsApp</span>
            </a>
        </div>
    </div>
</section>
@endsection

