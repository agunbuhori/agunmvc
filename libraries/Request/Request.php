<?php

namespace Libraries\Request;

class Request
{
    private $properties;

    /**
     * Request constructor
     * 
     * @return void
     */
    public function __construct()
    {
        foreach (array_keys($_REQUEST) as $request)
            $this->{$request} = $this->input($request);
    }

    /**
     * Request magic setter
     * 
     * @return void
     */
    public function __set($name, $value)
    {
        $this->properties[$name] = $value;   
    }

    /**
     * Request magic getter
     * 
     * @return string
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->properties))
            return $this->properties[$name];
    }

    /**
     * Request get input
     * 
     * @return string
     */
    public function input($key)
    {
        return filter_var($_REQUEST[$key], FILTER_SANITIZE_STRING);
    }
}