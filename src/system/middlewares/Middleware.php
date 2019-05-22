<?php

namespace system\middlewares;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use system\Response;
use Psr\Http\Message\ResponseInterface;
use system\ServerRequest;

class Middleware implements MiddlewareInterface
{

    private $listOfMiddlewares;

    public function __construct(array $listOfMiddlewares)
    {
        $this->listOfMiddlewares = $listOfMiddlewares;
    }

    public function process($request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (empty($this->listOfMiddlewares)) {
            return $handler->handle($request);
        } 

        $request->listOfMiddlewares = $this->listOfMiddlewares;
        $request->setGenerator();

        $request->middlewareGenerator->current()->handle($request);
    
        
        
        return $request->response;
    }
}
