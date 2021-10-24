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
        Role::create(['name' => 'Invitado', 'guard_name' => 'api']);
        Role::create(['name' => 'Libreton', 'guard_name' => 'api']);
        Role::create(['name' => 'MiPyme', 'guard_name' => 'api']);
    }
}
