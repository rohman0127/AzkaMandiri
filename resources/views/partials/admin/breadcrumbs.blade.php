@php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
    $crumbs = [];

    // Resolve breadcrumbs dynamically based on route hierarchy
    if (str_starts_with($currentRoute, 'admin.service-categories.')) {
        $crumbs[] = ['label' => 'Katalog & Konten'];
        $crumbs[] = ['label' => 'Kategori Layanan', 'url' => route('admin.service-categories.index')];
        if ($currentRoute === 'admin.service-categories.create') {
            $crumbs[] = ['label' => 'Tambah Kategori'];
        } elseif ($currentRoute === 'admin.service-categories.edit') {
            $crumbs[] = ['label' => 'Edit Kategori'];
        }
    } elseif (str_starts_with($currentRoute, 'admin.services.')) {
        $crumbs[] = ['label' => 'Katalog & Konten'];
        $crumbs[] = ['label' => 'Layanan', 'url' => route('admin.services.index')];
        if ($currentRoute === 'admin.services.create') {
            $crumbs[] = ['label' => 'Tambah Layanan'];
        } elseif ($currentRoute === 'admin.services.edit') {
            $crumbs[] = ['label' => 'Edit Layanan'];
        } elseif ($currentRoute === 'admin.services.show') {
            $crumbs[] = ['label' => 'Detail Layanan'];
        }
    } elseif (str_starts_with($currentRoute, 'admin.portfolio-categories.')) {
        $crumbs[] = ['label' => 'Katalog & Konten'];
        $crumbs[] = ['label' => 'Kategori Portofolio', 'url' => route('admin.portfolio-categories.index')];
        if ($currentRoute === 'admin.portfolio-categories.create') {
            $crumbs[] = ['label' => 'Tambah Kategori'];
        } elseif ($currentRoute === 'admin.portfolio-categories.edit') {
            $crumbs[] = ['label' => 'Edit Kategori'];
        }
    } elseif (str_starts_with($currentRoute, 'admin.portfolios.')) {
        $crumbs[] = ['label' => 'Katalog & Konten'];
        $crumbs[] = ['label' => 'Portofolio', 'url' => route('admin.portfolios.index')];
        if ($currentRoute === 'admin.portfolios.create') {
            $crumbs[] = ['label' => 'Tambah Portofolio'];
        } elseif ($currentRoute === 'admin.portfolios.edit') {
            $crumbs[] = ['label' => 'Edit Portofolio'];
        }
    } elseif (str_starts_with($currentRoute, 'admin.article-categories.')) {
        $crumbs[] = ['label' => 'Katalog & Konten'];
        $crumbs[] = ['label' => 'Kategori Artikel', 'url' => route('admin.article-categories.index')];
        if ($currentRoute === 'admin.article-categories.create') {
            $crumbs[] = ['label' => 'Tambah Kategori'];
        } elseif ($currentRoute === 'admin.article-categories.edit') {
            $crumbs[] = ['label' => 'Edit Kategori'];
        }
    } elseif (str_starts_with($currentRoute, 'admin.articles.')) {
        $crumbs[] = ['label' => 'Katalog & Konten'];
        $crumbs[] = ['label' => 'Artikel Blog', 'url' => route('admin.articles.index')];
        if ($currentRoute === 'admin.articles.create') {
            $crumbs[] = ['label' => 'Tambah Artikel'];
        } elseif ($currentRoute === 'admin.articles.edit') {
            $crumbs[] = ['label' => 'Edit Artikel'];
        }
    } elseif (str_starts_with($currentRoute, 'admin.testimonials.')) {
        $crumbs[] = ['label' => 'Katalog & Konten'];
        $crumbs[] = ['label' => 'Testimoni', 'url' => route('admin.testimonials.index')];
        if ($currentRoute === 'admin.testimonials.create') {
            $crumbs[] = ['label' => 'Tambah Testimoni'];
        } elseif ($currentRoute === 'admin.testimonials.edit') {
            $crumbs[] = ['label' => 'Edit Testimoni'];
        }
    } elseif (str_starts_with($currentRoute, 'admin.pages.')) {
        $crumbs[] = ['label' => 'Katalog & Konten'];
        $crumbs[] = ['label' => 'Halaman Statis', 'url' => route('admin.pages.index')];
        if ($currentRoute === 'admin.pages.create') {
            $crumbs[] = ['label' => 'Tambah Halaman'];
        } elseif ($currentRoute === 'admin.pages.edit') {
            $crumbs[] = ['label' => 'Edit Halaman'];
        }
    } elseif (str_starts_with($currentRoute, 'admin.contact-messages.')) {
        $crumbs[] = ['label' => 'Pesan & Sistem'];
        $crumbs[] = ['label' => 'Pesan Masuk', 'url' => route('admin.contact-messages.index')];
        if ($currentRoute === 'admin.contact-messages.show') {
            $crumbs[] = ['label' => 'Detail Pesan'];
        }
    } elseif ($currentRoute === 'admin.settings.profile') {
        $crumbs[] = ['label' => 'Pengaturan & Profil'];
        $crumbs[] = ['label' => 'Profil & Kontak Website'];
    } elseif ($currentRoute === 'admin.settings.seo') {
        $crumbs[] = ['label' => 'Pengaturan & Profil'];
        $crumbs[] = ['label' => 'Pengaturan SEO'];
    } elseif ($currentRoute === 'admin.profile.edit') {
        $crumbs[] = ['label' => 'Pengaturan & Profil'];
        $crumbs[] = ['label' => 'Akun Administrator'];
    } elseif (str_starts_with($currentRoute, 'admin.pos.quotations.')) {
        $crumbs[] = ['label' => 'Operasional & Kasir'];
        $crumbs[] = ['label' => 'Penawaran Harga', 'url' => route('admin.pos.quotations.index')];
        if ($currentRoute === 'admin.pos.quotations.create') {
            $crumbs[] = ['label' => 'Buat Penawaran Baru'];
        } elseif ($currentRoute === 'admin.pos.quotations.edit') {
            $crumbs[] = ['label' => 'Edit Penawaran'];
        } elseif ($currentRoute === 'admin.pos.quotations.show') {
            $crumbs[] = ['label' => 'Detail Penawaran'];
        }
    } elseif (str_starts_with($currentRoute, 'admin.pos.')) {
        $crumbs[] = ['label' => 'Operasional & Kasir'];
        if ($currentRoute === 'admin.pos.index') {
            $crumbs[] = ['label' => 'Terminal Kasir POS'];
        } elseif ($currentRoute === 'admin.pos.transactions' || str_starts_with($currentRoute, 'admin.pos.transactions.')) {
            $crumbs[] = ['label' => 'Riwayat Transaksi', 'url' => route('admin.pos.transactions')];
        }
    } elseif (str_starts_with($currentRoute, 'admin.reports.')) {
        $crumbs[] = ['label' => 'Laporan & Keuangan'];
        if ($currentRoute === 'admin.reports.sales') {
            $crumbs[] = ['label' => 'Laporan Penjualan'];
        } elseif ($currentRoute === 'admin.reports.purchases') {
            $crumbs[] = ['label' => 'Laporan Pembelian'];
        } elseif ($currentRoute === 'admin.reports.profit_loss') {
            $crumbs[] = ['label' => 'Laporan Laba Rugi'];
        } elseif ($currentRoute === 'admin.reports.stock') {
            $crumbs[] = ['label' => 'Laporan Valuasi Stok'];
        }
    }
@endphp

<nav aria-label="Breadcrumb" class="inline-flex items-center gap-1.5 flex-wrap">
    <!-- Home / Dashboard Root Link -->
    <a href="{{ route('admin.dashboard') }}" 
       class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-[#D6A84F]/15 text-gray-600 hover:text-[#172B4D] text-xs font-semibold transition group">
        <i data-lucide="home" class="w-3.5 h-3.5 text-[#D6A84F] group-hover:scale-110 transition-transform"></i>
        <span>Dashboard</span>
    </a>

    @if(count($crumbs) > 0)
        @foreach($crumbs as $crumb)
            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
            @if(isset($crumb['url']) && !$loop->last)
                <a href="{{ $crumb['url'] }}" 
                   class="inline-flex items-center px-2 py-1 rounded-lg text-gray-500 hover:text-[#172B4D] hover:bg-gray-100 text-xs font-medium transition">
                    {{ $crumb['label'] }}
                </a>
            @elseif($loop->last)
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-[#172B4D]/5 text-[#172B4D] text-xs font-bold border border-[#172B4D]/10 shadow-2xs">
                    {{ $crumb['label'] }}
                </span>
            @else
                <span class="text-xs text-gray-400 font-medium px-1">
                    {{ $crumb['label'] }}
                </span>
            @endif
        @endforeach
    @else
        @hasSection('breadcrumbs')
            @yield('breadcrumbs')
        @else
            @hasSection('title')
                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-[#172B4D]/5 text-[#172B4D] text-xs font-bold border border-[#172B4D]/10 shadow-2xs">
                    @yield('title')
                </span>
            @endif
        @endif
    @endif
</nav>

