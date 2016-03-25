<?php
function __autoload($className){
	if (@file_exists('./controllers/'.strtolower($className).'.php'))
		include_once ('./controllers/'.strtolower($className).'.php');
	else if (@file_exists('./core/'.strtolower($className).'.php'))
		include_once ('./core/'.strtolower($className).'.php');
	else if (@file_exists('./classes/'.strtolower($className).'.php'))
		include_once ('./classes/'.strtolower($className).'.php');
	else
		include_once ('./controllers/errors.php');//throw new Exception ('You haven\'t this class '.$className.' in your system. Please add this class in your system.');
}

function methodCheck($className, $methodName){
	if (method_exists($className, $methodName)){
		$refl = new ReflectionMethod($className, $methodName);

		if ($refl->isPrivate())
			throw new Exception("This method is not callable. Because this is private function.");
		else if ($refl->isProtected())
			throw new Exception("This method is not direct callable. Because this is protected function.");
		else{
			try{
				$return = $refl->invoke(new $className);		
			}catch(Exception $e){
				die($e->getMessage());
			}
		}
		return $return;
	}else
		return false;
}