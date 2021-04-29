<?php

namespace Wulfheart\PrettyRoutes\Tests\Unit\Commands;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Terminal;
use Wulfheart\PrettyRoutes\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Wulfheart\PrettyRoutes\Commands\PrettyRoutesCommand;

/**
 * Class PrettyRoutesCommandTest
 * @package Wulfheart\PrettyRoutes\Tests\Unit\Commands
 * @coversDefaultClass \Wulfheart\PrettyRoutes\Commands\PrettyRoutesCommand
 */
class PrettyRoutesCommandTest extends TestCase
{
    const MINIMUM_TERMINAL_WIDTH = 30;

    /**
     * @var Router|MockObject
     */
    private Router $router;

    /**
     * @var Terminal|MockObject
     */
    private Terminal $terminal;

    /**
     * @var PrettyRoutesCommand|MockObject
     */
    private PrettyRoutesCommand $prettyRoutesCommand;

    public function setUp(): void
    {
        parent::setUp();

        $this->router = $this->createMock(Router::class);
        $this->terminal = $this->createMock(Terminal::class);
        $this->prettyRoutesCommand = new PrettyRoutesCommand($this->router, $this->terminal);
    }

    /**
     * @test
     * @covers ::handle
     */
    function it_should_flush_middleware_groups_and_show_return_error_when_there_is_no_route_registered()
    {
        $this->prettyRoutesCommand = $this->getMockedCommand(['error', 'displayRoutes']);

        $this->router->expects($this->once())->method('flushMiddlewareGroups');
        $this->router->expects($this->once())->method('getRoutes')->willReturn([]);
        $this->prettyRoutesCommand
            ->expects($this->once())
            ->method('error')
            ->with("Your application doesn't have any routes.");
        $this->prettyRoutesCommand->expects($this->never())->method('displayRoutes');

        $this->prettyRoutesCommand->handle();
    }

    /**
     * @test
     * @covers ::handle
     */
    function it_should_return_error_when_there_is_no_matching_routes_for_given_criteria()
    {
        $this->prettyRoutesCommand = $this->getMockedCommand(['error', 'displayRoutes', 'getRoutes']);

        $this->router->expects($this->once())->method('flushMiddlewareGroups');
        $this->router->expects($this->once())->method('getRoutes')->willReturn(['route1', 'route2']);
        $this->prettyRoutesCommand
            ->expects($this->once())
            ->method('error')
            ->with("Your application doesn't have any routes matching the given criteria.");
        $this->prettyRoutesCommand->expects($this->once())->method('getRoutes')->willReturn([]);
        $this->prettyRoutesCommand->expects($this->never())->method('displayRoutes');

        $this->prettyRoutesCommand->handle();
    }

    /**
     * @test
     * @covers ::handle
     */
    function it_should_display_the_prettier_routes()
    {
        $routes = ['route1', 'route2'];
        $this->prettyRoutesCommand = $this->getMockedCommand(['error', 'displayRoutes', 'getRoutes']);

        $this->router->expects($this->once())->method('flushMiddlewareGroups');
        $this->router->expects($this->once())->method('getRoutes')->willReturn($routes);
        $this->prettyRoutesCommand->expects($this->once())->method('getRoutes')->willReturn($routes);
        $this->prettyRoutesCommand->expects($this->once())->method('displayRoutes')->with($routes);

        $this->prettyRoutesCommand->handle();
    }

    /**
     * @test
     * @covers ::getTerminalWidth
     */
    function it_should_compute_terminal_width_when_the_width_is_bigger_than_minimum_width()
    {
        $width = self::MINIMUM_TERMINAL_WIDTH + 10;

        $this->terminal->expects($this->once())->method('getWidth')->willReturn($width);

        $this->assertEquals($width, $this->invokeMethod($this->prettyRoutesCommand, 'getTerminalWidth'));
    }

    /**
     * @test
     * @covers ::getTerminalWidth
     */
    function it_should_compute_terminal_width_when_the_width_is_lesser_than_minimum_width()
    {
        $width = self::MINIMUM_TERMINAL_WIDTH - 10;

        $this->terminal->expects($this->once())->method('getWidth')->willReturn($width);

        $this->assertEquals(
            self::MINIMUM_TERMINAL_WIDTH,
            $this->invokeMethod($this->prettyRoutesCommand, 'getTerminalWidth')
        );
    }

    /**
     * @test
     * @covers ::getRoutes
     */
    function it_should_return_the_routes_as_a_displayable_format()
    {
        $firstRoute = $this->createMock(Route::class);
        $firstRouteInfo = ['method' => 'POST', 'uri' => '/first-route', 'name' => 'first-route'];
        $secondRoute = $this->createMock(Route::class);
        $secondRouteInfo = ['method' => 'GET', 'uri' => '/second-route', 'name' => 'second-route'];
        $this->prettyRoutesCommand = $this->getMockedCommand(['getRouteInformation', 'option']);

        $this->router->expects($this->once())->method('getRoutes')->willReturn([$firstRoute, $secondRoute]);
        $this->prettyRoutesCommand
            ->expects($this->exactly(2))
            ->method('getRouteInformation')
            ->withConsecutive([$firstRoute], [$secondRoute])
            ->willReturnOnConsecutiveCalls($firstRouteInfo, $secondRouteInfo);
        $this->prettyRoutesCommand
            ->expects($this->exactly(2))
            ->method('option')
            ->withConsecutive(['sort'], ['reverse'])
            ->willReturn(false);

        $this->assertEquals(
            [$firstRouteInfo, $secondRouteInfo],
            $this->invokeMethod($this->prettyRoutesCommand, 'getRoutes')
        );
    }

    /**
     * @test
     * @covers ::getRoutes
     */
    function it_should_return_the_sorted_routes_as_a_displayable_format()
    {
        $sortBy = 'uri';
        $firstRoute = $this->createMock(Route::class);
        $firstRouteInfo = ['method' => 'POST', 'uri' => '/first-route', 'name' => 'first-route'];
        $secondRoute = $this->createMock(Route::class);
        $secondRouteInfo = ['method' => 'GET', 'uri' => '/second-route', 'name' => 'second-route'];
        $this->prettyRoutesCommand = $this->getMockedCommand(['getRouteInformation', 'option', 'sortRoutes']);

        $this->router->expects($this->once())->method('getRoutes')->willReturn([$firstRoute, $secondRoute]);
        $this->prettyRoutesCommand
            ->expects($this->exactly(2))
            ->method('getRouteInformation')
            ->withConsecutive([$firstRoute], [$secondRoute])
            ->willReturnOnConsecutiveCalls($firstRouteInfo, $secondRouteInfo);
        $this->prettyRoutesCommand
            ->expects($this->exactly(2))
            ->method('option')
            ->withConsecutive(['sort'], ['reverse'])
            ->willReturnOnConsecutiveCalls($sortBy, false);
        $this->prettyRoutesCommand
            ->expects($this->once())
            ->method('sortRoutes')
            ->with($sortBy, [$firstRouteInfo, $secondRouteInfo])
            ->willReturn([$secondRouteInfo, $firstRouteInfo]);

        $this->assertEquals(
            [$secondRouteInfo, $firstRouteInfo],
            $this->invokeMethod($this->prettyRoutesCommand, 'getRoutes')
        );
    }

    /**
     * @test
     * @covers ::getRoutes
     */
    function it_should_return_the_reversed_sorted_routes_as_a_displayable_format()
    {
        $sortBy = 'uri';
        $firstRoute = $this->createMock(Route::class);
        $firstRouteInfo = ['method' => 'POST', 'uri' => '/first-route', 'name' => 'first-route-name'];
        $secondRoute = $this->createMock(Route::class);
        $secondRouteInfo = ['method' => 'GET', 'uri' => '/second-route', 'name' => 'second-route-name'];
        $this->prettyRoutesCommand = $this->getMockedCommand(['getRouteInformation', 'option', 'sortRoutes']);

        $this->router->expects($this->once())->method('getRoutes')->willReturn([$firstRoute, $secondRoute]);
        $this->prettyRoutesCommand
            ->expects($this->exactly(2))
            ->method('getRouteInformation')
            ->withConsecutive([$firstRoute], [$secondRoute])
            ->willReturnOnConsecutiveCalls($firstRouteInfo, $secondRouteInfo);
        $this->prettyRoutesCommand
            ->expects($this->exactly(2))
            ->method('option')
            ->withConsecutive(['sort'], ['reverse'])
            ->willReturnOnConsecutiveCalls($sortBy, true);
        $this->prettyRoutesCommand
            ->expects($this->once())
            ->method('sortRoutes')
            ->with($sortBy, [$firstRouteInfo, $secondRouteInfo])
            ->willReturn([$secondRouteInfo, $firstRouteInfo]);

        $this->assertEquals(
            array_reverse([$secondRouteInfo, $firstRouteInfo]),
            $this->invokeMethod($this->prettyRoutesCommand, 'getRoutes')
        );
    }

    /**
     * @test
     * @covers ::sortRoutes
     */
    function it_should_sort_routes()
    {
        $firstRouteInfo = ['method' => 'POST', 'uri' => '/b-first-route', 'name' => 'first-route-name'];
        $secondRouteInfo = ['method' => 'GET', 'uri' => '/a-second-route', 'name' => 'second-route-name'];

        $this->assertEquals(
            [1 => $secondRouteInfo, 0 => $firstRouteInfo],
            $this->invokeMethod($this->prettyRoutesCommand, 'sortRoutes', ['uri', [$firstRouteInfo, $secondRouteInfo]])
        );
    }

    /**
     * @test
     * @covers ::getRouteInformation
     * @covers ::filterRoute
     */
    function it_should_return_empty_array_when_it_has_method_option_and_there_is_not_route_matched()
    {
        $givenMethod = 'POST';
        $route = new Route(['GET'], '/example', ['TestController@index']);
        $this->prettyRoutesCommand = $this->getMockedCommand(['option']);

        $this->prettyRoutesCommand->expects($this->exactly(2))->method('option')->willReturn($givenMethod);

        $this->assertEquals([], $this->invokeMethod($this->prettyRoutesCommand, 'getRouteInformation', [$route]));
    }

    /**
     * @test
     * @covers ::getRouteInformation
     * @covers ::filterRoute
     */
    function it_should_return_empty_array_when_it_has_except_path_option_and_there_is_not_route_matched()
    {
        $givenUri = 'example';
        $route = new Route(['POST'], '/example', ['TestController@index']);
        $this->prettyRoutesCommand = $this->getMockedCommand(['option']);

        $this->prettyRoutesCommand
            ->expects($this->exactly(3))
            ->method('option')
            ->withConsecutive(['method'], ['except-path'], ['except-path'])
            ->willReturnOnConsecutiveCalls(false, $givenUri, $givenUri);

        $this->assertEquals([], $this->invokeMethod($this->prettyRoutesCommand, 'getRouteInformation', [$route]));
    }

    /**
     * @test
     * @covers ::getRouteInformation
     * @covers ::filterRoute
     */
    function it_should_return_empty_array_when_it_has_only_path_option_and_there_is_not_route_matched()
    {
        $givenPath = '/example';
        $route = new Route(['POST'], '/example', ['TestController@index']);
        $this->prettyRoutesCommand = $this->getMockedCommand(['option']);

        $this->prettyRoutesCommand
            ->expects($this->exactly(4))
            ->method('option')
            ->withConsecutive(['method'], ['except-path'], ['only-path'], ['only-path'])
            ->willReturnOnConsecutiveCalls(false, false, $givenPath, $givenPath);

        $this->assertEquals([], $this->invokeMethod($this->prettyRoutesCommand, 'getRouteInformation', [$route]));
    }

    /**
     * @test
     * @covers ::getRouteInformation
     * @covers ::filterRoute
     */
    function it_should_filter_route()
    {
        $route = new Route(['POST'], '/example', ['TestController@index']);
        $this->prettyRoutesCommand = $this->getMockedCommand(['option']);

        $this->prettyRoutesCommand
            ->expects($this->exactly(3))
            ->method('option')
            ->withConsecutive(['method'], ['except-path'], ['only-path'], ['only-path'])
            ->willReturnOnConsecutiveCalls(false, false, false);

        $this->assertEquals(
            [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri(),
                'name' => $route->getName(),
            ],
            $this->invokeMethod($this->prettyRoutesCommand, 'getRouteInformation', [$route])
        );
    }

    /**
     * @test
     * @covers ::displayRoutes
     * @dataProvider displayRouteProvider
     * @param string $color
     * @param array $route
     */
    function it_should_display_routes(string $color, array $route)
    {
        $output = $this->createMock(OutputStyle::class);
        $this->prettyRoutesCommand = $this->getMockedCommand(['getTerminalWidth']);
        $this->prettyRoutesCommand->setOutput($output);

        $this->prettyRoutesCommand
            ->expects($this->once())
            ->method('getTerminalWidth')
            ->willReturn(self::MINIMUM_TERMINAL_WIDTH);
        $output->expects($this->once())
            ->method('writeln')
            ->with(
                "  <fg=white;options=bold><fg={$color}>{$route['method']}</></>      <fg=white;options=bold>"
                . "{$route['uri']}</><fg=#6C7280>  </>{$route['name']}"
            );

        $this->invokeMethod($this->prettyRoutesCommand, 'displayRoutes', [[$route]]);
    }

    /**
     * @return array
     */
    public function displayRouteProvider(): array
    {
        return [
            ['green', ['method' => 'GET', 'uri' => '/example1', 'name' => 'example1']],
            ['default', ['method' => 'HEAD', 'uri' => '/example2', 'name' => 'example2']],
            ['default', ['method' => 'OPTIONS', 'uri' => '/example3', 'name' => 'example3']],
            ['magenta', ['method' => 'POST', 'uri' => '/example4', 'name' => 'example4']],
            ['yellow', ['method' => 'PUT', 'uri' => '/example5', 'name' => 'example5']],
            ['yellow', ['method' => 'PATCH', 'uri' => '/example6', 'name' => 'example6']],
            ['red', ['method' => 'DELETE', 'uri' => '/example7', 'name' => 'example7']],
            ['white', ['method' => 'UNKNOWN', 'uri' => '/unknown', 'name' => 'unknown']],
        ];
    }

    /**
     * @param array $methods
     * @return PrettyRoutesCommand|MockObject
     */
    private function getMockedCommand(array $methods = [])
    {
        return $this->getMockBuilder(PrettyRoutesCommand::class)
            ->setConstructorArgs([$this->router, $this->terminal])
            ->onlyMethods($methods)
            ->getMock();
    }
}
