@extends('layouts.admin')

@section('title', 'Profil Pelanggan - ' . $customer->name)
@section('breadcrumb', 'Kasir & POS / Pelanggan / Detail')

@section('content')
<div class="w-full space-y-6">
    <!-- Header Back -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.customers.index') }}" 
               class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </a>
            <div>
                <h2 class="text-xl font-extrabold text-[#172B4D]">{{ $customer->name }}</h2>
                <p class="text-xs text-gray-500">{{ $customer->company_name ?: 'Pelanggan Ritel / Perorangan' }}</p>
            </div>
        </div>

        @if($sisaPiutang > 0)
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                <i data-lucide="clock" class="w-3.5 h-3.5"></i> Sisa Piutang: Rp {{ number_format($sisaPiutang, 0, ',', '.') }}
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Tidak Ada Piutang (Lunas)
            </span>
        @endif
    </div>

    <!-- Info Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-xs">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Total Belanja (Omzet)</span>
            <span class="text-2xl font-extrabold text-[#172B4D] font-mono mt-1 block">Rp {{ number_format($totalSpent, 0, ',', '.') }}</span>
            <span class="text-[11px] text-gray-400 mt-1 block">Dari {{ $customer->transactions->count() }} transaksi kasir</span>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-xs">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Total Pembayaran Masuk</span>
            <span class="text-2xl font-extrabold text-emerald-600 font-mono mt-1 block">Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
            <span class="text-[11px] text-gray-400 mt-1 block">Pembayaran tunai / transfer / QRIS</span>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-xs">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Kontak WhatsApp</span>
            @if($customer->phone)
                @php
                    $waNum = preg_replace('/[^0-9]/', '', $customer->phone);
                    if (str_starts_with($waNum, '0')) {
                        $waNum = '62' . substr($waNum, 1);
                    }
                @endphp
                <div class="flex items-center justify-between mt-2">
                    <span class="font-mono text-base font-bold text-gray-800">{{ $customer->phone }}</span>
                    <a href="https://wa.me/{{ $waNum }}" target="_blank" 
                       class="px-3 py-1.5 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs flex items-center gap-1.5 transition">
                        <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                        <span>Chat WA</span>
                    </a>
                </div>
            @else
                <span class="text-gray-400 text-xs block mt-2">Nomor telepon belum diisi</span>
            @endif
        </div>
    </div>

    <!-- Riwayat Transaksi -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
        <div class="p-4 bg-gray-50/50 border-b border-gray-100 font-bold text-xs text-[#172B4D] uppercase tracking-wider flex items-center justify-between">
            <span>Riwayat Transaksi Belanja Pelanggan</span>
            <span class="text-gray-400 font-normal">Menampilkan seluruh invoice</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">No. Invoice</th>
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5">Tipe Order</th>
                        <th class="px-6 py-3.5 text-right">Total Transaksi</th>
                        <th class="px-6 py-3.5 text-right">Sudah Dibayar</th>
                        <th class="px-6 py-3.5 text-right">Sisa Piutang</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($customer->transactions as $t)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-6 py-4 font-mono font-bold text-[#172B4D]">
                                {{ $t->invoice_code }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $t->transaction_date->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($t->order_type === 'project_custom')
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-purple-50 text-purple-700">Proyek Custom</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-700">Ritel Kasir</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-mono font-bold text-[#172B4D]">
                                Rp {{ number_format($t->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-emerald-600">
                                Rp {{ number_format($t->paid_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-mono font-bold text-amber-600">
                                @if($t->remaining_debt > 0)
                                    Rp {{ number_format($t->remaining_debt, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-400 font-normal">Rp 0</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($t->payment_status === 'paid')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700">Lunas</span>
                                @elseif($t->payment_status === 'partial')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700">Sebagian / DP</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700">Belum Bayar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.pos.show', $t->id) }}" 
                                   class="px-2.5 py-1.5 rounded-lg bg-gray-100 hover:bg-[#172B4D] hover:text-white transition font-semibold text-[11px] inline-flex items-center gap-1">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                Pelanggan ini belum memiliki riwayat transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

