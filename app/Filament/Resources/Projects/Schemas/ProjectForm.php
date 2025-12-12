<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Donor;
use App\Models\FundingSource;
use App\Models\Region;
use App\Repositories\DonorRepository;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class ProjectForm
{
    private string $urban {
        set => $this->urban = $value;
        get {
            return "شهر";
        }
    }
    private string $rural {
        set => $this->rural = $value;
        get {
            return "روستا";
        }
    }


    public static function donors()
    {
        return Donor::query()->pluck('name', 'id')->all();
    }


    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->string(),

                Select::make('status')
                    ->required()
                    ->options([
                        'در دست اجرا' => 'در دست اجرا',
                        'کامل شده'    => 'کامل شده',
                        'کنسل شده' => 'کنسل شده',
                    ]),

                TextInput::make('space_code')
                    ->required()
                    ->integer()
                    ->length(8),

                Select::make('urban_rural')
                    ->label('نوع منطقه')
                    ->options([
                        'شهر'   => 'شهری',
                        'روستا' => 'روستایی',
                    ])
                    ->required()->reactive()
                    ->afterStateUpdated(
                        fn($state, $set) => $set('city', $state->city) && $set('village', $state->village)
                    ),

                TextInput::make('city')
                    ->required()
                    ->visible(
                        fn($get) => $get("urban_rural") == $this->urban
                    ),

                TextInput::make('village')
                    ->required()
                    ->visible(
                        fn($get) => $get("urban_rural") == $this->rural
                    ),

                Select::make('district')
                    ->required()
                    ->options(
                        fn() => Region::query()->pluck('name', 'id')->all()
                    ),

                Select::make('usage_type')
                    ->required()
                    ->options(
                        fn() => FundingSource::query()->pluck('name', 'id')->all()
                    ),

                TextInput::make('start_year')
                    ->required()
                    ->numeric()
                    ->minValue(1200)
                    ->maxValue(2000)
                    ->label('سال شروع'),

                TextInput::make('end_year')
                    ->required()
                    ->numeric()
                    ->minValue(1200)
                    ->maxValue(2000)
                    ->label('سال پایان'),

                Select::make('funding_source')
                    ->required()
                    ->options(
                        fn(): array => FundingSource::query()->pluck('name', 'id')->all(),
                    ),

                Select::make('builder_donor_id')
                    ->required()
                    ->options(DonorRepository::pluckDonors())
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search) => Donor::query()
                            ->where('name', 'like', "%{$search}%")
                            ->pluck('name', 'id')
                            ->all()
                    ),

                Select::make('land_donor_id')
                    ->required()
                    ->options(DonorRepository::pluckDonors()),

                TextInput::make('cost')
                    ->required()
                    ->integer()
                    ->formatStateUsing(
                        fn(int $cost) => number_format($cost, 2, '.', ' ')
                    ),

                TextInput::make("main_building_area")
                    ->required()
                    ->numeric()
                    ->length(5),

                TextInput::make("bathroom_area")
                    ->required()
                    ->integer()
                    ->length(5),

                TextInput::make("janitor_area")
                    ->required()
                    ->integer()
                    ->length(5),

                TextInput::make("guard_area")
                    ->required()
                    ->integer()
                    ->length(5),

                TextInput::make("wall_area")
                    ->required()
                    ->integer()
                    ->length(5),

                TextInput::make("land_spacing_area")
                    ->required()
                    ->integer()
                    ->length(5),

                TextInput::make("gym_area")
                    ->required()
                    ->integer()
                    ->length(5),

                TextInput::make("prayer_room_area")
                    ->required()
                    ->integer()
                    ->length(5),

                TextInput::make("total_under_constructions")
                    ->required()
                    ->integer()
                    ->length(5),

                TextInput::make("land_area")
                    ->required()
                    ->integer()
                    ->length(5),

                TextInput::make("classrooms_count")
                    ->required()
                    ->integer()
                    ->length(3),

                TextInput::make("contractor")
                    ->required()
                    ->string(),

                TextInput::make("supervisor")
                    ->required()
                    ->string(),

                TextInput::make("address")
                    ->required()
                    ->string(),

                Section::make('سایر اطلاعات')
                    ->components([
                        TextInput::make('contractor')->label('پیمانکار'),
                        TextInput::make('supervisor')->label('ناظر'),
                        Textarea::make('address')->label('آدرس')->rows(3),

                        FileUpload::make('agreement_file')
                            ->required()
                            ->label('فایل تفاهم‌نامه (PDF یا Word)')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/doc',
                                'application/docx',
                                'application/xlsx',
                                'application/zip'
                            ])
                            ->directory('projects/agreements')
                            ->nullable()
                    ])->columns(2),
            ]);
    }
}
