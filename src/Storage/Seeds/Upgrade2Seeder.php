<?php

namespace Garavel\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Upgrade2Seeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Insert New Settings
        $settingsInital = [
            [
                'title'         => 'Api Domain',
                'description'   => 'Yöneticinizden isteyiniz',
                'key'           => 'tmdauth_api_domain',
                'value'         => config('tmdauth.api_domain'),
                'is_changeable' => 0,
            ],
            [
                'title'         => 'Api Key',
                'description'   => 'Yöneticinizden isteyiniz',
                'key'           => 'tmdauth_api_key',
                'value'         => config('tmdauth.api_key'),
                'is_changeable' => 0,
            ],
            [
                'title'         => 'Api Pass',
                'description'   => 'Yöneticinizden isteyiniz',
                'key'           => 'tmdauth_api_pass',
                'value'         => config('tmdauth.app_pass'),
                'is_changeable' => 0,
            ],


            [
                'title'         => 'reCAPTCHA badge hide	',
                'description'   => 'set true if you want to hide your recaptcha badge	',
                'key'           => 'captcha.options.hideBadge',
                'value'         => 'false',
                'is_changeable' => 0,
            ],
            [
                'title'         => 'reCAPTCHA Databadge Position',
                'description'   => 'reposition the reCAPTCHA badge. values: bottomright, bottomleft, inline	',
                'key'           => 'captcha.options.dataBadge',
                'value'         => 'bottomright',
                'is_changeable' => 0,
            ],
            [
                'title'         => 'reCAPTCHA Debug	',
                'description'   => 'set true to show binding status on your javascript console	',
                'key'           => 'captcha.options.debug',
                'value'         => 'false',
                'is_changeable' => 0,
            ],
            [
                'title'         => 'reCAPTCHA secret key	',
                'description'   => 'recapthca secret key	',
                'key'           => 'captcha.secretKey',
                'value'         => '',
                'is_changeable' => 0,
            ],
            [
                'title'         => 'reCAPTCHA siteKey	',
                'description'   => 'reCAPTCHA siteKey	',
                'key'           => 'captcha.siteKey',
                'value'         => '',
                'is_changeable' => 0,
            ],
            [
                'title'         => 'reCAPTCHA timeout',
                'description'   => 'timeout value for guzzle client	',
                'key'           => 'captcha.options.timeout',
                'value'         => 5,
                'is_changeable' => 0,
            ],
            [
                'title'         => 'reCAPTCHA Açık/Kapalı	',
                'description'   => 'Login ekranında captcha getirilsinmi ?	',
                'key'           => 'captcha.isActive',
                'value'         => 0,
                'is_changeable' => 0,
            ]
        ];

        DB::table('settings')->insert($settingsInital);

        //Update tmd_auth_token
        DB::table('settings')->where('key', 'tmdauth_token')
            ->update(
                [
                    'title'         => 'LDAP Auth',
                    'description'   => 'TmdAuth Token, Otomatik üretilir',
                    'is_changeable' => 0,
                ]
            );

        //Give setting permission to super_admin
        $permission = Permission::create(['name' => 'settings_management']);
        $role = Role::findByName('super_admin');
        $role->givePermissionTo($permission);

        //Add Config To Menü
        DB::table('adminlte_menus')->insert(
            [
                [
                    'parent_id'     => 0,
                    'text'          => 'Ayarlar',
                    'icon'          => ' fas fa-cogs',
                    'href'          => 'settings',
                    'role_id'       => 1,
                    'permission_id' => null,
                ]
            ]
        );


    }
}
