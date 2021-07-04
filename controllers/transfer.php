<?php
class Transfer extends Controller{
	
	private $values = array();
	private $fields = array();
	private $plotvalues = array();
	private $plotfields = array();
	
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
				if($menus["xsubmenu"]=="Transfer")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/customers/js/codevalidator.js','views/stuenroll/js/studentenroll.js','views/transfer/js/getaccdt.js');
		$dt = date("Y/m/d");
		$date = date('Y-m-d', strtotime($dt));
		$year = date('Y',strtotime($date));
		$this->values = array(
			"xcus"=>"",
			"xshort"=>"",		
			"xadd1"=>"",
			"xagent"=>"",
			"xagname"=>"",
			"xagadd1"=>""
			);
			
			$this->fields = array(					
						array(
							"xcus-group_".URL."customers/picklist"=>'Customer Code*~star_maxlength="20"',
							"xshort-text"=>'Customer Name*~star_maxlength="100" readonly'					
							),
						array(							
							"xadd1-text"=>'Address_readonly',
							"xagent-group_".URL."agent/picklist"=>'Agent_maxlength="50"'
							),
						array(							
							"xagname-text"=>'Agent Name*~star_maxlength="100" readonly',
							"xagadd1-text"=>'Agent Address_readonly',
							)
						);

// flot transfer coad start here..//

		$this->plotvalues = array(
								"xcus"=>"",
								"xshort"=>"",		
								"xadd1"=>"",
								"xitemcode"=>"",
								"xitemdesc"=>"",
								"xrow"=>""
								);
			
		$this->plotfields = array(					
								array(
									"xcus-group_".URL."customers/picklist"=>'Customer Code*~star_maxlength="20"',
									"xshort-text"=>'Customer Name*~star_maxlength="100" readonly'					
									),
								array(							
									"xadd1-text"=>'Address_readonly',
									"xitemcode-group_".URL."itempicklist/picklist"=>'Plot No*~star_maxlength="20"',
									),
								array(							
									"xitemdesc-text"=>'Plot Description_readonly',
									"xrow-hidden"=>'_""'
									)
								);
		}
		
		public function index(){
		
		
		$btn = array(
			"Clear" => URL."transfer/agtransferentry",
		);	
		
		
		// form data
		
			$dynamicForm = new Dynamicform("Agent Transfer",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields,"","", $this->values, URL."transfer/showpost");
			
			//$this->view->table = $this->renderTable();
			
			$this->view->rendermainmenu('transfer/index');
			
		}
		
		public function editagent(){
			
			$result = "";
			$cus = $_POST['xcus'];
			
			$success=false;
			$form = new Form();
				$data = array();
				
				try{
					if(empty($_POST['xcus'])){
						throw new Exception("Select Customer!");
					}
			
				$form	->post('xagent')
						->val('minlength', 1)
						->val('maxlength', 20);
						
						 
				$form	->submit();
				
				$data = $form->fetch();	
				
				$data['xemail'] = Session::get('suser');
				$data['zutime'] = date("Y-m-d H:i:s");
				
				$success = $this->model->editAgent($data, $cus);
				$insdt = $this->model->getInsdt($cus);
				
				}catch(Exception $e){
					//echo $e->getMessage();die;
					$result = $e->getMessage();
					//echo $result;
				}
				if($result==""){
				if($success){
					$i=1;
				    while($i <= count($insdt)){
					foreach($insdt as $key=>$values){
						$fields = array(
							"zutime"=>$data['zutime'],
							"xemail" => $data['xemail'],
							"xagent" => $data['xagent']
							);
						$where = " bizid = ". Session::get('sbizid') ." and xinsnum = '". $values['xinsnum'] ."' and xinssl='".$values['xinssl']."'";
						$this->model->editInsmst($fields,$where);
					}
					$i++;
					}
					$result = "Agent Edited successfully";
				}else{
					$result = "Edit failed!";
				}
				}
				 $this->showpost($cus,$result);
				
		
		}
		

		function agtransferentry(){
				
		$btn = array(
			"Clear" => URL."transfer/agtransferentry"
		);

		// form data
		
			$dynamicForm = new Dynamicform("Agent Transfer",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields,"","", $this->values, URL."transfer/showpost");
			
			$this->view->table ="";
			
			$this->view->renderpage('transfer/stuextraentry', false);
		}

		function plottransferentry(){
				
			$btn = array(
				"Clear" => URL."transfer/plottransferentry"
			);
	
			// form data
			
				$dynamicForm = new Dynamicform("Plot Transfer",$btn);		
				
				$this->view->dynform = $dynamicForm->createForm($this->plotfields,"","", $this->plotvalues, URL."transfer/showplot");
				
				$this->view->table ="";
				
				$this->view->renderpage('transfer/stuextraentry', false);
			}
		

		public function showpost($cus="",$result=""){
			$cus = $_POST['xcus'];
			
		$tblvalues=array();
		$btn = array(
			"New" => URL."transfer/agtransferentry"
		);
		
		$tblvalues = $this->model->getCustomer($cus);
		//print_r($tblvalues);die;
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(					
					"xcus"=>$tblvalues[0]['xcus'],
					"xshort"=>$tblvalues[0]['xshort'],
					"xadd1"=>$tblvalues[0]['xadd1'],
					"xagent"=>$tblvalues[0]['xagent'],
					"xagname"=>$tblvalues[0]['xagname'],	
					"xagadd1"=>$tblvalues[0]['xagadd1']
					);
		
		// form data

			$dynamicForm = new Dynamicform("Agent Transfer", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."transfer/editagent", "Update",$tblvalues, URL."transfer/showpost");
			
			$this->view->table = "";
			
			$this->view->renderpage('transfer/stuextraentry');
		}

		public function showplot($cus="",$result=""){
			$cus = $_POST['xcus'];
			
		$tblvalues=array();
		$btn = array(
			"New" => URL."transfer/agtransferentry"
		);
		
		$tblvalues = $this->model->getCustomer($cus);
		//print_r($tblvalues);die;
		if(empty($tblvalues))
			$tblvalues=$this->plotvalues;
		else
			$tblvalues=array(					
					"xcus"=>$tblvalues[0]['xcus'],
					"xshort"=>$tblvalues[0]['xshort'],
					"xadd1"=>$tblvalues[0]['xadd1'],
					"xitemcode"=>"",
					"xitemdesc"=>"",
					"xrow"=>""
					);
		
		// form data

			$dynamicForm = new Dynamicform("Plot Transfer", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->plotfields,"","", $tblvalues, URL."transfer/showplot");
			
			$this->view->table = $this->renderTable($cus);
			
			$this->view->renderpage('transfer/plottransferentry');
		}

		public function editshowplot($cus="", $row="", $result=""){
		if($cus==""){
			header ('location: '.URL.'transfer/plottransferentry');
			exit;
		}
		$tblvalues=array();
		$btn = array(
			"New" => URL."transfer/agtransferentry"
		);
		
		$tblvalues = $this->model->getCustomer($cus);
		$getplot = $this->model->getPlot($cus,$row);
		//print_r($tblvalues);die;
		if(empty($tblvalues))
			$tblvalues=$this->plotvalues;
		else
			$tblvalues=array(					
					"xcus"=>$tblvalues[0]['xcus'],
					"xshort"=>$tblvalues[0]['xshort'],
					"xadd1"=>$tblvalues[0]['xadd1'],
					"xitemcode"=>$getplot[0]['xitemcode'],
					"xitemdesc"=>$getplot[0]['xitemdesc'],
					"xrow"=>$row
					);
		
		// form data

			$dynamicForm = new Dynamicform("Plot Transfer", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->plotfields, URL."transfer/editplot", "Update",$tblvalues, URL."transfer/showplot");
			
			$this->view->table = $this->renderTable($cus);
			
			$this->view->renderpage('transfer/plottransferentry');
		}

		public function editplot(){
			$result = "";
			$cus = $_POST['xcus'];
			$itemdt = $this->model->getItemDt($_POST['xitemcode']);

			$success=false;
			$form = new Form();
				$data = array();
				
				try{
					if(empty($_POST['xcus'])){
						throw new Exception("Select Customer!");
					}
			
				$form	->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20);
						
						 
				$form	->submit();
				
				$data = $form->fetch();	
				
				$data['xemail'] = Session::get('suser');
				$data['zutime'] = date("Y-m-d H:i:s");
				$data['xitembatch'] = $data['xitemcode'];
				$data['xblock'] = $itemdt[0]['xcat'];
				$data['xroad'] = $itemdt[0]['xcolor'];
				$data['xplot'] = $itemdt[0]['xsize'];

				$getitem = $this->model->getitem($cus,$_POST['xrow']);
				$this->model->itemupdate($getitem[0]['xitemcode']);

				$success = $this->model->editPlot($data, $cus, $_POST['xrow']);
				$item = $this->model->getitem($cus,$_POST['xrow']);
				
				}catch(Exception $e){
					//echo $e->getMessage();die;
					$result = $e->getMessage();
					//echo $result;
				}
				if($result==""){
				if($success){
					$this->model->saleItem($item[0]['xitemcode']);
					$result = "Plot Edited successfully";
				}else{
					$result = "Edit failed!";
				}
				}
				 $this->editshowplot($cus, $_POST['xrow'], $result);
				
		}

		function renderTable($cus){
			
			$sales = $this->model->getCusSale($cus);
			$row = $this->model->getvsalesdt($cus);
			
			$table = '<table class="table table-striped table-bordered">';
				$table .='<thead>
							<th></th><th>Sl.</th><th>Itemcode</th><th>Description</th><th style="text-align:right">Rate</th><th style="text-align:right">Qty</th><th style="text-align:right">Total</th>
						</thead>';
						$totalqty = 0;
						$totalextqty = 0;
						$total = 0;
						$totaltax = 0;
						$totaldisc = 0;
						$table .='<tbody>';

						foreach($row as $key=>$val){
							$showurl = URL."transfer/editshowplot/".$cus."/".$val['xrow'];
							$table .='<tr>';
							
							$table.='<td><a class="btn btn-info" id="btnshow" href="'.$showurl.'" role="button">Show</a></td>';

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
							$table .='<tr><td align="right" colspan="5"><strong>Total</strong></td><td align="right"><strong>'.number_format($totalqty,2).'</strong></td><td align="right"><strong>'.number_format($total,2).'</strong></td></tr>';
							
					$table .="</tbody>";			
			$table .= "</table>";
			
			return $table;
			
			
		}

}