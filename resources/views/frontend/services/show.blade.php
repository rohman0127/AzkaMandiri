@extends('layouts.app')

@section('meta_title', $service->meta_title ?: $service->name . ' – AzkaMandiri')
@section('meta_description', $service->meta_description ?: Str::limit($service->excerpt, 155))
@section('og_image', $service->main_image ? asset($service->main_image) : asset('assets/brand/logo-horizontal.svg'))

@section('content')
<!-- Breadcrumbs -->
<div class="bg-[#F5F6F8] py-4 border-b border-gray-200">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-[#172B4D] transition">Home</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <a href="{{ route('services.index') }}" class="hover:text-[#172B4D] transition">Layanan</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-[#172B4D] font-bold truncate">{{ $service->name }}</span>
        </nav>
    </div>
</div>

<!-- Main Detail Section -->
<section class="py-12 lg:py-16 bg-white">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left: Photos & Gallery -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Main Featured Photo -->
                <div class="rounded-3xl overflow-hidden border border-gray-200 shadow-lg bg-gray-100">
                    <img src="{{ $service->main_image ?: ($service->thumbnail ?: asset('assets/brand/logo-icon.svg')) }}" 
                         alt="{{ $service->name }}" 
                         class="w-full h-80 sm:h-[450px] object-cover">
                </div>

                <!-- Gallery Grid -->
                @if($service->images->isNotEmpty())
                    <div class="space-y-3 pt-2">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Galeri Dokumentasi Pemasangan</h4>
                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                            @foreach($service->images as $img)
                                <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-xs group cursor-pointer bg-gray-100">
                                    <img src="{{ $img->image_path }}" alt="Dokumentasi {{ $service->name }}" 
                                         class="w-full h-24 object-cover group-hover:scale-105 transition duration-300">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right: Service Details & Booking Card -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    @if($service->category)
                        <span class="inline-block px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider mb-3">
                            {{ $service->category->name }}
                        </span>
                    @endif
                    <h1 class="text-2xl sm:text-4xl font-extrabold text-[#172B4D] tracking-tight leading-tight">
                        {{ $service->name }}
                    </h1>
                </div>

                <!-- Price Highlight Box -->
                @if($service->price_info)
                    <div class="p-4 rounded-2xl bg-[#F5F6F8] border border-gray-200 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase">Estimasi Biaya</p>
                            <p class="text-lg font-extrabold text-[#172B4D] mt-0.5">{{ $service->price_info }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-amber-100 text-[#a97e2c] text-[10px] font-bold uppercase tracking-wider">
                            Survei Lokasi Gratis
                        </span>
                    </div>
                @endif

                <!-- Excerpt -->
                <p class="text-sm text-gray-600 leading-relaxed font-medium">
                    {{ $service->excerpt }}
                </p>

                <!-- Features Checklist -->
                @if(!empty($service->features) && is_array($service->features))
                    <div class="space-y-3 pt-2">
                        <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Keunggulan &amp; Spesifikasi:</h4>
                        <ul class="space-y-2">
                            @foreach($service->features as $feature)
                                <li class="flex items-center gap-2.5 text-xs sm:text-sm text-gray-700">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    </div>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- WhatsApp Booking Action -->
                <div class="pt-6 border-t border-gray-100 space-y-3">
                    <a href="{{ wa_service_link($service->name) }}" target="_blank"
                       class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-[#D6A84F] to-[#b88d3b] hover:from-[#e0b45b] hover:to-[#c79a45] text-[#101D33] font-bold text-sm uppercase tracking-wider transition shadow-lg shadow-[#D6A84F]/25 flex items-center justify-center gap-2">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                        <span>Konsultasi Layanan Ini via WhatsApp</span>
                    </a>
                    <p class="text-center text-[11px] text-gray-400">
                        Diskusi langsung dengan teknisi AzkaMandiri • Respon Cepat Setiap Hari
                    </p>
                </div>
            </div>
        </div>

        <!-- Full Detailed Description -->
        <div class="mt-16 pt-12 border-t border-gray-100 space-y-6">
            <h3 class="text-2xl font-bold text-[#172B4D]">Deskripsi Lengkap Layanan</h3>
            <div class="prose max-w-none text-gray-600 leading-relaxed whitespace-pre-line text-sm sm:text-base">
{{ $service->description }}
            </div>
        </div>

        <!-- Related Services -->
        @if($relatedServices->isNotEmpty())
            <div class="mt-20 pt-12 border-t border-gray-100 space-y-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-[#172B4D]">Layanan Terkait Lainnya</h3>
                        <p class="text-xs text-gray-500">Pilihan produk aluminium dan kaca pendukung</p>
                    </div>
                    <a href="{{ route('services.index') }}" class="text-xs font-bold text-[#D6A84F] hover:underline flex items-center gap-1">
                        <span>Semua Layanan</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedServices as $rel)
                        <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden shadow-xs hover:shadow-lg transition flex flex-col justify-between group">
                            <div class="h-44 overflow-hidden bg-gray-100">
                                <img src="{{ $rel->thumbnail ?: ($rel->main_image ?: asset('assets/brand/logo-icon.svg')) }}" 
                                     alt="{{ $rel->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>
                            <div class="p-5 space-y-2">
                                <h4 class="font-bold text-sm text-[#172B4D] group-hover:text-[#D6A84F] transition">
                                    <a href="{{ route('services.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h4>
                                <p class="text-xs text-gray-400 line-clamp-2">{{ $rel->excerpt }}</p>
                                <div class="pt-2">
                                    <a href="{{ route('services.show', $rel->slug) }}" class="text-xs font-bold text-[#D6A84F] hover:underline">
                                        Lihat Detail &rarr;
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

