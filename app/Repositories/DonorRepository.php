<?php

namespace App\Repositories;

use App\Models\Donor;

class DonorRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public static function pluckDonors(?string $column = null, ?string $key = null) : array
    {
        $column ??= "name";
        $key ??= 'id';

        return Donor::query()->pluck($column, $key)->all();
    }
}
