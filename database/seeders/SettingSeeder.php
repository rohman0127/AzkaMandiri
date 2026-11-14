<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Profile
            ['key' => 'site_name', 'value' => 'AzkaMandiri', 'group' => 'general'],
            ['key' => 'brand_title', 'value' => 'AzkaMandiri – Jasa Aluminium & Kaca', 'group' => 'general'],
            ['key' => 'tagline', 'value' => 'Solusi Aluminium & Kaca untuk Hunian dan Bangunan Anda', 'group' => 'general'],
            ['key' => 'business_type', 'value' => 'Jasa Pemasangan & Pembuatan Aluminium, Kaca & Custom Bangunan', 'group' => 'general'],
            ['key' => 'about_short', 'value' => 'AzkaMandiri hadir memberikan layanan pemasangan, pembuatan, dan pengerjaan aluminium serta kaca berkualitas dengan hasil rapi dan profesional untuk rumah, ruko, kantor, hingga gedung komersial.', 'group' => 'general'],
            ['key' => 'business_history', 'value' => 'Berawal dari dedikasi dan pengalaman bertahun-tahun para teknisi aluminium dan kaca, AzkaMandiri tumbuh sebagai mitra terpercaya bagi ratusan pemilik rumah, kontraktor, dan arsitek di area Jabodetabek. Kami mengutamakan ketepatan dimensi, kerapian sambungan, dan ketahanan material.', 'group' => 'general'],
            ['key' => 'vision', 'value' => 'Menjadi penyedia jasa aluminium dan kaca terdepan yang dipercaya atas kualitas pengerjaan presisi, integritas tinggi, dan kepuasan pelanggan menyeluruh.', 'group' => 'general'],
            ['key' => 'mission', 'value' => "1. Memberikan hasil instalasi aluminium dan kaca yang rapi, kokoh, dan presisi.\n2. Menggunakan material berkualitas dari merek terpercaya (Alexindo, YKK, Dacon, dll).\n3. Menawarkan harga yang transparan, kompetitif, dan sebanding dengan mutu layanan.\n4. Memberikan konsultasi teknis yang solutif serta pelayanan ramah dan responsif.", 'group' => 'general'],
            
            // Contact & Location
            ['key' => 'whatsapp_number', 'value' => '6281234567890', 'group' => 'contact'],
            ['key' => 'phone_number', 'value' => '+62 812-3456-7890', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'kontak@azkamandiri.com', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Jl. Aria Putra No. 45, Sarua Indah, Ciputat, Tangerang Selatan, Banten 15414', 'group' => 'contact'],
            ['key' => 'service_areas', 'value' => 'Jakarta Selatan, Jakarta Barat, Tangerang Selatan, Tangerang Kota, BSD City, Bintaro, Depok, Bekasi, dan sekitarnya', 'group' => 'contact'],
            ['key' => 'business_hours', 'value' => 'Senin – Sabtu: 08.00 – 17.00 WIB (Konsultasi WhatsApp 24 Jam)', 'group' => 'contact'],
            ['key' => 'google_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63456.63583272671!2d106.68060868846395!3d-6.308351543884898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fa0679883581%3A0x6758622f309a4d80!2sTangerang%20Selatan!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid', 'group' => 'contact'],

            // Social Media
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/azkamandiri.aluminium', 'group' => 'social'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/azkamandiri.aluminium', 'group' => 'social'],
            ['key' => 'tiktok_url', 'value' => 'https://tiktok.com/@azkamandiri', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@azkamandiri', 'group' => 'social'],

            // SEO & Meta
            ['key' => 'meta_title', 'value' => 'AzkaMandiri – Jasa Aluminium & Kaca Berkualitas Profesional', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Jasa pembuatan dan pemasangan kusen aluminium, jendela aluminium, pintu kaca tempered, partisi ruko, kanopi kaca, dan shower box terpercaya di Jabodetabek.', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'kusen aluminium, jendela aluminium, pintu aluminium, partisi kaca, kaca tempered jabodetabek, kanopi kaca, shower box bintaro, azkamandiri', 'group' => 'seo'],

            // Assets
            ['key' => 'logo_path', 'value' => '/assets/brand/logo-horizontal.svg', 'group' => 'assets'],
            ['key' => 'logo_dark_path', 'value' => '/assets/brand/logo-horizontal-dark.svg', 'group' => 'assets'],
            ['key' => 'favicon_path', 'value' => '/assets/brand/favicon.svg', 'group' => 'assets'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}

