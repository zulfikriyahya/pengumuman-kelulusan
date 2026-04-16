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
    "keywords": ["laravel", "framework"],
    "license": "MIT",
    "require": {
        "php": "^8.3",
        "barryvdh/laravel-dompdf": "*",
        "filament/filament": "*",
        "laravel-shift/blueprint": "*",
        "laravel/framework": "^13.0",
        "laravel/tinker": "^3.0",
        "maatwebsite/excel": "*",
        "simplesoftwareio/simple-qrcode": "*"
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",
        "laravel/pail": "^1.2.5",
        "laravel/pint": "^1.27",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.6",
        "pestphp/pest": "^4.5",
        "pestphp/pest-plugin-laravel": "^4.1"
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
        "@tailwindcss/vite": "^4.0.0",
        "axios": ">=1.11.0 <=1.14.0",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^3.0.0",
        "tailwindcss": "^4.0.0",
        "vite": "^8.0.0"
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
            input: ['resources/css/app.css', 'resources/js/app.js'],
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

### 📄 File: `./app/Actions/ImportDokumenSkl.php`

```php
<?php

namespace App\Actions;

use App\Models\Siswa;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Import satu atau banyak file PDF SKL.
 * Naming convention: <nisn>.pdf
 * Jika berkas sudah ada → replace (hapus lama, simpan baru).
 */
class ImportDokumenSkl
{
    /**
     * @param  UploadedFile[]  $files
     * @return array{berhasil: int, dilewati: int, gagal: int, log: string[]}
     */
    public function execute(array $files): array
    {
        $berhasil = $dilewati = $gagal = 0;
        $log = [];

        foreach ($files as $file) {
            $nisn = Str::beforeLast($file->getClientOriginalName(), '.pdf');

            if (! preg_match('/^\d{10}$/', $nisn)) {
                $log[] = "❌ Dilewati — nama file tidak valid: {$file->getClientOriginalName()}";
                $gagal++;
                continue;
            }

            $siswa = Siswa::where('nisn', $nisn)->first();

            if (! $siswa) {
                $log[] = "⚠️  Siswa dengan NISN {$nisn} tidak ditemukan.";
                $dilewati++;
                continue;
            }

            // Hapus berkas lama jika ada
            if ($siswa->berkas_skl && Storage::disk('public')->exists($siswa->berkas_skl)) {
                Storage::disk('public')->delete($siswa->berkas_skl);
            }

            $path = $file->storeAs('skl', "{$nisn}.pdf", 'public');

            $siswa->update(['berkas_skl' => $path]);
            $log[] = "✅ SKL {$nisn} berhasil diimpor.";
            $berhasil++;
        }

        return compact('berhasil', 'dilewati', 'gagal', 'log');
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
    protected $signature   = 'skl:broadcast {--force : Kirim tanpa cek jadwal}';
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
        $total  = $siswas->count();

        if ($total === 0) {
            $this->warn('Tidak ada siswa dengan nomor telepon terdaftar.');
            return self::SUCCESS;
        }

        $this->info("Mengirim ke {$total} siswa...");
        $bar    = $this->output->createProgressBar($total);
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

enum StatusSiswa: string
{
    case Lulus           = 'Lulus';
    case TidakLulus      = 'Tidak Lulus';
    case LulusBersyarat  = 'Lulus Bersyarat';

    public function label(): string
    {
        return match ($this) {
            self::Lulus          => 'Lulus',
            self::TidakLulus     => 'Tidak Lulus',
            self::LulusBersyarat => 'Lulus Bersyarat',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Lulus          => 'success',
            self::TidakLulus     => 'danger',
            self::LulusBersyarat => 'warning',
        };
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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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

class EditAlumni extends EditRecord
{
    protected static string $resource = AlumniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Pages/ListAlumnis.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Filament\Resources\Alumnis\AlumniResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlumnis extends ListRecords
{
    protected static string $resource = AlumniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
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

class ViewAlumni extends ViewRecord
{
    protected static string $resource = AlumniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Schemas/AlumniForm.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AlumniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('nisn')
                    ->required(),
                TextInput::make('tahun_lulus')
                    ->required(),
                TextInput::make('avatar'),
                Textarea::make('quote')
                    ->columnSpanFull(),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Schemas/AlumniInfolist.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AlumniInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('nama'),
                TextEntry::make('nisn'),
                TextEntry::make('tahun_lulus'),
                TextEntry::make('avatar')
                    ->placeholder('-'),
                TextEntry::make('quote')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Alumnis/Tables/AlumnisTable.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlumnisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('nisn')
                    ->searchable(),
                TextColumn::make('tahun_lulus')
                    ->searchable(),
                TextColumn::make('avatar')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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
            'create' => CreateInstansi::route('/create'),
            'view' => ViewInstansi::route('/{record}'),
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

class EditInstansi extends EditRecord
{
    protected static string $resource = InstansiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
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

class ListInstansis extends ListRecords
{
    protected static string $resource = InstansiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
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

class ViewInstansi extends ViewRecord
{
    protected static string $resource = InstansiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Instansis/Schemas/InstansiForm.php`

```php
<?php

namespace App\Filament\Resources\Instansis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InstansiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('npsn')
                    ->required(),
                TextInput::make('logo'),
                TextInput::make('logo_institusi'),
                TextInput::make('nomor_surat'),
                TextInput::make('nama_pimpinan'),
                TextInput::make('nip_pimpinan'),
                TextInput::make('tte_pimpinan'),
                TextInput::make('nama_ketua'),
                TextInput::make('nip_ketua'),
                TextInput::make('tte_ketua'),
                TextInput::make('jenjang')
                    ->required(),
                TextInput::make('akreditasi')
                    ->required(),
                Toggle::make('status')
                    ->required(),
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
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InstansiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('nama'),
                TextEntry::make('npsn'),
                TextEntry::make('logo')
                    ->placeholder('-'),
                TextEntry::make('logo_institusi')
                    ->placeholder('-'),
                TextEntry::make('nomor_surat')
                    ->placeholder('-'),
                TextEntry::make('nama_pimpinan')
                    ->placeholder('-'),
                TextEntry::make('nip_pimpinan')
                    ->placeholder('-'),
                TextEntry::make('tte_pimpinan')
                    ->placeholder('-'),
                TextEntry::make('nama_ketua')
                    ->placeholder('-'),
                TextEntry::make('nip_ketua')
                    ->placeholder('-'),
                TextEntry::make('tte_ketua')
                    ->placeholder('-'),
                TextEntry::make('jenjang'),
                TextEntry::make('akreditasi'),
                IconEntry::make('status')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Instansis/Tables/InstansisTable.php`

```php
<?php

namespace App\Filament\Resources\Instansis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InstansisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('npsn')
                    ->searchable(),
                TextColumn::make('logo')
                    ->searchable(),
                TextColumn::make('logo_institusi')
                    ->searchable(),
                TextColumn::make('nomor_surat')
                    ->searchable(),
                TextColumn::make('nama_pimpinan')
                    ->searchable(),
                TextColumn::make('nip_pimpinan')
                    ->searchable(),
                TextColumn::make('tte_pimpinan')
                    ->searchable(),
                TextColumn::make('nama_ketua')
                    ->searchable(),
                TextColumn::make('nip_ketua')
                    ->searchable(),
                TextColumn::make('tte_ketua')
                    ->searchable(),
                TextColumn::make('jenjang')
                    ->searchable(),
                TextColumn::make('akreditasi')
                    ->searchable(),
                IconColumn::make('status')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
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

### 📄 File: `./app/Filament/Resources/Personils/Pages/CreatePersonil.php`

```php
<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Filament\Resources\Personils\PersonilResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePersonil extends CreateRecord
{
    protected static string $resource = PersonilResource::class;
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

class EditPersonil extends EditRecord
{
    protected static string $resource = PersonilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/Pages/ListPersonils.php`

```php
<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Filament\Resources\Personils\PersonilResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPersonils extends ListRecords
{
    protected static string $resource = PersonilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
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

class ViewPersonil extends ViewRecord
{
    protected static string $resource = PersonilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
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

class PersonilResource extends Resource
{
    protected static ?string $model = Personil::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PersonilForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('nip'),
                TextInput::make('foto'),
                TextInput::make('telepon')
                    ->tel(),
                TextInput::make('sosial_media'),
                TextInput::make('jabatan')
                    ->required(),
                Textarea::make('quote')
                    ->columnSpanFull(),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/Schemas/PersonilInfolist.php`

```php
<?php

namespace App\Filament\Resources\Personils\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PersonilInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('nama'),
                TextEntry::make('nip')
                    ->placeholder('-'),
                TextEntry::make('foto')
                    ->placeholder('-'),
                TextEntry::make('telepon')
                    ->placeholder('-'),
                TextEntry::make('sosial_media')
                    ->placeholder('-'),
                TextEntry::make('jabatan'),
                TextEntry::make('quote')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Personils/Tables/PersonilsTable.php`

```php
<?php

namespace App\Filament\Resources\Personils\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PersonilsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('nip')
                    ->searchable(),
                TextColumn::make('foto')
                    ->searchable(),
                TextColumn::make('telepon')
                    ->searchable(),
                TextColumn::make('sosial_media')
                    ->searchable(),
                TextColumn::make('jabatan')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
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

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/Pages/ListSiswas.php`

```php
<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
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

class ViewSiswa extends ViewRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/Schemas/SiswaForm.php`

```php
<?php
// ──────────────────────────────────────────────────────────────
// app/Filament/Resources/Siswas/Schemas/SiswaForm.php
// fix: status pakai Select enum, bukan TextInput
// ──────────────────────────────────────────────────────────────

namespace App\Filament\Resources\Siswas\Schemas;

use App\Enums\StatusSiswa;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->required(),
            TextInput::make('nama_orangtua'),
            TextInput::make('nisn')
                ->required()
                ->maxLength(10),
            TextInput::make('berkas_skl')
                ->readOnly()
                ->helperText('Diisi otomatis saat import SKL.'),
            TextInput::make('telepon')
                ->tel()
                ->maxLength(15),
            // fix: Select enum, bukan TextInput
            Select::make('status')
                ->options(StatusSiswa::class)
                ->required()
                ->default(StatusSiswa::Lulus),
            TextInput::make('barcode_url')
                ->url()
                ->readOnly()
                ->helperText('Diisi otomatis saat import siswa.'),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/Siswas/Schemas/SiswaInfolist.php`

```php
<?php

namespace App\Filament\Resources\Siswas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SiswaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('id')->label('ID'),
            TextEntry::make('nama'),
            TextEntry::make('nama_orangtua')->placeholder('-'),
            TextEntry::make('nisn'),
            TextEntry::make('berkas_skl')->placeholder('-'),
            TextEntry::make('telepon')->placeholder('-'),
            // fix: badge berwarna sesuai status
            TextEntry::make('status')
                ->badge()
                ->color(fn($state) => $state?->color()),
            TextEntry::make('barcode_url')->placeholder('-'),
            TextEntry::make('created_at')->dateTime()->placeholder('-'),
            TextEntry::make('updated_at')->dateTime()->placeholder('-'),
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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('nama_orangtua')
                    ->searchable(),
                TextColumn::make('nisn')
                    ->searchable(),
                TextColumn::make('berkas_skl')
                    ->searchable(),
                TextColumn::make('telepon')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('barcode_url')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
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

class EditTahunPelajaran extends EditRecord
{
    protected static string $resource = TahunPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
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

class ListTahunPelajarans extends ListRecords
{
    protected static string $resource = TahunPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
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

class ViewTahunPelajaran extends ViewRecord
{
    protected static string $resource = TahunPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
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
use Filament\Schemas\Schema;

class TahunPelajaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                DateTimePicker::make('jadwal_pengumuman_mulai')
                    ->required(),
                DateTimePicker::make('jadwal_pengumuman_selesai')
                    ->required(),
                DateTimePicker::make('jadwal_kelulusan_mulai'),
                DateTimePicker::make('jadwal_kelulusan_selesai'),
                TextInput::make('jadwal_kelulusan_tempat'),
                Toggle::make('status')
                    ->required(),
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
use Filament\Schemas\Schema;

class TahunPelajaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('name'),
                TextEntry::make('jadwal_pengumuman_mulai')
                    ->dateTime(),
                TextEntry::make('jadwal_pengumuman_selesai')
                    ->dateTime(),
                TextEntry::make('jadwal_kelulusan_mulai')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('jadwal_kelulusan_selesai')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('jadwal_kelulusan_tempat')
                    ->placeholder('-'),
                IconEntry::make('status')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TahunPelajarans/Tables/TahunPelajaransTable.php`

```php
<?php

namespace App\Filament\Resources\TahunPelajarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TahunPelajaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('jadwal_pengumuman_mulai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('jadwal_pengumuman_selesai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('jadwal_kelulusan_mulai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('jadwal_kelulusan_selesai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('jadwal_kelulusan_tempat')
                    ->searchable(),
                IconColumn::make('status')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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
            'view' => ViewTahunPelajaran::route('/{record}'),
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

class EditTamuUndangan extends EditRecord
{
    protected static string $resource = TamuUndanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
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

class ListTamuUndangans extends ListRecords
{
    protected static string $resource = TamuUndanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
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

class ViewTamuUndangan extends ViewRecord
{
    protected static string $resource = TamuUndanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
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
use Filament\Schemas\Schema;

class TamuUndanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // fix: Select relationship
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
use Filament\Schemas\Schema;

class TamuUndanganInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('id')->label('ID'),
            // fix: pakai dot-notation relasi
            TextEntry::make('siswa.nama')->label('Siswa'),
            TextEntry::make('siswa.nisn')->label('NISN')->placeholder('-'),
            TextEntry::make('jumlah_tamu')->numeric()->placeholder('-'),
            TextEntry::make('created_at')->dateTime()->placeholder('-'),
            TextEntry::make('updated_at')->dateTime()->placeholder('-'),
        ]);
    }
}

```

---

### 📄 File: `./app/Filament/Resources/TamuUndangans/Tables/TamuUndangansTable.php`

```php
<?php

namespace App\Filament\Resources\TamuUndangans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TamuUndangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->toggleable(isToggledHiddenByDefault: true),
                // fix: relasi dot-notation
                TextColumn::make('siswa.nama')->label('Nama Siswa')->searchable()->sortable(),
                TextColumn::make('siswa.nisn')->label('NISN')->searchable(),
                TextColumn::make('jumlah_tamu')->numeric()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([ViewAction::make(), EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

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

use App\Http\Requests\AlumnusCariRequest;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumniController extends Controller
{
    public function index(Request $request): View
    {
        $alumnis = Alumni::orderBy('nama')->paginate(12);

        return view('alumni.index', ['alumnis' => $alumnis]);
    }

    public function cari(AlumnusCariRequest $request): View
    {
        // fix: ambil keyword dari field yang terisi
        $keyword = $request->filled('nisn')
            ? $request->validated('nisn')
            : $request->validated('nama');

        $alumnis = Alumni::where('nisn', $keyword)
            ->orWhere('nama', 'like', "%{$keyword}%")
            ->orderBy('nama')
            ->paginate(12)
            ->withQueryString();

        return view('alumni.index', [
            'alumnis' => $alumnis,
            'keyword' => $keyword,
        ]);
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

use App\Http\Requests\LandingPageCariRequest;
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
        $tahunPelajaran = TahunPelajaran::aktif()->first();

        return view('landing.index', [
            'tahunPelajaran' => $tahunPelajaran,
        ]);
    }

    public function cari(LandingPageCariRequest $request): View
    {
        $keyword = $request->keyword();

        $siswa = Siswa::where('nisn', $keyword)
            ->orWhere('telepon', $keyword)
            ->first();

        return view('landing.hasil', [
            'siswa'   => $siswa,
            'keyword' => $keyword,
        ]);
    }

    // fix: method baru — halaman hasil langsung via URL siswa
    public function hasil(Siswa $siswa): View
    {
        return view('landing.hasil', [
            'siswa'   => $siswa,
            'keyword' => $siswa->nisn,
        ]);
    }

    public function cetakSkl(Siswa $siswa): View
    {
        $tahunPelajaran = TahunPelajaran::aktif()->first();

        return view('landing.skl', [
            'siswa'          => $siswa,
            'tahunPelajaran' => $tahunPelajaran,
        ]);
    }

    // fix: method baru — render PDF SKL via DomPDF
    public function cetakSklPdf(Siswa $siswa): Response
    {
        $instansi       = Instansi::first();
        $tahunPelajaran = TahunPelajaran::aktif()->first();

        $pdf = Pdf::loadView('pdf.skl', compact('siswa', 'instansi', 'tahunPelajaran'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("SKL-{$siswa->nisn}.pdf");
    }

    public function cetakUndangan(Siswa $siswa): View
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak mendapatkan surat undangan.');

        $tahunPelajaran = TahunPelajaran::aktif()->first();

        return view('landing.undangan', [
            'siswa'          => $siswa,
            'tahunPelajaran' => $tahunPelajaran,
        ]);
    }

    // fix: method baru — render PDF Undangan via DomPDF
    public function cetakUndanganPdf(Siswa $siswa): Response
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak mendapatkan surat undangan.');

        $instansi       = Instansi::first();
        $tahunPelajaran = TahunPelajaran::aktif()->first();

        $pdf = Pdf::loadView('pdf.undangan', compact('siswa', 'instansi', 'tahunPelajaran'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Undangan-{$siswa->nisn}.pdf");
    }
}

```

---

### 📄 File: `./app/Http/Controllers/PersonilController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonilCariRequest;
use App\Models\Personil;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersonilController extends Controller
{
    public function index(Request $request): View
    {
        $personils = Personil::orderBy('jabatan')->get();

        return view('personil.index', [
            'personils' => $personils,
        ]);
    }

    public function cari(PersonilCariRequest $request): View
    {
        $keyword = $request->validated('nama');

        $personils = Personil::where('nama', 'like', "%{$keyword}%")
            ->orderBy('jabatan')
            ->get();

        return view('personil.index', [
            'personils' => $personils,
            'keyword'   => $keyword,
        ]);
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
    public function index(Request $request): View
    {
        $tamus = TamuUndangan::with('siswa')
            ->orderByDesc('created_at')
            ->paginate(20);

        // fix: hitung total PAX dari DB, bukan dari paginator (yang hanya halaman aktif)
        $totalPax    = TamuUndangan::sum('jumlah_tamu');
        $totalSiswa  = Siswa::whereIn('status', ['Lulus', 'Lulus Bersyarat'])->count();

        return view('tamu.index', [
            'tamuUndangans' => $tamus,
            'totalPax'      => $totalPax,
            'totalSiswa'    => $totalSiswa,
        ]);
    }

    public function scanQr(Request $request): View
    {
        return view('tamu.scan');
    }

    // fix: method baru — proses scan QR manual (POST dari form)
    public function processScan(Request $request): RedirectResponse
    {
        $request->validate([
            'kode' => ['required', 'string'],
        ]);

        $kode  = $request->input('kode');
        $siswa = Siswa::where('id', $kode)
            ->orWhere('nisn', $kode)
            ->first();

        if (! $siswa) {
            return back()->withErrors(['kode' => 'Siswa tidak ditemukan.'])->withInput();
        }

        return redirect()->route('tamu.konfirmasi', $siswa);
    }

    // fix: method baru — halaman konfirmasi kehadiran
    public function konfirmasi(Siswa $siswa): View
    {
        $sudahHadir = TamuUndangan::where('siswa_id', $siswa->id)->exists();

        return view('tamu.konfirmasi', [
            'siswa'       => $siswa,
            'sudahHadir'  => $sudahHadir,
        ]);
    }

    public function store(TamuUndanganStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        TamuUndangan::updateOrCreate(
            ['siswa_id'    => $data['siswa_id']],
            ['jumlah_tamu' => $data['jumlah_tamu'] ?? 1],
        );

        return redirect()->route('tamu.index')
            ->with('success', 'Tamu berhasil dicatat.');
    }

    // fix: method baru — cetak daftar hadir (view/PDF sederhana)
    public function cetakHadir(): View
    {
        $tamus = TamuUndangan::with('siswa')
            ->orderBy('created_at')
            ->get();

        return view('tamu.cetak-hadir', [
            'tamus'    => $tamus,
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
            // Pencarian by nama (like) atau nisn (exact) — salah satu wajib diisi
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
            // User cukup isi salah satu: nisn atau telepon
            'nisn' => ['required_without:telepon', 'nullable', 'string', 'max:10'],
            'telepon' => ['required_without:nisn', 'nullable', 'string', 'max:15'],
        ];
    }

    public function messages(): array
    {
        return [
            'nisn.required_without'     => 'Masukkan NISN atau nomor telepon.',
            'telepon.required_without'  => 'Masukkan NISN atau nomor telepon.',
        ];
    }

    // Kembalikan keyword tunggal yang diisi user
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
            // Hanya validasi siswa_id hasil scan QR
            'siswa_id' => ['required', 'uuid', 'exists:siswas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'siswa_id.required' => 'QR Code tidak terbaca.',
            'siswa_id.uuid'     => 'QR Code tidak valid.',
            'siswa_id.exists'   => 'Data siswa tidak ditemukan.',
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
            // fix: tambah where status lulus agar siswa tidak lulus tidak bisa check-in
            'siswa_id' => [
                'required',
                'uuid',
                Rule::exists('siswas', 'id')->where(
                    fn($q) => $q->whereIn('status', ['Lulus', 'Lulus Bersyarat'])
                ),
            ],
            'jumlah_tamu' => ['nullable', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'siswa_id.required' => 'QR Code tidak valid.',
            'siswa_id.uuid'     => 'QR Code tidak valid.',
            'siswa_id.exists'   => 'Siswa tidak ditemukan atau tidak berhak hadir.',
            'jumlah_tamu.min'   => 'Jumlah tamu minimal 1 orang.',
            'jumlah_tamu.max'   => 'Jumlah tamu maksimal 10 orang.',
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
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class AlumniImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): ?Alumni
    {
        // Skip baris tanpa nama atau nisn
        if (blank($row['nama'] ?? null) || blank($row['nisn'] ?? null)) {
            return null;
        }

        return new Alumni([
            'nama'        => $row['nama'],
            'nisn'        => $row['nisn'],
            'tahun_lulus' => $row['tahun_lulus'],
            'avatar'      => $row['avatar'] ?? null, // fix: field ada di model tapi tidak di-map
            'quote'       => $row['quote'] ?? null,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nisn';
    }
}

```

---

### 📄 File: `./app/Imports/PersonilImport.php`

```php
<?php

namespace App\Imports;

use App\Models\Personil;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PersonilImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): ?Personil
    {
        // Skip baris tanpa nama atau jabatan
        if (blank($row['nama'] ?? null) || blank($row['jabatan'] ?? null)) {
            return null;
        }

        return new Personil([
            'nama'         => $row['nama'],
            'nip'          => filled($row['nip'] ?? null) ? $row['nip'] : null,
            'jabatan'      => $row['jabatan'],
            'telepon'      => $row['telepon'] ?? null,
            'sosial_media' => $row['sosial_media'] ?? null,
            'quote'        => $row['quote'] ?? null,
        ]);
    }

    // nip nullable — upsert by nip hanya jika ada nilainya
    // Jika nip kosong, Laravel akan insert baru (bukan upsert)
    // Ini perilaku yang aman: personil tanpa NIP tidak saling tumpuk
    public function uniqueBy(): string
    {
        return 'nip';
    }
}

```

---

### 📄 File: `./app/Imports/SiswaImport.php`

```php
<?php
namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class SiswaImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): Siswa
    {
        return new Siswa([
            'nama'         => $row['nama'],
            'nama_orangtua'=> $row['nama_orangtua'] ?? null,
            'nisn'         => $row['nisn'],
            'telepon'      => $row['telepon'] ?? null,
            'status'       => $row['status'] ?? 'Lulus',
        ]);
    }

    /** Upsert key: nisn */
    public function uniqueBy(): string { return 'nisn'; }
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

    public int $tries   = 3;
    public int $backoff = 60; // detik antar retry otomatis Laravel

    public function __construct(
        private readonly Siswa $siswa,
        private readonly TahunPelajaran $tahunPelajaran,
    ) {}

    public function handle(): void
    {
        if (blank($this->siswa->telepon)) {
            return;
        }

        $pesan    = $this->buildPesan();
        $response = Http::withToken(config('services.wapi.token'))
            ->timeout(15)
            ->post(config('services.wapi.url'), [
                'phone'   => $this->siswa->telepon,
                'message' => $pesan,
            ]);

        // Lempar exception agar Laravel retry otomatis via $tries & $backoff
        // Jangan pakai $this->release() sekaligus $tries — akan double-count attempt
        if ($response->failed()) {
            Log::warning("WA gagal ke {$this->siswa->nisn} (attempt {$this->attempts()}): " . $response->body());

            throw new \RuntimeException("Gagal kirim WA ke {$this->siswa->nisn}: HTTP {$response->status()}");
        }

        Log::info("WA terkirim ke {$this->siswa->nisn}");
    }

    private function buildPesan(): string
    {
        $tp  = $this->tahunPelajaran;
        $url = config('app.url');

        $pesan  = "Assalamu'alaikum, {$this->siswa->nama}.\n\n";
        $pesan .= "Pengumuman Kelulusan sudah dapat diakses pada:\n";
        $pesan .= "🔗 {$url}\n\n";

        $adaJadwal = $tp->jadwal_kelulusan_mulai
            && $tp->jadwal_kelulusan_selesai
            && $tp->jadwal_kelulusan_tempat;

        if ($adaJadwal) {
            $mulai   = $tp->jadwal_kelulusan_mulai->translatedFormat('l, d F Y H:i');
            $selesai = $tp->jadwal_kelulusan_selesai->translatedFormat('H:i');

            $pesan .= "📅 Acara Kelulusan:\n";
            $pesan .= "Tanggal : {$mulai} – {$selesai} WIB\n";
            $pesan .= "Tempat  : {$tp->jadwal_kelulusan_tempat}\n\n";
        }

        $pesan .= "Selamat & semoga sukses! 🎓";

        return $pesan;
    }

    public function failed(\Throwable $e): void
    {
        Log::error("Broadcast WA gagal permanen untuk {$this->siswa->nisn}: " . $e->getMessage());
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
        'avatar',
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
        'telepon',
        'status',
        'barcode_url',
    ];

    protected function casts(): array
    {
        return [
            'status' => \App\Enums\StatusSiswa::class,
        ];
    }

    public function tamuUndangans(): HasMany
    {
        return $this->hasMany(TamuUndangan::class);
    }

    public function isLulus(): bool
    {
        return in_array($this->status, [
            \App\Enums\StatusSiswa::Lulus,
            \App\Enums\StatusSiswa::LulusBersyarat,
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
            'jadwal_pengumuman_mulai'  => 'datetime',
            'jadwal_pengumuman_selesai' => 'datetime',
            'jadwal_kelulusan_mulai'   => 'datetime',
            'jadwal_kelulusan_selesai' => 'datetime',
            'status'                   => 'boolean',
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
        if (!$this->jadwal_kelulusan_mulai || !$this->jadwal_kelulusan_selesai) {
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

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

```

---

### 📄 File: `./app/Providers/AppServiceProvider.php`

```php
<?php

namespace App\Providers;

use App\Models\Instansi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        view()->composer('*', function ($view) {
            // fix: cache query agar tidak hit DB di setiap request
            $instansi = Cache::remember('instansi.aktif', now()->addHour(), fn() => Instansi::first());
            $view->with('instansi', $instansi);
        });
    }
}

```

---

### 📄 File: `./app/Providers/Filament/AdminPanelProvider.php`

```php
<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken; // ← ganti ini
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class, // ← bukan PreventRequestForgery
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

```

---

## 📁 Directory: bootstrap (bootstrap)

### 📄 File: `./bootstrap/app.php`

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'jadwal.kelulusan' => \App\Http\Middleware\JadwalKelulusanAktif::class,
        ]);
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
    })->create(); // ← add ->create() here

```

---

### 📄 File: `./bootstrap/providers.php`

```php
<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
];

```

---

## 📁 Directory: config (Configuration)

Application configuration files.

### 📄 File: `./config/app.php`

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | which utilizes session storage plus the Eloquent user provider.
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | If you have multiple user tables or models you may configure multiple
    | providers to represent the model / table. These providers may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | These configuration options specify the behavior of Laravel's password
    | reset functionality, including the table utilized for token storage
    | and the user provider that is invoked to actually retrieve users.
    |
    | The expiry time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    | The throttle setting is the number of seconds a user must wait before
    | generating more password reset tokens. This prevents the user from
    | quickly generating a very large amount of password reset tokens.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the number of seconds before a password confirmation
    | window expires and users are asked to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];

```

---

### 📄 File: `./config/cache.php`

```php
<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache store that will be used by the
    | framework. This connection is utilized if another isn't explicitly
    | specified when running a cache operation inside the application.
    |
    */

    'default' => env('CACHE_STORE', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    | Supported drivers: "array", "database", "file", "memcached",
    |                    "redis", "dynamodb", "octane",
    |                    "failover", "null"
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing the APC, database, memcached, Redis, and DynamoDB cache
    | stores, there might be other applications using the same cache. For
    | that reason, you may prefix every cache key to avoid collisions.
    |
    */

    'prefix' => env('CACHE_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')).'-cache-'),

    /*
    |--------------------------------------------------------------------------
    | Serializable Classes
    |--------------------------------------------------------------------------
    |
    | This value determines the classes that can be unserialized from cache
    | storage. By default, no PHP classes will be unserialized from your
    | cache to prevent gadget chain attacks if your APP_KEY is leaked.
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'sqlite'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

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

### 📄 File: `./config/filesystems.php`

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
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

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that is utilized to write
    | messages to your logs. The value provided here should match one of
    | the channels present in the list of "channels" configured below.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => env('LOG_DEPRECATIONS_TRACE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Laravel
    | utilizes the Monolog PHP logging library, which includes a variety
    | of powerful log handlers and formatters that you're free to use.
    |
    | Available drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog", "custom", "stack"
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send all email
    | messages unless another mailer is explicitly specified when sending
    | the message. All additional mailers can be configured within the
    | "mailers" array. Examples of each type of mailer are provided.
    |
    */

    'default' => env('MAIL_MAILER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers that can be used
    | when delivering an email. You may specify which one you're using for
    | your mailers below. You may also add additional mailers if needed.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "resend", "log", "array",
    |            "failover", "roundrobin"
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all emails sent by your application to be sent from
    | the same address. Here you may specify a name and address that is
    | used globally for all emails that are sent by your application.
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Laravel's queue supports a variety of backends via a single, unified
    | API, giving you convenient access to each backend using identical
    | syntax for each. The default queue connection is defined below.
    |
    */

    'default' => env('QUEUE_CONNECTION', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection options for every queue backend
    | used by your application. An example configuration is provided for
    | each backend supported by Laravel. You're also free to add more.
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis",
    |          "deferred", "background", "failover", "null"
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Job Batching
    |--------------------------------------------------------------------------
    |
    | The following options configure the database and table that store job
    | batching information. These options can be updated to any database
    | connection and table which has been defined by your application.
    |
    */

    'batching' => [
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'job_batches',
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control how and where failed jobs are stored. Laravel ships with
    | support for storing failed jobs in a simple file or in a database.
    |
    | Supported drivers: "database-uuids", "dynamodb", "file", "null"
    |
    */

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

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

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

    'wapi' => [
      'url'   => env('WAPI_URL', 'https://wapi.zedlabs.id/send/messages'),
      'token' => env('WAPI_TOKEN'),
    ],

];

```

---

### 📄 File: `./config/session.php`

```php
<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option determines the default session driver that is utilized for
    | incoming requests. Laravel supports a variety of storage options to
    | persist session data. Database storage is a great default choice.
    |
    | Supported: "file", "cookie", "database", "memcached",
    |            "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that you wish the session
    | to be allowed to remain idle before it expires. If you want them
    | to expire immediately when the browser is closed then you may
    | indicate that via the expire_on_close configuration option.
    |
    */

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | This option allows you to easily specify that all of your session data
    | should be encrypted before it's stored. All encryption is performed
    | automatically by Laravel and you may use the session like normal.
    |
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | When utilizing the "file" session driver, the session files are placed
    | on disk. The default storage location is defined here; however, you
    | are free to provide another location where they should be stored.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | When using the "database" or "redis" session drivers, you may specify a
    | connection that should be used to manage these sessions. This should
    | correspond to a connection in your database configuration options.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify the table to
    | be used to store sessions. Of course, a sensible default is defined
    | for you; however, you're welcome to change this to another table.
    |
    */

    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | When using one of the framework's cache driven session backends, you may
    | define the cache store which should be used to store the session data
    | between requests. This must match one of your defined cache stores.
    |
    | Affects: "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Some session drivers must manually sweep their storage location to get
    | rid of old sessions from storage. Here are the chances that it will
    | happen on a given request. By default, the odds are 2 out of 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Here you may change the name of the session cookie that is created by
    | the framework. Typically, you should not need to change this value
    | since doing so does not grant a meaningful security improvement.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')).'-session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | The session cookie path determines the path for which the cookie will
    | be regarded as available. Typically, this will be the root path of
    | your application, but you're free to change this when necessary.
    |
    */

    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | This value determines the domain and subdomains the session cookie is
    | available to. By default, the cookie will be available to the root
    | domain without subdomains. Typically, this shouldn't be changed.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookies
    |--------------------------------------------------------------------------
    |
    | By setting this option to true, session cookies will only be sent back
    | to the server if the browser has a HTTPS connection. This will keep
    | the cookie from being sent to you when it can't be done securely.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will prevent JavaScript from accessing the
    | value of the cookie and the cookie will only be accessible through
    | the HTTP protocol. It's unlikely you should disable this option.
    |
    */

    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | This option determines how your cookies behave when cross-site requests
    | take place, and can be used to mitigate CSRF attacks. By default, we
    | will set this value to "lax" to permit secure cross-site requests.
    |
    | See: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#samesitesamesite-value
    |
    | Supported: "lax", "strict", "none", null
    |
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Partitioned Cookies
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will tie the cookie to the top-level site for
    | a cross-site context. Partitioned cookies are accepted by the browser
    | when flagged "secure" and the Same-Site attribute is set to "none".
    |
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

    /*
    |--------------------------------------------------------------------------
    | Session Serialization
    |--------------------------------------------------------------------------
    |
    | This value controls the serialization strategy for session data, which
    | is JSON by default. Setting this to "php" allows the storage of PHP
    | objects in the session but can make an application vulnerable to
    | "gadget chain" serialization attacks if the APP_KEY is leaked.
    |
    | Supported: "json", "php"
    |
    */

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

### 📄 File: `./database/factories/AlumniFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlumniFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->word(),
            'nisn' => fake()->regexify('[A-Za-z0-9]{10}'),
            'tahun_lulus' => fake()->regexify('[A-Za-z0-9]{4}'),
            'avatar' => fake()->word(),
            'quote' => fake()->text(),
        ];
    }
}

```

---

### 📄 File: `./database/factories/InstansiFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InstansiFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->word(),
            'npsn' => fake()->regexify('[A-Za-z0-9]{8}'),
            'logo' => fake()->word(),
            'logo_institusi' => fake()->word(),
            'nomor_surat' => fake()->word(),
            'nama_pimpinan' => fake()->word(),
            'nip_pimpinan' => fake()->word(),
            'tte_pimpinan' => fake()->word(),
            'nama_ketua' => fake()->word(),
            'nip_ketua' => fake()->word(),
            'tte_ketua' => fake()->word(),
            'jenjang' => fake()->randomElement(["SD","MI","SMP","MTS","SMA","SMK","MA"]),
            'akreditasi' => fake()->randomElement(["A","B","C","D","TT"]),
            'status' => fake()->boolean(),
        ];
    }
}

```

---

### 📄 File: `./database/factories/PersonilFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonilFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->word(),
            'nip' => fake()->word(),
            'foto' => fake()->word(),
            'telepon' => fake()->regexify('[A-Za-z0-9]{15}'),
            'sosial_media' => fake()->word(),
            'jabatan' => fake()->word(),
            'quote' => fake()->text(),
        ];
    }
}

```

---

### 📄 File: `./database/factories/SiswaFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama'          => fake()->name(),
            'nama_orangtua' => fake()->name(),
            'nisn'          => fake()->numerify('##########'), // fix: 10 digit numerik
            'berkas_skl'    => null,
            'telepon'       => fake()->numerify('08##########'),
            // fix: nilai sesuai enum PHP
            'status'        => fake()->randomElement(['Lulus', 'Tidak Lulus', 'Lulus Bersyarat']),
            'barcode_url'   => null,
        ];
    }
}

```

---

### 📄 File: `./database/factories/TahunPelajaranFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TahunPelajaranFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'jadwal_pengumuman_mulai' => fake()->dateTime(),
            'jadwal_pengumuman_selesai' => fake()->dateTime(),
            'jadwal_kelulusan_mulai' => fake()->dateTime(),
            'jadwal_kelulusan_selesai' => fake()->dateTime(),
            'jadwal_kelulusan_tempat' => fake()->word(),
            'status' => fake()->boolean(),
        ];
    }
}

```

---

### 📄 File: `./database/factories/TamuUndanganFactory.php`

```php
<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class TamuUndanganFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'jumlah_tamu' => fake()->numberBetween(-10000, 10000),
        ];
    }
}

```

---

### 📄 File: `./database/factories/UserFactory.php`

```php
<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

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
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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

    /**
     * Reverse the migrations.
     */
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
            $table->enum('jenjang', ["SD","MI","SMP","MTS","SMA","SMK","MA"]);
            $table->enum('akreditasi', ["A","B","C","D","TT"]);
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
            $table->string('telepon', 15)->unique()->nullable();
            $table->enum('status', ['Lulus', 'Tidak Lulus', 'Lulus Bersyarat'])->default('Lulus');
            $table->string('barcode_url')->nullable();
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
            // fix: uuid, bukan foreignId()
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
            $table->string('avatar')->nullable();
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

### 📄 File: `./database/seeders/DatabaseSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
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

if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__ . '/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->handleRequest(Request::capture());

```

---

### 📄 File: `./public/robots.txt`

```text
User-agent: *
Disallow:

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
        'title' => 'Alumni',
        'searchRoute' => 'alumni.cari',
        'clearRoute' => 'alumni.index',
        'placeholder' => 'Nama atau NISN&hellip;',
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
                use App\Enums\StatusSiswa;
                [$themeClass, $iconLabel, $statusLabel] = match ($siswa->status) {
                    StatusSiswa::Lulus => ['theme-lulus', 'LULUS', $siswa->status->label()],
                    StatusSiswa::TidakLulus => ['theme-tidak', 'TIDAK', $siswa->status->label()],
                    StatusSiswa::LulusBersyarat => ['theme-syarat', 'SYARAT', $siswa->status->label()],
                };
            @endphp

            <div class="card {{ $themeClass }}" style="overflow:hidden;">
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
                                    @if ($mono) style="font-family:monospace;" @endif>{{ $val }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="result-actions">
                    @if ($siswa->berkas_skl)
                        <a href="{{ route('landing.skl', $siswa) }}" target="_blank" class="doc-btn doc-btn-primary">
                            Unduh Surat Keterangan Lulus
                        </a>
                    @else
                        <div class="doc-btn doc-btn-disabled">Dokumen SKL belum tersedia &mdash; hubungi sekolah</div>
                    @endif

                    @if ($siswa->isLulus())
                        <a href="{{ route('landing.undangan', $siswa) }}" target="_blank" class="doc-btn doc-btn-outline">
                            Cetak Surat Undangan Kelulusan
                        </a>
                    @endif
                </div>
            </div>

            @if ($siswa->status === StatusSiswa::Lulus)
                <p class="result-footer-note">Selamat! Semoga sukses di jenjang berikutnya.</p>
            @elseif ($siswa->status === StatusSiswa::LulusBersyarat)
                <p class="result-footer-note" style="color:#fbbf24;">Segera hubungi sekolah untuk informasi lebih lanjut.
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

        /* Envelope */
        .amplop-section {
            display: flex;
            justify-content: center;
            padding: 1.25rem 2rem 0;
            animation: fade-up .8s ease both .35s;
        }

        .amplop-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .7rem;
        }

        .amplop-hint {
            font-size: .7rem;
            color: var(--muted);
            letter-spacing: .04em;
            animation: float 2s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
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
        $sudahBuka = $tp && $now->gte($tp->jadwal_pengumuman_mulai);
        $sudahTutup = $tp && $now->gt($tp->jadwal_pengumuman_selesai);
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
                        &nbsp;&middot;&nbsp; Tahun Pelajaran {{ $tp->name }}
                    @endif
                </p>

                @if (!$tp)
                    <div class="card state-card" style="margin-top:2.25rem;">
                        <div class="state-title">Informasi Belum Tersedia</div>
                        <div class="state-sub">Hubungi pihak sekolah untuk informasi lebih lanjut mengenai pengumuman
                            kelulusan.</div>
                    </div>
                @elseif ($belumBuka)
                    <div class="status-badge status-badge-warn">
                        Pengumuman dibuka pada {{ $tp->jadwal_pengumuman_mulai->translatedFormat('d F Y &middot; H:i') }}
                        WIB
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
                @elseif ($sudahTutup)
                    <div class="card state-card"
                        style="margin-top:2.25rem;background:rgba(245,158,11,.05);border-color:rgba(245,158,11,.18);">
                        <div class="state-title" style="color:#fbbf24;">Periode Pengumuman Telah Berakhir</div>
                        <div class="state-sub">Hubungi sekolah untuk informasi lebih lanjut.</div>
                    </div>
                @elseif ($sudahBuka)
                    <div class="amplop-section" id="amplop-section">
                        <button onclick="bukaAmplop()" id="amplop-btn" class="amplop-btn" aria-label="Buka amplop">
                            <div id="amplop"
                                style="position:relative;width:270px;height:180px;transition:all .5s ease;filter:drop-shadow(0 14px 36px rgba(13,148,136,.28))">
                                <svg viewBox="0 0 270 180" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    style="width:100%;height:100%">
                                    <rect width="270" height="180" rx="15" fill="#0d9488" />
                                    <rect width="270" height="180" rx="15" fill="url(#eg)" />
                                    <path d="M0 180 L135 104 L270 180Z" fill="#0f766e" />
                                    <path id="amplop-lid" d="M0 20 L135 102 L270 20 L270 0 L0 0Z" fill="#14b8a6"
                                        style="transform-origin:50% 0%;transition:transform .5s ease,opacity .5s ease;" />
                                    <path d="M0 20 L135 102 L270 20" stroke="rgba(94,234,212,.35)" stroke-width="1.5"
                                        fill="none" />
                                    <text x="135" y="150" text-anchor="middle" fill="rgba(255,255,255,.75)" font-size="10"
                                        font-family="var(--font-body),sans-serif" font-weight="600"
                                        letter-spacing="0.5">Ketuk untuk membuka</text>
                                    <defs>
                                        <linearGradient id="eg" x1="0" y1="0" x2="270"
                                            y2="180" gradientUnits="userSpaceOnUse">
                                            <stop offset="0%" stop-color="rgba(20,184,166,.28)" />
                                            <stop offset="100%" stop-color="rgba(13,148,136,0)" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <span class="amplop-hint">Ketuk amplop &uarr;</span>
                        </button>
                    </div>

                    <div id="cari-section" class="hidden" style="padding:0 1rem">
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
                                <button type="submit" class="btn btn-primary"
                                    style="width:100%;justify-content:center;">Cari Kelulusan</button>
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
                ['seconds', Math.floor((diff % 60000) / 1000)]
            ].forEach(([k, v]) => {
                const el = document.getElementById('cd-' + k);
                if (el) el.textContent = pad(v);
            });
        }
        if (document.getElementById('cd-seconds')) {
            tickCountdown();
            setInterval(tickCountdown, 1000);
        }

        function tampilkanForm() {
            document.getElementById('amplop-section')?.classList.add('hidden');
            const cari = document.getElementById('cari-section');
            if (!cari) return;
            cari.classList.remove('hidden');
            cari.classList.add('animate-fade-slide-up');
            setTimeout(() => cari.querySelector('input')?.focus(), 50);
        }

        function bukaAmplop() {
            const lid = document.getElementById('amplop-lid');
            const btn = document.getElementById('amplop-btn');
            if (!lid || btn.disabled) return;
            btn.disabled = true;
            lid.style.transform = 'rotateX(-180deg)';
            lid.style.opacity = '0';
            setTimeout(() => {
                const a = document.getElementById('amplop');
                if (a) {
                    a.style.transform = 'scale(.8)';
                    a.style.opacity = '0';
                }
            }, 400);
            setTimeout(tampilkanForm, 750);
            try {
                localStorage.setItem('amplop_dibuka', '1');
            } catch (e) {}
        }

        try {
            if (localStorage.getItem('amplop_dibuka') === '1') tampilkanForm();
        } catch (e) {}
        @if ($errors->any())
            tampilkanForm();
        @endif
    </script>
@endpush

```

---

### 📄 File: `./resources/views/landing/skl.blade.php`

```blade
@extends('layouts.app')
@section('title', 'SKL — ' . $siswa->nama)

@push('styles')
    @include('partials._doc-styles')
@endpush

@section('content')
    <div class="doc-wrap">
        <div class="doc-toolbar print:hidden">
            <a href="{{ route('landing.hasil', $siswa) }}" class="doc-back">
                <span>&larr;</span> Kembali
            </a>
            <a href="{{ route('landing.skl.pdf', $siswa) }}" target="_blank" class="btn btn-primary"
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
                </table>

                <h2 class="doc-title">Surat Keterangan Lulus</h2>

                <p class="doc-para">Yang bertanda tangan di bawah ini, Kepala {{ $instansi?->nama }}, menerangkan bahwa
                    siswa berikut:</p>

                <table class="doc-data">
                    <tr>
                        <td class="lbl">Nama Lengkap</td>
                        <td class="sep">:</td>
                        <td class="val">{{ $siswa->nama }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">NISN</td>
                        <td class="sep">:</td>
                        <td class="val">{{ $siswa->nisn }}</td>
                    </tr>
                    @if ($siswa->nama_orangtua)
                        <tr>
                            <td class="lbl">Nama Orang Tua</td>
                            <td class="sep">:</td>
                            <td class="val">{{ $siswa->nama_orangtua }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="lbl">Tahun Pelajaran</td>
                        <td class="sep">:</td>
                        <td class="val">{{ $tahunPelajaran?->name ?? '&mdash;' }}</td>
                    </tr>
                </table>

                @php
                    use App\Enums\StatusSiswa;
                    $statusText = match ($siswa->status) {
                        StatusSiswa::Lulus => 'dinyatakan <strong>LULUS</strong> dari satuan pendidikan',
                        StatusSiswa::LulusBersyarat
                            => 'dinyatakan <strong>LULUS BERSYARAT</strong> dari satuan pendidikan',
                        StatusSiswa::TidakLulus => 'dinyatakan <strong>TIDAK LULUS</strong> dari satuan pendidikan',
                    };
                @endphp

                <p class="doc-para">
                    Telah mengikuti dan menyelesaikan seluruh program pendidikan, dan {!! $statusText !!}
                    {{ $instansi?->nama }} Tahun Pelajaran {{ $tahunPelajaran?->name ?? '&mdash;' }}.
                </p>

                <p class="doc-para">Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat digunakan
                    sebagaimana mestinya.</p>

                @include('partials._ttd')

                @if ($siswa->barcode_url)
                    <div class="qr-block">
                        <img src="{{ $siswa->barcode_url }}" alt="QR Code">
                        <p>Scan untuk verifikasi</p>
                    </div>
                @endif
            </div>
        </div>

        <p class="doc-note print:hidden">Dokumen ini sah jika dicetak menggunakan tombol <strong>Unduh PDF</strong> di atas.
        </p>
    </div>
@endsection

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
                    beserta putra/putri atas nama <strong>{{ $siswa->nama }}</strong> (NISN: {{ $siswa->nisn }})
                    untuk menghadiri acara Wisuda &amp; Pengambilan Ijazah yang akan dilaksanakan pada:
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
                    <div class="doc-alert">Jadwal acara belum ditentukan. Pantau informasi dari sekolah.</div>
                @endif

                <p class="doc-para">Atas kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>
                <p class="doc-para">Wassalamu&rsquo;alaikum Warahmatullahi Wabarakatuh.</p>

                @include('partials._ttd')

                @if ($siswa->barcode_url)
                    <div class="qr-block">
                        <img src="{{ $siswa->barcode_url }}" alt="QR Code">
                        <p>Scan QR untuk verifikasi kehadiran di lokasi</p>
                    </div>
                @endif
            </div>
        </div>

        <p class="doc-note print:hidden">Dokumen ini sah jika dicetak menggunakan tombol <strong>Unduh PDF</strong> di atas.
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
            background-image: linear-gradient(rgba(13, 148, 136, .035) 1px, transparent 1px), linear-gradient(90deg, rgba(13, 148, 136, .035) 1px, transparent 1px);
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
            max-height: 380px;
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
            <li><a href="{{ route('personil.index') }}"
                    class="{{ request()->routeIs('personil*') ? 'active' : '' }}">Personil</a></li>
            <li><a href="{{ route('alumni.index') }}"
                    class="{{ request()->routeIs('alumni*') ? 'active' : '' }}">Alumni</a></li>
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
        [...drawer.querySelectorAll('a'), ...document.querySelectorAll('.d-link')].forEach(a =>
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
{{-- resources/views/partials/_doc-styles.blade.php --}}
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
{{--
    resources/views/partials/_kop-surat.blade.php
    Digunakan oleh: landing/skl, landing/undangan
--}}
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
{{--
    resources/views/partials/_page-header.blade.php

    Props:
      $title        — judul halaman
      $searchRoute  — route name untuk form action
      $clearRoute   — route name untuk tombol clear
      $placeholder  — placeholder input
      $keyword      — keyword aktif (optional)
      $totalFound   — jumlah data ditemukan (optional)
--}}

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
{{--
    resources/views/partials/_people-grid.blade.php
    Digunakan oleh: alumni/index & personil/index

    Props (via @include):
      $items       — collection (alumni / personil)
      $photoKey    — field name untuk foto ('avatar' | 'foto')
      $subKey      — field name untuk sub-title ('tahun_lulus' | 'jabatan')
      $subPrefix   — string prefix ('Lulus ' | '')
      $subColor    — CSS color string ('' | 'var(--teal-xl)')
      $monoKey     — field untuk monospace ('nisn' | 'nip')
      $routePrefix — untuk pagination links, jika perlu
      $keyword     — search keyword (optional)
--}}

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
{{-- resources/views/partials/_people-styles.blade.php --}}
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
{{--
    resources/views/partials/_ttd.blade.php
    Digunakan oleh: landing/skl, landing/undangan
--}}
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

### 📄 File: `./resources/views/pdf/skl.blade.php`

```blade
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SKL - {{ $siswa->nama }}</title>
    @include('pdf._base-styles')
</head>

<body>
    @include('pdf._kop')

    <table class="nomor">
        <tr>
            <td class="lbl">Nomor</td>
            <td class="sep">:</td>
            <td>{{ $instansi->nomor_surat ?? '-' }}</td>
        </tr>
    </table>

    <h2 class="judul">Surat Keterangan Lulus</h2>

    <div class="isi">
        <p>Yang bertanda tangan di bawah ini, Kepala {{ $instansi->nama }}, menerangkan bahwa siswa berikut:</p>
    </div>

    <table class="data">
        <tr>
            <td class="lbl">Nama Lengkap</td>
            <td class="sep">:</td>
            <td class="val">{{ $siswa->nama }}</td>
        </tr>
        <tr>
            <td class="lbl">NISN</td>
            <td class="sep">:</td>
            <td class="val">{{ $siswa->nisn }}</td>
        </tr>
        @if ($siswa->nama_orangtua)
            <tr>
                <td class="lbl">Nama Orang Tua / Wali</td>
                <td class="sep">:</td>
                <td class="val">{{ $siswa->nama_orangtua }}</td>
            </tr>
        @endif
        <tr>
            <td class="lbl">Tahun Pelajaran</td>
            <td class="sep">:</td>
            <td class="val">{{ $tahunPelajaran->name }}</td>
        </tr>
    </table>

    @php
        use App\Enums\StatusSiswa;
        $statusText = match ($siswa->status) {
            StatusSiswa::Lulus => 'dinyatakan <b>LULUS</b> dari satuan pendidikan',
            StatusSiswa::LulusBersyarat => 'dinyatakan <b>LULUS BERSYARAT</b> dari satuan pendidikan',
            StatusSiswa::TidakLulus => 'dinyatakan <b>TIDAK LULUS</b> dari satuan pendidikan',
        };
    @endphp

    <div class="isi">
        <p>Telah mengikuti dan menyelesaikan seluruh program pendidikan, dan {!! $statusText !!}
            {{ $instansi->nama }} Tahun Pelajaran {{ $tahunPelajaran->name }}.</p>
        <p>Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat digunakan sebagaimana mestinya.</p>
    </div>

    @include('pdf._ttd')

    @if ($siswa->barcode_url)
        <div class="qr-box">
            <img src="{{ $siswa->barcode_url }}" alt="QR Code">
            <p>Scan untuk verifikasi</p>
        </div>
    @endif
</body>

</html>

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
        <p>Dengan hormat, kami mengundang Bapak/Ibu <b>{{ $siswa->nama_orangtua ?? 'Orang Tua/Wali' }}</b> beserta
            putra/putri atas nama <b>{{ $siswa->nama }}</b> (NISN: {{ $siswa->nisn }}) untuk menghadiri acara Wisuda
            &amp; Pengambilan Ijazah yang akan dilaksanakan pada:</p>
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

    @if ($siswa->barcode_url)
        <div class="qr-box">
            <img src="{{ $siswa->barcode_url }}" alt="QR Code">
            <p>Scan untuk verifikasi kehadiran di lokasi acara</p>
        </div>
    @endif
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

    /* QR */
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
{{-- resources/views/pdf/_kop.blade.php --}}
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
{{-- resources/views/pdf/_ttd.blade.php --}}
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

### 📄 File: `./resources/views/personil/index.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Personil')

@push('styles')
    @include('partials._people-styles')
@endpush

@section('content')
    @include('partials._page-header', [
        'title' => 'Personil',
        'searchRoute' => 'personil.cari',
        'clearRoute' => 'personil.index',
        'placeholder' => 'Cari nama&hellip;',
        'keyword' => $keyword ?? null,
        'totalFound' => $personils->count() ?? null,
    ])

    @include('partials._people-grid', [
        'items' => $personils,
        'photoKey' => 'foto',
        'subKey' => 'jabatan',
        'subPrefix' => '',
        'subColor' => 'var(--teal-xl)',
        'monoKey' => 'nip',
        'keyword' => $keyword ?? null,
    ])
@endsection

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
                        <td style="font-weight:600">{{ $t->siswa?->nama ?? '&mdash;' }}</td>
                        <td class="tamu-hide" style="color:var(--muted)">{{ $t->siswa?->nama_orangtua ?? '&mdash;' }}</td>
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
            margin: 0 auto
        }

        .scan-title {
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: -.03em;
            margin-bottom: .35rem;
            font-family: var(--font-display)
        }

        .scan-sub {
            font-size: .8rem;
            color: var(--muted);
            margin-bottom: 1.4rem
        }

        .scanner-card {
            padding: 1.1rem;
            border-radius: var(--radius);
            margin-bottom: .9rem
        }

        #qr-region {
            border-radius: 11px;
            overflow: hidden;
            background: rgba(13, 148, 136, .04);
            aspect-ratio: 1
        }

        #qr-region video {
            border-radius: 11px;
            width: 100% !important
        }

        .qr-status-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            margin-top: .8rem
        }

        .qr-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--muted2);
            transition: background .3s
        }

        .qr-text {
            font-size: .73rem;
            color: var(--muted)
        }

        .manual-card {
            padding: 1.4rem;
            border-radius: var(--radius)
        }

        .manual-label {
            font-size: .78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: .8rem
        }

        .manual-form {
            display: flex;
            gap: .55rem
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
            color: var(--muted2)
        }

        .manual-input:focus {
            border-color: rgba(20, 184, 166, .42);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, .1)
        }

        .manual-input.is-error {
            border-color: rgba(220, 38, 38, .4)
        }
    </style>
@endpush

@section('content')
    <div class="scan-wrap">
        <h1 class="scan-title">Scan QR Undangan</h1>
        <p class="scan-sub">Arahkan kamera ke QR Code pada surat undangan siswa.</p>

        <div class="card scanner-card">
            <div id="qr-region"></div>
            <div class="qr-status-row">
                <span id="qr-dot" class="qr-dot"></span>
                <span id="qr-status" class="qr-text">Menginisialisasi kamera&hellip;</span>
            </div>
        </div>

        <div class="card manual-card">
            <div class="manual-label">Atau masukkan kode secara manual:</div>
            <form action="{{ route('tamu.scan.post') }}" method="POST" class="manual-form">
                @csrf
                <input type="text" name="kode" placeholder="ID Siswa / NISN"
                    class="manual-input {{ $errors->has('kode') ? 'is-error' : '' }}">
                <button type="submit" class="btn btn-primary"
                    style="font-size:.8rem;padding:.58rem 1rem;flex-shrink:0">Cari</button>
            </form>
            @error('kode')
                <p style="font-size:.72rem;color:#f87171;margin-top:.55rem;">&times; {{ $message }}</p>
            @enderror
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S09FkAP0l+F+VxQJr6B29Y5xMRCYAkELf2jNOGa+7kBvPKB4OIDHPx/8FBGqW2Y6UiRjg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const statusEl = document.getElementById('qr-status');
        const dotEl = document.getElementById('qr-dot');
        let scanned = false;

        function setStatus(msg, color = 'var(--muted2)') {
            statusEl.textContent = msg;
            dotEl.style.background = color;
        }

        const html5Qr = new Html5Qrcode('qr-region');
        Html5Qrcode.getCameras()
            .then(cameras => {
                if (!cameras.length) {
                    setStatus('Tidak ada kamera ditemukan.', '#f87171');
                    return;
                }
                const cam = cameras.find(c => /back|rear|environment/i.test(c.label)) ?? cameras[cameras.length - 1];
                setStatus('Kamera aktif — arahkan ke QR Code', 'var(--teal-xl)');
                html5Qr.start(cam.id, {
                    fps: 10,
                    qrbox: {
                        width: 230,
                        height: 230
                    }
                }, text => {
                    if (scanned) return;
                    scanned = true;
                    setStatus('QR terdeteksi, mengalihkan\u2026', 'var(--teal-xl)');
                    html5Qr.stop().catch(() => {});
                    window.location.href = '{{ route('tamu.konfirmasi', ['siswa' => ':id']) }}'.replace(':id',
                        encodeURIComponent(text));
                }).catch(() => setStatus('Gagal memulai kamera.', '#f87171'));
            })
            .catch(() => setStatus('Akses kamera ditolak. Gunakan input manual.', '#fbbf24'));
    </script>
@endpush

```

---

## 📁 Directory: routes (Routes)

Application routing definitions.

### 📄 File: `./routes/api.php`

```php
<?php

use Illuminate\Support\Facades\Route;

```

---

### 📄 File: `./routes/console.php`

```php
<?php

use App\Console\Commands\BroadcastKelulusan;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Broadcast otomatis setiap hari pukul 07:00
| Hanya berjalan jika hari ini adalah hari jadwal_pengumuman_mulai
|--------------------------------------------------------------------------
*/

Schedule::command(BroadcastKelulusan::class)
    ->dailyAt('07:00')
    ->when(
        fn() => \App\Models\TahunPelajaran::where('status', true)
            ->whereDate('jadwal_pengumuman_mulai', today())
            ->exists()
    );

Artisan::command('inspire', function () {
    $this->comment(\Illuminate\Foundation\Inspiring::quote());
})->purpose('Display an inspiring quote');

```

---

### 📄 File: `./routes/web.php`

```php
<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PersonilController;
use App\Http\Controllers\TamuUndanganController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page & Kelulusan
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::post('/cari', [LandingPageController::class, 'cari'])->name('landing.cari');       // fix: GET → POST
Route::get('/siswa/{siswa}', [LandingPageController::class, 'hasil'])->name('landing.hasil'); // fix: route baru
Route::get('/siswa/{siswa}/skl', [LandingPageController::class, 'cetakSkl'])
    ->name('landing.skl')
    ->middleware('throttle:30,1');
Route::get('/siswa/{siswa}/skl/pdf', [LandingPageController::class, 'cetakSklPdf'])      // fix: route baru
    ->name('landing.skl.pdf')
    ->middleware('throttle:10,1');
Route::get('/siswa/{siswa}/undangan', [LandingPageController::class, 'cetakUndangan'])
    ->name('landing.undangan')
    ->middleware('throttle:30,1');
Route::get('/siswa/{siswa}/undangan/pdf', [LandingPageController::class, 'cetakUndanganPdf']) // fix: route baru
    ->name('landing.undangan.pdf')
    ->middleware('throttle:10,1');

/*
|--------------------------------------------------------------------------
| Personil
|--------------------------------------------------------------------------
*/
Route::get('/personil', [PersonilController::class, 'index'])->name('personil.index');
Route::get('/personil/cari', [PersonilController::class, 'cari'])->name('personil.cari');

/*
|--------------------------------------------------------------------------
| Alumni
|--------------------------------------------------------------------------
*/
Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/cari', [AlumniController::class, 'cari'])->name('alumni.cari');

/*
|--------------------------------------------------------------------------
| Tamu Undangan (hanya aktif dalam rentang jadwal kelulusan)
|--------------------------------------------------------------------------
*/
Route::middleware(\App\Http\Middleware\JadwalKelulusanAktif::class)
    ->prefix('tamu')
    ->name('tamu.')
    ->group(function () {
        Route::get('/', [TamuUndanganController::class, 'index'])->name('index');
        Route::get('/scan', [TamuUndanganController::class, 'scanQr'])->name('scan');
        Route::post('/scan', [TamuUndanganController::class, 'processScan'])->name('scan.post'); // fix: baru
        Route::get('/konfirmasi/{siswa}', [TamuUndanganController::class, 'konfirmasi'])->name('konfirmasi'); // fix: baru
        Route::post('/', [TamuUndanganController::class, 'store'])->name('store');
        Route::get('/cetak-hadir', [TamuUndanganController::class, 'cetakHadir'])->name('cetak-hadir'); // fix: baru
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
