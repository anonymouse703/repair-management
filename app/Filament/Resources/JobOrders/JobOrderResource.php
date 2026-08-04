<?php

namespace App\Filament\Resources\JobOrders;

use App\Filament\Resources\JobOrders\Pages\CreateJobOrder;
use App\Filament\Resources\JobOrders\Pages\EditJobOrder;
use App\Filament\Resources\JobOrders\Pages\ListJobOrders;
use App\Filament\Resources\JobOrders\RelationManagers\InventoryUsagesRelationManager;
use App\Filament\Resources\JobOrders\Schemas\JobOrderForm;
use App\Filament\Resources\JobOrders\Tables\JobOrdersTable;
use App\Models\JobOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JobOrderResource extends Resource
{
    protected static ?string $model = JobOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();

    if (auth()->user()?->isTechnician()) {
        $query->where('technician_id', auth()->id());
    }

    return $query;
}

    public static function form(Schema $schema): Schema
    {
        return JobOrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InventoryUsagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobOrders::route('/'),
            'create' => CreateJobOrder::route('/create'),
            'view' => Pages\ViewJobOrder::route('/{record}'),
            'edit' => EditJobOrder::route('/{record}/edit'),
        ];
    }
}
