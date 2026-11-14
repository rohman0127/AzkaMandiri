@extends('layouts.admin')

@section('title', 'Detail Pesan Masuk')
@section('breadcrumb', 'Pesan Masuk / Detail dari ' . $contactMessage->name)

@section('content')
<div class="w-full space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Detail Pesan Masuk</h2>
            <p class="text-xs text-gray-500">Diterima pada {{ $contactMessage->created_at->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
        </div>
        <a href="{{ route('admin.contact-messages.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Inbox</span>
        </a>
    </div>

    <!-- Message Detail Card -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-6">
        <!-- Status & Direct Actions Bar -->
        <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-xl bg-gray-50 border border-gray-200">
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500 font-semibold">Status Saat Ini:</span>
                @if($contactMessage->status === 'unread')
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">Baru (Belum Dibaca)</span>
                @elseif($contactMessage->status === 'followed_up')
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Sudah Ditindaklanjuti</span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-200 text-gray-700">Sudah Dibaca</span>
                @endif
            </div>

            <!-- Status Changer Form -->
            <form action="{{ route('admin.contact-messages.update-status', $contactMessage->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="py-1.5 px-3 bg-white border border-gray-300 rounded-lg text-xs font-semibold focus:outline-none focus:border-[#D6A84F]">
                    <option value="read" {{ $contactMessage->status === 'read' ? 'selected' : '' }}>Tandai Sudah Dibaca</option>
                    <option value="followed_up" {{ $contactMessage->status === 'followed_up' ? 'selected' : '' }}>Tandai Sudah Ditindaklanjuti</option>
                    <option value="unread" {{ $contactMessage->status === 'unread' ? 'selected' : '' }}>Tandai Belum Dibaca</option>
                </select>
                <button type="submit" class="px-3 py-1.5 rounded-lg bg-[#172B4D] text-white text-xs font-bold hover:bg-[#101D33] transition">
                    Ubah
                </button>
            </form>
        </div>

        <!-- Sender Profile Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-6 border-b border-gray-100 text-sm">
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase">Nama Pengirim</p>
                <p class="font-extrabold text-[#172B4D] text-base mt-0.5">{{ $contactMessage->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase">Nomor WhatsApp / Telepon</p>
                <p class="font-bold text-[#172B4D] mt-0.5">{{ $contactMessage->phone_number }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase">Alamat Email</p>
                <p class="text-gray-700 mt-0.5">{{ $contactMessage->email ?: 'Tidak mencantumkan email' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase">Alamat IP Pengirim</p>
                <p class="text-gray-500 font-mono text-xs mt-0.5">{{ $contactMessage->ip_address ?: '-' }}</p>
            </div>
        </div>

        <!-- Message Content -->
        <div class="space-y-3">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Subjek Pesan:</span>
                <h3 class="text-lg font-bold text-[#172B4D] mt-1">{{ $contactMessage->subject }}</h3>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Isi Pesan:</span>
                <div class="mt-2 p-5 rounded-xl bg-gray-50 border border-gray-100 text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">
{{ $contactMessage->message }}
                </div>
            </div>
        </div>

        <!-- Reply Directly Via WhatsApp Button -->
        @php
            $rawPhone = preg_replace('/[^0-9]/', '', $contactMessage->phone_number);
            if (str_starts_with($rawPhone, '0')) {
                $rawPhone = '62' . substr($rawPhone, 1);
            }
            $replyMsg = "Halo {$contactMessage->name}, terima kasih telah menghubungi AzkaMandiri terkait: \"{$contactMessage->subject}\".";
            $waReplyUrl = "https://wa.me/{$rawPhone}?text=" . rawurlencode($replyMsg);
        @endphp

        <div class="pt-6 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
            <form action="{{ route('admin.contact-messages.destroy', $contactMessage->id) }}" method="POST"
                  class="inline form-delete"
                  data-confirm="Apakah Anda yakin ingin menghapus pesan dari '{{ $contactMessage->name }}' secara permanen?">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 font-semibold text-xs transition flex items-center gap-1.5 cursor-pointer delete-confirm">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    <span>Hapus Pesan</span>
                </button>
            </form>

            <a href="{{ $waReplyUrl }}" target="_blank"
               class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition shadow-sm flex items-center gap-2">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                <span>Balas Langsung via WhatsApp</span>
            </a>
        </div>
    </div>
</div>
@endsection

