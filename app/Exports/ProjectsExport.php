<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ProjectsExport implements FromCollection, WithHeadings
{
    public const string FORMAT = 'xlsx';


    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Project::all();
    }

    public static function filename(): string
    {
        return 'پروژه های مدرسه سازی .' . self::FORMAT;
    }

    public function headings(): array
    {
        return [
            'آی دی پروژه',
            'عنوان پروژه',
            'وضعیت پروژه',
            'کد فضا',
            'شهر / روستا',
            'شهر',
            'روستا',
            'ناحیه / منطقه',
            'نوع كاربري',
            'سال شروع',
            'سال پایان',
            'منبع تامين اعتبار',
            'باني بنا',
            'باني زمين',
            'هزینه صرف شده ( ریال)',
            'ساختمان اصلي',
            'سرويس بهداشتي',
            'سرايداري',
            'نگهبانی',
            'ديواركشي',
            'محوطه سازي',
            'سالن ورزشي',
            'نمازخانه',
            'كل زير بنا',
            'مساحت زمين',
            'تعداد كلاس',
            'پيمانكار',
            'ناظر',
            'آدرس',
            'فایل تفاهم‌نامه',
            'تاریخ ثبت',
            'تاریخ به روز رسانی',
        ];
    }
}
