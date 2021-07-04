<?php

class Customerupdate_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	
	public function editCustomer($data, $cus){
		
		$fields = array(
			
			"zutime"=>$data['zutime'],
			"xemail" => $data['xemail'],
			"xshort" => $data['xshort'],
			"xorg" => $data['xorg'],
			"xbillingadd" => $data['xbillingadd'],
			"xdeliveryadd" => $data['xdeliveryadd'],
			"xadd1" => $data['xadd1'],
			"xadd2" => $data['xadd2'],
			"xoccupation" => $data['xoccupation'],
			"xcountry" => $data['xcountry'],
			"xreligion" => $data['xreligion'],
			"xcontact" => $data['xcontact'],
			"xcity" => $data['xcity'],
			"xprovince" => $data['xprovince'],
			"xmobile" => $data['xmobile'],
			"xphone" => $data['xphone'],
			"xcusemail" => $data['xcusemail'],
			"xnid" => $data['xnid'],
			"xnoname" => $data['xnoname'],
			"xnorelation" => $data['xnorelation'],
			"nofather" => $data['nofather'],
			"xnoadd" => $data['xnoadd'],
			"xdob" => $data['xdob'],
			"xnoage" => $data['xnoage']
			);
			
			$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";
			 $results = $this->db->update('secus', $fields, $where);
			 return $results;
	}
	
	public function getCustomer($cus){
		$fields = array("*","(select xshort from agent where secus.bizid=agent.bizid and secus.xagent=agent.xagent) as xagname", "(select xadd1 from agent where secus.bizid=agent.bizid and secus.xagent=agent.xagent) as xagadd1");
		
		$where = "bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'" ;	
		
		return $this->db->select("secus", $fields, $where);
	}
	
}