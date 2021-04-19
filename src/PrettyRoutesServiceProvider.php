<?php

namespace Wulfheart\PrettyRoutes;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wulfheart\PrettyRoutes\Commands\PrettyRoutesCommand;

class PrettyRoutesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('pretty_routes')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_pretty_routes_table')
            ->hasCommand(PrettyRoutesCommand::class);
    }
}
