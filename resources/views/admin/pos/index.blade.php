@extends('layouts.admin')

@section('title', 'Mesin Kasir (POS)')
@section('breadcrumb', 'Kasir & POS / Mesin Kasir')

@section('content')
<div x-data="{
    products: {{ Js::from($products) }},
    categories: {{ Js::from($categories) }},
    search: '',
    selectedCategory: '',
    cart: [],
    customerId: '',
    orderType: 'retail',
    paymentType: 'cash',
    discountAmount: 0,
    paidAmount: 0,
    dueDate: '',
    notes: '',
    customerModal: false,
    isSubmitting: false,
    savingCustomer: false,
    newCustomer: { name: '', phone: '', company_name: '', address: '' },

    get filteredProducts() {
        return this.products.filter(p => {
            const matchSearch = this.search === '' || 
                p.name.toLowerCase().includes(this.search.toLowerCase()) || 
                p.sku.toLowerCase().includes(this.search.toLowerCase()) ||
                (p.barcode && p.barcode.toLowerCase().includes(this.search.toLowerCase()));
            const matchCat = this.selectedCategory === '' || p.category_id == this.selectedCategory;
            return matchSearch && matchCat;
        });
    },

    addToCart(product) {
        if (product.type === 'standard' && product.stock <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Habis!',
                text: 'Produk ' + product.name + ' saat ini tidak memiliki stok fisik.',
                confirmButtonColor: '#D6A84F'
            });
            return;
        }

        const existing = this.cart.find(item => item.product_id === product.id);
        if (existing) {
            if (product.type === 'standard' && existing.quantity + 1 > product.stock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Batas Stok Tercapai',
                    text: 'Stok tersedia hanya ' + product.stock + ' ' + product.unit_name,
                    confirmButtonColor: '#D6A84F'
                });
                return;
            }
            existing.quantity++;
        } else {
            this.cart.push({
                product_id: product.id,
                name: product.name,
                sku: product.sku,
                unit: product.unit_name,
                price: parseFloat(product.price),
                stock: product.stock,
                type: product.type,
                quantity: 1,
                specification: ''
            });
        }

        this.autoFillCashIfPas();
    },

    updateQty(index, delta) {
        const item = this.cart[index];
        const newQty = item.quantity + delta;

        if (newQty <= 0) {
            this.removeFromCart(index);
            return;
        }

        if (item.type === 'standard' && newQty > item.stock) {
            Swal.fire({
                icon: 'warning',
                title: 'Batas Stok',
                text: 'Stok tersedia hanya ' + item.stock + ' ' + item.unit,
                confirmButtonColor: '#D6A84F'
            });
            return;
        }

        item.quantity = newQty;
        this.autoFillCashIfPas();
    },

    setQtyDirect(index, value) {
        const item = this.cart[index];
        let val = parseFloat(value) || 1;
        if (val <= 0) val = 1;
        if (item.type === 'standard' && val > item.stock) {
            val = item.stock;
            Swal.fire({
                icon: 'warning',
                title: 'Batas Stok Maksimal',
                text: 'Stok dibatasi maksimum ' + item.stock + ' ' + item.unit,
                confirmButtonColor: '#D6A84F'
            });
        }
        item.quantity = val;
        this.autoFillCashIfPas();
    },

    removeFromCart(index) {
        this.cart.splice(index, 1);
        this.autoFillCashIfPas();
    },

    clearCart() {
        if (this.cart.length === 0) return;
        this.cart = [];
        this.paidAmount = 0;
        this.discountAmount = 0;
    },

    get subtotal() {
        return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    },

    get totalAmount() {
        return Math.max(0, this.subtotal - (parseFloat(this.discountAmount) || 0));
    },

    get changeAmount() {
        const paid = parseFloat(this.paidAmount) || 0;
        return Math.max(0, paid - this.totalAmount);
    },

    get remainingDebt() {
        const paid = parseFloat(this.paidAmount) || 0;
        return Math.max(0, this.totalAmount - paid);
    },

    setQuickCash(amount) {
        if (amount === 'pas') {
            this.paidAmount = this.totalAmount;
        } else {
            this.paidAmount = amount;
        }
    },

    autoFillCashIfPas() {
        if (this.paidAmount > 0 && this.paidAmount < this.totalAmount && this.orderType === 'retail') {
            this.paidAmount = this.totalAmount;
        }
    },

    formatRupiah(num) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num || 0);
    },

    submitTransaction(event) {
        if (this.cart.length === 0) {
            if (window.AzkaAlert) {
                window.AzkaAlert.warning('Keranjang Kosong', 'Pilih minimal satu produk untuk diproses.');
            } else if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'warning', title: 'Keranjang Kosong', text: 'Pilih minimal satu produk untuk diproses.', confirmButtonColor: '#D6A84F' });
            } else {
                alert('Pilih minimal 1 produk untuk diproses.');
            }
            return;
        }

        if (this.isSubmitting) {
            return;
        }

        this.isSubmitting = true;
        if (window.AzkaLoading) window.AzkaLoading.start();

        const form = document.getElementById('posCheckoutForm');
        if (form) {
            form.submit();
        }
    },

    saveQuickCustomer() {
        if (!this.newCustomer.name) {
            if (window.AzkaAlert) {
                window.AzkaAlert.error('Data Belum Lengkap', 'Nama pelanggan wajib diisi.');
            } else {
                alert('Nama pelanggan wajib diisi.');
            }
            return;
        }
        this.savingCustomer = true;
        if (window.AzkaLoading) window.AzkaLoading.start();
        fetch('{{ route('admin.customers.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(this.newCustomer)
        })
        .then(res => res.json())
        .then(data => {
            if (window.AzkaLoading) window.AzkaLoading.done();
            this.savingCustomer = false;
            window.location.reload();
        })
        .catch(err => {
            if (window.AzkaLoading) window.AzkaLoading.done();
            this.savingCustomer = false;
            if (window.AzkaAlert) {
                window.AzkaAlert.error('Gagal Menyimpan', 'Terjadi kendala saat menyimpan data pelanggan.');
            } else {
                alert('Gagal menyimpan pelanggan.');
            }
        });
    }
}" class="space-y-4">

    <!-- POS Top Header Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#172B4D] text-[#D6A84F] flex items-center justify-center font-bold">
                <i data-lucide="calculator" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="text-base font-extrabold text-[#172B4D] leading-tight">Terminal Kasir POS</h2>
                <p class="text-[11px] text-gray-500">Nomor Faktur Otomatis: <b class="text-[#D6A84F] font-mono">{{ $nextInvoiceCode }}</b></p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.pos.transactions') }}" 
               class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition flex items-center gap-1.5">
                <i data-lucide="receipt" class="w-3.5 h-3.5"></i>
                <span>Riwayat Nota</span>
            </a>
            <a href="{{ route('admin.inventory.products.index') }}" 
               class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-700 transition flex items-center gap-1.5">
                <i data-lucide="boxes" class="w-3.5 h-3.5"></i>
                <span>Data Stok</span>
            </a>
        </div>
    </div>

    @if(session('error') || $errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-center gap-3">
            <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 text-red-500"></i>
            <div>
                <p class="font-bold">{{ session('error') ?? 'Validasi Transaksi Gagal' }}</p>
                @if($errors->any())
                    <ul class="list-disc pl-4 mt-1 space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endif

    <!-- Main POS Grid Layout (Left: Catalog, Right: Cart) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        
        <!-- LEFT: Product Search & Grid Catalog (7 Cols) -->
        <div class="lg:col-span-7 space-y-4">
            <!-- Search & Filter Category -->
            <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs space-y-3">
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" x-model="search" placeholder="Ketik nama aluminium, kaca, kode SKU, atau scan barcode..." 
                           class="w-full pl-10 pr-4 py-2.5 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none bg-gray-50/50 focus:bg-white transition">
                </div>

                <!-- Category Horizontal Scroll Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-thin">
                    <button type="button" @click="selectedCategory = ''" 
                            :class="selectedCategory === '' ? 'bg-[#172B4D] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                            class="px-3 py-1.5 rounded-lg text-xs shrink-0 transition cursor-pointer">
                        Semua Kategori
                    </button>
                    <template x-for="cat in categories" :key="cat.id">
                        <button type="button" @click="selectedCategory = cat.id" 
                                :class="selectedCategory === cat.id ? 'bg-[#172B4D] text-white font-bold' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                class="px-3 py-1.5 rounded-lg text-xs shrink-0 transition cursor-pointer"
                                x-text="cat.name">
                        </button>
                    </template>
                </div>
            </div>

            <!-- Products Grid Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-[620px] overflow-y-auto pr-1">
                <template x-for="p in filteredProducts" :key="p.id">
                    <div @click="addToCart(p)" 
                         :class="p.type === 'standard' && p.stock <= 0 ? 'opacity-60 cursor-not-allowed bg-gray-50' : 'cursor-pointer hover:border-[#D6A84F] hover:shadow-md bg-white'"
                         class="p-3.5 rounded-2xl border border-gray-200/80 transition flex flex-col justify-between relative group">
                        
                        <!-- Top Badges -->
                        <div class="flex items-center justify-between gap-1 mb-2">
                            <span class="font-mono text-[10px] px-1.5 py-0.5 bg-gray-100 rounded text-gray-600 truncate max-w-[100px]" x-text="p.sku"></span>
                            
                            <!-- Stock Badge -->
                            <template x-if="p.type === 'standard'">
                                <span :class="p.stock <= 0 ? 'bg-red-100 text-red-700' : (p.stock <= p.min_stock ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800')"
                                      class="text-[10px] font-bold px-1.5 py-0.5 rounded-full shrink-0"
                                      x-text="p.stock <= 0 ? 'Habis' : (p.stock + ' ' + p.unit_name)">
                                </span>
                            </template>
                            <template x-if="p.type === 'custom_service'">
                                <span class="bg-purple-100 text-purple-700 text-[10px] font-bold px-1.5 py-0.5 rounded-full">Custom</span>
                            </template>
                        </div>

                        <!-- Product Name -->
                        <div class="mb-3">
                            <h4 class="text-xs font-bold text-[#172B4D] line-clamp-2 group-hover:text-[#D6A84F] transition" x-text="p.name"></h4>
                            <p class="text-[10px] text-gray-400 mt-0.5 truncate" x-text="p.category_name"></p>
                        </div>

                        <!-- Price & Add Action -->
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100 mt-auto">
                            <span class="font-mono font-extrabold text-xs text-[#172B4D]" x-text="formatRupiah(p.price)"></span>
                            <div class="w-6 h-6 rounded-lg bg-[#D6A84F]/10 text-[#D6A84F] group-hover:bg-[#D6A84F] group-hover:text-[#101D33] flex items-center justify-center transition">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="filteredProducts.length === 0" class="col-span-full py-16 text-center text-gray-400 bg-white rounded-2xl border border-gray-200/80">
                    <i data-lucide="package-search" class="w-10 h-10 mx-auto mb-2 opacity-50"></i>
                    <p class="text-xs">Tidak ditemukan produk sesuai kata kunci "<span x-text="search"></span>".</p>
                </div>
            </div>
        </div>

        <!-- RIGHT: Cart Drawer & Checkout Panel (5 Cols) -->
        <div class="lg:col-span-5 bg-white rounded-2xl border border-gray-200/80 shadow-xs p-5 space-y-4 sticky top-4">
            
            <form action="{{ route('admin.pos.store') }}" method="POST" id="posCheckoutForm" @submit.prevent="submitTransaction($event)">
                @csrf

                <!-- Cart Header & Customer Picker -->
                <div class="pb-3 border-b border-gray-100 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shopping-bag" class="w-4 h-4 text-[#D6A84F]"></i>
                            <h3 class="text-sm font-bold text-[#172B4D]">Keranjang Belanja</h3>
                            <span class="px-2 py-0.2 bg-[#172B4D] text-white text-[10px] font-bold rounded-full" x-text="cart.length"></span>
                        </div>
                        <button type="button" @click="clearCart()" 
                                x-show="cart.length > 0"
                                class="text-[11px] text-red-500 hover:text-red-700 font-semibold cursor-pointer">
                            Kosongkan
                        </button>
                    </div>

                    <!-- Customer & Order Type -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Pelanggan</label>
                            <div class="flex items-center gap-1.5">
                                <select name="customer_id" x-model="customerId" 
                                        class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none bg-white">
                                    <option value="">-- Tamu / Walk-in --</option>
                                    @foreach($customers as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone ?: 'No HP -' }})</option>
                                    @endforeach
                                </select>
                                <button type="button" @click="customerModal = true" 
                                        class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-[#D6A84F] hover:text-[#101D33] text-slate-700 border border-slate-200 flex items-center justify-center transition shrink-0 cursor-pointer shadow-2xs" 
                                        title="Tambah Pelanggan Baru Cepat">
                                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Transaksi</label>
                            <select name="order_type" x-model="orderType" 
                                    class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none bg-white">
                                <option value="retail">Ritel Kasir (Langsung)</option>
                                <option value="project_custom">Proyek Custom (Bisa DP)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Cart Items Scroll List -->
                <div class="max-h-[260px] overflow-y-auto divide-y divide-gray-100 my-2 pr-1">
                    <template x-for="(item, index) in cart" :key="item.product_id">
                        <div class="py-2.5 space-y-1.5">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex-1">
                                    <h5 class="text-xs font-bold text-[#172B4D] leading-tight" x-text="item.name"></h5>
                                    <span class="font-mono text-[10px] text-gray-400" x-text="item.sku"></span>
                                </div>
                                <span class="font-mono font-bold text-xs text-[#172B4D] shrink-0" x-text="formatRupiah(item.price * item.quantity)"></span>
                            </div>

                            <!-- Custom Note / Dimension Spec for Custom Cuts -->
                            <div>
                                <input type="text" :name="'items[' + index + '][specification]'" 
                                       x-model="item.specification" 
                                       placeholder="Catatan ukuran/spesifikasi (e.g. 210x90 cm)..." 
                                       class="w-full px-2 py-1 text-[11px] rounded-lg border border-gray-100 focus:border-gray-300 outline-none bg-gray-50/50">
                            </div>

                            <!-- Stepper Controls & Delete -->
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-gray-500 font-mono" x-text="'@ ' + formatRupiah(item.price) + ' / ' + item.unit"></span>
                                
                                <div class="flex items-center gap-1.5">
                                    <button type="button" @click="updateQty(index, -1)" 
                                            class="w-6 h-6 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center font-bold text-xs">
                                        -
                                    </button>
                                    <input type="number" step="any" min="0.01" 
                                           :name="'items[' + index + '][quantity]'" 
                                           :value="item.quantity"
                                           @input="setQtyDirect(index, $event.target.value)" 
                                           class="w-12 text-center text-xs font-bold font-mono py-0.5 border border-gray-200 rounded">
                                    <button type="button" @click="updateQty(index, 1)" 
                                            class="w-6 h-6 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center font-bold text-xs">
                                        +
                                    </button>
                                    <button type="button" @click="removeFromCart(index)" 
                                            class="p-1 text-gray-400 hover:text-red-600 transition ml-1">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Hidden inputs for backend form submission -->
                            <input type="hidden" :name="'items[' + index + '][product_id]'" :value="item.product_id">
                            <input type="hidden" :name="'items[' + index + '][unit_price]'" :value="item.price">
                        </div>
                    </template>

                    <div x-show="cart.length === 0" class="py-12 text-center text-gray-400">
                        <i data-lucide="shopping-cart" class="w-8 h-8 mx-auto mb-1.5 opacity-40"></i>
                        <p class="text-xs">Keranjang masih kosong.</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">Pilih produk di katalog sebelah kiri untuk mulai transaksi.</p>
                    </div>
                </div>

                <!-- Calculations & Totals -->
                <div class="border-t border-gray-100 pt-3 space-y-2 text-xs">
                    <div class="flex items-center justify-between text-gray-600">
                        <span>Subtotal Barang:</span>
                        <span class="font-mono font-bold" x-text="formatRupiah(subtotal)"></span>
                    </div>

                    <div class="flex items-center justify-between text-gray-600">
                        <span>Potongan Diskon (Rp):</span>
                        <div class="w-32">
                            <input type="number" step="any" min="0" name="discount_amount" x-model="discountAmount" 
                                   placeholder="0"
                                   class="w-full text-right px-2 py-1 text-xs border border-gray-200 rounded-lg font-mono outline-none focus:ring-1 focus:ring-[#D6A84F]">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-base font-extrabold text-[#172B4D] pt-2 border-t border-gray-200/80">
                        <span>Total Tagihan:</span>
                        <span class="font-mono text-xl text-[#172B4D]" x-text="formatRupiah(totalAmount)"></span>
                    </div>
                </div>

                <!-- Payment Method & Tender Amount -->
                <div class="border-t border-gray-100 pt-3 space-y-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label :class="paymentType === 'cash' ? 'bg-[#172B4D] text-white font-bold' : 'bg-gray-100 text-gray-700'"
                                   class="py-2 px-1 text-center text-xs rounded-xl cursor-pointer transition flex items-center justify-center gap-1.5">
                                <input type="radio" name="payment_type" value="cash" x-model="paymentType" class="hidden">
                                <i data-lucide="banknote" class="w-3.5 h-3.5"></i>
                                <span>Tunai</span>
                            </label>
                            <label :class="paymentType === 'transfer' ? 'bg-[#172B4D] text-white font-bold' : 'bg-gray-100 text-gray-700'"
                                   class="py-2 px-1 text-center text-xs rounded-xl cursor-pointer transition flex items-center justify-center gap-1.5">
                                <input type="radio" name="payment_type" value="transfer" x-model="paymentType" class="hidden">
                                <i data-lucide="arrow-right-left" class="w-3.5 h-3.5"></i>
                                <span>Transfer</span>
                            </label>
                            <label :class="paymentType === 'qris' ? 'bg-[#172B4D] text-white font-bold' : 'bg-gray-100 text-gray-700'"
                                   class="py-2 px-1 text-center text-xs rounded-xl cursor-pointer transition flex items-center justify-center gap-1.5">
                                <input type="radio" name="payment_type" value="qris" x-model="paymentType" class="hidden">
                                <i data-lucide="qr-code" class="w-3.5 h-3.5"></i>
                                <span>QRIS</span>
                            </label>
                        </div>
                    </div>

                    <!-- Quick Cash Buttons (when Cash is selected) -->
                    <div x-show="paymentType === 'cash' && totalAmount > 0" class="space-y-1.5">
                        <span class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider block">Uang Cepat:</span>
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <button type="button" @click="setQuickCash('pas')" class="px-2.5 py-1 text-[11px] rounded-lg bg-gray-100 hover:bg-gray-200 font-semibold text-gray-700">Uang Pas</button>
                            <button type="button" @click="setQuickCash(50000)" class="px-2.5 py-1 text-[11px] rounded-lg bg-gray-100 hover:bg-gray-200 font-mono text-gray-700">50k</button>
                            <button type="button" @click="setQuickCash(100000)" class="px-2.5 py-1 text-[11px] rounded-lg bg-gray-100 hover:bg-gray-200 font-mono text-gray-700">100k</button>
                            <button type="button" @click="setQuickCash(200000)" class="px-2.5 py-1 text-[11px] rounded-lg bg-gray-100 hover:bg-gray-200 font-mono text-gray-700">200k</button>
                            <button type="button" @click="setQuickCash(500000)" class="px-2.5 py-1 text-[11px] rounded-lg bg-gray-100 hover:bg-gray-200 font-mono text-gray-700">500k</button>
                            <button type="button" @click="setQuickCash(1000000)" class="px-2.5 py-1 text-[11px] rounded-lg bg-gray-100 hover:bg-gray-200 font-mono text-gray-700">1 Jt</button>
                        </div>
                    </div>

                    <!-- Nominal Bayar Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-[11px] font-semibold text-gray-700">Jumlah Uang Diterima (Rp) <span class="text-red-500">*</span></label>
                            <template x-if="orderType === 'project_custom'">
                                <span class="text-[10px] text-purple-600 font-semibold bg-purple-50 px-1.5 py-0.2 rounded">Bisa input DP</span>
                            </template>
                        </div>
                        <input type="number" step="any" min="0" name="paid_amount" x-model="paidAmount" required 
                               class="w-full px-3 py-2 text-base font-extrabold font-mono rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none text-right text-[#172B4D]">
                    </div>

                    <!-- Kembalian or Sisa Piutang Feedback -->
                    <div class="p-3 rounded-xl border" 
                         :class="remainingDebt > 0 ? 'bg-amber-50/50 border-amber-200' : 'bg-emerald-50/50 border-emerald-200'">
                        <template x-if="remainingDebt <= 0">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-emerald-800">Kembalian:</span>
                                <span class="font-mono font-extrabold text-base text-emerald-700" x-text="formatRupiah(changeAmount)"></span>
                            </div>
                        </template>
                        <template x-if="remainingDebt > 0">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-amber-800">Sisa Piutang / Pelunasan:</span>
                                    <span class="font-mono font-extrabold text-base text-amber-700" x-text="formatRupiah(remainingDebt)"></span>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-amber-800 mb-0.5">Jatuh Tempo Pelunasan Sisa:</label>
                                    <input type="date" name="due_date" x-model="dueDate" 
                                           class="w-full px-2 py-1 text-xs rounded-lg border border-amber-300 bg-white">
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Checkout CTA Button -->
                    <button type="button" 
                            :disabled="cart.length === 0 || isSubmitting"
                            @click="submitTransaction($event)"
                            class="w-full py-3.5 px-4 rounded-xl bg-[#D6A84F] hover:bg-[#c4963e] disabled:opacity-50 disabled:cursor-not-allowed text-[#101D33] font-extrabold text-sm transition shadow-sm flex items-center justify-center gap-2 cursor-pointer">
                        <template x-if="!isSubmitting">
                            <span class="flex items-center gap-2">
                                <i data-lucide="check-circle" class="w-5 h-5"></i>
                                <span>Proses Transaksi &amp; Selesai</span>
                            </span>
                        </template>
                        <template x-if="isSubmitting">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin w-5 h-5 text-[#101D33]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memproses Transaksi...</span>
                            </span>
                        </template>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL QUICK ADD CUSTOMER -->
    <div x-show="customerModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="customerModal = false" 
             class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 relative">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                <h3 class="text-sm font-bold text-[#172B4D]">Tambah Pelanggan Baru Cepat</h3>
                <button type="button" @click="customerModal = false" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Pelanggan <span class="text-red-500">*</span></label>
                    <input type="text" x-model="newCustomer.name" required placeholder="Bpk. Rian" 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" x-model="newCustomer.phone" placeholder="08123456789" 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none font-mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Info Proyek / Perusahaan</label>
                    <input type="text" x-model="newCustomer.company_name" placeholder="Ruko Gading Serpong / Rumah BSD" 
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Lokasi</label>
                    <textarea x-model="newCustomer.address" rows="2" placeholder="Alamat pengiriman / survei..." 
                              class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#D6A84F] outline-none"></textarea>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="customerModal = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="button" 
                            :disabled="savingCustomer"
                            @click="saveQuickCustomer()" 
                            class="px-5 py-2 rounded-xl text-xs font-bold bg-[#D6A84F] hover:bg-[#c4963e] text-[#101D33] transition flex items-center gap-2 cursor-pointer disabled:opacity-50">
                        <template x-if="!savingCustomer">
                            <span>Simpan</span>
                        </template>
                        <template x-if="savingCustomer">
                            <span class="flex items-center gap-1.5">
                                <svg class="animate-spin w-3.5 h-3.5 text-[#101D33]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Menyimpan...</span>
                            </span>
                        </template>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

