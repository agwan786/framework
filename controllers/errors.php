<?php
class Errors extends Controller{
	public function __constructor(){
		parent::__constructor();
	}

	public function err_404(){
		echo "Page not found";
	}
}
?>