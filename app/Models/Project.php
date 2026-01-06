<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use App\Filament\Resources\Projects\Schemas\ProjectForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'title', 'status', 'space_code', 'urban_rural', 'city', 'village', 'region_id', 'project_usage_type_id',
        'start_year', 'end_year', 'funding_source_id', 'builder_donor_id', 'land_donor_id', 'cost',
        'main_building_area', 'bathroom_area', 'janitor_area', 'guard_area', 'wall_area',
        'land_spacing_area', 'gym_area', 'prayer_room_area', 'total_under_constructions',
        'classrooms_count', 'contractor', 'supervisor', 'address', 'agreement_file'
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function projectUsageType(): BelongsTo
    {
        return $this->belongsTo(ProjectUsageType::class);
    }

    public function fundingSource(): BelongsTo
    {
        return $this->belongsTo(FundingSource::class);
    }

    public function builderDonor(): BelongsTo
    {
        return $this->belongsTo(Donor::class, 'builder_donor_id');
    }

    public function landDonor(): BelongsTo
    {
        return $this->belongsTo(Donor::class, 'land_donor_id');
    }


    public function isPending(): bool
    {
        return $this->status == ProjectStatus::PENDING;
    }

    public function isCompleted(): bool
    {
        return $this->status == ProjectStatus::COMPLETED;
    }

    public function isCanceled(): bool
    {
        return $this->status == ProjectStatus::CANCELED;
    }


    public function isUrban(): bool
    {
        return $this->urban_rural == ProjectForm::URBAN;
    }

    public function isRural(): bool
    {
        return $this->urban_rural == ProjectForm::RURAL;
    }


    public function hasCost(): bool
    {
        return $this->cost !== null;
    }


    protected function casts(): array
    {
        return [

        ];
    }
}
