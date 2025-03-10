<?php

namespace Database\Seeders;

use App\Models\SecondSectionBlock;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecondSectionBlockSeeder extends Seeder
{
    public function run(): void
    {
        SecondSectionBlock::create([
            'image' => 'storage/second_section_blocks_images/second_section_block_image_1.jpg',
            'text' => __('In this space you must put text of up to 100 characters to accompany the image.'),
            'second_section_id' => 1,
        ]);

        SecondSectionBlock::create([
            'image' => 'storage/second_section_blocks_images/second_section_block_image_2.jpg',
            'text' => __('In this space you must put text of up to 100 characters to accompany the image.'),
            'second_section_id' => 1,
        ]);

        SecondSectionBlock::create([
            'image' => 'storage/second_section_blocks_images/second_section_block_image_3.jpg',
            'text' => __('In this space you must put text of up to 100 characters to accompany the image.'),
            'second_section_id' => 1,
        ]);

        SecondSectionBlock::create([
            'image' => 'storage/second_section_blocks_images/second_section_block_image_4.jpg',
            'text' => __('In this space you must put text of up to 100 characters to accompany the image.'),
            'second_section_id' => 1,
        ]);
    }
}
