<?php

namespace App\Filament\Resources\Donors;

use App\Filament\Resources\Donors\Pages\CreateDonor;
use App\Filament\Resources\Donors\Pages\EditDonor;
use App\Filament\Resources\Donors\Pages\ListDonors;
use App\Filament\Resources\Donors\Schemas\DonorForm;
use App\Filament\Resources\Donors\Tables\DonorsTable;
use App\Models\Donor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;


class DonorResource extends Resource
{
    protected static ?string $model = Donor::class;
    protected static ?string $recordTitleAttribute = 'Donors';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DonorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DonorsTable::configure($table);
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
            'index' => ListDonors::route('/'),
            'create' => CreateDonor::route('/create'),
            'edit' => EditDonor::route('/{record}/edit'),
        ];
    }


    /**
     * @return string|null
     */
    public static function getNavigationLabel(): string
    {
        return __("donor.panel.navigation_label");
    }

    public static function getLabel(): ?string
    {
        return __("donor.panel.label");
    }

    public static function getBreadcrumb(): string
    {
        return __("donor.panel.breadcrumb");
    }
}
