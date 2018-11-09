<?php

namespace Libraries\Router;

use Libraries\Request\Request;

class ControllerHandler
{
    /**
     * Controllers path
     * 
     * @var string
     */
    private $controllersPath = "\\App\\Controllers\\";

    /**
     * Execute controller
     * 
     * @return void
     */
    protected function executeController($callback, $params)
    {
        $controller = $callback['controller'];
        $method = $callback['method'];

        $instanceString = $this->controllersPath.$controller;
        $instance = new $instanceString();

        if (! method_exists($instance, $method))
            throw new \Exception("Controller does not exists");
            
        if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'PATCH', 'DELETE']))
            array_unshift($params, new Request);

        return call_user_func_array([$instance, $method], $params);
    }
}