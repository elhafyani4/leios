<?php

namespace system\middlewares;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use system\Response;

class Middleware implements MiddlewareInterface
{

    private $listOfMiddlewares;

    public function __construct(array $listOfMiddlewares)
    {
        $this->listOfMiddlewares = $listOfMiddlewares;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): Response
    {
        if (empty($this->listOfMiddlewares)) {
            return $handler->handle($request);
        } 

        $request->listOfMiddlewares = $this->listOfMiddlewares;

        $request->next()->handle($request);
        
        return $request->response;
    }
}
