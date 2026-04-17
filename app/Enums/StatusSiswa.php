<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusSiswa: string implements HasLabel, HasColor
{
    case Lulus           = 'Lulus';
    case TidakLulus      = 'Tidak Lulus';
    case LulusBersyarat  = 'Lulus Bersyarat';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Lulus          => 'Lulus',
            self::TidakLulus     => 'Tidak Lulus',
            self::LulusBersyarat => 'Lulus Bersyarat',
        };
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
