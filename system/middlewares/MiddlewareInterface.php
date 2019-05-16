<?php
namespace system\middlewares;

interface MiddlewareInterface{
    public function handle($requestContext, &$response);
}