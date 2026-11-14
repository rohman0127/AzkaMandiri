@extends('layouts.app')

@section('meta_title', setting('site_name', 'AzkaMandiri') . ' – Jasa Aluminium & Kaca Berkualitas dan Profesional')
@section('meta_description', setting('meta_description', 'Layanan pembuatan dan pemasangan kusen aluminium, jendela, pintu, partisi, kaca tempered, kanopi kaca, dan shower box terpercaya di Jabodetabek.'))

@section('content')
<!-- HERO SECTION -->
<section class="relative bg-gradient-to-b from-[#101D33] via-[#172B4D] to-[#101D33] text-white pt-16 pb-24 lg:pt-24 lg:pb-32 overflow-hidden">
    <!-- Ambient architectural elements -->
    <div class="absolute inset-0 pointer-events-none opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-[#D6A84F]/30 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-blue-500/20 blur-3xl"></div>
    </div>

    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Headline & CTA -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/10 text-xs font-semibold text-[#D6A84F]">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                    <span>Jasa Spesialis Aluminium &amp; Kaca Terpercaya</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-[1.15] tracking-tight">
                    Solusi Aluminium &amp; Kaca untuk <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#D6A84F] to-[#f3dfb2]">Hunian dan Bangunan Anda</span>
                </h1>

                <p class="text-base sm:text-lg text-gray-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    AzkaMandiri hadir memberikan layanan pemasangan, pembuatan, dan pengerjaan aluminium serta kaca berkualitas dengan hasil rapi, presisi tinggi, dan garansi profesional.
                </p>

                <!-- Hero Action Buttons -->
                <div class="pt-4 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ wa_link('Halo AzkaMandiri, saya ingin berkonsultasi mengenai kebutuhan aluminium dan kaca untuk bangunan saya.') }}" 
                       target="_blank"
                       class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#b88d3b] hover:from-[#e0b45b] hover:to-[#c79a45] text-[#101D33] font-bold text-sm tracking-wide shadow-lg shadow-[#D6A84F]/25 transition duration-200 flex items-center justify-center gap-2.5">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                        <span>Konsultasi Sekarang</span>
                    </a>

                    <a href="{{ route('portfolios.index') }}" 
                       class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-sm transition duration-200 flex items-center justify-center gap-2">
                        <i data-lucide="eye" class="w-4 h-4 text-[#D6A84F]"></i>
                        <span>Lihat Portofolio</span>
                    </a>
                </div>

                <!-- Highlight Micro-Stats -->
                <div class="pt-6 grid grid-cols-3 gap-4 border-t border-white/10 max-w-lg mx-auto lg:mx-0">
                    <div>
                        <p class="text-2xl font-extrabold text-[#D6A84F]">100%</p>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider mt-0.5">Material SNI</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-[#D6A84F]">Presisi</p>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider mt-0.5">Tukang Berpengalaman</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-[#D6A84F]">Gratis</p>
                        <p class="text-[11px] text-gray-400 uppercase tracking-wider mt-0.5">Survei &amp; Konsultasi</p>
                    </div>
                </div>
            </div>

            <!-- Right Architectural Showcase Card -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none rounded-3xl overflow-hidden border border-white/15 bg-white/5 backdrop-blur-xl p-3 shadow-2xl">
                    <img src="{{ asset('assets/images/services/pintu-aluminium.svg') }}" 
                         alt="Instalasi Aluminium & Kaca AzkaMandiri" 
                         class="w-full h-80 sm:h-96 lg:h-[460px] object-cover rounded-2xl shadow-inner">
                    <div class="p-4 bg-[#101D33]/90 backdrop-blur-md rounded-xl mt-3 flex items-center justify-between border border-white/10">
                        <div>
                            <p class="text-xs font-bold text-white">Fabrikasi Presisi &amp; Rapi</p>
                            <p class="text-[11px] text-gray-400">Pintu, Jendela, Kusen &amp; Kaca Tempered</p>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-[#D6A84F]/20 text-[#D6A84F] text-[10px] font-bold uppercase tracking-wider border border-[#D6A84F]/30">
                            Garansi Pasang
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TRUST INDICATORS (SECTION 5.A.3) -->
<section class="bg-[#F5F6F8] py-10 border-b border-gray-200">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-center">
            <div class="flex flex-col items-center gap-2 p-3">
                <div class="w-12 h-12 rounded-2xl bg-white text-[#D6A84F] shadow-xs flex items-center justify-center border border-gray-200">
                    <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-sm text-[#172B4D]">Pengerjaan Rapi</h3>
                <p class="text-xs text-gray-500">Sudut miter rapat dan finishing halus</p>
            </div>

            <div class="flex flex-col items-center gap-2 p-3">
                <div class="w-12 h-12 rounded-2xl bg-white text-[#D6A84F] shadow-xs flex items-center justify-center border border-gray-200">
                    <i data-lucide="layers" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-sm text-[#172B4D]">Material Berkualitas</h3>
                <p class="text-xs text-gray-500">Merek Alexindo, YKK, Dacon resmi</p>
            </div>

            <div class="flex flex-col items-center gap-2 p-3">
                <div class="w-12 h-12 rounded-2xl bg-white text-[#D6A84F] shadow-xs flex items-center justify-center border border-gray-200">
                    <i data-lucide="badge-percent" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-sm text-[#172B4D]">Harga Kompetitif</h3>
                <p class="text-xs text-gray-500">Transparan tanpa biaya tersembunyi</p>
            </div>

            <div class="flex flex-col items-center gap-2 p-3">
                <div class="w-12 h-12 rounded-2xl bg-white text-[#D6A84F] shadow-xs flex items-center justify-center border border-gray-200">
                    <i data-lucide="message-square" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-sm text-[#172B4D]">Konsultasi Gratis</h3>
                <p class="text-xs text-gray-500">Diskusi teknis &amp; survei lokasi</p>
            </div>

            <div class="flex flex-col items-center gap-2 p-3 col-span-2 md:col-span-1">
                <div class="w-12 h-12 rounded-2xl bg-white text-[#D6A84F] shadow-xs flex items-center justify-center border border-gray-200">
                    <i data-lucide="heart-handshake" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-sm text-[#172B4D]">Kepuasan Pelanggan</h3>
                <p class="text-xs text-gray-500">Prioritas utama setiap pengerjaan</p>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT PREVIEW SECTION -->
<section class="py-20 bg-white">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 relative">
                <div class="relative rounded-3xl overflow-hidden shadow-xl border border-gray-200">
                    <img src="{{ asset('assets/images/services/kusen-aluminium.svg') }}" alt="Tentang AzkaMandiri" class="w-full h-80 sm:h-96 object-cover">
                </div>
                <div class="absolute -bottom-6 -right-4 sm:right-6 bg-[#172B4D] text-white p-5 rounded-2xl shadow-xl border border-white/10 max-w-xs">
                    <p class="text-xs uppercase tracking-wider text-[#D6A84F] font-bold">Keahlian &amp; Presisi</p>
                    <p class="text-xs text-gray-300 mt-1">Spesialis pengerjaan aluminium dan kaca custom sejak tahun-tahun berpengalaman.</p>
                </div>
            </div>

            <div class="lg:col-span-6 space-y-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-[#a97e2c] font-bold text-xs uppercase tracking-wider">
                    <i data-lucide="building-2" class="w-3.5 h-3.5"></i>
                    <span>Tentang AzkaMandiri</span>
                </div>

                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#172B4D] tracking-tight leading-tight">
                    Mitra Terpercaya untuk Pembuatan &amp; Pemasangan Aluminium Kaca
                </h2>

                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                    {{ setting('about_short', 'AzkaMandiri bergerak di bidang jasa pemasangan dan pembuatan aluminium, kaca, serta pekerjaan custom untuk kebutuhan bangunan rumah tinggal, ruko, kantor, dan gedung.') }}
                </p>

                <p class="text-sm text-gray-600 leading-relaxed">
                    Kami memadukan teknik fabrikasi presisi dengan material berkualitas tinggi agar setiap pintu, jendela, partisi, maupun kaca kanopi memiliki daya tahan maksimal, kedap terhadap cuaca, serta menambah nilai estetika properti Anda.
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <a href="{{ route('about') }}" class="px-6 py-3 rounded-xl bg-[#172B4D] hover:bg-[#101D33] text-white font-bold text-xs tracking-wider transition flex items-center gap-2">
                        <span>Selengkapnya Tentang Kami</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ wa_link('Halo AzkaMandiri, saya ingin tanya-tanya profil dan portofolio layanan.') }}" target="_blank"
                       class="px-6 py-3 rounded-xl border border-gray-300 hover:bg-gray-50 text-[#172B4D] font-bold text-xs tracking-wider transition flex items-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-600"></i>
                        <span>Tanya Tim Kami</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES PREVIEW SECTION -->
<section class="py-20 bg-[#F5F6F8]">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-14">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-xs uppercase tracking-wider">
                <i data-lucide="wrench" class="w-3.5 h-3.5"></i>
                <span>Layanan Utama</span>
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#172B4D] tracking-tight">
                Pilihan Layanan Aluminium &amp; Kaca Berkualitas
            </h2>
            <p class="text-sm sm:text-base text-gray-600">
                Solusi komprehensif mulai dari kusen, jendela, pintu, partisi ruangan hingga kaca tempered struktural.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <!-- Thumbnail Image -->
                    <div class="relative h-52 overflow-hidden bg-gray-100">
                        <img src="{{ $service->thumbnail ?: ($service->main_image ?: asset('assets/brand/logo-icon.svg')) }}" 
                             alt="{{ $service->name }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @if($service->category)
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#101D33]/80 backdrop-blur-md text-white text-[10px] font-bold tracking-wider uppercase border border-white/10">
                                {{ $service->category->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <h3 class="text-lg font-bold text-[#172B4D] group-hover:text-[#D6A84F] transition">
                                <a href="{{ route('services.show', $service->slug) }}">
                                    {{ $service->name }}
                                </a>
                            </h3>
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                {{ $service->excerpt }}
                            </p>
                        </div>

                        <!-- Price Info -->
                        @if($service->price_info)
                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                                <span class="text-gray-400">Estimasi Biaya:</span>
                                <span class="font-bold text-[#172B4D]">{{ $service->price_info }}</span>
                            </div>
                        @endif

                        <!-- Card Actions -->
                        <div class="pt-2 flex items-center gap-2">
                            <a href="{{ route('services.show', $service->slug) }}" 
                               class="flex-1 py-2.5 px-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-[#172B4D] text-xs font-bold text-center transition">
                                Detail Layanan
                            </a>
                            <a href="{{ wa_service_link($service->name) }}" target="_blank"
                               class="p-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold transition shrink-0"
                               title="Pesan lewat WhatsApp">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('services.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl bg-[#172B4D] hover:bg-[#101D33] text-white text-xs font-bold uppercase tracking-wider transition shadow-md">
                <span>Lihat Seluruh 10+ Layanan Kami</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="py-20 bg-white">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-5 space-y-6">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold text-xs uppercase tracking-wider">
                    <i data-lucide="award" class="w-3.5 h-3.5"></i>
                    <span>Keunggulan Kami</span>
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#172B4D] tracking-tight leading-tight">
                    Mengapa Memilih AzkaMandiri untuk Proyek Anda?
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Kami memahami bahwa pintu, jendela, dan sekat kaca adalah investasi jangka panjang untuk kenyamanan dan keamanan properti Anda.
                </p>

                <div class="space-y-4 pt-2">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#D6A84F]/20 text-[#D6A84F] flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-[#172B4D]">Potongan Miter Presisi 45 Derajat</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Sudut sambungan kusen rapat sempurna tanpa celah angin dan air hujan.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#D6A84F]/20 text-[#D6A84F] flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-[#172B4D]">Hardware &amp; Aksesoris Heavy-Duty</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Menggunakan kunci Dekkson/Kinlong, engsel tanam, dan rel stainless 304 anti karat.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#D6A84F]/20 text-[#D6A84F] flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-[#172B4D]">Survei Lapangan &amp; Konsultasi Transparan</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Pengukuran langsung di lokasi Anda serta rincian biaya yang jelas dan adil.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="p-6 rounded-3xl bg-[#F5F6F8] border border-gray-200/80 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-[#172B4D] text-[#D6A84F] flex items-center justify-center font-bold">
                        <i data-lucide="shield" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-[#172B4D]">Garansi Pemasangan</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Kami menjamin setiap hasil pemasangan bebas dari kebocoran sealant air hujan dan macet engsel.
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-[#F5F6F8] border border-gray-200/80 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-[#172B4D] text-[#D6A84F] flex items-center justify-center font-bold">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-[#172B4D]">Tepat Waktu (On Time)</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Jadwal fabrikasi terstruktur memastikan proyek selesai sesuai tenggat waktu yang disepakati.
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-[#F5F6F8] border border-gray-200/80 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-[#172B4D] text-[#D6A84F] flex items-center justify-center font-bold">
                        <i data-lucide="sparkles" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-[#172B4D]">Finishing Rapi &amp; Bersih</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Pekerjaan instalasi diselesaikan dengan pembersihan area kerja sehingga langsung siap pakai.
                    </p>
                </div>

                <div class="p-6 rounded-3xl bg-[#F5F6F8] border border-gray-200/80 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-[#172B4D] text-[#D6A84F] flex items-center justify-center font-bold">
                        <i data-lucide="settings" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-[#172B4D]">Pekerjaan Custom Fleksibel</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Menyesuaikan gambar rancangan arsitek, interior designer, maupun sketsa kebutuhan Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PORTFOLIO PREVIEW SECTION -->
<section class="py-20 bg-[#101D33] text-white">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
            <div class="space-y-3 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-[#D6A84F] font-bold text-xs uppercase tracking-wider border border-white/10">
                    <i data-lucide="images" class="w-3.5 h-3.5"></i>
                    <span>Hasil Pekerjaan</span>
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Portofolio Proyek AzkaMandiri
                </h2>
                <p class="text-sm text-gray-300">
                    Bukti nyata kerapian instalasi kusen, partisi kantor, pintu sliding, dan kanopi kaca kami.
                </p>
            </div>
            <a href="{{ route('portfolios.index') }}" class="px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs uppercase tracking-wider transition flex items-center gap-2 shrink-0">
                <span>Semua Portofolio</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($portfolios as $portfolio)
                <div class="bg-[#172B4D]/90 rounded-3xl border border-white/10 overflow-hidden shadow-xl group flex flex-col justify-between">
                    <div class="relative h-60 overflow-hidden bg-gray-900">
                        <img src="{{ $portfolio->main_image ?: asset('assets/brand/logo-icon.svg') }}" 
                             alt="{{ $portfolio->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#101D33] via-transparent to-transparent opacity-80"></div>
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#101D33]/90 text-[#D6A84F] text-[10px] font-bold uppercase tracking-wider border border-white/10">
                            {{ $portfolio->category ? $portfolio->category->name : 'Proyek' }}
                        </span>
                    </div>

                    <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 text-xs text-gray-400 mb-1">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                                <span>{{ $portfolio->location ?: 'Jabodetabek' }}</span>
                            </div>
                            <h3 class="text-base font-bold text-white group-hover:text-[#D6A84F] transition">
                                <a href="{{ route('portfolios.show', $portfolio->slug) }}">
                                    {{ $portfolio->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-gray-400 mt-2 line-clamp-2">
                                {{ $portfolio->excerpt }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                            <a href="{{ route('portfolios.show', $portfolio->slug) }}" class="text-xs font-bold text-[#D6A84F] hover:underline flex items-center gap-1">
                                <span>Lihat Dokumentasi</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <a href="{{ wa_portfolio_link($portfolio->title, $portfolio->location) }}" target="_blank"
                               class="text-xs text-gray-400 hover:text-white flex items-center gap-1" title="Tanya proyek ini">
                                <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>Pesan Serupa</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- HOW IT WORKS (ALUR KERJA) -->
<section class="py-20 bg-white">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-[#a97e2c] font-bold text-xs uppercase tracking-wider">
                <i data-lucide="git-commit" class="w-3.5 h-3.5"></i>
                <span>Cara Kerja Praktis</span>
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#172B4D] tracking-tight">
                Alur Pemesanan Mudah &amp; Cepat
            </h2>
            <p class="text-sm sm:text-base text-gray-600">
                4 langkah teratur untuk mewujudkan instalasi aluminium dan kaca idaman Anda
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <!-- Step 1 -->
            <div class="bg-[#F5F6F8] p-6 rounded-3xl border border-gray-200/80 text-center space-y-3 relative group hover:bg-[#172B4D] hover:text-white transition duration-300">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#D6A84F] text-[#101D33] font-extrabold text-lg flex items-center justify-center shadow-md">
                    1
                </div>
                <h3 class="text-base font-bold text-[#172B4D] group-hover:text-white transition">Konsultasi Kebutuhan</h3>
                <p class="text-xs text-gray-500 group-hover:text-gray-300 transition leading-relaxed">
                    Hubungi kami via WhatsApp atau formulir web untuk menjelaskan jenis pintu, jendela, atau kaca yang Anda perlukan.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-[#F5F6F8] p-6 rounded-3xl border border-gray-200/80 text-center space-y-3 relative group hover:bg-[#172B4D] hover:text-white transition duration-300">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#D6A84F] text-[#101D33] font-extrabold text-lg flex items-center justify-center shadow-md">
                    2
                </div>
                <h3 class="text-base font-bold text-[#172B4D] group-hover:text-white transition">Survei &amp; Estimasi</h3>
                <p class="text-xs text-gray-500 group-hover:text-gray-300 transition leading-relaxed">
                    Tim teknis kami melakukan pengukuran akurat di lokasi Anda dan memberikan rincian penawaran harga terbaik.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-[#F5F6F8] p-6 rounded-3xl border border-gray-200/80 text-center space-y-3 relative group hover:bg-[#172B4D] hover:text-white transition duration-300">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#D6A84F] text-[#101D33] font-extrabold text-lg flex items-center justify-center shadow-md">
                    3
                </div>
                <h3 class="text-base font-bold text-[#172B4D] group-hover:text-white transition">Fabrikasi Presisi</h3>
                <p class="text-xs text-gray-500 group-hover:text-gray-300 transition leading-relaxed">
                    Pemotongan profil aluminium dan kaca di workshop dengan standar mutu tinggi dan kontrol kerapian teliti.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="bg-[#F5F6F8] p-6 rounded-3xl border border-gray-200/80 text-center space-y-3 relative group hover:bg-[#172B4D] hover:text-white transition duration-300">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-[#D6A84F] text-[#101D33] font-extrabold text-lg flex items-center justify-center shadow-md">
                    4
                </div>
                <h3 class="text-base font-bold text-[#172B4D] group-hover:text-white transition">Pemasangan &amp; Serah Terima</h3>
                <p class="text-xs text-gray-500 group-hover:text-gray-300 transition leading-relaxed">
                    Instalasi di lokasi oleh teknisi ahli, uji fungsi hardware, penyegelan kedap air, dan serah terima garansi.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section class="py-20 bg-[#F5F6F8]">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-14">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold text-xs uppercase tracking-wider">
                <i data-lucide="quote" class="w-3.5 h-3.5"></i>
                <span>Ulasan Klien</span>
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#172B4D] tracking-tight">
                Apa Kata Pelanggan AzkaMandiri?
            </h2>
            <p class="text-sm sm:text-base text-gray-600">
                Komitmen kami terhadap kerapian dan integritas material menciptakan kepuasan pelanggan sejati.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($testimonials as $testi)
                <div class="bg-white p-8 rounded-3xl border border-gray-200/80 shadow-xs flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-1 text-amber-400">
                            @for($i = 1; $i <= $testi->rating; $i++)
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            @endfor
                        </div>
                        <p class="text-xs sm:text-sm text-gray-600 italic leading-relaxed">
                            "{{ $testi->content }}"
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center gap-3">
                        @if($testi->photo)
                            <img src="{{ $testi->photo }}" alt="{{ $testi->client_name }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-[#172B4D] text-[#D6A84F] font-bold text-xs flex items-center justify-center">
                                {{ strtoupper(substr($testi->client_name, 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-bold text-[#172B4D]">{{ $testi->client_name }}</p>
                            <p class="text-xs text-gray-400">{{ $testi->client_role }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- RECENT ARTICLES PREVIEW -->
@if($recentArticles->isNotEmpty())
<section class="py-20 bg-white">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-50 text-purple-700 font-bold text-xs uppercase tracking-wider mb-3">
                    <i data-lucide="newspaper" class="w-3.5 h-3.5"></i>
                    <span>Edukasi &amp; Panduan</span>
                </span>
                <h2 class="text-3xl font-extrabold text-[#172B4D]">Artikel &amp; Tips Terbaru</h2>
            </div>
            <a href="{{ route('articles.index') }}" class="text-xs font-bold text-[#D6A84F] hover:underline flex items-center gap-1">
                <span>Lihat Semua Artikel</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($recentArticles as $art)
                <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden shadow-xs hover:shadow-lg transition flex flex-col group">
                    <div class="h-48 overflow-hidden bg-gray-100">
                        <img src="{{ $art->thumbnail ?: asset('assets/brand/logo-icon.svg') }}" alt="{{ $art->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-[11px] text-gray-400 font-semibold">{{ $art->published_at ? $art->published_at->format('d F Y') : '' }}</span>
                            <h3 class="text-base font-bold text-[#172B4D] group-hover:text-[#D6A84F] transition mt-1 line-clamp-2">
                                <a href="{{ route('articles.show', $art->slug) }}">{{ $art->title }}</a>
                            </h3>
                            <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $art->excerpt }}</p>
                        </div>
                        <a href="{{ route('articles.show', $art->slug) }}" class="text-xs font-bold text-[#172B4D] hover:text-[#D6A84F] flex items-center gap-1 pt-2">
                            <span>Baca Selengkapnya</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA WHATSAPP BANNER (SECTION 5.A.10) -->
<section class="py-16 bg-gradient-to-r from-[#172B4D] via-[#101D33] to-[#172B4D] text-white">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 text-center space-y-6">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-[#D6A84F] text-xs font-bold uppercase tracking-wider border border-white/10">
            <i data-lucide="sparkles" class="w-4 h-4"></i>
            <span>Konsultasi Cepat Tanpa Ribet</span>
        </div>
        <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight max-w-3xl mx-auto leading-tight">
            Punya Rencana Pemasangan Aluminium &amp; Kaca? Konsultasikan Sekarang!
        </h2>
        <p class="text-sm sm:text-base text-gray-300 max-w-2xl mx-auto leading-relaxed">
            Dapatkan rekomendasi profil material terbaik, estimasi hitungan anggaran, dan jadwal survei gratis langsung dari teknisi AzkaMandiri.
        </p>
        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ wa_link('Halo AzkaMandiri, saya ingin mendiskusikan rencana pemasangan aluminium dan kaca. Apakah bisa dibantu?') }}" target="_blank"
               class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#b88d3b] hover:from-[#e0b45b] hover:to-[#c79a45] text-[#101D33] font-bold text-sm uppercase tracking-wider transition shadow-xl shadow-[#D6A84F]/20 flex items-center justify-center gap-2.5">
                <i data-lucide="message-circle" class="w-5 h-5"></i>
                <span>Hubungi via WhatsApp ({{ setting('phone_number', '+62 812-3456-7890') }})</span>
            </a>
            <a href="{{ route('contact') }}"
               class="w-full sm:w-auto px-8 py-4 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-sm transition flex items-center justify-center gap-2">
                <i data-lucide="mail" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Formulir Kontak Web</span>
            </a>
        </div>
    </div>
</section>
@endsection

