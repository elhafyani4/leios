<?php 
namespace application\configuration;

use application\repositories\ISampleService;
use application\repositories\SampleService;
use system\Container;

class config{
    
    /**
     * Route configuration
     * @var array
     */
    static $routes =  array(
        "/" => "Welcome/index",
        "\/help" => "Welcome/help"
        //"\/help\/(.*)\/(.*)" => "Welcome/getHelp"
    );
    
    
    public static function register_classes(){
        Container::add_to_registry(ISampleService::class, new SampleService());
    }
    
}