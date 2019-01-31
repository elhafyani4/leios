<?php

namespace application\controller;

use system\controller\BaseController;
use application\repositories\ISampleService;

/**
 * 
 * @author elhafyani
 * 
 */
class WelcomeController extends BaseController{
	
	public $repository;
	
	public function __construct(ISampleService $couponrepository){
		$this->repository = $couponrepository;
		parent::__construct($this);
	}
	
	public function index(){
	    $data = $this->repository->get_sample_record();
	    $this->view($data);
	}
	
	public function help(){
		$this->view();
	}
}