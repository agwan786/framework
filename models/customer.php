<?php
include_once('../core/objectModel.php');
class Customer extends objectModel{
	public function __construct(){
		parent::__construct();	
	}

    public function add($data){        
        parent::add($data);
    }
}

try {
    $cust = new Customer();
    $data = array('table'=>'customer', 'insert'=>array('fname'=>'Altaf', 'lname'=>'Husain', 'email'=>'altaf.h@cisinlabs.com', 'password'=>md5('123456'), 'date'=>date('Y-m-d H:i:s')));
    $this->set('*',$data);
    $cust->add();
} catch(Exception $e) {
    echo $e->getTraceAsString();
}
