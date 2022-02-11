<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

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
            Role::create(['role' => $role]);
        }
    }
}
