<?php

namespace Wulfheart\PrettyRoutes\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Wulfheart\PrettyRoutes\PrettyRoutesServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Spatie\\PrettyRoutes\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            PrettyRoutesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*
        include_once __DIR__.'/../database/migrations/create_pretty_routes_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }

    public function defineRoutes($router)
    {
        $router->get('/', function () {
            return view('welcome');
        });

        $router->get('admin', fn () => true);

        $router->resource('test', Controller::class);

        $router->get('/{one?}/{two}/some/{three?}', fn () => true);
        $router->post('some/thing/{one?}/{two}/some/{three?}', fn () => true);
    }
}
