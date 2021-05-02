<?php


namespace Wulfheart\PrettyRoutes\Tests;

use Illuminate\Support\Facades\Artisan;
use Spatie\Snapshots\MatchesSnapshots;

class SnapshotTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function basic_output()
    {
        Artisan::call('route:pretty');

        $this->assertMatchesSnapshot(Artisan::output());
    }
}
