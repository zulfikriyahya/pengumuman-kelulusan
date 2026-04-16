<?php

namespace App\Filament\Resources\TahunPelajarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TahunPelajaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('jadwal_pengumuman_mulai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('jadwal_pengumuman_selesai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('jadwal_kelulusan_mulai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('jadwal_kelulusan_selesai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('jadwal_kelulusan_tempat')
                    ->searchable(),
                IconColumn::make('status')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
