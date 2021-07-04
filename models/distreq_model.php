<?php 

class Distreq_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	public function create($data, $dtcols, $dtdata){
		//print_r($data); die;	
		$mstdata = array(
			"bizid"=>$data['bizid'],
			"ximreqnum"=>$data['ximreqnum'],
			"xnote"=>$data['xnote'],
			"xstatus"=>"Created",
			"xbranch" => $data['xbranch'],
			"xdate" => $data['xdate'],
			"zemail"=>$data['zemail']
			);
			
		$checkval = " bizid = " . $data['bizid'] . " and ximreqnum ='" . $data['ximreqnum'] . "'";
		
		$results = $this->db->insertMasterDetail('imreq',$mstdata,"imreqdet",$dtcols, $dtdata,$checkval);
		
		return $results;	
	}
	
	
	public function edit($data,$dt,$reqnum,$row){
		$header = array(
			"xnote"=>$data['xnote'],
			"xdate"=>$data['xdate'],
			"zutime"=>$data['zutime'],
			"xemail" => $data['xemail']
			);
		$detail = array(
					"xitemcode"=>$dt['xitemcode'],
					"xqty"=>$dt['xqty'],
					"xdate"=>$dt['xdate'],
					"xrate"=>$dt['xrate']
		);	
		//print_r($header); print_r($detail);die;
			$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and ximreqnum = '". $reqnum."'";
			$this->db->update('imreq', $header, $where);
			$where = "bizid = ". Session::get('sbizid') ." and ximreqnum = '". $reqnum."' and xrow=".$row;
			return ($this->db->update('imreqdet', $detail, $where));	
	}
	
	public function getImreq($reqnum){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and ximreqnum = '". $reqnum ."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("imreq", $fields, $where);
	}
	public function getSingleReqDt($reqnum, $row){
		$fields = array("*", "(select xdesc from seitem where imreqdet.bizid=seitem.bizid and imreqdet.xitemcode=seitem.xitemcode) as xitemdesc");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "bizid = ". Session::get('sbizid') ." and ximreqnum = '". $reqnum ."' and xrow = ". $row;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("imreqdet", $fields, $where);
	}
	
	public function getimreqdt($reqnum){
		$fields = array("xrow","xitemcode", "(select xdesc from seitem where imreqdet.bizid=seitem.bizid and imreqdet.xitemcode=seitem.xitemcode) as xitemdesc", "xqty","xrate","xqty*xrate as xsalestotal" );
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ." and ximreqnum = '". $reqnum ."'";	
		return $this->db->select("imreqdet", $fields, $where, " order by xrow");
	}
	
	public function getImreqList($status=""){
		$fields = array("date_format(xdate, '%d-%m-%Y') as xdate","ximreqnum","xnote");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and xstatus = '". $status ."' and bizid = ". Session::get('sbizid') ." and zemail='". Session::get('suser') ."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("imreq", $fields, $where);
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
		
		$this->db->update('glheader', $postdata, $where);
			
	}
	
	
	public function getYearPer($year, $per){
		return $this->db->getYearPer($year,$per);
	}
	
	public function getRow($table,$keyfield,$num, $xrow){
		
		return $this->db->rowIncrement($table,$keyfield,$num, $xrow);
	}
	function dbdelete($where){

			
			return $this->db->dbdelete("imreqdet",$where);

		}

	public function confirm($postdata,$where){
		
		$this->db->update('imreq', $postdata, $where);
			
	}	
	
	public function getItemDetail($searchby, $val){
		return $this->db->getItemMaster($searchby, $val);
	}
	public function getSubAccDt($where){
		
		echo json_encode($this->db->select("glchartsub",array(),$where));
	}
}