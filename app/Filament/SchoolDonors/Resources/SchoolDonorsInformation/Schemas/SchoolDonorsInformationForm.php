<?php

namespace App\Filament\SchoolDonors\Resources\SchoolDonorsInformation\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SchoolDonorsInformationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('fullName')->required()->label('نام و نام خانوادگی')->string(),
                TextInput::make('nationalCode')->required()->label('کد ملی')->string(),
                TextInput::make('address')->required()->label('آدرس')->string(),
                TextInput::make('city')->required()->label('شهر')->string(),
                TextInput::make('mobile')->required()->label('موبایل')->numeric(),
                Select::make('type')->options([
                    'حقیقی', 'حقوقی'
                ])->label('وع خیرن')->required(),
                Select::make('gender')->options([
                    'مرد' , 'زن'
                ])->required(),
            ]);
    }
}
