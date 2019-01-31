<?php

namespace system;

use system\routing\Routes;

class Startup{
	
	private static function define_variables(){
		define("VIEW_PATH", dirname(__DIR__).'/application/view');
		define("CONTROLLER_LOCATION", "application\\controller\\");
	}
	
	public static function application_start(){
		self::define_variables();
		Container::register_classes();
		Routes::register_routes();
	}
	
	public static function begin_request(){
		$request_uri = $_SERVER["REQUEST_URI"];
		$route = Routes::resolve_route($request_uri);
		$className = CONTROLLER_LOCATION.$route->controller.'Controller';
		$methodName = $route->action;
		
		$class = new \ReflectionClass($className);
		$parameters =  $class->getConstructor()->getParameters();
		
		$injectable_objects = array();
		foreach($parameters as $parameter){
		    array_push($injectable_objects, array($parameter->getPosition(), $parameter->getClass()));
		}
		
		ksort($injectable_objects);	
		
		$args = array();
		foreach($injectable_objects as $injectable_object){
		    array_push($args, container::GetInstance($injectable_object[1]));
		}
		
		if(count($args) == 0)
			$object = new $className();
		else {
			$object = $class->newInstanceArgs($args);
		}
		
		call_user_func_array(array($object, $methodName), $route->args);
	}
	
	
	public static function End_Request(){
		
	}
}