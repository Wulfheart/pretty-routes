<?php


namespace Wulfheart\PrettyRoutes\Tests;

use Illuminate\Support\Facades\Artisan;
use Spatie\Snapshots\MatchesSnapshots;

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
    public function only_name(): void
    {
        Artisan::call('route:pretty --only-name=test.');

        $this->assertMatchesSnapshot(Artisan::output());
    }

    /** @test */
    public function except_name(): void
    {
        Artisan::call('route:pretty --except-name=test.');

        $this->assertMatchesSnapshot(Artisan::output());
    }

    /** @test */
    public function except_name_and_only_name(): void
    {
        Artisan::call('route:pretty --except-name=test.store --only-name=test.');

        $this->assertMatchesSnapshot(Artisan::output());
    }
}