<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    public array $regions {
        set => $this->regions = $value;
        get {
            return $this->regions ?? [
                "ناحیه 1",
                "ناحیه 2",
                "ناحیه 3",
                "ناحیه 4",
                "کهک",
                "جعفریه",
                "خلجستان",
            ];
        }
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
