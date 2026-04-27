<?php

namespace App\Filament\Resources\Instansis\Tables;

// use Filament\Actions\ActionGroup;
// use Filament\Actions\BulkActionGroup;
// use Filament\Actions\DeleteAction;
// use Filament\Actions\DeleteBulkAction;
// use Filament\Actions\EditAction;
// use Filament\Actions\ViewAction;
// use Filament\Support\Colors\Color;
// use Filament\Support\Icons\Heroicon;
// use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InstansisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->disk('public')
                    ->height(40)
                    ->defaultImageUrl(asset('images/default.png')),
                TextColumn::make('nama'),
                // ->searchable()
                // ->sortable(),
                TextColumn::make('npsn')
                    ->label('NPSN'),
                // ->searchable(),
                TextColumn::make('jenjang'),
                // ->searchable(),
                TextColumn::make('akreditasi'),
                // ->searchable(),
                // IconColumn::make('status')
                //     ->boolean()
                //     ->label('Aktif'),
                // TextColumn::make('created_at')
                //     ->dateTime('d F Y H:i')
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->filters([])
            ->recordActions([
                //     ActionGroup::make([
                //         ViewAction::make()
                //             ->icon(Heroicon::Eye)
                //             ->label('Lihat')
                //             ->outlined()
                //             ->size('sm')
                //             ->color(Color::Zinc),
                //         EditAction::make()
                //             ->icon(Heroicon::PencilSquare)
                //             ->label('Ubah')
                //             ->outlined()
                //             ->size('sm')
                //             ->color(Color::Blue),
                //         DeleteAction::make()
                //             ->icon(Heroicon::Trash)
                //             ->label('Hapus')
                //             ->outlined()
                //             ->size('sm')
                //             ->color(Color::Red),
                //     ]),
                // ])
                // ->toolbarActions([
                //     BulkActionGroup::make([
                //         DeleteBulkAction::make(),
                //     ]),
            ]);
    }
}
