<?php

namespace App\Filament\Resources\Personils\Pages;

use App\Filament\Resources\Personils\PersonilResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPersonil extends ViewRecord
{
    protected static string $resource = PersonilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
