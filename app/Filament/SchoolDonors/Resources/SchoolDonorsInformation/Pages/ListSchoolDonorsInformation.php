<?php

namespace App\Filament\SchoolDonors\Resources\SchoolDonorsInformation\Pages;

use App\Filament\SchoolDonors\Resources\SchoolDonorsInformation\SchoolDonorsInformationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSchoolDonorsInformation extends ListRecords
{
    protected static string $resource = SchoolDonorsInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
