<?php

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Interfaces\RouterResolve;

class Router implements RouterResolve
{
    protected array $routes;

    public function routes()
    {
        return $this->routes;
    }

    public function register(string $requestMethod, string $route, $action): self
    {

        $this->routes[$requestMethod][$route] = $action;
        return $this;

    }

    public function get(string $route, $action): self
    {

        return $this->register('get', $route, $action);

    }

    public function post(string $route, $action): self
    {

        return $this->register('post', $route, $action);

    }

    public function put(string $route, $action): self
    {
        return $this->register('put', $route, $action);
    }

    public function delete(string $route, $action): self
    {
        return $this->register('put', $route, $action);
    }


    public function resolve(string $requestUri, string $requestMethod)
    {

        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;
        //var_dump($this->routes);

        if (!$action) {
            throw new RouteNotFoundException();
        }
        if (is_callable($action)) {

            return call_user_func($action);
        }

        if (is_array($action)) {

            [$class, $method] = $action;


            if (class_exists($class)) {

                $class = new $class();
            }

            if (method_exists($class, $method)) {

                return call_user_func_array([$class, $method], []);

            }
        }

    }
}
