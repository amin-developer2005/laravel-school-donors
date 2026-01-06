<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Donor;
use App\Models\FundingSource;
use App\Models\ProjectUsageType;
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
use Illuminate\Validation\Rule;

class ProjectForm
{
    public const string URBAN = "شهر" ;
    public const string RURAL = "روستا";

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->label('عنوان پروژه')
                    ->string()
                    ->validationAttribute('عنوان پروژه')

                    ->validationAttribute('عنوان پروژه')
                    ->validationMessages([
                        'required' => 'وارد کردن عنوان پروژه الزامی است.',
                        'string' => 'عنوان پروژه باید متن باشد.',
                    ]),

                Select::make('status')
                    ->required()
                    ->label('وضعیت پروژه')
                    ->reactive()
                    ->options([
                        'در دست اجرا' => 'در دست اجرا',
                        'کامل شده'    => 'کامل شده',
                        'کنسل شده' => 'کنسل شده',
                    ])
                    ->rules(['required','in:در دست اجرا,کامل شده,کنسل شده'])
                    ->validationAttribute('وضعیت پروژه')
                    ->validationAttribute('وضعیت پروژه')
                    ->validationMessages([
                        'required' => 'انتخاب وضعیت پروژه الزامی است.',
                    ]),

                TextInput::make('space_code')
                    ->required()
                    ->label('کد فضا (۸ رقمی)')
                    ->numeric()
                    ->maxLength(99999999)
                    ->rules(['required','numeric','digits:8', 'unique:projects,space_code'])
                    ->validationAttribute('کد فضا')
                    ->validationMessages([
                        'required' => 'کد فضا باید وارد شود.',
                        'unique'  => 'کد فضا باید منحصر به فرد باشد. این کد  قبلا استفاده شده است.',
                        'numeric' => 'کد فضا باید فقط شامل عدد باشد.',
                        'digits' => 'کد فضا باید دقیقاً ۸ رقم باشد.',
                    ]),


                Select::make('urban_rural')
                    ->label('نوع منطقه')
                    ->options([
                        self::URBAN   => self::URBAN,
                        self::RURAL   => self::RURAL,
                    ])
                    ->required()
                    ->reactive()
                    ->rules(['required','in:'.self::URBAN.','.self::RURAL])
                    ->validationAttribute('نوع منطقه')
                    ->validationAttribute('نوع منطقه')
                    ->validationMessages([
                        'required' => 'انتخاب نوع منطقه الزامی است.',
                    ]),

                TextInput::make('city')
                    ->required()
                    ->label('نام شهر')
                    ->visible(fn($get) : bool => $get("urban_rural") == self::URBAN)
                    ->rules([fn($get) => $get('urban_rural') == self::URBAN ? 'required' : 'nullable'])
                    ->validationAttribute('نام شهر')
                    ->validationAttribute('نام شهر')
                    ->validationMessages([
                        'required' => 'نام شهر را وارد کنید.',
                    ]),

                TextInput::make('village')
                    ->required()
                    ->label('نام روستا')
                    ->visible(fn($get) => $get("urban_rural") == self::RURAL)
                    ->rules([fn($get) => $get('urban_rural') == self::RURAL ? 'required' : 'nullable'])
                    ->validationAttribute('نام روستا')
                     ->validationAttribute('نام روستا')
                    ->validationMessages([
                        'required' => 'نام روستا را وارد کنید.',
                    ]),

                Select::make('region_id')
                    ->required()
                    ->label('ناحیه / منطقه')
                    ->options(fn() => Region::query()->pluck('name', 'id')->all())
                    ->rules(['required','integer','exists:regions,id'])
                    ->validationAttribute('ناحیه / منطقه')
                    ->validationAttribute('ناحیه / منطقه')
                    ->validationMessages([
                        'required' => 'انتخاب ناحیه یا منطقه الزامی است.',
                    ]),

                Select::make('project_usage_type_id')
                    ->required()
                    ->label('نوع کاربری')
                    ->options(fn() => ProjectUsageType::query()->pluck('name', 'id')->all())
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search) => ProjectUsageType::query()
                            ->where('name', 'like', "%{$search}%")
                            ->pluck('name', 'id')
                            ->all()
                    )
                    ->rules(['required','integer','exists:project_usage_types,id'])
                    ->validationAttribute('نوع کاربری')
                    ->validationAttribute('نوع کاربری')
                    ->validationMessages([
                        'required' => 'انتخاب نوع کاربری الزامی است.',
                    ]),

                TextInput::make('start_year')
                    ->required()
                    ->numeric()
                    ->minValue(1200)
                    ->maxValue(2000)
                    ->placeholder("1200 - 2000")
                    ->label('سال شروع')
                    ->rules(['required','integer','between:1200,2000'])
                    ->validationAttribute('سال شروع')
                    ->validationAttribute('سال شروع')
                    ->validationMessages([
                        'required' => 'سال شروع الزامی است.',
                        'numeric' => 'سال شروع باید عدد باشد.',
                        'min' => 'سال شروع نمی‌تواند کمتر از 1200 باشد.',
                        'max' => 'سال شروع نمی‌تواند بیشتر از 2000 باشد.',
                    ]),

                TextInput::make('end_year')
                    ->required()
                    ->numeric()
                    ->minValue(1200)
                    ->maxValue(2000)
                    ->placeholder("1200 - 2000")
                    ->label('سال پایان')
                    ->rules(['required','integer','between:1200,2000'])
                    ->validationAttribute('سال پایان')
                    ->validationAttribute('سال پایان')
                    ->validationMessages([
                        'required' => 'سال پایان الزامی است.',
                        'numeric' => 'سال پایان باید عدد باشد.',
                        'min' => 'سال پایان نمی‌تواند کمتر از 1200 باشد.',
                        'max' => 'سال پایان نمی‌تواند بیشتر از 2000 باشد.',
                    ]),

                Select::make('funding_source_id')
                    ->required()
                    ->label('منبع تامین اعتبار')
                    ->options(fn(): array => FundingSource::query()->pluck('name', 'id')->all())
                    ->searchable()
                    ->getSearchResultsUsing(
                        fn(string $search) => FundingSource::query()
                            ->where('name', 'like', "%{$search}%")
                            ->pluck('name', 'id')
                            ->all()
                    )
                    ->rules(['required','integer','exists:funding_sources,id'])
                    ->validationAttribute('منبع تامین اعتبار')
                    ->validationAttribute('منبع تامین اعتبار')
                    ->validationMessages([
                        'required' => 'انتخاب منبع تامین اعتبار الزامی است.',
                    ]),

                Select::make('builder_donor_id')
                    ->required()
                    ->label('بانی بنا')
                    ->options(DonorRepository::pluckDonors())
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search) => DonorRepository::searchDonors($search))
                    ->rules(['required','integer','exists:donors,id'])
                    ->validationAttribute('بانی بنا')
                    ->validationAttribute('بانی بنا')
                    ->validationMessages([
                        'required' => 'انتخاب بانی بنا الزامی است.',
                    ]),

                Select::make('land_donor_id')
                    ->required()
                    ->label('بانی زمین')
                    ->options(DonorRepository::pluckDonors())
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search) => DonorRepository::searchDonors($search))
                    ->rules(['required','integer','exists:donors,id'])
                    ->validationAttribute('بانی زمین')
                    ->validationAttribute('بانی زمین')
                    ->validationMessages([
                        'required' => 'انتخاب بانی زمین الزامی است.',
                    ]),

                TextInput::make('cost')
                    ->required()
                    ->integer()
                    ->visible(fn($get) => $get('status') == 'کامل شده')
                    ->rules(fn($get) => $get('status') == 'کامل شده' ? ['required', 'integer'] : ['nullable', 'integer'])
                    ->validationAttribute('هزینه')
                    ->validationAttribute('هزینه پروژه')
                    ->validationMessages([
                        'required' => 'هزینه پروژه الزامی است.',
                        'integer' => 'هزینه پروژه باید عدد صحیح باشد.',
                    ]),

                TextInput::make('main_building_area')
                    ->label('ساختمان اصلی (متر)')
                    ->numeric()
                    ->maxLength(99999)
                    ->rules(['nullable','numeric','digits:5'])
                    ->validationAttribute('ساختمان اصلی')
                    ->validationAttribute('ساختمان اصلی')
                    ->validationMessages([
                        'numeric' => 'مساحت ساختمان اصلی باید عدد باشد.',
                        'digits'  => 'این فیلد 5 رقم باید باشد.'
                    ]),

                TextInput::make('bathroom_area')
                    ->label('سرویس بهداشتی (متر)')
                    ->numeric()
                    ->maxLength(99999)
                    ->rules(['nullable','numeric','digits:5'])
                    ->validationAttribute('سرویس بهداشتی')
                    ->validationAttribute('سرویس بهداشتی')
                    ->validationMessages([
                        'numeric' => 'مساحت سرویس بهداشتی باید عدد باشد.',
                        'digits'  => 'این فیلد 5 رقم باید باشد.'
                    ]),

                TextInput::make('janitor_area')
                    ->label('سرایداری (متر)')
                    ->numeric()
                    ->maxLength(99999)
                    ->rules(['nullable','numeric','digits:5'])
                    ->validationAttribute('سرایداری')
                    ->validationAttribute('سرایداری')
                    ->validationMessages([
                        'numeric' => 'مساحت سرایداری باید عدد باشد.',
                        'digits'  => 'این فیلد 5 رقم باید باشد.'
                    ]),

                TextInput::make('guard_area')
                    ->label('نگهبانی (متر)')
                    ->numeric()
                    ->maxLength(99999)
                    ->rules(['nullable','numeric','digits:5'])
                    ->validationAttribute('نگهبانی')
                    ->validationAttribute('نگهبانی')
                    ->validationMessages([
                        'numeric' => 'مساحت نگهبانی باید عدد باشد.',
                        'digits'  => 'این فیلد 5 رقم باید باشد.'
                    ]),

                TextInput::make('wall_area')
                    ->label('دیوارکشی (متر)')
                    ->numeric()
                    ->maxLength(99999)
                    ->rules(['nullable','numeric','digits:5'])
                    ->validationAttribute('دیوارکشی')
                    ->validationAttribute('دیوارکشی')
                    ->validationMessages([
                        'numeric' => 'مساحت دیوارکشی باید عدد باشد.',
                        'digits'  => 'این فیلد 5 رقم باید باشد.'
                    ]),

                TextInput::make('landscaping_area')
                    ->label('محوطه‌سازی (متر)')
                    ->numeric()
                    ->maxLength(99999)
                    ->rules(['nullable','numeric','digits:5'])
                    ->validationAttribute('محوطه‌سازی')
                    ->validationAttribute('محوطه‌سازی')
                    ->validationMessages([
                        'numeric' => 'مساحت محوطه‌سازی باید عدد باشد.',
                        'digits'  => 'این فیلد 5 رقم باید باشد.'
                    ]),

                TextInput::make('gym_area')
                    ->label('سالن ورزشی (متر)')
                    ->numeric()
                    ->maxLength(99999)
                    ->rules(['nullable','numeric','digits:5'])
                    ->validationAttribute('سالن ورزشی')
                    ->validationAttribute('سالن ورزشی')
                    ->validationMessages([
                        'numeric' => 'مساحت سالن ورزشی باید عدد باشد.',
                        'digits'  => 'این فیلد 5 رقم باید باشد.'
                    ]),

                TextInput::make('prayer_room_area')
                    ->label('نمازخانه (متر)')
                    ->numeric()
                    ->maxLength(99999)
                    ->rules(['nullable','numeric','digits:5'])
                    ->validationAttribute('نمازخانه')
                    ->validationAttribute('نمازخانه')
                    ->validationMessages([
                        'numeric' => 'مساحت نمازخانه باید عدد باشد.',
                        'digits'  => 'این فیلد 5 رقم باید باشد.'
                    ]),

                TextInput::make('total_under_constructions')
                    ->label('کل زیربنا (متر)')
                    ->numeric()
                    ->maxLength(99999)
                    ->rules(['nullable','numeric','digits:5'])
                    ->validationAttribute('کل زیربنا')
                    ->validationAttribute('کل زیربنا')
                    ->validationMessages([
                        'numeric' => 'کل زیربنا باید عدد باشد.',
                        'digits'  => 'این فیلد 5 رقم باید باشد.'
                    ]),

                TextInput::make('land_spacing_area')
                    ->label('مساحت زمین (متر)')
                    ->numeric()
                    ->maxLength(99999)
                    ->rules(['nullable','numeric','digits:5'])
                    ->validationAttribute('مساحت زمین')
                    ->validationAttribute('مساحت زمین')
                    ->validationMessages([
                        'numeric' => 'مساحت زمین باید عدد باشد.',
                        'digits'  => 'این فیلد 5 رقم باید باشد.'
                    ]),

                TextInput::make('classrooms_count')
                    ->label('تعداد کلاس')
                    ->numeric()
                    ->maxLength(999)
                    ->rules(['nullable','integer','min:0','max:9999'])
                    ->validationAttribute('تعداد کلاس')
                    ->validationAttribute('تعداد کلاس')
                    ->validationMessages([
                        'numeric' => 'تعداد کلاس باید عدد باشد.',
                        'max' => 'حداکثر تعداد کلاس 999 می‌باشد.',
                    ]),

                TextInput::make('contractor')->label('پیمانکار')
                    ->rules(['nullable','string','max:255'])
                    ->validationAttribute('پیمانکار')
                    ->validationMessages([
                            'required' => 'نام پیمانکار الزامی است.'
                    ]),

                TextInput::make('supervisor')->label('ناظر')
                    ->rules(['nullable','string','max:255'])
                    ->validationAttribute('ناظر')
                    ->validationMessages([
                        'required' => 'نام  ناظر الزامی است.'
                    ]),

                Textarea::make('address')->label('آدرس')->rows(3)
                    ->rules(['nullable','string','max:2000'])
                    ->validationAttribute('آدرس')
                    ->validationMessages([
                        'address.string'    => 'آدرس باید متن باشد.',
                        'address.max'       => 'آدرس نباید بیش از :max کاراکتر باشد.',
                    ]),

                FileUpload::make('agreement_file')
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
                    ->rules(['nullable','file','mimes:pdf,doc,docx,xlsx,zip','max:5120'])
                    ->validationAttribute('فایل تفاهم‌نامه')
                    ->validationMessages([
                        'file'  => 'فایل تفاهم‌نامه نامعتبر است.',
                        'mimes' => 'فایل تفاهم‌نامه باید از نوع PDF، DOC، DOCX، XLSX یا ZIP باشد.',
                        'max'   => 'حجم فایل تفاهم‌نامه نباید بیش از :max کیلوبایت باشد.',
                    ]),
            ]);
    }
}
