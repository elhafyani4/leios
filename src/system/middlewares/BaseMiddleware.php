<?php

namespace system\middlewares;

use Psr\Http\Server\RequestHandlerInterface;
use system\Response;
use Psr\Http\Message\ResponseInterface;

abstract class BaseMiddleware  implements RequestHandlerInterface {

    public function invokeNext($requestContext) : ResponseInterface {
        $nextMiddleware = $requestContext->middlewareGenerator->send(null);

        if(!is_null($nextMiddleware)){
           
            return $nextMiddleware->handle($requestContext);
        }

        return new Response();
    }
}