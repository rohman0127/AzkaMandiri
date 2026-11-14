@extends('layouts.app')

@section('meta_title', $article->meta_title ?: $article->title . ' – AzkaMandiri')
@section('meta_description', $article->meta_description ?: Str::limit($article->excerpt, 155))
@section('og_image', $article->thumbnail ? asset($article->thumbnail) : asset('assets/brand/logo-horizontal.svg'))

@section('content')
<!-- Breadcrumbs -->
<div class="bg-[#F5F6F8] py-4 border-b border-gray-200">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-[#172B4D] transition">Home</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <a href="{{ route('articles.index') }}" class="hover:text-[#172B4D] transition">Artikel</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-[#172B4D] font-bold truncate">{{ $article->title }}</span>
        </nav>
    </div>
</div>

<article class="py-12 lg:py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Article Header -->
        <header class="space-y-4 text-center sm:text-left">
            @if($article->category)
                <span class="inline-block px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-bold uppercase tracking-wider">
                    {{ $article->category->name }}
                </span>
            @endif

            <h1 class="text-3xl sm:text-5xl font-extrabold text-[#172B4D] tracking-tight leading-[1.2]">
                {{ $article->title }}
            </h1>

            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 text-xs text-gray-500 pt-2 border-b border-gray-100 pb-4">
                <span class="flex items-center gap-1.5">
                    <i data-lucide="user" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    {{ $article->author_name }}
                </span>
                <span>•</span>
                <span class="flex items-center gap-1.5">
                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                    {{ $article->published_at ? $article->published_at->isoFormat('D MMMM Y') : 'Draft' }}
                </span>
                <span>•</span>
                <span class="flex items-center gap-1.5">
                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                    {{ $article->views_count }} Kali Dilihat
                </span>
            </div>
        </header>

        <!-- Featured Image -->
        @if($article->thumbnail)
            <div class="rounded-3xl overflow-hidden border border-gray-200 shadow-lg bg-gray-100">
                <img src="{{ $article->thumbnail }}" alt="{{ $article->title }}" class="w-full h-80 sm:h-[450px] object-cover">
            </div>
        @endif

        <!-- Excerpt Callout -->
        @if($article->excerpt)
            <div class="p-6 rounded-2xl bg-[#F5F6F8] border-l-4 border-[#D6A84F] text-gray-700 italic text-sm sm:text-base leading-relaxed">
                {{ $article->excerpt }}
            </div>
        @endif

        <!-- Body Content -->
        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed whitespace-pre-line font-sans text-base">
{{ $article->content }}
        </div>

        <!-- Consultation Banner Inside Article -->
        <div class="mt-12 p-8 rounded-3xl bg-[#172B4D] text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="space-y-1 text-center sm:text-left">
                <h3 class="text-xl font-bold text-white">Butuh Solusi Aluminium &amp; Kaca untuk Bangunan Anda?</h3>
                <p class="text-xs text-gray-300">Konsultasikan kebutuhan teknis dan dapatkan estimasi harga gratis dari AzkaMandiri.</p>
            </div>
            <a href="{{ wa_link('Halo AzkaMandiri, saya membaca artikel "' . $article->title . '" dan ingin berkonsultasi lebih lanjut.') }}" target="_blank"
               class="px-6 py-3.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs uppercase tracking-wider transition shrink-0 shadow-md flex items-center gap-2">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                <span>Tanya Kami via WhatsApp</span>
            </a>
        </div>

        <!-- Recent Articles -->
        @if($recentArticles->isNotEmpty())
            <div class="mt-16 pt-12 border-t border-gray-100 space-y-6">
                <h3 class="text-xl font-bold text-[#172B4D]">Artikel Terkait Lainnya</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($recentArticles as $recent)
                        <div class="p-5 rounded-2xl bg-[#F5F6F8] border border-gray-200 hover:border-[#D6A84F] transition flex items-start gap-4">
                            <img src="{{ $recent->thumbnail ?: asset('assets/brand/logo-icon.svg') }}" alt="{{ $recent->title }}" class="w-20 h-20 rounded-xl object-cover shrink-0">
                            <div class="space-y-1">
                                <span class="text-[10px] text-gray-400 font-semibold">{{ $recent->published_at ? $recent->published_at->format('d M Y') : '' }}</span>
                                <h4 class="text-xs sm:text-sm font-bold text-[#172B4D] line-clamp-2 hover:text-[#D6A84F]">
                                    <a href="{{ route('articles.show', $recent->slug) }}">{{ $recent->title }}</a>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>
@endsection

