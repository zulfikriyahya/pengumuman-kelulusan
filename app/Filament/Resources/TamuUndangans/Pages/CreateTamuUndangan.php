<?php

namespace App\Filament\Resources\TamuUndangans\Pages;

use App\Filament\Resources\TamuUndangans\TamuUndanganResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTamuUndangan extends CreateRecord
{
    protected static string $resource = TamuUndanganResource::class;
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
