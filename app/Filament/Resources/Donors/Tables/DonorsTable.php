<?php

namespace App\Filament\Resources\Donors\Tables;

use App\Filament\Exports\DonorExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Models\Export;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Symfony\Component\HttpFoundation\StreamedJsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
                TextColumn::make("degree_id")->label('مدرک تحصیلی'),
                TextColumn::make("major")->label('رشته تحصیلی'),
                TextColumn::make("marital_status")->label('وضعیت تاهل'),
                TextColumn::make("child_count")->label('تعداد فرزند'),
                TextColumn::make("veteran_status_id")->label('وضعیت ایثارگری'),
                TextColumn::make("landline_number")->label('تلفن ثابت'),
                TextColumn::make("mobile")->label('تلفن همراه'),
                TextColumn::make("address")->label('آدرس'),
            ])
            ->filters([
                //
            ])
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
                    ->exporter(DonorExporter::class)->label("خروجی اکسل")
                    ->after(function (StreamedResponse $response) {
                        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                        $response->headers->set('Content-Disposition', "attachment; filename=مشخصات-خیرین.xlsx");
                    }),
            ])
            ;
    }
}
