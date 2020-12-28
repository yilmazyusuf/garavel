<?php

namespace Garavel;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use TmdCore\Console\InstallCommand;
use TmdCore\Console\MakeFilterCommand;
use TmdCore\Console\SeedCommand;
use TmdCore\Console\UpgradeCommand;

class GaravelServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        $this->registerMigrations();
        $this->registerPublishing();

        //Fix for MySQL < 5.7.7 and MariaDB < 10.2.2
        // https://laravel.com/docs/master/migrations#creating-indexes
        Schema::defaultStringLength(191);

        //https://github.com/yajra/laravel-datatables/issues/2327.
        if (config('app.env') === 'production')
        {
            $url->forceScheme('https');
        }

    }


    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        if ($this->app->runningInConsole())
        {
            $this->loadMigrationsFrom(__DIR__ . '/../storage/migrations');
        }
    }


    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole())
        {
            $this->publishes([
                __DIR__ . '/../storage/Migrations' => database_path('migrations'),
            ], 'tmdcore-migrations');

            $this->publishes([
                __DIR__ . '/../storage/Seeds' => database_path('seeds'),
            ], 'tmdcore-seeds');

            $this->publishes([
                __DIR__ . '/../resources' => resource_path(),
            ], 'tmdcore-resources');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            InstallCommand::class,
            UpgradeCommand::class,
            MakeFilterCommand::class,
            SeedCommand::class,
        ]);

        //Captcha Settings
        if (settings('captcha.isActive') == 1)
        {
            config()->set('captcha.siteKey', settings('captcha.siteKey'));
            config()->set('captcha.secretKey', settings('captcha.isActive'));
            config()->set('captcha.options', [
                'hideBadge' => (boolean)json_decode(strtolower(settings('captcha.options.hideBadge'))),
                'dataBadge' => settings('captcha.options.dataBadge'),
                'timeout' => (int)settings('captcha.options.timeout'),
                'debug' => (boolean)json_decode(strtolower(settings('captcha.options.debug')))
            ]);
        }

        //https://github.com/yajra/laravel-datatables/issues/2327.
        if (config('app.env') === 'production')
        {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
