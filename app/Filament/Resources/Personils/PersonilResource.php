<?php

namespace App\Filament\Resources\Personils;

use App\Filament\Resources\Personils\Pages\CreatePersonil;
use App\Filament\Resources\Personils\Pages\EditPersonil;
use App\Filament\Resources\Personils\Pages\ListPersonils;
use App\Filament\Resources\Personils\Pages\ViewPersonil;
use App\Filament\Resources\Personils\Schemas\PersonilForm;
use App\Filament\Resources\Personils\Schemas\PersonilInfolist;
use App\Filament\Resources\Personils\Tables\PersonilsTable;
use App\Models\Personil;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PersonilResource extends Resource
{
    protected static ?string $model = Personil::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return PersonilForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PersonilInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PersonilsTable::configure($table);
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
            'index' => ListPersonils::route('/'),
            'create' => CreatePersonil::route('/create'),
            'view' => ViewPersonil::route('/{record}'),
            'edit' => EditPersonil::route('/{record}/edit'),
        ];
    }
}
