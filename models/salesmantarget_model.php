<?php  

class Salesmantarget_Model extends Model{
	
	function __construct(){
		parent::__construct();
		
	}
	public function create($data){
		
		$fields = array(
				"xdate"=> $data['xdate'],				
				"xagent" => $data['xagent'],
				"xamount" => $data['xamount'],
				"xprecement" => $data['xprecement'],
				"xamount"=>$data['xamount'],				
				"xscancement"=>$data['xscancement'],
				"xrod"=>$data['xrod'],
				"xfdate"=>$data['xfdate'],
				"xtdate"=>$data['xtdate'],
				"bizid"=>$data['bizid'],
				"zemail"=>$data['zemail'],				 
				"xbranch"=>$data['xbranch']
			);

		
		$results = $this->db->insert('salesmantarget', $fields);
		
		return $results;	
	}

	public function edit($data, $xsl){
		
		$fields = array(
				"xdate"=> $data['xdate'],				
				"xagent" => $data['xagent'],
				"xamount" => $data['xamount'],
				"xprecement" => $data['xprecement'],
				"xamount"=>$data['xamount'],				
				"xscancement"=>$data['xscancement'],
				"xrod"=>$data['xrod'],
				"xfdate"=>$data['xfdate'],
				"xtdate"=>$data['xtdate'],
				"bizid"=>$data['bizid'],
				"zemail"=>$data['zemail'],				 
				"xbranch"=>$data['xbranch']
			);
		
		$where = " bizid = " . $data['bizid'] . " and xsl ='" . $xsl ."'";
		$results = $this->db->update('salesmantarget', $fields, $where);
		
		return $results;	
	}

	

	public function glsalesinterface(){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " bizid = ". Session::get('sbizid') ." and xtypeinterface = 'Installment Interface'";	
		return $this->db->select("glinterface", $fields, $where);
	}

	public function getInsColldt($colsl){
		$fields = array("xamount as ta","xamount");
		
		$where = " bizid = ". Session::get('sbizid') ." and xcollectionno = '".$colsl."'";
		//print_r($where);die;
		return $this->db->select("installmentcoll", $fields, $where);
	}

	public function getInsColldtall($colsl){
		$fields = array();
		
		$where = " bizid = ". Session::get('sbizid') ." and xcollectionno = '".$colsl."'";
		//print_r($where);die;
		return $this->db->select("installmentcoll", $fields, $where);
	}

	public function getsl(){
		$fields = array("xsl");
		
		$where = " bizid = ". Session::get('sbizid') ."";
		//print_r($where);die;
		return $this->db->select("salesmantarget", $fields, $where,"order by xsl desc limit 1");
	}
	
	public function getSingleTarget($xsl){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xsl = '". $xsl."'" ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("salesmantarget", $fields, $where);
	}
	
	
	
	public function getsinglefees($cus, $year, $xdate){
		$fields = array("xcus","xamount","xinsnum","xinssl");		
		$where = " bizid = '". Session::get('sbizid') ."' and xbranch = '". Session::get('sbranch') ."' and xcus='".$cus."' and xyear='".$year."' and xdate='".$xdate."'";
		return $this->db->select("vinscollsummary", $fields, $where);
	}
	
	public function getEnrollByLimitPick($limit=""){
		$fields = array("xstudentid","xstuname","xroll", "xclass","xsection", "xshift", "xversion");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and xyear=(select xcode from secodes where xcodetype='Academic Year' order by xcode desc limit 1) and bizid = ". Session::get('sbizid') ." and xbranch = '". Session::get('sbranch') ."'";	
		return $this->db->select("vstuenrolldt", $fields, $where, " order by xenrollsl desc", $limit);
	}
	public function getYear(){
		$fields = array("xcode");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = " xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xcodetype = 'Academic Year' order by xcode desc LIMIT 1";	
		return $this->db->select("secodes", $fields, $where)[0]["xcode"];
	}
	public function getKeyValue($table,$keyfield,$prefix,$num){
		
		return $this->db->keyIncrement($table,$keyfield,$prefix,$num);
	}
	public function getheadcollection($cus, $xdate){
		$fields = array("xcus");
		$where = " bizid = ". Session::get('sbizid') ." and xcus='".$cus."' and xdate='".$xdate."' and xbranch = '". Session::get('sbranch') ."'";
		echo json_encode($this->db->select("installmentmst", $fields, $where));
	}
	
	public function getAccDt($acc){
		$fields = array();
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "bizid = ". Session::get('sbizid') ." and xacc = '". $acc ."'";	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("glchart", $fields, $where);
	}

	public function getCustomer($cus){
		$fields = array();
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";	
		return $this->db->select("secus", $fields, $where);
	}

	public function delete($where){
			//echo $where;die;
		$postdata=array(
			"xrecflag" => "Deleted",
			"xemail" => Session::get('suser'),
			"zutime" => date("Y-m-d H:i:s")
			);
		
		$this->db->update('edstuenroll', $postdata, $where);
			
	}

	public function getTargetList(){
		$fields = array("xsl","xagent","date_format(xfdate, '%d-%m-%Y') as xfdate", "date_format(xtdate, '%d-%m-%Y') as xtdate", "xamount","xprecement","xscancement","xrod");
		//print_r($this->db->select("pabuziness", $fields));die;
		$where = "xrecflag='Live' and bizid = ". Session::get('sbizid') ;	
		//print_r($this->db->select("seitem", $fields, $where));die;
		return $this->db->select("salesmantarget", $fields, $where);
	}

	public function colupdate($postdata, $where){
		$this->db->update('installmentcoll', $postdata, $where);
	}
	
}
