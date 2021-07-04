<?php 

class Smsindividual_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	
	public function getKeyValue($table,$keyfield,$prefix,$num){
		
		return $this->db->keyIncrement($table,$keyfield,$prefix,$num);
	}
	
}