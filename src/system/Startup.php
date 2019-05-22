<?php
namespace system;

use system\routing\Routing;
use system\container\Container;
use system\middlewares\RequestHandler;
use system\middlewares\SampleHandler;
use system\middlewares\Middleware;
use system\middlewares\AuthorizeMiddleware;

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

    private static $instance = null;
    /**
     * get instance
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * constructor
     */
    private function __construct(){
        define("VIEW_PATH", dirname(__DIR__) . '/application/view');
        define("CONTROLLER_LOCATION", "application\\controller\\");

        $this->container = new Container();
        $this->routing = new Routing();
        $this->middleWares = array();
    }

    /**
     * configure Middleware that is going to run
     */
    public function configure(){
        $this->useMiddleWare(new AuthorizeMiddleware());
        
        $this->useMiddleWare(new SampleHandler());
        $this->useMiddleWare(new RequestHandler());
        return $this;
    }

    /**
     * application start
     */
    public function initialize()
    {
        $this->container->registerClasses();
        $this->routing->registerRoutes();

        $this->serverRequest = new ServerRequest();
        $this->serverRequest->container = $this->container;
        $this->serverRequest->routing = $this->routing;

        return $this;
    }

    /**
     * start processing the request
     */
    public function process()
    {
        
        $middleware = new Middleware($this->middleWares, new RequestHandler());
        $response = $middleware->process($this->serverRequest, new RequestHandler());

        echo $response->messageBody;
    }

    public function endRequest()
    { 

    }

    private function useMiddleWare($middleware ){
        array_push($this->middleWares, $middleware);
    }
}
