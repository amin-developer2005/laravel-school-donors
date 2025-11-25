<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VeteranStatus>
 */
class VeteranStatusFactory extends Factory
{
    public array $names {
        set => $this->names = $value;
        get {
            return $this->names ?? [
                "ایثارگر نمی باشد",
                "آزاده",
                "جانباز",
                "رزمنده",
                "برادر شهید",
                "خواهر شهید",
                "پدر شهید",
                "مادر شهید",
                "خانواده شهدا",
                "همسر شهید",
                " سایر"
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
