<?php	/*	>php -q server.php	*/
/*
error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

$address = "127.0.0.1";
$port = "1222";
GLOBAL $clients;
GLOBAL $client_list;

// socket creation
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

if (!is_resource($socket))
	console("socket_create() failed: ".socket_strerror(socket_last_error()), true);

if (!socket_bind($socket, $address, $port))
	console("socket_bind() failed: ".socket_strerror(socket_last_error()), true);

if(!socket_listen($socket, 20))
	console("socket_listen() failed: ".socket_strerror(socket_last_error()), true);

console("Server started on $address : $port\n");






$master = $socket;
$sockets = array($socket);

$number_of_runs  = 0;


while(true){
	$changed = $sockets;
	

	foreach($changed as $socket){

		if($socket==$master){

			// new client will enter in this case and connect with server

			$write  = NULL;
			$except = NULL;
			@socket_select($changed,$write,$except, NULL);

			console("Master Socket Changed.\n");
			$client=socket_accept($master);
			if($client<0){ 
				console("socket_accept() failed\n"); continue; 
			} else { 
				console("Connecting socket.\n"); 
				fnConnectacceptedSocket($socket,$client); 
				$master=null; 
			}

		}else{
            
			// clients who are connected with server will enter into this case
			// first client will handshake with server and then exchange data with server
		
			$socket_id = (int) $socket;
            $client = getClientBySocket($socket_id);
			if($client) {
              
				if ($clients[$socket_id]["handshake"] == false){
					

					//$bytes = @socket_recv($client, $data, 2048, 0);
					$data = socket_read($client, 1024);
					console($data);
					

					
					
					// if ((int)$bytes == 0)
					// 	continue;

					console("Handshaking headers from client:".$data);

					if (handshake($client, $data, $socket)){
						$clients[$socket_id]["handshake"] = true;
					}
					
						
				} else if ($clients[$socket_id]["handshake"] == true) {
					$bytes = @socket_recv($client, $data, 2048, MSG_DONTWAIT);
					if ($data != ""){
						$decoded_data = unmask($data);
						socket_write($client, encode("You have entered: ".$decoded_data));
						console("Data from client:".$decoded_data);
						socket_close($socket);
					}
				}
			}
		}
	}
	

}

# Close the master sockets
socket_close($socket);

function unmask($payload) {
	$length = ord($payload[1]) & 127;

	if($length == 126) {
		$masks = substr($payload, 4, 4);
		$data = substr($payload, 8);
	}
	elseif($length == 127) {
		$masks = substr($payload, 10, 4);
		$data = substr($payload, 14);
	}
	else {
		$masks = substr($payload, 2, 4);
		$data = substr($payload, 6);
	}

	$text = '';
for ($i = 0; $i < strlen($data); ++$i) {
		$text .= $data[$i] ^ $masks[$i%4];
	}
	return $text;
}

function encode($text)
{
	// 0x1 text frame (FIN + opcode)
	$b1 = 0x80 | (0x1 & 0x0f);
	$length = strlen($text);

	if($length <= 125) 		$header = pack('CC', $b1, $length); 	elseif($length > 125 && $length < 65536) 		$header = pack('CCS', $b1, 126, $length); 	elseif($length >= 65536)
		$header = pack('CCN', $b1, 127, $length);

	return $header.$text;
}

function fnConnectacceptedSocket($socket,$client) {
	GLOBAL $clients;
    GLOBAL $client_list;
    
	$socket_id = (int) $socket;
    $clients[$socket_id]["id"] = uniqid();
	$clients[$socket_id]["socket"] = $socket;
	$clients[$socket_id]["handshake"] = false;
	console("Accepted client \n");

	$client_list[$socket_id] = $client;
}

function getClientBySocket($socket) {
    GLOBAL $client_list;
	$socket_id = (int) $socket;
	return $client_list[$socket_id];
}

function handshake($client, $headers, $socket) {

	if(preg_match("/Sec-WebSocket-Version: (.*)\r\n/", $headers, $match))
		$version = $match[1];
	else {
		console("The client doesn't support WebSocket");
		return false;
	}

	if($version == 13) {
		// Extract header variables
if(preg_match("/GET (.*) HTTP/", $headers, $match))
			$root = $match[1];
		if(preg_match("/Host: (.*)\r\n/", $headers, $match))
			$host = $match[1];
		if(preg_match("/Origin: (.*)\r\n/", $headers, $match))
			$origin = $match[1];
		if(preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $headers, $match))
			$key = $match[1];

		$acceptKey = $key.'258EAFA5-E914-47DA-95CA-C5AB0DC85B11';
		$acceptKey = base64_encode(sha1($acceptKey, true));

		$upgrade = "HTTP/1.1 101 Switching Protocols\r\n".
				   "Upgrade: websocket\r\n".
				   "Connection: Upgrade\r\n".
				   "Sec-WebSocket-Accept: $acceptKey".
				   "\r\n\r\n";

		socket_write($client, $upgrade);
		return true;
	}
	else {
		console("WebSocket version 13 required (the client supports version {$version})");
		return false;
}
}

function console($text){
	// $File = "log.txt"; 
	// $Handle = fopen($File, 'a');
	// fwrite($Handle, $text); 
	// fclose($Handle);
	echo $text;
}
*/


class WebSocket
{
    private $host;
    private $port;
    private $clients;
    private $timeout;
    private $events;
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }
    public function setTimeout($seconds)
    {
        $this->timeout = $seconds;
    }
    public function on($event, $callback)
    {
        $this->events[$event] = $callback;
    }
    public function run()
    {
        $null = NULL;
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($socket, $this->host, $this->port);
        socket_listen($socket);
        socket_set_nonblock($socket);
        $this->clients = array($socket);
        //start endless loop
        while (true) {
            $changed = $this->clients;
            socket_select($changed, $null, $null, 0, 10);
            //check for new socket
            if (in_array($socket, $changed)) {
                if (($socket_new = socket_accept($socket)) !== false) {
                    $this->clients[] = $socket_new;
					$header = socket_read($socket_new, 1024);
					var_dump($header);
                    if ($this->handshake($header, $socket_new) === false) {
                        continue;
                    }
                    socket_getpeername($socket_new, $ip);
                    if (isset($this->events['open'])) {
                        $this->events['open']($this, $ip);
                    }
                    $found_socket = array_search($socket, $changed);
                    unset($changed[$found_socket]);
                }
            }
            //loop through all connected sockets
            foreach ($changed as $changed_socket) {
                //check for any incomming data
                while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
                {
                    $received_text = $this->unmask($buf); //unmask data
                    $data = json_decode($received_text, true); //json decode
                    if (isset($this->events['message'])) {
                        $this->events['message']($this, $data);
                    }
                    break 2;
                }
                $buf = socket_read($changed_socket, 1024, PHP_NORMAL_READ);
                // check disconnected client
                if ($buf === false) {
                    $found_socket = array_search($changed_socket, $this->clients);
                    socket_getpeername($changed_socket, $ip);
                    unset($this->clients[$found_socket]);
                    if (isset($this->events['close'])) {
                        $this->events['close']($this, $ip);
                    }
                }
            }
            if ($this->timeout) {
                sleep($this->timeout);
            }
        }
        socket_close($socket);
    }
    public function send($message)
    {
        $response = $this->mask(json_encode($message));
        foreach($this->clients as $changed_socket) {
            socket_write($changed_socket, $response, strlen($response));
        }
        return true;
    }
    private function unmask($text)
    {
        $length = ord($text[1]) & 127;
        if($length == 126) {
            $masks = substr($text, 4, 4);
            $data = substr($text, 8);
        } elseif($length == 127) {
            $masks = substr($text, 10, 4);
            $data = substr($text, 14);
        } else {
            $masks = substr($text, 2, 4);
            $data = substr($text, 6);
        }
        $text = '';
        for ($i = 0; $i < strlen($data); ++$i) {
            $text .= $data[$i] ^ $masks[$i%4];
        }
        return $text;
    }
    private function mask($text)
    {
        $b1 = 0x80 | (0x1 & 0x0f);
        $length = strlen($text);
        $header = '';
        if($length <= 125) {
            $header = pack('CC', $b1, $length);
        } elseif($length > 125 && $length < 65536) {
            $header = pack('CCn', $b1, 126, $length);
        } elseif($length >= 65536) {
            $header = pack('CCNN', $b1, 127, $length);
        }
        return $header . $text;
    }
    private function handshake($receivedHeader, $clientConn)
    {
		
        $headers = array();
        $lines = preg_split("/\r\n/", $receivedHeader);
        foreach($lines as $line) {
            $line = chop($line);
            if(preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
                $headers[$matches[1]] = $matches[2];
            }
        }
        if (isset($this->events['handshake'])) {
            if ($this->events['handshake']($this, $headers) === false) {
                return false;
            }
		}
		
        $secKey = $headers['Sec-WebSocket-Key'];
        $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $upgrade =
            "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "WebSocket-Origin: $this->host\r\n" .
            "Sec-WebSocket-Accept: $secAccept\r\n\r\n";
        socket_write($clientConn, $upgrade, strlen($upgrade));
    }
}

$websocket = new WebSocket("127.0.0.1", 1222);
$websocket->run();