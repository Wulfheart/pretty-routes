<?php

namespace Wulfheart\PrettyRoutes\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Console\Terminal;

class PrettyRoutesCommand extends Command
{
    public $signature = 'route:pretty
    {--sort=uri}
    {--except-path=}
    {--only-path=}
    {--method=}
    {--reverse}
    ';

    public $description = 'List all registered routes in a pretty format';


    /**
     * The current terminal width.
     *
     * @var int|null
     */
    protected $terminalWidth;

    /**
     * Computes the terminal width.
     *
     * @return int
     */
    protected function getTerminalWidth()
    {
        if ($this->terminalWidth == null) {
            $this->terminalWidth = (new Terminal())->getWidth();

            $this->terminalWidth = $this->terminalWidth >= 30
                ? $this->terminalWidth
                : 30;
        }

        return $this->terminalWidth;
    }

    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->router->flushMiddlewareGroups();

        if (empty($this->router->getRoutes())) {
            return $this->error("Your application doesn't have any routes.");
        }

        if (empty($routes = $this->getRoutes())) {
            return $this->error("Your application doesn't have any routes matching the given criteria.");
        }

        $this->displayRoutes($routes);
    }

    /**
     * Compile the routes into a displayable format.
     *
     * @return array
     */
    protected function getRoutes()
    {
        $routes = collect($this->router->getRoutes())->map(function ($route) {
            return $this->getRouteInformation($route);
        })->filter()->all();

        if ($sort = $this->option('sort')) {
            $routes = $this->sortRoutes($sort, $routes);
        }

        if ($this->option('reverse')) {
            $routes = array_reverse($routes);
        }

        return $routes;
        //        return $this->pluckColumns($routes);
    }

    /**
     * Get the route information for a given route.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return array
     */
    protected function getRouteInformation(Route $route)
    {
        return $this->filterRoute([
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
        ]);
    }

    /**
     * Sort the routes by a given element.
     *
     * @param  string  $sort
     * @param  array  $routes
     * @return array
     */
    protected function sortRoutes($sort, array $routes)
    {
        return Arr::sort($routes, function ($route) use ($sort) {
            return $route[$sort];
        });
    }

    /**
     * Filter the route by URI and / or name.
     *
     * @param  array  $route
     * @return array|null
     */
    protected function filterRoute(array $route)
    {
        if ($this->option('method') && ! Str::contains($route['method'], strtoupper($this->option('method')))) {
            return;
        }

        if ($this->option('except-path')) {
            foreach (explode(',', $this->option('except-path')) as $path) {
                if (Str::contains($route['uri'], $path)) {
                    return;
                }
            }
        }

        if ($this->option('only-path')) {
            foreach (explode(',', $this->option('only-path')) as $path) {
                if (! Str::contains($route['uri'], $path)) {
                    return;
                }
            }
        }

        return $route;
    }

    protected function displayRoutes(array $routes)
    {
        $terminalWidth = $this->getTerminalWidth();

        $maxMethod = strlen(collect($routes)->max('method'));

        foreach ($routes as $route) {
            $method = $route["method"];
            $uri = $route["uri"];
            $name = $route["name"];

            $spaces = str_repeat(' ', max($maxMethod + 6 - strlen($method), 0));

            $additionalSpace = ! is_null($name) ? 1 : 0;
            $dots = str_repeat('.', max($terminalWidth - strlen($method.$uri.$name) - strlen($spaces) - 14 - $additionalSpace, 0));

            $method = implode('|', array_map(function ($m) {
                // ['GET' => 'success', 'HEAD' => 'default', 'OPTIONS' => 'default', 'POST' => 'primary', 'PUT' => 'warning', 'PATCH' => 'info', 'DELETE' => 'danger']

                $color = match ($m) {
                    'GET' => 'green',
                    'HEAD' => 'default',
                    'OPTIONS' => 'default',
                    'POST' => 'magenta',
                    'PUT' => 'yellow',
                    'PATCH' => 'yellow',
                    'DELETE' => 'red',
                    default => 'white',
                };

                return sprintf("<fg=%s>%s</>", $color, $m);
            }, explode('|', $method)));

            $this->output->writeln(sprintf(
                '  <fg=white;options=bold>%s</>%s<fg=white;options=bold>%s</><fg=#6C7280> %s </>%s',
                $method,
                $spaces,
                preg_replace('#({[^}]+})#', '<comment>$1</comment>', $uri),
                $dots,
                $name,
            ));
        }
    }
}
