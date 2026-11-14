<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') – AzkaMandiri Control Panel</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/brand/favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-[#F5F6F8] text-[#343A40] min-h-screen antialiased flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-black/60 z-40 lg:hidden" 
         style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-[#101D33] text-gray-300 flex flex-col transition-transform duration-300 ease-in-out border-r border-white/5">
        
        <!-- Sidebar Brand Header -->
        <div class="h-18 flex items-center justify-between px-6 border-b border-white/10 bg-[#0a1322]/80">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/brand/logo-icon.svg') }}" alt="AzkaMandiri" class="w-8 h-8 shrink-0">
                <div class="leading-tight">
                    <span class="font-extrabold text-white text-base tracking-tight">AZKA<span class="text-[#D6A84F]">MANDIRI</span></span>
                    <span class="block text-[10px] text-[#D6A84F] uppercase tracking-wider font-semibold">Admin Panel</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Navigation Menu Links -->
        <div class="flex-1 overflow-y-auto px-4 py-5 space-y-6 scrollbar-thin scrollbar-thumb-white/10">
            <!-- Main Group -->
            <div>
                <p class="px-3 text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Utama</p>
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 shrink-0"></i>
                        <span>Dashboard</span>
                    </a>
                </nav>
            </div>

            <!-- Content Management Group -->
            <div>
                <p class="px-3 text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Katalog &amp; Konten</p>
                <nav class="space-y-1">
                    <a href="{{ route('admin.services.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.services.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="wrench" class="w-4 h-4 shrink-0"></i>
                        <span>Layanan</span>
                    </a>
                    <a href="{{ route('admin.service-categories.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.service-categories.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="folder-tree" class="w-4 h-4 shrink-0"></i>
                        <span>Kategori Layanan</span>
                    </a>
                    <a href="{{ route('admin.portfolios.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.portfolios.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="images" class="w-4 h-4 shrink-0"></i>
                        <span>Portofolio</span>
                    </a>
                    <a href="{{ route('admin.portfolio-categories.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.portfolio-categories.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="folder" class="w-4 h-4 shrink-0"></i>
                        <span>Kategori Portofolio</span>
                    </a>
                    <a href="{{ route('admin.articles.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.articles.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="newspaper" class="w-4 h-4 shrink-0"></i>
                        <span>Artikel Blog</span>
                    </a>
                    <a href="{{ route('admin.article-categories.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.article-categories.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="tag" class="w-4 h-4 shrink-0"></i>
                        <span>Kategori Artikel</span>
                    </a>
                    <a href="{{ route('admin.testimonials.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="quote" class="w-4 h-4 shrink-0"></i>
                        <span>Testimoni</span>
                    </a>
                    <a href="{{ route('admin.pages.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.pages.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="file-text" class="w-4 h-4 shrink-0"></i>
                        <span>Halaman Statis</span>
                    </a>
                </nav>
            </div>

            <!-- Inquiries & Settings -->
            <div>
                <p class="px-3 text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Pesan &amp; Sistem</p>
                <nav class="space-y-1">
                    @php
                        $unreadCount = \App\Models\ContactMessage::unread()->count();
                    @endphp
                    <a href="{{ route('admin.contact-messages.index') }}"
                       class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.contact-messages.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <i data-lucide="mail" class="w-4 h-4 shrink-0"></i>
                            <span>Pesan Masuk</span>
                        </div>
                        @if($unreadCount > 0)
                            <span class="px-2 py-0.5 text-xs font-bold bg-amber-500 text-black rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.settings.profile') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.settings.profile') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="building-2" class="w-4 h-4 shrink-0"></i>
                        <span>Profil &amp; Kontak</span>
                    </a>

                    <a href="{{ route('admin.settings.seo') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.settings.seo') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="search" class="w-4 h-4 shrink-0"></i>
                        <span>Pengaturan SEO</span>
                    </a>

                    <a href="{{ route('admin.profile.edit') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.profile.edit') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="shield-check" class="w-4 h-4 shrink-0"></i>
                        <span>Akun Administrator</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Sidebar Footer Action -->
        <div class="p-4 border-t border-white/10 bg-[#0a1322]/80 space-y-2">
            <a href="{{ url('/') }}" target="_blank"
               class="flex items-center justify-center gap-2 w-full py-2 px-3 rounded-xl bg-white/5 hover:bg-white/10 text-xs font-semibold text-gray-300 hover:text-white transition">
                <i data-lucide="external-link" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                <span>Lihat Website Utama</span>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="flex items-center justify-center gap-2 w-full py-2 px-3 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-xs font-semibold text-red-300 hover:text-red-200 transition">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 lg:pl-64">
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-gray-200 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-xs">
            <div class="flex items-center gap-4 min-w-0">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-gray-600 hover:bg-gray-100 shrink-0">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
                <div class="min-w-0">
                    <div class="hidden sm:block mb-1">
                        @include('partials.admin.breadcrumbs')
                    </div>
                    <h1 class="text-lg sm:text-xl font-extrabold text-[#172B4D] leading-tight truncate">@yield('title', 'Dashboard')</h1>
                </div>
            </div>

            <div class="flex items-center gap-4 shrink-0">
                <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition shadow-2xs">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>Lihat Website</span>
                </a>

                <div class="flex items-center gap-3 pl-3 border-l border-gray-200">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#172B4D] to-[#101D33] text-[#D6A84F] font-black text-xs flex items-center justify-center shadow-xs border border-white/10">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-xs font-bold text-[#172B4D] leading-none">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-[10px] text-gray-500 mt-1 font-medium">Administrator Utama</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Data Attributes for Luxury SweetAlert2 -->
        @if(session('success'))
            <div data-flash-success="{{ session('success') }}" class="hidden"></div>
        @endif
        @if(session('error'))
            <div data-flash-error="{{ session('error') }}" class="hidden"></div>
        @endif

        <!-- Main Content (Full Width, Professional Layout) -->
        <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 w-full">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-900 text-sm flex items-center justify-between gap-3 shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-700"></i>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-900 text-sm flex items-center justify-between gap-3 shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-rose-100 flex items-center justify-center shrink-0">
                            <i data-lucide="alert-octagon" class="w-4 h-4 text-rose-700"></i>
                        </div>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 p-1">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-900 text-sm shadow-xs">
                    <div class="flex items-center gap-2 font-bold mb-2">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                        <span>Mohon periksa kesalahan input berikut:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 pl-2 text-rose-800">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Admin Footer -->
        <footer class="py-4 px-4 sm:px-6 lg:px-8 border-t border-gray-200 bg-white text-xs text-gray-500 text-center sm:text-left flex flex-col sm:flex-row justify-between items-center gap-2">
            <span>&copy; {{ date('Y') }} <strong>AzkaMandiri</strong> – Jasa Aluminium &amp; Kaca.</span>
            <span>Versi Sistem 1.0</span>
        </footer>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.renderIcons) {
                window.renderIcons();
            }
            if (window.initSelect2) {
                window.initSelect2();
            }
        });
    </script>
</body>
</html>

