<?php
include_once('mySQLModel.php');
abstract class ObjectModel extends mySQLModel{
	private $foo = array();
	private $errors;
	private $sql;
	
	public function __construct(){
		parent::__construct();				
	}

	public function set($name,$value){
		if($name=='*'){
			foreach($value as $key=>$val){
				$this->foo[$key] = $val;
			}
		}else{
			$this->foo[$name] = $value;
		}
	}

	public function get($name){
		return $this->foo[$name];
	}

	public function getData(){
		$this->sql = 'SELECT ';
		$where = '';
		$where_or = '';
		$where_in = '';
		$where_like = '';
		$order_by = '';
		if("null!=$this->get('select')"){
			$this->sql .= $this->get('select');
		}else{
			$this->sql .= "*";
		}
		$this->sql .=  " FROM {$this->get('table')} ";
		$this->where_condition();

		if($ordered = $this->get('order_by') && isset($ordered)){
			foreach ($this->get('order_by') as $key => $value) {
				$order_by .= "{$key} {$value}, ";
			}
			if($order_by!='')
				$order_by = 'ORDER BY '.rtrim($order_by, ",");
		}

		if("null!=$this->get('return')")
			$this->sql .= ' LIMIT 1';

		return $records = $this->executeS($this->sql);
	}

	public function add($dat){
		$this->sql = 'INSERT INTO {$this->get("table")} ';
		$columns = '';
		$values = '';
		foreach ($this->get('insert') as $key => $value) {
			$columns .= $key.", ";
			$values .= "'".$values."', ";
		}
		$columns = rtrim($columns, ",");
		$values = rtrim($values, ",");

		$this->sql = $this->sql."( ".$columns." ) VALUES (". $values. ")";
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
		if("null!=$this->get('where')"){
			foreach ($this->get('where') as $key => $value) {
				$where .= "{$key}='{$value}' AND ";
			}
			if($where!='')
				$where = rtrim($where, "AND");		
		}
		if("null!=$this->get('where_or')"){
			foreach ($this->get('where_or') as $key => $value) {
				$where_or .= "{$key}='{$value}' OR ";
			}
			if($where_or!='')
				$where_or = rtrim($where_or, "OR");
		}
		if("null!=$this->get('where_in')"){
			foreach ($this->get('where_in') as $key => $value) {
				$where_in .= "{$key} IN ({$value}) AND ";
			}
			if($where_in!='')
				$where_in = rtrim($where_in, " AND");
		}
		if("null!=$this->get('where_like')"){
			foreach ($this->get('where_like') as $key => $value) {
				$where_like .= "{$key} LIKE %{$value}% AND ";
			}
			if($where_like!='')
				$where_like = rtrim($where_like, " AND");
		}
		if($where!='' || $where_or!='' || $where_in!='' || $where_like!='')
			$this->sql .= "WHERE ".($where!='')?$where." AND ":($where_or!='')?$where_or." AND ":($where_in!='')?$where_in." AND ":($where_like!='')?$where_like." AND ":"";

		$this->sql = rtrim($this->sql,"AND");
	}
}