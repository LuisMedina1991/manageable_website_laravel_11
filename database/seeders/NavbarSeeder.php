<?php

namespace Database\Seeders;

use App\Models\Navbar;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavbarSeeder extends Seeder
{
    public function run(): void
    {
        Navbar::create([
            'identifier' => 'main-menu',
            'name' => __('First record'),
            'is_selected' => 1,
            'background_color_id' => 3,
            'text_color_id' => 14,
        ]);
    }
}
