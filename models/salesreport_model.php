<?php
 
class Salesreport_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	

	public function getinsdetail($fdate,$tdate,$xagent){
		$temp = "";
		if($xagent!="")
			$temp = " and (SELECT xagent from secus where secus.bizid = installmentmst.bizid and secus.xcus = installmentmst.xcus)='".$xagent."'";
		
		$fields = array("xinsnum", "xcus", "(SELECT xorg from secus WHERE secus.xcus=installmentmst.xcus) AS xorg","(SELECT xadd1 from secus WHERE secus.xcus=installmentmst.xcus) AS xadd1","(SELECT xmobile from secus WHERE secus.xcus=installmentmst.xcus) AS xmobile", "xamount");		
		$where = "xdate between '".$fdate."' and '".$tdate."' and bizid = ". Session::get('sbizid').$temp;
		return $this->db->select("installmentmst", $fields, $where);
	}

	public function salesmancolbal($xagent, $fdate, $tdate){
		
		
		$fields = array("abs(round(sum(xprime),2)) AS xbal");
		$where = "xflag='Credit' and xdate between '".$fdate."' and '".$tdate."' and (SELECT xagent from secus where secus.bizid = gldetailview.bizid and secus.xcus = gldetailview.xaccsub)='".$xagent."'";
		return $this->db->select("gldetailview", $fields, $where);
	}

	public function salesbybrand($xagent, $fdate, $tdate){
		
		
		$fields = array("xbrand","round(sum(xqty)) as xqty", "xunitsale", "round(sum(xsubtotal),2) as xbal", "(SELECT xagent from secus where secus.bizid = vsalesdt.bizid and secus.xcus = vsalesdt.xcus) as xagent");
		$where = "xdate between '".$fdate."' and '".$tdate."' and (SELECT xagent from secus where secus.bizid = vsalesdt.bizid and secus.xcus = vsalesdt.xcus)='".$xagent."'AND xbrand in ('Premier Cement','Rod','Scan Cement')";
		return $this->db->select("vsalesdt", $fields, $where, " group by xbrand");
	}

	public function salesmantarbal($xagent, $fdate, $tdate){
		
		$fields = array("xamount","xprecement","xscancement","xrod");
		$where = "xfdate='".$fdate."' and xtdate='".$tdate."' and  xagent ='".$xagent."'";
		return $this->db->select("salesmantarget", $fields, $where);
	}

	public function salescusareabal($xagent, $fdate){
		
		
		$fields = array("round(sum(xprime),2) AS xbal");
		$where = "xdate<'".$fdate."' and (SELECT xagent from secus where secus.bizid = gldetailview.bizid and secus.xcus = gldetailview.xaccsub)='".$xagent."'";
		return $this->db->select("gldetailview", $fields, $where);
	}
	
	public function saleswisecusbal($xagent, $tdate){
		
		$fields = array("round(sum(xprime),2) AS xbal");
		$where = "xdate<='".$tdate."' and (SELECT xagent from secus where secus.bizid = gldetailview.bizid and secus.xcus = gldetailview.xaccsub)='".$xagent."'";
		return $this->db->select("gldetailview", $fields, $where);
	}
	
}