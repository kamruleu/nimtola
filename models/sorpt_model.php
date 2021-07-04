<?php 

class Sorpt_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}

	public function dateWiseso($fdt, $tdt){
		$fields=array("DATE_FORMAT(xdate,'%d-%m-%Y') as xdate","xsonum","xcus","concat((select xorg from secus where vsalesdt.bizid=secus.bizid and vsalesdt.xcus=secus.xcus),' - ',(select xadd1 from secus where vsalesdt.bizid=secus.bizid and vsalesdt.xcus=secus.xcus)) as xorg","xitemcode","(select xdesc from seitem where vsalesdt.bizid=seitem.bizid and vsalesdt.xitemcode=seitem.xitemcode) as xitemdesc","xqty","xrate","xunitsale","xsubtotal");
			$where = " bizid = ". Session::get('sbizid') ." and xstatus = 'Confirmed' and xdate between '". $fdt ."' and '". $tdt ."'";
		
		return $this->db->select("vsalesdt", $fields, $where," order by ztime");
	}

	public function catWiseso($fdt){
		$fields=array("xitemcode","(select xdesc from seitem where vsalesdt.bizid=seitem.bizid and vsalesdt.xitemcode=seitem.xitemcode) as xitemdesc","xcat","TRUNCATE(sum(xqty), 2) as xqty","xrate","xunitsale","TRUNCATE(sum(xsubtotal), 2) as xsubtotal");
			$where = " bizid = ". Session::get('sbizid') ." and xstatus = 'Confirmed' and xdate = '". $fdt ."'";
		
		return $this->db->select("vsalesdt", $fields, $where," GROUP by xitemcode");
	}
	public function itemWiseso($fdt, $tdt){
		$fields=array("DATE_FORMAT(xdate,'%d-%m-%Y') as xdate","xsonum","xcus","(select xorg from secus where vsalesdt.bizid=secus.bizid and vsalesdt.xcus=secus.xcus) as xorg","xitemcode","(select xdesc from seitem where vsalesdt.bizid=seitem.bizid and vsalesdt.xitemcode=seitem.xitemcode) as xitemdesc","xqty","xrate","xunitsale","xsubtotal");
			$where = " bizid = ". Session::get('sbizid') ." and xstatus = 'Confirmed' and xdate between '". $fdt ."' and '". $tdt ."'";

		return $this->db->select("vsalesdt", $fields, $where, " ", " order by ztime");
	}
	
	public function cuswiseso($fdt, $tdt, $cus=""){
		$cond="";
		if($cus!="")
			$cond = " and xcus='".$cus."'";

		$fields=array("DATE_FORMAT(xdate,'%d-%m-%Y') as xdate","xsonum","xcus","concat((select xorg from secus where vsalesdt.bizid=secus.bizid and vsalesdt.xcus=secus.xcus),' - ',(select xadd1 from secus where vsalesdt.bizid=secus.bizid and vsalesdt.xcus=secus.xcus)) as xorg","xitemcode","(select xdesc from seitem where vsalesdt.bizid=seitem.bizid and vsalesdt.xitemcode=seitem.xitemcode) as xitemdesc","xqty","xrate","xunitsale","xsubtotal");
			$where = " bizid = ". Session::get('sbizid') ." and xstatus = 'Confirmed' ".$cond." and xdate between '". $fdt ."' and '". $tdt ."'";
		
		return $this->db->select("vsalesdt", $fields, $where," order by ztime");
	}
	public function retailerorder($fdt, $tdt){
		$fields=array("invoiceno","shopname","shopadd","prdid","prdname","price","qty","qty*price as xsubtotal");
			$where = " zid = ". Session::get('sbizid') ." and salestype = 'Retailer' and xdate between '". $fdt ."' and '". $tdt ."'";
		
		return $this->db->select("order_transaction", $fields, $where," order by xsl");
	}
	public function retailerreturn($fdt, $tdt){
		$fields=array("invoiceno","shopname","shopadd","prdid","prdname","price","qty","qty*price as xsubtotal");
			$where = " zid = ". Session::get('sbizid') ." and salestype = 'Return' and xdate between '". $fdt ."' and '". $tdt ."'";
		
		return $this->db->select("order_transaction", $fields, $where," order by xsl");
	}

	
	public function dealerorder($fdt, $tdt){
		$fields=array("invoiceno","shopname","shopadd","prdid","prdname","price","qty","qty*price as xsubtotal");
			$where = " zid = ". Session::get('sbizid') ." and salestype = 'Dealer' and xdate between '". $fdt ."' and '". $tdt ."'";
		
		return $this->db->select("order_transaction", $fields, $where," order by xsl");
	}
	public function dealerreturn($fdt, $tdt){
		$fields=array("invoiceno","shopname","shopadd","prdid","prdname","price","qty","qty*price as xsubtotal");
			$where = " zid = ". Session::get('sbizid') ." and salestype = 'Dealer Return' and xdate between '". $fdt ."' and '". $tdt ."'";
		
		return $this->db->select("order_transaction", $fields, $where," order by xsl");
	}
		public function mrporder($fdt, $tdt){
		$fields=array("invoiceno","shopname","shopadd","prdid","prdname","price","qty","qty*price as xsubtotal");
			$where = " zid = ". Session::get('sbizid') ." and salestype = 'MRP' and xdate between '". $fdt ."' and '". $tdt ."'";
		
		return $this->db->select("order_transaction", $fields, $where," order by xsl");
	}

	public function getcusdt($cus){
		$fields=array("xorg","xadd1");
			$where = " bizid = ". Session::get('sbizid') ." and xcus = '".$cus."'";
		
		return $this->db->select("secus", $fields, $where);
	}
	public function getYearPer($year, $per){
		return $this->db->getYearPer($year,$per);
	}
	
		
}