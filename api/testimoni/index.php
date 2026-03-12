<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();

if ($method === 'GET') {
    $stmt = $db->query('SELECT * FROM testimoni ORDER BY created_at DESC');
    ok($stmt->fetchAll());
}

if ($method === 'POST') {
    $body = getBody();
    if (empty($body['nama']) || empty($body['isi'])) err('Nama dan isi diperlukan');

    $stmt = $db->prepare('INSERT INTO testimoni (nama, nisn, isi) VALUES (?, ?, ?)');
    $stmt->execute([$body['nama'], $body['nisn'] ?? null, $body['isi']]);
    ok(['id' => $db->lastInsertId()]);
}

if ($method === 'DELETE' && isset($_GET['id'])) {
    requireAdmin();
    $stmt = $db->prepare('DELETE FROM testimoni WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    ok(['deleted' => $stmt->rowCount()]);
}

err('Not found', 404);
