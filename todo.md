Dependensi :

{

  "name": "madrasah-universe-pengumuman-kelulusan",

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

Fitur:
- Halaman Admin (Gunakan username dan password untuk mengelola data pada tampilan publik)
- Halaman Album : Menampilkan Foto galeri yang diupload admin
- Halaman Cari Masukkan NISN Untuk Membuka Amplop
- Halaman Buka Amplop / Section Buka Amplop Berdasarkan Waktu Mundur (Amplop dapat diklik buka jika sudah waktunya dan menampilkan modal informasi jika belum Waktunya)
- Halaman Album Pegawai dan Guru Yang menampilkan Nama, Foto, Kesan Pesan.
- Halaman Masukkan Testimoni, Kesan Pesan.

Ketentuan (Halaman dashboard admin):
Data Yang dimasukkan :
- Identitas SIswa: Nama Lengkap, NISN, Kelas, Jenis Kelamin, tahun pelajaran, Status kelulusan: Lulus, Tidak Lulus, Lulus Bersyarat
- input data dengan di import
- input data tanggal dan waktu pengumuman dan status aktifkan
- ada fitur tambah, hapus, edit, hapus semua,
- ada filter tampilan data, per jenis kelamin, tahun pelajaran, status kelulusan, perkelas
- ada filter pencarian berdasarkan nama atau nisn

Database menggunakan mysql (Gunakan PHP untuk backend)
