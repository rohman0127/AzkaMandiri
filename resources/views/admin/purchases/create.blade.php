@extends('layouts.admin')

@section('title', 'Catat Restock Pembelian')
@section('breadcrumb', 'Supplier & Belanja / Pembelian / Catat Restock')

@section('content')
<div class="space-y-6" x-data="{
    productsData: {{ Js::from($products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'sku' => $p->sku, 'unit' => $p->unit->symbol ?? 'pcs', 'cost_price' => (float)$p->cost_price])) }},
    items: [
        { product_id: '', unit: '', quantity: 1, unit_cost: 0, subtotal: 0 }
    ],
    addItem() {
        this.items.push({ product_id: '', unit: '', quantity: 1, unit_cost: 0, subtotal: 0 });
    },
    removeItem(index) {
        if (this.items.length > 1) {
            this.items.splice(index, 1);
        }
    },
    onProductChange(index, productId) {
        const prod = this.productsData.find(p => p.id == productId);
        if (prod) {
            this.items[index].product_id = prod.id;
            this.items[index].unit = prod.unit;
            this.items[index].unit_cost = prod.cost_price;
            this.calculateSubtotal(index);
        }
    },
    calculateSubtotal(index) {
        const qty = parseFloat(this.items[index].quantity) || 0;
        const cost = parseFloat(this.items[index].unit_cost) || 0;
        this.items[index].subtotal = qty * cost;
    },
    get grandTotal() {
        return this.items.reduce((sum, item) => sum + (parseFloat(item.subtotal) || 0), 0);
    },
    formatRupiah(num) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);
    }
}">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-[#172B4D]">Form Restock Pembelian Bahan</h2>
            <p class="text-xs text-gray-500">Catat faktur masuk dari supplier untuk menambah stok barang otomatis ke inventaris</p>
        </div>
        <a href="{{ route('admin.purchases.index') }}" 
           class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.purchases.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Info Faktur Card -->
        <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-xs">
            <h3 class="text-sm font-bold text-[#172B4D] mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4 text-[#D6A84F]"></i>
                <span>Informasi Faktur &amp; Supplier</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor Faktur / PO <span class="text-red-500">*</span></label>
                    <input type="text" name="invoice_number" value="{{ old('invoice_number', $invoiceNumber) }}" required 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono font-bold text-[#172B4D]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Pilih Supplier <span class="text-red-500">*</span></label>
                    <select name="supplier_id" required class="select2-luxury w-full">
                        <option value="">Pilih Supplier...</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                {{ $sup->company_name ?: $sup->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Tanggal Pembelian <span class="text-red-500">*</span></label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" required 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Status Pembayaran <span class="text-red-500">*</span></label>
                    <select name="payment_status" required class="select2-luxury w-full">
                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Sebagian (Tempo)</option>
                        <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-xs font-semibold text-gray-700 mb-1">Catatan Pembelian (Opsional)</label>
                <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Catatan termin, nomor surat jalan, atau kondisi barang..." 
                       class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
            </div>
        </div>

        <!-- Tabel Item Barang Masuk -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="text-sm font-bold text-[#172B4D] flex items-center gap-2">
                    <i data-lucide="boxes" class="w-4 h-4 text-[#D6A84F]"></i>
                    <span>Daftar Material / Barang Masuk</span>
                </h3>
                <button type="button" @click="addItem()" 
                        class="px-3 py-1.5 rounded-lg bg-[#172B4D] hover:bg-[#101D33] text-white font-bold text-xs transition flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="plus" class="w-3.5 h-3.5 text-[#D6A84F]"></i>
                    <span>Tambah Baris</span>
                </button>
            </div>

            <div class="overflow-x-auto p-4">
                <table class="w-full text-left text-xs text-gray-600">
                    <thead class="bg-gray-50 text-gray-500 uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-4 py-3 w-5/12">Pilih Produk / Material</th>
                            <th class="px-4 py-3 text-center w-2/12">Kuantitas</th>
                            <th class="px-4 py-3 text-right w-2/12">Harga Beli Satuan (Rp)</th>
                            <th class="px-4 py-3 text-right w-2/12">Subtotal (Rp)</th>
                            <th class="px-4 py-3 text-center w-1/12">Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(item, index) in items" :key="index">
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-4 py-3">
                                    <select :name="'items[' + index + '][product_id]'" 
                                            x-model="item.product_id"
                                            @change="onProductChange(index, $event.target.value)"
                                            required 
                                            class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none bg-white">
                                        <option value="">-- Pilih Produk Material --</option>
                                        <template x-for="prod in productsData" :key="prod.id">
                                            <option :value="prod.id" x-text="prod.name + ' (' + prod.sku + ')'"></option>
                                        </template>
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1">
                                        <input type="number" step="any" min="0.01" 
                                               :name="'items[' + index + '][quantity]'" 
                                               x-model="item.quantity" 
                                               @input="calculateSubtotal(index)"
                                               required 
                                               class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none text-center font-mono">
                                        <span class="text-xs text-gray-400 font-semibold w-12 text-left" x-text="item.unit || 'unit'"></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <input type="number" step="any" min="0" 
                                           :name="'items[' + index + '][unit_cost]'" 
                                           x-model="item.unit_cost" 
                                           @input="calculateSubtotal(index)"
                                           required 
                                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none text-right font-mono">
                                </td>
                                <td class="px-4 py-3 text-right font-mono font-bold text-[#172B4D]" 
                                    x-text="formatRupiah(item.subtotal)">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" @click="removeItem(index)" 
                                            :disabled="items.length === 1"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition disabled:opacity-30 disabled:cursor-not-allowed">
                                        <i data-lucide="trash" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Footer Total Section -->
            <div class="p-6 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-gray-500">
                    <p class="font-semibold text-gray-700">Catatan Pembaruan Stok:</p>
                    <p>Setelah formulir disimpan, jumlah stok fisik dari setiap produk di atas akan bertambah secara otomatis.</p>
                </div>

                <div class="flex items-center gap-6">
                    <div class="text-right">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Total Faktur Restock</span>
                        <span class="text-2xl font-extrabold text-[#172B4D] font-mono block" x-text="formatRupiah(grandTotal)"></span>
                    </div>

                    <button type="submit" 
                            class="px-6 py-3 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] font-extrabold text-sm transition shadow-sm flex items-center gap-2 cursor-pointer">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Transaksi Restock</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

