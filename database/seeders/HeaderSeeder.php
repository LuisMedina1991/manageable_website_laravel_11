<?php

namespace Database\Seeders;

use App\Models\Header;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeaderSeeder extends Seeder
{
    public function run(): void
    {
        Header::create([
            'identifier' => 'main-header',
            'name' => __('First record'),
            'link_phone' => '59175387328',
            'link_text' => __('Text for header WhatsApp link'),
            'is_selected' => 1,
            'background_color_id' => 13,
            'text_color_id' => 3,
        ]);
    }
}
