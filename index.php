<?php
use system\startup;

include_once("./system/autoload.php");

//this will bootstrap the application configure middleware and any other configuration
// initialize some data and process the request
startup::getInstance()->configure()->initialize()->process();




