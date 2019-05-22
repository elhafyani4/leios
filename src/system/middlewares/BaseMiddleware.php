<?php

namespace system\middlewares;

use Psr\Http\Server\RequestHandlerInterface;

abstract class BaseMiddleware  implements RequestHandlerInterface {

    public function invokeNext($requestContext){
        $nextMiddleware = $requestContext->middlewareGenerator->send(null);

        if(!is_null($nextMiddleware)){
           
            $nextMiddleware->handle($requestContext);
        }
    }
}