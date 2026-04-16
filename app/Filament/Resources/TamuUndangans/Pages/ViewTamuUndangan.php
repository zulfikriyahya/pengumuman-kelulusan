<?php

namespace App\Filament\Resources\TamuUndangans\Pages;

use App\Filament\Resources\TamuUndangans\TamuUndanganResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTamuUndangan extends ViewRecord
{
    protected static string $resource = TamuUndanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
