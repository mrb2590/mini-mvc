<?php
/**
 * bootstrap.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

/**
 * Turn on error reporting if in a development environment
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
 * Call upon our dear router the to guide our request
 */
try
{
    $router = new MiniMVC\Router\Router();
    $router->resolveRoute();
}
catch (Exception $e)
{
    $router->load(array(
        'controller' => 'MiniMVC\Controller\ErrorController',
        'action'     => 'index',
        'layout'     => 'layout/layout'
    ));
}
