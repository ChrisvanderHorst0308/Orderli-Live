<?php
// Router for localhost:8001 - Viewer
$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Remove leading slash
$requestPath = ltrim($requestPath, '/');

// Route to viewer.php
if ($requestPath === '' || $requestPath === 'index.php' || $requestPath === 'viewer.php') {
    require __DIR__ . '/viewer.php';
    exit;
}

// Default: show viewer
require __DIR__ . '/viewer.php';

