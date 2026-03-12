<?php

function loadEnv(string $path): void
{
    if (!file_exists($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$key, $val] = array_map('trim', explode('=', $line, 2));
        $_ENV[$key] = $val;
        putenv("$key=$val");
    }
}

loadEnv(__DIR__ . '/../.env');

set_exception_handler(function (Throwable $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
});

set_error_handler(function (int $errno, string $errstr) {
    throw new \ErrorException($errstr, $errno);
});

function getDB(): PDO
{
    static $pdo = null;
    if ($pdo) return $pdo;

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $_ENV['DB_HOST'],
        $_ENV['DB_PORT'],
        $_ENV['DB_NAME']
    );

    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}

function setCorsHeaders(): void
{
    $origin = $_ENV['ALLOWED_ORIGIN'] ?? '*';
    header("Access-Control-Allow-Origin: $origin");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Allow-Credentials: true');
    header('Content-Type: application/json');

    if (session_status() === PHP_SESSION_NONE) {
        $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || ($_SERVER['SERVER_PORT'] ?? 80) == 443;

        session_set_cookie_params([
            'lifetime' => 86400,
            'path'     => '/',
            'secure'   => $isSecure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }
}

function json(mixed $data, int $code = 200): never
{
    http_response_code($code);
    echo json_encode($data);
    exit;
}

function ok(mixed $data): never
{
    json(['status' => 'success', 'data' => $data]);
}

function err(string $msg, int $code = 400): never
{
    json(['status' => 'error', 'message' => $msg], $code);
}

function getBody(): array
{
    return json_decode(file_get_contents('php://input'), true) ?? [];
}

function requireAdmin(): void
{
    if (empty($_SESSION['admin'])) {
        err('Unauthorized', 401);
    }
}

function validateImageUpload(array $file): string
{
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $finfo   = new \finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($file['tmp_name']);

    if (!in_array($mime, $allowed, true)) {
        err('Tipe file tidak diizinkan. Gunakan JPG, PNG, WEBP, atau GIF.');
    }

    $maxSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        err('Ukuran file maksimal 5MB.');
    }

    return match ($mime) {
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    };
}

function validateFileUpload(array $file): string
{
    $allowed = [
        'application/pdf'                                                        => 'pdf',
        'application/msword'                                                     => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.ms-excel'                                               => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'      => 'xlsx',
    ];

    $finfo = new \finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);

    if (!isset($allowed[$mime])) {
        err('Tipe file tidak diizinkan. Gunakan PDF, DOC, DOCX, XLS, atau XLSX.');
    }

    $maxSize = 10 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        err('Ukuran file maksimal 10MB.');
    }

    return $allowed[$mime];
}
