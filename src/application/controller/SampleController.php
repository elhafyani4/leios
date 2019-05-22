<?php

namespace application\controller;

use system\controller\BaseController;
use application\repositories\ISampleService;
use Psr\Log\LoggerInterface;

class SampleController extends BaseController{

    private  $service;

    private $logger;

    public function __construct(ISampleService $sampleService, LoggerInterface $logger){
        $this->service = $sampleService;
        $this->logger = $logger;
    }

    public function index(){
        return $this->view();
    }


}