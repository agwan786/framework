<?php
abstract class MYSQLException extends Exception{
	public $log_path = '';
	public $log_file = '';
	public function __construct($msg=''){
		$this->log_file = 'mysql_error.txt';
		$this->log_path = _LOG_;
		$code = mysql_errno(); 
        $message = mysql_error(); 
        // open the log file for appending 
        /*if ($fp = fopen($this->log_path."/".$this->log_file,'a')) { 
 
            // construct the log message 
            $log_msg = date("[Y-m-d H:i:s]") . 
                " Code: $code - " . 
                " Message: $message\n"; 
 
            fwrite($fp, $log_msg); 
 
            fclose($fp); 
        }*/
 
        // call parent constructor 
        parent::__construct($message, $code); 
	}
}