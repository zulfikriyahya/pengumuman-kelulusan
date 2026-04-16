<?php

namespace App\Filament\Resources\Siswas\Tables;

use App\Enums\StatusSiswa;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                TextColumn::make('nama_orangtua')
                    ->label('Nama Orang Tua')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('telepon')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => $state?->color()),
                TextColumn::make('created_at')
                    ->dateTime('d F Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(StatusSiswa::class),
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
