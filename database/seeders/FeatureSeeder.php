<?php

namespace Database\Seeders;

use App\Enums\FeatureType;
use App\Models\AppFeature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(FeatureType::cases())->each(function (FeatureType $featureType) {
            AppFeature::create([
                'name' => $featureType->value,
                'type' => $featureType->name,
                'description' => $featureType->description(),
            ]);
        });
    }
}
