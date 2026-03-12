# Madrasah Universe — Pengumuman Kelulusan

Aplikasi web pengumuman kelulusan siswa berbasis PWA. Siswa dapat mencari status kelulusan menggunakan NISN, melihat album foto, membaca pesan guru, dan menulis testimoni. Admin dapat mengelola seluruh konten melalui panel admin.

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Frontend | Astro, Tailwind CSS v4, Vanilla JS |
| Backend | PHP 8.1+, PDO |
| Database | MySQL / MariaDB |
| Server (dev) | PHP Built-in Server, Astro Dev Server |

---

## Struktur Project

```
.
├── api/                        # Backend PHP
│   ├── config/
│   │   └── db.php              # Koneksi DB, helper, validasi upload
│   ├── auth/index.php          # Login, logout, cek sesi
│   ├── siswa/index.php         # CRUD data siswa + import CSV
│   ├── pengumuman/index.php    # Konfigurasi waktu & status pengumuman
│   ├── album/index.php         # Upload & hapus foto album
│   ├── guru/index.php          # CRUD guru & pegawai
│   ├── testimoni/index.php     # CRUD testimoni + approve
│   ├── informasi/index.php     # CRUD informasi & lampiran
│   ├── router.php              # Front controller + static file serving
│   └── setup.php              # Inisialisasi password admin (sekali jalan)
├── database/
│   └── schema.sql              # Skema database
├── public/
│   ├── manifest.json
│   ├── sw.js
│   └── icons/
├── src/
│   ├── layouts/Layout.astro
│   ├── pages/
│   │   ├── index.astro         # Halaman publik
│   │   └── admin/index.astro   # Panel admin
│   └── styles/global.css
├── uploads/                    # File yang diupload (auto-generated)
│   ├── album/
│   ├── guru/
│   └── informasi/
│       ├── foto/
│       └── file/
├── .env                        # Env frontend — development
├── .env.production             # Env frontend — production
└── api/.env                    # Env backend
```

---

## Instalasi & Setup

### 1. Clone & Install Dependencies

```bash
git clone <repo-url>
cd madrasah-universe
pnpm install
```

### 2. Buat Database

Import skema ke MySQL:

```bash
mysql -u root -p < database/schema.sql
```

### 3. Konfigurasi Backend

Salin contoh env dan isi nilainya:

```bash
cp api/.env.example api/.env
```

Edit `api/.env`:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=madrasah_kelulusan
DB_USER=root
DB_PASS=password_anda

ADMIN_USERNAME=admin
ADMIN_PASSWORD=password_admin_anda
SETUP_TOKEN=token_rahasia_anda

UPLOAD_DIR=../uploads/
PUBLIC_URL=http://localhost:3000/uploads

ALLOWED_ORIGIN=http://localhost:4321
```

### 4. Konfigurasi Frontend

File `.env` sudah tersedia untuk development:

```env
PUBLIC_API_BASE=http://localhost:4321/api
PUBLIC_UPLOAD_BASE=http://localhost:4321
```

### 5. Buat Direktori Upload

```bash
mkdir -p uploads/album uploads/guru uploads/informasi/foto uploads/informasi/file
```

### 6. Jalankan PHP Server

```bash
php -S localhost:3000 -t api api/router.php
```

### 7. Jalankan Astro Dev Server

```bash
pnpm dev
```

Aplikasi tersedia di `http://localhost:4321`.

### 8. Inisialisasi Password Admin

Jalankan sekali setelah server PHP berjalan:

```bash
curl "http://localhost:3000/setup.php?token=token_rahasia_anda"
```

---

## Build Production

### 1. Buat file `.env.production`

```env
PUBLIC_API_BASE=http://ip-atau-domain-server:3000/api
PUBLIC_UPLOAD_BASE=http://ip-atau-domain-server:3000
```

Sesuaikan dengan IP atau domain server PHP production.

### 2. Build

```bash
pnpm build
```

Output ada di folder `dist/`. Serve folder ini menggunakan web server statis (Nginx, Apache, atau `astro preview`).

### 3. Update CORS Backend

Edit `api/.env` di server production:

```env
ALLOWED_ORIGIN=https://domain-frontend-anda.com
```

---

## Fitur

### Halaman Publik
- **Beranda** — countdown pengumuman dan quote acak
- **Cari Kelulusan** — cari status via NISN, buka amplop dengan animasi
- **Album** — galeri foto kenangan dengan lightbox
- **Guru & Pegawai** — kesan dan pesan dari guru
- **Testimoni** — form kirim pesan + daftar testimoni yang sudah diapprove
- **Informasi** — pengumuman resmi dengan lampiran file dan link

### Panel Admin (`/admin`)
- **Data Siswa** — tambah, edit, hapus, import CSV, filter & pagination
- **Pengumuman** — atur tanggal waktu dan aktifkan/nonaktifkan pengumuman
- **Album Foto** — upload multiple foto
- **Guru & Pegawai** — tambah, edit, hapus, import batch dengan foto
- **Testimoni** — moderasi (approve/reject), edit, hapus bulk
- **Informasi** — tambah konten dengan foto, file attachment, dan link eksternal

---

## Format CSV Import Siswa

```csv
nama_lengkap,nisn,kelas,jenis_kelamin,tahun_pelajaran,status_kelulusan
Ahmad Fauzan,1234567890,IX-A,L,2024/2025,Lulus
Siti Aisyah,0987654321,IX-B,P,2024/2025,Tidak Lulus
```

Nilai `status_kelulusan` yang valid: `Lulus`, `Tidak Lulus`, `Lulus Bersyarat`.

File template tersedia di `public/template_import_siswa.csv`.

---

## API Endpoints

### Auth
| Method | Endpoint | Deskripsi |
|---|---|---|
| POST | `/auth?action=login` | Login admin |
| POST | `/auth?action=logout` | Logout |
| GET | `/auth?action=check` | Cek status sesi |

### Siswa
| Method | Endpoint | Deskripsi |
|---|---|---|
| GET | `/siswa` | Daftar siswa (filter: `q`, `kelas`, `jenis_kelamin`, `status_kelulusan`, `tahun_pelajaran`) |
| GET | `/siswa?id=nisn&nisn=xxx` | Cari siswa by NISN |
| POST | `/siswa` | Tambah siswa |
| POST | `/siswa?action=import` | Import bulk via JSON |
| PUT | `/siswa?id=xxx` | Update siswa |
| DELETE | `/siswa?id=xxx` | Hapus siswa |
| DELETE | `/siswa?id=all` | Hapus semua siswa |

### Pengumuman
| Method | Endpoint | Deskripsi |
|---|---|---|
| GET | `/pengumuman` | Ambil konfigurasi |
| POST | `/pengumuman` | Simpan konfigurasi |

### Album, Guru, Informasi
| Method | Endpoint | Deskripsi |
|---|---|---|
| GET | `/{resource}` | Daftar data |
| POST | `/{resource}` | Tambah (multipart/form-data) |
| PUT | `/{resource}?id=xxx` | Update |
| DELETE | `/{resource}?id=xxx` | Hapus |

### Testimoni
| Method | Endpoint | Deskripsi |
|---|---|---|
| GET | `/testimoni` | Daftar (publik: approved saja) |
| POST | `/testimoni` | Kirim testimoni baru |
| POST | `/testimoni?action=approve` | Approve/reject bulk |
| POST | `/testimoni?action=bulk-delete` | Hapus bulk |
| PUT | `/testimoni?id=xxx` | Edit |
| DELETE | `/testimoni?id=xxx` | Hapus |

---

## Catatan Keamanan

- File `api/setup.php` dilindungi token. Setelah setup selesai, tambahkan `SETUP_TOKEN` yang kuat di `api/.env`.
- Upload file divalidasi menggunakan MIME type sebenarnya (`finfo`), bukan hanya ekstensi.
- Session cookie menggunakan `httponly: true` dan `secure: true` otomatis saat HTTPS.
- Jangan commit `api/.env` ke repository — sudah masuk `.gitignore`.
