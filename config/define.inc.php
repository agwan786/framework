<?php
if(defined('_DEV_MODE_')){
	if(_DEV_MODE_){
		@ini_set('display_errors', 1);
		error_reporting(E_ALL);
	}else{
		@ini_set('display_errors', 0);
		error_reporting(0);
	}
}