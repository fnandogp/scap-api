<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        $admin_role = Role::create([
            'name'         => 'admin',
            'display_name' => 'Administrator',
        ]);

        $secretary_role = Role::create([
            'name'         => 'secretary',
            'display_name' => 'Secretary',
        ]);

        $professor_role = Role::create([
            'name'         => 'professor',
            'display_name' => 'professor',
        ]);


        // Users
        $admin = User::create([
            'name'       => 'Admin',
            'email'      => 'admin@example.com',
            'password'   => bcrypt('secret'),
            'enrollment' => '0000000000'
        ]);
        $admin->attachRole($admin_role);

        $secretary = User::create([
            'name'       => 'Secretary',
            'email'      => 'secretary@example.com',
            'password'   => bcrypt('secret'),
            'enrollment' => '1111111111'
        ]);
        $secretary->attachRole($secretary_role);

        $professor = User::create([
            'name'       => 'Professor',
            'email'      => 'professor@example.com',
            'password'   => bcrypt('secret'),
            'enrollment' => '2222222222'
        ]);
        $professor->attachRole($professor_role);

    }
}
