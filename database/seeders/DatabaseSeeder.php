<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'fullname' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'age'=>2,
            'phone'=>123456789,
            'id_identify' => 1,
            'image'=>'sssss.jpg',
            'id_identify_image' => 'sssss.jpg', // Provide a value
        ]);
}       
}
