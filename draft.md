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

@section('content')

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-green-700">Alumni</h1>
            @if (isset($keyword))
                <p class="text-sm text-gray-400 mt-0.5">
                    Hasil pencarian untuk <span class="font-semibold text-gray-600">"{{ $keyword }}"</span>
                    &mdash; {{ $alumnis->total() }} data
                </p>
            @endif
        </div>

        <form action="{{ route('alumni.cari') }}" method="GET" class="flex gap-2">
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none">🔎</span>
                <input type="text" name="nama" value="{{ request('nama', $keyword ?? '') }}"
                    placeholder="Nama atau NISN…"
                    class="border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm w-52
                          focus:outline-none focus:ring-2 focus:ring-green-500 transition">
            </div>
            <button
                class="bg-green-600 hover:bg-green-700 active:scale-[0.98]
                       text-white px-4 py-2 rounded-xl text-sm transition">
                Cari
            </button>
            @if (isset($keyword))
                <a href="{{ route('alumni.index') }}"
                    class="px-3 py-2 rounded-xl text-sm text-gray-400 hover:text-gray-600
                      border border-gray-200 hover:border-gray-300 transition">
                    ✕
                </a>
            @endif
        </form>
    </div>

    @if ($alumnis->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <p class="text-4xl mb-3">🔍</p>
            <p class="text-sm">
                Tidak ada data alumni{{ isset($keyword) ? ' untuk "' . $keyword . '"' : '' }}.
            </p>
            @if (isset($keyword))
                <a href="{{ route('alumni.index') }}" class="inline-block mt-3 text-xs text-green-600 hover:underline">
                    Lihat semua alumni
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach ($alumnis as $a)
                <div
                    class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-gray-100
                transition-all duration-200 hover:-translate-y-0.5 p-5 text-center group">
                    @if ($a->avatar)
                        <img src="{{ Storage::url($a->avatar) }}" alt="{{ $a->nama }}"
                            class="w-16 h-16 rounded-full object-cover mx-auto mb-3
                        ring-2 ring-blue-100 group-hover:ring-blue-300 transition">
                    @else
                        <div
                            class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center
                        mx-auto mb-3 ring-2 ring-blue-100 group-hover:ring-blue-300 transition">
                            <span class="text-blue-600 font-bold text-xl">
                                {{ strtoupper(substr($a->nama, 0, 1)) }}
                            </span>
                        </div>
                    @endif

                    <p class="font-semibold text-sm leading-tight">{{ $a->nama }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Lulus {{ $a->tahun_lulus }}</p>
                    <p class="text-xs text-gray-300 font-mono mt-0.5">{{ $a->nisn }}</p>

                    @if ($a->quote)
                        <p class="text-xs text-gray-400 italic mt-2 line-clamp-2 leading-relaxed">
                            "{{ $a->quote }}"
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $alumnis->links() }}</div>
    @endif

@endsection

```

---

### 📄 File: `./resources/views/landing/hasil.blade.php`

```blade
@extends('layouts.app')
@section('title', $siswa ? 'Hasil — ' . $siswa->nama : 'Siswa Tidak Ditemukan')

@section('content')
    <div class="max-w-lg mx-auto">

        {{-- Kembali --}}
        <a href="{{ route('landing') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-green-700 mb-5 transition group">
            <span class="group-hover:-translate-x-0.5 transition-transform">←</span>
            Kembali ke Pencarian
        </a>

        {{-- ══ Tidak ditemukan ══ --}}
        @if (!$siswa)
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-10 text-center">
                <p class="text-5xl mb-4">🔍</p>
                <h2 class="font-bold text-gray-700 text-lg mb-1">Data Tidak Ditemukan</h2>
                <p class="text-sm text-gray-400 mb-6">
                    Tidak ada siswa dengan NISN atau nomor telepon
                    <span class="font-mono font-semibold text-gray-600">"{{ $keyword }}"</span>.
                </p>
                <a href="{{ route('landing') }}"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700
                      text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition active:scale-[0.98]">
                    ← Coba Lagi
                </a>
            </div>

            {{-- ══ Ditemukan ══ --}}
        @else
            @php
                [$bgCard, $bgBadge, $textColor, $icon] = match ($siswa->status) {
                    \App\Enums\StatusSiswa::Lulus => ['from-green-50 to-white', 'bg-green-600', 'text-green-700', '🎓'],
                    \App\Enums\StatusSiswa::TidakLulus => ['from-red-50 to-white', 'bg-red-500', 'text-red-700', '📋'],
                    \App\Enums\StatusSiswa::LulusBersyarat => [
                        'from-yellow-50 to-white',
                        'bg-yellow-500',
                        'text-yellow-700',
                        '⚠️',
                    ],
                };
            @endphp

            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">

                {{-- Header --}}
                <div class="bg-gradient-to-br {{ $bgCard }} px-6 py-6 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div
                            class="{{ $bgBadge }} text-white rounded-2xl h-14 w-14 flex items-center justify-center text-2xl shadow-md flex-shrink-0">
                            {{ $icon }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-widest mb-0.5">Status Kelulusan</p>
                            <p class="text-xl font-bold {{ $textColor }}">{{ $siswa->status->label() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Info Siswa --}}
                <div class="px-6 py-5 space-y-3 text-sm">
                    @foreach ([
            'Nama Siswa' => $siswa->nama,
            'NISN' => $siswa->nisn,
            'Nama Orang Tua' => $siswa->nama_orangtua,
        ] as $label => $val)
                        @if ($val)
                            <div class="flex justify-between items-baseline gap-4">
                                <span class="text-gray-400 flex-shrink-0">{{ $label }}</span>
                                <span
                                    class="font-medium text-right {{ $label === 'NISN' ? 'font-mono' : '' }}">{{ $val }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="mx-6 border-t border-dashed border-gray-100"></div>

                {{-- Aksi --}}
                <div class="px-6 py-5 flex flex-col gap-2.5">

                    {{-- SKL --}}
                    @if ($siswa->berkas_skl)
                        <a href="{{ route('landing.skl', $siswa) }}" target="_blank"
                            class="flex items-center justify-center gap-2
                          bg-green-600 hover:bg-green-700 active:scale-[0.98]
                          text-white font-semibold py-3 rounded-xl text-sm transition-all
                          shadow-sm shadow-green-200">
                            <span>📄</span> Unduh Surat Keterangan Lulus
                        </a>
                    @else
                        <div
                            class="flex items-center gap-2 justify-center bg-gray-50 border border-dashed
                            border-gray-200 rounded-xl py-3 text-xs text-gray-400">
                            <span>🕐</span> Dokumen SKL belum tersedia — hubungi sekolah
                        </div>
                    @endif

                    {{-- Surat Undangan (Lulus & Lulus Bersyarat) --}}
                    @if ($siswa->isLulus())
                        <a href="{{ route('landing.undangan', $siswa) }}" target="_blank"
                            class="flex items-center justify-center gap-2
                          bg-white border border-green-300 text-green-700
                          hover:bg-green-50 active:scale-[0.98]
                          font-semibold py-3 rounded-xl text-sm transition-all">
                            <span>🎟️</span> Cetak Surat Undangan Kelulusan
                        </a>
                    @endif

                </div>
            </div>

            @if ($siswa->status === \App\Enums\StatusSiswa::Lulus)
                <p class="text-center text-xs text-gray-400 mt-4">
                    🎉 Selamat! Semoga sukses di jenjang berikutnya.
                </p>
            @elseif($siswa->status === \App\Enums\StatusSiswa::LulusBersyarat)
                <p class="text-center text-xs text-yellow-500 mt-4">
                    ⚠️ Segera hubungi sekolah untuk informasi lebih lanjut.
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

@section('content')
    @php
        $tp = $tahunPelajaran ?? null;
        $now = now();
        $belumBuka = $tp && $now->lt($tp->jadwal_pengumuman_mulai);
        $sudahBuka = $tp && $now->gte($tp->jadwal_pengumuman_mulai);
        $sudahTutup = $tp && $now->gt($tp->jadwal_pengumuman_selesai);
    @endphp

    {{-- ── Hero ──────────────────────────────────────────────── --}}
    <section class="text-center py-10 px-4">
        @if ($instansi?->logo_institusi)
            <img src="{{ Storage::url($instansi->logo_institusi) }}" alt="Logo"
                class="h-24 w-24 object-contain mx-auto mb-5 drop-shadow">
        @endif
        <h1 class="text-2xl md:text-3xl font-bold text-green-700 tracking-tight">
            Pengumuman Kelulusan
        </h1>
        <p class="text-gray-400 mt-2 text-sm">
            {{ $instansi?->nama }} &bull; Tahun Pelajaran {{ $tp?->name ?? '-' }}
        </p>
    </section>

    {{-- ══ STATE: Belum ada konfigurasi ══ --}}
    @if (!$tp)
        <section class="flex justify-center py-12 px-4">
            <div class="bg-gray-50 border border-gray-200 rounded-2xl px-8 py-8 max-w-sm text-center shadow-sm">
                <p class="text-4xl mb-3">🏫</p>
                <p class="text-gray-600 font-semibold">Informasi belum tersedia.</p>
                <p class="text-sm text-gray-400 mt-1">Hubungi sekolah untuk informasi lebih lanjut.</p>
            </div>
        </section>

        {{-- ══ STATE 1: Belum buka → Countdown ══ --}}
    @elseif($belumBuka)
        <section class="text-center py-8 px-4">
            <div class="inline-block bg-white rounded-2xl shadow-md px-8 py-6 mb-8 border border-gray-100">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Pengumuman dibuka pada</p>
                <p class="font-semibold text-green-700 text-sm">
                    {{ $tp->jadwal_pengumuman_mulai->translatedFormat('l, d F Y · H:i') }} WIB
                </p>
            </div>

            <div class="flex justify-center gap-3">
                @foreach (['days' => 'Hari', 'hours' => 'Jam', 'minutes' => 'Menit', 'seconds' => 'Detik'] as $key => $label)
                    <div class="bg-white shadow-md rounded-2xl px-5 py-4 min-w-[72px] border border-gray-100">
                        <span id="cd-{{ $key }}" class="text-3xl font-bold text-green-700 tabular-nums">00</span>
                        <p class="text-xs text-gray-400 mt-1">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            <p class="text-xs text-gray-400 mt-6">
                Pastikan kamu kembali tepat waktu ya 😊
            </p>
        </section>

        {{-- ══ STATE 2: Sudah tutup ══ --}}
    @elseif($sudahTutup)
        <section class="flex justify-center py-12 px-4">
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl px-8 py-8 max-w-sm text-center shadow-sm">
                <p class="text-4xl mb-3">📋</p>
                <p class="text-yellow-700 font-semibold">Periode pengumuman telah berakhir.</p>
                <p class="text-sm text-gray-500 mt-1">Hubungi sekolah untuk informasi lebih lanjut.</p>
            </div>
        </section>

        {{-- ══ STATE 3: Sedang buka → Amplop + Pencarian ══ --}}
    @elseif($sudahBuka)
        {{-- Amplop --}}
        <section class="flex justify-center my-4 px-4" id="amplop-section">
            <div class="flex flex-col items-center">
                <button onclick="bukaAmplop()" id="amplop-btn" class="group focus:outline-none"
                    aria-label="Klik untuk membuka amplop">
                    <div id="amplop"
                        class="relative w-72 h-48 transition-all duration-500 group-hover:scale-105 group-hover:-translate-y-1 drop-shadow-xl">
                        <svg viewBox="0 0 288 192" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <rect width="288" height="192" rx="14" fill="#16a34a" />
                            <path d="M0 192 L144 112 L288 192Z" fill="#15803d" />
                            <path d="M288 20 L288 192 L144 112Z" fill="#14532d" fill-opacity="0.3" />
                            <path d="M0 20 L0 192 L144 112Z" fill="#14532d" fill-opacity="0.2" />
                            <path id="amplop-lid" d="M0 20 L144 108 L288 20 L288 0 L0 0 Z" fill="#166534"
                                style="transform-origin:50% 0%;transition:transform .5s ease,opacity .5s ease;" />
                            <path d="M0 20 L144 108 L288 20" stroke="#bbf7d0" stroke-width="1.5" fill="none"
                                opacity="0.5" />
                            <text x="144" y="158" text-anchor="middle" fill="white" font-size="12"
                                font-family="Inter,sans-serif" font-weight="600" opacity="0.9">
                                ✉ Klik untuk membuka
                            </text>
                        </svg>
                    </div>
                </button>
                <p class="text-xs text-gray-400 mt-3 animate-bounce">↑ ketuk amplop</p>
            </div>
        </section>

        {{-- Form Pencarian --}}
        <section id="cari-section" class="hidden px-4">
            <div class="bg-white rounded-2xl shadow-md p-6 max-w-lg mx-auto border border-gray-100">
                <div class="flex items-center gap-3 mb-5">
                    <div
                        class="h-10 w-10 rounded-xl bg-green-100 flex items-center justify-center text-green-700 text-lg flex-shrink-0">
                        🎓
                    </div>
                    <div>
                        <h2 class="font-semibold text-green-700 text-base leading-tight">Cek Status Kelulusan</h2>
                        <p class="text-xs text-gray-400">Masukkan NISN atau nomor telepon terdaftar</p>
                    </div>
                </div>

                <form action="{{ route('landing.cari') }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none">🔎</span>
                        <input type="text" name="nisn" placeholder="NISN (10 digit) atau Nomor Telepon"
                            value="{{ old('nisn') }}"
                            class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                  transition placeholder:text-gray-300 @error('nisn') border-red-300 @enderror"
                            maxlength="15" autofocus>
                    </div>

                    @error('nisn')
                        <p class="text-red-500 text-xs flex items-center gap-1">
                            <span>⚠</span> {{ $message }}
                        </p>
                    @enderror
                    @error('telepon')
                        <p class="text-red-500 text-xs flex items-center gap-1">
                            <span>⚠</span> {{ $message }}
                        </p>
                    @enderror

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 active:scale-[0.98] text-white font-semibold
                               py-2.5 rounded-xl text-sm transition-all shadow-sm shadow-green-200">
                        Cari Kelulusan
                    </button>
                </form>
            </div>
        </section>

    @endif
@endsection

@push('styles')
    <style>
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-slide-up {
            animation: fadeSlideUp .4s ease forwards;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // ── Countdown ────────────────────────────────────────
        const cdTarget = new Date("{{ $tp?->jadwal_pengumuman_mulai?->toIso8601String() }}");
        const pad = n => String(n).padStart(2, '0');

        function tickCountdown() {
            const diff = cdTarget - Date.now();
            if (diff <= 0) {
                location.reload();
                return;
            }
            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            [
                ['days', d],
                ['hours', h],
                ['minutes', m],
                ['seconds', s]
            ].forEach(([k, v]) => {
                const el = document.getElementById('cd-' + k);
                if (el) el.textContent = pad(v);
            });
        }

        if (document.getElementById('cd-seconds')) {
            tickCountdown();
            setInterval(tickCountdown, 1000);
        }

        // ── Buka Amplop ──────────────────────────────────────
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
                const amplop = document.getElementById('amplop');
                if (amplop) {
                    amplop.style.transform = 'scale(0.8)';
                    amplop.style.opacity = '0';
                    amplop.style.transition = 'all .4s ease';
                }
            }, 400);

            setTimeout(tampilkanForm, 750);
            try {
                localStorage.setItem('amplop_dibuka', '1');
            } catch (e) {}
        }

        // Auto-buka jika sudah pernah
        try {
            if (localStorage.getItem('amplop_dibuka') === '1') tampilkanForm();
        } catch (e) {}

        // Auto-buka jika ada error validasi (form sudah disubmit)
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

@section('content')
    <div class="max-w-2xl mx-auto">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between mb-5 gap-3 flex-wrap print:hidden">
            <a href="{{ route('landing.hasil', $siswa) }}"
                class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-green-700 transition group">
                <span class="group-hover:-translate-x-0.5 transition-transform">←</span> Kembali
            </a>
            <a href="{{ route('landing.skl.pdf', $siswa) }}" target="_blank"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 active:scale-[0.98]
                  text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-sm shadow-green-200">
                ⬇ Unduh PDF
            </a>
        </div>

        {{-- Preview Card --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

            {{-- Kop Surat --}}
            <div class="flex items-center gap-4 px-8 pt-8 pb-5 border-b-4 border-double border-gray-800">
                @if ($instansi?->logo_institusi)
                    <img src="{{ Storage::url($instansi->logo_institusi) }}" alt=""
                        class="h-20 w-20 object-contain flex-shrink-0">
                @endif
                <div class="flex-1 text-center">
                    <h1 class="text-xl font-bold uppercase tracking-wide">{{ $instansi?->nama }}</h1>
                    <p class="text-xs text-gray-500 mt-0.5">
                        NPSN: {{ $instansi?->npsn ?? '-' }}
                        @if ($instansi?->akreditasi)
                            &nbsp;·&nbsp; Akreditasi: {{ $instansi->akreditasi }}
                        @endif
                    </p>
                </div>
            </div>

            {{-- Isi SKL --}}
            <div class="px-8 py-6 font-serif text-[13px] leading-relaxed">

                <h2 class="text-center text-base font-bold uppercase underline underline-offset-4 tracking-wider mb-6">
                    Surat Keterangan Lulus
                </h2>

                {{-- Nomor --}}
                <table class="mb-4 text-sm">
                    <tr>
                        <td class="pr-2 text-gray-500 w-24 align-top">Nomor</td>
                        <td class="pr-1 align-top">:</td>
                        <td>{{ $instansi?->nomor_surat ?? '-' }}</td>
                    </tr>
                </table>

                <p class="mb-4 text-justify indent-8">
                    Yang bertanda tangan di bawah ini, Kepala {{ $instansi?->nama }},
                    menerangkan bahwa siswa berikut:
                </p>

                {{-- Data Siswa --}}
                <table class="mb-4 w-full text-sm">
                    @php
                        $rows = [
                            'Nama Lengkap' => $siswa->nama,
                            'NISN' => $siswa->nisn,
                            'Tahun Pelajaran' => $tahunPelajaran?->name ?? '-',
                        ];
                    @endphp
                    @foreach ($rows as $lbl => $val)
                        <tr>
                            <td class="py-0.5 text-gray-500 w-44 align-top">{{ $lbl }}</td>
                            <td class="py-0.5 w-3 align-top">:</td>
                            <td class="py-0.5 font-medium">{{ $val }}</td>
                        </tr>
                    @endforeach
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

                <p class="mb-4 text-justify indent-8">
                    Telah mengikuti dan menyelesaikan seluruh program pendidikan, dan
                    {!! $statusText !!} {{ $instansi?->nama }} Tahun Pelajaran {{ $tahunPelajaran?->name ?? '-' }}.
                </p>

                <p class="mb-6 text-justify indent-8">
                    Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk
                    dapat digunakan sebagaimana mestinya.
                </p>

                {{-- TTD --}}
                <div class="flex justify-end mt-6">
                    <div class="text-center w-56">
                        <p>{{ $instansi?->nama }},
                            {{ now()->translatedFormat('d F Y') }}</p>
                        @if ($instansi?->tte_pimpinan)
                            <img src="{{ Storage::url($instansi->tte_pimpinan) }}" alt="TTD"
                                class="h-16 mx-auto my-2 object-contain">
                        @else
                            <div class="h-16"></div>
                        @endif
                        <p class="font-bold underline">{{ $instansi?->nama_pimpinan }}</p>
                        @if ($instansi?->nip_pimpinan)
                            <p class="text-xs text-gray-500">NIP. {{ $instansi->nip_pimpinan }}</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4 print:hidden">
            Dokumen ini sah jika dicetak menggunakan tombol <strong>Unduh PDF</strong> di atas.
        </p>
    </div>
@endsection

```

---

### 📄 File: `./resources/views/landing/undangan.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Surat Undangan — ' . $siswa->nama)

@section('content')
    <div class="max-w-2xl mx-auto">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between mb-5 gap-3 flex-wrap print:hidden">
            <a href="{{ route('landing.hasil', $siswa) }}"
                class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-green-700 transition group">
                <span class="group-hover:-translate-x-0.5 transition-transform">←</span> Kembali
            </a>
            <a href="{{ route('landing.undangan.pdf', $siswa) }}" target="_blank"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 active:scale-[0.98]
                  text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-sm shadow-green-200">
                ⬇ Unduh PDF
            </a>
        </div>

        {{-- Preview Card --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

            {{-- Kop Surat --}}
            <div class="flex items-center gap-4 px-8 pt-8 pb-5 border-b-4 border-double border-gray-800">
                @if ($instansi?->logo_institusi)
                    <img src="{{ Storage::url($instansi->logo_institusi) }}" alt=""
                        class="h-20 w-20 object-contain flex-shrink-0">
                @endif
                <div class="flex-1 text-center">
                    <h1 class="text-xl font-bold uppercase tracking-wide">{{ $instansi?->nama }}</h1>
                    <p class="text-xs text-gray-500 mt-0.5">
                        NPSN: {{ $instansi?->npsn ?? '-' }}
                        @if ($instansi?->akreditasi)
                            &nbsp;·&nbsp; Akreditasi: {{ $instansi->akreditasi }}
                        @endif
                    </p>
                </div>
            </div>

            {{-- Isi --}}
            <div class="px-8 py-6 font-serif text-[13px] leading-relaxed">

                {{-- Nomor & Hal --}}
                <table class="mb-5 text-sm">
                    <tr>
                        <td class="pr-2 text-gray-500 w-24 align-top">Nomor</td>
                        <td class="pr-1 align-top">:</td>
                        <td>{{ $instansi?->nomor_surat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="pr-2 text-gray-500 align-top">Hal</td>
                        <td class="pr-1 align-top">:</td>
                        <td>Undangan Wisuda &amp; Pengambilan Ijazah</td>
                    </tr>
                </table>

                <h2 class="text-center text-base font-bold uppercase underline underline-offset-4 tracking-wider mb-6">
                    Surat Undangan
                </h2>

                <p class="mb-4 text-justify indent-8">
                    Assalamu'alaikum Warahmatullahi Wabarakatuh.
                </p>

                <p class="mb-4 text-justify indent-8">
                    Dengan hormat, kami mengundang Bapak/Ibu
                    <strong>{{ $siswa->nama_orangtua ?? 'Orang Tua/Wali' }}</strong>
                    beserta putra/putri atas nama
                    <strong>{{ $siswa->nama }}</strong> (NISN: {{ $siswa->nisn }})
                    untuk menghadiri acara Wisuda &amp; Pengambilan Ijazah yang akan dilaksanakan pada:
                </p>

                @php
                    $tp = $tahunPelajaran;
                    $adaJadwal =
                        $tp?->jadwal_kelulusan_mulai && $tp?->jadwal_kelulusan_selesai && $tp?->jadwal_kelulusan_tempat;
                @endphp

                @if ($adaJadwal)
                    <table class="mb-5 text-sm ml-8">
                        <tr>
                            <td class="pr-2 text-gray-500 w-36 align-top">Hari / Tanggal</td>
                            <td class="pr-1 align-top">:</td>
                            <td>{{ $tp->jadwal_kelulusan_mulai->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="pr-2 text-gray-500 align-top">Waktu</td>
                            <td class="pr-1 align-top">:</td>
                            <td>
                                {{ $tp->jadwal_kelulusan_mulai->format('H:i') }} –
                                {{ $tp->jadwal_kelulusan_selesai->format('H:i') }} WIB
                            </td>
                        </tr>
                        <tr>
                            <td class="pr-2 text-gray-500 align-top">Tempat</td>
                            <td class="pr-1 align-top">:</td>
                            <td>{{ $tp->jadwal_kelulusan_tempat }}</td>
                        </tr>
                    </table>
                @else
                    <div class="mb-5 ml-8 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-xs text-yellow-700">
                        Jadwal acara belum ditentukan. Pantau informasi dari sekolah.
                    </div>
                @endif

                <p class="mb-4 text-justify indent-8">
                    Atas kehadiran Bapak/Ibu, kami ucapkan terima kasih.
                </p>
                <p class="mb-6 text-justify">
                    Wassalamu'alaikum Warahmatullahi Wabarakatuh.
                </p>

                {{-- TTD --}}
                <div class="flex justify-end mt-6">
                    <div class="text-center w-56">
                        <p>{{ $instansi?->nama }},
                            {{ now()->translatedFormat('d F Y') }}</p>
                        @if ($instansi?->tte_pimpinan)
                            <img src="{{ Storage::url($instansi->tte_pimpinan) }}" alt="TTD"
                                class="h-16 mx-auto my-2 object-contain">
                        @else
                            <div class="h-16"></div>
                        @endif
                        <p class="font-bold underline">{{ $instansi?->nama_pimpinan }}</p>
                        @if ($instansi?->nip_pimpinan)
                            <p class="text-xs text-gray-500">NIP. {{ $instansi->nip_pimpinan }}</p>
                        @endif
                    </div>
                </div>

                {{-- QR Code --}}
                @if ($siswa->barcode_url)
                    <div class="mt-8 pt-6 border-t border-dashed border-gray-200 flex flex-col items-center gap-2">
                        <img src="{{ $siswa->barcode_url }}" alt="QR Code" class="w-24 h-24 object-contain">
                        <p class="text-xs text-gray-400">Scan QR untuk verifikasi kehadiran di lokasi</p>
                    </div>
                @endif

            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4 print:hidden">
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
    <title>@yield('title', 'Layanan SKL') — {{ $instansi?->nama ?? config('app.name') }}</title>

    @if ($instansi?->logo_institusi)
        <link rel="icon" href="{{ Storage::url($instansi->logo_institusi) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400..700;1,14..32,400..500&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-gray-50 font-[Inter] text-gray-800 antialiased">

    {{-- ── Navbar ─────────────────────────────────────────────── --}}
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                @if ($instansi?->logo_institusi)
                    <img src="{{ Storage::url($instansi->logo_institusi) }}" alt="Logo"
                        class="h-9 w-9 object-contain transition group-hover:scale-105">
                @else
                    <div
                        class="h-9 w-9 rounded-lg bg-green-600 flex items-center justify-center text-white font-bold text-sm">
                        SKL
                    </div>
                @endif
                <div class="leading-tight">
                    <p class="font-bold text-sm text-green-700 group-hover:text-green-800 transition">
                        {{ $instansi?->nama ?? config('app.name') }}
                    </p>
                    <p class="text-xs text-gray-400">Layanan Surat Keterangan Lulus</p>
                </div>
            </a>

            <div class="flex items-center gap-1 text-sm font-medium">
                @foreach ([['route' => 'personil.index', 'label' => 'Personil'], ['route' => 'alumni.index', 'label' => 'Alumni']] as $nav)
                    <a href="{{ route($nav['route']) }}"
                        class="px-3 py-1.5 rounded-lg transition
                      {{ request()->routeIs(Str::before($nav['route'], '.') . '*')
                          ? 'bg-green-50 text-green-700 font-semibold'
                          : 'text-gray-500 hover:text-green-700 hover:bg-gray-50' }}">
                        {{ $nav['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    {{-- ── Flash Messages ─────────────────────────────────────── --}}
    @foreach (['error' => 'red', 'info' => 'blue', 'success' => 'green', 'warning' => 'yellow'] as $type => $color)
        @if (session($type))
            <div class="max-w-5xl mx-auto px-4 mt-4 flash-msg" data-color="{{ $color }}">
                <div
                    class="flash-inner flex items-start justify-between gap-3
                    bg-{{ $color }}-50 border border-{{ $color }}-200
                    text-{{ $color }}-700 px-4 py-3 rounded-xl text-sm shadow-sm
                    opacity-0 translate-y-1 transition-all duration-300">
                    <span>{{ session($type) }}</span>
                    <button onclick="this.closest('.flash-msg').remove()"
                        class="opacity-50 hover:opacity-100 transition text-lg leading-none mt-0.5 flex-shrink-0">
                        ×
                    </button>
                </div>
            </div>
        @endif
    @endforeach

    {{-- ── Main ───────────────────────────────────────────────── --}}
    <main class="max-w-5xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- ── Footer ─────────────────────────────────────────────── --}}
    <footer class="border-t mt-16 py-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} {{ $instansi?->nama ?? config('app.name') }} &nbsp;·&nbsp; Layanan SKL Digital
    </footer>

    <script>
        // Animate flash messages in, auto-dismiss after 4s
        document.querySelectorAll('.flash-msg .flash-inner').forEach(el => {
            requestAnimationFrame(() => {
                el.classList.remove('opacity-0', 'translate-y-1');
            });
            setTimeout(() => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(-4px)';
                setTimeout(() => el.closest('.flash-msg')?.remove(), 300);
            }, 4000);
        });
    </script>

    @stack('scripts')
</body>

</html>

```

---

### 📄 File: `./resources/views/pdf/skl.blade.php`

```blade
{{-- ════════════════════════════════════════════════════
     resources/views/pdf/skl.blade.php
     Surat Keterangan Lulus (DomPDF)
     Render via: Pdf::loadView('pdf.skl', compact('siswa','instansi','tahunPelajaran'))
════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SKL - {{ $siswa->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #1a1a1a;
            padding: 1.5cm 2cm 2cm;
            line-height: 1.6;
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
            letter-spacing: 0.5px;
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

        table.nomor td.label {
            width: 5cm;
            color: #555;
        }

        table.nomor td.sep {
            width: 0.3cm;
        }

        /* DATA SISWA */
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

        table.data td.label {
            width: 5.5cm;
            color: #555;
        }

        table.data td.sep {
            width: 0.3cm;
        }

        table.data td.val {
            font-weight: bold;
        }

        /* PARAGRAF */
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
</head>

<body>

    {{-- KOP --}}
    <div class="kop">
        @if ($instansi->logo_institusi)
            <img src="{{ public_path('storage/' . $instansi->logo_institusi) }}" alt="">
        @endif
        <div class="kop-text">
            <h1>{{ $instansi->nama }}</h1>
            <p>NPSN: {{ $instansi->npsn }}
                @if ($instansi->akreditasi)
                    &nbsp;&bull;&nbsp; Akreditasi: {{ $instansi->akreditasi }}
                @endif
            </p>
        </div>
    </div>

    {{-- NOMOR --}}
    <table class="nomor">
        <tr>
            <td class="label">Nomor</td>
            <td class="sep">:</td>
            <td>{{ $instansi->nomor_surat ?? '-' }}</td>
        </tr>
    </table>

    <h2 class="judul">Surat Keterangan Lulus</h2>

    <div class="isi">
        <p>
            Yang bertanda tangan di bawah ini, Kepala {{ $instansi->nama }},
            menerangkan bahwa siswa berikut:
        </p>
    </div>

    {{-- DATA SISWA --}}
    <table class="data">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="sep">:</td>
            <td class="val">{{ $siswa->nama }}</td>
        </tr>
        <tr>
            <td class="label">NISN</td>
            <td class="sep">:</td>
            <td class="val">{{ $siswa->nisn }}</td>
        </tr>
        @if ($siswa->nama_orangtua)
            <tr>
                <td class="label">Nama Orang Tua / Wali</td>
                <td class="sep">:</td>
                <td class="val">{{ $siswa->nama_orangtua }}</td>
            </tr>
        @endif
        <tr>
            <td class="label">Tahun Pelajaran</td>
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
        <p>
            Telah mengikuti dan menyelesaikan seluruh program pendidikan, dan
            {!! $statusText !!} {{ $instansi->nama }} Tahun Pelajaran {{ $tahunPelajaran->name }}.
        </p>
        <p>
            Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk
            dapat digunakan sebagaimana mestinya.
        </p>
    </div>

    {{-- TTD --}}
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

    {{-- QR --}}
    @if ($siswa->barcode_url)
        <div class="qr-box">
            <img src="{{ $siswa->barcode_url }}" alt="QR Code">
            <p>Scan untuk verifikasi kehadiran</p>
        </div>
    @endif

</body>

</html>

```

---

### 📄 File: `./resources/views/pdf/undangan.blade.php`

```blade
{{-- ════════════════════════════════════════════════════
     resources/views/pdf/undangan.blade.php
     Surat Undangan Kelulusan (DomPDF)
     Render via: Pdf::loadView('pdf.undangan', compact('siswa','instansi','tahunPelajaran'))
════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Undangan - {{ $siswa->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #1a1a1a;
            padding: 1.5cm 2cm 2cm;
            line-height: 1.7;
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
        }

        .kop-text p {
            font-size: 10pt;
            color: #444;
            margin-top: 2px;
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

        table.nomor td.label {
            width: 2cm;
            color: #555;
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

        /* ISI */
        .isi p {
            text-indent: 1.5cm;
            margin-bottom: 10px;
            text-align: justify;
        }

        /* JADWAL */
        table.jadwal {
            margin: 4px 0 16px 1.5cm;
            font-size: 11pt;
        }

        table.jadwal td {
            padding: 3px 6px 3px 0;
            vertical-align: top;
        }

        table.jadwal td.label {
            width: 4.5cm;
            color: #555;
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
</head>

<body>

    {{-- KOP --}}
    <div class="kop">
        @if ($instansi->logo_institusi)
            <img src="{{ public_path('storage/' . $instansi->logo_institusi) }}" alt="">
        @endif
        <div class="kop-text">
            <h1>{{ $instansi->nama }}</h1>
            <p>NPSN: {{ $instansi->npsn }}
                @if ($instansi->akreditasi)
                    &nbsp;&bull;&nbsp; Akreditasi: {{ $instansi->akreditasi }}
                @endif
            </p>
        </div>
    </div>

    {{-- NOMOR --}}
    <table class="nomor">
        <tr>
            <td class="label">Nomor</td>
            <td>:</td>
            <td>{{ $instansi->nomor_surat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Hal</td>
            <td>:</td>
            <td>Undangan Wisuda &amp; Pengambilan Ijazah</td>
        </tr>
    </table>

    <h2 class="judul">Surat Undangan</h2>

    <div class="isi">
        <p>Assalamu'alaikum Warahmatullahi Wabarakatuh.</p>
        <p>
            Dengan hormat, kami mengundang Bapak/Ibu
            <b>{{ $siswa->nama_orangtua ?? 'Orang Tua/Wali' }}</b>
            beserta putra/putri atas nama
            <b>{{ $siswa->nama }}</b> (NISN: {{ $siswa->nisn }})
            untuk menghadiri acara Wisuda &amp; Pengambilan Ijazah yang akan dilaksanakan pada:
        </p>
    </div>

    @php
        $tp = $tahunPelajaran;
        $adaJadwal = $tp->jadwal_kelulusan_mulai && $tp->jadwal_kelulusan_selesai && $tp->jadwal_kelulusan_tempat;
    @endphp

    @if ($adaJadwal)
        <table class="jadwal">
            <tr>
                <td class="label">Hari / Tanggal</td>
                <td>:</td>
                <td>{{ $tp->jadwal_kelulusan_mulai->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Waktu</td>
                <td>:</td>
                <td>{{ $tp->jadwal_kelulusan_mulai->format('H:i') }} –
                    {{ $tp->jadwal_kelulusan_selesai->format('H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="label">Tempat</td>
                <td>:</td>
                <td>{{ $tp->jadwal_kelulusan_tempat }}</td>
            </tr>
        </table>
    @endif

    <div class="isi">
        <p>Demikian undangan ini kami sampaikan. Atas kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>
        <p>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
    </div>

    {{-- TTD --}}
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

    {{-- QR --}}
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

### 📄 File: `./resources/views/personil/index.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Personil')

@section('content')

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-green-700">Personil</h1>
            @if (isset($keyword))
                <p class="text-sm text-gray-400 mt-0.5">
                    Hasil pencarian untuk <span class="font-semibold text-gray-600">"{{ $keyword }}"</span>
                    &mdash; {{ $personils->count() }} data
                </p>
            @endif
        </div>

        <form action="{{ route('personil.cari') }}" method="GET" class="flex gap-2">
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none">🔎</span>
                <input type="text" name="nama" value="{{ request('nama', $keyword ?? '') }}" placeholder="Cari nama…"
                    class="border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm w-52
                          focus:outline-none focus:ring-2 focus:ring-green-500 transition">
            </div>
            <button
                class="bg-green-600 hover:bg-green-700 active:scale-[0.98]
                       text-white px-4 py-2 rounded-xl text-sm transition">
                Cari
            </button>
            @if (isset($keyword))
                <a href="{{ route('personil.index') }}"
                    class="px-3 py-2 rounded-xl text-sm text-gray-400 hover:text-gray-600
                      border border-gray-200 hover:border-gray-300 transition">
                    ✕
                </a>
            @endif
        </form>
    </div>

    @if ($personils->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <p class="text-4xl mb-3">🔍</p>
            <p class="text-sm">
                Tidak ada data personil{{ isset($keyword) ? ' untuk "' . $keyword . '"' : '' }}.
            </p>
            @if (isset($keyword))
                <a href="{{ route('personil.index') }}" class="inline-block mt-3 text-xs text-green-600 hover:underline">
                    Lihat semua personil
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach ($personils as $p)
                <div
                    class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-gray-100
                transition-all duration-200 hover:-translate-y-0.5 p-5 text-center group">
                    @if ($p->foto)
                        <img src="{{ Storage::url($p->foto) }}" alt="{{ $p->nama }}"
                            class="w-16 h-16 rounded-full object-cover mx-auto mb-3
                        ring-2 ring-green-100 group-hover:ring-green-300 transition">
                    @else
                        <div
                            class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center
                        mx-auto mb-3 ring-2 ring-green-100 group-hover:ring-green-300 transition">
                            <span class="text-green-700 font-bold text-xl">
                                {{ strtoupper(substr($p->nama, 0, 1)) }}
                            </span>
                        </div>
                    @endif

                    <p class="font-semibold text-sm leading-tight">{{ $p->nama }}</p>
                    <p class="text-xs text-green-600 font-medium mt-0.5">{{ $p->jabatan }}</p>

                    @if ($p->nip)
                        <p class="text-xs text-gray-300 font-mono mt-0.5">{{ $p->nip }}</p>
                    @endif

                    @if ($p->quote)
                        <p class="text-xs text-gray-400 italic mt-2 line-clamp-2 leading-relaxed">
                            "{{ $p->quote }}"
                        </p>
                    @endif

                    @if ($p->sosial_media)
                        <a href="{{ $p->sosial_media }}" target="_blank" rel="noopener"
                            class="inline-block mt-2 text-xs text-blue-400 hover:text-blue-600 transition">
                            🔗 Sosial Media
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($personils instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6">{{ $personils->links() }}</div>
        @endif
    @endif

@endsection

```

---

### 📄 File: `./resources/views/tamu/index.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Tamu Undangan')

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 gap-3 flex-wrap">
        <h1 class="text-xl font-bold text-green-700">Tamu Undangan</h1>
        <div class="flex gap-2">
            <a href="{{ route('tamu.scan') }}"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 active:scale-[0.98]
                  text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-sm shadow-green-200">
                📷 Scan QR
            </a>
            <a href="{{ route('tamu.cetak-hadir') }}" target="_blank"
                class="flex items-center gap-2 bg-white border border-green-300 text-green-700
                  hover:bg-green-50 active:scale-[0.98]
                  text-sm font-semibold px-4 py-2 rounded-xl transition">
                🖨️ Cetak Hadir
            </a>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 {{ isset($totalSiswa) ? 'sm:grid-cols-3' : 'sm:grid-cols-2' }} gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-3xl font-bold text-green-700">{{ $tamuUndangans->total() }}</p>
            <p class="text-xs text-gray-400 mt-1">Siswa Hadir</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-3xl font-bold text-green-700">{{ $tamuUndangans->sum('jumlah_tamu') }}</p>
            <p class="text-xs text-gray-400 mt-1">Total PAX</p>
        </div>
        @isset($totalSiswa)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                @php $pct = $totalSiswa > 0 ? round($tamuUndangans->total() / $totalSiswa * 100) : 0; @endphp
                <p class="text-3xl font-bold text-green-700">{{ $pct }}%</p>
                <p class="text-xs text-gray-400 mt-1">Kehadiran</p>
            </div>
        @endisset
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-xs text-gray-400 uppercase tracking-wider">
                    <th class="px-4 py-3 text-left w-10">#</th>
                    <th class="px-4 py-3 text-left">Nama Siswa</th>
                    <th class="px-4 py-3 text-left hidden sm:table-cell">Nama Orang Tua</th>
                    <th class="px-4 py-3 text-center">PAX</th>
                    <th class="px-4 py-3 text-right">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($tamuUndangans as $i => $t)
                    <tr class="hover:bg-gray-50/70 transition">
                        <td class="px-4 py-3 text-gray-300 text-xs">{{ $tamuUndangans->firstItem() + $i }}</td>
                        <td class="px-4 py-3 font-medium">{{ $t->siswa?->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-400 hidden sm:table-cell">{{ $t->siswa?->nama_orangtua ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span
                                class="inline-flex items-center justify-center bg-green-100 text-green-700
                                 font-semibold text-xs px-2.5 py-1 rounded-full min-w-[28px]">
                                {{ $t->jumlah_tamu }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-400 text-xs text-right tabular-nums">
                            {{ $t->created_at->format('H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-14 text-gray-400">
                            <p class="text-3xl mb-2">👥</p>
                            <p class="text-sm">Belum ada tamu yang hadir.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $tamuUndangans->links() }}</div>

@endsection

```

---

### 📄 File: `./resources/views/tamu/konfirmasi.blade.php`

```blade
@extends('layouts.app')
@section('title', 'Konfirmasi Tamu')

@section('content')
    <div class="max-w-md mx-auto">

        <a href="{{ route('tamu.scan') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-green-700 mb-5 transition group">
            <span class="group-hover:-translate-x-0.5 transition-transform">←</span> Kembali ke Scanner
        </a>

        <h1 class="text-xl font-bold text-green-700 mb-4">Konfirmasi Kehadiran</h1>

        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

            {{-- Info siswa --}}
            <div class="px-6 py-5 space-y-3 text-sm border-b border-gray-100">
                @foreach ([
            'Nama Siswa' => $siswa->nama,
            'NISN' => $siswa->nisn,
            'Nama Orang Tua' => $siswa->nama_orangtua ?? '-',
            'Status' => $siswa->status->label(),
        ] as $label => $val)
                    <div class="flex justify-between items-baseline gap-4">
                        <span class="text-gray-400 flex-shrink-0">{{ $label }}</span>
                        <span
                            class="font-medium text-right {{ $label === 'NISN' ? 'font-mono' : '' }}
                             {{ $label === 'Status' ? 'text-green-700' : '' }}">
                            {{ $val }}
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- Form --}}
            <div class="px-6 py-5">
                @if (isset($sudahHadir) && $sudahHadir)
                    <div
                        class="mb-4 flex items-center gap-2 bg-yellow-50 border border-yellow-200
                            text-yellow-700 text-xs px-4 py-3 rounded-xl">
                        <span>⚠️</span>
                        <span>Siswa ini sudah tercatat hadir. Data akan diperbarui.</span>
                    </div>
                @endif

                <form action="{{ route('tamu.store') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Jumlah Tamu <span class="text-gray-400 font-normal">(termasuk orang tua/wali)</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="adj(-1)"
                                class="w-10 h-10 rounded-xl border border-gray-200 bg-gray-50
                                       hover:bg-gray-100 text-lg font-bold text-gray-600 transition
                                       flex items-center justify-center flex-shrink-0">
                                −
                            </button>
                            <input id="pax" type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}"
                                min="1" max="10" readonly
                                class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                      text-center font-bold text-lg focus:outline-none focus:ring-2
                                      focus:ring-green-500 @error('jumlah_tamu') border-red-300 @enderror">
                            <button type="button" onclick="adj(1)"
                                class="w-10 h-10 rounded-xl border border-gray-200 bg-gray-50
                                       hover:bg-gray-100 text-lg font-bold text-gray-600 transition
                                       flex items-center justify-center flex-shrink-0">
                                +
                            </button>
                        </div>
                        @error('jumlah_tamu')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <span>⚠</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 active:scale-[0.98]
                               text-white font-semibold py-3 rounded-xl text-sm transition
                               shadow-sm shadow-green-200 mt-1">
                        ✅ Simpan Kehadiran
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function adj(delta) {
            const el = document.getElementById('pax');
            const val = parseInt(el.value) + delta;
            el.value = Math.min(10, Math.max(1, val));
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
        #qr-region video {
            border-radius: 12px;
            width: 100% !important;
        }

        #qr-region {
            border-radius: 12px;
            overflow: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-md mx-auto">

        <div class="mb-6">
            <h1 class="text-xl font-bold text-green-700 mb-1">Scan QR Undangan</h1>
            <p class="text-sm text-gray-400">Arahkan kamera ke QR Code pada surat undangan siswa.</p>
        </div>

        {{-- Scanner --}}
        <div class="bg-white rounded-2xl shadow-md p-4 border border-gray-100 mb-4">
            <div id="qr-region" class="w-full aspect-square bg-gray-100 rounded-xl overflow-hidden"></div>
            <div id="qr-status-wrap" class="flex items-center justify-center gap-2 mt-3">
                <span id="qr-dot" class="inline-block w-2 h-2 rounded-full bg-gray-300"></span>
                <p id="qr-status" class="text-xs text-gray-400">Menginisialisasi kamera…</p>
            </div>
        </div>

        {{-- Manual --}}
        <div class="bg-white rounded-2xl shadow-md p-5 border border-gray-100">
            <p class="text-sm font-medium text-gray-600 mb-3">Atau masukkan kode secara manual:</p>
            <form action="{{ route('tamu.scan.post') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="kode" placeholder="ID Siswa / NISN"
                    class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                          focus:outline-none focus:ring-2 focus:ring-green-500 transition
                          @error('kode') border-red-300 @enderror">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2.5
                           rounded-xl text-sm transition active:scale-[0.98]">
                    Cari
                </button>
            </form>
            @error('kode')
                <p class="text-red-500 text-xs mt-2 flex items-center gap-1"><span>⚠</span> {{ $message }}</p>
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

        function setStatus(msg, color = 'gray') {
            statusEl.textContent = msg;
            dotEl.className = `inline-block w-2 h-2 rounded-full bg-${color}-400`;
        }

        const html5Qr = new Html5Qrcode('qr-region');

        Html5Qrcode.getCameras()
            .then(cameras => {
                if (!cameras.length) {
                    setStatus('Tidak ada kamera ditemukan.', 'red');
                    return;
                }

                // Prefer kamera belakang
                const cam = cameras.find(c => /back|rear|environment/i.test(c.label)) ?? cameras[cameras.length - 1];
                setStatus('Kamera aktif — arahkan ke QR Code…', 'green');

                html5Qr.start(
                    cam.id, {
                        fps: 10,
                        qrbox: {
                            width: 240,
                            height: 240
                        }
                    },
                    decodedText => {
                        if (scanned) return;
                        scanned = true;
                        setStatus('✅ QR terdeteksi, mengalihkan…', 'green');
                        html5Qr.stop().catch(() => {});
                        window.location.href = '{{ route('tamu.konfirmasi', ['siswa' => ':id']) }}'
                            .replace(':id', encodeURIComponent(decodedText));
                    }
                ).catch(() => {
                    setStatus('Gagal memulai kamera.', 'red');
                });
            })
            .catch(() => {
                setStatus('Akses kamera ditolak. Gunakan input manual.', 'red');
            });
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

