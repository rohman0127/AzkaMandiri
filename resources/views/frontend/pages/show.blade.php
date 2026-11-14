@extends('layouts.app')

@section('meta_title', $page->meta_title ?: $page->title . ' – AzkaMandiri')
@section('meta_description', $page->meta_description ?: Str::limit($page->content, 155))

@section('content')
<!-- Header Banner -->
<section class="bg-[#101D33] text-white py-14 lg:py-20 relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-3">
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
            {{ $page->title }}
        </h1>
        <p class="text-xs text-gray-400">Terakhir diperbarui: {{ $page->updated_at->isoFormat('D MMMM Y') }}</p>
    </div>
</section>

<!-- Content -->
<article class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="p-8 sm:p-12 rounded-3xl bg-[#F5F6F8] border border-gray-200 shadow-xs prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line text-sm sm:text-base font-sans">
{{ $page->content }}
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#172B4D] hover:text-[#D6A84F] transition">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Halaman Depan</span>
            </a>
        </div>
    </div>
</article>
@endsection

