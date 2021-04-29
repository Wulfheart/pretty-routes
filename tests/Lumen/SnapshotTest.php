<?php

namespace Wulfheart\PrettyRoutes\Tests;

use Anik\Testbench\TestCase;
use Laravel\Lumen\Routing\Router;
use Spatie\Snapshots\MatchesSnapshots;
use Wulfheart\PrettyRoutes\PrettyRoutesServiceProvider;

class SnapshotTest extends TestCase
{
    use MatchesSnapshots;

    protected function serviceProviders(): array
    {
        return [
            PrettyRoutesServiceProvider::class,
        ];
    }

    protected function routes(Router $router): void
    {
        $router->get('/', function () {
            return view('welcome');
        });

        $router->get('test', [
            'name' => 'test.index',
            'uses' => function () {
                return true;
            },
        ]);

        $router->post('test', [
            'name' => 'test.store',
            'uses' => function () {
                return true;
            },
        ]);

        $router->get('test/create', [
            'name' => 'test.create',
            'uses' => function () {
                return true;
            },
        ]);

        $router->get('test/{test}', [
            'name' => 'test.show',
            'uses' => function () {
                return true;
            },
        ]);

        $router->addRoute(['PUT', 'PATCH'], 'test/{test}', [
            'name' => 'test.update',
            'uses' => function () {
                return true;
            },
        ]);

        $router->delete('test/{test}', [
            'name' => 'test.destroy',
            'uses' => function () {
                return true;
            },
        ]);

        $router->get('test/{test}', [
            'name' => 'test.edit',
            'uses' => function () {
                return true;
            },
        ]);

        $router->get('/{one?}/{two}/some/{three?}', function () {
            return true;
        });

        $router->post('some/thing/{one?}/{two}/some/{three?}', function () {
            return true;
        });
    }

    protected function setUp(): void
    {
        putenv('COLUMNS=120');
        parent::setUp();
    }

    /** @test */
    public function basic_output(): void
    {
        $this->artisan('route:pretty');

        $this->assertMatchesSnapshot($this->artisanOutput());
    }
}
