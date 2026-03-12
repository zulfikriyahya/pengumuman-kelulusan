<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$db = getDB();

if ($method === 'GET') {
    $stmt = $db->query('SELECT * FROM album ORDER BY created_at DESC');
    ok($stmt->fetchAll());
}

if ($method === 'POST') {
    requireAdmin();

    if (empty($_FILES['foto'])) err('File foto diperlukan');

    $uploadDir = $_ENV['UPLOAD_DIR'] . 'album/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('album_') . '.' . strtolower($ext);
    $dest = $uploadDir . $filename;

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $dest)) err('Upload gagal');

    $publicUrl = $_ENV['PUBLIC_URL'] . 'album/' . $filename;
    $judul = $_POST['judul'] ?? null;

    $stmt = $db->prepare('INSERT INTO album (judul, foto_path) VALUES (?, ?)');
    $stmt->execute([$judul, $publicUrl]);
    ok(['id' => $db->lastInsertId(), 'foto_path' => $publicUrl]);
}

if ($method === 'DELETE' && $id) {
    requireAdmin();
    $stmt = $db->prepare('DELETE FROM album WHERE id = ?');
    $stmt->execute([$id]);
    ok(['deleted' => $stmt->rowCount()]);
}

err('Not found', 404);
