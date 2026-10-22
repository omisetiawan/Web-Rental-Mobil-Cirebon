<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $adminExists = User::where('email', 'admin@rental.com')->exists();

        if (!$adminExists) {
            User::forceCreate([
                'name' => 'Administrator',
                'email' => 'admin@rental.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Rentgo19'), // Ganti dengan password yang aman
                'role' => 'admin', // Admin privilege assignment via forceCreate
            ]);

            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@rental.com');
            $this->command->info('Password: Rentgo19');
        } else {
            $this->command->info('Admin user already exists!');
        }
    }
}
