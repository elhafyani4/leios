<?php


require 'vendor/autoload.php';

use system\startup;

//this will bootstrap the application configure middleware and any other configuration
// initialize some data and process the request
startup::getInstance()->configure()->initialize()->process();




