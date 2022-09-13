<?php

namespace Masmaleki\ZohoAllInOne;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Masmaleki\ZohoAllInOne\Commands\ZohoAllInOneCommand;

class ZohoAllInOneServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('zoho-v3')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations('create_zoho_v3_table', 'create_zoho_model_has_roles_table')
            ->hasCommand(ZohoAllInOneCommand::class);
    }

    public function packageBooted()
    {
        $this->configureRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishSeeders();
        }
    }

    protected function configureRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
    }

    protected function publishSeeders()
    {
        $this->publishes([
            __DIR__ . '/../database/seeders/ZohoUserHasRoleSeeder.php' => database_path('seeders/ZohoUserHasRoleSeeder.php'),
        ], 'zoho-v3-seeders');
    }
}
