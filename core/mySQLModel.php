<?php
include 'configData.php';
abstract class mySQLModel extends MYSQLException{
	/* Host value like localhost */
	protected $host;
	/* Username value like root */
	protected $username;
	/* Password value like root */
	protected $password;
	/* Database name value like database */
	protected $database;

	public $error = array();

	public function __construct(){
		$this->host = _SERVER_;
		$this->username = _USER_;
		$this->password = _PASSWORD_; 
		$this->database = _DATABASE_;
		parent::__construct();
	}

	public function connect(){
		try{
			/* Make link with server*/
			$link = mysql_connect($this->host, $this->username, $this->password);
		}catch(MYSQLException $e){
			throw new MYSQLException;
		}

		/* Make connection with database*/
		$this->set_db($link, $this->database);
	}

	public function set_db($link, $db){
		if(!mysql_select_db($db, $link))
			throw new MYSQLException;
	}

	public function execute($query){
		if(mysql_query($query))
			return TRUE;
		else
			return FALSE;
	}

	public function executeS($query){
		$records = array();
		if($execute = mysql_query($query)){
			while ($data = mysql_fetch_assoc($execute)) {
				$records[] = $data;
			}
		}
		return $records;
	}

	public function getNum($query){
		$result = 0;
		if($execute = mysql_query($query))
			$result = $execute->num_rows();
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