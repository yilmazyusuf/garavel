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
use Symfony\Component\Process\Process;

class UpgradeCommand extends Command {


    use PackageInfo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'garavel:upgrade {version}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade Garavel';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;
    private $upgradeConf;
    private $version;
    private $package;


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
        $this->version = $this->argument('version');
        $this->package = PackageInfo::findPackageByName('yilmazyusuf/garavel');
        $upgradable = require_once __DIR__ . '/../../upgrades/upgrades.php';

        if (!isset($upgradable[$this->version]))
        {
            $this->error("Talep ettiginiz upgrade bulunamadi");

            return;
        }

        $this->upgradeConf = $upgradable[$this->version];

        $this->startSignal();

        $this->call('vendor:publish', ['--tag' => 'garavel-migrations']);
        $this->call('vendor:publish', ['--tag' => 'garavel-seeds']);
        $this->call('migrate');

        $this->composer->dumpAutoloads();
        $this->runSeeders();
        $this->endSignal();
        $this->hasAfterCommand();
    }

    private function endSignal()
    {
        if ($this->checkHasDown())
        {
            $this->call('up');
            $this->info("Uygulama bakim modundan cikarildi.");
        }

        $this->info("Upgrade basari ile tamamlandi.");
    }

    private function startSignal()
    {
        $packageVersion = PackageInfo::getVersion($this->package);

        $this->info("Mevcut versiyonunuz $packageVersion .");
        $this->warn("Upgrade : {$this->version} kuruluyor...");
        $this->alert("Notlar : {$this->upgradeConf['notes']}");
        $this->info("Bu adresten upgrade notlarina ulasabilirsiniz : {$this->upgradeConf['url']}");

        if ($this->checkHasDown())
        {
            $this->warn("Sistem bakim moduna alınacak, upgrade bittikten sonra otomatik bakim modundan cikartilacaktir.");
            $this->call('down', ['--message' => 'Güncelleme işlemi yapılmaktadır. Kısa süre sonra tekrar deneyiniz.', '--retry' => 5]);
        }
    }

    private function runSeeders()
    {
        if ($this->checkHasSeeds())
        {
            $seeds = $this->upgradeConf['seeds'];
            foreach ($seeds as $seed)
            {
                $seedProcess = new Process('php artisan db:seed --class=' . $seed . ' --force');
                $seedProcess->run();
                $this->info($seedProcess->getOutput());
            }
        }
    }


    private function hasUpgradeConf(string $conf)
    : bool
    {
        return isset($this->upgradeConf[$conf]) &&
        !is_null($this->upgradeConf[$conf]) &&
        !empty($this->upgradeConf[$conf]) ? true : false;
    }

    private function checkHasDown()
    : bool
    {
        return $this->hasUpgradeConf('is_down') &&
        $this->upgradeConf['is_down'] === true ? true : false;
    }

    private function checkHasSeeds()
    : bool
    {
        return $this->hasUpgradeConf('seeds') &&
        is_array($this->upgradeConf['seeds']) &&
        count($this->upgradeConf['seeds']) > 0 ? true : false;

    }

    private function hasAfterCommand()
    {
        if ($this->hasUpgradeConf('after') && $this->upgradeConf['after'] instanceof \Closure)
        {
            call_user_func($this->upgradeConf['after']);
        }
    }


}
