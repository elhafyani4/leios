<?php
namespace application\configuration;

use application\repositories\ISampleService;
use application\repositories\SampleService;
use system\logging\FileLogger;
use Psr\Log\LoggerInterface;

class config
{

    /**
     * Route configuration
     *
     * @var array
     */
    static $routes = array(
        "/" => "Welcome/index",
        "\/help" => "Welcome/help"
        // "\/help\/(.*)\/(.*)" => "Welcome/getHelp"
    );

    
    public static function register_classes(&$container)
    {
        $container->add(ISampleService::class, new SampleService());
        $container->add(LoggerInterface::class, new FileLogger(__DIR__."\..\..\logging\logger.log"));
    }
}