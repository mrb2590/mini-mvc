<?php

namespace App\Controller;

use MiniMVC\Controller\Controller;
use MiniMVC\View\View;

class AboutController extends Controller
{
    public function indexAction()
    {
        $test = 'test';
        return new View(array(
            'test' => $test,
        ));
    }

    public function frogsAction()
    {
        $frogs = var_export($this->paramVars, true);
        return new View(array(
            'frogs' => $frogs,
        ));
    }
}
