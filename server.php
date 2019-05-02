<?php

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();


GLOBAL $clients;
GLOBAL $client_list;

$logger = new logger();

$sockets = array();
$master = stream_socket_server("tcp://0.0.0.0:8000", $errno, $errstr);

if (!$master) {
  echo "$errstr ($errno)<br />\n";
} else {
  $sockets[] = $master;
  $read = $sockets;

  while (1) {
    $read = $sockets;
    $mod_fd = @stream_select($read, $_w = null, $_e = null, 5);
    if ($mod_fd === false) {
      break;
    }

    for ($i = 0; $i < $mod_fd; ++$i) {
      if ($read[$i] === $master) {
        $client = stream_socket_accept($master);
        if ($client < 0) {
          $logger->info("stream_socket_accept");
        } else { 
          $logger->info("connecting socket", $client);

          GLOBAL $clients;
          GLOBAL $client_list;
          $clients[$socket]["id"] = uniqid();
          $clients[$socket]["socket"] = $socket;
          $clients[$socket]["handshake"] = false;
          $logger->info("Accepted client \n\n");

          $client_list[$socket] = $client;

        }
      } else {
        $sock_data = @fread($read[$i], 1024);
        var_dump($sock_data);
        if (strlen($sock_data) === 0) { // connection closed
          $key_to_del = array_search($read[$i], $master, true);
          fclose($read[$i]);
          unset($master[$key_to_del]);
        } else if ($sock_data === false) {
          echo "Something bad happened";
          $key_to_del = array_search($read[$i], $master, true);
          unset($master[$key_to_del]);
        } else {
          echo "The client has sent :";
          var_dump($sock_data);
          fwrite($read[$i], "You have sent :[" . $sock_data . "]\n");
          fclose($read[$i]);
          unset($master[array_search($read[$i], $master)]);
        }
      }
    }
  }
}


public function accept_client(){
  
}


class logger
{

  private $fileName = "log.text";

  private $handle = null;

  public function __construct()
  {
    $this->handle = fopen($this->fileName, 'a');
  }

  public function info($message, ...$args)
  {
    $message = sprintf($message, $args);
    fwrite($this->handle, $message);
  }

  public function __destruct()
  {
    fclose($this->handle);
  }
}
