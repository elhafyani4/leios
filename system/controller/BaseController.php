<?php
namespace system\controller;

abstract class BaseController
{

    public $controllerName = "";

    public function __construct($object)
    {
        $this->controllerName = self::get_controller_name(get_class($object));
    }

    protected function view($viewName = null, $data = NULL)
    {
        $numargs = func_num_args();
        if ($numargs == 1) {
            $argument = func_get_arg(0);
            $argymentType = gettype($argument);
            if ($argymentType instanceof string) {
                $viewName = $argument;
                $data = null;
            } else {
                $viewName = null;
                $data = $argument;
            }
        } else {
            $viewName = func_get_arg(0);
            $data = func_get_arg(1);
        }

        if ($viewName == NULL) {
            $viewName = $this->get_calling_function();
        }

        if ($data != NULL) {
            if (is_array($data)) {
                extract($data);
            } else {
                throw new \Exception('Data is not compatible to extract, only array is accepted.');
            }
        }

        include_once VIEW_PATH . '/' . $this->controllerName . '/' . $viewName . '.php';
    }

    protected static function get_controller_name($className)
    {
        $parts = explode("\\", $className);
        return str_replace("Controller", '', $parts[sizeof($parts) - 1]);
    }

    private function get_calling_function()
    {
        $stack = debug_backtrace();
        return $stack[2]['function'];
    }
}