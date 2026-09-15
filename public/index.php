<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Subdirectory support (APP_URL path like /dev/artsdiva)
$envFile = __DIR__.'/../.env';
if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || ! str_starts_with($line, 'APP_URL=')) {
            continue;
        }
        $appUrl = trim(substr($line, 8), " \t\"'");
        $basePath = rtrim((string) parse_url($appUrl, PHP_URL_PATH), '/');
        if ($basePath !== '' && $basePath !== '/') {
            $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
            if (str_starts_with($requestUri, $basePath)) {
                $_SERVER['REQUEST_URI'] = substr($requestUri, strlen($basePath)) ?: '/';
            }
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            if (str_starts_with($scriptName, $basePath)) {
                $_SERVER['SCRIPT_NAME'] = substr($scriptName, strlen($basePath)) ?: '/index.php';
            }
        }
        break;
    }
}

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
