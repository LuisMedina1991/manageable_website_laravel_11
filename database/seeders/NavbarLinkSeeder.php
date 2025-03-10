<?php

namespace Database\Seeders;

use App\Models\NavbarLink;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavbarLinkSeeder extends Seeder
{
    public function run(): void
    {
        NavbarLink::create([
            'href' => 'first-section',
            'text' => __('1st Section'),
            'navbar_id' => 1,
        ]);

        NavbarLink::create([
            'href' => 'second-section',
            'text' => __('2nd Section'),
            'navbar_id' => 1,
        ]);

        NavbarLink::create([
            'href' => 'third-section',
            'text' => __('3rd Section'),
            'navbar_id' => 1,
        ]);
    }
}
