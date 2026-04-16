<?php

namespace App\Filament\Resources\TahunPelajarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TahunPelajaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tahun Pelajaran')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jadwal_pengumuman_mulai')
                    ->label('Pengumuman Mulai')
                    ->dateTime('d F Y H:i')
                    ->sortable(),
                TextColumn::make('jadwal_pengumuman_selesai')
                    ->label('Pengumuman Selesai')
                    ->dateTime('d F Y H:i')
                    ->sortable(),
                TextColumn::make('jadwal_kelulusan_tempat')
                    ->label('Tempat Kelulusan')
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('status')
                    ->boolean()
                    ->label('Aktif'),
                TextColumn::make('created_at')
                    ->dateTime('d F Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('status')->label('Aktif'),
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
