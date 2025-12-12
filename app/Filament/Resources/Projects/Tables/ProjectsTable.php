<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
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
                TextColumn::make('city')->label('شهر'),
                TextColumn::make('village')->label('روستا'),
                TextColumn::make('district')->label('ناحیه / منطقه'),
                TextColumn::make('usage_type')->label('نوع كاربري'),
                TextColumn::make('start_year')->label('سال شروع'),
                TextColumn::make('end_year')->label('سال پایان'),
                TextColumn::make('funding_source')->label('منبع تامين اعتبار'),
                TextColumn::make('builderDonor.name')->label('باني بنا'),
                TextColumn::make('landDonor.name')->label('باني زمين'),
                TextColumn::make('cost')->label('هزینه شده ( ریال)'),
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

            ])
            ->filters([
                Filter::make('status')
                    ->query(
                        fn(\Illuminate\Database\Query\Builder $query) => $query
                            ->where('status', 'کامل شده')
                            ->latest()
                            ->get()
                    ),
            ])
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
