@extends('layouts.app')

@section('meta_title', 'Artikel & Panduan Aluminium Kaca – AzkaMandiri')
@section('meta_description', 'Kumpulan artikel, tips pemilihan kusen, spesifikasi kaca tempered, dan panduan perawatan pintu & jendela aluminium.')

@section('content')
<!-- Header Banner -->
<section class="bg-[#101D33] text-white py-14 lg:py-20 relative overflow-hidden">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 text-center relative z-10 space-y-4">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-[#D6A84F] font-bold text-xs uppercase tracking-wider border border-white/10">
            <i data-lucide="newspaper" class="w-3.5 h-3.5"></i>
            <span>Blog &amp; Edukasi</span>
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
            Artikel &amp; Inspirasi Arsitektur
        </h1>
        <p class="text-sm sm:text-base text-gray-300 max-w-2xl mx-auto">
            Wawasan teknis seputar material kusen, kaca tempered, tips perawatan, dan tren desain hunian.
        </p>
    </div>
</section>

<!-- Filter & Article Grid -->
<section class="py-16 bg-[#F5F6F8]">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 space-y-8">
        <!-- Search and Filter Bar -->
        <div class="bg-white p-6 rounded-3xl border border-gray-200/80 shadow-xs space-y-4">
            <form method="GET" action="{{ route('articles.index') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari topik artikel (contoh: YKK, tempered, perawatan)..."
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

            <!-- Category Pills -->
            <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-gray-100">
                <a href="{{ route('articles.index', request()->only('q')) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ !request('kategori') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Semua Topik
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('articles.index', array_merge(request()->only('q'), ['kategori' => $cat->slug])) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ request('kategori') === $cat->slug ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $cat->name }} ({{ $cat->articles_count }})
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($articles as $art)
                <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <div class="relative h-52 overflow-hidden bg-gray-100">
                        <img src="{{ $art->thumbnail ?: asset('assets/brand/logo-icon.svg') }}" 
                             alt="{{ $art->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @if($art->category)
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#101D33]/85 text-[#D6A84F] text-[10px] font-bold tracking-wider uppercase border border-white/10">
                                {{ $art->category->name }}
                            </span>
                        @endif
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-3 text-[11px] text-gray-400">
                                <span>{{ $art->published_at ? $art->published_at->format('d M Y') : '' }}</span>
                                <span>•</span>
                                <span>{{ $art->author_name }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-[#172B4D] group-hover:text-[#D6A84F] transition leading-snug line-clamp-2">
                                <a href="{{ route('articles.show', $art->slug) }}">
                                    {{ $art->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                {{ $art->excerpt }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('articles.show', $art->slug) }}" 
                               class="text-xs font-bold text-[#172B4D] hover:text-[#D6A84F] flex items-center gap-1">
                                <span>Baca Artikel</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            <span class="text-[11px] text-gray-400 flex items-center gap-1">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                {{ $art->views_count }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-gray-400">
                    <i data-lucide="newspaper" class="w-12 h-12 mx-auto text-gray-300 mb-3"></i>
                    <p class="text-base font-semibold">Tidak ditemukan artikel yang sesuai.</p>
                    <a href="{{ route('articles.index') }}" class="inline-block mt-4 text-xs font-bold text-[#D6A84F] hover:underline">
                        Lihat Semua Artikel
                    </a>
                </div>
            @endforelse
        </div>

        @if($articles->hasPages())
            <div class="pt-6">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

