<?php
class Pmbom extends Controller{
	
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
				if($menus["xsubmenu"]=="Bill Of Material")
					$iscode=1;				
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/distreg/js/codevalidator.js','views/pmbom/js/getitemdt.js','views/suppliers/js/getsup.js');
		$dt = date("Y/m/d");
		$this->values = array(
			
			"xbomcode"=>"",			
			"xitemcode"=>"",
			"xdesc"=>"",
			"xrawitem"=>"",
			"xrawdesc"=>"",
			"xqty"=>"0",
			"xrow"=>"0",			
			);
			
			$this->fields = array(
						array(
							
							"xbomcode-text"=>'BOM Code_maxlength="20"',
								
							),
						array(
							"xitemcode-group_".URL."itempicklist/picklist"=>'Item Code_maxlength="20"',
							"xdesc-text"=>'Description_readonly'													
							),
						array(
							"Item Detail-div"=>''													
							),
						array(
							"xrawitem-group_".URL."itempicklist/rawitempicklist"=>'Raw Material_maxlength="20"',
							"xrawdesc-text"=>'Description_readonly'							
							),
						array(							
							"xqty-text_digit"=>'Quantity*~star_number="true" minlength="1" maxlength="18" required',
							"xrow-hidden"=>''
							)
						);
						
								
		}
		
		public function index(){
		
					
			$this->view->rendermainmenu('pmbom/index');
			
		}
		
		public function save(){
				
								
				$xdate = date("Y/m/d");
				$dt = str_replace('/', '-', $xdate);
				$date = date('Y-m-d', strtotime($dt));
				$year = date('Y',strtotime($date));
				$month = date('m',strtotime($date)); 
				$yearoffset = Session::get('syearoffset');
				$txnnum = $_POST['xbomcode'];
				$keyfieldval="0";
				$form = new Form();
				$data = array();
				$success=0;
				$result = ""; 
				/*$xyear = 0;
				$xper = 0;
				//print_r($this->model->getYearPer($yearoffset,intval($month))); die;
				foreach ($this->model->getYearPer($yearoffset,intval($month)) as $key=>$val){
					$xper = $key;
					$xyear = $val;
				}*/
				try{
					
				
				$form	->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20)

						->post('xrawitem')
						->val('minlength', 1)
						->val('maxlength', 20)
						
						->post('xbomcode')	
						
						->post('xqty');
						
				$form	->submit();
				
				
					
				
				$data = $form->fetch();
				
				
				$item = $this->model->getItem($data['xrawitem']);


				
				if($data['xbomcode'] == "")
					$keyfieldval = $this->model->getKeyValue("pmbommst","xbomcode","BOM-","6");
				else
					$keyfieldval = $data['xbomcode'];
				
					
				$data['bizid'] = Session::get('sbizid');
				$data['zemail'] = Session::get('suser');
				$data['xbomcode'] = $keyfieldval;
				$data['xitemcode'] = $data['xitemcode'];
				$data['xdate'] = $date;
				$data['xbranch'] = Session::get('sbranch');
				//$data['xfinyear'] = $xyear;
				//$data['xfinper'] = $xper;			
				//print_r($data); die;
				$rownum = $this->model->getRow("pmbomdet","xbomcode",$data['xbomcode'],"xrow");
				
				$cols = "`bizid`,`xbomcode`,`xrow`,`xrawitem`,`xitembatch`,`xqty`,`xconversion`,`xunit`,`xitemtype`";
				
				$vals = "(" . Session::get('sbizid') . ",'". $keyfieldval ."','". $rownum ."','". $data['xrawitem'] ."','',
				'". $data['xqty'] ."','1','". $item[0]['xunitstk'] ."','". $item[0]['xgitem'] ."')";
				
					
				$success = $this->model->create($data, $cols, $vals);
				
				if(empty($success))
					$success=0;
				
				
				}catch(Exception $e){
					
					$this->result = $e->getMessage();
					
				}
				
				if($success>0)
					$this->result = 'Bill Of Material Created</br><a style="color:red" id="invnum" href="'.URL.'pmbom/printbom/'.$keyfieldval.'">Click To Print Bill Of Material - '.$keyfieldval.'</a>';
				
				if($success == 0 && empty($this->result))
					$this->result = "Failed to Create Bill Of Material! Reason: Could be Duplicate Trunsaction Code or system error!";
				
				 $this->showentry($keyfieldval, $this->result);
				 
				 
				
		}
		
		public function edit(){
			
			$result = "";
			
			$hd = array();
			$dt = array();
			
				$yearoffset = Session::get('syearoffset');
				$xdate = date("Y/m/d");
				$dt = str_replace('/', '-', $xdate);
				$date = date('Y-m-d', strtotime($dt));
				$month = date('m',strtotime($date)); 
				
				$xyear = 0;
				$xper = 0;
				//print_r($this->model->getYearPer($yearoffset,intval($month))); die;
				foreach ($this->model->getYearPer($yearoffset,intval($month)) as $key=>$val){
					$xper = $key;
					$xyear = $val;
				}
				
			$success=false;
			$bomcode = $_POST['xbomcode'];
			$form = new Form();
				$data = array();
				
				try{
				
				
				$form	->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20)

						->post('xrawitem')
						->val('minlength', 1)
						->val('maxlength', 20)
						
						->post('xbomcode')	
						
						->post('xqty');

				$form	->submit();
				
			
				
				$data = $form->fetch();	
				//print_r($data);die;
				$item = $this->model->getItem($data['xitemcode']);
						
				$hd = array (
					"xitemcode"=>$data['xitemcode'],				
					
				);
				
				$dt = array (
					
					"xqty"=>$data['xqty'],
					
				);
				
				$success = $this->model->edit($hd,$dt,$bomcode,$_POST['xrow']);
				
				
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
				
				 $this->showentry($bomcode, $result.'<br /><a style="color:red" id="invnum" href="'.URL.'pmbom/printbom/'.$bomcode.'">Click To Print Bill Of Material - '.$bomcode.'</a>');
				
		
		}
		
		public function show($txnnum, $row, $result=""){
		if($txnnum=="" || $row==""){
			header ('location: '.URL.'pmbom/bomentry');
			exit;
		}
		$tblvalues=array();
		$btn = array(
			"New" => URL."pmbom/bomentry"
		);
		if($result=="")
			$result='<a style="color:red" id="invnum" href="'.URL.'pmbom/printbom/'.$txnnum.'">Click To Print Bill Of Material - '.$txnnum.'</a>';
		
		$tblvalues = $this->model->getBom($txnnum);
		$tbldtvals = $this->model->getSingleBomDt($txnnum, $row);
		$status="";
		if(!empty($tblvalues))
			$status = $tblvalues[0]['xstatus']; //echo $status; die;
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					
					"xbomcode"=>$tblvalues[0]['xbomcode'],
					"xitemcode"=>$tblvalues[0]['xitemcode'],
					"xdesc"=>$tblvalues[0]['xdesc'],
					"xrawitem"=>$tbldtvals[0]['xrawitem'],
					"xrawdesc"=>$tbldtvals[0]['xrawdesc'],
					"xqty"=>$tbldtvals[0]['xqty'],
					"xrow"=>$tbldtvals[0]['xrow'],
					
					);
			
		// form data
		
			$confurl = URL."pmbom/confirm";
			$saveurl = URL."pmbom/edit/";
			/*if($status=="Confirmed"){
				$confurl="";
				$saveurl="";
			}*/
		$this->view->balance = "";
			
			$dynamicForm = new Dynamicform("Bill Of Material", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, $saveurl, "Update",$tblvalues, URL."pmbom/showpost");
			
			$this->view->table = $this->renderTable($txnnum);
			
			$this->view->renderpage('pmbom/bomentry');
		}
		
		
		
		public function showentry($txnnum, $result=""){
		
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."pmbom/bomentry"
		);
		if($result=="")
			$result='<a style="color:red" id="invnum" href="'.URL.'pmbom/printbom/'.$txnnum.'">Click To Bill Of Material - '.$txnnum.'</a>';
		$tblvalues = $this->model->getBom($txnnum);
		$status="";
		if(!empty($tblvalues))
			$status = $tblvalues[0]['xstatus'];
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					
					"xbomcode"=>$tblvalues[0]['xbomcode'],					
					"xitemcode"=>$tblvalues[0]['xitemcode'],
					"xdesc"=>$tblvalues[0]['xdesc'],
					"xrawitem"=>"",
					"xrawdesc"=>"",
					"xqty"=>"0",
					"xrow"=>"0",
					
					);
			$this->view->balance = "";
			//print_r($tblvalues); die;
			$dynamicForm = new Dynamicform("Bill Of Material", $btn, $result);		
			$confurl = URL."pmbom/confirm";
			$saveurl = URL."pmbom/save/";
			/*if($status=="Confirmed"){
				$confurl="";
				$saveurl="";
			}*/
			$this->view->dynform = $dynamicForm->createForm($this->fields, $saveurl, "Save",$tblvalues ,URL."pmbom/showpost");
			
			$this->view->table = $this->renderTable($txnnum);
			
			$this->view->renderpage('pmbom/bomentry');
		}
		
		public function confirm(){
			/*
			$this->model->confirm(" bizid=".Session::get('sbizid')." and xbomcode='".$_POST['xbomcode']."' and xstatus='Created'");
			$this->showentry($_POST['xbomcode']);*/
		}
		
		function renderTable($txnnum){
			
			$pur = $this->model->getBom($txnnum);
			$status = "";
			if(!empty($pur))
				$status = $pur[0]["xstatus"];
			
			$delurl = URL."pmbom/recdelete/".$txnnum."/";
			
			if($status=="Confirmed")
			{
				$delurl="";
			}			
			
			$fields = array(
						"xrow-Sl",
						"xrawitem-Item Code",
						"xrawdesc-Description",
						"xqty-Quantity",						
						);
			$table = new Datatable();
			$row = $this->model->getbomdt($txnnum);
			
			return $table->myTable($fields, $row, "xrow", URL."pmbom/show/".$txnnum."/", $delurl);
			
			
		}
		
		
		function bomlist(){
			$rows = $this->model->getBomList("Confirmed");
			$cols = array("xbomcode-BOM Code","xitemcode-Itemcode");
			$table = new Datatable();
			$this->view->table = $table->createTable($cols, $rows, "xbomcode",URL."pmbom/showentry/");
			$this->view->renderpage('pmbom/bomlist', false);
		}
		function unconfirmedlist(){
			$rows = $this->model->getBomList("Created");
			$cols = array("xbomcode-BOM Code","xitemcode-Itemcode","xdesc-Item Description");
			$table = new Datatable();
			$this->view->table = $table->createTable($cols, $rows, "xbomcode",URL."pmbom/showentry/");
			$this->view->renderpage('pmbom/bomlist', false);
		}
		
		function bomentry(){
				
		$btn = array(
			"Clear" => URL."pmbom/bomentry"
		);

		// form data
		$this->view->balance = "";
		
			$dynamicForm = new Dynamicform("Bill Of Material",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."pmbom/save", "Save",$this->values, URL."pmbom/showpost");
			
			
			$this->view->table = $this->renderTable("");
			
			$this->view->renderpage('pmbom/bomentry', false);
		}
		
		
		public function showpost(){
		//echo 123;die;
		$txnnum = $_POST['xbomcode'];
			
		$tblvalues=array();
		
		$btn = array(
			"New" => URL."pmbom/bomentry"
		);
		
		$tblvalues = $this->model->getBom($txnnum);
		$status="";
		if(!empty($tblvalues))
			$status = $tblvalues[0]['xstatus'];
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					"xbomcode"=>$tblvalues[0]['xbomcode'],					
					"xitemcode"=>$tblvalues[0]['xitemcode'],
					"xdesc"=>$tblvalues[0]['xdesc'],
					"xrawitem"=>"",
					"xrawdesc"=>"",
					"xqty"=>"0",
					"xrow"=>"0",
					);
			
		
			
		// form data
			$this->view->balance = "";
			
			$dynamicForm = new Dynamicform("Bill Of Material", $btn,'<a style="color:red" id="invnum" href="'.URL.'pmbom/printbom/'.$txnnum.'">Click To Print Bill Of Material - '.$txnnum.'</a>');		
			$confurl = URL."pmbom/confirm";
			$saveurl = URL."pmbom/save/";
			/*if($status=="Confirmed"){
				$confurl="";
				$saveurl="";
			}*/
			$this->view->dynform = $dynamicForm->createForm($this->fields, $saveurl, "Save",$tblvalues ,URL."pmbom/showpost");
			
			$this->view->table = $this->renderTable($txnnum);
			
			$this->view->renderpage('pmbom/bomentry');
		}
		function recdelete($bomcode, $row){
			$grn = $this->model->getBom($bomcode);
			$status = "";
			if(!empty($grn))
				$status = $grn[0]["xstatus"];
			if($status=="Created")
				$this->model->recdelete(" WHERE xbomcode='".$bomcode."' and xrow=".$row);
			
			$this->showentry($bomcode);
		}
		function printbom($bomcode){
			
			$values = $this->model->getvbomdt($bomcode);
			//print_r($values);die;
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li>Bill Of Material</li>							
						   </ul>';
			
			$this->view->bomcode=$bomcode;

			$totqty = 0;
			$totcost = 0;
			$finisheditem="";
			
			$finisheditemdesc="";
			
			foreach($values as $key=>$val){
				
				$finisheditem=$val['xitemcode'];
				$finisheditemdesc=$val['xitemdesc'];
				
				$totqty+=$val['xqty'];
				$totcost+=$val['xstdcost'];
			}
			$this->view->finisheditem=$finisheditem;

			$this->view->finisheditemdesc=$finisheditemdesc;
				
			$this->view->totqty=$totqty;
			
			$this->view->totcost=$totcost;
			
			$this->view->vrow = $values;
			
			$this->view->vrptname = "Bill Of Material";
			$this->view->org=Session::get('sbizlong');
			
			$this->view->renderpage('pmbomcost/printbom');		
		}
}