<?php
abstract class ObjectModel extends Mysql{
	private $foo = array();
	private $errors;
	private $sql;
	private $class;
	private $setData = array();
	
	public function __construct(){
		parent::__construct();
		$this->class = strtolower(get_class($this));
		$obj = new ReflectionClass($this->class);
		$data = $obj->getStaticPropertyValue('definitation');
		$this->def($data);
	}	

	public function __set($name,$value){
		$this->foo[$name] = $value;		
	}

	public function __get($name){
		return $this->foo[$name];
	}

	public function getData(){
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
			
		return $records = $this->executeS($this->sql);
	}

	public function add(){
		$this->sql = 'INSERT INTO '.$this->class;
		$columns = '';
		$values = '';

		foreach ($this->setData as $key => $value) {
			$columns .= $key.", ";
			$values .= "'".$this->foo[$key]."', ";
		}
		$columns = rtrim($columns, " , ");
		$values = rtrim($values, " , ");

		$this->sql = $this->sql."( ".$columns." ) VALUES (". $values. ")";
		echo $this->sql;die;
		$this->execute($this->sql);
		return $id = mysql_insert_id();
	}

	public function update(){
		$set = '';
		$where = '';
		$where_or = '';
		$where_in = '';
		$where_like = '';
		$this->sql = 'UPDATE {$this->get("table")} SET ';
		foreach ($this->get('update') as $key => $value) {
			$set = "{$key}='{$value}', ";
		}
		$set = rtrim($set, ",");
		$this->sql .= $set ." ";
		$this->where_condition();
		$this->execute($this->sql);
		return mysql_affected_rows();
	}

	public function where_condition(){
		$where = '';
		$where_or = '';
		$where_in = '';
		$where_like = '';
		if(isset($this->foo['where'])){
			foreach ($this->foo['where'] as $key => $value)
				$where .= $key."='".$value."' AND ";
			
			if($where!='')
				$where = rtrim($where, " AND ");		
		}
		
		if(isset($this->foo['where_or'])){
			foreach ($this->foo['where_or'] as $key => $value) {
				$where_or .= "{$key}='{$value}' OR ";
			}
			if($where_or!='')
				$where_or = rtrim($where_or, "OR");
		}
		if(isset($this->foo['where_in'])){
			foreach ($this->foo['where_in'] as $key => $value) {
				$where_in .= "{$key} IN ({$value}) AND ";
			}
			if($where_in!='')
				$where_in = rtrim($where_in, " AND");
		}
		if(isset($this->foo['where_like'])){
			foreach ($this->get('where_like') as $key => $value) {
				$where_like .= "{$key} LIKE %{$value}% AND ";
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

	public function def($data){
		foreach($data['fields'] as $key=>$value){
			$this->setData[$key] = $this->foo[$key];
		}
	}
}