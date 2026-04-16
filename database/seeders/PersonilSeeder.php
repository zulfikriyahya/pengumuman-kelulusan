<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PersonilSeeder extends Seeder
{
    public function run(): void
    {
        $personils = [
            ['nama' => 'Dr. Suwarno, M.Pd',        'nip' => '196501011990031001', 'jabatan' => 'Kepala Sekolah'],
            ['nama' => 'Dra. Hartini, M.M',         'nip' => '196703151992032002', 'jabatan' => 'Wakil Kepala Sekolah Bidang Kurikulum'],
            ['nama' => 'Bambang Eko Susilo, S.Pd',  'nip' => '197002201995031003', 'jabatan' => 'Wakil Kepala Sekolah Bidang Kesiswaan'],
            ['nama' => 'Sri Mulyani, S.Pd',         'nip' => '197108051998032004', 'jabatan' => 'Wakil Kepala Sekolah Bidang Sarana'],
            ['nama' => 'Agus Triyono, S.Pd',        'nip' => '197305101999031005', 'jabatan' => 'Wakil Kepala Sekolah Bidang Humas'],
            ['nama' => 'Siti Khoiriyah, S.Pd',      'nip' => '197506152000032006', 'jabatan' => 'Guru Matematika'],
            ['nama' => 'Hendra Gunawan, S.Pd',      'nip' => '197708202001031007', 'jabatan' => 'Guru Fisika'],
            ['nama' => 'Dewi Ratnasari, S.Pd',      'nip' => '197809252002032008', 'jabatan' => 'Guru Kimia'],
            ['nama' => 'Aris Budiman, S.Pd',        'nip' => '197910302003031009', 'jabatan' => 'Guru Biologi'],
            ['nama' => 'Nurul Hidayah, S.Pd',       'nip' => '198001052004032010', 'jabatan' => 'Guru Bahasa Indonesia'],
            ['nama' => 'Muhamad Yusuf, S.Pd',       'nip' => '198103102005031011', 'jabatan' => 'Guru Bahasa Inggris'],
            ['nama' => 'Rina Oktavia, S.Pd',        'nip' => '198205152006032012', 'jabatan' => 'Guru Sejarah'],
            ['nama' => 'Dedi Kurniawan, S.Pd',      'nip' => '198307202007031013', 'jabatan' => 'Guru Geografi'],
            ['nama' => 'Fitri Handayani, S.Pd',     'nip' => '198409252008032014', 'jabatan' => 'Guru Ekonomi'],
            ['nama' => 'Eko Prasetyo, S.Pd',        'nip' => '198511302009031015', 'jabatan' => 'Guru Sosiologi'],
            ['nama' => 'Anita Sari, S.Pd',          'nip' => '198612052010032016', 'jabatan' => 'Guru PKn'],
            ['nama' => 'Rudi Hermawan, S.Pd',       'nip' => '198714102011031017', 'jabatan' => 'Guru Pendidikan Agama Islam'],
            ['nama' => 'Lestari Wulandari, S.Pd',   'nip' => '198816152012032018', 'jabatan' => 'Guru Seni Budaya'],
            ['nama' => 'Wahyu Setiawan, S.Pd',      'nip' => '198918202013031019', 'jabatan' => 'Guru Penjasorkes'],
            ['nama' => 'Mega Puspita, S.Kom',       'nip' => '199020252014032020', 'jabatan' => 'Guru TIK'],
            ['nama' => 'Fajar Nugroho, S.Pd',       'nip' => '199122302015031021', 'jabatan' => 'Guru Bimbingan Konseling'],
            ['nama' => 'Ratna Dewi, S.Pd',          'nip' => '199224052016032022', 'jabatan' => 'Guru Bimbingan Konseling'],
            ['nama' => 'Surya Darma, S.E',          'nip' => '199326102017031023', 'jabatan' => 'Kepala Tata Usaha'],
            ['nama' => 'Yanti Andriani, S.E',       'nip' => '199428152018032024', 'jabatan' => 'Staf Tata Usaha Keuangan'],
            ['nama' => 'Bimo Saputro, A.Md',        'nip' => '199530202019031025', 'jabatan' => 'Staf Tata Usaha Kepegawaian'],
            ['nama' => 'Dian Fitriani, A.Md',       'nip' => '199632252020032026', 'jabatan' => 'Staf Tata Usaha Umum'],
            ['nama' => 'Adi Santoso, S.Pd',         'nip' => '199734302021031027', 'jabatan' => 'Guru Matematika'],
            ['nama' => 'Tini Rahayu, S.Pd',         'nip' => '199836052022032028', 'jabatan' => 'Guru Bahasa Jawa'],
            ['nama' => 'Hadi Purnomo, S.Pd',        'nip' => '199938102023031029', 'jabatan' => 'Guru Prakarya'],
            ['nama' => 'Winda Safitri, S.Pd',       'nip' => '200040152024032030', 'jabatan' => 'Guru Bahasa Inggris'],
            ['nama' => 'Sigit Wahyono, S.Pd',       'nip' => null,                 'jabatan' => 'Guru Honorer Matematika'],
            ['nama' => 'Layla Indriani, S.Pd',      'nip' => null,                 'jabatan' => 'Guru Honorer IPA'],
            ['nama' => 'Bayu Nugroho, S.Pd',        'nip' => null,                 'jabatan' => 'Guru Honorer IPS'],
            ['nama' => 'Rosita Amelia, S.Pd',       'nip' => null,                 'jabatan' => 'Guru Honorer Bahasa Indonesia'],
            ['nama' => 'Dony Setiawan, S.Kom',      'nip' => null,                 'jabatan' => 'Guru Honorer TIK'],
            ['nama' => 'Ani Kusumawati, S.Pd',      'nip' => null,                 'jabatan' => 'Guru Honorer Seni Budaya'],
            ['nama' => 'Rohmat Efendi',              'nip' => null,                 'jabatan' => 'Petugas Perpustakaan'],
            ['nama' => 'Suyono',                     'nip' => null,                 'jabatan' => 'Petugas Laboratorium'],
            ['nama' => 'Marno Susanto',              'nip' => null,                 'jabatan' => 'Petugas Kebersihan'],
            ['nama' => 'Parmin',                     'nip' => null,                 'jabatan' => 'Petugas Kebersihan'],
            ['nama' => 'Sutejo',                     'nip' => null,                 'jabatan' => 'Petugas Keamanan'],
            ['nama' => 'Sarno',                      'nip' => null,                 'jabatan' => 'Petugas Keamanan'],
            ['nama' => 'Didik Prasetyo',             'nip' => null,                 'jabatan' => 'Petugas UKS'],
            ['nama' => 'Endah Rahmawati, A.Md',     'nip' => null,                 'jabatan' => 'Petugas Perpustakaan'],
            ['nama' => 'Haryono',                    'nip' => null,                 'jabatan' => 'Petugas Kantin'],
            ['nama' => 'Srimulyono, S.Pd',          'nip' => '198540012025031046', 'jabatan' => 'Koordinator Ekskul'],
            ['nama' => 'Dita Permata, S.Pd',        'nip' => null,                 'jabatan' => 'Pembina OSIS'],
            ['nama' => 'Fery Ardian, S.Pd',         'nip' => null,                 'jabatan' => 'Pembina Pramuka'],
            ['nama' => 'Nuning Listiani, S.Pd',     'nip' => null,                 'jabatan' => 'Pembina PMR'],
            ['nama' => 'Galuh Prabowo, S.Pd',       'nip' => null,                 'jabatan' => 'Pembina Olahraga'],
        ];

        $quotes = [
            'Mendidik bukan sekadar mengajar, tapi membentuk karakter generasi bangsa.',
            'Guru yang baik bukan yang paling pintar, tapi yang paling sabar.',
            'Setiap murid adalah bintang yang menunggu untuk bersinar.',
            'Investasi terbaik adalah investasi pada pendidikan.',
            'Mengajar adalah profesi yang menciptakan semua profesi lainnya.',
        ];

        $now = Carbon::now();
        $data = [];

        foreach ($personils as $i => $p) {
            $data[] = [
                'id'           => Str::uuid(),
                'nama'         => $p['nama'],
                'nip'          => $p['nip'],
                'foto'         => null,
                'telepon'      => null,
                'sosial_media' => null,
                'jabatan'      => $p['jabatan'],
                'quote'        => $quotes[$i % count($quotes)],
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        DB::table('personils')->insert($data);
    }
}
