<?php

namespace Wulfheart\PrettyRoutes\Commands;

use Illuminate\Console\Command;

class PrettyRoutesCommand extends Command
{
    public $signature = 'pretty_routes';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
