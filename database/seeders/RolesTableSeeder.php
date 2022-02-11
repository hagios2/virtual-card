<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['supervisor', 'data entry user', 'admin', 'super admin'];

        foreach ($roles as $role) {
            Role::create(['guard_name' => 'admin', 'name' => $role]);
        }
    }
}
