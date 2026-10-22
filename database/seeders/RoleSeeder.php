<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'name' => 'admin',
            'label' => 'Administrator'
        ]);

        Role::create([
            'name' => 'user',
            'label' => 'Regular User'
        ]);
    }
}
