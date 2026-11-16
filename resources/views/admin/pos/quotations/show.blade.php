@extends('layouts.admin')

@section('title', 'Detail Penawaran ' . $quotation->quotation_number)

@section('content')
<div class="space-y-6">

    <!-- Top Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight font-mono">
                    {{ $quotation->quotation_number }}
                </h1>
                @php $badge = $quotation->status_badge; @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $badge['bg'] }} {{ $badge['text'] }} {{ $badge['border'] }}">
                    <span class="w-2 h-2 rounded-full {{ $badge['dot'] }}"></span>
                    <span>{{ $badge['label'] }}</span>
                </span>
                @if($quotation->is_expired)
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                        <i data-lucide="clock" class="w-3 h-3"></i>
                        <span>Kedaluwarsa</span>
                    </span>
                @endif
            </div>
            <p class="text-xs text-slate-500 mt-1">Diterbitkan pada {{ $quotation->date ? $quotation->date->translatedFormat('d F Y') : '-' }} &bull; Estimator: <strong>{{ $quotation->creator->name ?? 'Admin' }}</strong></p>
        </div>

        <!-- Action Buttons Toolbar -->
        <div class="flex flex-wrap items-center gap-2">
            
            <!-- Cetak PDF -->
            <a href="{{ route('admin.pos.quotations.pdf', $quotation) }}" target="_blank"
               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold shadow-xs transition">
                <i data-lucide="printer" class="w-4 h-4 text-rose-600"></i>
                <span>Cetak / Ekspor PDF</span>
            </a>

            <!-- Konversi ke Kasir (POS) -->
            @if($quotation->status !== 'converted')
            <form action="{{ route('admin.pos.quotations.convert', $quotation) }}" method="POST" class="inline"
                  data-confirm="Konversi surat penawaran {{ $quotation->quotation_number }} langsung ke Transaksi Kasir / Invoice Penjualan?">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold shadow-md shadow-purple-600/20 transition transform active:scale-95">
                    <i data-lucide="shopping-bag" class="w-4 h-4 text-purple-200"></i>
                    <span>Konversi ke Kasir (POS)</span>
                </button>
            </form>
            @endif

            <!-- Edit (jika belum dikonversi) -->
            @if($quotation->status !== 'converted')
            <a href="{{ route('admin.pos.quotations.edit', $quotation) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                <span>Edit</span>
            </a>
            @endif

            <!-- Hapus (jika belum dikonversi) -->
            @if($quotation->status !== 'converted')
            <form action="{{ route('admin.pos.quotations.destroy', $quotation) }}" method="POST" class="inline form-delete"
                  data-confirm="Hapus surat penawaran {{ $quotation->quotation_number }} secara permanen?">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="p-2 rounded-xl text-rose-500 hover:bg-rose-50 hover:text-rose-700 transition"
                        title="Hapus Penawaran">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </form>
            @endif

        </div>
    </div>

    <!-- CONVERTED BANNER ALERT (Jika sudah jadi transaksi) -->
    @if($quotation->status === 'converted' && $quotation->convertedTransaction)
    <div class="p-4 rounded-2xl bg-gradient-to-r from-purple-900 to-indigo-900 text-white shadow-md flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center shrink-0">
                <i data-lucide="check-check" class="w-6 h-6 text-emerald-400"></i>
            </div>
            <div>
                <p class="font-bold text-sm">Surat Penawaran Telah Dikonversi Menjadi Transaksi Kasir!</p>
                <p class="text-xs text-purple-200 mt-0.5">
                    Nomor Nota / Invoice: <strong class="font-mono text-white">{{ $quotation->convertedTransaction->invoice_code }}</strong> &bull; Total: Rp {{ number_format($quotation->convertedTransaction->total_amount, 0, ',', '.') }}
                </p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.pos.show', $quotation->convertedTransaction) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-purple-950 font-bold text-xs hover:bg-purple-50 transition shadow-sm">
                <span>Buka Detail Transaksi</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- QUICK STATUS CHANGER (Jika belum dikonversi) -->
    @if($quotation->status !== 'converted')
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-slate-700">Perbarui Status Penawaran:</span>
            <span class="text-[11px] text-slate-400">Klik tombol untuk mengubah tahapan proposal:</span>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            
            @if($quotation->status !== 'draft')
            <form action="{{ route('admin.pos.quotations.status', $quotation) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="draft">
                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                    Kembalikan ke Draft
                </button>
            </form>
            @endif

            @if($quotation->status !== 'sent')
            <form action="{{ route('admin.pos.quotations.status', $quotation) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="sent">
                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 transition flex items-center gap-1.5">
                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                    <span>Tandai Terkirim ke Klien</span>
                </button>
            </form>
            @endif

            @if($quotation->status !== 'accepted')
            <form action="{{ route('admin.pos.quotations.status', $quotation) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="accepted">
                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-300 transition flex items-center gap-1.5">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                    <span>Disetujui / Diterima Klien</span>
                </button>
            </form>
            @endif

            @if($quotation->status !== 'rejected')
            <form action="{{ route('admin.pos.quotations.status', $quotation) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="rejected">
                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition flex items-center gap-1.5">
                    <i data-lucide="x-circle" class="w-3.5 h-3.5"></i>
                    <span>Tandai Ditolak</span>
                </button>
            </form>
            @endif

        </div>
    </div>
    @endif

    <!-- MAIN CONTENT: 2 COLUMNS (8 cols & 4 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Customer, Items, Terms (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Customer & Project Location Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="user-check" class="w-4 h-4 text-[#D6A84F]"></i>
                        <span>Informasi Klien &amp; Lokasi Pekerjaan</span>
                    </h3>
                    @if($quotation->customer)
                        <a href="{{ route('admin.customers.show', $quotation->customer) }}" 
                           class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                            <span>Buka Profil Pelanggan</span>
                            <i data-lucide="external-link" class="w-3 h-3"></i>
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Klien / Kontak</p>
                        <p class="font-bold text-slate-900 text-sm mt-0.5">{{ $quotation->effective_customer_name }}</p>
                        @if($quotation->effective_customer_company)
                            <p class="text-slate-600 font-medium mt-0.5">{{ $quotation->effective_customer_company }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kontak / Telepon</p>
                        <p class="font-bold text-slate-800 font-mono mt-0.5 flex items-center gap-2">
                            <span>{{ $quotation->effective_customer_phone }}</span>
                            @if($quotation->effective_customer_phone && $quotation->effective_customer_phone !== '-')
                                @php
                                    $waNumber = preg_replace('/[^0-9]/', '', $quotation->effective_customer_phone);
                                    if (str_starts_with($waNumber, '0')) {
                                        $waNumber = '62' . substr($waNumber, 1);
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}?text=Halo%20{{ urlencode($quotation->effective_customer_name) }},%20kami%20dari%20AzkaMandiri%20ingin%20mengonfirmasi%20Surat%20Penawaran%20{{ urlencode($quotation->quotation_number) }}."
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-md text-[10px] font-bold border border-emerald-200 transition">
                                    <i data-lucide="message-circle" class="w-3 h-3"></i>
                                    <span>WhatsApp</span>
                                </a>
                            @endif
                        </p>
                    </div>
                    <div class="sm:col-span-2 pt-2 border-t border-slate-50">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Lokasi Proyek / Alamat Pemasangan</p>
                        <p class="text-slate-700 mt-0.5 leading-relaxed">
                            {{ $quotation->effective_customer_address ?: 'Lokasi disesuaikan dengan instruksi klien / workshop' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Items & Specifications Table Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                            <i data-lucide="package" class="w-4 h-4 text-primary"></i>
                            <span>Rincian Item Barang &amp; Jasa Fabrikasi</span>
                        </h3>
                    </div>
                    <span class="text-xs font-bold text-slate-500 font-mono">{{ $quotation->items->count() }} Baris Item</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100/80 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[10px]">
                                <th class="py-3 px-4 w-10 text-center">No</th>
                                <th class="py-3 px-4">Deskripsi Barang / Item Pekerjaan</th>
                                <th class="py-3 px-4">Dimensi / Spesifikasi</th>
                                <th class="py-3 px-4 text-center">Volume</th>
                                <th class="py-3 px-4 text-center">Satuan</th>
                                <th class="py-3 px-4 text-right">Harga Satuan (Rp)</th>
                                <th class="py-3 px-4 text-right">Total Harga (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($quotation->items as $idx => $item)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3 px-4 text-center text-slate-400 font-mono font-bold">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900">{{ $item->item_name }}</div>
                                    @if($item->product && $item->product->sku)
                                        <div class="text-[10px] text-slate-400 font-mono">SKU: {{ $item->product->sku }}</div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-slate-600">
                                    {{ $item->dimensions ?: '-' }}
                                </td>
                                <td class="py-3 px-4 text-center font-bold font-mono text-slate-800">
                                    {{ (float)$item->quantity == (int)$item->quantity ? (int)$item->quantity : number_format($item->quantity, 2, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center text-slate-500">
                                    {{ $item->unit_name ?: ($item->product->unit->symbol ?? 'unit') }}
                                </td>
                                <td class="py-3 px-4 text-right font-mono text-slate-700">
                                    Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-right font-mono font-bold text-slate-900">
                                    Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Terms & Conditions Box -->
            @if($quotation->terms_conditions)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-3">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                    <span>Syarat &amp; Ketentuan Penawaran (Terms &amp; Conditions)</span>
                </h3>
                <div class="text-xs text-slate-600 leading-relaxed whitespace-pre-line bg-slate-50/70 p-4 rounded-xl border border-slate-200/60 font-sans">
                    {{ $quotation->terms_conditions }}
                </div>
            </div>
            @endif

            <!-- Project Notes Box -->
            @if($quotation->notes)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-3">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i data-lucide="message-square" class="w-4 h-4 text-[#D6A84F]"></i>
                    <span>Catatan Khusus Pekerjaan</span>
                </h3>
                <div class="text-xs text-slate-600 leading-relaxed whitespace-pre-line bg-slate-50/70 p-4 rounded-xl border border-slate-200/60">
                    {{ $quotation->notes }}
                </div>
            </div>
            @endif

        </div>

        <!-- Right: Financial Summary & Meta Details (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Financial Calculation Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 flex items-center gap-2">
                    <i data-lucide="calculator" class="w-4 h-4 text-[#D6A84F]"></i>
                    <span>Ringkasan Keuangan Proyek</span>
                </h3>

                <div class="space-y-2.5 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Subtotal Nilai Item:</span>
                        <span class="font-mono font-bold text-slate-800">Rp {{ number_format($quotation->subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if($quotation->discount > 0)
                    <div class="flex items-center justify-between text-emerald-600">
                        <span>Potongan Diskon:</span>
                        <span class="font-mono font-bold">- Rp {{ number_format($quotation->discount, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    @if($quotation->tax > 0)
                    <div class="flex items-center justify-between text-slate-700">
                        <span>PPN / Pajak Terkait:</span>
                        <span class="font-mono font-bold">+ Rp {{ number_format($quotation->tax, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </div>

                <!-- Grand Total Box -->
                <div class="pt-3 border-t-2 border-slate-900 mt-2">
                    <div class="p-4 rounded-xl bg-slate-900 text-white flex items-center justify-between shadow-md">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Kesepakatan</p>
                            <p class="text-xs text-slate-300">Grand Total Penawaran</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-extrabold text-[#D6A84F] font-mono">
                                Rp {{ number_format($quotation->grand_total, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Print CTA -->
                <div class="pt-2">
                    <a href="{{ route('admin.pos.quotations.pdf', $quotation) }}" target="_blank"
                       class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold flex items-center justify-center gap-2 transition">
                        <i data-lucide="file-down" class="w-4 h-4 text-rose-600"></i>
                        <span>Unduh Surat Penawaran (PDF)</span>
                    </a>
                </div>
            </div>

            <!-- Document Meta Details Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-3.5 text-xs">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">
                    Metadata Dokumen
                </h3>

                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Tipe Pekerjaan:</span>
                    <span class="font-semibold text-slate-800">{{ $quotation->order_type === 'retail' ? 'Pengadaan Bahan Ritel' : 'Pekerjaan Custom Fabrikasi' }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Tanggal Diterbitkan:</span>
                    <span class="font-bold text-slate-800">{{ $quotation->date ? $quotation->date->format('d/m/Y') : '-' }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Masa Berlaku:</span>
                    <span class="font-bold {{ $quotation->is_expired ? 'text-rose-600' : 'text-slate-800' }}">
                        {{ $quotation->valid_until ? $quotation->valid_until->format('d/m/Y') : '-' }}
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Disiapkan Oleh:</span>
                    <span class="font-semibold text-slate-800">{{ $quotation->creator->name ?? 'Admin' }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Dibuat Sistem:</span>
                    <span class="text-slate-400 font-mono">{{ $quotation->created_at ? $quotation->created_at->format('d/m/Y H:i') : '-' }}</span>
                </div>
            </div>

            <!-- Rekening Pembayaran Card -->
            <div class="bg-slate-50 rounded-2xl border border-slate-200/80 p-5 space-y-2 text-xs">
                <p class="font-bold text-slate-800 uppercase tracking-wider text-[11px] flex items-center gap-1.5">
                    <i data-lucide="credit-card" class="w-3.5 h-3.5 text-primary"></i>
                    <span>Rekening Resmi AzkaMandiri</span>
                </p>
                <div class="space-y-1.5 pt-1 text-slate-600">
                    <div>
                        <p class="font-semibold text-slate-800">Bank Mandiri</p>
                        <p class="font-mono text-[11px] text-slate-700">156-00-1888-9999</p>
                        <p class="text-[10px] text-slate-400">a.n. CV Azka Mandiri Perkasa</p>
                    </div>
                    <div class="pt-1.5 border-t border-slate-200/60">
                        <p class="font-semibold text-slate-800">Bank BCA</p>
                        <p class="font-mono text-[11px] text-slate-700">842-099-1234</p>
                        <p class="text-[10px] text-slate-400">a.n. Azka Mandiri</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

