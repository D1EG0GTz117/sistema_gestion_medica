<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'medico',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'paciente',
            'guard_name' => 'web',
        ]);
    }
}
