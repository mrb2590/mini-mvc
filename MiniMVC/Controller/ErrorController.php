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
    public function indexAction()
    {
        return new View();
    }

    public function _404Action()
    {
        header("HTTP/1.0 404 Not Found");
        return new View();
    }
}
