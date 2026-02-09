<?php

namespace App\Filament\Resources\Donors\Tables;


use App\Exports\SchoolDonorsExport;
use App\Models\Degree;
use App\Models\Donor;
use App\Models\Project;
use App\Models\VeteranStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;
use Maatwebsite\Excel\Facades\Excel;


class DonorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("type")
                    ->label('نوع متعهد')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make("national_code")
                    ->label('کد ملی')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make("full_name")
                    ->label('نام و نام خانوادگی خیر')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("life_status")
                    ->label('وضعیت حیات')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("father_name")
                    ->label('نام پدر')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("birth_certificate_number")
                    ->label('شماره شناسنامه')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->label('تاریخ تولد')
                    ->jalaliDate()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make("birth_location")
                    ->label('محل تولد')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("degree.name")
                    ->label('مدرک تحصیلی')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("major")
                    ->label('رشته تحصیلی')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("marital_status")
                    ->label('وضعیت تاهل')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("child_count")
                    ->label('تعداد فرزند')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("veteranStatus.name")
                    ->label('وضعیت ایثارگری')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("landline_number")
                    ->label('تلفن ثابت')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("mobile")
                    ->label('تلفن همراه')
                    ->getStateUsing(fn(Donor $donor) => 0 . $donor->mobile)
                    ->toggleable()
                    ->searchable(),
                TextColumn::make("address")
                    ->label('آدرس')
                    ->toggleable()
                    ->searchable(),
            ])
            ->filters([
                Filter::make('type')
                    ->schema([ Select::make('type')->label('نوع متعهد')->options([
                        'حقیقی' => 'حقیقی',
                        'حقوقی' => 'حقوقی',
                    ])->placeholder('همه') ])
                    ->query(fn (Builder $query, array $data) => $query->when($data['type'] ?? null, fn($q,$v) => $q->where('type', $v))),

                Filter::make('full_name')
                    ->schema([ TextInput::make('full_name')->label('نام و نام خانوادگی') ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['full_name'] ?? null, fn($q, $v) => $q->where('full_name', 'like', "%{$v}%"));
                    }),

                Filter::make('national_code')
                    ->schema([ TextInput::make('national_code')->label('کد ملی')->placeholder('مثال: 0012345678') ])
                    ->query(fn (Builder $query, array $data) => $query->when($data['national_code'] ?? null, fn($q,$v) => $q->where('national_code', 'like', "%{$v}%"))),

                Filter::make('birth_certificate_number')
                    ->schema([ TextInput::make('birth_certificate_number')->label('شماره شناسنامه') ])
                    ->query(fn (Builder $query, array $data) => $query->when($data['birth_certificate_number'] ?? null, fn($q,$v) => $q->where('birth_certificate_number', 'like', "%{$v}%"))),

                Filter::make('birth_date')
                    ->schema([
                        DatePicker::make('birth_date_from')->label('تاریخ تولد از')->jalali(),
                        DatePicker::make('birth_date_to')->label('تاریخ تولد تا')->jalali()
                    ])
                    ->query(function (Builder $query, array $data) {
                        $query->when($data['birth_date_from'] ?? null, fn($q, $val) => $q->whereDate('birth_date', '>=', $val));
                        $query->when($data['birth_date_to'] ?? null, fn($q, $val) => $q->whereDate('birth_date', '<=', $val));
                    }),

                Filter::make('father_name')
                    ->schema([ TextInput::make('father_name')->label('نام پدر') ])
                    ->query(fn (Builder $query, array $data) => $query->when($data['father_name'] ?? null, fn($q,$v) => $q->where('father_name', 'like', "%{$v}%"))),

                Filter::make('mobile')
                    ->schema([ TextInput::make('mobile')->label('تلفن همراه') ])
                    ->query(fn (Builder $query, array $data) => $query->when($data['mobile'] ?? null, fn($q,$v) => $q->where('mobile', 'like', "%{$v}%"))),

                Filter::make('landline_number')
                    ->schema([ TextInput::make('landline_number')->label('تلفن ثابت') ])
                    ->query(fn (Builder $query, array $data) => $query->when($data['landline_number'] ?? null, fn($q,$v) => $q->where('landline_number', 'like', "%{$v}%"))),

                Filter::make('major')
                    ->schema([ TextInput::make('major')->label('رشته تحصیلی') ])
                    ->query(fn (Builder $query, array $data) => $query->when($data['major'] ?? null, fn($q,$v) => $q->where('major', 'like', "%{$v}%"))),

                Filter::make('birth_location')
                    ->schema([ TextInput::make('birth_location')->label('محل تولد') ])
                    ->query(fn (Builder $query, array $data) => $query->when($data['birth_location'] ?? null, fn($q,$v) => $q->where('birth_location', 'like', "%{$v}%"))),

                Filter::make('child_count')
                    ->schema([
                        TextInput::make('child_count_min')->label('تعداد فرزند (از)')->type('number'),
                        TextInput::make('child_count_max')->label('تعداد فرزند (تا)')->type('number'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        $query = $query->when(isset($data['child_count_min']) && $data['child_count_min'] !== null, fn($q,$v) => $q->where('child_count', '>=', $v));
                        return $query->when(isset($data['child_count_max']) && $data['child_count_max'] !== null, fn($q,$v) => $q->where('child_count', '<=', $v));
                    }),

                SelectFilter::make('veteran_status_id')->label('وضعیت ایثارگری')->options(
                    VeteranStatus::query()->pluck('name', 'id')->all())
                    ->placeholder('همه')
                    ->searchable(),

                SelectFilter::make('marital_status')->label('وضعیت تاهل')->options([
                    'مجرد' => 'مجرد',
                    'متاهل' => 'متاهل',
                ]),

                SelectFilter::make('life_status')->label('وضعیت حیات')->options([
                    'در قید حیات'   => 'در قید حیات',
                    'فوت شده'       => 'فوت شده',
                ]),

                SelectFilter::make('degree_id')->label('مدرک تحصیلی')->options(
                    fn() => Degree::query()->pluck('name', 'id')->all()
                )->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                BulkAction::make('حذف انتخابی')
                    ->action(
                        fn(object $records) => $records->each->delete()
                    )
            ])
            ->headerActions([
                Action::make('export_excel')
                    ->label("خروجی اکسل")
                    ->action(
                        fn() => Excel::download(new SchoolDonorsExport(), SchoolDonorsExport::filename())
                    )
            ])
            ;
    }

    private function filters(Table $table): Table
    {
        return $table->filters([
            Filter::make('type')->query(
                fn (Builder $query) => $query->where('type', "حقیقی")->latest()->get(),
            )->label("نوع متعد: حقیقی"),

            Filter::make('life_status')->query(
                fn (Builder $query) => $query->where('life_status', 'فوت شده')->latest()->get())
                ->label('وضعیت حیات')
            ,
            Filter::make('address')->query(
                fn(Builder $query) => $query->whereNotNull('address')->latest()->get()
            )->label('آدرس'),

            Filter::make()->query(
                fn(Builder $query) => $query->where('type', 'حقوقی')->latest()->get(),
            )->label("نوع متعد: حقوقی"),

            Filter::make('marital_status')->query(
                fn(Builder $query) => $query->where('marital_status',"متاهل")->latest()->get(),
            )->label("وضعیت تاهل: متاهل"),
        ]);
    }
}
