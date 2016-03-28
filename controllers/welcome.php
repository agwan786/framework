<?php
class Welcome extends Controller{
	public function __constructor(){
		parent::__constructor();
	}

	public function index(){
		$obj = new Customer('1');
		$obj->fname = 'Altaf';
		$obj->update();
		//echo "<pre>";print_r($obj->getData);die;
	}

	public function helloWorld(){
		$obj = new Customer();
		$obj->fname = 'Monika';
		$obj->lname = "x' or 'x'='x";
		$obj->email = 'monika.w@cisinlabs.com';
		$obj->password = md5('123456');
		$obj->date = date('Y-m-d H:i:s');
		try{
			$return = $obj->add();
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
}