<?php 
class Customerseparate extends Controller{
	
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
				if($menus["xsubmenu"]=="Customer Separate")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/customerseparate/js/codevalidator.js','views/customerseparate/js/getaccdt.js');
		$dt = date("Y/m/d");
		$date = date('Y-m-d', strtotime($dt));
		$year = date('Y',strtotime($date));
		$this->values = array(
			"xcus"=>"",
			"xshort"=>"",		
			"xorg"=>"",
			"xbillingadd"=>"",
			"xdeliveryadd"=>"",
			"xadd1"=>"",
			"xadd2"=>"",
			"xoccupation"=>"",
			"xcountry"=>"",
			"xdob"=>$dt,
			"xreligion"=>"",
			"xcontact"=>"",
			"xcity"=>"",
			"xprovince"=>"",
			"xmobile"=>"",
			"xphone"=>"",
			"xcusemail"=>"",
			"xnid"=>"",
			"xnoname"=>"",
			"xnorelation"=>"",
			"xnoage"=>$dt,
			"nofather"=>"",
			"xnoadd"=>""
			);
			
			$this->fields = array(					
						array(
							"xcus-group_".URL."customerseparate/picklist"=>'Customer Code*~star_maxlength="20" readonly',
							"xshort-text"=>'Name_maxlength="160" readonly',	
							),
						array(
							"xorg-text"=>'Description_maxlength="100" readonly',
							"xbillingadd-text"=>'Father/Husband_maxlength="160" readonly'
							),
						array(
							"xdeliveryadd-text"=>'Mother Name_maxlength="160" readonly',
							"xadd1-text"=>'Present Address_maxlength="160" readonly'
							),
						array(
							"xadd2-text"=>'Parmanent Address_maxlength="160" readonly',
							"xoccupation-select_Occupation"=>'Occupation_maxlength="160" readonly'
							),
						array(
							"xcountry-select_Country"=>'Nationality_maxlength="160" readonly',
							"xdob-datepicker"=>'Date Of Birth_""',
							),
						array(
							"xreligion-select_Religion"=>'Religion_maxlength="160" readonly',
							"xcontact-text"=>'Contact_maxlength="50" readonly'
							),
						array(
							"xcity-text"=>'PS_maxlength="50" readonly',
							"xprovince-text"=>'District_maxlength="100" readonly'
							),
						array(
							"xmobile-text"=>'Phone_maxlength="50" readonly',
							"xphone-text"=>'Mobile_maxlength="50" readonly'
							),
						array(
							"xcusemail-text"=>'Email_maxlength="50" email="true" readonly',
							"xnid-text"=>'NID/PP/BIRTH_maxlength="50" readonly'
							),
						array(
							"Nominee Detail-div"=>''		
							),
						array(
							"xnoname-text"=>'Nominee Name_maxlength="160" readonly',
							"xnorelation-text"=>'Relation_maxlength="100" readonly'
							),
						array(
							"xnoage-datepicker"=>'Date Of Birth_""',
							"nofather-text"=>'Father/Husband_maxlength="160" readonly'
							),
						array(
							"xnoadd-text"=>'Nominee Address_maxlength="160" readonly'
							)
						);
		}
		
		public function index(){
		
		
		$btn = array(
			"Clear" => URL."customerseparate/cusupdateentry",
		);	
		
		
		// form data
		
			$dynamicForm = new Dynamicform("Customer Separate",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields,"","", $this->values, URL."customerseparate/showpost");
			
			//$this->view->table = $this->renderTable();
			
			$this->view->rendermainmenu('customerseparate/index');
			
		}
		
		public function editcustomer(){

			date_default_timezone_set("Asia/Dhaka");
			$result = "";
			$cus = $_POST['xcus'];

			$success=false;
			$cofcus=array();
			$cofcus = $this->model->getSingleCustomer($cus);
				try{
					if(empty($_POST['xcus'])){
						throw new Exception("Select Customer!");
					}

				$rows = $this->model->getsalesForConfirm($cus);
				$glinterface = $this->model->glsalesinterface();

				if(!empty($glinterface)){

					$xdate = date('Y-m-d');
					$dt = str_replace('/', '-', $xdate);
					$date = date('Y-m-d', strtotime($dt));
					$year = date('Y',strtotime($date));
					$month = date('m',strtotime($date)); 
						//glheader goes here
						$voucher = $this->model->getKeyValue("glheader","xvoucher","SSINV".Session::get('suserrow')."-","6");
						
						$data = array();

						$data['bizid'] = Session::get('sbizid');
						$data['zemail'] = Session::get('suser');
						$data['xnarration'] = "Customer Separated Voucher, ".$cofcus[0]['xsonum']."; ".$cus."-".$cofcus[0]['xshort']."-".$cofcus[0]['xadd1'];
						$data['xyear'] = $year;
						$data['xper'] = $month;
						$data['xvoucher'] = $voucher;
						$data['xdate'] = $date;
						$data['xstatusjv'] = 'Confirmed';
						$data['xbranch'] = Session::get('sbranch');
						$data['xdoctype'] = "Sales Separated Voucher";
						$data['xdocnum'] = $cus;

						$cols = "`bizid`,`xvoucher`,`xrow`,`xacc`,`xacctype`,`xaccusage`,`xaccsource`,xaccsub,`xcur`,`xbase`,`xexch`,`xprime`,xflag,xremarks";

						$vals = "";	

						$i = 0;	
						$globalvar = new Globalvar();
						foreach($glinterface as $key=>$val){
							$i++;
							$amt = $globalvar->getFormula($rows,$val["xformula"]);
							
							if($val['xaction']=="Credit")
								$amt = "-".$amt;

							$acc = $this->model->getAcc($val['xacc']);
							$subacc = "";
							if($acc[0]['xaccsource']=="Customer")
								$subacc = $rows[0]['xcus'];
							else
								$subacc = "";
							if($amt<>0)
									$vals .= "(" . Session::get('sbizid') . ",'". $voucher ."','". $i ."','". $val['xacc'] ."','". $acc[0]['xacctype'] ."','". $acc[0]['xaccusage'] ."','". $acc[0]['xaccsource'] ."','". $subacc ."','".Session::get('sbizcur')."','". $amt ."','1','". $amt ."','". $val['xaction'] ."',''),";
						}

									$vals = rtrim($vals, ",");

					$success = $this->model->confirmgl($data, $cols, $vals);
					
				}
				
				}catch(Exception $e){
					//echo $e->getMessage();die;
					$result = $e->getMessage();
					//echo $result;
				}
					$where = " where bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."' AND xinssl not in (SELECT xinssl FROM installmentcoll WHERE installmentcoll.xcus='".$cus."')";

				if($result==""){
					if($success){
						$this->model->editCustomer($cus);
						$this->model->itemUpdate($cus);
						$this->model->installmentDelete($where);
						$result = "Customer Separated successfully";
					}else{
						$result = "Separated failed!";
					}
				
				}
				 $this->showpost($cus,$result);
				
		
		}
		

		function cusupdateentry(){
				
		$btn = array(
			"Clear" => URL."customerseparate/cusupdateentry"
		);

		// form data
		
			$dynamicForm = new Dynamicform("Customer Separate",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields,"","", $this->values, URL."customerseparate/showpost");
			
			$this->view->table ="";
			
			$this->view->renderpage('customerseparate/stuextraentry', false);
		}
		

		public function showpost($cus="",$result=""){
			if($cus == ""){
				$cus = $_POST['xcus'];
			}else{
				$cus = $cus;
			}
			
		$tblvalues=array();
		$btn = array(
			"New" => URL."customerseparate/cusupdateentry"
		);
		
		$tblvalues = $this->model->getCustomer($cus);
		//print_r($tblvalues);die;
		$conf="";
		if(count($tblvalues)>0){
			if($tblvalues[0]['xstatus']=="Confirmed"){
				$conf=array(URL."customerseparate/editcustomer", "Separate");
			}
		}

		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=$tblvalues[0];
		// form data

			$dynamicForm = new Dynamicform("Customer Separate", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, "", "",$tblvalues, URL."customerseparate/showpost", $conf);
			
			$this->view->table = "";
			
			$this->view->renderpage('customerseparate/stuextraentry');
		}

		function picklist(){
			$this->view->table = $this->customerPickTable();
			
			$this->view->renderpage('customerseparate/customerpicklist', false);
		}
		
		function customerPickTable(){
			$fields = array(
						"xcus-Customer No",
						"xshort-Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xcustype-Customer Type"
						);
			$table = new Datatable();
			$row = $this->model->getCustomersByLimit();
			
			return $table->picklistTable($fields, $row, "xcus");
		}

		function customerlist(){
			$this->view->table = $this->itemTable();
			
			$this->view->renderpage('customerseparate/extrastulist', false);
		}

		function itemTable(){
			$fields = array(
						"xcus-Customer No",
						"xshort-Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xcustype-Customer Type"
						);
			$table = new Datatable();
			$row = $this->model->getCustomerAll();
			
			return $table->createTable($fields, $row, "xcus", URL."customerseparate/showpost/");
		}

}