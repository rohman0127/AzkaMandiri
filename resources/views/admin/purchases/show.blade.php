@extends('layouts.admin')

@section('title', 'Detail Pembelian ' . $purchase->invoice_number)
@section('breadcrumb', 'Supplier & Belanja / Pembelian / Detail')

@section('content')
<div class="w-full space-y-6">
    <!-- Header Action -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.purchases.index') }}" 
               class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </a>
            <div>
                <h2 class="text-xl font-extrabold text-[#172B4D]">Faktur Pembelian: {{ $purchase->invoice_number }}</h2>
                <p class="text-xs text-gray-500">Tanggal Transaksi: {{ \Carbon\Carbon::parse($purchase->purchase_date)->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <div>
            @if($purchase->payment_status === 'paid')
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Pembayaran Lunas
                </span>
            @elseif($purchase->payment_status === 'partial')
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span> Tempo / Sebagian
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span> Belum Lunas
                </span>
            @endif
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Supplier Card -->
        <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-xs">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Informasi Supplier</h3>
            <p class="text-base font-bold text-[#172B4D]">{{ $purchase->supplier->company_name ?: $purchase->supplier->name }}</p>
            <p class="text-xs text-gray-500 mt-1">PIC: <b>{{ $purchase->supplier->name }}</b></p>
            <p class="text-xs text-gray-500 mt-1">Telepon / WA: {{ $purchase->supplier->phone ?: '-' }}</p>
            <p class="text-xs text-gray-500 mt-1">Alamat: {{ $purchase->supplier->address ?: '-' }}</p>
        </div>

        <!-- Purchase Summary Card -->
        <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-xs">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Ringkasan Faktur</h3>
            <div class="flex items-center justify-between py-1 text-xs">
                <span class="text-gray-500">Total Jenis Barang:</span>
                <span class="font-bold text-gray-700">{{ $purchase->items->count() }} Item</span>
            </div>
            <div class="flex items-center justify-between py-1 text-xs">
                <span class="text-gray-500">Catatan:</span>
                <span class="text-gray-700">{{ $purchase->notes ?: '-' }}</span>
            </div>
            <div class="flex items-center justify-between pt-3 mt-2 border-t border-gray-100">
                <span class="text-sm font-bold text-[#172B4D]">Total Pembelian:</span>
                <span class="text-xl font-extrabold text-[#172B4D] font-mono">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
        <div class="p-4 bg-gray-50/50 border-b border-gray-100 font-bold text-xs text-[#172B4D] uppercase tracking-wider">
            Rincian Barang yang Diterima
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">No</th>
                        <th class="px-6 py-3.5">Nama Produk &amp; SKU</th>
                        <th class="px-6 py-3.5 text-center">Jumlah Diterima</th>
                        <th class="px-6 py-3.5 text-right">Harga Modal Beli</th>
                        <th class="px-6 py-3.5 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($purchase->items as $idx => $item)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-6 py-4 text-gray-400 font-mono">{{ $idx + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#172B4D] text-sm block">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                                <span class="font-mono text-[11px] text-gray-400">SKU: {{ $item->product->sku ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-700">
                                {{ $item->quantity }} {{ $item->product->unit->symbol ?? 'pcs' }}
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-gray-600">
                                Rp {{ number_format($item->unit_cost, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-mono font-bold text-[#172B4D]">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

