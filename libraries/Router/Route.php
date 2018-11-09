<?php

namespace Libraries\Router;

use Libraries\Router\RouteRegister;
use Libraries\Router\RouteDispatcher;

class Route extends RouteRegister
{
    /**
     * Extend prefix
     * 
     * @var string
     */
    private $prefix = '';

    /**
     * Register route with get method
     * 
     * @return void
     */
    public function get($route, $callback)
    {
        parent::addRoute('GET', $this->prefix.$route, $callback);
    }
    /**
     * Register route with post method
     * 
     * @return void
     */
    public function post($route, $callback)
    {
        parent::addRoute('POST', $this->prefix.$route, $callback);
    }
    /**
     * Register route with put method
     * 
     * @return void
     */
    public function put($route, $callback)
    {
        parent::addRoute('PUT', $this->prefix.$route, $callback);
    }
    /**
     * Register route with patch method
     * 
     * @return void
     */
    public function patch($route, $callback)
    {
        parent::addRoute('PATCH', $this->prefix.$route, $callback);
    }
    /**
     * Register route with options method
     * 
     * @return void
     */
    public function options($route, $callback)
    {
        
    }
    /**
     * Register route with delete method
     * 
     * @return void
     */
    public function delete($route, $callback)
    {
        parent::addRoute('DELETE', $route, $callback);
    }

    /**
     * Riouting group
     * 
     * @return void
     */
    public function group($config, $callback)
    {
        if (array_key_exists('prefix', $config))
            $this->prefix = '/'.trim($config['prefix']);
        
        call_user_func($callback);

        $this->prefix = '';
    }

    /**
     * Dispatch
     * 
     * @return void
     */
    public function dispatch()
    {
        $routerDispatcher = new RouterDispatcher();
        $routerDispatcher->dispatch(parent::getRoutes());
    }
}