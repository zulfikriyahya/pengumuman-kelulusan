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
                ->columns(3)
                ->schema([
                    FileUpload::make('avatar')
                        ->hiddenLabel()
                        ->avatar()
                        ->image()
                        ->directory('alumni')
                        ->maxSize(1024)
                        ->visibility('public')
                        ->disk('public')
                        ->imageEditor()
                        ->columnSpanFull()
                        ->imageEditorAspectRatios([
                            '1:1' => '1:1',
                            null,
                        ])
                        ->circleCropper()
                        ->getUploadedFileNameForStorageUsing(function ($file, $record) {
                            $nisn = $record?->nisn ?? 'alumni_' . time();
                            $ext = $file->getClientOriginalExtension();
                            return strtolower($nisn) . '.' . $ext;
                        })
                        ->extraAttributes([
                            'class' => 'flex flex-col items-center',
                        ])
                        ->columnSpanFull(),
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
