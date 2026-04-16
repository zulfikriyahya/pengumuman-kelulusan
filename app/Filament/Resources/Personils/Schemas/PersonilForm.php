<?php

namespace App\Filament\Resources\Personils\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PersonilForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identitas Personil')
                ->icon('heroicon-o-identification')
                ->columns(2)
                ->schema([
                    TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('jabatan')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('nip')
                        ->label('NIP')
                        ->maxLength(30),
                    TextInput::make('telepon')
                        ->tel()
                        ->maxLength(15),
                    TextInput::make('sosial_media')
                        ->label('Sosial Media')
                        ->url(),
                    FileUpload::make('foto')
                        ->image()
                        ->disk('public')
                        ->directory('personil')
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
