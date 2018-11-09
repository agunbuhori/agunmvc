<?php

namespace Libraries\Router;

use Libraries\Router\ControllerHandler;

class RouterDispatcher extends ControllerHandler
{
    /**
     * Dispatch matched route to provided callback
     * 
     * @return void
     */
    public function dispatch($routes)
    {
        $pathInfo = $this->getPathInfo();
        $currentMethod = $this->getCurrentMethod();

        $activeRoute = array_filter($routes, function ($route) use ($pathInfo, $currentMethod) {
            return preg_match('/^'.$route['pattern'].'$/', $pathInfo) && $route['method'] == $currentMethod;
        });

        if (! $activeRoute) {
            $this->response404();
        }

        $activeRoute = reset($activeRoute);
        
        $this->returnResponse($this->executeCallback($activeRoute['callback'], $activeRoute['requests']));
    }

    /**
     * Execute registered callback
     * 
     * @return void
     */
    private function executeCallback($callback, $requests)
    {
        $paramValues = $this->getParamsValue($requests);

        if (is_callable($callback))
            return $callbackOutput = call_user_func_array($callback, $paramValues);
        elseif (is_array($callback))
            return $callbackOutput = parent::executeController($callback, $paramValues);
    }

    /**
     * Return response as any format
     * 
     * @return string
     */
    private function returnResponse($output)
    {
        if (is_string($output) || is_numeric($output))
            echo $output;
        elseif (is_array($output))
            $this->responseJson($output);
        elseif (is_object($output))
            $this->responseJson((array) $output);
    }

    /**
     * Return response as 404
     * 
     * @return void
     */
    private function response404()
    {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        include PATH."system/pages/error-404.php";
        die();
    }

    /**
     * Return response as json format
     * 
     * @return string
     */
    private function responseJson($callbackOutput)
    {
        if (array_key_exists('error', $callbackOutput))
            return $this->response404();

        header('Content-Type:application/json');
        echo json_encode($callbackOutput);
    }

    /**
     * Get current method
     * 
     * @return string
     */
    private function getCurrentMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get path info
     * 
     * @return string
     */
    private function getPathInfo()
    {
        return isset($_SERVER['PATH_INFO']) ? filter_var(rtrim($_SERVER['PATH_INFO'], '/'), FILTER_SANITIZE_URL) : '****index****';
    }
    
    /**
     * Get params from url
     * 
     * 
     * @return array
     */
    private function getParamsValue($requests)
    {
        $params = preg_replace('/('.implode('|', $requests).')/', '', $this->getPathInfo());
        $params = preg_replace('/\/+/', '/', $params);
        
        return explode('/', trim($params, '/'));
    }
}