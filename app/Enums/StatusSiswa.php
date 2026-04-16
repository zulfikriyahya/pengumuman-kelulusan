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
