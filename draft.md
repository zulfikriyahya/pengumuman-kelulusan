# Laravel Project Blueprint

## 📁 Directory: Root Files

Configuration and setup files in project root.

### 📄 File: `./.editorconfig`

```
root = true

[*]
charset = utf-8
end_of_line = lf
indent_size = 4
indent_style = space
insert_final_newline = true
trim_trailing_whitespace = true

[*.md]
trim_trailing_whitespace = false

[*.{yml,yaml}]
indent_size = 2

[compose.yaml]
indent_size = 4

```

---

### 📄 File: `./artisan`

_Laravel command-line interface._

```
#!/usr/bin/env php
<?php

use Illuminate\Foundation\Application;
use Symfony\Component\Console\Input\ArgvInput;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel and handle the command...
/** @var Application $app */
$app = require_once __DIR__ . '/bootstrap/app.php';

$status = $app->handleCommand(new ArgvInput);

exit($status);

```

---

### 📄 File: `./composer.json`

_PHP dependencies and project metadata._

```json
{
    "$schema": "https://getcomposer.org/schema.json",
    "name": "laravel/laravel",
    "type": "project",
    "description": "The skeleton application for the Laravel framework.",
    "keywords": [
        "laravel",
        "framework"
    ],
    "license": "MIT",
    "require": {
        "php": "^8.3",
        "barryvdh/laravel-dompdf": "*",
        "devonab/filament-easy-footer": "^2.0",
        "diogogpinto/filament-auth-ui-enhancer": "^2.0",
        "filament/filament": "*",
        "laravel/framework": "^13.0",
        "laravel/tinker": "^3.0",
        "maatwebsite/excel": "*",
        "simplesoftwareio/simple-qrcode": "^4.2"
    },
    "require-dev": {
        "laravel/pint": "^1.27"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "setup": [
            "composer install",
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\"",
            "@php artisan key:generate",
            "@php artisan migrate --force",
            "npm install --ignore-scripts",
            "npm run build"
        ],
        "dev": [
            "Composer\\Config::disableProcessTimeout",
            "npx concurrently -c \"#93c5fd,#c4b5fd,#fdba74\" \"php artisan serve\" \"php artisan queue:listen --tries=1\" \"npm run dev\" --names='server,queue,vite'"
        ],
        "test": [
            "@php artisan config:clear --ansi",
            "@php artisan test"
        ],
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi",
            "@php artisan filament:upgrade"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi",
            "@php -r \"file_exists('database/database.sqlite') || touch('database/database.sqlite');\"",
            "@php artisan migrate --graceful --ansi"
        ],
        "pre-package-uninstall": [
            "Illuminate\\Foundation\\ComposerScripts::prePackageUninstall"
        ]
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        }
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}

```

---

### 📄 File: `./package.json`

_Node.js dependencies and build scripts._

```json
{
    "$schema": "https://www.schemastore.org/package.json",
    "private": true,
    "type": "module",
    "scripts": {
        "build": "vite build",
        "dev": "vite"
    },
    "devDependencies": {
        "@tailwindcss/vite": "^4.2.2",
        "axios": ">=1.11.0 <=1.14.0",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^3.0.0",
        "tailwindcss": "^4.2.2",
        "vite": "^8.0.0"
    },
    "dependencies": {
        "chartjs-plugin-datalabels": "^2.2.0"
    }
}

```

---

### 📄 File: `./phpunit.xml`

_PHPUnit testing configuration._

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
    </testsuites>
    <source>
        <include>
            <directory>app</directory>
        </include>
    </source>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="APP_MAINTENANCE_DRIVER" value="file"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="BROADCAST_CONNECTION" value="null"/>
        <env name="CACHE_STORE" value="array"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="DB_URL" value=""/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="PULSE_ENABLED" value="false"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
        <env name="NIGHTWATCH_ENABLED" value="false"/>
    </php>
</phpunit>

```

---

### 📄 File: `./vite.config.js`

_Vite build tool configuration._

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/filament/admin/theme.css'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

```

---

## 📁 Directory: app (Application Core)

Contains models, controllers, services, and business logic.

### 📄 File: `./app/Actions/ImportDokumen.php`

```php
<?php

namespace App\Actions;

use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ImportDokumen
{
    /**
     * @param  string  $zipPath  Path absolut ke file ZIP
     * @param  string  $kolom  Kolom pada model Siswa: 'berkas_skl' | 'berkas_undangan'
     * @param  string  $dir  Direktori storage tujuan: 'skl' | 'undangan'
     * @param  string  $label  Label untuk log/notifikasi: 'SKL' | 'Undangan'
     * @return array{berhasil: int, dilewati: int, gagal: int, log: string[]}
     */
    public function execute(string $zipPath, string $kolom, string $dir, string $label): array
    {
        $berhasil = $dilewati = $gagal = 0;
        $log = [];

        $zip = new ZipArchive;

        if ($zip->open($zipPath) !== true) {
            return [
                'berhasil' => 0,
                'dilewati' => 0,
                'gagal' => 1,
                'log' => ['Gagal membuka file ZIP. Pastikan file tidak rusak.'],
            ];
        }

        $tmpDir = storage_path('app/tmp/'.Str::slug($label).'-'.uniqid());
        mkdir($tmpDir, 0755, true);

        $zip->extractTo($tmpDir);
        $zip->close();

        foreach ($this->collectPdfs($tmpDir) as $pdfPath) {
            $filename = basename($pdfPath);
            $nisn = Str::beforeLast($filename, '.pdf');

            if (! preg_match('/^\d{10}$/', $nisn)) {
                $log[] = "Dilewati — nama file tidak valid: {$filename}";
                $gagal++;

                continue;
            }

            $siswa = Siswa::where('nisn', $nisn)->first();

            if (! $siswa) {
                $log[] = "Siswa dengan NISN {$nisn} tidak ditemukan.";
                $dilewati++;

                continue;
            }

            $oldPath = $siswa->getAttribute($kolom);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $destination = "{$dir}/{$nisn}.pdf";
            Storage::disk('public')->put($destination, file_get_contents($pdfPath));

            $siswa->update([$kolom => $destination]);
            $log[] = "{$label} {$nisn} berhasil diimpor.";
            $berhasil++;
        }

        $this->deleteDirectory($tmpDir);

        return compact('berhasil', 'dilewati', 'gagal', 'log');
    }

    /**
     * Alias untuk kompatibilitas pemanggilan lama.
     *
     * @deprecated Gunakan execute() dengan parameter eksplisit.
     */
    public function executeFromZip(string $zipPath): array
    {
        return $this->execute($zipPath, 'berkas_skl', 'skl', 'SKL');
    }

    private function collectPdfs(string $dir): array
    {
        $pdfs = [];

        foreach (scandir($dir) as $entry) {
            if (in_array($entry, ['.', '..'], true)) {
                continue;
            }

            $full = $dir.DIRECTORY_SEPARATOR.$entry;

            if (is_dir($full)) {
                $pdfs = array_merge($pdfs, $this->collectPdfs($full));
            } elseif (is_file($full) && strtolower(pathinfo($full, PATHINFO_EXTENSION)) === 'pdf') {
                $pdfs[] = $full;
            }
        }

        return $pdfs;
    }

    private function deleteDirectory(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        foreach (scandir($dir) as $entry) {
            if (in_array($entry, ['.', '..'], true)) {
                continue;
            }

            $full = $dir.DIRECTORY_SEPARATOR.$entry;
            is_dir($full) ? $this->deleteDirectory($full) : unlink($full);
        }

        rmdir($dir);
    }
}

```

---

### 📄 File: `./app/Actions/ImportFoto.php`

```php
<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ImportFoto
{
    /**
     * Ekstensi gambar yang didukung.
     */
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    /**
     * @param  string  $zipPath  Path absolut ke file ZIP
     * @param  class-string  $modelClass  Model Eloquent target (Siswa::class, dll.)
     * @param  string  $identifierCol  Kolom pencocok nama file, mis. 'nisn' atau 'nip'
     * @param  string  $fotoCol  Kolom yang menyimpan path foto, mis. 'foto' atau 'avatar'
     * @param  string  $storageDir  Direktori tujuan di disk public, mis. 'foto-siswa'
     * @return array{berhasil: int, dilewati: int, gagal: int, log: string[]}
     */
    public function execute(
        string $zipPath,
        string $modelClass,
        string $identifierCol,
        string $fotoCol,
        string $storageDir,
    ): array {
        $berhasil = $dilewati = $gagal = 0;
        $log = [];

        // Buka ZIP
        $zip = new ZipArchive;
        if ($zip->open($zipPath) !== true) {
            return [
                'berhasil' => 0,
                'dilewati' => 0,
                'gagal' => 1,
                'log' => ['Gagal membuka file ZIP. Pastikan file tidak rusak.'],
            ];
        }

        $tmpDir = storage_path('app/tmp/foto-'.uniqid());
        mkdir($tmpDir, 0755, true);
        $zip->extractTo($tmpDir);
        $zip->close();

        $images = $this->collectImages($tmpDir);

        if (empty($images)) {
            $this->deleteDirectory($tmpDir);

            return [
                'berhasil' => 0,
                'dilewati' => 0,
                'gagal' => 1,
                'log' => ['Tidak ada file gambar yang ditemukan di dalam ZIP.'],
            ];
        }

        foreach ($images as $imagePath) {
            $filename = basename($imagePath);
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $identifier = Str::beforeLast($filename, '.'.$ext);

            // Validasi: identifier tidak boleh kosong
            if (blank($identifier)) {
                $log[] = "Dilewati — nama file tidak valid: {$filename}";
                $gagal++;

                continue;
            }

            /** @var Model|null $record */
            $record = $modelClass::where($identifierCol, $identifier)->first();

            if (! $record) {
                $log[] = "Data dengan {$identifierCol} '{$identifier}' tidak ditemukan — {$filename} dilewati.";
                $dilewati++;

                continue;
            }

            // Hapus foto lama jika ada
            $oldPath = $record->getAttribute($fotoCol);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Simpan foto baru dengan nama bersih: {identifier}.{ext}
            $destination = "{$storageDir}/{$identifier}.{$ext}";
            Storage::disk('public')->put($destination, file_get_contents($imagePath));

            $record->update([$fotoCol => $destination]);
            $log[] = "Foto '{$identifier}' berhasil diimpor.";
            $berhasil++;
        }

        $this->deleteDirectory($tmpDir);

        return compact('berhasil', 'dilewati', 'gagal', 'log');
    }

    /**
     * Kumpulkan semua file gambar secara rekursif dari direktori.
     */
    private function collectImages(string $dir): array
    {
        $results = [];

        foreach (scandir($dir) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            // Lewati file/folder tersembunyi (mis. __MACOSX dari macOS ZIP)
            if (str_starts_with($entry, '.') || str_starts_with($entry, '__')) {
                continue;
            }

            $full = $dir.DIRECTORY_SEPARATOR.$entry;

            if (is_dir($full)) {
                $results = array_merge($results, $this->collectImages($full));
            } elseif (
                is_file($full) &&
                in_array(strtolower(pathinfo($full, PATHINFO_EXTENSION)), self::ALLOWED_EXTENSIONS, true)
            ) {
                $results[] = $full;
            }
        }

        return $results;
    }

    /**
     * Hapus direktori beserta isinya secara rekursif.
     */
    private function deleteDirectory(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        foreach (scandir($dir) as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            $full = $dir.DIRECTORY_SEPARATOR.$entry;
            is_dir($full) ? $this->deleteDirectory($full) : unlink($full);
        }

        rmdir($dir);
    }
}

```

---

### 📄 File: `./app/Console/Commands/BroadcastKelulusan.php`

```php
<?php

namespace App\Console\Commands;

use App\Jobs\BroadcastPesanKelulusan;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Illuminate\Console\Command;

class BroadcastKelulusan extends Command
{
    protected $signature = 'skl:broadcast {--force : Kirim tanpa cek jadwal}';

    protected $description = 'Broadcast pesan kelulusan via WhatsApp ke seluruh siswa yang memiliki nomor.';

    public function handle(): int
    {
        $tp = TahunPelajaran::where('status', true)->first();

        if (! $tp) {
            $this->error('Tidak ada Tahun Pelajaran aktif.');

            return self::FAILURE;
        }

        $dalamJadwal = now()->between(
            $tp->jadwal_pengumuman_mulai,
            $tp->jadwal_pengumuman_selesai,
        );

        if (! $this->option('force') && ! $dalamJadwal) {
            $this->warn('Belum dalam rentang jadwal pengumuman. Gunakan --force untuk memaksa.');

            return self::FAILURE;
        }

        $siswas = Siswa::whereNotNull('telepon')->get();
        $total = $siswas->count();

        if ($total === 0) {
            $this->warn('Tidak ada siswa dengan nomor telepon terdaftar.');

            return self::SUCCESS;
        }

        $this->info("Mengirim ke {$total} siswa...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        // Delay akumulatif agar job tidak membanjiri API sekaligus
        $offsetDetik = 0;

        foreach ($siswas as $siswa) {
            $offsetDetik += rand(2, 8);

            BroadcastPesanKelulusan::dispatch($siswa, $tp)
                ->delay(now()->addSeconds($offsetDetik));

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Semua {$total} job berhasil di-dispatch. Estimasi selesai: ~{$offsetDetik} detik.");

        return self::SUCCESS;
    }
}

```

---

### 📄 File: `./app/Enums/StatusSiswa.php`

```php
<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusSiswa: string implements HasColor, HasLabel
{
    case Lulus = 'Lulus';
    case TidakLulus = 'Tidak Lulus';
    case LulusBersyarat = 'Lulus Bersyarat';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    /** Alias agar kompatibel jika dipanggil ->label() di view. */
    public function label(): string
    {
        return $this->value;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Lulus => 'success',
            self::TidakLulus => 'danger',
            self::LulusBersyarat => 'warning',
        };
    }

    public function theme(): string
    {
        return match ($this) {
            self::Lulus => 'theme-lulus',
            self::TidakLulus => 'theme-tidak',
            self::LulusBersyarat => 'theme-syarat',
        };
    }

    public function iconLabel(): string
    {
        return match ($this) {
            self::Lulus => 'LULUS',
            self::TidakLulus => 'TIDAK',
            self::LulusBersyarat => 'SYARAT',
        };
    }

    public function footerNote(): ?string
    {
        return match ($this) {
            self::Lulus => 'Selamat! Semoga sukses di jenjang berikutnya.',
            self::TidakLulus => 'Tetap semangat. Hubungi madrasah untuk langkah selanjutnya.',
            self::LulusBersyarat => 'Segera hubungi madrasah untuk informasi lebih lanjut.',
        };
    }

    public function footerColor(): ?string
    {
        return match ($this) {
            self::Lulus => null,
            self::TidakLulus => '#f87171',
            self::LulusBersyarat => '#fbbf24',
        };
    }
}

```

---

### 📄 File: `./app/Exports/AlumniExport.php`

```php
<?php

namespace App\Exports;

use App\Exports\Concerns\HasExportStyles;
use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class AlumniExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    use HasExportStyles;

    private int $no = 0;

    public function __construct(private readonly ?string $tahunLulus = null) {}

    public function query()
    {
        return Alumni::query()
            ->when($this->tahunLulus, fn ($q) => $q->where('tahun_lulus', $this->tahunLulus))
            ->orderByDesc('tahun_lulus')
            ->orderBy('nama');
    }

    public function title(): string
    {
        return 'Data Alumni';
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'NISN', 'Tahun Lulus', 'Quote', 'Dibuat'];
    }

    public function map($alumni): array
    {
        return [
            ++$this->no,
            $alumni->nama,
            $alumni->nisn,
            $alumni->tahun_lulus,
            $alumni->quote ?? '-',
            $alumni->created_at->format('d/m/Y'),
        ];
    }
}

```

---

### 📄 File: `./app/Exports/Concerns/HasExportStyles.php`

```php
<?php

namespace App\Exports\Concerns;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

trait HasExportStyles
{
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D9488']],
            ],
        ];
    }
}

```

---

### 📄 File: `./app/Exports/PersonilExport.php`

```php
<?php

namespace App\Exports;

use App\Exports\Concerns\HasExportStyles;
use App\Models\Personil;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class PersonilExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    use HasExportStyles;

    private int $no = 0;

    public function query()
    {
        return Personil::query()->orderBy('jabatan');
    }

    public function title(): string
    {
        return 'Data Personil';
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'NIP', 'Jabatan', 'Telepon', 'Sosial Media', 'Quote'];
    }

    public function map($personil): array
    {
        return [
            ++$this->no,
            $personil->nama,
            $personil->nip ?? '-',
            $personil->jabatan,
            $personil->telepon ?? '-',
            $personil->sosial_media ?? '-',
            $personil->quote ?? '-',
        ];
    }
}

```

---

### 📄 File: `./app/Exports/SiswaExport.php`

```php
<?php

namespace App\Exports;

use App\Enums\StatusSiswa;
use App\Exports\Concerns\HasExportStyles;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class SiswaExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    use HasExportStyles;

    private int $no = 0;

    private readonly ?string $status;

    public function __construct(StatusSiswa|string|null $status = null)
    {
        $this->status = $status instanceof StatusSiswa ? $status->value : $status;
    }

    public function query()
    {
        return Siswa::query()
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->orderBy('nama');
    }

    public function title(): string
    {
        return 'Data Siswa';
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Nama Orang Tua', 'NISN', 'Telepon', 'Status', 'Berkas SKL', 'Dibuat'];
    }

    public function map($siswa): array
    {
        return [
            ++$this->no,
            $siswa->nama,
            $siswa->nama_orangtua ?? '-',
            $siswa->nisn,
            $siswa->telepon ?? '-',
            $siswa->status->getLabel(),
            $siswa->berkas_skl ?? '-',
            $siswa->created_at->format('d/m/Y'),
        ];
    }
}

```

---

### 📄 File: `./app/Exports/Templates/AlumniTemplateExport.php`

```php
<?php

namespace App\Exports\Templates;

use App\Exports\Concerns\HasExportStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class AlumniTemplateExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    use HasExportStyles;

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
}

```

---

### 📄 File: `./app/Exports/Templates/PersonilTemplateExport.php`

```php
<?php

namespace App\Exports\Templates;

use App\Exports\Concerns\HasExportStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class PersonilTemplateExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    use HasExportStyles;

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
}

```

---

### 📄 File: `./app/Exports/Templates/SiswaTemplateExport.php`

```php
<?php

namespace App\Exports\Templates;

use App\Exports\Concerns\HasExportStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class SiswaTemplateExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    use HasExportStyles;

    public function array(): array
    {
        return [
            ['Budi Santoso', 'Ahmad Santoso', '0012345678', '08123456789', 'Lulus'],
            ['Siti Rahayu',  'Budi Rahayu',   '0098765432', '08199999999', 'Tidak Lulus'],
            ['Andi Wijaya',  'Hendra Wijaya', '0011223344', '',             'Lulus Bersyarat'],
        ];
    }

    public function headings(): array
    {
        return ['nama', 'nama_orangtua', 'nisn', 'telepon', 'status'];
    }
}

```

---

### 📄 File: `./app/Filament/Concerns/HasImportActions.php`

```php
<?php

namespace App\Filament\Concerns;

use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Validators\Failure;

trait HasImportActions
{
    /**
     * Resolve path dari filename Filament upload (disk local, dir imports-tmp).
     */
    protected function resolveUpload(string $filename): string
    {
        $path = storage_path('app/private/'.$filename);

        if (! file_exists($path)) {
            throw new \RuntimeException("Uploaded file not found: {$filename}");
        }

        return $path;
    }

    /**
     * Kirim notifikasi berdasarkan hasil array {berhasil, dilewati, gagal, log}.
     *
     * @param  array{berhasil: int, dilewati: int, gagal: int, log: string[]}  $result
     */
    protected function sendImportNotification(array $result, string $prefix): void
    {
        $isWarning = $result['gagal'] > 0 || $result['dilewati'] > 0;

        $title = "{$prefix}: {$result['berhasil']} berhasil"
            .($result['dilewati'] ? ", {$result['dilewati']} dilewati" : '')
            .($result['gagal'] ? ", {$result['gagal']} gagal" : '');

        $body = implode("\n", array_slice($result['log'], 0, 8));
        if (count($result['log']) > 8) {
            $body .= "\n... dan ".(count($result['log']) - 8).' lainnya.';
        }

        Notification::make()
            ->title($title)
            ->body($body)
            ->when($isWarning, fn ($n) => $n->warning(), fn ($n) => $n->success())
            ->persistent()
            ->send();
    }

    /**
     * Kirim notifikasi hasil import Excel (ToModel/WithValidation pattern).
     *
     * @param  Collection<int, Failure>  $failures
     */
    protected function sendExcelNotification(int $berhasil, Collection $failures, string $entity): void
    {
        if ($failures->count() > 0) {
            $messages = $failures
                ->map(fn (Failure $f) => "Baris {$f->row()}: ".implode(', ', $f->errors()))
                ->take(5)
                ->join("\n");

            Notification::make()
                ->title("Import selesai — {$berhasil} berhasil, {$failures->count()} baris gagal")
                ->body($messages)
                ->warning()
                ->persistent()
                ->send();

            return;
        }

        Notification::make()
            ->title("{$berhasil} data {$entity} berhasil diimpor!")
            ->success()
            ->send();
    }
}

```

---

### 📄 File: `./app/Filament/Pages/Auth/EditProfileCustom.php`

```php
<?php

namespace App\Filament\Pages\Auth;

use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Auth\Pages\EditProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfileCustom extends EditProfile
{
    use HasCustomLayout;

    protected string $view = 'filament.pages.auth.edit-profile';

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getAvatarFormComponent(),
                        $this->getNameFormComponent(),
                        $this->getUsernameFormComponent(),
                        $this->getTeleponFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
                    ->inlineLabel(! static::isSimple()),
            ),
        ];
    }

    protected function getAvatarFormComponent(): Component
    {
        return FileUpload::make('avatar')
            ->label('Avatar')
            ->image()
            ->minSize(5)
            ->maxSize(500)
            ->visibility('private')
            ->directory('assets/avatar');
    }

    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label('Nama Lengkap')
            ->suffixIcon('heroicon-o-user-circle')
            ->required()
            ->maxLength(100)
            ->autofocus();
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('Username')
            ->suffixIcon('heroicon-o-identification')
            ->required()
            ->unique(ignoreRecord: true)
            ->validationMessages([
                'unique' => 'Username: Username sudah pernah diisi.',
                'required' => 'Form ini wajib diisi.',
            ]);
    }

    protected function getTeleponFormComponent(): Component
    {
        return TextInput::make('telepon')
            ->label('Nomor WhatsApp Aktif')
            ->suffixIcon('heroicon-o-phone')
            ->tel()
            ->maxLength(15)
            ->placeholder('Contoh: 08123456789')
            ->helperText('Nomor ini digunakan untuk notifikasi dan verifikasi OTP.')
            ->validationMessages([
                'required' => 'Nomor WhatsApp wajib diisi.',
                'max' => 'Nomor WhatsApp maksimal 15 karakter.',
            ]);
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email')
            ->suffixIcon('heroicon-o-envelope')
            ->email()
            ->required()
            ->maxLength(50)
            ->unique(ignoreRecord: true)
            ->validationMessages([
                'max' => 'Email: Masukkan maksimal 50 Karakter.',
                'unique' => 'Email: Email ini sudah pernah diisi.',
                'required' => 'Form ini wajib diisi.',
            ]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Password')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->rule(Password::default())
            ->autocomplete('new-password')
            ->dehydrated(fn ($state): bool => filled($state))
            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
            ->live(debounce: 500)
            ->same('passwordConfirmation')
            ->validationMessages([
                'same' => 'Password: Password tidak sesuai dengan isian password konfirmasi.',
                'min' => 'Password: Masukkan minimal 8 karakter alfanumerik.',
                'required' => 'Form ini wajib diisi.',
            ]);
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label('Ulangi Password')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->visible(fn (Get $get): bool => filled($get('password')))
            ->dehydrated(false);
    }
}

```

---

### 📄 File: `./app/Filament/Pages/Auth/ForgotPasswordCustom.php`

```php
<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use App\Services\OtpMessageService;
use App\Services\WhatsAppService;
use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\SimplePage;
use Filament\Schemas\Components\Form;
use Illuminate\Support\Facades\Redis;

class ForgotPasswordCustom extends SimplePage implements HasForms
{
    use HasCustomLayout;
    use InteractsWithForms;

    protected string $view = 'filament.pages.auth.forgot-password';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('identity')
                    ->label('Username / Email / Nomor WhatsApp')
                    ->required()
                    ->suffixIcon('heroicon-o-user')
                    ->autofocus()
                    ->placeholder('Masukkan salah satu')
                    ->validationMessages([
                        'required' => 'Field ini wajib diisi.',
                    ]),
            ])
            ->statePath('data');
    }

    public function kirim(): void
    {
        $data = $this->form->getState();
        $identity = trim($data['identity']);

        // Cari user berdasarkan username, email, atau telepon
        $user = User::where('username', $identity)
            ->orWhere('email', $identity)
            ->orWhere('telepon', $identity)
            ->where('status', 'Aktif')
            ->first();

        // Selalu tampilkan pesan sukses untuk mencegah user enumeration
        if (! $user) {
            Notification::make()
                ->title('Data tidak ditemukan.')
                ->success()
                ->send();

            return;
        }

        if (! $user->telepon) {
            Notification::make()
                ->title('Akun ini tidak memiliki nomor WhatsApp terdaftar.')
                ->body('Hubungi panitia PMBM untuk bantuan.')
                ->danger()
                ->send();

            return;
        }

        // Cek cooldown
        $cooldownKey = "otp_cooldown:{$user->id}";
        if (Redis::exists($cooldownKey)) {
            $ttl = Redis::ttl($cooldownKey);
            Notification::make()
                ->title("Tunggu {$ttl} detik sebelum meminta OTP baru.")
                ->warning()
                ->send();

            return;
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Redis::setex("reset_otp:{$user->id}", 300, $otp);   // OTP TTL 5 menit
        Redis::setex($cooldownKey, 60, 1);                    // cooldown 60 detik

        $message = OtpMessageService::resetPassword($user->name, $otp);

        app(WhatsAppService::class)->send(
            phone: $user->telepon,
            message: $message,
            minDelay: 1,
            maxDelay: 5,
        );

        session(['reset_otp_user_id' => $user->id]);

        Notification::make()
            ->title('Kode OTP telah dikirim ke WhatsApp Anda.')
            ->success()
            ->send();

        $this->redirect(route('otp.reset-password'));
    }

    public function getTitle(): string
    {
        return 'Lupa Password';
    }
}

```

---

### 📄 File: `./app/Filament/Pages/Auth/LoginCustom.php`

```php
<?php

namespace App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;

class LoginCustom extends Login
{
    use HasCustomLayout;

    protected string $view = 'filament.pages.auth.login';

    public function getTitle(): string|Htmlable
    {
        return 'Masuk ke Sistem PMBM MTsN 1 Pandeglang';
    }

    public function getHeading(): string|Htmlable
    {
        return 'Selamat Datang Kembali';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Silakan masuk dengan akun Anda untuk melanjutkan';
    }

    protected function getLayoutData(): array
    {
        return [
            'emptyPanelBackgroundImageUrl' => $this->getBackgroundImage(),
            'emptyPanelBackgroundColor' => $this->getBackgroundColor(),
        ];
    }

    protected function getBackgroundImage(): string
    {
        return asset('/images/wallpaper.png');
    }

    protected function getBackgroundColor(): string
    {
        return '';
    }

    protected function getSchemas(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getLoginFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label(__('Ingat Saya'))
            ->hint(new HtmlString(
                '<a href="https://daftar.mtsn1pandeglang.sch.id"
                class="text-sm text-blue-500 transition hover:text-primary-600">
                ← Kembali Beranda
            </a>'
            ));
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label(__('Email/Nomor Induk Siswa Nasional (NISN)'))
            ->required()
            ->suffixIcon('heroicon-o-lock-closed')
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    public function getFooter(): ?View
    {
        return view('filament.pages.auth.login-footer');
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $login_type => $data['login'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (! Auth::attempt([
            $login_type => $data['login'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Auth::user();

        if ($user && ! $user->hasVerifiedEmail()) {
            session(['otp_user_id' => $user->id]);
            Auth::logout();
            $this->redirect('/verifikasi-otp');

            return null;
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}

```

---

### 📄 File: `./app/Filament/Pages/Auth/NewPassword.php`

```php
<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use App\Services\OtpMessageService;
use App\Services\WhatsAppService;
use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\SimplePage;
use Filament\Schemas\Components\Form;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rules\Password;

class NewPassword extends SimplePage implements HasForms
{
    use HasCustomLayout;
    use InteractsWithForms;

    protected string $view = 'filament.pages.auth.new-password';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        $userId = session('reset_otp_user_id');

        if (! $userId || ! Redis::exists("reset_token:{$userId}")) {
            $this->redirect(route('otp.forgot-password'));

            return;
        }

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('password')
                    ->label('Password Baru')
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required()
                    ->rule(Password::default())
                    ->same('password_confirmation')
                    ->autofocus()
                    ->validationMessages([
                        'required' => 'Password wajib diisi.',
                        'same' => 'Password tidak sesuai dengan konfirmasi.',
                        'min' => 'Password minimal 8 karakter.',
                    ]),

                TextInput::make('password_confirmation')
                    ->label('Ulangi Password Baru')
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required()
                    ->dehydrated(false),
            ])
            ->statePath('data');
    }

    public function simpanPassword(): void
    {
        $data = $this->form->getState();
        $userId = session('reset_otp_user_id');

        if (! Redis::exists("reset_token:{$userId}")) {
            Notification::make()->title('Sesi reset password sudah kadaluarsa.')->body('Silakan ulangi proses lupa password.')->danger()->send();
            $this->redirect(route('otp.forgot-password'));

            return;
        }

        $user = User::find($userId);

        if (! $user) {
            $this->redirect(route('otp.forgot-password'));

            return;
        }

        $user->forceFill([
            'password' => Hash::make($data['password']),
        ])->save();

        Redis::del("reset_token:{$userId}");
        Redis::del("otp_cooldown:{$userId}");
        session()->forget('reset_otp_user_id');

        $message = OtpMessageService::passwordBerhasilDiubah($user->name);

        app(WhatsAppService::class)->send(
            phone: $user->telepon,
            message: $message,
            minDelay: 1,
            maxDelay: 5,
        );

        Notification::make()->title('Password berhasil diubah.')->body('Silakan login dengan password baru Anda.')->success()->send();

        $this->redirect(filament()->getLoginUrl());
    }

    public function getTitle(): string
    {
        return 'Buat Password Baru';
    }
}

```

---

### 📄 File: `./app/Filament/Pages/Auth/RegisterCustom.php`

```php
<?php

namespace App\Filament\Pages\Auth;

use App\Services\OtpMessageService;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;
use Filament\Auth\Pages\Register;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password;

class RegisterCustom extends Register
{
    use HasCustomLayout;

    protected string $view = 'filament.pages.auth.register';

    public function mount(): void
    {
        if (! $this->isRegistrationOpen()) {
            Notification::make()
                ->title('Pendaftaran Ditutup')
                ->body('Pendaftaran belum dibuka atau sudah ditutup.')
                ->warning()
                ->send();

            $this->redirect(filament()->getLoginUrl());

            return;
        }

        parent::mount();
    }

    protected function isRegistrationOpen(): bool
    {
        return Cache::remember('ppdb:registration_open', 5, function () {
            try {
                if (! Schema::hasTable('tahun_pendaftarans')) {
                    return false;
                }

                $tahun = DB::table('tahun_pendaftarans')
                    ->where('status', 'Aktif')
                    ->first();

                if (! $tahun) {
                    return false;
                }

                $now = Carbon::now();
                $start = Carbon::parse($tahun->tanggal_ppdb_mulai);
                $end = Carbon::parse($tahun->tanggal_ppdb_selesai);

                return $now->between($start, $end);
            } catch (\Throwable $e) {
                Log::error('RegisterCustom::isRegistrationOpen error: '.$e->getMessage());

                return false;
            }
        });
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getUsernameFormComponent(),
                        $this->getTeleponFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label('Nama Lengkap')
            ->required()
            ->suffixIcon('heroicon-o-user-circle')
            ->maxLength(100)
            ->autofocus();
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('Nomor Induk Siswa Nasional (NISN)')
            ->required()
            ->suffixIcon('heroicon-o-identification')
            ->numeric()
            ->maxLength(10)
            ->minLength(10)
            ->validationMessages([
                'max_digits' => 'NISN: Masukkan maksimal 10 Angka.',
                'min_digits' => 'NISN: Masukkan minimal 10 Angka.',
                'unique' => 'NISN: Nomor ini sudah pernah dipakai.',
                'required' => 'Form ini harus diisi.',
            ])
            ->unique($this->getUserModel());
    }

    protected function getTeleponFormComponent(): Component
    {
        return TextInput::make('telepon')
            ->label('Nomor WhatsApp Aktif')
            ->required()
            ->suffixIcon('heroicon-o-phone')
            ->tel()
            ->maxLength(15)
            ->placeholder('Contoh: 08123456789')
            ->validationMessages([
                'required' => 'Nomor WhatsApp harus diisi.',
                'max' => 'Nomor WhatsApp maksimal 15 karakter.',
                'unique' => 'Nomor WhatsApp: Nomor ini sudah pernah dipakai.',
            ])
            ->unique($this->getUserModel());
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email')
            ->email()
            ->required()
            ->suffixIcon('heroicon-o-envelope')
            ->maxLength(50)
            ->validationMessages([
                'max' => 'Email: Masukkan maksimal 50 Karakter.',
                'unique' => 'Email: Email ini sudah pernah dipakai.',
                'required' => 'Form ini harus diisi.',
            ])
            ->unique($this->getUserModel());
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Password')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->rule(Password::default())
            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationMessages([
                'same' => 'Password: Password tidak sesuai dengan isian password konfirmasi.',
                'min' => 'Password: Masukkan minimal 8 karakter alfanumerik.',
                'required' => 'Form ini harus diisi.',
            ])
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'));
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label('Ulangi Password')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false);
    }

    // -----------------------------------------------------------------------
    // Register — kirim OTP setelah user dibuat
    // -----------------------------------------------------------------------

    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();

        $user = $this->getUserModel()::create($data);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $ttl = 300;

        Redis::setex("otp:{$user->id}", $ttl, $otp);

        $message = OtpMessageService::verifikasi($user->name, $otp);

        app(WhatsAppService::class)->send(
            phone: $user->telepon,
            message: $message,
            minDelay: 1,   // OTP: kirim cepat
            maxDelay: 5,
        );

        session(['otp_user_id' => $user->id]);

        $this->redirect(route('otp.verifikasi'));

        return null;
    }
}

```

---

### 📄 File: `./app/Filament/Pages/Auth/ResetPasswordOtp.php`

```php
<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use App\Services\OtpMessageService;
use App\Services\WhatsAppService;
use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\SimplePage;
use Filament\Schemas\Components\Form;
use Illuminate\Support\Facades\Redis;

class ResetPasswordOtp extends SimplePage implements HasForms
{
    use HasCustomLayout;
    use InteractsWithForms;

    protected string $view = 'filament.pages.auth.reset-password-otp';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        if (! session('reset_otp_user_id')) {
            $this->redirect(route('otp.forgot-password'));

            return;
        }
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('otp')
                    ->label('Kode OTP')
                    ->required()
                    ->numeric()
                    ->length(6)
                    ->placeholder('Masukkan 6 digit kode OTP')
                    ->suffixIcon('heroicon-o-key')
                    ->autofocus()
                    ->validationMessages([
                        'required' => 'Kode OTP wajib diisi.',
                        'digits' => 'Kode OTP harus 6 digit.',
                    ]),
            ])
            ->statePath('data');
    }

    public function verifikasiOtp(): void
    {
        $data = $this->form->getState();
        $userId = session('reset_otp_user_id');
        $user = User::find($userId);

        if (! $user) {
            Notification::make()->title('Sesi tidak valid. Silakan ulangi proses lupa password.')->danger()->send();
            $this->redirect(route('otp.forgot-password'));

            return;
        }

        $storedOtp = Redis::get("reset_otp:{$userId}");

        if (! $storedOtp) {
            Notification::make()->title('Kode OTP sudah kadaluarsa.')->body('Silakan minta kode OTP baru.')->danger()->send();

            return;
        }

        // OPTIMASI: Mencegah Timing Attack
        if (! hash_equals((string) $storedOtp, (string) $data['otp'])) {
            Notification::make()->title('Kode OTP tidak valid.')->body('Periksa kembali kode yang dikirim ke WhatsApp Anda.')->danger()->send();

            return;
        }

        Redis::del("reset_otp:{$userId}");
        Redis::setex("reset_token:{$userId}", 900, 1);

        Notification::make()->title('OTP valid. Silakan buat password baru.')->success()->send();
        $this->redirect(route('otp.new-password'));
    }

    public function resend(): void
    {
        $userId = session('reset_otp_user_id');
        $user = User::find($userId);

        if (! $user) {
            Notification::make()->title('Sesi tidak valid.')->danger()->send();

            return;
        }

        $cooldownKey = "otp_cooldown:{$userId}";
        if (Redis::exists($cooldownKey)) {
            $ttl = Redis::ttl($cooldownKey);
            Notification::make()->title("Tunggu {$ttl} detik sebelum meminta OTP baru.")->warning()->send();

            return;
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Redis::setex("reset_otp:{$userId}", 300, $otp);
        Redis::setex($cooldownKey, 60, 1);

        $message = OtpMessageService::resetPassword($user->name, $otp);

        app(WhatsAppService::class)->send(
            phone: $user->telepon,
            message: $message,
            minDelay: 1,
            maxDelay: 5,
        );

        Notification::make()->title('Kode OTP baru telah dikirim ke WhatsApp Anda.')->success()->send();
    }

    public function getTitle(): string
    {
        return 'Verifikasi OTP';
    }
}

```

---

### 📄 File: `./app/Filament/Pages/Auth/VerifikasiOtp.php`

```php
<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use App\Services\OtpMessageService;
use App\Services\WhatsAppService;
use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\SimplePage;
use Filament\Schemas\Components\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class VerifikasiOtp extends SimplePage implements HasForms
{
    use HasCustomLayout;
    use InteractsWithForms;

    protected string $view = 'filament.pages.auth.verifikasi-otp';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user() ?? User::find(session('otp_user_id'));

        if (! $user) {
            $this->redirect(filament()->getLoginUrl());

            return;
        }

        if ($user->hasVerifiedEmail()) {
            $this->redirect(filament()->getUrl());

            return;
        }

        // Simpan ke session agar resend & verifikasi bisa pakai
        session(['otp_user_id' => $user->id]);

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('otp')
                    ->label('Kode OTP')
                    ->required()
                    ->numeric()
                    ->length(6)
                    ->placeholder('Masukkan 6 digit kode OTP')
                    ->suffixIcon('heroicon-o-key')
                    ->autofocus()
                    ->validationMessages([
                        'required' => 'Kode OTP wajib diisi.',
                        'digits' => 'Kode OTP harus 6 digit.',
                    ]),
            ])
            ->statePath('data');
    }

    public function verifikasi(): void
    {
        $data = $this->form->getState();
        $userId = session('otp_user_id');
        $user = User::find($userId);

        if (! $user) {
            Notification::make()->title('Sesi tidak valid. Silakan daftar ulang.')->danger()->send();
            $this->redirect(filament()->getLoginUrl());

            return;
        }

        $storedOtp = Redis::get("otp:{$userId}");

        if (! $storedOtp) {
            Notification::make()->title('Kode OTP sudah kadaluarsa.')->body('Silakan minta kode OTP baru.')->danger()->send();

            return;
        }

        // OPTIMASI: Mencegah Timing Attack
        if (! hash_equals((string) $storedOtp, (string) $data['otp'])) {
            Notification::make()->title('Kode OTP tidak valid.')->body('Periksa kembali kode yang dikirim ke WhatsApp Anda.')->danger()->send();

            return;
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'status' => 'Aktif',
        ])->save();

        Redis::del("otp:{$userId}");
        Redis::del("otp_cooldown:{$userId}");
        session()->forget('otp_user_id');

        Auth::login($user);

        Notification::make()->title('Akun berhasil diverifikasi!')->body('Selamat datang di PMBM MTsN 1 Pandeglang.')->success()->send();
        $this->redirect(filament()->getUrl());
    }

    public function resend(): void
    {
        $userId = session('otp_user_id');
        $user = User::find($userId);

        if (! $user) {
            Notification::make()->title('Sesi tidak valid.')->danger()->send();

            return;
        }

        $cooldownKey = "otp_cooldown:{$userId}";
        if (Redis::exists($cooldownKey)) {
            $ttl = Redis::ttl($cooldownKey);
            Notification::make()->title("Tunggu {$ttl} detik sebelum meminta OTP baru.")->warning()->send();

            return;
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Redis::setex("otp:{$userId}", 300, $otp);
        Redis::setex($cooldownKey, 60, 1);

        $message = OtpMessageService::verifikasi($user->name, $otp);

        app(WhatsAppService::class)->send(
            phone: $user->telepon,
            message: $message,
            minDelay: 1,
            maxDelay: 5,
        );

        Notification::make()->title('Kode OTP baru telah dikirim ke WhatsApp Anda.')->success()->send();
    }

    public function getTitle(): string
    {
        return 'Verifikasi OTP';
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/AlumniResource.php`

```php
<?php

namespace App\Filament\Resources\Alumnis;

use App\Filament\Resources\Alumnis\Pages\CreateAlumni;
use App\Filament\Resources\Alumnis\Pages\EditAlumni;
use App\Filament\Resources\Alumnis\Pages\ListAlumnis;
use App\Filament\Resources\Alumnis\Pages\ViewAlumni;
use App\Filament\Resources\Alumnis\Schemas\AlumniForm;
use App\Filament\Resources\Alumnis\Schemas\AlumniInfolist;
use App\Filament\Resources\Alumnis\Tables\AlumnisTable;
use App\Models\Alumni;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AlumniResource extends Resource
{
    protected static ?string $model = Alumni::class;

    protected static bool $shouldRegisterNavigation = true;

    // protected static string|UnitEnum|null $navigationGroup = 'Personil';
    protected static ?string $navigationLabel = 'Alumni';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return AlumniForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AlumniInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlumnisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAlumnis::route('/'),
            'create' => CreateAlumni::route('/create'),
            'view' => ViewAlumni::route('/{record}'),
            'edit' => EditAlumni::route('/{record}/edit'),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Pages/CreateAlumni.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Filament\Resources\Alumnis\AlumniResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAlumni extends CreateRecord
{
    protected static string $resource = AlumniResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Pages/EditAlumni.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Filament\Resources\Alumnis\AlumniResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class EditAlumni extends EditRecord
{
    protected static string $resource = AlumniResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon(Heroicon::Eye)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Zinc),
            DeleteAction::make()
                ->icon(Heroicon::Trash)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Rose),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Pages/ListAlumnis.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Actions\ImportFoto;
use App\Exports\AlumniExport;
use App\Exports\Templates\AlumniTemplateExport;
use App\Filament\Concerns\HasImportActions;
use App\Filament\Resources\Alumnis\AlumniResource;
use App\Imports\AlumniImport;
use App\Models\Alumni;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Maatwebsite\Excel\Facades\Excel;

class ListAlumnis extends ListRecords
{
    use HasImportActions;

    protected static string $resource = AlumniResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            // ── 1. Import Excel ────────────────────────────────────────
            Action::make('import_excel')
                ->label('Import Excel')
                ->icon(Heroicon::ArrowUpTray)
                ->color(Color::Blue)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Data Alumni dari Excel')
                ->modalDescription('Upload file Excel (.xlsx). Gunakan template agar format kolom sesuai.')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel (.xlsx / .xls)')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                        ])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(5120)
                        ->required()
                        ->helperText('Kolom wajib: nama, nisn, tahun_lulus. Opsional: quote. Maks. 5 MB.'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['file']);

                    try {
                        $import = new AlumniImport;
                        Excel::import($import, $path);

                        $this->sendExcelNotification($import->getBerhasil(), $import->failures(), 'alumni');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 2. Export Excel ────────────────────────────────────────
            Action::make('export_excel')
                ->label('Export Excel')
                ->icon(Heroicon::ArrowDownTray)
                ->color(Color::Emerald)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Export Data Alumni')
                ->modalSubmitActionLabel('Export Sekarang')
                ->form([
                    Select::make('tahun_lulus')
                        ->label('Filter Tahun Lulus')
                        ->placeholder('Semua Tahun')
                        ->options(
                            fn () => Alumni::query()
                                ->distinct()
                                ->orderByDesc('tahun_lulus')
                                ->pluck('tahun_lulus', 'tahun_lulus')
                        ),
                ])
                ->action(fn (array $data) => Excel::download(
                    new AlumniExport($data['tahun_lulus'] ?? null),
                    'alumni-'.now()->format('Ymd-His').'.xlsx'
                )),

            // ── 3. Import Foto Alumni (ZIP) ────────────────────────────
            Action::make('import_foto')
                ->label('Import Foto (ZIP)')
                ->icon(Heroicon::Photo)
                ->color(Color::Orange)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Foto Alumni dari ZIP')
                ->modalDescription('Upload 1 file ZIP berisi foto alumni. Nama file harus berupa NISN 10 digit. Format yang didukung: jpg, jpeg, png, webp.')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('zip_file')
                        ->label('File ZIP berisi foto')
                        ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(204800)
                        ->required()
                        ->helperText('Maks. 200 MB. Nama file = NISN 10 digit, contoh: 0012345678.jpg'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['zip_file']);

                    try {
                        $result = (new ImportFoto)->execute(
                            zipPath: $path,
                            modelClass: Alumni::class,
                            identifierCol: 'nisn',
                            fotoCol: 'foto',
                            storageDir: 'foto-alumni',
                        );

                        $this->sendImportNotification($result, 'Foto alumni');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 4. Unduh Template Excel ────────────────────────────────
            Action::make('template')
                ->label('Unduh Template')
                ->icon(Heroicon::DocumentArrowDown)
                ->color(Color::Gray)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->action(fn () => Excel::download(
                    new AlumniTemplateExport,
                    'template-alumni.xlsx'
                )),

            // ── 5. Tambah Alumni ───────────────────────────────────────
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Pages/ViewAlumni.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Filament\Resources\Alumnis\AlumniResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ViewAlumni extends ViewRecord
{
    protected static string $resource = AlumniResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::PencilSquare)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Cyan),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Schemas/AlumniForm.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlumniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Alumni')
                ->icon('heroicon-o-academic-cap')
                ->columns(3)
                ->schema([
                    FileUpload::make('foto')
                        ->hiddenLabel()
                        ->avatar()
                        ->image()
                        ->directory('alumni')
                        ->maxSize(1024)
                        ->visibility('public')
                        ->disk('public')
                        ->imageEditor()
                        ->columnSpanFull()
                        ->imageEditorAspectRatios([
                            '1:1' => '1:1',
                            null,
                        ])
                        ->circleCropper()
                        ->getUploadedFileNameForStorageUsing(function ($file, $record) {
                            $nisn = $record?->nisn ?? 'alumni_'.time();
                            $ext = $file->getClientOriginalExtension();

                            return strtolower($nisn).'.'.$ext;
                        })
                        ->extraAttributes([
                            'class' => 'flex flex-col items-center',
                        ])
                        ->columnSpanFull(),
                    TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('nisn')
                        ->required()
                        ->maxLength(10)
                        ->label('NISN'),
                    TextInput::make('tahun_lulus')
                        ->required()
                        ->numeric()
                        ->minValue(2000)
                        ->maxValue(now()->year),
                ]),

            Section::make('Kutipan')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->schema([
                    Textarea::make('quote')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Schemas/AlumniInfolist.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlumniInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Alumni')
                ->icon('heroicon-o-academic-cap')
                ->columns(4)
                ->schema([
                    ImageEntry::make('foto')
                        ->disk('public')
                        ->hiddenLabel()
                        ->height(80)
                        ->placeholder('-')
                        ->extraAttributes([
                            'class' => 'flex flex-col items-center',
                        ]),
                    TextEntry::make('nama'),
                    TextEntry::make('nisn')->label('NISN'),
                    TextEntry::make('tahun_lulus'),
                ]),

            Section::make('Waktu')
                ->icon('heroicon-o-clock')
                ->columns(2)
                ->schema([
                    TextEntry::make('created_at')->dateTime('d F Y H:i')->placeholder('-'),
                    TextEntry::make('updated_at')->dateTime('d F Y H:i')->placeholder('-'),
                ]),

            Section::make('Kutipan')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->schema([
                    TextEntry::make('quote')
                        ->placeholder('-')
                        ->columnSpanFull(),
                ])
                ->collapsed()
                ->columnSpanFull(),

        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Tables/AlumnisTable.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlumnisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(asset('images/default.png')),
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                TextColumn::make('tahun_lulus')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d F Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('tahun_lulus', 'desc')
            ->filters([])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->icon(Heroicon::Eye)
                        ->label('Lihat')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Zinc),
                    EditAction::make()
                        ->icon(Heroicon::PencilSquare)
                        ->label('Ubah')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Blue),
                    DeleteAction::make()
                        ->icon(Heroicon::Trash)
                        ->label('Hapus')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Red),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Instansis/InstansiResource.php`

```php
<?php

namespace App\Filament\Resources\Instansis;

use App\Filament\Resources\Instansis\Pages\CreateInstansi;
use App\Filament\Resources\Instansis\Pages\EditInstansi;
use App\Filament\Resources\Instansis\Pages\ListInstansis;
use App\Filament\Resources\Instansis\Pages\ViewInstansi;
use App\Filament\Resources\Instansis\Schemas\InstansiForm;
use App\Filament\Resources\Instansis\Schemas\InstansiInfolist;
use App\Filament\Resources\Instansis\Tables\InstansisTable;
use App\Models\Instansi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InstansiResource extends Resource
{
    protected static ?string $model = Instansi::class;

    protected static bool $shouldRegisterNavigation = true;

    // protected static string|UnitEnum|null $navigationGroup = 'Personil';
    protected static ?string $navigationLabel = 'Instansi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice2;

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return InstansiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InstansiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstansisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInstansis::route('/'),
            // 'create' => CreateInstansi::route('/create'),
            // 'view' => ViewInstansi::route('/{record}'),
            'edit' => EditInstansi::route('/{record}/edit'),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Instansis/Pages/CreateInstansi.php`

```php
<?php

namespace App\Filament\Resources\Instansis\Pages;

use App\Filament\Resources\Instansis\InstansiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInstansi extends CreateRecord
{
    protected static string $resource = InstansiResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Instansis/Pages/EditInstansi.php`

```php
<?php

namespace App\Filament\Resources\Instansis\Pages;

use App\Filament\Resources\Instansis\InstansiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class EditInstansi extends EditRecord
{
    protected static string $resource = InstansiResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
    // protected function getHeaderActions(): array
    // {
    //     return [
    //         ViewAction::make()
    //             ->icon(Heroicon::Eye)
    //             ->label('')
    //             ->outlined()
    //             ->size('sm')
    //             ->color(Color::Zinc),
    //         DeleteAction::make()
    //             ->icon(Heroicon::Trash)
    //             ->label('')
    //             ->outlined()
    //             ->size('sm')
    //             ->color(Color::Rose),
    //     ];
    // }
}

```

---

### 📄 File: `./app/Filament/Resources/Instansis/Pages/ListInstansis.php`

```php
<?php

namespace App\Filament\Resources\Instansis\Pages;

use App\Filament\Resources\Instansis\InstansiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ListInstansis extends ListRecords
{
    protected static string $resource = InstansiResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make()
    //             ->icon(Heroicon::PlusCircle)
    //             ->label('')
    //             ->outlined()
    //             ->size('sm')
    //             ->color(Color::Green),
    //     ];
    // }
}

```

---

### 📄 File: `./app/Filament/Resources/Instansis/Pages/ViewInstansi.php`

```php
<?php

namespace App\Filament\Resources\Instansis\Pages;

use App\Filament\Resources\Instansis\InstansiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ViewInstansi extends ViewRecord
{
    protected static string $resource = InstansiResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
    // protected function getHeaderActions(): array
    // {
    //     return [
    //         EditAction::make()
    //             ->icon(Heroicon::PencilSquare)
    //             ->label('')
    //             ->outlined()
    //             ->size('sm')
    //             ->color(Color::Cyan),
    //     ];
    // }
}

```

---

### 📄 File: `./app/Filament/Resources/Instansis/Schemas/InstansiForm.php`

```php
<?php

namespace App\Filament\Resources\Instansis\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InstansiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Instansi')
                ->icon('heroicon-o-building-office-2')
                ->columns(3)
                ->schema([
                    TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('npsn')
                        ->required()
                        ->label('NPSN')
                        ->maxLength(20),
                    Select::make('jenjang')
                        ->required()
                        ->native(false)
                        ->options([
                            'SD' => 'SD',
                            'MI' => 'MI',
                            'SMP' => 'SMP',
                            'MTS' => 'MTS',
                            'SMA' => 'SMA',
                            'SMK' => 'SMK',
                            'MA' => 'MA',
                        ]),
                    Select::make('akreditasi')
                        ->required()
                        ->native(false)
                        ->options([
                            'A' => 'A',
                            'B' => 'B',
                            'C' => 'C',
                            'TT' => 'TT',
                        ]),
                    TextInput::make('nomor_surat'),
                    Toggle::make('status')
                        ->label('Aktif')
                        ->inline(false),
                ]),

            Section::make('Logo & Aset')
                ->icon('heroicon-o-photo')
                ->columns(2)
                ->schema([
                    FileUpload::make('logo')
                        ->image()
                        ->imagePreviewHeight('80')
                        ->label('Logo Instansi')
                        ->directory('instansi')
                        ->maxSize(1024)
                        ->visibility('public')
                        ->disk('public')
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '1:1' => '1:1',
                            '4:3' => '4:3',
                            '16:9' => '16:9',
                            null,
                        ])
                        ->getUploadedFileNameForStorageUsing(function ($file, $record) {
                            $npsn = $record?->npsn ?? 'logo_'.time();
                            $ext = $file->getClientOriginalExtension();

                            return strtolower($npsn).'.'.$ext;
                        }),
                    FileUpload::make('logo_institusi')
                        ->image()
                        ->imagePreviewHeight('80')
                        ->label('Logo Institusi')
                        ->directory('institusi')
                        ->maxSize(1024)
                        ->visibility('public')
                        ->disk('public')
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '1:1' => '1:1',
                            '4:3' => '4:3',
                            '16:9' => '16:9',
                            null,
                        ])
                        ->getUploadedFileNameForStorageUsing(function ($file, $record) {
                            $npsn = $record?->npsn ?? 'logo_institusi_'.time();
                            $ext = $file->getClientOriginalExtension();

                            return strtolower($npsn).'.'.$ext;
                        }),
                ]),

            Section::make('Pimpinan')
                ->icon('heroicon-o-user-circle')
                ->columns(3)
                ->schema([
                    TextInput::make('nama_pimpinan')->label('Nama Pimpinan')->placeholder('-'),
                    TextInput::make('nip_pimpinan')->label('NIP Pimpinan')->placeholder('-'),
                    FileUpload::make('tte_pimpinan')
                        ->image()
                        ->disk('public')
                        ->directory('instansi/tte')
                        ->imagePreviewHeight('80')
                        ->label('TTE Pimpinan'),
                ]),

            Section::make('Panitia')
                ->icon('heroicon-o-user-circle')
                ->columns(3)
                ->schema([
                    TextInput::make('nama_ketua')->label('Nama Ketua Panitia')->placeholder('-'),
                    TextInput::make('nip_ketua')->label('NIP Ketua Panitia')->placeholder('-'),
                    FileUpload::make('tte_ketua')
                        ->image()
                        ->disk('public')
                        ->directory('instansi/tte')
                        ->imagePreviewHeight('80')
                        ->label('TTE Ketua Panitia'),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Instansis/Schemas/InstansiInfolist.php`

```php
<?php

namespace App\Filament\Resources\Instansis\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InstansiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Instansi')
                ->icon('heroicon-o-building-office-2')
                ->columns(3)
                ->schema([
                    TextEntry::make('nama'),
                    TextEntry::make('npsn')
                        ->label('NPSN'),
                    TextEntry::make('jenjang')
                        ->badge(),
                    TextEntry::make('akreditasi')
                        ->badge(),
                    TextEntry::make('nomor_surat')
                        ->label('Nomor Surat Undangan')->placeholder('-')
                        ->badge(),
                    IconEntry::make('status')->boolean()->label('Aktif'),
                ]),

            Section::make('Logo & Aset')
                ->icon('heroicon-o-photo')
                ->columns(2)
                ->schema([
                    ImageEntry::make('logo')
                        ->disk('public')
                        ->height(80)
                        ->placeholder('-')
                        ->label('Logo Instansi'),
                    ImageEntry::make('logo_institusi')
                        ->disk('public')
                        ->height(80)
                        ->placeholder('-')
                        ->label('Logo Institusi'),
                ]),

            Section::make('Pimpinan')
                ->icon('heroicon-o-user-circle')
                ->columns(3)
                ->schema([
                    TextEntry::make('nama_pimpinan')->label('Nama Pimpinan')->placeholder('-'),
                    TextEntry::make('nip_pimpinan')->label('NIP Pimpinan')->placeholder('-'),
                    ImageEntry::make('tte_pimpinan')
                        ->disk('public')
                        ->height(80)
                        ->placeholder('-')
                        ->label('TTE Pimpinan'),
                ]),

            Section::make('Panitia')
                ->icon('heroicon-o-user-circle')
                ->columns(3)
                ->schema([
                    TextEntry::make('nama_ketua')->label('Nama Ketua Panitia')->placeholder('-'),
                    TextEntry::make('nip_ketua')->label('NIP Ketua Panitia')->placeholder('-'),
                    ImageEntry::make('tte_ketua')
                        ->disk('public')
                        ->height(80)
                        ->placeholder('-')
                        ->label('TTE Ketua Panitia'),
                ]),

            Section::make('Waktu')
                ->icon('heroicon-o-clock')
                ->columns(2)
                ->collapsed()
                ->columnSpanFull()
                ->schema([
                    TextEntry::make('created_at')->dateTime('d F Y H:i')->placeholder('-'),
                    TextEntry::make('updated_at')->dateTime('d F Y H:i')->placeholder('-'),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Instansis/Tables/InstansisTable.php`

```php
<?php

namespace App\Filament\Resources\Instansis\Tables;

// use Filament\Actions\ActionGroup;
// use Filament\Actions\BulkActionGroup;
// use Filament\Actions\DeleteAction;
// use Filament\Actions\DeleteBulkAction;
// use Filament\Actions\EditAction;
// use Filament\Actions\ViewAction;
// use Filament\Support\Colors\Color;
// use Filament\Support\Icons\Heroicon;
// use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InstansisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->disk('public')
                    ->height(40)
                    ->defaultImageUrl(asset('images/default.png')),
                TextColumn::make('nama'),
                // ->searchable()
                // ->sortable(),
                TextColumn::make('npsn')
                    ->label('NPSN'),
                // ->searchable(),
                TextColumn::make('jenjang'),
                // ->searchable(),
                TextColumn::make('akreditasi'),
                // ->searchable(),
                // IconColumn::make('status')
                //     ->boolean()
                //     ->label('Aktif'),
                // TextColumn::make('created_at')
                //     ->dateTime('d F Y H:i')
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->filters([])
            ->recordActions([
                //     ActionGroup::make([
                //         ViewAction::make()
                //             ->icon(Heroicon::Eye)
                //             ->label('Lihat')
                //             ->outlined()
                //             ->size('sm')
                //             ->color(Color::Zinc),
                //         EditAction::make()
                //             ->icon(Heroicon::PencilSquare)
                //             ->label('Ubah')
                //             ->outlined()
                //             ->size('sm')
                //             ->color(Color::Blue),
                //         DeleteAction::make()
                //             ->icon(Heroicon::Trash)
                //             ->label('Hapus')
                //             ->outlined()
                //             ->size('sm')
                //             ->color(Color::Red),
                //     ]),
                // ])
                // ->toolbarActions([
                //     BulkActionGroup::make([
                //         DeleteBulkAction::make(),
                //     ]),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/Pages/CreatePersonil.php`

```php
<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Filament\Resources\Personils\PersonilResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePersonil extends CreateRecord
{
    protected static string $resource = PersonilResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/Pages/EditPersonil.php`

```php
<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Filament\Resources\Personils\PersonilResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class EditPersonil extends EditRecord
{
    protected static string $resource = PersonilResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon(Heroicon::Eye)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Zinc),
            DeleteAction::make()
                ->icon(Heroicon::Trash)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Rose),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/Pages/ListPersonils.php`

```php
<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Actions\ImportFoto;
use App\Exports\PersonilExport;
use App\Exports\Templates\PersonilTemplateExport;
use App\Filament\Concerns\HasImportActions;
use App\Filament\Resources\Personils\PersonilResource;
use App\Imports\PersonilImport;
use App\Models\Personil;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Maatwebsite\Excel\Facades\Excel;

class ListPersonils extends ListRecords
{
    use HasImportActions;

    protected static string $resource = PersonilResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            // ── 1. Import Excel ────────────────────────────────────────
            Action::make('import_excel')
                ->label('Import Excel')
                ->icon(Heroicon::ArrowUpTray)
                ->color(Color::Blue)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Data Personil dari Excel')
                ->modalDescription('Upload file Excel (.xlsx). Gunakan template agar format kolom sesuai.')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel (.xlsx / .xls)')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                        ])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(5120)
                        ->required()
                        ->helperText('Kolom wajib: nama, jabatan. Opsional: nip, telepon, sosial_media, quote. Maks. 5 MB.'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['file']);

                    try {
                        $import = new PersonilImport;
                        Excel::import($import, $path);

                        $this->sendExcelNotification($import->getBerhasil(), $import->failures(), 'personil');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 2. Export Excel ────────────────────────────────────────
            Action::make('export_excel')
                ->label('Export Excel')
                ->icon(Heroicon::ArrowDownTray)
                ->color(Color::Emerald)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->action(fn () => Excel::download(
                    new PersonilExport,
                    'personil-'.now()->format('Ymd-His').'.xlsx'
                )),

            // ── 3. Import Foto Personil (ZIP) ──────────────────────────
            Action::make('import_foto')
                ->label('Import Foto (ZIP)')
                ->icon(Heroicon::Photo)
                ->color(Color::Orange)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Foto Personil dari ZIP')
                ->modalDescription('Upload 1 file ZIP berisi foto personil. Nama file harus berupa NIP. Format yang didukung: jpg, jpeg, png, webp. Untuk personil tanpa NIP, gunakan fitur edit manual.')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('zip_file')
                        ->label('File ZIP berisi foto')
                        ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(204800)
                        ->required()
                        ->helperText('Maks. 200 MB. Nama file = NIP personil, contoh: 196501011990032001.jpg'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['zip_file']);

                    try {
                        $result = (new ImportFoto)->execute(
                            zipPath: $path,
                            modelClass: Personil::class,
                            identifierCol: 'nip',
                            fotoCol: 'foto',
                            storageDir: 'foto-personil',
                        );

                        $this->sendImportNotification($result, 'Foto personil');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 4. Unduh Template Excel ────────────────────────────────
            Action::make('template')
                ->label('Unduh Template')
                ->icon(Heroicon::DocumentArrowDown)
                ->color(Color::Gray)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->action(fn () => Excel::download(
                    new PersonilTemplateExport,
                    'template-personil.xlsx'
                )),

            // ── 5. Tambah Personil ─────────────────────────────────────
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/Pages/ViewPersonil.php`

```php
<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Filament\Resources\Personils\PersonilResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ViewPersonil extends ViewRecord
{
    protected static string $resource = PersonilResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::PencilSquare)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Cyan),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/PersonilResource.php`

```php
<?php

namespace App\Filament\Resources\Personils;

use App\Filament\Resources\Personils\Pages\CreatePersonil;
use App\Filament\Resources\Personils\Pages\EditPersonil;
use App\Filament\Resources\Personils\Pages\ListPersonils;
use App\Filament\Resources\Personils\Pages\ViewPersonil;
use App\Filament\Resources\Personils\Schemas\PersonilForm;
use App\Filament\Resources\Personils\Schemas\PersonilInfolist;
use App\Filament\Resources\Personils\Tables\PersonilsTable;
use App\Models\Personil;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PersonilResource extends Resource
{
    protected static ?string $model = Personil::class;

    protected static bool $shouldRegisterNavigation = true;

    // protected static string|UnitEnum|null $navigationGroup = 'Personil';
    protected static ?string $navigationLabel = 'Personil';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return PersonilForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PersonilInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PersonilsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPersonils::route('/'),
            'create' => CreatePersonil::route('/create'),
            'view' => ViewPersonil::route('/{record}'),
            'edit' => EditPersonil::route('/{record}/edit'),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/Schemas/PersonilForm.php`

```php
<?php

namespace App\Filament\Resources\Personils\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PersonilForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Personil')
                ->icon('heroicon-o-identification')
                ->columns(3)
                ->schema([
                    TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    Select::make('jabatan')
                        ->required()
                        ->native(false)
                        ->options([
                            'Kepala Madrasah' => 'Kepala Madrasah',
                            'Wakil Kepala Madrasah' => 'Wakil Kepala Madrasah',
                            'Komite Madrasah' => 'Komite Madrasah',
                            'Guru' => 'Guru',
                            'Kepala Tata Usaha' => 'Kepala Tata Usaha',
                            'Bendahara' => 'Bendahara',
                            'Staf Tata Usaha' => 'Staf Tata Usaha',
                            'Outsourcing' => 'Outsourcing',
                        ]),
                    TextInput::make('nip')
                        ->label('NIP')
                        ->maxLength(30),
                    TextInput::make('telepon')
                        ->tel()
                        ->maxLength(15),
                    TextInput::make('sosial_media')
                        ->label('Sosial Media')
                        ->url(),
                    FileUpload::make('foto')
                        ->image()
                        ->imagePreviewHeight('80')
                        ->label('Foto')
                        ->directory('personil')
                        ->maxSize(1024)
                        ->visibility('public')
                        ->disk('public')
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '1:1' => '1:1',
                            '4:3' => '4:3',
                            '16:9' => '16:9',
                            null,
                        ])
                        ->getUploadedFileNameForStorageUsing(function ($file, $record) {
                            $nip = $record?->nip ?? 'foto_'.time();
                            $ext = $file->getClientOriginalExtension();

                            return strtolower($nip).'.'.$ext;
                        }),
                ]),

            Section::make('Kutipan')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->schema([
                    Textarea::make('quote')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/Schemas/PersonilInfolist.php`

```php
<?php

namespace App\Filament\Resources\Personils\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PersonilInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Personil')
                ->icon('heroicon-o-identification')
                ->columns(2)
                ->schema([
                    TextEntry::make('nama'),
                    TextEntry::make('jabatan'),
                    TextEntry::make('nip')->label('NIP')->placeholder('-'),
                    TextEntry::make('telepon')->placeholder('-'),
                    TextEntry::make('sosial_media')->label('Sosial Media')->placeholder('-'),
                    ImageEntry::make('foto')
                        ->disk('public')
                        ->height(80)
                        ->placeholder('-')
                        ->columnSpanFull(),
                ]),

            Section::make('Kutipan')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->schema([
                    TextEntry::make('quote')
                        ->placeholder('-')
                        ->columnSpanFull(),
                ]),

            Section::make('Waktu')
                ->icon('heroicon-o-clock')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextEntry::make('created_at')->dateTime('d F Y H:i')->placeholder('-'),
                    TextEntry::make('updated_at')->dateTime('d F Y H:i')->placeholder('-'),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/Tables/PersonilsTable.php`

```php
<?php

namespace App\Filament\Resources\Personils\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PersonilsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(asset('images/default.png')),
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jabatan')
                    ->searchable(),
                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable(),
                TextColumn::make('telepon')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d F Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->icon(Heroicon::Eye)
                        ->label('Lihat')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Zinc),
                    EditAction::make()
                        ->icon(Heroicon::PencilSquare)
                        ->label('Ubah')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Blue),
                    DeleteAction::make()
                        ->icon(Heroicon::Trash)
                        ->label('Hapus')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Red),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/Pages/CreateSiswa.php`

```php
<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/Pages/EditSiswa.php`

```php
<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon(Heroicon::Eye)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Zinc),
            DeleteAction::make()
                ->icon(Heroicon::Trash)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Rose),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/Pages/ListSiswas.php`

```php
<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Actions\ImportDokumen;
use App\Actions\ImportFoto;
use App\Enums\StatusSiswa;
use App\Exports\SiswaExport;
use App\Exports\Templates\SiswaTemplateExport;
use App\Filament\Concerns\HasImportActions;
use App\Filament\Resources\Siswas\SiswaResource;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Maatwebsite\Excel\Facades\Excel;

class ListSiswas extends ListRecords
{
    use HasImportActions;

    protected static string $resource = SiswaResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            // ── 1. Import Excel ────────────────────────────────────────
            Action::make('import_excel')
                ->label('Import Excel')
                ->icon(Heroicon::ArrowUpTray)
                ->color(Color::Blue)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Data Siswa dari Excel')
                ->modalDescription('Upload file Excel (.xlsx). Gunakan template agar format kolom sesuai.')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel (.xlsx / .xls)')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                        ])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(5120)
                        ->required()
                        ->helperText('Kolom wajib: nama, nisn. Opsional: nama_orangtua, telepon, status. Maks. 5 MB.'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['file']);

                    try {
                        $import = new SiswaImport;
                        Excel::import($import, $path);

                        $this->sendExcelNotification($import->getBerhasil(), $import->failures(), 'siswa');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 2. Export Excel ────────────────────────────────────────
            Action::make('export_excel')
                ->label('Export Excel')
                ->icon(Heroicon::ArrowDownTray)
                ->color(Color::Emerald)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Export Data Siswa')
                ->modalSubmitActionLabel('Export Sekarang')
                ->form([
                    Select::make('status')
                        ->label('Filter Status Kelulusan')
                        ->placeholder('Semua Status')
                        ->options(StatusSiswa::class),
                ])
                ->action(function (array $data) {
                    $status = $data['status'] ?? null;
                    if ($status instanceof StatusSiswa) {
                        $status = $status->value;
                    }

                    return Excel::download(
                        new SiswaExport($status),
                        'siswa-'.now()->format('Ymd-His').'.xlsx'
                    );
                }),

            // ── 3a. Import SKL (ZIP berisi PDF) ───────────────────────
            Action::make('import_skl')
                ->label('Import SKL (ZIP)')
                ->icon(Heroicon::DocumentArrowUp)
                ->color(Color::Purple)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Berkas SKL dari ZIP')
                ->modalDescription('Upload 1 file ZIP yang berisi file-file PDF. Nama setiap PDF harus berupa NISN 10 digit, contoh: 0012345678.pdf')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('zip_file')
                        ->label('File ZIP berisi PDF SKL')
                        ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(102400)
                        ->required()
                        ->helperText('Maks. 100 MB. Nama file PDF = NISN 10 digit, contoh: 0012345678.pdf'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['zip_file']);

                    try {
                        $result = (new ImportDokumen)->execute($path, 'berkas_skl', 'skl', 'SKL');
                        $this->sendImportNotification($result, 'SKL');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 3b. Import Undangan (ZIP berisi PDF) ──────────────────
            Action::make('import_undangan')
                ->label('Import Undangan (ZIP)')
                ->icon(Heroicon::DocumentArrowUp)
                ->color(Color::Purple)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Berkas Undangan dari ZIP')
                ->modalDescription('Upload 1 file ZIP yang berisi file-file PDF. Nama setiap PDF harus berupa NISN 10 digit, contoh: 0012345678.pdf')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('zip_file')
                        ->label('File ZIP berisi PDF Undangan')
                        ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(102400)
                        ->required()
                        ->helperText('Maks. 100 MB. Nama file PDF = NISN 10 digit, contoh: 0012345678.pdf'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['zip_file']);

                    try {
                        $result = (new ImportDokumen)->execute($path, 'berkas_undangan', 'undangan', 'Undangan');
                        $this->sendImportNotification($result, 'Undangan');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 4. Import Foto Siswa (ZIP) ─────────────────────────────
            Action::make('import_foto')
                ->label('Import Foto (ZIP)')
                ->icon(Heroicon::Photo)
                ->color(Color::Orange)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Import Foto Siswa dari ZIP')
                ->modalDescription('Upload 1 file ZIP berisi foto siswa. Nama file harus berupa NISN 10 digit. Format yang didukung: jpg, jpeg, png, webp.')
                ->modalSubmitActionLabel('Import Sekarang')
                ->form([
                    FileUpload::make('zip_file')
                        ->label('File ZIP berisi foto')
                        ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                        ->disk('local')
                        ->directory('imports-tmp')
                        ->visibility('private')
                        ->maxSize(204800)
                        ->required()
                        ->helperText('Maks. 200 MB. Nama file = NISN 10 digit, contoh: 0012345678.jpg'),
                ])
                ->action(function (array $data): void {
                    $path = $this->resolveUpload($data['zip_file']);

                    try {
                        $result = (new ImportFoto)->execute(
                            zipPath: $path,
                            modelClass: Siswa::class,
                            identifierCol: 'nisn',
                            fotoCol: 'foto',
                            storageDir: 'foto-siswa',
                        );

                        $this->sendImportNotification($result, 'Foto siswa');
                    } finally {
                        @unlink($path);
                    }
                }),

            // ── 5. Unduh Template Excel ────────────────────────────────
            Action::make('template')
                ->label('Unduh Template')
                ->icon(Heroicon::DocumentArrowDown)
                ->color(Color::Gray)
                ->outlined()
                ->size('sm')
                ->requiresConfirmation()
                ->modalHeading('Unduh Template Excel')
                ->modalDescription('Apakah Anda yakin ingin mengunduh template Excel untuk mengisi data siswa?')
                ->action(fn () => Excel::download(
                    new SiswaTemplateExport,
                    'template-siswa.xlsx'
                )),

            // ── 6. Tambah Siswa ────────────────────────────────────────
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/Pages/ViewSiswa.php`

```php
<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ViewSiswa extends ViewRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::PencilSquare)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Cyan),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/Schemas/SiswaForm.php`

```php
<?php

namespace App\Filament\Resources\Siswas\Schemas;

use App\Enums\StatusSiswa;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Siswa')
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    TextInput::make('nama')
                        ->label('Nama Siswa')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('nisn')
                        ->required()
                        ->label('NISN')
                        ->maxLength(10),
                    TextInput::make('nama_orangtua')
                        ->label('Nama Orang Tua')
                        ->maxLength(255),
                    TextInput::make('telepon')
                        ->tel()
                        ->maxLength(15),
                    FileUpload::make('foto')
                        ->label('Foto Siswa')
                        ->openable()
                        ->directory('foto-siswa')
                        ->columnSpanFull()
                        ->maxSize(2048) // 2MB
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->helperText('Unggah foto siswa dalam format JPG, PNG, atau WEBP dengan ukuran maksimal 2MB.'),
                ]),

            Section::make('Data Sistem')
                ->columns(2)
                ->icon('heroicon-o-circle-stack')
                ->schema([
                    Select::make('status')
                        ->options(StatusSiswa::class)
                        ->native(false)
                        ->columnSpanFull()
                        ->required()
                        ->default(StatusSiswa::Lulus),
                    FileUpload::make('berkas_skl')->label('Berkas SKL')
                        ->directory('berkas-skl')
                        ->openable()
                        ->maxSize(2048) // 2MB
                        ->acceptedFileTypes(['application/pdf'])
                        ->helperText('Unggah berkas SKL dalam format PDF dengan ukuran maksimal 2MB.'),
                    FileUpload::make('berkas_undangan')->label('Berkas undangan')
                        ->directory('berkas-undangan')
                        ->openable()
                        ->maxSize(2048) // 2MB
                        ->acceptedFileTypes(['application/pdf'])
                        ->helperText('Unggah berkas undangan dalam format PDF dengan ukuran maksimal 2MB.'),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/Schemas/SiswaInfolist.php`

```php
<?php

namespace App\Filament\Resources\Siswas\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Siswa')
                ->icon('heroicon-o-user')
                ->columns(3)
                ->schema([
                    ImageEntry::make('foto')->placeholder('-'),
                    TextEntry::make('nama'),
                    TextEntry::make('nama_orangtua')->label('Nama Orang Tua')->placeholder('-'),
                    TextEntry::make('nisn')->label('NISN'),
                    TextEntry::make('telepon')->placeholder('-'),
                    TextEntry::make('status')
                        ->badge(),
                ]),

            Section::make('Data Sistem')
                ->icon('heroicon-o-circle-stack')
                ->columns(2)
                ->schema([
                    TextEntry::make('berkas_skl')->placeholder('-'),
                    TextEntry::make('berkas_undangan')->placeholder('-'),
                    TextEntry::make('created_at')->dateTime('d F Y H:i')->placeholder('-'),
                    TextEntry::make('updated_at')->dateTime('d F Y H:i')->placeholder('-'),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/SiswaResource.php`

```php
<?php

namespace App\Filament\Resources\Siswas;

use App\Filament\Resources\Siswas\Pages\CreateSiswa;
use App\Filament\Resources\Siswas\Pages\EditSiswa;
use App\Filament\Resources\Siswas\Pages\ListSiswas;
use App\Filament\Resources\Siswas\Pages\ViewSiswa;
use App\Filament\Resources\Siswas\Schemas\SiswaForm;
use App\Filament\Resources\Siswas\Schemas\SiswaInfolist;
use App\Filament\Resources\Siswas\Tables\SiswasTable;
use App\Models\Siswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static bool $shouldRegisterNavigation = true;

    // protected static string|UnitEnum|null $navigationGroup = 'Personil';
    protected static ?string $navigationLabel = 'Siswa';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return SiswaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SiswaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiswasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSiswas::route('/'),
            'create' => CreateSiswa::route('/create'),
            'view' => ViewSiswa::route('/{record}'),
            'edit' => EditSiswa::route('/{record}/edit'),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/Tables/SiswasTable.php`

```php
<?php

namespace App\Filament\Resources\Siswas\Tables;

use App\Enums\StatusSiswa;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular(),
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                TextColumn::make('nama_orangtua')
                    ->label('Nama Orang Tua')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('telepon')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('berkas_skl')
                    ->label('SKL')
                    ->url(fn ($record) => $record->berkas_skl ? asset('storage/'.$record->berkas_skl) : null),
                TextColumn::make('berkas_undangan')
                    ->label('Undangan')
                    ->url(fn ($record) => $record->berkas_undangan ? asset('storage/'.$record->berkas_undangan) : null),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(StatusSiswa::class),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->icon(Heroicon::Eye)
                        ->label('Lihat')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Zinc),
                    EditAction::make()
                        ->icon(Heroicon::PencilSquare)
                        ->label('Ubah')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Blue),
                    DeleteAction::make()
                        ->icon(Heroicon::Trash)
                        ->label('Hapus')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Red),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TahunPelajarans/Pages/CreateTahunPelajaran.php`

```php
<?php

namespace App\Filament\Resources\TahunPelajarans\Pages;

use App\Filament\Resources\TahunPelajarans\TahunPelajaranResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTahunPelajaran extends CreateRecord
{
    protected static string $resource = TahunPelajaranResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TahunPelajarans/Pages/EditTahunPelajaran.php`

```php
<?php

namespace App\Filament\Resources\TahunPelajarans\Pages;

use App\Filament\Resources\TahunPelajarans\TahunPelajaranResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class EditTahunPelajaran extends EditRecord
{
    protected static string $resource = TahunPelajaranResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make()
            //     ->icon(Heroicon::Eye)
            //     ->label('')
            //     ->outlined()
            //     ->size('sm')
            //     ->color(Color::Zinc),
            DeleteAction::make()
                ->icon(Heroicon::Trash)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Rose),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TahunPelajarans/Pages/ListTahunPelajarans.php`

```php
<?php

namespace App\Filament\Resources\TahunPelajarans\Pages;

use App\Filament\Resources\TahunPelajarans\TahunPelajaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ListTahunPelajarans extends ListRecords
{
    protected static string $resource = TahunPelajaranResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TahunPelajarans/Pages/ViewTahunPelajaran.php`

```php
<?php

namespace App\Filament\Resources\TahunPelajarans\Pages;

use App\Filament\Resources\TahunPelajarans\TahunPelajaranResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ViewTahunPelajaran extends ViewRecord
{
    protected static string $resource = TahunPelajaranResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::PencilSquare)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Cyan),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TahunPelajarans/Schemas/TahunPelajaranForm.php`

```php
<?php

namespace App\Filament\Resources\TahunPelajarans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TahunPelajaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas')
                ->icon('heroicon-o-calendar-days')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->label('Nama Tahun Pelajaran')
                        ->columnSpanFull(),
                    Toggle::make('status')
                        ->label('Aktif')
                        ->inline(false),
                ]),

            Section::make('Jadwal Pengumuman')
                ->icon('heroicon-o-megaphone')
                ->columns(2)
                ->schema([
                    DateTimePicker::make('jadwal_pengumuman_mulai')
                        ->required()
                        ->label('Mulai'),
                    DateTimePicker::make('jadwal_pengumuman_selesai')
                        ->required()
                        ->label('Selesai'),
                ]),

            Section::make('Jadwal Kelulusan')
                ->icon('heroicon-o-academic-cap')
                ->columns(2)
                ->schema([
                    DateTimePicker::make('jadwal_kelulusan_mulai')
                        ->label('Mulai'),
                    DateTimePicker::make('jadwal_kelulusan_selesai')
                        ->label('Selesai'),
                    TextInput::make('jadwal_kelulusan_tempat')
                        ->label('Tempat')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TahunPelajarans/Schemas/TahunPelajaranInfolist.php`

```php
<?php

namespace App\Filament\Resources\TahunPelajarans\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TahunPelajaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas')
                ->icon('heroicon-o-calendar-days')
                ->columns(2)
                ->schema([
                    TextEntry::make('name')->label('Nama Tahun Pelajaran')->columnSpanFull(),
                    IconEntry::make('status')->boolean()->label('Aktif'),
                ]),

            Section::make('Jadwal Pengumuman')
                ->icon('heroicon-o-megaphone')
                ->columns(2)
                ->schema([
                    TextEntry::make('jadwal_pengumuman_mulai')->dateTime('d F Y H:i')->label('Mulai'),
                    TextEntry::make('jadwal_pengumuman_selesai')->dateTime('d F Y H:i')->label('Selesai'),
                ]),

            Section::make('Jadwal Kelulusan')
                ->icon('heroicon-o-academic-cap')
                ->columns(2)
                ->schema([
                    TextEntry::make('jadwal_kelulusan_mulai')->dateTime('d F Y H:i')->label('Mulai')->placeholder('-'),
                    TextEntry::make('jadwal_kelulusan_selesai')->dateTime('d F Y H:i')->label('Selesai')->placeholder('-'),
                    TextEntry::make('jadwal_kelulusan_tempat')->label('Tempat')->placeholder('-')->columnSpanFull(),
                ]),

            Section::make('Waktu')
                ->icon('heroicon-o-clock')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextEntry::make('created_at')->dateTime('d F Y H:i')->placeholder('-'),
                    TextEntry::make('updated_at')->dateTime('d F Y H:i')->placeholder('-'),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TahunPelajarans/Tables/TahunPelajaransTable.php`

```php
<?php

namespace App\Filament\Resources\TahunPelajarans\Tables;

use App\Models\TahunPelajaran;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TahunPelajaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tahun Pelajaran')
                    ->searchable(TahunPelajaran::count() >= 10)
                    ->sortable(TahunPelajaran::count() >= 10),
                TextColumn::make('jadwal_pengumuman_mulai')
                    ->label('Pengumuman Mulai')
                    ->dateTime('d F Y H:i')
                    ->sortable(TahunPelajaran::count() >= 10),
                TextColumn::make('jadwal_pengumuman_selesai')
                    ->label('Pengumuman Selesai')
                    ->dateTime('d F Y H:i')
                    ->sortable(TahunPelajaran::count() >= 10),
                TextColumn::make('jadwal_kelulusan_tempat')
                    ->label('Tempat Kelulusan')
                    ->searchable(TahunPelajaran::count() >= 10),
                // ->toggleable(),
                IconColumn::make('status')
                    ->boolean()
                    ->label('Aktif'),
                // TextColumn::make('created_at')
                //     ->dateTime('d F Y H:i')
                //     ->sortable(TahunPelajaran::count() >= 10)
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->filters([
            //     TernaryFilter::make('status')->label('Aktif'),
            // ])
            ->recordActions([
                ActionGroup::make([
                    // ViewAction::make()
                    //     ->icon(Heroicon::Eye)
                    //     ->label('Lihat')
                    //     ->outlined()
                    //     ->size('sm')
                    //     ->color(Color::Zinc),
                    EditAction::make()
                        ->icon(Heroicon::PencilSquare)
                        ->label('Ubah')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Blue),
                    DeleteAction::make()
                        ->icon(Heroicon::Trash)
                        ->label('Hapus')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Red),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TahunPelajarans/TahunPelajaranResource.php`

```php
<?php

namespace App\Filament\Resources\TahunPelajarans;

use App\Filament\Resources\TahunPelajarans\Pages\CreateTahunPelajaran;
use App\Filament\Resources\TahunPelajarans\Pages\EditTahunPelajaran;
use App\Filament\Resources\TahunPelajarans\Pages\ListTahunPelajarans;
use App\Filament\Resources\TahunPelajarans\Pages\ViewTahunPelajaran;
use App\Filament\Resources\TahunPelajarans\Schemas\TahunPelajaranForm;
use App\Filament\Resources\TahunPelajarans\Schemas\TahunPelajaranInfolist;
use App\Filament\Resources\TahunPelajarans\Tables\TahunPelajaransTable;
use App\Models\TahunPelajaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TahunPelajaranResource extends Resource
{
    protected static ?string $model = TahunPelajaran::class;

    protected static bool $shouldRegisterNavigation = true;

    // protected static string|UnitEnum|null $navigationGroup = 'Personil';
    protected static ?string $navigationLabel = 'Tahun Pelajaran';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TahunPelajaranForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TahunPelajaranInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TahunPelajaransTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTahunPelajarans::route('/'),
            'create' => CreateTahunPelajaran::route('/create'),
            // 'view' => ViewTahunPelajaran::route('/{record}'),
            'edit' => EditTahunPelajaran::route('/{record}/edit'),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TamuUndangans/Pages/CreateTamuUndangan.php`

```php
<?php

namespace App\Filament\Resources\TamuUndangans\Pages;

use App\Filament\Resources\TamuUndangans\TamuUndanganResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTamuUndangan extends CreateRecord
{
    protected static string $resource = TamuUndanganResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TamuUndangans/Pages/EditTamuUndangan.php`

```php
<?php

namespace App\Filament\Resources\TamuUndangans\Pages;

use App\Filament\Resources\TamuUndangans\TamuUndanganResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class EditTamuUndangan extends EditRecord
{
    protected static string $resource = TamuUndanganResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon(Heroicon::Eye)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Zinc),
            DeleteAction::make()
                ->icon(Heroicon::Trash)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Rose),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TamuUndangans/Pages/ListTamuUndangans.php`

```php
<?php

namespace App\Filament\Resources\TamuUndangans\Pages;

use App\Filament\Resources\TamuUndangans\TamuUndanganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ListTamuUndangans extends ListRecords
{
    protected static string $resource = TamuUndanganResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::PlusCircle)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Green),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TamuUndangans/Pages/ViewTamuUndangan.php`

```php
<?php

namespace App\Filament\Resources\TamuUndangans\Pages;

use App\Filament\Resources\TamuUndangans\TamuUndanganResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ViewTamuUndangan extends ViewRecord
{
    protected static string $resource = TamuUndanganResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(Heroicon::PencilSquare)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Cyan),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TamuUndangans/Schemas/TamuUndanganForm.php`

```php
<?php

namespace App\Filament\Resources\TamuUndangans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TamuUndanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas')
                ->icon('heroicon-o-user')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    Select::make('siswa_id')
                        ->relationship('siswa', 'nama')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('jumlah_tamu')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->maxValue(10),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TamuUndangans/Schemas/TamuUndanganInfolist.php`

```php
<?php

namespace App\Filament\Resources\TamuUndangans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TamuUndanganInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas')
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    TextEntry::make('siswa.nama')->label('Nama Siswa'),
                    TextEntry::make('siswa.nisn')->label('NISN')->placeholder('-'),
                    TextEntry::make('siswa.nama_orangtua')->label('Orang Tua Siswa'),
                    TextEntry::make('jumlah_tamu')->label('Jumlah Tamu')->suffix(' Orang')->numeric()->placeholder('-'),
                ]),
            Section::make('Waktu')
                ->icon('heroicon-o-clock')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextEntry::make('created_at')->dateTime('d F Y H:i')->placeholder('-'),
                    TextEntry::make('updated_at')->dateTime('d F Y H:i')->placeholder('-'),
                ]),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TamuUndangans/Tables/TamuUndangansTable.php`

```php
<?php

namespace App\Filament\Resources\TamuUndangans\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TamuUndangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('siswa.nama_orangtua')->label('Nama Orang Tua')->searchable()->sortable(),
                TextColumn::make('siswa.nama')->label('Nama Siswa')->searchable()->sortable(),
                TextColumn::make('siswa.nisn')->label('NISN')->searchable(),
                TextColumn::make('siswa.telepon')->label('Telepon')->searchable(),
                TextColumn::make('jumlah_tamu')->label('Jumlah Tamu')->numeric()->sortable()
                    ->suffix(' orang'),
                TextColumn::make('siswa.status')->label('Status Kelulusan')->sortable()
                    ->badge(),
                TextColumn::make('created_at')->dateTime('d F Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime('d F Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->icon(Heroicon::Eye)
                        ->label('Lihat')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Zinc),
                    EditAction::make()
                        ->icon(Heroicon::PencilSquare)
                        ->label('Ubah')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Blue),
                    DeleteAction::make()
                        ->icon(Heroicon::Trash)
                        ->label('Hapus')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Red),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TamuUndangans/TamuUndanganResource.php`

```php
<?php

namespace App\Filament\Resources\TamuUndangans;

use App\Filament\Resources\TamuUndangans\Pages\CreateTamuUndangan;
use App\Filament\Resources\TamuUndangans\Pages\EditTamuUndangan;
use App\Filament\Resources\TamuUndangans\Pages\ListTamuUndangans;
use App\Filament\Resources\TamuUndangans\Pages\ViewTamuUndangan;
use App\Filament\Resources\TamuUndangans\Schemas\TamuUndanganForm;
use App\Filament\Resources\TamuUndangans\Schemas\TamuUndanganInfolist;
use App\Filament\Resources\TamuUndangans\Tables\TamuUndangansTable;
use App\Models\TamuUndangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TamuUndanganResource extends Resource
{
    protected static ?string $model = TamuUndangan::class;

    protected static bool $shouldRegisterNavigation = true;

    // protected static string|UnitEnum|null $navigationGroup = 'Personil';
    protected static ?string $navigationLabel = 'Tamu Undangan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return TamuUndanganForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TamuUndanganInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TamuUndangansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTamuUndangans::route('/'),
            'create' => CreateTamuUndangan::route('/create'),
            'view' => ViewTamuUndangan::route('/{record}'),
            'edit' => EditTamuUndangan::route('/{record}/edit'),
        ];
    }
}

```

---

### 📄 File: `./app/Http/Controllers/AlumniController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPeopleIndex;
use App\Models\Alumni;

class AlumniController extends Controller
{
    use HasPeopleIndex;

    protected function model(): string
    {
        return Alumni::class;
    }

    protected function indexView(): string
    {
        return 'alumni.index';
    }

    protected function searchColumns(): array
    {
        return ['nisn', 'nama'];
    }
}

```

---

### 📄 File: `./app/Http/Controllers/Concerns/HasPeopleIndex.php`

```php
<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Trait reusable untuk controller yang menampilkan daftar "orang"
 * dengan fitur pencarian (Alumni, Personil, dsb.)
 */
trait HasPeopleIndex
{
    /**
     * Nama model Eloquent (FQCN), diisi di masing-masing controller.
     * Contoh: protected string $model = Alumni::class;
     */
    abstract protected function model(): string;

    /**
     * Nama view untuk halaman index.
     * Contoh: 'alumni.index'
     */
    abstract protected function indexView(): string;

    /**
     * Kolom yang bisa dicari (OR query).
     * Contoh: ['nisn', 'nama']
     */
    abstract protected function searchColumns(): array;

    /**
     * Kolom default untuk ordering.
     */
    protected function orderBy(): string
    {
        return 'nama';
    }

    /**
     * Apakah hasil pakai paginate (true) atau get (false).
     */
    protected function paginated(): bool
    {
        return true;
    }

    protected function perPage(): int
    {
        return 12;
    }

    // ──────────────────────────────────────────────────────────────

    public function index(Request $request): View
    {
        $items = $this->buildQuery()->orderBy($this->orderBy());

        $items = $this->paginated()
            ? $items->paginate($this->perPage())
            : $items->get();

        return view($this->indexView(), compact('items'));
    }

    public function search(Request $request): View
    {
        $keyword = $this->resolveKeyword($request);

        $items = $this->buildQuery($keyword)->orderBy($this->orderBy());

        $items = $this->paginated()
            ? $items->paginate($this->perPage())->withQueryString()
            : $items->get();

        return view($this->indexView(), compact('items', 'keyword'));
    }

    // ──────────────────────────────────────────────────────────────

    protected function buildQuery(?string $keyword = null): Builder
    {
        $query = $this->model()::query();

        if ($keyword) {
            $columns = $this->searchColumns();
            $query->where(function (Builder $q) use ($keyword, $columns) {
                foreach ($columns as $i => $col) {
                    $method = $i === 0 ? 'where' : 'orWhere';
                    // Kolom NISN/kode: exact match; kolom teks: LIKE
                    if (in_array($col, ['nisn', 'nip', 'id'])) {
                        $q->$method($col, $keyword);
                    } else {
                        $q->$method($col, 'like', "%{$keyword}%");
                    }
                }
            });
        }

        return $query;
    }

    /**
     * Ambil keyword dari request — subclass bisa override jika perlu.
     */
    protected function resolveKeyword(Request $request): string
    {
        // Coba semua input yang mungkin dipakai sebagai keyword
        return $request->input('nisn')
            ?? $request->input('nama')
            ?? $request->input('q')
            ?? '';
    }
}

```

---

### 📄 File: `./app/Http/Controllers/Controller.php`

```php
<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
}

```

---

### 📄 File: `./app/Http/Controllers/LandingPageController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Instansi;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function index(Request $request): View
    {
        return view('landing.index');
        // $tahunPelajaran sudah di-share global via AppServiceProvider
    }

    public function cari(SearchRequest $request): View
    {
        $keyword = $request->keyword();

        $siswa = Siswa::where('nisn', $keyword)
            ->orWhere('telepon', $keyword)
            ->first();

        return view('landing.hasil', compact('siswa', 'keyword'));
    }

    public function hasil(Siswa $siswa): View
    {
        return view('landing.hasil', [
            'siswa' => $siswa,
            'keyword' => $siswa->nisn,
        ]);
    }

    // ── Dokumen ────────────────────────────────────────────────────

    public function cetakSkl(Siswa $siswa): View
    {
        return view('landing.skl', compact('siswa'));
        // $tahunPelajaran sudah global
    }

    public function cetakSklPdf(Siswa $siswa): Response
    {
        return $this->renderPdf('pdf.skl', $siswa, "SKL-{$siswa->nisn}.pdf");
    }

    public function cetakUndangan(Siswa $siswa): View
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak mendapatkan surat undangan.');

        return view('landing.undangan', compact('siswa'));
    }

    public function cetakUndanganPdf(Siswa $siswa): Response
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak mendapatkan surat undangan.');

        return $this->renderPdf('pdf.undangan', $siswa, "Undangan-{$siswa->nisn}.pdf");
    }

    // ── Helper ─────────────────────────────────────────────────────

    /**
     * Render view sebagai PDF dan langsung download.
     * Menghilangkan duplikasi Pdf::loadView() di dua method cetak.
     */
    private function renderPdf(string $view, Siswa $siswa, string $filename): Response
    {
        $instansi = Instansi::first();
        $tahunPelajaran = TahunPelajaran::aktif()->first();

        return Pdf::loadView($view, compact('siswa', 'instansi', 'tahunPelajaran'))
            ->setPaper('a4', 'portrait')
            ->download($filename);
    }
}

```

---

### 📄 File: `./app/Http/Controllers/PersonilController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPeopleIndex;
use App\Models\Personil;

class PersonilController extends Controller
{
    use HasPeopleIndex;

    protected function model(): string
    {
        return Personil::class;
    }

    protected function indexView(): string
    {
        return 'personil.index';
    }

    protected function searchColumns(): array
    {
        return ['nama'];
    }

    protected function paginated(): bool
    {
        return false;
    }
}

```

---

### 📄 File: `./app/Http/Controllers/TamuUndanganController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\TamuUndanganStoreRequest;
use App\Models\Siswa;
use App\Models\TamuUndangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TamuUndanganController extends Controller
{
    public function index(): View
    {
        $tamus = TamuUndangan::with('siswa')->latest()->paginate(20);
        $totalSiswa = Siswa::whereIn('status', ['Lulus', 'Lulus Bersyarat'])->count();

        return view('tamu.index', [
            'tamuUndangans' => $tamus,
            'totalPax' => $tamus->sum('jumlah_tamu'),
            'totalSiswa' => $totalSiswa,
        ]);
    }

    public function scanQr(): View
    {
        return view('tamu.scan');
    }

    public function processScan(Request $request): RedirectResponse
    {
        $request->validate([
            'kode' => ['required', 'string', 'max:36'],
        ]);

        $kode = trim($request->input('kode'));
        $siswa = Siswa::where('id', $kode)->orWhere('nisn', $kode)->first();

        if (! $siswa) {
            return back()
                ->withErrors(['kode' => 'Siswa tidak ditemukan. Periksa kode yang dimasukkan.'])
                ->withInput();
        }

        if (! $siswa->isLulus()) {
            return back()
                ->withErrors(['kode' => "Siswa {$siswa->nama} tidak berhak hadir (status: {$siswa->status->getLabel()})."])
                ->withInput();
        }

        return redirect()->route('tamu.konfirmasi', $siswa);
    }

    public function konfirmasi(Siswa $siswa): View
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak hadir.');

        return view('tamu.konfirmasi', [
            'siswa' => $siswa,
            'sudahHadir' => TamuUndangan::where('siswa_id', $siswa->id)->exists(),
        ]);
    }

    public function store(TamuUndanganStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        TamuUndangan::updateOrCreate(
            ['siswa_id' => $data['siswa_id']],
            ['jumlah_tamu' => $data['jumlah_tamu'] ?? 1],
        );

        return redirect()->route('tamu.index')->with('success', 'Kehadiran berhasil dicatat.');
    }

    public function cetakHadir(): View
    {
        $tamus = TamuUndangan::with('siswa')->oldest()->get();

        return view('tamu.cetak-hadir', [
            'tamus' => $tamus,
            'totalPax' => $tamus->sum('jumlah_tamu'),
        ]);
    }
}

```

---

### 📄 File: `./app/Http/Middleware/JadwalKelulusanAktif.php`

```php
<?php

namespace App\Http\Middleware;

use App\Models\TahunPelajaran;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JadwalKelulusanAktif
{
    public function handle(Request $request, Closure $next): Response
    {
        $tp = TahunPelajaran::where('status', true)->first();

        $aktif = $tp
            && $tp->jadwal_kelulusan_mulai
            && $tp->jadwal_kelulusan_selesai
            && now()->between($tp->jadwal_kelulusan_mulai, $tp->jadwal_kelulusan_selesai);

        if (! $aktif) {
            return redirect()->route('landing')
                ->with('info', 'Halaman tamu undangan belum tersedia.');
        }

        return $next($request);
    }
}

```

---

### 📄 File: `./app/Http/Requests/AlumnusCariRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumnusCariRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required_without:nisn', 'nullable', 'string', 'max:255'],
            'nisn' => ['required_without:nama', 'nullable', 'string', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required_without' => 'Masukkan nama atau NISN alumni.',
            'nisn.required_without' => 'Masukkan nama atau NISN alumni.',
        ];
    }
}

```

---

### 📄 File: `./app/Http/Requests/LandingPageCariRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LandingPageCariRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nisn' => ['required_without:telepon', 'nullable', 'string', 'max:10'],
            'telepon' => ['required_without:nisn', 'nullable', 'string', 'max:15'],
        ];
    }

    public function messages(): array
    {
        return [
            'nisn.required_without' => 'Masukkan NISN atau nomor telepon.',
            'telepon.required_without' => 'Masukkan NISN atau nomor telepon.',
        ];
    }

    public function keyword(): string
    {
        return $this->filled('nisn') ? $this->nisn : $this->telepon;
    }
}

```

---

### 📄 File: `./app/Http/Requests/PersonilCariRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonilCariRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Masukkan nama personil yang ingin dicari.',
        ];
    }
}

```

---

### 📄 File: `./app/Http/Requests/SearchRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request umum untuk semua halaman pencarian publik.
 *
 * Menggantikan: AlumnusCariRequest, PersonilCariRequest, LandingPageCariRequest
 */
class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'nama' => ['nullable', 'string', 'max:255'],
            'nisn' => ['nullable', 'string', 'max:10'],
            'telepon' => ['nullable', 'string', 'max:15'],
        ];
    }

    /**
     * Setidaknya satu field pencarian harus diisi.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            if (! $this->anyFilled(['q', 'nama', 'nisn', 'telepon'])) {
                $v->errors()->add('q', 'Masukkan kata kunci pencarian.');
            }
        });
    }

    /**
     * Kembalikan keyword tunggal dari field manapun yang terisi.
     */
    public function keyword(): string
    {
        return $this->input('nisn')
            ?? $this->input('telepon')
            ?? $this->input('nama')
            ?? $this->input('q')
            ?? '';
    }
}

```

---

### 📄 File: `./app/Http/Requests/TamuUndanganScanQrRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TamuUndanganScanQrRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'siswa_id' => ['required', 'uuid', 'exists:siswas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'siswa_id.required' => 'QR Code tidak terbaca.',
            'siswa_id.uuid' => 'QR Code tidak valid.',
            'siswa_id.exists' => 'Data siswa tidak ditemukan.',
        ];
    }
}

```

---

### 📄 File: `./app/Http/Requests/TamuUndanganStoreRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TamuUndanganStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'siswa_id' => [
                'required',
                'uuid',
                Rule::exists('siswas', 'id')->where(
                    fn ($q) => $q->whereIn('status', ['Lulus', 'Lulus Bersyarat'])
                ),
            ],
            'jumlah_tamu' => ['nullable', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'siswa_id.required' => 'QR Code tidak valid.',
            'siswa_id.uuid' => 'QR Code tidak valid.',
            'siswa_id.exists' => 'Siswa tidak ditemukan atau tidak berhak hadir.',
            'jumlah_tamu.min' => 'Jumlah tamu minimal 1 orang.',
            'jumlah_tamu.max' => 'Jumlah tamu maksimal 10 orang.',
        ];
    }
}

```

---

### 📄 File: `./app/Imports/AlumniImport.php`

```php
<?php

namespace App\Imports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class AlumniImport implements SkipsOnError, SkipsOnFailure, ToModel, WithHeadingRow, WithUpserts, WithValidation
{
    use SkipsErrors, SkipsFailures;

    private int $berhasil = 0;

    public function model(array $row): ?Alumni
    {
        if (blank($row['nama'] ?? null) || blank($row['nisn'] ?? null)) {
            return null;
        }

        $this->berhasil++;

        return new Alumni([
            'nama' => trim($row['nama']),
            'nisn' => (string) $row['nisn'],
            'tahun_lulus' => (string) ($row['tahun_lulus'] ?? date('Y')),
            'avatar' => $row['avatar'] ?? null,
            'quote' => $row['quote'] ?? null,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nisn';
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'digits:10'],
            'tahun_lulus' => ['required', 'digits:4', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nisn.digits' => 'NISN harus tepat 10 digit angka.',
            'tahun_lulus.digits' => 'Tahun lulus harus 4 digit.',
            'nama.required' => 'Kolom nama wajib diisi.',
        ];
    }

    public function getBerhasil(): int
    {
        return $this->berhasil;
    }
}

```

---

### 📄 File: `./app/Imports/PersonilImport.php`

```php
<?php

namespace App\Imports;

use App\Models\Personil;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class PersonilImport implements SkipsOnError, SkipsOnFailure, ToModel, WithHeadingRow, WithUpserts, WithValidation
{
    use SkipsErrors, SkipsFailures;

    private int $berhasil = 0;

    public function model(array $row): ?Personil
    {
        if (blank($row['nama'] ?? null) || blank($row['jabatan'] ?? null)) {
            return null;
        }

        $this->berhasil++;

        return new Personil([
            'nama' => trim($row['nama']),
            'nip' => filled($row['nip'] ?? null) ? (string) $row['nip'] : null,
            'jabatan' => trim($row['jabatan']),
            'telepon' => filled($row['telepon'] ?? null) ? (string) $row['telepon'] : null,
            'sosial_media' => $row['sosial_media'] ?? null,
            'quote' => $row['quote'] ?? null,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nip';
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'telepon' => ['nullable', 'max:15'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nama.required' => 'Kolom nama wajib diisi.',
            'jabatan.required' => 'Kolom jabatan wajib diisi.',
        ];
    }

    public function getBerhasil(): int
    {
        return $this->berhasil;
    }
}

```

---

### 📄 File: `./app/Imports/SiswaImport.php`

```php
<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements SkipsOnError, SkipsOnFailure, ToModel, WithHeadingRow, WithUpserts, WithValidation
{
    use SkipsErrors, SkipsFailures;

    private int $berhasil = 0;

    public function model(array $row): ?Siswa
    {
        if (blank($row['nisn'] ?? null) || blank($row['nama'] ?? null)) {
            return null;
        }

        $this->berhasil++;

        return new Siswa([
            'nama' => trim($row['nama']),
            'nama_orangtua' => filled($row['nama_orangtua'] ?? null) ? trim($row['nama_orangtua']) : null,
            'nisn' => (string) $row['nisn'],
            'telepon' => filled($row['telepon'] ?? null) ? (string) $row['telepon'] : null,
            'status' => $row['status'] ?? 'Lulus',
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nisn';
    }

    public function rules(): array
    {
        return [
            'nisn' => ['required', 'digits:10'],
            'nama' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'in:Lulus,Tidak Lulus,Lulus Bersyarat'],
            'telepon' => ['nullable', 'max:15'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nisn.digits' => 'NISN harus tepat 10 digit angka.',
            'nama.required' => 'Kolom nama wajib diisi.',
            'status.in' => 'Status harus salah satu dari: Lulus, Tidak Lulus, Lulus Bersyarat.',
        ];
    }

    public function getBerhasil(): int
    {
        return $this->berhasil;
    }
}

```

---

### 📄 File: `./app/Jobs/BroadcastPesanKelulusan.php`

```php
<?php

namespace App\Jobs;

use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BroadcastPesanKelulusan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 60;

    public function __construct(
        private readonly Siswa $siswa,
        private readonly TahunPelajaran $tahunPelajaran,
    ) {}

    public function handle(): void
    {
        if (blank($this->siswa->telepon)) {
            return;
        }

        $pesan = $this->buildPesan();
        $response = Http::withToken(config('services.wapi.token'))
            ->timeout(15)
            ->post(config('services.wapi.url'), [
                'phone' => $this->siswa->telepon,
                'message' => $pesan,
            ]);
        if ($response->failed()) {
            Log::warning("WA gagal ke {$this->siswa->nisn} (attempt {$this->attempts()}): ".$response->body());

            throw new \RuntimeException("Gagal kirim WA ke {$this->siswa->nisn}: HTTP {$response->status()}");
        }

        Log::info("WA terkirim ke {$this->siswa->nisn}");
    }

    private function buildPesan(): string
    {
        $tp = $this->tahunPelajaran;
        $url = config('app.url');

        $pesan = "Assalamu'alaikum, {$this->siswa->nama}.\n\n";
        $pesan .= "Pengumuman Kelulusan sudah dapat diakses pada:\n";
        $pesan .= "🔗 {$url}\n\n";

        $adaJadwal = $tp->jadwal_kelulusan_mulai
            && $tp->jadwal_kelulusan_selesai
            && $tp->jadwal_kelulusan_tempat;

        if ($adaJadwal) {
            $mulai = $tp->jadwal_kelulusan_mulai->translatedFormat('l, d F Y H:i');
            $selesai = $tp->jadwal_kelulusan_selesai->translatedFormat('H:i');

            $pesan .= "📅 Acara Kelulusan:\n";
            $pesan .= "Tanggal : {$mulai} – {$selesai} WIB\n";
            $pesan .= "Tempat  : {$tp->jadwal_kelulusan_tempat}\n\n";
        }

        $pesan .= 'Selamat & semoga sukses!';

        return $pesan;
    }

    public function failed(\Throwable $e): void
    {
        Log::error("Broadcast WA gagal permanen untuk {$this->siswa->nisn}: ".$e->getMessage());
    }
}

```

---

### 📄 File: `./app/Jobs/SendWhatsAppJob.php`

```php
<?php

namespace App\Jobs;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 60;

    public function __construct(
        public readonly string $phone,
        public readonly string $message,
    ) {}

    public function handle(WhatsAppService $wa): void
    {
        $wa->sendDirect($this->phone, $this->message);
    }

    public function tags(): array
    {
        return ['whatsapp', 'phone:'.$this->phone];
    }
}

```

---

### 📄 File: `./app/Models/Alumni.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'nisn',
        'tahun_lulus',
        'foto',
        'quote',
    ];
}

```

---

### 📄 File: `./app/Models/Instansi.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'npsn',
        'logo',
        'logo_institusi',
        'nomor_surat',
        'nama_pimpinan',
        'nip_pimpinan',
        'tte_pimpinan',
        'nama_ketua',
        'nip_ketua',
        'tte_ketua',
        'jenjang',
        'akreditasi',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
}

```

---

### 📄 File: `./app/Models/Personil.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personil extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'nip',
        'foto',
        'telepon',
        'sosial_media',
        'jabatan',
        'quote',
    ];
}

```

---

### 📄 File: `./app/Models/Siswa.php`

```php
<?php

namespace App\Models;

use App\Enums\StatusSiswa;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama',
        'nama_orangtua',
        'nisn',
        'berkas_skl',
        'berkas_undangan',
        'foto',
        'telepon',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => StatusSiswa::class,
        ];
    }

    public function tamuUndangans(): HasMany
    {
        return $this->hasMany(TamuUndangan::class);
    }

    public function isLulus(): bool
    {
        return in_array($this->status, [
            StatusSiswa::Lulus,
            StatusSiswa::LulusBersyarat,
        ]);
    }
}

```

---

### 📄 File: `./app/Models/TahunPelajaran.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPelajaran extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'jadwal_pengumuman_mulai',
        'jadwal_pengumuman_selesai',
        'jadwal_kelulusan_mulai',
        'jadwal_kelulusan_selesai',
        'jadwal_kelulusan_tempat',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'jadwal_pengumuman_mulai' => 'datetime',
            'jadwal_pengumuman_selesai' => 'datetime',
            'jadwal_kelulusan_mulai' => 'datetime',
            'jadwal_kelulusan_selesai' => 'datetime',
            'status' => 'boolean',
        ];
    }

    // Apakah halaman pengumuman sedang aktif
    public function isPengumumanAktif(): bool
    {
        $now = now();

        return $this->status
            && $now->gte($this->jadwal_pengumuman_mulai)
            && $now->lte($this->jadwal_pengumuman_selesai);
    }

    // Apakah rentang acara kelulusan sedang aktif
    public function isKelulusanAktif(): bool
    {
        if (! $this->jadwal_kelulusan_mulai || ! $this->jadwal_kelulusan_selesai) {
            return false;
        }
        $now = now();

        return $now->gte($this->jadwal_kelulusan_mulai)
            && $now->lte($this->jadwal_kelulusan_selesai);
    }

    // Scope: tahun pelajaran yang sedang aktif
    public function scopeAktif($query)
    {
        return $query->where('status', true);
    }
}

```

---

### 📄 File: `./app/Models/TamuUndangan.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TamuUndangan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'siswa_id',
        'jumlah_tamu',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_tamu' => 'integer',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}

```

---

### 📄 File: `./app/Models/User.php`

```php
<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, HasAvatar, MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'telepon',
        'status',
        'email',
        'email_verified_at',
        'password',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar) {
            return asset('storage/'.$this->avatar);
        }

        return null;
    }
}

```

---

### 📄 File: `./app/Providers/AppServiceProvider.php`

```php
<?php

namespace App\Providers;

use App\Models\Instansi;
use App\Models\TahunPelajaran;
use Carbon\Carbon;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        FilamentColor::register([
            'danger' => Color::hex('#FF0022'),
            'info' => Color::hex('#00FFEA'),
            'primary' => Color::hex('#BF00FF'),
            'success' => Color::hex('#00FF41'),
            'warning' => Color::hex('#FF6D00'),
        ]);

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        setlocale(LC_TIME, 'id_ID.utf8');
        Carbon::setLocale('id');

        // Share instansi ke semua view
        $instansiArray = Cache::remember('instansi.aktif', now()->addHour(), function () {
            $data = Instansi::first();

            return $data ? $data->toArray() : null;
        });
        $instansi = $instansiArray ? (object) $instansiArray : null;
        View::share('instansi', $instansi);

        // Share tahun pelajaran aktif ke semua view
        $tahunPelajaran = TahunPelajaran::where('status', true)->first();
        View::share('tahunPelajaran', $tahunPelajaran);
    }
}

```

---

### 📄 File: `./app/Providers/Filament/AdminPanelProvider.php`

```php
<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfileCustom;
use App\Filament\Pages\Auth\ForgotPasswordCustom;
use App\Filament\Pages\Auth\LoginCustom;
use App\Filament\Pages\Auth\RegisterCustom;
use App\Filament\Pages\Auth\VerifikasiOtp;
use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->theme(asset('css/filament/admin/theme.css'))
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            // ->login(LoginCustom::class)
            // ->registration(RegisterCustom::class)
            // ->passwordReset(ForgotPasswordCustom::class)
            // ->emailVerification(VerifikasiOtp::class)
            // ->profile(EditProfileCustom::class)
            ->spa()
            ->breadcrumbs(false)
            ->topNavigation()
            ->maxContentWidth(Width::Full)
            // ->simplePageMaxContentWidth(Width::Small)
            ->globalSearch(false)
            ->databaseNotifications()
            ->unsavedChangesAlerts()
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->favicon(asset('images/default.png'))
            ->brandName('Academic Graduation Portal')
            ->darkModeBrandLogo(asset('/images/brand-darkmode.png'))
            ->brandLogo(asset('/images/brand-lightmode.png'))
            // ->brandLogo(asset('images/default.png'))
            ->brandLogoHeight('2.6rem')
            ->defaultThemeMode(ThemeMode::Dark)
            ->darkMode(true)
            ->font('Lexend')
            // ->navigationGroups([
            //     'Instansi',
            //     'Tahun Pelajaran',
            //     'Personil',
            //     'Alumni',
            //     'Siswa',
            //     'Tamu Undangan',
            // ])
            ->navigationItems([
                NavigationItem::make('Whatsapp')
                    ->url('https://wapi.zedlabs.id', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->sort(7),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                EasyFooterPlugin::make()
                    ->withFooterPosition('footer')
                    ->withBorder()
                    ->hiddenFromPagesEnabled()
                    ->withSentence(new HtmlString('MTsN 1 Pandeglang | Crafted with dedication by<a href="https://zedlabs.id" target="_blank"><b>Yahya Zulfikri</b></a>')),
                AuthUIEnhancerPlugin::make()
                    ->formPanelPosition('left')
                    ->formPanelWidth('40%')
                    ->emptyPanelBackgroundColor(Color::hex('#010101'))
                    ->emptyPanelBackgroundImageUrl('/images/wallpaper.png')
                    ->emptyPanelBackgroundColor(Color::hex('#010101'))
                    ->showEmptyPanelOnMobile(false),
            ]);
    }
}

```

---

### 📄 File: `./app/Services/OtpMessageService.php`

```php
<?php

namespace App\Services;

class OtpMessageService
{
    public static function verifikasi(string $name, string $otp): string
    {
        return "Halo {$name},\n\n"
            ."Kode OTP verifikasi akun PMBM MTsN 1 Pandeglang Anda:\n\n"
            ."*{$otp}*\n\n"
            .'Kode berlaku selama 5 menit. Jangan bagikan kode ini kepada siapapun.';
    }

    public static function resetPassword(string $name, string $otp): string
    {
        return "Halo {$name},\n\n"
            ."Kode OTP reset password PMBM MTsN 1 Pandeglang Anda:\n\n"
            ."*{$otp}*\n\n"
            .'Kode berlaku selama 5 menit. Jangan bagikan kode ini kepada siapapun.';
    }

    public static function passwordBerhasilDiubah(string $name): string
    {
        return "Halo {$name},\n\n"
            ."Password akun PMBM MTsN 1 Pandeglang Anda telah berhasil diubah.\n\n"
            .'Jika Anda tidak merasa melakukan perubahan ini, segera hubungi panitia PMBM.';
    }
}

```

---

### 📄 File: `./app/Services/WhatsAppService.php`

```php
<?php

namespace App\Services;

use App\Jobs\SendWhatsAppJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Dispatch ke queue dengan random delay (mencegah banned).
     * Default range: 5–30 detik. Bisa di-override per call.
     */
    public function send(
        string $phone,
        string $message,
        int $minDelay = 5,
        int $maxDelay = 30,
    ): void {
        $delay = rand($minDelay, $maxDelay);
        SendWhatsAppJob::dispatch($phone, $message)
            ->delay(now()->addSeconds($delay));
    }

    /**
     * Kirim langsung (tanpa queue) — dipakai oleh Job itu sendiri.
     * Jangan panggil ini dari luar Job kecuali ada alasan khusus.
     */
    public function sendDirect(string $phone, string $message): bool
    {
        $normalized = $this->normalizePhone($phone);

        $response = Http::withHeaders([
            'X-Api-Key' => config('services.whatsapp.api_key'),
        ])->post(config('services.whatsapp.endpoint'), [
            'number' => $normalized,
            'message' => $message,
        ]);

        Log::info('WhatsApp send', [
            'phone' => $normalized,
            'endpoint' => config('services.whatsapp.endpoint'),
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException(
                'WhatsApp send failed ['.$response->status().']: '.$response->body()
            );
        }

        return true;
    }

    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62'.substr($phone, 1);
        }

        if (! str_starts_with($phone, '62')) {
            $phone = '62'.$phone;
        }

        return $phone;
    }
}

```

---

## 📁 Directory: bootstrap (bootstrap)

### 📄 File: `./bootstrap/app.php`

```php
<?php

use App\Http\Middleware\JadwalKelulusanAktif;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'jadwal.kelulusan' => JadwalKelulusanAktif::class,
        ]);
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpException $e, $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return redirect()
                    ->to('/admin')
                    ->with('error', "Terjadi kesalahan ({$e->getStatusCode()}).");
            }

            return redirect()
                ->route('landing')
                ->with('error', "Terjadi kesalahan ({$e->getStatusCode()}). Silakan coba lagi.");
        });
    })->create();

```

---

### 📄 File: `./bootstrap/providers.php`

```php
<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
];

```

---

## 📁 Directory: config (Configuration)

Application configuration files.

### 📄 File: `./config/app.php`

```php
<?php

return [
    'name' => env('APP_NAME', 'AGP MTs Negeri 1 Pandeglang'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'https://lulus.mtsn1pandeglang.sch.id'),
    'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),
    'locale' => env('APP_LOCALE', 'id'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'id'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'id_ID'),
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],
];

```

---

### 📄 File: `./config/auth.php`

```php
<?php

use App\Models\User;

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];

```

---

### 📄 File: `./config/cache.php`

```php
<?php

use Illuminate\Support\Str;

return [
    'default' => env('CACHE_STORE', 'database'),
    'stores' => [
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CACHE_CONNECTION'),
            'table' => env('DB_CACHE_TABLE', 'cache'),
            'lock_connection' => env('DB_CACHE_LOCK_CONNECTION'),
            'lock_table' => env('DB_CACHE_LOCK_TABLE'),
        ],
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
        ],
        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],
        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_CACHE_CONNECTION', 'cache'),
            'lock_connection' => env('REDIS_CACHE_LOCK_CONNECTION', 'default'),
        ],
        'dynamodb' => [
            'driver' => 'dynamodb',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => env('DYNAMODB_ENDPOINT'),
        ],
        'octane' => [
            'driver' => 'octane',
        ],
        'failover' => [
            'driver' => 'failover',
            'stores' => [
                'database',
                'array',
            ],
        ],
    ],
    'prefix' => env('CACHE_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')).'-cache-'),
    'serializable_classes' => false,
];

```

---

### 📄 File: `./config/database.php`

```php
<?php

use Illuminate\Support\Str;
use Pdo\Mysql;

return [
    'default' => env('DB_CONNECTION', 'sqlite'),
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
            'transaction_mode' => 'DEFERRED',
        ],
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                (PHP_VERSION_ID >= 80500 ? Mysql::ATTR_SSL_CA : PDO::MYSQL_ATTR_SSL_CA) => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        'mariadb' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                (PHP_VERSION_ID >= 80500 ? Mysql::ATTR_SSL_CA : PDO::MYSQL_ATTR_SSL_CA) => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => env('DB_SSLMODE', 'prefer'),
        ],
        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

    ],
    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],
    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')).'-database-'),
            'persistent' => env('REDIS_PERSISTENT', false),
        ],
        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],
        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],
    ],
];

```

---

### 📄 File: `./config/filament.php`

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Broadcasting
    |--------------------------------------------------------------------------
    |
    | By uncommenting the Laravel Echo configuration, you may connect Filament
    | to any Pusher-compatible websockets server.
    |
    | This will allow your users to receive real-time notifications.
    |
    */

    'broadcasting' => [

        // 'echo' => [
        //     'broadcaster' => 'pusher',
        //     'key' => env('VITE_PUSHER_APP_KEY'),
        //     'cluster' => env('VITE_PUSHER_APP_CLUSTER'),
        //     'wsHost' => env('VITE_PUSHER_HOST'),
        //     'wsPort' => env('VITE_PUSHER_PORT'),
        //     'wssPort' => env('VITE_PUSHER_PORT'),
        //     'authEndpoint' => '/broadcasting/auth',
        //     'disableStats' => true,
        //     'encrypted' => true,
        //     'forceTLS' => env('VITE_PUSHER_SCHEME', 'https') === 'https',
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | This is the storage disk Filament will use to store files. You may use
    | any of the disks defined in the `config/filesystems.php`.
    |
    */

    'default_filesystem_disk' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Assets Path
    |--------------------------------------------------------------------------
    |
    | This is the directory where Filament's assets will be published to. It
    | is relative to the `public` directory of your Laravel application.
    |
    | After changing the path, you should run `php artisan filament:assets`.
    |
    */

    'assets_path' => null,

    /*
    |--------------------------------------------------------------------------
    | Cache Path
    |--------------------------------------------------------------------------
    |
    | This is the directory that Filament will use to store cache files that
    | are used to optimize the registration of components.
    |
    | After changing the path, you should run `php artisan filament:cache-components`.
    |
    */

    'cache_path' => base_path('bootstrap/cache/filament'),

    /*
    |--------------------------------------------------------------------------
    | Livewire Loading Delay
    |--------------------------------------------------------------------------
    |
    | This sets the delay before loading indicators appear.
    |
    | Setting this to 'none' makes indicators appear immediately, which can be
    | desirable for high-latency connections. Setting it to 'default' applies
    | Livewire's standard 200ms delay.
    |
    */

    'livewire_loading_delay' => 'default',

    /*
    |--------------------------------------------------------------------------
    | File Generation
    |--------------------------------------------------------------------------
    |
    | Artisan commands that generate files can be configured here by setting
    | configuration flags that will impact their location or content.
    |
    | Often, this is useful to preserve file generation behavior from a
    | previous version of Filament, to ensure consistency between older and
    | newer generated files. These flags are often documented in the upgrade
    | guide for the version of Filament you are upgrading to.
    |
    */

    'file_generation' => [
        'flags' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | System Route Prefix
    |--------------------------------------------------------------------------
    |
    | This is the prefix used for the system routes that Filament registers,
    | such as the routes for downloading exports and failed import rows.
    |
    */

    'system_route_prefix' => 'filament',

];

```

---

### 📄 File: `./config/filament-easy-footer.php`

```php
<?php

return [
    'app_name' => env('APP_NAME', ''),
    'github' => [
        'repository' => env('GITHUB_REPOSITORY', ''),
        'token' => env('GITHUB_TOKEN', ''),
        'cache_ttl' => env('GITHUB_CACHE_TTL', 3600),
    ],
];

```

---

### 📄 File: `./config/filesystems.php`

```php
<?php

return [
    'default' => env('FILESYSTEM_DISK', 'local'),
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],
    ],
    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];

```

---

### 📄 File: `./config/livewire.php`

```php
<?php

return [
    'temporary_file_upload' => [
        'disk' => 'local',
        'rules' => ['required', 'file', 'max:51200'],
        'directory' => 'livewire-tmp',
    ],
];

```

---

### 📄 File: `./config/logging.php`

```php
<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;

return [
    'default' => env('LOG_CHANNEL', 'stack'),
    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => env('LOG_DEPRECATIONS_TRACE', false),
    ],
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => explode(',', (string) env('LOG_STACK', 'single')),
            'ignore_exceptions' => false,
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => env('LOG_DAILY_DAYS', 14),
            'replace_placeholders' => true,
        ],
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => env('LOG_SLACK_USERNAME', env('APP_NAME', 'Laravel')),
            'emoji' => env('LOG_SLACK_EMOJI', ':boom:'),
            'level' => env('LOG_LEVEL', 'critical'),
            'replace_placeholders' => true,
        ],
        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
                'connectionString' => 'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT'),
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],
        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'handler_with' => [
                'stream' => 'php://stderr',
            ],
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'processors' => [PsrLogMessageProcessor::class],
        ],
        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => env('LOG_SYSLOG_FACILITY', LOG_USER),
            'replace_placeholders' => true,
        ],
        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],
        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],
        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],
];

```

---

### 📄 File: `./config/mail.php`

```php
<?php

return [
    'default' => env('MAIL_MAILER', 'log'),
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 2525),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],
        'ses' => [
            'transport' => 'ses',
        ],
        'postmark' => [
            'transport' => 'postmark',
            // 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],
        'resend' => [
            'transport' => 'resend',
        ],
        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],
        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],
        'array' => [
            'transport' => 'array',
        ],
        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
            'retry_after' => 60,
        ],
        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
            'retry_after' => 60,
        ],
    ],
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', env('APP_NAME', 'Laravel')),
    ],
];

```

---

### 📄 File: `./config/queue.php`

```php
<?php

return [
    'default' => env('QUEUE_CONNECTION', 'database'),
    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_QUEUE_CONNECTION'),
            'table' => env('DB_QUEUE_TABLE', 'jobs'),
            'queue' => env('DB_QUEUE', 'default'),
            'retry_after' => (int) env('DB_QUEUE_RETRY_AFTER', 90),
            'after_commit' => false,
        ],
        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => env('BEANSTALKD_QUEUE_HOST', 'localhost'),
            'queue' => env('BEANSTALKD_QUEUE', 'default'),
            'retry_after' => (int) env('BEANSTALKD_QUEUE_RETRY_AFTER', 90),
            'block_for' => 0,
            'after_commit' => false,
        ],
        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'default'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'after_commit' => false,
        ],
        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => (int) env('REDIS_QUEUE_RETRY_AFTER', 90),
            'block_for' => null,
            'after_commit' => false,
        ],
        'deferred' => [
            'driver' => 'deferred',
        ],
        'background' => [
            'driver' => 'background',
        ],
        'failover' => [
            'driver' => 'failover',
            'connections' => [
                'database',
                'deferred',
            ],
        ],
    ],
    'batching' => [
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'job_batches',
    ],
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'failed_jobs',
    ],
];

```

---

### 📄 File: `./config/services.php`

```php
<?php

return [
    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],
    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'whatsapp' => [
        'endpoint' => env('WHATSAPP_ENDPOINT'),
        'api_key' => env('WHATSAPP_API_KEY'),
    ],
];

```

---

### 📄 File: `./config/session.php`

```php
<?php

use Illuminate\Support\Str;

return [
    'driver' => env('SESSION_DRIVER', 'database'),
    'lifetime' => (int) env('SESSION_LIFETIME', 120),
    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),
    'encrypt' => env('SESSION_ENCRYPT', false),
    'files' => storage_path('framework/sessions'),
    'connection' => env('SESSION_CONNECTION'),
    'table' => env('SESSION_TABLE', 'sessions'),
    'store' => env('SESSION_STORE'),
    'lottery' => [2, 100],
    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')).'-session'
    ),
    'path' => env('SESSION_PATH', '/'),
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE_COOKIE'),
    'http_only' => env('SESSION_HTTP_ONLY', true),
    'same_site' => env('SESSION_SAME_SITE', 'lax'),
    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),
    'serialization' => 'json',
];

```

---

## 📁 Directory: database (Database)

Migrations, seeders, and factories.

### 📄 File: `./database/.gitignore`

```
*.sqlite*

```

---

### 📄 File: `./database/migrations/0001_01_01_000000_create_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->index();
            $table->string('username', 13)->unique()->index();
            $table->string('telepon', 20)->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->string('email', 50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

```

---

### 📄 File: `./database/migrations/0001_01_01_000001_create_cache_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->bigInteger('expiration')->index();
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->bigInteger('expiration')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};

```

---

### 📄 File: `./database/migrations/0001_01_01_000002_create_jobs_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};

```

---

### 📄 File: `./database/migrations/2026_04_16_113318_create_instansis_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instansis', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nama');
            $table->string('npsn', 8)->unique();
            $table->string('logo')->nullable();
            $table->string('logo_institusi')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->string('nama_pimpinan')->nullable();
            $table->string('nip_pimpinan')->nullable();
            $table->string('tte_pimpinan')->nullable();
            $table->string('nama_ketua')->nullable();
            $table->string('nip_ketua')->nullable();
            $table->string('tte_ketua')->nullable();
            $table->enum('jenjang', ['SD', 'MI', 'SMP', 'MTS', 'SMA', 'SMK', 'MA']);
            $table->enum('akreditasi', ['A', 'B', 'C', 'D', 'TT']);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instansis');
    }
};

```

---

### 📄 File: `./database/migrations/2026_04_16_113319_create_tahun_pelajarans_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tahun_pelajarans', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->dateTime('jadwal_pengumuman_mulai');
            $table->dateTime('jadwal_pengumuman_selesai');
            $table->dateTime('jadwal_kelulusan_mulai')->nullable();
            $table->dateTime('jadwal_kelulusan_selesai')->nullable();
            $table->string('jadwal_kelulusan_tempat')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_pelajarans');
    }
};

```

---

### 📄 File: `./database/migrations/2026_04_16_113320_create_siswas_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('nama_orangtua')->nullable();
            $table->string('nisn', 10)->unique();
            $table->string('berkas_skl')->nullable();
            $table->string('berkas_undangan')->nullable();
            $table->string('foto')->nullable();
            $table->string('telepon', 15)->unique()->nullable();
            $table->enum('status', ['Lulus', 'Tidak Lulus', 'Lulus Bersyarat'])->default('Lulus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};

```

---

### 📄 File: `./database/migrations/2026_04_16_113321_create_tamu_undangans_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tamu_undangans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswas')->cascadeOnDelete();
            $table->unsignedSmallInteger('jumlah_tamu')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tamu_undangans');
    }
};

```

---

### 📄 File: `./database/migrations/2026_04_16_113322_create_alumnis_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumnis', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nama');
            $table->string('nisn', 10)->unique();
            $table->string('tahun_lulus', 4);
            $table->string('foto')->nullable();
            $table->text('quote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};

```

---

### 📄 File: `./database/migrations/2026_04_16_113323_create_personils_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personils', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('foto')->nullable();
            $table->string('telepon', 15)->nullable();
            $table->string('sosial_media')->nullable();
            $table->string('jabatan');
            $table->text('quote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personils');
    }
};

```

---

### 📄 File: `./database/migrations/2026_04_16_212753_create_notifications_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

```

---

### 📄 File: `./database/seeders/AlumniSeeder.php`

```php
<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                'id' => Str::uuid(),
                'nama' => $namaAlumni[$i],
                'nisn' => str_pad($nisnBase % 10000000000, 10, '0', STR_PAD_LEFT),
                'tahun_lulus' => $tahunLulus[$i % count($tahunLulus)],
                'foto' => null,
                'quote' => $quotes[$i % count($quotes)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('alumnis')->insert($alumnis);
    }
}

```

---

### 📄 File: `./database/seeders/DatabaseSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'avatar' => 'assets/avatar/default.png',
            'username' => 'administrator',
            'status' => 'Aktif',
            'email' => 'adm@mtsn1pandeglang.sch.id',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $this->call([
            InstansiSeeder::class,
            TahunPelajaranSeeder::class,
            // SiswaSeeder::class,
            // AlumniSeeder::class,
            // PersonilSeeder::class,
        ]);
    }
}

```

---

### 📄 File: `./database/seeders/InstansiSeeder.php`

```php
<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('instansis')->insert([
            'id' => Str::uuid(),
            'nama' => 'MTs Negeri 1 Pandeglang',
            'npsn' => '20123456',
            'logo' => null,
            'logo_institusi' => null,
            'nomor_surat' => '421.3/001/MTSN1/2026',
            'nama_pimpinan' => 'Hj. Yanti Mariah, S.S., M.Pd',
            'nip_pimpinan' => '111111111111111111',
            'tte_pimpinan' => null,
            'nama_ketua' => 'Yahya Zulfikri, M.Pd',
            'nip_ketua' => '000000000000000000',
            'tte_ketua' => null,
            'jenjang' => 'MTS',
            'akreditasi' => 'A',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

```

---

### 📄 File: `./database/seeders/PersonilSeeder.php`

```php
<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                'id' => Str::uuid(),
                'nama' => $p['nama'],
                'nip' => $p['nip'],
                'foto' => null,
                'telepon' => null,
                'sosial_media' => null,
                'jabatan' => $p['jabatan'],
                'quote' => $quotes[$i % count($quotes)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('personils')->insert($data);
    }
}

```

---

### 📄 File: `./database/seeders/SiswaSeeder.php`

```php
<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                'id' => Str::uuid(),
                'nama' => $namaSiswa[$i],
                'nama_orangtua' => $namaOrangTua[$i],
                'nisn' => str_pad($nisnBase, 10, '0', STR_PAD_LEFT),
                'berkas_skl' => null,
                'foto' => null,
                'telepon' => '08'.str_pad(10000000 + ($i * 77777), 10, '0', STR_PAD_LEFT),
                'status' => $statusOptions[$i % 3 === 0 ? ($i % 2 === 0 ? 1 : 2) : 0],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('siswas')->insert($siswas);
    }
}

```

---

### 📄 File: `./database/seeders/TahunPelajaranSeeder.php`

```php
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

```

---

## 📁 Directory: public (Public Assets)

Publicly accessible files (entry point).

### 📄 File: `./public/.htaccess`

```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

```

---

### 📄 File: `./public/index.php`

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());

```

---

### 📄 File: `./public/manifest.json`

```json
{
    "name": "Layanan SKL Digital",
    "short_name": "SKL",
    "description": "Sistem Pengumuman Kelulusan & Surat Keterangan Lulus Digital",
    "start_url": "/",
    "display": "standalone",
    "orientation": "portrait",
    "background_color": "#060d0c",
    "theme_color": "#0d9488",
    "icons": [
        {
            "src": "/favicon.ico",
            "sizes": "192x192",
            "type": "image/x-icon",
            "purpose": "any maskable"
        },
        {
            "src": "/favicon.ico",
            "sizes": "512x512",
            "type": "image/x-icon",
            "purpose": "any maskable"
        }
    ],
    "screenshots": [
        {
            "src": "/favicon.ico",
            "sizes": "512x512",
            "type": "image/x-icon",
            "form_factor": "narrow"
        }
    ],
    "categories": [
        "education"
    ],
    "lang": "id"
}

```

---

### 📄 File: `./public/offline.html`

```html
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tidak Ada Koneksi — SKL</title>
    <style>
        :root {
            --teal: #0d9488;
            --teal-xl: #5eead4;
            --gold: #d4a843;
            --bg: #060d0c;
            --text: #dff0ec;
            --muted: #6aada3;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100svh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        .wrap {
            max-width: 340px;
        }

        .icon {
            font-size: 3.5rem;
            margin-bottom: 1.25rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .5
            }
        }

        h1 {
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: -.02em;
            margin-bottom: .5rem;
        }

        p {
            font-size: .82rem;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        button {
            background: linear-gradient(135deg, var(--teal), #0f766e);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .7rem 2rem;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            box-shadow: 0 0 20px rgba(13, 148, 136, .3);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 28px rgba(13, 148, 136, .45);
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="icon">📡</div>
        <h1>Tidak Ada Koneksi</h1>
        <p>Periksa koneksi internet kamu, lalu coba lagi.<br>Halaman ini tersimpan untuk diakses offline.</p>
        <button onclick="location.reload()">Coba Lagi</button>
    </div>
</body>

</html>

```

---

### 📄 File: `./public/robots.txt`

```text
User-agent: *
Disallow:

```

---

### 📄 File: `./public/sw.js`

```javascript
const CACHE = "skl-v1";
const OFFLINE = "/offline.html";

// Aset statis yang di-precache saat install
const PRECACHE = ["/", OFFLINE, "/favicon.ico", "/manifest.json"];

// ── Install: precache aset ──────────────────────────────────
self.addEventListener("install", (e) => {
    e.waitUntil(
        caches
            .open(CACHE)
            .then((c) => c.addAll(PRECACHE))
            .then(() => self.skipWaiting()),
    );
});

// ── Activate: hapus cache lama ──────────────────────────────
self.addEventListener("activate", (e) => {
    e.waitUntil(
        caches
            .keys()
            .then((keys) =>
                Promise.all(
                    keys
                        .filter((k) => k !== CACHE)
                        .map((k) => caches.delete(k)),
                ),
            )
            .then(() => self.clients.claim()),
    );
});

// ── Fetch: Network-first, fallback cache, fallback offline ──
self.addEventListener("fetch", (e) => {
    // Lewati request non-GET dan request ke API/admin
    const url = new URL(e.request.url);
    if (e.request.method !== "GET") return;
    if (url.pathname.startsWith("/admin")) return;
    if (url.pathname.startsWith("/api")) return;

    e.respondWith(
        fetch(e.request)
            .then((res) => {
                // Simpan salinan response ke cache (hanya response valid)
                if (res && res.status === 200 && res.type === "basic") {
                    const clone = res.clone();
                    caches.open(CACHE).then((c) => c.put(e.request, clone));
                }
                return res;
            })
            .catch(() =>
                caches.match(e.request).then((cached) => {
                    if (cached) return cached;
                    // Jika halaman HTML tidak ada di cache → halaman offline
                    if (
                        e.request.headers.get("accept")?.includes("text/html")
                    ) {
                        return caches.match(OFFLINE);
                    }
                }),
            ),
    );
});

```

---

## 📁 Directory: resources (Frontend Resources)

Views, CSS, JavaScript, and frontend assets.

### 📄 File: `./resources/css/app.css`

```css
@import 'tailwindcss';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';
@source '../**/*.blade.php';
@source '../**/*.js';

@theme {
    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji',
        'Segoe UI Symbol', 'Noto Color Emoji';
}

```

---

### 📄 File: `./resources/css/filament/admin/theme.css`

```css
@import "../../../../vendor/filament/filament/resources/css/theme.css";

@source '../../../../app/Filament/**/*';
@source '../../../../resources/views/filament/**/*';
@source '../../../../vendor/devonab/filament-easy-footer/resources/views/**/*';
@source '../../../../vendor/diogogpinto/filament-auth-ui-enhancer/resources/**/*.blade.php';

```

---

### 📄 File: `./resources/js/app.js`

```javascript
import './bootstrap';

```

---

### 📄 File: `./resources/js/bootstrap.js`

```javascript
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

```

---

### 📄 File: `./resources/views/alumni/index.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Alumni')

@push('styles')
    @include('partials._people-styles')
@endpush

@section('content')
    @include('partials._page-header', [
        'title'       => 'Alumni',
        'searchRoute' => 'alumni.cari',
        'clearRoute'  => 'alumni.index',
        'placeholder' => 'Nama atau NISN',
        'keyword'     => $keyword ?? null,
        'totalFound'  => $items->total() ?? null,
    ])

    @include('partials._people-grid', [
        'items'     => $items,
        'photoKey'  => 'foto',
        'subKey'    => 'tahun_lulus',
        'subPrefix' => 'Lulus ',
        'monoKey'   => 'nisn',
        'keyword'   => $keyword ?? null,
    ])
@endsection

```

---

### 📄 File: `./resources/views/components/auth-wrapper.blade.php`

```blade
<hr class="my-3 border-gray-700">
<p class="text-xs text-center text-gray-500">
    Crafted with dedication by <span class="text-emerald-500 font-semibold">Yahya Zulfikri</span>
    <br>
    &copy; {{ date('Y') }} AGP MTsN 1 Pandeglang. All rights reserved.
</p>

```

---

### 📄 File: `./resources/views/components/flash-messages.blade.php`

```blade
@foreach (['success', 'error', 'warning', 'info'] as $type)
    @if (session($type))
        <div class="flash-msg" data-type="{{ $type }}">
            <div class="flash-inner flash-{{ $type }}">
                <span>{{ session($type) }}</span>
                <button onclick="this.closest('.flash-msg').remove()" aria-label="Tutup">&times;</button>
            </div>
        </div>
    @endif
@endforeach

```

---

### 📄 File: `./resources/views/components/kop-surat.blade.php`

```blade
@props(['forPdf' => false])
@php
    $logoSrc = $instansi?->logo_institusi
        ? ($forPdf
            ? public_path('storage/' . $instansi->logo_institusi)
            : Storage::url($instansi->logo_institusi))
        : null;
@endphp

<div class="kop-surat">
    @if ($logoSrc)
        <img src="{{ $logoSrc }}" alt="">
    @endif
    <div class="kop-text">
        <h1>{{ $instansi?->nama }}</h1>
        <p>
            NPSN: {{ $instansi?->npsn ?? '&mdash;' }}
            @if ($instansi?->akreditasi)
                &nbsp;&middot;&nbsp; Akreditasi: {{ $instansi->akreditasi }}
            @endif
        </p>
    </div>
</div>

```

---

### 📄 File: `./resources/views/components/ttd.blade.php`

```blade
@props(['forPdf' => false])
@php
    $ttdSrc = $instansi?->tte_pimpinan
        ? ($forPdf
            ? public_path('storage/' . $instansi->tte_pimpinan)
            : Storage::url($instansi->tte_pimpinan))
        : null;
@endphp

<div class="ttd-block">
    <div class="ttd-inner">
        <p>{{ $instansi?->nama }}, {{ now()->translatedFormat('d F Y') }}</p>
        @if ($ttdSrc)
            <img src="{{ $ttdSrc }}" alt="Tanda Tangan">
        @else
            <div class="ttd-space"></div>
        @endif
        <p class="ttd-nama">{{ $instansi?->nama_pimpinan }}</p>
        @if ($instansi?->nip_pimpinan)
            <p class="ttd-nip">NIP. {{ $instansi->nip_pimpinan }}</p>
        @endif
    </div>
</div>

```

---

### 📄 File: `./resources/views/filament/pages/auth/edit-profile.blade.php`

```blade
<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}
        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>
    <x-auth-wrapper />
</x-filament-panels::page.simple>

```

---

### 📄 File: `./resources/views/filament/pages/auth/forgot-password.blade.php`

```blade
<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="kirim">
        {{ $this->form }}
        <x-filament::button type="submit" size="lg" class="w-full">
            Kirim Kode OTP
        </x-filament::button>
    </x-filament-panels::form>
    <div class="mt-6 text-sm text-center text-gray-600 dark:text-gray-400">
        Sudah ingat password?
        <a href="{{ filament()->getLoginUrl() }}"
            class="font-semibold transition duration-200 text-primary-600 hover:text-primary-500 hover:underline dark:text-primary-400 dark:hover:text-primary-300">
            Kembali ke Login
        </a>
    </div>
    <x-auth-wrapper />
</x-filament-panels::page.simple>

```

---

### 📄 File: `./resources/views/filament/pages/auth/login.blade.php`

```blade
{{-- <x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}
            {{ $this->registerAction }}
        </x-slot>
    @endif
    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}
        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>
    <x-auth-wrapper />
</x-filament-panels::page.simple> --}}
<x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            Belum punya akun?
            {{ $this->registerAction }}
        </x-slot>
    @endif

    <form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament::button type="submit" class="w-full">
            Masuk
        </x-filament::button>
    </form>

    <x-auth-wrapper />
</x-filament-panels::page.simple>

```

---

### 📄 File: `./resources/views/filament/pages/auth/new-password.blade.php`

```blade
<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="simpanPassword">
        {{ $this->form }}
        <x-filament::button type="submit" size="lg" class="w-full">
            Simpan Password Baru
        </x-filament::button>
    </x-filament-panels::form>
    <div class="mt-6 text-sm text-center">
        <a href="{{ route('otp.forgot-password') }}"
            class="font-medium text-gray-500 transition duration-200 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
            &larr; Kembali
        </a>
    </div>
    <x-auth-wrapper />
</x-filament-panels::page.simple>

```

---

### 📄 File: `./resources/views/filament/pages/auth/register.blade.php`

```blade
<x-filament-panels::page.simple>
    @if (filament()->hasLogin())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/register.actions.login.before') }}
            {{ $this->loginAction }}
        </x-slot>
    @endif
    <x-filament-panels::form wire:submit="register">
        {{ $this->form }}
        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>
    <x-auth-wrapper />
</x-filament-panels::page.simple>

```

---

### 📄 File: `./resources/views/filament/pages/auth/reset-password-otp.blade.php`

```blade
<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="verifikasiOtp">
        {{ $this->form }}
        <x-filament::button type="submit" size="lg" class="w-full">
            Verifikasi OTP
        </x-filament::button>
    </x-filament-panels::form>
    <div class="mt-6 space-y-4 text-sm text-center text-gray-600 dark:text-gray-400">
        <div>
            Belum menerima kode OTP?
            <button wire:click="resend" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                type="button"
                class="font-semibold transition duration-200 text-primary-600 hover:text-primary-500 hover:underline dark:text-primary-400 dark:hover:text-primary-300">
                Kirim ulang
            </button>
        </div>
        <div>
            <a href="{{ route('otp.forgot-password') }}"
                class="inline-block font-medium text-gray-500 transition duration-200 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                &larr; Kembali
            </a>
        </div>
    </div>
    <x-auth-wrapper />
</x-filament-panels::page.simple>

```

---

### 📄 File: `./resources/views/filament/pages/auth/verifikasi-otp.blade.php`

```blade
<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="verifikasi">
        {{ $this->form }}
        <x-filament::button type="submit" size="lg" class="w-full">
            Verifikasi
        </x-filament::button>
    </x-filament-panels::form>
    <div class="mt-6 text-sm text-center text-gray-600 dark:text-gray-400">
        Belum menerima kode OTP?
        <button wire:click="resend" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
            type="button"
            class="font-semibold transition duration-200 text-primary-600 hover:text-primary-500 hover:underline dark:text-primary-400 dark:hover:text-primary-300">
            Kirim ulang
        </button>
    </div>
    <x-auth-wrapper />
</x-filament-panels::page.simple>

```

---

### 📄 File: `./resources/views/landing/hasil.blade.php`

```blade
@extends('layouts.app')
@section('title', $siswa ? 'Hasil — ' . $siswa->nama : 'Siswa Tidak Ditemukan')

@push('styles')
    @include('partials._people-styles')
@endpush

@push('styles')
    <style>
        .hasil-wrap {
            max-width: 500px;
            margin: 0 auto
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            font-size: .8rem;
            color: var(--muted);
            text-decoration: none;
            margin-bottom: 1.5rem;
            transition: color .2s
        }

        .back-link:hover { color: var(--teal-xl) }
        .back-link span { transition: transform .2s }
        .back-link:hover span { transform: translateX(-2px) }

        /* Not found */
        .notfound-card { padding: 3rem 2rem; text-align: center }
        .notfound-title { font-size: 1.05rem; font-weight: 700; margin-bottom: .45rem; font-family: var(--font-display) }
        .notfound-sub { font-size: .82rem; color: var(--muted); line-height: 1.75; margin-bottom: 1.4rem }

        /* Result */
        .result-header { padding: 1.5rem 1.6rem; border-bottom: 1px solid var(--border2) }
        .status-row { display: flex; align-items: center; gap: .9rem }
        .status-icon-wrap {
            width: 50px; height: 50px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            font-size: .72rem; font-weight: 800; letter-spacing: .08em;
            text-transform: uppercase; font-family: var(--font-display)
        }
        .status-label-sm { font-size: .62rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; opacity: .7; margin-bottom: .18rem }
        .status-text { font-size: 1.2rem; font-weight: 800; letter-spacing: -.02em; line-height: 1.1; font-family: var(--font-display) }
        .result-info { padding: 1.1rem 1.6rem; border-bottom: 1px solid var(--border2) }
        .info-row { display: flex; justify-content: space-between; align-items: baseline; gap: 1rem; padding: .5rem 0; border-bottom: 1px solid var(--border2) }
        .info-row:last-child { border-bottom: none }
        .info-label { font-size: .73rem; color: var(--muted); flex-shrink: 0; font-weight: 500 }
        .info-val { font-size: .83rem; font-weight: 600; text-align: right }
        .result-actions { padding: 1.1rem 1.6rem; display: flex; flex-direction: column; gap: .6rem }
        .doc-btn {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            padding: .8rem 1.1rem; border-radius: 11px; font-size: .82rem; font-weight: 700;
            font-family: var(--font-body); text-decoration: none; cursor: pointer; transition: all .22s; border: none
        }
        .doc-btn-primary {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff; box-shadow: 0 0 24px rgba(13,148,136,.22)
        }
        .doc-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 28px rgba(13,148,136,.38) }
        .doc-btn-outline { background: transparent; border: 1px solid rgba(20,184,166,.28); color: var(--teal-xl) }
        .doc-btn-outline:hover { background: rgba(20,184,166,.07); border-color: rgba(20,184,166,.5) }
        .doc-btn-disabled {
            background: rgba(255,255,255,.02); border: 1px dashed var(--border);
            color: var(--muted2); cursor: default; pointer-events: none
        }
        .result-footer-note { text-align: center; font-size: .72rem; color: var(--muted2); margin-top: .85rem; letter-spacing: .01em }

        /* Themes */
        .theme-lulus .status-icon-wrap { background: rgba(20,184,166,.1); border: 1px solid rgba(20,184,166,.2); color: var(--teal-xl) }
        .theme-lulus .status-text { color: var(--teal-xl) }
        .theme-tidak .status-icon-wrap { background: rgba(220,38,38,.08); border: 1px solid rgba(220,38,38,.18); color: #f87171 }
        .theme-tidak .status-text { color: #f87171 }
        .theme-syarat .status-icon-wrap { background: rgba(245,158,11,.09); border: 1px solid rgba(245,158,11,.2); color: #fbbf24 }
        .theme-syarat .status-text { color: #fbbf24 }
    </style>
@endpush

@section('content')
    <div class="hasil-wrap reveal visible">
        <a href="{{ route('landing') }}" class="back-link"><span>&larr;</span> Kembali ke Pencarian</a>

        @if (!$siswa)
            <div class="card notfound-card">
                <div class="notfound-title">Data Tidak Ditemukan</div>
                <div class="notfound-sub">
                    Tidak ada siswa dengan NISN atau nomor telepon
                    <strong style="color:var(--text)">&ldquo;{{ $keyword }}&rdquo;</strong>.
                    Pastikan data yang dimasukkan sudah benar.
                </div>
                <a href="{{ route('landing') }}" class="btn btn-primary" style="margin:0 auto;">&larr; Coba Lagi</a>
            </div>
        @else
            @php
                $status      = $siswa->status;
                $adaSkl      = (bool) $siswa->berkas_skl;
                $bolehUndang = $siswa->isLulus();
            @endphp

            <div class="card {{ $status->theme() }}" style="overflow:hidden;">

                <div class="result-header">
                    <div class="eyebrow" style="margin-bottom:.9rem;">Hasil Seleksi Kelulusan</div>
                    <div class="status-row">
                        <div class="status-icon-wrap">{{ $status->iconLabel() }}</div>
                        <div>
                            <div class="status-label-sm">Status</div>
                            <div class="status-text">{{ $status->getLabel() }}</div>
                        </div>
                    </div>
                </div>

                <div class="result-info">
                    @foreach ([
                        'Nama Siswa'     => [$siswa->nama,           false],
                        'NISN'           => [$siswa->nisn,           true],
                        'Nama Orang Tua' => [$siswa->nama_orangtua,  false],
                    ] as $label => [$val, $mono])
                        @if ($val)
                            <div class="info-row">
                                <span class="info-label">{{ $label }}</span>
                                <span class="info-val" @if ($mono) style="font-family:monospace;" @endif>
                                    {{ $val }}
                                </span>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="result-actions">
                    @if ($adaSkl)
                        <a href="{{ route('landing.skl', $siswa) }}" target="_blank" class="doc-btn doc-btn-primary">
                            Unduh Surat Keterangan Lulus
                        </a>
                    @else
                        <div class="doc-btn doc-btn-disabled">
                            Dokumen SKL belum tersedia &mdash; hubungi madrasah
                        </div>
                    @endif

                    @if ($bolehUndang)
                        <a href="{{ route('landing.undangan', $siswa) }}" target="_blank" class="doc-btn doc-btn-outline">
                            Cetak Surat Undangan Kelulusan
                        </a>
                    @endif
                </div>

            </div>

            @if ($status->footerNote())
                <p class="result-footer-note"
                   @if ($status->footerColor()) style="color:{{ $status->footerColor() }}" @endif>
                    {{ $status->footerNote() }}
                </p>
            @endif
        @endif
    </div>
@endsection

```

---

### 📄 File: `./resources/views/landing/index.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Pengumuman Kelulusan')

@push('styles')
    <style>
        .hero-section {
            min-height: calc(100svh - var(--nav-h));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
            text-align: center;
            position: relative;
        }

        .hero-inner {
            max-width: 620px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero-logo {
            width: 84px;
            height: 84px;
            object-fit: contain;
            margin: 0 auto 1.4rem;
            border-radius: 18px;
            border: 1px solid var(--border);
            background: rgba(13, 148, 136, .07);
            padding: 6px;
            box-shadow: 0 0 36px rgba(13, 148, 136, .16);
            animation: fade-up .6s ease both .1s;
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 2.9rem);
            font-weight: 900;
            letter-spacing: -.03em;
            line-height: 1.08;
            font-family: var(--font-display);
            animation: fade-up .7s ease both .2s;
        }

        .grad {
            background: linear-gradient(135deg, var(--teal-xl), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            font-size: .86rem;
            color: var(--muted);
            margin-top: .8rem;
            line-height: 1.7;
            animation: fade-up .7s ease both .3s;
        }

        /* Countdown */
        .cd-card {
            max-width: 400px;
            margin: 2.25rem auto 0;
            padding: 1.6rem;
            border-radius: 20px;
            background: rgba(13, 148, 136, .07);
            border: 1px solid rgba(20, 184, 166, .16);
            backdrop-filter: blur(16px);
            animation: fade-up .8s ease both .4s;
        }

        .cd-label {
            font-size: .67rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--gold-l);
            text-align: center;
            margin-bottom: .8rem;
        }

        .cd-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .55rem;
        }

        .cd-box {
            background: rgba(13, 148, 136, .09);
            border: 1px solid rgba(20, 184, 166, .13);
            border-radius: 11px;
            padding: .85rem .35rem;
            text-align: center;
        }

        .cd-n {
            font-size: 1.9rem;
            font-weight: 900;
            font-variant-numeric: tabular-nums;
            background: linear-gradient(135deg, var(--teal-xl), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        .cd-l {
            font-size: .56rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .12em;
            margin-top: .25rem;
            font-weight: 600;
        }

        .cd-footer-note {
            margin-top: .9rem;
            font-size: .71rem;
            color: var(--muted);
            text-align: center;
        }

        /* State cards */
        .state-card {
            max-width: 400px;
            margin: 2rem auto 0;
            padding: 2.25rem;
            border-radius: 20px;
            text-align: center;
            animation: fade-up .7s ease both .3s;
        }

        .state-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: .4rem;
            font-family: var(--font-display);
        }

        .state-sub {
            font-size: .8rem;
            color: var(--muted);
            line-height: 1.7;
        }

        /* Search card */
        .search-card {
            max-width: 460px;
            margin: 1.4rem auto 0;
            padding: 1.75rem;
            border-radius: 20px;
            background: rgba(13, 148, 136, .06);
            border: 1px solid rgba(20, 184, 166, .16);
            backdrop-filter: blur(16px);
        }

        .search-card-head {
            display: flex;
            align-items: center;
            gap: .9rem;
            margin-bottom: 1.35rem;
        }

        .search-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 11px;
            background: rgba(20, 184, 166, .1);
            border: 1px solid rgba(20, 184, 166, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: .72rem;
            font-weight: 800;
            color: var(--teal-xl);
            font-family: var(--font-display);
            letter-spacing: .03em;
        }

        .search-card-title {
            font-size: .94rem;
            font-weight: 700;
            line-height: 1.2;
            font-family: var(--font-display);
        }

        .search-card-sub {
            font-size: .73rem;
            color: var(--muted);
            margin-top: .18rem;
        }

        .search-field {
            position: relative;
            margin-bottom: .9rem;
        }

        .search-input {
            width: 100%;
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: .72rem .9rem;
            font-size: .86rem;
            font-family: var(--font-body);
            color: var(--text);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .search-input::placeholder {
            color: var(--muted2);
        }

        .search-input:focus {
            border-color: rgba(20, 184, 166, .45);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .1);
        }

        .search-input.is-error {
            border-color: rgba(220, 38, 38, .42);
        }

        .search-error {
            font-size: .73rem;
            color: #f87171;
            margin-bottom: .7rem;
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .42rem 1rem;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 700;
            margin-top: 1.4rem;
            animation: fade-up .7s ease both .35s;
        }

        .status-badge-warn {
            background: rgba(245, 158, 11, .08);
            border: 1px solid rgba(245, 158, 11, .22);
            color: #fbbf24;
        }

        /* Form muncul langsung jika sudah buka — tanpa amplop */
        #cari-section {
            animation: fade-up .7s ease both .35s;
            padding: 0 1rem;
        }

        #cari-section.hidden {
            display: none;
        }

        .animate-fade-slide-up {
            animation: fade-up .4s ease both;
        }
    </style>
@endpush

@section('content')
    @php
        $tp = $tahunPelajaran ?? null;
        $now = now();
        $belumBuka = $tp && $now->lt($tp->jadwal_pengumuman_mulai);
        $sudahTutup = $tp && $now->gt($tp->jadwal_pengumuman_selesai);
        $sudahBuka = $tp && $now->between($tp->jadwal_pengumuman_mulai, $tp->jadwal_pengumuman_selesai);
    @endphp

    <div style="margin-top:-2.5rem">
        <section class="hero-section">
            <div class="hero-inner">

                @if ($instansi?->logo_institusi)
                    <img src="{{ Storage::url($instansi->logo_institusi) }}" alt="Logo" class="hero-logo">
                @endif

                <h1 class="hero-title">Pengumuman<br><span class="grad">Kelulusan</span></h1>
                <p class="hero-sub">
                    {{ $instansi?->nama }}
                    @if ($tp)
                        Tahun Pelajaran {{ $tp->name }}
                    @endif
                </p>

                {{-- CASE 1: Tidak ada TP aktif --}}
                @if (!$tp)
                    <div class="card state-card" style="margin-top:2.25rem;">
                        <div class="state-title">Informasi Belum Tersedia</div>
                        <div class="state-sub">
                            Hubungi pihak madrasah untuk informasi lebih lanjut mengenai pengumuman kelulusan.
                        </div>
                    </div>

                    {{-- CASE 2: Belum waktunya buka --}}
                @elseif ($belumBuka)
                    <div class="status-badge status-badge-warn">
                        Pengumuman dibuka pada {{ $tp->jadwal_pengumuman_mulai->translatedFormat('d F Y H:i') }} WIB
                    </div>
                    <div class="cd-card">
                        <div class="cd-label">Hitung Mundur Pembukaan</div>
                        <div class="cd-grid">
                            @foreach (['days' => 'Hari', 'hours' => 'Jam', 'minutes' => 'Menit', 'seconds' => 'Detik'] as $k => $l)
                                <div class="cd-box">
                                    <div class="cd-n" id="cd-{{ $k }}">00</div>
                                    <div class="cd-l">{{ $l }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="cd-footer-note">Pastikan kamu kembali tepat waktu.</div>
                    </div>

                    {{-- CASE 3: Periode sudah tutup --}}
                @elseif ($sudahTutup)
                    <div class="card state-card"
                        style="margin-top:2.25rem;background:rgba(245,158,11,.05);border-color:rgba(245,158,11,.18);">
                        <div class="state-title" style="color:#fbbf24;">Periode Pengumuman Telah Berakhir</div>
                        <div class="state-sub">Hubungi madrasah untuk informasi lebih lanjut.</div>
                    </div>

                    {{-- CASE 4: Sedang buka — langsung tampilkan form --}}
                @elseif ($sudahBuka)
                    <div id="cari-section">
                        <div class="search-card">
                            <div class="search-card-head">
                                <div class="search-icon-wrap"
                                    style="background:transparent;border:none;padding:0;width:44px;height:44px;flex-shrink:0;">
                                    <img src="/favicon.ico" alt="SKL"
                                        style="width:44px;height:44px;object-fit:contain;border-radius:10px;">
                                </div>
                                <div style="min-width:0;">
                                    <div class="search-card-title">Cek Status Kelulusan</div>
                                    <div class="search-card-sub">Masukkan NISN</div>
                                </div>
                            </div>

                            <form action="{{ route('landing.cari') }}" method="POST">
                                @csrf
                                <div class="search-field">
                                    <input type="text" name="nisn" placeholder="Cth. 0000971291"
                                        value="{{ old('nisn') }}"
                                        class="search-input {{ $errors->hasAny(['nisn', 'telepon']) ? 'is-error' : '' }}"
                                        maxlength="15" autofocus>
                                </div>
                                @error('nisn')
                                    <div class="search-error"><span>&times;</span> {{ $message }}</div>
                                @enderror
                                @error('telepon')
                                    <div class="search-error"><span>&times;</span> {{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                                    Cari Kelulusan
                                </button>
                            </form>
                        </div>
                    </div>
            </div>
            @endif

    </div>
    </section>
    </div>
@endsection

@push('scripts')
    <script>
        // Countdown — hanya jalan jika elemen ada (state belumBuka)
        const cdEl = document.getElementById('cd-seconds');
        if (cdEl) {
            const cdTarget = new Date("{{ $tp?->jadwal_pengumuman_mulai?->toIso8601String() }}");
            const pad = n => String(n).padStart(2, '0');

            function tickCountdown() {
                const diff = cdTarget - Date.now();
                if (diff <= 0) {
                    location.reload();
                    return;
                }
                [
                    ['days', Math.floor(diff / 86400000)],
                    ['hours', Math.floor((diff % 86400000) / 3600000)],
                    ['minutes', Math.floor((diff % 3600000) / 60000)],
                    ['seconds', Math.floor((diff % 60000) / 1000)],
                ].forEach(([k, v]) => {
                    const el = document.getElementById('cd-' + k);
                    if (el) el.textContent = pad(v);
                });
            }

            tickCountdown();
            setInterval(tickCountdown, 1000);
        }
    </script>
@endpush

```

---

### 📄 File: `./resources/views/landing/undangan.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Surat Undangan — ' . $siswa->nama)

@push('styles')
    @include('partials._doc-styles')
@endpush

@section('content')
    <div class="doc-wrap">
        <div class="doc-toolbar print:hidden">
            <a href="{{ route('landing.hasil', $siswa) }}" class="doc-back">
                <span>&larr;</span> Kembali
            </a>
            <a href="{{ route('landing.undangan.pdf', $siswa) }}" target="_blank" class="btn btn-primary"
                style="font-size:.82rem;padding:.55rem 1.1rem;">
                Unduh PDF
            </a>
        </div>

        <div class="doc-card">
            <x-kop-surat />

            <div class="doc-body">
                <table class="doc-meta">
                    <tr>
                        <td class="lbl">Nomor</td>
                        <td class="sep">:</td>
                        <td>{{ $instansi?->nomor_surat ?? '&mdash;' }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Hal</td>
                        <td class="sep">:</td>
                        <td>Undangan Wisuda &amp; Pengambilan Ijazah</td>
                    </tr>
                </table>

                <h2 class="doc-title">Surat Undangan</h2>

                <p class="doc-para">Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh.</p>

                <p class="doc-para">
                    Dengan hormat, kami mengundang Bapak/Ibu
                    <strong>{{ $siswa->nama_orangtua ?? 'Orang Tua/Wali' }}</strong>
                    beserta putra/putri atas nama <strong>{{ $siswa->nama }}</strong>
                    (NISN: {{ $siswa->nisn }}) untuk menghadiri acara Wisuda &amp; Pengambilan Ijazah
                    yang akan dilaksanakan pada:
                </p>

                @php
                    $tp        = $tahunPelajaran;
                    $adaJadwal = $tp?->jadwal_kelulusan_mulai
                              && $tp?->jadwal_kelulusan_selesai
                              && $tp?->jadwal_kelulusan_tempat;
                @endphp

                @if ($adaJadwal)
                    <table class="doc-jadwal">
                        <tr>
                            <td class="lbl">Hari / Tanggal</td>
                            <td>:</td>
                            <td>{{ $tp->jadwal_kelulusan_mulai->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Waktu</td>
                            <td>:</td>
                            <td>{{ $tp->jadwal_kelulusan_mulai->format('H:i') }} &ndash;
                                {{ $tp->jadwal_kelulusan_selesai->format('H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <td class="lbl">Tempat</td>
                            <td>:</td>
                            <td>{{ $tp->jadwal_kelulusan_tempat }}</td>
                        </tr>
                    </table>
                @else
                    <div class="doc-alert">Jadwal acara belum ditentukan. Pantau informasi dari madrasah.</div>
                @endif

                <p class="doc-para">Atas kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>
                <p class="doc-para">Wassalamu&rsquo;alaikum Warahmatullahi Wabarakatuh.</p>

                <x-ttd />

                <div class="qr-block">
                    {!! QrCode::size(100)->format('svg')->generate($siswa->id) !!}
                    <p>Scan QR ini saat registrasi kehadiran &bull; {{ $siswa->nisn }}</p>
                </div>
            </div>
        </div>

        <p class="doc-note print:hidden">
            Dokumen ini sah jika dicetak menggunakan tombol <strong>Unduh PDF</strong> di atas.
        </p>
    </div>
@endsection

```

---

### 📄 File: `./resources/views/layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Layanan Kelulusan Digital') &mdash; {{ $instansi?->nama ?? config('app.name') }}</title>

    @if ($instansi?->logo_institusi)
        <link rel="icon" href="{{ Storage::url($instansi->logo_institusi) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── RESET ─────────────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* ── TOKENS ────────────────────────────────────────────────── */
        :root {
            --teal: #0d9488;
            --teal-l: #14b8a6;
            --teal-d: #0f766e;
            --teal-xl: #5eead4;
            --gold: #d4a843;
            --gold-l: #f0c96a;
            --bg: #060d0c;
            --bg2: #091210;
            --surface: #0e1a18;
            --card: rgba(20, 184, 166, .05);
            --card2: rgba(255, 255, 255, .03);
            --border: rgba(20, 184, 166, .11);
            --border2: rgba(255, 255, 255, .05);
            --text: #dff0ec;
            --muted: #6aada3;
            --muted2: #4a8078;
            --radius: 14px;
            --nav-h: 62px;
            --font-display: 'Lexend', system-ui, sans-serif;
            --font-body: 'Lexend', system-ui, sans-serif;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
            min-height: 100svh;
        }

        ::-webkit-scrollbar {
            width: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--teal);
            border-radius: 3px;
        }

        /* ── AMBIENT ───────────────────────────────────────────────── */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(160px);
            opacity: .065;
            pointer-events: none;
            z-index: 0;
            animation: orb-drift 20s ease-in-out infinite alternate;
        }

        .orb-1 {
            width: 680px;
            height: 680px;
            background: radial-gradient(circle, var(--teal), transparent 70%);
            top: -260px;
            left: -220px;
        }

        .orb-2 {
            width: 480px;
            height: 480px;
            background: radial-gradient(circle, var(--gold), transparent 70%);
            bottom: -160px;
            right: -180px;
            animation-delay: -10s;
        }

        @keyframes orb-drift {
            to {
                transform: translate(28px, 18px) scale(1.07);
            }
        }

        .grid-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(13, 148, 136, .035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(13, 148, 136, .035) 1px, transparent 1px);
            background-size: 56px 56px;
            mask-image: radial-gradient(ellipse 80% 55% at 50% 0%, black 35%, transparent 100%);
        }

        /* ── NAV ───────────────────────────────────────────────────── */
        nav#mainNav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            height: var(--nav-h);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            background: rgba(6, 13, 12, .85);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(28px) saturate(160%);
            transition: background .3s, box-shadow .3s;
        }

        nav#mainNav.scrolled {
            background: rgba(6, 13, 12, .96);
            box-shadow: 0 1px 0 var(--border), 0 4px 32px rgba(13, 148, 136, .1);
        }

        /* Brand */
        .nav-brand {
            display: flex;
            align-items: center;
            gap: .7rem;
            text-decoration: none;
            color: inherit;
            flex-shrink: 0;
            min-width: 0;
        }

        .nav-logo {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid rgba(20, 184, 166, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(13, 148, 136, .08);
            box-shadow: 0 0 14px rgba(13, 148, 136, .15);
        }

        .nav-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 3px;
        }

        .nav-logo-fallback {
            font-size: .68rem;
            font-weight: 800;
            color: var(--teal-xl);
            font-family: var(--font-display);
        }

        .nav-brand-text {
            min-width: 0;
        }

        .nav-name {
            font-size: .8rem;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-family: var(--font-display);
            max-width: 240px;
            color: var(--text);
        }

        .nav-sub {
            font-size: .57rem;
            font-weight: 500;
            color: var(--teal-l);
            margin-top: 2px;
            letter-spacing: .03em;
            white-space: nowrap;
            text-transform: none;
        }

        /* Centre links */
        .nav-links {
            display: flex;
            gap: .05rem;
            list-style: none;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .nav-links a {
            text-decoration: none;
            color: var(--muted);
            font-size: .76rem;
            font-weight: 600;
            padding: .38rem .75rem;
            border-radius: 8px;
            transition: all .2s;
            white-space: nowrap;
            letter-spacing: .01em;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .09);
        }

        .nav-links a.nav-tamu {
            color: var(--gold-l);
        }

        .nav-links a.nav-tamu:hover,
        .nav-links a.nav-tamu.active {
            color: var(--gold-l);
            background: rgba(212, 168, 67, .1);
        }

        /* Right side */
        .nav-right {
            display: flex;
            align-items: center;
            gap: .45rem;
            flex-shrink: 0;
        }

        .n-btn {
            height: 34px;
            padding: 0 .9rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--card2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .76rem;
            color: inherit;
            transition: all .2s;
            white-space: nowrap;
            font-weight: 600;
            font-family: var(--font-body);
            text-decoration: none;
            letter-spacing: .01em;
        }

        .n-btn:hover {
            border-color: var(--teal);
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .09);
        }

        .n-btn-primary {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff;
            border-color: transparent;
            box-shadow: 0 0 18px rgba(13, 148, 136, .22);
        }

        .n-btn-primary:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 22px rgba(13, 148, 136, .38);
        }

        /* Hamburger */
        #menuBtn {
            width: 34px;
            height: 34px;
            flex-direction: column;
            gap: 5px;
            display: none;
            /* shown via media query */
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            padding: 0;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        #menuBtn:hover {
            border-color: var(--teal);
            background: rgba(20, 184, 166, .09);
        }

        #menuBtn span {
            display: block;
            width: 15px;
            height: 1.5px;
            background: currentColor;
            border-radius: 2px;
            transition: all .28s cubic-bezier(.4, 0, .2, 1);
        }

        #menuBtn.open span:nth-child(1) {
            transform: translateY(6.5px) rotate(45deg);
        }

        #menuBtn.open span:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }

        #menuBtn.open span:nth-child(3) {
            transform: translateY(-6.5px) rotate(-45deg);
        }

        /* ── MOBILE DRAWER ─────────────────────────────────────────── */
        .drawer {
            position: fixed;
            top: var(--nav-h);
            left: 0;
            right: 0;
            z-index: 190;
            display: flex;
            flex-direction: column;
            gap: .25rem;
            background: rgba(6, 13, 12, .97);
            border-bottom: 1px solid transparent;
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s cubic-bezier(.4, 0, .2, 1), padding .3s, border-color .3s;
            backdrop-filter: blur(20px);
            padding: 0 1.25rem;
        }

        .drawer.open {
            max-height: 420px;
            padding: .75rem 1.25rem 1.5rem;
            border-color: var(--border);
        }

        .drawer a {
            text-decoration: none;
            color: var(--muted);
            font-size: .84rem;
            font-weight: 600;
            padding: .6rem .85rem;
            border-radius: 9px;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .drawer a:hover {
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .07);
        }

        .drawer a.active {
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .06);
        }

        .drawer a.drawer-tamu {
            color: var(--gold-l);
        }

        .drawer a.drawer-tamu:hover {
            color: var(--gold-l);
            background: rgba(212, 168, 67, .08);
        }

        .drawer-divider {
            height: 1px;
            background: var(--border2);
            margin: .35rem 0;
        }

        /* ── PAGE ──────────────────────────────────────────────────── */
        .page-wrap {
            position: relative;
            z-index: 1;
            padding-top: var(--nav-h);
        }

        .content-wrap {
            max-width: 1160px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        /* ── FLASH ─────────────────────────────────────────────────── */
        .flash-area {
            max-width: 1160px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .flash-msg {
            margin-top: .85rem;
        }

        .flash-inner {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .7rem;
            padding: .8rem 1rem;
            border-radius: 11px;
            font-size: .8rem;
            font-weight: 500;
            opacity: 0;
            transform: translateY(4px);
            transition: opacity .3s, transform .3s;
        }

        .flash-inner button {
            opacity: .45;
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            font-size: 1rem;
            line-height: 1;
            flex-shrink: 0;
            padding: 0;
            transition: opacity .2s;
        }

        .flash-inner button:hover {
            opacity: 1;
        }

        .flash-success {
            background: rgba(20, 184, 166, .09);
            border: 1px solid rgba(20, 184, 166, .22);
            color: var(--teal-xl);
        }

        .flash-error {
            background: rgba(220, 38, 38, .08);
            border: 1px solid rgba(220, 38, 38, .2);
            color: #f87171;
        }

        .flash-warning {
            background: rgba(245, 158, 11, .08);
            border: 1px solid rgba(245, 158, 11, .2);
            color: #fbbf24;
        }

        .flash-info {
            background: rgba(96, 165, 250, .08);
            border: 1px solid rgba(96, 165, 250, .2);
            color: #93c5fd;
        }

        /* ── COMPONENTS ────────────────────────────────────────────── */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            backdrop-filter: blur(12px);
            transition: border-color .3s, transform .3s, box-shadow .3s;
        }

        .card-hover:hover {
            border-color: rgba(20, 184, 166, .3);
            transform: translateY(-3px);
            box-shadow: 0 10px 36px rgba(13, 148, 136, .12);
        }

        .badge {
            display: inline-block;
            padding: .2rem .75rem;
            border-radius: 999px;
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .28rem .85rem;
            border-radius: 999px;
            font-size: .66rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            background: rgba(20, 184, 166, .09);
            color: var(--teal-xl);
            border: 1px solid rgba(20, 184, 166, .22);
            margin-bottom: .8rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .65rem 1.5rem;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all .22s;
            white-space: nowrap;
            letter-spacing: -.005em;
            font-family: var(--font-body);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff;
            box-shadow: 0 0 24px rgba(13, 148, 136, .24);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 32px rgba(13, 148, 136, .4);
        }

        .btn-ghost {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border2);
        }

        .btn-ghost:hover {
            color: var(--teal-xl);
            border-color: rgba(20, 184, 166, .4);
            background: rgba(20, 184, 166, .06);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), #b8882a);
            color: #fff;
            box-shadow: 0 0 20px rgba(212, 168, 67, .2);
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 28px rgba(212, 168, 67, .34);
        }

        /* ── FORM ──────────────────────────────────────────────────── */
        .field {
            display: flex;
            flex-direction: column;
            gap: .4rem;
        }

        .field label {
            font-size: .76rem;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: .01em;
        }

        .input {
            width: 100%;
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: .62rem .95rem;
            font-size: .86rem;
            font-family: var(--font-body);
            color: var(--text);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .input::placeholder {
            color: var(--muted2);
        }

        .input:focus {
            border-color: rgba(20, 184, 166, .42);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .1);
        }

        .input-error {
            border-color: rgba(220, 38, 38, .4);
        }

        .error-msg {
            font-size: .72rem;
            color: #f87171;
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        /* ── TABLE ─────────────────────────────────────────────────── */
        .tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl thead th {
            padding: .8rem 1rem;
            font-size: .66rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .tbl tbody tr {
            border-bottom: 1px solid var(--border2);
            transition: background .15s;
        }

        .tbl tbody tr:hover {
            background: rgba(13, 148, 136, .035);
        }

        .tbl tbody td {
            padding: .8rem 1rem;
            font-size: .83rem;
        }

        .tbl tbody tr:last-child {
            border-bottom: none;
        }

        /* ── REVEAL ────────────────────────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .5s ease, transform .5s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: none;
        }

        .reveal-delay-1 {
            transition-delay: .1s;
        }

        .reveal-delay-2 {
            transition-delay: .18s;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border2);
            margin: 1.25rem 0;
        }

        /* ── MOBILE: card landing full-width ──────────────────────── */
        @media (max-width: 599px) {

            .search-card,
            .cd-card,
            .state-card,
            .hasil-wrap,
            .konfirmasi-wrap,
            .scan-wrap {
                max-width: 100% !important;
                border-radius: 14px;
            }

            .hero-section {
                padding: 3rem .5rem;
            }
        }

        /* ── FOOTER ────────────────────────────────────────────────── */
        footer.site-footer {
            border-top: 1px solid var(--border);
            padding: 1.75rem 2rem;
            text-align: center;
            font-size: .7rem;
            color: var(--muted2);
            position: relative;
            z-index: 1;
            letter-spacing: .01em;
        }

        /* ── PERSON MODAL ──────────────────────────────────────────── */
        .person-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 500;
            background: rgba(4, 10, 9, .78);
            backdrop-filter: blur(14px) saturate(140%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease;
        }

        .person-modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .person-modal {
            background: linear-gradient(145deg, #0c1a18, #091410);
            border: 1px solid rgba(20, 184, 166, .18);
            border-radius: 22px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, .55), 0 0 0 1px rgba(20, 184, 166, .07), inset 0 1px 0 rgba(94, 234, 212, .06);
            width: 100%;
            max-width: 400px;
            transform: translateY(22px) scale(.97);
            transition: transform .28s cubic-bezier(.22, 1, .36, 1), opacity .25s ease;
            overflow: hidden;
            position: relative;
        }

        .person-modal-overlay.open .person-modal {
            transform: translateY(0) scale(1);
        }

        .modal-close {
            position: absolute;
            top: .85rem;
            right: .85rem;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
            color: var(--muted);
            cursor: pointer;
            font-size: .85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            line-height: 1;
            padding: 0;
            font-family: var(--font-body);
            z-index: 2;
        }

        .modal-close:hover {
            background: rgba(220, 38, 38, .15);
            border-color: rgba(220, 38, 38, .3);
            color: #f87171;
        }

        /* Header strip */
        .modal-header-strip {
            height: 3px;
            background: linear-gradient(90deg, var(--teal), var(--gold-l), var(--teal-xl));
        }

        /* Avatar */
        .modal-avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1.5rem 1.25rem;
            gap: .75rem;
        }

        .modal-avatar-ring {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), var(--gold));
            padding: 2px;
            flex-shrink: 0;
        }

        .modal-avatar-inner {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-avatar-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-avatar-fallback {
            font-size: 2rem;
            font-weight: 800;
            font-family: var(--font-display);
            color: var(--teal-xl);
        }

        .modal-name {
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: -.025em;
            font-family: var(--font-display);
            text-align: center;
            line-height: 1.25;
        }

        .modal-role-badge {
            display: inline-flex;
            align-items: center;
            padding: .28rem .85rem;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .06em;
            background: rgba(20, 184, 166, .1);
            border: 1px solid rgba(20, 184, 166, .2);
            color: var(--teal-xl);
        }

        .modal-role-badge.gold {
            background: rgba(212, 168, 67, .1);
            border-color: rgba(212, 168, 67, .2);
            color: var(--gold-l);
        }

        /* Body rows */
        .modal-body {
            padding: 0 1.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: .35rem;
        }

        .modal-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: .55rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
        }

        .modal-row:last-child {
            border-bottom: none;
        }

        .modal-row-label {
            font-size: .7rem;
            color: var(--muted);
            font-weight: 500;
            flex-shrink: 0;
        }

        .modal-row-val {
            font-size: .82rem;
            font-weight: 600;
            text-align: right;
            word-break: break-all;
        }

        .modal-row-mono {
            font-family: monospace;
            font-size: .8rem;
            color: var(--teal-xl);
        }

        .modal-quote {
            margin: .25rem 0 .5rem;
            padding: .75rem 1rem;
            border-left: 2px solid rgba(20, 184, 166, .3);
            font-size: .78rem;
            font-style: italic;
            color: var(--muted);
            line-height: 1.65;
            border-radius: 0 8px 8px 0;
            background: rgba(20, 184, 166, .03);
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border2);
            display: flex;
            gap: .5rem;
        }

        .modal-footer .btn {
            flex: 1;
            justify-content: center;
            font-size: .78rem;
            padding: .58rem;
        }

        /* Cursor on clickable cards */
        .person-card.clickable {
            cursor: pointer;
        }

        /* ── RESPONSIVE ────────────────────────────────────────────── */
        @media (max-width: 960px) {
            .nav-links {
                display: none !important;
            }

            #menuBtn {
                display: flex !important;
            }
        }

        /* Sembunyikan tombol Beranda di smartphone */
        @media (max-width: 768px) {
            .n-btn-primary.nav-home-btn {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            :root {
                --nav-h: 54px;
            }

            .content-wrap {
                padding: 1.75rem .65rem;
            }

            .nav-name {
                max-width: none;
                overflow: visible;
                text-overflow: unset;
                white-space: normal;
                line-height: 1.2;
                font-size: .72rem;
            }

            .people-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: .65rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: .75rem;
            }

            .search-form {
                width: 100%;
            }

            .search-field-wrap {
                flex: 1;
            }

            .search-field-input {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .tamu-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .tamu-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .doc-wrap {
                padding: 0 .25rem;
            }

            .doc-card .doc-body {
                padding: 1.1rem 1.2rem 1.5rem;
            }

            .kop-surat {
                padding: 1.25rem 1.2rem 1rem;
                gap: .65rem;
            }

            .kop-surat img {
                height: 52px;
                width: 52px;
            }

            .hasil-wrap {
                max-width: 100%;
            }

            .result-header,
            .result-info,
            .result-actions {
                padding-left: 1.1rem;
                padding-right: 1.1rem;
            }

            .tamu-table-wrap {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .tamu-tbl {
                min-width: 500px;
            }
        }

        @media (max-width: 540px) {
            :root {
                --nav-h: 50px;
            }

            .content-wrap {
                padding: 1.5rem .5rem;
            }

            .nav-sub {
                display: none;
            }

            .nav-name {
                font-size: .68rem;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .search-card {
                padding: 1.25rem 1rem;
            }

            .konfirmasi-wrap {
                max-width: 100%;
            }

            .scan-wrap {
                max-width: 100%;
            }

            .doc-toolbar {
                flex-direction: column;
                align-items: flex-start;
                gap: .5rem;
            }

            /* Modal full-width on small screens */
            .person-modal {
                max-width: 100%;
                border-radius: 18px 18px 0 0;
            }

            .person-modal-overlay {
                align-items: flex-end;
                padding: 0;
            }
        }

        @media print {

            .orb,
            .grid-bg,
            nav#mainNav,
            .drawer,
            .flash-area,
            footer.site-footer {
                display: none !important;
            }

            .page-wrap {
                padding-top: 0;
            }

            .content-wrap {
                padding: 0;
                max-width: 100%;
            }

            body {
                background: #fff;
                color: #000;
            }
        }
    </style>

    {{-- PWA --}}
    <meta name="theme-color" content="#0d9488">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $instansi?->nama ?? 'SKL' }}">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/favicon.ico">

    @stack('styles')
</head>

<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="grid-bg"></div>

    @php
        $navTp = $tahunPelajaran ?? null;
        $tampilTamu = $navTp && $navTp->isKelulusanAktif();
    @endphp

    {{-- ── NAVBAR ───────────────────────────────────────────────── --}}
    <nav id="mainNav">
        <a href="{{ route('landing') }}" class="nav-brand">
            <div class="nav-logo">
                <img src="/favicon.ico" alt="Logo"
                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <span class="nav-logo-fallback" style="display:none;">SKL</span>
            </div>
            <div class="nav-brand-text">
                <div class="nav-name">{{ $instansi?->nama ?? config('app.name') }}</div>
                <div class="nav-sub">Layanan Kelulusan Digital</div>
            </div>
        </a>

        {{-- Center links (hidden ≤960px) --}}
        <ul class="nav-links">
            <li>
                <a href="{{ route('personil.index') }}" class="{{ request()->routeIs('personil*') ? 'active' : '' }}">
                    Personil
                </a>
            </li>
            <li>
                <a href="{{ route('alumni.index') }}" class="{{ request()->routeIs('alumni*') ? 'active' : '' }}">
                    Alumni
                </a>
            </li>
            @if ($tampilTamu)
                <li>
                    <a href="{{ route('tamu.index') }}"
                        class="nav-tamu {{ request()->routeIs('tamu*') ? 'active' : '' }}">
                        Tamu Undangan
                    </a>
                </li>
            @endif
        </ul>

        <div class="nav-right">
            {{-- Hamburger --}}
            <button id="menuBtn" aria-label="Menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            <a href="{{ route('landing') }}" class="n-btn n-btn-primary nav-home-btn">Beranda</a>
        </div>
    </nav>

    {{-- ── MOBILE DRAWER ───────────────────────────────────────── --}}
    <div class="drawer" id="drawer" aria-hidden="true">
        <a href="{{ route('landing') }}" class="{{ request()->routeIs('landing') ? 'active' : '' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            Beranda
        </a>
        <div class="drawer-divider"></div>
        <a href="{{ route('personil.index') }}" class="{{ request()->routeIs('personil*') ? 'active' : '' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
            Personil
        </a>
        <a href="{{ route('alumni.index') }}" class="{{ request()->routeIs('alumni*') ? 'active' : '' }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                <path d="M6 12v5c3 3 9 3 12 0v-5" />
            </svg>
            Alumni
        </a>
        @if ($tampilTamu)
            <div class="drawer-divider"></div>
            <a href="{{ route('tamu.index') }}" class="drawer-tamu {{ request()->routeIs('tamu*') ? 'active' : '' }}">
                Tamu Undangan
            </a>
        @endif
    </div>

    {{-- ── PERSON MODAL ─────────────────────────────────────────── --}}
    <div class="person-modal-overlay" id="personModal" role="dialog" aria-modal="true" aria-labelledby="modalName">
        <div class="person-modal" id="personModalBox">
            <div class="modal-header-strip"></div>
            <button class="modal-close" id="modalClose" aria-label="Tutup">&times;</button>

            <div class="modal-avatar-section">
                <div class="modal-avatar-ring">
                    <div class="modal-avatar-inner" id="modalAvatarInner">
                        <span class="modal-avatar-fallback" id="modalAvatarFallback">?</span>
                    </div>
                </div>
                <div class="modal-name" id="modalName">—</div>
                <div class="modal-role-badge" id="modalBadge">—</div>
            </div>

            <div class="modal-body" id="modalBody"></div>

            <div class="modal-footer" id="modalFooter" style="display:none;"></div>
        </div>
    </div>

    {{-- ── PAGE ─────────────────────────────────────────────────── --}}
    <div class="page-wrap">
        <div class="flash-area">
            @foreach (['success', 'error', 'warning', 'info'] as $type)
                @if (session($type))
                    <div class="flash-msg" data-type="{{ $type }}">
                        <div class="flash-inner flash-{{ $type }}">
                            <span>{{ session($type) }}</span>
                            <button onclick="this.closest('.flash-msg').remove()" aria-label="Tutup">&times;</button>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <main class="content-wrap">@yield('content')</main>

        <footer class="site-footer">
            &copy; {{ date('Y') }} {{ $instansi?->nama ?? config('app.name') }}
            &nbsp;&middot;&nbsp; Layanan Kelulusan Digital
        </footer>
    </div>

    <script>
        (() => {
            /* ── Nav scroll ─────────────────────────────── */
            const nav = document.getElementById('mainNav');
            window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 40), {
                passive: true
            });

            /* ── Drawer toggle ──────────────────────────── */
            const menuBtn = document.getElementById('menuBtn');
            const drawer = document.getElementById('drawer');

            function toggleDrawer(force) {
                const open = typeof force === 'boolean' ? force : !drawer.classList.contains('open');
                drawer.classList.toggle('open', open);
                menuBtn.classList.toggle('open', open);
                menuBtn.setAttribute('aria-expanded', open);
                drawer.setAttribute('aria-hidden', !open);
            }

            menuBtn.addEventListener('click', e => {
                e.stopPropagation();
                toggleDrawer();
            });
            [...drawer.querySelectorAll('a')].forEach(a => a.addEventListener('click', () => toggleDrawer(false)));
            document.addEventListener('click', e => {
                if (!drawer.contains(e.target) && !menuBtn.contains(e.target)) toggleDrawer(false);
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') toggleDrawer(false);
            });

            /* ── Flash messages ─────────────────────────── */
            document.querySelectorAll('.flash-msg .flash-inner').forEach(el => {
                requestAnimationFrame(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'none';
                });
                setTimeout(() => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-4px)';
                    setTimeout(() => el.closest('.flash-msg')?.remove(), 300);
                }, 4200);
            });

            /* ── Reveal on scroll ───────────────────────── */
            const revealObs = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('visible');
                        revealObs.unobserve(e.target);
                    }
                });
            }, {
                threshold: .1,
                rootMargin: '0px 0px -36px 0px'
            });
            document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

            /* ── Person Modal ───────────────────────────── */
            const overlay = document.getElementById('personModal');
            const modalBox = document.getElementById('personModalBox');
            const modalClose = document.getElementById('modalClose');

            function openPersonModal(data) {
                /* Avatar */
                const inner = document.getElementById('modalAvatarInner');
                const fb = document.getElementById('modalAvatarFallback');
                inner.innerHTML = '';
                if (data.photo) {
                    const img = document.createElement('img');
                    img.src = data.photo;
                    img.alt = data.nama;
                    inner.appendChild(img);
                } else {
                    fb.textContent = (data.nama || '?').trim().charAt(0).toUpperCase();
                    inner.appendChild(fb);
                }

                /* Name & badge */
                document.getElementById('modalName').textContent = data.nama || '—';
                const badge = document.getElementById('modalBadge');
                badge.textContent = data.badge || '—';
                badge.className = 'modal-role-badge' + (data.badgeGold ? ' gold' : '');

                /* Body rows */
                const body = document.getElementById('modalBody');
                body.innerHTML = '';

                if (data.quote) {
                    const q = document.createElement('blockquote');
                    q.className = 'modal-quote';
                    q.textContent = '\u201C' + data.quote + '\u201D';
                    body.appendChild(q);
                }

                (data.rows || []).forEach(([label, val, mono]) => {
                    if (!val) return;
                    const row = document.createElement('div');
                    row.className = 'modal-row';
                    const lbl = document.createElement('span');
                    lbl.className = 'modal-row-label';
                    lbl.textContent = label;
                    const valEl = document.createElement('span');
                    valEl.className = 'modal-row-val' + (mono ? ' modal-row-mono' : '');
                    valEl.textContent = val;
                    row.appendChild(lbl);
                    row.appendChild(valEl);
                    body.appendChild(row);
                });

                /* Footer / social */
                const footer = document.getElementById('modalFooter');
                footer.innerHTML = '';
                if (data.sosial) {
                    footer.style.display = 'flex';
                    const a = document.createElement('a');
                    a.href = data.sosial;
                    a.target = '_blank';
                    a.rel = 'noopener';
                    a.className = 'btn btn-ghost';
                    a.textContent = '🔗 Sosial Media';
                    footer.appendChild(a);
                } else {
                    footer.style.display = 'none';
                }

                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
                setTimeout(() => modalClose.focus(), 50);
            }

            function closeModal() {
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            }

            modalClose.addEventListener('click', closeModal);
            overlay.addEventListener('click', e => {
                if (e.target === overlay) closeModal();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal();
            });

            /* Attach to all person cards */
            function bindPersonCards() {
                document.querySelectorAll('.person-card[data-person]').forEach(card => {
                    if (card._modalBound) return;
                    card._modalBound = true;
                    card.classList.add('clickable');
                    card.setAttribute('role', 'button');
                    card.setAttribute('tabindex', '0');
                    card.addEventListener('click', () => openPersonModal(JSON.parse(card.dataset.person)));
                    card.addEventListener('keydown', e => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            openPersonModal(JSON.parse(card.dataset.person));
                        }
                    });
                });
            }
            bindPersonCards();

            /* Re-bind after any dynamic DOM mutation (pagination) */
            new MutationObserver(bindPersonCards).observe(document.body, {
                childList: true,
                subtree: true
            });

            /* Expose globally */
            window.openPersonModal = openPersonModal;
        })();
    </script>

    {{-- PWA Service Worker --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .catch(e => console.warn('SW error:', e));
            });
        }
    </script>
    @stack('scripts')
</body>

</html>

```

---

### 📄 File: `./resources/views/partials/_doc-styles.blade.php`

```blade
<style>
    .doc-wrap {
        max-width: 680px;
        margin: 0 auto
    }

    .doc-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        gap: .75rem;
        flex-wrap: wrap
    }

    .doc-back {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        font-size: .8rem;
        color: var(--muted);
        text-decoration: none;
        transition: color .2s
    }

    .doc-back:hover {
        color: var(--teal-xl)
    }

    .doc-back span {
        transition: transform .2s
    }

    .doc-back:hover span {
        transform: translateX(-2px)
    }

    .doc-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 24px rgba(0, 0, 0, .12);
        border: 1px solid rgba(0, 0, 0, .06);
        overflow: hidden;
        color: #1a1a1a
    }

    .kop-surat {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.75rem 2rem 1.25rem;
        border-bottom: 3px double #1a1a1a
    }

    .kop-surat img {
        height: 72px;
        width: 72px;
        object-fit: contain;
        flex-shrink: 0
    }

    .kop-text {
        flex: 1;
        text-align: center
    }

    .kop-text h1 {
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #111;
        font-family: 'Times New Roman', serif
    }

    .kop-text p {
        font-size: .7rem;
        color: #666;
        margin-top: .2rem
    }

    .doc-body {
        padding: 1.5rem 2rem 2rem;
        font-family: 'Times New Roman', Georgia, serif;
        font-size: .82rem;
        line-height: 1.75;
        color: #1a1a1a
    }

    .doc-title {
        text-align: center;
        font-size: .94rem;
        font-weight: 700;
        text-decoration: underline;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin: .5rem 0 1.25rem
    }

    .doc-meta {
        border-collapse: collapse;
        margin-bottom: 1rem;
        font-size: .8rem
    }

    .doc-meta td {
        padding: 2px 4px 2px 0;
        vertical-align: top
    }

    .doc-meta .lbl {
        width: 5rem;
        color: #666;
        white-space: nowrap
    }

    .doc-meta .sep {
        width: .5rem
    }

    .doc-data {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
        font-size: .8rem
    }

    .doc-data td {
        padding: 3px 4px 3px 0;
        vertical-align: top
    }

    .doc-data .lbl {
        width: 9rem;
        color: #666
    }

    .doc-data .sep {
        width: .5rem
    }

    .doc-data .val {
        font-weight: 600
    }

    .doc-para {
        text-indent: 2rem;
        margin-bottom: .75rem;
        text-align: justify
    }

    .ttd-block {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem
    }

    .ttd-inner {
        text-align: center;
        width: 11rem;
        font-size: .8rem
    }

    .ttd-inner img {
        height: 60px;
        margin: .5rem auto;
        display: block;
        object-fit: contain
    }

    .ttd-space {
        height: 60px
    }

    .ttd-nama {
        font-weight: 700;
        text-decoration: underline
    }

    .ttd-nip {
        font-size: .72rem;
        color: #555;
        margin-top: .15rem
    }

    .doc-note {
        text-align: center;
        font-size: .7rem;
        color: var(--muted2);
        margin-top: .85rem
    }

    .doc-jadwal {
        border-collapse: collapse;
        margin: .25rem 0 1rem 2rem;
        font-size: .8rem
    }

    .doc-jadwal td {
        padding: 3px 4px 3px 0;
        vertical-align: top
    }

    .doc-jadwal .lbl {
        width: 7rem;
        color: #666
    }

    .qr-block {
        margin-top: 1.25rem;
        padding-top: 1rem;
        border-top: 1px dashed #d1d5db;
        text-align: center
    }

    .qr-block img {
        width: 84px;
        height: 84px;
        object-fit: contain;
        margin: 0 auto
    }

    .qr-block p {
        font-size: .68rem;
        color: #9ca3af;
        margin-top: .3rem
    }

    .doc-alert {
        padding: .65rem .85rem;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 8px;
        color: #92400e;
        font-size: .75rem;
        margin: .5rem 0 1rem 2rem
    }
</style>

```

---

### 📄 File: `./resources/views/partials/_page-header.blade.php`

```blade
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $title }}</h1>
        @if (isset($keyword) && isset($totalFound))
            <p class="page-meta">
                Hasil untuk <strong>&ldquo;{{ $keyword }}&rdquo;</strong>
                &mdash; {{ $totalFound }} data ditemukan
            </p>
        @endif
    </div>

    <form action="{{ route($searchRoute) }}" method="GET" class="search-form">
        <div class="search-field-wrap">
            <input type="text" name="nama" value="{{ request('nama', $keyword ?? '') }}"
                placeholder="{{ $placeholder ?? 'Cari nama' }}" class="search-field-input">
        </div>
        <button type="submit" class="search-btn">Cari</button>
        @if (isset($keyword))
            <a href="{{ route($clearRoute) }}" class="clear-btn" aria-label="Hapus pencarian">&times;</a>
        @endif
    </form>
</div>

```

---

### 📄 File: `./resources/views/partials/_people-grid.blade.php`

```blade
@php
    $isEmpty = method_exists($items, 'isEmpty') ? $items->isEmpty() : $items->count() === 0;
@endphp

@if ($isEmpty)
    <div class="empty-state">
        <p class="empty-title">
            Tidak ada data{{ isset($keyword) ? ' untuk &ldquo;' . e($keyword) . '&rdquo;' : '' }}.
        </p>
        @isset($keyword)
            <a href="{{ url()->current() }}" class="empty-link">Lihat semua &rarr;</a>
        @endisset
    </div>
@else
    <div class="people-grid">
        @foreach ($items as $p)
            @php
                $photo = $p->{$photoKey} ?? null;
                $photoUrl = $photo ? Storage::url($photo) : null;

                /*
                 * Tentukan badge & baris data berdasarkan konteks:
                 *  - alumni  : subKey = tahun_lulus, monoKey = nisn
                 *  - personil: subKey = jabatan
                 */
                $isAlumni = isset($monoKey) && $monoKey === 'nisn';
                $badgeLabel = $isAlumni ? ($subPrefix ?? '') . ($p->{$subKey} ?? '') : $p->{$subKey} ?? '';

                $rows = [];
                if (!$isAlumni && ($p->{$subKey} ?? null)) {
                    $rows[] = ['Jabatan', $p->{$subKey}, false];
                }
                if (!empty($monoKey) && ($p->{$monoKey} ?? null)) {
                    $rows[] = [$isAlumni ? 'NISN' : 'ID', $p->{$monoKey}, true];
                }
                if ($isAlumni && ($p->nama_orangtua ?? null)) {
                    $rows[] = ['Nama Orang Tua', $p->nama_orangtua, false];
                }

                $personData = json_encode(
                    [
                        'nama' => $p->nama,
                        'photo' => $photoUrl,
                        'badge' => $badgeLabel,
                        'badgeGold' => $isAlumni,
                        'quote' => $p->quote ?? null,
                        'sosial' => $p->sosial_media ?? null,
                        'rows' => $rows,
                    ],
                    JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT,
                );
            @endphp

            <div class="card card-hover person-card reveal" data-person="{{ $personData }}"
                title="Lihat detail {{ $p->nama }}">

                <div class="avatar-wrap">
                    @if ($photoUrl)
                        <img src="{{ $photoUrl }}" alt="{{ $p->nama }}" class="avatar-img">
                    @else
                        <div class="avatar-fallback">{{ strtoupper(mb_substr($p->nama, 0, 1)) }}</div>
                    @endif
                </div>

                <div class="person-name">{{ $p->nama }}</div>

                <div class="person-sub" @isset($subColor) style="color:{{ $subColor }}" @endisset>
                    {{ $subPrefix ?? '' }}{{ $p->{$subKey} ?? '' }}
                </div>

                @if (!empty($monoKey) && ($p->{$monoKey} ?? null))
                    <div class="person-mono">{{ $p->{$monoKey} }}</div>
                @endif

                @if ($p->quote ?? null)
                    <div class="person-quote">&ldquo;{{ $p->quote }}&rdquo;</div>
                @endif

                {{-- Tanda klik --}}
                <div class="person-hint">Lihat detail &rsaquo;</div>

            </div>
        @endforeach
    </div>

    @if (method_exists($items, 'links'))
        <div class="pagination-wrap">{{ $items->links() }}</div>
    @endif
@endif

```

---

### 📄 File: `./resources/views/partials/_people-styles.blade.php`

```blade
<style>
    /* ── Page Header ──────────────────────────────────────────── */
    .page-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -.03em;
        font-family: var(--font-display);
    }

    .page-meta {
        font-size: .76rem;
        color: var(--muted);
        margin-top: .25rem;
    }

    .page-meta strong {
        color: var(--text);
    }

    /* ── Search Form ──────────────────────────────────────────── */
    .search-form {
        display: flex;
        gap: .45rem;
        align-items: center;
    }

    .search-field-wrap {
        position: relative;
    }

    .search-field-input {
        background: var(--card2);
        border: 1px solid var(--border);
        border-radius: 9px;
        padding: .52rem .9rem;
        font-size: .8rem;
        font-family: var(--font-body);
        color: var(--text);
        width: 14rem;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .search-field-input::placeholder {
        color: var(--muted2);
    }

    .search-field-input:focus {
        border-color: rgba(20, 184, 166, .42);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, .1);
    }

    .search-btn {
        background: linear-gradient(135deg, var(--teal), var(--teal-d));
        color: #fff;
        border: none;
        border-radius: 9px;
        padding: .52rem 1rem;
        font-size: .8rem;
        font-weight: 700;
        font-family: var(--font-body);
        cursor: pointer;
        transition: all .2s;
        box-shadow: 0 0 14px rgba(13, 148, 136, .18);
    }

    .search-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 18px rgba(13, 148, 136, .32);
    }

    .clear-btn {
        background: var(--card2);
        border: 1px solid var(--border);
        border-radius: 9px;
        padding: .52rem .65rem;
        font-size: .8rem;
        color: var(--muted);
        cursor: pointer;
        font-family: var(--font-body);
        transition: all .2s;
        text-decoration: none;
        display: flex;
        align-items: center;
        line-height: 1;
    }

    .clear-btn:hover {
        border-color: rgba(20, 184, 166, .32);
        color: var(--teal-xl);
    }

    /* ── Empty State ──────────────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-title {
        font-size: .86rem;
        color: var(--muted);
        margin-bottom: .65rem;
    }

    .empty-link {
        font-size: .76rem;
        color: var(--teal-xl);
        text-decoration: none;
    }

    .empty-link:hover {
        text-decoration: underline;
    }

    /* ── People Grid ──────────────────────────────────────────── */
    .people-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(160px, 100%), 1fr));
        gap: 1rem;
    }

    /* ── Person Card ──────────────────────────────────────────── */
    .person-card {
        padding: clamp(.85rem, 3vw, 1.4rem) clamp(.65rem, 2.5vw, .9rem) clamp(.75rem, 2.5vw, 1rem);
        text-align: center;
        border-radius: var(--radius);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .12rem;
        position: relative;
        overflow: hidden;
    }

    /* Subtle teal glow on hover */
    .person-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: radial-gradient(ellipse at 50% 0%, rgba(20, 184, 166, .08), transparent 70%);
        opacity: 0;
        transition: opacity .3s;
        pointer-events: none;
    }

    .person-card:hover::before {
        opacity: 1;
    }

    /* Avatar — ukuran fluid berdasarkan lebar container */
    .avatar-wrap {
        width: clamp(48px, 12vw, 68px);
        height: clamp(48px, 12vw, 68px);
        border-radius: 50%;
        margin-bottom: clamp(.5rem, 1.5vw, .8rem);
        flex-shrink: 0;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 1.5px solid var(--border);
    }

    .avatar-fallback {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: clamp(.9rem, 3vw, 1.25rem);
        font-family: var(--font-display);
        border: 1.5px solid var(--border);
        background: rgba(20, 184, 166, .08);
        color: var(--teal-xl);
    }

    .person-name {
        font-size: clamp(.75rem, 2.2vw, .88rem);
        font-weight: 700;
        line-height: 1.25;
        font-family: var(--font-display);
    }

    .person-sub {
        font-size: clamp(.63rem, 1.8vw, .72rem);
        color: var(--muted);
        margin-top: .12rem;
    }

    .person-mono {
        font-size: clamp(.58rem, 1.6vw, .67rem);
        font-family: monospace;
        color: var(--muted2);
        margin-top: .08rem;
        letter-spacing: .03em;
    }

    .person-quote {
        font-size: clamp(.63rem, 1.7vw, .7rem);
        color: var(--muted);
        font-style: italic;
        margin-top: .45rem;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* "Lihat detail" hint */
    .person-hint {
        font-size: clamp(.55rem, 1.5vw, .62rem);
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--teal-xl);
        margin-top: .5rem;
        opacity: 0;
        transition: opacity .2s, transform .2s;
        transform: translateY(4px);
    }

    .person-card:hover .person-hint,
    .person-card:focus .person-hint {
        opacity: .8;
        transform: translateY(0);
    }

    /* Focus ring */
    .person-card:focus-visible {
        outline: 2px solid rgba(20, 184, 166, .55);
        outline-offset: 2px;
    }

    /* ── Responsive overrides ─────────────────────────────────── */

    /* Laptop / tablet lebar — 4–5 kolom nyaman */
    @media (min-width: 900px) {
        .people-grid {
            grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
            gap: 1.1rem;
        }
    }

    /* Tablet portrait — 3 kolom */
    @media (max-width: 899px) and (min-width: 600px) {
        .people-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: .85rem;
        }
    }

    /* Smartphone landscape / kecil — 2 kolom */
    @media (max-width: 599px) {
        .people-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: .65rem;
        }

        /* Card lebih compact di hp */
        .person-card {
            padding: .9rem .6rem .75rem;
        }

        .avatar-wrap {
            width: 52px;
            height: 52px;
            margin-bottom: .55rem;
        }

        .person-name {
            font-size: .78rem;
        }

        .person-sub {
            font-size: .65rem;
        }

        .person-mono {
            font-size: .6rem;
        }

        /* Hint selalu visible di touch (tidak ada hover) */
        .person-hint {
            opacity: .55;
            transform: none;
            font-size: .55rem;
        }
    }

    /* HP kecil ≤360px — tetap 2 kolom tapi lebih compact */
    @media (max-width: 360px) {
        .people-grid {
            gap: .5rem;
        }

        .person-card {
            padding: .8rem .5rem .65rem;
        }

        .avatar-wrap {
            width: 44px;
            height: 44px;
        }

        .person-name {
            font-size: .72rem;
        }
    }

    /* ── Pagination ───────────────────────────────────────────── */
    .pagination-wrap {
        margin-top: 1.75rem;
    }
</style>

```

---

### 📄 File: `./resources/views/pdf/undangan.blade.php`

```blade
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Undangan - {{ $siswa->nama }}</title>
    @include('pdf._base-styles')
    <style>
        table.jadwal {
            margin: 4px 0 16px 1.5cm;
            font-size: 11pt;
        }

        table.jadwal td {
            padding: 3px 6px 3px 0;
            vertical-align: top;
        }

        table.jadwal td.lbl {
            width: 4.5cm;
            color: #555;
        }
    </style>
</head>

<body>
    <x-kop-surat :for-pdf="true" />

    <table class="nomor">
        <tr>
            <td class="lbl">Nomor</td>
            <td class="sep">:</td>
            <td>{{ $instansi->nomor_surat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="lbl">Hal</td>
            <td class="sep">:</td>
            <td>Undangan Wisuda &amp; Pengambilan Ijazah</td>
        </tr>
    </table>

    <h2 class="judul">Surat Undangan</h2>

    <div class="isi">
        <p>Assalamu'alaikum Warahmatullahi Wabarakatuh.</p>
        <p>
            Dengan hormat, kami mengundang Bapak/Ibu
            <b>{{ $siswa->nama_orangtua ?? 'Orang Tua/Wali' }}</b>
            beserta putra/putri atas nama <b>{{ $siswa->nama }}</b>
            (NISN: {{ $siswa->nisn }}) untuk menghadiri acara Wisuda &amp; Pengambilan Ijazah
            yang akan dilaksanakan pada:
        </p>
    </div>

    @php
        $tp = $tahunPelajaran;
        $adaJadwal = $tp->jadwal_kelulusan_mulai && $tp->jadwal_kelulusan_selesai && $tp->jadwal_kelulusan_tempat;
    @endphp

    @if ($adaJadwal)
        <table class="jadwal">
            <tr>
                <td class="lbl">Hari / Tanggal</td>
                <td>:</td>
                <td>{{ $tp->jadwal_kelulusan_mulai->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td class="lbl">Waktu</td>
                <td>:</td>
                <td>{{ $tp->jadwal_kelulusan_mulai->format('H:i') }} &ndash;
                    {{ $tp->jadwal_kelulusan_selesai->format('H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="lbl">Tempat</td>
                <td>:</td>
                <td>{{ $tp->jadwal_kelulusan_tempat }}</td>
            </tr>
        </table>
    @endif

    <div class="isi">
        <p>Demikian undangan ini kami sampaikan. Atas kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>
        <p>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
    </div>

    <x-ttd :for-pdf="true" />

    <div class="qr-box">
        <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(120)->generate($siswa->id)) }}"
            alt="QR Code">
        <p>Scan QR ini saat registrasi kehadiran &bull; NISN: {{ $siswa->nisn }}</p>
    </div>
</body>

</html>

```

---

### 📄 File: `./resources/views/pdf/_base-styles.blade.php`

```blade
<style>
    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12pt;
        color: #1a1a1a;
        padding: 1.5cm 2cm 2cm;
        line-height: 1.65;
    }

    /* ── KOP ──────────────────────────────────────────────────── */
    .kop-surat {
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 4px double #1a1a1a;
        padding-bottom: 10px;
        margin-bottom: 18px;
    }

    .kop-surat img {
        height: 80px;
        width: 80px;
        object-fit: contain;
    }

    .kop-text {
        flex: 1;
        text-align: center;
    }

    .kop-text h1 {
        font-size: 15pt;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .kop-text p {
        font-size: 10pt;
        color: #444;
        margin-top: 2px;
    }

    /* ── JUDUL ────────────────────────────────────────────────── */
    h2.judul {
        text-align: center;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 18px 0 20px;
    }

    /* ── NOMOR / META ─────────────────────────────────────────── */
    table.nomor {
        margin-bottom: 16px;
        font-size: 11pt;
    }

    table.nomor td {
        padding: 2px 6px 2px 0;
        vertical-align: top;
    }

    table.nomor td.lbl {
        width: 5cm;
        color: #555;
    }

    table.nomor td.sep {
        width: .3cm;
    }

    /* ── DATA SISWA ───────────────────────────────────────────── */
    table.data {
        width: 100%;
        margin-bottom: 16px;
        font-size: 11pt;
        border-collapse: collapse;
    }

    table.data td {
        padding: 3px 6px 3px 0;
        vertical-align: top;
    }

    table.data td.lbl {
        width: 5.5cm;
        color: #555;
    }

    table.data td.sep {
        width: .3cm;
    }

    table.data td.val {
        font-weight: bold;
    }

    /* ── ISI ──────────────────────────────────────────────────── */
    .isi p {
        text-indent: 1.5cm;
        margin-bottom: 10px;
        text-align: justify;
    }

    /* ── TTD ──────────────────────────────────────────────────── */
    .ttd-block {
        display: flex;
        justify-content: flex-end;
        margin-top: 32px;
    }

    .ttd-inner {
        text-align: center;
        width: 7cm;
        font-size: 11pt;
    }

    .ttd-inner img {
        height: 72px;
        margin: 6px auto;
        display: block;
        object-fit: contain;
    }

    .ttd-inner .ttd-space {
        height: 72px;
    }

    .ttd-inner .ttd-nama {
        font-weight: bold;
        text-decoration: underline;
    }

    .ttd-inner .ttd-nip {
        font-size: 10pt;
        color: #444;
    }

    /* ── QR ───────────────────────────────────────────────────── */
    .qr-box {
        margin-top: 28px;
        text-align: center;
        border-top: 1px dashed #ccc;
        padding-top: 14px;
    }

    .qr-box img {
        width: 90px;
        height: 90px;
    }

    .qr-box p {
        font-size: 9pt;
        color: #666;
        margin-top: 4px;
    }
</style>

```

---

### 📄 File: `./resources/views/personil/index.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Personil')

@push('styles')
    @include('partials._people-styles')
    <style>
        .group-section {
            margin-bottom: 2.5rem;
        }

        .group-heading {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.1rem;
        }

        .group-heading-label {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--teal-xl);
            white-space: nowrap;
        }

        .group-heading-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .group-heading-count {
            font-size: .62rem;
            font-weight: 600;
            color: var(--muted2);
            white-space: nowrap;
        }

        /* Desktop: center dengan auto-fit */
        .group-section .people-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(160px, 100%), 175px));
            justify-content: center;
            gap: 1rem;
        }

        /* Tablet portrait */
        @media (max-width: 899px) and (min-width: 600px) {
            .group-section .people-grid {
                grid-template-columns: repeat(3, 1fr);
                justify-content: normal;
            }
        }

        /* Mobile: 2 kolom simetris — spesifisitas dinaikkan untuk override _people-styles */
        @media (max-width: 599px) {
            .group-section .people-grid.people-grid {
                grid-template-columns: repeat(2, 1fr);
                justify-content: normal;
                gap: .65rem;
            }
        }
    </style>
@endpush

@section('content')
    @include('partials._page-header', [
        'title' => 'Personil',
        'searchRoute' => 'personil.cari',
        'clearRoute' => 'personil.index',
        'placeholder' => 'Cari nama',
        'keyword' => $keyword ?? null,
        'totalFound' => $items->count() ?? null,
    ])

    @php
        $groupOrder = [
            'Kepala Madrasah',
            'Wakil Kepala Madrasah',
            'Guru',
            'Kepala Tata Usaha',
            'Bendahara',
            'Staf Tata Usaha',
            'Outsourcing',
            'Komite Madrasah',
        ];

        $grouped = $items->groupBy('jabatan');

        $ordered = collect();
        foreach ($groupOrder as $jabatan) {
            if ($grouped->has($jabatan) && $grouped[$jabatan]->isNotEmpty()) {
                $ordered->put($jabatan, $grouped[$jabatan]);
            }
        }

        $lainnya = collect();
        foreach ($grouped as $jabatan => $anggota) {
            if (!in_array($jabatan, $groupOrder)) {
                $lainnya = $lainnya->merge($anggota);
            }
        }
        if ($lainnya->isNotEmpty()) {
            $ordered->put('Lainnya', $lainnya);
        }
    @endphp

    @if ($items->isEmpty())
        @include('partials._people-grid', [
            'items' => $items,
            'photoKey' => 'foto',
            'subKey' => 'jabatan',
            'subColor' => 'var(--teal-xl)',
            'keyword' => $keyword ?? null,
        ])
    @else
        @foreach ($ordered as $jabatan => $anggota)
            @if ($anggota->isEmpty())
                @continue
            @endif

            <div class="group-section">
                <div class="group-heading">
                    <span class="group-heading-label">{{ $jabatan }}</span>
                    <span class="group-heading-line"></span>
                    <span class="group-heading-count">{{ $anggota->count() }} orang</span>
                </div>

                @include('partials._people-grid', [
                    'items' => $anggota,
                    'photoKey' => 'foto',
                    'subKey' => 'jabatan',
                    'subColor' => 'var(--teal-xl)',
                    'keyword' => $keyword ?? null,
                ])
            </div>
        @endforeach
    @endif
@endsection

```

---

### 📄 File: `./resources/views/tamu/cetak-hadir.blade.php`

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir Tamu Undangan</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            color: #1a1a1a;
            padding: 1.5cm 2cm;
            line-height: 1.6;
        }
        .kop {
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 4px double #1a1a1a;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }
        .kop img { height: 70px; width: 70px; object-fit: contain; }
        .kop-text { flex: 1; text-align: center; }
        .kop-text h1 { font-size: 14pt; font-weight: bold; text-transform: uppercase; letter-spacing: .4px; }
        .kop-text p { font-size: 10pt; color: #444; margin-top: 2px; }
        h2.judul {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 16px 0 4px;
        }
        .sub-judul { text-align: center; font-size: 10pt; color: #555; margin-bottom: 16px; }
        table.daftar {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        table.daftar th {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            text-align: left;
            font-weight: bold;
        }
        table.daftar td {
            border: 1px solid #d1d5db;
            padding: 5px 8px;
            vertical-align: top;
        }
        table.daftar tr:nth-child(even) td { background: #fafafa; }
        .ttd-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 28px;
        }
        .ttd-box { text-align: center; width: 6.5cm; font-size: 10pt; }
        .ttd-box .ttd-space { height: 60px; }
        .ttd-box .nama { font-weight: bold; text-decoration: underline; }
        .ttd-box .nip { font-size: 9pt; color: #444; }
        .summary { margin: 0 0 14px; font-size: 10pt; color: #444; }
        .no-print { text-align: center; padding: 1rem; }
        .no-print button {
            padding: .5rem 1.5rem; background: #0d9488; color: #fff;
            border: none; border-radius: 6px; font-size: 1rem; cursor: pointer;
        }
        @media print {
            .no-print { display: none; }
            @page { margin: 0; }
            body { padding: 1.5cm 2cm; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
    </div>

    <div class="kop">
        @if ($instansi?->logo_institusi)
            <img src="{{ public_path('storage/' . $instansi->logo_institusi) }}" alt="Logo">
        @endif
        <div class="kop-text">
            <h1>{{ $instansi?->nama }}</h1>
            <p>NPSN: {{ $instansi?->npsn }}
                @if ($instansi?->akreditasi) &bull; Akreditasi: {{ $instansi->akreditasi }} @endif
            </p>
        </div>
    </div>

    <h2 class="judul">Daftar Hadir Tamu Undangan</h2>
    <p class="sub-judul">Acara Wisuda &amp; Pengambilan Ijazah &bull; Dicetak {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>

    <p class="summary">
        Total Siswa Hadir: <strong>{{ $tamus->count() }}</strong> &nbsp;&bull;&nbsp;
        Total Tamu (PAX): <strong>{{ $totalPax }}</strong>
    </p>

    <table class="daftar">
        <thead>
            <tr>
                <th style="width:2rem">No.</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Nama Orang Tua / Wali</th>
                <th style="text-align:center;width:3.5rem">PAX</th>
                <th style="width:4.5rem">Waktu</th>
                <th style="width:5rem">TTD</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tamus as $i => $t)
                <tr>
                    <td style="text-align:center">{{ $i + 1 }}</td>
                    <td>{{ $t->siswa?->nama ?? '-' }}</td>
                    <td style="font-family:monospace">{{ $t->siswa?->nisn ?? '-' }}</td>
                    <td>{{ $t->siswa?->nama_orangtua ?? '-' }}</td>
                    <td style="text-align:center">{{ $t->jumlah_tamu }}</td>
                    <td>{{ $t->created_at->format('H:i') }}</td>
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:1.5rem;color:#9ca3af;">
                        Belum ada tamu yang tercatat.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if ($tamus->isNotEmpty())
        <tfoot>
            <tr>
                <td colspan="4" style="font-weight:bold;text-align:right;padding:6px 8px;">Total</td>
                <td style="font-weight:bold;text-align:center">{{ $totalPax }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="ttd-section">
        <div class="ttd-box">
            <p>{{ $instansi?->nama }}, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Panitia Wisuda</p>
            @if ($instansi?->tte_pimpinan)
                <img src="{{ public_path('storage/' . $instansi->tte_pimpinan) }}" alt="TTD"
                    style="height:60px;margin:6px auto;display:block;object-fit:contain;">
            @else
                <div class="ttd-space"></div>
            @endif
            <p class="nama">{{ $instansi?->nama_pimpinan }}</p>
            @if ($instansi?->nip_pimpinan)
                <p class="nip">NIP. {{ $instansi->nip_pimpinan }}</p>
            @endif
        </div>
    </div>

</body>
</html>

```

---

### 📄 File: `./resources/views/tamu/index.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Tamu Undangan')

@push('styles')
    <style>
        .tamu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.6rem
        }

        .tamu-title {
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -.03em;
            font-family: var(--font-display)
        }

        .tamu-actions {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .9rem;
            margin-bottom: 1.6rem
        }

        .stat-tile {
            padding: 1.4rem 1.1rem;
            text-align: center;
            border-radius: var(--radius)
        }

        .stat-val {
            font-size: 1.9rem;
            font-weight: 900;
            font-family: var(--font-display);
            background: linear-gradient(135deg, var(--teal-xl), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1
        }

        .stat-lbl {
            font-size: .7rem;
            color: var(--muted);
            margin-top: .4rem;
            font-weight: 500
        }

        .tamu-table-wrap {
            border-radius: var(--radius);
            overflow: hidden
        }

        .tamu-tbl {
            width: 100%;
            border-collapse: collapse
        }

        .tamu-tbl thead th {
            padding: .8rem 1.05rem;
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            text-align: left;
            border-bottom: 1px solid var(--border)
        }

        .tamu-tbl tbody tr {
            border-bottom: 1px solid var(--border2);
            transition: background .15s
        }

        .tamu-tbl tbody tr:hover {
            background: rgba(13, 148, 136, .035)
        }

        .tamu-tbl tbody td {
            padding: .8rem 1.05rem;
            font-size: .82rem
        }

        .tamu-tbl tbody tr:last-child {
            border-bottom: none
        }

        .pax-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(20, 184, 166, .1);
            border: 1px solid rgba(20, 184, 166, .2);
            color: var(--teal-xl);
            border-radius: 999px;
            min-width: 28px;
            height: 22px;
            padding: 0 .45rem;
            font-size: .7rem;
            font-weight: 700
        }

        .time-cell {
            font-size: .7rem;
            color: var(--muted);
            font-variant-numeric: tabular-nums
        }

        .empty-tbl {
            text-align: center;
            padding: 3.5rem 2rem;
            color: var(--muted)
        }

        .empty-tbl-sub {
            font-size: .82rem;
            margin-top: .4rem
        }

        @media(max-width:640px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr
            }

            .tamu-hide {
                display: none
            }
        }
    </style>
@endpush

@section('content')
    <div class="tamu-header">
        <h1 class="tamu-title">Tamu Undangan</h1>
        <div class="tamu-actions">
            <a href="{{ route('tamu.scan') }}" class="btn btn-primary" style="font-size:.8rem;padding:.52rem 1rem;">Scan QR</a>
            <a href="{{ route('tamu.cetak-hadir') }}" class="btn btn-ghost" style="font-size:.8rem;padding:.52rem 1rem;"
                target="_blank">Cetak Hadir</a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="card stat-tile reveal">
            <div class="stat-val">{{ $tamuUndangans->total() }}</div>
            <div class="stat-lbl">Siswa Hadir</div>
        </div>
        <div class="card stat-tile reveal reveal-delay-1">
            <div class="stat-val">{{ $tamuUndangans->sum('jumlah_tamu') }}</div>
            <div class="stat-lbl">Total PAX</div>
        </div>
        @isset($totalSiswa)
            @php $pct = $totalSiswa > 0 ? round($tamuUndangans->total() / $totalSiswa * 100) : 0; @endphp
            <div class="card stat-tile reveal reveal-delay-2">
                <div class="stat-val">{{ $pct }}%</div>
                <div class="stat-lbl">Kehadiran</div>
            </div>
        @endisset
    </div>

    <div class="card tamu-table-wrap reveal">
        <table class="tamu-tbl">
            <thead>
                <tr>
                    <th style="width:2.25rem">#</th>
                    <th>Nama Siswa</th>
                    <th class="tamu-hide">Nama Orang Tua</th>
                    <th style="text-align:center">PAX</th>
                    <th style="text-align:right">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tamuUndangans as $i => $t)
                    <tr>
                        <td style="color:var(--muted2);font-size:.7rem;">{{ $tamuUndangans->firstItem() + $i }}</td>
                        <td style="font-weight:600">{{ $t->siswa?->nama ?? '-' }}</td>
                        <td class="tamu-hide" style="color:var(--muted)">{{ $t->siswa?->nama_orangtua ?? '-' }}</td>
                        <td style="text-align:center"><span class="pax-badge">{{ $t->jumlah_tamu }}</span></td>
                        <td style="text-align:right" class="time-cell">{{ $t->created_at->format('H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-tbl">
                            <div style="font-size:1.5rem;margin-bottom:.5rem;opacity:.3">—</div>
                            <div class="empty-tbl-sub">Belum ada tamu yang hadir.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.1rem">{{ $tamuUndangans->links() }}</div>
@endsection

```

---

### 📄 File: `./resources/views/tamu/konfirmasi.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Konfirmasi Tamu')

@push('styles')
    <style>
        .konfirmasi-wrap {
            max-width: 420px;
            margin: 0 auto
        }

        .pax-control {
            display: flex;
            align-items: center;
            gap: .8rem
        }

        .pax-btn {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: var(--card2);
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .2s;
            font-family: var(--font-body);
        }

        .pax-btn:hover {
            border-color: rgba(20, 184, 166, .42);
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .07)
        }

        .pax-input {
            flex: 1;
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: .6rem;
            font-size: 1.2rem;
            font-weight: 800;
            font-family: var(--font-display);
            color: var(--text);
            text-align: center;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .pax-input:focus {
            border-color: rgba(20, 184, 166, .42);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .1)
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 1rem;
            padding: .48rem 0;
            border-bottom: 1px solid var(--border2)
        }

        .info-row:last-child {
            border-bottom: none
        }
    </style>
@endpush

@section('content')
    <div class="konfirmasi-wrap">
        <a href="{{ route('tamu.scan') }}"
            style="margin-bottom:1.4rem;display:inline-flex;align-items:center;gap:.45rem;font-size:.8rem;color:var(--muted);text-decoration:none;">
            &larr; Kembali ke Scanner
        </a>

        <h1
            style="font-size:1.3rem;font-weight:800;letter-spacing:-.03em;margin-bottom:1.35rem;font-family:var(--font-display)">
            Konfirmasi Kehadiran</h1>

        <div class="card" style="overflow:hidden;">
            <div style="padding:1.4rem 1.6rem;border-bottom:1px solid var(--border2);">
                @if (isset($sudahHadir) && $sudahHadir)
                    <div
                        style="display:flex;align-items:center;gap:.55rem;background:rgba(245,158,11,.07);border:1px solid rgba(245,158,11,.18);color:#fbbf24;border-radius:9px;padding:.7rem .9rem;font-size:.76rem;font-weight:600;margin-bottom:.9rem;">
                        Siswa ini sudah tercatat hadir. Data akan diperbarui.
                    </div>
                @endif

                @foreach ([
            'Nama Siswa' => [$siswa->nama, false, false],
            'NISN' => [$siswa->nisn, true, false],
            'Nama Ortu' => [$siswa->nama_orangtua ?? '—', false, false],
            'Status' => [$siswa->status->label(), false, true],
        ] as $lbl => [$val, $mono, $accent])
                    <div class="info-row">
                        <span style="font-size:.73rem;color:var(--muted)">{{ $lbl }}</span>
                        <span
                            style="font-size:.82rem;font-weight:600;{{ $mono ? 'font-family:monospace;' : '' }}{{ $accent ? 'color:var(--teal-xl);' : '' }}">{{ $val }}</span>
                    </div>
                @endforeach
            </div>

            <div style="padding:1.4rem 1.6rem;">
                <form action="{{ route('tamu.store') }}" method="POST"
                    style="display:flex;flex-direction:column;gap:1rem;">
                    @csrf
                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                    <div>
                        <label
                            style="font-size:.76rem;font-weight:600;color:var(--muted);display:block;margin-bottom:.7rem;">
                            Jumlah Tamu <span style="font-weight:400;color:var(--muted2)">(termasuk orang tua/wali)</span>
                        </label>
                        <div class="pax-control">
                            <button type="button" onclick="adj(-1)" class="pax-btn">&minus;</button>
                            <input id="pax" type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}"
                                min="1" max="10" readonly class="pax-input">
                            <button type="button" onclick="adj(1)" class="pax-btn">+</button>
                        </div>
                        @error('jumlah_tamu')
                            <p style="font-size:.72rem;color:#f87171;margin-top:.45rem;">&times; {{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" style="justify-content:center;">Simpan Kehadiran</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function adj(d) {
            const el = document.getElementById('pax');
            el.value = Math.min(10, Math.max(1, parseInt(el.value) + d));
        }
    </script>
@endpush

```

---

### 📄 File: `./resources/views/tamu/scan.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Scan QR Tamu')

@push('styles')
    <style>
        .scan-wrap {
            max-width: 440px;
            margin: 0 auto;
        }

        .scan-title {
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: -.03em;
            margin-bottom: .35rem;
            font-family: var(--font-display);
        }

        .scan-sub {
            font-size: .8rem;
            color: var(--muted);
            margin-bottom: 1.4rem;
        }

        .scanner-card {
            padding: 1.1rem;
            border-radius: var(--radius);
            margin-bottom: .9rem;
        }

        .qr-viewport {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 12px;
            overflow: hidden;
            background: #060f0d;
            border: 1px solid var(--border);
        }

        #qr-video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            display: none;
        }

        /* Overlay scrim + aim box */
        .qr-scrim {
            position: absolute;
            inset: 0;
            pointer-events: none;
            display: none;
            background:
                linear-gradient(rgba(0, 0, 0, .4) 0 calc(50% - 110px), transparent calc(50% - 110px)),
                linear-gradient(transparent calc(50% + 110px), rgba(0, 0, 0, .4) calc(50% + 110px)),
                linear-gradient(90deg, rgba(0, 0, 0, .4) 0 calc(50% - 110px), transparent calc(50% - 110px)),
                linear-gradient(90deg, transparent calc(50% + 110px), rgba(0, 0, 0, .4) calc(50% + 110px));
        }

        .qr-aim-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 220px;
            height: 220px;
            border: 2px solid rgba(94, 234, 212, .7);
            border-radius: 14px;
            animation: aim-pulse 2s ease-in-out infinite;
            pointer-events: none;
        }

        .qr-aim-box::before,
        .qr-aim-box::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-color: var(--teal-xl);
            border-style: solid;
        }

        .qr-aim-box::before {
            top: -2px;
            left: -2px;
            border-width: 3px 0 0 3px;
            border-radius: 4px 0 0 0;
        }

        .qr-aim-box::after {
            bottom: -2px;
            right: -2px;
            border-width: 0 3px 3px 0;
            border-radius: 0 0 4px 0;
        }

        @keyframes aim-pulse {

            0%,
            100% {
                border-color: rgba(94, 234, 212, .5);
            }

            50% {
                border-color: rgba(94, 234, 212, 1);
                box-shadow: 0 0 18px rgba(94, 234, 212, .25);
            }
        }

        /* Placeholder */
        .qr-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .75rem;
        }

        .qr-spinner {
            width: 38px;
            height: 38px;
            border: 3px solid rgba(20, 184, 166, .15);
            border-top-color: var(--teal-xl);
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .qr-ph-text {
            font-size: .72rem;
            color: var(--muted);
        }

        /* Status */
        .qr-status-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            margin-top: .8rem;
        }

        .qr-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--muted2);
            flex-shrink: 0;
            transition: background .3s;
        }

        .qr-text {
            font-size: .73rem;
            color: var(--muted);
        }

        /* Error */
        .cam-error {
            display: none;
            margin-top: .7rem;
            padding: .65rem .85rem;
            border-radius: 10px;
            background: rgba(220, 38, 38, .07);
            border: 1px solid rgba(220, 38, 38, .2);
            color: #f87171;
            font-size: .75rem;
            line-height: 1.6;
        }

        .cam-error.visible {
            display: block;
        }

        /* Start btn */
        .qr-start-btn {
            display: none;
            width: 100%;
            margin-top: .7rem;
            padding: .62rem;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff;
            border: none;
            font-family: var(--font-body);
            font-size: .82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            box-shadow: 0 0 18px rgba(13, 148, 136, .22);
        }

        .qr-start-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 22px rgba(13, 148, 136, .38);
        }

        .qr-start-btn.visible {
            display: block;
        }

        /* Manual */
        .manual-card {
            padding: 1.4rem;
            border-radius: var(--radius);
        }

        .manual-label {
            font-size: .78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: .8rem;
        }

        .manual-form {
            display: flex;
            gap: .55rem;
        }

        .manual-input {
            flex: 1;
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: .58rem .88rem;
            font-size: .83rem;
            font-family: var(--font-body);
            color: var(--text);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .manual-input::placeholder {
            color: var(--muted2);
        }

        .manual-input:focus {
            border-color: rgba(20, 184, 166, .42);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .1);
        }

        .manual-input.is-error {
            border-color: rgba(220, 38, 38, .4);
        }

        /* Redirect overlay */
        .scan-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999;
            background: rgba(6, 13, 12, .92);
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
            backdrop-filter: blur(8px);
        }

        .scan-overlay.active {
            display: flex;
        }

        .scan-spinner2 {
            width: 44px;
            height: 44px;
            border: 3px solid rgba(20, 184, 166, .2);
            border-top-color: var(--teal-xl);
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }

        .scan-overlay-text {
            font-size: .85rem;
            color: var(--teal-xl);
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="scan-overlay" id="scan-overlay">
        <div class="scan-spinner2"></div>
        <div class="scan-overlay-text">QR terdeteksi, memuat data…</div>
    </div>

    <div class="scan-wrap">
        <a href="{{ route('tamu.index') }}"
            style="margin-bottom:1.2rem;display:inline-flex;align-items:center;gap:.45rem;font-size:.8rem;color:var(--muted);text-decoration:none;">
            &larr; Kembali ke Daftar Tamu
        </a>

        <h1 class="scan-title">Scan QR Undangan</h1>
        <p class="scan-sub">Arahkan kamera ke QR Code pada surat undangan siswa.</p>

        <div class="card scanner-card">
            <div class="qr-viewport" id="qr-viewport">
                <video id="qr-video" playsinline muted autoplay></video>
                <canvas id="qr-canvas" style="display:none;"></canvas>
                <div class="qr-scrim" id="qr-scrim"></div>
                <div class="qr-aim-box" id="qr-aim" style="display:none;"></div>
                <div class="qr-placeholder" id="qr-placeholder">
                    <div class="qr-spinner"></div>
                    <span class="qr-ph-text" id="qr-ph-text">Meminta izin kamera…</span>
                </div>
            </div>

            <div class="qr-status-row">
                <span id="qr-dot" class="qr-dot"></span>
                <span id="qr-status" class="qr-text">Meminta izin kamera…</span>
            </div>

            <div class="cam-error" id="cam-error"></div>
            <button class="qr-start-btn" id="qr-start-btn" type="button">📷 Izinkan &amp; Mulai Kamera</button>
        </div>

        <div class="card manual-card">
            <div class="manual-label">Atau masukkan kode secara manual (ID Siswa / NISN):</div>
            <form action="{{ route('tamu.scan.post') }}" method="POST" class="manual-form">
                @csrf
                <input type="text" name="kode" placeholder="Contoh: 0012345678"
                    class="manual-input {{ $errors->has('kode') ? 'is-error' : '' }}">
                <button type="submit" class="btn btn-primary"
                    style="font-size:.8rem;padding:.58rem 1rem;flex-shrink:0;">Cari</button>
            </form>
            @error('kode')
                <p style="font-size:.72rem;color:#f87171;margin-top:.55rem;">&times; {{ $message }}</p>
            @enderror
        </div>
    </div>
@endsection

@push('scripts')
    {{-- BarcodeDetector polyfill untuk browser yang belum support (Firefox, older Safari) --}}
    <script src="https://cdn.jsdelivr.net/npm/barcode-detector@2/dist/es2015/barcode-detector.min.js"
        crossorigin="anonymous"></script>

    <script>
        (() => {
            const video = document.getElementById('qr-video');
            const canvas = document.getElementById('qr-canvas');
            const ctx = canvas.getContext('2d', {
                willReadFrequently: true
            });
            const statusEl = document.getElementById('qr-status');
            const phText = document.getElementById('qr-ph-text');
            const dotEl = document.getElementById('qr-dot');
            const overlay = document.getElementById('scan-overlay');
            const placeholder = document.getElementById('qr-placeholder');
            const scrim = document.getElementById('qr-scrim');
            const aimEl = document.getElementById('qr-aim');
            const errBox = document.getElementById('cam-error');
            const startBtn = document.getElementById('qr-start-btn');

            const konfirmasiBase = @json(url('/tamu/konfirmasi'));
            let stream = null;
            let rafId = null;
            let scanned = false;
            let detector = null;

            /* ── Status helpers ──────────────────────────────────── */
            function setStatus(msg, color) {
                statusEl.textContent = msg;
                if (phText) phText.textContent = msg;
                dotEl.style.background = color || 'var(--muted2)';
            }

            function showError(msg) {
                setStatus('Kamera tidak tersedia', '#f87171');
                errBox.textContent = msg;
                errBox.classList.add('visible');
                startBtn.classList.add('visible');
            }

            function humanizeErr(err) {
                const s = String(err.name || err).toLowerCase();
                if (s.includes('notallowed') || s.includes('permission'))
                    return 'Izin kamera ditolak. Buka pengaturan browser → izinkan kamera untuk situs ini, lalu muat ulang.';
                if (s.includes('notfound') || s.includes('devicenotfound'))
                    return 'Kamera tidak ditemukan pada perangkat ini.';
                if (s.includes('notreadable') || s.includes('trackstart'))
                    return 'Kamera sedang dipakai aplikasi lain. Tutup aplikasi tersebut lalu coba lagi.';
                if (s.includes('overconstrained'))
                    return 'Konfigurasi kamera tidak cocok dengan perangkat ini.';
                return 'Gagal mengakses kamera: ' + (err.message || err);
            }

            /* ── Camera start ────────────────────────────────────── */
            async function startCamera() {
                startBtn.classList.remove('visible');
                errBox.classList.remove('visible');
                setStatus('Meminta izin kamera…', 'var(--muted2)');

                // Constraints: utama belakang, fallback default
                const constraints = [{
                        video: {
                            facingMode: {
                                ideal: 'environment'
                            },
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            }
                        }
                    },
                    {
                        video: {
                            facingMode: 'environment'
                        }
                    },
                    {
                        video: true
                    },
                ];

                for (const c of constraints) {
                    try {
                        stream = await navigator.mediaDevices.getUserMedia(c);
                        break;
                    } catch (e) {
                        if (e.name === 'NotAllowedError' || e.name === 'PermissionDeniedError') {
                            showError(humanizeErr(e));
                            return;
                        }
                        // coba constraint berikutnya
                    }
                }

                if (!stream) {
                    showError('Tidak dapat membuka kamera. Coba izinkan secara manual.');
                    return;
                }

                video.srcObject = stream;
                video.onloadedmetadata = () => {
                    video.play().then(() => {
                        video.style.display = 'block';
                        placeholder.style.display = 'none';
                        scrim.style.display = 'block';
                        aimEl.style.display = 'block';
                        setStatus('Kamera aktif — arahkan ke QR Code', 'var(--teal-xl)');
                        scheduleDetect();
                    }).catch(e => showError(humanizeErr(e)));
                };
            }

            /* ── QR Detection loop ───────────────────────────────── */
            async function initDetector() {
                // BarcodeDetector API (Chrome 83+, Edge 83+, Safari 17.4+, + polyfill)
                if ('BarcodeDetector' in window) {
                    const formats = await BarcodeDetector.getSupportedFormats();
                    if (formats.includes('qr_code')) {
                        detector = new BarcodeDetector({
                            formats: ['qr_code']
                        });
                        return;
                    }
                }
                // Fallback: ZXing-js (dinamis, hanya load jika perlu)
                detector = null;
            }

            function scheduleDetect() {
                rafId = requestAnimationFrame(detectFrame);
            }

            async function detectFrame() {
                if (scanned || !video.videoWidth) {
                    scheduleDetect();
                    return;
                }

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                ctx.drawImage(video, 0, 0);

                try {
                    if (detector) {
                        const results = await detector.detect(video);
                        if (results.length) {
                            handleResult(results[0].rawValue);
                            return;
                        }
                    } else {
                        // Fallback: jsQR (CDN dinamis)
                        if (!window.jsQR) {
                            scheduleDetect();
                            return;
                        }
                        const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        const result = jsQR(imgData.data, imgData.width, imgData.height, {
                            inversionAttempts: 'dontInvert'
                        });
                        if (result) {
                            handleResult(result.data);
                            return;
                        }
                    }
                } catch (_) {
                    /* skip frame */
                }

                scheduleDetect();
            }

            function handleResult(text) {
                if (scanned) return;
                scanned = true;
                cancelAnimationFrame(rafId);
                stream?.getTracks().forEach(t => t.stop());
                setStatus('QR terdeteksi!', 'var(--teal-xl)');
                overlay.classList.add('active');
                window.location.href = konfirmasiBase + '/' + encodeURIComponent(text.trim());
            }

            /* ── Load jsQR sebagai fallback jika BarcodeDetector tidak ada ── */
            async function loadFallbackLib() {
                if ('BarcodeDetector' in window) return; // tidak perlu
                return new Promise(res => {
                    const s = document.createElement('script');
                    s.src = 'https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js';
                    s.onload = res;
                    s.onerror = res;
                    document.head.appendChild(s);
                });
            }

            /* ── Init ────────────────────────────────────────────── */
            async function init() {
                await loadFallbackLib();
                await initDetector();
                await startCamera();
            }

            startBtn.addEventListener('click', () => {
                scanned = false;
                init();
            });

            // Pause/resume saat tab disembunyikan
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    cancelAnimationFrame(rafId);
                    stream?.getTracks().forEach(t => t.stop());
                    stream = null;
                } else if (!scanned) {
                    init();
                }
            });

            // Autostart setelah halaman selesai render
            if (document.readyState === 'complete') {
                init();
            } else {
                window.addEventListener('load', init);
            }
        })();
    </script>
@endpush

```

---

## 📁 Directory: routes (Routes)

Application routing definitions.

### 📄 File: `./routes/console.php`

```php
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

```

---

### 📄 File: `./routes/web.php`

```php
<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PersonilController;
use App\Http\Controllers\TamuUndanganController;
use App\Http\Middleware\JadwalKelulusanAktif;
use Illuminate\Support\Facades\Route;

// ── Landing & Pencarian ────────────────────────────────────────────
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::post('/cari', [LandingPageController::class, 'cari'])->name('landing.cari');

// ── Siswa: hasil & dokumen ─────────────────────────────────────────
Route::prefix('/siswa/{siswa}')->name('landing.')->group(function () {
    Route::get('/', [LandingPageController::class, 'hasil'])->name('hasil');
    Route::get('/skl', [LandingPageController::class, 'cetakSkl'])->name('skl')->middleware('throttle:30,1');
    Route::get('/skl/pdf', [LandingPageController::class, 'cetakSklPdf'])->name('skl.pdf')->middleware('throttle:10,1');
    Route::get('/undangan', [LandingPageController::class, 'cetakUndangan'])->name('undangan')->middleware('throttle:30,1');
    Route::get('/undangan/pdf', [LandingPageController::class, 'cetakUndanganPdf'])->name('undangan.pdf')->middleware('throttle:10,1');
});

// ── Personil ───────────────────────────────────────────────────────
Route::prefix('personil')->name('personil.')->controller(PersonilController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/cari', 'search')->name('cari');
});

// ── Alumni ─────────────────────────────────────────────────────────
Route::prefix('alumni')->name('alumni.')->controller(AlumniController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/cari', 'search')->name('cari');
});

// ── Tamu Undangan (dibatasi jadwal kelulusan) ──────────────────────
Route::middleware(JadwalKelulusanAktif::class)
    ->prefix('tamu')
    ->name('tamu.')
    ->controller(TamuUndanganController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/scan', 'scanQr')->name('scan');
        Route::post('/scan', 'processScan')->name('scan.post');
        Route::get('/konfirmasi/{siswa}', 'konfirmasi')->name('konfirmasi');
        Route::post('/', 'store')->name('store');
        Route::get('/cetak-hadir', 'cetakHadir')->name('cetak-hadir');
    });

```

---

## 📁 Directory: storage (storage)

### 📄 File: `./storage/app/.gitignore`

```
*
!private/
!public/
!.gitignore

```

---

### 📄 File: `./storage/app/private/.gitignore`

```
*
!.gitignore

```

---

### 📄 File: `./storage/app/private/livewire-tmp/Ddby8mkflsNfTl03PYoFDxOUZFjzC7JuhRw7dmND.xlsx.json`

```json
{"name":"template-siswa(1).xlsx","type":"application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","size":6625,"hash":"95l4zmiVkdJhs7eDoCC0KYiVAgk0lI5W6MQG0qNQ.xlsx"}
```

---

### 📄 File: `./storage/app/private/livewire-tmp/MDOuKsO1QGpIrdCUEjfpVIYC7ynZzHR2QnJm2ByD.xlsx.json`

```json
{"name":"template-personil.xlsx","type":"application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","size":12488,"hash":"C2llOtaF0GVVo8mF4okBjhLpUcB9lagqlnqMfH0e.xlsx"}
```

---

### 📄 File: `./storage/app/public/.gitignore`

```
*
!.gitignore

```

---

### 📄 File: `./storage/framework/.gitignore`

```
compiled.php
config.php
down
events.scanned.php
maintenance.php
routes.php
routes.scanned.php
schedule-*
services.json

```

---

### 📄 File: `./storage/framework/testing/.gitignore`

```
*
!.gitignore

```

---

