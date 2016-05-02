<?php
/**
 * Controller.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

namespace MiniMVC\Controller;

class Controller
{

    /**
     * @var Array $postVars  Any POST variables
     */
    public $postVars;

    /**
     * @var Array $getVars  Any GET variables
     */
    public $getVars;

    /**
     * @var Array $paramVars  Any variables fromt he request URI
     */
    public $paramVars;

    /**
     * Constructor
     */
    function __construct()
    {
        $this->postVars = $_POST;
        $this->getVars = $_GET;
        $this->paramVars = array();
    }
}
