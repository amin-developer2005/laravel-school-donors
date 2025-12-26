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
        $column ??= "full_name";
        $key ??= 'id';

        return Donor::query()->pluck($column, $key)->all();
    }

    public static function searchDonors(string $search, ?string $field = null) : array
    {
        $query = Donor::query()
            ->where('full_name', 'like', "%{$search}%")
            ->pluck('full_name', 'id');

        return $field ? $query->get($field) : $query->all();
    }
}
