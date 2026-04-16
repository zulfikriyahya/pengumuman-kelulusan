<?php

namespace App\Filament\Resources\TamuUndangans\Pages;

use App\Filament\Resources\TamuUndangans\TamuUndanganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTamuUndangans extends ListRecords
{
    protected static string $resource = TamuUndanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
