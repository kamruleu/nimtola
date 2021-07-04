<?php 

class Customers_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	public function createopeningbal($mstdata, $dtcols, $dtdata){
		//print_r($data); die;	
		
			
		$checkval = " bizid = 100 and xvoucher ='OP--000001'";
		$results = $this->db->insertMasterDetail('glheader',$mstdata,"gldetail",$dtcols, $dtdata,$checkval);
		
		return $results;	
	}
	public function create($data,$cols,$vals){



		$mstdata =  array(
			"bizid"=>$data['bizid'],
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
			"xsepcus"=>$data['xsepcus'],
			"xindustryseg" => $data['xindustryseg'],
			"xdiscountpct" => $data['xdiscountpct'],
			"xagent" => $data['xagent'],
			"xagentcom" => $data['xagentcom'],
			"xbookcom" => $data['xbookcom'],
			"xdevfee" => $data['xdevfee'],
			"xcommisionpct" => $data['xcommisionpct'],
			"xcreditlimit" => $data['xcreditlimit'],
			"xcreditterms" => $data['xcreditterms'],
			"zactive"=>$data['zactive'],
			"zemail"=>Session::get('suser'),
			"xoccupation"=>$data['xoccupation'],
			"xdob"=>$data['xdob'],
			"xreligion"=>$data['xreligion'],
			"xnoname"=>$data['xnoname'],
			"xnorelation"=>$data['xnorelation'],
			"xnoage"=>$data['xnoage'],
			"nofather"=>$data['nofather'],
			"xnoadd"=>$data['xnoadd'],
			"xsonum"=>$data['xsonum'],
			"xstatus"=>'Created',
			"xbookpay"=>$data['xbookpay'],
			"xdownpay"=>$data['xdownpay'],
			"xnotes"=>$data['xnotes'],
			"xtype"=>$data['xtype'],
			"xmonth"=>$data['xmonth'],
			"xmonthint"=>$data['xmonthint'],
			"xinsdate"=>$data['xinsdate'],
			"xquotnum"=>$data['xquotnum'],
			"xchequeno"=>$data['xchequeno'],
			"xchequedate"=>$data['xchequedate'],
			"xdate"=>$data['xdate'],
			"xper"=>$data['xper'],
			"xyear"=>$data['xyear']
			);

		
		$checkval = " bizid = " . $data['bizid'] . " and xcus ='" . $data['xcus'] . "'";

		$results = $this->db->insertMasterDetail('secus',$mstdata,"salesdt",$cols,$vals,$checkval);
		
		return $results;
		
	}

	public function InsCreate($icols,$ivals){
			
		$results = $this->db->insertMultipleDetail('installmentmst',$icols,$ivals);
		
		return $results;
		
	}
	
	public function editCustomer($data, $sdt, $cus, $row){
		$mstdata =  array(
			"bizid"=>$data['bizid'],
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
			"xsepcus"=>$data['xsepcus'],
			"xindustryseg" => $data['xindustryseg'],
			"xdiscountpct" => $data['xdiscountpct'],
			"xagent" => $data['xagent'],
			"xagentcom" => $data['xagentcom'],
			"xbookcom" => $data['xbookcom'],
			"xdevfee" => $data['xdevfee'],
			"xcommisionpct" => $data['xcommisionpct'],
			"xcreditlimit" => $data['xcreditlimit'],
			"xcreditterms" => $data['xcreditterms'],
			"zactive"=>$data['zactive'],
			"xoccupation"=>$data['xoccupation'],
			"xdob"=>$data['xdob'],
			"xreligion"=>$data['xreligion'],
			"xnoname"=>$data['xnoname'],
			"xnorelation"=>$data['xnorelation'],
			"xnoage"=>$data['xnoage'],
			"nofather"=>$data['nofather'],
			"xnoadd"=>$data['xnoadd'],
			"xstatus"=>'Created',
			"xbookpay"=>$data['xbookpay'],
			"xdownpay"=>$data['xdownpay'],
			"xnotes"=>$data['xnotes'],
			"xtype"=>$data['xtype'],
			"xmonth"=>$data['xmonth'],
			"xmonthint"=>$data['xmonthint'],
			"xinsdate"=>$data['xinsdate'],
			"xquotnum"=>$data['xquotnum'],
			"xchequeno"=>$data['xchequeno'],
			"xchequedate"=>$data['xchequedate'],
			"xdate"=>$data['xdate'],
			"xper"=>$data['xper'],
			"xyear"=>$data['xyear'],
			"xemail"=>$data['xemail'],
			"zutime"=>$data['zutime']
			);
		$saldt = array (
			"xitemcode"=>$sdt['xitemcode'],
			"xitembatch"=>$sdt['xitembatch'],
			"xqty"=>$sdt['xqty'],
			"xcost"=>$sdt['xcost'],
			"xrate"=>$sdt['xrate'],
			"xdisc"=>$sdt['xdisc'],
			"xtypestk"=>$sdt['xtypestk'],
			"xunitsale"=>$sdt['xunitsale'],
			"xwh"=>$sdt['xwh'],
			"xbranch"=>$sdt['xbranch'],
			"xproj"=>$sdt['xproj'],
			"xdate"=>$sdt['xdate'],
			"xyear" =>$sdt['xyear'],
			"xper" =>$sdt['xper']
				);
			
			/*if($itemauto=="NO")
				$results["xitemcode"] = $data['xitemcode']; print_r($results);die;*/
			//print_r($sdt);die;
			$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xcus = '". $cus."'";
			$this->db->update('secus', $mstdata, $where);

			$where = "bizid = ". Session::get('sbizid') ." and xcus = '". $cus."' and xrow=".$row;
			return ($this->db->update('salesdt', $saldt, $where));
	}

	public function confirm($postdata,$where){
		
		$this->db->update('secus', $postdata, $where);
			
	}

	public function Cancel($postdata,$where){
		
		$this->db->update('installmentmst', $postdata, $where);
			
	}
	
	public function getSingleCustomer($cus){
		$fields = array("*");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xcus = '". $cus."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("secus", $fields, $where);
	}

	public function getSingleInsdt($cus){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xcus = '". $cus."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("installmentmst", $fields, $where);
	}
	
	public function getCustomers($status){
		$fields = array("xcus", "xshort", "xadd1","xmobile", "xcustype");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and xstatus='".$status."' and bizid = ". Session::get('sbizid') ."";	
		return $this->db->select("secus", $fields, $where, " order by xcus desc");
	}

	public function getCustomersByLimit(){
		$fields = array("xcus", "xshort", "xadd1","xmobile", "xcustype");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ."";	
		return $this->db->select("secus", $fields, $where, " order by xcus desc");
	}

	public function getSeparatedCustomer(){
		$fields = array("xcus as xsepcus", "xshort", "xadd1","xmobile", "xcustype");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and xstatus='Separated' and bizid = ". Session::get('sbizid') ."";	
		return $this->db->select("secus", $fields, $where, " order by xcus desc");
	}
	
	public function getKeyValue($table,$keyfield,$prefix,$num){
		
		return $this->db->keyIncrement($table,$keyfield,$prefix,$num);
	}
	
	public function delete($where){
		$this->db->dbdelete('salesdt', $where);
			
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

	public function getsalesdata($cus){
		$fields = array("xdate","xcus","sum(xqty*xrate) as amt");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";	
		return $this->db->select("salesdt", $fields, $where, " GROUP BY xcus");
	}

	public function getsinglesalesdt($cus,$row){
		$fields = array("xdate","xcus","sum(xqty*xrate) as amt","xitemcode","xrate","xqty","(select xdesc from seitem where salesdt.bizid=seitem.bizid and salesdt.xitemcode=seitem.xitemcode) as xitemdesc","xrow");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."' and xrow='".$row."'";	
		return $this->db->select("salesdt", $fields, $where);
	}
	public function getSalesDt($cus){
		$fields = array("xitemcode","sum(xqty*xrate) as xtotrate","sum(xqty) as totkatha");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";	
		return $this->db->select("salesdt", $fields, $where,"group by xcus");
	}
	public function getSalesPlot($cus){
		$fields = array("xplot");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";	
		return $this->db->select("salesdt", $fields, $where,"order by xplot asc");
	}
	public function getItemDt($item){
		$fields = array("xcat","xcolor","xsize","xcitem");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xitemcode = '". $item ."'";	
		return $this->db->select("seitem", $fields, $where);
	}

	public function getitem($cus,$row){
		$fields = array("xitemcode");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."' and xrow='".$row."'";	
		return $this->db->select("salesdt", $fields, $where);
	}

	public function saleItem($item){
		$saldt = array (
						"xtaxcodepo"=>'Confirmed'
						);
		$where = "bizid = ". Session::get('sbizid') ." and xitemcode = '". $item."'";
		return ($this->db->update('seitem', $saldt, $where));
	}

	public function itemupdate($item){
		$saldt = array (
						"xtaxcodepo"=>'Created'
						);
		$where = "bizid = ". Session::get('sbizid') ." and xitemcode = '". $item."'";
		return ($this->db->update('seitem', $saldt, $where));
	}

	public function glsalesinterface(){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xtypeinterface = 'GL Sales Interface'";	
		return $this->db->select("glinterface", $fields, $where);
	}

	public function getsalesForConfirm($cus){
		$fields = array("xrow","xcus","(select xcommisionpct from secus where salesdt.bizid=secus.bizid and salesdt.xcus=secus.xcus) as xgrossdisc","(select xdownpay from secus where salesdt.bizid=secus.bizid and salesdt.xcus=secus.xcus) as xrcvamt","xitemcode","(select xdesc from seitem where salesdt.bizid=seitem.bizid and salesdt.xitemcode=seitem.xitemcode) as xitemdesc","xqty","xrate","xqty*xrate as ta","xqty*(xtaxrate*xrate/100) as tt","xqty*xdisc as id" );
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";
		return $this->db->select("salesdt", $fields, $where, " order by xrow");
	}

	public function getAcc($acc){
		$fields = array();
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xacc = '". $acc ."'";	
		return $this->db->select("glchart", $fields, $where);
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
	public function confirmbpay($data, $dtcols, $dtdata){
		//print_r($data); die;	
		$mstdata = array(
			"bizid"=>$data['bizid'],
			"xvoucher"=>$data['xvoucher'],
			"xnarration"=>$data['xnarration'],
			"xyear"=>$data['xyear'],
			"xper"=>$data['xper'],
			"xstatusjv"=>"Created",
			"xbranch" => $data['xbranch'],
			"xdoctype" =>'Booking Payment',
			"xdocnum" => $data['xdocnum'],
			"xdate" => $data['xdate'],			
			"zemail"=>$data['zemail']
			);
			
		$checkval = " bizid = " . $data['bizid'] . " and xvoucher ='" . $data['xvoucher'] ."'";
		$results = $this->db->insertMasterDetail('glheader',$mstdata,"gldetail",$dtcols, $dtdata,$checkval);
		
		return $results;
	}

	public function getPlotDetail(){
		$fields = array("xcus", "xshort", "xitemcode","xdesc", "xblock","xroad","xplot","xqty");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and xstatus !='Canceled' and bizid = ". Session::get('sbizid') ."";	
		return $this->db->select("vplotsalesdt", $fields, $where, " order by xcus desc");
	}
	
}
