<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $statusOptions = ['Lulus', 'Tidak Lulus', 'Lulus Bersyarat'];

        $namaSiswa = [
            'Ahmad Fauzi',
            'Budi Santoso',
            'Citra Dewi',
            'Dian Pratiwi',
            'Eko Wahyudi',
            'Fitri Rahayu',
            'Gilang Permana',
            'Hani Safitri',
            'Irfan Maulana',
            'Joko Susilo',
            'Kartika Sari',
            'Lukman Hakim',
            'Maya Anggraini',
            'Nanda Kurniawan',
            'Olivia Putri',
            'Putra Ramadhan',
            'Qori Hidayah',
            'Rizky Aditya',
            'Siti Aisyah',
            'Teguh Wibowo',
            'Ulfa Nurjanah',
            'Vino Saputra',
            'Wulandari Susanto',
            'Xena Maharani',
            'Yusuf Effendi',
            'Zahra Nadia',
            'Andi Firmansyah',
            'Bella Kusuma',
            'Cahyo Nugroho',
            'Devi Permatasari',
            'Erwin Setiawan',
            'Fanny Oktavia',
            'Gunawan Prasetyo',
            'Hendra Wijaya',
            'Indah Lestari',
            'Jefri Andriyanto',
            'Krisna Bayu',
            'Lina Marlina',
            'Muhamad Iqbal',
            'Novi Andriani',
            'Oscar Pratama',
            'Putri Handayani',
            'Qodir Maulana',
            'Reni Astuti',
            'Syahrul Ramli',
            'Tia Ratnasari',
            'Umar Faruq',
            'Viska Amelia',
            'Wahyu Hidayat',
            'Zulkifli Nasir',
        ];

        $namaOrangTua = [
            'Slamet Riyadi',
            'Bambang Supriyanto',
            'Heru Santoso',
            'Agus Setiawan',
            'Darmawan',
            'Sunarto',
            'Wiyono',
            'Sukirman',
            'Rohmad',
            'Parwoto',
            'Suharto',
            'Mulyadi',
            'Triyono',
            'Sugiyanto',
            'Purwanto',
            'Sumarno',
            'Hartono',
            'Widodo',
            'Sarjono',
            'Budiman',
            'Sutrisno',
            'Ngadimin',
            'Siswanto',
            'Prayitno',
            'Wahyono',
            'Suprapto',
            'Teguh Santosa',
            'Kusnan',
            'Sumardi',
            'Bowo Leksono',
            'Arifin',
            'Sugiarto',
            'Hari Purnomo',
            'Basuki',
            'Jatmiko',
            'Riyanto',
            'Susanto',
            'Karyadi',
            'Edi Purnomo',
            'Sodik',
            'Marwoto',
            'Sutarno',
            'Darwis',
            'Harun',
            'Kurniadi',
            'Sunaryo',
            'Winarto',
            'Paimin',
            'Nuryanto',
            'Supardi',
        ];

        $now = Carbon::now();
        $siswas = [];

        for ($i = 0; $i < 50; $i++) {
            $nisnBase = 1000000000 + ($i * 13 + 7); // unik, deterministik
            $siswas[] = [
                'id'            => Str::uuid(),
                'nama'          => $namaSiswa[$i],
                'nama_orangtua' => $namaOrangTua[$i],
                'nisn'          => str_pad($nisnBase, 10, '0', STR_PAD_LEFT),
                'berkas_skl'    => null,
                'telepon'       => '08' . str_pad(10000000 + ($i * 77777), 10, '0', STR_PAD_LEFT),
                'status'        => $statusOptions[$i % 3 === 0 ? ($i % 2 === 0 ? 1 : 2) : 0],
                'barcode_url'   => null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        DB::table('siswas')->insert($siswas);
    }
}
