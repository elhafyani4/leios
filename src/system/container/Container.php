<?php
namespace system\container;

use application\configuration\config;

class container implements ContainerInterface
{

    public $container; 

    public function __constructor()
    {
        $this->container = array();
    }

    public function registerClasses()
    {
        \application\configuration\config::register_classes($this);
    }

    public function add($clazz, $instance)
    {
        if (!isset($this->container[$clazz])) {
            $this->container[$clazz] = $instance;
        } else {
            throw new \Exception("Exception Adding Mapping to the container");
        }
    }

    public function get($str)
    {
        $className = isset($str->name) ? $str->name : $str;
        if (array_key_exists($className, $this->container)) {
            return $this->container[$className];
        }
    }


    public function has($str)
    {
        $className = isset($str->name) ? $str->name : $str;
        return array_key_exists($className, $this->container);
    }
}
