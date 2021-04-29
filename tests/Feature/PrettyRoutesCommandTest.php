<?php

namespace Wulfheart\PrettyRoutes\Tests\Feature;

use Spatie\Snapshots\MatchesSnapshots;
use Illuminate\Support\Facades\Artisan;
use Wulfheart\PrettyRoutes\Tests\TestCase;

/**
 * Class PrettyRoutesCommandTest
 * @package Wulfheart\PrettyRoutes\Tests\Feature
 * @coversDefaultClass \Wulfheart\PrettyRoutes\Commands\PrettyRoutesCommand
 */
class PrettyRoutesCommandTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function basic_output()
    {
        Artisan::call('route:pretty');

        $this->assertMatchesSnapshot(Artisan::output());
    }

    /** @test */
    public function ansi_output(): void
    {
        Artisan::call('route:pretty --ansi');

        $this->assertMatchesSnapshot(Artisan::output());
    }
}
