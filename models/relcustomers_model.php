<?php

class Relcustomers_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	public function createopeningbal($mstdata, $dtcols, $dtdata){
		//print_r($data); die;	
		
			
		$checkval = " bizid = 100 and xvoucher ='OP--000001'";
		$results = $this->db->insertMasterDetail('glheader',$mstdata,"gldetail",$dtcols, $dtdata,$checkval);
		
		return $results;	
	}
	public function create($ccols,$cvals,$mcols,$mvals,$cols,$vals){
			
		// $results = $this->db->insert('secus', array(
		// 	"bizid"=>$data['bizid'],
		// 	"xcus"=>$data['xcus'],
		// 	"xshort"=>$data['xshort'],
		// 	"xorg"=>$data['xorg'],
		// 	"xadd1"=>$data['xadd1'],
		// 	"xadd2"=>$data['xadd2'],
		// 	"xbillingadd" => $data['xbillingadd'],
		// 	"xdeliveryadd" => $data['xdeliveryadd'],
		// 	"xcity" => $data['xcity'],
		// 	"xprovince" => $data['xprovince'],
		// 	"xpostal" => $data['xpostal'],
		// 	"xcountry" => $data['xcountry'],
		// 	"xcontact" => $data['xcontact'],
		// 	"xtitle" => $data['xtitle'],
		// 	"xphone" => $data['xphone'],
		// 	"xcusemail" => $data['xcusemail'],
		// 	"xmobile" => $data['xmobile'],
		// 	"xfax" => $data['xfax'],
		// 	"xweburl" => $data['xweburl'],
		// 	"xnid" => $data['xnid'],
		// 	"xtaxno" => $data['xtaxno'],
		// 	"xtaxscope" => $data['xtaxscope'],
		// 	"xgcus" => $data['xgcus'],
		// 	"xpricegroup" => $data['xpricegroup'],
		// 	"xcustype" => $data['xcustype'],
		// 	"xindustryseg" => $data['xindustryseg'],
		// 	"xdiscountpct" => $data['xdiscountpct'],
		// 	"xagent" => $data['xagent'],
		// 	"xcommisionpct" => $data['xcommisionpct'],
		// 	"xcreditlimit" => $data['xcreditlimit'],
		// 	"xcreditterms" => $data['xcreditterms'],
		// 	"zactive"=>$data['zactive'],
		// 	"zemail"=>Session::get('suser'),
		// 	));

		// $mstdata = array(
		// 	"bizid"=>$data['bizid'],
		// 	"xsonum"=>$data['xsonum'],
		// 	"xwh"=>"None",
		// 	"xbranch"=>Session::get('sbranch'),
		// 	"xproj"=>Session::get('sbranch'),
		// 	"xstatus"=>"Created",
		// 	"xdate" => $data['xdate'],
		// 	"zemail"=>$data['zemail'],
		// 	"xcus"=>$data['xcus'],
		// 	"xcusbal"=>"0",
		// 	"xtruckfair"=>"0",
		// 	"xnotes"=>$data['xnotes'],
		// 	"xrcvamt"=>$data['xrcvamt'],	
		// 	"xyear"=>$data['xyear'],
		// 	"xper"=>$data['xper']
		// 	);

		$cresults = $this->db->insertMultipleDetail('secus',$ccols,$cvals);
		$mresults = $this->db->insertMultipleDetail('somst',$mcols,$mvals);
		$results = $this->db->insertMultipleDetail('sodet',$cols,$vals);
		
		return $results;
		
	}

	public function InsCreate($icols,$ivals){
			
		$results = $this->db->insertMultipleDetail('installmentmst',$icols,$ivals);
		
		return $results;
		
	}
	
	public function editCustomer($data, $cus){
		$results = array(
			"xcus"=>$data['xcus'],
			"xshort"=>$data['xshort'],
			"xorg"=>$data['xorg'],
			"xadd1"=>$data['xadd1'],
			"xadd2"=>$data['xadd2'],
			"xbillingadd" => $data['xbillingadd'],
			"xdeliveryadd" => $data['xdeliveryadd'],
			"xcity" => $data['xcity'],
			"xprovince" => $data['xprovince'],
			"xpostal" => $data['xpostal'],
			"xcountry" => $data['xcountry'],
			"xcontact" => $data['xcontact'],
			"xtitle" => $data['xtitle'],
			"xphone" => $data['xphone'],
			"xcusemail" => $data['xcusemail'],
			"xmobile" => $data['xmobile'],
			"xfax" => $data['xfax'],
			"xweburl" => $data['xweburl'],
			"xnid" => $data['xnid'],
			"xtaxno" => $data['xtaxno'],
			"xtaxscope" => $data['xtaxscope'],
			"xgcus" => $data['xgcus'],
			"xpricegroup" => $data['xpricegroup'],
			"xcustype" => $data['xcustype'],
			"xindustryseg" => $data['xindustryseg'],
			"xdiscountpct" => $data['xdiscountpct'],
			"xagent" => $data['xagent'],
			"xcommisionpct" => $data['xcommisionpct'],
			"xcreditlimit" => $data['xcreditlimit'],
			"xcreditterms" => $data['xcreditterms'],
			"zactive" => $data['zactive']
			);
			
			/*if($itemauto=="NO")
				$results["xitemcode"] = $data['xitemcode']; print_r($results);die;*/
			
			
			
			if(Session::get('sbizcusauto')=='NO')
				$results["xcus"] = $data['xcus'];
			
			$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xcus = '". $cus."'";
			return $this->db->update('secus', $results, $where);
	}
	
	public function getSingleCustomer($cus){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xcus = '". $cus."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("secus", $fields, $where);
	}
	
	public function getCustomersByLimit($limit=""){
		$fields = array("xcus", "xorg", "xadd1","xmobile", "xcustype");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ."";	
		return $this->db->select("secus", $fields, $where, " order by xcus desc", $limit);
	}
	
	public function getKeyValue($table,$keyfield,$prefix,$num){
		
		return $this->db->keyIncrement($table,$keyfield,$prefix,$num);
	}
	
	public function delete($where){
			//echo $where;die;
		$postdata=array(
			"xrecflag" => "Deleted",
			"xemail" => Session::get('suser'),
			"zutime" => date("Y-m-d H:i:s")
			);
		
		$this->db->update('secus', $postdata, $where);
			
	}

	public function getItemMaster($xitem,$xval){
		return $this->db->getItemMaster($xitem,$xval);
	}

	public function getYearPer($year, $per){
		return $this->db->getYearPer($year,$per);
	}

	public function getRow($table,$keyfield,$num, $xrow){
		
		return $this->db->rowIncrement($table,$keyfield,$num, $xrow);
	}

	public function getSales($sonum){
		$fields = array("*","(select xorg from secus where secus.bizid=somst.bizid and secus.xcus=somst.xcus) as xorg",
		"(select xadd1 from secus where secus.bizid=somst.bizid and secus.xcus=somst.xcus) as xadd1",
		"(select xphone from secus where secus.bizid=somst.bizid and secus.xcus=somst.xcus) as xphone");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xcus = '". $sonum ."'" ;
		//print_r($this->db->select("somst", $fields, $where));die;
		return $this->db->select("somst", $fields, $where);
	}

	public function getvsalesdt($sonum){
		$fields = array("*",
		"(select xdesc from seitem where vsalesdt.bizid=seitem.bizid and vsalesdt.xitemcode=seitem.xitemcode) as xitemdesc","(select xorg from secus where secus.bizid=vsalesdt.bizid and secus.xcus=vsalesdt.xcus) as xorg"
		,"(select xadd1 from secus where secus.bizid=vsalesdt.bizid and secus.xcus=vsalesdt.xcus) as xadd"
		,"(select xphone from secus where secus.bizid=vsalesdt.bizid and secus.xcus=vsalesdt.xcus) as xphone");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $sonum ."'";	
		return $this->db->select("vsalesdt", $fields, $where, " order by xrow");
	}
	
}