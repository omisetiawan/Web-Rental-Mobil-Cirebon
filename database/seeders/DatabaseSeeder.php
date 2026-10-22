<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CarSeeder::class,      // Pastikan CarSeeder dipanggil dulu
            BookingSeeder::class,  // Lalu BookingSeeder
            PostSeeder::class,     // Artikel & Blog Yoast SEO
        ]);
    }
}
