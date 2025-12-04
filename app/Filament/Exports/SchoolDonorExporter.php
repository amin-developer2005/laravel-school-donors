<?php

namespace App\Filament\Exports;

use App\Models\Donor;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

class SchoolDonorExporter extends Exporter
{
    protected static ?string $model = Donor::class;
    private string $disk {
        set => $this->disk = $value;
        get {
            return $this->disk ?? "public";
        }
    }
    private string $extension {
        set => $this->extension = $value;
        get {
            return $this->extension ?? ".xlsx";
        }
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('شماره خیر'),
            ExportColumn::make('type')->label('نوع متعهد (خیر)'),
            ExportColumn::make('national_code')->label('کد ملی ( کد خیر)'),
            ExportColumn::make('full_name')->label('نام و نام خانوادگی خیر'),
            ExportColumn::make('life_status')->label('وضعیت حیات'),
            ExportColumn::make('father_name')->label('نام پدر'),
            ExportColumn::make('birth_certificate_number')->label('شماره شناسنامه'),
            ExportColumn::make('birth_date')->label('تاریخ تولد'),
            ExportColumn::make('birth_location')->label('محل تولد'),
            ExportColumn::make('degree.name')->label('مدرک تحصیلی'),
            ExportColumn::make('major')->label('رشته تحصیلی'),
            ExportColumn::make('marital_status')->label('وضعیت تاهل'),
            ExportColumn::make('child_count')->label('تعداد فرزند'),
            ExportColumn::make('veteranStatus.name')->label('وضعیت ایثارگری'),
            ExportColumn::make('landline_number')->label('تلفن ثابت'),
            ExportColumn::make('mobile')->label('تلفن همراه'),
            ExportColumn::make('address')->label('آدرس'),
            ExportColumn::make('description')->label('توضیحات'),
            ExportColumn::make("created_at")->label('تاریخ ایجاد'),
            ExportColumn::make("updated_at")->label('تاریخ بروزرسانی')
        ];
    }


    public static function getCompletedNotificationBody(Export $export): string
    {
        $successfulRow = $export->successful_rows;
        $body = "خروجی اکسل شما با موفقیت انجام شد و " . Number::format($successfulRow) . ' ' . str('row')
            ->plural($successfulRow) . " خروجی گرفته شد.";

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' '. str('row')->plural($failedRowsCount)
                . ' خروجی اکسل با خطا مواجه شد.';
        }

        return $body;
    }

    public static function getCompletedNotificationTitle(Export $export): string
    {
        $successfulRows = $export->successful_rows;
        $title = "خروجی اکسل با تعداد " . Number::format($successfulRows) . " با موفقیت انجام شد.";

        if ($export->getFailedRowsCount()) {
            $title .= " خروجی اکسل با خطا مواجه شد.";
        }

        return $title;
    }


    public function getFileName(Export $export): string
    {
        return "مشخصات-خیرین";
    }

    public function getFormats(): array
    {
        return [
            ExportFormat::Xlsx
        ];
    }

    public function getFileDisk(): string
    {
        return $this->disk;
    }
}
