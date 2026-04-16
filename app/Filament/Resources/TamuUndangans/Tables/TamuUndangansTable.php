<?php

namespace App\Filament\Resources\TamuUndangans\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TamuUndangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('siswa.nama_orangtua')->label('Nama Orang Tua')->searchable()->sortable(),
                TextColumn::make('siswa.nama')->label('Nama Siswa')->searchable()->sortable(),
                TextColumn::make('siswa.nisn')->label('NISN')->searchable(),
                TextColumn::make('siswa.telepon')->label('Telepon')->searchable(),
                TextColumn::make('jumlah_tamu')->label('Jumlah Tamu')->numeric()->sortable()
                    ->suffix(' orang'),
                TextColumn::make('siswa.status')->label('Status Kelulusan')->sortable()
                    ->badge()
                    ->color(fn ($state) => $state?->color()),
                TextColumn::make('created_at')->dateTime('d F Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime('d F Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
