<?php

namespace Garavel\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'title'         => 'LDAP Auth',
            'description'   => 'TmdAuth Token, Otomatik üretilir',
            'is_changeable' => 0,
            'key'           => 'tmdauth_token',
            'value'         => ''
        ]);
    }
}
