<?php
// Router untuk PHP built-in server (php -S localhost:8080 router.php)
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Izinkan file asli (assets, uploads, dll)
$file = __DIR__ . $path;
if ($path !== '/' && file_exists($file) && !is_dir($file)) {
    return false;
}

// Semua request lain diteruskan ke index.php
require __DIR__ . '/index.php';
