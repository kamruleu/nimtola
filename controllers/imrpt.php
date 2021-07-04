<?php
class Imrpt extends Controller{
	
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
				if($menus["xsubmenu"]=="Inventory Reports")
					$iscode=1;				
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/imrpt/js/getitemdt.js');
								
		}
		
		public function index(){
					
			
			$this->view->rendermainmenu('imrpt/index');
			
		}
		
		
		
		function imrptmenu(){
			
			$menuarr = array(
			0 => array("Inventory Receive"=>URL."imrpt/invrcv","Inventory Issue"=>URL."imrpt/invissue","Datewise Receive"=>URL."imrpt/dwinvrcv","Datewise Issue"=>URL."imrpt/dwinvissue"),
			1 => array("Itemwise Receive"=>URL."imrpt/iwinvrcv","Itemwise Issue"=>URL."imrpt/iwinvissue","Item Ledger"=>URL."imrpt/itemledger","Stock Report"=>URL."imrpt/stock"),
			2 => array("Datewise Issue Receive"=>URL."imrpt/dwissrcv","Warehouse Stock"=>URL."imrpt/whstock"),			
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
			$this->view->renderpage('imrpt/imrptmenu', false);
		}
		
		function dwissrcv(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."imrpt/dwissrcv",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xitemcode"=>"",
				"xitemdesc"=>""
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xitemcode-group_".URL."itempicklist/picklist"=>'Item Code_maxlength="20"',
								"xitemdesc-text"=>'Description_maxlength="100" readonly',
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."imrpt/showdwissrcv", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('imrpt/imrptfilter', false);
		
		}

		public function showdwissrcv(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li><a href="'.URL.'imrpt/dwissrcv">Report Filter Form</a></li>
							<li class="active">Inventoy Receive</li>
						   </ul>';
		
			
						   

			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();	
			$item = $_POST['xitemcode'];		
			$cond = " and xitemcode='".$item."' ";
			if($item=="")
				$cond="";	
			
			$tblvalues = $this->model->getinvissrcv($fdate, $tdate, $cond);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Inventory Issue Receive";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Date",1=>"Document Type",2=>"Document No",3=>"Item Code",4=>"Item Description",5=>"Cost",6=>"Receive",7=>"Issue"),
				"buttons"=>array(),
				"urlvals"=>array(),
				"sumfields"=>array("xqtydr","xqtycr"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->reportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('imrpt/reportpage');
		}

		function invrcv(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."imrpt/invrcv",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xitemcode"=>"",
				"xitemdesc"=>""
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xitemcode-group_".URL."itempicklist/picklist"=>'Item Code_maxlength="20"',
								"xitemdesc-text"=>'Description_maxlength="100" readonly',
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."imrpt/showinvrcv", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('imrpt/imrptfilter', false);
		
		}

		public function showinvrcv(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li><a href="'.URL.'imrpt/invrcv">Report Filter Form</a></li>
							<li class="active">Inventoy Receive</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();			
			
			$item = $_POST['xitemcode'];		
			$cond = " and xitemcode='".$item."' ";
			if($item=="")
				$cond="";

			$tblvalues = $this->model->getinvrcv($fdate, $tdate, $cond);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Inventory Receive";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Date",1=>"Document Type",2=>"Document No",3=>"Item Code",4=>"Item Description",5=>"Cost",6=>"Qty",7=>"Total"),
				"buttons"=>array(),
				"urlvals"=>array(),
				"sumfields"=>array("xqty","xtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->reportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('imrpt/reportpage');
		}

		function invissue(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."imrpt/invissue",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xitemcode"=>"",
				"xitemdesc"=>""
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xitemcode-group_".URL."itempicklist/picklist"=>'Item Code_maxlength="20"',
								"xitemdesc-text"=>'Description_maxlength="100" readonly',
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."imrpt/showinvissue", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('imrpt/imrptfilter', false);
		
		}

		public function showinvissue(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li><a href="'.URL.'imrpt/invissue">Report Filter Form</a></li>
							<li class="active">Inventoy Issue</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();	

			$item = $_POST['xitemcode'];		
			$cond = " and xitemcode='".$item."' ";
			if($item=="")
				$cond="";
			
			$tblvalues = $this->model->getinvissue($fdate, $tdate, $cond);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Date wise Inventory Issue";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Date",1=>"Document Type",2=>"Document No",3=>"Item Code",4=>"Item Description",5=>"Cost",6=>"Qty",7=>"Total"),
				"buttons"=>array(),
				"urlvals"=>array(),
				"sumfields"=>array("xqty","xtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->reportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('imrpt/reportpage');
		}

		function dwinvrcv(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."imrpt/dwinvrcv",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xitemcode"=>"",
				"xitemdesc"=>""
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xitemcode-group_".URL."itempicklist/picklist"=>'Item Code_maxlength="20"',
								"xitemdesc-text"=>'Description_maxlength="100" readonly',
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."imrpt/showdatewiseinvrcv", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('imrpt/imrptfilter', false);
		
		}
		
		function showdatewiseinvrcv(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li><a href="'.URL.'imrpt/dwinvrcv">Report Filter Form</a></li>
							<li class="active">Datewise Inventoy Receive</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();		

			$item = $_POST['xitemcode'];		
			$cond = " and xitemcode='".$item."' ";
			if($item=="")
				$cond="";	

			$tblvalues = $this->model->getinvrcv($fdate, $tdate,$cond);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Datewise Inventory Receive";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Document Type",1=>"Document No",2=>"Item Code",3=>"Item Description",4=>"Cost",5=>"Qty",6=>"Total"),
				"groupfield"=>"Date~xdate",
				"grouprecords"=>array(), //database records columns to show in group
				"detailsection"=>array("xdoctype","xtxnnum","xitemcode","xitemdesc","xstdcost","xqty","xtotal"),
				"buttons"=>array(),
				"urlvals"=>array(),
				"sumfields"=>array("xqty","xtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('imrpt/reportpage');
		}

		function dwinvissue(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."imrpt/dwinvissue",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xitemcode"=>"",
				"xitemdesc"=>""
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xitemcode-group_".URL."itempicklist/picklist"=>'Item Code_maxlength="20"',
								"xitemdesc-text"=>'Description_maxlength="100" readonly',
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."imrpt/showdatewiseinvissue", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('imrpt/imrptfilter', false);
		
		}

		function showdatewiseinvissue(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li><a href="'.URL.'imrpt/dwinvissue">Report Filter Form</a></li>
							<li class="active">Datewise Inventoy Issue</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();			

			$item = $_POST['xitemcode'];		
			$cond = " and xitemcode='".$item."' ";
			if($item=="")
				$cond="";

			$tblvalues = $this->model->getinvissue($fdate, $tdate, $cond);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Datewise Inventory Issue";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Document Type",1=>"Document No",2=>"Item Code",3=>"Item Description",4=>"Cost",5=>"Qty",6=>"Total"),
				"groupfield"=>"Date~xdate",
				"grouprecords"=>array(), //database records columns to show in group
				"detailsection"=>array("xdoctype","xtxnnum","xitemcode","xitemdesc","xstdcost","xqty","xtotal"),
				"buttons"=>array(),
				"urlvals"=>array(),
				"sumfields"=>array("xqty","xtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('imrpt/reportpage');
		}
		
		function iwinvrcv(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."imrpt/iwinvrcv",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xitemcode"=>"",
				"xitemdesc"=>""
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xitemcode-group_".URL."itempicklist/picklist"=>'Item Code_maxlength="20"',
								"xitemdesc-text"=>'Description_maxlength="100" readonly',
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."imrpt/showitemwiseinvrcv", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('imrpt/imrptfilter', false);
		
		}
		
		function showitemwiseinvrcv(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li><a href="'.URL.'imrpt/iwinvrcv">Report Filter Form</a></li>
							<li class="active">Itemwise Inventoy Receive</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();		

			$item = $_POST['xitemcode'];		
			$cond = " and xitemcode='".$item."' ";
			if($item=="")
				$cond="";
	
			
			$tblvalues = $this->model->getinvrcv($fdate, $tdate, $cond);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Itemwise Inventory Receive";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Date",1=>"Document Type",2=>"Document No",3=>"Cost",4=>"Qty",5=>"Total"),
				"groupfield"=>"Item Code~xitemcode",
				"grouprecords"=>array("Description~xitemdesc"), //database records columns to show in group
				"detailsection"=>array("xdate","xdoctype","xtxnnum","xstdcost","xqty","xtotal"),
				"buttons"=>array(),
				"urlvals"=>array(),
				"sumfields"=>array("xqty","xtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('imrpt/reportpage');
		}

		function iwinvissue(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."imrpt/iwinvissue",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xitemcode"=>"",
				"xitemdesc"=>""
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xitemcode-group_".URL."itempicklist/picklist"=>'Item Code_maxlength="20"',
								"xitemdesc-text"=>'Description_maxlength="100" readonly',
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."imrpt/showitemwiseinvissue", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('imrpt/imrptfilter', false);
		
		}

		function showitemwiseinvissue(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li><a href="'.URL.'imrpt/iwinvissue">Report Filter Form</a></li>
							<li class="active">Itemwise Inventoy Issue</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();	

			$item = $_POST['xitemcode'];		
			$cond = " and xitemcode='".$item."' ";
			if($item=="")
				$cond="";
	
					
			
			$tblvalues = $this->model->getinvissue($fdate, $tdate, $cond);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Itemwise Inventory Issue";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Date",1=>"Document Type",2=>"Document No",3=>"Cost",4=>"Qty",5=>"Total"),
				"groupfield"=>"Item Code~xitemcode",
				"grouprecords"=>array("Description~xitemdesc"), //database records columns to show in group
				"detailsection"=>array("xdate","xdoctype","xtxnnum","xstdcost","xqty","xtotal"),
				"buttons"=>array(),
				"urlvals"=>array(),
				"sumfields"=>array("xqty","xtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('imrpt/reportpage');
		}

		function itemledger(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."imrpt/itemledger",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt,
				"xitemcode"=>"",
				"xitemdesc"=>""
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""',
								"xitemcode-group_".URL."itempicklist/picklist"=>'Item Code_maxlength="20"',
								"xitemdesc-text"=>'Description_maxlength="100" readonly',
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."imrpt/showitemledger", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('imrpt/imrptfilter', false);
		
		}

		function showitemledger(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li><a href="'.URL.'imrpt/itemledger">Report Filter Form</a></li>
							<li class="active">Item Ledger</li>
						   </ul>';
		
			$item = $_POST['xitemcode'];			
			$itemdesc = $_POST['xitemdesc'];	

			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();			
			
			$tblvalues = $this->model->getinvdetail($fdate, $tdate, $item);
			
			$opbal = $this->model->getopbal($fdate, $item);
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Item Ledger for item<br/>".$item."-".$itemdesc;
			$this->view->org=Session::get('sbizlong');
			$fields = array(
						"xdate-Date",
						"xdoctype-Ducument Type",
						"xtxnnum-Txn. No",
						"xcost-cost",
						"xqtydr-Receive",
						"xqtycr-Issue"
						);
			$table = new ReportingTable();
			$this->view->table = $table->itemledgerTable($fields, $tblvalues, "xitemcode", $opbal[0]["xbal"],$item,$itemdesc);
				
			$this->view->renderpage('imrpt/reportpage');
		}

		public function stock(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>		
							<li class="active">Stock Report</li>
						   </ul>';
		
						
			
			$tblvalues=array();			
			
			$tblvalues = $this->model->getImStock();
				//print_r($tblvalues);die;
			
			$this->view->vfdate = "A";
			$this->view->vtdate = "Z";
			$this->view->vrptname = "Stock Report";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Item Code",1=>"Description",2=>"PO Qty",3=>"Qty",4=>"Sold Qty"),
				"groupfield"=>"Warehouse~xwh",
				"grouprecords"=>array(), //database records columns to show in group
				"detailsection"=>array("xitemcode","xitemdesc","xqtypo","xqty","xqtyso"),
				"buttons"=>array(),
				"urlvals"=>array(),
				"sumfields"=>array("xqtypo","xqty","xqtyso"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('imrpt/reportpage');
		}


		function whstock(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."imrpt/whstock",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				
				"xwh"=>"",
				
				);
				
				$fields = array(array(
								
								"xwh-select_Warehouse"=>'Warehouse_maxlength="20"'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."imrpt/showwhstock", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('imrpt/imrptfilter', false);
		
		}

		public function showwhstock(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'imrpt/imrptmenu">Inventory Reports</a></li>
							<li><a href="'.URL.'imrpt/dwissrcv">Report Filter Form</a></li>
							<li class="active">Inventoy Receive</li>
						   </ul>';
		
			$wh = $_POST['xwh'];			
			
				
			$tblvalues=array();			
			
			$tblvalues = $this->model->getWarehouseStock(" and xwh='".$wh."' ");
				//print_r($tblvalues);die;
			
			$this->view->vfdate ="A";
			$this->view->vtdate = "Z";
			$this->view->vrptname = "Warehouse Stock For ".$wh;
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Item Code",1=>"Description",2=>"Qty"),
				"buttons"=>array(),
				"urlvals"=>array(),
				"sumfields"=>array("xqty"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->reportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('imrpt/reportpage');
		}
		
	}