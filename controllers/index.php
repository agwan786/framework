<?php
class Index extends Controller{
	public function __constructor(){
		parent::__constructor();
	}

	public function home(){
		echo "Hello World!";
	}

	public function helloWorld(){
		$obj = new Customer('1');
		$obj->fname = 'Monika';
		$obj->lname = 'Wadhwani';
		$obj->email = 'monika.w@cisinlabs.com';
		$obj->add();
	}
}