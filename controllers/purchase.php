<?php
class Purchase extends Controller{
	
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
				if($menus["xsubmenu"]=="Purchase Order")
					$iscode=1;				
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/distreg/js/codevalidator.js','views/items/js/getitemdt.js','views/suppliers/js/getsup.js');
		$dt = date("Y/m/d");
		$this->values = array(
			"xdate"=>$dt,
			"xponum"=>"",
			"xsup"=>"",
			"xsupname"=>"",
			"xwh"=>"",
			"xsupdoc"=>"",
			"xitemcode"=>"",
			"xnote"=>"",
			"xdesc"=>"",
			"xqty"=>"0",
			"xrow"=>"0",
			"xratepur"=>"0.00"
			);
			
			$this->fields = array(
						array(
							"Purchase Detail-div"=>''													
							),
						array(
							"xponum-text"=>'PO No_maxlength="20"',
							"xdate-datepicker" => 'Date_""'							
							),
						array(
							"xsup-group_".URL."suppliers/picklist"=>'Supplier_""',
							"xsupname-text"=>'Name_readonly'
							),
						array(
							"xwh-select_Warehouse"=>'Warehouse*~star_maxlength="50"',
							"xsupdoc-text"=>'DO No*~star_maxlength="50"'														
							),
						array(							
							"xnote-textarea"=>'Additional Notes_""'							
							),
						array(
							"Item Detail-div"=>''													
							),
						array(
							"xitemcode-group_".URL."itempicklist/picklist"=>'Item Code_maxlength="20"',
							"xdesc-text"=>'Description_readonly'							
							),
						array(
							"xratepur-text_number"=>'Rate*~star_number="true" minlength="1" maxlength="18" required',
							"xqty-text_digit"=>'Quantity*~star_number="true" minlength="1" maxlength="18" required',
							"xrow-hidden"=>''
							)
						);
						
								
		}
		
		public function index(){
		
		
		$btn = array(
			"Clear" => URL."purchase/purchaseentry",
		);	
		
					
			$this->view->rendermainmenu('purchase/index');
			
		}
		
		public function savepurchase(){
				if (empty($_POST['xitemcode']) || empty($_POST['xdesc']) || empty($_POST['xqty'])){
					header ('location: '.URL.'purchase/purchaseentry');
					exit;
				}
								
				$xdate = $_POST['xdate'];
				$dt = str_replace('/', '-', $xdate);
				$date = date('Y-m-d', strtotime($dt));
				$year = date('Y',strtotime($date));
				$month = date('m',strtotime($date)); 
				$yearoffset = Session::get('syearoffset');
				$txnnum = $_POST['xponum'];
				$keyfieldval="0";
				$form = new Form();
				$data = array();
				$success=0;
				$result = ""; 
				$xyear = 0;
				$xper = 0;
				//print_r($this->model->getYearPer($yearoffset,intval($month))); die;
				foreach ($this->model->getYearPer($yearoffset,intval($month)) as $key=>$val){
					$xper = $key;
					$xyear = $val;
				}
				try{
					
				/*if($_POST['xsupdoc']=="")
					throw new Exception("DO Not Found!");*/
				
				if($_POST['xwh']=="")
					throw new Exception("Warehouse Not Found!");
				
				if($_POST['xsup']=="")
					throw new Exception("Warehouse Not Found!");
				
				$form	->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20)
						
						->post('xponum')	
						
						->post('xsup')
						->val('minlength', 1)
						->val('maxlength', 20)

						->post('xsupname')
						->val('minlength', 1)
						->val('maxlength', 100)						
				
						->post('xwh')
						->val('minlength', 1)
						->val('maxlength', 50)

						->post('xnote')
						->val('maxlength', 1000)
						
						->post('xsupdoc')						
						->val('maxlength', 50)
						
						->post('xqty')
						
						->post('xratepur');
						
				$form	->submit();
				
				
					
				
				$data = $form->fetch();
				
				
				$item = $this->model->getItem($data['xitemcode']);
				
				if($data['xponum'] == "")
					$keyfieldval = $this->model->getKeyValue("pomst","xponum","PORD-","6");
				else
					$keyfieldval = $data['xponum'];
				
					
				$data['bizid'] = Session::get('sbizid');
				$data['zemail'] = Session::get('suser');
				$data['xponum'] = $keyfieldval;
				$data['xdate'] = $date;
				$data['xbranch'] = Session::get('sbranch');
				$data['xfinyear'] = $xyear;
				$data['xfinper'] = $xper;			
				
				$rownum = $this->model->getRow("podet","xponum",$data['xponum'],"xrow");
				
				$cols = "`bizid`,`xponum`,`xrow`,`xitemcode`,`xitembatch`,`xqty`,`xdate`,`xratepur`,`xwh`,`xbranch`,`xproj`,`xtaxrate`,`xdisc`,`xexch`,`xcur`,`xtaxcode`,`xtaxscope`,`zemail`,`xunitpur`,`xconversion`,`xunitstk`,`xtypestk`";
				
				$vals = "(" . Session::get('sbizid') . ",'". $keyfieldval ."','". $rownum ."','". $data['xitemcode'] ."','". $data['xitemcode'] ."',
				'". $data['xqty'] ."','". $date ."','". $data['xratepur'] ."','". $data['xwh'] ."','". $data['xwh'] ."','". $data['xwh'] ."','0','0','1','BDT','None','None','".$data['zemail']."','".$item[0]['xunitpur']."','".$item[0]['xconversion']."','".$item[0]['xunitstk']."','".$item[0]['xtypestk']."')";
				
					
				$success = $this->model->create($data, $cols, $vals);
				
				if(empty($success))
					$success=0;
				
				
				}catch(Exception $e){
					
					$this->result = $e->getMessage();
					
				}
				
				if($success>0)
					$this->result = 'Purchase Order Created</br><a style="color:red" id="invnum" href="'.URL.'purchase/printpo/'.$keyfieldval.'">Click To Print Purchase Order - '.$keyfieldval.'</a>';
				
				if($success == 0 && empty($this->result))
					$this->result = "Failed to Create Purchase Order! Reason: Could be Duplicate Trunsaction Code or system error!";
				
				 $this->showentry($keyfieldval, $this->result);
				 
				 
				
		}
		
		public function editpurchase(){
			
			if (empty($_POST['xponum'])){
					header ('location: '.URL.'purchase/purchaseentry');
					exit;
				}
			$result = "";
			
			$hd = array();
			$dt = array();
			
				$yearoffset = Session::get('syearoffset');
				$xdate = $_POST['xdate'];
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
			$ponum = $_POST['xponum'];
			$form = new Form();
				$data = array();
				
				try{
				
				
				$form	->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20)
						
						->post('xponum')	
						
						->post('xsup')
						->val('minlength', 1)
						->val('maxlength', 20)

						->post('xsupname')
						->val('minlength', 1)
						->val('maxlength', 100)						
				
						->post('xwh')
						->val('minlength', 1)
						->val('maxlength', 50)

						->post('xnote')
						->val('maxlength', 1000)
						
						->post('xsupdoc')
						->val('maxlength', 50)
						
						->post('xqty')
						
						->post('xratepur');
						
				$form	->submit();
				
			
				
				$data = $form->fetch();	
				//print_r($data);die;
				$item = $this->model->getItem($data['xitemcode']);
						
				$hd = array (
					"xemail"=>Session::get('suser'),
					"zutime"=>date("Y-m-d H:i:s"),
					"xdate"=>$date,
					"xsup"=>$data['xsup'],
					"xwh"=>$data['xwh'],
					"xbranch"=>$data['xwh'],
					"xproj"=>$data['xwh'],
					"xnote"=>$data['xnote'],
					"xsupdoc"=>$data['xsupdoc'],
					"xfinyear" => $xyear,
					"xfinper" => $xper
					
				);
				
				$dt = array (
					"xitemcode"=>$data['xitemcode'],
					"xqty"=>$data['xqty'],
					"xratepur"=>$data['xratepur'],
					"xwh"=>$data['xwh'],
					"xbranch"=>$data['xwh'],
					"xproj"=>$data['xwh'],
					"xdate"=>$date,
					"xunitpur"=>$item[0]['xunitpur'],
					"xconversion"=>$item[0]['xconversion'],
					"xunitstk"=>$item[0]['xunitstk'],
					"xtypestk"=>$item[0]['xtypestk']
				);
				
				$success = $this->model->edit($hd,$dt,$ponum,$_POST['xrow']);
				
				
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
				
				 $this->showentry($ponum, $result.'<br /><a style="color:red" id="invnum" href="'.URL.'purchase/printpo/'.$ponum.'">Click To Print Voucher - '.$ponum.'</a>');
				
		
		}
		
		public function show($txnnum, $row, $result=""){
		if($txnnum=="" || $row==""){
			header ('location: '.URL.'purchase/purchaseentry');
			exit;
		}
		$tblvalues=array();
		$btn = array(
			"New" => URL."purchase/purchaseentry"
		);
		if($result=="")
			$result='<a style="color:red" id="invnum" href="'.URL.'purchase/printpo/'.$txnnum.'">Click To Print Voucher - '.$txnnum.'</a>';
		
		$tblvalues = $this->model->getPurchase($txnnum);
		$tbldtvals = $this->model->getSinglePurchaseDt($txnnum, $row);
		$status="";
		if(!empty($tblvalues))
			$status = $tblvalues[0]['xstatus']; //echo $status; die;
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					"xdate"=>$tblvalues[0]['xdate'],
					"xponum"=>$tblvalues[0]['xponum'],
					"xsup"=>$tblvalues[0]['xsup'],
					"xsupname"=>$tblvalues[0]['xsupname'],
					"xsupdoc"=>$tblvalues[0]['xsupdoc'],
					"xwh"=>$tblvalues[0]['xwh'],
					"xnote"=>$tblvalues[0]['xnote'],
					"xitemcode"=>$tbldtvals[0]['xitemcode'],
					"xdesc"=>$tbldtvals[0]['xdesc'],
					"xqty"=>$tbldtvals[0]['xqty'],
					"xrow"=>$tbldtvals[0]['xrow'],
					"xratepur"=>$tbldtvals[0]['xratepur']
					);
			
		// form data
			$confurl = array();
			$saveurl = "";
			if($status=="Created"){
				$confurl = array(URL."purchase/confirmpur", "Confirm");
				$saveurl = URL."purchase/editpurchase/";
			}
			if($status=="Confirmed"){
				$confurl = array(URL."purchase/cancelpur", "Cancel");
				$saveurl="";
			}
		$this->view->balance = "";
			
			$dynamicForm = new Dynamicform("Purchase Order", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, $saveurl, "Update",$tblvalues, URL."purchase/showpost");
			
			$this->view->table = $this->renderTable($txnnum);
			
			$this->view->renderpage('purchase/purchaseentry');
		}
		
		
		
		public function showentry($txnnum, $result=""){
		
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."purchase/purchaseentry"
		);
		if($result=="")
			$result='<a style="color:red" id="invnum" href="'.URL.'purchase/printpo/'.$txnnum.'">Click To Print Voucher - '.$txnnum.'</a>';
		$tblvalues = $this->model->getPurchase($txnnum);
		$status="";
		if(!empty($tblvalues))
			$status = $tblvalues[0]['xstatus'];
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					"xdate"=>$tblvalues[0]['xdate'],
					"xponum"=>$tblvalues[0]['xponum'],
					"xsup"=>$tblvalues[0]['xsup'],
					"xsupname"=>$tblvalues[0]['xsupname'],
					"xsupdoc"=>$tblvalues[0]['xsupdoc'],
					"xwh"=>$tblvalues[0]['xwh'],
					"xnote"=>$tblvalues[0]['xnote'],
					"xitemcode"=>"",
					"xdesc"=>"",
					"xqty"=>"0",
					"xrow"=>"0",
					"xratepur"=>"0"
					);
			$this->view->balance = "";
			//print_r($tblvalues); die;
			$dynamicForm = new Dynamicform("Purchase", $btn, $result);		
			$confurl = array();
			$saveurl = "";
			if($status=="Created"){
				$confurl = array(URL."purchase/confirmpur", "Confirm");
				$saveurl = URL."purchase/savepurchase/";
			}
			if($status=="Confirmed"){
				$confurl = array(URL."purchase/cancelpur", "Cancel");
				$saveurl="";
			}
			$this->view->dynform = $dynamicForm->createForm($this->fields, $saveurl, "Save",$tblvalues ,URL."purchase/showpost",$confurl);
			
			$this->view->table = $this->renderTable($txnnum);
			
			$this->view->renderpage('purchase/purchaseentry');
		}
		
		public function confirmpur(){
			
			$this->model->confirm(" bizid=".Session::get('sbizid')." and xponum='".$_POST['xponum']."' and xstatus='Created'");
			$this->showentry($_POST['xponum']);
		}

		public function cancelpur(){
			
			$this->model->cancel(" bizid=".Session::get('sbizid')." and xponum='".$_POST['xponum']."' and xstatus='Confirmed'");
			$this->showentry($_POST['xponum']);
		}
		
		function renderTable($txnnum){

			$pur = $this->model->getPurchase($txnnum);
			$status = "";
			if(!empty($pur))
				$status = $pur[0]["xstatus"];
			
			$delbtn = "";
			if(count($pur)>0){
			if($pur[0]["xstatus"]=="Created")
				$delbtn = URL."purchase/recdelete/".$txnnum."/";
				
			}
			
			$row = $this->model->getvpodt($txnnum);
			
			$table = '<table class="table table-striped table-bordered">';
				$table .='<thead>
							<th></th><th></th><th>Sl.</th><th>Itemcode</th><th>Description</th><th style="text-align:right">Rate</th><th style="text-align:right">Qty</th><th>UOM</th><th style="text-align:right">Total</th>
						</thead>';
						$totalqty = 0;
						$total = 0;
						$totaltax = 0;
						$totaldisc = 0;
						$table .='<tbody>';

						foreach($row as $key=>$val){
							$showurl = URL."purchase/show/".$txnnum."/".$val['xrow'];
							$table .='<tr>';
							
							$table.='<td><a class="btn btn-info" id="btnshow" href="'.$showurl.'" role="button">Show</a></td>';
							if($delbtn!="")
								$table.='<td><a id="delbtn" class="btn btn-danger" href="'.$delbtn."/".$val['xrow'].'" role="button">Delete</a></td>';
							else
								$table.='<td></td>';

								$table .= "<td>".$val['xrow']."</td>";
								$table .= "<td>".$val['xitemcode']."</td>";
								$table .= "<td>".$val['xitemdesc']."</td>";
								$table .='<td align="right">'.$val['xratepur'].'</td>';		
								$table .='<td align="right">'.$val['xqty'].'</td>';
								$table .='<td>'.$val['xunitpur'].'</td>';
								//$table .='<td align="right">'.$val['xtaxtotal'].'</td>';
								//$table .='<td align="right">'.$val['xdisctotal'].'</td>';
								$subtotal = $val['xtotal']+$val['xtotaltax']-$val['xtotaldisc'];
								$table .='<td align="right">'.$subtotal.'</td>';
								$total+=$subtotal;
								$totalqty+=	$val['xqty'];
								//$totaltax +=$val['xtaxtotal'];
								//$totaldisc+= $val['xdisctotal'];
								
							$table .="</tr>";
						}
							$table .='<tr><td align="right" colspan="6"><strong>Total</strong></td><td align="right"><strong>'.$totalqty.'</strong></td><td></td><td align="right"><strong>'.$total.'</strong></td></tr>';
							/*$net=0;
							if(!empty($row)){
								$table .='<tr><td align="right" colspan="8"><strong>Fixed Discount</strong></td><td align="right"><strong>'.$row[0]["xgrossdisc"].'</strong></td></tr>';
								
								//$net = $total-$row[0]["xgrossdisc"];
							}
							$table .='<tr><td align="right" colspan="8"><strong>Net Total</strong></td><td align="right"><strong>'.$net.'</strong></td></tr>';*/
							 	
					$table .="</tbody>";			
			$table .= "</table>";
			
			return $table;
			
			/*$pur = $this->model->getPurchase($txnnum);
			$status = "";
			if(!empty($pur))
				$status = $pur[0]["xstatus"];
			
			$delurl = URL."purchase/recdelete/".$txnnum."/";
			
			if($status=="Confirmed")
			{
				$delurl="";
			}			
			
			$fields = array(
						"xrow-Sl",
						"xitemcode-Item Code",
						"xitemdesc-Description",
						"xqty-Quantity",
						"xratepur-Rate",
						"xtotal-Total"
						);
			$table = new Datatable();
			$row = $this->model->getpurchasedt($txnnum);
			
			return $table->myTable($fields, $row, "xrow", URL."purchase/show/".$txnnum."/", $delurl);
			*/
			
		}
		
		
		function polist(){
			$rows = $this->model->getPurchaseList("Confirmed");
			$cols = array("xdate-Date","xponum-PO No","xsup-Supplier","xsupname-Name","xsupdoc-DO NO");
			$table = new Datatable();
			$this->view->table = $table->createTable($cols, $rows, "xponum",URL."purchase/showentry/");
			$this->view->renderpage('purchase/purchaselist', false);
		}
		function unconfirmedlist(){
			$rows = $this->model->getPurchaseList("Created");
			$cols = array("xdate-Date","xponum-PO No","xsup-Supplier","xsupname-Name","xsupdoc-DO NO");
			$table = new Datatable();
			$this->view->table = $table->createTable($cols, $rows, "xponum",URL."purchase/showentry/");
			$this->view->renderpage('purchase/purchaselist', false);
		}
		
		function purchaseentry(){
				
		$btn = array(
			"Clear" => URL."purchase/purchaseentry"
		);

		// form data
		$this->view->balance = "";
		
			$dynamicForm = new Dynamicform("Purchase Order",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."purchase/savepurchase", "Save",$this->values, URL."purchase/showpost");
			
			
			$this->view->table = $this->renderTable("");
			
			$this->view->renderpage('purchase/purchaseentry', false);
		}
		
		
		public function showpost(){
		//echo 123;die;
		$txnnum = $_POST['xponum'];
			
		$tblvalues=array();
		
		$btn = array(
			"New" => URL."purchase/purchaseentry"
		);
		
		$tblvalues = $this->model->getPurchase($txnnum);
		$status="";
		if(!empty($tblvalues))
			$status = $tblvalues[0]['xstatus'];
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					"xdate"=>$tblvalues[0]['xdate'],
					"xponum"=>$tblvalues[0]['xponum'],
					"xsup"=>$tblvalues[0]['xsup'],
					"xsupname"=>$tblvalues[0]['xsupname'],
					"xsupdoc"=>$tblvalues[0]['xsupdoc'],
					"xwh"=>$tblvalues[0]['xwh'],
					"xnote"=>$tblvalues[0]['xnote'],
					"xitemcode"=>"",
					"xdesc"=>"",
					"xqty"=>"0",
					"xrow"=>"0",
					"xratepur"=>"0"
					);
			
		
			
		// form data
			$this->view->balance = "";
			
			$dynamicForm = new Dynamicform("Purchase Order", $btn,'<a style="color:red" id="invnum" href="'.URL.'purchase/printpo/'.$txnnum.'">Click To Print Purchase Order - '.$txnnum.'</a>');
			$confurl = array();
			$saveurl = "";
			if($status=="Created"){		
				$confurl = array(URL."purchase/confirmpur", "Confirm");
				$saveurl = URL."purchase/savepurchase/";
			}
			if($status=="Confirmed"){
				$confurl = array(URL."purchase/cancelpur", "Cancel");
				$saveurl="";
			}
			$this->view->dynform = $dynamicForm->createForm($this->fields, $saveurl, "Save",$tblvalues ,URL."purchase/showpost",$confurl);
			
			$this->view->table = $this->renderTable($txnnum);
			
			$this->view->renderpage('purchase/purchaseentry');
		}
		function recdelete($ponum, $row){
			$grn = $this->model->getPurchase($ponum);
			$status = "";
			if(!empty($grn))
				$status = $grn[0]["xstatus"];
			if($status=="Created")
				$this->model->recdelete(" WHERE xponum='".$ponum."' and xrow=".$row);
			
			$this->showentry($ponum);
		}
		function printpo($pono=""){
			
			$values = $this->model->getvpodt($pono);
			//print_r($values);die;
			$this->view->breadcrumb = '<ul class="breadcrumb">
							<li>Purchase Order</li>							
						   </ul>';
			
			$this->view->pono=$pono;
			$totqty = 0;
			$total = 0;
			$xdate="";
			$supplier="";
			$supadd="";
			$supphone="";
			$supdoc="";
			$note = "";
			
			foreach($values as $key=>$val){
				$xdate=$val['xdate'];
				$supplier=$val['xorg'];
				$supadd=$val['xsupadd'];
				$supphone=$val['xsupphone'];
				$supdoc=$val['xsupdoc'];
				$note=$val['xnote'];
				$totqty+=$val['xqty'];
				$total+=$val['xtotal'];
			}
			$this->view->xdate=$xdate;
			$this->view->supplier=$supplier;
			$this->view->supadd=$supadd;
			$this->view->supphone=$supphone;
			$this->view->supdoc=$supdoc;			
			$this->view->totqty=$totqty;
			$this->view->total=$total;
			$this->view->note=$note;
			
			$cur = new Currency();
			$this->view->inword="In Words: ". $cur->get_bd_amount_in_text($total);
			$this->view->vrow = $values;
			
			$this->view->vrptname = "Purchase Order";
			$this->view->org=Session::get('sbizlong');
			
			$this->view->renderpage('purchase/printpurchase');		
		}
}