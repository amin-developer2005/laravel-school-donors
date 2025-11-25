<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Degree>
 */
class DegreeFactory extends Factory
{
    public array $names {
        set => $this->names = $value;
        get {
            return $this->names ?? [
                "بی سواد",
                "تحصیلات حوزوی",
                "زیردیپلم",
                "دیپلم",
                "فوق دیپلم",
                "لیسانس",
                "فوق لیسانس",
                "دکتری",
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
