<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['name' => 'Batang', 'symbol' => 'btg', 'description' => 'Satuan panjang standar profil aluminium (6 meter)'],
            ['name' => 'Lembar', 'symbol' => 'lbr', 'description' => 'Satuan bidang lembaran kaca atau panel aluminium'],
            ['name' => 'Meter', 'symbol' => 'm', 'description' => 'Satuan panjang linier pemotongan bahan'],
            ['name' => 'Pcs', 'symbol' => 'pcs', 'description' => 'Satuan per biji/buah komponen'],
            ['name' => 'Set', 'symbol' => 'set', 'description' => 'Satuan kelengkapan sepasang (handle, kunci, engsel)'],
            ['name' => 'Unit', 'symbol' => 'unit', 'description' => 'Satuan barang jadi atau rakitan siap pasang'],
            ['name' => 'Roll', 'symbol' => 'roll', 'description' => 'Satuan gulungan karet atau pelindung profil'],
            ['name' => 'Dus', 'symbol' => 'dus', 'description' => 'Satuan kemasan kotak sekrup atau aksesoris massal'],
        ];

        foreach ($units as $u) {
            Unit::firstOrCreate(['symbol' => $u['symbol']], $u);
        }
    }
}

