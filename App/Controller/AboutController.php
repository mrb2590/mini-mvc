<?php

namespace App\Controller;

use MiniMVC\Controller\Controller;
use MiniMVC\View\View;

class AboutController extends Controller
{
    public function indexAction()
    {
        return new View();
    }

    public function varsAction()
    {
        return new View(array(
            'getVars' => $this->getVars,
            'postVars' => $this->postVars,
            'paramVars' => $this->paramVars,
        ));
    }
}
