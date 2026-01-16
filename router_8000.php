<?php
// Router for localhost:8000 - Generator & Admin
$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Remove leading slash
$requestPath = ltrim($requestPath, '/');

switch ($requestPath) {
    case '':
    case 'index.php':
        require __DIR__ . '/index.php';
        break;
    case 'generator.php':
        require __DIR__ . '/generator.php';
        break;
    case 'preset.php':
        require __DIR__ . '/preset.php';
        break;
    case 'admin_login.php':
        require __DIR__ . '/admin_login.php';
        break;
    case 'admin_dashboard.php':
        require __DIR__ . '/admin_dashboard.php';
        break;
    case 'generated_concept.json':
        readfile(__DIR__ . '/generated_concept.json');
        break;
    default:
        // fallback to index
        require __DIR__ . '/index.php';
        break;
}

