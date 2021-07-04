<?php 
class Oglrpt extends Controller{
	
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
				if($menus["xsubmenu"]=="Reports")
					$iscode=1;				
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/distreg/js/codevalidator.js','views/oglrpt/js/getaccdt.js');
								
		}
		
		public function index(){
					
			
			$this->view->rendermainmenu('oglrpt/index');
			
		}
		
		
		
		function glrptmenu(){
			
			$menuarr = array(
			// 0 => array("Account Ledger"=>URL."oglrpt/ledger","Subsidiary Ledger"=>URL."oglrpt/subledger","Customer Ledger"=>URL."oglrpt/customerledger","Supplier Ledger"=>URL."oglrpt/supplierledger"),
			// 1 => array("Account Receivable"=>URL."oglrpt/incexpledger/Acounts Receivable","Accounts Payable"=>URL."oglrpt/incexpledger/Accounts Payable","Expenditure"=>URL."oglrpt/incexpledger/Expenditure","Income"=>URL."oglrpt/incexpledger/Income"),
			// 2 => array("Trial Balance"=>URL."glrptstatement/trialbal","Income Statement"=>URL."glrptstatement/plstatementbydate","Balance Sheet"=>URL."glrptstatement/balancesheet","Day Book"=>URL."oglrpt/daybook"),			
			// 3 => array("Customer Balance"=>URL."glrptstatement/shocusbal","Supplier Balance"=>URL."glrptstatement/shosupbal","Receipt Payment"=>URL."glrptstatement/rcptnpayment","Cash Book"=>URL."oglrpt/cashbook"),
			0 => array("Customer Ledger"=>URL."oglrpt/customerledger","Customer Type Balance"=>URL."oglrpt/custypebal"),
			);
			$menutable='<table class="table" style="width:100%"><tbody>';
			foreach($menuarr as $key=>$value){
				$menutable.='<tr>';
					foreach($value as $k=>$val){
						$menutable.='<td><a style="width:100%" class="btn btn-info" href="'.$val.'" role="button"><span class="glyphicon glyphicon-open-file"></span>&nbsp;'.$k.'</a></td>';
					}
				$menutable.='</tr>';
				
			}
			$menutable.='</tbody></table>';
			$this->view->table = $menutable;
			$this->view->renderpage('oglrpt/glrptmenu', false);
		}
		function daybook(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li class="active">Day Book</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."oglrpt/dayBook",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xacc"=>"",
				"xaccdesc"=>"",	
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xacc-group_".URL."glchart/glchartpicklist"=>'Account_maxlength="20"',
								"xaccdesc-text"=>'Acc Desc_readonly'
								),
								array(
								
								),
								array(
								
								)
							);
			
				$dynamicForm = new Dynamicform("Day Book Report Filter",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnForm($fields, URL."oglrpt/showDayBook", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('oglrpt/glrptfilter', false);
		
		}
		public function showDayBook(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li><a href="'.URL.'oglrpt/daybook">Day Book</a></li>
							<li class="active">Day Book Report</li>
						   </ul>';
		
			$acc = $_POST['xacc'];
			
			$accdesc = $_POST['xaccdesc'];
			
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();
			$btn = array(
				"Clear" => URL."oglrpt/daybook",
			);	
			
				$tblvalues = $this->model->dayBook($fdate, $tdate, $acc);
				
				$fields = array(
						"xdate-Date",
						"xvoucher-Voucher",
						"xacc-Account",
						"xaccsub-SubAccount",
						"xnarration-Narration",
						"xprimedr-Dr. Amount",
						"xprimecr-Cr. Amount"
						);
			$table = new Accrpttable();
			
			$opbal = 0;
			$opbal = $this->model->getopbal($acc, $fdate)[0]['xprime'];
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Day Book Report";
			$this->view->org=Session::get('sbizlong');
			
			$this->view->table = $table->generalTable($fields, $tblvalues, "xvoucher", $opbal, $acc, $accdesc);
				
			$this->view->renderpage('oglrpt/reportpage');
		}

		function cashbook(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li class="active">Cash Book</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."oglrpt/cashbook",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,				
				"xsite"=>""	
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xsite-select_Project"=>'Project_""'																
								),
								array(								
								
								)
								,
								array(								
								
								)
								,
								array(								
								
								)
							);
				
				$dynamicForm = new Dynamicform("Cash Book Report Filter",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnForm($fields, URL."oglrpt/showcashbook", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('oglrpt/glrptfilter', false);
		
		}

		public function showcashbook(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li><a href="'.URL.'oglrpt/cashbook">Cash Book</a></li>
							<li class="active">Cash Book</li>
						   </ul>';
		
			$acc = "";
			$project = "";
			
			$xfdate = $_POST['xfdate'];
			
			if(isset($_POST['xsite']))
				$project = $_POST['xsite'];
			
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();
			$btn = array(
				"Clear" => URL."oglrpt/cashbook",
			);
			
			
				$tblvalues = $this->model->getcashbankbook($fdate, $tdate,"Cash", $project);
				//print_r($tblvalues); die;
				$fields = array(
						"xdate-Date",
						"xbranch-Branch",
						"xvoucher-Voucher",
						"xnarration-Narration",
						"xprimedr-Dr. Amount",
						"xprimecr-Cr. Amount"
						);
			$table = new Accrpttable();
			$acc=""; 
			$opbal = 0;
			$opbal = $this->model->getopbalcashbank("Cash", $fdate, $project);
			$acc=""; $accdesc="";$acctype="";
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Cash Book";
			if($project!="")
				$this->view->vrptname = "Account Ledger Report<br />Project :".$project;
			$this->view->org=Session::get('sbizlong');
			
			$this->view->table = $table->cashbankbook( $tblvalues, $opbal, "xacc");

							
			$this->view->renderpage('oglrpt/reportpage');
		}
		function bankbook(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li class="active">Bank Book</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."oglrpt/bankbook",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,				
				"xsite"=>""	
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xsite-select_Project"=>'Project_""'																
								),
								array(								
								
								)
								,
								array(								
								
								)
								,
								array(								
								
								)
							);
				
				$dynamicForm = new Dynamicform("Bank Book Report Filter",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnForm($fields, URL."oglrpt/showbankbook", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('oglrpt/glrptfilter', false);
		
		}

		public function showbankbook(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li><a href="'.URL.'oglrpt/bankbook">Bank Book</a></li>
							<li class="active">Bank Book</li>
						   </ul>';
		
			$acc = "";
			$project = "";
			
			$xfdate = $_POST['xfdate'];
			
			if(isset($_POST['xsite']))
				$project = $_POST['xsite'];
			
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();
			$btn = array(
				"Clear" => URL."oglrpt/bankbook",
			);
			
			
			$tblvalues = $this->model->getcashbankbook($fdate, $tdate,"Bank", $project);
			//print_r($tblvalues); die;
			$fields = array(
					"xdate-Date",
					"xbranch-Branch",
					"xvoucher-Voucher",
					"xnarration-Narration",
					"xprimedr-Dr. Amount",
					"xprimecr-Cr. Amount"
					);
			$table = new Accrpttable();
			$acc=""; 
			$opbal = 0;
			$opbal = $this->model->getopbalcashbank("Bank", $fdate, $project);
			$acc=""; $accdesc="";$acctype="";
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Bank Book";
			if($project!="")
				$this->view->vrptname = "Account Ledger Report<br />Project :".$project;
			$this->view->org=Session::get('sbizlong');
			
			$this->view->table = $table->cashbankbookday( $tblvalues, $opbal, "xacc");
				
			$this->view->renderpage('oglrpt/reportpage');
		}

		function ledger(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li class="active">Account Ledger</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."oglrpt/ledger",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xacc"=>"",
				"xaccdesc"=>"",
				"xsite"=>""	
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xacc-group_".URL."glchart/glchartpicklist"=>'Account_maxlength="20"',
								"xaccdesc-text"=>'Acc Desc_readonly',								
								),
								array(								
								"xsite-select_Project"=>'Project_""'
								)
							);
				
				$dynamicForm = new Dynamicform("Account Ledger Report Filter",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnForm($fields, URL."oglrpt/showledger", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('oglrpt/glrptfilter', false);
		
		}

		function custypebal(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li class="active">Customer type Balance</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."oglrpt/custypebal",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xcustype"=>""	
				);
				
				$fields = array(
								array(								
								"xcustype-select_Customer Type"=>'Customer Type_""'
								)
							);
				
				$dynamicForm = new Dynamicform("Customer Balance Report Filter",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnForm($fields, URL."oglrpt/shocustypebal", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('oglrpt/glrptfilter', false);
		
		}

		function shocustypebal(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li><a href="'.URL.'oglrpt/custypebal">Report Filter</a></li>
							<li class="active">Customer Type Balance</li>
						   </ul>';
			$tblsettings = array(
				"columns"=>array("0"=>"Customer Code","1"=>"Name",2=>"Address",3=>"Mobile",4=>"Balance"),
				"groupfield"=>"Customer Type~xcustype",
				"grouprecords"=>array(), //database records columns to show in group
				"detailsection"=>array("xaccsub","xorg","xadd1","xmobile","xbal"),
				//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
				//"urlvals"=>array("id","phone"),
				"sumfields"=>array(),
				);

			$xcustype = "";
			if(isset($_POST['xcustype']))
				$xcustype = $_POST['xcustype'];

			$row = $this->model->customertypebal($xcustype);
			$totalpoint = "";			
			$this->view->vfdate = "A";
			$this->view->vtdate = "Z";
			$this->view->vrptname = "Customer Type Balance Report";
			$this->view->org=Session::get('sbizlong');
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $row);
				
			$this->view->renderpage('oglrpt/reportpage');
		
		}

		// public function showcustypebal(){
		
		// 	$this->view->breadcrumb = '<ul class="breadcrumb">
		// 					<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
		// 					<li><a href="'.URL.'oglrpt/shocustypebal">Customer Type Balance Form</a></li>
		// 					<li class="active">Customer Type Balance</li>
		// 				   </ul>';
		
						
		// 	$xfdate = $_POST['xfdate'];
		// 	$fdt = str_replace('/', '-', $xfdate);
		// 	$fdate = date('Y-m-d', strtotime($fdt));
			
		// 	$xtdate = $_POST['xtdate'];
		// 	$tdt = str_replace('/', '-', $xtdate);
		// 	$tdate = date('Y-m-d', strtotime($tdt));
				
		// 	$tblvalues=array();			
			
		// 		$tblvalues = $this->model->dateWiseso($fdate, $tdate);
		// 		//print_r($tblvalues);die;
			
		// 	$this->view->vfdate = $fdt;
		// 	$this->view->vtdate = $tdt;
		// 	$this->view->vrptname = "Type Wise Customer Balance";
		// 	$this->view->org=Session::get('sbizlong');



		// 	$tblsettings = array(
		// 		"columns"=>array("0"=>"Invoice","1"=>"Item Code",2=>"Item Description",3=>"Rate",4=>"Qty",5=>"Unit",6=>"Total"),
		// 		"groupfield"=>"Date~xdate",
		// 		"grouprecords"=>array(), //database records columns to show in group
		// 		"detailsection"=>array("xsonum","xitemcode","xitemdesc","xrate","xqty","xunitsale","xsubtotal"),
		// 		//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
		// 		//"urlvals"=>array("id","phone"),
		// 		"sumfields"=>array("xqty","xsubtotal"),
		// 		);
		// 	$table = new ReportingTable();
		// 	$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
		// 	$this->view->renderpage('oglrpt/glrptfilter');
		// }
		
		function glpayvoucher($voucher){
			
			//$amtinwords = new AmountInWords();
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'glpayvou/glpayvouentry">Payment Voucher</a></li>
							<li class="active">Payment Voucher</li>
						   </ul>';
		
			$vou = $voucher;
			
			$values = $this->model->getvoucher($vou);
			//print_r($values);die;
			$paymethod="";
			$xdate="";
			$xcheque="";
			
			$payto="";
			$xprime="";
			$xnarration="";
			
			foreach($values as $key=>$val){
				if($val['xflag']=="Credit"){
					$paymethod=$val['xaccusage'];
					$xdate=$val['xdate'];
					//$xcheque=$val['xcheque'];
				}
				if($val['xflag']=="Debit"){
					$payto=$val['xaccsubdesc'];
					$xprime=$val['xprime'];
					$xnarration=$val['xnarration'];
				}
			}
			
			$this->view->voucher=$vou;
			$this->view->paymethod=$paymethod;
			$this->view->xdate=$xdate;
			$this->view->xcheque=$xcheque;
			
			$this->view->payto=$payto;
			$this->view->xprime=$xprime;
			$this->view->xnarration=$xnarration;
			//$inword=new toWords($xprime);
			$cur = new Currency();
			$this->view->inword="In Words: ". $cur->get_bd_amount_in_text($xprime);
			
			
			$this->view->vrptname = "Payment Voucher";
			$this->view->org=Session::get('sbizlong');
			
			$this->view->renderpage('oglrpt/payvoucherpage');		
		}
		function glrcptvoucher($voucher){
			
			
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'glrcptvou/glrcptvouentry">Receipt Voucher</a></li>
							<li class="active">Receipt Voucher</li>
						   </ul>';
		
			$vou = $voucher;
			
			$values = $this->model->getvoucher($vou);
			//print_r($values);die;
			$paymethod="";
			$xdate="";
			$xcheque="";
			
			$payto="";
			$xprime="";
			$xnarration="";
			
			foreach($values as $key=>$val){
				if($val['xflag']=="Debit"){
					$paymethod=$val['xaccusage'];
					$xdate=$val['xdate'];
					//$xcheque=$val['xcheque'];
				}
				if($val['xflag']=="Credit"){
					$payto=$val['xaccsubdesc'];
					$xprime=$val['xprime'];
					$xnarration=$val['xnarration'];
				}
			}
			
			$this->view->voucher=$vou;
			$this->view->paymethod=$paymethod;
			$this->view->xdate=$xdate;
			$this->view->xcheque=$xcheque;
			
			$this->view->payto=$payto;
			$this->view->xprime=$xprime;
			$this->view->xnarration=$xnarration;
			//$amtinwords = new AmountInWords();
			//$inword=new toWords($xprime);
			$cur = new Currency();
			$this->view->inword="In Words: ". $cur->get_bd_amount_in_text(abs($xprime));
			
			
			$this->view->vrptname = "Receipt Voucher";
			$this->view->org=Session::get('sbizlong');
			
			$this->view->renderpage('oglrpt/rcptvoucherpage');		
		}
		
		function glvoucher($type,$voucher){
			
			
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'gljvvou/gljvvouentry">'.$type.' Voucher</a></li>
							<li class="active">'.$type.' Voucher</li>
						   </ul>';
		
			$vou = $voucher;
			
			$values = $this->model->getjournal($voucher);
			//print_r($values);die;
			
			
			$this->view->voucher=$vou;
			$totdr = 0;
			$totcr = 0;
			$xdate="";
			$narration="";
			$project = "";
			foreach($values as $key=>$val){
				$xdate=$val['xdate'];
				$narration=$val['xnarration'];
				$totdr+=$val['xprimedr'];
				$totcr+=$val['xprimecr'];
				$project = $val['xsite'];
			}
			$this->view->vproject=$project;
			if($project!="")
				$this->view->vproject="Project :".$project;
			
			$this->view->xdate=$xdate;
			$this->view->narration=$narration;			
			$this->view->totprimedr=$totdr;
			$this->view->totprimecr=$totcr;
			//$inword=new toWords($totdr);
			$cur = new Currency();
			$this->view->inword="In Words: ". $cur->get_bd_amount_in_text($totdr);
			$this->view->vrow = $values;
			
			$this->view->vrptname = $type." Voucher";
			$this->view->org=Session::get('sbizlong');
			
			$this->view->renderpage('oglrpt/voucherpage');		
		}
		
		function subledger(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li class="active">Sub Account Ledger</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."oglrpt/subledger",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xacc"=>"",
				"xaccdesc"=>"",
				"xaccsub"=>"",
				"xaccsubdesc"=>"",
				"xsite"=>""	
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xacc-group_".URL."glchart/glchartpicklist"=>'Account_maxlength="20"',
								"xaccdesc-text"=>'Acc Desc_readonly'
								),
							array(
								"xaccsub-group_".URL."glchart/glchartpicklist"=>'Sub Account_maxlength="20"',
								"xaccsubdesc-text"=>'Sub Description_readonly',
								"xsite-select_Project"=>'Project_""'
								)
							);
			
				$dynamicForm = new Dynamicform("Subsidiary Account Ledger Report Filter",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnForm($fields, URL."oglrpt/showsubledger", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('oglrpt/glrptfilter', false);
		
		}
		
		function customerledger(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li class="active">Customer Ledger</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."oglrpt/customerledger",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xcus"=>"",
				"xorg"=>""
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xcus-group_".URL."jsondata/customerpicklist"=>'Customer Code_maxlength="20"',
								"xorg-text"=>'Cusotomer_maxlength="100"'
								)
							);
			
				$dynamicForm = new Dynamicform("Customer Ledger Report Filter",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."oglrpt/showcusledger", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('oglrpt/glrptfilter', false);
		
		}
		
		function supplierledger(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li class="active">Supplier Ledger</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."oglrpt/supplierledger",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xsup"=>"",
				"xorg"=>""
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xsup-group_".URL."suppliers/picklist"=>'Supplier Code_maxlength="20"',
								"xorg-text"=>'Supplier_maxlength="100"'
								)
							);
			
				$dynamicForm = new Dynamicform("Supplier Ledger Report Filter",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."oglrpt/showsupledger", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('oglrpt/glrptfilter', false);
		
		}
		
		function incexpledger($type){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li class="active">'.$type.' Ledger</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."oglrpt/incexpledger/".$type,
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xsite"=>"",
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xsite-select_Project" => 'Project_""',
								)
							);
				
				$dynamicForm = new Dynamicform($type." Report Filter",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."oglrpt/getexpinc/".$type, "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('oglrpt/glrptfilter', false);
		
		}
		
		public function showledger(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li><a href="'.URL.'oglrpt/ledger">Account Ledger</a></li>
							<li class="active">Ledger Report</li>
						   </ul>';
		
			$acc = "";
			$project = "";
			if(isset($_POST['xacc']))
				$acc = $_POST['xacc'];
			
			$accdesc = $_POST['xaccdesc'];
			
			$xfdate = $_POST['xfdate'];
			
			if(isset($_POST['xsite']))
				$project = $_POST['xsite'];
			
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();
			$btn = array(
				"Clear" => URL."oglrpt/ledger",
			);
			$acctype = "";	
			if(!empty($this->model->getAccType($acc)))
				$acctype=$this->model->getAccType($acc)[0]['xacctype'];
			
			
				$tblvalues = $this->model->getledger($fdate, $tdate, $acc, $project);
				
				$fields = array(
						"xdate-Date",
						"xbranch-Branch",
						"xvoucher-Voucher",
						"xnarration-Narration",
						"xprimedr-Dr. Amount",
						"xprimecr-Cr. Amount"
						);
			$table = new Accrpttable();
			
			$opbal = 0;
			$opbal = $this->model->getopbal($acc, $fdate, $project)[0]['xprime'];
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Account Ledger Report";
			if($project!="")
				$this->view->vrptname = "Account Ledger Report<br />Project :".$project;
			$this->view->org=Session::get('sbizlong');
			
			$this->view->table = $table->ledgerTable($fields, $tblvalues, "xvoucher", $opbal, $acc, $accdesc,$acctype);
				
			$this->view->renderpage('oglrpt/reportpage');
		}
		public function showsubledger(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li><a href="'.URL.'oglrpt/subledger">Sub Account Ledger</a></li>
							<li class="active">Subsidiary Ledger Report</li>
						   </ul>';
		
			$acc = "";
			
			$accdesc = "";
			
			$accsub = "";
			
			$accsubdesc = "";
			
			$project = "";
			
			if(isset($_POST['xacc']))
				$acc = $_POST['xacc'];
			if(isset($_POST['xaccdesc']))
				$accdesc = $_POST['xaccdesc'];
			if(isset($_POST['xaccsub']))
				$accsub = $_POST['xaccsub'];
			if(isset($_POST['xaccsubdesc']))
				$accsubdesc = $_POST['xaccsubdesc'];
			
			if(isset($_POST['xsite']))
				$project = $_POST['xsite'];
			
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();
			$btn = array(
				"Clear" => URL."oglrpt/subledger",
			);	
			
			$acctype = "";	
			if(!empty($this->model->getAccType($acc)))
				$acctype=$this->model->getAccType($acc)[0]['xacctype'];
			
				$tblvalues = $this->model->getsubledger($fdate, $tdate, $acc, $accsub, $project);
				
				$fields = array(
						"xdate-Date",
						"xbranch-Branch",
						"xvoucher-Voucher",
						"xnarration-Narration",
						"xprimedr-Dr. Amount",
						"xprimecr-Cr. Amount"
						);
			$table = new Accrpttable();
			
			$opbal = 0;
			$opbal = $this->model->getsubopbal($acc,$accsub, $fdate, $project)[0]['xprime'];
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			
			$this->view->vrptname = "Subsiadiary Account Ledger Report";
			if($project!="")
				$this->view->vrptname = "Subsiadiary Account Ledger Report<br/>Project :".$project;
			$this->view->org=Session::get('sbizlong');
			
			$this->view->table = $table->ledgerTable($fields, $tblvalues, "xvoucher", $opbal, $accsub, $accsubdesc,$acctype);
				
			$this->view->renderpage('oglrpt/reportpage');
		}
		
		public function showcusledger(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li><a href="'.URL.'oglrpt/customerledger">Customer Ledger</a></li>
							<li class="active">Customer Ledger Report</li>
						   </ul>';
		
			$cus = $_POST['xcus'];
			
			$org = $_POST['xorg'];
			
			
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();
			$btn = array(
				"Clear" => URL."oglrpt/customerledger",
			);	
			
				$tblvalues = $this->model->getcussupledger($fdate, $tdate, $cus, "Customer");
				
				$fields = array(
						"xdate-Date",
						"xbranch-Branch",
						"xvoucher-Voucher",
						"xnarration-Narration",
						"xprimedr-Dr. Amount",
						"xprimecr-Cr. Amount"
						);
			$table = new Accrpttable();
			
			$opbal = 0;
			$opbal = $this->model->getcusopbal($cus,$fdate)[0]['xprime'];
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Customer Ledger Report";
			$this->view->org=Session::get('sbizlong');
			
			$this->view->table = $table->ledgerTable($fields, $tblvalues, "xvoucher", $opbal, $cus, $org,"Customer");
				
			$this->view->renderpage('oglrpt/reportpage');
		}
		
		public function showsupledger(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li><a href="'.URL.'oglrpt/supplierledger">Supplier Ledger</a></li>
							<li class="active">Supplier Ledger Report</li>
						   </ul>';
		
			$sup = $_POST['xsup'];
			
			$org = $_POST['xorg'];
			
			
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();
			$btn = array(
				"Clear" => URL."oglrpt/supplierledger",
			);	
			
				$tblvalues = $this->model->getcussupledger($fdate, $tdate, $sup, "Supplier");
				
				$fields = array(
						"xdate-Date",
						"xbranch-Branch",
						"xvoucher-Voucher",
						"xnarration-Narration",
						"xprimedr-Dr. Amount",
						"xprimecr-Cr. Amount"
						);
			$table = new Accrpttable();
			
			$opbal = 0;
			$opbal = $this->model->getsupopbal($sup,$fdate)[0]['xprime'];
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Supplier Ledger Report";
			$this->view->org=Session::get('sbizlong');
			
			$this->view->table = $table->ledgerTable($fields, $tblvalues, "xvoucher", $opbal, $sup, $org,"Supplier");
				
			$this->view->renderpage('oglrpt/reportpage');
		}


		function getexpinc($type){
			
			$claus = "";
			if($type=="Accounts Payable")
				$claus="xaccusage='AP'";
			if($type=="Acounts Receivable")
				$claus="xaccusage='AR'";
			if($type=="Expenditure")
				$claus="xacctype='Expenditure'";	
			if($type=="Income")
				$claus="xacctype='Income'";	
			
			$project = ""; 

			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'oglrpt/glrptmenu">GL Reports</a></li>
							<li><a href="'.URL.'oglrpt/incexpledger/'.$type.'">'.$type.' Ledger</a></li>
							<li class="active">'.$type.' Report</li>
						   </ul>';
			
			if(isset($_POST['xsite']))
				$project = $_POST['xsite'];
			
			if($project!="")
				$project = " and xsite='".$_POST['xsite']."'";
			
			
			$acc = "";
			$project = "";
			
			$xfdate = $_POST['xfdate'];
			
			if(isset($_POST['xsite']))
				$project = $_POST['xsite'];
			
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();
			$btn = array(
				"Clear" => URL."oglrpt/incexpledger/".$type,
			);
			
			
				$tblvalues = $this->model->getArApExpInc($fdate, $tdate,$claus, $project);
				//print_r($tblvalues); die;
				$fields = array(
						"xdate-Date",
						"xbranch-Branch",
						"xvoucher-Voucher",
						"xnarration-Narration",
						"xprimedr-Dr. Amount",
						"xprimecr-Cr. Amount"
						);
			$table = new Accrpttable();
			$acc=""; 
			$opbal = 0;
			$opbal = $this->model->getOpArApExpInc($claus, $fdate, $project);
			$acc=""; $accdesc="";$acctype="";
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = $type;
			if($project!="")
				$this->view->vrptname = "Account Ledger Report<br />Project :".$project;
			$this->view->org=Session::get('sbizlong');
			
			$this->view->table = $table->apacincexp( $tblvalues, $opbal, "xacc", $type);
				
			$this->view->renderpage('oglrpt/reportpage');
		}
		
		
		
		
		
		
		function myTabledt($fields, $row){
		
		$field = array();
		$head = array();
		foreach($fields as $str){
			$st=explode('-',$str);
			
			$head[] = $st[1];
		}
		
		$table = '<div class="table-responsive"><table class="table table-bordered table-striped" style="width:100%">';
		$table.='<thead>';
		$table.='<tr>';
		foreach($head as $hd){
			$table.='<th>'.$hd.'</th>';
		}
				
		$com = 0;
		$tax = 0;
		$tot = 0;
		
		
		$table.='</tr>';
		$table.='</thead>';
		$table.='<tbody>'; 
		foreach($row as $key=>$value){
			$table.='<tr>';
			foreach($value as $k=>$str){
				if($k == "xcom")
					$com+=$str;
				if($k == "xtax")
					$tax+=$str;
				if($k == "xtotal")
					$tot+=$str;
				
				$table.='<td>'.htmlentities($str).'</td>';
			}
			
			
			$table.='</tr>';
		}
		$table.='</tbody>';
		$table.='<tfoot>';
		$table.='<tr>';
		$table.='<td><strong>Total</strong></td><td></td><td></td><td><strong></strong></td><td><strong>'.$com.'</strong></td><td><strong>'.$tax.'</strong><td><strong>'.$tot.'</strong></td>';
		$table.='</tr>';
		$table.='</tfoot>';
		$table.='</table></div>';
		return $table;
	}	
	}