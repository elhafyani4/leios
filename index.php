<?php
use system\startup;

spl_autoload_register(function ($class_name) {
    $filename = str_replace('\\', '/', $class_name . '.php');
    if (file_exists($filename)) {
        include $filename;
    } else {
        throw new Exception("something wrong loading classname $class_name using path $filename, make sure that the classname is the same as filename");
    }
});

spl_autoload_extensions('.php');
spl_autoload_register();

startup::application_start();
startup::begin_request();


function is_php(string $phpVersion)
{
    $version = PHP_VERSION;
    $version_parts = explode(".", $version);
    $in_version_parts = explode(".", $phpVersion);
    for ($i = 0; $i < sizeof($in_version_parts); $i ++) {
        echo $in_version_parts[$i];
        echo $version_parts[$i];
        if(!isset($version_parts[$i])){
            return true;
        }
        
        if ($version_parts[$i] == $in_version_parts[$i]) {
            continue;
        }
        
        if ($version_parts[$i] >= $in_version_parts[$i]) {
            return true;
        } else {
            return false;
        }
    }
    
    return false;
}

var_dump( is_php("7.2"));