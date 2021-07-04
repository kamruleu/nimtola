<?php 
class Customers extends Controller{
	
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
				if($menus["xsubmenu"]=="Customer Master")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','public/js/imageshow.js','views/customers/js/codevalidator.js','views/customers/js/getaccdt.js');
		$dt = date("Y/m/d");
		$this->values = array(
			"xdate"=>$dt,
			"prefix"=>"",
			"xcus"=>"",
			"xshort"=>"",
			"xorg"=>"",
			"xadd1"=>"",
			"xadd2"=>"",
			"xbillingadd"=>"",
			"xdeliveryadd"=>"",
			"xcity"=>"",
			"xprovince"=>"",
			"xpostal"=>"",
			"xcountry"=>"",
			"xcontact"=>"",
			"xtitle"=>"",
			"xphone"=>"",
			"xcusemail"=>"",
			"xmobile"=>"",
			"xfax"=>"",
			"xweburl"=>"",
			"xnid"=>"",
			"xtaxno"=>"",
			"xtaxscope"=>"",
			"xgcus"=>"None",
			"xpricegroup"=>"",
			"xcustype"=>"New",
			"xindustryseg"=>"",
			"xdiscountpct"=>"0",
			"xagent"=>"",
			"xagentcom"=>"0.00",
			"xbookcom"=>"0.00",
			"xcommisionpct"=>"0",
			"xcreditlimit"=>"0",
			"xcreditterms"=>"0",
			"zactive"=>"1",
			"xitemcode"=>"",
			"xitemdesc"=>"",
			"xoccupation"=>"",
			"xdob"=>$dt,
			"xreligion"=>"",
			"xnoname"=>"",
			"xnorelation"=>"",
			"xnoage"=>$dt,
			"nofather"=>"",
			"xnoadd"=>"",
			"xrate"=>"0.00",
			"xqty"=>"0",
			"xdownpay"=>"0.00",
			"xbookpay"=>"0.00",
			"xdevfee"=>"0.00",
			"xnotes"=>"",
			"xinsnum"=>"",
			"xinsdate"=>$dt,
			"xquotnum"=>"",
			"xtype"=>"At A Time",
			"xmonth"=>"",
			"xmonthint"=>"",
			"xchequeno"=>"",
			"xchequedate"=>$dt,
			"xrow"=>"0",
			"xtotalamt"=>"0.00",
			"xsepcus"=>""
			);
			
			$this->fields = array(array(
							"prefix-select_Customer Prefix"=>'Customer Prefix_maxlength="4"',
							"xcus-group_".URL."customers/picklist"=>'Customer Code_maxlength="20"'
							),
						array(
							"xshort-text"=>'Name_maxlength="160"',
							"xorg-text"=>'Description_maxlength="100"'
							),
						array(
							"xbillingadd-text"=>'Father/Husband_maxlength="160"',
							"xdeliveryadd-text"=>'Mother Name_maxlength="160"'
							),
						array(
							"xadd1-text"=>'Present Address_maxlength="160"',
							"xadd2-text"=>'Parmanent Address_maxlength="160"'
							),
						array(
							"xoccupation-select_Occupation"=>'Occupation_maxlength="160"',
							"xcountry-select_Country"=>'Nationality_maxlength="160"'
							),
						array(
							"xdob-datepicker"=>'Date Of Birth_""',
							"xreligion-select_Religion"=>'Religion_maxlength="160"'
							),		
						array(
							"xagent-group_".URL."agent/picklist"=>'Agent_maxlength="50"',
							"xcontact-text"=>'Contact_maxlength="50"'
							),
						array(
							"xcity-text"=>'PS_maxlength="50"',
							"xprovince-text"=>'District_maxlength="100"'
							),
						array(
							"xmobile-text"=>'Phone_maxlength="50"',
							"xphone-text"=>'Mobile_maxlength="50"'
							),
						array(
							"xcusemail-text"=>'Email_maxlength="50" email="true"',
							"xnid-text"=>'NID/PP/BIRTH_maxlength="50"'
							),		
						array(
							"zactive-checkbox_1"=>'Active?_""'
							),
						array(
							"Nominee Detail-div"=>''		
							),
						array(
							"xnoname-text"=>'Nominee Name_maxlength="160"',
							"xnorelation-text"=>'Relation_maxlength="100"'
							),
						array(
							"xnoage-datepicker"=>'Date Of Birth_""',
							"nofather-text"=>'Father/Husband_maxlength="160"'
							),
						array(
							"xnoadd-text"=>'Nominee Address_maxlength="160"'
							),
						array(
							"Sales Detail-div"=>''		
							),
						array(
							"xitemcode-group_".URL."itempicklist/picklist"=>'Plot No*~star_maxlength="20" readonly',
							"xdate-datepicker" => 'Sales Date_""'							
							),
						array(
							"xitemdesc-text"=>'Description_readonly',
							"xrate-text_number"=>'Rate(Katha)_number="true" minlength="1" maxlength="18" required'							
							),
						array(
							"xqty-text_number"=>'Quantity(Katha)*~star_number="true" minlength="1" maxlength="18" required',
							"xtotalamt-text_number"=>'Total Amount_number="true" minlength="1" maxlength="18" readonly'
							),
						array(
							"xbookpay-text_number"=>'Booking Payment._number="true" minlength="1" maxlength="18" required',
							"xdownpay-text_number"=>'Down Payment._number="true" minlength="1" maxlength="18" required'
							),
						array(
							"xbookcom-text_number"=>'Booking Commission_number="true" minlength="1" maxlength="18"',
							"xagentcom-text_number"=>'Agent Commission(%)_number="true" minlength="1" maxlength="18"'
							),
						array(
							"xchequeno-text"=>'Cheque No_maxlength="160"',
							"xchequedate-datepicker"=>'Cheque Date_maxlength="160"'
							),
						array(
							"xnotes-textarea"=>'Additional Notes_""'
							),
						array(
							"Installment Detail-div"=>''		
							),
						array(
							"xinsnum-group_".URL."installment/picklist"=>'Installment No_maxlength="20" readonly',
							"xinsdate-datepicker" => 'Installment Date_""'
							),
						array(							
							"xquotnum-text"=>'Quotation No_maxlength="50"',
							"xmonthint-text"=>'Month Interval_maxlength="50"'
							),
						array(
							"xtype-radio_At A Time_Multiple Month"=>'Installment Type_readonly',
							"xmonth-text"=>'Month Number_maxlength="50"',
							),
						array(
							"xcustype-radio_New_Separated"=>'Customer Type_readonly',
							"xsepcus-group_".URL."customers/sepcuspicklist"=>'From Customer_maxlength="20" readonly',
							"xrow-hidden"=>'_""'
							),
						array(
							"xtaxno-hidden"=>'',
							"xdevfee-hidden"=>'',
							"xtaxscope-hidden"=>'',
							"xgcus-hidden"=>'',
							"xpricegroup-hidden"=>'',
							"xdiscountpct-hidden"=>'',
							"xindustryseg-hidden"=>'',
							"xcommisionpct-hidden"=>'',
							"xcreditlimit-hidden"=>'',
							"xcreditterms-hidden"=>'',
							"xpostal-hidden"=>'',
							"xtitle-hidden"=>'',
							"xfax-hidden"=>'',
							"xweburl-hidden"=>'',
							"xinsnum-hidden"=>''
							)
						);
		}
		
		public function index(){
		
		
		$btn = array(
			"Clear" => URL."customers/customerentry",
		);	
		
		
		// form data
		//$this->createopbal();
			$dynamicForm = new Dynamicform("Customer",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."customers/savecustomers", "Save",$this->values,URL."customers/showpost");
			$this->view->table ="";
			//$this->view->table = $this->renderTable();
			
			$this->view->rendermainmenu('customers/index');
			
		}
		
		public function savecustomers(){
				$xdate = $_POST['xdate'];
				$dt = str_replace('/', '-', $xdate);
				$date = date('Y-m-d', strtotime($dt));
				$year = date('Y',strtotime($date));
				$month = date('m',strtotime($date));

				$xmonth = $_POST['xmonth'];
				//echo $xmonth;die;
				$xinsdate = $_POST['xinsdate'];
				$insdt = str_replace('/', '-', $xinsdate);
				$insdate = date('Y-m-d', strtotime($insdt));
				$insyear = date('Y',strtotime($insdate));
				$insmonth = date('m',strtotime($insdate));

				$xdob = $_POST['xdob'];
				$cdob = str_replace('/', '-', $xdob);
				$dob = date('Y-m-d', strtotime($cdob));

				$xnodob = $_POST['xnoage'];
				$nodob = str_replace('/', '-', $xnodob);
				$dobno = date('Y-m-d', strtotime($nodob));

				$xchedate = $_POST['xchequedate'];
				$chedt = str_replace('/', '-', $xchedate);
				$chedate = date('Y-m-d', strtotime($chedt));

				$yearoffset = Session::get('syearoffset');
				$xyear = 0;
				$per = 0;
				foreach ($this->model->getYearPer($yearoffset,intval($month)) as $key=>$val){
					$per = $key;
					$xyear = $val;
				}

				if (!isset($_POST['xcus'])){
					header ('location: '.URL.'customers');
					exit;
				}
				$cusauto =	Session::get('sbizcusauto');	
				$prefix = $_POST['prefix'];
				$keyfieldval="0";
				
				//print_r($keyfieldso);die;
				$form = new Form();
				$data = array();
				$inssuccess=0;
				$success=0;
				$result = "";
				try{
					
				
				$form	->post('xcus')
						->val('maxlength', 20)
									
				
						->post('xshort')
						->val('maxlength', 160)
				
						->post('xorg')
						->val('maxlength', 160)
						
						->post('xadd1')
						->val('maxlength', 160)
						
						->post('xadd2')
						->val('maxlength', 160)
						
						->post('xbillingadd')
						->val('maxlength', 160)
						
						->post('xdeliveryadd')
						->val('maxlength', 160)
						
						->post('xcity')
						->val('maxlength', 50)
						
						->post('xprovince')
						
						->post('xpostal')
						->val('maxlength', 20)
						
						->post('xcountry')
						
						->post('xcontact')
						->val('maxlength', 50)
						
						->post('xtitle')
						->val('maxlength', 50)
						
						->post('xphone')
						->val('maxlength', 15)
						
						->post('xfax')
						->val('maxlength', 20)
						
						->post('xmobile')
						->val('maxlength', 14)
						
						->post('xcusemail')
						->val('maxlength', 100)
						
						->post('xweburl')
						->val('maxlength', 50)
						
						->post('xnid')
						->val('maxlength', 20)
						
						->post('xtaxno')
						->val('maxlength', 20)
						
						->post('xtaxscope')
						
						->post('xgcus')
						
						->post('xpricegroup')
						
						->post('xcustype')

						->post('xsepcus')
						
						->post('xindustryseg')
						
						->post('xdiscountpct')
						->val('checkdouble')
						
						->post('xagent')
						->val('maxlength', 20)
						
						->post('xagentcom')
						->val('checkdouble')

						->post('xbookcom')
						->val('checkdouble')

						->post('xdevfee')
						->val('checkdouble')

						->post('xcommisionpct')
						->val('checkdouble')
						
						->post('xcreditlimit')
						->val('checkdouble')
						
						->post('xcreditterms')
						->val('digit')

						->post('xoccupation')						
						->val('maxlength', 100)

						->post('xdob')

						->post('xreligion')						
						->val('maxlength', 100)

						->post('xnoname')						
						->val('maxlength', 160)

						->post('xnorelation')						
						->val('maxlength', 100)

						->post('xnoage')						
						->val('maxlength', 10)

						->post('nofather')						
						->val('maxlength', 150)

						->post('xnoadd')						
						->val('maxlength', 150)

						->post('xbookpay')

						->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20)

						->post('xqty')
						
						->post('xdownpay')
						
						->post('xrate')

						->post('xnotes')						
						->val('maxlength', 100)

						->post('xinsnum')

						->post('xtype')
						
						->post('xmonth')

						->post('xmonthint')
						
						->post('xquotnum')

						->post('xchequeno')
						
						->post('zactive');
						
				$form	->submit();
				
				$data = $form->fetch();

				if($data['xcus'] == "")
				$keyfieldval = $this->model->getKeyValue("secus","xcus",$prefix,"6");
				else
				$keyfieldval = $data['xcus'];

				$tblvalues = $this->model->getSingleCustomer($keyfieldval);
				if (!empty($tblvalues)) {
					$keyfieldso = $tblvalues[0]['xsonum'];
				}else{
					$keyfieldso = $this->model->getKeyValue("secus","xsonum","SORD-","6");
				}
				
				$data['xcus'] = $keyfieldval;
				$data['xsonum'] = $keyfieldso;
				$data['xdate'] = $date;
				$data['xdob'] = $dob;
				$data['xnoage'] = $dobno;
				$data['xinsdate'] = $insdate;
				$data['xchequedate'] = $chedate;
				$data['xyear'] = $year;
				$data['xper'] = $month;
				$data['bizid'] = Session::get('sbizid');
				$data['zemail'] = Session::get('suser');

				$itemdetail = $this->model->getItemMaster("xitemcode",$data['xitemcode']);

				$rownum = $this->model->getRow("salesdt","xsonum",$data['xsonum'],"xrow");
				// $file = fopen("C:/Users/kamrul/Desktop/testdoc.txt","w");
				// echo fwrite($file,$cvals);
				// fclose($file);
				
				$cols = "`bizid`,`xsonum`,`xrow`,`xitemcode`,`xitembatch`,`xqty`,`xblock`,`xroad`,`xplot`,`xdate`,`xcost`,`xrate`,`xwh`,`xbranch`,`xproj`,`xtaxrate`,`xdisc`,`xexch`,`xcur`,`xtaxcode`,`xtaxscope`,`zemail`,`xunitsale`,`xcus`,`xyear`,`xper`,`xtypestk`";
				
				$vals = "(" . Session::get('sbizid') . ",'". $keyfieldso ."','". $rownum ."','". $data['xitemcode'] ."','". $data['xitemcode'] ."','". $data['xqty'] ."','". $itemdetail[0]['xcat'] ."','". $itemdetail[0]['xcolor'] ."','". $itemdetail[0]['xsize'] ."','". $date ."','0','". $data['xrate'] ."','None','". Session::get('sbranch') ."','". Session::get('sbranch') ."','0','0','1','BDT','". Session::get('sbizcur') ."','None','".$data['zemail']."','".$itemdetail[0]['xunitsale']."','". $data['xcus'] ."','".$xyear."','".$per."','".$itemdetail[0]['xtypestk']."')";

				//print_r($data);die;

				$success = $this->model->create($data,$cols,$vals);
				$getitem = $this->model->getitem($keyfieldval,$rownum);
				//print_r($getitem);die;
				
				if(empty($success))
					$success=0;
				
				
				}catch(Exception $e){
					
					$this->result = $e->getMessage();
					
				}
				
				if($success>0){
					$this->model->saleItem($getitem[0]['xitemcode']);
					$this->result = 'Customer saved successfully<br><a style="color:red" id="invnum" href="'.URL.'customers/showinvoice/'.$keyfieldval.'">Click To Print Invoice - '.$keyfieldval.'</a>';
					if ($_FILES['imagefield']["name"]){
						$imgupload = new ImageUpload();
						$imgupload->store_uploaded_image('images/nominee/nomilg/','imagefield', 400, 400,$keyfieldval);
						$imgupload->store_uploaded_image('images/nominee/nomism/','imagefield', 171, 181,$keyfieldval);
					}
					if ($_FILES['imagefield2']["name"]){
						$imgupload2 = new ImageUpload();
						$imgupload2->store_uploaded_image('images/customers/cuslg/','imagefield2', 400, 400,$keyfieldval);
						$imgupload2->store_uploaded_image('images/customers/cussm/','imagefield2', 171, 181,$keyfieldval);
					}
				}
				
				if($success == 0 && empty($this->result))
					$this->result = "Failed to save customer!";
				
				 $this->showentry($keyfieldval, $this->result);
				 
				 
				
		}
		
		public function editcustomer(){
			
			if (!isset($_POST['xcus'])){
					header ('location: '.URL.'customers');
					exit;
				}
			$result = "";
			$xdate = $_POST['xdate'];
			$dt = str_replace('/', '-', $xdate);
			$date = date('Y-m-d', strtotime($dt));
			$year = date('Y',strtotime($date));
			$month = date('m',strtotime($date));

			$xmonth = $_POST['xmonth'];
			//echo $xmonth;die;
			$xinsdate = $_POST['xinsdate'];
			$insdt = str_replace('/', '-', $xinsdate);
			$insdate = date('Y-m-d', strtotime($insdt));
			$insyear = date('Y',strtotime($insdate));
			$insmonth = date('m',strtotime($insdate));

			$xdob = $_POST['xdob'];
			$cdob = str_replace('/', '-', $xdob);
			$dob = date('Y-m-d', strtotime($cdob));

			$xnodob = $_POST['xnoage'];
			$nodob = str_replace('/', '-', $xnodob);
			$dobno = date('Y-m-d', strtotime($nodob));

			$xchedate = $_POST['xchequedate'];
			$chedt = str_replace('/', '-', $xchedate);
			$chedate = date('Y-m-d', strtotime($chedt));
			
			$success=false;
			$cus = $_POST['xcus'];
			$form = new Form();
				$data = array();
				
				try{
					
					
				
				
				$form	->post('xcus')
						->val('maxlength', 20)
									
				
						->post('xshort')
						->val('maxlength', 160)
				
						->post('xorg')
						->val('maxlength', 160)
						
						->post('xadd1')
						->val('maxlength', 160)
						
						->post('xadd2')
						->val('maxlength', 160)
						
						->post('xbillingadd')
						->val('maxlength', 160)
						
						->post('xdeliveryadd')
						->val('maxlength', 160)
						
						->post('xcity')
						->val('maxlength', 50)
						
						->post('xprovince')
						
						->post('xpostal')
						->val('maxlength', 20)
						
						->post('xcountry')
						
						->post('xcontact')
						->val('maxlength', 50)
						
						->post('xtitle')
						->val('maxlength', 50)
						
						->post('xphone')
						->val('maxlength', 15)
						
						->post('xfax')
						->val('maxlength', 20)
						
						->post('xmobile')
						->val('maxlength', 14)
						
						->post('xcusemail')
						->val('maxlength', 100)
						
						->post('xweburl')
						->val('maxlength', 50)
						
						->post('xnid')
						->val('maxlength', 20)
						
						->post('xtaxno')
						->val('maxlength', 20)
						
						->post('xtaxscope')
						
						->post('xgcus')
						
						->post('xpricegroup')
						
						->post('xcustype')

						->post('xsepcus')
						
						->post('xindustryseg')
						
						->post('xdiscountpct')
						->val('checkdouble')
						
						->post('xagent')
						->val('maxlength', 20)
						
						->post('xagentcom')
						->val('checkdouble')

						->post('xbookcom')
						->val('checkdouble')

						->post('xdevfee')
						->val('checkdouble')

						->post('xcommisionpct')
						->val('checkdouble')
						
						->post('xcreditlimit')
						->val('checkdouble')
						
						->post('xcreditterms')
						->val('digit')

						->post('xoccupation')						
						->val('maxlength', 100)

						->post('xdob')

						->post('xreligion')						
						->val('maxlength', 100)

						->post('xnoname')						
						->val('maxlength', 160)

						->post('xnorelation')						
						->val('maxlength', 100)

						->post('xnoage')						
						->val('maxlength', 10)

						->post('nofather')						
						->val('maxlength', 150)

						->post('xnoadd')						
						->val('maxlength', 150)

						->post('xbookpay')

						->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20)

						->post('xqty')
						
						->post('xdownpay')
						
						->post('xrate')

						->post('xnotes')						
						->val('maxlength', 100)

						->post('xinsnum')

						->post('xtype')
						
						->post('xmonth')

						->post('xmonthint')
						
						->post('xquotnum')

						->post('xchequeno')
						
						->post('zactive');
						
				$form	->submit();
				
				$data = $form->fetch();	
				//print_r($data);die;
				$data['xdate'] = $date;
				$data['xdob'] = $dob;
				$data['xnoage'] = $dobno;
				$data['xinsdate'] = $insdate;
				$data['xchequedate'] = $chedate;
				$data['xyear'] = $year;
				$data['xper'] = $month;
				$data['bizid'] = Session::get('sbizid');
				$data['xemail'] = Session::get('suser');
				$data['zutime'] = date("Y-m-d H:i:s");
				$itemdetail = $this->model->getItemMaster("xitemcode",$data['xitemcode']);

				$saledt = array (
					"xitemcode"=>$data['xitemcode'],
					"xitembatch"=>$data['xitemcode'],
					"xqty"=>$data['xqty'],
					"xcost"=>'0',
					"xrate"=>$data['xrate'],
					"xdisc"=>'0',
					"xtypestk"=>$itemdetail[0]['xtypestk'],
					"xunitsale"=>$itemdetail[0]['xunitsale'],
					"xwh"=>'None',
					"xbranch"=>Session::get('sbranch'),
					"xproj"=>Session::get('sbranch'),
					"xdate"=>$date,
					"xyear" => $year,
					"xper" => $month
				);
				$getitem = $this->model->getitem($cus,$_POST['xrow']);

				$this->model->itemupdate($getitem[0]['xitemcode']);

				$success = $this->model->editCustomer($data, $saledt, $cus, $_POST['xrow']);
				$item = $this->model->getitem($cus,$_POST['xrow']);
				
				}catch(Exception $e){
					//echo $e->getMessage();die;
					$result = $e->getMessage();
					
				}
				if($result==""){
				if($success){
					//print_r($item);die;
					$this->model->saleItem($item[0]['xitemcode']);
					$result = 'Customer Edit successfully<br><a style="color:red" id="invnum" href="'.URL.'customers/showinvoice/'.$cus.'">Click To Print Invoice - '.$cus.'</a>';
					$file1 = 'images/nominee/nomism/'.$cus.'.jpg';
					$file2 = 'images/customers/cussm/'.$cus.'.jpg';
					if ($_FILES['imagefield']["name"]){
						if(file_exists($file1))
							unlink($file1); 
						
						$imgupload = new ImageUpload();
						$imgupload->store_uploaded_image('images/nominee/nomilg/','imagefield', 400, 400,$cus);
						$imgupload->store_uploaded_image('images/nominee/nomism/','imagefield', 171, 181,$cus);
					}
					if ($_FILES['imagefield2']["name"]){
						if(file_exists($file2))
							unlink($file2); 
						
						$imgupload2 = new ImageUpload();
						$imgupload2->store_uploaded_image('images/customers/cuslg/','imagefield2', 400, 400,$cus);
						$imgupload2->store_uploaded_image('images/customers/cussm/','imagefield2', 171, 181,$cus);
					}
				}
				else
					$result = "Edit failed!";
				
				}
				 $this->showcustomer($cus, $result);
				
		
		}
		
		public function showcustomer($cus="", $result=""){
		if($cus==""){
			header ('location: '.URL.'customers');
			exit;
		}
		$tblvalues=array();
		$btn = array(
			"New" => URL."customers/customerentry"
		);
		
		$tblvalues = $this->model->getSingleCustomer($cus);
		$totamt = $this->model->getsalesdata($cus);

		$conf="";
		$sv="";
		$svbtn = "Save";
		if(count($tblvalues)>0){	
			if($tblvalues[0]['xstatus']=="Created"){
				$conf=array(URL."customers/confirmpost", "Confirm");
				$sv=URL."customers/savecustomers/";
			}		
			if($tblvalues[0]['xstatus']=="Confirmed"){
				$sv="";
				$conf=array(URL."customers/cancelpost", "Cancel");

			}		
		}
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
				"xcus"=>$tblvalues[0]['xcus'],
				"xshort"=>$tblvalues[0]['xshort'],
				"xorg"=>$tblvalues[0]['xorg'],
				"xadd1"=>$tblvalues[0]['xadd1'],
				"xadd2"=>$tblvalues[0]['xadd2'],
				"xbillingadd"=>$tblvalues[0]['xbillingadd'],
				"xdeliveryadd"=>$tblvalues[0]['xdeliveryadd'],
				"xcity"=>$tblvalues[0]['xcity'],
				"xprovince"=>$tblvalues[0]['xprovince'],
				"xpostal"=>$tblvalues[0]['xpostal'],
				"xcountry"=>$tblvalues[0]['xcountry'],
				"xcontact"=>$tblvalues[0]['xcontact'],
				"xtitle"=>$tblvalues[0]['xtitle'],
				"xphone"=>$tblvalues[0]['xphone'],
				"xcusemail"=>$tblvalues[0]['xcusemail'],
				"xmobile"=>$tblvalues[0]['xmobile'],
				"xfax"=>$tblvalues[0]['xfax'],
				"xweburl"=>$tblvalues[0]['xweburl'],
				"xnid"=>$tblvalues[0]['xnid'],
				"xtaxno"=>$tblvalues[0]['xtaxno'],
				"xtaxscope"=>$tblvalues[0]['xtaxscope'],
				"xgcus"=>$tblvalues[0]['xgcus'],
				"xpricegroup"=>$tblvalues[0]['xpricegroup'],
				"xcustype"=>$tblvalues[0]['xcustype'],
				"xsepcus"=>$tblvalues[0]['xsepcus'],
				"xindustryseg"=>$tblvalues[0]['xindustryseg'],
				"xdiscountpct"=>$tblvalues[0]['xdiscountpct'],
				"xagent"=>$tblvalues[0]['xagent'],
				"xagentcom"=>$tblvalues[0]['xagentcom'],
				"xbookcom"=>$tblvalues[0]['xbookcom'],
				"xdevfee"=>$tblvalues[0]['xdevfee'],
				"xcommisionpct"=>$tblvalues[0]['xcommisionpct'],
				"xcreditlimit"=>$tblvalues[0]['xcreditlimit'],
				"xcreditterms"=>$tblvalues[0]['xcreditterms'],
				"zactive"=>$tblvalues[0]['zactive'],
				"xoccupation"=>$tblvalues[0]['xoccupation'],
				"xdob"=>$tblvalues[0]['xdob'],
				"xreligion"=>$tblvalues[0]['xreligion'],
				"xnoname"=>$tblvalues[0]['xnoname'],
				"xnorelation"=>$tblvalues[0]['xnorelation'],
				"xnoage"=>$tblvalues[0]['xnoage'],
				"nofather"=>$tblvalues[0]['nofather'],
				"xnoadd"=>$tblvalues[0]['xnoadd'],
				"xitemcode"=>"",
				"xdate"=>$tblvalues[0]['xdate'],
				"xitemdesc"=>"",
				"xrate"=>"0.00",
				"xqty"=>"0",
				"xdownpay"=>$tblvalues[0]['xdownpay'],
				"xbookpay"=>$tblvalues[0]['xbookpay'],
				"xnotes"=>$tblvalues[0]['xnotes'],
				"xsonum"=>$tblvalues[0]['xsonum'],
				"xinsnum"=>"",
				"xinsdate"=>$tblvalues[0]['xinsdate'],
				"xquotnum"=>$tblvalues[0]['xquotnum'],
				"xtype"=>$tblvalues[0]['xtype'],
				"xmonth"=>$tblvalues[0]['xmonth'],
				"xmonthint"=>$tblvalues[0]['xmonthint'],
				"xtotalamt"=>$totamt[0]['amt'],
				"xchequeno"=>$tblvalues[0]['xchequeno'],
				"xchequedate"=>$tblvalues[0]['xchequedate'],
				"xrow"=>"0"
			);
			
		
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Customer", $btn, $result);
			$file = 'images/customers/cussm/'.$cus.'.jpg';
			$file2 = 'images/nominee/nomism/'.$cus.'.jpg';
		
		$imagename = "";	
		$imagename2 = "";	
		if(file_exists($file))
			$imagename = '../../../'.$file;
		else
			$imagename = '../../../images/customers/noimage.jpg';
			
		if(file_exists($file2))
			$imagename2 = '../../../'.$file2;
		else
			$imagename2 = '../../../images/nominee/noimage.jpg';

			$this->view->filename1 = $imagename;
			$this->view->filename2 = $imagename2;
			$this->view->dynform = $dynamicForm->createForm($this->fields, $sv, $svbtn,$tblvalues ,URL."customers/showpost",$conf,"imagefield","imagefield2");
			
			$this->view->table = $this->renderTable($cus);
			
			$this->view->renderpage('customers/customerentry');
		}


		public function editshowcus($cus="", $row="", $result=""){
		if($cus==""){
			header ('location: '.URL.'customers');
			exit;
		}
		$tblvalues=array();
		$btn = array(
			"New" => URL."customers/customerentry"
		);
		
		$tblvalues = $this->model->getSingleCustomer($cus);
		$singlecus = $this->model->getsinglesalesdt($cus,$row);

		$conf="";
		$sv="";
		$svbtn = "Update";
		if(count($tblvalues)>0){	
			if($tblvalues[0]['xstatus']=="Created"){
				$conf=array(URL."customers/confirmpost", "Confirm");
				$sv=URL."customers/editcustomer/";
			}		
			if($tblvalues[0]['xstatus']=="Confirmed"){
				$sv="";
				$conf=array(URL."customers/cancelpost", "Cancel");

			}		
		}
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
				"xcus"=>$tblvalues[0]['xcus'],
				"xshort"=>$tblvalues[0]['xshort'],
				"xorg"=>$tblvalues[0]['xorg'],
				"xadd1"=>$tblvalues[0]['xadd1'],
				"xadd2"=>$tblvalues[0]['xadd2'],
				"xbillingadd"=>$tblvalues[0]['xbillingadd'],
				"xdeliveryadd"=>$tblvalues[0]['xdeliveryadd'],
				"xcity"=>$tblvalues[0]['xcity'],
				"xprovince"=>$tblvalues[0]['xprovince'],
				"xpostal"=>$tblvalues[0]['xpostal'],
				"xcountry"=>$tblvalues[0]['xcountry'],
				"xcontact"=>$tblvalues[0]['xcontact'],
				"xtitle"=>$tblvalues[0]['xtitle'],
				"xphone"=>$tblvalues[0]['xphone'],
				"xcusemail"=>$tblvalues[0]['xcusemail'],
				"xmobile"=>$tblvalues[0]['xmobile'],
				"xfax"=>$tblvalues[0]['xfax'],
				"xweburl"=>$tblvalues[0]['xweburl'],
				"xnid"=>$tblvalues[0]['xnid'],
				"xtaxno"=>$tblvalues[0]['xtaxno'],
				"xtaxscope"=>$tblvalues[0]['xtaxscope'],
				"xgcus"=>$tblvalues[0]['xgcus'],
				"xpricegroup"=>$tblvalues[0]['xpricegroup'],
				"xcustype"=>$tblvalues[0]['xcustype'],
				"xsepcus"=>$tblvalues[0]['xsepcus'],
				"xindustryseg"=>$tblvalues[0]['xindustryseg'],
				"xdiscountpct"=>$tblvalues[0]['xdiscountpct'],
				"xagent"=>$tblvalues[0]['xagent'],
				"xagentcom"=>$tblvalues[0]['xagentcom'],
				"xbookcom"=>$tblvalues[0]['xbookcom'],
				"xdevfee"=>$tblvalues[0]['xdevfee'],
				"xcommisionpct"=>$tblvalues[0]['xcommisionpct'],
				"xcreditlimit"=>$tblvalues[0]['xcreditlimit'],
				"xcreditterms"=>$tblvalues[0]['xcreditterms'],
				"zactive"=>$tblvalues[0]['zactive'],
				"xoccupation"=>$tblvalues[0]['xoccupation'],
				"xdob"=>$tblvalues[0]['xdob'],
				"xreligion"=>$tblvalues[0]['xreligion'],
				"xnoname"=>$tblvalues[0]['xnoname'],
				"xnorelation"=>$tblvalues[0]['xnorelation'],
				"xnoage"=>$tblvalues[0]['xnoage'],
				"nofather"=>$tblvalues[0]['nofather'],
				"xnoadd"=>$tblvalues[0]['xnoadd'],
				"xitemcode"=>$singlecus[0]['xitemcode'],
				"xdate"=>$tblvalues[0]['xdate'],
				"xitemdesc"=>$singlecus[0]['xitemdesc'],
				"xrate"=>$singlecus[0]['xrate'],
				"xqty"=>$singlecus[0]['xqty'],
				"xdownpay"=>$tblvalues[0]['xdownpay'],
				"xbookpay"=>$tblvalues[0]['xbookpay'],
				"xnotes"=>$tblvalues[0]['xnotes'],
				"xsonum"=>$tblvalues[0]['xsonum'],
				"xinsnum"=>"",
				"xinsdate"=>$tblvalues[0]['xinsdate'],
				"xquotnum"=>$tblvalues[0]['xquotnum'],
				"xtype"=>$tblvalues[0]['xtype'],
				"xmonth"=>$tblvalues[0]['xmonth'],
				"xmonthint"=>$tblvalues[0]['xmonthint'],
				"xtotalamt"=>$singlecus[0]['amt'],
				"xchequeno"=>$tblvalues[0]['xchequeno'],
				"xchequedate"=>$tblvalues[0]['xchequedate'],
				"xrow"=>$singlecus[0]['xrow']
			);
			
		
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Customer", $btn, $result);
			$file = 'images/customers/cussm/'.$cus.'.jpg';
			$file2 = 'images/nominee/nomism/'.$cus.'.jpg';
		
		$imagename = "";	
		$imagename2 = "";	
		if(file_exists($file))
			$imagename = '../../../'.$file;
		else
			$imagename = '../../../images/customers/noimage.jpg';
			
		if(file_exists($file2))
			$imagename2 = '../../../'.$file2;
		else
			$imagename2 = '../../../images/nominee/noimage.jpg';

			$this->view->filename1 = $imagename;
			$this->view->filename2 = $imagename2;
			$this->view->dynform = $dynamicForm->createForm($this->fields, $sv, $svbtn,$tblvalues ,URL."customers/showpost",$conf,"imagefield","imagefield2");
			
			$this->view->table = $this->renderTable($cus);
			
			$this->view->renderpage('customers/customerentry');
		}
		
		
		
		public function showentry($cus, $result=""){
		
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."customers/customerentry"
		);
		
		$tblvalues = $this->model->getSingleCustomer($cus);
		$tblvaluesins = $this->model->getSingleInsdt($cus);
		$totamt = $this->model->getsalesdata($cus);
		
		$conf="";
		$sv="";
		$svbtn = "Save";
		if(count($tblvalues)>0){	
			if($tblvalues[0]['xstatus']=="Created"){
				$conf=array(URL."customers/confirmpost", "Confirm");
				$sv=URL."customers/savecustomers/";
			}		
			if($tblvalues[0]['xstatus']=="Confirmed"){
				$sv="";
				$conf=array(URL."customers/cancelpost", "Cancel");

			}		
		}

		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
				"xcus"=>$tblvalues[0]['xcus'],
				"xshort"=>$tblvalues[0]['xshort'],
				"xorg"=>$tblvalues[0]['xorg'],
				"xadd1"=>$tblvalues[0]['xadd1'],
				"xadd2"=>$tblvalues[0]['xadd2'],
				"xbillingadd"=>$tblvalues[0]['xbillingadd'],
				"xdeliveryadd"=>$tblvalues[0]['xdeliveryadd'],
				"xcity"=>$tblvalues[0]['xcity'],
				"xprovince"=>$tblvalues[0]['xprovince'],
				"xpostal"=>$tblvalues[0]['xpostal'],
				"xcountry"=>$tblvalues[0]['xcountry'],
				"xcontact"=>$tblvalues[0]['xcontact'],
				"xtitle"=>$tblvalues[0]['xtitle'],
				"xphone"=>$tblvalues[0]['xphone'],
				"xcusemail"=>$tblvalues[0]['xcusemail'],
				"xmobile"=>$tblvalues[0]['xmobile'],
				"xfax"=>$tblvalues[0]['xfax'],
				"xweburl"=>$tblvalues[0]['xweburl'],
				"xnid"=>$tblvalues[0]['xnid'],
				"xtaxno"=>$tblvalues[0]['xtaxno'],
				"xtaxscope"=>$tblvalues[0]['xtaxscope'],
				"xgcus"=>$tblvalues[0]['xgcus'],
				"xpricegroup"=>$tblvalues[0]['xpricegroup'],
				"xcustype"=>$tblvalues[0]['xcustype'],
				"xsepcus"=>$tblvalues[0]['xsepcus'],
				"xindustryseg"=>$tblvalues[0]['xindustryseg'],
				"xdiscountpct"=>$tblvalues[0]['xdiscountpct'],
				"xagent"=>$tblvalues[0]['xagent'],
				"xagentcom"=>$tblvalues[0]['xagentcom'],
				"xbookcom"=>$tblvalues[0]['xbookcom'],
				"xdevfee"=>$tblvalues[0]['xdevfee'],
				"xcommisionpct"=>$tblvalues[0]['xcommisionpct'],
				"xcreditlimit"=>$tblvalues[0]['xcreditlimit'],
				"xcreditterms"=>$tblvalues[0]['xcreditterms'],
				"zactive"=>$tblvalues[0]['zactive'],
				"xoccupation"=>$tblvalues[0]['xoccupation'],
				"xdob"=>$tblvalues[0]['xdob'],
				"xreligion"=>$tblvalues[0]['xreligion'],
				"xnoname"=>$tblvalues[0]['xnoname'],
				"xnorelation"=>$tblvalues[0]['xnorelation'],
				"xnoage"=>$tblvalues[0]['xnoage'],
				"nofather"=>$tblvalues[0]['nofather'],
				"xnoadd"=>$tblvalues[0]['xnoadd'],
				"xbookpay"=>$tblvalues[0]['xbookpay'],
				"xitemcode"=>"",
				"xitemdesc"=>"",
				"xdate"=>$tblvalues[0]['xdate'],
				"xrate"=>"0.00",
				"xqty"=>"0",
				"xdownpay"=>$tblvalues[0]['xdownpay'],
				"xnotes"=>$tblvalues[0]['xnotes'],
				"xsonum"=>$tblvalues[0]['xsonum'],
				"xinsnum"=>"",
				"xinsdate"=>$tblvalues[0]['xinsdate'],
				"xquotnum"=>$tblvalues[0]['xquotnum'],
				"xtype"=>$tblvalues[0]['xtype'],
				"xmonth"=>$tblvalues[0]['xmonth'],
				"xmonthint"=>$tblvalues[0]['xmonthint'],
				"xtotalamt"=>$totamt[0]['amt'],
				"xchequeno"=>$tblvalues[0]['xchequeno'],
				"xchequedate"=>$tblvalues[0]['xchequedate'],
				"xrow"=>"0"
			);
		
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Customer", $btn, $result);	
				$file = 'images/customers/cussm/'.$cus.'.jpg';
				$file2 = 'images/nominee/nomism/'.$cus.'.jpg';
		
		$imagename = "";	
		$imagename2 = "";	
		if(file_exists($file))
			$imagename = '../'.$file;
		else
			$imagename = '../images/customers/noimage.jpg';
			
		if(file_exists($file2))
			$imagename2 = '../'.$file2;
		else
			$imagename2 = '../images/nominee/noimage.jpg';

			$this->view->filename1 = $imagename;
			$this->view->filename2 = $imagename2;
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, $sv, $svbtn,$tblvalues ,URL."customers/showpost",$conf,"imagefield","imagefield2");
			
			$this->view->table = $this->renderTable($cus);
			
			$this->view->renderpage('customers/customerentry');
		}
		
		function renderTable($txnnum){
			
			$sales = $this->model->getCusSale($txnnum);
			$status = "";
			if(!empty($sales))
				$status = $sales[0]["xstatus"];
			
			$delbtn = "";
			if(count($sales)>0){
			if($sales[0]["xstatus"]=="Created")
				$delbtn = URL."customers/deletesales/".$txnnum."/";
				
			}
			
			$row = $this->model->getvsalesdt($txnnum);
			
			$table = '<table class="table table-striped table-bordered">';
				$table .='<thead>
							<th></th><th></th><th>Sl.</th><th>Itemcode</th><th>Description</th><th style="text-align:right">Rate</th><th style="text-align:right">Qty</th><th style="text-align:right">Total</th>
						</thead>';
						$totalqty = 0;
						$totalextqty = 0;
						$total = 0;
						$totaltax = 0;
						$totaldisc = 0;
						$table .='<tbody>';

						foreach($row as $key=>$val){
							$showurl = URL."customers/editshowcus/".$txnnum."/".$val['xrow'];
							$table .='<tr>';
							
							$table.='<td><a class="btn btn-info" id="btnshow" href="'.$showurl.'" role="button">Show</a></td>';
							if($delbtn!="")
								$table.='<td><a id="delbtn" class="btn btn-danger" href="'.$delbtn."/".$val['xrow'].'" role="button">Delete</a></td>';
							else
								$table.='<td></td>';

								$table .= "<td>".$val['xrow']."</td>";
								$table .= "<td>".$val['xitemcode']."</td>";
								$table .= "<td>".$val['xitemdesc']."</td>";
								$table .='<td align="right">'.$val['xrate'].'</td>';		
								$table .='<td align="right">'.number_format($val['xqty'],2).'</td>';
								$table .='<td align="right">'.number_format($val['xsubtotal'],2).'</td>';
								$total+=$val['xsubtotal'];
								$totalqty+=	$val['xqty'];
								
							$table .="</tr>";
						}
							$table .='<tr><td align="right" colspan="6"><strong>Total</strong></td><td align="right"><strong>'.number_format($totalqty,2).'</strong></td><td align="right"><strong>'.number_format($total,2).'</strong></td></tr>';
							
							if(!empty($sales)){
							$table .='<tr><td align="right" colspan="7"><strong>Received Amt.</strong></td><td align="right"><strong>'.$sales[0]["xbookpay"].'</strong></td></tr>';
							}	
					$table .="</tbody>";			
			$table .= "</table>";
			
			return $table;
			
			
		}
 
		function showinvoice($txnnum=""){
			
			$values = $this->model->getSingleCustomer($txnnum);
			$value = $this->model->getSalesDt($txnnum);
			$getplot = $this->model->getSalesPlot($txnnum);

			$valu = $this->model->getItemDt($value[0]['xitemcode']);
			//print_r($valu);die;
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li>Sales Invoice</li>							
						   </ul>';
			
			$this->view->cus=$txnnum;
			//$totqty = 0;			
			//$xdate="";
			$xcus="";
			$name="";
			$fname="";
			$fname="";
			$pradd="";
			$paradd="";
			$occupation="";
			$dob="";
			$nationality="";
			$nid="";
			$xmobile="";
			$religion="";
			$noname="";
			$norelation="";
			$noage="";
			$nofather="";
			$noadd="";
			$insmonth="";
			$bookpay="";
			$downpay="";
			$block="";
			$rod="";
			$plot="";
			$katha="";
				
				// if($rodqty[0]["xqty"]!=0)	
				// 	$narretion = " Rod ".number_format($rodqty[0]["xqty"],2)." KG And ".$rodqty[0]["xextqty"]." Bundle<br/>";
				// if($cementqty[0]["xqty"]!=0)	
				// 	$narretion .= " Cement ".$cementqty[0]["xqty"]." BAG ";
			
			foreach($values as $key=>$val){
				//$xdate=$val['xdate'];
				$xcus=$val['xcus'];
				$name=$val['xshort'];
				$fname=$val['xbillingadd'];
				$mname=$val['xdeliveryadd'];
				//$truckamt=$val['xtruckfair'];
				$pradd=$val['xadd1'];
				$paradd=$val['xadd2'];
				$occupation=$val['xoccupation'];
				$dob=$val['xdob'];
				$nationality=$val['xcountry'];
				$nid=$val['xnid'];
				$xmobile=$val['xphone'];
				$religion=$val['xreligion'];
				$noname=$val['xnoname'];
				$norelation=$val['xnorelation'];
				$noage=$val['xnoage'];
				$nofather=$val['nofather'];
				$noadd=$val['xnoadd'];
				$insmonth=$val['xmonth'];
				$bookpay=$val['xbookpay'];
				$downpay=$val['xdownpay'];
				$chequeno=$val['xchequeno'];
				$chequedate=$val['xdate'];

				
			}
			foreach($valu as $key=>$val){
				
				$block=$val['xcat'];
				$rod=$val['xcolor'];

				
			}
		foreach($value as $key=>$val){
				
				$totrate=$val['xtotrate'];
				$katha=$val['totkatha'];

			}
			

			$this->view->getplot=$getplot;
			$this->view->cus=$xcus;
			$this->view->name=$name;
			$this->view->fname=$fname;
			$this->view->mname=$mname;
			$this->view->pradd=$pradd;
			$this->view->paradd=$paradd;
			$this->view->occupation=$occupation;
			$this->view->dob=$dob;
			$this->view->nationality=$nationality;
			$this->view->nid=$nid;
			$this->view->xmobile=$xmobile;		
			$this->view->religion=$religion;	
			$this->view->noname=$noname;
			$this->view->norelation=$norelation;
			$this->view->noage=$noage;
			$this->view->nofather=$nofather;
			$this->view->noadd=$noadd;
			$this->view->insmonth=$insmonth;
			$this->view->bookpay=$bookpay;
			$this->view->downpay=$downpay;
			$this->view->block=$block;
			$this->view->rod=$rod;
			$this->view->katha=$katha;
			$this->view->chequeno=$chequeno;
			$this->view->chequedate=$chequedate;
			$this->view->totrate=$totrate;
			//$cur = new Currency();
			
			//$this->view->vrow = $values;
			$cur = new Currency();
			$this->view->inword=$cur->get_bd_amount_in_text($bookpay);
			$this->view->inworddown=$cur->get_bd_amount_in_text($downpay);
			$this->view->inwordtotal=$cur->get_bd_amount_in_text($totrate);
			//$this->view->inword="In Words: ";
			$this->view->vrptname = "Invoice/Bill";
			$this->view->org=Session::get('sbizlong');
			$this->view->add=Session::get('sbizadd');
			
			$this->view->renderpage('customers/printinvoice');		
		}

		function confirmpost(){
			$voucher ="";
			$cus = $_POST['xcus'];
			
			$cofcus=array();
			$cofcus = $this->model->getSingleCustomer($cus);

			if ($cofcus[0]['xbookpay']>0) {
				$comamt=$cofcus[0]['xbookcom'];
				$comtype='Booking Commission';
			}elseif($cofcus[0]['xdownpay']>0){
				$comamt=$cofcus[0]['xbookcom'];
				$comtype='Down Payment Commission';
			}else{
				$comtype="";
			}

			$postdata=array(
					"xstatus" => "Confirmed",
					"xcomamt" => $comamt,
					"xcomtype" => $comtype
					);
			$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";

			$yearoffset = Session::get('syearoffset');
			$narretion = "";
			$xinsdate = $cofcus[0]['xinsdate'];
			$insdt = str_replace('/', '-', $xinsdate);
			$insdate = date('Y-m-d', strtotime($insdt));
			$insyear = date('Y',strtotime($insdate));
			$insmonth = date('m',strtotime($insdate));
			$inssuccess=0;



			if($cofcus[0]['xstatus']=="Confirmed"){
					$result='Customer Already Confirmed!';
				}

				$rows = $this->model->getsalesForConfirm($cus);
				$glinterface = $this->model->glsalesinterface();

				if(!empty($glinterface)){

					$xdate = $_POST['xdate'];
					$dt = str_replace('/', '-', $xdate);
					$date = date('Y-m-d', strtotime($dt));
					$year = date('Y',strtotime($date));
					$month = date('m',strtotime($date)); 
						//glheader goes here
						$xyear = 0;
						$per = 0;
						//print_r($this->model->getYearPer($yearoffset,intval($month))); die;
						foreach ($this->model->getYearPer($yearoffset,intval($month)) as $key=>$val){
							$per = $key;
							$xyear = $val;
						}
						$voucher = $this->model->getKeyValue("glheader","xvoucher","SINV".Session::get('suserrow')."-","6");
						
						$data = array();

						$data['bizid'] = Session::get('sbizid');
						$data['zemail'] = Session::get('suser');
						$data['xnarration'] = $cofcus[0]['xsonum'].$narretion." ;".$cus."-".$cofcus[0]['xshort']."-".$cofcus[0]['xadd1'];
						$data['xyear'] = $xyear;
						$data['xper'] = $per;
						$data['xvoucher'] = $voucher;
						$data['xdate'] = $date;
						$data['xstatusjv'] = 'Confirmed';
						$data['xbranch'] = Session::get('sbranch');
						$data['xdoctype'] = "Sales Voucher";
						$data['xdocnum'] = $cofcus[0]['xsonum'];

						$cols = "`bizid`,`xvoucher`,`xrow`,`xacc`,`xacctype`,`xaccusage`,`xaccsource`,xaccsub,`xcur`,`xbase`,`xexch`,`xprime`,xflag,xremarks";

						$vals = "";	

						$i = 0;	
						$globalvar = new Globalvar();
						foreach($glinterface as $key=>$val){
							$i++;
							$amt = $globalvar->getFormula($rows,$val["xformula"], $rows[0]['xgrossdisc'], $rows[0]['xrcvamt']);
							
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
					if($cofcus[0]['xbookpay']>0){
								
						$i1 = $i+1;
						$i2 = $i+2;
						$bacc = $this->model->getAcc('9100');
						$cacc = $this->model->getAcc('1029');

							$bcols = "`bizid`,`xvoucher`,`xrow`,`xacc`,`xacctype`,`xaccusage`,`xaccsource`,xaccsub,`xcur`,`xbase`,`xexch`,`xprime`,xflag,xremarks";
						
							$bvals .= "(" . Session::get('sbizid') . ",'". $voucher ."','".$i1."','1029','". $cacc[0]['xacctype'] ."','". $cacc[0]['xaccusage'] ."','". $cacc[0]['xaccsource'] ."','','".Session::get('sbizcur')."','". $cofcus[0]['xbookpay'] ."','1','". $cofcus[0]['xbookpay'] ."','Debit',''),
							(" . Session::get('sbizid') . ",'". $voucher ."','".$i2."','9100','". $bacc[0]['xacctype'] ."','". $bacc[0]['xaccusage'] ."','". $bacc[0]['xaccsource'] ."','','".Session::get('sbizcur')."','-". $cofcus[0]['xbookpay'] ."','1','-". $cofcus[0]['xbookpay'] ."','Credit','')";

							$this->model->confirmbpay($data, $bcols, $bvals);
						}
					
				}
				
				$keyfieldins = $this->model->getKeyValue("installmentmst","xinsnum","INS-","6");
				$saledt = $this->model->getsalesdata($cus);
				//print_r($saledt);die;
				$inssl = $this->model->getRow("installmentmst","xinsnum",$keyfieldins,"xinssl");
				//print_r($inssl);die;
				$icols = "bizid,xcus,xagent,xagentcom,xquotnum,xinssl,xdate,xinsnum,xpct,xamount,zemail,xbranch,xyear,xper";
				$ivals ="";
				if ($cofcus[0]['xmonth']!="") {
					$amt = ($saledt[0]['amt']-$cofcus[0]['xdownpay'])/$cofcus[0]['xmonth'];
				}else{
					$amt = ($saledt[0]['amt']-$cofcus[0]['xdownpay'])/1;
				}
				//print_r($amt);die;
				if($cofcus[0]['xtype']=='Multiple Month' && $cofcus[0]['xmonth']>1){
					$invm = $cofcus[0]['xmonthint'];
					for($i=1; $i<=$cofcus[0]['xmonth']; $i++){

						$dte = date('Y-m-d', strtotime($saledt[0]['xdate'].'+'.$invm.' month'));
						$mnth = date('n',strtotime($dte));
						$yar = date('Y',strtotime($dte));
						$ivals .= "(" . Session::get('sbizid') . ",'". $cofcus[0]['xcus'] ."','". $cofcus[0]['xagent'] ."','". $cofcus[0]['xagentcom'] ."','". $cofcus[0]['xquotnum'] ."',
						'".$inssl."', '".$dte."', '". $keyfieldins ."','0','". $amt ."','". Session::get('suser') ."','". Session::get('sbranch') ."',
						'". $yar ."','". $mnth ."'),";

						$invm = $invm+$cofcus[0]['xmonthint'];
						$inssl++;
					}
				}elseif($cofcus[0]['xtype']=='At A Time'){
						$ivals = "(" . Session::get('sbizid') . ",'". $cofcus[0]['xcus'] ."','". $cofcus[0]['xagent'] ."','". $cofcus[0]['xagentcom'] ."','". $cofcus[0]['xquotnum'] ."','".$inssl."',
						'". $cofcus[0]['xinsdate'] ."', '". $keyfieldins ."','0','". $amt ."','". Session::get('suser') ."','". Session::get('sbranch') ."',
						'". $insyear ."','". $insmonth ."')";
				}
						$ivals = rtrim($ivals,",");

			$this->model->confirm($postdata,$where);

			$tblvalues=array();
			$tblvalues = $this->model->getSingleCustomer($cus);
			if($tblvalues[0]['xstatus']=="Confirmed"){

				$inssuccess = $this->model->InsCreate($icols,$ivals);
				if ($inssuccess>0) {
					$result='Customer Confirmed!';
				}
				
			}else{
				$result="Confirm Failed";
			}
			$this->showentry($cus, $result);

		}

		function cancelpost(){
			$cus = $_POST['xcus'];
			$cuscan=array();
			$cuscan = $this->model->getSingleCustomer($cus);
			if($cuscan[0]['xstatus']=="Canceled"){
					$result='Customer Already Canceled!';
				}else{
					$postdata=array(
					"xstatus" => "Canceled"
					);				
					$where = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";

					$insdata=array(
					"xactive" => "Canceled"
					);				
					$inswhere = " bizid = ". Session::get('sbizid') ." and xcus = '". $cus ."'";

					$this->model->confirm($postdata,$where);
					$tblvalues=array();
					$tblvalues = $this->model->getSingleCustomer($cus);
					if($tblvalues[0]['xstatus']=="Canceled"){

						$this->model->Cancel($insdata,$inswhere);
						$result='Customer Canceled!';
					}else{
						$result='Canceled Failed!';
					}
				}
				$this->showentry($cus, $result);
		}
		
		function customerlist($status){ 
			$btn = '<div>
				<a href="'.URL.'customers/allcustomers" class="btn btn-primary">Print Customer List</a>
				<a href="'.URL.'customers/printinvoiceblank" class="btn btn-primary">Blank Invoice Print</a>
				</div>
				<div>
				<hr/>
				</div>';
			$this->view->table = $btn.$this->itemTable($status);
			
			$this->view->renderpage('customers/customerlist', false);
		}
		
		function picklist(){
			$this->view->table = $this->customerPickTable();
			
			$this->view->renderpage('customers/customerpicklist', false);
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

		function sepcuspicklist(){
			$this->view->table = $this->sepcusPickTable();
			
			$this->view->renderpage('customers/customerpicklist', false);
		}
		
		function sepcusPickTable(){
			$fields = array(
						"xsepcus-Customer No",
						"xshort-Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xcustype-Customer Type"
						);
			$table = new Datatable();
			$row = $this->model->getSeparatedCustomer();
			
			return $table->picklistTable($fields, $row, "xsepcus");
		}
		
		function itemTable($status){
			$fields = array(
						"xcus-Customer No",
						"xshort-Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xcustype-Customer Type"
						);
			$table = new Datatable();
			$row = $this->model->getCustomers($status);
			
			return $table->createTable($fields, $row, "xcus", URL."customers/showcustomer/");
		}

		function plotwisesales(){ 
			
			$this->view->table = $this->plotTable();
			
			$this->view->renderpage('customers/customerlist', false);
		}
		function plotTable(){
			$fields = array(
						"xcus-Customer No",
						"xshort-Name",
						"xitemcode-Item",
						"xdesc-Description",
						"xblock-Block",
						"xroad-Road",
						"xplot-Plot",
						"xqty-Katha"
						);
			$table = new Datatable();
			$row = $this->model->getPlotDetail();
			
			return $table->createTable($fields, $row, "xcus", URL."customers/showcustomer/");
		}
		
		function printinvoiceblank(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li>Sales Invoice</li>							
						   </ul>';
			
			$this->view->renderpage('customers/printinvoiceblank', false);
		}

		function allcustomers(){
			$fields = array(
						"xcus-Customer No",
						"xshort-Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xcustype-Customer Type"
						);
			$table = new Datatable();
			$row = $this->model->getCustomersByLimit();
			$btn = '<div><a class="btn btn-primary" href="javascript:void(0);" onclick="window.print();" role="button">
			<span class="glyphicon glyphicon-print"></span>&nbsp;Print</a>
			</div><div id="printdiv"><div style="text-align:center">'.Session::get('sbizlong').'<br/>Customer List</div><hr/>';
			$this->view->table=$btn.$table->myTable($fields, $row, "xcus")."</div>";
			$this->view->renderpage('customers/customerlist', false);
		}
		
		function customerentry(){
				
		$btn = array(
			"Clear" => URL."customers/customerentry"
		);

		// form data
		
			$dynamicForm = new Dynamicform("Customer",$btn);		
			$imagename1 = '../images/products/noimage.jpg';
			$imagename2 = '../images/nominee/noimage.jpg';
			
			$this->view->filename1 = $imagename1;
			$this->view->filename2= $imagename2;
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."customers/savecustomers	", "Save",$this->values, URL."customers/showpost","","imagefield","imagefield2");
			$this->view->table ="";
			//$this->view->table = $this->renderTable();
			
			$this->view->renderpage('customers/customerentry', false);
		}
		
		public function deletesales($cus, $row){
			$tblvalues = $this->model->getCusSale($cus);
			$item = $this->model->getitem($cus, $row);
			$result = "";
			if(count($tblvalues)>0){
			if($tblvalues[0]["xstatus"]=="Created")
				$result = $this->model->delete(" where xcus='".$cus."' and xrow=".$row);
			$this->model->itemupdate($item[0]['xitemcode']);
			}
			$this->showcustomer($cus, $result);
		}
		
		public function showpost(){
		$cus = $_POST['xcus'];
		//print_r($cus);die;
			
		$tblvalues=array();
		$btn = array(
			"New" => URL."customers/customerentry"
		);
		
		$tblvalues = $this->model->getSingleCustomer($cus);
		$totamt = $this->model->getsalesdata($cus);
		$conf="";
		$sv="";
		$svbtn = "Save";
		if(count($tblvalues)>0){	
			if($tblvalues[0]['xstatus']=="Created"){
				$conf=array(URL."customers/confirmpost", "Confirm");
				$sv=URL."customers/savecustomers/";
			}		
			if($tblvalues[0]['xstatus']=="Confirmed"){
				$sv="";
				$conf=array(URL."customers/cancelpost", "Cancel");

			}		
		}
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
				"xcus"=>$tblvalues[0]['xcus'],
				"xshort"=>$tblvalues[0]['xshort'],
				"xorg"=>$tblvalues[0]['xorg'],
				"xadd1"=>$tblvalues[0]['xadd1'],
				"xadd2"=>$tblvalues[0]['xadd2'],
				"xbillingadd"=>$tblvalues[0]['xbillingadd'],
				"xdeliveryadd"=>$tblvalues[0]['xdeliveryadd'],
				"xcity"=>$tblvalues[0]['xcity'],
				"xprovince"=>$tblvalues[0]['xprovince'],
				"xpostal"=>$tblvalues[0]['xpostal'],
				"xcountry"=>$tblvalues[0]['xcountry'],
				"xcontact"=>$tblvalues[0]['xcontact'],
				"xtitle"=>$tblvalues[0]['xtitle'],
				"xphone"=>$tblvalues[0]['xphone'],
				"xcusemail"=>$tblvalues[0]['xcusemail'],
				"xmobile"=>$tblvalues[0]['xmobile'],
				"xfax"=>$tblvalues[0]['xfax'],
				"xweburl"=>$tblvalues[0]['xweburl'],
				"xnid"=>$tblvalues[0]['xnid'],
				"xtaxno"=>$tblvalues[0]['xtaxno'],
				"xtaxscope"=>$tblvalues[0]['xtaxscope'],
				"xgcus"=>$tblvalues[0]['xgcus'],
				"xpricegroup"=>$tblvalues[0]['xpricegroup'],
				"xcustype"=>$tblvalues[0]['xcustype'],
				"xsepcus"=>$tblvalues[0]['xsepcus'],
				"xindustryseg"=>$tblvalues[0]['xindustryseg'],
				"xdiscountpct"=>$tblvalues[0]['xdiscountpct'],
				"xagent"=>$tblvalues[0]['xagent'],
				"xagentcom"=>$tblvalues[0]['xagentcom'],
				"xbookcom"=>$tblvalues[0]['xbookcom'],
				"xdevfee"=>$tblvalues[0]['xdevfee'],
				"xcommisionpct"=>$tblvalues[0]['xcommisionpct'],
				"xcreditlimit"=>$tblvalues[0]['xcreditlimit'],
				"xcreditterms"=>$tblvalues[0]['xcreditterms'],
				"zactive"=>$tblvalues[0]['zactive'],
				"xoccupation"=>$tblvalues[0]['xoccupation'],
				"xdob"=>$tblvalues[0]['xdob'],
				"xreligion"=>$tblvalues[0]['xreligion'],
				"xnoname"=>$tblvalues[0]['xnoname'],
				"xnorelation"=>$tblvalues[0]['xnorelation'],
				"xnoage"=>$tblvalues[0]['xnoage'],
				"nofather"=>$tblvalues[0]['nofather'],
				"xnoadd"=>$tblvalues[0]['xnoadd'],
				"xbookpay"=>$tblvalues[0]['xbookpay'],
				"xitemcode"=>"",
				"xitemdesc"=>"",
				"xdate"=>$tblvalues[0]['xdate'],
				"xrate"=>"0.00",
				"xqty"=>"0",
				"xdownpay"=>$tblvalues[0]['xdownpay'],
				"xnotes"=>$tblvalues[0]['xnotes'],
				"xsonum"=>$tblvalues[0]['xsonum'],
				"xinsnum"=>"",
				"xinsdate"=>$tblvalues[0]['xinsdate'],
				"xquotnum"=>$tblvalues[0]['xquotnum'],
				"xtype"=>$tblvalues[0]['xtype'],
				"xmonth"=>$tblvalues[0]['xmonth'],
				"xmonthint"=>$tblvalues[0]['xmonthint'],
				"xtotalamt"=>$totamt[0]['amt'],
				"xchequeno"=>$tblvalues[0]['xchequeno'],
				"xchequedate"=>$tblvalues[0]['xchequedate'],
				"xrow"=>"0"
			);
		
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Customer", $btn,'<a style="color:red" id="invnum" href="'.URL.'customers/showinvoice/'.$cus.'">Click To Print Invoice - '.$cus.'</a>');
			$file = 'images/customers/cussm/'.$cus.'.jpg';
				$file2 = 'images/nominee/nomism/'.$cus.'.jpg';
		
		$imagename = "";	
		$imagename2 = "";	
		if(file_exists($file))
			$imagename = '../'.$file;
		else
			$imagename = '../images/customers/noimage.jpg';
			
		if(file_exists($file2))
			$imagename2 = '../'.$file2;
		else
			$imagename2 = '../images/nominee/noimage.jpg';

			$this->view->filename1 = $imagename;
			$this->view->filename2 = $imagename2;
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, $sv, $svbtn,$tblvalues ,URL."customers/showpost",$conf,"imagefield","imagefield2");
			
			$this->view->table = $this->renderTable($cus);
			
			$this->view->renderpage('customers/customerentry');
		}
		
		function createopbal(){
			
			$mstdata = array(
			"bizid"=>"100",
			"xvoucher"=>"OP--000001",
			"xnarration"=>"Customer Opening Balance",
			"xyear"=>"2018",
			"xper"=>"7",
			"xstatusjv"=>"Created",
			"xbranch" => "Head Office",
			"xdoctype" => "Opening Balance",
			"xdocnum" => "OP--000001",
			"xdate" => "2019-01-02",
			"xsite" => "",
			"zemail"=>"System"
			);
			
						
			$amt  = 0;
			$amtnot = 0;
			$data = $this->data();
			foreach ($data as $key=>$val){
				if($val>0)
					$amt += $val;
				if($val<0)
					$amtnot += $val;
				
			}
			
		//$checkval = " bizid = " . $data['bizid'] . " and xvoucher ='" . $data['xvoucher'] ."'";
			$i=1;
				$cols = "`bizid`,`xvoucher`,`xrow`,`xacc`,`xacctype`,`xaccusage`,`xaccsource`,xaccsub,`xcur`,`xbase`,
				`xexch`,`xprime`,xflag";
				$vals = "(100,'OP--000001',".$i.",'2035',
					'Liability','Ledger','None','','BDT',
					'-". $amt ."','1','-". $amt ."','Credit'),";
				$i+=1;
				$vals .= "(100,'OP--000001',".$i.",'2035',
					'Liability','Ledger','None','','BDT',
					'". abs($amtnot) ."','1','". abs($amtnot) ."','Debit'),";	
					
				foreach ($data as $key=>$val){
				$i++;
					if($val>0){
					
					$vals .= "(100,'OP--000001',".$i.",'1010',
					'Asset','AR','Customer','". $key ."','BDT',
					'". $val ."','1','". $val ."','Debit'),";
					}
					
					if($val<0){
					
					$vals .= "(100,'OP--000001',".$i.",'1010',
					'Asset','AR','Customer','". $key ."','BDT',
					'". $val ."','1','". $val ."','Credit'),";
					}
					
				}
				
				$vals = rtrim($vals,",");
				//echo $vals; die;
				echo $this->model->createopeningbal($mstdata, $cols, $vals);
		}
		
		function data(){
			return array(
				'AKS-000152'=>4700.6,




	
			);
		}
		
}