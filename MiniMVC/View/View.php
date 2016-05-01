<?php
/**
 * View.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

namespace MiniMVC\View;

class View
{
    /**
     * @var Array $vars  Any variables returned by the controller to be used in the view
     */
    public $vars;

    /**
     * @var Array $route  The matching route configuration with resolved dynamic action
     */
    private $route;

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
     * @var Array $route  The matching route configuration with resolved dynamic action
     */
    public function render($route)
    {
        $this->route = $route;
        require DOC_ROOT.'/view/layout/layout.php';
    }

    /**
     * Include the view into the layout by parsing the controller name to build the view's path
     */
    public function content()
    {
        $parts = explode('\\', $this->route['controller']);
        $controller = array_pop($parts);
        $controller = strtolower(str_replace('Controller', '', $controller));
        require DOC_ROOT.'/view/'.$controller.'/'.$this->route['action'].'.php';
    }
}
