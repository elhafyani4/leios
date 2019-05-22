<?php

namespace system\middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class SampleHandler extends BaseMiddleware
{
    public function handle(ServerRequestInterface $requestContext): ResponseInterface
    {

        $response = $this->invokeNext($requestContext);
        $contentLength =  strlen($response->messageBody);

        $message = "
                        <br /> <br /> 
                        <div class='container'>
                            <div class='alert alert-primary' role='alert'>
                                Content Length {$contentLength} characters
                            </div>
                        </div>";

        $response->messageBody .=  $message;
        return $response;
    }
}
