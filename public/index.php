<?php

declare(strict_types=1);

require __DIR__ . '/../bootstrap/app.php';

$routes = require base_path('routes/web.php');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

if (defined('PUBLIC_PREFIX')) {
    $prefix = rtrim((string) PUBLIC_PREFIX, '/');
    if ($prefix !== '' && str_starts_with($uri, $prefix)) {
        $uri = substr($uri, strlen($prefix)) ?: '/';
    }
}

$routeKey = $method . ' ' . $uri;

if (!isset($routes[$routeKey])) {
    http_response_code(404);
    echo '404 Not Found';
    exit;
}

[$controllerClass, $action] = $routes[$routeKey];
$controller = new $controllerClass();
$controller->$action();
