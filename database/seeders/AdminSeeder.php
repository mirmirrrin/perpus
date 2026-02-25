<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            [ 'email' => 'admin@gmail.com' ],
            [ 
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->assignRole('admin');

    }
}
