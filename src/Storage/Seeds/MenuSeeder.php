<?php

namespace Garavel\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        //Add Permission and Roles to super_admin
        $permission = Permission::create(['name' => 'menu_management']);
        $role = Role::findByName('super_admin');
        $role->givePermissionTo($permission);


        //Super User
        DB::table('adminlte_menus')->insert(
            [
                [
                    'id' => 1,
                    'parent_id' => 0,
                    'text' => 'Kullanıcı Yönetimi',
                    'icon' => 'fas fa-users-cog',
                    'href' => '#',
                    'role_id' => 1,
                    'permission_id' => null,
                ],
                [
                    'id' => 2,
                    'parent_id' => 1,
                    'text' => 'Kullanıcılar',
                    'icon' => 'fas fa-user-edit',
                    'href' => 'users',
                    'role_id' => null,
                    'permission_id' => 2,
                ],
                [
                    'id' => 3,
                    'parent_id' => 1,
                    'text' => 'Roller',
                    'icon' => 'fas fa-unlock-alt',
                    'href' => 'roles',
                    'role_id' => null,
                    'permission_id' => 3,
                ],
                [
                    'id' => 4,
                    'parent_id' => 1,
                    'text' => 'Yetkiler',
                    'icon' => 'fas fa-user-lock',
                    'href' => 'permissions',
                    'role_id' => null,
                    'permission_id' => 1,
                ],
                [
                    'id' => 5,
                    'parent_id' => 0,
                    'text' => 'Menüler',
                    'icon' => 'fas fa-list',
                    'href' => 'menus',
                    'role_id' => null,
                    'permission_id' => $permission->id,
                ],
                [
                    'id' => 6,
                    'parent_id' => 0,
                    'text' => 'Telescope Log',
                    'icon' => 'fas fa-database',
                    'href' => 'telescope',
                    'role_id' => 1,
                    'permission_id' => null,
                ]
            ]

        );



    }
}
