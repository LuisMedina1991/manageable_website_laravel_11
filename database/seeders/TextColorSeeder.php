<?php

namespace Database\Seeders;

use App\Models\TextColor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TextColorSeeder extends Seeder
{
    public function run(): void
    {
        TextColor::create([
            'name' => __('blue'),
            'class' => 'text-primary',
        ]);

        TextColor::create([
            'name' => __('dark blue'),
            'class' => 'text-primary-emphasis',
        ]);

        TextColor::create([
            'name' => __('gray'),
            'class' => 'text-secondary',
        ]);

        TextColor::create([
            'name' => __('dark gray'),
            'class' => 'text-secondary-emphasis',
        ]);

        TextColor::create([
            'name' => __('green'),
            'class' => 'text-success',
        ]);

        TextColor::create([
            'name' => __('dark green'),
            'class' => 'text-success-emphasis',
        ]);

        TextColor::create([
            'name' => __('red'),
            'class' => 'text-danger',
        ]);

        TextColor::create([
            'name' => __('dark red'),
            'class' => 'text-danger-emphasis',
        ]);

        TextColor::create([
            'name' => __('yellow'),
            'class' => 'text-warning',
        ]);

        TextColor::create([
            'name' => __('dark yellow'),
            'class' => 'text-warning-emphasis',
        ]);

        TextColor::create([
            'name' => __('cerulean blue'),
            'class' => 'text-info',
        ]);

        TextColor::create([
            'name' => __('dark cerulean blue'),
            'class' => 'text-info-emphasis',
        ]);

        TextColor::create([
            'name' => __('light'),
            'class' => 'text-light',
        ]);

        TextColor::create([
            'name' => __('white'),
            'class' => 'text-white',
        ]);

        TextColor::create([
            'name' => __('dark'),
            'class' => 'text-dark',
        ]);

        TextColor::create([
            'name' => __('black'),
            'class' => 'text-black',
        ]);
    }
}
