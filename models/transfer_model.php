<?php

class Transfer_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	
	public function editAgent($data, $cus){
		
		$fields = array(
			
			"zutime"=>$data['zutime'],
			"xemail" => $data['xemail'],
			"xagent" => $data['xagent']
			);
			
			$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";
			 $results = $this->db->update('secus', $fields, $where);
			 return $results;
	}
	
	public function getCustomer($cus){
		$fields = array("xcus","xshort","xadd1","xagent","(select xshort from agent where secus.bizid=agent.bizid and secus.xagent=agent.xagent) as xagname", "(select xadd1 from agent where secus.bizid=agent.bizid and secus.xagent=agent.xagent) as xagadd1");
		
		$where = "bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'" ;	
		
		return $this->db->select("secus", $fields, $where);
	}

	public function getInsdt($cus){
		$fields = array("date_format(xdate, '%d-%m-%Y') as xdate","xinsnum","xinssl","xcus","xagent","xagentcom","xamount");
		
		$where = " bizid = ". Session::get('sbizid') ." and xbranch = '". Session::get('sbranch') ."' and xcus='".$cus."' and xamount>0";
		//print_r($where);die;
		return $this->db->select("vinscollsummary", $fields, $where);
	}

	public function editInsmst($fields,$where){
			 $results = $this->db->update('installmentmst', $fields, $where);
			 return $results;
	}

	public function getCusSale($cus){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'" ;
		//print_r($this->db->select("somst", $fields, $where));die;
		return $this->db->select("secus", $fields, $where);
	}

	public function getvsalesdt($cus){
		$fields = array("xrow","xitemcode","xrate","xqty","(xrate*xqty) as xsubtotal","(select xdesc from seitem where salesdt.bizid=seitem.bizid and salesdt.xitemcode=seitem.xitemcode) as xitemdesc");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";	
		return $this->db->select("salesdt", $fields, $where, " order by xrow");
	}
	public function getPlot($cus,$row){
		$fields = array("xdate","xcus","sum(xqty*xrate) as amt","xitemcode","xrate","xqty","(select xdesc from seitem where salesdt.bizid=seitem.bizid and salesdt.xitemcode=seitem.xitemcode) as xitemdesc","xrow");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."' and xrow='".$row."'";	
		return $this->db->select("salesdt", $fields, $where);
	}
	public function editPlot($data, $cus, $row){
		
		$fields = array(
			
			"zutime"=>$data['zutime'],
			"xemail" => $data['xemail'],
			"xitemcode" => $data['xitemcode'],
			"xitembatch" => $data['xitembatch'],
			"xblock" => $data['xblock'],
			"xroad" => $data['xroad'],
			"xplot" => $data['xplot']
			);
			
			$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."' and xrow='".$row."'";
			 $results = $this->db->update('salesdt', $fields, $where);
			 return $results;
	}

	public function getitem($cus,$row){
		$fields = array("xitemcode");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."' and xrow='".$row."'";	
		return $this->db->select("salesdt", $fields, $where);
	}
	public function itemupdate($item){
		$saldt = array (
						"xtaxcodepo"=>'Created'
						);
		$where = "bizid = ". Session::get('sbizid') ." and xitemcode = '". $item."'";
		return ($this->db->update('seitem', $saldt, $where));
	}
	public function saleItem($item){
		$saldt = array (
						"xtaxcodepo"=>'Confirmed'
						);
		$where = "bizid = ". Session::get('sbizid') ." and xitemcode = '". $item."'";
		return ($this->db->update('seitem', $saldt, $where));
	}
	public function getItemDt($item){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xitemcode = '". $item ."'";	
		return $this->db->select("seitem", $fields, $where);
	}
	
}