<?php
namespace application\controller;


use system\controller\BaseController;
use application\repositories\ISampleService;
use Psr\Log\LoggerInterface;

/**
 *
 * @author elhafyani
 * 
 * @authorize       
 */
class WelcomeController extends BaseController
{

    public $repository;

    public $logger;

    public function __construct(ISampleService $couponrepository, LoggerInterface $logger)
    {
        $this->repository = $couponrepository;
        $this->logger = $logger;
        parent::__construct($this);
    }

    public function index()
    {        
        $data = $this->repository->get_sample_record();
        $this->view($data);
    }

    public function help()
    {
        $this->view();
    }
}