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
CREATE TABLE IF NOT EXISTS informasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    isi TEXT,
    foto_path VARCHAR(500),
    foto_caption VARCHAR(255),
    file_path VARCHAR(500),
    file_name VARCHAR(255),
    link_eksternal VARCHAR(500),
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
ALTER TABLE testimoni ADD COLUMN is_approved TINYINT(1) NOT NULL DEFAULT 0 AFTER isi;

INSERT INTO admin (username, password)
VALUES ('admin', '$2y$12$placeholder_will_be_generated_on_setup');
