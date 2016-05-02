<?php
/**
 * routes.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */


/**
 * Define all application routes here
 *
 * To dynamically call a controller's action, set 'action' => '?',
 * and set 'path' => '/controller/$action/...'
 *
 * To dynamically include variables, use $
 * Example: 'path' => '/home/$/'
 * 
 * To set a path segment as optional, wrap it in ()
 * Example: /home/($)/
 *
 * Path variables will be set in $_GET, define an array of path variables
 * called 'path-vars'. The index of each will be the varibale's name, and the
 * value will be the segment number (starting with 1 not 0). 
 * Example:
 *                 /blog/comment/($)/
 *                   1      2     3
 *
 *                'path-vars' => array(
 *                    'comment_id' => 3
 *                ),
 *
 */
return array(
    'error404' => array(
        'path'       => '',
        'method'     => 'GET',
        'controller' => 'MiniMVC\Controller\ErrorController',
        'action'     => '_404',
        'layout'     => 'layout/layout',
    ),
    'errorIndex' => array(
        'path'       => '',
        'method'     => 'GET',
        'controller' => 'MiniMVC\Controller\ErrorController',
        'action'     => 'index',
        'layout'     => 'layout/layout'
    ),
);
