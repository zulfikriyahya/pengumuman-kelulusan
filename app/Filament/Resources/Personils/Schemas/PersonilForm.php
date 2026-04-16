<?php

namespace App\Filament\Resources\Personils\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PersonilForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('nip'),
                TextInput::make('foto'),
                TextInput::make('telepon')
                    ->tel(),
                TextInput::make('sosial_media'),
                TextInput::make('jabatan')
                    ->required(),
                Textarea::make('quote')
                    ->columnSpanFull(),
            ]);
    }
}
