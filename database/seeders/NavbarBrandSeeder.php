<?php

namespace Database\Seeders;

use App\Models\NavbarBrand;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavbarBrandSeeder extends Seeder
{
    public function run(): void
    {
        NavbarBrand::create([
            'text' => 'UrWebsite',
            'image' => 'storage/navbar_brand_images/Logo_UrWebsite_1.png',
            'navbar_id' => 1,
        ]);
    }
}
