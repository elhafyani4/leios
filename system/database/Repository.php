<?php
namespace system\database;

class Repository implements IRepository{
	
	private $mysqli;
	
	public function __construct($host, $user, $pass, $db, $port=3306){
		$this->mysqli = new \mysqli($host, $user, $pass, $db, $port);
		if($this->mysqli->connect_errno){
			die("mysql_connect error");
		}
	}
	
	public function query($sql){
		$result = $this->mysqli->query($sql);
		if($result) return $result;
		return null;
	}
	
	public function multi_query($sql){
		$result = $this->mysqli->multi_query($sql);
		if($result) return $result;
		return null;
	}
	
	
	function __destruct(){
		$this->mysqli->close();
	}
}

interface IRepository{
    
    
}