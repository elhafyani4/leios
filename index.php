<?php
use system\startup;

include_once("./system/autoload.php");

if(php_sapi_name()==="cli"){
  echo "CLI Application";
  die();
}


startup::application_start();
startup::begin_request();


