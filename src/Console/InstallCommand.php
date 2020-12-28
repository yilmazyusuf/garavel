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

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Symfony\Component\Process\Process;

class InstallCommand extends Command {


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'garavel:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Garavel resources';

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
        $this->comment('Publishing Garavel Configuration...');

        //Intervention
        $this->call('vendor:publish', ['--provider' => 'Intervention\Image\ImageServiceProviderLaravelRecent', '--force' => true]);
        //Spatie
        $this->call('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider', '--force' => true]);

        $this->call('telescope:install');
        $this->call('migrate:fresh');
        $this->call('ui',['type' => 'bootstrap', '--auth' => true]);

        $this->composer->dumpAutoloads();
        $seedProcess = new Process(['php', 'artisan' ,'garavel:seed']);
        $seedProcess->run();
        $this->info($seedProcess->getOutput());


        //Garavel
        $this->call('vendor:publish', ['--tag' => 'garavel-project', '--force' => true]);
        //Admin LTE
        $this->call('vendor:publish', ['--tag' => 'theme-core', '--force' => true]);
        $this->call('vendor:publish', ['--tag' => 'theme-plugins', '--force' => true]);
        //File Manager
        $this->call('vendor:publish', ['--tag' => 'fm-config', '--force' => true]);
        $this->call('vendor:publish', ['--tag' => 'fm-assets', '--force' => true]);
        //Data Table
        $this->call('vendor:publish', ['--tag' => 'datatables', '--force' => true]);


        //Delete Default User Model
        $userModel = app_path('User.php');

        if(file_exists($userModel)){
            unlink($userModel);
        }


        $this->info('AdminLTE kurulumu tamamlandı.');
        $this->composer->dumpAutoloads();


    }

}
