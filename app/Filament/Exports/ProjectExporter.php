<?php

namespace App\Filament\Exports;

use App\Models\Project;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ProjectExporter extends Exporter
{
    protected static ?string $model = Project::class;

    public const string FILE_DISK = "public";

    public string $disk {
        get {
            return self::FILE_DISK;
        }
    }


    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('آی دی پروژه'),
            ExportColumn::make('title')->label('عنوان پروژه'),
            ExportColumn::make('status')->label('وضعیت پروژه'),
            ExportColumn::make('space_code')->label('کد فضا'),
            ExportColumn::make('urban_rural')->label('شهر / روستا'),
            ExportColumn::make('city')->label('شهر'),
            ExportColumn::make('village')->label('روستا'),
            ExportColumn::make('region.name')->label('ناحیه / منطقه'),
            ExportColumn::make('projectUsageType.name')->label('نوع كاربري'),
            ExportColumn::make('start_year')->label('سال شروع'),
            ExportColumn::make('end_year')->label('سال پایان'),
            ExportColumn::make('fundingSource.name')->label('منبع تامين اعتبار'),
            ExportColumn::make('builderDonor.name')->label('باني بنا'),
            ExportColumn::make('landDonor.name')->label('باني زمين'),
            ExportColumn::make('cost')->label('هزینه صرف شده ( ریال)'),
            ExportColumn::make('main_building_area')->label('ساختمان اصلي'),
            ExportColumn::make('bathroom_area')->label('سرويس بهداشتي'),
            ExportColumn::make('janitor_area')->label('سرايداري'),
            ExportColumn::make('guard_area')->label('نگهبانی'),
            ExportColumn::make('wall_area')->label('ديواركشي'),
            ExportColumn::make('land_spacing_area')->label('محوطه سازي'),
            ExportColumn::make('gym_area')->label('سالن ورزشي'),
            ExportColumn::make('prayer_room_area')->label('نمازخانه'),
            ExportColumn::make('total_under_constructions')->label('كل زير بنا'),
            ExportColumn::make('land_area')->label('مساحت زمين'),
            ExportColumn::make('classrooms_count')->label('تعداد كلاس'),
            ExportColumn::make('contractor')->label('پيمانكار'),
            ExportColumn::make('supervisor')->label('ناظر'),
            ExportColumn::make('address')->label('آدرس'),
            ExportColumn::make('created_at')->label('تاریخ ایجاد'),
            ExportColumn::make('updated_at')->label('تاریخ به روز رسانی'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'خروجی اکسل پروژه های شما با موفقیت انجام شد و  ' .
            Number::format($export->successful_rows) . ' ' . str('رکورد')->plural($export->successful_rows) . ' خروجی گرفته شد.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('رکورد')->plural($failedRowsCount) . ' خروجی با شکست مواجه شد.';
        }

        return $body;
    }



    public function getFormats(): array
    {
        return [
            ExportFormat::Xlsx,
        ];
    }

    public function getFileDisk(): string
    {
        return $this->disk;
    }

    public function getFileName(Export $export): string
    {
        return "پروژه های خیرین مدرسه ساز";
    }
}
