<?php

namespace Wulfheart\PrettyRoutes;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wulfheart\PrettyRoutes\PrettyRoutes
 */
class PrettyRoutesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pretty_routes';
    }
}
