<?php

namespace Database\Seeders;

use App\Models\Region;
use Database\Factories\RegionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public RegionFactory $factory {
        set => $this->factory = $value;
        get => $this->factory;
    }

    public function __construct(RegionFactory $factory)
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
        collect($this->factory->regions)->each(
            fn(string $region) => Region::factory()->create([
                'name' => $region
            ])
        );
    }
}
