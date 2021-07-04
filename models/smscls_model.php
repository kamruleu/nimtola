<?php 

class Smscls_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	
	
	public function getTeacherNumber(){
		$fields = array("xmobile");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xbranch = '". Session::get('sbranch') ."' and xdesig='faculty'";	
		return $this->db->select("edfaculty", $fields, $where);
	}
	public function getEmployeeNumber(){
		$fields = array("xmobile");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xbranch = '". Session::get('sbranch') ."' and xdesig='employee'";	
		return $this->db->select("edfaculty", $fields, $where);
	}
	public function getParentsNumber(){
		$fields = array("xfmobile","xmmobile");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xbranch = '". Session::get('sbranch') ."'";	
		return $this->db->select("vstuenrolldt", $fields, $where);
	}
	public function getParentsNumberForPA($flag,$date){
		$fields = array("xfmobile","xmmobile");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and xdevice = 'Manual' and xdate = '".$date."' and bizid = ". Session::get('sbizid') ." and xattflag = '".$flag."' and xbranch = '". Session::get('sbranch') ."'";	
		return $this->db->select("vstuatt", $fields, $where);
	}
	
	public function getKeyValue($table,$keyfield,$prefix,$num){
		
		return $this->db->keyIncrement($table,$keyfield,$prefix,$num);
	}
	
}
// 1751291939