<?php
/**
 * Router.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

namespace MiniMVC\Router;

class Router
{
    /**
     * @var Array $routes  The application's route configuration from routes.php
     */
    private $routes;

    /**
     * @var Array $request  The parsed request URI path
     */
    private $request;

    /**
     * Retrieve the route configuration and parse the request URI
     */
    function __construct()
    {
        $this->routes = require DOC_ROOT.'/App/routes.php';
        $this->request = parse_url($_SERVER['REQUEST_URI']);
    }

    /**
     * Check each route config against the request URI. If a match is found,
     * load the controller, and set any path variables into $_GET
     */
    public function resolveRoute()
    {
        $routeMatch = false;
        foreach ($this->routes as $name => $route)
        {
            if ($_SERVER['REQUEST_METHOD'] == $route['method'])
            {
                $routeSegs = explode('/', trim($route['path'], '/'));
                $requestSegs = explode('/', trim($this->request['path'], '/'));
                if ($routeSegs[0] == $requestSegs[0])
                {
                    // Match found
                    // Check for dynamic action
                    if ($route['action'] == '?')
                    {
                        // Look for the action keyword in the route
                        foreach ($routeSegs as $index => $routeSeg)
                        {
                            if ($routeSeg == '($action)')
                            {
                                if (isset($requestSegs[$index]))
                                {
                                    $route['action'] = $requestSegs[$index];
                                }
                                else
                                {
                                    $route['action'] = $route['default-action'];
                                }
                                break;
                            } elseif ($routeSeg === end($routeSegs)) {
                                throw new \Exception('No action specified');
                            }
                        }
                    }
                    // Check for any extra segments in the request, or any missing segments.
                    // If there are missing segments, check they are not required
                    $totalRouteSegs = count($routeSegs);
                    $totalRequestSegs = count($requestSegs);
                    if ($totalRouteSegs != $totalRequestSegs)
                    {
                        $diff = $totalRouteSegs - $totalRequestSegs;
                        // If there are more request segments than the route allows, skip
                        if ($diff < 0) continue;
                        // Check if the extra segment(s) are required path vars, loop thru extra segments
                        $skip = false;
                        for ($i = $totalRouteSegs - 1; $i >= $totalRouteSegs - $diff; $i--)
                        {
                            if (substr($routeSegs[$i], 0, 1) != '(' && substr($routeSegs[$i],-1, 1) != ')')
                            {
                                // The path var is required and not present
                                $skip = true;
                                break;
                            }
                        }
                        // A path var is required and not present
                        if ($skip) continue;
                    }
                    // Set any path vars to $_GET
                    if (isset($route['path-vars']))
                    {
                        foreach ($route['path-vars'] as $index => $value)
                        {
                            $_GET[$index] = (isset($requestSegs[$value])) ? $requestSegs[$value] : null;
                        }
                    }
                    $routeMatch = $this->load($route);
                    break;
                }
            }
        }
        if (!$routeMatch)
        {
            $this->load(array(
                'controller' => 'MiniMVC\Controller\ErrorController',
                'action'     => '_404',
                'layout'     => 'layout/layout'
            ));
        }
    }

    /**
     * Determines if the action exists for the controller and if so will instantiate the controller,
     * and the view, then render the view, and return true. Otherwise, return false
     *
     * @param Array $route  The found route configuration
     * @return Bool  True if the controller action exists, false otherwise
     */
    public function load($route)
    {
        $controller = new $route['controller']();
        $action = $route['action'].'Action';
        if (method_exists($controller, $action))
        {
            $view = $controller->$action();
            $view->render($route);
            $exists = true;
        }
        else
        {
            $exists = false;
        }
        return $exists;
    }
}
