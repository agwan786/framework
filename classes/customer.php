<?php
error_reporting(E_DEPRECATED);
class Customer extends objectModel{
	public function __construct(){
		parent::__construct();	
	}

    public function add(){        
        parent::add();
    }

    public function test(){
        echo "Altaf Husain";
    }
}

// try {
//     $cust = new Customer();
//     $data = array('table'=>'customer', 'insert'=>array('fname'=>'Altaf', 'lname'=>'Husain', 'email'=>'altaf.h@cisinlabs.com', 'password'=>md5('123456'), 'date'=>date('Y-m-d H:i:s')));
//     $cust->set('*',$data);
//     $cust->add();
// } catch(Exception $e) {
//     echo $e->getTraceAsString();
// }
