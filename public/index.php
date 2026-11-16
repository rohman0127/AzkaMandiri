<?php

// 1. Paksa PHP Menampilkan Semua Pesan Error ke Layar Browser
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// 2. Tangkap Fatal Error (E_ERROR, Parse Error, Out of Memory, Class Not Found)
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
        // Tulis juga ke file teks darurat di folder public agar bisa dibaca via FTP
        @file_put_contents(__DIR__ . '/fatal_error_log.txt', print_r($error, true));
        
        echo '<div style="background:#fff1f2; color:#9f1239; border:2px solid #e11d48; padding:20px; font-family:monospace; margin:20px; border-radius:8px;">';
        echo '<h2 style="margin-top:0; color:#be123c;">⚠️ PHP FATAL ERROR TERCATAT</h2>';
        echo '<strong>Pesan:</strong> ' . htmlspecialchars($error['message']) . '<br>';
        echo '<strong>File:</strong> ' . htmlspecialchars($error['file']) . '<br>';
        echo '<strong>Baris:</strong> ' . $error['line'] . '<br>';
        echo '</div>';
    }
});

// 3. Tangkap Uncaught Exception / Error Laravel
set_exception_handler(function (\Throwable $e) {
    $trace = "UNCAUGHT EXCEPTION: " . get_class($e) . ": " . $e->getMessage() . "\n" .
             "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n" .
             $e->getTraceAsString();
             
    @file_put_contents(__DIR__ . '/fatal_error_log.txt', $trace);

    echo '<div style="background:#fff1f2; color:#9f1239; border:2px solid #e11d48; padding:20px; font-family:monospace; margin:20px; border-radius:8px;">';
    echo '<h2 style="margin-top:0; color:#be123c;">⚠️ LARAVEL EXCEPTION TERCATAT</h2>';
    echo '<strong>Tipe:</strong> ' . get_class($e) . '<br>';
    echo '<strong>Pesan:</strong> ' . htmlspecialchars($e->getMessage()) . '<br>';
    echo '<strong>File:</strong> ' . htmlspecialchars($e->getFile()) . ' (Baris ' . $e->getLine() . ')<br>';
    echo '<h4 style="margin-bottom:5px;">Stack Trace:</h4>';
    echo '<pre style="background:#ffe4e6; padding:10px; border-radius:4px; overflow-x:auto;">' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    echo '</div>';
});

// Auto-extract deployment packages if present in root directory
try {
    $rootDir = dirname(__DIR__);
    $zips = ['core.zip', 'public.zip', 'vendor_addons.zip', 'vendor.zip'];
    $needsExtract = false;
    foreach ($zips as $z) {
        if (file_exists($rootDir . '/' . $z)) {
            $needsExtract = true;
            break;
        }
    }
    if ($needsExtract && class_exists('ZipArchive')) {
        @set_time_limit(300);
        foreach ($zips as $z) {
            $zipPath = $rootDir . '/' . $z;
            if (file_exists($zipPath)) {
                $zip = new ZipArchive();
                if ($zip->open($zipPath) === true) {
                    $zip->extractTo($rootDir);
                    $zip->close();
                    @unlink($zipPath);
                }
            }
        }
        @unlink($rootDir . '/bootstrap/cache/config.php');
        @unlink($rootDir . '/bootstrap/cache/routes-v7.php');
        // Clear compiled blade views to reflect changes immediately
        $viewFiles = glob($rootDir . '/storage/framework/views/*.php');
        if ($viewFiles) {
            foreach ($viewFiles as $vf) {
                @unlink($vf);
            }
        }
    }
} catch (\Throwable $e) {
    @file_put_contents(__DIR__ . '/deploy_error.log', "Deploy extract notice: " . $e->getMessage() . "\n", FILE_APPEND);
}

// Auto-run one-time server synchronization if run_sync.php is present
if (file_exists(__DIR__ . '/run_sync.php')) {
    try {
        include_once __DIR__ . '/run_sync.php';
        @unlink(__DIR__ . '/run_sync.php');
    } catch (\Throwable $t) {
        @file_put_contents(__DIR__ . '/sync_error.log', $t->getMessage());
    }
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
