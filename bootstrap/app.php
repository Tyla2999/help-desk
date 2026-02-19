<?php

declare(strict_types=1);

session_start();

$appConfig = require __DIR__ . '/../config/app.php';
date_default_timezone_set((string) ($appConfig['timezone'] ?? 'Asia/Bangkok'));

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

function base_path(string $path = ''): string
{
    $base = dirname(__DIR__);
    return $path ? $base . '/' . ltrim($path, '/') : $base;
}

function request_base_path(): string
{
    $scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
    $dir = rtrim((string) dirname($scriptName), '/');

    if ($dir === '.' || $dir === '/') {
        return '';
    }

    return $dir;
}

function app_base_url(): string
{
    return request_base_path();
}

function url(string $path = ''): string
{
    $base = app_base_url();
    $normalizedPath = ltrim($path, '/');

    if ($normalizedPath === '') {
        return $base === '' ? '/' : $base . '/';
    }

    return ($base === '' ? '' : $base) . '/' . $normalizedPath;
}

function asset_url(string $path = ''): string
{
    $base = app_base_url();
    $prefix = '';

    if (defined('PUBLIC_PREFIX')) {
        $prefix = rtrim((string) PUBLIC_PREFIX, '/');
    }

    $assetPath = ltrim($path, '/');

    if ($assetPath === '') {
        return ($base === '' ? '' : $base) . $prefix . '/';
    }

    return ($base === '' ? '' : $base) . $prefix . '/' . $assetPath;
}

function view(string $view, array $data = []): void
{
    extract($data, EXTR_SKIP);

    ob_start();
    require base_path('app/Views/' . $view . '.php');
    $content = (string) ob_get_clean();

    require base_path('app/Views/layouts/main.php');
}

function redirect(string $path): void
{
    $target = preg_match('#^https?://#', $path) ? $path : url($path);
    header('Location: ' . $target);
    exit;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
