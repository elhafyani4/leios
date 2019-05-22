<?php
namespace system\routing;

use application\configuration\config;

class Routing
{

    /*
     * Routes for the application
     */
    public $routes;

    public function __construct(){
        $this->routes = array();
    }

    public function registerRoutes()
    {
        foreach (config::$routes as $key => $route) {
            $arguments = $this->getRouteArguments($route);
            $this->addRoute($key, $arguments[0], $arguments[1] ?? "");
        }
    }

    /*
     * Resolve Route
     */
    public function resolveRoute($route, &$route_result)
    {
        $array_keys = array_keys($this->routes);
        $result_keys = array();
        $args = array();
        foreach ($array_keys as $key) {
            $match = array();
            preg_match('%^' . $key . '$%', $route, $match);
            if (sizeof($match) > 0) {
                array_push($result_keys, $key);
                $args = array_slice($match, 1);
            }
        }

        if(count($result_keys) == 0){
            return false;
        }

        $route = clone ($this->routes[$result_keys[0]]);
        $route->args = $args;
        $route_result = $route;
        return true;
    }


    public function addRoute($route_name, $controller, $action = null, $args = array())
    {
        $route = new route();
        $route->action = $action;
        $route->controller = $controller;
        $route->args = $args;
        if (isset($this->routes[$route_name])) {
            throw new \Exception("Error Adding Routing mapping , the mapping already exists");
        } else {
            $this->routes[$route_name] = $route;
        }
    }
    

    private function getRouteArguments($route): array
    {
        $arguments = explode("/", $route);
        return $arguments;
    }

}
