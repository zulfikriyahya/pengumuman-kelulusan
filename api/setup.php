<?php
require_once __DIR__ . '/config/db.php';

$token  = $_GET['token'] ?? '';
$secret = $_ENV['SETUP_TOKEN'] ?? '';

if (!$secret || $token !== $secret) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Forbidden']);
    exit;
}

$hash = password_hash($_ENV['ADMIN_PASSWORD'], PASSWORD_BCRYPT);
getDB()->prepare('UPDATE admin SET password = ? WHERE username = ?')
    ->execute([$hash, $_ENV['ADMIN_USERNAME']]);

echo json_encode(['status' => 'success', 'message' => 'Password updated.']);
