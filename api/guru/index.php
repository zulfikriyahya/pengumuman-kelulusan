<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$db = getDB();

if ($method === 'GET') {
    $stmt = $db->query('SELECT * FROM guru ORDER BY nama ASC');
    ok($stmt->fetchAll());
}

if ($method === 'POST') {
    requireAdmin();

    $uploadDir = $_ENV['UPLOAD_DIR'] . 'guru/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $fotoUrl = null;
    if (!empty($_FILES['foto'])) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('guru_') . '.' . strtolower($ext);
        move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $filename);
        $fotoUrl = $_ENV['PUBLIC_URL'] . 'guru/' . $filename;
    }

    $stmt = $db->prepare('INSERT INTO guru (nama, jabatan, foto_path, kesan_pesan) VALUES (?, ?, ?, ?)');
    $stmt->execute([$_POST['nama'], $_POST['jabatan'] ?? null, $fotoUrl, $_POST['kesan_pesan'] ?? null]);
    ok(['id' => $db->lastInsertId()]);
}

if ($method === 'DELETE' && $id) {
    requireAdmin();
    $stmt = $db->prepare('DELETE FROM guru WHERE id = ?');
    $stmt->execute([$id]);
    ok(['deleted' => $stmt->rowCount()]);
}

err('Not found', 404);
