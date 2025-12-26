<?php

namespace App\Filament\Resources\Projects\Tables;


use App\Filament\Resources\Projects\Schemas\ProjectForm;
use App\Models\FundingSource;
use App\Models\ProjectUsageType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\View\Components\ButtonComponent;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;


class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('عنوان پروژه'),

                TextColumn::make('status')->label('وضعیت پروژه'),
                TextColumn::make('space_code')->label('کد فضا'),
                TextColumn::make('urban_rural')->label('شهر / روستا'),
                TextColumn::make('city')
                    ->label('شهر'),
                TextColumn::make('village')
                    ->label('روستا'),
                TextColumn::make('district')->label('ناحیه / منطقه'),
                TextColumn::make('usage_type')->label('نوع كاربري'),
                TextColumn::make('start_year')->label('سال شروع'),
                TextColumn::make('end_year')->label('سال پایان'),
                TextColumn::make('funding_source')->label('منبع تامين اعتبار'),
                TextColumn::make('builderDonor.full_name')->label('باني بنا'),
                TextColumn::make('landDonor.full_name')->label('باني زمين'),

                TextColumn::make('cost')
                    ->label('هزینه صرف شده ( ریال)')
                    ->money("IRR")
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('main_building_area')->label('ساختمان اصلي'),
                TextColumn::make('bathroom_area')->label('سرويس بهداشتي'),
                TextColumn::make('janitor_area')->label('سرايداري'),
                TextColumn::make('guard_area')->label('نگهبانی'),
                TextColumn::make('wall_area')->label('ديواركشي'),
                TextColumn::make('landscaping_area')->label('محوطه سازي'),
                TextColumn::make('gym_area')->label('سالن ورزشي'),
                TextColumn::make('prayer_room_area')->label('نمازخانه'),
                TextColumn::make('total_under_construction')->label('كل زير بنا'),
                TextColumn::make('land_area')->label('مساحت زمين'),
                TextColumn::make('classrooms_count')->label('تعداد كلاس'),
                TextColumn::make('contractor')->label('پيمانكار'),
                TextColumn::make('supervisor')->label('ناظر'),

                TextColumn::make('address')->label('آدرس')->formatStateUsing(
                    fn($state) => null !== $state ? $state : null
                ),

                TextColumn::make('agreement_file')
                    ->label('فایل تفاهم‌نامه'),
            ])
            ->filters(
                [
                    SelectFilter::make('funding_source')->options(
                        fn(): array => FundingSource::query()->pluck('name', 'id')->all()
                    ),
                    SelectFilter::make('status')
                        ->label('وضعیت پروژه')
                        ->options([
                            'در دست اجرا' => 'در دست اجرا',
                            'کامل شده'    => 'کامل شده',
                            'کنسل شده' => 'کنسل شده',
                        ]),
                    SelectFilter::make('urban_rural')
                        ->label('نوع منطقه')
                        ->options([
                            ProjectForm::URBAN => ProjectForm::URBAN,
                            ProjectForm::RURAL => ProjectForm::RURAL,
                        ]),
                    SelectFilter::make('usage_type')
                        ->label('نوع كاربري')
                        ->options(
                            fn(): array => ProjectUsageType::query()->pluck('name', 'id')->all()
                        )
                ]
            )
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
