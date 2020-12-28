<?php

namespace Garavel;

use Garavel\Console\InstallCommand;
use Garavel\Console\MakeFilterCommand;
use Garavel\Console\SeedCommand;
use Garavel\Console\UpgradeCommand;
use Garavel\Exceptions\GaravelExceptionHandler;
use Garavel\Utils\Ajax;
use Garavel\ViewComposers\FlashMessageViewComposer;
use Garavel\ViewComposers\MenuComposer;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


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

        $this->app->singleton('ajax', Ajax::class);
        $this->loadRoutesFrom(__DIR__ . '/Base/Routes/adminlte.php');
        $this->loadViewsFrom(__DIR__ . '/Base/Views', 'adminlte');

        /*
 * Unbind
 * AppServiceProvider
 *  $this->app->bind(
        ExceptionHandler::class,
        Handler::class
    );
 *
 */

        $this->app->bind(
            ExceptionHandler::class,
            GaravelExceptionHandler::class
        );

        View::composer('adminlte::layouts.app', FlashMessageViewComposer::class);
        View::composer('adminlte::layouts.app', MenuComposer::class);

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
            $this->loadMigrationsFrom(__DIR__ . '/Storage/Migrations');
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
                __DIR__ . '/../publishes/' => base_path(),
            ], 'garavel-project');

            $this->publishes([
                base_path('vendor/almasaeed2010/adminlte/dist') => public_path('vendor/adminlte/dist'),
            ], 'theme-core');

            $this->publishes([
                base_path('vendor/almasaeed2010/adminlte/plugins') => public_path('vendor/adminlte/plugins'),
            ], 'theme-plugins');
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
                'timeout'   => (int)settings('captcha.options.timeout'),
                'debug'     => (boolean)json_decode(strtolower(settings('captcha.options.debug')))
            ]);
        }

        //https://github.com/yajra/laravel-datatables/issues/2327.
        if (config('app.env') === 'production')
        {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
