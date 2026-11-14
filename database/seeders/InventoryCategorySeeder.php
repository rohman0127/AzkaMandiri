<?php

namespace Database\Seeders;

use App\Models\InventoryCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InventoryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Profil Kusen Aluminium',
                'description' => 'Profil kusen aluminium 3 inch, 4 inch, daun pintu, dan daun jendela berbagai merek ternama.',
            ],
            [
                'name' => 'Kaca & Panel Arsitektur',
                'description' => 'Lembaran kaca polos, tempered, laminated, riben, dan cermin berbagai ketebalan.',
            ],
            [
                'name' => 'Aksesoris & Hardware Pintu/Jendela',
                'description' => 'Handle, engsel casement, kunci tanam, roda sliding, dan perlengkapan pintu geser/lipat.',
            ],
            [
                'name' => 'Sealant, Karet & Perekat',
                'description' => 'Silikon sealant netral/asam, karet profil, sekrup roofing, dan baut pengunci.',
            ],
            [
                'name' => 'Jasa Custom & Rakitan',
                'description' => 'Item pengerjaan khusus fabrikasi, bending profil, dan perakitan pesanan custom.',
            ],
        ];

        foreach ($categories as $cat) {
            $cat['slug'] = Str::slug($cat['name']);
            InventoryCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}

