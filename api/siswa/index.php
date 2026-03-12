<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

$db = getDB();

if ($method === 'GET' && !$id) {
    $where = ['1=1'];
    $params = [];

    foreach (['jenis_kelamin', 'tahun_pelajaran', 'status_kelulusan', 'kelas'] as $col) {
        if (!empty($_GET[$col])) {
            $where[] = "$col = ?";
            $params[] = $_GET[$col];
        }
    }

    if (!empty($_GET['q'])) {
        $where[] = '(nama_lengkap LIKE ? OR nisn LIKE ?)';
        $params[] = '%' . $_GET['q'] . '%';
        $params[] = '%' . $_GET['q'] . '%';
    }

    $sql = 'SELECT * FROM siswa WHERE ' . implode(' AND ', $where) . ' ORDER BY nama_lengkap ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    ok($stmt->fetchAll());
}

if ($method === 'GET' && $id === 'nisn') {
    $nisn = $_GET['nisn'] ?? '';
    if (!$nisn) err('NISN diperlukan');

    $stmt = $db->prepare('SELECT * FROM siswa WHERE nisn = ?');
    $stmt->execute([$nisn]);
    $row = $stmt->fetch();
    if (!$row) err('Siswa tidak ditemukan', 404);
    ok($row);
}

if ($method === 'POST' && ($_GET['action'] ?? '') === 'import') {
    requireAdmin();

    $body = getBody();
    $rows = $body['rows'] ?? [];
    if (empty($rows)) err('Data kosong');

    $stmt = $db->prepare('INSERT INTO siswa (nama_lengkap, nisn, kelas, jenis_kelamin, tahun_pelajaran, status_kelulusan)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            nama_lengkap = VALUES(nama_lengkap),
            kelas = VALUES(kelas),
            jenis_kelamin = VALUES(jenis_kelamin),
            tahun_pelajaran = VALUES(tahun_pelajaran),
            status_kelulusan = VALUES(status_kelulusan)
    ');

    $db->beginTransaction();
    foreach ($rows as $r) {
        $stmt->execute([
            $r['nama_lengkap'],
            $r['nisn'],
            $r['kelas'],
            $r['jenis_kelamin'],
            $r['tahun_pelajaran'],
            $r['status_kelulusan'] ?? 'Lulus',
        ]);
    }
    $db->commit();
    ok(['imported' => count($rows)]);
}

if ($method === 'POST') {
    requireAdmin();
    $body = getBody();
    $stmt = $db->prepare('INSERT INTO siswa (nama_lengkap, nisn, kelas, jenis_kelamin, tahun_pelajaran, status_kelulusan)
        VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $body['nama_lengkap'],
        $body['nisn'],
        $body['kelas'],
        $body['jenis_kelamin'],
        $body['tahun_pelajaran'],
        $body['status_kelulusan'] ?? 'Lulus',
    ]);
    ok(['id' => $db->lastInsertId()]);
}

if ($method === 'PUT' && $id) {
    requireAdmin();
    $body = getBody();
    $stmt = $db->prepare('UPDATE siswa SET nama_lengkap=?, nisn=?, kelas=?, jenis_kelamin=?, tahun_pelajaran=?, status_kelulusan=? WHERE id=?');
    $stmt->execute([
        $body['nama_lengkap'],
        $body['nisn'],
        $body['kelas'],
        $body['jenis_kelamin'],
        $body['tahun_pelajaran'],
        $body['status_kelulusan'],
        $id,
    ]);
    ok(['updated' => $stmt->rowCount()]);
}

if ($method === 'DELETE' && $id === 'all') {
    requireAdmin();
    $db->exec('TRUNCATE TABLE siswa');
    ok(['message' => 'Semua data dihapus']);
}

if ($method === 'DELETE' && $id) {
    requireAdmin();
    $stmt = $db->prepare('DELETE FROM siswa WHERE id = ?');
    $stmt->execute([$id]);
    ok(['deleted' => $stmt->rowCount()]);
}

err('Not found', 404);
