<?php

namespace App\Controller;

use MiniMVC\View\View;

class AboutController
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
        var_dump($_GET);
        $frogs = 'frogs';
        return new View(array(
            'frogs' => $frogs,
        ));
    }
}
