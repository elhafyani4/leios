<?php

class logger {

    private $fileName = "log.text";

    private $handle = null;

    public function __construct(){
        $this->handle = fopen($this->fileName, 'a');
    }

    public function info($message, ...$args){
        $message = sprintf($message, $args);
        fwrite($this->handle, $message);
    }

    public function __destruct(){
        fclose($this->handle);
    }
}