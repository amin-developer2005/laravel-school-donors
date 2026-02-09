<?php

namespace App\Filament\Resources\Projects\Tables;


use App\Exports\ProjectsExport;
use App\Filament\Exports\ProjectExporter;
use App\Filament\Resources\Projects\Schemas\ProjectForm;
use App\Models\Donor;
use App\Models\FundingSource;
use App\Models\Project;
use App\Models\ProjectUsageType;
use App\Models\Region;
use App\Models\User;
use App\Repositories\DonorRepository;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Actions\ViewAction;
use Filament\Infolists\View\Components\IconEntryComponent\IconComponent;
use Filament\Schemas\Components\Icon;
use Filament\Support\Colors\Color;
use Filament\Support\View\Components\ButtonComponent;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class ProjectsTable
{
    public const string NOT_SUBMITTED = 'ثبت نشده';

    public static function configure(Table $table): Table
    {
        return $table
            ->query(fn() => Project::with(['projectUsageType', 'fundingSource', 'builderDonor', 'landDonor', 'region']))
            ->columns([
                TextColumn::make('title')
                    ->label('عنوان پروژه')
                    ->wrap(),

                TextColumn::make('status')
                    ->label('وضعیت پروژه')
                    ->badge()
                    ->color(function (Project $project) {
                            if ($project->isPending()) {
                                return Color::Emerald;
                            } elseif ($project->isCompleted()) {
                                return Color::Blue;
                            } else {
                                return Color::Red;
                            }
                        }
                    )
                    ->searchable()
                    ->sortable(),

                TextColumn::make('space_code')->label('کد فضا')->searchable(),
                TextColumn::make('urban_rural')->label('شهر / روستا')->searchable(),
                TextColumn::make('city')
                    ->label('شهر')
                    ->getStateUsing(
                            fn(Project $project) => $project->isUrban() ? ($project->city ?? '-') : '-'
                    )
                    ->searchable(),

                TextColumn::make('village')
                    ->label('روستا')
                    ->getStateUsing(
                             fn(Project $project) => $project->isRural() ? ($project->village ?? '-') : '-'
                    )
                    ->searchable(),

                TextColumn::make('region.name')
                    ->label('ناحیه / منطقه')
                    ->searchable(),

                TextColumn::make('projectUsageType.name')
                    ->label('نوع كاربري')
                    ->searchable(),
                TextColumn::make('start_year')->label('سال شروع')->sortable(),
                TextColumn::make('end_year')->label('سال پایان')->sortable(),
                TextColumn::make('fundingSource.name')->label('منبع تامين اعتبار')
                    ->searchable(),
                TextColumn::make('builderDonor.full_name')->label('باني بنا')
                    ->searchable(),
                TextColumn::make('landDonor.full_name')->label('باني زمين')
                    ->searchable(),

                TextColumn::make('cost')
                    ->label('هزینه صرف شده ( ریال)')
                    ->money("IRR")
                    ->formatStateUsing(
                        fn($state, Project $project) => $project->hasCost() ? number_format($state) . 'تومان' : $state
                    )
                    ->getStateUsing(
                        fn(Project $project) => $project->hasCost() ? $project->cost : '-'
                    ),

                TextColumn::make('main_building_area')
                    ->label('ساختمان اصلی')
                        ->getStateUsing(
                            fn(Project $project) => $project->main_building_area ? number_format($project->main_building_area) . ' متر' : '-'
                    )
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('bathroom_area')
                    ->label('سرویس بهداشتی')
                    ->getStateUsing(fn(Project $project) => $project->bathroom_area !== null ? number_format($project->bathroom_area) . ' متر' : '-')
                    ->toggleable(),

                TextColumn::make('janitor_area')
                    ->label('سرایداری')
                    ->getStateUsing(fn(Project $project) => $project->janitor_area !== null ? number_format($project->janitor_area) . ' متر' : '-')
                    ->toggleable(),

                TextColumn::make('guard_area')
                    ->label('نگهبانی')
                    ->getStateUsing(fn(Project $project) => $project->guard_area !== null ? number_format($project->guard_area) . ' متر' : '-')
                    ->toggleable(),

                TextColumn::make('wall_area')
                    ->label('دیوارکشی')
                    ->getStateUsing(
                        fn(Project $project) => $project->wall_area !== null ? number_format($project->wall_area) . ' متر' : '-'
                    )
                    ->toggleable(),

                TextColumn::make('landscaping_area')
                    ->label('محوطه‌سازی')
                    ->getStateUsing(
                        fn(Project $project) => $project->landscaping_area !== null ? number_format($project->landscaping_area) . ' متر' : '-'
                    )
                    ->toggleable(),

                TextColumn::make('gym_area')
                    ->label('سالن ورزشی')
                    ->getStateUsing(
                        fn(Project $project) => $project->gym_area !== null ? number_format($project->gym_area) . ' متر' : '-'
                    )
                    ->toggleable(),

                TextColumn::make('prayer_room_area')
                    ->label('نمازخانه')
                    ->getStateUsing(
                        fn(Project $project) => $project->prayer_room_area !== null ? number_format($project->prayer_room_area) . ' متر' : '-'
                    )
                    ->toggleable(),

                TextColumn::make('total_under_construction')
                    ->label('کل زیربنا')
                    ->getStateUsing(
                        fn(Project $project) => $project->total_under_construction !== null ? number_format($project->total_under_construction) . ' متر' : '-'
                    )
                    ->toggleable(),

                TextColumn::make('land_area')
                    ->label('مساحت زمین')
                    ->getStateUsing(fn(Project $project) => $project->land_area !== null ? number_format($project->land_area) . ' متر' : '-')
                    ->toggleable(),

                TextColumn::make('classrooms_count')
                    ->label('تعداد کلاس')
                    ->getStateUsing(fn(Project $project) => $project->classrooms_count !== null ? number_format($project->classrooms_count) : '-')
                    ->toggleable(),

                TextColumn::make('contractor')
                    ->label('پیمانکار')
                    ->getStateUsing(fn(Project $project) => $project->contractor ?: self::NOT_SUBMITTED)
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('supervisor')
                    ->label('ناظر')
                    ->getStateUsing(fn(Project $project) => $project->supervisor ?: self::NOT_SUBMITTED)
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('address')->label('آدرس')
                    ->getStateUsing(fn(Project $project) => $project->address ?: self::NOT_SUBMITTED)
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('agreement_file')
                    ->label('فایل تفاهم‌نامه')
                    ->getStateUsing(
                        function (Project $project) {
                            if (! $project->agreement_file) {
                                return 'ثبت نشده';
                            }

                            try {
                                $url = Storage::temporaryUrl($project->agreement_file, now()->addMinutes(15));
                            } catch (Exception $exception) {
                                return "خطا در دانلود فایل";
                            }

                            return "<a href=\"{$url}\" target=\"_blank\" rel=\"noopener noreferrer\">دانلود</a>";
                        }
                    )
                    ->html()
                    ->color(fn(Project $project) => ! $project->agreement_file ?: Color::Emerald)
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('تاریخ ثبت')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('تاریخ به روز رسانی')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('latitude')
                    ->label('عرض جغرافیایی')
                    ->getStateUsing(fn(Project $project) => $project->latitude !== null ? number_format($project->latitude) : '-')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('longitude')
                    ->label('عرض جغرافیایی')
                    ->getStateUsing(fn(Project $project) => $project->longitude !== null ? number_format($project->longitude) : '-')
                    ->sortable()
                    ->toggleable(),
            ])
            ->searchable()
            ->filters(
                [   SelectFilter::make('status')
                    ->label('وضعیت پروژه')
                    ->options([
                        'در دست اجرا' => 'در دست اجرا',
                        'کامل شده'    => 'کامل شده',
                        'کنسل شده'    => 'کنسل شده',
                    ]),
                    SelectFilter::make('funding_source_id')
                        ->label('منبع تامین اعتبار')
                        ->options(
                            fn(): array => FundingSource::query()->pluck('name', 'id')->all()
                        ),
                    SelectFilter::make('builder_donor_id')
                        ->label('باني بنا')
                        ->options(
                            fn() => DonorRepository::pluckDonors()
                        ),
                    SelectFilter::make('land_donor_id')
                        ->label('باني زمين')
                        ->options(
                            fn() => DonorRepository::pluckDonors()
                        ),
                    SelectFilter::make('urban_rural')
                        ->label('نوع منطقه')
                        ->options([
                            ProjectForm::URBAN => ProjectForm::URBAN,
                            ProjectForm::RURAL => ProjectForm::RURAL,
                        ]),
                    SelectFilter::make('project_usage_type_id')
                        ->label('نوع كاربري')
                        ->options(
                            fn(): array => ProjectUsageType::query()->pluck('name', 'id')->all()
                        ),
                    SelectFilter::make('region_id')
                        ->label('ناحیه / منطقه')
                        ->options(
                            fn() => Region::query()->pluck('name', 'id')->all()
                        ),

                ]
            )
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ViewAction::make()
                    ->label('مشاهده')
                    ->icon('heroicon-o-eye'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->label('حذف انتخابی')
                        ->action(
                            fn(array $records) => Project::query()->whereIn('id', $records['id'])->delete()
                        )
                        ->requiresConfirmation()
                        ->color(Color::Red),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Action::make('download_excel')
                    ->label('خروجی اکسل')
                    ->action(function () {
                        return Excel::download(new ProjectsExport(), ProjectsExport::filename());
                    })
            ]);
    }
}
