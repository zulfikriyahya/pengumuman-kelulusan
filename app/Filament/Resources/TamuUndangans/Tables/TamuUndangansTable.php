<?php

namespace App\Filament\Resources\TamuUndangans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TamuUndangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->toggleable(isToggledHiddenByDefault: true),
                // fix: relasi dot-notation
                TextColumn::make('siswa.nama')->label('Nama Siswa')->searchable()->sortable(),
                TextColumn::make('siswa.nisn')->label('NISN')->searchable(),
                TextColumn::make('jumlah_tamu')->numeric()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([ViewAction::make(), EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
