<?php

namespace Database\Seeders;

use App\Models\SecondSection;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecondSectionSeeder extends Seeder
{
    public function run(): void
    {
        SecondSection::create([
            'identifier' => 'second-section',
            'name' => __('First record'),
            'is_selected' => 1,
            'background_color_id' => 13,
            'text_color_id' => 3,
        ]);
    }
}
