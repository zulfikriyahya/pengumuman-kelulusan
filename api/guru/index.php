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

if ($method === 'POST' && ($_GET['action'] ?? '') === 'import') {
    requireAdmin();

    $uploadDir = realpath(__DIR__ . '/../../uploads/guru') . '/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $rows = [];
    $files = $_FILES['foto'] ?? [];
    $fotoMap = [];

    // Proses upload foto jika ada (multifile, key = index baris)
    if (!empty($files['name'])) {
        foreach ($files['name'] as $i => $name) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK || !$name) continue;
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $filename = uniqid('guru_') . '.' . $ext;
            if (move_uploaded_file($files['tmp_name'][$i], $uploadDir . $filename)) {
                $fotoMap[$i] = $_ENV['PUBLIC_URL'] . 'guru/' . $filename;
            }
        }
    }

    $namaList  = $_POST['nama'] ?? [];
    $jabList   = $_POST['jabatan'] ?? [];
    $kesanList = $_POST['kesan_pesan'] ?? [];

    if (empty($namaList)) err('Data kosong');

    $stmt = $db->prepare('INSERT INTO guru (nama, jabatan, foto_path, kesan_pesan) VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE jabatan = VALUES(jabatan), kesan_pesan = VALUES(kesan_pesan)');

    $db->beginTransaction();
    foreach ($namaList as $i => $nama) {
        if (!trim($nama)) continue;
        $stmt->execute([
            trim($nama),
            trim($jabList[$i] ?? ''),
            $fotoMap[$i] ?? null,
            trim($kesanList[$i] ?? ''),
        ]);
        $rows[] = $nama;
    }
    $db->commit();

    ok(['imported' => count($rows)]);
}

if ($method === 'POST') {
    requireAdmin();

    $uploadDir = realpath(__DIR__ . '/../../uploads/guru') . '/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $fotoUrl = null;
    if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $filename = uniqid('guru_') . '.' . $ext;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $filename)) {
            $fotoUrl = $_ENV['PUBLIC_URL'] . 'guru/' . $filename;
        }
    }

    $stmt = $db->prepare('INSERT INTO guru (nama, jabatan, foto_path, kesan_pesan) VALUES (?, ?, ?, ?)');
    $stmt->execute([
        $_POST['nama'] ?? '',
        $_POST['jabatan'] ?? null,
        $fotoUrl,
        $_POST['kesan_pesan'] ?? null,
    ]);
    ok(['id' => $db->lastInsertId(), 'foto_path' => $fotoUrl]);
}

if ($method === 'DELETE' && $id) {
    requireAdmin();
    $stmt = $db->prepare('SELECT foto_path FROM guru WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row && $row['foto_path']) {
        $filePath = realpath(__DIR__ . '/../../uploads/guru') . '/' . basename($row['foto_path']);
        if (is_file($filePath)) unlink($filePath);
    }
    $stmt = $db->prepare('DELETE FROM guru WHERE id = ?');
    $stmt->execute([$id]);
    ok(['deleted' => $stmt->rowCount()]);
}

err('Not found', 404);
