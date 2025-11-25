<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeteranStatus extends Model
{
    /** @use HasFactory<\Database\Factories\VeteranStatusFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;


    public function donors(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Donor::class);
    }
}
