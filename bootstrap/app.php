<?php

declare(strict_types=1);

session_start();

date_default_timezone_set('Asia/Bangkok');

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
