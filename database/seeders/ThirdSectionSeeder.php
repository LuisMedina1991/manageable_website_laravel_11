<?php

namespace Database\Seeders;

use App\Models\ThirdSection;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThirdSectionSeeder extends Seeder
{
    public function run(): void
    {
        ThirdSection::create([
            'identifier' => 'third-section',
            'name' => __('First record'),
            'is_selected' => 1,
            'background_color_id' => 3,
        ]);
    }
}
