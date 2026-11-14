<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Bpk. Surya Wijaya',
                'company_name' => 'PT Duta Aluminium Nusantara',
                'phone' => '081299887766',
                'email' => 'sales@dutaaluminium.co.id',
                'address' => 'Kawasan Industri Jatake, Blok C No. 12, Tangerang',
                'notes' => 'Distributor utama profil aluminium Alexindo, Dacon, dan Inkalum. Tempo 30 hari.',
            ],
            [
                'name' => 'Ibu Liana Tan',
                'company_name' => 'Toko Kaca Asahi Prima Mandiri',
                'phone' => '081388776655',
                'email' => 'order@asahiprima.com',
                'address' => 'Jl. Daan Mogot Km. 14, Jakarta Barat',
                'notes' => 'Supplier kaca lembaran polos, tempered, dan laminated standar Asahi Mas.',
            ],
            [
                'name' => 'Bpk. Hendry Salim',
                'company_name' => 'CV Mitra Hardware Aluminium',
                'phone' => '085711223344',
                'email' => 'mitra.hardware@gmail.com',
                'address' => 'Pusat Niaga Roxy Mas Lt. 2 No. 45, Jakarta Pusat',
                'notes' => 'Aksesoris merek Dekkson, Hampton, Kinlong, dan Belleza.',
            ],
            [
                'name' => 'Bpk. Budi Santoso',
                'company_name' => 'UD Sinar Makmur Sealant & Bahan',
                'phone' => '087822334455',
                'email' => 'sinarmakmur.sealant@gmail.com',
                'address' => 'Jl. Raya Serpong No. 88, Tangerang Selatan',
                'notes' => 'Sealant Dowsil 791/795, karet hitam EPDM, dan sekrup stainless.',
            ],
        ];

        foreach ($suppliers as $s) {
            Supplier::firstOrCreate(['company_name' => $s['company_name']], $s);
        }
    }
}

