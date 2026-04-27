<?php

use App\Console\Commands\BroadcastKelulusan;
use App\Models\TahunPelajaran;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

Schedule::command(BroadcastKelulusan::class)
    ->dailyAt('07:00')
    ->when(
        fn () => TahunPelajaran::where('status', true)
            ->whereDate('jadwal_pengumuman_mulai', today())
            ->exists()
    );

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Generate template Excel untuk semua entitas.
 *
 * Usage: php artisan export:template
 */
Artisan::command('export:template', function () {
    // ── Template Siswa ────────────────────────────────────────────
    Excel::store(
        new class implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
        {
            public function array(): array
            {
                return [
                    ['Budi Santoso', 'Ahmad Santoso', '0012345678', '08123456789', 'Lulus'],
                    ['Siti Rahayu',  'Budi Rahayu',   '0098765432', '08199999999', 'Tidak Lulus'],
                ];
            }

            public function headings(): array
            {
                return ['nama', 'nama_orangtua', 'nisn', 'telepon', 'status'];
            }

            public function styles(Worksheet $sheet): array
            {
                return [1 => [
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D9488']],
                ]];
            }
        },
        'templates/template-siswa.xlsx',
        'public'
    );
    $this->info('✓ template-siswa.xlsx');

    // ── Template Personil ─────────────────────────────────────────
    Excel::store(
        new class implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
        {
            public function array(): array
            {
                return [
                    ['Siti Aminah, S.Pd', '196501011990032001', 'Guru Matematika', '08111111111', 'https://instagram.com/siti', 'Semangat belajar!'],
                    ['Drs. Hendra',       '',                   'Wali Kelas XII',  '08222222222', '',                           'Terus berkarya'],
                ];
            }

            public function headings(): array
            {
                return ['nama', 'nip', 'jabatan', 'telepon', 'sosial_media', 'quote'];
            }

            public function styles(Worksheet $sheet): array
            {
                return [1 => [
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D9488']],
                ]];
            }
        },
        'templates/template-personil.xlsx',
        'public'
    );
    $this->info('✓ template-personil.xlsx');

    // ── Template Alumni ───────────────────────────────────────────
    Excel::store(
        new class implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
        {
            public function array(): array
            {
                return [
                    ['Budi Santoso', '0012345678', '2024', 'Terus semangat meraih mimpi!'],
                    ['Siti Rahayu',  '0098765432', '2024', ''],
                ];
            }

            public function headings(): array
            {
                return ['nama', 'nisn', 'tahun_lulus', 'quote'];
            }

            public function styles(Worksheet $sheet): array
            {
                return [1 => [
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D9488']],
                ]];
            }
        },
        'templates/template-alumni.xlsx',
        'public'
    );
    $this->info('✓ template-alumni.xlsx');

    $this->info('');
    $this->info('Semua template berhasil dibuat di storage/app/public/templates/');
})->purpose('Buat template Excel untuk import siswa, personil, dan alumni');
