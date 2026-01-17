<?php
// Router for localhost:8001 - Viewer
$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Remove leading slash
$requestPath = ltrim($requestPath, '/');

// Route to viewer.php
if ($requestPath === '' || $requestPath === 'index.php' || $requestPath === 'viewer.php') {
    require __DIR__ . '/../public/viewer.php';
    exit;
}

// Serve images if requested
if (strpos($requestPath, 'images/') === 0) {
    $imagePath = __DIR__ . '/../public/' . $requestPath;
    if (file_exists($imagePath)) {
        $mimeType = mime_content_type($imagePath);
        header('Content-Type: ' . $mimeType);
        readfile($imagePath);
        exit;
    }
}

// Default: show viewer
require __DIR__ . '/../public/viewer.php';

