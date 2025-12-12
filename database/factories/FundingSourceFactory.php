<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FundingSource>
 */
class FundingSourceFactory extends Factory
{
    public array $sourceNames {
        set => $this->sourceNames = $value;
        get {
            return $this->sourceNames ?? [
                "مردمی", "مشارکتی", "استانی", "ملی", "سایر",
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
