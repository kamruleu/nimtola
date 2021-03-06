<?php  
class Sorpt extends Controller{
	
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
				if($menus["xsubmenu"]=="Sales Reports")
					$iscode=1;				
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/glrpt/js/getaccdt.js');
								
		}
		
		public function index(){
					
			
			$this->view->rendermainmenu('sorpt/index');
			
		}
		
		
		
		function sorptmenu(){
			
			$menuarr = array(
			0 => array("Date wise Sales Order"=>URL."sorpt/datewiseso","Item wise Sales Order"=>URL."sorpt/itemwiseso","Customerwise Sales Order"=>URL."sorpt/cuswiseso","Category Wise Sales"=>URL."sorpt/catwisesales",),
			1 => array("Mobile Order Dealer"=>URL."sorpt/dealerorder","Mobile Order MRP"=>URL."sorpt/mrporder","Retailer Return"=>URL."sorpt/retailerreturn","Dealer Return"=>URL."sorpt/dealerreturn")
			
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
			$this->view->renderpage('sorpt/sorptmenu', false);
		}
		
		
		function doubleGroupTable($cols, $rows, $groupval=array(), $totalfield=array()){
		
			$row = $rows;
			$cl = count($cols);
			$val1="";
			$val2="";
			if(count($groupval)>0 && count($groupval)<3){
				$val1=$groupval[0];
				$val2=$groupval[1];
			}
			$grouprec = [];
			$sgrouprec = [];
			foreach($row as $gkey=>$gval){
				$keyval = $gval[$val1];
				$grouprec[$keyval][]=$gval;
				foreach ($grouprec[$keyval] as $skey=>$sval){
								$skeyval = $sval[$val2];
								$sgrouprec[$keyval][$skeyval]= $sval;
							}
			}
			
												
			$table = '';
			$total=0;
			
			$table.= '<table id="grouptable" class="table table-bordered table-striped" style="width:100%">';	
				$table.= '<thead>';
				foreach ($cols as $col){
					$table.= '<th>'.$col.'</th>';
				}
				$table.= '</thead>';
				$table.= '<tbody>';
					foreach($sgrouprec as $key=>$sval ){
						$subtotal=0; //print_r($sval[]); die;
						$table.= '<tr rowspan="'.count($cols).'">';
							$table.= '<td><strong>'. $key .'</strong></td>';
							for ($i=0; $i<count($cols)-1; $i++){
								$table.= '<td></td>';
							}
						$table.= '</tr>';
						
							foreach($sval as $sk=>$val ){
							$subtotal=0;
							$table.= '<tr rowspan="'.count($cols).'">';
								$table.= '<td></td><td><strong>'. $sk .'</strong></td>';
								for ($i=0; $i<count($cols)-2; $i++){
									$table.= '<td></td>';
								}
							$table.= '</tr>';
							$table.= '<tr><td></td><td></td>';
							foreach($val as $k=>$v ){
									
									if ($k <> $val1 && $k <> $val2){
										$alin = "";
										if($k=="xqty")
											$alin = 'style="background-color:gray; text-align:center; color:white;"';
										
										$table.= '<td '.$alin.'>'. $v .'</td>';
									}
								
							}
							$table.= '</tr>';
					}
					}
				$table.= '</tbody></table>';
				
			
			return $table;
			
		}


		function datewiseso(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."sorpt/datewiseso",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."sorpt/showdatewiseso", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('sorpt/sorptfilter', false);
		
		}

		

		public function showdatewiseso(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li><a href="'.URL.'sorpt/datewiseso">Report Filter Form</a></li>
							<li class="active">Sales Orders</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();			
			 
				$tblvalues = $this->model->dateWiseso($fdate, $tdate);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Date wise Sales Order";
			$this->view->tabletitle = "";
			$this->view->org=Session::get('sbizlong');

			//first version--------
// 			$tblsettings = array(
// 				"columns"=>array("0"=>"Salese Order","1"=>"Customer","2"=>"Name/Org","3"=>"Item Code",4=>"Item Description",5=>"Rate",6=>"Qty",7=>"Unit",8=>"Total"),
// 				"groupfield"=>"Date~xdate",
// 				"grouprecords"=>array(), //database records columns to show in group
// 				"detailsection"=>array("xsonum","xcus","xorg","xitemcode","xitemdesc","xrate","xqty","xunitsale","xsubtotal"),
// 				//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
// 				//"urlvals"=>array("id","phone"),
// 				"sumfields"=>array("xqty","xsubtotal"),
// 				);
			//second version-------
            // $tblsettings = array(
			// 	"columns"=>array("0"=>"Date","1"=>"Item Code",2=>"Item Description",3=>"Rate",4=>"Qty",5=>"Unit",6=>"Total"),
			// 	"groupfield"=>"Invoice No~xsonum",
			// 	"grouprecords"=>array("Customer~xcus","Name/Org~xorg"), //database records columns to show in group
			// 	"detailsection"=>array("xdate","xitemcode","xitemdesc","xrate","xqty","xunitsale","xsubtotal"),
			// 	//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
			// 	//"urlvals"=>array("id","phone"),
			// 	"sumfields"=>array("xqty","xsubtotal"),
			// 	);
			// $table = new ReportingTable();
			// $this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);


			$tblsettings = array(
				"columns"=>array("0"=>"Date","1"=>"Item Code",2=>"Item Description",3=>"Qty",4=>"Unit",5=>"Rate",6=>"Total"),
				"groupfield"=>"Invoice No~xsonum",
				"grouprecords"=>array("Customer~xcus","Name/Org-Address~xorg"), //database records columns to show in group
				"detailsection"=>array("xdate","xitemcode","xitemdesc","xqty","xunitsale","xrate","xsubtotal"),
				//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
				//"urlvals"=>array("id","phone"),
				"sumfields"=>array("xqty","xsubtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('sorpt/reportpage');
		}
		
		
		
		
        // new --------------------------------

		function catwisesales(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."sorpt/catwisesales",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."sorpt/showcatwisesales", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('sorpt/sorptfilter', false);
		}

		public function showcatwisesales(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li><a href="'.URL.'sorpt/datewiseso">Report Filter Form</a></li>
							<li class="active">Sales Orders</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
				
			$tblvalues=array();			
			
				$tblvalues = $this->model->catWiseso($fdate);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vrptname = "Category wise Sales Order";
			$this->view->tabletitle = "";
			$this->view->org=Session::get('sbizlong');
            $tblsettings = array(
				"columns"=>array("0"=>"Item Code",1=>"Item Description",2=>"Qty",3=>"Unit",4=>"Total"),
				"groupfield"=>"Category~xcat",
				"grouprecords"=>array(), //database records columns to show in group
				"detailsection"=>array("xitemcode","xitemdesc","xqty","xunitsale","xsubtotal"),
				//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
				//"urlvals"=>array("id","phone"),
				"sumfields"=>array("xqty","xsubtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('sorpt/catreportpage');
		}
		
		// end new --------------------------------
		

		function itemwiseso(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">PO Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."sorpt/itemwiseso",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."sorpt/showitemwiseso", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('sorpt/sorptfilter', false);
		
		}

		public function showitemwiseso(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li><a href="'.URL.'sorpt/itemwiseso">Report Filter Form</a></li>
							<li class="active">Sales Order List</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
			// $sup = "";
			// if(isset($_POST["xsup"]))
			// 	$sup = $_POST["xsup"];
			// $item = "";			
			// if(isset($_POST["xitemcode"]))
			// 	$item = $_POST["xitemcode"];
				
			$tblvalues=array();			
			
				$tblvalues = $this->model->itemwiseso($fdate, $tdate);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Item wise Sales Order";
			$this->view->tabletitle = "";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array("0"=>"Date",1=>"Order No",2=>"Qty",3=>"Unit",4=>"Rate",5=>"Total"),
				"groupfield"=>"Item Code~xitemcode",
				"grouprecords"=>array("Item Description~xitemdesc"),
				"detailsection"=>array("xdate","xsonum","xqty","xunitsale","xrate","xsubtotal"),
				"sumfields"=>array("xqty","xsubtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('sorpt/reportpage');
		}

		function cuswiseso(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">PO Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."sorpt/cuswiseso",
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
								"xcus-group_".URL."customers/picklist"=>'Customer_""',
								"xorg-text"=>'Org/Name_"" readonly'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."sorpt/showcuswiseso", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('sorpt/sorptfilter', false);
		
		}

		public function showcuswiseso(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li><a href="'.URL.'sorpt/cuswiseso">Report Filter Form</a></li>
							<li class="active">Sales Orders</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));

			$cus = "";
			if(isset($_POST["xcus"]))
				$cus = $_POST["xcus"];
			$getcusdt = $this->model->getcusdt($cus);
				
			$tblvalues=array();
			$tblvalues = $this->model->cuswiseso($fdate, $tdate, $cus);
			//print_r($tblvalues);die;
			
			

			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Customerwise Sales Order";
			$this->view->tabletitle = "Customer ID : ".$cus." , Name : ".$getcusdt[0]['xorg']." , Address : ".$getcusdt[0]['xadd1'];
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Date",1=>"Item Code",2=>"Item Description",3=>"Qty",4=>"Unit",5=>"Rate",6=>"Total"),
				"groupfield"=>"SO No~xsonum",
				"detailsection"=>array("xdate","xitemcode","xitemdesc","xqty","xunitsale","xrate","xsubtotal"),
				"sumfields"=>array("xsubtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->CusSingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('sorpt/reportpage');
		}
        function dealerorder(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Report</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."sorpt/dealerorder",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."sorpt/showdealerorder", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('sorpt/sorptfilter', false);
		
		}

		public function showdealerorder(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li><a href="'.URL.'sorpt/dealerorder">Report Filter Form</a></li>
							<li class="active">Dealer Orders</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();			
			
				$tblvalues = $this->model->dealerorder($fdate, $tdate);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Dealer Order";
			$this->view->tabletitle = "";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array("0"=>"Order Number","1"=>"Customer","2"=>"Name/Org","3"=>"Item Code",4=>"Item Description",5=>"Rate",6=>"Qty",7=>"Total"),
				//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
				//"urlvals"=>array("id","phone"),
				"sumfields"=>array("qty","xsubtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->reportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('sorpt/reportpage');
		}
		
		function dealerreturn(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Report</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."sorpt/dealerreturn",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."sorpt/showdealereturn", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('sorpt/sorptfilter', false);
		
		}

		public function showdealereturn(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li><a href="'.URL.'sorpt/dealerreturn">Report Filter Form</a></li>
							<li class="active">Dealer Return</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();			
			
				$tblvalues = $this->model->dealerreturn($fdate, $tdate);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Dealer Return";
			$this->view->tabletitle = "";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array("0"=>"Order Number","1"=>"Customer","2"=>"Name/Org","3"=>"Item Code",4=>"Item Description",5=>"Rate",6=>"Qty",7=>"Total"),
				//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
				//"urlvals"=>array("id","phone"),
				"sumfields"=>array("qty","xsubtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->reportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('sorpt/reportpage');
		}
		
        function retailerorder(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Report</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."sorpt/retailerorder",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."sorpt/showretailerorder", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('sorpt/sorptfilter', false);
		
		}

		public function showretailerorder(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li><a href="'.URL.'sorpt/retailerorder">Report Filter Form</a></li>
							<li class="active">Retailer Orders</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();			
			
				$tblvalues = $this->model->retailerorder($fdate, $tdate);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Retailer Order";
			$this->view->tabletitle = "";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array("0"=>"Order Number","1"=>"Customer","2"=>"Name/Org","3"=>"Item Code",4=>"Item Description",5=>"Rate",6=>"Qty",7=>"Total"),
				//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
				//"urlvals"=>array("id","phone"),
				"sumfields"=>array("qty","xsubtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->reportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('sorpt/reportpage');
		}
		 function retailerreturn(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Retailer Return</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."sorpt/retailerreturn",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."sorpt/showretailerreturn", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('sorpt/sorptfilter', false);
		
		}

		public function showretailerreturn(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li><a href="'.URL.'sorpt/retailerreturn">Report Filter Form</a></li>
							<li class="active">Retailer Return</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();			
			
				$tblvalues = $this->model->retailerreturn($fdate, $tdate);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Retailer Return";
			$this->view->tabletitle = "";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array("0"=>"Order Number","1"=>"Customer","2"=>"Name/Org","3"=>"Item Code",4=>"Item Description",5=>"Rate",6=>"Qty",7=>"Total"),
				//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
				//"urlvals"=>array("id","phone"),
				"sumfields"=>array("qty","xsubtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->reportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('sorpt/reportpage');
		}
		 function mrporder(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">MRP Order</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."sorpt/mrporder",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xfdate"=>$dt,
				"xtdate"=>$dt
				);
				
				$fields = array(array(
								"xfdate-datepicker" => 'From_""',
								"xtdate-datepicker" => 'To_""'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."sorpt/showmrporder", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('sorpt/sorptfilter', false);
		
		}

		public function showmrporder(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'sorpt/sorptmenu">Sales Reports</a></li>
							<li><a href="'.URL.'sorpt/mrporder">Report Filter Form</a></li>
							<li class="active">MRP Orders</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();			
			
				$tblvalues = $this->model->mrporder($fdate, $tdate);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "MRP Order";
			$this->view->tabletitle = "";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array("0"=>"Order Number","1"=>"Customer","2"=>"Name/Org","3"=>"Item Code",4=>"Item Description",5=>"Rate",6=>"Qty",7=>"Total"),
				//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
				//"urlvals"=>array("id","phone"),
				"sumfields"=>array("qty","xsubtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->reportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('sorpt/reportpage');
		}
		
	}