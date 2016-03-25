<?php
class Customer extends objectModel{	
	public static $definitation= array(
		'table'=>'customer',
		'primary'=>'id',
		'fields'=>array(
			'fname'=>array('require'=>true, 'type'=>'string'),
			'lname'=>array('require'=>true, 'type'=>'string'),
			'email'=>array('require'=>true, 'type'=>'string'),			
			)
		);
	public function __construct($id_customer=''){			
		parent::__construct();	
		if($id_customer){
			$this->return = 1;
			$this->where = array('id'=>$id_customer);
			//echo "<pre>";print_r($this->getData());
		}
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
