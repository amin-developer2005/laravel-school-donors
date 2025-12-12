<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUsageType extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectUsageTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;


    public function projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Project::class);
    }
}
