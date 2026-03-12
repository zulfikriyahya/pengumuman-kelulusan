<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$id     = $_GET['id'] ?? null;
$db     = getDB();

if ($method === 'GET') {
    $stmt = $db->query('SELECT * FROM album ORDER BY created_at DESC');
    ok($stmt->fetchAll());
}

if ($method === 'POST') {
    requireAdmin();

    if (empty($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        err('File foto diperlukan atau upload gagal');
    }

    $uploadDir = realpath(__DIR__ . '/../../uploads/album') . '/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $ext      = validateImageUpload($_FILES['foto']);
    $filename = uniqid('album_') . '.' . $ext;
    $dest     = $uploadDir . $filename;

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $dest)) err('Upload gagal');

    $publicUrl = $_ENV['PUBLIC_URL'] . 'album/' . $filename;
    $judul     = $_POST['judul'] ?? null;

    $stmt = $db->prepare('INSERT INTO album (judul, foto_path) VALUES (?, ?)');
    $stmt->execute([$judul, $publicUrl]);
    ok(['id' => $db->lastInsertId(), 'foto_path' => $publicUrl]);
}

if ($method === 'DELETE' && $id) {
    requireAdmin();

    $stmt = $db->prepare('SELECT foto_path FROM album WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($row) {
        $filePath = realpath(__DIR__ . '/../../uploads/album') . '/' . basename($row['foto_path']);
        if (is_file($filePath)) unlink($filePath);
    }

    $stmt = $db->prepare('DELETE FROM album WHERE id = ?');
    $stmt->execute([$id]);
    ok(['deleted' => $stmt->rowCount()]);
}

err('Not found', 404);
