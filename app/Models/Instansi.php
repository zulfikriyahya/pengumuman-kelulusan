<?php

namespace App\Models;

use App\Observers\InstansiObserver;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory, HasUuids;

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

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::observe(InstansiObserver::class);
    }
}
