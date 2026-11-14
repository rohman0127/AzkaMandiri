@extends('layouts.admin')

@section('title', 'Profil Akun Administrator')
@section('breadcrumb', 'Pengaturan / Akun Administrator')

@section('content')
<div class="w-full space-y-6">
    <div>
        <h2 class="text-xl font-extrabold text-[#172B4D]">Profil &amp; Keamanan Akun</h2>
        <p class="text-xs text-gray-500">Perbarui nama pengguna, email login, dan password administrator</p>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Informasi Akun</h3>

            <div>
                <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Administrator *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Email Login *</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-gray-100">
            <h3 class="text-sm font-bold text-[#172B4D] uppercase tracking-wider border-b border-gray-100 pb-3">Ubah Password (Opsional)</h3>
            <p class="text-xs text-gray-400">Kosongkan kolom password di bawah ini jika tidak ingin mengubah password saat ini.</p>

            <div>
                <label for="current_password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password"
                       class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                       placeholder="••••••••">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="new_password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Password Baru</label>
                    <input type="password" id="new_password" name="new_password"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="••••••••">
                </div>

                <div>
                    <label for="new_password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                           class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition"
                           placeholder="••••••••">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end pt-4 border-t border-gray-100">
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] text-xs font-bold transition shadow-sm flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                <span>Perbarui Akun Administrator</span>
            </button>
        </div>
    </form>
</div>
@endsection

