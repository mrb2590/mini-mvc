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
        $frogs = 'frogs';
        return new View(array(
            'frogs' => $frogs,
        ));
    }
}
