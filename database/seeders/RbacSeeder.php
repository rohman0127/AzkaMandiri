<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // 1. Kasir & POS
            [
                'name' => 'pos.access',
                'display_name' => 'Akses Mesin Kasir POS',
                'group' => 'pos',
                'group_label' => 'Kasir & POS',
                'description' => 'Membuka antarmuka kasir dan keranjang transaksi.',
            ],
            [
                'name' => 'pos.create_transaction',
                'display_name' => 'Proses Transaksi & Checkout',
                'group' => 'pos',
                'group_label' => 'Kasir & POS',
                'description' => 'Melakukan checkout penjualan ritel maupun custom.',
            ],
            [
                'name' => 'pos.view_transactions',
                'display_name' => 'Lihat Riwayat Transaksi',
                'group' => 'pos',
                'group_label' => 'Kasir & POS',
                'description' => 'Membuka daftar riwayat penjualan kasir.',
            ],
            [
                'name' => 'pos.add_payment',
                'display_name' => 'Catat Pelunasan & DP',
                'group' => 'pos',
                'group_label' => 'Kasir & POS',
                'description' => 'Mencatat pembayaran cicilan bertahap atau sisa piutang.',
            ],
            [
                'name' => 'pos.print_receipt',
                'display_name' => 'Cetak Struk & Invoice',
                'group' => 'pos',
                'group_label' => 'Kasir & POS',
                'description' => 'Mencetak struk thermal 58/80mm dan mengunduh Invoice PDF.',
            ],
            [
                'name' => 'customers.view',
                'display_name' => 'Lihat Data Pelanggan',
                'group' => 'pos',
                'group_label' => 'Kasir & POS',
                'description' => 'Melihat direktori dan kontak WhatsApp pelanggan.',
            ],
            [
                'name' => 'customers.manage',
                'display_name' => 'Kelola Pelanggan (CRUD)',
                'group' => 'pos',
                'group_label' => 'Kasir & POS',
                'description' => 'Menambah, mengubah, dan menghapus profil pelanggan.',
            ],

            // 2. Inventaris & Stok
            [
                'name' => 'products.view',
                'display_name' => 'Lihat Produk & Material',
                'group' => 'inventory',
                'group_label' => 'Inventaris & Stok',
                'description' => 'Melihat daftar master material dan sisa stok fisik.',
            ],
            [
                'name' => 'products.create',
                'display_name' => 'Tambah Produk Baru',
                'group' => 'inventory',
                'group_label' => 'Inventaris & Stok',
                'description' => 'Mendaftarkan SKU atau material baru ke gudang.',
            ],
            [
                'name' => 'products.edit',
                'display_name' => 'Ubah Produk & Harga',
                'group' => 'inventory',
                'group_label' => 'Inventaris & Stok',
                'description' => 'Mengubah nama, harga modal, harga jual, dan batas stok.',
            ],
            [
                'name' => 'products.delete',
                'display_name' => 'Hapus Produk',
                'group' => 'inventory',
                'group_label' => 'Inventaris & Stok',
                'description' => 'Menghapus data produk dari database.',
            ],
            [
                'name' => 'inventory.categories',
                'display_name' => 'Kelola Kategori Produk',
                'group' => 'inventory',
                'group_label' => 'Inventaris & Stok',
                'description' => 'CRUD kategori inventaris (profil aluminium, kaca, aksesoris).',
            ],
            [
                'name' => 'inventory.units',
                'display_name' => 'Kelola Satuan Barang',
                'group' => 'inventory',
                'group_label' => 'Inventaris & Stok',
                'description' => 'CRUD satuan ukuran (batang, lembar, meter, pcs, dll.).',
            ],
            [
                'name' => 'inventory.adjust_stock',
                'display_name' => 'Stok Opname & Koreksi',
                'group' => 'inventory',
                'group_label' => 'Inventaris & Stok',
                'description' => 'Mencatat opname berkala, barang rusak, dan penyesuaian.',
            ],

            // 3. Supplier & Belanja Restock
            [
                'name' => 'suppliers.view',
                'display_name' => 'Lihat Data Supplier',
                'group' => 'suppliers',
                'group_label' => 'Supplier & Belanja',
                'description' => 'Melihat daftar toko dan vendor penyuplai bahan baku.',
            ],
            [
                'name' => 'suppliers.manage',
                'display_name' => 'Kelola Data Supplier',
                'group' => 'suppliers',
                'group_label' => 'Supplier & Belanja',
                'description' => 'Menambah, mengubah, dan menghapus profil toko supplier.',
            ],
            [
                'name' => 'purchases.view',
                'display_name' => 'Lihat Riwayat Belanja',
                'group' => 'suppliers',
                'group_label' => 'Supplier & Belanja',
                'description' => 'Melihat daftar nota belanja barang masuk dari supplier.',
            ],
            [
                'name' => 'purchases.create',
                'display_name' => 'Input Belanja Masuk (Restock)',
                'group' => 'suppliers',
                'group_label' => 'Supplier & Belanja',
                'description' => 'Menginput barang restock yang otomatis menambah stok gudang.',
            ],

            // 4. Laporan & Keuangan
            [
                'name' => 'reports.sales',
                'display_name' => 'Laporan Penjualan',
                'group' => 'reports',
                'group_label' => 'Laporan & Keuangan',
                'description' => 'Melihat analisis omzet kasir dan distribusi metode bayar.',
            ],
            [
                'name' => 'reports.purchases',
                'display_name' => 'Laporan Pembelian & Restock',
                'group' => 'reports',
                'group_label' => 'Laporan & Keuangan',
                'description' => 'Melihat analisis pengeluaran belanja bahan baku dan faktur supplier.',
            ],
            [
                'name' => 'reports.profit_loss',
                'display_name' => 'Laporan Laba Rugi',
                'group' => 'reports',
                'group_label' => 'Laporan & Keuangan',
                'description' => 'Melihat margin keuntungan kotor per produk dan total laba.',
            ],
            [
                'name' => 'reports.stock',
                'display_name' => 'Laporan Valuasi & Stok',
                'group' => 'reports',
                'group_label' => 'Laporan & Keuangan',
                'description' => 'Melihat nilai aset gudang dan peringatan stok kritis.',
            ],

            // 5. Konten Web & Portofolio
            [
                'name' => 'services.manage',
                'display_name' => 'Kelola Layanan Jasa',
                'group' => 'content',
                'group_label' => 'Konten Web & CMS',
                'description' => 'CRUD layanan aluminium/kaca dan kategori layanan.',
            ],
            [
                'name' => 'portfolios.manage',
                'display_name' => 'Kelola Portofolio Proyek',
                'group' => 'content',
                'group_label' => 'Konten Web & CMS',
                'description' => 'CRUD galeri proyek hasil pengerjaan tim.',
            ],
            [
                'name' => 'articles.manage',
                'display_name' => 'Kelola Artikel Blog',
                'group' => 'content',
                'group_label' => 'Konten Web & CMS',
                'description' => 'CRUD artikel edukasi dan tips aluminium/interior.',
            ],
            [
                'name' => 'testimonials.manage',
                'display_name' => 'Kelola Testimoni Klien',
                'group' => 'content',
                'group_label' => 'Konten Web & CMS',
                'description' => 'CRUD ulasan dan kepuasan pelanggan.',
            ],
            [
                'name' => 'pages.manage',
                'display_name' => 'Kelola Halaman Statis',
                'group' => 'content',
                'group_label' => 'Konten Web & CMS',
                'description' => 'Mengatur halaman tentang kami dan kebijakan.',
            ],

            // 6. Pesan Kontak
            [
                'name' => 'messages.view',
                'display_name' => 'Lihat Pesan Masuk',
                'group' => 'messages',
                'group_label' => 'Pesan Masuk',
                'description' => 'Membaca formulir kontak dari pengunjung website.',
            ],
            [
                'name' => 'messages.manage',
                'display_name' => 'Tindak Lanjut & Hapus Pesan',
                'group' => 'messages',
                'group_label' => 'Pesan Masuk',
                'description' => 'Mengubah status pesan atau menghapus pesan masuk.',
            ],

            // 7. Pengaturan Sistem & Pengguna
            [
                'name' => 'settings.profile',
                'display_name' => 'Kelola Profil & Kontak Perusahaan',
                'group' => 'settings',
                'group_label' => 'Sistem & Pengaturan',
                'description' => 'Mengubah nomor WhatsApp, alamat workshop, dan jam kerja.',
            ],
            [
                'name' => 'settings.seo',
                'display_name' => 'Kelola Pengaturan SEO',
                'group' => 'settings',
                'group_label' => 'Sistem & Pengaturan',
                'description' => 'Mengubah meta title, description, dan kata kunci.',
            ],
            [
                'name' => 'users.view',
                'display_name' => 'Lihat Daftar Pengguna',
                'group' => 'settings',
                'group_label' => 'Sistem & Pengaturan',
                'description' => 'Melihat daftar akun administrator dan staf.',
            ],
            [
                'name' => 'users.manage',
                'display_name' => 'Kelola Akun Pengguna',
                'group' => 'settings',
                'group_label' => 'Sistem & Pengaturan',
                'description' => 'Menambah akun, mengganti role, blokir, dan reset password.',
            ],
            [
                'name' => 'roles.manage',
                'display_name' => 'Kelola Peran & Hak Akses (RBAC)',
                'group' => 'settings',
                'group_label' => 'Sistem & Pengaturan',
                'description' => 'Membuat role baru dan mencentang matriks permissions.',
            ],
        ];

        // 1. Seed or update permissions
        $permissionModels = [];
        foreach ($permissions as $p) {
            $permissionModels[$p['name']] = Permission::updateOrCreate(
                ['name' => $p['name']],
                $p
            );
        }

        // 2. Seed Default Roles
        // Role: Super Admin
        $superAdmin = Role::updateOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'Super Admin',
                'description' => 'Memiliki hak akses penuh ke seluruh modul, pengaturan, dan database sistem.',
                'is_system' => true,
            ]
        );
        $superAdmin->permissions()->sync(array_values(array_map(fn($pm) => $pm->id, $permissionModels)));

        // Role: Kasir
        $kasir = Role::updateOrCreate(
            ['slug' => 'kasir'],
            [
                'name' => 'Kasir',
                'description' => 'Petugas kasir toko untuk transaksi POS, cetak struk, direktori pelanggan, dan monitoring stok.',
                'is_system' => false,
            ]
        );
        $kasirPerms = [
            'pos.access', 'pos.create_transaction', 'pos.view_transactions', 'pos.add_payment',
            'pos.print_receipt', 'customers.view', 'customers.manage', 'products.view', 'reports.sales'
        ];
        $kasirIds = [];
        foreach ($kasirPerms as $kp) {
            if (isset($permissionModels[$kp])) {
                $kasirIds[] = $permissionModels[$kp]->id;
            }
        }
        $kasir->permissions()->sync($kasirIds);

        // Role: Staff Gudang & Logistik
        $gudang = Role::updateOrCreate(
            ['slug' => 'staff-gudang'],
            [
                'name' => 'Staff Gudang',
                'description' => 'Pengelola persediaan material aluminium/kaca, restock belanja supplier, dan stok opname.',
                'is_system' => false,
            ]
        );
        $gudangPerms = [
            'products.view', 'products.create', 'products.edit', 'inventory.categories',
            'inventory.units', 'inventory.adjust_stock', 'suppliers.view', 'suppliers.manage',
            'purchases.view', 'purchases.create', 'reports.stock', 'reports.purchases'
        ];
        $gudangIds = [];
        foreach ($gudangPerms as $gp) {
            if (isset($permissionModels[$gp])) {
                $gudangIds[] = $permissionModels[$gp]->id;
            }
        }
        $gudang->permissions()->sync($gudangIds);

        // 3. Attach Super Admin to primary admin user
        $primaryAdmin = User::where('email', 'admin@azkamandiri.com')->first();
        if (!$primaryAdmin) {
            $primaryAdmin = User::create([
                'name' => 'Administrator Utama',
                'email' => 'admin@azkamandiri.com',
                'phone' => '081932735383',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]);
        } else {
            $primaryAdmin->update([
                'is_active' => true,
                'phone' => $primaryAdmin->phone ?? '081932735383',
            ]);
        }
        $primaryAdmin->roles()->syncWithoutDetaching([$superAdmin->id]);

        // 4. Create sample staff users for testing
        $cashierUser = User::updateOrCreate(
            ['email' => 'kasir@azkamandiri.com'],
            [
                'name' => 'Siti Kasir',
                'phone' => '081298765432',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $cashierUser->roles()->sync([$kasir->id]);

        $gudangUser = User::updateOrCreate(
            ['email' => 'gudang@azkamandiri.com'],
            [
                'name' => 'Budi Gudang',
                'phone' => '081345678901',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $gudangUser->roles()->sync([$gudang->id]);
    }
}

