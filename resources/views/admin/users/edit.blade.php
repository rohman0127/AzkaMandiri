@extends('layouts.admin')

@section('title', 'Edit Pengguna: ' . $user->name)

@section('content')
<div class="w-full space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.users.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Pengguna: {{ $user->name }}</h1>
            <p class="text-sm text-slate-500">Perbarui data profil, peran sistem, dan status aktif akun</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Profil Dasar -->
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4 text-primary"></i>
                    <span>Informasi Akun &amp; Identitas</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap Staf / Karyawan <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary @error('name') border-rose-500 @enderror">
                        @error('name')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email Login <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary @error('email') border-rose-500 @enderror">
                        @error('email')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary @error('phone') border-rose-500 @enderror">
                        @error('phone')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 2: Penugasan Role -->
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-primary"></i>
                    <span>Penugasan Peran (Role)</span>
                </h3>

                @php
                    $currentRoleId = $user->roles->first()?->id;
                @endphp

                <div class="space-y-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Peran Staf <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach($roles as $role)
                        <label class="relative flex flex-col p-4 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-all focus-within:ring-2 focus-within:ring-primary">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-sm text-slate-800">{{ $role->name }}</span>
                                <input type="radio" name="role_id" value="{{ $role->id }}" {{ old('role_id', $currentRoleId) == $role->id ? 'checked' : '' }}
                                       class="text-primary focus:ring-primary">
                            </div>
                            <p class="text-xs text-slate-500 line-clamp-2">{{ $role->description ?: 'Hak akses standar modul.' }}</p>
                        </label>
                        @endforeach
                    </div>
                    @error('role_id')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 3: Reset Password (Opsional) -->
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-2">
                    <i data-lucide="lock" class="w-4 h-4 text-primary"></i>
                    <span>Ubah Kata Sandi (Opsional)</span>
                </h3>
                <p class="text-xs text-slate-400 mb-4">Biarkan kedua kolom di bawah kosong jika Anda tidak ingin mengubah password saat ini.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter jika ingin diubah"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary @error('password') border-rose-500 @enderror">
                        @error('password')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Ulangi Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ketik ulang password baru"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Section 4: Status Akun -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-bold text-slate-800">Status Akun Aktif</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Jika dinonaktifkan, akun ini tidak akan dapat login ke dashboard admin.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                           {{ auth()->id() === $user->id ? 'disabled' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>
            @if(auth()->id() === $user->id)
                <p class="text-[11px] text-amber-600 italic -mt-4">* Anda tidak dapat menonaktifkan status akun Anda sendiri saat ini.</p>
            @endif

            <!-- Submit Buttons -->
            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-sm font-bold shadow-sm transition-all flex items-center gap-2 cursor-pointer">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

