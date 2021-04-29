<?php

namespace Wulfheart\PrettyRoutes;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wulfheart\PrettyRoutes\Commands\LumenPrettyRoutesCommand;
use Wulfheart\PrettyRoutes\Commands\PrettyRoutesCommand;
use Laravel\Lumen\Application as LumenApplication;

class PrettyRoutesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        if ($this->app instanceof LumenApplication) {
            $command = LumenPrettyRoutesCommand::class;
        } else {
            $command = PrettyRoutesCommand::class;
        }

        $package
            ->name('pretty_routes')
            ->hasCommand($command);
    }
}
