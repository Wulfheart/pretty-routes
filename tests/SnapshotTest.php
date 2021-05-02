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
     * @dataProvider cliDataProvider
     */
    public function basic_output(string $command): void
    {
        Artisan::call($command);

        $this->assertMatchesSnapshot(Artisan::output());
    }

    public function cliDataProvider()
    {
        $groups = ['', 'path', 'name'];

        $commands = [
            'basic_output' => 'route:pretty',
            'only-name' => 'route:pretty --only-name=fire.',
            'only-path' => 'route:pretty --only-path=fire.',
            'except-name' => 'route:pretty --except-name=fire.',
            'except-path' => 'route:pretty --except-path=fire.',
        ];

        $data = [];
        foreach ($groups as $group) {
            foreach ($commands as $description => $baseCommand) {
                $fullDescription = sprintf("group_%s-%s",  empty($group) ? 'none' : $group, $description);
                $fullCommand = sprintf("%s %s", $baseCommand, empty($group) ? '' : sprintf('--group=%s', $group));
                $data[$fullDescription][] = $fullCommand;
            }
        }

        return $data;
    }

//    /** @test */
//    public function only_name(): void
//    {
//        Artisan::call('route:pretty --only-name=test.');
//
//        $this->assertMatchesSnapshot(Artisan::output());
//    }
//
//    /** @test */
//    public function except_name(): void
//    {
//        Artisan::call('route:pretty --except-name=test.');
//
//        $this->assertMatchesSnapshot(Artisan::output());
//    }
//
//    /** @test */
//    public function except_name_and_only_name(): void
//    {
//        Artisan::call('route:pretty --except-name=test.store --only-name=test.');
//
//        $this->assertMatchesSnapshot(Artisan::output());
//    }
}
