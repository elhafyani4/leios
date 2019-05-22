<?php

namespace system\middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use system\Response;

class SampleHandler extends BaseMiddleware{
    public function handle(ServerRequestInterface $requestContext) :ResponseInterface
    {

        $this->invokeNext($requestContext);

        
        if ( !isset($requestContext->response) ) {
            $requestContext->response = new Response();
        }

        $contentLength =  strlen($requestContext->response->messageBody);

        $requestContext->response->messageBody .= "
                        <br /> <br /> 
                        <div class='container'>
                            <div class='alert alert-primary' role='alert'>
                                Content Length {$contentLength} characters
                            </div>
                        </div>"
        ;

        return $requestContext->response;
    }
}