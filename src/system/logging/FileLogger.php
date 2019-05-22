<?php

namespace system\logging;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class FileLogger implements LoggerInterface{
    use LoggerTrait;

    /**
     * File Handler where the log will be written  
     */
    private $fileHandler;

    /**
     * constuctor for the File Logger
     */
    public function __construct(string $fileName) {
        
        $this->fileHandler = fopen($fileName.date("Y_d_m"), 'a');
    }

      /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = array()){
        fwrite($this->fileHandler, date("[Y-m-d H:i:s B]") . ":" . $level . " : ".$message."\n" );
    }

    /**
     * Method called before class destruction
     */
    public function __destruct(){
        fclose($this->fileHandler);
    }
}

