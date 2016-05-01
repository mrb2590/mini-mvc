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
     * @var String $controller  The controller which called the View
     */
    private $controller;

    /**
     * @var String $action  The controller's action
     */
    private $action;

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
        $parts = explode('\\', $this->route['controller']);
        $controller = array_pop($parts);
        $this->controller = strtolower(str_replace('Controller', '', $controller));
        $this->action = $this->route['action'];
        // Check if an underscore is used for an action that starts with digits (404Action)
        if (strpos($this->action, '_') === 0)
        {
            $this->action = ltrim($this->route['action'], '_');
        }
        require DOC_ROOT.'/view/'.$route['layout'].'.phtml';
    }

    /**
     * Include the view in the layout
     */
    public function content()
    {
        require DOC_ROOT.'/view/'.$this->controller.'/'.$this->action.'.phtml';
    }
}
