@extends('layouts.admin')

@section('title', 'Data Supplier')
@section('breadcrumb', 'Supplier & Belanja / Data Supplier')

@section('content')
<div class="space-y-6" x-data="{ 
    createModal: false, 
    editModal: false, 
    editData: { 
        id: '', 
        name: '', 
        company_name: '', 
        phone: '', 
        email: '', 
        address: '', 
        notes: '', 
        is_active: '1', 
        updateUrl: '' 
    },
    openEdit(item) {
        this.editData = {
            id: item.id,
            name: item.name,
            company_name: item.company_name || '',
            phone: item.phone || '',
            email: item.email || '',
            address: item.address || '',
            notes: item.notes || '',
            is_active: item.is_active ? '1' : '0',
            updateUrl: item.updateUrl
        };
        this.editModal = true;
        this.$nextTick(() => {
            $('#edit_supplier_active').val(this.editData.is_active).trigger('change');
            if (window.initSelect2) window.initSelect2(this.$refs.editModalCard);
        });
    }
}">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Data Supplier &amp; Toko Bahan</h2>
            <p class="text-xs text-gray-500">Daftar mitra supplier aluminium, pabrik kaca, aksesoris, dan distributor sealant</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.suppliers.export', request()->query()) }}" 
               class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 font-semibold text-xs shadow-xs hover:bg-slate-50 transition flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i>
                <span>Ekspor Excel/CSV</span>
            </a>
            <a href="{{ route('admin.purchases.create') }}" 
               class="px-4 py-2.5 rounded-xl bg-[#172B4D] hover:bg-[#101D33] text-white font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm">
                <i data-lucide="shopping-cart" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Catat Pembelian Baru</span>
            </a>
            <button type="button" 
                    @click="createModal = true; $nextTick(() => { if (window.initSelect2) window.initSelect2($refs.createModalCard); });" 
                    class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm shrink-0 cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Supplier</span>
            </button>
        </div>
    </div>

    <!-- Data Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <!-- Search Bar -->
        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('admin.suppliers.index') }}" class="flex items-center gap-3">
                <div class="relative flex-1 max-w-sm">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama supplier, PT, nomor HP..." 
                           class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-[#D6A84F] outline-none bg-white">
                </div>
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.suppliers.index') }}" class="px-3.5 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 text-xs font-semibold transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Perusahaan / Toko</th>
                        <th class="px-6 py-3.5">Kontak Person</th>
                        <th class="px-6 py-3.5">Telepon &amp; WhatsApp</th>
                        <th class="px-6 py-3.5">Alamat Gudang</th>
                        <th class="px-6 py-3.5 text-center">Total Pembelian</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($suppliers as $sup)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#172B4D] text-sm block">{{ $sup->company_name ?: $sup->name }}</span>
                                @if($sup->company_name)
                                    <span class="text-xs text-gray-400">PIC: {{ $sup->name }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-700">
                                {{ $sup->name }}
                                @if($sup->email)
                                    <span class="block text-[11px] text-gray-400 font-mono">{{ $sup->email }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($sup->phone)
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-xs text-gray-700">{{ $sup->phone }}</span>
                                        @php
                                            $waNum = preg_replace('/[^0-9]/', '', $sup->phone);
                                            if (str_starts_with($waNum, '0')) {
                                                $waNum = '62' . substr($waNum, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $waNum }}" target="_blank" 
                                           class="p-1 rounded-md bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition" 
                                           title="Chat WhatsApp Supplier">
                                            <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600 max-w-xs truncate">
                                {{ $sup->address ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $sup->purchases_count }} Transaksi
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($sup->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" 
                                            @click="openEdit({
                                                id: {{ $sup->id }},
                                                name: '{{ addslashes($sup->name) }}',
                                                company_name: '{{ addslashes($sup->company_name ?? '') }}',
                                                phone: '{{ addslashes($sup->phone ?? '') }}',
                                                email: '{{ addslashes($sup->email ?? '') }}',
                                                address: '{{ addslashes($sup->address ?? '') }}',
                                                notes: '{{ addslashes($sup->notes ?? '') }}',
                                                is_active: {{ $sup->is_active ? 1 : 0 }},
                                                updateUrl: '{{ route('admin.suppliers.update', $sup->id) }}'
                                            })"
                                            class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-[#172B4D] hover:text-white text-slate-700 border border-slate-200 flex items-center justify-center transition cursor-pointer shadow-2xs"
                                            title="Edit Supplier">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <form action="{{ route('admin.suppliers.destroy', $sup->id) }}" method="POST" class="inline form-delete" data-confirm="Hapus data supplier '{{ $sup->name }}'? Riwayat transaksi pembelian terkait akan tetap tersimpan.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 border border-rose-200 flex items-center justify-center transition cursor-pointer delete-confirm shadow-2xs"
                                                title="Hapus Supplier">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <i data-lucide="truck" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                Belum ada data supplier. Klik tombol "Tambah Supplier" di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suppliers->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL CREATE -->
    <div x-show="createModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div x-ref="createModalCard" @click.away="createModal = false" 
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4 sticky top-0 bg-white z-10">
                <h3 class="text-base font-bold text-[#172B4D]">Tambah Data Supplier</h3>
                <button type="button" @click="createModal = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form action="{{ route('admin.suppliers.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Perusahaan / Toko</label>
                        <input type="text" name="company_name" placeholder="PT Duta Aluminium" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Kontak / PIC <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Surya Wijaya" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor Telepon / WA</label>
                        <input type="text" name="phone" placeholder="08123456789" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" placeholder="sales@supplier.com" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Gudang / Kantor</label>
                    <textarea name="address" rows="2" placeholder="Alamat lengkap lokasi pengiriman..." 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Catatan Tambahan (Termin Pembayaran, dsb.)</label>
                    <textarea name="notes" rows="2" placeholder="Contoh: Tempo 30 hari, diskon volume 5%..." 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Status Supplier</label>
                    <select name="is_active" class="select2-luxury w-full">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="createModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] transition">Simpan Supplier</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div x-show="editModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div x-ref="editModalCard" @click.away="editModal = false" 
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4 sticky top-0 bg-white z-10">
                <h3 class="text-base font-bold text-[#172B4D]">Edit Data Supplier</h3>
                <button type="button" @click="editModal = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form :action="editData.updateUrl" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Perusahaan / Toko</label>
                        <input type="text" name="company_name" x-model="editData.company_name" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Kontak / PIC <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editData.name" required 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor Telepon / WA</label>
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
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Gudang / Kantor</label>
                    <textarea name="address" x-model="editData.address" rows="2" 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Catatan Tambahan</label>
                    <textarea name="notes" x-model="editData.notes" rows="2" 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Status Supplier</label>
                    <select name="is_active" id="edit_supplier_active" class="select2-luxury w-full">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] transition">Perbarui Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

