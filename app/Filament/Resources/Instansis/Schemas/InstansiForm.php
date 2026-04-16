<?php

namespace App\Filament\Resources\Instansis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InstansiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('npsn')
                    ->required(),
                TextInput::make('logo'),
                TextInput::make('logo_institusi'),
                TextInput::make('nomor_surat'),
                TextInput::make('nama_pimpinan'),
                TextInput::make('nip_pimpinan'),
                TextInput::make('tte_pimpinan'),
                TextInput::make('nama_ketua'),
                TextInput::make('nip_ketua'),
                TextInput::make('tte_ketua'),
                TextInput::make('jenjang')
                    ->required(),
                TextInput::make('akreditasi')
                    ->required(),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
