<?php

namespace App\Filament\Resources\Donors\Tables;


use App\Filament\Exports\SchoolDonorExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;


class DonorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("type")->label('نوع متعهد '),
                TextColumn::make("national_code")->label('کد ملی '),
                TextColumn::make("full_name")->label('نام و نام خانوادگی خیر'),
                TextColumn::make("life_status")->label('وضعیت حیات'),
                TextColumn::make("father_name")->label('نام پدر'),
                TextColumn::make("birth_certificate_number")->label('شماره شناسنامه'),
                TextColumn::make("birth_date")->label('تاریخ تولد'),
                TextColumn::make("birth_location")->label('محل تولد'),
                TextColumn::make("degree.name")->label('مدرک تحصیلی'),
                TextColumn::make("major")->label('رشته تحصیلی'),
                TextColumn::make("marital_status")->label('وضعیت تاهل'),
                TextColumn::make("child_count")->label('تعداد فرزند'),
                TextColumn::make("veteranStatus.name")->label('وضعیت ایثارگری'),
                TextColumn::make("landline_number")->label('تلفن ثابت'),
                TextColumn::make("mobile")->label('تلفن همراه'),
                TextColumn::make("address")->label('آدرس'),
            ])
            ->filters([

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

            ])
            ->searchable(['full_name', 'type'])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(SchoolDonorExporter::class)->label("خروجی اکسل")
            ])
            ;
    }
}
