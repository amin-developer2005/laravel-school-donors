<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectUsageType>
 */
class ProjectUsageTypeFactory extends Factory
{
    public array $usageTypes {
        set => $this->usageTypes = $value;
        get {
            return $this->usageTypes ?? [
                "آموزشی",
                "کانون",
                "سالن ورزشی",
                "کارگاه",
                " سالن چند منظوره",
                "زمین چمن",
                "استخر",
                " نمازخانه",
                "کتابخانه",
                "اردوگاه",
                "خوابگاه",
                "اداری",
                "سایر",
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
