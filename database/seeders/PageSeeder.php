<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => 'AzkaMandiri adalah penyedia jasa terpercaya di bidang fabrikasi dan pemasangan aluminium serta kaca untuk kebutuhan residensial dan komersial di kawasan Jabodetabek dan sekitarnya. Kami berkomitmen memberikan solusi arsitektural yang fungsional, modern, dan tahan lama.',
                'meta_title' => 'Tentang AzkaMandiri – Jasa Aluminium & Kaca Terpercaya',
                'meta_description' => 'Mengenal AzkaMandiri lebih dekat, sejarah, visi misi dan keunggulan kami dalam jasa pemasangan kusen aluminium dan kaca.',
                'is_active' => true,
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'content' => 'Kebijakan Privasi ini menjelaskan bagaimana AzkaMandiri mengumpulkan, menggunakan, dan melindungi informasi pribadi yang Anda berikan saat menggunakan layanan atau website kami. Kami menghargai kerahasiaan data Anda dan berkomitmen menjaganya dengan standar keamanan yang baik.',
                'meta_title' => 'Kebijakan Privasi – AzkaMandiri',
                'meta_description' => 'Kebijakan privasi pengunjung website dan pelanggan jasa aluminium AzkaMandiri.',
                'is_active' => true,
            ],
            [
                'title' => 'Syarat dan Ketentuan',
                'slug' => 'syarat-ketentuan',
                'content' => 'Syarat dan Ketentuan ini mengatur pemesanan layanan, survei lokasi, pembayaran bertahap, dan garansi pengerjaan yang disepakati antara pelanggan dan AzkaMandiri.',
                'meta_title' => 'Syarat dan Ketentuan Layanan – AzkaMandiri',
                'meta_description' => 'Syarat dan ketentuan pemesanan jasa aluminium dan kaca di AzkaMandiri.',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}

