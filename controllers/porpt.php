<?php 
class Porpt extends Controller{
	
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
				if($menus["xsubmenu"]=="PO Reports")
					$iscode=1;				
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/glrpt/js/getaccdt.js');
								
		}
		
		public function index(){
					
			
			$this->view->rendermainmenu('porpt/index');
			
		}
		
		
		
		function porptmenu(){
			
			$menuarr = array(
			0 => array("Date wise Purchase Order"=>URL."porpt/datewisepo","Item wise Purchase Order"=>URL."porpt/itemwisepo","Supplier wise Purchase Order"=>URL."porpt/supwisepo"),
			
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
			$this->view->renderpage('porpt/porptmenu', false);
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

		

		function datewisepo(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'porpt/porptmenu">PO Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."porpt/datewisepo",
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
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."porpt/showdatewisepo", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('porpt/porptfilter', false);
		
		}

		public function showdatewisepo(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'porpt/porptmenu">PO Reports</a></li>
							<li><a href="'.URL.'porpt/datewisepo">Report Filter Form</a></li>
							<li class="active">Purchase Order List</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
				
			$tblvalues=array();			
			
				$tblvalues = $this->model->dateWisePO($fdate, $tdate);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Date wise Purchase Order";
			$this->view->tabletitle = "";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array("0"=>"PO","1"=>"Supplier","2"=>"Name/Org","3"=>"Item Code",4=>"Item Description",5=>"Qty",6=>"Rate",7=>"Unit",8=>"Total"),
				"groupfield"=>"Date~xdate",
				"grouprecords"=>array(), //database records columns to show in group
				"detailsection"=>array("xponum","xsup","xorg","xitemcode","xitemdesc","xqty","xratepur","xunitpur","xtotal"),
				//"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
				//"urlvals"=>array("id","phone"),
				"sumfields"=>array("xqty","xtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('porpt/reportpage');
		}

		function itemwisepo(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'porpt/porptmenu">PO Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."porpt/itemwisepo",
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
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."porpt/showitemwisepo", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('porpt/porptfilter', false);
		
		}

		public function showitemwisepo(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'porpt/porptmenu">PO Reports</a></li>
							<li><a href="'.URL.'porpt/itemwisepo">Report Filter Form</a></li>
							<li class="active">Purchase Order List</li>
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
			
				$tblvalues = $this->model->itemWisePO($fdate, $tdate);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Item wise Purchase Order";
			$this->view->tabletitle = "";
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array("0"=>"Date",1=>"xponum",2=>"Qty",3=>"Rate",4=>"Unit",5=>"Total"),
				"groupfield"=>"Item Code~xitemcode",
				"grouprecords"=>array("Item Description~xitemdesc"),
				"detailsection"=>array("xdate","xponum","xratepur","xunitpur","xqty","xtotal"),
				"sumfields"=>array("xqty","xtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('porpt/reportpage');
		}

		function supwisepo(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'porpt/porptmenu">PO Reports</a></li>
							<li class="active">Report Filter</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."porpt/supwisepo",
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
								"xsup-group_".URL."suppliers/picklist"=>'Supplier_""',
								"xorg-text"=>'Org/Name_"" readonly'
								)
							);
			
				$dynamicForm = new Dynamicform("Report Filter Form",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."porpt/showsupwisepo", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('porpt/porptfilter', false);
		
		}

		public function showsupwisepo(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'porpt/porptmenu">PO Reports</a></li>
							<li><a href="'.URL.'porpt/supwisepo">Report Filter Form</a></li>
							<li class="active">Purchase Order List</li>
						   </ul>';
		
						
			$xfdate = $_POST['xfdate'];
			$fdt = str_replace('/', '-', $xfdate);
			$fdate = date('Y-m-d', strtotime($fdt));
			
			$xtdate = $_POST['xtdate'];
			$tdt = str_replace('/', '-', $xtdate);
			$tdate = date('Y-m-d', strtotime($tdt));
			$sup = "";
			if(isset($_POST["xsup"]))
				$sup = $_POST["xsup"];
			$getsupdt = $this->model->getsupdt($sup);
				
			$tblvalues=array();			
			
				$tblvalues = $this->model->supWisePO($fdate, $tdate, $sup);
				//print_r($tblvalues);die;
			
			$this->view->vfdate = $fdt;
			$this->view->vtdate = $tdt;
			$this->view->vrptname = "Supplierwise Purches Order";
			$this->view->tabletitle = "Supplierwise ID : ".$sup." , Name : ".$getsupdt[0]['xorg']." , Address : ".$getsupdt[0]['xadd1'];
			$this->view->org=Session::get('sbizlong');
			$tblsettings = array(
				"columns"=>array(0=>"Date",1=>"PO",2=>"Item Code",3=>"Item Description",4=>"Qty",5=>"Rate",6=>"Unit",7=>"Total"),
				"groupfield"=>"Supplier~xponum",
				"detailsection"=>array("xdate","xponum","xitemcode","xitemdesc","xqty","xratepur","xunitpur","xtotal"),
				"sumfields"=>array("xtotal"),
				);
			$table = new ReportingTable();
			$this->view->table = $table->SupSingleGroupReportingtbl($tblsettings, $tblvalues);
				
			$this->view->renderpage('porpt/reportpage');
		}


		
	}