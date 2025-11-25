<?php

namespace App\Filament\Resources\Donors\Schemas;

use App\Models\Degree;
use App\Models\VeteranStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DonorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')->options([
                    'حقیقی' => 'حقیقی',
                    'حقوقی' => 'حقوقی',
                ])->label('نوع متعهد')->required(),
                TextInput::make('national_code')->label('کد ملی')->string()->required(),
                TextInput::make('full_name')->label('نام و نام خانوادگی')->string()->required(),

                Select::make('life_status')->label('وضعیت حیات')->options([
                    'در قید حیات'   => 'در قید حیات',
                    'فوت شده'   => 'فوت شده',
                ])->required(),

                TextInput::make('father_name')->label('نام پدر')->string()->required(),
                TextInput::make('birth_certificate_number')->label('شماره شناسنامه')->string()->required(),

                DateTimePicker::make('birth_date')->label('تاریخ تولد')->required(),
                TextInput::make('birth_location')->label('محل تولد')->required(),

                Select::make('degree_id')
                    ->label('مدرک تحصیلی')
                    ->options(self::degrees())
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => Degree::query()
                        ->where('name', 'like', "%{$search}%")
                        ->pluck('name', 'id')
                        ->all()
                    )
                    ->getOptionLabelsUsing(fn (string $value) : ?string => Degree::query()
                        ->find($value)?->name ?? ''
                    )
                    ->noSearchResultsMessage('مدرک تحصیلی مورد نظر شما یافت نشد.')
                    ->loadingMessage("در حال بارگزاری مدارک تحصیلی....")
                    ->searchingMessage("در حال جستجو مدرک تحصیلی .....")
                    ->required(),

                TextInput::make('major')
                    ->label('رشته تحصیلی')
                    ->string()
                    ->required(),

                Select::make('marital_status')
                    ->label('وضعیت تاهل')
                    ->options([
                    'مجرد' => 'مجرد',
                    'متاهل' => 'متاهل',
                ])->required(),

                TextInput::make('child_count')
                    ->label('تعداد فرزند')
                    ->integer()
                    ->required(),

                Select::make('veteran_status_id')
                    ->label('وضعیت ایثارگری')
                    ->options(self::veteranStatuses())
                    ->searchable()
                    ->getOptionLabelsUsing(
                        fn (string $value) : ?string => VeteranStatus::query()->find($value)?->name ?? 'Not Found'
                    )
                    ->required(),

                TextInput::make('landline_number')
                    ->label('تلفن ثابت')
                    ->numeric()->required(),
                TextInput::make('mobile')
                    ->label('تلفن همراه')
                    ->numeric()->required(),

                TextInput::make('address')
                    ->label('آدرس')
                    ->string(),
                TextInput::make('description')
                    ->label('توضیحات تکمیلی')
                    ->string(),
            ]);
    }

    private static function degrees(): array
    {
        return Degree::query()->pluck('name', 'id')->toArray();
    }

    private static function veteranStatuses(): array
    {
        return VeteranStatus::query()->pluck('name', 'id')->toArray();
    }
}
