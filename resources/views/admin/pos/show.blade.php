@extends('layouts.admin')

@section('title', 'Detail Transaksi ' . $transaction->invoice_code)

@section('content')
<div class="space-y-6" x-data="{ showPaymentModal: false }">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pos.transactions') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold text-slate-800 font-mono">{{ $transaction->invoice_code }}</h1>
                    @if($transaction->payment_status === 'paid')
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Lunas
                        </span>
                    @elseif($transaction->payment_status === 'partial')
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i> DP / Bertahap
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> Belum Bayar
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    Dibuat pada {{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('l, d F Y - H:i') }} WIB oleh <span class="font-medium text-slate-700">{{ $transaction->user->name ?? 'Admin' }}</span>
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            @if($transaction->remaining_debt > 0)
                <button type="button" @click="showPaymentModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm shadow-sm transition-colors">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Catat Pelunasan</span>
                </button>
            @endif

            <a href="{{ route('admin.pos.thermal-receipt', $transaction->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-sm transition-colors shadow-sm">
                <i data-lucide="printer" class="w-4 h-4 text-slate-500"></i>
                <span>Struk Thermal</span>
            </a>

            <a href="{{ route('admin.pos.invoice-pdf', $transaction->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#172B4D] hover:bg-[#101D33] text-white font-medium text-sm shadow-sm transition-colors cursor-pointer">
                <i data-lucide="file-down" class="w-4 h-4"></i>
                <span>Cetak Invoice A4 (PDF)</span>
            </a>
        </div>
    </div>

    <!-- Debt Alert Banner if Partial / Unpaid -->
    @if($transaction->remaining_debt > 0)
    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
            </div>
            <div>
                <h4 class="font-bold text-amber-900 text-sm">Tagihan Belum Lunas (Sisa Piutang)</h4>
                <p class="text-xs text-amber-700 mt-0.5">
                    Terdapat sisa tagihan sebesar <strong class="text-amber-900">Rp {{ number_format($transaction->remaining_debt, 0, ',', '.') }}</strong>
                    @if($transaction->due_date)
                        dengan batas jatuh tempo <strong>{{ \Carbon\Carbon::parse($transaction->due_date)->translatedFormat('d F Y') }}</strong>.
                    @endif
                </p>
            </div>
        </div>
        <button type="button" @click="showPaymentModal = true" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold transition-colors shrink-0">
            Bayar Sekarang
        </button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info: Items & Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer & Order Meta -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4 text-primary"></i>
                    <span>Informasi Pelanggan & Pesanan</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-400 block font-medium">Data Pelanggan</span>
                        @if($transaction->customer)
                            <div class="font-bold text-slate-800 mt-1">{{ $transaction->customer->name }}</div>
                            @if($transaction->customer->phone)
                                <div class="text-xs text-slate-600 mt-1 flex items-center gap-1.5">
                                    <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                    <span>{{ $transaction->customer->phone }}</span>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $transaction->customer->phone) }}" target="_blank" class="text-emerald-600 hover:underline font-semibold text-[11px] ml-1">
                                        (Chat WA)
                                    </a>
                                </div>
                            @endif
                            @if($transaction->customer->address)
                                <div class="text-xs text-slate-500 mt-1.5 flex items-start gap-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5"></i>
                                    <span>{{ $transaction->customer->address }}</span>
                                </div>
                            @endif
                        @else
                            <div class="font-medium text-slate-700 mt-1">Pelanggan Umum (Walk-in Customer)</div>
                            <div class="text-xs text-slate-400 mt-0.5">Penjualan langsung tanpa identitas tersimpan</div>
                        @endif
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-400 block font-medium">Tipe Pesanan & Kasir</span>
                        <div class="mt-1 flex items-center gap-2">
                            @if($transaction->order_type === 'project_custom')
                                <span class="px-2.5 py-0.5 rounded-md text-xs font-bold bg-purple-100 text-purple-700">
                                    Proyek Custom Aluminium / Kaca
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-md text-xs font-bold bg-blue-100 text-blue-700">
                                    Penjualan Ritel Toko
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-600 mt-2">
                            Kasir: <strong class="text-slate-800">{{ $transaction->user->name ?? 'Admin' }}</strong>
                        </div>
                        @if($transaction->notes)
                            <div class="text-xs text-slate-500 mt-1 italic">
                                Catatan: "{{ $transaction->notes }}"
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="package" class="w-4 h-4 text-primary"></i>
                        <span>Daftar Rincian Produk & Jasa ({{ $transaction->items->count() }} Item)</span>
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-medium">
                                <th class="py-3 px-4">No</th>
                                <th class="py-3 px-4">Nama Produk / Material & Spesifikasi</th>
                                <th class="py-3 px-4 text-center">Satuan</th>
                                <th class="py-3 px-4 text-right">Harga Satuan</th>
                                <th class="py-3 px-4 text-center">Qty</th>
                                <th class="py-3 px-4 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($transaction->items as $index => $item)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-3 px-4 text-slate-400 text-xs">{{ $index + 1 }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-800">{{ $item->product->name ?? 'Item Kustom' }}</div>
                                    <div class="text-xs text-slate-400 font-mono mt-0.5">
                                        SKU: {{ $item->product->sku ?? '-' }}
                                    </div>
                                    @if($item->specification)
                                        <div class="text-xs text-primary font-medium mt-1 bg-primary/5 px-2 py-0.5 rounded inline-block">
                                            Spesifikasi: {{ $item->specification }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center text-xs text-slate-600">
                                    {{ $item->product->unit->symbol ?? $item->product->unit->name ?? 'pcs' }}
                                </td>
                                <td class="py-3 px-4 text-right text-slate-700">
                                    Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-slate-800">
                                    {{ (float)$item->quantity == (int)$item->quantity ? number_format($item->quantity, 0) : number_format($item->quantity, 2) }}
                                </td>
                                <td class="py-3 px-4 text-right font-bold text-slate-800">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar: Financial Summary & Payment History -->
        <div class="space-y-6">
            <!-- Summary Card -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i data-lucide="calculator" class="w-4 h-4 text-primary"></i>
                    <span>Ringkasan Keuangan</span>
                </h3>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal Item</span>
                        <span class="font-medium text-slate-800">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if($transaction->discount_amount > 0)
                    <div class="flex justify-between text-emerald-600">
                        <span>Diskon Khusus</span>
                        <span class="font-medium">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="pt-2 border-t border-slate-100 flex justify-between text-base font-bold text-slate-800">
                        <span>Grand Total</span>
                        <span class="text-primary font-mono">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-emerald-600 font-semibold pt-1">
                        <span>Total Terbayar</span>
                        <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
                    </div>

                    @if($transaction->remaining_debt > 0)
                    <div class="flex justify-between text-rose-600 font-bold bg-rose-50 p-2.5 rounded-xl border border-rose-100">
                        <span>Sisa Piutang</span>
                        <span>Rp {{ number_format($transaction->remaining_debt, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    @if($transaction->change_amount > 0)
                    <div class="flex justify-between text-slate-500 text-xs">
                        <span>Kembalian Kasir</span>
                        <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </div>

                @if($transaction->remaining_debt > 0)
                <div class="pt-3">
                    <button type="button" @click="showPaymentModal = true" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl text-sm flex items-center justify-center gap-2 shadow-sm transition-colors">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Input Pembayaran Baru</span>
                    </button>
                </div>
                @endif
            </div>

            <!-- Payment Timeline Card -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="history" class="w-4 h-4 text-primary"></i>
                        <span>Riwayat Pembayaran</span>
                    </h3>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-medium">
                        {{ $transaction->payments->count() }} kali
                    </span>
                </div>

                <div class="relative pl-6 space-y-4 before:content-[''] before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    @forelse($transaction->payments as $pmt)
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-white"></div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-800 text-sm">
                                    Rp {{ number_format($pmt->amount, 0, ',', '.') }}
                                </span>
                                <span class="text-[11px] uppercase tracking-wider font-mono font-semibold text-slate-500 bg-white px-1.5 py-0.5 rounded border border-slate-200">
                                    {{ $pmt->payment_type }}
                                </span>
                            </div>
                            <div class="text-xs text-slate-400 mt-1">
                                {{ \Carbon\Carbon::parse($pmt->payment_date)->translatedFormat('d M Y, H:i') }}
                            </div>
                            @if($pmt->notes)
                                <div class="text-xs text-slate-600 mt-1">
                                    {{ $pmt->notes }}
                                </div>
                            @endif
                            @if($pmt->reference_number)
                                <div class="text-[11px] text-slate-400 font-mono mt-0.5">
                                    Ref: {{ $pmt->reference_number }}
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 italic">Belum ada riwayat pembayaran tercatat.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Catat Pembayaran / Pelunasan Piutang -->
    <div x-show="showPaymentModal" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-200 overflow-hidden"
             @click.away="showPaymentModal = false">
            <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Catat Pembayaran Tagihan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Nota: {{ $transaction->invoice_code }}</p>
                </div>
                <button type="button" @click="showPaymentModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.pos.add-payment', $transaction->id) }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-xs text-amber-800">
                    Sisa Piutang Saat Ini: <strong class="text-amber-900 text-sm block mt-0.5">Rp {{ number_format($transaction->remaining_debt, 0, ',', '.') }}</strong>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Pembayaran (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="amount" min="1" max="{{ $transaction->remaining_debt }}" value="{{ $transaction->remaining_debt }}" required
                           class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary font-bold">
                    <p class="text-[11px] text-slate-400 mt-1">Maksimal: Rp {{ number_format($transaction->remaining_debt, 0, ',', '.') }} (Bisa bayar sebagian atau langsung lunas)</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Metode Pembayaran <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="flex items-center justify-center gap-1.5 p-2 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 text-xs font-medium">
                            <input type="radio" name="payment_type" value="cash" checked class="text-primary focus:ring-primary">
                            <span>Tunai</span>
                        </label>
                        <label class="flex items-center justify-center gap-1.5 p-2 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 text-xs font-medium">
                            <input type="radio" name="payment_type" value="transfer" class="text-primary focus:ring-primary">
                            <span>Transfer</span>
                        </label>
                        <label class="flex items-center justify-center gap-1.5 p-2 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 text-xs font-medium">
                            <input type="radio" name="payment_type" value="qris" class="text-primary focus:ring-primary">
                            <span>QRIS</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Referensi / Bukti Transfer (Opsional)</label>
                    <input type="text" name="reference_number" placeholder="Contoh: BCA-198234827"
                           class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                    <input type="text" name="notes" placeholder="Contoh: Pelunasan termin 2 saat barang terpasang"
                           class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                </div>

                <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                    <button type="button" @click="showPaymentModal = false" class="px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-colors">
                        Simpan Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

