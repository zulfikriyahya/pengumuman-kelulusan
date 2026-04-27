<?php

namespace App\Filament\Resources\Alumnis\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlumnisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(asset('images/default.png')),
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                TextColumn::make('tahun_lulus')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d F Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('tahun_lulus', 'desc')
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
