<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Filament\Resources\Personils\PersonilResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPersonil extends EditRecord
{
    protected static string $resource = PersonilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
