<?php

namespace App\Controller;

use MiniMVC\Controller\Controller;
use MiniMVC\View\View;

class HomeController extends Controller
{
    public function indexAction()
    {
        $test = var_export($this->getVars, true);
        return new View(array(
            'test' => $test,
        ));
    }
}
