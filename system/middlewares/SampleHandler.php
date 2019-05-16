<?php

namespace system\middlewares;


class SampleHandler implements MiddlewareInterface{
    public function handle($requestContext, &$response){
        $length = strlen($response);
        $response .= "Response length is ". $length/1000 . "KB";
    }
}