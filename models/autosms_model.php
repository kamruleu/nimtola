<?php 

class Autosms_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	public function create($data){
			
		$results = $this->db->insert('smslog', array(
			"bizid"=>$data['bizid'],
			"zemail"=>$data['zemail'],
			"smsbody"=>$data['smsbody'],
			"xsmsfor"=>$data['xsmsfor'],
			"xactive"=>$data['xactive'],
			"xbranch"=>$data['xbranch']
			));
		
		return $results;	
	}
	
	public function getSingleSms($sl){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xsl = '". $sl ."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("smslog", $fields, $where);
	}
	
	public function getSmsByLimit($limit=""){
		$fields = array("xsl", "smsbody", "xsmsfor", "xactive");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xbranch ='". Session::get('sbranch') ."'";	
		return $this->db->select("smslog", $fields, $where, " order by xsl", $limit);
	}
	
	public function editSms($data, $sl){
		$results = array(
			"zemail"=>$data['zemail'],
			"smsbody"=>$data['smsbody'],
			"xsmsfor"=>$data['xsmsfor'],
			"xactive"=>$data['xactive']
			);
			
			$where = "bizid = ". Session::get('sbizid') ." and xsl=".$sl;
			return $this->db->update('smslog', $results, $where);
	}
	
	public function delete($where){
			//echo $where;die;
		$postdata=array(
			"xrecflag" => "Deleted",
			"xemail" => Session::get('suser'),
			"zutime" => date("Y-m-d H:i:s")
			);
		
		$this->db->update('smslog', $postdata, $where);
			
	}
	
}