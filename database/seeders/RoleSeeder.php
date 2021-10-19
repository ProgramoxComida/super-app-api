<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Negocio', 'guard_name' => 'api']);
        Role::create(['name' => 'Emprendedor', 'guard_name' => 'api']);
        Role::create(['name' => 'Cuentahabiente', 'guard_name' => 'api']);
    }
}
