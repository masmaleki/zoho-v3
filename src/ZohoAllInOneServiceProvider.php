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
            ->hasMigration('create_zoho_v3_table')
            ->hasCommand(ZohoAllInOneCommand::class);
    }

    public function packageBooted()
    {
        $this->configureRoutes();
    }

    protected function configureRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
    }
}
