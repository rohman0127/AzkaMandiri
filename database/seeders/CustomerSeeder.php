<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Bpk. Hendra Gunawan',
                'company_name' => 'Owner Rumah Tinggal - De Park BSD',
                'phone' => '081288991122',
                'email' => 'hendra.gunawan@gmail.com',
                'address' => 'Cluster Heliconia Blok B3 No. 7, BSD City, Tangerang Selatan',
            ],
            [
                'name' => 'Ibu Siti Nurhaliza',
                'company_name' => 'Klinik Estetika Bintaro',
                'phone' => '081377889900',
                'email' => 'siti.nurhaliza@klinikbintaro.com',
                'address' => 'Ruko Emerald Avenue Sektor 9, Bintaro Jaya, Tangerang Selatan',
            ],
            [
                'name' => 'Bpk. Aris Munandar',
                'company_name' => 'PT Cipta Bangun Graha',
                'phone' => '085611224466',
                'email' => 'proyek@ciptabangungraha.co.id',
                'address' => 'Gading Serpong Boulevard Kav. 18, Tangerang',
            ],
            [
                'name' => 'Bpk. Kevin Adiputra',
                'company_name' => 'Rumah Cluster Sutera Narada',
                'phone' => '087788112233',
                'email' => 'kevin.adiputra@gmail.com',
                'address' => 'Alam Sutera, Serpong Utara, Tangerang Selatan',
            ],
        ];

        foreach ($customers as $c) {
            Customer::firstOrCreate(['phone' => $c['phone']], $c);
        }
    }
}

