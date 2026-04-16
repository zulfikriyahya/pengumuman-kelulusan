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
