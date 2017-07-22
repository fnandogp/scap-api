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
        // Permissions
        $manage_users = Permission::create([
            'name'         => 'manage-user',
            'display_name' => 'Manage users (Create, Read, Update, Delete, Index).'
        ]);

        $view_request = Permission::create([
            'name'         => 'view-request',
            'display_name' => 'View and List requests'
        ]);

        $create_request = Permission::create([
            'name'         => 'create-request',
            'display_name' => 'Create request'
        ]);

        $defer_opinion = Permission::create([
            'name'         => 'defer-opinion',
            'display_name' => 'Defer opinion'
        ]);

        $manifest_against = Permission::create([
            'name'         => 'manifest-against',
            'display_name' => 'Manifest against'
        ]);

        $cancel_request = Permission::create([
            'name'         => 'cancel-request',
            'display_name' => 'Cancel request'
        ]);

        // Roles
        $admin_role = Role::create([
            'name'         => 'admin',
            'display_name' => 'Administrator',
        ]);
        $admin_role->attachPermissions([
            $manage_users,
            $view_request,
            $create_request,
            $cancel_request,
            $defer_opinion,
            $manifest_against
        ]);

        $secretary_role = Role::create([
            'name'         => 'secretary',
            'display_name' => 'Secretary',
        ]);
        $secretary_role->attachPermissions([
            $manage_users,
            $view_request,
            $defer_opinion,
        ]);

        $professor_role = Role::create([
            'name'         => 'professor',
            'display_name' => 'professor',
        ]);
        $professor_role->attachPermissions([
            $view_request,
            $create_request,
            $cancel_request,
            $manifest_against,
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

//        $department_chief = User::create([
//            'name'       => 'Department Chief',
//            'email'      => 'department.chief@example.com',
//            'password'   => bcrypt('secret'),
//            'enrollment' => '3333333333'
//        ]);
//        $department_chief->attachRole($department_chief_role);

    }
}
