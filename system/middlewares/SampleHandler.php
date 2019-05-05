<?php

namespace system\middlewares;


class SampleHandler implements MiddlewareInterface{
    public function handle($requestContext){
        return "hello world , I am sample middle ware";
    }
}