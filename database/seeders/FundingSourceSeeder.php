<?php

namespace Database\Seeders;

use App\Models\FundingSource;
use Database\Factories\FundingSourceFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FundingSourceSeeder extends Seeder
{
    public FundingSourceFactory $factory {
        set => $this->factory = $value;
        get => $this->factory;
    }

    public function __construct(FundingSourceFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect($this->factory->sourceNames)->each(
            fn(string $sourceName) => FundingSource::factory()->create([
                'name' => $sourceName
            ])
        );
    }
}
