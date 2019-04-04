<?php
namespace system\routing;

abstract class BaseRoutes
{

    /*
     * Routes for the application
     */
    public static $routes = array();

    /*
     * Register Routes
     */
    // abstract protected register_routes();

    /*
     * Resolve Route
     */
    static function resolve_route($route)
    {
        $array_keys = array_keys(Routes::$routes);
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
        $route = clone (Routes::$routes[$result_keys[0]]);
        $route->args = $args;
        return $route;
    }

    static function register_route($route_name, $controller, $action = null, $args = array())
    {
        $route = new route();
        $route->action = $action;
        $route->controller = $controller;
        $route->args = $args;
        if (isset(self::$routes[$route_name])) {
            throw new \Exception("Error Adding Routing mapping , the mapping already exists");
        } else {
            self::$routes[$route_name] = $route;
        }
    }
}
