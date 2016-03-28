<?php
class Customer extends ObjectModel{	
	public static $definitation= array(
		'table'=>'customer',
		'primary'=>'id',
		'fields'=>array(
			'fname'=>array('require'=>true, 'type'=>'string'),
			'lname'=>array('require'=>false, 'type'=>'string'),
			'email'=>array('require'=>true, 'type'=>'string'),			
			'password'=>array('require'=>true, 'type'=>'string'),
			'status'=>array('type'=>'integer'),
			'date'=>array('require'=>true, 'type'=>'string'),
			)
		);
	public function __construct($id_customer=''){			
		parent::__construct($id_customer);
	}

    public function add(){      
        parent::add();
    }

    public function update(){
        parent::update();
    }
}
