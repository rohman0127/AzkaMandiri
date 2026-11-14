<?php

use App\Helpers\WhatsAppHelper;
use App\Models\Setting;

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('wa_link')) {
    function wa_link(?string $message = null): string
    {
        return WhatsAppHelper::makeLink($message);
    }
}

if (!function_exists('wa_service_link')) {
    function wa_service_link(string $serviceName): string
    {
        return WhatsAppHelper::forService($serviceName);
    }
}

if (!function_exists('wa_portfolio_link')) {
    function wa_portfolio_link(string $projectTitle, ?string $location = null): string
    {
        return WhatsAppHelper::forPortfolio($projectTitle, $location);
    }
}

