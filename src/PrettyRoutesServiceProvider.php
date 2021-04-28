<?php

namespace Wulfheart\PrettyRoutes;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wulfheart\PrettyRoutes\Commands\PrettyRoutesCommand;

class PrettyRoutesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('pretty_routes')
            ->hasCommand(PrettyRoutesCommand::class);
    }
}
