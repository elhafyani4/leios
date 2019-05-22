<?php

namespace system\middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthorizeMiddleware extends BaseMiddleware
{
    public function handle(ServerRequestInterface $requestContext): ResponseInterface
    {

        if (!$this->check_if_authorized($requestContext)) {
            echo "403 Not Authorized";
            exit();
        }

        $response = $this->invokeNext($requestContext);

        return $response;
    }

    private function check_if_authorized($requestContext)
    {
        $request_uri = $_SERVER["REQUEST_URI"];
        $route = null;
        if ($requestContext->routing->resolveRoute($request_uri, $route) === true) {
            $className = CONTROLLER_LOCATION . $route->controller . 'Controller';
        }

        $class = new \ReflectionClass($className);
        $classDocumentation = $class->getDocComment();


        if (strpos($classDocumentation, '@authorize') > -1) {
            if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
                return false;
            }
        }
        
        return true;
    }
}
