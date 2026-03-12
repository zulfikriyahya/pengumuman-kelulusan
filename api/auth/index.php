<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($method === 'POST' && $action === 'login') {
    $body = getBody();
    $username = trim($body['username'] ?? '');
    $password = $body['password'] ?? '';

    $db = getDB();
    $stmt = $db->prepare('SELECT * FROM admin WHERE username = ?');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if (!$admin || !password_verify($password, $admin['password'])) {
        err('Username atau password salah', 401);
    }

    $_SESSION['admin'] = $admin['id'];
    ok(['message' => 'Login berhasil']);
}

if ($method === 'POST' && $action === 'logout') {
    $_SESSION = [];
    session_destroy();
    ok(['message' => 'Logout berhasil']);
}

if ($method === 'GET' && $action === 'check') {
    ok(['authenticated' => !empty($_SESSION['admin'])]);
}

err('Not found', 404);
