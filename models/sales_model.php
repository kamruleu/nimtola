<?php 

class Sales_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	public function create($data, $dtcols, $dtdata){
		//print_r($data); die;	
		$mstdata = array(
			"bizid"=>$data['bizid'],
			"xsonum"=>$data['xsonum'],
			"xwh"=>$data['xwh'],
			"xbranch"=>Session::get('sbranch'),
			"xproj"=>Session::get('sbranch'),
			"xstatus"=>"Created",
			"xdate" => $data['xdate'],
			"zemail"=>$data['zemail'],
			"xcus"=>$data['xcus'],
			"xcusbal"=>$data['xcusbal'],
			"xtruckfair"=>$data['xtruckfair'],
			"xmanager"=>$data['xmanager'],
			"xnotes"=>$data['xnotes'],
			"xquotnum"=>$data['xquotnum'],
			"xgrossdisc"=>$data['xgrossdisc'],
			"xrcvamt"=>$data['xrcvamt'],	
			"xyear"=>$data['xyear'],
			"xper"=>$data['xper']
			);
		$somstdata = array(
			
			"xwh"=>$data['xwh'],
			"xcus"=>$data['xcus'],
			"xcusbal"=>$data['xcusbal'],
			"xtruckfair"=>$data['xtruckfair'],
			"xnotes"=>$data['xnotes'],
			"xquotnum"=>$data['xquotnum'],
			"xdate" => $data['xdate'],
			"xgrossdisc"=>$data['xgrossdisc'],
			"xrcvamt"=>$data['xrcvamt']
			);

		$sodetdata = array(

			"xcus"=>$data['xcus'],
			"xdate" => $data['xdate']
			);
			
		$checkval = " bizid = " . $data['bizid'] . " and xsonum ='" . $data['xsonum'] . "'";
		
		$results = $this->db->insertMasterDetail('somst',$mstdata,"sodet",$dtcols, $dtdata,$checkval);

		$upsomst = " bizid = " . Session::get('sbizid') . " and xsonum ='" . $data['xsonum'] . "'";
		$upsodet = " bizid = " . Session::get('sbizid') . " and xsonum ='" . $data['xsonum'] . "'";
		$this->db->update('somst', $somstdata, $upsomst);
		$this->db->update('sodet', $sodetdata, $upsodet);
		
		return $results;	
	}
	
	
	public function edit($data,$dt,$sonum,$row){
		$header = array(
			"xemail"=>Session::get('suser'),
			"zutime"=>date("Y-m-d H:i:s"),
			"xdate"=>$data['xdate'],
			"xcus"=>$data['xcus'],
			"xcusbal"=>$data['xcusbal'],
			"xtruckfair"=>$data['xtruckfair'],
			"xmanager"=>$data['xmanager'],
			"xwh"=>$data['xwh'],			
			"xnotes"=>$data['xnotes'],
			"xquotnum"=>$data['xquotnum'],
			"xgrossdisc"=>$data['xgrossdisc'],
			"xrcvamt"=>$data['xrcvamt'],	
			"xyear"=>$data['xyear'],
			"xper"=>$data['xper']
			);
		$detail = array(
					"xitemcode"=>$dt['xitemcode'],
					"xqty"=>$dt['xqty'],
					"xcus"=>$dt['xcus'],
					"xextqty"=>$dt['xextqty'],
					"xrate"=>$dt['xrate'],
					"xdisc"=>$dt['xdisc'],
					"xunitsale"=>$dt['xunitsale'],
					"xtypestk"=>$dt['xtypestk'],
					"xwh"=>$dt['xwh'],
					"xbranch"=>$dt['xwh'],
					"xproj"=>$dt['xproj'],
					"xdate"=>$dt['xdate'],
					"xyear"=>$data['xyear'],
					"xper"=>$data['xper'],
					"xcost"=>$dt['xcost']
		);

		$updt = array(
					
					"xcus"=>$dt['xcus'],
					"xdate" => $data['xdate']
		);
		//print_r($header); print_r($detail);die;
			$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum."'";
			$this->db->update('somst', $header, $where);

			$wher = "bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum."'";
			$this->db->update('sodet', $updt, $wher);
			
			$where = "bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum."' and xrow=".$row;
			return ($this->db->update('sodet', $detail, $where));	
	}

	public function savedelivery($data, $dtcols, $dtdata){
		//print_r($data); die;	
		$mstdata = array(
			"bizid"=>$data['bizid'],
			"xreqdelnum"=>$data['xreqdelnum'],
			"xsonum"=>$data['xsonum'],
			"xwh"=>$data['xwh'],
			"xbranch"=>$data['xbranch'],
			"xproj"=>$data['xproj'],
			"xstatus"=>$data['xstatus'],
			"xdate" => $data['xdate'],
			"xsalesdate" => $data['xsalesdate'],
			"zemail"=>$data['zemail'],
			"xcus"=>$data['xcus'],						
			"xgrossdisc"=>$data['xgrossdisc'],
			"xfinyear"=>$data['xfinyear'],
			"xfinper"=>$data['xfinper']
			);
			//print_r($mstdata); die;
		$checkval = " bizid = " . $data['bizid'] . " and xreqdelnum ='" . $data['xreqdelnum'] . "'";
		
		$results = $this->db->insertMasterDetail('imreqdelmst',$mstdata,"imreqdeldet",$dtcols, $dtdata,$checkval);
		
		return $results;	
	}
	
	public function getSales($sonum){
		$fields = array("*","(select xorg from secus where secus.bizid=somst.bizid and secus.xcus=somst.xcus) as xorg",
		"(select xadd1 from secus where secus.bizid=somst.bizid and secus.xcus=somst.xcus) as xadd1",
		"(select xphone from secus where secus.bizid=somst.bizid and secus.xcus=somst.xcus) as xphone");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum ."'" ;	
		//print_r($this->db->select("somst", $fields, $where));die;
		return $this->db->select("somst", $fields, $where);
	}




	public function getSingleSalesDt($sonum, $row){
		$fields = array("*",
		"(select xdesc from seitem where sodet.bizid=seitem.bizid and sodet.xitemcode=seitem.xitemcode) as xitemdesc");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum ."' and xrow = ". $row;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("sodet", $fields, $where);
	}
	
	public function getrodqty($sonum){
		$fields = array("COALESCE(sum(xqty),0) as xqty","COALESCE(sum(xextqty),0) as xextqty");
		
		$where = "bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum ."' and xcat='Rod'";	
		
		return $this->db->select("vsalesdt", $fields, $where);
	}

	public function getagentmbl($cus){
		$fields = array("xdesc");
		
		$where = "bizid = ". Session::get('sbizid') ." and xcodetype = 'Salesman' and xcode=(SELECT xagent from secus WHERE xcus='".$cus."')";	
		
		return $this->db->select("secodes", $fields, $where);
	}
	
	public function getcementqty($sonum){
		$fields = array("COALESCE(sum(xqty),0) as xqty");
		
		$where = "bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum ."' and xcat='Cement'";	
		
		return $this->db->select("vsalesdt", $fields, $where);
	}
	
	public function getsalesdt($sonum){
		$fields = array("xrow",
		"xitemcode","(select xdesc from seitem where sodet.bizid=seitem.bizid and sodet.xitemcode=seitem.xitemcode) as xitemdesc",	
		"xqty","xrate","xqty*xrate as xsalestotal","xqty*xdisc as xtotaldisc" );
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum ."'";	
		return $this->db->select("sodet", $fields, $where, " order by xrow");
	}
	public function getsalesForConfirm($sonum){
		$fields = array("xrow","xcus","xgrossdisc","xrcvamt",
		"xitemcode","(select xdesc from seitem where vsalesdt.bizid=seitem.bizid and vsalesdt.xitemcode=seitem.xitemcode) as xitemdesc",	
		"xqty","xrate","xqty*xrate as ta","xqty*(xtaxrate*xrate/100) as tt","xqty*xdisc as id","xtruckfair" );
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum ."'";	
		return $this->db->select("vsalesdt", $fields, $where, " order by xrow");
	}
	public function getvsalesdt($sonum){
		$fields = array("*",
		"(select xdesc from seitem where vsalesdt.bizid=seitem.bizid and vsalesdt.xitemcode=seitem.xitemcode) as xitemdesc","(select xorg from secus where secus.bizid=vsalesdt.bizid and secus.xcus=vsalesdt.xcus) as xorg"
		,"(select xadd1 from secus where secus.bizid=vsalesdt.bizid and secus.xcus=vsalesdt.xcus) as xadd"
		,"(select xphone from secus where secus.bizid=vsalesdt.bizid and secus.xcus=vsalesdt.xcus) as xphone");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum ."'";	
		return $this->db->select("vsalesdt", $fields, $where, " order by xrow");
	}

	public function gettotalsale($sonum){
		$fields = array("(sum(xqty*xrate)+sum(xtaxtotal)-sum(xdisctotal)) as xtotal");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum ."'";	
		return $this->db->select("vsalesdt", $fields, $where);
	}

	public function glsalesinterface(){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xtypeinterface = 'GL Sales Interface'";	
		return $this->db->select("glinterface", $fields, $where);
	}
	public function getSalesList($status){
		$fields = array("date_format(xdate, '%d-%m-%Y') as xdate","xsonum","xcus","(select xorg from secus where secus.bizid=somst.bizid and secus.xcus=somst.xcus) as xorg","xcusdoc");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and xstatus='".$status."' and bizid = ". Session::get('sbizid') ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("somst", $fields, $where);
	}

	public function getsomilestone($txnnum){
		$fields = array("*");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xsonum = '". $txnnum ."'" ;	
		//print_r($this->db->select("somst", $fields, $where));die;
		return $this->db->select("vsomilestone", $fields, $where);
	}
	
	
	
	public function confirm($postdata,$where){
		
		$this->db->update('somst', $postdata, $where);
			
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
	
	
	public function getItemMaster($xitem,$xval){
		return $this->db->getItemMaster($xitem,$xval);
	}
	
	public function getItemcost($item){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "bizid = ". Session::get('sbizid') ." and xitemcode = '". $item ."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("vitemcost", $fields, $where);
	}
	
	
	public function getcustomer($cus){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("secus", $fields, $where);
	}

	public function getcuscrelimit($sonum){
		$fields = array("xcus","(((xcusbal-xgrossdisc)+(select sum((xqty*xrate)-xdisc) from sodet WHERE xsonum='".$sonum."' AND sodet.bizid=somst.bizid))-xrcvamt) as totdueamt");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "bizid = ". Session::get('sbizid') ." and xsonum = '". $sonum ."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("somst", $fields, $where);
	}
	
	public function getcustomerbal($cus){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "bizid = ". Session::get('sbizid') ." and xaccsub = '". $cus ."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("vcustomerbal", $fields, $where);
	}


	public function getItemMasterCost($item){
		return $this->db->getItemCost($item);
	}
	
	public function getKeyValue($table,$keyfield,$prefix,$num){
		
		return $this->db->keyIncrement($table,$keyfield,$prefix,$num);
	}
	
	public function getYearPer($year, $per){
		return $this->db->getYearPer($year,$per);
	}
	public function getRow($table,$keyfield,$num, $xrow){
		
		return $this->db->rowIncrement($table,$keyfield,$num, $xrow);
	}
	public function recdelete($where){
		$this->db->dbdelete('sodet', $where);
	}
public function getItemStock($xitemcode, $xwh){
			return $this->db->getIMBalance($xitemcode, $xwh);
		}
	public function getAcc($acc){
		$fields = array();
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xacc = '". $acc ."'";	
		return $this->db->select("glchart", $fields, $where);
	}
	
}