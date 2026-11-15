<?php

// Auto-extract deployment zip packages if present
$appRoot = dirname(__DIR__);
$zips = ['core.zip', 'public.zip', 'vendor_addons.zip', 'vendor.zip'];
$needsExtract = false;
foreach ($zips as $z) {
    if (file_exists($appRoot . '/' . $z)) {
        $needsExtract = true;
        break;
    }
}
if ($needsExtract) {
    @set_time_limit(300);
    foreach ($zips as $z) {
        $zipPath = $appRoot . '/' . $z;
        if (file_exists($zipPath)) {
            $zip = new ZipArchive();
            if ($zip->open($zipPath) === true) {
                $zip->extractTo($appRoot);
                $zip->close();
                @unlink($zipPath);
            }
        }
    }
    // Clear stale view and route caches
    $views = glob($appRoot . '/storage/framework/views/*.php');
    if ($views) {
        foreach ($views as $vf) {
            @unlink($vf);
        }
    }
    @unlink($appRoot . '/bootstrap/cache/config.php');
    @unlink($appRoot . '/bootstrap/cache/routes-v7.php');

    // Automatically sync uploaded media from storage/app/public into public/storage
    $srcStorage = $appRoot . '/storage/app/public';
    $dstStorage = __DIR__ . '/storage';
    if (is_dir($srcStorage)) {
        if (!is_dir($dstStorage)) {
            @mkdir($dstStorage, 0777, true);
        }
        $iter = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($srcStorage, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iter as $file) {
            $sub = $iter->getSubPathName();
            $targetFile = $dstStorage . '/' . $sub;
            if ($file->isDir()) {
                if (!is_dir($targetFile)) {
                    @mkdir($targetFile, 0777, true);
                }
            } else {
                if (!file_exists($targetFile) || filemtime($file) > filemtime($targetFile)) {
                    $pDir = dirname($targetFile);
                    if (!is_dir($pDir)) {
                        @mkdir($pDir, 0777, true);
                    }
                    @copy($file->getPathname(), $targetFile);
                }
            }
        }
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
