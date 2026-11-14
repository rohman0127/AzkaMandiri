@extends('layouts.admin')

@section('title', 'Pembelian (Restock)')
@section('breadcrumb', 'Supplier & Belanja / Pembelian')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Riwayat Pembelian &amp; Restock</h2>
            <p class="text-xs text-gray-500">Pencatatan faktur pembelian material masuk dari supplier yang otomatis menambah stok fisik</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.purchases.export', request()->query()) }}" 
               class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 font-semibold text-xs shadow-xs hover:bg-slate-50 transition flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i>
                <span>Ekspor Excel/CSV</span>
            </a>
            <a href="{{ route('admin.purchases.create') }}" 
               class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm shrink-0">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Catat Restock Baru</span>
            </a>
        </div>
    </div>

    <!-- Data Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <!-- Search & Filter Form -->
        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('admin.purchases.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <div class="sm:col-span-6 relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nomor PO atau nama supplier..." 
                           class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-[#D6A84F] outline-none bg-white">
                </div>

                <div class="sm:col-span-4">
                    <select name="supplier_id" class="select2-luxury w-full" onchange="this.form.submit()">
                        <option value="">Semua Supplier</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>
                                {{ $sup->company_name ?: $sup->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2 px-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'supplier_id']))
                        <a href="{{ route('admin.purchases.index') }}" class="p-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition" title="Reset">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">No. Faktur (PO)</th>
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5">Nama Supplier</th>
                        <th class="px-6 py-3.5 text-center">Jumlah Item</th>
                        <th class="px-6 py-3.5 text-right">Total Pembelian</th>
                        <th class="px-6 py-3.5 text-center">Status Pembayaran</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($purchases as $po)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4 font-mono font-bold text-xs text-[#172B4D]">
                                {{ $po->invoice_number }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">
                                {{ \Carbon\Carbon::parse($po->purchase_date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#172B4D] text-sm block">{{ $po->supplier->company_name ?: $po->supplier->name }}</span>
                                <span class="text-xs text-gray-400">PIC: {{ $po->supplier->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                    {{ $po->items->count() }} Jenis Barang
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-mono font-bold text-xs text-[#172B4D]">
                                Rp {{ number_format($po->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($po->payment_status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        Lunas
                                    </span>
                                @elseif($po->payment_status === 'partial')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                        Sebagian (Tempo)
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                        Belum Lunas
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.purchases.show', $po->id) }}" 
                                       class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-[#172B4D] hover:text-white text-slate-700 border border-slate-200 flex items-center justify-center transition shadow-2xs"
                                       title="Lihat Detail Faktur">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.purchases.destroy', $po->id) }}" method="POST" class="inline form-delete" data-confirm="Hapus transaksi pembelian '{{ $po->purchase_number }}'? Stok produk yang sudah ditambah akan dikurangi kembali secara otomatis.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 border border-rose-200 flex items-center justify-center transition cursor-pointer delete-confirm shadow-2xs"
                                                title="Hapus / Batalkan Pembelian (Stok Dikurangi Kembali)">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <i data-lucide="shopping-cart" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                Belum ada riwayat pembelian. Klik "Catat Restock Baru" di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($purchases->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $purchases->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

