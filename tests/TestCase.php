<?php

namespace Wulfheart\PrettyRoutes\Tests;

use Illuminate\Routing\Controller;
use Orchestra\Testbench\TestCase as Orchestra;
use Wulfheart\PrettyRoutes\PrettyRoutesServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [PrettyRoutesServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        putenv('COLUMNS=120');
    }

    public function defineRoutes($router): void
    {
        $router->get('/', function () {
            return view('welcome');
        });

        $router->get('admin', fn () => true);

        $router->resource('user', Controller::class);
        $router->resource('user.admin', Controller::class);
        $router->resource('water', Controller::class);
        $router->resource('fire', Controller::class);
        $router->resource('flash', Controller::class);

        $router->get('/{one?}/{two}/some/{three?}', fn () => true)->name('long.index');
        $router->post('some/thing/{one?}/{two}/some/{three?}', fn () => true);
    }
}
