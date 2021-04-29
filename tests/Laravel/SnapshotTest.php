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

    /** @test */
    public function filter_by_method(): void
    {
        Artisan::call('route:pretty --method=POST');

        $this->assertMatchesSnapshot(Artisan::output());
    }

    /** @test */
    public function filter_by_except_path(): void
    {
        Artisan::call('route:pretty --except-path=test');

        $this->assertMatchesSnapshot(Artisan::output());

        Artisan::call('route:pretty --except-path=test,some');

        $this->assertMatchesSnapshot(Artisan::output());
    }

    /** @test */
    public function filter_by_only_path(): void
    {
        Artisan::call('route:pretty --only-path=admin');

        $this->assertMatchesSnapshot(Artisan::output());

        Artisan::call('route:pretty --only-path=admin,some');

        $this->assertMatchesSnapshot(Artisan::output());
    }
}
