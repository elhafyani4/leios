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
 
