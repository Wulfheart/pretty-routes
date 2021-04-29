<?php

namespace Wulfheart\PrettyRoutes\Tests\Unit;

use Spatie\LaravelPackageTools\Package;
use Wulfheart\PrettyRoutes\Tests\TestCase;
use Wulfheart\PrettyRoutes\PrettyRoutesServiceProvider;
use Wulfheart\PrettyRoutes\Commands\PrettyRoutesCommand;

/**
 * Class PrettyRoutesServiceProviderTest
 * @package Wulfheart\PrettyRoutes\Tests\Unit
 * @coversDefaultClass \Wulfheart\PrettyRoutes\PrettyRoutesServiceProvider
 */
class PrettyRoutesServiceProviderTest extends TestCase
{
    /**
     * @test
     * @covers ::configurePackage
     */
    function it_should_configure_package()
    {
        $package = $this->createMock(Package::class);
        $provider = $this->getMockBuilder(PrettyRoutesServiceProvider::class)
            ->disableOriginalConstructor()
            ->onlyMethods([])
            ->getMock();

        $package->expects($this->once())->method('name')->with('pretty_routes')->willReturnSelf();
        $package->expects($this->once())->method('hasCommand')->with(PrettyRoutesCommand::class);

        $provider->configurePackage($package);
    }
}
