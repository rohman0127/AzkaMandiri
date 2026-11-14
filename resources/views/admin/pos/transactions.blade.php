@extends('layouts.admin')

@section('title', 'Riwayat Transaksi POS & Penjualan')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.pos.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Riwayat Transaksi POS</h1>
                    <p class="text-sm text-slate-500">Pencatatan seluruh penjualan kasir ritel, pesanan custom, dan pembayaran piutang</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.pos.transactions.export', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 font-semibold text-xs shadow-xs hover:bg-slate-50 transition cursor-pointer">
                <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i>
                <span>Ekspor Excel/CSV</span>
            </a>
            <a href="{{ route('admin.pos.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#D6A84F] text-[#101D33] font-bold hover:bg-[#c4963e] shadow-sm transition-all cursor-pointer">
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                <span>Buka Kasir POS</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Transaksi</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($transactions->total(), 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Nota terdaftar</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="receipt" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Penerimaan Kas</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p class="text-xs text-emerald-600 font-medium mt-0.5">Kasir & Pelunasan</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sisa Piutang / Tagihan</p>
                <h3 class="text-2xl font-bold text-amber-600 mt-1">Rp {{ number_format($totalReceivable, 0, ',', '.') }}</h3>
                <p class="text-xs text-amber-600 font-medium mt-0.5">Belum Lunas / DP</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Laporan Lengkap</p>
                <div class="mt-2">
                    <a href="{{ route('admin.reports.sales') }}" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                        Lihat Analisis Penjualan <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <i data-lucide="trending-up" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.pos.transactions') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-3">
                <label class="block text-xs font-medium text-slate-600 mb-1">Cari Nota / Pelanggan</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="No. Nota, Nama, No. HP..."
                           class="w-full pl-9 pr-3 py-2 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-2.5"></i>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-slate-600 mb-1">Status Bayar</label>
                <select name="payment_status" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <option value="">Semua Status</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>DP / Sebagian</option>
                    <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-slate-600 mb-1">Jenis Pesanan</label>
                <select name="order_type" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <option value="">Semua Jenis</option>
                    <option value="retail" {{ request('order_type') == 'retail' ? 'selected' : '' }}>Ritel / Toko</option>
                    <option value="project_custom" {{ request('order_type') == 'project_custom' ? 'selected' : '' }}>Proyek Custom</option>
                </select>
            </div>

            <div class="md:col-span-3">
                <label class="block text-xs font-medium text-slate-600 mb-1">Rentang Tanggal</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-2.5 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-2.5 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                </div>
            </div>

            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-medium transition-colors flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Filter</span>
                </button>
                @if(request()->anyFilled(['search', 'payment_status', 'order_type', 'start_date', 'end_date']))
                    <a href="{{ route('admin.pos.transactions') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium transition-colors" title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-medium">
                        <th class="py-3.5 px-4">No. Invoice & Tanggal</th>
                        <th class="py-3.5 px-4">Pelanggan</th>
                        <th class="py-3.5 px-4">Jenis & Item</th>
                        <th class="py-3.5 px-4 text-right">Total Transaksi</th>
                        <th class="py-3.5 px-4 text-right">Terbayar / Sisa</th>
                        <th class="py-3.5 px-4 text-center">Metode & Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50/75 transition-colors">
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.pos.show', $trx->id) }}" class="font-bold text-primary hover:underline block font-mono text-xs">
                                {{ $trx->invoice_code }}
                            </a>
                            <div class="text-xs text-slate-500 mt-0.5">
                                {{ \Carbon\Carbon::parse($trx->transaction_date)->translatedFormat('d M Y, H:i') }}
                            </div>
                            <div class="text-[11px] text-slate-400">
                                Kasir: {{ $trx->user->name ?? 'Admin' }}
                            </div>
                        </td>

                        <td class="py-3 px-4">
                            @if($trx->customer)
                                <div class="font-semibold text-slate-800">{{ $trx->customer->name }}</div>
                                @if($trx->customer->phone)
                                    <div class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                                        <i data-lucide="phone" class="w-3 h-3 text-slate-400"></i>
                                        <span>{{ $trx->customer->phone }}</span>
                                    </div>
                                @endif
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    Umum / Walk-in
                                </span>
                            @endif
                        </td>

                        <td class="py-3 px-4">
                            <div class="flex items-center gap-1.5 mb-1">
                                @if($trx->order_type === 'project_custom')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                        Proyek Custom
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        Ritel Toko
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $trx->items->count() }} barang/jasa
                            </div>
                        </td>

                        <td class="py-3 px-4 text-right">
                            <div class="font-bold text-slate-800">
                                Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                            </div>
                            @if($trx->discount_amount > 0)
                                <div class="text-xs text-emerald-600">
                                    Disc: Rp {{ number_format($trx->discount_amount, 0, ',', '.') }}
                                </div>
                            @endif
                        </td>

                        <td class="py-3 px-4 text-right">
                            <div class="font-semibold text-emerald-600 text-xs">
                                Dibayar: Rp {{ number_format($trx->paid_amount, 0, ',', '.') }}
                            </div>
                            @if($trx->remaining_debt > 0)
                                <div class="text-xs font-bold text-amber-600 mt-0.5">
                                    Sisa: Rp {{ number_format($trx->remaining_debt, 0, ',', '.') }}
                                </div>
                                @if($trx->due_date)
                                    <div class="text-[11px] text-slate-400">
                                        Tempo: {{ \Carbon\Carbon::parse($trx->due_date)->format('d/m/Y') }}
                                    </div>
                                @endif
                            @endif
                        </td>

                        <td class="py-3 px-4 text-center">
                            <div class="mb-1">
                                @if($trx->payment_status === 'paid')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i> Lunas
                                    </span>
                                @elseif($trx->payment_status === 'partial')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                        <i data-lucide="clock" class="w-3 h-3"></i> DP / Bertahap
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                        <i data-lucide="alert-circle" class="w-3 h-3"></i> Belum Lunas
                                    </span>
                                @endif
                            </div>
                            <span class="inline-block text-[11px] uppercase tracking-wider text-slate-500 font-mono">
                                {{ $trx->payment_type }}
                            </span>
                        </td>

                        <td class="py-3 px-4 text-center">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('admin.pos.show', $trx->id) }}" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-[#172B4D] hover:text-white text-slate-700 flex items-center justify-center transition border border-slate-200 shadow-2xs" title="Detail Transaksi &amp; Pelunasan">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.pos.thermal-receipt', $trx->id) }}" target="_blank" class="w-8 h-8 rounded-xl bg-emerald-50 hover:bg-emerald-600 hover:text-white text-emerald-700 flex items-center justify-center transition border border-emerald-200 shadow-2xs" title="Cetak Struk Thermal (58/80mm)">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.pos.invoice-pdf', $trx->id) }}" target="_blank" class="w-8 h-8 rounded-xl bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-700 flex items-center justify-center transition border border-blue-200 shadow-2xs" title="Unduh / Cetak Invoice A4 (PDF)">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                <i data-lucide="receipt" class="w-8 h-8"></i>
                            </div>
                            <p class="font-medium text-slate-600">Belum ada riwayat transaksi penjualan</p>
                            <p class="text-xs text-slate-400 mt-1">Transaksi yang dicatat melalui kasir POS akan muncul di sini.</p>
                            <a href="{{ route('admin.pos.index') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-[#D6A84F] text-[#101D33] rounded-xl text-sm font-bold hover:bg-[#c4963e] transition-colors cursor-pointer">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                                <span>Buka Kasir POS Sekarang</span>
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

