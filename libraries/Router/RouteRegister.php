<?php

namespace Libraries\Router;

const NUMERIC_PATTERN = '[0-9]+';
const ALPHA_PATTERN = '[a-zA-Z]+';
const ANY_PATTERN = '[^/]+';
const PARAM_ANY_PATTERN = '/\{[a-zA-Z0-9]+\}/';
const PARAM_NUMERIC_PATTERN = '/\{num\:[a-zA-Z0-9]+\}/';
const OPTIONAL_PARAM_PATTERN = '/\{\?[a-zA-Z0-9]+\}/';
const CALLBACK_PATTERN = '/[a-z0-9]+\@[a-z0-9]+/';
const INDEX_ALIAS = '****index****';

class RouteRegister
{

    /**
     * Registered routes
     * 
     * @var array
     */
    protected $routes;

    /**
     * Construnctor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * Push new route item to route list
     * 
     * @param callback
     * @return void
     */
    protected function addRoute($method, $route, $callback)
    {
        array_push($this->routes, [
            'method' => $method,
            'uri' => $this->getUri($route),
            'pattern' => $this->getPattern($route),
            'requests' => $this->getRequests($route),
            'callback' => $this->parseCallback($callback),
        ]);
    }

    /**
     * Get route uri
     * 
     * @param string
     * @return string
     */
    private function getUri($route)
    {
        return $route === '/' ?  INDEX_ALIAS : preg_replace('/\{.+\}$/', '', $route);
    }

    /**
     * Get route params
     * 
     * @param string
     * @return array
     */
    private function getPattern($route)
    {
        if (preg_match(PARAM_NUMERIC_PATTERN ,$route))
            return str_replace('/', '\/', rtrim(preg_replace(PARAM_NUMERIC_PATTERN, NUMERIC_PATTERN, $route), '/'));
        elseif (preg_match(PARAM_ANY_PATTERN, $route))
            return str_replace('/', '\/', rtrim(preg_replace(PARAM_ANY_PATTERN, ANY_PATTERN, $route), '/'));
        elseif ($route === '/')
            return preg_quote(INDEX_ALIAS);
        else
            return str_replace('/', '\/', rtrim($route, '/'));
    }

    /**
     * Get requests uri
     * 
     * @param string
     * @return array
     */
    private function getRequests($route)
    {
        $uris = explode('/', trim($route, '/'));

        return array_filter($uris, function ($item) {
            return ! preg_match('/\{.+\}/', $item);
        });
        
    }

    /**
     * Parse callback
     * 
     * @param callback
     * @return array
     */
    private function parseCallback($callback)
    {
        return (! is_callable($callback) && preg_match(CALLBACK_PATTERN, $callback))
            ? $this->parseControllerCallable($callback)
            : $callback;
    }

    /**
     * Parse controller callable
     * 
     * @param callback
     * @return array
     */
    private function parseControllerCallable($callback)
    {
        $explode = explode('@', $callback);
        $controller = $explode[0];
        $method = $explode[1];

        return compact('controller', 'method');
    }

    /**
     * Get route list
     * 
     * @return array
     */
    protected function getRoutes()
    {
        return $this->routes;
    }
}