<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator – AzkaMandiri</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/brand/favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#101D33] min-h-screen flex items-center justify-center p-4 antialiased text-[#F5F6F8]">
    <!-- Ambient architectural background glow -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-[#D6A84F]/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-[#172B4D]/60 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-[#172B4D]/90 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-8 sm:p-10">
            <!-- Brand Logo -->
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-flex flex-col items-center transition-transform hover:scale-105 duration-200 group">
                    <div class="h-16 w-20 rounded-2xl bg-white p-2 flex items-center justify-center shadow-lg shadow-black/30 border border-white/20 mb-3 group-hover:shadow-amber-500/20 transition">
                        <img src="{{ asset('assets/brand/logo-icon.svg') }}" alt="Azka Mandiri" class="max-h-full max-w-full object-contain">
                    </div>
                    <span class="font-serif font-black text-2xl tracking-wide text-white">AZKA MANDIRI</span>
                    <span class="text-[10px] uppercase tracking-[0.25em] text-[#D6A84F] font-bold mt-1">Spesialis Aluminium &amp; Kaca</span>
                </a>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400 font-semibold mt-4">Enterprise POS &amp; Management</p>
                <h1 class="text-lg font-bold text-white mt-1">Masuk ke Panel Kontrol</h1>
            </div>

            @if(session('success'))
                <div class="mb-6 p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-sm flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 shrink-0 text-emerald-400"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-3.5 rounded-xl bg-red-500/10 border border-red-500/20 text-red-300 text-sm">
                    <div class="flex items-center gap-2 font-semibold mb-1">
                        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 text-red-400"></i>
                        <span>Terjadi Kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 text-red-200/90 pl-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5" x-data="{ showPass: false }">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Email Administrator</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </span>
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required autofocus
                            class="w-full pl-10 pr-4 py-2.5 bg-[#101D33]/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-[#D6A84F] focus:ring-1 focus:ring-[#D6A84F] transition text-sm">
                    </div>
                </div>

                <!-- Password Input with Show/Hide Toggle -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">Password</label>
                        <button type="button" @click="showPass = !showPass" class="text-xs text-[#D6A84F] hover:underline flex items-center gap-1 focus:outline-none">
                            <span x-text="showPass ? 'Sembunyikan' : 'Tampilkan'">Tampilkan</span>
                        </button>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>
                        <input :type="showPass ? 'text' : 'password'" type="password" id="password" name="password" required
                            class="w-full pl-10 pr-10 py-2.5 bg-[#101D33]/80 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-[#D6A84F] focus:ring-1 focus:ring-[#D6A84F] transition text-sm"
                            placeholder="••••••••">
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-white transition focus:outline-none">
                            <i data-lucide="eye" x-show="!showPass" class="w-4 h-4"></i>
                            <i data-lucide="eye-off" x-show="showPass" x-cloak class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-gray-300 hover:text-white select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-600 text-[#D6A84F] focus:ring-[#D6A84F] bg-[#101D33]">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                    <span class="text-xs text-[#D6A84F]/80 hover:text-[#D6A84F]">Akses Terlindungi</span>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-[#D6A84F] to-[#b88d3b] hover:from-[#e0b45b] hover:to-[#c79a45] text-[#101D33] font-bold rounded-xl shadow-lg shadow-[#D6A84F]/20 hover:shadow-[#D6A84F]/30 transition duration-200 flex items-center justify-center gap-2 text-sm cursor-pointer">
                    <span>Masuk ke Panel Admin</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/10 text-center">
                <a href="{{ url('/') }}" class="text-xs text-gray-400 hover:text-white inline-flex items-center gap-1.5 transition">
                    <i data-lucide="home" class="w-3.5 h-3.5"></i>
                    <span>Kembali ke Halaman Depan Website</span>
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-gray-500 mt-6">
            &copy; {{ date('Y') }} AzkaMandiri – Jasa Aluminium &amp; Kaca. Seluruh hak cipta dilindungi.
        </p>
    </div>
</body>
</html>

