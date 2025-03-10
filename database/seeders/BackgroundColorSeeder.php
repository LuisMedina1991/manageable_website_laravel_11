<?php

namespace Database\Seeders;

use App\Models\BackgroundColor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BackgroundColorSeeder extends Seeder
{
    public function run(): void
    {
        BackgroundColor::create([
            'name' => __('blue'),
            'class' => 'bg-primary',
        ]);

        BackgroundColor::create([
            'name' => __('subtle blue'),
            'class' => 'bg-primary-subtle',
        ]);

        BackgroundColor::create([
            'name' => __('gray'),
            'class' => 'bg-secondary',
        ]);

        BackgroundColor::create([
            'name' => __('subtle gray'),
            'class' => 'bg-secondary-subtle',
        ]);

        BackgroundColor::create([
            'name' => __('green'),
            'class' => 'bg-success',
        ]);

        BackgroundColor::create([
            'name' => __('subtle green'),
            'class' => 'bg-success-subtle',
        ]);

        BackgroundColor::create([
            'name' => __('red'),
            'class' => 'bg-danger',
        ]);

        BackgroundColor::create([
            'name' => __('subtle red'),
            'class' => 'bg-danger-subtle',
        ]);

        BackgroundColor::create([
            'name' => __('yellow'),
            'class' => 'bg-warning',
        ]);

        BackgroundColor::create([
            'name' => __('subtle yellow'),
            'class' => 'bg-warning-subtle',
        ]);

        BackgroundColor::create([
            'name' => __('cerulean blue'),
            'class' => 'bg-info',
        ]);

        BackgroundColor::create([
            'name' => __('subtle cerulean blue'),
            'class' => 'bg-info-subtle',
        ]);

        BackgroundColor::create([
            'name' => __('light'),
            'class' => 'bg-light',
        ]);

        BackgroundColor::create([
            'name' => __('dark'),
            'class' => 'bg-dark',
        ]);

        BackgroundColor::create([
            'name' => __('black'),
            'class' => 'bg-black',
        ]);
    }
}
