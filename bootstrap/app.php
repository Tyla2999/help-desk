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

function app_base_url(): string
{
    if (defined('PUBLIC_PREFIX')) {
        return rtrim((string) PUBLIC_PREFIX, '/');
    }

    return '';
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
    header('Location: ' . $path);
    exit;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
