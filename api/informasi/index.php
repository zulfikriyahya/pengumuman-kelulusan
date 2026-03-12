<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$id     = $_GET['id'] ?? null;
$db     = getDB();

if ($method === 'GET') {
    $adminMode = !empty($_SESSION['admin']);
    $sql       = $adminMode
        ? 'SELECT * FROM informasi ORDER BY created_at DESC'
        : 'SELECT * FROM informasi WHERE is_published = 1 ORDER BY created_at DESC';
    $stmt = $db->query($sql);
    ok($stmt->fetchAll());
}

if ($method === 'POST' && !$id) {
    requireAdmin();

    $uploadBase = realpath(__DIR__ . '/../../uploads') . '/';

    $fotoPath = null;
    if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $dir = $uploadBase . 'informasi/foto/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $ext      = validateImageUpload($_FILES['foto']);
        $filename = uniqid('info_foto_') . '.' . $ext;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $dir . $filename)) {
            $fotoPath = $_ENV['PUBLIC_URL'] . 'informasi/foto/' . $filename;
        }
    }

    $filePath    = null;
    $fileOrigName = null;
    if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $dir = $uploadBase . 'informasi/file/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $ext      = validateFileUpload($_FILES['file']);
        $filename = uniqid('info_file_') . '.' . $ext;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $dir . $filename)) {
            $filePath     = $_ENV['PUBLIC_URL'] . 'informasi/file/' . $filename;
            $fileOrigName = $_FILES['file']['name'];
        }
    }

    $stmt = $db->prepare('INSERT INTO informasi (judul, isi, foto_path, foto_caption, file_path, file_name, link_eksternal, is_published)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $_POST['judul'] ?? '',
        $_POST['isi'] ?? null,
        $fotoPath,
        $_POST['foto_caption'] ?? null,
        $filePath,
        $fileOrigName,
        $_POST['link_eksternal'] ?? null,
        (int)($_POST['is_published'] ?? 1),
    ]);
    ok(['id' => $db->lastInsertId()]);
}

if ($method === 'PUT' && $id) {
    requireAdmin();
    $body = getBody();
    $stmt = $db->prepare('UPDATE informasi SET judul=?, isi=?, foto_caption=?, link_eksternal=?, is_published=? WHERE id=?');
    $stmt->execute([
        $body['judul'],
        $body['isi'] ?? null,
        $body['foto_caption'] ?? null,
        $body['link_eksternal'] ?? null,
        (int)($body['is_published'] ?? 1),
        $id,
    ]);
    ok(['updated' => $stmt->rowCount()]);
}

if ($method === 'DELETE' && $id) {
    requireAdmin();

    $stmt = $db->prepare('SELECT foto_path, file_path FROM informasi WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($row) {
        $base = realpath(__DIR__ . '/../../uploads') . '/';
        foreach (['foto_path' => 'informasi/foto/', 'file_path' => 'informasi/file/'] as $col => $subdir) {
            if ($row[$col]) {
                $f = $base . $subdir . basename($row[$col]);
                if (is_file($f)) unlink($f);
            }
        }
    }

    $stmt = $db->prepare('DELETE FROM informasi WHERE id = ?');
    $stmt->execute([$id]);
    ok(['deleted' => $stmt->rowCount()]);
}

err('Not found', 404);
