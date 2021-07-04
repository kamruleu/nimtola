<?php 
class Relcustomers extends Controller{
	
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
				if($menus["xsubmenu"]=="Releted Customer Entry")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','public/js/imageshow.js','views/relcustomers/js/codevalidator.js');
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
			"xcustype"=>"",
			"xindustryseg"=>"",
			"xdiscountpct"=>"0",
			"xagent"=>"",
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
			"xnoage"=>"",
			"nofather"=>"",
			"xnoadd"=>"",
			"xrate"=>"0.00",
			"xqty"=>"0",
			"xrcvamt"=>"0.00",
			"xtruckfair"=>"0.00",
			"xnotes"=>"",
			"xinsnum"=>"",
			"xinsdate"=>$dt,
			"xquotnum"=>"",
			"xtype"=>"One Month",	
			"xamount"=>"0",
			"xmonth"=>"",
			"xinssl"=>"0"
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
							"xoccupation-text"=>'Occupation_maxlength="160"',
							"xcountry-select_Country"=>'Nationality_maxlength="160"'
							),
						array(
							"xdob-datepicker"=>'Date Of Birth_""',
							"xreligion-select_Religion"=>'Religion_maxlength="160"'
							),		
						array(
							"xagent-select_Salesman"=>'Agent_maxlength="50"',
							"xcontact-text"=>'Contact_maxlength="50"'
							),
						array(
							"xcity-select_City"=>'City_maxlength="50"',
							"xprovince-select_Province"=>'District_maxlength="100"'
							),
						array(
							"xmobile-text"=>'Phone_maxlength="50"',
							"xphone-text"=>'Mobile_maxlength="50"'
							),
						array(
							"xcusemail-text"=>'Email_maxlength="50" email="true"',
							"xnid-text"=>'NID_maxlength="50"'
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
							"xnoage-text"=>'Age_maxlength="160"',
							"nofather-text"=>'Father/Husband_maxlength="160"'
							),
						array(
							"xnoadd-text"=>'Nominee Address_maxlength="160"'
							),
						array(
							"Sales Detail-div"=>''		
							),
						array(
							"xitemcode-group_".URL."itempicklist/picklist"=>'Plot No*~star_maxlength="20"',
							"xdate-datepicker" => 'Sales Date_""'							
							),
						array(
							"xitemdesc-text"=>'Description_readonly',
							"xrate-text_number"=>'Rate(Katha)_number="true" minlength="1" maxlength="18" required'							
							),
						array(
							"xqty-text_number"=>'Quantity(Katha)*~star_number="true" minlength="1" maxlength="18" required',
							"xrcvamt-text_number"=>'Down Payment._number="true" minlength="1" maxlength="18" required',
							),
						array(
							"xtruckfair-text_number"=>'Booking Payment._number="true" minlength="1" maxlength="18" required',
							),
						array(
							"xnotes-textarea"=>'Additional Notes_""'
							),
						array(
							"Installment Detail-div"=>''		
							),
						array(
							"xinsnum-group_".URL."installment/picklist"=>'Installment No_maxlength="20" readonly',
							"xinsdate-datepicker" => 'Date_""'
							),
						array(							
							"xquotnum-text"=>'Quotation No_maxlength="50"',
							"xamount-text"=>'Amount_number="true" minlength="1" maxlength="18"'
							),
						array(
							"xtype-radio_One Month_Multiple Month"=>'_readonly',
							"xmonth-text"=>'Month Number_maxlength="50"',
							"xinssl-hidden"=>'_""'
							),
						array(
							"xtaxno-hidden"=>'',
							"xtaxscope-hidden"=>'',
							"xgcus-hidden"=>'',
							"xpricegroup-hidden"=>'',
							"xdiscountpct-hidden"=>'',
							"xindustryseg-hidden"=>'',
							"xcommisionpct-hidden"=>'',
							"xcreditlimit-hidden"=>'',
							"xcreditterms-hidden"=>'',
							"xpostal-hidden"=>'',
							"xcustype-hidden"=>'',
							"xtitle-hidden"=>'',
							"xfax-hidden"=>'',
							"xweburl-hidden"=>''
							)
						);
		}
		
		public function index(){
		
		
		$btn = array(
			"Clear" => URL."relcustomers/customerentry",
		);	
		
		
		// form data
		//$this->createopbal();
			$dynamicForm = new Dynamicform("Customer",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."relcustomers/savecustomers", "Save",$this->values,URL."relcustomers/showpost");
			$this->view->table ="";
			//$this->view->table = $this->renderTable();
			
			$this->view->rendermainmenu('relcustomers/index');
			
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

				$yearoffset = Session::get('syearoffset');
				$xyear = 0;
				$per = 0;
				foreach ($this->model->getYearPer($yearoffset,intval($month)) as $key=>$val){
					$per = $key;
					$xyear = $val;
				}

				if (!isset($_POST['xcus'])){
					header ('location: '.URL.'relcustomers');
					exit;
				}
				$cusauto =	Session::get('sbizcusauto');	
				$prefix = $_POST['prefix'];	
				$keyfieldval = $this->model->getKeyValue("secus","xcus",$prefix,"6");
				$keyfieldso = $this->model->getKeyValue("somst","xsonum","SORD-","6");
				//print_r($keyfieldso);die;
				$form = new Form();
				$data = array();
				$inssuccess=0;
				$success=0;
				$result = "";
				try{
					
				if($cusauto=="NO"){
				$form	->post('xcus')
						->val('minlength', 1)
						->val('maxlength', 20);
				}						
				
				$form	->post('xshort')
						->val('maxlength', 160)
				
						->post('xorg')
						->val('minlength', 4)
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
						
						->post('xindustryseg')
						
						->post('xdiscountpct')
						->val('checkdouble')
						
						->post('xagent')
						->val('maxlength', 20)
						
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

						->post('xtruckfair')

						->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20)

						->post('xqty')
						
						->post('xrcvamt')
						
						->post('xrate')

						->post('xnotes')						
						->val('maxlength', 100)

						->post('xinsnum')

						->post('xtype')
						
						->post('xmonth')
						
						->post('xquotnum')
						
						->post('xamount')
						->val('checkdouble')
						->val('minlength', 1)
						
						->post('zactive');
						
				$form	->submit();
				
				$data = $form->fetch();
				if($cusauto=="YES")
					$data['xcus'] = $keyfieldval;
				$data['xsonum'] = $keyfieldso;
				$data['xdate'] = $date;
				$data['xyear'] = $xyear;
				$data['xper'] = $per;
				$data['bizid'] = Session::get('sbizid');
				$data['zemail'] = Session::get('suser');

				$itemdetail = $this->model->getItemMaster("xitemcode",$data['xitemcode']);

				$rownum = $this->model->getRow("sodet","xsonum",$data['xsonum'],"xrow");

				$ccols = "`bizid`,`xcus`,`xshort`,`xorg`,`xadd1`,`xadd2`,`xbillingadd`,`xdeliveryadd`,`xcity`,`xprovince`,`xpostal`,`xcountry`,`xcontact`,`xtitle`,`xphone`,`xcusemail`,`xmobile`,`xfax`,`xweburl`,`xnid`,`xtaxno`,`xtaxscope`,`xgcus`,`xpricegroup`,`xcustype`,`xindustryseg`,`xdiscountpct`,`xagent`,`xcommisionpct`,`xcreditlimit`,`xcreditterms`,`zactive`,`zemail`,`xoccupation`,`xdob`,`xreligion`,`xnoname`,`xnorelation`,`xnoage`,`nofather`,`xnoadd`";
				
				$cvals = "(" . Session::get('sbizid') . ",'". $data['xcus'] ."','". $data['xshort'] ."','". $data['xorg'] ."','". $data['xadd1'] ."',
				'". $data['xadd2'] ."','". $data['xbillingadd'] ."','".$data['xdeliveryadd']."','". $data['xcity'] ."','". $data['xprovince'] ."','". $data['xpostal'] ."','". $data['xcountry'] ."','".$data['xcontact']."','".$data['xtitle']."','".$data['xphone']."','".$data['xcusemail']."','". $data['xmobile'] ."','".$data['xfax']."','".$data['xweburl']."','".$data['xnid']."','". $data['xtaxno'] ."','".$data['xtaxscope']."','".$data['xgcus']."','".$data['xpricegroup']."','".$data['xcustype']."','".$data['xindustryseg']."','".$data['xdiscountpct']."','".$data['xagent']."','".$data['xcommisionpct']."','".$data['xcreditlimit']."','".$data['xcreditterms']."','".$data['zactive']."','".Session::get('suser')."','".$data['xoccupation']."','".$data['xdob']."','".$data['xreligion']."','".$data['xnoname']."','".$data['xnorelation']."','".$data['xnoage']."','".$data['nofather']."','".$data['xnoadd']."')";

				// $file = fopen("C:/Users/kamrul/Desktop/testdoc.txt","w");
				// echo fwrite($file,$cvals);
				// fclose($file);
				$mcols = "`bizid`,`xsonum`,`xwh`,`xbranch`,`xproj`,`xstatus`,`xdate`,`zemail`,`xcus`,`xcusbal`,`xtruckfair`,`xnotes`,`xrcvamt`,`xyear`,`xper`";
				
				$mvals = "(" . Session::get('sbizid') . ",'". $data['xsonum'] ."','None','".Session::get('sbranch')."','".Session::get('sbranch')."',
				'Created','". $data['xdate'] ."','".$data['zemail']."','".$data['xcus']."','0','". $data['xtruckfair'] ."','". $data['xnotes'] ."','".$data['xrcvamt']."','".$data['xyear']."','".$data['xper']."')";

				$cols = "`bizid`,`xsonum`,`xrow`,`xitemcode`,`xitembatch`,`xqty`,`xdate`,`xcost`,`xrate`,`xwh`,`xbranch`,`xproj`,`xtaxrate`,`xdisc`,`xexch`,`xcur`,`xtaxcode`,`xtaxscope`,`zemail`,`xunitsale`,`xcus`,`xyear`,`xper`,`xtypestk`";
				
				$vals = "(" . Session::get('sbizid') . ",'". $keyfieldso ."','". $rownum ."','". $data['xitemcode'] ."','". $data['xitemcode'] ."',
				'". $data['xqty'] ."','". $date ."','0','". $data['xrate'] ."','None','". Session::get('sbranch') ."','". Session::get('sbranch') ."','0','0','1','BDT','". Session::get('sbizcur') ."','None','".$data['zemail']."','".$itemdetail[0]['xunitsale']."','". $data['xcus'] ."','".$xyear."','".$per."','".$itemdetail[0]['xtypestk']."')";

				//print_r($data);die;

				if($data['xinsnum'] == "")
				$keyfieldins = $this->model->getKeyValue("installmentmst","xinsnum","INS-","6");
				else
				$keyfieldins = $data['xinsnum'];
				//print_r($keyfieldval);die;
				$inssl = $this->model->getRow("installmentmst","xinsnum",$keyfieldins,"xinssl");
				//print_r($inssl);die;
				$icols = "bizid,xcus,xquotnum,xinssl,xdate,xinsnum,xpct,xamount,zemail,xbranch,xyear,xper";
				$ivals ="";
				if($data['xtype']=='Multiple Month' && $xmonth>1){
					for($i=1; $i<=$xmonth; $i++){
						$dte = date('Y-m-d', strtotime($dt.'+'.$i.' month'));
						$mnth = date('n',strtotime($dte));
						$yar = date('Y',strtotime($dte));
						$ivals .= "(" . Session::get('sbizid') . ",'". $data['xcus'] ."','". $data['xquotnum'] ."',
						'".$inssl."', '".$dte."', '". $keyfieldins ."','0','". $data['xamount'] ."','". Session::get('suser') ."','". Session::get('sbranch') ."',
						'". $yar ."','". $mnth ."'),";

						$inssl++;
					}
				}else{
						$ivals = "(" . Session::get('sbizid') . ",'". $data['xcus'] ."','". $data['xquotnum'] ."','".$inssl."',
						'". $date ."', '". $keyfieldins ."','0','". $data['xamount'] ."','". Session::get('suser') ."','". Session::get('sbranch') ."',
						'". $insyear ."','". $insmonth ."')";
				}
						$ivals = rtrim($ivals,",");

				$inssuccess = $this->model->InsCreate($icols,$ivals);
				$success = $this->model->create($ccols,$cvals,$mcols,$mvals,$cols,$vals);
				
				if(empty($success) || empty($inssuccess))
					$success=0;
				
				
				}catch(Exception $e){
					
					$this->result = $e->getMessage();
					
				}
				
				if($success>0){
					$this->result = "Customer saved successfully";
					if ($_FILES['imagefield']["name"]){
						$imgupload = new ImageUpload();
						$imgupload->store_uploaded_image('images/nominee/nomilg/','imagefield', 400, 400,$keyfieldval);
						$imgupload->store_uploaded_image('images/nominee/nomism/','imagefield', 171, 181,$keyfieldval);
					}
					if ($_FILES['imagefield2']["name"]){
						$imgupload2 = new ImageUpload();
						$imgupload2->store_uploaded_image('images/relcustomers/cuslg/','imagefield2', 400, 400,$keyfieldval);
						$imgupload2->store_uploaded_image('images/relcustomers/cussm/','imagefield2', 171, 181,$keyfieldval);
					}
				}
				
				if($success == 0 && empty($this->result))
					$this->result = "Failed to save customer!";
				
				 $this->showentry($keyfieldval, $this->result);
				 
				 
				
		}
		
		public function editcustomer($cus){
			
			if (!isset($_POST['xcus'])){
					header ('location: '.URL.'relcustomers');
					exit;
				}
			$result = "";
			
			$success=false;
			$form = new Form();
				$data = array();
				
				try{
					
					
				
				
				$form	->post('xcus')
						->val('minlength', 1)
						->val('maxlength', 20)
										
				
						->post('xshort')
						->val('maxlength', 20)
				
						->post('xorg')
						->val('minlength', 4)
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
						
						
						->post('xindustryseg')
						
						->post('xdiscountpct')
						->val('checkdouble')
						
						->post('xagent')
						->val('maxlength', 20)
						
						->post('xcommisionpct')
						->val('checkdouble')
						
						->post('xcreditlimit')
						->val('checkdouble')
						
						->post('xcreditterms')
						->val('digit')
						
						->post('zactive');
						
				$form	->submit();
				
				$data = $form->fetch();	
				//print_r($data);die;
				
				$data['bizid'] = Session::get('sbizid');
				$data['xemail'] = Session::get('suser');
				$data['zutime'] = date("Y-m-d H:i:s");
				$success = $this->model->editCustomer($data, $cus);
				
				
				}catch(Exception $e){
					//echo $e->getMessage();die;
					$result = $e->getMessage();
					
				}
				if($result==""){
				if($success){
					$result = "Edited successfully";
					$file = 'images/relcustomers/cussm/'.$cus.'.jpg';
					if ($_FILES['imagefield']["name"]){
						if(file_exists($file))
							unlink($file); 
						
						$imgupload = new ImageUpload();
						$imgupload->store_uploaded_image('images/relcustomers/cuslg/','imagefield', 400, 400, $cus);
						$imgupload->store_uploaded_image('images/relcustomers/cussm/','imagefield', 171, 181, $cus);
						
					}
				}
				else
					$result = "Edit failed!";
				
				}
				 $this->showcustomer($cus, $result);
				
		
		}
		
		public function showcustomer($cus="", $result=""){
		if($cus==""){
			header ('location: '.URL.'relcustomers');
			exit;
		}
		$tblvalues=array();
		$btn = array(
			"New" => URL."relcustomers/customerentry"
		);
		
		$tblvalues = $this->model->getSingleCustomer($cus);
		
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
				"xindustryseg"=>$tblvalues[0]['xindustryseg'],
				"xdiscountpct"=>$tblvalues[0]['xdiscountpct'],
				"xagent"=>$tblvalues[0]['xagent'],
				"xcommisionpct"=>$tblvalues[0]['xcommisionpct'],
				"xcreditlimit"=>$tblvalues[0]['xcreditlimit'],
				"xcreditterms"=>$tblvalues[0]['xcreditterms'],
				"zactive"=>$tblvalues[0]['zactive'],
				"xitemcode"=>"",
				"xdate"=>"",
				"xitemdesc"=>"",
				"xrate"=>"0.00",
				"xqty"=>"0",
				"xrcvamt"=>"0.00",
				"xnotes"=>"",
				"xinsnum"=>"",
				"xinsdate"=>"",
				"xquotnum"=>"",
				"xtype"=>"One Month",	
				"xamount"=>"0",
				"xmonth"=>"",
				"xinssl"=>"0"
			);
			
		
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Customer", $btn, $result);
			
			$file = 'images/relcustomers/cussm/'.$cus.'.jpg';
		
		$imagename = "";	
		if(file_exists($file))
			$imagename = '../../'.$file;
		else
			$imagename = '../../images/products/noimage.jpg';
			
			$this->view->filename = $imagename;
		
		$this->view->filename = $imagename;
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."relcustomers/editcustomer/".$cus, "Edit",$tblvalues, URL."relcustomers/showpost","","imagefield1","imagefield2");
			
			$this->view->table = $this->renderTable($cus);
			
			$this->view->renderpage('relcustomers/customerentry');
		}
		
		
		
		public function showentry($cus, $result=""){
		
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."relcustomers/customerentry"
		);
		
		$tblvalues = $this->model->getSingleCustomer($cus);
		
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
				"xindustryseg"=>$tblvalues[0]['xindustryseg'],
				"xdiscountpct"=>$tblvalues[0]['xdiscountpct'],
				"xagent"=>$tblvalues[0]['xagent'],
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
				"xtruckfair"=>"0.00",
				"xitemcode"=>"",
				"xitemdesc"=>"",
				"xdate"=>"",
				"xrate"=>"0.00",
				"xqty"=>"0",
				"xrcvamt"=>"0.00",
				"xnotes"=>"",
				"xinsnum"=>"",
				"xinsdate"=>"",
				"xquotnum"=>"",
				"xtype"=>"One Month",	
				"xamount"=>"0",
				"xmonth"=>"",
				"xinssl"=>"0"
			);
		
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Customer", $btn, $result);	
				$file = 'images/relcustomers/cussm/'.$cus.'.jpg';
				$file2 = 'images/nominee/nomism/'.$cus.'.jpg';
		
		$imagename = "";	
		$imagename2 = "";	
		if(file_exists($file))
			$imagename = '../'.$file;
		else
			$imagename = '../images/relcustomers/noimage.jpg';
			
		if(file_exists($file2))
			$imagename2 = '../'.$file2;
		else
			$imagename2 = '../images/nominee/noimage.jpg';

			$this->view->filename1 = $imagename;
			$this->view->filename2 = $imagename2;
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."relcustomers/savecustomers", "Save",$tblvalues ,URL."relcustomers/showpost","","imagefield","imagefield2");
			
			$this->view->table = $this->renderTable($cus);
			
			$this->view->renderpage('relcustomers/customerentry');
		}
		
		function renderTable($txnnum){
			
			$sales = $this->model->getSales($txnnum);
			$status = "";
			if(!empty($sales))
				$status = $sales[0]["xstatus"];
			
			$delbtn = "";
			if(count($sales)>0){
			if($sales[0]["xstatus"]=="Created")
				$delbtn = URL."sales/deletesales/".$txnnum."/";
				
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
							$showurl = URL."sales/showsales/".$txnnum."/".$val['xrow'];
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
								$total+=$val['xsubtotal']+$val['xtaxtotal']-$val['xdisctotal'];
								$totalqty+=	$val['xqty'];
								
							$table .="</tr>";
						}
							$table .='<tr><td align="right" colspan="6"><strong>Total</strong></td><td align="right"><strong>'.number_format($totalqty,2).'</strong></td><td align="right"><strong>'.number_format($total,2).'</strong></td></tr>';
							$net=0;
							if(!empty($row)){
								
								$net = $total-$row[0]["xgrossdisc"];
							}
							$table .='<tr><td align="right" colspan="7"><strong>Net Total</strong></td><td align="right"><strong>'.number_format($net,2).'</strong></td></tr>';
							if(!empty($row)){
							$table .='<tr><td align="right" colspan="7"><strong>Received Amt.</strong></td><td align="right"><strong>'.$row[0]["xrcvamt"].'</strong></td></tr>';
							}	
					$table .="</tbody>";			
			$table .= "</table>";
			
			return $table;
			
			
		}
		
		function customerlist(){
			$btn = '<div>
				<a href="'.URL.'relcustomers/allcustomers" class="btn btn-primary">Print Customer List</a>
				</div>
				<div>
				<hr/>
				</div>';
			$this->view->table = $btn.$this->itemTable();
			
			$this->view->renderpage('relcustomers/customerlist', false);
		}
		
		function picklist(){
			$this->view->table = $this->customerPickTable();
			
			$this->view->renderpage('relcustomers/customerpicklist', false);
		}
		
		function customerPickTable(){
			$fields = array(
						"xcus-Customer No",
						"xorg-Organization/Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xcustype-Customer Type"
						);
			$table = new Datatable();
			$row = $this->model->getCustomersByLimit();
			
			return $table->picklistTable($fields, $row, "xcus");
		}
		
		function itemTable(){
			$fields = array(
						"xcus-Customer No",
						"xorg-Organization/Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xcustype-Customer Type"
						);
			$table = new Datatable();
			$row = $this->model->getCustomersByLimit();
			
			return $table->createTable($fields, $row, "xcus", URL."relcustomers/showcustomer/", URL."relcustomers/deletecustomer/");
		}
		
		function allcustomers(){
			$fields = array(
						"xcus-Customer No",
						"xorg-Organization/Name",
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
			$this->view->renderpage('relcustomers/customerlist', false);
		}
		
		function customerentry(){
				
		$btn = array(
			"Clear" => URL."relcustomers/customerentry"
		);

		// form data
		
			$dynamicForm = new Dynamicform("Customer",$btn);		
			$imagename1 = '../images/products/noimage.jpg';
			$imagename2 = '../images/nominee/noimage.jpg';
			
			$this->view->filename1 = $imagename1;
			$this->view->filename2= $imagename2;
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."relcustomers/savecustomers	", "Save",$this->values, URL."relcustomers/showpost","","imagefield","imagefield2");
			$this->view->table ="";
			//$this->view->table = $this->renderTable();
			
			$this->view->renderpage('relcustomers/customerentry', false);
		}
		
		public function deletecustomer($cus){
			$where = "bizid=".Session::get('sbizid')." and xcus='".$cus."'";
			$this->model->delete($where);
			$this->view->message = "";
			$this->customerlist();
		}
		
		public function showpost(){
			$cus = $_POST['xcus'];
			
		$tblvalues=array();
		$btn = array(
			"New" => URL."relcustomers/customerentry"
		);
		
		$tblvalues = $this->model->getSingleCustomer($cus);
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=$tblvalues[0];
			
		
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Customer", $btn);
			$file = 'images/relcustomers/cussm/'.$cus.'.jpg';
		
		$imagename = "";	
		if(file_exists($file))
			$imagename = '../../'.$file;
		else
			$imagename = '../../images/products/noimage.jpg';
			
			$this->view->filename = $imagename;
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."relcustomers/savecustomers", "Save",$tblvalues,URL."relcustomers/showpost","","imagefield");
			
			$this->view->table = $this->renderTable($cus);
			
			$this->view->renderpage('relcustomers/customerentry');
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