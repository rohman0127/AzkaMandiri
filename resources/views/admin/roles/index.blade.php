@extends('layouts.admin')

@section('title', 'Manajemen Peran & Hak Akses (RBAC)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Peran &amp; Hak Akses</h1>
            <p class="text-sm text-slate-500">Konfigurasi peran pengguna (Roles) dan matriks izin akses modul sistem (Permissions)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-sm shadow-sm transition-colors">
                <i data-lucide="users" class="w-4 h-4 text-slate-500"></i>
                <span>Kelola Pengguna</span>
            </a>
            @can('roles.manage')
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#172B4D] hover:bg-[#101D33] text-white font-medium text-sm shadow-sm transition-colors cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Peran Baru</span>
            </a>
            @endcan
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Peran (Roles)</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $roles->count() }} Peran</h3>
                <p class="text-xs text-slate-500 mt-0.5">Tingkatan akses staf</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i data-lucide="shield" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Hak Akses Sistem</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $totalPermissions }} Permissions</h3>
                <p class="text-xs text-emerald-600 font-medium mt-0.5">Tersedia di 7 modul</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="key" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Keamanan RBAC</p>
                <h3 class="text-2xl font-bold text-primary mt-1">Aktif &amp; Dinamis</h3>
                <p class="text-xs text-slate-500 mt-0.5">Gate &amp; Middleware enforced</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <i data-lucide="lock" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Roles Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($roles as $role)
        @php
            $permCount = $role->slug === 'super-admin' ? $totalPermissions : $role->permissions_count;
            $percent = $totalPermissions > 0 ? round(($permCount / $totalPermissions) * 100) : 0;
        @endphp
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div>
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl {{ $role->slug === 'super-admin' ? 'bg-purple-100 text-purple-700' : ($role->slug === 'kasir' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700') }} flex items-center justify-center font-bold">
                            <i data-lucide="{{ $role->slug === 'super-admin' ? 'crown' : ($role->slug === 'kasir' ? 'calculator' : 'shield-check') }}" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-slate-800">{{ $role->name }}</h3>
                            <span class="text-xs font-mono text-slate-400">{{ $role->slug }}</span>
                        </div>
                    </div>
                    @if($role->is_system)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                            Sistem Bawaan
                        </span>
                    @endif
                </div>

                <p class="text-xs text-slate-500 mb-5 leading-relaxed min-h-[36px]">
                    {{ $role->description ?: 'Peran pengguna dengan hak akses terkustomisasi.' }}
                </p>

                <!-- Stats summary -->
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 space-y-2.5 mb-5 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Pengguna Ditugaskan:</span>
                        <a href="{{ route('admin.users.index', ['role_id' => $role->id]) }}" class="font-bold text-primary hover:underline">
                            {{ $role->users_count }} Pengguna →
                        </a>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Cakupan Izin Akses:</span>
                        <span class="font-bold text-slate-800">{{ $permCount }} / {{ $totalPermissions }} ({{ $percent }}%)</span>
                    </div>

                    <!-- Progress bar -->
                    <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $role->slug === 'super-admin' ? 'bg-purple-600' : ($percent >= 50 ? 'bg-emerald-500' : 'bg-primary') }}"
                             style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Actions footer -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                @can('roles.manage')
                <a href="{{ route('admin.roles.edit', $role->id) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-[#172B4D] hover:text-white text-slate-700 text-xs font-semibold transition-all cursor-pointer">
                    <i data-lucide="sliders" class="w-3.5 h-3.5"></i>
                    <span>Atur Hak Akses</span>
                </a>

                @if(!$role->is_system && $role->users_count === 0)
                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline form-delete"
                          data-confirm="Hapus role '{{ $role->name }}'? Tindakan ini tidak dapat dibatalkan.">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 border border-rose-200 flex items-center justify-center transition shadow-2xs cursor-pointer delete-confirm" title="Hapus Peran">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                @endif
                @endcan
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

