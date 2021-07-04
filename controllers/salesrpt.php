<?php 
class Salesrpt extends Controller{
	
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
			
		$this->view->js = array('public/js/datatable.js','views/distreg/js/codevalidator.js','views/salesrpt/js/getaccdt.js');
								
		}
		
		public function index(){
					
			
			$this->view->rendermainmenu('salesrpt/index');
			
		}
		
		
		
		function salesrptmenu(){
			
			$menuarr = array(
			0 => array("Agent Wise Sales Report"=>URL."salesrpt/customerledger","Agent Wise Collection"=>""),
			);
			$menutable='<div class="table-responsive"><table class="table" style="width:100%"><tbody>';
			foreach($menuarr as $key=>$value){
				$menutable.='<tr>';
					foreach($value as $k=>$val){
						$menutable.='<td><a style="width:100%" class="btn btn-info" href="'.$val.'" role="button"><span class="glyphicon glyphicon-open-file"></span>&nbsp;'.$k.'</a></td>';
					}
				$menutable.='</tr>';
				
			}
			$menutable.='</tbody></table></div>';
			$this->view->table = $menutable;
			$this->view->renderpage('salesrpt/salesrptmenu', false);
		}
		
		
		function customerledger(){
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'salesrpt/salesrptmenu">GL Reports</a></li>
							<li class="active">Customer Ledger</li>
						   </ul>';
			$btn = array(
				"Clear" => URL."salesrpt/customerledger",
			);	
			$dt = date("Y/m/d");
			
			$values = array(
				"xagent"=>"",
				"xshort"=>""
				);
				
				$fields = array(
							array(
								"xagent-group_".URL."jsondata/agentpicklist"=>'Agent Code_maxlength="20"',
								"xshort-text"=>'Agent_maxlength="100"'
								)
							);
			
				$dynamicForm = new Dynamicform("Customer Ledger Report Filter",$btn);		
				
				$this->view->dynform = $dynamicForm->createFourColumnFormGen($fields, URL."salesrpt/showcusledger", "Show Report",$values);
				
				$this->view->table = "";
				
				$this->view->renderpage('salesrpt/salesrptfilter', false);
		
		}
		
		
		
		public function showcusledger(){
		
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li><a href="'.URL.'salesrpt/salesrptmenu">GL Reports</a></li>
							<li><a href="'.URL.'salesrpt/customerledger">Customer Ledger</a></li>
							<li class="active">Customer Ledger Report</li>
						   </ul>';
		
			$xagent = "";
			$xshort = "";
			if(isset($_POST['xagent']))
				$xagent = $_POST['xagent'];
			if(isset($_POST['xshort']))
				$xshort = $_POST['xshort'];

			$totalpoint = "";
			$this->view->tabletitle = "Agent No : ".$xagent.", Name :".$xshort;
			$this->view->vrptname = "Agent Wise Sales Report</br>";
			$this->view->org=Session::get('sbizlong');
			$this->view->table = $this->salestable($xagent);
				
			$this->view->renderpage('salesrpt/reportpage');
		}

		public function salestable($xagent){
		$table="";
		$insdt = $this->model->getsalesdt($xagent);

		
		$table.= '<div class=""><table id="grouptable" border="1" class="table table-bordered table-striped">';
			$table.='<thead>';
				$table.='<tr>';
					$table.='<td><strong>Customer No</strong></td><td><strong>Name</strong></td><td style="width:600px"><strong>Address</strong></td><td><strong>Mobile</strong></td><td><strong>Katha</strong></td><td><strong>Block</strong></td><td><strong>Road</strong></td><td><strong>Ploat</strong></td>';
				$table.='</tr>';
				$table.='</thead>';
				$table.='<tbody>';
					$table.='<tr>';
					foreach ($insdt as $key => $value) {
						$katha = $this->model->getkatha($value['xcus']);
						$ploat = $this->model->getploat($value['xcus']);
						$table.='<td>'.$value['xcus'].'</td>';
						$table.='<td>'.$value['xshort'].'</td>';
						$table.='<td style="width:600px">'.$value['xadd1'].'</td>';
						$table.='<td>'.$value['xmobile'].'</td>';
						foreach ($katha as $key => $val) {
							$table.='<td>'.$val['xkatha'].'</td>';
							$table.='<td>'.$val['xblock'].'</td>';
							$table.='<td>'.$val['xroad'].'</td>';
						}
						
							$table.='<td>';
							if(count($ploat)>1){
							    foreach ($ploat as $key => $valu) {
							$table.='<i>'.$valu['xplot'].'</i>,';
							    }
							}else{
							    foreach ($ploat as $key => $valu) {
							$table.='<i>'.$valu['xplot'].'</i>';
							    }
							}
							$table.='</td>';
						
					
						
					$table.='</tr>';
				}
					


				$table.='</tbody>';
				$table.='</table></div';
				return  $table;	
		}
		
		
	}