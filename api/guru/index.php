<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$id     = $_GET['id'] ?? null;
$db     = getDB();

if ($method === 'GET') {
    $stmt = $db->query('SELECT * FROM guru ORDER BY nama ASC');
    ok($stmt->fetchAll());
}

if ($method === 'POST' && ($_GET['action'] ?? '') === 'import') {
    requireAdmin();

    $uploadDir = __DIR__ . '/../../uploads/guru/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $uploadDir = realpath($uploadDir) . '/';
    $publicUrl = rtrim($_ENV['PUBLIC_URL'], '/');

    $fotoMap = [];
    $files   = $_FILES['foto'] ?? [];

    if (!empty($files['name'])) {
        foreach ($files['name'] as $i => $name) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK || !$name) continue;
            $singleFile = [
                'tmp_name' => $files['tmp_name'][$i],
                'name'     => $name,
                'size'     => $files['size'][$i],
                'error'    => $files['error'][$i],
            ];
            $ext      = validateImageUpload($singleFile);
            $filename = uniqid('guru_') . '.' . $ext;
            if (move_uploaded_file($files['tmp_name'][$i], $uploadDir . $filename)) {
                $fotoMap[$i] = $publicUrl . '/guru/' . $filename;
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
    $count = 0;
    foreach ($namaList as $i => $nama) {
        if (!trim($nama)) continue;
        $stmt->execute([
            trim($nama),
            trim($jabList[$i] ?? ''),
            $fotoMap[$i] ?? null,
            trim($kesanList[$i] ?? ''),
        ]);
        $count++;
    }
    $db->commit();

    ok(['imported' => $count]);
}

if ($method === 'POST' && !$id) {
    requireAdmin();

    $uploadDir = __DIR__ . '/../../uploads/guru/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $uploadDir = realpath($uploadDir) . '/';

    $fotoUrl = null;
    if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext      = validateImageUpload($_FILES['foto']);
        $filename = uniqid('guru_') . '.' . $ext;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $filename)) {
            $publicUrl = rtrim($_ENV['PUBLIC_URL'], '/');
            $fotoUrl   = $publicUrl . '/guru/' . $filename;
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

if ($method === 'PUT' && $id) {
    requireAdmin();

    $uploadDir = __DIR__ . '/../../uploads/guru/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $uploadDir = realpath($uploadDir) . '/';

    $stmt = $db->prepare('SELECT foto_path FROM guru WHERE id = ?');
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if (!$existing) err('Data tidak ditemukan', 404);

    $fotoUrl = $existing['foto_path'];

    if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        if ($fotoUrl) {
            $old = $uploadDir . basename($fotoUrl);
            if (is_file($old)) unlink($old);
        }
        $ext      = validateImageUpload($_FILES['foto']);
        $filename = uniqid('guru_') . '.' . $ext;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $filename)) {
            $publicUrl = rtrim($_ENV['PUBLIC_URL'], '/');
            $fotoUrl   = $publicUrl . '/guru/' . $filename;
        }
    }

    $stmt = $db->prepare('UPDATE guru SET nama = ?, jabatan = ?, foto_path = ?, kesan_pesan = ? WHERE id = ?');
    $stmt->execute([
        $_POST['nama'] ?? '',
        $_POST['jabatan'] ?? null,
        $fotoUrl,
        $_POST['kesan_pesan'] ?? null,
        $id,
    ]);
    ok(['updated' => $stmt->rowCount(), 'foto_path' => $fotoUrl]);
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
