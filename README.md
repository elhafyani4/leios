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

