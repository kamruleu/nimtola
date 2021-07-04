<?php  

class Porpt_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}

	public function dateWisePO($fdt, $tdt){
		$fields=array("DATE_FORMAT(xdate,'%d-%m-%Y') as xdate","xponum","xsup","xorg","xitemcode","xitemdesc","xqty","xratepur","xunitpur","xtotal");
			$where = " bizid = ". Session::get('sbizid') ." and xstatus = 'Confirmed' and xdate between '". $fdt ."' and '". $tdt ."'";
		
		return $this->db->select("vpodet", $fields, $where," order by ztime");
	}
	public function itemWisePO($fdt, $tdt){
		$fields=array("DATE_FORMAT(xdate,'%d-%m-%Y') as xdate","xponum","xitemcode","xitemdesc","xqty","xratepur","xunitpur","xtotal");
			$where = " bizid = ". Session::get('sbizid') ." and xstatus = 'Confirmed' and xdate between '". $fdt ."' and '". $tdt ."'";

		return $this->db->select("vpodet", $fields, $where, " ", " order by ztime");
	}
	
	public function supWisePO($fdt, $tdt, $sup=""){
		$cond="";
		if($sup!="")
			$cond = " and xsup='".$sup."'";

		$fields=array("DATE_FORMAT(xdate,'%d-%m-%Y') as xdate","xponum","xsup","xorg","xitemcode","xitemdesc","xqty","xratepur","xunitpur","xtotal");
			$where = " bizid = ". Session::get('sbizid') ." and xstatus = 'Confirmed' ".$cond." and xdate between '". $fdt ."' and '". $tdt ."'";
		
		return $this->db->select("vpodet", $fields, $where," order by ztime");
	}

	public function getsupdt($sup){
		$fields=array("xorg","xadd1");
			$where = " bizid = ". Session::get('sbizid') ." and xsup = '".$sup."'";
		
		return $this->db->select("sesup", $fields, $where);
	}
	
	public function getYearPer($year, $per){
		return $this->db->getYearPer($year,$per);
	}
	
		
}