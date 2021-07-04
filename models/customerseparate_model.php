<?php 

class Customerseparate_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	
	public function editCustomer($cus){
		
		$fields = array(
			"xstatus" => 'Separated'
			);
			
			$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";
			 $results = $this->db->update('secus', $fields, $where);
			 return $results;
	}

	public function getCustomersByLimit(){
		$fields = array("xcus", "xshort", "xadd1","xmobile", "xcustype");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xstatus='Confirmed'";	
		return $this->db->select("secus", $fields, $where, " order by xcus desc");
	}

	public function getCustomerAll(){
		$fields = array("xcus", "xshort", "xadd1","xmobile", "xcustype");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xstatus='Separated'";	
		return $this->db->select("secus", $fields, $where, " order by xcus desc");
	}
	
	public function getCustomer($cus){
		$fields = array("*","(select xshort from agent where secus.bizid=agent.bizid and secus.xagent=agent.xagent) as xagname", "(select xadd1 from agent where secus.bizid=agent.bizid and secus.xagent=agent.xagent) as xagadd1");
		
		$where = "bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'" ;	
		
		return $this->db->select("secus", $fields, $where);
	}

	public function getSingleCustomer($cus){
		$fields = array("*");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xcus = '". $cus."' and xstatus='Confirmed'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("secus", $fields, $where);
	}

	public function glsalesinterface(){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xtypeinterface = 'Sales Separate Interface'";	
		return $this->db->select("glinterface", $fields, $where);
	}

	public function getsalesForConfirm($cus){
		$fields = array("xaccsub as xcus","sum(xprime) as ta");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xaccsub = '". $cus ."'";
		return $this->db->select("gldetail", $fields, $where);
	}

	public function getAcc($acc){
		$fields = array();
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xacc = '". $acc ."'";	
		return $this->db->select("glchart", $fields, $where);
	}

	public function getKeyValue($table,$keyfield,$prefix,$num){
		
		return $this->db->keyIncrement($table,$keyfield,$prefix,$num);
	}

	public function confirmgl($data, $dtcols, $dtdata){
		//print_r($data); die;	
		$mstdata = array(
			"bizid"=>$data['bizid'],
			"xvoucher"=>$data['xvoucher'],
			"xnarration"=>$data['xnarration'],
			"xyear"=>$data['xyear'],
			"xper"=>$data['xper'],
			"xstatusjv"=>"Created",
			"xbranch" => $data['xbranch'],
			"xdoctype" => $data['xdoctype'],
			"xdocnum" => $data['xdocnum'],
			"xdate" => $data['xdate'],			
			"zemail"=>$data['zemail']
			);
			
		$checkval = " bizid = " . $data['bizid'] . " and xvoucher ='" . $data['xvoucher'] ."'";
		$results = $this->db->insertMasterDetail('glheader',$mstdata,"gldetail",$dtcols, $dtdata,$checkval);
		
		return $results;
	}

	public function itemUpdate($cus){
		$fields = array(
			"xtaxcodepo" => 'Created'
			);
			
		$where = " bizid = ". Session::get('sbizid') ." and xitemcode in (select xitemcode from salesdt where salesdt.xcus='".$cus."')";
		$results = $this->db->update('seitem', $fields, $where);
		return $results;
	}
	
	public function installmentDelete($where){
		$this->db->dbdelete('installmentmst', $where);
			
	}
}