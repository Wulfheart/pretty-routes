<?php

namespace Wulfheart\PrettyRoutes\Tests\Laravel;

use Illuminate\Support\Facades\Artisan;
use Spatie\Snapshots\MatchesSnapshots;
use Wulfheart\PrettyRoutes\Tests\TestCase;

final class SnapshotTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function basic_output(): void
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
