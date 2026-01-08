<?php

namespace App\Exports;

use App\Models\Donor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SchoolDonorsExport implements FromCollection, WithHeadings
{
    public const string FORMAT = 'xlsx';



    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Donor::all();
    }


    public static function filename(): string
    {
        return 'خیرین مدرسه ساز.' . self::FORMAT;
    }



    public function headings(): array
    {
        return [
            'شماره خیر',
            'نوع متعهد (خیر)',
            'کد ملی ( کد خیر)',
            'نام و نام خانوادگی خیر',
            'وضعیت حیات',
            'نام پدر',
            'شماره شناسنامه',
            'تاریخ تولد',
            'محل تولد',
            'مدرک تحصیلی',
            'رشته تحصیلی',
            'وضعیت تاهل',
            'تعداد فرزند',
            'وضعیت ایثارگری',
            'تلفن ثابت',
            'تلفن همراه',
            'آدرس',
            'توضیحات',
            'تاریخ ایجاد',
            'تاریخ بروزرسانی',
        ];
    }
}
