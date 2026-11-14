@extends('layouts.admin')

@section('title', 'Tambah Peran & Hak Akses Baru')

@section('content')
<div class="w-full space-y-6" x-data="{
    selectedPerms: [],
    selectAll() {
        const allBoxes = document.querySelectorAll('input[type=checkbox].perm-box');
        this.selectedPerms = Array.from(allBoxes).map(el => el.value);
    },
    deselectAll() {
        this.selectedPerms = [];
    },
    toggleGroup(groupClass) {
        const groupBoxes = document.querySelectorAll('.' + groupClass);
        const groupValues = Array.from(groupBoxes).map(el => el.value);
        const allSelected = groupValues.every(val => this.selectedPerms.includes(val));

        if (allSelected) {
            // Remove group values
            this.selectedPerms = this.selectedPerms.filter(val => !groupValues.includes(val));
        } else {
            // Add group values
            const newValues = groupValues.filter(val => !this.selectedPerms.includes(val));
            this.selectedPerms = [...this.selectedPerms, ...newValues];
        }
    }
}">
    <!-- Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.roles.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Peran &amp; Hak Akses</h1>
            <p class="text-sm text-slate-500">Tentukan nama peran dan centang izin hak akses modul yang diizinkan</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Role Basic Info -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                <i data-lucide="shield" class="w-4 h-4 text-primary"></i>
                <span>Informasi Dasar Peran (Role)</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Peran / Jabatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Supervisor Toko, Admin Pajak" required
                           class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Singkat Tanggung Jawab</label>
                    <input type="text" name="description" value="{{ old('description') }}" placeholder="Contoh: Mengelola operasional kasir dan stok barang"
                           class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                </div>
            </div>
        </div>

        <!-- Master Permissions Toolbar -->
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-4 sm:p-5 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
            <div>
                <h3 class="text-sm font-bold flex items-center gap-2">
                    <i data-lucide="key" class="w-4 h-4 text-[#D6A84F]"></i>
                    <span>Matriks Hak Akses (Permissions Matrix)</span>
                </h3>
                <p class="text-xs text-slate-300 mt-0.5">Centang modul yang diizinkan untuk diakses oleh peran ini.</p>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="selectAll()" class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-semibold transition border border-white/20">
                    Centang Semua
                </button>
                <button type="button" @click="deselectAll()" class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-semibold transition border border-white/20">
                    Hapus Semua
                </button>
            </div>
        </div>

        <!-- Permissions By Group -->
        <div class="space-y-6">
            @foreach($permissions as $groupLabel => $groupPerms)
            @php
                $groupSlug = \Illuminate\Support\Str::slug($groupLabel);
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 sm:p-5 bg-slate-50/80 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                        <h4 class="font-bold text-sm text-slate-800">{{ $groupLabel }}</h4>
                        <span class="text-xs text-slate-400">({{ $groupPerms->count() }} Izin)</span>
                    </div>
                    <button type="button" @click="toggleGroup('group-{{ $groupSlug }}')"
                            class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                        <span>Pilih Semua di Grup Ini</span>
                    </button>
                </div>

                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($groupPerms as $p)
                    <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50/80 cursor-pointer transition focus-within:ring-2 focus-within:ring-primary/20">
                        <input type="checkbox" name="permissions[]" value="{{ $p->id }}"
                               x-model="selectedPerms"
                               class="mt-1 text-primary focus:ring-primary rounded border-slate-300 perm-box group-{{ $groupSlug }}">
                        <div class="min-w-0">
                            <span class="font-semibold text-xs text-slate-800 block">{{ $p->display_name }}</span>
                            <span class="font-mono text-[10px] text-slate-400 block mt-0.5">{{ $p->name }}</span>
                            @if($p->description)
                                <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $p->description }}</p>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Submit Actions -->
        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <span class="text-xs text-slate-500">
                Terpilih: <strong class="text-primary font-mono text-sm" x-text="selectedPerms.length">0</strong> hak akses
            </span>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.roles.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-sm font-bold shadow-sm transition-all flex items-center gap-2 cursor-pointer">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Peran &amp; Hak Akses</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

