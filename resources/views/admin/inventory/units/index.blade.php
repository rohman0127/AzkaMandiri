@extends('layouts.admin')

@section('title', 'Satuan Barang')
@section('breadcrumb', 'Inventaris & Stok / Satuan Barang')

@section('content')
<div class="space-y-6" x-data="{ 
    createModal: false, 
    editModal: false, 
    editData: { 
        id: '', 
        name: '', 
        symbol: '', 
        description: '', 
        is_active: '1', 
        updateUrl: '' 
    },
    openEdit(item) {
        this.editData = {
            id: item.id,
            name: item.name,
            symbol: item.symbol,
            description: item.description || '',
            is_active: item.is_active ? '1' : '0',
            updateUrl: item.updateUrl
        };
        this.editModal = true;
        this.$nextTick(() => {
            $('#edit_unit_active').val(this.editData.is_active).trigger('change');
            if (window.initSelect2) window.initSelect2(this.$refs.editModalCard);
        });
    }
}">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Satuan Barang &amp; Material</h2>
            <p class="text-xs text-gray-500">Kelola unit pengukuran inventaris (Batang, Lembar, Meter, Pcs, Set, Roll)</p>
        </div>
        <button type="button" 
                @click="createModal = true; $nextTick(() => { if (window.initSelect2) window.initSelect2($refs.createModalCard); });" 
                class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm shrink-0 cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Satuan</span>
        </button>
    </div>

    <!-- Data Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <!-- Search Bar -->
        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('admin.inventory.units.index') }}" class="flex items-center gap-3">
                <div class="relative flex-1 max-w-sm">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama atau simbol satuan..." 
                           class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 text-xs focus:ring-2 focus:ring-[#D6A84F] outline-none bg-white">
                </div>
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition">
                    Cari
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.inventory.units.index') }}" class="px-3.5 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 text-xs font-semibold transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Nama Satuan</th>
                        <th class="px-6 py-3.5">Simbol</th>
                        <th class="px-6 py-3.5">Keterangan</th>
                        <th class="px-6 py-3.5 text-center">Jumlah Produk</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($units as $u)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4 font-bold text-[#172B4D]">
                                {{ $u->name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs px-2.5 py-1 rounded bg-gray-100 text-gray-700 font-semibold">
                                    {{ $u->symbol }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-400">
                                {{ $u->description ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $u->products_count }} Produk
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($u->is_active)
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
                                                id: {{ $u->id }},
                                                name: '{{ addslashes($u->name) }}',
                                                symbol: '{{ addslashes($u->symbol) }}',
                                                description: '{{ addslashes($u->description ?? '') }}',
                                                is_active: {{ $u->is_active ? 1 : 0 }},
                                                updateUrl: '{{ route('admin.inventory.units.update', $u->id) }}'
                                            })"
                                            class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-[#172B4D] hover:text-white text-slate-700 border border-slate-200 flex items-center justify-center transition cursor-pointer shadow-2xs"
                                            title="Edit Satuan">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>
                                    <form action="{{ route('admin.inventory.units.destroy', $u->id) }}" method="POST" class="inline form-delete" data-confirm="Hapus satuan '{{ $u->name }}'? Pastikan satuan tidak digunakan produk aktif.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 border border-rose-200 flex items-center justify-center transition cursor-pointer delete-confirm shadow-2xs"
                                                title="Hapus Satuan">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i data-lucide="scale" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                Belum ada satuan barang. Klik tombol "Tambah Satuan" di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($units->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $units->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL CREATE -->
    <div x-show="createModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div x-ref="createModalCard" @click.away="createModal = false" 
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 relative">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                <h3 class="text-base font-bold text-[#172B4D]">Tambah Satuan Barang</h3>
                <button type="button" @click="createModal = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form action="{{ route('admin.inventory.units.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Satuan <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: Batang" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Simbol / Singkatan <span class="text-red-500">*</span></label>
                        <input type="text" name="symbol" required placeholder="Contoh: btg" 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Keterangan</label>
                    <textarea name="description" rows="2" placeholder="Keterangan penggunaan satuan..." 
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
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] transition">Simpan Satuan</button>
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
                <h3 class="text-base font-bold text-[#172B4D]">Edit Satuan Barang</h3>
                <button type="button" @click="editModal = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form :action="editData.updateUrl" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Satuan <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editData.name" required 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Simbol / Singkatan <span class="text-red-500">*</span></label>
                        <input type="text" name="symbol" x-model="editData.symbol" required 
                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Keterangan</label>
                    <textarea name="description" x-model="editData.description" rows="2" 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Status</label>
                    <select name="is_active" id="edit_unit_active" class="select2-luxury w-full">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] transition">Perbarui Satuan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

