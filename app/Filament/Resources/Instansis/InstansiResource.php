<?php

namespace App\Filament\Resources\Instansis;

use App\Filament\Resources\Instansis\Pages\CreateInstansi;
use App\Filament\Resources\Instansis\Pages\EditInstansi;
use App\Filament\Resources\Instansis\Pages\ListInstansis;
use App\Filament\Resources\Instansis\Pages\ViewInstansi;
use App\Filament\Resources\Instansis\Schemas\InstansiForm;
use App\Filament\Resources\Instansis\Schemas\InstansiInfolist;
use App\Filament\Resources\Instansis\Tables\InstansisTable;
use App\Models\Instansi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InstansiResource extends Resource
{
    protected static ?string $model = Instansi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return InstansiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InstansiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstansisTable::configure($table);
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
            'index' => ListInstansis::route('/'),
            'create' => CreateInstansi::route('/create'),
            'view' => ViewInstansi::route('/{record}'),
            'edit' => EditInstansi::route('/{record}/edit'),
        ];
    }
}
