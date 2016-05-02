<?php
/**
 * bootstrap.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

/**
 * Turn on error reporting the app is in a development environment
 */
if ($_SERVER['APP_ENV'] == 'development')
{
    error_reporting(E_ALL);
    ini_set('display_errors', true);
}

/**
 * Define any global constants
 */
define("DOC_ROOT", realpath(__DIR__.'/../'));

/**
 * Use Composer's autoloader
 */
require DOC_ROOT . '/vendor/autoload.php';

/**
 * The Router will compare the request URI with the paths in the
 * routes configuration file. If a match is found the Router will return
 * route object containing the information about which controller to load
 * and action to call. The Route is then passed to the Loader. The Loader 
 * will then instantiate the corresponding controller then call the
 * corresponding action. The controller's action will return a View object,
 * and the view object's render function is then called.
 *
 * If any exceptions are thrown, they are caught here. The route configuration
 * for errors is directly accessed and loaded.
 */
try
{
    $request = new MiniMVC\Http\Request();
    $router = new MiniMVC\Router\Router($request);
    $route = $router->resolveRoute();
    MiniMVC\Loader\Loader::load($route);
}
catch (Exception $e)
{
    $errorPathConfig = require 'routes.php';
    $route = new MiniMvc\Router\Route($errorPathConfig['errorIndex'], $request);
    MiniMVC\Loader\Loader::load($route, array('exception' => $e));
}
