<?php

namespace App\Controller;

use MiniMVC\View\View;

class HomeController
{
    public function indexAction()
    {
        $test = 'test';
        return new View(array(
            'test' => $test,
        ));
    }
}
