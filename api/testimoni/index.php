<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$db     = getDB();

if ($method === 'GET') {
    $adminMode = !empty($_SESSION['admin']);
    $where     = ['1=1'];
    $params    = [];

    if ($adminMode && isset($_GET['is_approved'])) {
        $where[]  = 'is_approved = ?';
        $params[] = (int)$_GET['is_approved'];
    } elseif (!$adminMode || !isset($_GET['show_all'])) {
        $where[] = 'is_approved = 1';
    }

    if (!empty($_GET['q'])) {
        $where[]  = '(nama LIKE ? OR isi LIKE ? OR nisn LIKE ?)';
        $q        = '%' . $_GET['q'] . '%';
        $params[] = $q;
        $params[] = $q;
        $params[] = $q;
    }

    $sort = ($_GET['sort'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
    $sql  = 'SELECT * FROM testimoni WHERE ' . implode(' AND ', $where) . " ORDER BY created_at $sort";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    ok($stmt->fetchAll());
}

if ($method === 'POST' && ($_GET['action'] ?? '') === 'approve') {
    requireAdmin();

    $body     = getBody();
    $ids      = $body['ids'] ?? [];
    $approved = (int)($body['is_approved'] ?? 1);

    if (empty($ids)) err('IDs diperlukan');

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt         = $db->prepare("UPDATE testimoni SET is_approved = ? WHERE id IN ($placeholders)");
    $stmt->execute([$approved, ...$ids]);
    ok(['updated' => $stmt->rowCount()]);
}

if ($method === 'POST' && ($_GET['action'] ?? '') === 'bulk-delete') {
    requireAdmin();

    $body = getBody();
    $ids  = $body['ids'] ?? [];

    if (empty($ids)) err('IDs diperlukan');

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt         = $db->prepare("DELETE FROM testimoni WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    ok(['deleted' => $stmt->rowCount()]);
}

if ($method === 'POST') {
    $body = getBody();
    if (empty($body['nama']) || empty($body['isi'])) err('Nama dan isi diperlukan');

    $stmt = $db->prepare('INSERT INTO testimoni (nama, nisn, isi, is_approved) VALUES (?, ?, ?, 0)');
    $stmt->execute([$body['nama'], $body['nisn'] ?? null, $body['isi']]);
    ok(['id' => $db->lastInsertId()]);
}

if ($method === 'PUT' && isset($_GET['id'])) {
    requireAdmin();

    $body = getBody();
    if (empty($body['isi'])) err('Isi diperlukan');

    $stmt = $db->prepare('UPDATE testimoni SET nama = ?, isi = ? WHERE id = ?');
    $stmt->execute([$body['nama'], $body['isi'], $_GET['id']]);
    ok(['updated' => $stmt->rowCount()]);
}

if ($method === 'DELETE' && isset($_GET['id'])) {
    requireAdmin();

    $stmt = $db->prepare('DELETE FROM testimoni WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    ok(['deleted' => $stmt->rowCount()]);
}

err('Not found', 404);
