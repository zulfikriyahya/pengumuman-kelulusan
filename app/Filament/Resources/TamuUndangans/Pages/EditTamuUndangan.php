<?php

namespace App\Filament\Resources\TamuUndangans\Pages;

use App\Filament\Resources\TamuUndangans\TamuUndanganResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTamuUndangan extends EditRecord
{
    protected static string $resource = TamuUndanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
