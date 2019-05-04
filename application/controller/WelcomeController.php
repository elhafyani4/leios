<?php
namespace application\controller;

use system\controller\ApiBaseController;
use system\controller\BaseController;
use application\repositories\ISampleService;
use system\logging\LoggerInterface;

/**
 *
 * @author elhafyani
 *        
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
        $this->logger->debug("hello world");
        $data = $this->repository->get_sample_record();
        $this->view($data);
    }

    public function help()
    {
        $this->view();
    }
}