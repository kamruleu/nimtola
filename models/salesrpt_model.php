<?php 
 
class Salesrpt_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}

	public function getsalesdt($xagent){
		
		$fields = array("xcus","xshort","xadd1","xmobile");
		$where = "bizid = ". Session::get('sbizid') ." and xagent='".$xagent."'";
		return $this->db->select("secus", $fields, $where);
	}

	public function getkatha($cus){
		
		$fields = array("sum(xqty) as xkatha","xblock","xroad");
		$where = "bizid = ". Session::get('sbizid') ." and xcus='".$cus."'";
		return $this->db->select("salesdt", $fields, $where,"group by xcus");
	}

	public function getploat($cus){
		
		$fields = array("xplot");
		$where = "bizid = ". Session::get('sbizid') ." and xcus='".$cus."'";
		return $this->db->select("salesdt", $fields, $where);
	}
	
	
	
}