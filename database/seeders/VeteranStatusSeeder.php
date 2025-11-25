<?php

namespace Database\Seeders;

use App\Models\VeteranStatus;
use Database\Factories\VeteranStatusFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VeteranStatusSeeder extends Seeder
{
    private VeteranStatusFactory $veteranStatusFactory {
        set => $this->veteranStatusFactory = $value;
        get => $this->veteranStatusFactory;
    }

    public function __construct(VeteranStatusFactory $veteranStatusFactory)
    {
        $this->veteranStatusFactory = $veteranStatusFactory;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect($this->veteranStatusFactory->names)->each(function (string $name) {
            VeteranStatus::factory()->create([
                'name' => $name,
            ]);
        });
    }
}
