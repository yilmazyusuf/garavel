<?php
/**
 *
 *
 * @category
 * @package
 * @author yusuf.yilmaz
 * @since  : 9.01.2020
 */

namespace Garavel\Console;

use Garavel\Traits\PackageInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Composer;

class SeedCommand extends Command {

    use PackageInfo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'garavel:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Klasöründe yer alan tüm seed dosyaları sırası ile uygulanıyor';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;


    /**
     * Create a new migration install command instance.
     *
     * @param \Illuminate\Database\Migrations\MigrationCreator $creator
     * @param \Illuminate\Support\Composer                     $composer
     *
     * @return void
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }


    public function handle()
    {
        $this->call('db:seed', ['--class' => 'Garavel\Seeders\UsersRolesPermissionsSeeder', '--force' => true]);
        $this->call('db:seed', ['--class' => 'Garavel\Seeders\MenuSeeder', '--force' => true]);
        $this->call('db:seed', ['--class' => 'Garavel\Seeders\SettingsTableSeeder', '--force' => true]);
        $this->call('db:seed', ['--class' => 'Garavel\Seeders\Upgrade2Seeder', '--force' => true]);
        $this->call('db:seed', ['--class' => 'Garavel\Seeders\CroppiePermissionSeeder', '--force' => true]);
    }


}
