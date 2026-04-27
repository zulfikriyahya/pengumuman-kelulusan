<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $namaAlumni = [
            'Agung Prasetyo',
            'Bagas Wicaksono',
            'Candra Kusuma',
            'Dita Ayu',
            'Endra Saputra',
            'Fadillah Rahma',
            'Gilang Nugroho',
            'Hesti Wulandari',
            'Ivan Kurniawan',
            'Jihan Nabila',
            'Khoirul Anam',
            'Laila Fitri',
            'Miko Setiawan',
            'Nina Rahayu',
            'Omar Abdillah',
            'Puspita Dewi',
            'Qurrotul Aini',
            'Raka Mahendra',
            'Salma Aulia',
            'Taufiq Rahman',
            'Ulul Azmi',
            'Vina Septiani',
            'Wahid Fathoni',
            'Xaverius Budi',
            'Yeni Permata',
            'Zaid Mubarak',
            'Agus Hermawan',
            'Bella Safira',
            'Chandra Iswanto',
            'Desy Natalia',
            'Elsa Pertiwi',
            'Faris Mubarok',
            'Galih Prakoso',
            'Hana Azzahra',
            'Imam Syafi\'i',
            'Juwita Sari',
            'Kiki Amalia',
            'Luthfi Hakim',
            'Maulida Zahrani',
            'Nando Pratama',
            'Okta Rinaldi',
            'Prima Yudhistira',
            'Qisthi Nabilah',
            'Rendi Saputro',
            'Safa Ayu',
            'Toni Hermawan',
            'Umi Kulsum',
            'Vito Surya',
            'Wilda Rahmawati',
            'Yuda Permana',
        ];

        $quotes = [
            'Belajar tanpa berpikir adalah sia-sia, berpikir tanpa belajar adalah berbahaya.',
            'Kesuksesan adalah hasil dari persiapan, kerja keras, dan belajar dari kegagalan.',
            'Pendidikan adalah senjata paling ampuh untuk mengubah dunia.',
            'Bermimpilah setinggi langit, jika jatuh kau akan jatuh di antara bintang-bintang.',
            'Jangan pernah menyerah karena hal-hal besar butuh waktu.',
            'Ilmu tanpa amal seperti pohon tanpa buah.',
            'Masa depan milik mereka yang percaya pada keindahan mimpi-mimpi mereka.',
            'Setiap hari adalah kesempatan baru untuk belajar sesuatu yang lebih baik.',
            'Kerja keras mengalahkan bakat ketika bakat tidak mau bekerja keras.',
            'Jadi dirimu sendiri, semua orang lain sudah terambil.',
        ];

        $tahunLulus = ['2020', '2021', '2022', '2023', '2024'];
        $now = Carbon::now();
        $alumnis = [];

        for ($i = 0; $i < 50; $i++) {
            $nisnBase = 2000000000 + ($i * 11 + 3);
            $alumnis[] = [
                'id'          => Str::uuid(),
                'nama'        => $namaAlumni[$i],
                'nisn'        => str_pad($nisnBase % 10000000000, 10, '0', STR_PAD_LEFT),
                'tahun_lulus' => $tahunLulus[$i % count($tahunLulus)],
                'foto'      => null,
                'quote'       => $quotes[$i % count($quotes)],
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        DB::table('alumnis')->insert($alumnis);
    }
}
