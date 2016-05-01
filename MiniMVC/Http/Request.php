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
    public $parts;
    public $segments;
    public $totalSegments;

    function __construct()
    {
        $this->parts = parse_url($_SERVER['REQUEST_URI']);
        $this->segments = explode('/', trim($this->parts['path'], '/'));
        $this->totalSegments = count($this->segments);
    }
}
