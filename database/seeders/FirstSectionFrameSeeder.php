<?php

namespace Database\Seeders;

use App\Models\FirstSectionFrame;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirstSectionFrameSeeder extends Seeder
{
    public function run(): void
    {
        FirstSectionFrame::create([
            'subtitle' => __('First Section Subtitle'),
            'text' => __('In this space you must put information related to any topic you would like to share in text format of up to 255 characters.'),
            'first_section_id' => 1,
        ]);

        FirstSectionFrame::create([
            'subtitle' => __('First Section Subtitle'),
            'text' => __('In this space you must put information related to any topic you would like to share in text format of up to 255 characters.'),
            'first_section_id' => 1,
        ]);

        FirstSectionFrame::create([
            'subtitle' => __('First Section Subtitle'),
            'text' => __('In this space you must put information related to any topic you would like to share in text format of up to 255 characters.'),
            'first_section_id' => 1,
        ]);

        FirstSectionFrame::create([
            'subtitle' => __('First Section Subtitle'),
            'text' => __('In this space you must put information related to any topic you would like to share in text format of up to 255 characters.'),
            'first_section_id' => 1,
        ]);
    }
}
