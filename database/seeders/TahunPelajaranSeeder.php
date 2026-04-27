<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TahunPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tahun_pelajarans')->insert([
            'id' => Str::uuid(),
            'name' => '2025/2026',
            'jadwal_pengumuman_mulai' => Carbon::create(2026, 4, 1, 8, 0, 0),
            'jadwal_pengumuman_selesai' => Carbon::create(2026, 4, 31, 23, 59, 59),
            'jadwal_kelulusan_mulai' => Carbon::create(2026, 4, 1, 8, 0, 0),
            'jadwal_kelulusan_selesai' => Carbon::create(2026, 4, 31, 12, 0, 0),
            'jadwal_kelulusan_tempat' => 'Aula Gedung Diklat Kabupaten Pandeglang',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
