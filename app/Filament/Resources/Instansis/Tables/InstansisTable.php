<?php

namespace App\Filament\Resources\Instansis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InstansisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('npsn')
                    ->searchable(),
                TextColumn::make('logo')
                    ->searchable(),
                TextColumn::make('logo_institusi')
                    ->searchable(),
                TextColumn::make('nomor_surat')
                    ->searchable(),
                TextColumn::make('nama_pimpinan')
                    ->searchable(),
                TextColumn::make('nip_pimpinan')
                    ->searchable(),
                TextColumn::make('tte_pimpinan')
                    ->searchable(),
                TextColumn::make('nama_ketua')
                    ->searchable(),
                TextColumn::make('nip_ketua')
                    ->searchable(),
                TextColumn::make('tte_ketua')
                    ->searchable(),
                TextColumn::make('jenjang')
                    ->searchable(),
                TextColumn::make('akreditasi')
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
