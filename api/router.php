<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = rtrim($uri, '/');

if (str_starts_with($path, '/uploads/')) {
    $file = realpath(__DIR__ . '/..' . $path);
    if ($file && is_file($file) && str_starts_with($file, realpath(__DIR__ . '/../uploads'))) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png'         => 'image/png',
            'gif'         => 'image/gif',
            'webp'        => 'image/webp',
            default       => 'application/octet-stream',
        };
        header("Content-Type: $mime");
        header("Access-Control-Allow-Origin: *");
        readfile($file);
        exit;
    }
    http_response_code(404);
    exit;
}

$file = __DIR__ . $path . '/index.php';

if (!is_file($file)) {
    $file = __DIR__ . $path . '.php';
}

if (is_file($file)) {
    require $file;
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Not found: ' . $path]);
}
