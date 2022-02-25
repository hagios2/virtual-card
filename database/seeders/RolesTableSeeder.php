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
        $adminRoles = ['supervisor', 'data entry user', 'admin', 'super admin'];
        $agentRoles = ['admin', 'user'];

        foreach ($adminRoles as $role) {
            Role::create(['guard_name' => 'admin', 'name' => $role]);
        }

        foreach ($agentRoles as $role) {
            Role::create(['guard_name' => 'agent', 'name' => $role]);
        }
    }
}
