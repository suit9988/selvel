<?php
	/*
	 * v1 - Database
	 * v2 - Added affected_rows();
	 */
    session_start();
    class Database
    {
		private $connection;
		function __construct()
		{
			$this->open_connection();
		}
		
		public function open_connection()
		{
			$this->connection = mysqli_connect("localhost", "u862532462_selveluser", "@Selvel123@", "u862532462_selveldb");
		//$this->connection = new mysqli("localhost", "root", "", "selvel");

			if ($this->connection->connect_errno) {
				die("Failed to connect to MySQL: (" . $this->connection->connect_errno . ") " . $this->connection->connect_error);
			}
		}
		
		public function close_connection()
		{
			if(isset($this->connection))
			{
				$this->connection->close();
				unset($this->connection);
			}
		}
		
		public function query($sql)
		{
			$result=$this->connection->query($sql);
			if(!$result)
			{
				die("Database query failed".$this->connection->error);
			}
			return $result;
		}
		
		public function fetch($query)
		{
			$row=$query->fetch_assoc();
			return $row;
		}
		
		public function escape_string($string)
		{
			$string = $this->connection->real_escape_string($string);
			return $string;
		}
		
		public function num_rows($result)
		{
			$rows = $result->num_rows;
			return $rows;
		}

		public function affected_rows() {
			$affected_rows = $this->connection->affected_rows;
			return $affected_rows;
		}

		public function last_insert_id()
		{
			$last_insert_id = $this->connection->insert_id;
			return $last_insert_id;
		}
		
		public function strip_all($string)
		{
			$string = strip_tags($string);
			return $string;
		}
		
		public function strip_selected($string, $allowTags)
		{
			$string = strip_tags($string, $allowTags);
			return $string;
		}
		
	}    
	$connect = new PDO("mysql:host=localhost;dbname=u862532462_selveldb", "u862532462_selveluser", "@Selvel123@");
//	$con = mysqli_connect("localhost", "buildweb_selvel_user", "UgSSl.sChGZ5", "buildweb_selvel");
	
?>