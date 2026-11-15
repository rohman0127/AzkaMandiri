@extends('layouts.admin')

@section('title', 'Edit Surat Penawaran ' . $quotation->quotation_number)

@section('content')
<div class="space-y-6">

    <!-- Top Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition">Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.pos.quotations.index') }}" class="hover:text-primary transition">Penawaran Harga</a>
                <span>/</span>
                <a href="{{ route('admin.pos.quotations.show', $quotation) }}" class="hover:text-primary transition">{{ $quotation->quotation_number }}</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Edit</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2.5">
                <i data-lucide="edit-3" class="w-7 h-7 text-[#D6A84F]"></i>
                <span>Edit Surat Penawaran: {{ $quotation->quotation_number }}</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui rincian spesifikasi, volume, atau penyesuaian harga penawaran.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.pos.quotations.show', $quotation) }}" 
               class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition">
                Kembali ke Detail
            </a>
        </div>
    </div>

    @php
        $initialItems = $quotation->items->map(function($item) {
            return [
                'product_id' => $item->product_id ?: '',
                'item_name' => $item->item_name,
                'dimensions' => $item->dimensions ?: '',
                'quantity' => (float)$item->quantity,
                'unit_name' => $item->unit_name ?: 'unit',
                'unit_price' => (float)$item->unit_price,
            ];
        })->values()->toArray();
    @endphp

    <!-- Hidden Data Holder for Clean Alpine Extraction -->
    <div id="quotation-form-data" class="hidden"
         data-products="{{ json_encode($products) }}"
         data-items="{{ json_encode(old('items', $initialItems)) }}"
         data-discount="{{ old('discount', (float)$quotation->discount) }}"
         data-tax="{{ old('tax', (float)$quotation->tax) }}"
         data-is-custom-customer="{{ old('customer_id', $quotation->customer_id) ? 'false' : 'true' }}"></div>

    <!-- Main Form -->
    <form action="{{ route('admin.pos.quotations.update', $quotation) }}" method="POST" x-data="quotationForm" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- SECTION 1: Header & Metadata Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-primary"></i>
                    <span>Informasi Surat &amp; Pelanggan</span>
                </h3>
                <span class="text-[11px] font-mono font-bold text-[#b45309] bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200">
                    No: {{ $quotation->quotation_number }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Tanggal Penawaran -->
                <div>
                    <label for="date" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Tanggal Diterbitkan <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" id="date" name="date" value="{{ old('date', $quotation->date ? $quotation->date->format('Y-m-d') : '') }}" required
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:border-primary transition">
                    @error('date')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Masa Berlaku -->
                <div>
                    <label for="valid_until" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Berlaku Sampai <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" id="valid_until" name="valid_until" value="{{ old('valid_until', $quotation->valid_until ? $quotation->valid_until->format('Y-m-d') : '') }}" required
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:border-primary transition">
                    @error('valid_until')
                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Status Penawaran <span class="text-rose-500">*</span>
                    </label>
                    <select id="status" name="status" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:border-primary transition font-semibold">
                        <option value="draft" {{ old('status', $quotation->status) == 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                        <option value="sent" {{ old('status', $quotation->status) == 'sent' ? 'selected' : '' }}>Terkirim ke Klien</option>
                        <option value="accepted" {{ old('status', $quotation->status) == 'accepted' ? 'selected' : '' }}>Disetujui / Diterima (Accepted)</option>
                        <option value="rejected" {{ old('status', $quotation->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Tipe Pesanan / Pekerjaan -->
                <div>
                    <label for="order_type" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Tipe Pekerjaan <span class="text-rose-500">*</span>
                    </label>
                    <select id="order_type" name="order_type" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:border-primary transition font-semibold">
                        <option value="project_custom" {{ old('order_type', $quotation->order_type) == 'project_custom' ? 'selected' : '' }}>Pekerjaan Fabrikasi &amp; Pemasangan Custom</option>
                        <option value="retail" {{ old('order_type', $quotation->order_type) == 'retail' ? 'selected' : '' }}>Pengadaan Bahan / Material Ritel</option>
                    </select>
                </div>

            </div>

            <!-- Customer Picker & Quick Details -->
            <div class="pt-3 border-t border-slate-100">
                <div class="flex items-center justify-between mb-3">
                    <label for="customer_id" class="text-xs font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4 text-[#D6A84F]"></i>
                        <span>Pilih Pelanggan / Klien</span>
                    </label>
                    <button type="button" @click="isCustomCustomer = !isCustomCustomer" 
                            class="text-xs text-primary hover:underline font-semibold flex items-center gap-1">
                        <span x-text="isCustomCustomer ? 'Pilih dari Database Pelanggan' : '+ Input Manual / Tamu Baru'"></span>
                    </button>
                </div>

                <!-- Mode 1: Pilih dari database pelanggan -->
                <div x-show="!isCustomCustomer" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <select id="customer_id" name="customer_id"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:border-primary transition">
                            <option value="">-- Pelanggan Umum / Pilih dari Database --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" {{ old('customer_id', $quotation->customer_id) == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} {{ $c->company_name ? "({$c->company_name})" : '' }} &bull; {{ $c->phone ?: '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Mode 2: Input manual pelanggan / walk-in -->
                <div x-show="isCustomCustomer" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50/60 p-4 rounded-xl border border-slate-200/80">
                    <div>
                        <label for="customer_name" class="block text-[11px] font-bold text-slate-700 mb-1">Nama Klien / Kontak</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $quotation->customer_name) }}"
                               class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-primary transition">
                    </div>
                    <div>
                        <label for="customer_company" class="block text-[11px] font-bold text-slate-700 mb-1">Nama Perusahaan / Instansi</label>
                        <input type="text" id="customer_company" name="customer_company" value="{{ old('customer_company', $quotation->customer_company) }}"
                               class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-primary transition">
                    </div>
                    <div>
                        <label for="customer_phone" class="block text-[11px] font-bold text-slate-700 mb-1">No. WhatsApp / Telepon</label>
                        <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $quotation->customer_phone) }}"
                               class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-primary transition">
                    </div>
                    <div class="md:col-span-3">
                        <label for="customer_address" class="block text-[11px] font-bold text-slate-700 mb-1">Alamat Proyek / Lokasi Pemasangan</label>
                        <input type="text" id="customer_address" name="customer_address" value="{{ old('customer_address', $quotation->customer_address) }}"
                               class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-primary transition">
                    </div>
                </div>
            </div>

        </div>

        <!-- SECTION 2: Dynamic Items & Specifications -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4 text-[#D6A84F]"></i>
                        <span>Rincian Item Barang &amp; Jasa Pekerjaan</span>
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Ubah item pekerjaan atau sesuaikan harga penawaran.</p>
                </div>
                <button type="button" @click="addItem()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-bold transition">
                    <i data-lucide="plus" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>Tambah Baris</span>
                </button>
            </div>

            <!-- Dynamic Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-2.5 px-3 w-10 text-center">#</th>
                            <th class="py-2.5 px-3 min-w-[240px]">Nama Barang / Item Pekerjaan</th>
                            <th class="py-2.5 px-3 min-w-[170px]">Dimensi / Spesifikasi</th>
                            <th class="py-2.5 px-3 w-24 text-center">Volume</th>
                            <th class="py-2.5 px-3 w-24 text-center">Satuan</th>
                            <th class="py-2.5 px-3 w-36 text-right">Harga Satuan (Rp)</th>
                            <th class="py-2.5 px-3 w-36 text-right">Total (Rp)</th>
                            <th class="py-2.5 px-3 w-12 text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="(item, index) in items" :key="index">
                            <tr class="hover:bg-slate-50/50 transition">
                                <!-- Row Number -->
                                <td class="py-3 px-3 text-center text-slate-400 font-mono font-bold" x-text="index + 1"></td>

                                <!-- Product / Item Name -->
                                <td class="py-3 px-3">
                                    <div class="space-y-1.5">
                                        <!-- Quick product picker -->
                                        <select :name="`items[${index}][product_id]`" x-model="item.product_id" @change="onProductSelect(item)"
                                                class="w-full px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-700 focus:bg-white focus:outline-none focus:border-primary transition">
                                            <option value="">-- Pilih Material POS (Opsional) --</option>
                                            <template x-for="p in products" :key="p.id">
                                                <option :value="p.id" x-text="`${p.name} (Rp ${Math.round(p.price).toLocaleString('id-ID')})`"></option>
                                            </template>
                                        </select>
                                        <!-- Item name input -->
                                        <input type="text" :name="`items[${index}][item_name]`" x-model="item.item_name" required
                                               placeholder="Tuliskan nama barang atau pekerjaan custom..."
                                               class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-800 font-semibold focus:outline-none focus:border-primary transition">
                                    </div>
                                </td>

                                <!-- Dimensions & Specs -->
                                <td class="py-3 px-3">
                                    <input type="text" :name="`items[${index}][dimensions]`" x-model="item.dimensions"
                                           placeholder="Ukuran: P x L / Warna / Tebal"
                                           class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:border-primary transition">
                                </td>

                                <!-- Quantity -->
                                <td class="py-3 px-3">
                                    <input type="number" step="any" min="0.01" :name="`items[${index}][quantity]`" x-model.number="item.quantity" required
                                           class="w-full px-2 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-center font-bold text-slate-800 focus:outline-none focus:border-primary transition">
                                </td>

                                <!-- Unit -->
                                <td class="py-3 px-3">
                                    <input type="text" :name="`items[${index}][unit_name]`" x-model="item.unit_name"
                                           placeholder="unit"
                                           class="w-full px-2 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-center text-slate-700 focus:outline-none focus:border-primary transition">
                                </td>

                                <!-- Unit Price -->
                                <td class="py-3 px-3">
                                    <input type="number" step="any" min="0" :name="`items[${index}][unit_price]`" x-model.number="item.unit_price" required
                                           class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-right font-mono font-bold text-slate-800 focus:outline-none focus:border-primary transition">
                                </td>

                                <!-- Line Total -->
                                <td class="py-3 px-3 text-right font-mono font-bold text-slate-900" x-text="formatIDR(getItemTotal(item))"></td>

                                <!-- Remove Action -->
                                <td class="py-3 px-3 text-center">
                                    <button type="button" @click="removeItem(index)" :disabled="items.length <= 1"
                                            class="p-1 rounded-lg text-slate-300 hover:text-rose-600 hover:bg-rose-50 transition disabled:opacity-20 disabled:hover:bg-transparent disabled:hover:text-slate-300"
                                            title="Hapus Baris">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Bottom Add Row Button -->
            <div class="pt-2 flex justify-start">
                <button type="button" @click="addItem()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-dashed border-slate-300 hover:border-primary hover:bg-slate-50 text-slate-600 hover:text-primary text-xs font-semibold transition">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>+ Tambah Baris Pekerjaan</span>
                </button>
            </div>
        </div>

        <!-- SECTION 3: Terms, Notes & Financial Totals -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left: Notes & Terms (7 cols) -->
            <div class="lg:col-span-7 space-y-4">
                
                <!-- Terms & Conditions -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5">
                    <div class="flex items-center justify-between mb-2">
                        <label for="terms_conditions" class="text-xs font-bold text-slate-800 flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                            <span>Syarat &amp; Ketentuan Penawaran (Terms &amp; Conditions)</span>
                        </label>
                        <span class="text-[10px] text-slate-400">Dicetak di bagian bawah PDF</span>
                    </div>
                    <textarea id="terms_conditions" name="terms_conditions" rows="5"
                              class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 leading-relaxed focus:bg-white focus:outline-none focus:border-primary transition">{{ old('terms_conditions', $quotation->terms_conditions) }}</textarea>
                </div>

                <!-- Internal Notes -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5">
                    <label for="notes" class="block text-xs font-bold text-slate-800 mb-2 flex items-center gap-2">
                        <i data-lucide="message-square" class="w-4 h-4 text-[#D6A84F]"></i>
                        <span>Catatan Proyek / Keterangan Tambahan</span>
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                              class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 leading-relaxed focus:bg-white focus:outline-none focus:border-primary transition">{{ old('notes', $quotation->notes) }}</textarea>
                </div>

            </div>

            <!-- Right: Calculation Summary (5 cols) -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4 sticky top-6">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 flex items-center gap-2">
                        <i data-lucide="calculator" class="w-4 h-4 text-[#D6A84F]"></i>
                        <span>Ringkasan Keuangan Penawaran</span>
                    </h3>

                    <!-- Subtotal -->
                    <div class="flex items-center justify-between text-xs py-1">
                        <span class="text-slate-500">Subtotal Item:</span>
                        <span class="font-mono font-bold text-slate-800 text-sm" x-text="formatIDR(subtotal)">Rp 0</span>
                    </div>

                    <!-- Diskon Khusus -->
                    <div class="space-y-1 py-1">
                        <div class="flex items-center justify-between text-xs">
                            <label for="discount" class="text-slate-500">Potongan Diskon (Rp):</label>
                            <span class="font-mono text-emerald-600 font-bold" x-text="`- ${formatIDR(discount)}`">- Rp 0</span>
                        </div>
                        <input type="number" min="0" step="any" id="discount" name="discount" x-model.number="discount"
                               class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-right font-mono font-bold text-slate-800 focus:bg-white focus:outline-none focus:border-primary transition">
                    </div>

                    <!-- PPN / Pajak -->
                    <div class="space-y-1 py-1">
                        <div class="flex items-center justify-between text-xs">
                            <label for="tax" class="text-slate-500">PPN / Pajak Tambahan (Rp):</label>
                            <span class="font-mono text-slate-700 font-bold" x-text="`+ ${formatIDR(tax)}`">+ Rp 0</span>
                        </div>
                        <input type="number" min="0" step="any" id="tax" name="tax" x-model.number="tax"
                               class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-right font-mono font-bold text-slate-800 focus:bg-white focus:outline-none focus:border-primary transition">
                    </div>

                    <!-- Grand Total Banner -->
                    <div class="pt-3 border-t-2 border-slate-900 mt-2">
                        <div class="p-4 rounded-xl bg-slate-900 text-white flex items-center justify-between shadow-md">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Penawaran</p>
                                <p class="text-xs text-slate-300">Grand Total Proyek</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-extrabold text-[#D6A84F] font-mono" x-text="formatIDR(grandTotal)">Rp 0</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="pt-3 flex flex-col gap-2">
                        <button type="submit" 
                                class="w-full py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-lg shadow-primary/20 flex items-center justify-center gap-2 transition transform active:scale-98">
                            <i data-lucide="save" class="w-4 h-4 text-[#D6A84F]"></i>
                            <span>Simpan Perubahan Penawaran</span>
                        </button>
                        <a href="{{ route('admin.pos.quotations.show', $quotation) }}" 
                           class="w-full py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-semibold text-center transition">
                            Batalkan
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </form>

</div>
@endsection

@push('scripts')
@vite(['resources/js/admin/quotation-form.js'])
@endpush
