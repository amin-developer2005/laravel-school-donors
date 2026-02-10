<?php

namespace App\Filament\Pages\Admin\Projects;

use App\Models\Project;
use Filament\Pages\Page;

class Map extends Page
{
    protected string $view = 'filament.pages.admin.projects.map';
    protected static ?string $title = "نقشهٔ پروژه‌های مدرسه‌سازی — استان قم";
    protected static ?string $navigationLabel = 'نقشه پروژه‌های مدرسه سازی';
    protected static ?int $navigationSort = 50;
    protected static string|null|\UnitEnum $navigationGroup = 'نقشه‌ها';

    public mixed $projects {
        set => $this->projects = $value;
        get => $this->projects;
    }

    public function mount(): void
    {
        $this->projects = Project::with('region')
            ->select(['id', 'title', 'address', 'latitude', 'longitude', 'start_year'])
            ->whereNotNull(['latitude', 'longitude'])
            ->get();
    }
}
