<?php

namespace system\middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use system\Response;

class AuthorizeMiddleware extends BaseMiddleware{
    public function handle(ServerRequestInterface $requestContext) : ResponseInterface
    {
        

        $request_uri = $_SERVER["REQUEST_URI"];
        $route = null;
        if($requestContext->routing->resolveRoute($request_uri, $route) === false){
            $className = "system\controller\NotFoundController";
            $methodName = "index";
            $arguments = array();
        }else{
            $className = CONTROLLER_LOCATION . $route->controller . 'Controller';
            $methodName = $route->action;
        }
        $class = new \ReflectionClass($className);
        $classDocumentation = $class->getDocComment();

        if(strpos($classDocumentation , '@authorize') > -1){
            if(!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false){
                echo "not authorized";
                exit();
            }
        }


        $this->invokeNext($requestContext);

       return new Response();
    }

}