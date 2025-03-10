<?php

namespace Database\Seeders;

use App\Models\ThirdSectionContactForm;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThirdSectionContactFormSeeder extends Seeder
{
    public function run(): void
    {
        ThirdSectionContactForm::create([
            'title' => __('Contact Us'),
            'name_label' => __('Full Name'),
            'email_label' => __('Email'),
            'phone_label' => __('Phone Number'),
            'message_label' => __('Message'),
            'third_section_id' => 1,
        ]);
    }
}
