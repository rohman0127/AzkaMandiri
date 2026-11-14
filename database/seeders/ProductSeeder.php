<?php

namespace Database\Seeders;

use App\Models\InventoryCategory;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catAlu = InventoryCategory::where('slug', 'profil-kusen-aluminium')->first();
        $catKaca = InventoryCategory::where('slug', 'kaca-panel-arsitektur')->first();
        $catAks = InventoryCategory::where('slug', 'aksesoris-hardware-pintujendela')->first();
        $catSea = InventoryCategory::where('slug', 'sealant-karet-perekat')->first();
        $catCustom = InventoryCategory::where('slug', 'jasa-custom-rakitan')->first();

        $uBtg = Unit::where('symbol', 'btg')->first();
        $uLbr = Unit::where('symbol', 'lbr')->first();
        $uPcs = Unit::where('symbol', 'pcs')->first();
        $uSet = Unit::where('symbol', 'set')->first();
        $uRoll = Unit::where('symbol', 'roll')->first();
        $uUnit = Unit::where('symbol', 'unit')->first();

        $products = [
            // Aluminium Profiles
            [
                'sku' => 'ALU-KS3-BLK',
                'name' => 'Kusen Aluminium 3" Alexindo Hitam Anodize (6 Meter)',
                'category_id' => $catAlu->id,
                'unit_id' => $uBtg->id,
                'cost_price' => 125000,
                'price' => 175000,
                'stock' => 45,
                'min_stock' => 10,
                'rack_location' => 'Rak A-01',
                'type' => 'standard',
                'description' => 'Profil kusen 3 inch panjang 6 meter finishing hitam anodize standar perumahan modern.',
            ],
            [
                'sku' => 'ALU-KS3-WHT',
                'name' => 'Kusen Aluminium 3" Alexindo Putih Powder Coating (6 Meter)',
                'category_id' => $catAlu->id,
                'unit_id' => $uBtg->id,
                'cost_price' => 135000,
                'price' => 185000,
                'stock' => 38,
                'min_stock' => 10,
                'rack_location' => 'Rak A-02',
                'type' => 'standard',
                'description' => 'Profil kusen 3 inch putih glossy tahan cuaca dan anti luntur.',
            ],
            [
                'sku' => 'ALU-KS4-BRN',
                'name' => 'Kusen Aluminium 4" Alexindo Cokelat Anodize (6 Meter)',
                'category_id' => $catAlu->id,
                'unit_id' => $uBtg->id,
                'cost_price' => 170000,
                'price' => 235000,
                'stock' => 26,
                'min_stock' => 8,
                'rack_location' => 'Rak A-03',
                'type' => 'standard',
                'description' => 'Profil kusen tebal 4 inch cocok untuk ruko, partisi kantor, dan fasad utama.',
            ],
            [
                'sku' => 'ALU-DP-SLD',
                'name' => 'Tiang Daun Pintu Sliding Aluminium Alexindo Hitam',
                'category_id' => $catAlu->id,
                'unit_id' => $uBtg->id,
                'cost_price' => 155000,
                'price' => 210000,
                'stock' => 20,
                'min_stock' => 6,
                'rack_location' => 'Rak B-01',
                'type' => 'standard',
                'description' => 'Profil profil tiang pintu geser aluminium.',
            ],

            // Kaca & Panel
            [
                'sku' => 'KAC-CLR-5MM',
                'name' => 'Kaca Polos Clear 5mm Asahi (Ukuran Standar 152 x 213 cm)',
                'category_id' => $catKaca->id,
                'unit_id' => $uLbr->id,
                'cost_price' => 195000,
                'price' => 285000,
                'stock' => 18,
                'min_stock' => 5,
                'rack_location' => 'Gudang Kaca Rak 1',
                'type' => 'standard',
                'description' => 'Lembaran kaca bening kejernihan tinggi untuk jendela dan ventilasi.',
            ],
            [
                'sku' => 'KAC-RYB-5MM',
                'name' => 'Kaca Rayban Gelap 5mm Asahi (Ukuran Standar 152 x 213 cm)',
                'category_id' => $catKaca->id,
                'unit_id' => $uLbr->id,
                'cost_price' => 220000,
                'price' => 315000,
                'stock' => 14,
                'min_stock' => 5,
                'rack_location' => 'Gudang Kaca Rak 2',
                'type' => 'standard',
                'description' => 'Kaca pelindung sinar UV redup panas untuk jendela samping.',
            ],
            [
                'sku' => 'KAC-TMP-8MM',
                'name' => 'Kaca Tempered 8mm Custom Partisi & Shower Screen',
                'category_id' => $catKaca->id,
                'unit_id' => $uLbr->id,
                'cost_price' => 450000,
                'price' => 650000,
                'stock' => 4,
                'min_stock' => 5, // sengaja low stock untuk trigger alert
                'rack_location' => 'Gudang Kaca Khusus',
                'type' => 'standard',
                'description' => 'Kaca tempered safety kekuatan 5x lipat kaca biasa, tepi gosok halus mesin.',
            ],

            // Aksesoris & Hardware
            [
                'sku' => 'AKS-HDL-DKK',
                'name' => 'Handle Pintu Lever Dekkson Stainless Steel LHTR 0016',
                'category_id' => $catAks->id,
                'unit_id' => $uSet->id,
                'cost_price' => 180000,
                'price' => 260000,
                'stock' => 25,
                'min_stock' => 5,
                'rack_location' => 'Lemari Aksesoris L-1',
                'type' => 'standard',
                'description' => 'Handle pintu minimalis modern bahan SUS 304 anti karat.',
            ],
            [
                'sku' => 'AKS-EGS-CS12',
                'name' => 'Friction Stay / Engsel Casement Jendela 12" Stainless',
                'category_id' => $catAks->id,
                'unit_id' => $uSet->id,
                'cost_price' => 45000,
                'price' => 75000,
                'stock' => 40,
                'min_stock' => 10,
                'rack_location' => 'Lemari Aksesoris L-2',
                'type' => 'standard',
                'description' => 'Engsel jungkit jendela aluminium penahan angin kuat.',
            ],
            [
                'sku' => 'AKS-KNC-SLD',
                'name' => 'Kunci Tanam Pintu Sliding Aluminium Hampton',
                'category_id' => $catAks->id,
                'unit_id' => $uSet->id,
                'cost_price' => 95000,
                'price' => 145000,
                'stock' => 15,
                'min_stock' => 5,
                'rack_location' => 'Lemari Aksesoris L-3',
                'type' => 'standard',
                'description' => 'Kunci kait pintu geser lengkap silinder dan anak kunci.',
            ],
            [
                'sku' => 'AKS-RDA-HVY',
                'name' => 'Roda Pintu Geser Aluminium Heavy Duty Bearing Nilon',
                'category_id' => $catAks->id,
                'unit_id' => $uPcs->id,
                'cost_price' => 28000,
                'price' => 45000,
                'stock' => 50,
                'min_stock' => 15,
                'rack_location' => 'Kotak Part B-4',
                'type' => 'standard',
                'description' => 'Roda bawah sliding dorong halus tanpa suara berdecit.',
            ],

            // Sealant & Pembantu
            [
                'sku' => 'SLN-DOW-BLK',
                'name' => 'Silikon Sealant Dowsil 791 Weatherproofing Hitam 300ml',
                'category_id' => $catSea->id,
                'unit_id' => $uPcs->id,
                'cost_price' => 42000,
                'price' => 60000,
                'stock' => 3, // LOW STOCK!
                'min_stock' => 12,
                'rack_location' => 'Rak Sealant C-1',
                'type' => 'standard',
                'description' => 'Sealant netral elastisitas tinggi tahan panas terik matahari dan hujan lebat.',
            ],
            [
                'sku' => 'KRT-KUS-BLK',
                'name' => 'Karet Kancing Profil Kusen Aluminium EPDM Hitam (50m/roll)',
                'category_id' => $catSea->id,
                'unit_id' => $uRoll->id,
                'cost_price' => 85000,
                'price' => 130000,
                'stock' => 12,
                'min_stock' => 4,
                'rack_location' => 'Rak Sealant C-2',
                'type' => 'standard',
                'description' => 'Karet peredam getaran dan kedap suara untuk penjepit kaca ke kusen.',
            ],

            // Jasa Custom
            [
                'sku' => 'CST-PNT-SPK',
                'name' => 'Pesanan Custom Daun Pintu Aluminium Spandrel / Kaca',
                'category_id' => $catCustom->id,
                'unit_id' => $uUnit->id,
                'cost_price' => 950000,
                'price' => 1650000,
                'stock' => 999,
                'min_stock' => 0,
                'rack_location' => 'Area Fabrikasi Workshop',
                'type' => 'custom_service',
                'description' => 'Paket pintu aluminium custom rakitan lengkap aksesoris sesuai ukuran konsumen.',
            ],
        ];

        foreach ($products as $p) {
            Product::firstOrCreate(['sku' => $p['sku']], $p);
        }
    }
}

