<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            // Match the admin by email
            ['email' => 'nsuzon02@gmail.com'],
            // Update or create with these attributes
            [
                'name' => 'User',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
