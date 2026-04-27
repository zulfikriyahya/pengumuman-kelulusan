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
use Carbon\Carbon;

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

```

---

### 📄 File: `./database/seeders/PersonilSeeder.php`

```php
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

```

---

### 📄 File: `./database/seeders/SiswaSeeder.php`

```php
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
                'foto'    => null,
                'telepon'       => '08' . str_pad(10000000 + ($i * 77777), 10, '0', STR_PAD_LEFT),
                'status'        => $statusOptions[$i % 3 === 0 ? ($i % 2 === 0 ? 1 : 2) : 0],
                'created_at'    => $now,
                'updated_at'    => $now,
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

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TahunPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tahun_pelajarans')->insert([
            'id'                          => Str::uuid(),
            'name'                        => '2025/2026',
            'jadwal_pengumuman_mulai'     => Carbon::create(2026, 4, 1, 8, 0, 0),
            'jadwal_pengumuman_selesai'   => Carbon::create(2026, 4, 31, 23, 59, 59),
            'jadwal_kelulusan_mulai'      => Carbon::create(2026, 4, 1, 8, 0, 0),
            'jadwal_kelulusan_selesai'    => Carbon::create(2026, 4, 31, 12, 0, 0),
            'jadwal_kelulusan_tempat'     => 'Aula Gedung Diklat Kabupaten Pandeglang',
            'status'                      => true,
            'created_at'                  => Carbon::now(),
            'updated_at'                  => Carbon::now(),
        ]);
    }
}

```

---

## 📁 Directory: resources (Frontend Resources)

### 📄 File: `./resources/views/alumni/index.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Alumni')

@push('styles')
    @include('partials._people-styles')
@endpush

@section('content')
    @include('partials._page-header', [
        'title' => 'Alumni',
        'searchRoute' => 'alumni.cari',
        'clearRoute' => 'alumni.index',
        'placeholder' => 'Nama atau NISN',
        'keyword' => $keyword ?? null,
        'totalFound' => $alumnis->total() ?? null,
    ])

    @include('partials._people-grid', [
        'items' => $alumnis,
        'photoKey' => 'avatar',
        'subKey' => 'tahun_lulus',
        'subPrefix' => 'Lulus ',
        'subColor' => '',
        'monoKey' => 'nisn',
        'keyword' => $keyword ?? null,
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

        .back-link:hover {
            color: var(--teal-xl)
        }

        .back-link span {
            transition: transform .2s
        }

        .back-link:hover span {
            transform: translateX(-2px)
        }

        /* Not found */
        .notfound-card {
            padding: 3rem 2rem;
            text-align: center
        }

        .notfound-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: .45rem;
            font-family: var(--font-display)
        }

        .notfound-sub {
            font-size: .82rem;
            color: var(--muted);
            line-height: 1.75;
            margin-bottom: 1.4rem
        }

        /* Result */
        .result-header {
            padding: 1.5rem 1.6rem;
            border-bottom: 1px solid var(--border2)
        }

        .status-row {
            display: flex;
            align-items: center;
            gap: .9rem
        }

        .status-icon-wrap {
            width: 50px;
            height: 50px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            font-family: var(--font-display)
        }

        .status-label-sm {
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            opacity: .7;
            margin-bottom: .18rem
        }

        .status-text {
            font-size: 1.2rem;
            font-weight: 800;
            letter-spacing: -.02em;
            line-height: 1.1;
            font-family: var(--font-display)
        }

        .result-info {
            padding: 1.1rem 1.6rem;
            border-bottom: 1px solid var(--border2)
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 1rem;
            padding: .5rem 0;
            border-bottom: 1px solid var(--border2)
        }

        .info-row:last-child {
            border-bottom: none
        }

        .info-label {
            font-size: .73rem;
            color: var(--muted);
            flex-shrink: 0;
            font-weight: 500
        }

        .info-val {
            font-size: .83rem;
            font-weight: 600;
            text-align: right
        }

        .result-actions {
            padding: 1.1rem 1.6rem;
            display: flex;
            flex-direction: column;
            gap: .6rem
        }

        .doc-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .8rem 1.1rem;
            border-radius: 11px;
            font-size: .82rem;
            font-weight: 700;
            font-family: var(--font-body);
            text-decoration: none;
            cursor: pointer;
            transition: all .22s;
            border: none
        }

        .doc-btn-primary {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff;
            box-shadow: 0 0 24px rgba(13, 148, 136, .22)
        }

        .doc-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 28px rgba(13, 148, 136, .38)
        }

        .doc-btn-outline {
            background: transparent;
            border: 1px solid rgba(20, 184, 166, .28);
            color: var(--teal-xl)
        }

        .doc-btn-outline:hover {
            background: rgba(20, 184, 166, .07);
            border-color: rgba(20, 184, 166, .5)
        }

        .doc-btn-disabled {
            background: rgba(255, 255, 255, .02);
            border: 1px dashed var(--border);
            color: var(--muted2);
            cursor: default;
            pointer-events: none
        }

        .result-footer-note {
            text-align: center;
            font-size: .72rem;
            color: var(--muted2);
            margin-top: .85rem;
            letter-spacing: .01em
        }

        /* Themes */
        .theme-lulus .status-icon-wrap {
            background: rgba(20, 184, 166, .1);
            border: 1px solid rgba(20, 184, 166, .2);
            color: var(--teal-xl)
        }

        .theme-lulus .status-text {
            color: var(--teal-xl)
        }

        .theme-tidak .status-icon-wrap {
            background: rgba(220, 38, 38, .08);
            border: 1px solid rgba(220, 38, 38, .18);
            color: #f87171
        }

        .theme-tidak .status-text {
            color: #f87171
        }

        .theme-syarat .status-icon-wrap {
            background: rgba(245, 158, 11, .09);
            border: 1px solid rgba(245, 158, 11, .2);
            color: #fbbf24
        }

        .theme-syarat .status-text {
            color: #fbbf24
        }
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
                <a href="{{ route('landing') }}" class="btn btn-primary" style="margin:0 auto;">
                    &larr; Coba Lagi
                </a>
            </div>
        @else
            @php
                [$themeClass, $iconLabel] = match ($siswa->status) {
                    \App\Enums\StatusSiswa::Lulus => ['theme-lulus', 'LULUS'],
                    \App\Enums\StatusSiswa::TidakLulus => ['theme-tidak', 'TIDAK'],
                    \App\Enums\StatusSiswa::LulusBersyarat => ['theme-syarat', 'SYARAT'],
                };

                $statusLabel = $siswa->status->getLabel();
                $adaSkl = (bool) $siswa->berkas_skl;
                $bolehUndang = $siswa->isLulus();
            @endphp

            <div class="card {{ $themeClass }}" style="overflow:hidden;">

                {{-- Header status --}}
                <div class="result-header">
                    <div class="eyebrow" style="margin-bottom:.9rem;">Hasil Seleksi Kelulusan</div>
                    <div class="status-row">
                        <div class="status-icon-wrap">{{ $iconLabel }}</div>
                        <div>
                            <div class="status-label-sm">Status</div>
                            <div class="status-text">{{ $statusLabel }}</div>
                        </div>
                    </div>
                </div>

                {{-- Info siswa --}}
                <div class="result-info">
                    @foreach ([
            'Nama Siswa' => [$siswa->nama, false],
            'NISN' => [$siswa->nisn, true],
            'Nama Orang Tua' => [$siswa->nama_orangtua, false],
        ] as $label => [$val, $mono])
                        @if ($val)
                            <div class="info-row">
                                <span class="info-label">{{ $label }}</span>
                                <span class="info-val"
                                    @if ($mono) style="font-family:monospace;" @endif>
                                    {{ $val }}
                                </span>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Tombol dokumen --}}
                <div class="result-actions">
                    {{-- SKL: semua status berhak, tapi cek berkas tersedia --}}
                    @if ($adaSkl)
                        <a href="{{ route('landing.skl', $siswa) }}" target="_blank" class="doc-btn doc-btn-primary">
                            Unduh Surat Keterangan Lulus
                        </a>
                    @else
                        <div class="doc-btn doc-btn-disabled">
                            Dokumen SKL belum tersedia &mdash; hubungi madrasah
                        </div>
                    @endif

                    {{-- Surat Undangan: hanya Lulus & Lulus Bersyarat --}}
                    @if ($bolehUndang)
                        <a href="{{ route('landing.undangan', $siswa) }}" target="_blank" class="doc-btn doc-btn-outline">
                            Cetak Surat Undangan Kelulusan
                        </a>
                    @endif
                </div>

            </div>

            {{-- Catatan bawah --}}
            @if ($siswa->status === \App\Enums\StatusSiswa::Lulus)
                <p class="result-footer-note">Selamat! Semoga sukses di jenjang berikutnya.</p>
            @elseif ($siswa->status === \App\Enums\StatusSiswa::LulusBersyarat)
                <p class="result-footer-note" style="color:#fbbf24;">
                    Segera hubungi madrasah untuk informasi lebih lanjut.
                </p>
            @elseif ($siswa->status === \App\Enums\StatusSiswa::TidakLulus)
                <p class="result-footer-note" style="color:#f87171;">
                    Tetap semangat. Hubungi madrasah untuk langkah selanjutnya.
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
                                <div class="search-icon-wrap">SKL</div>
                                <div>
                                    <div class="search-card-title">Cek Status Kelulusan</div>
                                    <div class="search-card-sub">Masukkan NISN atau nomor telepon terdaftar</div>
                                </div>
                            </div>
                            <form action="{{ route('landing.cari') }}" method="POST">
                                @csrf
                                <div class="search-field">
                                    <input type="text" name="nisn" placeholder="NISN (10 digit) atau Nomor Telepon"
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
            <div class="kop-surat">
                @include('partials._kop-surat')
            </div>

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
                    $tp = $tahunPelajaran;
                    $adaJadwal =
                        $tp?->jadwal_kelulusan_mulai && $tp?->jadwal_kelulusan_selesai && $tp?->jadwal_kelulusan_tempat;
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

                @include('partials._ttd')

                {{-- QR CODE SECTION --}}
                <div class="qr-block"
                    style="margin-top:1.5rem;padding-top:1rem;border-top:1px dashed #d1d5db;text-align:center;">
                    {!! QrCode::size(100)->format('svg')->generate($siswa->id) !!}
                    <p style="font-size:.68rem;color:#9ca3af;margin-top:.35rem;">
                        Scan QR ini saat registrasi kehadiran &bull; {{ $siswa->nisn }}
                    </p>
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
    <title>@yield('title', 'Layanan SKL') &mdash; {{ $instansi?->nama ?? config('app.name') }}</title>

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
        /* RESET */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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

        /* AMBIENT */
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

        /* NAV */
        nav#mainNav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            height: var(--nav-h);
            padding: 0 2rem;
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

        .nav-brand {
            display: flex;
            align-items: center;
            gap: .7rem;
            text-decoration: none;
            color: inherit;
            flex-shrink: 0;
        }

        .nav-logo {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(13, 148, 136, .1);
        }

        .nav-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .nav-logo-fallback {
            font-size: .7rem;
            font-weight: 800;
            color: var(--teal-xl);
            font-family: var(--font-display);
        }

        .nav-name {
            font-size: .84rem;
            font-weight: 700;
            letter-spacing: -.01em;
            white-space: nowrap;
            font-family: var(--font-display);
        }

        .nav-sub {
            font-size: .6rem;
            font-weight: 500;
            color: var(--teal-l);
            margin-top: 1px;
            letter-spacing: .02em;
        }

        .nav-links {
            display: flex;
            gap: .1rem;
            list-style: none;
            flex: 1;
            justify-content: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--muted);
            font-size: .76rem;
            font-weight: 600;
            padding: .35rem .7rem;
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

        .nav-right {
            display: flex;
            align-items: center;
            gap: .45rem;
            flex-shrink: 0;
        }

        .n-btn {
            height: 34px;
            padding: 0 .95rem;
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

        #menuBtn {
            width: 34px;
            height: 34px;
            flex-direction: column;
            gap: 5px;
            display: none;
        }

        #menuBtn span {
            display: block;
            width: 16px;
            height: 1.5px;
            background: currentColor;
            border-radius: 2px;
            transition: all .3s;
            margin: 0 auto;
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

        /* DRAWER */
        .drawer {
            position: fixed;
            top: var(--nav-h);
            left: 0;
            right: 0;
            z-index: 190;
            flex-direction: column;
            background: rgba(6, 13, 12, .97);
            border-bottom: 1px solid transparent;
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s cubic-bezier(.4, 0, .2, 1), padding .3s, border-color .3s;
            display: flex;
            backdrop-filter: blur(20px);
        }

        .drawer.open {
            max-height: 420px;
            padding: .9rem 1.5rem 1.75rem;
            border-color: var(--border);
        }

        .drawer a {
            text-decoration: none;
            color: var(--muted);
            font-size: .86rem;
            font-weight: 600;
            padding: .55rem .85rem;
            border-radius: 9px;
            transition: all .2s;
        }

        .drawer a:hover {
            color: var(--teal-xl);
            background: rgba(20, 184, 166, .07);
        }

        .drawer a.drawer-tamu {
            color: var(--gold-l);
        }

        .drawer a.drawer-tamu:hover {
            color: var(--gold-l);
            background: rgba(212, 168, 67, .08);
        }

        /* PAGE */
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

        /* FLASH */
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

        /* COMPONENTS */
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

        /* FORM */
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

        /* TABLE */
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

        /* REVEAL */
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

        /* FOOTER */
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

        /* RESPONSIVE */
        @media (max-width: 960px) {
            .nav-links {
                display: none !important;
            }

            #menuBtn {
                display: flex;
            }
        }

        @media (max-width: 768px) {
            :root {
                --nav-h: 54px;
            }

            .content-wrap {
                padding: 2rem 1.1rem;
            }
        }

        @media (max-width: 540px) {
            :root {
                --nav-h: 50px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="grid-bg"></div>

    @php
        // Hitung sekali di sini — $tahunPelajaran sudah di-share via AppServiceProvider
        $navTp = $tahunPelajaran ?? null;
        $tampilTamu = $navTp && $navTp->isKelulusanAktif();
    @endphp

    <nav id="mainNav">
        <a href="{{ route('landing') }}" class="nav-brand">
            <div class="nav-logo">
                @if ($instansi?->logo_institusi)
                    <img src="{{ Storage::url($instansi->logo_institusi) }}" alt="Logo">
                @else
                    <span class="nav-logo-fallback">SKL</span>
                @endif
            </div>
            <div>
                <div class="nav-name">{{ $instansi?->nama ?? config('app.name') }}</div>
                <div class="nav-sub">Layanan Surat Keterangan Lulus</div>
            </div>
        </a>

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
            <button class="n-btn" id="menuBtn" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
            <a href="{{ route('landing') }}" class="n-btn n-btn-primary">Beranda</a>
        </div>
    </nav>

    <div class="drawer" id="drawer">
        <a href="{{ route('landing') }}">Beranda</a>
        <a href="{{ route('personil.index') }}">Personil</a>
        <a href="{{ route('alumni.index') }}">Alumni</a>
        @if ($tampilTamu)
            <a href="{{ route('tamu.index') }}" class="drawer-tamu">🎓 Tamu Undangan</a>
        @endif
    </div>

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
            &nbsp;&middot;&nbsp; Layanan SKL Digital
        </footer>
    </div>

    <script>
        // Nav scroll
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 40), {
            passive: true
        });

        // Drawer
        const menuBtn = document.getElementById('menuBtn');
        const drawer = document.getElementById('drawer');
        menuBtn.addEventListener('click', () => {
            const o = drawer.classList.toggle('open');
            menuBtn.classList.toggle('open', o);
        });
        [...drawer.querySelectorAll('a')].forEach(a =>
            a.addEventListener('click', () => {
                drawer.classList.remove('open');
                menuBtn.classList.remove('open');
            })
        );
        document.addEventListener('click', e => {
            if (!drawer.contains(e.target) && !menuBtn.contains(e.target)) {
                drawer.classList.remove('open');
                menuBtn.classList.remove('open');
            }
        });

        // Flash
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

        // Reveal
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

### 📄 File: `./resources/views/partials/_kop-surat.blade.php`

```blade
<div class="kop-surat">
    @if ($instansi?->logo_institusi)
        <img src="{{ Storage::url($instansi->logo_institusi) }}" alt="">
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
@if ($items->isEmpty())
    <div class="empty-state">
        <p class="empty-title">Tidak ada data{{ isset($keyword) ? ' untuk &ldquo;' . e($keyword) . '&rdquo;' : '' }}.</p>
        @if (isset($keyword))
            <a href="{{ url()->current() }}" class="empty-link">Lihat semua &rarr;</a>
        @endif
    </div>
@else
    <div class="people-grid">
        @foreach ($items as $p)
            @php $photo = $p->{$photoKey} ?? null; @endphp
            <div class="card card-hover person-card reveal">
                <div class="avatar-wrap">
                    @if ($photo)
                        <img src="{{ Storage::url($photo) }}" alt="{{ $p->nama }}" class="avatar-img">
                    @else
                        <div class="avatar-fallback">{{ strtoupper(mb_substr($p->nama, 0, 1)) }}</div>
                    @endif
                </div>

                <div class="person-name">{{ $p->nama }}</div>

                <div class="person-sub" @if (!empty($subColor)) style="color:{{ $subColor }}" @endif>
                    {{ $subPrefix ?? '' }}{{ $p->{$subKey} ?? '' }}
                </div>

                @if (!empty($monoKey) && $p->{$monoKey})
                    <div class="person-mono">{{ $p->{$monoKey} }}</div>
                @endif

                @if ($p->quote ?? null)
                    <div class="person-quote">&ldquo;{{ $p->quote }}&rdquo;</div>
                @endif

                @if ($p->sosial_media ?? null)
                    <a href="{{ $p->sosial_media }}" target="_blank" rel="noopener" class="person-link">Sosial
                        Media</a>
                @endif
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
    .page-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem
    }

    .page-title {
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -.03em;
        font-family: var(--font-display)
    }

    .page-meta {
        font-size: .76rem;
        color: var(--muted);
        margin-top: .25rem
    }

    .page-meta strong {
        color: var(--text)
    }

    .search-form {
        display: flex;
        gap: .45rem;
        align-items: center
    }

    .search-field-wrap {
        position: relative
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
        color: var(--muted2)
    }

    .search-field-input:focus {
        border-color: rgba(20, 184, 166, .42);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, .1)
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
        box-shadow: 0 3px 18px rgba(13, 148, 136, .32)
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
        color: var(--teal-xl)
    }

    .empty-state {
        text-align: center;
        padding: 5rem 2rem
    }

    .empty-title {
        font-size: .86rem;
        color: var(--muted);
        margin-bottom: .65rem
    }

    .empty-link {
        font-size: .76rem;
        color: var(--teal-xl);
        text-decoration: none
    }

    .empty-link:hover {
        text-decoration: underline
    }

    .people-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(172px, 1fr));
        gap: .9rem
    }

    .person-card {
        padding: 1.4rem .9rem;
        text-align: center;
        border-radius: var(--radius);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .12rem
    }

    .avatar-wrap {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-bottom: .7rem;
        flex-shrink: 0
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 1.5px solid var(--border)
    }

    .avatar-fallback {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.2rem;
        font-family: var(--font-display);
        border: 1.5px solid var(--border);
        background: rgba(20, 184, 166, .08);
        color: var(--teal-xl);
    }

    .person-name {
        font-size: .85rem;
        font-weight: 700;
        line-height: 1.25;
        font-family: var(--font-display)
    }

    .person-sub {
        font-size: .71rem;
        color: var(--muted);
        margin-top: .12rem
    }

    .person-mono {
        font-size: .67rem;
        font-family: monospace;
        color: var(--muted2);
        margin-top: .08rem;
        letter-spacing: .03em
    }

    .person-quote {
        font-size: .7rem;
        color: var(--muted);
        font-style: italic;
        margin-top: .45rem;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden
    }

    .person-link {
        font-size: .7rem;
        color: var(--teal-xl);
        text-decoration: none;
        margin-top: .35rem;
        display: inline-block;
        border-bottom: 1px solid rgba(94, 234, 212, .25);
        padding-bottom: 1px;
        transition: border-color .2s
    }

    .person-link:hover {
        border-color: var(--teal-xl)
    }

    .pagination-wrap {
        margin-top: 1.75rem
    }
</style>

```

---

### 📄 File: `./resources/views/partials/_ttd.blade.php`

```blade
<div class="ttd-block">
    <div class="ttd-inner">
        <p>{{ $instansi?->nama }}, {{ now()->translatedFormat('d F Y') }}</p>
        @if ($instansi?->tte_pimpinan)
            <img src="{{ Storage::url($instansi->tte_pimpinan) }}" alt="Tanda Tangan">
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
    @include('pdf._kop')

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

    @include('pdf._ttd')

    {{-- QR CODE untuk PDF (PNG base64 agar DomPDF support) --}}
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

    /* KOP */
    .kop {
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 4px double #1a1a1a;
        padding-bottom: 10px;
        margin-bottom: 18px;
    }

    .kop img {
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

    /* JUDUL */
    h2.judul {
        text-align: center;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 18px 0 20px;
    }

    /* NOMOR */
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

    /* DATA */
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

    /* ISI */
    .isi p {
        text-indent: 1.5cm;
        margin-bottom: 10px;
        text-align: justify;
    }

    /* TTD */
    .ttd {
        display: flex;
        justify-content: flex-end;
        margin-top: 32px;
    }

    .ttd-box {
        text-align: center;
        width: 7cm;
        font-size: 11pt;
    }

    .ttd-box img {
        height: 72px;
        margin: 6px auto;
        display: block;
        object-fit: contain;
    }

    .ttd-box .nama {
        font-weight: bold;
        text-decoration: underline;
    }

    .ttd-box .nip {
        font-size: 10pt;
        color: #444;
    }

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

### 📄 File: `./resources/views/pdf/_kop.blade.php`

```blade
<div class="kop">
    @if ($instansi->logo_institusi)
        <img src="{{ public_path('storage/' . $instansi->logo_institusi) }}" alt="">
    @endif
    <div class="kop-text">
        <h1>{{ $instansi->nama }}</h1>
        <p>NPSN: {{ $instansi->npsn }}
            @if ($instansi->akreditasi) &bull; Akreditasi: {{ $instansi->akreditasi }} @endif
        </p>
    </div>
</div>

```

---

### 📄 File: `./resources/views/pdf/_ttd.blade.php`

```blade
<div class="ttd">
    <div class="ttd-box">
        <p>{{ $instansi->nama }},<br>{{ now()->translatedFormat('d F Y') }}</p>
        @if ($instansi->tte_pimpinan)
            <img src="{{ public_path('storage/' . $instansi->tte_pimpinan) }}" alt="TTD">
        @else
            <div style="height:72px;"></div>
        @endif
        <p class="nama">{{ $instansi->nama_pimpinan }}</p>
        @if ($instansi->nip_pimpinan)
            <p class="nip">NIP. {{ $instansi->nip_pimpinan }}</p>
        @endif
    </div>
</div>

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
use Maatwebsite\Excel\Facades\Excel;

Schedule::command(BroadcastKelulusan::class)
    ->dailyAt('07:00')
    ->when(
        fn() => TahunPelajaran::where('status', true)
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
        new class implements
            \Maatwebsite\Excel\Concerns\FromArray,
            \Maatwebsite\Excel\Concerns\WithHeadings,
            \Maatwebsite\Excel\Concerns\WithStyles,
            \Maatwebsite\Excel\Concerns\ShouldAutoSize {
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

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): array
            {
                return [1 => [
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D9488']]
                ]];
            }
        },
        'templates/template-siswa.xlsx',
        'public'
    );
    $this->info('✓ template-siswa.xlsx');

    // ── Template Personil ─────────────────────────────────────────
    Excel::store(
        new class implements
            \Maatwebsite\Excel\Concerns\FromArray,
            \Maatwebsite\Excel\Concerns\WithHeadings,
            \Maatwebsite\Excel\Concerns\WithStyles,
            \Maatwebsite\Excel\Concerns\ShouldAutoSize {
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

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): array
            {
                return [1 => [
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D9488']]
                ]];
            }
        },
        'templates/template-personil.xlsx',
        'public'
    );
    $this->info('✓ template-personil.xlsx');

    // ── Template Alumni ───────────────────────────────────────────
    Excel::store(
        new class implements
            \Maatwebsite\Excel\Concerns\FromArray,
            \Maatwebsite\Excel\Concerns\WithHeadings,
            \Maatwebsite\Excel\Concerns\WithStyles,
            \Maatwebsite\Excel\Concerns\ShouldAutoSize {
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

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): array
            {
                return [1 => [
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D9488']]
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

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::post('/cari', [LandingPageController::class, 'cari'])->name('landing.cari');
Route::get('/siswa/{siswa}', [LandingPageController::class, 'hasil'])->name('landing.hasil');
Route::get('/siswa/{siswa}/skl', [LandingPageController::class, 'cetakSkl'])
    ->name('landing.skl')
    ->middleware('throttle:30,1');
Route::get('/siswa/{siswa}/skl/pdf', [LandingPageController::class, 'cetakSklPdf'])
    ->name('landing.skl.pdf')
    ->middleware('throttle:10,1');
Route::get('/siswa/{siswa}/undangan', [LandingPageController::class, 'cetakUndangan'])
    ->name('landing.undangan')
    ->middleware('throttle:30,1');
Route::get('/siswa/{siswa}/undangan/pdf', [LandingPageController::class, 'cetakUndanganPdf'])
    ->name('landing.undangan.pdf')
    ->middleware('throttle:10,1');

Route::get('/personil', [PersonilController::class, 'index'])->name('personil.index');
Route::get('/personil/cari', [PersonilController::class, 'cari'])->name('personil.cari');

Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/cari', [AlumniController::class, 'cari'])->name('alumni.cari');

Route::middleware(JadwalKelulusanAktif::class)
    ->prefix('tamu')
    ->name('tamu.')
    ->group(function () {
        Route::get('/',                            [TamuUndanganController::class, 'index'])->name('index');
        Route::get('/scan',                        [TamuUndanganController::class, 'scanQr'])->name('scan');
        Route::post('/scan',                       [TamuUndanganController::class, 'processScan'])->name('scan.post');
        Route::get('/konfirmasi/{siswa}',          [TamuUndanganController::class, 'konfirmasi'])->name('konfirmasi');
        Route::post('/',                           [TamuUndanganController::class, 'store'])->name('store');
        Route::get('/cetak-hadir',                 [TamuUndanganController::class, 'cetakHadir'])->name('cetak-hadir');
    });

```

---
