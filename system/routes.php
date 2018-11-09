<?php

use Libraries\Router\Route;

$route = new Route;

$route->group(['prefix' => 'user'], function () use ($route) {
    $route->get('/', 'UserController@index');
    $route->get('/{id}', 'UserController@show');
    $route->post('/', 'UserController@store');
    $route->put('/{id}', 'UserController@update');
    $route->delete('/{id}', 'UserController@destroy');
});

$route->dispatch();