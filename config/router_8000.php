<?php
// Router for localhost:8000 - Generator & Admin
$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Remove leading slash
$requestPath = ltrim($requestPath, '/');

switch ($requestPath) {
    case '':
    case 'index.php':
        require __DIR__ . '/../public/index.php';
        break;
    case 'generator.php':
        require __DIR__ . '/../public/generator.php';
        break;
    case 'preset.php':
        require __DIR__ . '/../public/preset.php';
        break;
    case 'admin_login.php':
        require __DIR__ . '/../public/admin_login.php';
        break;
    case 'admin_dashboard.php':
        require __DIR__ . '/../public/admin_dashboard.php';
        break;
    case 'generated_concept.json':
        readfile(__DIR__ . '/../data/generated_concept.json');
        break;
    case (strpos($requestPath, 'images/') === 0):
        // Serve images
        $imagePath = __DIR__ . '/../public/' . $requestPath;
        if (file_exists($imagePath)) {
            $mimeType = mime_content_type($imagePath);
            header('Content-Type: ' . $mimeType);
            readfile($imagePath);
            exit;
        }
        break;
    default:
        // fallback to index
        require __DIR__ . '/../public/index.php';
        break;
}

