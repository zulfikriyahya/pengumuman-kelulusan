<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlumniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Alumni')
                ->icon('heroicon-o-academic-cap')
                ->columns(2)
                ->schema([
                    TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('nisn')
                        ->required()
                        ->maxLength(10)
                        ->label('NISN'),
                    TextInput::make('tahun_lulus')
                        ->required()
                        ->numeric()
                        ->minValue(2000)
                        ->maxValue(now()->year),
                    FileUpload::make('avatar')
                        ->image()
                        ->disk('public')
                        ->directory('alumni')
                        ->imagePreviewHeight('80')
                        ->columnSpanFull(),
                ]),

            Section::make('Kutipan')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->schema([
                    Textarea::make('quote')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
