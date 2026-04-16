<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AlumniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('nisn')
                    ->required(),
                TextInput::make('tahun_lulus')
                    ->required(),
                TextInput::make('avatar'),
                Textarea::make('quote')
                    ->columnSpanFull(),
            ]);
    }
}
