<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donor extends Model
{
    /** @use HasFactory<\Database\Factories\DonorFactory> */
    use HasFactory;

    protected $fillable = [
        "type",
        "national_code",
        "full_name",
        "life_status",
        "father_name",
        "birth_certificate_number",
        "birth_date",
        "birth_location",
        "degree_id",
        "major",
        "marital_status",
        "child_count",
        "veteran_status_id",
        "landline_number",
        "mobile",
        "address",
        "description",
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }

    public function veteranStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VeteranStatus::class);
    }
}
