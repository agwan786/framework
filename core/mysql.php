<?php
include_once 'config.php';
abstract class Mysql extends Mysqlexception{
	/* Host value like localhost */
	protected $host;
	/* Username value like root */
	protected $username;
	/* Password value like root */
	protected $password;
	/* Database name value like database */
	protected $database;
	
	public $link;

	public $error = array();

	public function __construct(){
		$this->host = _SERVER_;
		$this->username = _USER_;
		$this->password = _PASSWORD_; 
		$this->database = _DATABASE_;
		parent::__construct();
		$this->connect();
	}

	public function connect(){
		try{
			/* Make link with server*/
			$this->link = mysqli_connect($this->host, $this->username, $this->password, $this->database);
		}catch(Mysqlexception $e){
			throw new Mysqlexception;
		}

		if (!$this->link) {
			throw new Mysqlexception;
			exit();
		}

		/* Make connection with database*/
		//$this->set_db($link, $this->database);
	}

	//public function set_db($link, $db){
	//	if(!mysql_select_db($db, $link))
	//		throw new Mysqlexception;
	//}

	public function execute($query){
		if(mysqli_query($this->link, $query))
			return $this->link->insert_id or $this->link->affected_rows;
		else
			return FALSE;
	}

	public function executeS($query){
		$records = array();
		if($execute = $this->link->query($query)){
			if($this->return == 1)
				$records = $execute->fetch_assoc();
			else
				while ($data = $execute->fetch_assoc()) {
					if($this->return == 1)
						$records = $data;
					else
						$records[] = $data;
				}
			$execute->free();
		}
		$this->link->close();
		return $records;
	}

	public function getNum($query){
		$result = 0;
		if($execute = $this->link->query($query))
			$result = $execute->num_rows;
		return $result;
	}

	public function __destruct(){
		$this->host;
		$this->username;
		$this->password; 
		$this->database;
		$this->error;
	}
}