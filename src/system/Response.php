<?php

namespace system;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface
{


    public $protocolVersion;
    public $statusCode;
    public $reasonPhrase;
    public $headers;
    public $messageBody;

    public function __construct($protocolVersion = null, $statusCode = null){

    }

    public function setMessageBody($messageBody) {
        $this->messageBody = $messageBody;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getReasonPhrase(){

    }

    public function getProtocolVersion(){

    }

    public function withProtocolVersion($version){

    }

    public function getHeaders(){

    }

    public function hasHeader($name){

    }

    public function getHeader($name){

    }

    public function getHeaderLine($name){

    }

    public function withHeader($name, $value){

    }

    public function withAddedHeader($name, $value){

    }
    
    public function withoutHeader($name){


    }

    public function getBody(){

    }

    public function withBody(StreamInterface $body){

    }

    public function withStatus($code, $reasonPhrase = '') : Response
    {
        $instance = new self();
        $instance->setStatusCode($code);
        if(!is_null($reasonPhrase)){
            $instance->setReasonPhrase($reasonPhrase);
        }
        return $instance;
    }

}
