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
