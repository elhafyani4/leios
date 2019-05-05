<?php
namespace system;

use system\routing\Routing;
use system\container\Container;
use system\middlewares\RequestHandler;
use system\middlewares\SampleHandler;


class startup
{
    /**
     * Container Object that serves as dependecy registry
     */
    private $container;

    /**
     * Routing information for URL and Controller 
     */
    private $routing;

    /**
     * Request Context
     */
    private $requestContext;

    /**
     * array of middle for request processing
     */
    private $middleWares;

    /**
     * constructor
     */
    public function __construct(){
        define("VIEW_PATH", dirname(__DIR__) . '/application/view');
        define("CONTROLLER_LOCATION", "application\\controller\\");

        $this->container = new Container();
        $this->routing = new Routing();
        $this->middleWares = array();
    }

    public function configureMiddleware(){
        $this->useMiddleWare(new RequestHandler());
        $this->useMiddleWare(new SampleHandler());
    }

    public function applicationStart()
    {
        $this->container->registerClasses();
        $this->routing->registerRoutes();

        $this->requestContext = new RequestContext();
        $this->requestContext->container = $this->container;
        $this->requestContext->routing = $this->routing;

    }

    public function beginRequest()
    {
       $response = "";
       foreach($this->middleWares as $middleWare){
           $response .= $middleWare->handle($this->requestContext);
       }
       echo $response;
    }

    public function endRequest()
    { 

    }

    private function useMiddleWare($middleware ){
        array_push($this->middleWares, $middleware);
    }
}
