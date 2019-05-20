<?php

namespace system\middlewares;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class SampleHandler implements RequestHandlerInterface{
    public function handle(ServerRequestInterface $requestContext) :ResponseInterface
    {
        //do some logic
        $requestContext->next()->handle($requestContext);
        //do other logic

        return $requestContext->response;
    }
}