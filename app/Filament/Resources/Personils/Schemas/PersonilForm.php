<?php

namespace App\Filament\Resources\Personils\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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
                ->columns(3)
                ->schema([
                    TextInput::make('nama')
                        ->required()
                        ->maxLength(255),
                    Select::make('jabatan')
                        ->required()
                        ->native(false)
                        ->options([
                            'Kepala Madrasah' => 'Kepala Madrasah',
                            'Wakil Kepala Madrasah' => 'Wakil Kepala Madrasah',
                            'Komite Madrasah' => 'Komite Madrasah',
                            'Guru' => 'Guru',
                            'Staff' => 'Staff',
                            'Outsourcing' => 'Outsourcing',
                        ]),
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
                        ->imagePreviewHeight('80')
                        ->label('Foto')
                        ->directory('personil')
                        ->maxSize(1024)
                        ->visibility('public')
                        ->disk('public')
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '1:1' => '1:1',
                            '4:3' => '4:3',
                            '16:9' => '16:9',
                            null,
                        ])
                        ->getUploadedFileNameForStorageUsing(function ($file, $record) {
                            $nip = $record?->nip ?? 'foto_'.time();
                            $ext = $file->getClientOriginalExtension();

                            return strtolower($nip).'.'.$ext;
                        }),
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
