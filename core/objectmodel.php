<?php
abstract class ObjectModel extends Mysql{
	private $foo = array();
	private $errors;
	private $sql;
	private $class;
	private $setData = array();
	private $data = array();
	public $getData = array();
	public $allQuery = array();
	
	public function __construct($id=''){
		parent::__construct();
		$this->class = strtolower(get_class($this));
		$obj = new ReflectionClass($this->class);
		$this->data = $obj->getStaticPropertyValue('definitation');
		if($id!=''){
			$this->where = array($this->data['primary']=>$id);
			$this->order_by = array($this->data['primary']=>'desc');
			$this->return = 1;
			$this->getData = $this->select();
		}
	}	

	public function __set($name, $value){
		$this->foo[$name] = $value;	
	}

	public function __get($name){
		return $this->foo[$name];
	}

	protected function select(){
		//$this->def($this->data);
		$this->sql = 'SELECT ';		
		$order_by = '';
		if(isset($this->foo['select'])){
			$this->sql .= $this->foo['select'];
		}else{
			$this->sql .= "*";
		}
		$this->sql .=  " FROM ".$this->class;
		if(isset($this->foo['where']))
			$this->where_condition();

		if(isset($this->foo['order_by']) && $ordered = $this->foo['order_by']){
			foreach ($this->foo['order_by'] as $key => $value) {
				$order_by .= "{$key} {$value}, ";
			}
			if($order_by!='')
				$order_by = 'ORDER BY '.rtrim($order_by, ",");
		}

		if(isset($this->foo['return']))
			$this->sql .= ' LIMIT 1';
		$this->allQuery[] = $this->sql."<br/>";
		$records = $this->executeS($this->sql);
		//$this->unsetData();
		return $records;
	}

	protected function add(){
		$this->def($this->data);
		if(empty($this->errors)){
			$this->sql = 'INSERT INTO '.$this->class;
			$columns = '';
			$values = '';
			foreach ($this->setData as $key => $value) {
				$columns .= $key.", ";
				$values .= "'".mysql_real_escape_string($value)."', ";
			}
			$columns = rtrim($columns, " , ");
			$values = rtrim($values, " , ");

			$this->sql = $this->sql."( ".$columns." ) VALUES (". $values. ")";
			$this->allQuery[] = $this->sql."<br/>";
			$return = $this->execute($this->sql);
			$this->unsetData();
			return $id = $return;
		}else{
			$strErr = '';
			foreach($this->errors as $sqlErr)
				$strErr .= $sqlErr. "<br/>";
			$this->unsetData();
			throw new Exception($strErr);
		}
	}

	protected function update(){		
		$this->def($this->data);
		$set = '';
		$where = '';
		$where_or = '';
		$where_in = '';
		$where_like = '';
		$this->sql = 'UPDATE '.$this->class.' SET ';

		foreach ($this->setData as $key => $value) {
			$set = "$key='".$value."', ";
		}
		$set = rtrim($set, ",");
		$this->sql .= $set ." ";
		$this->where_condition();
		$this->allQuery[] = $this->sql."<br/>";
		$return = $this->execute($this->sql);
		$this->unsetData();
		return $return;
	}

	private function where_condition(){
		$where = '';
		$where_or = '';
		$where_in = '';
		$where_like = '';
		// if(isset($this->data['primary']))
		// 	$where .= $this->data['primary']." = '".$this->getData[$this->data['primary']]."'";
		if(isset($this->foo['where'])){
			foreach ($this->foo['where'] as $key => $value)
				$where .= $key."='".$value."' AND ";
			
			if($where!='')
				$where = rtrim($where, " AND ");		
		}
		
		if(isset($this->foo['where_or'])){
			foreach ($this->foo['where_or'] as $key => $value) {
				$where_or .= "{$key}='".$value."' OR ";
			}
			if($where_or!='')
				$where_or = rtrim($where_or, "OR");
		}
		if(isset($this->foo['where_in'])){
			foreach ($this->foo['where_in'] as $key => $value) {
				$where_in .= "{$key} IN (".$value.") AND ";
			}
			if($where_in!='')
				$where_in = rtrim($where_in, " AND");
		}
		if(isset($this->foo['where_like'])){
			foreach ($this->get('where_like') as $key => $value) {
				$where_like .= "{$key} LIKE %".$value."% AND ";
			}
			if($where_like!='')
				$where_like = rtrim($where_like, " AND");
		}
		if($where!='' || $where_or!='' || $where_in!='' || $where_like!=''){
			$this->sql .= " WHERE ";
			if($where!='')
				$this->sql .= ($where!='')?$where." AND ":"";
			else if ($where_or!='')
				$this->sql .= ($where_or!='')?$where_or." AND ":"";
			else if ($where_in!='')
				$this->sql .= ($where_in!='')?$where_in." AND ":"";
			else if ($where_like!='')
				$this->sql .= ($where_like!='')?$where_like." AND ":"";
			else
				$this->sql .= " AND ";			
		}		
		$this->sql = rtrim($this->sql," AND ");
	}

	private function def($data = array()){
		$obj = new Validation();
		foreach($data['fields'] as $key=>$value){			
			if(isset($value['require']) && $value['require']){
				if(!isset($this->foo[$key]) || $this->foo[$key]=="" || $this->foo[$key]==null){
					if(!isset($this->getData[$key]))
						$this->errors[] = ucwords($key)." can't be null or blank";
					else
						$this->foo[$key] = $this->getData[$key];
				}
				if(!$isValid = $obj->validate($value['type'], $this->foo[$key]))
					$this->errors[] = ucwords($key)." isn't {$value['type']}";
				if(!$fieldData = $obj->xss_clean($this->foo[$key]))
					$this->errors[] = ucwords($key)." isn't passed xss clean security";
				if(empty($this->errors))
					$fieldValue = isset($this->foo[$key])?$this->foo[$key]:$this->getData[$key];
			}else{
				$fieldValue = isset($this->foo[$key])?$this->foo[$key]:"";
			}
			$this->setData[$key] = $fieldValue;
		}

	}

	private function unsetData(){
		unset($this->foo);
		unset($this->setData);
		unset($this->errors);
	}

}