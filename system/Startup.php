<?php
namespace system;

use system\routing\Routing;
use system\container\Container;

class startup
{

    private $container;
    private $routing;

    public function __construct(){
        define("VIEW_PATH", dirname(__DIR__) . '/application/view');
        define("CONTROLLER_LOCATION", "application\\controller\\");
    }

    public function application_start()
    {
        $this->container = new Container();
        $this->routing = new Routing();
        
        
        $this->container->registerClasses();
        $this->routing->registerRoutes();
    }

    public function beginRequest()
    {
        $request_uri = $_SERVER["REQUEST_URI"];
        if($this->routing->resolveRoute($request_uri, $route) === false){
            $className = "system\controller\NotFoundController";
            $methodName = "index";
            $arguments = array();
        }else{
            $className = CONTROLLER_LOCATION . $route->controller . 'Controller';
            $methodName = $route->action;
        }

        $class = new \ReflectionClass($className);
        $parameters = $class->getConstructor()->getParameters();

        $injectable_objects = array();
        foreach ($parameters as $parameter) {
            array_push($injectable_objects, array(
                $parameter->getPosition(),
                $parameter->getClass()
            ));
        }

        ksort($injectable_objects);

        $args = array();
        foreach ($injectable_objects as $injectable_object) {
            array_push($args, $this->container->get($injectable_object[1]));
        }

        if (count($args) == 0)
            $object = new $className();
        else {
            $object = $class->newInstanceArgs($args);
        }

        call_user_func_array(array(
            $object,
            $methodName
        ),  $arguments ?? $route->args);
    }

    public function endRequest()
    { 
        
    }
}
