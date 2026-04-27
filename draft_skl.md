[LAYANAN SKL]

[DOMAIN]
- kelulusan.mtsn1pandeglang.sch.id
- github.com/zulfikriyahya/kelulusan.git branch: main

[TECHSTACK]
- Laravel 13
- Filament 5
- TailwindCSS 4
- MariaDB
- PHP 8.5
- FrankenPHP + Octane
- PDF
- Blueprint Laravel
- Whatsapp API {
url: wapi.zedlabs.id/send/messages
token : [32Char]
}

[CONTROLLER]
- LandingPage
- Personil
- Alumni
- Tamu Undangan

[PAGES] -> (Blade Templating Engine)
- Landing Page -> Countdown -> Pencarian Siswa by nisn|telepon -> Cetak Dokumen Kelulusan & Surat Undangan (Jika Status Tidak Lulus, Hanya cetak Dokumen Kelulusan)
- Personil -> Pencarian Personil by nama
- Alumni -> Pencarian Alumni by nama|nisn
- Tamu Undangan -> Muncul Ketika rentang jadwal_kelulusan_mulai dan jadwal_kelulusan_selesai -> Scan QR Dokumen Surat Undangan -> Input Jumlah PAX -> Simpan -> Tampilkan Tabel Tamu Undangan Dengan Nama Siswa, Nama Orang Tua Siswa, Jumlah PAX

[FEATURE]
- Statistik Kelulusan Pertahun Pelajaran [Lulus, Tidak Lulus, Lulus Bersyarat]
- Cetak Daftar Hadir Tamu (Panel Kelulusan)
- Import Data Siswa (key: nisn -> update jika ada data)
- Import Data Alumni (key: nisn -> update jika ada data)
- Import Data Personil (key: nip -> update jika ada data)
- Import Dokumen Kelulusan (filename: <nisn>.pdf -> update (replace) jika ada data)
- Handle Error Page [redirect ke halaman Landing]
- Handle Error Page Panel [redirect ke halaman Dashboard]
- Broadcast Pesan Whatsapp ke Siswa jika memasuki Waktu Kelulusan -> Pesan "Pengumuman Kelulusan sudah dapat diakses pada Halaman: kelulusan.mtsn1pandeglang.sch.id dan informasikan tanggal, waktu, dan tempat acara kelulusan (Jika jadwal_kelulusan_mulai, jadwal_kelulusan_selesai dan waktu jadwal_kelulusan_tempat memiliki nilai tanggal dan tempat.)" -> Rate Limit, Delay Acak, Retry Jika gagal
