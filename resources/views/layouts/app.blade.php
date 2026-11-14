<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Dynamic SEO Metadata -->
    <title>@yield('meta_title', setting('meta_title', 'AzkaMandiri – Jasa Aluminium & Kaca Berkualitas'))</title>
    <meta name="description" content="@yield('meta_description', setting('meta_description', 'Jasa pembuatan & pemasangan kusen aluminium, jendela, pintu, partisi kaca tempered, kanopi kaca terpercaya.'))">
    <meta name="keywords" content="@yield('meta_keywords', setting('meta_keywords', 'kusen aluminium, jendela aluminium, pintu aluminium, kaca tempered'))">
    <meta name="author" content="AzkaMandiri">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('meta_title', setting('meta_title', 'AzkaMandiri – Jasa Aluminium & Kaca'))">
    <meta property="og:description" content="@yield('meta_description', setting('meta_description', 'Jasa pembuatan & pemasangan kusen aluminium, jendela, pintu, partisi kaca.'))">
    <meta property="og:image" content="@yield('og_image', asset(setting('og_image_path', 'assets/brand/logo-horizontal.svg')))">
    <meta property="og:site_name" content="AzkaMandiri">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta_title', setting('meta_title', 'AzkaMandiri'))">
    <meta name="twitter:description" content="@yield('meta_description', setting('meta_description'))">
    <meta name="twitter:image" content="@yield('og_image', asset(setting('og_image_path', 'assets/brand/logo-horizontal.svg')))">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset(setting('favicon_path', 'assets/brand/favicon.svg')) }}">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <!-- Schema.org JSON-LD LocalBusiness -->
    <script type="application/ld+json">
    {
      "{{ '@context' }}": "https://schema.org",
      "{{ '@type' }}": "HomeAndConstructionBusiness",
      "name": "{{ setting('site_name', 'AzkaMandiri') }}",
      "image": "{{ asset(setting('logo_path', 'assets/brand/logo-horizontal.svg')) }}",
      "url": "{{ url('/') }}",
      "telephone": "{{ setting('phone_number', '+6281234567890') }}",
      "priceRange": "$$",
      "address": {
        "{{ '@type' }}": "PostalAddress",
        "streetAddress": "{{ setting('address', 'Tangerang Selatan') }}",
        "addressLocality": "Tangerang Selatan",
        "addressRegion": "Banten",
        "postalCode": "15414",
        "addressCountry": "ID"
      },
      "geo": {
        "{{ '@type' }}": "GeoCoordinates",
        "latitude": -6.30835,
        "longitude": 106.68060
      },
      "openingHoursSpecification": {
        "{{ '@type' }}": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        "opens": "08:00",
        "closes": "17:00"
      }
    }
    </script>
</head>
<body class="bg-white text-[#343A40] font-sans antialiased selection:bg-[#D6A84F] selection:text-[#101D33] min-h-screen flex flex-col justify-between"
      x-data="{ mobileMenuOpen: false, scrolled: false }"
      x-on:scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Top Announcement Strip -->
    <div class="bg-[#101D33] text-gray-300 text-xs py-2 px-4 sm:px-6 lg:px-10 xl:px-14 border-b border-white/5">
        <div class="w-full flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5 text-gray-300">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>Area Layanan: Jabodetabek &amp; Sekitarnya</span>
                </span>
                <span class="hidden md:inline-flex items-center gap-1.5 text-gray-400">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>{{ setting('business_hours', 'Senin - Sabtu: 08.00 - 17.00') }}</span>
                </span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ wa_link() }}" target="_blank" class="text-gray-300 hover:text-[#D6A84F] transition flex items-center gap-1 font-medium">
                    <i data-lucide="phone" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>{{ setting('phone_number', '+62 812-3456-7890') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 transition-all duration-300"
            :class="scrolled ? 'bg-[#172B4D]/95 backdrop-blur-md shadow-lg py-3 border-b border-white/10' : 'bg-[#172B4D] py-4 border-b border-white/5'">
        <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
            <div class="flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group transition">
                    <img src="{{ asset(setting('logo_dark_path', 'assets/brand/logo-horizontal-dark.svg')) }}" 
                         alt="{{ setting('site_name', 'AzkaMandiri') }}" 
                         class="h-10 sm:h-12 w-auto transition-transform group-hover:scale-102">
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" 
                       class="text-sm font-semibold transition py-1 relative {{ request()->routeIs('home') ? 'text-[#D6A84F] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#D6A84F]' : 'text-gray-200 hover:text-white' }}">
                        Home
                    </a>
                    <a href="{{ route('about') }}" 
                       class="text-sm font-semibold transition py-1 relative {{ request()->routeIs('about') ? 'text-[#D6A84F] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#D6A84F]' : 'text-gray-200 hover:text-white' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('services.index') }}" 
                       class="text-sm font-semibold transition py-1 relative {{ request()->routeIs('services.*') ? 'text-[#D6A84F] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#D6A84F]' : 'text-gray-200 hover:text-white' }}">
                        Layanan
                    </a>
                    <a href="{{ route('portfolios.index') }}" 
                       class="text-sm font-semibold transition py-1 relative {{ request()->routeIs('portfolios.*') ? 'text-[#D6A84F] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#D6A84F]' : 'text-gray-200 hover:text-white' }}">
                        Portofolio
                    </a>
                    <a href="{{ route('articles.index') }}" 
                       class="text-sm font-semibold transition py-1 relative {{ request()->routeIs('articles.*') ? 'text-[#D6A84F] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#D6A84F]' : 'text-gray-200 hover:text-white' }}">
                        Artikel
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="text-sm font-semibold transition py-1 relative {{ request()->routeIs('contact') ? 'text-[#D6A84F] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#D6A84F]' : 'text-gray-200 hover:text-white' }}">
                        Kontak
                    </a>
                </nav>

                <!-- Header CTA Button -->
                <div class="hidden lg:flex items-center gap-4">
                    <a href="{{ wa_link('Halo AzkaMandiri, saya ingin konsultasi gratis mengenai kebutuhan aluminium dan kaca bangunan saya.') }}" 
                       target="_blank"
                       class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#b88d3b] hover:from-[#e0b45b] hover:to-[#c79a45] text-[#101D33] font-bold text-xs uppercase tracking-wider transition shadow-md shadow-[#D6A84F]/20 flex items-center gap-2 group">
                        <i data-lucide="message-circle" class="w-4 h-4 transition-transform group-hover:scale-110"></i>
                        <span>Hubungi Kami</span>
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="lg:hidden flex items-center gap-3">
                    <a href="{{ wa_link() }}" target="_blank" class="p-2 rounded-lg bg-[#D6A84F] text-[#101D33] font-bold text-xs">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="p-2 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 transition"
                            aria-label="Toggle navigation">
                        <i x-show="!mobileMenuOpen" data-lucide="menu" class="w-6 h-6"></i>
                        <i x-show="mobileMenuOpen" data-lucide="x" class="w-6 h-6" style="display: none;"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="lg:hidden pt-4 pb-6 border-t border-white/10 mt-3 space-y-2"
                 style="display: none;">
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                   class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('home') ? 'bg-[#D6A84F] text-[#101D33]' : 'text-gray-200 hover:bg-white/5' }}">
                    Home
                </a>
                <a href="{{ route('about') }}" @click="mobileMenuOpen = false"
                   class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('about') ? 'bg-[#D6A84F] text-[#101D33]' : 'text-gray-200 hover:bg-white/5' }}">
                    Tentang Kami
                </a>
                <a href="{{ route('services.index') }}" @click="mobileMenuOpen = false"
                   class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('services.*') ? 'bg-[#D6A84F] text-[#101D33]' : 'text-gray-200 hover:bg-white/5' }}">
                    Layanan
                </a>
                <a href="{{ route('portfolios.index') }}" @click="mobileMenuOpen = false"
                   class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('portfolios.*') ? 'bg-[#D6A84F] text-[#101D33]' : 'text-gray-200 hover:bg-white/5' }}">
                    Portofolio
                </a>
                <a href="{{ route('articles.index') }}" @click="mobileMenuOpen = false"
                   class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('articles.*') ? 'bg-[#D6A84F] text-[#101D33]' : 'text-gray-200 hover:bg-white/5' }}">
                    Artikel
                </a>
                <a href="{{ route('contact') }}" @click="mobileMenuOpen = false"
                   class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('contact') ? 'bg-[#D6A84F] text-[#101D33]' : 'text-gray-200 hover:bg-white/5' }}">
                    Kontak
                </a>

                <div class="pt-3">
                    <a href="{{ wa_link('Halo AzkaMandiri, saya ingin konsultasi dari website.') }}" 
                       target="_blank"
                       class="w-full py-3 px-4 rounded-xl bg-[#D6A84F] text-[#101D33] font-bold text-xs uppercase tracking-wider text-center flex items-center justify-center gap-2">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Konsultasi WhatsApp Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Dynamic Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Floating WhatsApp Action Button -->
    <aside class="fixed bottom-6 right-6 z-50 flex items-center group">
        <a href="{{ wa_link('Halo AzkaMandiri, saya ingin konsultasi cepat mengenai pemasangan aluminium dan kaca.') }}" 
           target="_blank"
           aria-label="Konsultasi WhatsApp AzkaMandiri"
           class="relative flex items-center justify-center w-14 h-14 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full shadow-2xl transition-all duration-300 group-hover:scale-110">
            <!-- Pulsing Halo Effect -->
            <span class="absolute -inset-1 rounded-full bg-emerald-500/40 animate-ping pointer-events-none"></span>
            <i data-lucide="message-circle" class="w-7 h-7 relative z-10 fill-current"></i>
        </a>
        <div class="absolute right-16 mr-3 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap bg-[#101D33] text-white text-xs font-bold py-1.5 px-3 rounded-lg shadow-xl border border-white/10 hidden sm:block">
            Konsultasi WhatsApp Langsung
        </div>
    </aside>

    <!-- Footer -->
    <footer class="bg-[#101D33] text-gray-300 pt-16 pb-12 border-t border-white/5">
        <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Col 1: Brand Info -->
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="inline-block">
                        <img src="{{ asset(setting('logo_dark_path', 'assets/brand/logo-horizontal-dark.svg')) }}" 
                             alt="{{ setting('site_name', 'AzkaMandiri') }}" class="h-10 w-auto">
                    </a>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        {{ setting('about_short', 'AzkaMandiri adalah penyedia jasa pemasangan, pembuatan, dan fabrikasi aluminium serta kaca berkualitas untuk kebutuhan rumah tinggal, ruko, kantor, dan gedung.') }}
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        @if(setting('instagram_url'))
                            <a href="{{ setting('instagram_url') }}" target="_blank" aria-label="Instagram" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-[#D6A84F] hover:text-[#101D33] text-gray-300 flex items-center justify-center transition">
                                <i data-lucide="instagram" class="w-4 h-4"></i>
                            </a>
                        @endif
                        @if(setting('facebook_url'))
                            <a href="{{ setting('facebook_url') }}" target="_blank" aria-label="Facebook" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-[#D6A84F] hover:text-[#101D33] text-gray-300 flex items-center justify-center transition">
                                <i data-lucide="facebook" class="w-4 h-4"></i>
                            </a>
                        @endif
                        @if(setting('tiktok_url'))
                            <a href="{{ setting('tiktok_url') }}" target="_blank" aria-label="TikTok" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-[#D6A84F] hover:text-[#101D33] text-gray-300 flex items-center justify-center transition">
                                <i data-lucide="video" class="w-4 h-4"></i>
                            </a>
                        @endif
                        @if(setting('youtube_url'))
                            <a href="{{ setting('youtube_url') }}" target="_blank" aria-label="YouTube" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-[#D6A84F] hover:text-[#101D33] text-gray-300 flex items-center justify-center transition">
                                <i data-lucide="youtube" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Navigasi Utama</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-[#D6A84F] transition">Beranda</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-[#D6A84F] transition">Tentang Kami</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-[#D6A84F] transition">Layanan Aluminium &amp; Kaca</a></li>
                        <li><a href="{{ route('portfolios.index') }}" class="hover:text-[#D6A84F] transition">Portofolio Proyek</a></li>
                        <li><a href="{{ route('articles.index') }}" class="hover:text-[#D6A84F] transition">Artikel &amp; Edukasi</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-[#D6A84F] transition">Kontak &amp; Alamat</a></li>
                    </ul>
                </div>

                <!-- Col 3: Services Quick Links -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Layanan Unggulan</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ url('/layanan/kusen-aluminium') }}" class="hover:text-[#D6A84F] transition">Kusen Aluminium 3" &amp; 4"</a></li>
                        <li><a href="{{ url('/layanan/jendela-aluminium') }}" class="hover:text-[#D6A84F] transition">Jendela Casement &amp; Sliding</a></li>
                        <li><a href="{{ url('/layanan/pintu-aluminium') }}" class="hover:text-[#D6A84F] transition">Pintu Swing &amp; Folding Lipat</a></li>
                        <li><a href="{{ url('/layanan/partisi-aluminium') }}" class="hover:text-[#D6A84F] transition">Partisi Kantor &amp; Sekat Ruko</a></li>
                        <li><a href="{{ url('/layanan/kaca-tempered') }}" class="hover:text-[#D6A84F] transition">Kaca Tempered Safety 8-12mm</a></li>
                        <li><a href="{{ url('/layanan/kanopi-kaca') }}" class="hover:text-[#D6A84F] transition">Kanopi Kaca Carport Modern</a></li>
                        <li><a href="{{ url('/layanan/shower-box') }}" class="hover:text-[#D6A84F] transition">Shower Box Kamar Mandi</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact & Workshop -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Kontak &amp; Workshop</h3>
                    <div class="space-y-3 text-xs text-gray-400">
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-[#D6A84F] shrink-0 mt-0.5"></i>
                            <span>{{ setting('address', 'Jl. Aria Putra No. 45, Sarua Indah, Ciputat, Tangerang Selatan') }}</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400 shrink-0"></i>
                            <a href="{{ wa_link() }}" target="_blank" class="hover:text-white transition font-medium">
                                {{ setting('phone_number', '+62 812-3456-7890') }}
                            </a>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="mail" class="w-4 h-4 text-[#D6A84F] shrink-0"></i>
                            <a href="mailto:{{ setting('email', 'kontak@azkamandiri.com') }}" class="hover:text-white transition">
                                {{ setting('email', 'kontak@azkamandiri.com') }}
                            </a>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="clock" class="w-4 h-4 text-[#D6A84F] shrink-0 mt-0.5"></i>
                            <span>{{ setting('business_hours', 'Senin - Sabtu: 08.00 - 17.00 WIB') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Legal & Copyright -->
            <div class="pt-12 mt-12 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} <strong>{{ setting('site_name', 'AzkaMandiri') }}</strong> – Jasa Aluminium &amp; Kaca. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ url('/halaman/kebijakan-privasi') }}" class="hover:text-gray-400 transition">Kebijakan Privasi</a>
                    <a href="{{ url('/halaman/syarat-ketentuan') }}" class="hover:text-gray-400 transition">Syarat &amp; Ketentuan</a>
                    <a href="{{ route('admin.login') }}" class="hover:text-[#D6A84F] transition">Login Admin</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.renderIcons) {
                window.renderIcons();
            }
        });
    </script>
</body>
</html>
