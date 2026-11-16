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
<body class="bg-[#F5F6F8] text-[#343A40] min-h-screen antialiased flex"
      x-data="{ 
          sidebarOpen: false,
          sidebarCollapsed: localStorage.getItem('sidebar_collapsed') === 'true',
          toggleSidebar() {
              if (window.innerWidth >= 1024) {
                  this.sidebarCollapsed = !this.sidebarCollapsed;
                  localStorage.setItem('sidebar_collapsed', this.sidebarCollapsed);
              } else {
                  this.sidebarOpen = !this.sidebarOpen;
              }
          }
      }">
    <!-- Interactive Top Loading Bar -->
    <div id="azka-top-loader"></div>

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-cloak
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-black/60 z-40 lg:hidden"></div>

    @php
        $lowStockAlertCount = \App\Models\Product::where('type', 'standard')->whereColumn('stock', '<=', 'min_stock')->count();
        $unreadCount = \App\Models\ContactMessage::unread()->count();

        $isPosActive = request()->routeIs('admin.pos.*') || request()->routeIs('admin.customers.*');
        $isInventoryActive = request()->routeIs('admin.inventory.*') || request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.units.*') || request()->routeIs('admin.stock-adjustments.*');
        $isSuppliersActive = request()->routeIs('admin.suppliers.*') || request()->routeIs('admin.purchases.*');
        $isReportsActive = request()->routeIs('admin.reports.*');
        $isCmsActive = request()->routeIs('admin.services.*') || request()->routeIs('admin.service-categories.*') || request()->routeIs('admin.portfolios.*') || request()->routeIs('admin.portfolio-categories.*') || request()->routeIs('admin.articles.*') || request()->routeIs('admin.article-categories.*') || request()->routeIs('admin.testimonials.*') || request()->routeIs('admin.contact-messages.*') || request()->routeIs('admin.contacts');
        $isCompanyActive = request()->routeIs('admin.pages.*') || request()->routeIs('admin.settings.company');
        $isSettingsActive = request()->routeIs('admin.settings.profile') || request()->routeIs('admin.settings.seo') || request()->routeIs('admin.settings') || request()->routeIs('admin.profile.*') || request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*');
    @endphp

    <!-- Sidebar -->
    <aside :class="{
               'translate-x-0': sidebarOpen,
               '-translate-x-full lg:translate-x-0': !sidebarOpen,
               'w-64': !sidebarCollapsed,
               'w-20': sidebarCollapsed
           }"
           class="fixed inset-y-0 left-0 z-50 bg-[#101D33] text-gray-300 flex flex-col transition-all duration-300 ease-in-out border-r border-white/5"
           x-data="{
               openGroups: {
                   pos: {{ $isPosActive ? 'true' : 'false' }},
                   inventory: {{ $isInventoryActive ? 'true' : 'false' }},
                   suppliers: {{ $isSuppliersActive ? 'true' : 'false' }},
                   reports: {{ $isReportsActive ? 'true' : 'false' }},
                   cms: {{ $isCmsActive ? 'true' : 'false' }},
                   company: {{ $isCompanyActive ? 'true' : 'false' }},
                   settings: {{ $isSettingsActive ? 'true' : 'false' }}
               },
               toggle(group) {
                   if (sidebarCollapsed) {
                       sidebarCollapsed = false;
                       localStorage.setItem('sidebar_collapsed', 'false');
                   }
                   this.openGroups[group] = !this.openGroups[group];
               }
           }">
        
        <!-- Sidebar Brand Header -->
        <div class="h-16 sm:h-20 flex items-center justify-between border-b border-white/10 bg-[#0a1322]/90"
             :class="sidebarCollapsed ? 'justify-center px-2' : 'px-5'">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group transition" :class="sidebarCollapsed ? 'justify-center' : ''">
                <div class="h-10 w-12 rounded-xl bg-white p-1 flex items-center justify-center shrink-0 shadow-md shadow-black/20 group-hover:scale-105 transition-transform duration-200">
                    <img src="{{ asset('assets/brand/logo-icon.svg') }}" alt="Logo Azka Mandiri" class="max-h-full max-w-full object-contain">
                </div>
                <div class="leading-tight min-w-0" x-show="!sidebarCollapsed" x-transition>
                    <span class="font-serif font-black text-white text-base tracking-wide block leading-none">AZKA MANDIRI</span>
                    <span class="block text-[9.5px] text-[#D6A84F] uppercase tracking-widest font-bold mt-1">POS &amp; ERP System</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition" x-show="!sidebarCollapsed">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Sidebar User Information Widget -->
        <div class="p-3 border-b border-white/10 bg-[#0a1322]/60">
            <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-white/5 border border-white/10 hover:border-[#D6A84F]/40 transition group" :class="sidebarCollapsed ? 'justify-center p-2' : ''">
                <!-- User Avatar / Initials -->
                <div class="relative shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#172B4D] to-[#0a1322] text-[#D6A84F] font-black text-xs flex items-center justify-center border border-[#D6A84F]/30 shadow-xs ring-1 ring-white/10 group-hover:ring-[#D6A84F]/40 transition">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 border-2 border-[#101D33]" title="Online"></span>
                </div>

                <!-- User Name & Role -->
                <div class="min-w-0 flex-1" x-show="!sidebarCollapsed" x-transition>
                    <a href="{{ route('admin.profile.edit') }}" class="block truncate">
                        <p class="text-xs font-bold text-white truncate leading-tight group-hover:text-[#D6A84F] transition">
                            {{ auth()->user()->name ?? 'Administrator' }}
                        </p>
                        <p class="text-[10px] text-gray-400 mt-0.5 font-medium truncate">
                            {{ auth()->user()->role_name ?? 'Administrator Utama' }}
                        </p>
                    </a>
                </div>

                <!-- Quick Profile Link -->
                <a href="{{ route('admin.profile.edit') }}" 
                   x-show="!sidebarCollapsed"
                   class="p-1.5 rounded-lg text-gray-400 hover:text-[#D6A84F] hover:bg-white/10 transition shrink-0" 
                   title="Profil &amp; Akun">
                    <i data-lucide="user-cog" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

        <!-- Navigation Menu Links (Accordion Groups) -->
        <div class="flex-1 overflow-y-auto space-y-4 scrollbar-thin scrollbar-thumb-white/10" :class="sidebarCollapsed ? 'px-2 py-3 space-y-3' : 'px-3.5 py-4 space-y-4'">
            
            <!-- 1. 📊 MENU UTAMA (STANDALONE) -->
            <div>
                <p x-show="!sidebarCollapsed" class="px-2.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Menu Utama</p>
                <div x-show="sidebarCollapsed" class="h-px bg-white/10 my-2 mx-1"></div>
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                       :class="sidebarCollapsed ? 'justify-center px-2 py-2.5' : 'px-3 py-2'"
                       :title="sidebarCollapsed ? 'Dashboard Utama' : ''"
                       class="flex items-center gap-3 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-md' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-[#101D33]' : 'text-gray-400' }}"></i>
                        <span x-show="!sidebarCollapsed" class="truncate">Dashboard Utama</span>
                    </a>
                </nav>
            </div>

            <!-- MODUL OPERASIONAL & KEUANGAN -->
            <div>
                <p x-show="!sidebarCollapsed" class="px-2.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Operasional &amp; Transaksi</p>
                <div x-show="sidebarCollapsed" class="h-px bg-white/10 my-2 mx-1"></div>
                <div class="space-y-1.5">

                    <!-- 2. 🛒 OPERASIONAL & KASIR (POS) -->
                    @if(auth()->user()->can('pos.access') || auth()->user()->can('pos.view_transactions') || auth()->user()->can('customers.view'))
                    <div>
                        <button type="button" @click="toggle('pos')"
                                :class="sidebarCollapsed ? 'justify-center px-2 py-2.5' : 'justify-between px-3 py-2'"
                                :title="sidebarCollapsed ? 'Operasional Kasir' : ''"
                                class="w-full flex items-center rounded-xl text-xs font-semibold transition border-l-2 {{ $isPosActive ? 'bg-white/5 text-white border-[#D6A84F]' : 'text-gray-300 hover:text-white hover:bg-white/5 border-transparent' }}">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <i data-lucide="calculator" class="w-4 h-4 shrink-0 {{ $isPosActive ? 'text-[#D6A84F]' : 'text-gray-400' }}"></i>
                                <span x-show="!sidebarCollapsed" class="truncate">Operasional Kasir</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="transition-transform duration-200 inline-flex items-center" :class="openGroups.pos ? 'rotate-90 text-[#D6A84F]' : 'text-gray-400'">
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                </span>
                            </div>
                        </button>
                        

                        <div x-show="openGroups.pos && !sidebarCollapsed"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="relative mt-1 ml-5 pl-3 border-l border-slate-700/60 space-y-1 py-0.5">
                            @can('pos.access')
                            <a href="{{ route('admin.pos.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.pos.index') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Kasir Penjualan</span>
                            </a>
                            <a href="{{ route('admin.pos.quotations.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.pos.quotations.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Penawaran Harga</span>
                            </a>
                            @endcan
                            @can('pos.view_transactions')
                            <a href="{{ route('admin.pos.transactions') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.pos.transactions') || request()->routeIs('admin.pos.show') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Riwayat Transaksi</span>
                            </a>
                            @endcan
                            @can('customers.view')
                            <a href="{{ route('admin.customers.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.customers.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Direktori Pelanggan</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                    @endif

                    <!-- 3. 📦 INVENTARIS & STOK -->
                    @if(auth()->user()->can('products.view') || auth()->user()->can('inventory.adjust_stock') || auth()->user()->can('inventory.categories'))
                    <div>
                        <button type="button" @click="toggle('inventory')"
                                :class="sidebarCollapsed ? 'justify-center px-2 py-2.5' : 'justify-between px-3 py-2'"
                                :title="sidebarCollapsed ? 'Inventaris & Stok' : ''"
                                class="w-full flex items-center rounded-xl text-xs font-semibold transition border-l-2 {{ $isInventoryActive ? 'bg-white/5 text-white border-[#D6A84F]' : 'text-gray-300 hover:text-white hover:bg-white/5 border-transparent' }}">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <i data-lucide="package" class="w-4 h-4 shrink-0 {{ $isInventoryActive ? 'text-[#D6A84F]' : 'text-gray-400' }}"></i>
                                <span x-show="!sidebarCollapsed" class="truncate">Inventaris &amp; Stok</span>
                            </div>
                            <div x-show="!sidebarCollapsed" class="flex items-center gap-2">
                                <span class="transition-transform duration-200 inline-flex items-center" :class="openGroups.inventory ? 'rotate-90 text-[#D6A84F]' : 'text-gray-400'">
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                </span>
                            </div>
                        </button>

                        <div x-show="openGroups.inventory && !sidebarCollapsed"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="relative mt-1 ml-5 pl-3 border-l border-slate-700/60 space-y-1 py-0.5">
                            @can('products.view')
                            <a href="{{ route('admin.inventory.products.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.inventory.products.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Produk &amp; Material</span>
                                @if($lowStockAlertCount > 0)
                                    <span class="px-1.5 py-0.2 text-[9px] bg-red-500 text-white font-bold rounded-full">{{ $lowStockAlertCount }}</span>
                                @endif
                            </a>
                            @endcan
                            @can('inventory.categories')
                            <a href="{{ route('admin.inventory.categories.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.inventory.categories.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Kategori Produk</span>
                            </a>
                            @endcan
                            @can('inventory.units')
                            <a href="{{ route('admin.inventory.units.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.inventory.units.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Satuan Barang</span>
                            </a>
                            @endcan
                            @can('inventory.adjust_stock')
                            <a href="{{ route('admin.inventory.stock-adjustments.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.inventory.stock-adjustments.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Stok Opname / Koreksi</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                    @endif

                    <!-- 4. 🚚 SUPPLIER & PEMBELIAN -->
                    @if(auth()->user()->can('suppliers.view') || auth()->user()->can('purchases.view') || auth()->user()->can('purchases.create'))
                    <div>
                        <button type="button" @click="toggle('suppliers')"
                                :class="sidebarCollapsed ? 'justify-center px-2 py-2.5' : 'justify-between px-3 py-2'"
                                :title="sidebarCollapsed ? 'Supplier & Pembelian' : ''"
                                class="w-full flex items-center rounded-xl text-xs font-semibold transition border-l-2 {{ $isSuppliersActive ? 'bg-white/5 text-white border-[#D6A84F]' : 'text-gray-300 hover:text-white hover:bg-white/5 border-transparent' }}">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <i data-lucide="truck" class="w-4 h-4 shrink-0 {{ $isSuppliersActive ? 'text-[#D6A84F]' : 'text-gray-400' }}"></i>
                                <span x-show="!sidebarCollapsed" class="truncate">Supplier &amp; Pembelian</span>
                            </div>
                            <span x-show="!sidebarCollapsed" class="transition-transform duration-200 inline-flex items-center" :class="openGroups.suppliers ? 'rotate-90 text-[#D6A84F]' : 'text-gray-400'">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </span>
                        </button>

                        <div x-show="openGroups.suppliers && !sidebarCollapsed"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="relative mt-1 ml-5 pl-3 border-l border-slate-700/60 space-y-1 py-0.5">
                            @can('suppliers.view')
                            <a href="{{ route('admin.suppliers.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.suppliers.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Data Supplier</span>
                            </a>
                            @endcan
                            @can('purchases.view')
                            <a href="{{ route('admin.purchases.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.purchases.index') || request()->routeIs('admin.purchases.show') || request()->routeIs('admin.purchases.edit') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Riwayat Belanja Stok</span>
                            </a>
                            @endcan
                            @can('purchases.create')
                            <a href="{{ route('admin.purchases.create') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.purchases.create') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Input Belanja Masuk</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                    @endif

                    <!-- 5. 📈 LAPORAN & KEUANGAN -->
                    @if(auth()->user()->can('reports.sales') || auth()->user()->can('reports.purchases') || auth()->user()->can('reports.profit_loss') || auth()->user()->can('reports.stock'))
                    <div>
                        <button type="button" @click="toggle('reports')"
                                :class="sidebarCollapsed ? 'justify-center px-2 py-2.5' : 'justify-between px-3 py-2'"
                                :title="sidebarCollapsed ? 'Laporan & Keuangan' : ''"
                                class="w-full flex items-center rounded-xl text-xs font-semibold transition border-l-2 {{ $isReportsActive ? 'bg-white/5 text-white border-[#D6A84F]' : 'text-gray-300 hover:text-white hover:bg-white/5 border-transparent' }}">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <i data-lucide="bar-chart-3" class="w-4 h-4 shrink-0 {{ $isReportsActive ? 'text-[#D6A84F]' : 'text-gray-400' }}"></i>
                                <span x-show="!sidebarCollapsed" class="truncate">Laporan &amp; Keuangan</span>
                            </div>
                            <span x-show="!sidebarCollapsed" class="transition-transform duration-200 inline-flex items-center" :class="openGroups.reports ? 'rotate-90 text-[#D6A84F]' : 'text-gray-400'">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </span>
                        </button>

                        <div x-show="openGroups.reports && !sidebarCollapsed"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="relative mt-1 ml-5 pl-3 border-l border-slate-700/60 space-y-1 py-0.5">
                            @can('reports.sales')
                            <a href="{{ route('admin.reports.sales') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.reports.sales') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Laporan Penjualan</span>
                            </a>
                            @endcan
                            @can('reports.purchases')
                            <a href="{{ route('admin.reports.purchases') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.reports.purchases*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Laporan Pembelian</span>
                            </a>
                            @endcan
                            @can('reports.profit_loss')
                            <a href="{{ route('admin.reports.profit-loss') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.reports.profit-loss') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Laba Rugi (Profit)</span>
                            </a>
                            @endcan
                            @can('reports.stock')
                            <a href="{{ route('admin.reports.stock') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.reports.stock') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Valuasi &amp; Sisa Stok</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <!-- MODUL KONTEN & PROFIL USAHA -->
            <div>
                <p x-show="!sidebarCollapsed" class="px-2.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Konten &amp; Profil Publik</p>
                <div x-show="sidebarCollapsed" class="h-px bg-white/10 my-2 mx-1"></div>
                <div class="space-y-1.5">

                    <!-- 6. 🌐 MANAJEMEN KONTEN PUBLIK (CMS) -->
                    @if(auth()->user()->can('services.manage') || auth()->user()->can('portfolios.manage') || auth()->user()->can('articles.manage') || auth()->user()->can('testimonials.manage') || auth()->user()->can('messages.view'))
                    <div>
                        <button type="button" @click="toggle('cms')"
                                :class="sidebarCollapsed ? 'justify-center px-2 py-2.5' : 'justify-between px-3 py-2'"
                                :title="sidebarCollapsed ? 'Manajemen Website' : ''"
                                class="w-full flex items-center rounded-xl text-xs font-semibold transition border-l-2 {{ $isCmsActive ? 'bg-white/5 text-white border-[#D6A84F]' : 'text-gray-300 hover:text-white hover:bg-white/5 border-transparent' }}">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <i data-lucide="globe" class="w-4 h-4 shrink-0 {{ $isCmsActive ? 'text-[#D6A84F]' : 'text-gray-400' }}"></i>
                                <span x-show="!sidebarCollapsed" class="truncate">Manajemen Website</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="transition-transform duration-200 inline-flex items-center" :class="openGroups.cms ? 'rotate-90 text-[#D6A84F]' : 'text-gray-400'">
                                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                </span>
                            </div>
                        </button>

                        <div x-show="openGroups.cms && !sidebarCollapsed"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="relative mt-1 ml-5 pl-3 border-l border-slate-700/60 space-y-1 py-0.5">
                            @can('services.manage')
                            <a href="{{ route('admin.services.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.services.*') || request()->routeIs('admin.service-categories.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Manajemen Layanan</span>
                            </a>
                            @endcan
                            @can('portfolios.manage')
                            <a href="{{ route('admin.portfolios.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.portfolios.*') || request()->routeIs('admin.portfolio-categories.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Manajemen Portofolio</span>
                            </a>
                            @endcan
                            @can('articles.manage')
                            <a href="{{ route('admin.articles.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.articles.*') || request()->routeIs('admin.article-categories.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Manajemen Artikel</span>
                            </a>
                            @endcan
                            @can('testimonials.manage')
                            <a href="{{ route('admin.testimonials.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.testimonials.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Testimoni Klien</span>
                            </a>
                            @endcan
                            @can('messages.view')
                            <a href="{{ route('admin.contact-messages.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.contact-messages.*') || request()->routeIs('admin.contacts') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Pesan Masuk</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                    @endif

                    <!-- 7. 🏢 PROFIL & INFORMASI USAHA -->
                    @if(auth()->user()->can('pages.manage'))
                    <div>
                        <button type="button" @click="toggle('company')"
                                :class="sidebarCollapsed ? 'justify-center px-2 py-2.5' : 'justify-between px-3 py-2'"
                                :title="sidebarCollapsed ? 'Profil Perusahaan' : ''"
                                class="w-full flex items-center rounded-xl text-xs font-semibold transition border-l-2 {{ $isCompanyActive ? 'bg-white/5 text-white border-[#D6A84F]' : 'text-gray-300 hover:text-white hover:bg-white/5 border-transparent' }}">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <i data-lucide="building-2" class="w-4 h-4 shrink-0 {{ $isCompanyActive ? 'text-[#D6A84F]' : 'text-gray-400' }}"></i>
                                <span x-show="!sidebarCollapsed" class="truncate">Profil Perusahaan</span>
                            </div>
                            <span x-show="!sidebarCollapsed" class="transition-transform duration-200 inline-flex items-center" :class="openGroups.company ? 'rotate-90 text-[#D6A84F]' : 'text-gray-400'">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </span>
                        </button>

                        <div x-show="openGroups.company && !sidebarCollapsed"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="relative mt-1 ml-5 pl-3 border-l border-slate-700/60 space-y-1 py-0.5">
                            <a href="{{ route('admin.pages.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.pages.*') || request()->routeIs('admin.settings.company') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Profil Perusahaan / Halaman</span>
                            </a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <!-- MODUL SISTEM & ADMINISTRASI -->
            <div>
                <p x-show="!sidebarCollapsed" class="px-2.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Sistem &amp; Administrasi</p>
                <div x-show="sidebarCollapsed" class="h-px bg-white/10 my-2 mx-1"></div>
                <div class="space-y-1.5">

                    <!-- 8. 🛡️ PENGATURAN SISTEM & AKSES (ADMIN AREA) -->
                    @if(auth()->user()->can('settings.profile') || auth()->user()->can('settings.seo') || auth()->user()->can('users.view') || auth()->user()->can('roles.manage'))
                    <div>
                        <button type="button" @click="toggle('settings')"
                                :class="sidebarCollapsed ? 'justify-center px-2 py-2.5' : 'justify-between px-3 py-2'"
                                :title="sidebarCollapsed ? 'Pengaturan Sistem' : ''"
                                class="w-full flex items-center rounded-xl text-xs font-semibold transition border-l-2 {{ $isSettingsActive ? 'bg-white/5 text-white border-[#D6A84F]' : 'text-gray-300 hover:text-white hover:bg-white/5 border-transparent' }}">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <i data-lucide="shield" class="w-4 h-4 shrink-0 {{ $isSettingsActive ? 'text-[#D6A84F]' : 'text-gray-400' }}"></i>
                                <span x-show="!sidebarCollapsed" class="truncate">Pengaturan Sistem</span>
                            </div>
                            <span x-show="!sidebarCollapsed" class="transition-transform duration-200 inline-flex items-center" :class="openGroups.settings ? 'rotate-90 text-[#D6A84F]' : 'text-gray-400'">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </span>
                        </button>

                        <div x-show="openGroups.settings && !sidebarCollapsed"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="relative mt-1 ml-5 pl-3 border-l border-slate-700/60 space-y-1 py-0.5">
                            @can('settings.profile')
                            <a href="{{ route('admin.settings.profile') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.settings.profile') || request()->routeIs('admin.settings') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Pengaturan Website</span>
                            </a>
                            @endcan
                            @can('settings.seo')
                            <a href="{{ route('admin.settings.seo') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.settings.seo') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Konfigurasi SEO</span>
                            </a>
                            @endcan
                            @can('users.view')
                            <a href="{{ route('admin.users.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.users.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Manajemen Pengguna</span>
                            </a>
                            @endcan
                            @can('roles.manage')
                            <a href="{{ route('admin.roles.index') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.roles.*') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Peran &amp; Hak Akses</span>
                            </a>
                            @endcan
                            <a href="{{ route('admin.profile.edit') }}"
                               class="group relative flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-medium transition before:absolute before:-left-3 before:top-1/2 before:-translate-y-1/2 before:w-3 before:h-px {{ request()->routeIs('admin.profile.edit') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs before:bg-[#D6A84F] before:h-0.5' : 'text-gray-400 hover:text-white hover:bg-white/5 before:bg-slate-700/60 hover:before:bg-gray-300' }}">
                                <span>Akun Administrator</span>
                            </a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </aside>

    <!-- Main Content Area -->
    <div :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-64'"
         class="flex-1 flex flex-col min-w-0 transition-all duration-300 ease-in-out">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-slate-200/90 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 shadow-xs">
            <!-- Left: Minimize / Toggle Sidebar Button -->
            <div class="flex items-center gap-3">
                <button type="button" 
                        @click="toggleSidebar()"
                        class="p-2 sm:px-3 sm:py-2 rounded-xl text-slate-700 hover:text-[#101D33] hover:bg-slate-100 transition border border-slate-200 shadow-2xs group flex items-center gap-2 cursor-pointer focus:outline-hidden"
                        :title="sidebarCollapsed ? 'Buka / Perluas Sidebar' : 'Minimize Sidebar'">
                    <i data-lucide="menu" class="w-5 h-5 text-slate-700 group-hover:text-slate-900"></i>
                    <span class="hidden sm:inline text-xs font-bold text-slate-700 group-hover:text-slate-900" x-text="sidebarCollapsed ? 'Buka Menu' : 'Minimize Sidebar'"></span>
                </button>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition shadow-2xs">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>Lihat Website</span>
                </a>

                <!-- User Profile Dropdown Menu -->
                <div class="relative pl-3 border-l border-gray-200" x-data="{ userMenuOpen: false }">
                    <button type="button" 
                            @click="userMenuOpen = !userMenuOpen" 
                            @click.outside="userMenuOpen = false"
                            class="flex items-center gap-2.5 p-1 sm:px-2.5 sm:py-1.5 rounded-2xl hover:bg-gray-50 transition cursor-pointer group focus:outline-hidden"
                            :class="{ 'bg-gray-50 ring-2 ring-[#D6A84F]/30': userMenuOpen }">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#172B4D] to-[#101D33] text-[#D6A84F] font-black text-xs flex items-center justify-center shadow-xs border border-white/10 group-hover:border-[#D6A84F]/50 transition shrink-0">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-xs font-bold text-[#172B4D] leading-none group-hover:text-[#D6A84F] transition">{{ auth()->user()->name ?? 'Administrator' }}</p>
                            <p class="text-[10px] text-gray-500 mt-1 font-medium">{{ auth()->user()->role_name ?? 'Administrator Utama' }}</p>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-400 group-hover:text-gray-600 transition ml-0.5" :class="{ 'rotate-180': userMenuOpen }"></i>
                    </button>

                    <!-- Dropdown Popover -->
                    <div x-show="userMenuOpen"
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                         class="absolute right-0 mt-2 w-56 rounded-2xl bg-white border border-gray-100 shadow-xl py-2 z-50 text-gray-700 divide-y divide-gray-100">
                        
                        <!-- User Meta Header -->
                        <div class="px-4 py-2.5 bg-gray-50/70">
                            <p class="text-xs font-bold text-[#172B4D] truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                            <p class="text-[11px] text-gray-500 truncate mt-0.5">{{ auth()->user()->email ?? '' }}</p>
                            <div class="mt-1.5 flex items-center gap-1.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-semibold bg-[#D6A84F]/15 text-[#9E7324] border border-[#D6A84F]/30 uppercase">
                                    {{ auth()->user()->role_name ?? 'Administrator Utama' }}
                                </span>
                            </div>
                        </div>

                        <!-- Dropdown Actions -->
                        <div class="p-1.5 space-y-0.5">
                            <a href="{{ route('admin.profile.edit') }}" 
                               @click="userMenuOpen = false"
                               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-[#172B4D] transition">
                                <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                                <span>Lihat Profil</span>
                            </a>
                        </div>

                        <!-- Logout Action -->
                        <div class="p-1.5">
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition cursor-pointer">
                                    <i data-lucide="log-out" class="w-4 h-4 text-rose-500"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
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
        <main class="flex-1 px-4 sm:px-6 py-6 w-full">
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

            @if(isset($errors) && $errors->any())
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
        <footer class="py-4 px-4 sm:px-6 border-t border-gray-200 bg-white text-xs text-gray-500 text-center sm:text-left flex flex-col sm:flex-row justify-between items-center gap-2">
            <span>&copy; {{ date('Y') }} <strong>AzkaMandiri</strong> – Jasa Aluminium &amp; Kaca.</span>
            <span>Versi Sistem 1.0</span>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
