<?php
return [
    2 => [
        'notes'      => 'Capthcha',
        'url'        => 'http://gitlab.tmd/kurumsal-icerik/tmdcore/blob/master/upgrades/2.md',
        'migrations' =>
            [
                'vendor/tmdcore/core/storage/Migrations/2020_06_16_123607_add_title_description_to_settings_table.php'
            ],
        'seeds'      =>
            [
                'Upgrade2Seeder'
            ],
        'is_down'    => true,
        'after'      => function ()
        {

            deletePermanentEnv('TMDAUTH_APIKEY');
            deletePermanentEnv('TMDAUTH_APIPASS');
            deletePermanentEnv('TMDAUTH_APIDOMAIN');
            $this->info('.env dosyanizdan tmdauth verileri (TMDAUTH_APIKEY,TMDAUTH_APIPASS,TMDAUTH_APIDOMAIN) silindi');

            //Delete Tmdauth config
            $tmdauthFile = config_path('tmdauth.php');

            if(file_exists($tmdauthFile)){
                unlink($tmdauthFile);
            }
            //AdminLte Settings
            $this->call('vendor:publish', ['--tag' => 'adminlte-settings', '--force' => true]);

            $this->info('config/tmdauth.php dosyaniz silindi');
        }
    ]

];
