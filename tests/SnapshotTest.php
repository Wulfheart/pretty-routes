<?php


namespace Wulfheart\PrettyRoutes\Tests;

use Illuminate\Support\Facades\Artisan;
use Spatie\Snapshots\MatchesSnapshots;

final class SnapshotTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @test
     *
     * These are not complete but should do the trick.
     *
     * @dataProvider cliDataProvider
     */
    public function basic_snapshot_tests(string $command): void
    {
        Artisan::call($command);

        $this->assertMatchesSnapshot(Artisan::output());
    }

    public function cliDataProvider()
    {
        $groups = ['', 'path', 'name'];

        $commands = [
            'basic_output' => '',
            'only-name' => '--only-name=fire.',
            'only-path' => '--only-path=fire.',
            'except-name' => '--except-name=fire.',
            'except-path' => '--except-path=fire.',
            'except-name_except-path' => '--except-name=.admin --except-path=fire',
            'except-name_only-path' => '--except-name=.admin --only-path=user',
            'only-path-multiple' => '--only-path=fire,water',
        ];

        $data = [];
        foreach ($groups as $group) {
            foreach ($commands as $description => $baseCommand) {
                $fullDescription = sprintf("group_%s-%s",  empty($group) ? 'none' : $group, $description);
                $fullCommand = sprintf("%s %s", $baseCommand, empty($group) ? '' : sprintf('--group=%s', $group));
                $data[$fullDescription][] = 'route:pretty ' . $fullCommand;
            }
        }

        return $data;
    }
}
