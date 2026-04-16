<?php

namespace App\Filament\Resources\TahunPelajarans\Pages;

use App\Filament\Resources\TahunPelajarans\TahunPelajaranResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTahunPelajaran extends ViewRecord
{
    protected static string $resource = TahunPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
