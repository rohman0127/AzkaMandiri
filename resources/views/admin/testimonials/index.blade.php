@extends('layouts.admin')

@section('title', 'Kelola Testimoni')
@section('breadcrumb', 'Ulasan & Testimoni Pelanggan')

@section('content')
<div class="space-y-6" x-data="{ 
    createModal: false, 
    editModal: false, 
    editData: { 
        id: '', 
        client_name: '', 
        client_role: '', 
        content: '', 
        rating: '5', 
        sort_order: 0, 
        is_active: '1', 
        updateUrl: '' 
    },
    openEdit(item) {
        this.editData = {
            id: item.id,
            client_name: item.client_name,
            client_role: item.client_role || '',
            content: item.content || '',
            rating: item.rating ? item.rating.toString() : '5',
            sort_order: item.sort_order || 0,
            is_active: item.is_active ? '1' : '0',
            updateUrl: item.updateUrl
        };
        this.editModal = true;
        this.$nextTick(() => {
            $('#edit_t_rating').val(this.editData.rating).trigger('change');
            $('#edit_t_is_active').val(this.editData.is_active).trigger('change');
            if (window.initSelect2) window.initSelect2(this.$refs.editModalCard);
        });
    }
}">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Daftar Testimoni Pelanggan</h2>
            <p class="text-xs text-gray-500">Kelola ulasan kepuasan pelanggan untuk membangun kredibilitas usaha</p>
        </div>
        <button type="button" 
                @click="createModal = true; $nextTick(() => { if (window.initSelect2) window.initSelect2($refs.createModalCard); });" 
                class="px-4 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm shrink-0 cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Testimoni</span>
        </button>
    </div>

    <!-- Data Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Pelanggan</th>
                        <th class="px-6 py-3.5">Isi Ulasan</th>
                        <th class="px-6 py-3.5 text-center">Rating</th>
                        <th class="px-6 py-3.5 text-center">Urutan</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($testimonials as $t)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($t->photo)
                                        <img src="{{ $t->photo }}" alt="{{ $t->client_name }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-[#172B4D] text-[#D6A84F] flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($t->client_name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-[#172B4D] text-sm">{{ $t->client_name }}</p>
                                        <p class="text-xs text-gray-400">{{ $t->client_role ?: 'Pelanggan' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600 max-w-md">
                                <p class="line-clamp-2">"{{ $t->content }}"</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center gap-0.5 text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $t->rating)
                                            <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                                        @else
                                            <i data-lucide="star" class="w-3.5 h-3.5 text-gray-300"></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-xs font-semibold">
                                {{ $t->sort_order }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($t->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" 
                                            data-item="{{ json_encode([
                                                'id' => $t->id,
                                                'client_name' => $t->client_name,
                                                'client_role' => $t->client_role ?? '',
                                                'content' => $t->content ?? '',
                                                'rating' => $t->rating,
                                                'sort_order' => $t->sort_order,
                                                'is_active' => $t->is_active ? 1 : 0,
                                                'updateUrl' => route('admin.testimonials.update', $t->id),
                                            ]) }}"
                                            @click="openEdit(JSON.parse($el.getAttribute('data-item')))"
                                            class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition cursor-pointer"
                                            title="Edit Testimoni">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </button>

                                    <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST"
                                          data-confirm="Hapus ulasan dari '{{ $t->client_name }}'?" 
                                          class="inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition cursor-pointer delete-confirm" title="Hapus Testimoni">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400 text-xs">
                                Belum ada data ulasan testimoni.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($testimonials->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL: Tambah Testimoni -->
    <div x-show="createModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
         style="display: none;"
         x-cloak>
        <div @click.outside="createModal = false" 
             x-ref="createModalCard"
             class="bg-white rounded-3xl border border-gray-200/90 shadow-2xl w-full max-w-lg overflow-hidden transform transition-all relative">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#172B4D] via-[#D6A84F] to-[#172B4D]"></div>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-[#D6A84F] flex items-center justify-center border border-amber-200/50">
                        <i data-lucide="quote" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#172B4D] text-base">Tambah Testimoni Klien</h3>
                        <p class="text-xs text-gray-500">Masukkan ulasan kepuasan pelanggan</p>
                    </div>
                </div>
                <button type="button" @click="createModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="t_create_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Pelanggan *</label>
                        <input type="text" id="t_create_name" name="client_name" required
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                               placeholder="Nama Klien">
                    </div>
                    <div>
                        <label for="t_create_role" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Peran / Lokasi Proyek</label>
                        <input type="text" id="t_create_role" name="client_role"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                               placeholder="Contoh: Pemilik Rumah, BSD City">
                    </div>
                </div>

                <div>
                    <label for="t_create_content" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Isi Ulasan Testimoni *</label>
                    <textarea id="t_create_content" name="content" rows="3" required
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                              placeholder="Kesan dan pengalaman pelanggan terhadap pengerjaan aluminium &amp; kaca..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="t_create_rating" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Rating Bintang *</label>
                        <select id="t_create_rating" name="rating" class="select2 w-full" required>
                            <option value="5" selected>⭐ ⭐ ⭐ ⭐ ⭐ (5 Bintang)</option>
                            <option value="4">⭐ ⭐ ⭐ ⭐ (4 Bintang)</option>
                            <option value="3">⭐ ⭐ ⭐ (3 Bintang)</option>
                            <option value="2">⭐ ⭐ (2 Bintang)</option>
                            <option value="1">⭐ (1 Bintang)</option>
                        </select>
                    </div>
                    <div>
                        <label for="t_create_is_active" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status Tampil</label>
                        <select id="t_create_is_active" name="is_active" class="select2 w-full">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="t_create_photo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Foto Profil / Avatar (Opsional)</label>
                    <input type="file" id="t_create_photo" name="photo" accept="image/*"
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="createModal = false" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition cursor-pointer">
                        Batalkan
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#c4963e] hover:from-[#e3ba63] text-[#101D33] text-xs font-extrabold shadow-sm transition cursor-pointer flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Simpan Testimoni</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit Testimoni -->
    <div x-show="editModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
         style="display: none;"
         x-cloak>
        <div @click.outside="editModal = false" 
             x-ref="editModalCard"
             class="bg-white rounded-3xl border border-gray-200/90 shadow-2xl w-full max-w-lg overflow-hidden transform transition-all relative">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#172B4D] via-[#D6A84F] to-[#172B4D]"></div>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-200/50">
                        <i data-lucide="edit" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#172B4D] text-base">Edit Testimoni</h3>
                        <p class="text-xs text-gray-500">Perbarui informasi ulasan klien</p>
                    </div>
                </div>
                <button type="button" @click="editModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :action="editData.updateUrl" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="t_edit_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Pelanggan *</label>
                        <input type="text" id="t_edit_name" name="client_name" x-model="editData.client_name" required
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                    <div>
                        <label for="t_edit_role" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Peran / Lokasi Proyek</label>
                        <input type="text" id="t_edit_role" name="client_role" x-model="editData.client_role"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label for="t_edit_content" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Isi Ulasan Testimoni *</label>
                    <textarea id="t_edit_content" name="content" rows="3" x-model="editData.content" required
                              class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_t_rating" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Rating Bintang *</label>
                        <select id="edit_t_rating" name="rating" class="select2 w-full" required>
                            <option value="5">⭐ ⭐ ⭐ ⭐ ⭐ (5 Bintang)</option>
                            <option value="4">⭐ ⭐ ⭐ ⭐ (4 Bintang)</option>
                            <option value="3">⭐ ⭐ ⭐ (3 Bintang)</option>
                            <option value="2">⭐ ⭐ (2 Bintang)</option>
                            <option value="1">⭐ (1 Bintang)</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit_t_is_active" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status Tampil</label>
                        <select id="edit_t_is_active" name="is_active" class="select2 w-full">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="t_edit_photo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Ganti Foto Profil / Avatar</label>
                    <input type="file" id="t_edit_photo" name="photo" accept="image/*"
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="editModal = false" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition cursor-pointer">
                        Batalkan
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#D6A84F] to-[#c4963e] hover:from-[#e3ba63] text-[#101D33] text-xs font-extrabold shadow-sm transition cursor-pointer flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        <span>Perbarui Testimoni</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
