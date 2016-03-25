<?php
//place this before any script you want to calculate time
$time_start = microtime(true);

include_once 'config/constant.php';
include_once 'config/routes.php';
include_once 'config/define.inc.php';
include_once 'config/checker.php';
include_once 'config/config.php';
include_once 'config/callable.php';

<<<<<<< HEAD

$time_end = microtime(true);

//dividing with 60 will give the execution time in minutes other wise seconds
$execution_time = ($time_end - $time_start);

//execution time of the script
echo '<br/><b>Total Execution Time:</b> '.$execution_time.' Seconds';
=======
 

$time_end = microtime(true);
//dividing with 60 will give the execution time in minutes other wise seconds
$execution_time = ($time_end - $time_start)/60;

//execution time of the script
echo '<br/><b>Total Execution Time:</b> '.$execution_time.' Mins';
>>>>>>> 9085e8462f2819c7d9346873481f289dca8fbb88
