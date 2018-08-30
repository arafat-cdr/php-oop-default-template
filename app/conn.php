<?php

require_once(__DIR__.'/config.php');

class Conn
{
	public $db_host = DB_HOST;
	public $db_user = DB_USER;
	public $db_pass = DB_PASS;
	public $db_name = DB_NAME;
	public $connection;
	
	public function db_connect()
	{
		// Create connection
		$this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass);
		mysqli_query($this->connection,"SET CHARACTER_SET_CLIENT='utf8'");

		mysqli_query($this->connection,"SET CHARACTER_SET_RESULTS='utf8'");

		mysqli_query($this->connection,"SET CHARACTER_SET_CONNECTION='utf8'");

		// Check connection
		if ($this->connection->connect_error) 
		{
		    die("Connection failed: " . $this->connection->connect_error);
		} 
		
		$db_select = mysqli_select_db($this->connection,$this->db_name);
		
		if($db_select)
		{
		 	#echo "Connected successfully";
			return $this->connection;
		}
		else
		{
		    die("Connection failed: " . $this->connection->connect_error);
		}

		
	}
}

?>