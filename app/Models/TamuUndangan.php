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
