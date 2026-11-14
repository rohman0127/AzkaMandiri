<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Bpk. Bambang S.',
                'client_role' => 'Pemilik Rumah – BSD City (Sample Demo)',
                'photo' => null,
                'content' => 'Pemasangan kusen dan jendela aluminium untuk renovasi rumah sangat rapi, siku-sikunya presisi dan tidak ada goresan. Komunikasi lewat WhatsApp sangat cepat dan jelas.',
                'rating' => 5,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'client_name' => 'Ibu Maya Larasati',
                'client_role' => 'Desainer Interior – Jakarta (Sample Demo)',
                'photo' => null,
                'content' => 'Sering bekerja sama dengan AzkaMandiri untuk partisi kaca kantor dan shower box apartemen. Kualitas material sesuai pesanan dan waktu pengerjaan on time.',
                'rating' => 5,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'client_name' => 'Bpk. Ferry Kurniawan',
                'client_role' => 'Pemilik Ruko – Tangerang (Sample Demo)',
                'photo' => null,
                'content' => 'Pintu sliding kaca ruko saya terpasang dengan baik. Relnya halus, aksesoris kunci juga kokoh. Harga sangat wajar dibandingkan kompetitor.',
                'rating' => 5,
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(
                ['client_name' => $t['client_name']],
                $t
            );
        }
    }
}

