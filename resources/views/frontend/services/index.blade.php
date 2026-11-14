@extends('layouts.app')

@section('meta_title', 'Layanan Aluminium & Kaca – AzkaMandiri')
@section('meta_description', 'Katalog lengkap layanan kusen aluminium, jendela, pintu, partisi ruangan, kaca tempered, kanopi, shower box, etalase, dan pengerjaan custom.')

@section('content')
<!-- Header Banner -->
<section class="bg-[#101D33] text-white py-14 lg:py-20 relative overflow-hidden">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 text-center relative z-10 space-y-4">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-[#D6A84F] font-bold text-xs uppercase tracking-wider border border-white/10">
            <i data-lucide="wrench" class="w-3.5 h-3.5"></i>
            <span>Katalog Lengkap</span>
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
            Layanan Aluminium &amp; Kaca
        </h1>
        <p class="text-sm sm:text-base text-gray-300 max-w-2xl mx-auto">
            Temukan solusi terbaik untuk pintu, jendela, partisi, fasad, dan custom interior bangunan Anda.
        </p>
    </div>
</section>

<!-- Main Filter & Grid -->
<section class="py-16 bg-[#F5F6F8]">
    <div class="w-full px-4 sm:px-6 lg:px-10 xl:px-14 space-y-8">
        <!-- Search and Category Filter -->
        <div class="bg-white p-6 rounded-3xl border border-gray-200/80 shadow-xs space-y-4">
            <!-- Search Form -->
            <form method="GET" action="{{ route('services.index') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari layanan (contoh: kusen, sliding, partisi)..."
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
                <a href="{{ route('services.index', request()->only('q')) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ !request('kategori') ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Semua Layanan
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('services.index', array_merge(request()->only('q'), ['kategori' => $cat->slug])) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ request('kategori') === $cat->slug ? 'bg-[#D6A84F] text-[#101D33] font-bold shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $cat->name }} ({{ $cat->services_count }})
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $srv)
                <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <div class="relative h-56 overflow-hidden bg-gray-100">
                        <img src="{{ $srv->thumbnail ?: ($srv->main_image ?: asset('assets/brand/logo-icon.svg')) }}" 
                             alt="{{ $srv->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @if($srv->category)
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-[#101D33]/85 text-white text-[10px] font-bold tracking-wider uppercase border border-white/10">
                                {{ $srv->category->name }}
                            </span>
                        @endif
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <h3 class="text-xl font-bold text-[#172B4D] group-hover:text-[#D6A84F] transition">
                                <a href="{{ route('services.show', $srv->slug) }}">
                                    {{ $srv->name }}
                                </a>
                            </h3>
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                {{ $srv->excerpt }}
                            </p>
                        </div>

                        <!-- Feature highlights -->
                        @if(!empty($srv->features) && is_array($srv->features))
                            <div class="pt-3 border-t border-gray-100 space-y-1.5">
                                @foreach(array_slice($srv->features, 0, 3) as $feat)
                                    <div class="flex items-center gap-2 text-xs text-gray-600">
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-[#D6A84F] shrink-0"></i>
                                        <span class="truncate">{{ $feat }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Price Info -->
                        @if($srv->price_info)
                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                                <span class="text-gray-400">Estimasi:</span>
                                <span class="font-bold text-[#172B4D]">{{ $srv->price_info }}</span>
                            </div>
                        @endif

                        <!-- Card Actions -->
                        <div class="pt-2 flex items-center gap-2">
                            <a href="{{ route('services.show', $srv->slug) }}" 
                               class="flex-1 py-2.5 px-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-[#172B4D] text-xs font-bold text-center transition">
                                Detail Layanan
                            </a>
                            <a href="{{ wa_service_link($srv->name) }}" target="_blank"
                               class="p-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold transition shrink-0"
                               title="Pesan via WhatsApp">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-gray-400">
                    <i data-lucide="search-x" class="w-12 h-12 mx-auto text-gray-300 mb-3"></i>
                    <p class="text-base font-semibold">Tidak ditemukan layanan yang sesuai dengan pencarian.</p>
                    <a href="{{ route('services.index') }}" class="inline-block mt-4 text-xs font-bold text-[#D6A84F] hover:underline">
                        Lihat Semua Layanan
                    </a>
                </div>
            @endforelse
        </div>

        @if($services->hasPages())
            <div class="pt-6">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

