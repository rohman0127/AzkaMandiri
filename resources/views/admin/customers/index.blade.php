@extends('layouts.admin')

@section('title', 'Pelanggan & Piutang')
@section('breadcrumb', 'Kasir & POS / Pelanggan & Piutang')

@section('content')
<div class="space-y-6" x-data="{ 
    createModal: false, 
    editModal: false, 
    editData: { 
        id: '', 
        name: '', 
        phone: '', 
        email: '', 
        company_name: '', 
        address: '', 
        is_active: '1', 
        updateUrl: '' 
    },
    openEdit(item) {
        this.editData = {
            id: item.id,
            name: item.name,
            phone: item.phone || '',
            email: item.email || '',
            company_name: item.company_name || '',
            address: item.address || '',
            is_active: item.is_active ? '1' : '0',
            updateUrl: item.updateUrl
        };
        this.editModal = true;
        this.$nextTick(() => {
            $('#edit_cust_active').val(this.editData.is_active).trigger('change');
            if (window.initSelect2) window.initSelect2(this.$refs.editModalCard);
        });
    }
}">
    <!-- Top Summary Card: Total Piutang Konsumen -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pelanggan Terdaftar</p>
                <p class="text-2xl font-extrabold text-[#172B4D] mt-1">{{ number_format($customers->total()) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-xs flex items-center justify-between sm:col-span-2">
            <div>
                <p class="text-xs font-semibold text-amber-700 uppercase tracking-wider">Total Piutang Belum Tertagih (Sisa DP / Proyek Custom)</p>
                <p class="text-2xl font-extrabold text-amber-600 font-mono mt-1">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</p>
                <span class="text-[11px] text-gray-500">Akumulasi sisa pembayaran transaksi kasir/proyek yang belum lunas</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Manajemen Data Pelanggan</h2>
            <p class="text-xs text-gray-500">Kelola riwayat belanja, kontak WhatsApp, dan pemantauan pelunasan piutang pelanggan</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.customers.export', request()->query()) }}" 
               class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 font-semibold text-xs shadow-xs hover:bg-slate-50 transition flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i>
                <span>Ekspor Excel/CSV</span>
            </a>
            <button type="button" 
                    @click="createModal = true; $nextTick(() => { if (window.initSelect2) window.initSelect2($refs.createModalCard); });" 
                    class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm shrink-0 cursor-pointer">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Tambah Pelanggan</span>
            </button>
        </div>
    </div>

    <!-- Data Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <!-- Search Bar -->
        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="flex items-center gap-3">
                <div class="relative flex-1 max-w-sm">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama pelanggan, nomor WhatsApp..." 
                           class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-[#D6A84F] outline-none bg-white">
                </div>
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.customers.index') }}" class="px-3.5 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 text-xs font-semibold transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Nama Pelanggan</th>
                        <th class="px-6 py-3.5">Nomor WhatsApp</th>
                        <th class="px-6 py-3.5">Perusahaan / Info Proyek</th>
                        <th class="px-6 py-3.5">Alamat Pengiriman</th>
                        <th class="px-6 py-3.5 text-center">Total Transaksi</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($customers as $c)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.customers.show', $c->id) }}" class="font-bold text-[#172B4D] hover:text-[#D6A84F] text-sm block">
                                    {{ $c->name }}
                                </a>
                                @if($c->email)
                                    <span class="text-xs text-gray-400 font-mono">{{ $c->email }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($c->phone)
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-xs text-gray-700">{{ $c->phone }}</span>
                                        @php
                                            $waNum = preg_replace('/[^0-9]/', '', $c->phone);
                                            if (str_starts_with($waNum, '0')) {
                                                $waNum = '62' . substr($waNum, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $waNum }}" target="_blank" 
                                           class="p-1 rounded-md bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition" 
                                           title="Kirim Pesan WhatsApp">
                                            <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600">
                                {{ $c->company_name ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 max-w-xs truncate">
                                {{ $c->address ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.customers.show', $c->id) }}" 
                                   class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 hover:bg-blue-100 transition">
                                    {{ $c->transactions_count }} Transaksi &rarr;
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($c->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.customers.show', $c->id) }}" 
                                       class="p-1.5 rounded-lg text-gray-500 hover:text-amber-600 hover:bg-amber-50 transition" 
                                       title="Riwayat Belanja & Piutang">
                                        <i data-lucide="history" class="w-4 h-4"></i>
                                    </a>
                                    <button type="button" 
                                            @click="openEdit({
                                                id: {{ $c->id }},
                                                name: '{{ addslashes($c->name) }}',
                                                phone: '{{ addslashes($c->phone ?? '') }}',
                                                email: '{{ addslashes($c->email ?? '') }}',
                                                company_name: '{{ addslashes($c->company_name ?? '') }}',
                                                address: '{{ addslashes($c->address ?? '') }}',
                                                is_active: {{ $c->is_active ? 1 : 0 }},
                                                updateUrl: '{{ route('admin.customers.update', $c->id) }}'
                                            })"
                                            class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-[#172B4D] hover:text-white text-slate-700 border border-slate-200 flex items-center justify-center transition cursor-pointer shadow-2xs"
                                            title="Edit Pelanggan">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <form action="{{ route('admin.customers.destroy', $c->id) }}" method="POST" class="inline form-delete" data-confirm="Hapus data pelanggan '{{ $c->name }}'? Tindakan ini tidak dapat dibatalkan.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 border border-rose-200 flex items-center justify-center transition cursor-pointer delete-confirm shadow-2xs"
                                                title="Hapus Pelanggan">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <i data-lucide="users" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                Belum ada data pelanggan. Klik tombol "Tambah Pelanggan" di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL CREATE -->
    <div x-show="createModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div x-ref="createModalCard" @click.away="createModal = false" 
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 relative">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                <h3 class="text-base font-bold text-[#172B4D]">Tambah Data Pelanggan Baru</h3>
                <button type="button" @click="createModal = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap Pelanggan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Bpk. Hendra Gunawan" 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">No. WhatsApp / HP</label>
                        <input type="text" name="phone" placeholder="08123456789" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" placeholder="hendra@example.com" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Perusahaan / Info Proyek</label>
                    <input type="text" name="company_name" placeholder="Contoh: Owner Rumah Tinggal BSD / PT Maju Sejahtera" 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Pemasangan / Lokasi</label>
                    <textarea name="address" rows="2" placeholder="Alamat lengkap lokasi pengiriman atau survei..." 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Status</label>
                    <select name="is_active" class="select2-luxury w-full">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="createModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] transition">Simpan Pelanggan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div x-show="editModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div x-ref="editModalCard" @click.away="editModal = false" 
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 relative">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                <h3 class="text-base font-bold text-[#172B4D]">Edit Data Pelanggan</h3>
                <button type="button" @click="editModal = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form :action="editData.updateUrl" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap Pelanggan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" x-model="editData.name" required 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">No. WhatsApp / HP</label>
                        <input type="text" name="phone" x-model="editData.phone" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" x-model="editData.email" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Perusahaan / Info Proyek</label>
                    <input type="text" name="company_name" x-model="editData.company_name" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Pemasangan</label>
                    <textarea name="address" x-model="editData.address" rows="2" 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Status</label>
                    <select name="is_active" id="edit_cust_active" class="select2-luxury w-full">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] transition">Perbarui Pelanggan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

