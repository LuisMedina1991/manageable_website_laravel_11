<?php

namespace Database\Seeders;

use App\Models\FirstSection;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirstSectionSeeder extends Seeder
{
    public function run(): void
    {
        FirstSection::create([
            'identifier' => 'first-section',
            'name' => __('First record'),
            'title' => __('First Section Title'),
            'is_selected' => 1,
            'text_color_id' => 3,
        ]);
    }
}
