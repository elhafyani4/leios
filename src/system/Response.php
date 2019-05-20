<?php

namespace system;

use Psr\Http\Message\ResponseInterface;

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

    public static function withStatus($code, $reasonPhrase = '') : Response
    {
        $instance = new self();
        $instance->setStatusCode($code);
        if(!is_null($reasonPhrase)){
            $instance->setReasonPhrase($reasonPhrase);
        }
        return $instance;
    }

}
