@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('breadcrumb', 'Kotak Masuk & Permintaan Konsultasi')

@section('content')
<div class="space-y-6" x-data="{
    detailModal: false,
    selectedMsg: {
        id: '',
        name: '',
        phone_number: '',
        email: '',
        subject: '',
        message: '',
        status: 'unread',
        created_at: '',
        ip_address: '',
        waUrl: '',
        updateStatusUrl: ''
    },
    openDetail(item) {
        this.selectedMsg = item;
        this.detailModal = true;
        this.$nextTick(() => {
            $('#msg_status_select').val(item.status).trigger('change');
            if (window.initSelect2) window.initSelect2(this.$refs.detailModalCard);
        });
    }
}">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Pesan Masuk &amp; Konsultasi</h2>
            <p class="text-xs text-gray-500">Daftar pertanyaan dan permintaan survei lokasi dari calon pelanggan website</p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.contact-messages.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pengirim, telepon, atau subjek..."
                       class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#D6A84F] focus:bg-white transition">
            </div>

            <div class="w-full sm:w-48">
                <select name="status" class="select2 w-full">
                    <option value="">Semua Status</option>
                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Belum Dibaca (Baru)</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                    <option value="followed_up" {{ request('status') === 'followed_up' ? 'selected' : '' }}>Ditindaklanjuti</option>
                </select>
            </div>

            <button type="submit" class="px-5 py-2 rounded-xl bg-[#172B4D] text-white text-xs font-bold hover:bg-[#101D33] transition flex items-center justify-center gap-1.5 cursor-pointer">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                <span>Filter</span>
            </button>

            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.contact-messages.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card (Full Width) -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden w-full">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Pengirim</th>
                        <th class="px-6 py-3.5">Kontak</th>
                        <th class="px-6 py-3.5">Subjek &amp; Pesan</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-center">Waktu Masuk</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($messages as $msg)
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $msg->phone_number);
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                            $waText = urlencode("Halo {$msg->name}, terima kasih telah menghubungi AzkaMandiri. Menanggapi pesan Anda mengenai: \"{$msg->subject}\"...");
                            $waUrl = "https://wa.me/{$cleanPhone}?text={$waText}";
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition {{ $msg->status === 'unread' ? 'bg-amber-50/20 font-semibold' : '' }}">
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#172B4D] text-sm">{{ $msg->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <div class="flex items-center gap-1.5 text-gray-800">
                                    <i data-lucide="phone" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                                    <span>{{ $msg->phone_number }}</span>
                                </div>
                                @if($msg->email)
                                    <div class="text-gray-400 text-[11px] mt-0.5">{{ $msg->email }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs max-w-sm">
                                <p class="font-bold text-gray-800">{{ $msg->subject }}</p>
                                <p class="text-gray-500 line-clamp-1 mt-0.5">{{ $msg->message }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($msg->status === 'unread')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-100 text-red-800">Baru</span>
                                @elseif($msg->status === 'followed_up')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Ditindaklanjuti</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-600">Dibaca</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-xs text-gray-400">
                                {{ $msg->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Modal Detail Trigger -->
                                    <button type="button" 
                                            data-item="{{ json_encode([
                                                'id' => $msg->id,
                                                'name' => $msg->name,
                                                'phone_number' => $msg->phone_number,
                                                'email' => $msg->email ?? '',
                                                'subject' => $msg->subject,
                                                'message' => $msg->message,
                                                'status' => $msg->status,
                                                'created_at' => $msg->created_at->format('d M Y, H:i') . ' WIB',
                                                'ip_address' => $msg->ip_address ?? '-',
                                                'waUrl' => $waUrl,
                                                'updateStatusUrl' => route('admin.contact-messages.update-status', $msg->id),
                                            ]) }}"
                                            @click="openDetail(JSON.parse($el.getAttribute('data-item')))"
                                            class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 transition cursor-pointer" 
                                            title="Buka Detail Pesan">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>

                                    <!-- Delete Form Intercepted by SweetAlert2 -->
                                    <form action="{{ route('admin.contact-messages.destroy', $msg->id) }}" method="POST"
                                          data-confirm="Hapus pesan dari '{{ $msg->name }}'?" 
                                          class="inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-red-600 hover:bg-red-50 transition cursor-pointer delete-confirm" title="Hapus Pesan">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i data-lucide="inbox" class="w-10 h-10 mx-auto text-gray-300 mb-2"></i>
                                <p class="text-sm font-semibold">Tidak ada pesan yang sesuai filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL: Detail Pesan Masuk & Balas WhatsApp                                -->
    <!-- ========================================================================= -->
    <div x-show="detailModal" 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
         style="display: none;"
         x-cloak>
        <div @click.outside="detailModal = false" 
             x-ref="detailModalCard"
             class="bg-white rounded-3xl border border-gray-200/90 shadow-2xl w-full max-w-xl overflow-hidden transform transition-all relative my-8">
            <div class="h-1.5 w-full bg-gradient-to-r from-[#172B4D] via-[#D6A84F] to-[#172B4D]"></div>
            
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-200/50">
                        <i data-lucide="mail-open" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-[#172B4D] text-base">Detail Pesan Masuk</h3>
                        <p class="text-xs text-gray-500" x-text="selectedMsg.created_at"></p>
                    </div>
                </div>
                <button type="button" @click="detailModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto text-sm">
                <!-- Sender Info Card -->
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-semibold text-gray-400 uppercase">Nama Pengirim</span>
                            <h4 class="font-bold text-[#172B4D] text-base" x-text="selectedMsg.name"></h4>
                        </div>
                        <a :href="selectedMsg.waUrl" target="_blank" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                            <span>Balas via WhatsApp</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-2 text-xs text-gray-600 border-t border-gray-200/60">
                        <div>
                            <span class="text-gray-400">Nomor Telepon:</span>
                            <span class="font-semibold text-gray-800 ml-1" x-text="selectedMsg.phone_number"></span>
                        </div>
                        <div>
                            <span class="text-gray-400">Email:</span>
                            <span class="font-semibold text-gray-800 ml-1" x-text="selectedMsg.email || '-'"></span>
                        </div>
                    </div>
                </div>

                <!-- Subject & Full Message -->
                <div class="space-y-1.5">
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Subjek Pesan:</span>
                    <p class="font-bold text-[#172B4D] text-sm" x-text="selectedMsg.subject"></p>
                </div>

                <div class="space-y-1.5">
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Isi Pesan:</span>
                    <div class="p-4 bg-gray-50 border border-gray-200/80 rounded-2xl text-gray-700 leading-relaxed text-sm whitespace-pre-wrap" x-text="selectedMsg.message"></div>
                </div>

                <!-- Status Update Form -->
                <form :action="selectedMsg.updateStatusUrl" method="POST" class="pt-4 border-t border-gray-100 flex items-center justify-between gap-4">
                    @csrf
                    @method('PATCH')
                    <div class="flex-1">
                        <label for="msg_status_select" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Status Tindak Lanjut</label>
                        <select id="msg_status_select" name="status" class="select2 w-full">
                            <option value="unread">Belum Dibaca (Baru)</option>
                            <option value="read">Sudah Dibaca</option>
                            <option value="followed_up">Ditindaklanjuti (Selesai)</option>
                        </select>
                    </div>
                    <button type="submit" class="mt-4 px-4 py-2.5 rounded-xl bg-[#172B4D] hover:bg-[#101D33] text-white text-xs font-bold transition flex items-center gap-1.5 shrink-0 cursor-pointer">
                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                        <span>Update Status</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
