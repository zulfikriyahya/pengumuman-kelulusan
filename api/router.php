<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = rtrim($uri, '/');
$file = __DIR__ . $path . '/index.php';

if (is_file($file)) {
    require $file;
} elseif (is_file(__DIR__ . $path)) {
    require __DIR__ . $path;
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Not found: ' . $path]);
}
