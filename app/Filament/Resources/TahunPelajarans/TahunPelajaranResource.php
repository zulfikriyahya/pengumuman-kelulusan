<?php

namespace App\Filament\Resources\TahunPelajarans;

use App\Filament\Resources\TahunPelajarans\Pages\CreateTahunPelajaran;
use App\Filament\Resources\TahunPelajarans\Pages\EditTahunPelajaran;
use App\Filament\Resources\TahunPelajarans\Pages\ListTahunPelajarans;
use App\Filament\Resources\TahunPelajarans\Pages\ViewTahunPelajaran;
use App\Filament\Resources\TahunPelajarans\Schemas\TahunPelajaranForm;
use App\Filament\Resources\TahunPelajarans\Schemas\TahunPelajaranInfolist;
use App\Filament\Resources\TahunPelajarans\Tables\TahunPelajaransTable;
use App\Models\TahunPelajaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TahunPelajaranResource extends Resource
{
    protected static ?string $model = TahunPelajaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TahunPelajaranForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TahunPelajaranInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TahunPelajaransTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTahunPelajarans::route('/'),
            'create' => CreateTahunPelajaran::route('/create'),
            'view' => ViewTahunPelajaran::route('/{record}'),
            'edit' => EditTahunPelajaran::route('/{record}/edit'),
        ];
    }
}
