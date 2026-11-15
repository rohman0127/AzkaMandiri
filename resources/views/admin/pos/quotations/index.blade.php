@extends('layouts.admin')

@section('title', 'Surat Penawaran Harga (Quotations)')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition">Dashboard</a>
                <span>/</span>
                <span>Operasional &amp; Kasir</span>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Penawaran Harga</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2.5">
                <i data-lucide="file-spreadsheet" class="w-7 h-7 text-[#D6A84F]"></i>
                <span>Surat Penawaran Harga (Quotation)</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Kelola penawaran harga resmi, estimasi proyek aluminium &amp; kaca, dan konversi ke transaksi kasir.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.pos.quotations.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-md shadow-primary/20 transition transform active:scale-95">
                <i data-lucide="plus-circle" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Buat Penawaran Baru</span>
            </a>
        </div>
    </div>

    <!-- KPI Summary Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Quotations -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Penawaran</p>
                <p class="text-xl font-extrabold text-slate-800 font-mono mt-1">{{ number_format($stats['total']) }}</p>
                <p class="text-[10px] text-slate-500 mt-0.5">Seluruh proposal tercatat</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center border border-slate-200">
                <i data-lucide="file-text" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Pending / Sent -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-sky-600 uppercase tracking-wider">Terkirim (Menunggu)</p>
                <p class="text-xl font-extrabold text-sky-700 font-mono mt-1">{{ number_format($stats['pending']) }}</p>
                <p class="text-[10px] text-slate-500 mt-0.5">Menunggu konfirmasi klien</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-200">
                <i data-lucide="send" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Accepted -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Disetujui / Diterima</p>
                <p class="text-xl font-extrabold text-emerald-700 font-mono mt-1">{{ number_format($stats['accepted']) }}</p>
                <p class="text-[10px] text-slate-500 mt-0.5">Siap dikonversi ke kasir</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-200">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Total Value -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-[#b45309] uppercase tracking-wider">Total Nilai Penawaran</p>
                <p class="text-lg font-extrabold text-[#0f172a] font-mono mt-1">Rp {{ number_format($stats['total_value'], 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-500 mt-0.5">{{ number_format($stats['converted']) }} telah jadi transaksi</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-[#D6A84F]/15 text-[#b45309] flex items-center justify-center border border-[#D6A84F]/30">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-4">
        <form action="{{ route('admin.pos.quotations.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <!-- Left: Search Box -->
            <div class="relative flex-1 min-w-[260px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Cari nomor penawaran, nama pelanggan, atau perusahaan..."
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
            </div>

            <!-- Middle: Status Selector -->
            <div class="flex items-center gap-2">
                <label for="status-filter" class="text-xs font-semibold text-slate-600 shrink-0">Status:</label>
                <select id="status-filter" name="status" onchange="this.form.submit()"
                        class="bg-slate-50 border border-slate-200 text-xs text-slate-700 font-semibold rounded-xl px-3 py-2 focus:outline-none focus:border-primary focus:bg-white transition">
                    <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Terkirim</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima (Accepted)</option>
                    <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Dikonversi ke Invoice</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Right: Date Range & Action Buttons -->
            <div class="flex items-center gap-2">
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                       class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-xl px-2.5 py-1.5 focus:outline-none focus:border-primary transition"
                       title="Tanggal Mulai">
                <span class="text-slate-400 text-xs">s/d</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                       class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-xl px-2.5 py-1.5 focus:outline-none focus:border-primary transition"
                       title="Tanggal Akhir">
                <button type="submit" 
                        class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-xl transition">
                    Filter
                </button>
                @if(request('q') || (request('status') && request('status') !== 'all') || request('start_date') || request('end_date'))
                    <a href="{{ route('admin.pos.quotations.index') }}" 
                       class="p-2 text-slate-400 hover:text-slate-600 rounded-xl border border-slate-200 hover:bg-slate-50 transition"
                       title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-4">No. Penawaran</th>
                        <th class="py-3.5 px-4">Pelanggan / Klien</th>
                        <th class="py-3.5 px-4">Tanggal &amp; Berlaku</th>
                        <th class="py-3.5 px-4 text-right">Total Nilai (Rp)</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($quotations as $q)
                    <tr class="hover:bg-slate-50/60 transition group">
                        
                        <!-- No Penawaran & Info -->
                        <td class="py-3.5 px-4">
                            <a href="{{ route('admin.pos.quotations.show', $q) }}" class="font-bold text-slate-900 hover:text-primary flex items-center gap-1.5 font-mono">
                                <i data-lucide="file-text" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                                <span>{{ $q->quotation_number }}</span>
                            </a>
                            <div class="text-[10px] text-slate-400 mt-0.5 flex items-center gap-1">
                                <span>{{ $q->items->count() }} item</span>
                                <span>&bull;</span>
                                <span>{{ $q->order_type === 'retail' ? 'Ritel' : 'Pekerjaan Custom' }}</span>
                            </div>
                        </td>

                        <!-- Pelanggan -->
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-800">{{ $q->effective_customer_name }}</div>
                            @if($q->effective_customer_company)
                                <div class="text-[10px] text-slate-500 font-medium">{{ $q->effective_customer_company }}</div>
                            @endif
                            <div class="text-[10px] text-slate-400">{{ $q->effective_customer_phone }}</div>
                        </td>

                        <!-- Tanggal & Masa Berlaku -->
                        <td class="py-3.5 px-4">
                            <div class="text-slate-700 font-medium">{{ $q->date ? $q->date->format('d M Y') : '-' }}</div>
                            <div class="text-[10px] mt-0.5 flex items-center gap-1 {{ $q->is_expired ? 'text-rose-500 font-bold' : 'text-slate-400' }}">
                                @if($q->is_expired)
                                    <i data-lucide="alert-circle" class="w-3 h-3 text-rose-500"></i>
                                    <span>Kedaluwarsa ({{ $q->valid_until ? $q->valid_until->format('d M Y') : '-' }})</span>
                                @else
                                    <span>Berlaku s/d {{ $q->valid_until ? $q->valid_until->format('d M Y') : '-' }}</span>
                                @endif
                            </div>
                        </td>

                        <!-- Nilai Penawaran -->
                        <td class="py-3.5 px-4 text-right">
                            <div class="font-mono font-bold text-slate-900 text-sm">
                                Rp {{ number_format($q->grand_total, 0, ',', '.') }}
                            </div>
                            @if($q->discount > 0)
                                <div class="text-[10px] text-emerald-600 font-mono">
                                    Diskon: -Rp {{ number_format($q->discount, 0, ',', '.') }}
                                </div>
                            @endif
                        </td>

                        <!-- Status Badge -->
                        <td class="py-3.5 px-4 text-center">
                            @php $badge = $q->status_badge; @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badge['bg'] }} {{ $badge['text'] }} {{ $badge['border'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }}"></span>
                                <span>{{ $badge['label'] }}</span>
                            </span>
                            @if($q->status === 'converted' && $q->convertedTransaction)
                                <div class="mt-1">
                                    <a href="{{ route('admin.pos.show', $q->convertedTransaction) }}" 
                                       class="text-[10px] font-mono text-purple-600 hover:text-purple-800 underline flex items-center justify-center gap-0.5">
                                        <span>Inv: {{ $q->convertedTransaction->invoice_code }}</span>
                                        <i data-lucide="external-link" class="w-2.5 h-2.5"></i>
                                    </a>
                                </div>
                            @endif
                        </td>

                        <!-- Action Buttons -->
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                
                                <!-- Detail -->
                                <a href="{{ route('admin.pos.quotations.show', $q) }}"
                                   class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition"
                                   title="Lihat Detail Penawaran">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                <!-- Print PDF -->
                                <a href="{{ route('admin.pos.quotations.pdf', $q) }}" target="_blank"
                                   class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition"
                                   title="Cetak Dokumen PDF">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>

                                <!-- Konversi ke POS (jika belum dikonversi) -->
                                @if($q->status !== 'converted')
                                <form action="{{ route('admin.pos.quotations.convert', $q) }}" method="POST" class="inline"
                                      data-confirm="Konversi surat penawaran {{ $q->quotation_number }} menjadi transaksi Kasir &amp; Invoice penjualan?">
                                    @csrf
                                    <button type="submit"
                                            class="p-1.5 rounded-lg text-slate-500 hover:text-purple-600 hover:bg-purple-50 transition"
                                            title="Konversi ke Penjualan / Kasir POS">
                                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif

                                <!-- Edit (jika belum dikonversi) -->
                                @if($q->status !== 'converted')
                                <a href="{{ route('admin.pos.quotations.edit', $q) }}"
                                   class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition"
                                   title="Edit Penawaran">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                @endif

                                <!-- Delete (jika belum dikonversi) -->
                                @if($q->status !== 'converted')
                                <form action="{{ route('admin.pos.quotations.destroy', $q) }}" method="POST" class="inline form-delete"
                                      data-confirm="Hapus surat penawaran {{ $q->quotation_number }}? Tindakan ini tidak dapat dibatalkan.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                            title="Hapus Penawaran">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                <i data-lucide="file-question" class="w-7 h-7"></i>
                            </div>
                            <p class="font-bold text-slate-700 text-sm">Belum Ada Surat Penawaran</p>
                            <p class="text-xs text-slate-400 mt-1">Buat estimasi harga proyek baru untuk pelanggan Anda.</p>
                            <div class="mt-4">
                                <a href="{{ route('admin.pos.quotations.create') }}" 
                                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-primary text-white text-xs font-bold hover:bg-primary-hover transition">
                                    <i data-lucide="plus" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                                    <span>Buat Penawaran Pertama</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($quotations->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $quotations->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
