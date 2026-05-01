## 📁 Directory: Root Files

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

    public function cetakUndangan(Siswa $siswa): View
    {
        abort_unless($siswa->isLulus(), 403, 'Siswa tidak berhak mendapatkan surat undangan.');

        return view('landing.undangan', compact('siswa'));
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

## 📁 Directory: database (Database)

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

## 📁 Directory: public (Public Assets)

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
                <a href="{{ route('landing') }}" class="btn btn-primary" style="margin:0 auto;">&larr; Coba Lagi</a>
            </div>
        @else
            @php
                $status = $siswa->status;
                $adaSkl = (bool) $siswa->berkas_skl;
                $bolehUndang = $siswa->isLulus();
            @endphp

            <div class="card {{ $status->theme() }}" style="overflow:hidden;">

                <div class="result-header">
                    <div class="eyebrow" style="margin-bottom:.9rem;">Hasil Kelulusan</div>
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
