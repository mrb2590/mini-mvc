<?php
/**
 * Request.php
 * 
 * MiniMVC
 * 
 * @author Mike Buonomo <mrb2590@gmail.com>
 */

namespace MiniMVC\Http;

class Request
{
    /**
     * @var Array $parts  The parsed request URI
     */
    public $parts;

    /**
     * @var Array $segments  The segments of the request URI path
     */
    public $segments;

    /**
     * @var Integer $totalSegments  The total number of segments
     */
    public $totalSegments;

    /**
     * @var String $method  The request method
     */
    public $method;

    /**
     * @var Array $headers  All request headers sent
     */
    public $headers;

    /**
     * @var Array $postVars  Any POST variables
     */
    public $postVars;

    /**
     * @var Array $getVars  Any GET variables
     */
    public $getVars;

    /**
     * @var Array $paramVars  Any variables passed via URI
     */
    public $paramVars;

    /**
     * Constructor
     */
    function __construct()
    {
        $this->parts = parse_url($_SERVER['REQUEST_URI']);
        $this->segments = explode('/', trim($this->parts['path'], '/'));
        $this->totalSegments = count($this->segments);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders();
        $this->postVars = $_POST;
        $this->getVars = $_GET;
        $this->paramVars = array();
    }
}
