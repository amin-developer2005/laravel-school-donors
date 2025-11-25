<?php

namespace App\Filament\SchoolDonors\Resources\SchoolDonorsInformation\Pages;

use App\Filament\SchoolDonors\Resources\SchoolDonorsInformation\SchoolDonorsInformationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSchoolDonorsInformation extends EditRecord
{
    protected static string $resource = SchoolDonorsInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
