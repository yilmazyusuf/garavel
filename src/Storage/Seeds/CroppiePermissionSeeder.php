<?php

namespace Garavel\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class CroppiePermissionSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Give Croppie permission to super_admin
        $permission = Permission::create(['name' => 'croppie_upload']);
        $role = Role::findByName('super_admin');
        $role->givePermissionTo($permission);

    }
}
