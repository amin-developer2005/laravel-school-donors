<?php

namespace Database\Seeders;

use App\Models\Degree;
use Database\Factories\DegreeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    private DegreeFactory $degreeFactory {
        set => $this->degreeFactory = $value;
        get => $this->degreeFactory;
    }

    public function __construct(DegreeFactory $degreeFactory)
    {
        $this->degreeFactory = $degreeFactory;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect($this->degreeFactory->names)->each(function (string $name) {
            Degree::factory()->create([
                'name' => $name,
            ]);
        });
    }
}
