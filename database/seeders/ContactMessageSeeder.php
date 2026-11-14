<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Bpk. Ridwan',
                'phone_number' => '081299887766',
                'email' => 'ridwan.sample@example.com',
                'subject' => 'Tanya Biaya Kusen Aluminium Rumah 2 Lantai',
                'message' => 'Halo AzkaMandiri, saya berencana merenovasi jendela rumah di daerah Bintaro. Ada sekitar 12 titik jendela casement dan 2 pintu sliding. Apakah bisa dijadwalkan survei ke lokasi akhir pekan ini?',
                'status' => 'unread',
                'ip_address' => '127.0.0.1',
            ],
            [
                'name' => 'Ibu Cynthia',
                'phone_number' => '081311223344',
                'email' => 'cynthia.sample@example.com',
                'subject' => 'Pemasangan Kanopi Kaca Carport',
                'message' => 'Selamat siang, mohon info estimasi harga per meter untuk kanopi kaca tempered laminated ukuran 4x5 meter. Rangka hollow galvanis. Terima kasih.',
                'status' => 'read',
                'ip_address' => '127.0.0.1',
            ],
        ];

        foreach ($messages as $msg) {
            ContactMessage::firstOrCreate(
                ['phone_number' => $msg['phone_number'], 'subject' => $msg['subject']],
                $msg
            );
        }
    }
}

