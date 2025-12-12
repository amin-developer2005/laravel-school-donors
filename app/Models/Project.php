<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'title', 'status', 'space_code', 'urban_rural', 'city', 'village', 'district', 'usage_type',
        'start_year', 'end_year', 'funding_source', 'builder_donor_id', 'land_donor_id', 'cost',
        'main_building_area', 'bathroom_area', 'janitor_area', 'guard_area', 'wall_area',
        'landscaping_area', 'gym_area', 'prayer_room_area', 'total_under_construction',
        'land_area', 'classrooms_count', 'contractor', 'supervisor', 'address', 'agreement_file'
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function usageType(): BelongsTo
    {
        return $this->belongsTo(ProjectUsageType::class);
    }

    public function builderDonor(): BelongsTo
    {
        return $this->belongsTo(Donor::class, 'builder_donor_id');
    }

    public function landDonor(): BelongsTo
    {
        return $this->belongsTo(Donor::class, 'land_donor_id');
    }
}
