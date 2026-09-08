<?php

// Tampilkan error bawaan PHP
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Buat folder storage sementara di Vercel jika belum ada
$storageFolders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/bootstrap/cache',
    '/tmp/storage/logs',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
}

// Arahkan path cache Laravel ke /tmp secara paksa
$_ENV['APP_SERVICES_CACHE'] = '/tmp/storage/bootstrap/cache/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/storage/bootstrap/cache/packages.php';
$_ENV['APP_CONFIG_CACHE']   = '/tmp/storage/bootstrap/cache/config.php';
$_ENV['APP_ROUTES_CACHE']   = '/tmp/storage/bootstrap/cache/routes.php';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

// Panggil aplikasi Laravel
require __DIR__ . '/../public/index.php';