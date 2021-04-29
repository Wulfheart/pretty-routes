<?php

namespace Wulfheart\PrettyRoutes\Tests;

use ReflectionClass;
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

        $router->get('admin', fn() => true);

        $router->resource('test', Controller::class);

        $router->get('/{one?}/{two}/some/{three?}', fn() => true);
        $router->post('some/thing/{one?}/{two}/some/{three?}', fn() => true);
    }

    /**
     * Call protected/private method of a class.
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to all call.
     * @param array $parameters Array of parameters to be pass into method.
     * @return mixed Method return.
     * @throws \ReflectionException
     */
    protected function invokeMethod(&$object, string $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
