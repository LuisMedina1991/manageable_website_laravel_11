<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            BackgroundColorSeeder::class,
            TextColorSeeder::class,
            HeaderSeeder::class,
            NavbarSeeder::class,
            NavbarBrandSeeder::class,
            NavbarLinkSeeder::class,
            CarouselImageSeeder::class,
            FirstSectionSeeder::class,
            FirstSectionFrameSeeder::class,
            SecondSectionSeeder::class,
            SecondSectionBlockSeeder::class,
            ThirdSectionSeeder::class,
            ThirdSectionContactFormSeeder::class,
            FooterSocialMediaLinkSeeder::class,
            UserSeeder::class,

        ]);
    }
}
