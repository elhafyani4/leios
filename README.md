# Leios
## MVC PHP Framework

Leios is a simple micro mvc framework, built for lightweight application.

To try the framework :
```
git checkout https://github.com/elhafyani4/Leios.git
```
to run it 
```
php -S 0.0.0.0:80
```
Browse to 
```
http://localhost/
```

### What is Leios?
Leios is a micro php framework, the whole purpose of Leios is to provide developer with a non opinionated framework , Leios doesn't tell you how would handle your database calls , or do authentication. The user should be able to extend it to fit the project.

## Feature 
Routing

Dependency Injection

Middlewares PSR-15


### How to get started?
## Create Controller & View

```php
namespace application\controller;

use system\controller\BaseController;

class SampleController extends BaseController {

    public function __construct() {

    }

    public function index() {
        return $this->view();
    }
}
```

after creating controller with a function named index, go 
`
src\application\controller
`
and create a folder for that controller actions, and create a file that match the action name , in this case index.php

`
src\application\controller\sample\index.php
`

```html
<html>
  <head>
    <title>Welcome to Leios</title>
  </head>
  <body>
    Hello from Leios Framework
  </body>
</html>
```

to access this action go to http://localhost/sample/index

if you dont like the way the url looks, you can use routing to access this action , go to the /src/application/configuration/config.php
, edit the section $routes to something like this.

```php
static $routes = array(
        "/sample" => "Sample/index"        
    );
```

now you can go to the http://localhost/sample and it would render the same action as before


## Dependency Injection 

the dependency injection currently works only with controller, all the services that you pass in the controller constructor would be provided from the container 

### How to setup dependency injection 
lets create a sample service ore repository 

ISampleService.php
```php
<?php
namespace application\repositories;

interface ISampleService
{
    function get_sample_record();
}
```

then let's create an implementation of that interface

SampleService.php
```php
<?php
namespace application\repositories;

class SampleService implements ISampleService
{
    public function get_sample_record()
    {
        return array(
            "application_name" => "Leios Framework"
        );
    }
    
}
```

now let's register instance of this class in the src/application/configuration/config.php

```php
public static function register_classes(&$container)
{
    $container->add(ISampleService::class, new SampleService());
}
 ```
 
create controller 
```php
<?php

namespace application\controller;

use system\controller\BaseController;
use application\repositories\ISampleService;
use Psr\Log\LoggerInterface;

class SampleController extends BaseController{

    private $service;

    private $logger;

    public function __construct(ISampleService $sampleService, LoggerInterface $logger){
        $this->service = $sampleService;
        $this->logger = $logger;
    }

    public function index(){
        return $this->view();
    }
}
```
 
### Middleware
the request in leios go through a middleware pipeline , currently , RequestHander (MVC) is a middleware in the middleware pipeline
```
Request------------>AuthorizeMiddleware--------------->RequestHandler(MVC)--------------->SampleMiddleware--
                                                                                                            |
                                                                                                            |
                                                                                                            |
                                                                                                            |
Response<------------AuthorizeMiddleware<---------------RequestHandler(MVC)<--------------SampleMiddleware<-
```

To create a middleware you need to extend the BaseMiddleware, let's take the example of the AuthorizeMiddleware and SampleMiddleware

AuthorizeMiddleware.php
```php
<?php

namespace system\middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthorizeMiddleware extends BaseMiddleware
{
    public function handle(ServerRequestInterface $requestContext): ResponseInterface
    {
        if ($this->check_if_authorized($requestContext)) {
            echo "not authorized";
            exit();
        }

        $response = $this->invokeNext($requestContext);

        return $response;
    }

    private function check_if_authorized($requestContext)
    {
        $request_uri = $_SERVER["REQUEST_URI"];
        $route = null;
        if ($requestContext->routing->resolveRoute($request_uri, $route) === true) {
            $className = CONTROLLER_LOCATION . $route->controller . 'Controller';
        }

        $class = new \ReflectionClass($className);
        $classDocumentation = $class->getDocComment();

        if (strpos($classDocumentation, '@authorize') > -1) {
            if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
                return false;
            }
        }
    }
}

```

SampleMiddleware.php
```php
<?php

namespace system\middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class SampleHandler extends BaseMiddleware
{
    public function handle(ServerRequestInterface $requestContext): ResponseInterface
    {

        $response = $this->invokeNext($requestContext);
        $contentLength =  strlen($response->messageBody);

        $message = "
                        <br /> <br /> 
                        <div class='container'>
                            <div class='alert alert-primary' role='alert'>
                                Content Length {$contentLength} characters
                            </div>
                        </div>";

        $response->messageBody .=  $message;
        return $response;
    }
}
```

In order to attach this middleware to the pipeline we need to configure  this in the Startup.php
``` php
    .
    .
    .
    public function configure(){
        $this->useMiddleWare(new AuthorizeMiddleware());
        $this->useMiddleWare(new SampleHandler());
        $this->useMiddleWare(new RequestHandler());
        return $this;
    }
    
```
