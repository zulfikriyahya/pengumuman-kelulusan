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
