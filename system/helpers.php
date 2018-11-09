<?php

if (! function_exists('env')) {
    /**
     * Get environment variable value
     * 
     * @param string
     * @return string
     */
    function env($key, $value)
    {
        $env_file = file_get_contents(PATH.'.env');
        $variables = explode(PHP_EOL, $env_file);
        
        foreach ($variables as $variable) {
            $env_item = explode('=', $variable);
            $item_key = $env_item[0];
            $item_value = $env_item[1];

            if ($key == $item_key)
                return $item_value;
        }

        return $value;
    }
}

if (! function_exists('request')) {
    /**
     * Create request instance
     * 
     * @return callback
     */
    function request($key = null)
    {
        $request = new \Libraries\Request\Request;

        if (! is_null($key))
            return $request->input($key);

        return $request;
    }
}

if (! function_exists('singularize')) {
    function singularize($word)
    {
        $rules = [ 
            'ss' => false, 
            'os' => 'o', 
            'ies' => 'y', 
            'xes' => 'x', 
            'oes' => 'o', 
            'ies' => 'y', 
            'ves' => 'f', 
            's' => ''
        ];
        
        foreach (array_keys($rules) as $key) {
            if (substr($word, (strlen($key) * -1)) != $key) 
                continue;

            if($key === false) 
                return $word;
            return substr($word, 0, strlen($word) - strlen($key)) . $rules[$key]; 
        }
        return $word;
    }
}

if (! function_exists('pluralize')) {
    function pluralize($singular, $plural = null) {
        if ($plural !== null) return $plural;

        $last_letter = strtolower($singular[strlen($singular)-1]);
        switch($last_letter) {
            case 'y':
                return substr($singular,0,-1).'ies';
            case 's':
                return $singular.'es';
            default:
                return $singular.'s';
        }
    }
}

if (! function_exists('public_path')) {
    function public_path($path = null)
    {
        return url("public/".$path);
    }
}

if (! function_exists('url')) {
    function url($uri = null)
    {
        return sprintf(
            "%s://%s%s/%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            preg_replace('/\/index\.php/', '', $_SERVER['SCRIPT_NAME']),
            trim($uri, '/')
        );
    }
}