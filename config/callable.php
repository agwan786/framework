<?php
$url = ((defined('_HTTP_PROTOCOL_'))?_HTTP_PROTOCOL_:'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$domain = ((defined('_HTTP_PROTOCOL_'))?_HTTP_PROTOCOL_:'http://')._SITE_URL_;

if(strpos($url, 'index.php'))
	$urlParam = explode('index.php/', $url);
else
	$urlParam = explode($domain, $url);

$strRequest = explode('/', $urlParam[1]);
$controllerName = ucwords($strRequest[0]);
$methodName = $strRequest[1];
try{
	$getMethodFunc = methodCheck($controllerName, $methodName);

	if(false === $getMethodFunc){
		die("This function is not exist in your system.");
	}
}catch(Exception $e){
	die($e->getMessage());
}