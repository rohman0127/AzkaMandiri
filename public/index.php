<?php

// Safe auto-extractor
try {
    $appRoot = dirname(__DIR__);
    $coreZip = $appRoot . '/core.zip';
    $publicZip = $appRoot . '/public.zip';

    if ((file_exists($coreZip) || file_exists($publicZip)) && class_exists('ZipArchive')) {
        @set_time_limit(180);
        if (file_exists($coreZip)) {
            $zip = new ZipArchive();
            if ($zip->open($coreZip) === true) {
                $zip->extractTo($appRoot);
                $zip->close();
                @unlink($coreZip);
            }
        }
        if (file_exists($publicZip)) {
            $zip = new ZipArchive();
            if ($zip->open($publicZip) === true) {
                $zip->extractTo($appRoot);
                $zip->close();
                @unlink($publicZip);
            }
        }
        // Remove stale bootstrap caches
        @unlink($appRoot . '/bootstrap/cache/config.php');
        @unlink($appRoot . '/bootstrap/cache/routes-v7.php');
        @unlink($appRoot . '/bootstrap/cache/services.php');
        @unlink($appRoot . '/bootstrap/cache/packages.php');
    }
} catch (\Throwable $e) {
    error_log('Deploy auto-extract notice: ' . $e->getMessage());
}

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
