<?php

namespace App\Filament\Resources\TamuUndangans;

use App\Filament\Resources\TamuUndangans\Pages\CreateTamuUndangan;
use App\Filament\Resources\TamuUndangans\Pages\EditTamuUndangan;
use App\Filament\Resources\TamuUndangans\Pages\ListTamuUndangans;
use App\Filament\Resources\TamuUndangans\Pages\ViewTamuUndangan;
use App\Filament\Resources\TamuUndangans\Schemas\TamuUndanganForm;
use App\Filament\Resources\TamuUndangans\Schemas\TamuUndanganInfolist;
use App\Filament\Resources\TamuUndangans\Tables\TamuUndangansTable;
use App\Models\TamuUndangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TamuUndanganResource extends Resource
{
    protected static ?string $model = TamuUndangan::class;

    protected static bool $shouldRegisterNavigation = true;

    // protected static string|UnitEnum|null $navigationGroup = 'Personil';
    protected static ?string $navigationLabel = 'Tamu Undangan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return TamuUndanganForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TamuUndanganInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TamuUndangansTable::configure($table);
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
            'index' => ListTamuUndangans::route('/'),
            'create' => CreateTamuUndangan::route('/create'),
            'view' => ViewTamuUndangan::route('/{record}'),
            'edit' => EditTamuUndangan::route('/{record}/edit'),
        ];
    }
}
