<?php

namespace system\controller;


/***
 * Class ApiBaseController
 *
 * @package system\controller
 */
abstract class ApiBaseController extends BaseController
{

  /***
   * @param $data
   * @return  string
   */
  protected function json($data)
  {

    if (is_array($data)) {
      echo json_encode($data);
    }
    throw new \Exception("can't serialize the data to json");
  }

  protected function xml($data)
  {
    if (is_array($data)) {
      echo (xmlrpc_encode($data));
    }
  }
}
