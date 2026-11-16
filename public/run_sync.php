<?php
header('Content-Type: text/plain');

$output = [];
$output[] = "=== SYNC SCRIPT EXECUTED AT " . date('Y-m-d H:i:s') . " ===";

// 1. Connect to Database using .env credentials
$envFile = __DIR__ . '/../.env';
if (!file_exists($envFile)) {
    $envFile = __DIR__ . '/.env';
}

$dbHost = 'sql303.infinityfree.com';
$dbName = 'if0_42986792_azkamandiri';
$dbUser = 'if0_42986792';
$dbPass = 'bO9CcHQMU0fgG';

if (file_exists($envFile)) {
    $envContent = file_get_contents($envFile);
    if (preg_match('/DB_HOST=(.*)/', $envContent, $m)) $dbHost = trim($m[1], " \t\n\r\0\x0B\"'");
    if (preg_match('/DB_DATABASE=(.*)/', $envContent, $m)) $dbName = trim($m[1], " \t\n\r\0\x0B\"'");
    if (preg_match('/DB_USERNAME=(.*)/', $envContent, $m)) $dbUser = trim($m[1], " \t\n\r\0\x0B\"'");
    if (preg_match('/DB_PASSWORD=(.*)/', $envContent, $m)) $dbPass = trim($m[1], " \t\n\r\0\x0B\"'");
}

$output[] = "DB Host: $dbHost, DB: $dbName, User: $dbUser";

try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $output[] = "✅ Database connection successful!";

    // Check current logo settings
    $stmt = $pdo->query("SELECT `key`, `value` FROM settings WHERE `key` LIKE '%logo%' OR `key` LIKE '%company%' OR `key` IN ('address', 'phone_number', 'whatsapp_number', 'bank_name', 'bank_account', 'bank_holder')");
    $output[] = "--- Current Settings in DB ---";
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $output[] = "{$r['key']} => {$r['value']}";
    }

    // Target correct settings
    $updates = [
        'logo_path' => 'assets/brand/logo-horizontal.svg',
        'logo_dark_path' => 'assets/brand/logo-horizontal-dark.svg',
        'favicon_path' => 'assets/brand/favicon.svg',
        'company_name' => 'AZKA MANDIRI',
        'company_address' => 'Jl. Pondok Serut, Paku Jaya, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15220',
        'company_phone' => '+62 819-3273-5383',
        'company_email' => 'kontak@azkamandiri.com',
        'address' => 'Jl. Pondok Serut, Paku Jaya, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15220',
        'phone_number' => '+62 819-3273-5383',
        'whatsapp_number' => '6281932735383',
        'bank_name' => 'Bank BCA',
        'bank_account' => '474-0850-364',
        'bank_holder' => 'Mikliw Oking',
    ];

    $updateStmt = $pdo->prepare("INSERT INTO settings (`key`, `value`, `group`, `created_at`, `updated_at`) 
        VALUES (:key, :val, 'general', NOW(), NOW()) 
        ON DUPLICATE KEY UPDATE `value` = :val_update, `updated_at` = NOW()");

    foreach ($updates as $k => $v) {
        $updateStmt->execute([
            ':key' => $k,
            ':val' => $v,
            ':val_update' => $v
        ]);
        $output[] = "Updated DB setting: $k => $v";
    }

} catch (\Throwable $e) {
    $output[] = "❌ DB Error: " . $e->getMessage();
}

// 2. Clear File Caches
$rootDir = dirname(__DIR__);
if (!is_dir($rootDir . '/storage')) {
    $rootDir = __DIR__;
}

$cacheDirs = [
    $rootDir . '/storage/framework/cache/data',
    $rootDir . '/storage/framework/views',
    $rootDir . '/bootstrap/cache',
];

function rrmdir($dir) {
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..' || $file === '.gitignore') continue;
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            rrmdir($path);
            @rmdir($path);
        } else {
            @unlink($path);
        }
    }
}

foreach ($cacheDirs as $d) {
    if (is_dir($d)) {
        rrmdir($d);
        $output[] = "Cleared cache dir: $d";
    }
}

$resultText = implode("\n", $output) . "\n";
file_put_contents(__DIR__ . '/sync_log.txt', $resultText);
echo $resultText;
