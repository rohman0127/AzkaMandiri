@extends('layouts.app')

@section('meta_title', 'Portofolio Hasil Proyek – AzkaMandiri')
@section('meta_description', 'Dokumentasi proyek pengerjaan kusen, pintu aluminium sliding, jendela casement, partisi kantor kaca tempered, dan kanopi carport di Jabodetabek.')

@section('content')
<!-- Header Banner -->
<section class="bg-[#101D33] text-white py-14 lg:py-20 relative overflow-hidden">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 text-center relative z-10 space-y-4">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-[#D6A84F] font-bold text-xs uppercase tracking-wider border border-white/10">
            <i data-lucide="images" class="w-3.5 h-3.5"></i>
            <span>Dokumentasi Kerja</span>
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
            Portofolio Proyek AzkaMandiri
        </h1>
        <p class="text-sm sm:text-base text-gray-300 max-w-2xl mx-auto">
            Kumpulan hasil pemasangan kusen, jendela, pintu, partisi, dan kaca di berbagai hunian dan gedung komersial.
        </p>
    </div>
</section>

<!-- Filter & Portfolio Grid -->
<section class="py-16 bg-[#F5F6F8]">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 space-y-8">
        <!-- Search and Filter Bar -->
        <div class="bg-white p-6 rounded-3xl border border-gray-200/80 shadow-xs space-y-4">
            <form method="GET" action="{{ route('portfolios.index') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari proyek berdasarkan judul, lokasi (BSD, SCBD, Bintaro)..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                </div>
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#172B4D] hover:bg-[#101D33] text-white font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    <span>Cari</span>
                </button>
            </form>

            <!-- Category Filter Pills -->
            <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-gray-100">
                <a href="{{ route('portfolios.index', request()->only('q')) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ !request('kategori') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Semua Proyek
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('portfolios.index', array_merge(request()->only('q'), ['kategori' => $cat->slug])) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ request('kategori') === $cat->slug ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $cat->name }} ({{ $cat->portfolios_count }})
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Portfolios Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($portfolios as $port)
                <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <div class="relative h-60 overflow-hidden bg-gray-100">
                        <img src="{{ $port->main_image ?: asset('assets/brand/logo-icon.svg') }}" 
                             alt="{{ $port->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        @if($port->category)
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#101D33]/85 text-[#D6A84F] text-[10px] font-bold tracking-wider uppercase border border-white/10">
                                {{ $port->category->name }}
                            </span>
                        @endif
                        <span class="absolute bottom-3 left-4 text-xs font-semibold text-white/90 flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                            <span>{{ $port->location ?: 'Jabodetabek' }}</span>
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-[11px] text-gray-400">
                                <span>Tahun: {{ $port->completion_year ?: '-' }}</span>
                                <span>{{ $port->client_name ?: 'Klien Umum' }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-[#172B4D] group-hover:text-[#D6A84F] transition">
                                <a href="{{ route('portfolios.show', $port->slug) }}">
                                    {{ $port->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">
                                {{ $port->excerpt }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('portfolios.show', $port->slug) }}" 
                               class="text-xs font-bold text-[#172B4D] hover:text-[#D6A84F] flex items-center gap-1">
                                <span>Detail Dokumentasi</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <a href="{{ wa_portfolio_link($port->title, $port->location) }}" target="_blank"
                               class="p-2 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition"
                               title="Pesan Proyek Serupa via WhatsApp">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-gray-400">
                    <i data-lucide="images" class="w-12 h-12 mx-auto text-gray-300 mb-3"></i>
                    <p class="text-base font-semibold">Tidak ditemukan portofolio yang cocok.</p>
                    <a href="{{ route('portfolios.index') }}" class="inline-block mt-4 text-xs font-bold text-[#D6A84F] hover:underline">
                        Lihat Semua Portofolio
                    </a>
                </div>
            @endforelse
        </div>

        @if($portfolios->hasPages())
            <div class="pt-6">
                {{ $portfolios->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

