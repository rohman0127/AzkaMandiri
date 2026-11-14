@extends('layouts.admin')

@section('title', 'Manajemen Pengguna & Staf')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Pengguna &amp; Akun Staf</h1>
            <p class="text-sm text-slate-500">Kelola akun administrator, kasir, staf gudang, serta status akses sistem</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-sm shadow-sm transition-colors">
                <i data-lucide="shield" class="w-4 h-4 text-slate-500"></i>
                <span>Kelola Peran &amp; Hak Akses</span>
            </a>
            @can('users.manage')
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#172B4D] hover:bg-[#101D33] text-white font-medium text-sm shadow-sm transition-colors cursor-pointer">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Tambah Pengguna Baru</span>
            </a>
            @endcan
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Akun</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalUsers }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Pengguna terdaftar</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Akun Aktif</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $activeUsers }}</h3>
                <p class="text-xs text-emerald-600 font-medium mt-0.5">Dapat login &amp; akses</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Akun Dinonaktifkan</p>
                <h3 class="text-2xl font-bold {{ $inactiveUsers > 0 ? 'text-rose-600' : 'text-slate-700' }} mt-1">{{ $inactiveUsers }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Akses login diblokir</p>
            </div>
            <div class="w-12 h-12 rounded-xl {{ $inactiveUsers > 0 ? 'bg-rose-50 text-rose-600' : 'bg-slate-50 text-slate-400' }} flex items-center justify-center">
                <i data-lucide="user-x" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Peran (Roles)</p>
                <h3 class="text-2xl font-bold text-primary mt-1">{{ $roles->count() }} Peran</h3>
                <div class="mt-1">
                    <a href="{{ route('admin.roles.index') }}" class="text-xs font-semibold text-primary hover:underline">
                        Lihat Matriks Izin →
                    </a>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-5">
                <label class="block text-xs font-medium text-slate-600 mb-1">Cari Pengguna</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau no. HP..."
                           class="w-full pl-9 pr-3 py-2 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-2.5"></i>
                </div>
            </div>

            <div class="md:col-span-3">
                <label class="block text-xs font-medium text-slate-600 mb-1">Peran (Role)</label>
                <select name="role_id" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <option value="">Semua Peran</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-slate-600 mb-1">Status Akun</label>
                <select name="status" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Dinonaktifkan</option>
                </select>
            </div>

            <div class="md:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-medium transition-colors flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Filter</span>
                </button>
                @if(request()->anyFilled(['search', 'role_id', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium transition-colors" title="Reset">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-medium">
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Kontak</th>
                        <th class="py-3.5 px-4 text-center">Peran (Role)</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Tanggal Dibuat</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/75 transition-colors">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#172B4D] to-[#101D33] text-[#D6A84F] font-bold text-xs flex items-center justify-center shrink-0 shadow-xs border border-white/10">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-bold text-slate-800 flex items-center gap-2">
                                        <span>{{ $user->name }}</span>
                                        @if(auth()->id() === $user->id)
                                            <span class="px-1.5 py-0.5 rounded text-[10px] bg-blue-100 text-blue-700 font-bold">Anda</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-400 mt-0.5">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="py-3 px-4">
                            @if($user->phone)
                                <div class="text-xs text-slate-600 flex items-center gap-1.5">
                                    <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                    <span>{{ $user->phone }}</span>
                                </div>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>

                        <td class="py-3 px-4 text-center">
                            @foreach($user->roles as $role)
                                @if($role->name === 'Super Admin')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> {{ $role->name }}
                                    </span>
                                @elseif($role->name === 'Kasir')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                        <i data-lucide="calculator" class="w-3.5 h-3.5"></i> {{ $role->name }}
                                    </span>
                                @elseif($role->name === 'Staff Gudang')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i data-lucide="box" class="w-3.5 h-3.5"></i> {{ $role->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $role->name }}
                                    </span>
                                @endif
                            @endforeach
                            @if($user->roles->isEmpty())
                                <span class="text-xs text-slate-400 italic">Tanpa Role</span>
                            @endif
                        </td>

                        <td class="py-3 px-4 text-center">
                            @if($user->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Dinonaktifkan
                                </span>
                            @endif
                        </td>

                        <td class="py-3 px-4 text-center text-xs text-slate-500">
                            {{ $user->created_at->translatedFormat('d M Y') }}
                        </td>

                        <td class="py-3 px-4 text-center">
                            <div class="inline-flex items-center gap-1.5">
                                @can('users.manage')
                                <!-- Toggle Active Status Button -->
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="w-8 h-8 rounded-xl border {{ $user->is_active ? 'bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-600 hover:text-white' : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-600 hover:text-white' }} flex items-center justify-center transition shadow-2xs cursor-pointer"
                                                title="{{ $user->is_active ? 'Blokir / Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                            <i data-lucide="{{ $user->is_active ? 'user-x' : 'user-check' }}" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-[#172B4D] hover:text-white text-slate-700 border border-slate-200 flex items-center justify-center transition shadow-2xs" title="Edit Akun &amp; Role">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                @if(auth()->id() !== $user->id && (!$user->hasRole('Super Admin') || $totalUsers > 1))
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline form-delete"
                                          data-confirm="Hapus akun '{{ $user->name }}'? Pengguna ini tidak akan dapat login lagi.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 border border-rose-200 flex items-center justify-center transition shadow-2xs cursor-pointer delete-confirm" title="Hapus Pengguna">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                <i data-lucide="users" class="w-8 h-8"></i>
                            </div>
                            <p class="font-medium text-slate-600">Tidak ada pengguna yang cocok dengan kriteria filter</p>
                            <p class="text-xs text-slate-400 mt-1">Gunakan kata kunci lain atau reset filter pencarian.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

