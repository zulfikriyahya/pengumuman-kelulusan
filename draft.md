# Project Files

.
├── api
│   ├── album
│   │   └── index.php
│   ├── auth
│   │   └── index.php
│   ├── config
│   │   └── db.php
│   ├── guru
│   │   └── index.php
│   ├── informasi
│   │   └── index.php
│   ├── pengumuman
│   │   └── index.php
│   ├── router.php
│   ├── setup.php
│   ├── siswa
│   │   └── index.php
│   └── testimoni
│       └── index.php
├── astro.config.mjs
├── database
│   └── schema.sql
├── package.json
├── public
│   ├── favicon.png
│   ├── favicon.svg
│   ├── icons
│   │   ├── 192x192.png
│   │   └── 512x512.png
│   ├── manifest.json
│   ├── sw.js
│   └── template_import_siswa.csv
├── setup.sh
├── src
│   ├── layouts
│   │   └── Layout.astro
│   ├── pages
│   │   ├── admin
│   │   │   └── index.astro
│   │   └── index.astro
│   └── styles
│       └── global.css
├── tsconfig.json
└── uploads
    ├── album
    │   └── album_69b27a062bfae.png
    ├── guru
    │   └── guru_69b27948375f7.png
    └── informasi
        ├── file
        └── foto
            └── info_foto_69b28137669f1.png

24 directories, 29 files

# File Contents

## ./pnpm-workspace.yaml

```
allowBuilds:
  esbuild: true
  sharp: true

```
---

## ./public/sw.js

```javascript
// public/sw.js
const CACHE_NAME = "presensi-rfid-v1";
const OFFLINE_URL = "/";

self.addEventListener("install", (event) => {
  self.skipWaiting(); // Langsung aktifkan SW baru
});

self.addEventListener("activate", (event) => {
  event.waitUntil(clients.claim()); // Ambil alih kontrol klien segera
});

self.addEventListener("fetch", (event) => {
  // Strategi: Network Only (Karena ini aplikasi realtime presensi)
  // Kita tidak ingin meng-cache request API presensi.
  // Jika offline, browser akan menangani fallback lewat manifest.
  event.respondWith(fetch(event.request));
});

```
---

## ./public/manifest.json

```json
{
  "name": "Sistem Presensi RFID",
  "short_name": "Presensi RFID",
  "description": "Aplikasi Presensi RFID Sekolah dan Sholat",
  "start_url": "/",
  "display": "standalone",
  "background_color": "#0f172a",
  "theme_color": "#0f172a",
  "orientation": "portrait",
  "icons": [
    {
      "src": "/icons/192x192.png",
      "sizes": "192x192",
      "type": "image/png"
    },
    {
      "src": "/icons/512x512.png",
      "sizes": "512x512",
      "type": "image/png"
    }
  ]
}

```
---

## ./public/template_import_siswa.csv

```
nama_lengkap,nisn,kelas,jenis_kelamin,tahun_pelajaran,status_kelulusan
Ahmad Fauzan,1234567890,IX-A,L,2024/2025,Lulus
Siti Aisyah,0987654321,IX-B,P,2024/2025,Lulus
Budi Santoso,1122334455,IX-A,L,2024/2025,Tidak Lulus
Dewi Rahayu,2233445566,IX-B,P,2024/2025,Lulus
Eko Prasetyo,3344556677,IX-C,L,2024/2025,Lulus
Fitri Handayani,4455667788,IX-C,P,2024/2025,Lulus Bersyarat
Galih Permana,5566778899,IX-A,L,2024/2025,Lulus
Hana Safitri,6677889900,IX-B,P,2024/2025,Lulus
Irfan Maulana,7788990011,IX-D,L,2024/2025,Lulus
Jihan Aulia,8899001122,IX-D,P,2024/2025,Lulus
Kurniawan,9900112233,IX-A,L,2024/2025,Tidak Lulus
Laila Nur,0011223344,IX-B,P,2024/2025,Lulus
Muhammad Rizki,1122334456,IX-C,L,2024/2025,Lulus
Nadia Putri,2233445567,IX-C,P,2024/2025,Lulus
Oki Setiawan,3344556678,IX-D,L,2024/2025,Lulus Bersyarat
Putri Maharani,4455667789,IX-A,P,2024/2025,Lulus
Qomar Hidayat,5566778890,IX-B,L,2024/2025,Lulus
Rini Astuti,6677889901,IX-D,P,2024/2025,Lulus
Surya Dinata,7788990012,IX-A,L,2024/2025,Lulus
Tari Wulandari,8899001123,IX-C,P,2024/2025,Tidak Lulus
Umar Faruq,9900112234,IX-B,L,2024/2025,Lulus
Vina Melinda,0011223345,IX-D,P,2024/2025,Lulus
Wahyu Hidayat,1122334457,IX-A,L,2024/2025,Lulus
Xenia Putri,2233445568,IX-C,P,2024/2025,Lulus Bersyarat
Yusuf Aditya,3344556679,IX-B,L,2024/2025,Lulus
Zahira Salsabila,4455667790,IX-D,P,2024/2025,Lulus
Abdul Hafiz,5566778891,IX-A,L,2024/2025,Lulus
Bella Anggraini,6677889902,IX-B,P,2024/2025,Lulus
Candra Wijaya,7788990013,IX-C,L,2024/2025,Tidak Lulus
Dina Fitriani,8899001124,IX-D,P,2024/2025,Lulus
Endra Kusuma,9900112235,IX-A,L,2024/2025,Lulus
Farah Nabila,0011223346,IX-B,P,2024/2025,Lulus
Gilang Ramadhan,1122334458,IX-C,L,2024/2025,Lulus Bersyarat
Hasna Mutiara,2233445569,IX-D,P,2024/2025,Lulus
Ivan Prasetya,3344556680,IX-A,L,2024/2025,Lulus
Julia Rahmawati,4455667791,IX-B,P,2024/2025,Lulus
Khairul Anwar,5566778892,IX-C,L,2024/2025,Lulus
Lina Marlina,6677889903,IX-D,P,2024/2025,Tidak Lulus
Malik Ibrahim,7788990014,IX-A,L,2024/2025,Lulus
Nisa Aulia,8899001125,IX-B,P,2024/2025,Lulus
Oman Firdaus,9900112236,IX-C,L,2024/2025,Lulus
Prita Dewi,0011223347,IX-D,P,2024/2025,Lulus Bersyarat
Qisma Azzahra,1122334459,IX-A,P,2024/2025,Lulus
Reza Firmansyah,2233445570,IX-B,L,2024/2025,Lulus
Sari Indah,3344556681,IX-C,P,2024/2025,Lulus
Teguh Santoso,4455667792,IX-D,L,2024/2025,Tidak Lulus
Ulfa Khoiriyah,5566778893,IX-A,P,2024/2025,Lulus
Vicky Pranata,6677889904,IX-B,L,2024/2025,Lulus
Weni Oktaviani,7788990015,IX-C,P,2024/2025,Lulus
Xander Putra,8899001126,IX-D,L,2024/2025,Lulus
Yasmin Azzahra,9900112237,IX-A,P,2024/2025,Lulus Bersyarat
Zaki Mubarok,0011223348,IX-B,L,2024/2025,Lulus
Aulia Rahma,1122334460,IX-C,P,2024/2025,Lulus
Bagas Saputra,2233445571,IX-D,L,2024/2025,Lulus
Cahya Ningrum,3344556682,IX-A,P,2024/2025,Tidak Lulus
Daffa Ardiansyah,4455667793,IX-B,L,2024/2025,Lulus
Elsa Permatasari,5566778894,IX-C,P,2024/2025,Lulus
Farhan Syaputra,6677889905,IX-D,L,2024/2025,Lulus
Gita Puspita,7788990016,IX-A,P,2024/2025,Lulus
Hendra Kurniawan,8899001127,IX-B,L,2024/2025,Lulus Bersyarat
Ika Nurhaliza,9900112238,IX-C,P,2024/2025,Lulus
Joko Widodo,0011223349,IX-D,L,2024/2025,Lulus
Karina Dewi,1122334461,IX-A,P,2024/2025,Lulus
Luthfi Hakim,2233445572,IX-B,L,2024/2025,Tidak Lulus
Mega Sari,3344556683,IX-C,P,2024/2025,Lulus
Nando Pratama,4455667794,IX-D,L,2024/2025,Lulus
Oktavia Putri,5566778895,IX-A,P,2024/2025,Lulus
Panji Nugroho,6677889906,IX-B,L,2024/2025,Lulus
Qonita Amalia,7788990017,IX-C,P,2024/2025,Lulus Bersyarat
Rangga Putra,8899001128,IX-D,L,2024/2025,Lulus
Silvia Anggraeni,9900112239,IX-A,P,2024/2025,Lulus
Taufik Hidayat,0011223350,IX-B,L,2024/2025,Lulus
Umi Kalsum,1122334462,IX-C,P,2024/2025,Tidak Lulus
Vino Bastian,2233445573,IX-D,L,2024/2025,Lulus
Wulan Sari,3344556684,IX-A,P,2024/2025,Lulus
Xiomara Putri,4455667795,IX-B,P,2024/2025,Lulus
Yoga Pratama,5566778896,IX-C,L,2024/2025,Lulus
Zahra Kamila,6677889907,IX-D,P,2024/2025,Lulus Bersyarat
Arif Budiman,7788990018,IX-A,L,2024/2025,Lulus
Bella Safira,8899001129,IX-B,P,2024/2025,Lulus
Ciko Mardika,9900112240,IX-C,L,2024/2025,Tidak Lulus
Diana Kusuma,0011223351,IX-D,P,2024/2025,Lulus
Evan Dwi,1122334463,IX-A,L,2024/2025,Lulus
Fanny Rahayu,2233445574,IX-B,P,2024/2025,Lulus
Guntur Prabowo,3344556685,IX-C,L,2024/2025,Lulus
Hesti Wulandari,4455667796,IX-D,P,2024/2025,Lulus Bersyarat
Imam Syafi'i,5566778897,IX-A,L,2024/2025,Lulus
Jasmine Putri,6677889908,IX-B,P,2024/2025,Lulus
Kevin Ananda,7788990019,IX-C,L,2024/2025,Lulus
Lusiana Dewi,8899001130,IX-D,P,2024/2025,Tidak Lulus
Muharram Ali,9900112241,IX-A,L,2024/2025,Lulus
Nadia Khairunnisa,0011223352,IX-B,P,2024/2025,Lulus
Oscar Maulana,1122334464,IX-C,L,2024/2025,Lulus
Puspita Ayu,2233445575,IX-D,P,2024/2025,Lulus Bersyarat
Qodri Ananda,3344556686,IX-A,L,2024/2025,Lulus
Riska Amelia,4455667797,IX-B,P,2024/2025,Lulus
Satria Budi,5566778898,IX-C,L,2024/2025,Lulus
Tiara Anggun,6677889909,IX-D,P,2024/2025,Lulus

```
---

## ./database/schema.sql

```
CREATE DATABASE IF NOT EXISTS madrasah_kelulusan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE madrasah_kelulusan;

CREATE TABLE IF NOT EXISTS siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    nisn VARCHAR(20) NOT NULL UNIQUE,
    kelas VARCHAR(20) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tahun_pelajaran VARCHAR(10) NOT NULL,
    status_kelulusan ENUM('Lulus', 'Tidak Lulus', 'Lulus Bersyarat') NOT NULL DEFAULT 'Lulus',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pengumuman_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal_waktu DATETIME NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO pengumuman_config (tanggal_waktu, is_active)
VALUES (NOW(), 0)
ON DUPLICATE KEY UPDATE id = id;

CREATE TABLE IF NOT EXISTS album (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255),
    foto_path VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    jabatan VARCHAR(255),
    foto_path VARCHAR(500),
    kesan_pesan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS testimoni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    nisn VARCHAR(20),
    isi TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password)
VALUES ('admin', '$2y$12$placeholder_will_be_generated_on_setup');

```
---

## ./api/config/db.php

```
<?php

function loadEnv(string $path): void
{
    if (!file_exists($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$key, $val] = array_map('trim', explode('=', $line, 2));
        $_ENV[$key] = $val;
        putenv("$key=$val");
    }
}

loadEnv(__DIR__ . '/../.env');

function getDB(): PDO
{
    static $pdo = null;
    if ($pdo) return $pdo;

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $_ENV['DB_HOST'],
        $_ENV['DB_PORT'],
        $_ENV['DB_NAME']
    );

    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}

function setCorsHeaders(): void
{
    $origin = $_ENV['ALLOWED_ORIGIN'] ?? '*';
    header("Access-Control-Allow-Origin: $origin");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Allow-Credentials: true');
    header('Content-Type: application/json');

    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params([
            'lifetime' => 86400,
            'path'     => '/',
            'secure'   => false,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }
}

function json(mixed $data, int $code = 200): never
{
    http_response_code($code);
    echo json_encode($data);
    exit;
}

function ok(mixed $data): never
{
    json(['status' => 'success', 'data' => $data]);
}

function err(string $msg, int $code = 400): never
{
    json(['status' => 'error', 'message' => $msg], $code);
}

function getBody(): array
{
    return json_decode(file_get_contents('php://input'), true) ?? [];
}

function requireAdmin(): void
{
    if (empty($_SESSION['admin'])) {
        err('Unauthorized', 401);
    }
}

```
---

## ./api/informasi/index.php

```
<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$db = getDB();

if ($method === 'GET') {
    $adminMode = !empty($_SESSION['admin']);
    $sql = $adminMode
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
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $filename = uniqid('info_foto_') . '.' . $ext;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $dir . $filename)) {
            $fotoPath = $_ENV['PUBLIC_URL'] . 'informasi/foto/' . $filename;
        }
    }

    $filePath = null;
    $fileOrigName = null;
    if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $dir = $uploadBase . 'informasi/file/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        $filename = uniqid('info_file_') . '.' . $ext;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $dir . $filename)) {
            $filePath = $_ENV['PUBLIC_URL'] . 'informasi/file/' . $filename;
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

```
---

## ./api/setup.php

```
<?php
require_once __DIR__ . '/config/db.php';

$hash = password_hash($_ENV['ADMIN_PASSWORD'], PASSWORD_BCRYPT);
getDB()->prepare('UPDATE admin SET password = ? WHERE username = ?')
    ->execute([$hash, $_ENV['ADMIN_USERNAME']]);

echo 'Done. Hash: ' . $hash;

```
---

## ./api/siswa/index.php

```
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

```
---

## ./api/pengumuman/index.php

```
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

    $waktu = $body['tanggal_waktu'] ?? '';
    $aktif = (int)($body['is_active'] ?? 0);

    if (!$waktu) err('Tanggal waktu diperlukan');

    $stmt = $db->prepare('UPDATE pengumuman_config SET tanggal_waktu = ?, is_active = ? WHERE id = 1');
    $stmt->execute([$waktu, $aktif]);

    if ($stmt->rowCount() === 0) {
        $stmt = $db->prepare('INSERT INTO pengumuman_config (tanggal_waktu, is_active) VALUES (?, ?)');
        $stmt->execute([$waktu, $aktif]);
    }

    ok(['message' => 'Config disimpan']);
}

err('Not found', 404);

```
---

## ./api/.env

```
DB_HOST=localhost
DB_PORT=3306
DB_NAME=madrasah_kelulusan
DB_USER=root
DB_PASS=18012000

ADMIN_USERNAME=admin
ADMIN_PASSWORD=P@ssw0rd

UPLOAD_DIR=../uploads/
PUBLIC_URL=http://localhost:3000/uploads/

ALLOWED_ORIGIN=http://localhost:4321

```
---

## ./api/auth/index.php

```
<?php
require_once __DIR__ . '/../config/db.php';

setCorsHeaders();
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($method === 'POST' && $action === 'login') {
    $body = getBody();
    $username = trim($body['username'] ?? '');
    $password = $body['password'] ?? '';

    $db = getDB();
    $stmt = $db->prepare('SELECT * FROM admin WHERE username = ?');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if (!$admin || !password_verify($password, $admin['password'])) {
        err('Username atau password salah', 401);
    }

    $_SESSION['admin'] = $admin['id'];
    ok(['message' => 'Login berhasil']);
}

if ($method === 'POST' && $action === 'logout') {
    $_SESSION = [];
    session_destroy();
    ok(['message' => 'Logout berhasil']);
}

if ($method === 'GET' && $action === 'check') {
    ok(['authenticated' => !empty($_SESSION['admin'])]);
}

err('Not found', 404);

```
---

## ./api/guru/index.php

```
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

```
---

## ./api/album/index.php

```
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

    if (empty($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        err('File foto diperlukan atau upload gagal');
    }

    $uploadDir = realpath(__DIR__ . '/../../uploads/album') . '/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $filename = uniqid('album_') . '.' . $ext;
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
    $stmt = $db->prepare('SELECT foto_path FROM album WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($row) {
        $filename = basename($row['foto_path']);
        $filePath = realpath(__DIR__ . '/../../uploads/album') . '/' . $filename;
        if (is_file($filePath)) unlink($filePath);
    }

    $stmt = $db->prepare('DELETE FROM album WHERE id = ?');
    $stmt->execute([$id]);
    ok(['deleted' => $stmt->rowCount()]);
}

err('Not found', 404);

```
---

## ./api/router.php

```
<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = rtrim($uri, '/');

// Serve static files dari uploads/
if (str_starts_with($path, '/uploads/')) {

    $file = realpath(__DIR__ . '/..' . $path);
    if ($file && is_file($file) && str_starts_with($file, realpath(__DIR__ . '/../uploads'))) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png'         => 'image/png',
            'gif'         => 'image/gif',
            'webp'        => 'image/webp',
            default       => 'application/octet-stream',
        };
        header("Content-Type: $mime");
        header("Access-Control-Allow-Origin: *");
        readfile($file);
        exit;
    }
    http_response_code(404);
    exit;
}

// Route ke index.php endpoint
$file = __DIR__ . $path . '/index.php';

if (is_file($file)) {
    require $file;
} elseif (is_file(__DIR__ . $path)) {
    require __DIR__ . $path;
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Not found: ' . $path]);
}

```
---

## ./api/testimoni/index.php

```
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

if ($method === 'POST' && ($_GET['action'] ?? '') === 'bulk-delete') {
    requireAdmin();
    $body = getBody();
    $ids = $body['ids'] ?? [];
    if (empty($ids)) err('IDs diperlukan');

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $db->prepare("DELETE FROM testimoni WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    ok(['deleted' => $stmt->rowCount()]);
}

if ($method === 'POST') {
    $body = getBody();
    if (empty($body['nama']) || empty($body['isi'])) err('Nama dan isi diperlukan');

    $stmt = $db->prepare('INSERT INTO testimoni (nama, nisn, isi) VALUES (?, ?, ?)');
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

```
---

## ./.env

```
PUBLIC_API_BASE=http://localhost:3000

```
---

## ./astro.config.mjs

```javascript
// @ts-check
import { defineConfig } from "astro/config";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  vite: {
    plugins: [tailwindcss()],
    server: {
      proxy: {
        "/api": {
          target: "http://localhost:3000",
          changeOrigin: true,
          rewrite: (path) => path.replace(/^\/api/, ""),
        },
      },
    },
  },
});

```
---

## ./src/layouts/Layout.astro

```html
---
import "../styles/global.css";

interface Props {
  title: string;
  description?: string;
}

const { title, description = "Pengumuman Kelulusan Madrasah Universe" } = Astro.props;

const APP_NAME = "Madrasah Universe";
const THEME_COLOR = "#0f172a";
---

<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover"
    />
    <meta name="description" content={description} />
    <meta name="theme-color" content={THEME_COLOR} />
    <meta name="color-scheme" content="dark" />

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json" />

    <!-- iOS PWA -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-title" content={APP_NAME} />
    <link rel="apple-touch-icon" href="/icons/192x192.png" />

    <!-- Open Graph -->
    <meta property="og:title" content={title} />
    <meta property="og:description" content={description} />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="/icons/512x512.png" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/192x192.png" />

    <!-- Font: Lexend via Google Fonts dengan preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap"
    />

    <title>{title}</title>
  </head>

  <body
    class="bg-slate-900 text-slate-50 font-['Lexend'] overflow-x-hidden select-none antialiased"
  >
    <slot />

    <script>
      if ("serviceWorker" in navigator) {
        window.addEventListener("load", () => {
          navigator.serviceWorker.register("/sw.js").catch(() => {});
        });
      }
    </script>
  </body>
</html>

<style is:global>
  * {
    -webkit-tap-highlight-color: transparent;
    box-sizing: border-box;
  }

  :root {
    --safe-bottom: env(safe-area-inset-bottom);
  }

  html {
    scroll-behavior: smooth;
  }

  /* Scrollbar tipis untuk panel admin */
  ::-webkit-scrollbar {
    width: 4px;
    height: 4px;
  }
  ::-webkit-scrollbar-track {
    background: transparent;
  }
  ::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 2px;
  }

  /* Transisi section publik */
  .section {
    animation: fadeIn 0.2s ease;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(6px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

```
---

## ./src/styles/global.css

```css
@import "tailwindcss";

@reference "tailwindcss";

@layer components {
  .inp {
    @apply bg-slate-700/60 border border-white/10 rounded-xl px-4 py-2.5 text-sm
           focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full;
  }

  .tab-btn {
    @apply whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-400
           border-b-2 border-transparent hover:text-white transition-colors;
  }

  .tab-btn.active {
    @apply text-indigo-400 border-indigo-500;
  }

  .nav-btn {
    @apply flex-1 flex flex-col items-center justify-center py-3 gap-0.5
           text-slate-500 transition-colors;
  }

  .nav-btn.active {
    @apply text-indigo-400;
  }

  .section {
    animation: fadeIn 0.2s ease;
  }

  .safe-bottom {
    padding-bottom: env(safe-area-inset-bottom);
  }
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(6px); }
  to   { opacity: 1; transform: translateY(0); }
}

```
---

## ./src/pages/admin/index.astro

```html
---
import Layout from "../../layouts/Layout.astro";
const API = import.meta.env.PUBLIC_API_BASE;
---

<Layout title="Admin — Madrasah Universe">
  <div class="min-h-screen bg-slate-950 text-slate-100 font-['Lexend']">
    <!-- LOGIN SCREEN -->
    <div id="loginScreen" class="min-h-screen flex items-center justify-center p-4">
      <div
        class="bg-slate-800/80 backdrop-blur border border-white/10 rounded-3xl p-8 w-full max-w-sm shadow-2xl"
      >
        <h1 class="text-2xl font-bold text-center mb-1">Admin Panel</h1>
        <p class="text-slate-400 text-sm text-center mb-6">Madrasah Universe</p>
        <div class="space-y-3">
          <input
            id="loginUser"
            type="text"
            placeholder="Username"
            class="w-full bg-slate-700/60 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
          />
          <input
            id="loginPass"
            type="password"
            placeholder="Password"
            class="w-full bg-slate-700/60 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
          />
          <div id="loginErr" class="text-red-400 text-xs hidden text-center"></div>
          <button
            id="btnLogin"
            class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-semibold transition-all active:scale-95"
            >Masuk</button
          >
        </div>
      </div>
    </div>

    <!-- DASHBOARD -->
    <div id="dashboard" class="hidden">
      <!-- TOPBAR -->
      <header
        class="bg-slate-900 border-b border-white/10 px-4 py-3 flex items-center justify-between sticky top-0 z-30"
      >
        <h1 class="font-bold text-base">Admin Panel</h1>
        <div class="flex items-center gap-3">
          <span class="text-slate-400 text-xs hidden sm:block">Madrasah Universe</span>
          <button
            id="btnLogout"
            class="text-xs text-red-400 hover:text-red-300 border border-red-400/30 px-3 py-1.5 rounded-lg transition"
            >Logout</button
          >
        </div>
      </header>

      <!-- TAB NAV -->
      <nav
        class="bg-slate-900 border-b border-white/10 px-4 flex gap-1 overflow-x-auto sticky top-[53px] z-20"
      >
        {
          [
            { id: "siswa", label: "Data Siswa" },
            { id: "pengumuman", label: "Pengumuman" },
            { id: "album", label: "Album Foto" },
            { id: "guru", label: "Guru & Pegawai" },
            { id: "testimoni", label: "Testimoni" },
            { id: "informasi", label: "Informasi" },
          ].map((t) => (
            <button
              data-tab={t.id}
              class="tab-btn whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-400 border-b-2 border-transparent hover:text-white transition-colors"
            >
              {t.label}
            </button>
          ))
        }
      </nav>

      <!-- PANEL: SISWA -->
      <section id="tab-siswa" class="tab-panel p-4 max-w-7xl mx-auto">
        <div class="flex flex-wrap gap-3 mb-4">
          <input
            id="searchSiswa"
            type="text"
            placeholder="Cari nama / NISN..."
            class="flex-1 min-w-[180px] bg-slate-800 border border-white/10 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
          />
          <select
            id="filterKelas"
            class="bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm"
            ><option value="">Semua Kelas</option></select
          >
          <select
            id="filterJK"
            class="bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm"
          >
            <option value="">Semua JK</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
          <select
            id="filterStatus"
            class="bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm"
          >
            <option value="">Semua Status</option>
            <option>Lulus</option>
            <option>Tidak Lulus</option>
            <option>Lulus Bersyarat</option>
          </select>
          <select
            id="filterTP"
            class="bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm"
            ><option value="">Semua Tahun</option></select
          >
        </div>

        <div class="flex flex-wrap gap-2 mb-4">
          <button
            id="btnTambahSiswa"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-xl text-sm font-semibold transition active:scale-95"
            >+ Tambah</button
          >
          <label
            class="px-4 py-2 bg-emerald-700 hover:bg-emerald-600 rounded-xl text-sm font-semibold transition cursor-pointer active:scale-95"
          >
            Import CSV <input type="file" id="csvInput" accept=".csv" class="hidden" />
          </label>
          <button
            id="btnHapusSemua"
            class="px-4 py-2 bg-red-700/60 hover:bg-red-600 rounded-xl text-sm font-semibold transition active:scale-95"
            >Hapus Semua</button
          >
          <span id="siswaCount" class="ml-auto text-slate-400 text-sm self-center"></span>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/10">
          <table class="w-full text-sm">
            <thead class="bg-slate-800 text-slate-400 text-xs uppercase">
              <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">NISN</th>
                <th class="px-4 py-3 text-left">Kelas</th>
                <th class="px-4 py-3 text-left">JK</th>
                <th class="px-4 py-3 text-left">Tahun</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody id="siswaBody" class="divide-y divide-white/5"></tbody>
          </table>
        </div>
      </section>

      <!-- PANEL: PENGUMUMAN -->
      <section id="tab-pengumuman" class="tab-panel hidden p-4 max-w-lg mx-auto">
        <div class="bg-slate-800/60 border border-white/10 rounded-2xl p-6 space-y-4">
          <h2 class="font-bold text-lg">Konfigurasi Pengumuman</h2>
          <div>
            <label class="text-slate-400 text-xs mb-1 block">Tanggal & Waktu Pengumuman</label>
            <input
              id="inputWaktu"
              type="datetime-local"
              class="w-full bg-slate-700/60 border border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
          </div>
          <label class="flex items-center gap-3 cursor-pointer">
            <div class="relative">
              <input type="checkbox" id="inputAktif" class="sr-only" />
              <div id="toggleBg" class="w-11 h-6 bg-slate-600 rounded-full transition-colors"></div>
              <div
                id="toggleDot"
                class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full transition-transform"
              >
              </div>
            </div>
            <span class="text-sm">Aktifkan pengumuman</span>
          </label>
          <button
            id="btnSavePengumuman"
            class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-semibold transition active:scale-95"
            >Simpan</button
          >
          <p id="pengumumanMsg" class="text-center text-sm hidden"></p>
        </div>
      </section>

      <!-- PANEL: ALBUM -->
      <section id="tab-album" class="tab-panel hidden p-4 max-w-5xl mx-auto">
        <div class="mb-4 flex items-center gap-3">
          <label
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-xl text-sm font-semibold cursor-pointer transition active:scale-95"
          >
            + Upload Foto <input
              type="file"
              id="albumInput"
              accept="image/*"
              multiple
              class="hidden"
            />
          </label>
          <input
            id="albumJudul"
            type="text"
            placeholder="Judul (opsional)"
            class="flex-1 bg-slate-800 border border-white/10 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
          />
          <button
            id="btnUploadAlbum"
            class="px-4 py-2 bg-emerald-700 hover:bg-emerald-600 rounded-xl text-sm font-semibold transition active:scale-95"
            >Upload</button
          >
        </div>
        <div id="albumGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3"></div>
      </section>

      <!-- PANEL: GURU -->
      <section id="tab-guru" class="tab-panel hidden p-4 max-w-5xl mx-auto">
        <div class="flex flex-wrap gap-2 mb-4">
          <button
            id="btnTambahGuru"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-xl text-sm font-semibold transition active:scale-95"
            >+ Tambah</button
          >
          <button
            id="btnImportGuru"
            class="px-4 py-2 bg-emerald-700 hover:bg-emerald-600 rounded-xl text-sm font-semibold transition active:scale-95"
            >Import</button
          >
        </div>
        <div id="guruGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"></div>
      </section>

      <!-- PANEL: TESTIMONI -->
      <section id="tab-testimoni" class="tab-panel hidden p-4 max-w-4xl mx-auto">
        <div class="flex gap-2 mb-4">
          <button
            id="btnBulkDeleteTestimoni"
            class="px-4 py-2 bg-red-700/60 hover:bg-red-600 rounded-xl text-sm font-semibold transition active:scale-95 hidden"
            >Hapus Terpilih</button
          >
          <span id="testimoniSelectedCount" class="text-slate-400 text-sm self-center hidden"
          ></span>
        </div>
        <div id="testimoniList" class="space-y-3"></div>
      </section>
      <!-- PANEL: INFORMASI -->
      <section id="tab-informasi" class="tab-panel hidden p-4 max-w-4xl mx-auto">
        <button
          id="btnTambahInfo"
          class="mb-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-xl text-sm font-semibold transition active:scale-95"
          >+ Tambah Informasi</button
        >
        <div id="infoList" class="space-y-3"></div>
      </section>
    </div>

    <!-- /dashboard -->

    <!-- MODAL SISWA -->
    <div
      id="modalSiswa"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm hidden p-4"
    >
      <div class="bg-slate-800 border border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <h3 id="modalSiswaTitle" class="font-bold text-lg mb-4">Tambah Siswa</h3>
        <div class="space-y-3">
          <input id="fNama" type="text" placeholder="Nama Lengkap" class="inp w-full" />
          <input id="fNisn" type="text" placeholder="NISN" class="inp w-full" />
          <input id="fKelas" type="text" placeholder="Kelas (contoh: IX-A)" class="inp w-full" />
          <select id="fJK" class="inp w-full">
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
          <input
            id="fTP"
            type="text"
            placeholder="Tahun Pelajaran (contoh: 2024/2025)"
            class="inp w-full"
          />
          <select id="fStatus" class="inp w-full">
            <option>Lulus</option>
            <option>Tidak Lulus</option>
            <option>Lulus Bersyarat</option>
          </select>
        </div>
        <div class="flex gap-3 mt-5">
          <button
            id="btnSimpanSiswa"
            class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-semibold transition"
            >Simpan</button
          >
          <button
            id="btnBatalSiswa"
            class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 rounded-xl font-semibold transition"
            >Batal</button
          >
        </div>
      </div>
    </div>

    <!-- MODAL GURU -->
    <div
      id="modalGuru"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm hidden p-4"
    >
      <div class="bg-slate-800 border border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <h3 class="font-bold text-lg mb-4">Tambah Guru / Pegawai</h3>
        <div class="space-y-3">
          <input id="gNama" type="text" placeholder="Nama" class="inp w-full" />
          <input id="gJabatan" type="text" placeholder="Jabatan" class="inp w-full" />
          <textarea id="gKesan" placeholder="Kesan & Pesan" rows="3" class="inp w-full resize-none"
          ></textarea>
          <label class="block text-slate-400 text-xs">Foto</label>
          <input id="gFoto" type="file" accept="image/*" class="text-sm text-slate-300" />
        </div>
        <div class="flex gap-3 mt-5">
          <button
            id="btnSimpanGuru"
            class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-semibold transition"
            >Simpan</button
          >
          <button
            id="btnBatalGuru"
            class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 rounded-xl font-semibold transition"
            >Batal</button
          >
        </div>
      </div>
    </div>

    <!-- MODAL IMPORT GURU -->
    <div
      id="modalImportGuru"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm hidden p-4"
    >
      <div
        class="bg-slate-800 border border-white/10 rounded-2xl p-6 w-full max-w-2xl shadow-2xl max-h-[90dvh] flex flex-col"
      >
        <h3 class="font-bold text-lg mb-4 flex-shrink-0">Import Guru / Pegawai</h3>
        <p class="text-slate-400 text-xs mb-3 flex-shrink-0">
          Isi data di bawah. Foto bersifat opsional per baris.
        </p>

        <div class="overflow-y-auto flex-1 space-y-3 pr-1" id="importGuruRows"></div>

        <div class="flex gap-3 mt-4 flex-shrink-0">
          <button
            id="btnTambahRowGuru"
            class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-xl text-sm font-semibold transition"
            >+ Baris</button
          >
          <button
            id="btnKirimImportGuru"
            class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-semibold transition"
            >Import</button
          >
          <button
            id="btnBatalImportGuru"
            class="px-4 py-2.5 bg-slate-700 hover:bg-slate-600 rounded-xl font-semibold transition"
            >Batal</button
          >
        </div>
      </div>
    </div>

    <!-- MODAL EDIT TESTIMONI -->
    <div
      id="modalTestimoni"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm hidden p-4"
    >
      <div class="bg-slate-800 border border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <h3 class="font-bold text-lg mb-4">Edit Testimoni</h3>
        <div class="space-y-3">
          <input id="etNama" type="text" placeholder="Nama" class="inp w-full" />
          <textarea
            id="etIsi"
            rows="4"
            placeholder="Isi testimoni..."
            class="inp w-full resize-none"></textarea>
        </div>
        <div class="flex gap-3 mt-5">
          <button
            id="btnSimpanTestimoni"
            class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-semibold transition"
            >Simpan</button
          >
          <button
            id="btnBatalTestimoni"
            class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 rounded-xl font-semibold transition"
            >Batal</button
          >
        </div>
      </div>
    </div>
    <!-- MODAL INFORMASI -->
    <div
      id="modalInfo"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm hidden p-4"
    >
      <div
        class="bg-slate-800 border border-white/10 rounded-2xl p-6 w-full max-w-lg shadow-2xl max-h-[90dvh] overflow-y-auto"
      >
        <h3 id="modalInfoTitle" class="font-bold text-lg mb-4">Tambah Informasi</h3>
        <div class="space-y-3">
          <input id="iJudul" type="text" placeholder="Judul *" class="inp w-full" />
          <textarea
            id="iIsi"
            rows="4"
            placeholder="Isi / deskripsi (opsional)"
            class="inp w-full resize-none"></textarea>
          <div>
            <label class="text-slate-400 text-xs block mb-1">Foto (opsional)</label>
            <input id="iFoto" type="file" accept="image/*" class="text-sm text-slate-300" />
            <input
              id="iFotoCaption"
              type="text"
              placeholder="Caption foto"
              class="inp w-full mt-2"
            />
          </div>
          <div>
            <label class="text-slate-400 text-xs block mb-1">File attachment (PDF, dll)</label>
            <input
              id="iFile"
              type="file"
              accept=".pdf,.doc,.docx,.xls,.xlsx"
              class="text-sm text-slate-300"
            />
          </div>
          <input id="iLink" type="url" placeholder="Link eksternal (opsional)" class="inp w-full" />
          <label class="flex items-center gap-2 cursor-pointer text-sm">
            <input type="checkbox" id="iPublished" checked class="w-4 h-4 accent-indigo-500" />
            Tampilkan ke publik
          </label>
        </div>
        <div class="flex gap-3 mt-5">
          <button
            id="btnSimpanInfo"
            class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-semibold transition"
            >Simpan</button
          >
          <button
            id="btnBatalInfo"
            class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-600 rounded-xl font-semibold transition"
            >Batal</button
          >
        </div>
      </div>
    </div>
    <!-- TOAST -->
    <div id="toast" class="fixed bottom-6 right-6 z-[100] hidden">
      <div
        id="toastMsg"
        class="bg-slate-700 border border-white/10 text-sm px-5 py-3 rounded-xl shadow-xl"
      >
      </div>
    </div>
  </div>
</Layout>

<script define:vars={{ API }}>
  const BASE = API.replace(/\/+$/, "");
  const SISWA_URL = `${BASE}/siswa/`;
  const PENGUMUMAN_URL = `${BASE}/pengumuman/`;
  const ALBUM_URL = `${BASE}/album/`;
  const GURU_URL = `${BASE}/guru/`;
  const TESTIMONI_URL = `${BASE}/testimoni/`;
  const AUTH_URL = `${BASE}/auth/`;
  const INFO_URL = `${BASE}/informasi/`;

  // ---- TOAST ----
  function toast(msg, ok = true) {
    const el = document.getElementById("toast");
    const msg_el = document.getElementById("toastMsg");
    msg_el.textContent = msg;
    msg_el.className = `px-5 py-3 rounded-xl shadow-xl text-sm border ${ok ? "bg-emerald-800 border-emerald-500/40 text-emerald-100" : "bg-red-800 border-red-500/40 text-red-100"}`;
    el.classList.remove("hidden");
    clearTimeout(el._t);
    el._t = setTimeout(() => el.classList.add("hidden"), 3000);
  }

  // ---- AUTH ----
  async function checkAuth() {
    const res = await fetch(`${AUTH_URL}?action=check`, { credentials: "include" });
    const j = await res.json();
    return j.data?.authenticated;
  }

  async function login() {
    const username = document.getElementById("loginUser").value.trim();
    const password = document.getElementById("loginPass").value;
    const errEl = document.getElementById("loginErr");
    errEl.classList.add("hidden");

    const res = await fetch(`${AUTH_URL}?action=login`, {
      method: "POST",
      credentials: "include",
      body: JSON.stringify({ username, password }),
      headers: { "Content-Type": "application/json" },
    });
    const j = await res.json();
    if (j.status === "success") {
      showDashboard();
    } else {
      errEl.textContent = j.message;
      errEl.classList.remove("hidden");
    }
  }

  async function logout() {
    await fetch(`${AUTH_URL}?action=logout`, { method: "POST", credentials: "include" });
    document.getElementById("dashboard").classList.add("hidden");
    document.getElementById("loginScreen").classList.remove("hidden");
  }

  function showDashboard() {
    document.getElementById("loginScreen").classList.add("hidden");
    document.getElementById("dashboard").classList.remove("hidden");
    initTabs();
    loadSiswa();
  }

  // ---- TABS ----
  function initTabs() {
    const tabs = document.querySelectorAll(".tab-btn");
    tabs.forEach((btn) => {
      btn.addEventListener("click", () => {
        tabs.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
        document.querySelectorAll(".tab-panel").forEach((p) => p.classList.add("hidden"));
        const panel = document.getElementById(`tab-${btn.dataset.tab}`);
        panel.classList.remove("hidden");

        const loaders = {
          pengumuman: loadPengumuman,
          album: loadAlbum,
          guru: loadGuru,
          testimoni: loadTestimoni,
          informasi: loadInformasi,
        };
        loaders[btn.dataset.tab]?.();
      });
    });
    tabs[0].click();
  }

  // ---- SISWA ----
  let siswaData = [];
  let editSiswaId = null;

  async function loadSiswa() {
    const q = document.getElementById("searchSiswa").value;
    const kelas = document.getElementById("filterKelas").value;
    const jk = document.getElementById("filterJK").value;
    const status = document.getElementById("filterStatus").value;
    const tp = document.getElementById("filterTP").value;

    const params = new URLSearchParams({
      q,
      kelas,
      jenis_kelamin: jk,
      status_kelulusan: status,
      tahun_pelajaran: tp,
    });
    const res = await fetch(`${SISWA_URL}?${params}`, { credentials: "include" });
    const j = await res.json();
    siswaData = j.data ?? [];

    populateFilters(siswaData);
    renderSiswaTable(siswaData);
    document.getElementById("siswaCount").textContent = `${siswaData.length} data`;
  }

  function populateFilters(data) {
    const kelasSet = [...new Set(data.map((d) => d.kelas))].sort();
    const tpSet = [...new Set(data.map((d) => d.tahun_pelajaran))].sort().reverse();

    const fKelas = document.getElementById("filterKelas");
    const fTP = document.getElementById("filterTP");
    const curKelas = fKelas.value;
    const curTP = fTP.value;

    fKelas.innerHTML =
      '<option value="">Semua Kelas</option>' +
      kelasSet.map((k) => `<option ${k === curKelas ? "selected" : ""}>${k}</option>`).join("");
    fTP.innerHTML =
      '<option value="">Semua Tahun</option>' +
      tpSet.map((t) => `<option ${t === curTP ? "selected" : ""}>${t}</option>`).join("");
  }

  function statusBadge(s) {
    const map = {
      Lulus: "bg-emerald-500/20 text-emerald-300",
      "Tidak Lulus": "bg-red-500/20 text-red-300",
      "Lulus Bersyarat": "bg-amber-500/20 text-amber-300",
    };
    return `<span class="text-xs px-2 py-0.5 rounded-full font-medium ${map[s] ?? ""}">${s}</span>`;
  }

  function renderSiswaTable(data) {
    const tbody = document.getElementById("siswaBody");
    if (!data.length) {
      tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8 text-slate-500">Tidak ada data</td></tr>`;
      return;
    }
    tbody.innerHTML = data
      .map(
        (s) => `
      <tr class="hover:bg-white/5 transition-colors">
        <td class="px-4 py-3 font-medium">${s.nama_lengkap}</td>
        <td class="px-4 py-3 text-slate-400 font-mono text-xs">${s.nisn}</td>
        <td class="px-4 py-3">${s.kelas}</td>
        <td class="px-4 py-3">${s.jenis_kelamin === "L" ? "L" : "P"}</td>
        <td class="px-4 py-3 text-slate-400 text-xs">${s.tahun_pelajaran}</td>
        <td class="px-4 py-3">${statusBadge(s.status_kelulusan)}</td>
        <td class="px-4 py-3 text-center">
          <button onclick="editSiswa(${s.id})" class="text-xs text-indigo-400 hover:text-indigo-300 mr-3">Edit</button>
          <button onclick="hapusSiswa(${s.id})" class="text-xs text-red-400 hover:text-red-300">Hapus</button>
        </td>
      </tr>
    `
      )
      .join("");
  }

  function openModalSiswa(id = null) {
    editSiswaId = id;
    const s = id ? siswaData.find((d) => d.id === id) : null;
    document.getElementById("modalSiswaTitle").textContent = id ? "Edit Siswa" : "Tambah Siswa";
    document.getElementById("fNama").value = s?.nama_lengkap ?? "";
    document.getElementById("fNisn").value = s?.nisn ?? "";
    document.getElementById("fKelas").value = s?.kelas ?? "";
    document.getElementById("fJK").value = s?.jenis_kelamin ?? "L";
    document.getElementById("fTP").value = s?.tahun_pelajaran ?? "";
    document.getElementById("fStatus").value = s?.status_kelulusan ?? "Lulus";
    document.getElementById("modalSiswa").classList.remove("hidden");
  }

  async function simpanSiswa() {
    const body = {
      nama_lengkap: document.getElementById("fNama").value.trim(),
      nisn: document.getElementById("fNisn").value.trim(),
      kelas: document.getElementById("fKelas").value.trim(),
      jenis_kelamin: document.getElementById("fJK").value,
      tahun_pelajaran: document.getElementById("fTP").value.trim(),
      status_kelulusan: document.getElementById("fStatus").value,
    };

    const url = editSiswaId ? `${SISWA_URL}?id=${editSiswaId}` : SISWA_URL;
    const method = editSiswaId ? "PUT" : "POST";
    const res = await fetch(url, { method, credentials: "include", body: JSON.stringify(body) });
    const j = await res.json();

    if (j.status === "success") {
      document.getElementById("modalSiswa").classList.add("hidden");
      toast(editSiswaId ? "Data diperbarui" : "Siswa ditambahkan");
      loadSiswa();
    } else {
      toast(j.message, false);
    }
  }

  window.editSiswa = (id) => openModalSiswa(id);

  window.hapusSiswa = async (id) => {
    if (!confirm("Hapus siswa ini?")) return;
    const res = await fetch(`${SISWA_URL}?id=${id}`, { method: "DELETE", credentials: "include" });
    const j = await res.json();
    if (j.status === "success") {
      toast("Siswa dihapus");
      loadSiswa();
    } else toast(j.message, false);
  };

  async function hapusSemua() {
    if (!confirm("Hapus SEMUA data siswa? Tindakan ini tidak dapat dibatalkan.")) return;
    const res = await fetch(`${SISWA_URL}?id=all`, { method: "DELETE", credentials: "include" });
    const j = await res.json();
    if (j.status === "success") {
      toast("Semua data dihapus");
      loadSiswa();
    } else toast(j.message, false);
  }

  // CSV Import
  function handleCSV(file) {
    const reader = new FileReader();
    reader.onload = async (e) => {
      const lines = e.target.result.trim().split("\n");
      const headers = lines[0].split(",").map((h) => h.trim().toLowerCase().replace(/\s+/g, "_"));
      const rows = lines
        .slice(1)
        .map((line) => {
          const vals = line.split(",").map((v) => v.trim().replace(/^"|"$/g, ""));
          return Object.fromEntries(headers.map((h, i) => [h, vals[i] ?? ""]));
        })
        .filter((r) => r.nisn && r.nama_lengkap);

      if (!rows.length) {
        toast("Format CSV tidak valid", false);
        return;
      }

      const res = await fetch(`${SISWA_URL}?action=import`, {
        method: "POST",
        credentials: "include",
        body: JSON.stringify({ rows }),
      });
      const j = await res.json();
      if (j.status === "success") {
        toast(`${j.data.imported} data diimport`);
        loadSiswa();
      } else toast(j.message, false);
    };
    reader.readAsText(file);
  }

  // ---- PENGUMUMAN ----
  async function loadPengumuman() {
    const res = await fetch(PENGUMUMAN_URL, { credentials: "include" });
    const j = await res.json();
    const d = j.data;
    if (!d) return;
    document.getElementById("inputWaktu").value = d.tanggal_waktu?.slice(0, 16) ?? "";
    setToggle(!!d.is_active);
  }

  function setToggle(active) {
    const cb = document.getElementById("inputAktif");
    const bg = document.getElementById("toggleBg");
    const dot = document.getElementById("toggleDot");
    cb.checked = active;
    bg.className = `w-11 h-6 rounded-full transition-colors ${active ? "bg-indigo-600" : "bg-slate-600"}`;
    dot.className = `absolute top-0.5 w-5 h-5 bg-white rounded-full transition-transform ${active ? "translate-x-5" : "translate-x-0.5"}`;
  }

  async function savePengumuman() {
    const body = {
      tanggal_waktu: document.getElementById("inputWaktu").value,
      is_active: document.getElementById("inputAktif").checked ? 1 : 0,
    };
    const res = await fetch(PENGUMUMAN_URL, {
      method: "POST",
      credentials: "include",
      body: JSON.stringify(body),
    });
    const j = await res.json();
    const msg = document.getElementById("pengumumanMsg");
    msg.textContent = j.status === "success" ? "Konfigurasi disimpan." : j.message;
    msg.className = `text-center text-sm ${j.status === "success" ? "text-emerald-400" : "text-red-400"}`;
    msg.classList.remove("hidden");
    setTimeout(() => msg.classList.add("hidden"), 3000);
  }

  // ---- ALBUM ----
  async function loadAlbum() {
    const res = await fetch(ALBUM_URL, { credentials: "include" });
    const j = await res.json();
    const grid = document.getElementById("albumGrid");
    grid.innerHTML =
      (j.data ?? [])
        .map(
          (a) => `
      <div class="relative group rounded-xl overflow-hidden aspect-square bg-slate-800">
        <img src="${a.foto_path}" alt="${a.judul ?? ""}" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex flex-col justify-end p-2">
          <p class="text-xs text-white truncate">${a.judul ?? ""}</p>
          <button onclick="hapusAlbum(${a.id})" class="text-xs text-red-300 mt-1">Hapus</button>
        </div>
      </div>
    `
        )
        .join("") || '<p class="text-slate-500 text-sm">Belum ada foto.</p>';
  }

  async function uploadAlbum() {
    const files = document.getElementById("albumInput").files;
    const judul = document.getElementById("albumJudul").value;
    if (!files.length) {
      toast("Pilih file dulu", false);
      return;
    }

    for (const file of files) {
      const fd = new FormData();
      fd.append("foto", file);
      if (judul) fd.append("judul", judul);
      await fetch(ALBUM_URL, { method: "POST", credentials: "include", body: fd });
    }
    toast(`${files.length} foto diupload`);
    document.getElementById("albumInput").value = "";
    document.getElementById("albumJudul").value = "";
    loadAlbum();
  }

  window.hapusAlbum = async (id) => {
    if (!confirm("Hapus foto ini?")) return;
    await fetch(`${ALBUM_URL}?id=${id}`, { method: "DELETE", credentials: "include" });
    toast("Foto dihapus");
    loadAlbum();
  };

  // ---- GURU ----
  async function loadGuru() {
    const res = await fetch(GURU_URL, { credentials: "include" });
    const j = await res.json();
    const grid = document.getElementById("guruGrid");
    grid.innerHTML =
      (j.data ?? [])
        .map(
          (g) => `
      <div class="bg-slate-800/60 border border-white/10 rounded-2xl p-4 flex gap-4 items-start">
        ${
          g.foto_path
            ? `<img src="${g.foto_path}" class="w-16 h-16 rounded-xl object-cover flex-shrink-0" />`
            : `<div class="w-16 h-16 rounded-xl bg-slate-700 flex-shrink-0 flex items-center justify-center text-2xl">👤</div>`
        }
        <div class="flex-1 min-w-0">
          <p class="font-semibold truncate">${g.nama}</p>
          <p class="text-slate-400 text-xs mb-1">${g.jabatan ?? ""}</p>
          <p class="text-slate-300 text-xs line-clamp-2">${g.kesan_pesan ?? ""}</p>
        </div>
        <button onclick="hapusGuru(${g.id})" class="text-red-400 hover:text-red-300 text-xs flex-shrink-0">Hapus</button>
      </div>
    `
        )
        .join("") || '<p class="text-slate-500 text-sm">Belum ada data.</p>';
  }

  async function simpanGuru() {
    const fd = new FormData();
    fd.append("nama", document.getElementById("gNama").value.trim());
    fd.append("jabatan", document.getElementById("gJabatan").value.trim());
    fd.append("kesan_pesan", document.getElementById("gKesan").value.trim());
    const foto = document.getElementById("gFoto").files[0];
    if (foto) fd.append("foto", foto);

    const res = await fetch(GURU_URL, { method: "POST", credentials: "include", body: fd });
    const j = await res.json();
    if (j.status === "success") {
      document.getElementById("modalGuru").classList.add("hidden");
      document.getElementById("gNama").value = "";
      document.getElementById("gJabatan").value = "";
      document.getElementById("gKesan").value = "";
      document.getElementById("gFoto").value = "";
      toast("Data guru ditambahkan");
      loadGuru();
    } else toast(j.message, false);
  }

  window.hapusGuru = async (id) => {
    if (!confirm("Hapus data ini?")) return;
    await fetch(`${GURU_URL}?id=${id}`, { method: "DELETE", credentials: "include" });
    toast("Data dihapus");
    loadGuru();
  };

  let importGuruRowCount = 0;

  function addImportRow() {
    const i = importGuruRowCount++;
    const row = document.createElement("div");
    row.className = "grid grid-cols-[1fr_1fr_1fr_auto] gap-2 items-start";
    row.dataset.row = i;
    row.innerHTML = `
      <input name="nama_${i}" type="text" placeholder="Nama *" class="inp" />
      <input name="jabatan_${i}" type="text" placeholder="Jabatan" class="inp" />
      <input name="kesan_${i}" type="text" placeholder="Kesan & Pesan" class="inp" />
      <div class="flex flex-col gap-1">
        <label class="w-10 h-10 bg-slate-700 hover:bg-slate-600 rounded-xl flex items-center justify-center cursor-pointer text-lg" title="Upload foto">
          📷<input type="file" accept="image/*" class="hidden" data-foto="${i}" />
        </label>
        <button type="button" onclick="this.closest('[data-row]').remove()" class="w-10 h-8 bg-red-700/50 hover:bg-red-600 rounded-xl text-xs text-red-200">✕</button>
      </div>
    `;
    document.getElementById("importGuruRows").appendChild(row);
  }

  function openImportGuru() {
    importGuruRowCount = 0;
    document.getElementById("importGuruRows").innerHTML = "";
    addImportRow();
    document.getElementById("modalImportGuru").classList.remove("hidden");
  }

  async function kirimImportGuru() {
    const rows = document.querySelectorAll("#importGuruRows [data-row]");
    if (!rows.length) {
      toast("Tambah minimal 1 baris", false);
      return;
    }

    const fd = new FormData();
    let count = 0;

    rows.forEach((row, idx) => {
      const nama = row.querySelector('[name^="nama"]').value.trim();
      if (!nama) return;
      fd.append("nama[]", nama);
      fd.append("jabatan[]", row.querySelector('[name^="jabatan"]').value.trim());
      fd.append("kesan_pesan[]", row.querySelector('[name^="kesan"]').value.trim());
      const fotoInput = row.querySelector('input[type="file"]');
      if (fotoInput.files[0]) fd.append("foto[]", fotoInput.files[0]);
      else fd.append("foto[]", new Blob([]), "");
      count++;
    });

    if (!count) {
      toast("Minimal 1 nama diisi", false);
      return;
    }

    const res = await fetch(`${GURU_URL}?action=import`, {
      method: "POST",
      credentials: "include",
      body: fd,
    });
    const j = await res.json();
    if (j.status === "success") {
      document.getElementById("modalImportGuru").classList.add("hidden");
      toast(`${j.data.imported} data diimport`);
      loadGuru();
    } else toast(j.message, false);
  }

  // ---- TESTIMONI ----

  let testimoniSelected = new Set();
  let editTestimoniId = null;

  async function loadTestimoni() {
    const res = await fetch(TESTIMONI_URL, { credentials: "include" });
    const j = await res.json();
    const list = document.getElementById("testimoniList");
    testimoniSelected.clear();
    updateBulkDeleteBtn();

    list.innerHTML =
      (j.data ?? [])
        .map(
          (t) => `
      <div class="bg-slate-800/60 border border-white/10 rounded-xl p-4 flex items-start gap-3">
        <input type="checkbox" data-id="${t.id}" onchange="toggleSelectTestimoni(${t.id})"
          class="mt-1 w-4 h-4 accent-indigo-500 flex-shrink-0 cursor-pointer" />
        <div class="flex-1 min-w-0">
          <div class="flex justify-between items-start gap-2">
            <p class="font-semibold text-sm">${t.nama} <span class="text-slate-500 text-xs font-mono">${t.nisn ? "· " + t.nisn : ""}</span></p>
            <span class="text-slate-500 text-xs flex-shrink-0">${new Date(t.created_at).toLocaleDateString("id-ID", { day: "numeric", month: "short", year: "numeric" })}</span>
          </div>
          <p class="text-slate-300 text-sm mt-1">${t.isi}</p>
        </div>
        <div class="flex gap-2 flex-shrink-0">
          <button onclick="openEditTestimoni(${t.id}, '${t.nama.replace(/'/g, "\\'")}', \`${t.isi.replace(/`/g, "\\`")}\`)" class="text-xs text-indigo-400 hover:text-indigo-300">Edit</button>
          <button onclick="hapusTestimoni(${t.id})" class="text-xs text-red-400 hover:text-red-300">Hapus</button>
        </div>
      </div>
    `
        )
        .join("") || '<p class="text-slate-500 text-sm">Belum ada testimoni.</p>';
  }

  window.toggleSelectTestimoni = (id) => {
    if (testimoniSelected.has(id)) testimoniSelected.delete(id);
    else testimoniSelected.add(id);
    updateBulkDeleteBtn();
  };

  function updateBulkDeleteBtn() {
    const btn = document.getElementById("btnBulkDeleteTestimoni");
    const count = document.getElementById("testimoniSelectedCount");
    if (testimoniSelected.size > 0) {
      btn.classList.remove("hidden");
      count.textContent = `${testimoniSelected.size} dipilih`;
      count.classList.remove("hidden");
    } else {
      btn.classList.add("hidden");
      count.classList.add("hidden");
    }
  }

  window.openEditTestimoni = (id, nama, isi) => {
    editTestimoniId = id;
    document.getElementById("etNama").value = nama;
    document.getElementById("etIsi").value = isi;
    document.getElementById("modalTestimoni").classList.remove("hidden");
  };

  async function simpanTestimoni() {
    const nama = document.getElementById("etNama").value.trim();
    const isi = document.getElementById("etIsi").value.trim();
    if (!nama || !isi) {
      toast("Nama dan isi wajib diisi", false);
      return;
    }

    const res = await fetch(`${TESTIMONI_URL}?id=${editTestimoniId}`, {
      method: "PUT",
      credentials: "include",
      body: JSON.stringify({ nama, isi }),
    });
    const j = await res.json();
    if (j.status === "success") {
      document.getElementById("modalTestimoni").classList.add("hidden");
      toast("Testimoni diperbarui");
      loadTestimoni();
    } else toast(j.message, false);
  }

  async function bulkDeleteTestimoni() {
    if (!confirm(`Hapus ${testimoniSelected.size} testimoni terpilih?`)) return;
    const res = await fetch(`${TESTIMONI_URL}?action=bulk-delete`, {
      method: "POST",
      credentials: "include",
      body: JSON.stringify({ ids: [...testimoniSelected] }),
    });
    const j = await res.json();
    if (j.status === "success") {
      toast(`${j.data.deleted} testimoni dihapus`);
      loadTestimoni();
    } else toast(j.message, false);
  }

  window.hapusTestimoni = async (id) => {
    if (!confirm("Hapus testimoni?")) return;
    await fetch(`${TESTIMONI_URL}?id=${id}`, { method: "DELETE", credentials: "include" });
    toast("Testimoni dihapus");
    loadTestimoni();
  };

  // ---- INFORMASI ----
  let editInfoId = null;

  async function loadInformasi() {
    const res = await fetch(INFO_URL, { credentials: "include" });
    const j = await res.json();
    const list = document.getElementById("infoList");

    list.innerHTML =
      (j.data ?? [])
        .map(
          (d) => `
    <div class="bg-slate-800/60 border border-white/10 rounded-2xl p-4 flex gap-4">
      ${d.foto_path ? `<img src="${d.foto_path}" class="w-20 h-20 rounded-xl object-cover flex-shrink-0" />` : ""}
      <div class="flex-1 min-w-0">
        <div class="flex items-start justify-between gap-2 mb-1">
          <p class="font-semibold text-sm">${d.judul}</p>
          <span class="text-[10px] px-2 py-0.5 rounded-full flex-shrink-0 ${d.is_published ? "bg-emerald-500/20 text-emerald-300" : "bg-slate-600 text-slate-400"}">
            ${d.is_published ? "Publik" : "Draft"}
          </span>
        </div>
        ${d.isi ? `<p class="text-slate-400 text-xs line-clamp-2 mb-1">${d.isi}</p>` : ""}
        <div class="flex flex-wrap gap-3 mt-2">
          ${d.file_path ? `<a href="${d.file_path}" target="_blank" class="text-xs text-indigo-400 hover:underline">📎 ${d.file_name ?? "File"}</a>` : ""}
          ${d.link_eksternal ? `<a href="${d.link_eksternal}" target="_blank" class="text-xs text-indigo-400 hover:underline">🔗 Link</a>` : ""}
          <span class="text-slate-500 text-xs">${new Date(d.created_at).toLocaleDateString("id-ID", { day: "numeric", month: "short", year: "numeric" })}</span>
        </div>
      </div>
      <div class="flex flex-col gap-2 flex-shrink-0">
        <button onclick="editInfo(${d.id}, ${JSON.stringify(d).replace(/"/g, "&quot;")})" class="text-xs text-indigo-400 hover:text-indigo-300">Edit</button>
        <button onclick="hapusInfo(${d.id})" class="text-xs text-red-400 hover:text-red-300">Hapus</button>
      </div>
    </div>
  `
        )
        .join("") || '<p class="text-slate-500 text-sm">Belum ada informasi.</p>';
  }

  function openModalInfo(reset = true) {
    if (reset) {
      editInfoId = null;
      document.getElementById("modalInfoTitle").textContent = "Tambah Informasi";
      document.getElementById("iJudul").value = "";
      document.getElementById("iIsi").value = "";
      document.getElementById("iFoto").value = "";
      document.getElementById("iFotoCaption").value = "";
      document.getElementById("iFile").value = "";
      document.getElementById("iLink").value = "";
      document.getElementById("iPublished").checked = true;
    }
    document.getElementById("modalInfo").classList.remove("hidden");
  }

  window.editInfo = (id, data) => {
    editInfoId = id;
    document.getElementById("modalInfoTitle").textContent = "Edit Informasi";
    document.getElementById("iJudul").value = data.judul ?? "";
    document.getElementById("iIsi").value = data.isi ?? "";
    document.getElementById("iFotoCaption").value = data.foto_caption ?? "";
    document.getElementById("iLink").value = data.link_eksternal ?? "";
    document.getElementById("iPublished").checked = !!data.is_published;
    openModalInfo(false);
  };

  async function simpanInfo() {
    const judul = document.getElementById("iJudul").value.trim();
    if (!judul) {
      toast("Judul wajib diisi", false);
      return;
    }

    if (editInfoId) {
      const body = {
        judul,
        isi: document.getElementById("iIsi").value.trim(),
        foto_caption: document.getElementById("iFotoCaption").value.trim(),
        link_eksternal: document.getElementById("iLink").value.trim(),
        is_published: document.getElementById("iPublished").checked ? 1 : 0,
      };
      const res = await fetch(`${INFO_URL}?id=${editInfoId}`, {
        method: "PUT",
        credentials: "include",
        body: JSON.stringify(body),
      });
      const j = await res.json();
      if (j.status === "success") {
        document.getElementById("modalInfo").classList.add("hidden");
        toast("Informasi diperbarui");
        loadInformasi();
      } else toast(j.message, false);
      return;
    }

    const fd = new FormData();
    fd.append("judul", judul);
    fd.append("isi", document.getElementById("iIsi").value.trim());
    fd.append("foto_caption", document.getElementById("iFotoCaption").value.trim());
    fd.append("link_eksternal", document.getElementById("iLink").value.trim());
    fd.append("is_published", document.getElementById("iPublished").checked ? "1" : "0");
    const foto = document.getElementById("iFoto").files[0];
    const file = document.getElementById("iFile").files[0];
    if (foto) fd.append("foto", foto);
    if (file) fd.append("file", file);

    const res = await fetch(INFO_URL, { method: "POST", credentials: "include", body: fd });
    const j = await res.json();
    if (j.status === "success") {
      document.getElementById("modalInfo").classList.add("hidden");
      toast("Informasi ditambahkan");
      loadInformasi();
    } else toast(j.message, false);
  }

  window.hapusInfo = async (id) => {
    if (!confirm("Hapus informasi ini?")) return;
    const res = await fetch(`${INFO_URL}?id=${id}`, { method: "DELETE", credentials: "include" });
    const j = await res.json();
    if (j.status === "success") {
      toast("Informasi dihapus");
      loadInformasi();
    } else toast(j.message, false);
  };

  // ---- INIT ----
  (async () => {
    const authed = await checkAuth();
    if (authed) showDashboard();

    document.getElementById("btnLogin").onclick = login;
    document.getElementById("loginPass").addEventListener("keydown", (e) => {
      if (e.key === "Enter") login();
    });
    document.getElementById("btnLogout").onclick = logout;

    // Siswa events
    document.getElementById("btnTambahSiswa").onclick = () => openModalSiswa();
    document.getElementById("btnSimpanSiswa").onclick = simpanSiswa;
    document.getElementById("btnBatalSiswa").onclick = () =>
      document.getElementById("modalSiswa").classList.add("hidden");
    document.getElementById("btnHapusSemua").onclick = hapusSemua;
    document.getElementById("csvInput").onchange = (e) => {
      if (e.target.files[0]) handleCSV(e.target.files[0]);
    };

    ["searchSiswa", "filterKelas", "filterJK", "filterStatus", "filterTP"].forEach((id) => {
      document.getElementById(id).addEventListener("input", loadSiswa);
      document.getElementById(id).addEventListener("change", loadSiswa);
    });

    // Pengumuman events
    document.getElementById("btnSavePengumuman").onclick = savePengumuman;
    document
      .getElementById("inputAktif")
      .addEventListener("change", (e) => setToggle(e.target.checked));

    // Album events
    document.getElementById("btnUploadAlbum").onclick = uploadAlbum;

    // Guru events
    document.getElementById("btnTambahGuru").onclick = () =>
      document.getElementById("modalGuru").classList.remove("hidden");
    document.getElementById("btnImportGuru").onclick = openImportGuru;
    document.getElementById("btnSimpanGuru").onclick = simpanGuru;
    document.getElementById("btnBatalGuru").onclick = () =>
      document.getElementById("modalGuru").classList.add("hidden");
    document.getElementById("btnTambahRowGuru").onclick = addImportRow;
    document.getElementById("btnKirimImportGuru").onclick = kirimImportGuru;
    document.getElementById("btnBatalImportGuru").onclick = () =>
      document.getElementById("modalImportGuru").classList.add("hidden");

    // Testimoni events
    document.getElementById("btnBulkDeleteTestimoni").onclick = bulkDeleteTestimoni;
    document.getElementById("btnSimpanTestimoni").onclick = simpanTestimoni;
    document.getElementById("btnBatalTestimoni").onclick = () =>
      document.getElementById("modalTestimoni").classList.add("hidden");

    document.getElementById("btnTambahInfo").onclick = () => openModalInfo();
    document.getElementById("btnSimpanInfo").onclick = simpanInfo;
    document.getElementById("btnBatalInfo").onclick = () =>
      document.getElementById("modalInfo").classList.add("hidden");
  })();
</script>

```
---

## ./src/pages/index.astro

```html
---
import Layout from "../layouts/Layout.astro";
const API_BASE = import.meta.env.PUBLIC_API_BASE;
const INFO_URL = `${API_BASE}/informasi/`;
---

<Layout title="Pengumuman Kelulusan — Madrasah Universe">
  <!-- ===================== SECTIONS ===================== -->

  <!-- BERANDA -->
  <section
    id="sec-beranda"
    class="section min-h-[100dvh] flex flex-col items-center justify-center px-6 py-24 text-center gap-6 relative overflow-hidden"
  >
    <div
      class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_50%_0%,rgba(99,102,241,0.15),transparent_70%)]"
    >
    </div>

    <img
      id="logoMadrasah"
      src="/favicon.svg"
      alt="Logo"
      class="w-24 h-24 object-contain drop-shadow-2xl"
    />
    <div>
      <h1 id="namaMadrasah" class="text-2xl font-bold leading-tight">Madrasah Universe</h1>
      <p class="text-slate-400 text-sm mt-1">Pengumuman Kelulusan</p>
    </div>

    <!-- Countdown -->
    <div id="countdownWrapper" class="w-full max-w-sm">
      <p class="text-slate-400 text-xs uppercase tracking-widest mb-3">Pengumuman dalam</p>
      <div class="grid grid-cols-4 gap-2">
        {
          ["H", "Jam", "Menit", "Detik"].map((l, i) => (
            <div class="bg-slate-800/80 border border-white/10 rounded-2xl py-4 flex flex-col items-center">
              <span id={`cd-${["d", "h", "m", "s"][i]}`} class="text-3xl font-bold tabular-nums">
                00
              </span>
              <span class="text-[10px] text-slate-400 mt-1">{l}</span>
            </div>
          ))
        }
      </div>
      <p id="cdExpired" class="hidden mt-3 text-emerald-400 text-sm font-semibold animate-pulse">
        Pengumuman sudah dibuka!
      </p>
    </div>

    <!-- Quote -->
    <blockquote
      id="quoteText"
      class="max-w-xs text-slate-400 text-sm italic leading-relaxed border-l-2 border-indigo-500 pl-4 text-left"
    >
      "Pendidikan adalah senjata paling ampuh yang bisa kamu gunakan untuk mengubah dunia."
    </blockquote>

    <button
      onclick="goSection('cari')"
      class="mt-2 px-8 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-2xl font-semibold transition-all active:scale-95 shadow-lg shadow-indigo-500/25"
    >
      Cek Kelulusan Saya
    </button>
  </section>

  <!-- CARI NISN -->
  <section
    id="sec-cari"
    class="section hidden min-h-[100dvh] flex flex-col items-center justify-center px-6 py-24 gap-6"
  >
    <div class="w-full max-w-sm">
      <h2 class="text-xl font-bold mb-1 text-center">Cari Kelulusan</h2>
      <p class="text-slate-400 text-sm text-center mb-6">
        Masukkan NISN untuk membuka amplop kelulusanmu
      </p>

      <div class="relative mb-3">
        <input
          id="nisnInput"
          type="text"
          inputmode="numeric"
          maxlength="10"
          placeholder="Masukkan NISN..."
          class="w-full bg-slate-800 border border-white/10 rounded-2xl px-5 py-4 text-center text-lg font-mono tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
        />
      </div>
      <button
        id="btnCariNisn"
        class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-500 rounded-2xl font-semibold transition-all active:scale-95 shadow-lg shadow-indigo-500/25"
      >
        Cari
      </button>
      <p id="cariErr" class="text-red-400 text-sm text-center mt-3 hidden"></p>

      <!-- Hasil Cari -->
      <div id="hasilCari" class="hidden mt-6">
        <div class="bg-slate-800/60 border border-white/10 rounded-2xl p-5 text-center">
          <p id="hasilNama" class="font-bold text-lg mb-0.5"></p>
          <p id="hasilKelas" class="text-slate-400 text-sm mb-4"></p>

          <!-- Amplop -->
          <button
            id="btnBukaAmplop"
            class="relative mx-auto flex flex-col items-center justify-center gap-2 w-full py-6 rounded-2xl border-2 border-dashed transition-all active:scale-95 group"
          >
            <div
              id="amplopIcon"
              class="text-6xl transition-transform group-hover:scale-110 duration-300"
            >
              ✉️
            </div>
            <span id="amplopLabel" class="text-sm font-semibold"></span>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- ALBUM FOTO -->
  <section id="sec-album" class="section hidden min-h-[100dvh] px-4 py-24 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold text-center mb-6">Album Kenangan</h2>
    <div id="albumPublicGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
      <div class="col-span-full text-center text-slate-500 text-sm py-10">Memuat...</div>
    </div>
  </section>

  <!-- GURU & PEGAWAI -->
  <section id="sec-guru" class="section hidden min-h-[100dvh] px-4 py-24 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold text-center mb-6">Pesan Guru & Pegawai</h2>
    <div id="guruPublicList" class="space-y-4">
      <div class="text-center text-slate-500 text-sm py-10">Memuat...</div>
    </div>
  </section>

  <!-- TESTIMONI -->
  <section id="sec-testimoni" class="section hidden min-h-[100dvh] px-4 py-24 max-w-lg mx-auto">
    <h2 class="text-xl font-bold text-center mb-2">Kesan & Pesan</h2>
    <p class="text-slate-400 text-sm text-center mb-6">Bagikan kenangan indahmu bersama madrasah</p>

    <!-- Form -->
    <div class="bg-slate-800/60 border border-white/10 rounded-2xl p-5 mb-6 space-y-3">
      <input id="tNama" type="text" placeholder="Nama kamu" class="inp w-full" />
      <input
        id="tNisn"
        type="text"
        inputmode="numeric"
        placeholder="NISN (opsional)"
        class="inp w-full"
      />
      <textarea
        id="tIsi"
        rows="4"
        placeholder="Tulis kesan & pesanmu..."
        class="inp w-full resize-none"></textarea>
      <button
        id="btnKirimTestimoni"
        class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-semibold transition active:scale-95"
        >Kirim</button
      >
      <p id="testimoniMsg" class="text-center text-sm hidden"></p>
    </div>

    <!-- List -->
    <div id="testimoniPublicList" class="space-y-3">
      <div class="text-center text-slate-500 text-sm py-4">Memuat...</div>
    </div>
  </section>

  <!-- INFOMASI -->
  <section id="sec-info" class="section hidden min-h-[100dvh] px-4 py-24 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold text-center mb-6">Informasi</h2>
    <div id="infoPublicList" class="space-y-4">
      <div class="text-center text-slate-500 text-sm py-10">Memuat...</div>
    </div>
  </section>

  <!-- ===================== BOTTOM NAV ===================== -->
  <nav
    class="fixed bottom-0 inset-x-0 z-40 bg-slate-900/95 backdrop-blur border-t border-white/10 safe-bottom"
  >
    <div class="flex max-w-lg mx-auto">
      {
        [
          { id: "beranda", icon: "🏠", label: "Beranda" },
          { id: "cari", icon: "🔍", label: "Cari" },
          { id: "album", icon: "📷", label: "Album" },
          { id: "guru", icon: "👨‍🏫", label: "Guru" },
          { id: "testimoni", icon: "💬", label: "Pesan" },
          { id: "info", icon: "📢", label: "Info" },
        ].map((n) => (
          <button
            data-nav={n.id}
            onclick={`goSection('${n.id}')`}
            class="nav-btn flex-1 flex flex-col items-center justify-center py-3 gap-0.5 text-slate-500 transition-colors"
          >
            <span class="text-xl leading-none">{n.icon}</span>
            <span class="text-[10px] font-medium">{n.label}</span>
          </button>
        ))
      }
    </div>
  </nav>

  <!-- ===================== MODALS ===================== -->

  <!-- Modal: Amplop Dibuka -->
  <div
    id="modalAmplop"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4"
  >
    <div
      id="modalAmplopBox"
      class="bg-slate-800 border border-white/10 rounded-3xl p-8 w-full max-w-sm text-center shadow-2xl transform scale-90 opacity-0 transition-all duration-500"
    >
      <div id="modalAmplopEmoji" class="text-7xl mb-4 transition-all duration-700">✉️</div>
      <div id="modalAmplopStatus" class="text-4xl font-bold mb-2"></div>
      <p id="modalAmplopNama" class="text-slate-300 text-lg font-semibold mb-1"></p>
      <p id="modalAmplopKelas" class="text-slate-400 text-sm mb-6"></p>
      <div id="modalAmplopBadge" class="inline-block px-6 py-2 rounded-full text-sm font-bold mb-6">
      </div>
      <button
        onclick="closeModalAmplop()"
        class="w-full py-3 bg-slate-700 hover:bg-slate-600 rounded-2xl font-semibold transition"
        >Tutup</button
      >
    </div>
    <canvas id="confettiCanvas" class="fixed inset-0 pointer-events-none z-[-1]"></canvas>
  </div>

  <!-- Modal: Belum Waktunya -->
  <div
    id="modalBelumWaktu"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4"
  >
    <div
      class="bg-slate-800 border border-white/10 rounded-3xl p-8 w-full max-w-sm text-center shadow-2xl"
    >
      <div class="text-6xl mb-4">🔒</div>
      <h3 class="text-xl font-bold mb-2">Belum Waktunya</h3>
      <p class="text-slate-400 text-sm mb-4">Pengumuman akan dibuka pada:</p>
      <p id="waktuPengumuman" class="text-indigo-400 font-semibold mb-2"></p>
      <div class="grid grid-cols-4 gap-2 mb-6">
        {
          ["H", "Jam", "Mnt", "Dtk"].map((l, i) => (
            <div class="bg-slate-700/60 rounded-xl py-3 flex flex-col items-center">
              <span id={`mcd-${["d", "h", "m", "s"][i]}`} class="text-2xl font-bold tabular-nums">
                00
              </span>
              <span class="text-[10px] text-slate-400">{l}</span>
            </div>
          ))
        }
      </div>
      <button
        onclick="document.getElementById('modalBelumWaktu').classList.replace('flex','hidden')"
        class="w-full py-3 bg-slate-700 hover:bg-slate-600 rounded-2xl font-semibold transition"
        >Mengerti</button
      >
    </div>
  </div>

  <!-- Lightbox Album -->
  <div
    id="lightbox"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 p-4"
    onclick="this.classList.replace('flex','hidden')"
  >
    <img id="lightboxImg" src="" alt="" class="max-w-full max-h-full rounded-2xl object-contain" />
  </div>
</Layout>

<script define:vars={{ API_BASE }}>
  const SISWA_URL = `${API_BASE}/siswa/`;
  const PENGUMUMAN_URL = `${API_BASE}/pengumuman/`;
  const ALBUM_URL = `${API_BASE}/album/`;
  const GURU_URL = `${API_BASE}/guru/`;
  const TESTIMONI_URL = `${API_BASE}/testimoni/`;

  const QUOTES = [
    "Pendidikan adalah senjata paling ampuh yang bisa kamu gunakan untuk mengubah dunia.",
    "Belajarlah seolah kamu akan hidup selamanya, hiduplah seolah kamu akan mati besok.",
    "Kesuksesan bukan kunci kebahagiaan. Kebahagiaan adalah kunci kesuksesan.",
    "Setiap ahli dulunya pernah menjadi pemula. Jangan takut untuk memulai.",
    "Mimpi bukan yang kamu lihat saat tidur, melainkan yang tidak membiarkanmu tidur.",
  ];

  // ---- STATE ----
  let pengumumanConfig = null;
  let siswaFound = null;
  let currentSection = "beranda";
  let albumLoaded = false;
  let guruLoaded = false;
  let testimoniLoaded = false;
  let countdownInterval = null;

  // ---- NAVIGATION ----
  window.goSection = function (id) {
    document.querySelectorAll(".section").forEach((s) => s.classList.add("hidden"));
    document.querySelectorAll(".nav-btn").forEach((b) => b.classList.remove("active"));

    document.getElementById(`sec-${id}`).classList.remove("hidden");
    document.querySelector(`[data-nav="${id}"]`)?.classList.add("active");
    currentSection = id;
    window.scrollTo(0, 0);

    if (id === "album" && !albumLoaded) {
      loadAlbum();
      albumLoaded = true;
    }
    if (id === "guru" && !guruLoaded) {
      loadGuru();
      guruLoaded = true;
    }
    if (id === "testimoni" && !testimoniLoaded) {
      loadTestimoni();
      testimoniLoaded = true;
    }
  };

  // ---- COUNTDOWN ----
  function parseDiff(target) {
    const diff = Math.max(0, target - Date.now());
    return {
      d: Math.floor(diff / 86400000),
      h: Math.floor((diff % 86400000) / 3600000),
      m: Math.floor((diff % 3600000) / 60000),
      s: Math.floor((diff % 60000) / 1000),
      expired: diff === 0,
    };
  }

  function pad(n) {
    return String(n).padStart(2, "0");
  }

  function startCountdown(target) {
    function tick() {
      const t = parseDiff(target);
      ["d", "h", "m", "s"].forEach((k) => {
        document.getElementById(`cd-${k}`).textContent = pad(t[k]);
        const mc = document.getElementById(`mcd-${k}`);
        if (mc) mc.textContent = pad(t[k]);
      });

      if (t.expired) {
        clearInterval(countdownInterval);
        document.getElementById("countdownWrapper").querySelector("p").textContent = "";
        document.getElementById("cdExpired").classList.remove("hidden");
        updateAmplopState();
      }
    }
    tick();
    countdownInterval = setInterval(tick, 1000);
  }

  function isAmplopOpen() {
    if (!pengumumanConfig) return false;
    if (!pengumumanConfig.is_active) return false;
    return Date.now() >= new Date(pengumumanConfig.tanggal_waktu).getTime();
  }

  function updateAmplopState() {
    if (!siswaFound) return;
    const open = isAmplopOpen();
    const btn = document.getElementById("btnBukaAmplop");
    const label = document.getElementById("amplopLabel");

    if (open) {
      btn.className =
        "relative mx-auto flex flex-col items-center justify-center gap-2 w-full py-6 rounded-2xl border-2 border-dashed border-indigo-500 bg-indigo-500/10 hover:bg-indigo-500/20 cursor-pointer transition-all active:scale-95 group";
      label.textContent = "Klik untuk membuka amplop!";
      label.className = "text-sm font-semibold text-indigo-300 animate-pulse";
    } else {
      btn.className =
        "relative mx-auto flex flex-col items-center justify-center gap-2 w-full py-6 rounded-2xl border-2 border-dashed border-slate-600 bg-slate-700/20 cursor-not-allowed transition-all group opacity-70";
      label.textContent = "Amplop terkunci";
      label.className = "text-sm font-semibold text-slate-500";
    }
  }

  // ---- CONFETTI ----
  function runConfetti() {
    const canvas = document.getElementById("confettiCanvas");
    const ctx = canvas.getContext("2d");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const pieces = Array.from({ length: 120 }, () => ({
      x: Math.random() * canvas.width,
      y: Math.random() * -canvas.height,
      w: Math.random() * 10 + 5,
      h: Math.random() * 6 + 3,
      color: ["#6366f1", "#a78bfa", "#34d399", "#fbbf24", "#f472b6"][Math.floor(Math.random() * 5)],
      vx: (Math.random() - 0.5) * 3,
      vy: Math.random() * 4 + 2,
      rot: Math.random() * 360,
      rotV: (Math.random() - 0.5) * 6,
    }));

    let frame;
    let done = false;

    function draw() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      pieces.forEach((p) => {
        p.x += p.vx;
        p.y += p.vy;
        p.rot += p.rotV;
        ctx.save();
        ctx.translate(p.x, p.y);
        ctx.rotate((p.rot * Math.PI) / 180);
        ctx.fillStyle = p.color;
        ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
        ctx.restore();
      });
      if (!done) frame = requestAnimationFrame(draw);
    }
    draw();
    setTimeout(() => {
      done = true;
      cancelAnimationFrame(frame);
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    }, 4000);
  }

  // ---- MODAL AMPLOP ----
  function openModalAmplop(siswa) {
    const modal = document.getElementById("modalAmplop");
    const box = document.getElementById("modalAmplopBox");

    const cfg = {
      Lulus: {
        emoji: "🎉",
        status: "LULUS",
        badge: "bg-emerald-500/20 text-emerald-300 border border-emerald-500/30",
      },
      "Tidak Lulus": {
        emoji: "📋",
        status: "TIDAK LULUS",
        badge: "bg-red-500/20 text-red-300 border border-red-500/30",
      },
      "Lulus Bersyarat": {
        emoji: "📌",
        status: "LULUS BERSYARAT",
        badge: "bg-amber-500/20 text-amber-300 border border-amber-500/30",
      },
    }[siswa.status_kelulusan] ?? {
      emoji: "📄",
      status: siswa.status_kelulusan,
      badge: "bg-slate-600 text-slate-300",
    };

    document.getElementById("modalAmplopEmoji").textContent = "✉️";
    document.getElementById("modalAmplopStatus").textContent = "";
    document.getElementById("modalAmplopNama").textContent = siswa.nama_lengkap;
    document.getElementById("modalAmplopKelas").textContent =
      `${siswa.kelas} · ${siswa.tahun_pelajaran}`;
    document.getElementById("modalAmplopBadge").textContent = cfg.status;
    document.getElementById("modalAmplopBadge").className =
      `inline-block px-6 py-2 rounded-full text-sm font-bold mb-6 ${cfg.badge}`;

    modal.classList.remove("hidden");
    modal.classList.add("flex");
    requestAnimationFrame(() => {
      box.classList.remove("scale-90", "opacity-0");
      box.classList.add("scale-100", "opacity-100");
    });

    // Animasi amplop buka
    setTimeout(() => {
      document.getElementById("modalAmplopEmoji").textContent = cfg.emoji;
      document.getElementById("modalAmplopStatus").textContent = cfg.status;
      if (siswa.status_kelulusan === "Lulus") runConfetti();
    }, 600);
  }

  window.closeModalAmplop = function () {
    const modal = document.getElementById("modalAmplop");
    const box = document.getElementById("modalAmplopBox");
    box.classList.add("scale-90", "opacity-0");
    setTimeout(() => {
      modal.classList.add("hidden");
      modal.classList.remove("flex");
      box.classList.remove("scale-100", "opacity-100");
    }, 300);
  };

  function openModalBelumWaktu() {
    const waktu = new Date(pengumumanConfig.tanggal_waktu);
    document.getElementById("waktuPengumuman").textContent = waktu.toLocaleString("id-ID", {
      weekday: "long",
      day: "numeric",
      month: "long",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit",
    });
    const modal = document.getElementById("modalBelumWaktu");
    modal.classList.remove("hidden");
    modal.classList.add("flex");
  }

  // ---- CARI NISN ----
  async function cariNisn() {
    const nisn = document.getElementById("nisnInput").value.trim();
    const errEl = document.getElementById("cariErr");
    errEl.classList.add("hidden");

    if (!nisn) {
      errEl.textContent = "Masukkan NISN terlebih dahulu";
      errEl.classList.remove("hidden");
      return;
    }

    try {
      const res = await fetch(`${SISWA_URL}?id=nisn&nisn=${encodeURIComponent(nisn)}`);
      const j = await res.json();

      if (j.status !== "success") {
        errEl.textContent = "NISN tidak ditemukan. Periksa kembali.";
        errEl.classList.remove("hidden");
        document.getElementById("hasilCari").classList.add("hidden");
        return;
      }

      siswaFound = j.data;
      document.getElementById("hasilNama").textContent = j.data.nama_lengkap;
      document.getElementById("hasilKelas").textContent =
        `${j.data.kelas} · ${j.data.tahun_pelajaran}`;
      document.getElementById("hasilCari").classList.remove("hidden");
      updateAmplopState();
    } catch {
      errEl.textContent = "Gagal terhubung ke server.";
      errEl.classList.remove("hidden");
    }
  }

  // ---- ALBUM ----
  async function loadAlbum() {
    const grid = document.getElementById("albumPublicGrid");
    try {
      const res = await fetch(ALBUM_URL);
      const j = await res.json();
      const data = j.data ?? [];
      if (!data.length) {
        grid.innerHTML =
          '<p class="col-span-full text-center text-slate-500 py-10">Belum ada foto.</p>';
        return;
      }
      grid.innerHTML = data
        .map(
          (a) => `
        <button onclick="openLightbox('${a.foto_path}')" class="relative aspect-square rounded-xl overflow-hidden bg-slate-800 group">
          <img src="${a.foto_path}" alt="${a.judul ?? ""}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" />
          ${a.judul ? `<div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 px-3 py-2"><p class="text-xs text-white truncate">${a.judul}</p></div>` : ""}
        </button>
      `
        )
        .join("");
    } catch {
      grid.innerHTML =
        '<p class="col-span-full text-center text-slate-500 py-10">Gagal memuat album.</p>';
    }
  }

  // ---- INFORMASI ----
  let infoLoaded = false;

  async function loadInfo() {
    const list = document.getElementById("infoPublicList");
    try {
      const res = await fetch(INFO_URL);
      const j = await res.json();
      const data = j.data ?? [];
      if (!data.length) {
        list.innerHTML = '<p class="text-center text-slate-500 py-10">Belum ada informasi.</p>';
        return;
      }
      list.innerHTML = data
        .map(
          (d) => `
      <div class="bg-slate-800/60 border border-white/10 rounded-2xl overflow-hidden">
        ${
          d.foto_path
            ? `
          <div class="relative">
            <img src="${d.foto_path}" class="w-full h-48 object-cover" />
            ${d.foto_caption ? `<p class="absolute bottom-0 inset-x-0 bg-black/60 text-xs text-white px-3 py-1">${d.foto_caption}</p>` : ""}
          </div>`
            : ""
        }
        <div class="p-4">
          <p class="font-bold mb-1">${d.judul}</p>
          ${d.isi ? `<p class="text-slate-300 text-sm leading-relaxed mb-3">${d.isi}</p>` : ""}
          <div class="flex flex-wrap gap-3">
            ${d.file_path ? `<a href="${d.file_path}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-slate-700 hover:bg-slate-600 px-3 py-1.5 rounded-lg transition">📎 ${d.file_name ?? "Unduh File"}</a>` : ""}
            ${d.link_eksternal ? `<a href="${d.link_eksternal}" target="_blank" class="inline-flex items-center gap-1 text-xs bg-indigo-600/30 hover:bg-indigo-600/50 px-3 py-1.5 rounded-lg transition text-indigo-300">🔗 Selengkapnya</a>` : ""}
          </div>
          <p class="text-slate-500 text-xs mt-3">${new Date(d.created_at).toLocaleDateString("id-ID", { day: "numeric", month: "long", year: "numeric" })}</p>
        </div>
      </div>
    `
        )
        .join("");
    } catch {
      list.innerHTML = '<p class="text-center text-slate-500 py-10">Gagal memuat informasi.</p>';
    }
  }

  window.openLightbox = function (src) {
    document.getElementById("lightboxImg").src = src;
    document.getElementById("lightbox").classList.remove("hidden");
    document.getElementById("lightbox").classList.add("flex");
  };

  // ---- GURU ----
  async function loadGuru() {
    const list = document.getElementById("guruPublicList");
    try {
      const res = await fetch(GURU_URL);
      const j = await res.json();
      const data = j.data ?? [];
      if (!data.length) {
        list.innerHTML = '<p class="text-center text-slate-500 py-10">Belum ada data.</p>';
        return;
      }
      list.innerHTML = data
        .map(
          (g) => `
        <div class="bg-slate-800/60 border border-white/10 rounded-2xl p-5 flex gap-4 items-start">
          ${
            g.foto_path
              ? `<img src="${g.foto_path}" class="w-16 h-16 rounded-2xl object-cover flex-shrink-0" />`
              : `<div class="w-16 h-16 rounded-2xl bg-slate-700 flex items-center justify-center text-2xl flex-shrink-0">👤</div>`
          }
          <div>
            <p class="font-semibold">${g.nama}</p>
            <p class="text-indigo-400 text-xs mb-2">${g.jabatan ?? ""}</p>
            <p class="text-slate-300 text-sm leading-relaxed">${g.kesan_pesan ?? '<em class="text-slate-500">Belum ada pesan.</em>'}</p>
          </div>
        </div>
      `
        )
        .join("");
    } catch {
      list.innerHTML = '<p class="text-center text-slate-500 py-10">Gagal memuat data.</p>';
    }
  }

  // ---- TESTIMONI ----
  async function loadTestimoni() {
    const list = document.getElementById("testimoniPublicList");
    try {
      const res = await fetch(TESTIMONI_URL);
      const j = await res.json();
      const data = j.data ?? [];
      if (!data.length) {
        list.innerHTML = '<p class="text-center text-slate-500 py-4">Belum ada testimoni.</p>';
        return;
      }
      list.innerHTML = data
        .map(
          (t) => `
        <div class="bg-slate-800/60 border border-white/10 rounded-xl p-4">
          <div class="flex justify-between items-start mb-2">
            <p class="font-semibold text-sm">${t.nama}</p>
            <span class="text-slate-500 text-xs">${new Date(t.created_at).toLocaleDateString("id-ID", { day: "numeric", month: "short", year: "numeric" })}</span>
          </div>
          <p class="text-slate-300 text-sm leading-relaxed">${t.isi}</p>
        </div>
      `
        )
        .join("");
    } catch {
      list.innerHTML = '<p class="text-center text-slate-500 py-4">Gagal memuat.</p>';
    }
  }

  async function kirimTestimoni() {
    const nama = document.getElementById("tNama").value.trim();
    const nisn = document.getElementById("tNisn").value.trim();
    const isi = document.getElementById("tIsi").value.trim();
    const msg = document.getElementById("testimoniMsg");

    if (!nama || !isi) {
      msg.textContent = "Nama dan isi wajib diisi.";
      msg.className = "text-center text-sm text-red-400";
      msg.classList.remove("hidden");
      return;
    }

    try {
      const res = await fetch(TESTIMONI_URL, {
        method: "POST",
        body: JSON.stringify({ nama, nisn, isi }),
        headers: { "Content-Type": "application/json" },
      });
      const j = await res.json();
      if (j.status === "success") {
        msg.textContent = "Terima kasih! Pesan kamu telah dikirim.";
        msg.className = "text-center text-sm text-emerald-400";
        document.getElementById("tNama").value = "";
        document.getElementById("tNisn").value = "";
        document.getElementById("tIsi").value = "";
        testimoniLoaded = false;
        loadTestimoni();
      } else {
        msg.textContent = j.message;
        msg.className = "text-center text-sm text-red-400";
      }
    } catch {
      msg.textContent = "Gagal mengirim. Coba lagi.";
      msg.className = "text-center text-sm text-red-400";
    }
    msg.classList.remove("hidden");
    setTimeout(() => msg.classList.add("hidden"), 4000);
  }

  // ---- INIT ----
  (async () => {
    // Quote acak
    document.getElementById("quoteText").textContent =
      `"${QUOTES[Math.floor(Math.random() * QUOTES.length)]}"`;

    // Load config pengumuman
    try {
      const res = await fetch(PENGUMUMAN_URL);
      const j = await res.json();
      pengumumanConfig = j.data;
      if (pengumumanConfig?.tanggal_waktu) {
        const target = new Date(pengumumanConfig.tanggal_waktu).getTime();
        startCountdown(target);
      } else {
        ["d", "h", "m", "s"].forEach((k) => {
          document.getElementById(`cd-${k}`).textContent = "00";
        });
      }
    } catch {
      ["d", "h", "m", "s"].forEach((k) => {
        document.getElementById(`cd-${k}`).textContent = "--";
      });
    }

    // Events
    document.getElementById("btnCariNisn").onclick = cariNisn;
    document.getElementById("nisnInput").addEventListener("keydown", (e) => {
      if (e.key === "Enter") cariNisn();
    });
    document.getElementById("btnKirimTestimoni").onclick = kirimTestimoni;

    document.getElementById("btnBukaAmplop").onclick = () => {
      if (isAmplopOpen()) openModalAmplop(siswaFound);
      else openModalBelumWaktu();
    };

    // Aktifkan beranda
    goSection("beranda");
    if (id === "info" && !infoLoaded) {
      loadInfo();
      infoLoaded = true;
    }
  })();
</script>

```
---

## ./package.json

```json
{
  "name": "presensi-rfid-astro",
  "type": "module",
  "version": "1.0.0",
  "scripts": {
    "dev": "astro dev",
    "build": "astro build",
    "preview": "astro preview",
    "astro": "astro"
  },
  "dependencies": {
    "@tailwindcss/vite": "^4.2.1",
    "astro": "^6.0.3",
    "tailwindcss": "^4.2.1"
  }
}

```
---

## ./tsconfig.json

```json
{
  "extends": "astro/tsconfigs/strict",
  "include": [".astro/types.d.ts", "**/*"],
  "exclude": ["dist"]
}

```
---
