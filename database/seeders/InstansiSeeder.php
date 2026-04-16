<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('instansis')->insert([
            'id'               => Str::uuid(),
            'nama'             => 'MTs Negeri 1 Pandeglang',
            'npsn'             => '20123456',
            'logo'             => null,
            'logo_institusi'   => null,
            'nomor_surat'      => '421.3/001/MTSN1/2026',
            'nama_pimpinan'    => 'Hj. Yanti Mariah, S.S., M.Pd',
            'nip_pimpinan'     => '111111111111111111',
            'tte_pimpinan'     => null,
            'nama_ketua'       => 'Yahya Zulfikri, M.Pd',
            'nip_ketua'        => '000000000000000000',
            'tte_ketua'        => null,
            'jenjang'          => 'MTS',
            'akreditasi'       => 'A',
            'status'           => true,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now(),
        ]);
    }
}
