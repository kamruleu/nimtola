<?php
class Distreq extends Controller{
	
	private $values = array();
	private $fields = array();
	
	function __construct(){
		parent::__construct();
		Session::init();
		$logged = Session::get('loggedIn');
			if($logged == false){
				Session::destroy();
				header('location: '.URL.'login');
				exit;
			}
			
		$usersessionmenu = 	Session::get('mainmenus');
		
		$iscode=0;
		foreach($usersessionmenu as $menus){
				if($menus["xsubmenu"]=="PO Requisition")
					$iscode=1;				
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/distreg/js/codevalidator.js','views/distreq/js/getitemdt.js');
		$dt = date("Y/m/d");
		$this->values = array(
			"xdate"=>$dt,
			"ximreqnum"=>"",
			"xnote"=>"",
			"xitemcode"=>"",
			"xitemdesc"=>"",
			"xqty"=>"0",
			"xrow"=>"0",
			"xrate"=>"0.00"
			);
			
			$this->fields = array(array(
							"ximreqnum-text"=>'Requisition No_maxlength="20"',
							"xdate-datepicker" => 'Date_""',
							"xrow-hidden"=>''
							),
						array(
							"xnote-textarea"=>'Note_maxlength="250"'													
							),
						array(
							"xitemcode-group_".URL."itempicklist/ospitems"=>'Item Code*~star_maxlength="20"',
							"xitemdesc-text"=>'Description_readonly'							
							),
						array(
							"xrate-text_number"=>'Ref. value_number="true" minlength="1" maxlength="18" required',
							"xqty-text_digit"=>'Quantity*~star_number="true" minlength="1" maxlength="18" required'							
							)
						);
						
								
		}
		
		public function index(){
		
		
		$btn = array(
			"Clear" => URL."distreq/distreqentry",
		);	
		
					
			$this->view->rendermainmenu('distreq/index');
			
		}
		
		public function savedistreq(){
				
								
				$xdate = $_POST['xdate'];
				$dt = str_replace('/', '-', $xdate);
				$date = date('Y-m-d', strtotime($dt));
				$year = date('Y',strtotime($date));
				$month = date('m',strtotime($date)); 
				$xyear = 0;
				$per = 0;
				
				$xvoucher = $_POST['ximreqnum'];
				$keyfieldval="0";
				$form = new Form();
				$data = array();
				$success=0;
				$result = ""; 
				$itemdetail = $this->model->getItemDetail("xitemcode", $_POST['xitemcode']);
				try{
				if($_POST['xrate']<=0){
					throw new Exception("Product rate must be greater than 0!");
				}	
				if($_POST['xqty']<=0){
					throw new Exception("Product quantity must be greater than 0!");
				}
					if(empty($itemdetail)){
						throw new Exception("Item not found!");
					}				
				$form	->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20)
						
						->post('ximreqnum')						
				
						->post('xnote')
						->val('maxlength', 250)
						
						->post('xqty')
						
						->post('xrate');
						
				$form	->submit();
				
				$data = $form->fetch();
				
				if($data['ximreqnum'] == "")
					$keyfieldval = $this->model->getKeyValue("imreq","ximreqnum","REQ-","5");
				else
					$keyfieldval = $data['ximreqnum'];

				
					
				$data['bizid'] = Session::get('sbizid');
				$data['zemail'] = Session::get('suser');
				$data['ximreqnum'] = $keyfieldval;
				$data['xdate'] = $date;
				$data['xbranch'] = Session::get('sbranch');
				
				
				
				$rownum = $this->model->getRow("imreqdet","ximreqnum",$data['ximreqnum'],"xrow");
				
				$cols = "`bizid`,`ximreqnum`,`xrow`,`xitemcode`,`xqty`,`xdate`,`xrate`,`zemail`,`xyear`,`xper`";
				
				$vals = "(" . Session::get('sbizid') . ",'". $keyfieldval ."','". $rownum ."','". $data['xitemcode'] ."',
				'". $data['xqty'] ."','". $date ."','". $data['xrate'] ."','". Session::get('suser') ."',
				'". $xyear ."','". $month ."')";
				
					
				$success = $this->model->create($data, $cols, $vals);
				
				if(empty($success))
					$success=0;
				
				
				}catch(Exception $e){
					
					$this->result = $e->getMessage();
					
				}
				
				if($success>0)
					$this->result = 'Purchase Requisition Created';
				
				if($success == 0 && empty($this->result))
					$this->result = "Failed to Create Purchase Requisition! Reason: Could be Duplicate Account Code or system error!";
				
				 $this->showentry($keyfieldval, $this->result);
				 
				 
				
		}
		
		public function editdistreq(){
			
			if (empty($_POST['ximreqnum'])){
					header ('location: '.URL.'distreq/distreqentry');
					exit;
				}
			$result = "";
			
			$hd = array();
			$dt = array();
			
				
				$xdate = $_POST['xdate'];
				$dt = str_replace('/', '-', $xdate);
				$date = date('Y-m-d', strtotime($dt));
				
			$success=false;
			$imreqnum = $_POST['ximreqnum'];
			$form = new Form();
				$data = array();
				
				try{
				
				
				$form	->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20)
										
				
						->post('xnote')
						->val('maxlength', 250)
						
						->post('xqty')
						
						->post('xrate');
						
				$form	->submit();
				
			
				
				$data = $form->fetch();	
				//print_r($data);die;
				
								
				$hd = array (
					"xemail"=>Session::get('suser'),
					"zutime"=>date("Y-m-d H:i:s"),
					"xdate"=>$date,
					"xnote"=>$data['xnote']					
				);
				
				$dt = array (
					"xitemcode"=>$data['xitemcode'],
					"xqty"=>$data['xqty'],
					"xrate"=>$data['xrate'],
					"xdate"=>$date,
				);
				
				$success = $this->model->edit($hd,$dt,$imreqnum,$_POST['xrow']);
				
				
				}catch(Exception $e){
					//echo $e->getMessage();die;
					$result = $e->getMessage();
					
				}
				if($result==""){
				if($success)
					$result = "Edited successfully";
				else
					$result = "Edit failed!";
				
				}
				
				 $this->showentry($imreqnum, $result);
				
		
		}
		
		public function showdistreq($reqnum, $row, $result=""){
		if($reqnum=="" || $row==""){
			header ('location: '.URL.'distreq/distreqentry');
			exit;
		}
		$tblvalues=array();
		$btn = array(
			"New" => URL."distreq/distreqentry"
		);
		
		$tblvalues = $this->model->getImreq($reqnum);
		$tbldtvals = $this->model->getSingleReqDt($reqnum, $row);

		$conf="";
		$sv="";
		if(count($tblvalues)>0){	
			if($tblvalues[0]['xstatus']=="Created"){
				$conf=array(URL."distreq/confirmpost", "Confirm");
				$sv=URL."distreq/editdistreq";
			}		
			if($tblvalues[0]['xstatus']=="Confirmed"){
				$sv="";
				$conf=array(URL."distreq/cancelpost", "Cancel");
			}		
		}
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					"xdate"=>$tblvalues[0]['xdate'],
					"ximreqnum"=>$tblvalues[0]['ximreqnum'],
					"xnote"=>$tblvalues[0]['xnote'],
					"xitemcode"=>$tbldtvals[0]['xitemcode'],
					"xitemdesc"=>$tbldtvals[0]['xitemdesc'],
					"xqty"=>$tbldtvals[0]['xqty'],
					"xrow"=>$tbldtvals[0]['xrow'],
					"xrate"=>$tbldtvals[0]['xrate']
					);
			
		// form data
		
			
			$dynamicForm = new Dynamicform("PO Requisition", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, $sv, "Update",$tblvalues, URL."distreq/showpost", $conf);
			
			$this->view->table = $this->renderTable($reqnum);
			
			$this->view->renderpage('distreq/distreqentry');
		}
		
		
		
		public function showentry($reqnum, $result=""){
		
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."distreq/distreqentry"
		);
		
		$tblvalues = $this->model->getImreq($reqnum);

		$conf="";
		$sv="";
		if(count($tblvalues)>0){	
			if($tblvalues[0]['xstatus']=="Created"){
				$conf=array(URL."distreq/confirmpost", "Confirm");
				$sv=URL."distreq/savedistreq";
			}		
			if($tblvalues[0]['xstatus']=="Confirmed"){
				$sv="";
				$conf=array(URL."distreq/cancelpost", "Cancel");
			}		
		}
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					"xdate"=>$tblvalues[0]['xdate'],
					"ximreqnum"=>$tblvalues[0]['ximreqnum'],
					"xnote"=>$tblvalues[0]['xnote'],
					"xitemcode"=>"",
					"xitemdesc"=>"",
					"xqty"=>"0",
					"xrow"=>"0",
					"xrate"=>"0"
					);
			
			//print_r($tblvalues); die;
			$dynamicForm = new Dynamicform("PO Requisition", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, $sv, "Save",$tblvalues ,URL."distreq/showpost", $conf);
			
			$this->view->table = $this->renderTable($reqnum);
			
			$this->view->renderpage('distreq/distreqentry');
		}
		
		function renderTable($imreqnum){
			$tblvalues = $this->model->getImreq($imreqnum);
			$fields = array(
						"xrow-Sl",
						"xitemcode-Item Code",
						"xitemdesc-Description",
						"xqty-Quantity",
						"xrate-Rate",
						"xsalestotal-Total"
						);
			$table = new Datatable();
			$row = $this->model->getimreqdt($imreqnum);
			$delbtn = "";
			if(count($tblvalues)>0){
			if($tblvalues[0]["xstatus"]=="Created")
				$delbtn = URL."distreq/deldistreq/".$imreqnum."/";
			}
			
			return $table->myTable($fields, $row, "xrow", URL."distreq/showdistreq/".$imreqnum."/", $delbtn);
			
			
		}		
		
		function imreqlist($status){
			$rows = $this->model->getImreqList($status);
			$cols = array("xdate-Date","ximreqnum-Requisition No","xnote-Note");
			$table = new Datatable();
			$this->view->table = $table->createTable($cols, $rows, "ximreqnum",URL."distreq/showentry/");
			$this->view->renderpage('distreq/distreqlist', false);
		}		
		
		function distreqentry(){
				
		$btn = array(
			"Clear" => URL."distreq/distreqentry"
		);

		// form data
		
		
			$dynamicForm = new Dynamicform("Requisition",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."distreq/savedistreq", "Save",$this->values, URL."distreq/showpost");
			
			
			$this->view->table = $this->renderTable("");
			
			$this->view->renderpage('distreq/distreqentry', false);
		}
		
		
		public function showpost(){
		//echo 123;die;
		$imreqnum = $_POST['ximreqnum'];
			
		$tblvalues=array();
		
		$btn = array(
			"New" => URL."distreq/distreqentry"
		);
		
		$tblvalues = $this->model->getImreq($imreqnum);

		$conf="";
		$sv="";
		if(count($tblvalues)>0){	
			if($tblvalues[0]['xstatus']=="Created"){
				$conf=array(URL."distreq/confirmpost", "Confirm");
				$sv=URL."distreq/savedistreq";
			}		
			if($tblvalues[0]['xstatus']=="Confirmed"){
				$sv="";
				$conf=array(URL."distreq/cancelpost", "Cancel");
			}		
		}
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					"xdate"=>$tblvalues[0]['xdate'],
					"ximreqnum"=>$tblvalues[0]['ximreqnum'],
					"xnote"=>$tblvalues[0]['xnote'],
					"xitemcode"=>"",
					"xitemdesc"=>"",
					"xqty"=>"0",
					"xrow"=>"0",
					"xrate"=>"0"
					);
			
		
			
		// form data
			
			
			$dynamicForm = new Dynamicform("Requisition", $btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, $sv, "Save",$tblvalues, URL."distreq/showpost", $conf);
			
			$this->view->table = $this->renderTable($imreqnum);
			
			$this->view->renderpage('distreq/distreqentry');
		}
		

		function deldistreq($imreqnum, $rw){

			$where = " where bizid=".Session::get('sbizid')." and ximreqnum='".$imreqnum."' and xrow=".$rw;

			$result = $this->model->dbdelete($where);

			
			$this->showentry($imreqnum, "Deleted Successfully!");
			
		}

		function confirmpost(){
				
				$reqnum = $_POST['ximreqnum'];
				
								
				$where = " bizid = ". Session::get('sbizid') ." and ximreqnum = '". $reqnum ."'";
				
				$postdata=array(
					"xstatus" => "Confirmed"
					);	
				
				$this->model->confirm($postdata,$where);
				$tblvalues=array();
				$tblvalues =  $this->model->getImreq($reqnum);
				
				$result="Confirm Failed";
				
				if($tblvalues[0]['xstatus']=="Confirmed"){
					$result='Confirmed!<br/><a style="color:red" id="invnum" href="'.URL.'salesquot/showquot/'.$reqnum.'">Click To Print PO Requisition - '.$reqnum.'</a>';
				}
				$this->showentry($reqnum, $result);
		
		}

		function cancelpost(){
				
				$reqnum = $_POST['ximreqnum'];
				
								
				$where = " bizid = ". Session::get('sbizid') ." and ximreqnum = '". $reqnum ."'";
				
				$postdata=array(
					"xstatus" => "Canceled"
					);	
				
				$this->model->confirm($postdata,$where);
				$tblvalues=array();
				$tblvalues =  $this->model->getImreq($reqnum);
				
				$result="Cancel Failed";
				
				if($tblvalues[0]['xstatus']=="Canceled"){
					$result='PO Requisition Canceled!<br/><a style="color:red" id="invnum" href="'.URL.'salesquot/showquot/'.$reqnum.'">Click To Print PO Requisition - '.$reqnum.'</a>';
				}
				$this->showentry($reqnum, $result);
		
		}
}