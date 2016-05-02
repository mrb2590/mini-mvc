<?php
/**
 * ErrorController.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

namespace MiniMVC\Controller;

use MiniMVC\View\View;

class ErrorController
{

    /**
     * @return MiniMVC\View\View  The view to be rendered
     */
    public function indexAction()
    {
        return new View();
    }

    /**
     * @return MiniMVC\View\View  The view to be rendered
     */
    public function _404Action()
    {
        header("HTTP/1.0 404 Not Found");
        return new View();
    }
}
