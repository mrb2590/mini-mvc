<?php
/**
 * Loader.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

namespace MiniMVC\Loader;

use MiniMVC\Router\Route;

class Loader
{
    /**
     * Determines if the action exists for the controller and if so will instantiate the controller,
     * and the view, then render the view. If the action does not exist, then load the 404 route.
     *
     * @param MiniMVC\Router\Route $route  The route configuration to load from
     * @param Array $additionalParameters  Any addtional parameters to be merged with the view's vars
     */
    public static function load(Route $route, $additionalParameters = array())
    {
        $controller = new $route->controllerNamespace();
        $controller->getVars = $route->request->getVars;
        $controller->postVars = $route->request->postVars;
        $controller->paramVars = $route->request->paramVars;
        $action = $route->action.'Action';
        if (method_exists($controller, $action))
        {
            $view = $controller->$action();
            if (!empty($additionalParameters))
            {
                foreach ($additionalParameters as $name => $value)
                {
                    $view->vars[$name] = $value;
                }
            }
            $view->render($route);
        }
        else
        {
            $errorPathConfig = require DOC_ROOT.'/MiniMVC/routes.php';
            $route = new Route($errorPathConfig['error404'], $route->request);
            self::load($route);
        }
    }
}
