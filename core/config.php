<?php
/* Define all configurable data */
define('_SERVER_', 'localhost');//set server value
define('_USER_', 'root');//set your database username
define('_PASSWORD_', '');//set your database password
define('_DATABASE_', 'framework');//set your database name
define('_TABLE_PREFIX_', 'db_');//set your database prefix
define('_LOG_','../log');//set your site log folder path
define('MODE', 'DEV');//set your site developement mode

if(MODE=='DEV'){//if MODE defined as dev then it will show errors
	@ini_set('display_errors', 1);
	error_reporting(E_ALL);
}else{
	error_reporting(0);
}
