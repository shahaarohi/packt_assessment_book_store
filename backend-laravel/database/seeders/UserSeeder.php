<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert admin user
        User::create([
            'name' => 'Packt',
            'email' => 'packt@gmail.com',
            'password' => bcrypt('packt@1234'),
            'is_admin' => true
        ]);
        
        // Insert normal user
        User::create([
            'name' => 'Aarohi Shah',
            'email' => 'aarohi@gmail.com',
            'password' => bcrypt('aarohi@1234'),
        ]);
    }
}
