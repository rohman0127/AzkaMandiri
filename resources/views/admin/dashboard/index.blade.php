@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('breadcrumb', 'Ringkasan Statistik & Aktivitas AzkaMandiri')

@section('content')
<div class="space-y-8">
    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <!-- Card 1: Services -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <i data-lucide="wrench" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Layanan</p>
                <h3 class="text-2xl font-extrabold text-[#172B4D] mt-0.5">{{ $stats['total_services'] }}</h3>
            </div>
        </div>

        <!-- Card 2: Portfolios -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-[#D6A84F] flex items-center justify-center shrink-0">
                <i data-lucide="images" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Portofolio</p>
                <h3 class="text-2xl font-extrabold text-[#172B4D] mt-0.5">{{ $stats['total_portfolios'] }}</h3>
            </div>
        </div>

        <!-- Card 3: Articles -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <i data-lucide="newspaper" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Artikel</p>
                <h3 class="text-2xl font-extrabold text-[#172B4D] mt-0.5">{{ $stats['total_articles'] }}</h3>
            </div>
        </div>

        <!-- Card 4: Testimonials -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="quote" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Testimoni</p>
                <h3 class="text-2xl font-extrabold text-[#172B4D] mt-0.5">{{ $stats['total_testimonials'] }}</h3>
            </div>
        </div>

        <!-- Card 5: Total Messages -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <i data-lucide="mail" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pesan</p>
                <h3 class="text-2xl font-extrabold text-[#172B4D] mt-0.5">{{ $stats['total_messages'] }}</h3>
            </div>
        </div>

        <!-- Card 6: Unread Messages -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ $stats['unread_messages'] > 0 ? 'bg-red-50 text-red-600' : 'bg-gray-50 text-gray-400' }} flex items-center justify-center shrink-0">
                <i data-lucide="mail-warning" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pesan Baru</p>
                <h3 class="text-2xl font-extrabold {{ $stats['unread_messages'] > 0 ? 'text-red-600' : 'text-gray-400' }} mt-0.5">{{ $stats['unread_messages'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Quick Action Bar -->
    <div class="bg-gradient-to-r from-[#172B4D] to-[#101D33] rounded-2xl p-6 text-white flex flex-col md:flex-row items-center justify-between gap-4 shadow-md">
        <div>
            <h2 class="text-lg font-bold">Kelola Konten AzkaMandiri dengan Cepat</h2>
            <p class="text-xs text-gray-300 mt-1">Tambahkan layanan baru, unggah hasil portofolio proyek, atau perbarui informasi kontak langsung.</p>
        </div>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('admin.services.create') }}" class="px-3.5 py-2 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Layanan</span>
            </a>
            <a href="{{ route('admin.portfolios.create') }}" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition flex items-center gap-1.5 border border-white/20">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Portofolio</span>
            </a>
            <a href="{{ route('admin.articles.create') }}" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition flex items-center gap-1.5 border border-white/20">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tulis Artikel</span>
            </a>
        </div>
    </div>

    <!-- Content Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Messages (2 Columns) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-[#172B4D]">Pesan Masuk Terbaru</h2>
                    <p class="text-xs text-gray-500">Form kontak dari pengunjung website</p>
                </div>
                <a href="{{ route('admin.contact-messages.index') }}" class="text-xs font-semibold text-[#D6A84F] hover:underline flex items-center gap-1">
                    <span>Lihat Semua Pesan</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($recentMessages as $msg)
                    <div class="p-5 hover:bg-gray-50/80 transition flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm text-[#172B4D]">{{ $msg->name }}</span>
                                <span class="text-xs text-gray-400">• {{ $msg->created_at->diffForHumans() }}</span>
                                @if($msg->status === 'unread')
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-700">Baru</span>
                                @elseif($msg->status === 'followed_up')
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-700">Ditindaklanjuti</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-gray-100 text-gray-600">Dibaca</span>
                                @endif
                            </div>
                            <p class="text-xs font-semibold text-gray-700">{{ $msg->subject }}</p>
                            <p class="text-xs text-gray-500 line-clamp-1">{{ Str::limit($msg->message, 90) }}</p>
                            <div class="text-[11px] text-gray-400 flex items-center gap-4 pt-1">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="phone" class="w-3 h-3 text-[#D6A84F]"></i>
                                    {{ $msg->phone_number }}
                                </span>
                                @if($msg->email)
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="mail" class="w-3 h-3"></i>
                                        {{ $msg->email }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('admin.contact-messages.show', $msg->id) }}" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition shrink-0">
                            <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                @empty
                    <div class="p-10 text-center text-gray-400">
                        <i data-lucide="inbox" class="w-10 h-10 mx-auto text-gray-300 mb-2"></i>
                        <p class="text-sm">Belum ada pesan masuk dari formulir kontak.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Portfolios & System Status (1 Column) -->
        <div class="space-y-6">
            <!-- Portfolios Preview -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-[#172B4D]">Portofolio Terbaru</h3>
                    <a href="{{ route('admin.portfolios.index') }}" class="text-xs text-[#D6A84F] font-semibold hover:underline">Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse($recentPortfolios as $port)
                        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 transition">
                            <img src="{{ $port->main_image ?: asset('assets/brand/logo-icon.svg') }}" alt="{{ $port->title }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200 shrink-0 bg-gray-100">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold text-[#172B4D] truncate">{{ $port->title }}</p>
                                <p class="text-[11px] text-gray-400 truncate">{{ $port->location ?: 'Lokasi Proyek' }}</p>
                            </div>
                            <a href="{{ route('admin.portfolios.edit', $port->id) }}" class="text-gray-400 hover:text-[#172B4D] p-1">
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada portofolio.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

