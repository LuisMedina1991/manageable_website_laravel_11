<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => config('app.admin_name'),
            'email' => config('app.admin_email'),
            'password' => config('app.admin_password'),
            'is_admin' => 1,
        ]);
    }
}
