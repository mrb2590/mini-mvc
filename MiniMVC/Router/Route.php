<?php
/**
 * Route.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

namespace MiniMVC\Router;

use MiniMVC\Http\Request;

class Route
{
    /**
     * @var Array $routeConfig  The matched route configuration
     */
    private $routeConfig;
    /**
     * @var MiniMVC\Http\Request $request  The request
     */
    public $request;

    /**
     * @var String $controllerNamespace  The full name of the controller including namespace
     */
    public $controllerNamespace;

    /**
     * @var String $controller  The name of the contorller without the namespace
     */
    public $controller;

    /**
     * @var String $action  The action to call
     */
    public $action;

    /**
     * @var String $defaultAction  The default action if none is passed in the URI
     */
    public $defaultAction;

    /**
     * @var Array $segments  The segments of the route path
     */
    public $segments;

    /**
     * @var Integer $totalSegments  The total number of segments of the route path
     */
    public $totalSegments;

    /**
     * @var String $requestMethod  The excpected request method
     */
    public $requestMethod;

    /**
     * @var Array $pathVars  Any path variables from the route configuration
     */
    public $pathVars;

    /**
     * @var String $layout  The layout to render for this route
     */
    public $layout;

    /**
     * Constructor
     */
    function __construct($routeConfig, Request $request)
    {
        $this->routeConfig = $routeConfig;
        $this->request = $request;
        $this->controllerNamespace = $routeConfig['controller'];
        // parse controller name to get the short name
        $parts = explode('\\', $routeConfig['controller']);
        $name = array_pop($parts);
        $this->controller = str_replace('Controller', '', $name);
        $this->action = $routeConfig['action'];
        $this->defaultAction = (isset($routeConfig['default-action'])) ? $routeConfig['default-action'] : null;
        $this->segments =  explode('/', trim($routeConfig['path'], '/'));
        $this->totalSegments = count($this->segments);
        $this->requestMethod = $routeConfig['method'];
        $this->pathVars = (isset($routeConfig['path-vars'])) ? $routeConfig['path-vars'] : null;
        $this->layout = $routeConfig['layout'];
    }

    /**
     * If the path configuration's action is dynamic, find out which
     * action to call. Set this as the action.
     *
     * @param MiniMVC\Http\Request $request  The request to pull the action from
     */
    public function resolveAction(Request $request)
    {
        if ($this->action == '?')
        {
            // Look for the action keyword in the route
            foreach ($this->segments as $index => $segment)
            {
                if ($segment == '($action)' || $segment == '$action')
                {
                    if (isset($request->segments[$index]))
                    {
                        $this->action = $request->segments[$index];
                    }
                    else
                    {
                        $this->action = $this->defaultAction;
                    }
                    break;
                }
                elseif ($segment === end($this->segments))
                {
                    throw new \Exception('No action specified');
                }
            }
        }
    }
}
