<?php

namespace system\routing;

use application\configuration\config;

class Routes extends BaseRoutes{
	
	public static function register_routes() : void
	{
	    foreach(config::$routes as $key => $route)
	    {
	        $arguments = self::get_route_arguments($route);
	        self::register_route($key, $arguments[0], $arguments[1] ?? "");
	    }
	}
	
	private static function get_route_arguments($route) : array 
	{
	    $arguments = explode( "/" , $route);
	    return $arguments;
	}
}