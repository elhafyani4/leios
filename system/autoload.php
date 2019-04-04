<?php

spl_autoload_register(function ($class_name) {
  $filename = str_replace('\\', '/', $class_name . '.php');
  if (file_exists($filename)) {
    include $filename;
  } else {
    throw new Exception("something wrong loading classname $class_name using path $filename, make sure that the classname is the same as filename");
  }
});

spl_autoload_extensions('.php');
