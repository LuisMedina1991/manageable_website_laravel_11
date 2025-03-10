<?php

namespace Database\Seeders;

use App\Models\CarouselImage;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarouselImageSeeder extends Seeder
{
    public function run(): void
    {
        CarouselImage::create([
            'name' => __('First record'),
            'image' => 'storage/carousel_images/carousel_image_1.jpg',
            'text' => __('First image text'),
            'is_selected' => 1,
            'position' => 1,
        ]);
    }
}
