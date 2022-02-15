<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'name' => 'Emmanuel Oteng',
            'email' => 'hagioswilson@gmail.com',
            'password' => bcrypt('123456'),
            'phone_number' => '233556684934',
            'must_change_password' => false
        ]);

        $admin->assignRole('super admin');
    }
}
