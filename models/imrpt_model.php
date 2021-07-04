<?php 

class Imrpt_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}

	
	public function getYearPer($year, $per){
		return $this->db->getYearPer($year,$per);
	}
	
	public function getinvrcv($fdt, $tdt, $itemcondition=""){
		$fields=array("DATE_FORMAT(xdate,'%d-%m-%Y') as xdate","xdoctype","xtxnnum","xitemcode","xitemdesc","replace(format(xstdcost,".session::get('sbizdecimals')."),',','') as xstdcost","xqty","replace(format(xstdcost*xqty,".session::get('sbizdecimals')."), ',','') as xtotal");
			$where = " bizid = ". Session::get('sbizid') ." and xqty<>0 ".$itemcondition." and xsign=1  and xdate between '". $fdt ."' and '". $tdt ."'";

		return $this->db->select("vimtrn", $fields, $where, " ", " order by ztime");
	}

	public function getinvdetail($fdt, $tdt, $item){
		$fields=array("DATE_FORMAT(xdate,'%d-%m-%Y') as xdate","xdoctype","xtxnnum","replace(format(xstdcost,".session::get('sbizdecimals')."),',','') as xstdcost","if((xqty*xsign)>=0, xqty, 0) as xqtydr", "if((xqty*xsign)<0, xqty, 0) as xqtycr");
			$where = " bizid = ". Session::get('sbizid') ." and xqty<>0 and xitemcode='".$item."' and xdate between '". $fdt ."' and '". $tdt ."'";

		return $this->db->select("vimtrn", $fields, $where, " ", " order by ztime");
	}

	public function getinvissrcv($fdt, $tdt , $itemcondition=""){
		$fields=array("DATE_FORMAT(xdate,'%d-%m-%Y') as xdate","xdoctype","xtxnnum","xitemcode","xitemdesc","replace(format(xstdcost,".session::get('sbizdecimals')."),',','') as xstdcost","if((xqty*xsign)>=0, xqty, 0) as xqtydr", "if((xqty*xsign)<0, xqty, 0) as xqtycr");
			$where = " bizid = ". Session::get('sbizid') ."  $itemcondition and xqty<>0 and xdate between '". $fdt ."' and '". $tdt ."'";

		return $this->db->select("vimtrn", $fields, $where, " ", " order by ztime");
	}
	public function getopbal($fdt, $item){
		$fields=array("COALESCE(sum(xqty*xsign),0) as xbal");
			$where = " bizid = ". Session::get('sbizid') ." and xqty<>0 and xitemcode='".$item."' and xdate<'". $fdt ."'";

		return $this->db->select("vimtrn", $fields, $where);
	}
	
	public function getinvissue($fdt, $tdt , $itemcondition=""){
		$fields=array("DATE_FORMAT(xdate,'%d-%m-%Y') as xdate","xdoctype","xtxnnum","xitemcode","xitemdesc","replace(format(xstdcost,".session::get('sbizdecimals')."),',','') as xstdcost","xqty","replace(format(xstdcost*xqty,".session::get('sbizdecimals')."), ',','') as xtotal");
			$where = " bizid = ". Session::get('sbizid') ."  $itemcondition and xqty<>0 and xsign=-1 and xdate between '". $fdt ."' and '". $tdt ."'";

		return $this->db->select("vimtrn", $fields, $where, " ", " order by ztime");
	}

	public function getImStock($wh=""){
		$fields = array("xwh", "xitemcode", "(select xdesc from seitem where vimstock.bizid=seitem.bizid and vimstock.xitemcode=seitem.xitemcode) as xitemdesc", "xqtypo","xqty","xqtyso");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xqtypo<>0 or xqty<>0 or xqtyso<>0 $wh";	
		return $this->db->select("vimstock", $fields, $where, " order by xitemcode");
	}

	public function getWarehouseStock($wh=""){
		$fields = array("xitemcode", "(select xdesc from seitem where vimstock.bizid=seitem.bizid and vimstock.xitemcode=seitem.xitemcode) as xitemdesc","xqty");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xqtypo<>0 or xqty<>0 or xqtyso<>0 $wh";	
		return $this->db->select("vimstock", $fields, $where, " order by xitemcode");
	}
	
}