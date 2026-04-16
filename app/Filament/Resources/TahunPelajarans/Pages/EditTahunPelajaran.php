<?php

namespace App\Filament\Resources\TahunPelajarans\Pages;

use App\Filament\Resources\TahunPelajarans\TahunPelajaranResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTahunPelajaran extends EditRecord
{
    protected static string $resource = TahunPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
