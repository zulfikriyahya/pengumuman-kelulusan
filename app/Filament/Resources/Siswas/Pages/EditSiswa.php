<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->icon(Heroicon::Eye)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Zinc),
            DeleteAction::make()
                ->icon(Heroicon::Trash)
                ->label('')
                ->outlined()
                ->size('sm')
                ->color(Color::Rose),
        ];
    }
}
