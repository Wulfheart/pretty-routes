<?php

namespace Wulfheart\PrettyRoutes\Commands;

class LumenPrettyRoutesCommand extends PrettyRoutesCommand
{
    /**
     * Get the route information for a given route.
     *
     * @param $route
     *
     * @return array|null
     */
    protected function getRouteInformation($route): ?array
    {
        return $this->filterRoute([
            'method' => $route['method'],
            'uri' => $route['uri'],
            'name' => $route['action']['name'] ?? null,
            'middlewares' => $route['action']['middleware'] ?? [],
        ]);
    }
}
