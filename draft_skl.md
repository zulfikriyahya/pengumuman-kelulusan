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

[MODEL]
- Instansi:
    id: uuid
    nama: string
    npsn: string:8 unique
    logo: string nullable
    logo_institusi: string nullable
    nomor_surat: string nullable
    nama_pimpinan: string nullable
    nip_pimpinan: string nullable
    tte_pimpinan: string nullable
    nama_ketua: string nullable
    nip_ketua: string nullable
    tte_ketua: string nullable
    jenjang: enum:'SD','MI','SMP','MTS','SMA','SMK','MA'
    akreditasi: enum:'A','B','C','D','TT'
    status: boolean
- User:
    id: int
    name: string
    username: string
    password: string hashed
    avatar: string nullable
    telepon: string nullable
- TahunPelajaran:
    id: uuid
    name: string
    jadwal_pengumuman_mulai: datetime
    jadwal_pengumuman_selesai: datetime
    jadwal_kelulusan_mulai: datetime nullable
    jadwal_kelulusan_selesai: datetime nullable
    jadwal_kelulusan_tempat: string nullable
    status: boolean
- Siswa:
    id: uuid
    nama: string
    nama_orangtua: string nullable
    nisn: string:10 unique
    berkas_skl: string nullable
    telepon: string:15 unique nullable
    status: enum:'Lulus','Tidak Lulus','Lulus Bersyarat'
    barcode_url: string nullable
    relationships:
      hasMany: TamuUndangan
- Alumni:
    id: uuid
    nama: string
    nisn: string:10 unique
    tahun_lulus: string:4
    avatar: string nullable
    quote: text nullable
- Personil:
    id: uuid
    nama: string
    nip: string nullable
    foto: string nullable
    telepon: string:15 nullable
    sosial_media: string nullable
    jabatan: string
    quote: text nullable
- TamuUndangan:
    id: uuid
    siswa_id: id foreignId:siswas
    jumlah_tamu: integer nullable default:1
    relationships:
      belongsTo: Siswa

[CONTROLLER]
- LandingPage
- Personil
- Alumni
- Tamu Undangan

[PAGES] -> (Blade Templating Engine)
- Landing Page -> Countdown -> Buka Amplop Kelulusan -> Pencarian Siswa by nisn|telepon -> Cetak Dokumen Kelulusan & Surat Undangan (Jika Status Tidak Lulus, Hanya cetak Dokumen Kelulusan)
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
