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
                $log[] = "Dilewati — nama file tidak valid: {$file->getClientOriginalName()}";
                $gagal++;

                continue;
            }

            $siswa = Siswa::where('nisn', $nisn)->first();

            if (! $siswa) {
                $log[] = "Siswa dengan NISN {$nisn} tidak ditemukan.";
                $dilewati++;

                continue;
            }

            // Hapus berkas lama jika ada
            if ($siswa->berkas_skl && Storage::disk('public')->exists($siswa->berkas_skl)) {
                Storage::disk('public')->delete($siswa->berkas_skl);
            }

            $path = $file->storeAs('skl', "{$nisn}.pdf", 'public');

            $siswa->update(['berkas_skl' => $path]);
            $log[] = "SKL {$nisn} berhasil diimpor.";
            $berhasil++;
        }

        return compact('berhasil', 'dilewati', 'gagal', 'log');
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

enum StatusSiswa: string implements HasLabel, HasColor
{
    case Lulus          = 'Lulus';
    case TidakLulus     = 'Tidak Lulus';
    case LulusBersyarat = 'Lulus Bersyarat';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Lulus          => 'Lulus',
            self::TidakLulus     => 'Tidak Lulus',
            self::LulusBersyarat => 'Lulus Bersyarat',
        };
    }

    /**
     * Alias untuk getLabel() — agar kompatibel jika dipanggil ->label()
     * di view atau tempat lain.
     */
    public function label(): string
    {
        return $this->getLabel();
    }

    public function getColor(): string|array|null
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

### 📄 File: `./app/Exports/PersonilExport.php`

```php
<?php

namespace App\Exports;

use App\Models\Personil;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PersonilExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
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
        return [
            'No',
            'Nama',
            'NIP',
            'Jabatan',
            'Telepon',
            'Sosial Media',
            'Quote',
        ];
    }

    public function map($personil): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $personil->nama,
            $personil->nip ?? '-',
            $personil->jabatan,
            $personil->telepon ?? '-',
            $personil->sosial_media ?? '-',
            $personil->quote ?? '-',
        ];
    }

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

### 📄 File: `./app/Exports/SiswaExport.php`

```php
<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    public function __construct(
        private readonly ?string $status = null,
    ) {}

    public function query()
    {
        return Siswa::query()
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy('nama');
    }

    public function title(): string
    {
        return 'Data Siswa';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Nama Orang Tua',
            'NISN',
            'Telepon',
            'Status',
            'Berkas SKL',
            'Dibuat',
        ];
    }

    public function map($siswa): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $siswa->nama,
            $siswa->nama_orangtua ?? '-',
            $siswa->nisn,
            $siswa->telepon ?? '-',
            $siswa->status->getLabel(),
            $siswa->berkas_skl ?? '-',
            $siswa->created_at->format('d/m/Y'),
        ];
    }

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

### 📄 File: `./app/Filament/Resources/Alumnis/Pages/ListAlumnis.php`

```php
<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Filament\Resources\Alumnis\AlumniResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ListAlumnis extends ListRecords
{
    protected static string $resource = AlumniResource::class;

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

### 📄 File: `./app/Filament/Resources/Personils/Pages/ListPersonils.php`

```php
<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Filament\Resources\Personils\PersonilResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ListPersonils extends ListRecords
{
    protected static string $resource = PersonilResource::class;

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

### 📄 File: `./app/Filament/Resources/Siswas/Pages/ListSiswas.php`

```php
<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

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
        if (blank($row['nama'] ?? null) || blank($row['nisn'] ?? null)) {
            return null;
        }

        return new Alumni([
            'nama' => $row['nama'],
            'nisn' => $row['nisn'],
            'tahun_lulus' => $row['tahun_lulus'],
            'avatar' => $row['avatar'] ?? null,
            'quote' => $row['quote'] ?? null,
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
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class PersonilImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, SkipsOnError
{
    use SkipsErrors;

    public function model(array $row): ?Personil
    {
        if (blank($row['nama'] ?? null) || blank($row['jabatan'] ?? null)) {
            return null;
        }

        return new Personil([
            'nama'        => $row['nama'],
            'nip'         => filled($row['nip'] ?? null) ? (string) $row['nip'] : null,
            'jabatan'     => $row['jabatan'],
            'telepon'     => $row['telepon'] ?? null,
            'sosial_media' => $row['sosial_media'] ?? null,
            'quote'       => $row['quote'] ?? null,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nip';
    }

    public function rules(): array
    {
        return [
            'nama'    => ['required', 'string'],
            'jabatan' => ['required', 'string'],
        ];
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
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class SiswaImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, SkipsOnError
{
    use SkipsErrors;

    private int $berhasil = 0;

    public function model(array $row): ?Siswa
    {
        if (blank($row['nisn'] ?? null) || blank($row['nama'] ?? null)) {
            return null;
        }

        $this->berhasil++;

        return new Siswa([
            'nama'         => $row['nama'],
            'nama_orangtua' => $row['nama_orangtua'] ?? null,
            'nisn'         => (string) $row['nisn'],
            'telepon'      => filled($row['telepon'] ?? null) ? (string) $row['telepon'] : null,
            'status'       => $row['status'] ?? 'Lulus',
        ]);
    }

    public function uniqueBy(): string
    {
        return 'nisn';
    }

    public function rules(): array
    {
        return [
            'nisn'   => ['required'],
            'nama'   => ['required', 'string'],
            'status' => ['nullable', 'in:Lulus,Tidak Lulus,Lulus Bersyarat'],
        ];
    }

    public function getBerhasil(): int
    {
        return $this->berhasil;
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

## 📁 Directory: database (Database)

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

Artisan::command('export:template', function () {
    // Template Siswa
    Excel::store(
        new class implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function array(): array
            {
                return [['Budi Santoso', 'Ahmad Santoso', '0012345678', '08123456789', 'Lulus']];
            }
            public function headings(): array
            {
                return ['nama', 'nama_orangtua', 'nisn', 'telepon', 'status'];
            }
        },
        'templates/template-siswa.xlsx',
        'public'
    );

    // Template Personil
    Excel::store(
        new class implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function array(): array
            {
                return [['Siti Aminah', '196501011990032001', 'Guru Matematika', '08111111111', 'https://instagram.com/siti', 'Semangat!']];
            }
            public function headings(): array
            {
                return ['nama', 'nip', 'jabatan', 'telepon', 'sosial_media', 'quote'];
            }
        },
        'templates/template-personil.xlsx',
        'public'
    );

    $this->info('Template berhasil dibuat di storage/app/public/templates/');
})->purpose('Buat template Excel untuk import siswa dan personil');

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
