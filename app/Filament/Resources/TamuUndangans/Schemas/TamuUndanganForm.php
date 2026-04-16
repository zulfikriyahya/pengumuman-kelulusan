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
