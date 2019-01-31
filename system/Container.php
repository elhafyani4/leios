<?php
namespace system;

use Exception;

use application\configuration\config;

class Container{
	
	public static $container = array();
	
	public static function register_classes(){
	    config::register_classes();
	}
	
	public static function add_to_registry($clazz, $instance){
	    if(!isset(self::$container[$clazz])){
	        self::$container[$clazz] = $instance;
		}else{
			throw new Exception("Exception Adding Mapping to the container");
		}
	}
	
	public static function GetInstance($str){
	    $className = isset($str->name) ? $str->name : $str;
	    if(array_key_exists($className, self::$container)){
	        return self::$container[$className];
		}
	}
}