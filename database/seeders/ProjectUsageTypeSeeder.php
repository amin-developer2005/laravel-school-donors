<?php

namespace Database\Seeders;

use App\Models\ProjectUsageType;
use Database\Factories\ProjectUsageTypeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectUsageTypeSeeder extends Seeder
{
    public ProjectUsageTypeFactory $factory {
        set => $this->factory = $value;
        get => $this->factory;
    }

    public function __construct(ProjectUsageTypeFactory $factory)
    {
        $this->factory = $factory;
    }


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->injectFactoryData();
    }


    private function injectFactoryData(): void
    {
        collect($this->factory->usageTypes)->each(
            fn(string $usageType) => ProjectUsageType::factory()->create([
                'name' => $usageType
            ])
        );
    }
}
