<?php
/**
 * View.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

namespace MiniMVC\View;

use MiniMVC\Router\Route;

class View
{
    /**
     * @var Array $vars  Any variables returned by the controller to be used in the view
     */
    public $vars;

    /**
     * @var MiniMVC\Router\Route $route  The matching route configuration with resolved dynamic action
     */
    public $route;

    /**
     * Constructor
     */
    function __construct($vars = array())
    {
        $this->vars = $vars;
    }

    /**
     * Render the view.
     * 
     * @var MiniMVC\Router\Route $route  The matching route configuration with resolved dynamic action
     */
    public function render(Route $route)
    {
        $this->route = $route;
        require DOC_ROOT.'/view/'.$this->route->layout.'.phtml';
    }

    /**
     * Include the action's view in the layout
     */
    public function content()
    {
        // Convert camelcase to snakecase
        $actionFile = $this->camelToSnake($this->route->action);
        require DOC_ROOT.'/view/'.strtolower($this->route->controller).'/'.ltrim($actionFile, '_').'.phtml';
    }

    /**
     * Converts camelCase to snake_case
     */
    public function camelToSnake($string)
    {
        return strtolower(
            preg_replace(
                ["/([A-Z]+)/", "/_([A-Z]+)([A-Z][a-z])/"], 
                ["_$1", "_$1_$2"], 
                lcfirst($string)
            )
        );
    }
}
