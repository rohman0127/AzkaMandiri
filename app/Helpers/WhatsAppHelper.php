<?php

namespace App\Helpers;

use App\Models\Setting;

class WhatsAppHelper
{
    /**
     * Generate a WhatsApp direct link with formatted phone number and pre-filled message.
     */
    public static function makeLink(?string $message = null, ?string $customNumber = null): string
    {
        $rawNumber = $customNumber ?: Setting::get('whatsapp_number', '6281234567890');

        // Sanitize phone number: strip +, -, spaces, parentheses
        $phone = preg_replace('/[^0-9]/', '', (string)$rawNumber);

        // If starts with 0, replace with 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $defaultMessage = "Halo AzkaMandiri, saya ingin berkonsultasi mengenai jasa pemasangan aluminium dan kaca. Mohon info lebih lanjut.";
        $text = $message ?: $defaultMessage;

        return 'https://wa.me/' . $phone . '?text=' . rawurlencode($text);
    }

    public static function forService(string $serviceName): string
    {
        $text = "Halo AzkaMandiri, saya tertarik untuk konsultasi dan pemesanan layanan {$serviceName}. Apakah bisa dibantu untuk estimasi harga dan survei lokasi?";
        return self::makeLink($text);
    }

    public static function forPortfolio(string $projectTitle, ?string $location = null): string
    {
        $locText = $location ? " di {$location}" : "";
        $text = "Halo AzkaMandiri, saya melihat hasil pekerjaan proyek \"{$projectTitle}\"{$locText} di website Anda dan berminat membuat yang serupa. Mohon informasi teknis dan penawarannya.";
        return self::makeLink($text);
    }
}

