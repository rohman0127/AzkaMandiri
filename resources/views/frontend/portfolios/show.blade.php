@extends('layouts.app')

@section('meta_title', $portfolio->meta_title ?: $portfolio->title . ' – Portofolio AzkaMandiri')
@section('meta_description', $portfolio->meta_description ?: Str::limit($portfolio->excerpt, 155))
@section('og_image', $portfolio->main_image ? asset($portfolio->main_image) : asset('assets/brand/logo-horizontal.svg'))

@section('content')
<!-- Breadcrumbs -->
<div class="bg-[#F5F6F8] py-4 border-b border-gray-200">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-[#172B4D] transition">Home</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <a href="{{ route('portfolios.index') }}" class="hover:text-[#172B4D] transition">Portofolio</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-[#172B4D] font-bold truncate">{{ $portfolio->title }}</span>
        </nav>
    </div>
</div>

<section class="py-12 lg:py-16 bg-white">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left: Gallery & Photos -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Main Project Image -->
                <div class="rounded-3xl overflow-hidden border border-gray-200 shadow-lg bg-gray-100">
                    <img src="{{ $portfolio->main_image ?: asset('assets/brand/logo-icon.svg') }}" 
                         alt="{{ $portfolio->title }}" 
                         class="w-full h-80 sm:h-[480px] object-cover">
                </div>

                <!-- Gallery Images -->
                @if($portfolio->images->isNotEmpty())
                    <div class="space-y-3 pt-4">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Galeri Sudut Dokumentasi</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($portfolio->images as $img)
                                <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-xs group bg-gray-100">
                                    <img src="{{ $img->image_path }}" alt="Dokumentasi Proyek" 
                                         class="w-full h-36 object-cover group-hover:scale-105 transition duration-300">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Description Text -->
                <div class="pt-8 border-t border-gray-100 space-y-4">
                    <h3 class="text-2xl font-bold text-[#172B4D]">Ulasan &amp; Detail Pengerjaan Proyek</h3>
                    <div class="prose max-w-none text-gray-600 leading-relaxed whitespace-pre-line text-sm sm:text-base">
{{ $portfolio->description }}
                    </div>
                </div>
            </div>

            <!-- Right: Project Meta Sidebar -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-[#F5F6F8] p-6 sm:p-8 rounded-3xl border border-gray-200 space-y-6">
                    <div>
                        @if($portfolio->category)
                            <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-[#a97e2c] text-xs font-bold uppercase tracking-wider mb-2">
                                {{ $portfolio->category->name }}
                            </span>
                        @endif
                        <h1 class="text-xl sm:text-2xl font-extrabold text-[#172B4D] leading-tight">
                            {{ $portfolio->title }}
                        </h1>
                    </div>

                    <!-- Meta Specs Table -->
                    <div class="divide-y divide-gray-200 text-xs">
                        <div class="py-2.5 flex justify-between">
                            <span class="text-gray-500">Lokasi:</span>
                            <span class="font-bold text-gray-800 text-right">{{ $portfolio->location ?: 'Jabodetabek' }}</span>
                        </div>
                        <div class="py-2.5 flex justify-between">
                            <span class="text-gray-500">Tahun Pengerjaan:</span>
                            <span class="font-bold text-gray-800">{{ $portfolio->completion_year ?: '-' }}</span>
                        </div>
                        <div class="py-2.5 flex justify-between">
                            <span class="text-gray-500">Klien / Pemilik:</span>
                            <span class="font-bold text-gray-800">{{ $portfolio->client_name ?: 'Klien Umum' }}</span>
                        </div>
                        <div class="py-2.5 flex justify-between">
                            <span class="text-gray-500">Pelaksana:</span>
                            <span class="font-bold text-[#172B4D]">Tim Teknisi AzkaMandiri</span>
                        </div>
                    </div>

                    <!-- Booking WhatsApp CTA -->
                    <div class="pt-2 space-y-3">
                        <a href="{{ wa_portfolio_link($portfolio->title, $portfolio->location) }}" target="_blank"
                           class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-[#D6A84F] to-[#b88d3b] hover:from-[#e0b45b] hover:to-[#c79a45] text-[#101D33] font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-[#D6A84F]/25 flex items-center justify-center gap-2">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>Pesan Model Seperti Ini via WhatsApp</span>
                        </a>
                        <p class="text-center text-[11px] text-gray-400">
                            Konsultasikan ukuran &amp; rancangan bangunan Anda
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Projects -->
        @if($relatedPortfolios->isNotEmpty())
            <div class="mt-20 pt-12 border-t border-gray-100 space-y-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-[#172B4D]">Proyek Lainnya</h3>
                        <p class="text-xs text-gray-500">Inspirasi pengerjaan aluminium dan kaca lainnya</p>
                    </div>
                    <a href="{{ route('portfolios.index') }}" class="text-xs font-bold text-[#D6A84F] hover:underline flex items-center gap-1">
                        <span>Semua Proyek</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedPortfolios as $rel)
                        <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden shadow-xs hover:shadow-lg transition flex flex-col justify-between group">
                            <div class="h-44 overflow-hidden bg-gray-100">
                                <img src="{{ $rel->main_image ?: asset('assets/brand/logo-icon.svg') }}" 
                                     alt="{{ $rel->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>
                            <div class="p-5 space-y-2">
                                <span class="text-[11px] text-gray-400">{{ $rel->location }}</span>
                                <h4 class="font-bold text-sm text-[#172B4D] group-hover:text-[#D6A84F] transition line-clamp-1">
                                    <a href="{{ route('portfolios.show', $rel->slug) }}">{{ $rel->title }}</a>
                                </h4>
                                <div class="pt-2">
                                    <a href="{{ route('portfolios.show', $rel->slug) }}" class="text-xs font-bold text-[#D6A84F] hover:underline">
                                        Lihat Dokumentasi &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

