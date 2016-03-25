<?php
//place this before any script you want to calculate time
$time_start = microtime(true);

include_once 'config/constant.php';
include_once 'config/routes.php';
include_once 'config/define.inc.php';
include_once 'config/checker.php';
include_once 'config/config.php';
include_once 'config/callable.php';


$time_end = microtime(true);

//dividing with 60 will give the execution time in minutes other wise seconds
$execution_time = ($time_end - $time_start);

//execution time of the script
echo '<br/><b>Total Execution Time:</b> '.$execution_time.' Seconds';