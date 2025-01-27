<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            // Match the admin by email
            ['email' => 'admin@gmail.com'],
            // Update or create with these attributes
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
