<?php
class Index extends Controller{
	public function __constructor(){
		parent::__constructor();
	}

	public function index(){
		echo "Hello World!";
	}

	public function helloWorld(){
		$obj = new Customer();
		$obj->test();
	}
}