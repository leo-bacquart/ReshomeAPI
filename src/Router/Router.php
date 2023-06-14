<?php

namespace Hetic\ReshomeApi\Router;

class Router
{
    private $routes = [];

    public function register($method, $route, $handler)
    {
        $this->routes[$method][$route] = $handler;
    }

    public function handleRequest($method, $uri)
    {
        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo "Not Found";
            exit();
        }

        $handler = $this->routes[$method][$uri];
        echo $handler();
    }
}