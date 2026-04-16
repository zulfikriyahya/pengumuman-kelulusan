<?php

namespace App\Filament\Resources\TahunPelajarans\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
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
                ActionGroup::make([
                    ViewAction::make()
                        ->icon(Heroicon::Eye)
                        ->label('Lihat')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Zinc),
                    EditAction::make()
                        ->icon(Heroicon::PencilSquare)
                        ->label('Ubah')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Blue),
                    DeleteAction::make()
                        ->icon(Heroicon::Trash)
                        ->label('Hapus')
                        ->outlined()
                        ->size('sm')
                        ->color(Color::Red),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
