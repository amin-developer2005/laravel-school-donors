<?php

namespace App\Filament\SchoolDonors\Resources\SchoolDonorsInformation;

use App\Filament\SchoolDonors\Resources\SchoolDonorsInformation\Pages\CreateSchoolDonorsInformation;
use App\Filament\SchoolDonors\Resources\SchoolDonorsInformation\Pages\EditSchoolDonorsInformation;
use App\Filament\SchoolDonors\Resources\SchoolDonorsInformation\Pages\ListSchoolDonorsInformation;
use App\Filament\SchoolDonors\Resources\SchoolDonorsInformation\Schemas\SchoolDonorsInformationForm;
use App\Filament\SchoolDonors\Resources\SchoolDonorsInformation\Tables\SchoolDonorsInformationTable;
use App\Models\Donor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SchoolDonorsInformationResource extends Resource
{
    protected static ?string $model = Donor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'اطلاعات خیرین مدرسه ساز';

    public static function form(Schema $schema): Schema
    {
        return SchoolDonorsInformationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchoolDonorsInformationTable::configure($table);
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
            'index' => ListSchoolDonorsInformation::route('/'),
            'create' => CreateSchoolDonorsInformation::route('/create'),
            'edit' => EditSchoolDonorsInformation::route('/{record}/edit'),
        ];
    }
}
