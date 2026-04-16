<?php

namespace App\Filament\Resources\TahunPelajarans\Pages;

use App\Filament\Resources\TahunPelajarans\TahunPelajaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTahunPelajarans extends ListRecords
{
    protected static string $resource = TahunPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
