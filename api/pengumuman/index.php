<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$db = getDB();

if ($method === 'GET') {
    $stmt = $db->query('SELECT * FROM pengumuman_config ORDER BY id DESC LIMIT 1');
    ok($stmt->fetch());
}

if ($method === 'POST') {
    requireAdmin();
    $body = getBody();

    $stmt = $db->prepare('UPDATE pengumuman_config SET tanggal_waktu = ?, is_active = ? WHERE id = 1');
    $stmt->execute([
        $body['tanggal_waktu'],
        (int)($body['is_active'] ?? 0),
    ]);
    ok(['message' => 'Config disimpan']);
}

err('Not found', 404);
