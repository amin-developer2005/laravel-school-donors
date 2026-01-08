<?php

namespace App\Filament\Resources\Donors\Schemas;

use App\Models\Degree;
use App\Models\Donor;
use App\Models\VeteranStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class DonorForm
{
    public static function configures(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')->options([
                    'حقیقی' => 'حقیقی',
                    'حقوقی' => 'حقوقی',
                ])->label('نوع متعهد')->required(),
                TextInput::make('national_code')->label('کد ملی')
                    ->required()
                    ->string()
                    ->maxLength(10)
                    ->rules(['required', 'string', 'digits:10', 'unique:donors,national_code'])
                    ->validationAttribute('کد ملی')
                    ->validationMessages([
                        'required'  => 'لطفا کد ملی خود را وارد نمایید.',
                        'digits'  => 'طول کد ملی باید 10 رقم باشد.',
                        'unique'  => 'کد ملی شما باید منحصر به فرد باشد. این کد ملی ملی متعلق به فرد دیگری است.',
                    ])
                ,
                TextInput::make('full_name')->label('نام و نام خانوادگی')->string()->required(),

                Select::make('life_status')->label('وضعیت حیات')->options([
                    'در قید حیات'   => 'در قید حیات',
                    'فوت شده'       => 'فوت شده',
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

                Textarea::make('address')
                    ->label('آدرس')
                    ->string(),
                Textarea::make('description')
                    ->label('توضیحات تکمیلی')
                    ->string(),
            ]);
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('نوع متعهد')
                    ->options([
                        'حقیقی' => 'حقیقی',
                        'حقوقی' => 'حقوقی',
                    ])
                    ->required()
                    ->rules(['required', "in:حقیقی,حقوقی"])
                    ->validationMessages([
                        'required' => 'لطفاً نوع متعهد را انتخاب کنید.',
                        'in'       => 'نوع متعهد انتخاب‌شده نامعتبر است.',
                    ]),

                TextInput::make('national_code')
                    ->label('کد ملی')
                    ->required()
                    ->string()
                    ->maxLength(10)
                    ->rules(['required', 'digits:10', 'regex:/^\d{10}$/', 'unique:donors,national_code'])
                    ->validationMessages([
                        'required' => 'لطفاً کد ملی را وارد کنید.',
                        'digits'   => 'کد ملی باید دقیقاً :digits رقم باشد.',
                        'regex'    => 'کد ملی باید شامل تنها ارقام و دارای طول ۱۰ رقم باشد.',
                        'string'   => 'کد ملی باید به صورت متن وارد شود.',
                        'max'      => 'کد ملی نمی‌تواند بیش از :max کاراکتر باشد.',
                        'unique'  => 'کد ملی شما باید منحصر به فرد باشد. این کد ملی ملی متعلق به فرد دیگری است.',
                    ]),

                TextInput::make('full_name')
                    ->label('نام و نام خانوادگی')
                    ->string()
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'وارد کردن نام و نام خانوادگی الزامی است.',
                        'string'   => 'نام و نام خانوادگی باید به صورت متن وارد شود.',
                        'max'      => 'نام و نام خانوادگی نباید بیش از :max کاراکتر باشد.',
                    ]),

                Select::make('life_status')
                    ->label('وضعیت حیات')
                    ->options([
                        'در قید حیات' => 'در قید حیات',
                        'فوت شده'     => 'فوت شده',
                    ])
                    ->required()
                    ->rules(['required', "in:در قید حیات,فوت شده"])
                    ->validationMessages([
                        'required' => 'لطفاً وضعیت حیات را انتخاب کنید.',
                        'in'       => 'وضعیت حیات انتخاب‌شده نامعتبر است.',
                    ]),

                TextInput::make('father_name')
                    ->label('نام پدر')
                    ->string()
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'نام پدر را وارد کنید.',
                        'string'   => 'نام پدر باید به صورت متن وارد شود.',
                        'max'      => 'نام پدر نباید بیش از :max کاراکتر باشد.',
                    ]),

                TextInput::make('birth_certificate_number')
                    ->label('شماره شناسنامه')
                    ->string()
                    ->required()
                    ->maxLength(50)
                    ->rule([
                        'required', 'string', 'max:50', 'unique:donors,birth_certificate_number',
                    ])
                    ->validationMessages([
                        'required' => 'شماره شناسنامه را وارد کنید.',
                        'string'   => 'شماره شناسنامه باید به صورت متن وارد شود.',
                        'max'      => 'شماره شناسنامه نباید بیش از :max کاراکتر باشد.',
                        'unique'   => 'این شماره شناسنامه قبلاً در سیستم ثبت شده است.',
                    ]),

                DateTimePicker::make('birth_date')
                    ->label('تاریخ تولد')
                    ->required()
                    ->rules(['required', 'date'])
                    ->validationMessages([
                        'required'    => 'لطفاً تاریخ تولد را وارد کنید.',
                        'date'        => 'تاریخ تولد وارد شده معتبر نیست.',
                        'date_format' => 'تاریخ تولد باید با فرمت معتبر ثبت شود.',
                    ]),

                TextInput::make('birth_location')
                    ->label('محل تولد')
                    ->string()
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'محل تولد را وارد کنید.',
                        'string'   => 'محل تولد باید به صورت متن وارد شود.',
                        'max'      => 'محل تولد نباید بیش از :max کاراکتر باشد.',
                    ]),

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
                    ->required()
                    // فرض بر این است که جدول degrees وجود دارد و id معتبر چک شود
                    ->rules(['required', 'integer', 'exists:degrees,id'])
                    ->validationMessages([
                        'required' => 'لطفاً مدرک تحصیلی را انتخاب کنید.',
                        'integer'  => 'مدرک تحصیلی انتخاب‌شده نامعتبر است.',
                        'exists'   => 'مدرک تحصیلی انتخاب‌شده در سیستم وجود ندارد.',
                    ]),

                TextInput::make('major')
                    ->label('رشته تحصیلی')
                    ->string()
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'رشته تحصیلی را وارد کنید.',
                        'string'   => 'رشته تحصیلی باید به صورت متن وارد شود.',
                        'max'      => 'رشته تحصیلی نباید بیش از :max کاراکتر باشد.',
                    ]),

                Select::make('marital_status')
                    ->label('وضعیت تاهل')
                    ->options([
                        'مجرد'  => 'مجرد',
                        'متاهل' => 'متاهل',
                    ])
                    ->required()
                    ->rules(['required', "in:مجرد,متاهل"])
                    ->validationMessages([
                        'required' => 'لطفاً وضعیت تاهل را انتخاب کنید.',
                        'in'       => 'وضعیت تاهل انتخاب‌شده نامعتبر است.',
                    ]),

                TextInput::make('child_count')
                    ->label('تعداد فرزند')
                    ->integer()
                    ->required()
                    ->rules(['required', 'integer', 'min:0'])
                    ->validationMessages([
                        'required' => 'تعداد فرزند را وارد کنید.',
                        'integer'  => 'تعداد فرزند باید یک عدد صحیح باشد.',
                        'min'      => 'تعداد فرزند نمی‌تواند کمتر از :min باشد.',
                    ]),

                Select::make('veteran_status_id')
                    ->label('وضعیت ایثارگری')
                    ->options(self::veteranStatuses())
                    ->searchable()
                    ->getOptionLabelsUsing(
                        fn (string $value) : ?string => VeteranStatus::query()->find($value)?->name ?? 'Not Found'
                    )
                    ->required()
                    ->rules(['required', 'integer', 'exists:veteran_statuses,id'])
                    ->validationMessages([
                        'required' => 'وضعیت ایثارگری را انتخاب کنید.',
                        'integer'  => 'وضعیت ایثارگری انتخاب‌شده نامعتبر است.',
                        'exists'   => 'وضعیت ایثارگری انتخاب‌شده در سیستم وجود ندارد.',
                    ]),

                TextInput::make('landline_number')
                    ->label('تلفن ثابت')
                    ->numeric()
                    ->required()
                    // اجازه می‌دهیم بین 7 تا 15 رقم (با پیش‌شماره‌ها) وارد شود
                    ->rules(['required', 'digits_between:7,15', 'numeric'])
                    ->validationMessages([
                        'required'       => 'تلفن ثابت را وارد کنید.',
                        'numeric'        => 'تلفن ثابت باید فقط شامل ارقام باشد.',
                        'digits_between' => 'تلفن ثابت باید بین :min تا :max رقم باشد.',
                    ]),

                TextInput::make('mobile')
                    ->label('تلفن همراه')
                    ->numeric()
                    ->required()
                    // فرمت موبایل ایران: 09XXXXXXXXX (11 رقم) — regex چک می‌کند
                    ->rules(['required', 'regex:/^09\d{9}$/', 'digits:11'])
                    ->validationMessages([
                        'required' => 'شماره تلفن همراه را وارد کنید.',
                        'numeric'  => 'شماره تلفن همراه باید فقط شامل ارقام باشد.',
                        'digits'   => 'شماره تلفن همراه باید دقیقاً :digits رقم باشد.',
                        'regex'    => 'شماره تلفن همراه وارد شده معتبر نیست. مثال معتبر: 09123456789',
                    ]),

                Textarea::make('address')
                    ->label('آدرس')
                    ->string()
                    ->maxLength(1000)
                    ->validationMessages([
                        'string' => 'آدرس باید به صورت متن وارد شود.',
                        'max'    => 'آدرس نمی‌تواند بیش از :max کاراکتر باشد.',
                    ]),

                Textarea::make('description')
                    ->label('توضیحات تکمیلی')
                    ->string()
                    ->maxLength(2000)
                    ->validationMessages([
                        'string' => 'توضیحات تکمیلی باید به صورت متن وارد شود.',
                        'max'    => 'توضیحات تکمیلی نمی‌تواند بیش از :max کاراکتر باشد.',
                    ]),
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
