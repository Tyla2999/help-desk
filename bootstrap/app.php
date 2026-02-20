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

function csrf_token(): string
{
    if (!isset($_SESSION['_csrf_token']) || !is_string($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf_token'];
}

function verify_csrf_token(?string $token): bool
{
    $sessionToken = $_SESSION['_csrf_token'] ?? null;

    return is_string($sessionToken) && is_string($token) && hash_equals($sessionToken, $token);
}

function current_user(): ?array
{
    static $resolved = false;
    static $user = null;

    if ($resolved) {
        return is_array($user) ? $user : null;
    }

    $resolved = true;

    $userId = $_SESSION['auth_user_id'] ?? null;
    if (!is_numeric($userId)) {
        return null;
    }

    $model = new \App\Models\User();
    $found = $model->findById((int) $userId);
    if ($found === null) {
        return null;
    }

    $user = $found;
    return $user;
}

function auth_check(): bool
{
    return current_user() !== null;
}

function login_user(int $userId): void
{
    session_regenerate_id(true);
    $_SESSION['auth_user_id'] = $userId;
}

function logout_user(): void
{
    unset($_SESSION['auth_user_id']);
    session_regenerate_id(true);
}

function require_auth(): void
{
    if (!auth_check()) {
        redirect('/login');
    }
}

function has_role(string|array $roles): bool
{
    $user = current_user();
    if ($user === null) {
        return false;
    }

    $roleList = is_array($roles) ? $roles : [$roles];
    return in_array((string) ($user['role'] ?? ''), $roleList, true);
}

function require_role(string|array $roles): void
{
    require_auth();

    if (!has_role($roles)) {
        redirect('/dashboard');
    }
}
