<?php
/**
 * Router.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

namespace MiniMVC\Router;

use MiniMVC\Http\Request;
use MiniMVC\Loader\Loader;

class Router
{
    /**
     * @var Array $routeConfigs  The application's route configuration
     */
    private $routeConfigs;

    /**
     * @var MiniMVC\Http\Request $request  Al information about the request that we need
     */
    private $request;

    /**
     * Retrieve the route configuration and instatiate the request
     */
    function __construct(Request $request)
    {
        $this->routeConfigs = array_merge(require DOC_ROOT.'/App/routes.php', require DOC_ROOT.'/MiniMVC/routes.php');
        $this->request = $request;
    }

    /**
     * Check each route config against the request URI. If a match is found,
     * resolve the action if it is dynamic, make sure all required route segments
     * are present in the request URI, and then set any path vars to $_GET. If
     * a match is found, return the route, other wise return the 404 route.
     *
     * @return MiniMVC\Router\Route $route  The matching route to be loaded
     */
    public function resolveRoute()
    {
        $routeMatch = false;
        foreach ($this->routeConfigs as $name => $routeConfig)
        {
            $route = new Route($routeConfig, $this->request);
            if ($this->request->method == $route->requestMethod)
            {
                if ($route->segments[0] == $this->request->segments[0])
                {
                    // Possible match found, check for dynamic action
                    $route->resolveAction($this->request);
                    // Check for any extra segments in the request, or any missing segments.
                    // If there are missing segments, check they are not required
                    if ($route->totalSegments != $this->request->totalSegments)
                    {
                        $diff = $route->totalSegments - $this->request->totalSegments;
                        // If there are more request segments than the route allows, skip
                        if ($diff < 0) continue;
                        // Check if the extra segment(s) are required path vars, loop through extra segments
                        $skip = false;
                        for ($i = $route->totalSegments - 1; $i >= $route->totalSegments - $diff; $i--)
                        {
                            if (substr($route->segments[$i], 0, 1) != '(' && substr($route->segments[$i],-1, 1) != ')')
                            {
                                // The path var is required and not present
                                $skip = true;
                                break;
                            }
                        }
                        if ($skip) continue;
                    }
                    // Set any path vars to $_GET
                    if (isset($route->pathVars))
                    {
                        foreach ($route->pathVars as $index => $value)
                        {
                            if (isset($this->request->segments[$value]))
                            {
                                $this->request->paramVars[$index] = $this->request->segments[$value];
                            }
                            else
                            {
                                throw new \Exception('Path segment is missing, but should be there...');
                            }
                        }
                    }
                    $routeMatch = $route;
                    break;
                }
            }
        }
        // If a match is not found, return the 404 route
        if (!$routeMatch)
        {
            $route = new Route($this->routeConfigs['error404'], $this->request);
        }
        return $route;
    }
}
