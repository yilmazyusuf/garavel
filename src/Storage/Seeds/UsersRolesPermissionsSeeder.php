<?php

namespace Garavel\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersRolesPermissionsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         //Super User
         DB::table('users')->insert([
             [
                 'name'        => 'Admin',
                 'email'       => 'tmdadmin@sabah.com.tr',
                 'password'    => Hash::make('123456'),
                 'is_tmd_auth' => 0,
                 'status'      => 1,
             ],

         ]);
         $user = DB::table('users')->find(1);
         //Roles
         $role = Role::create(['name' => 'super_admin']);
         $user->assignRole($role);


         $permission = Permission::create(['name' => 'permission_management']);
         $role->givePermissionTo($permission);

         $permission = Permission::create(['name' => 'user_management']);
         $role->givePermissionTo($permission);

         $permission = Permission::create(['name' => 'roles_management']);
         $role->givePermissionTo($permission);
        */

        //Super User
        DB::table('users')->insert([
            'id'          => 1,
            'name'        => 'Admin',
            'email'       => 'tmdadmin@sabah.com.tr',
            'password'    => Hash::make('123456'),
            'is_tmd_auth' => 0,
            'status'      => 1,
        ]);

        //Roles
        DB::table('roles')->insert([
            'id'         => 1,
            'name'       => 'super_admin',
            'guard_name' => 'web'
        ]);

        //Permissions
        $permissions = [
            [
                'id'         => 1,
                'name'       => 'permission_management',
                'guard_name' => 'web'
            ],
            [
                'id'         => 2,
                'name'       => 'user_management',
                'guard_name' => 'web'
            ],
            [
                'id'         => 3,
                'name'       => 'roles_management',
                'guard_name' => 'web'
            ]

        ];

        DB::table('permissions')->insert($permissions);

        //Role Has Permissions
        $roleHasPermissions = [
            [
                'permission_id' => 1,
                'role_id'       => 1,
            ],
            [
                'permission_id' => 2,
                'role_id'       => 1
            ],
            [
                'permission_id' => 3,
                'role_id'       => 1,
            ]

        ];

        DB::table('role_has_permissions')->insert($roleHasPermissions);

        //Model Has Roles
        $modelHasRoles = [
            [
                'role_id'    => 1,
                'model_type' => 'Garavel\Model\GaravelUserModel',
                'model_id'   => 1,
            ]

        ];

        DB::table('model_has_roles')->insert($modelHasRoles);

        //Model Has Permissions
        $modelHasPermissions = [
            [
                'permission_id' => 1,
                'model_type'    => 'Garavel\Model\GaravelUserModel',
                'model_id'      => 1,
            ],
            [
                'permission_id' => 2,
                'model_type'    => 'Garavel\Model\GaravelUserModel',
                'model_id'      => 1,
            ],
            [
                'permission_id' => 3,
                'model_type'    => 'Garavel\Model\GaravelUserModel',
                'model_id'      => 1,
            ]

        ];

        DB::table('model_has_permissions')->insert($modelHasPermissions);


    }
}
