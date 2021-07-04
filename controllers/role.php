<?php 
class Role extends Controller{
	public $menus=array();
	function __construct(){
		parent::__construct();
		Session::init();
		$logged = Session::get('loggedIn');
			if($logged == false){
				Session::destroy();
				header('location: '.URL.'login');
				exit;
			}
		// session menu management
		$usersessionmenu = 	Session::get('mainmenus');
		
		$iscode=0;
		foreach($usersessionmenu as $menus){
				if($menus["xsubmenu"]=="Role Management")
					$iscode=1;							
		}
		if($iscode==0)	
			header('location: '.URL.'mainmenu');
		// session menu management ENDS
		
			$this->menus=array(
					array(
					"menu"=>"Inbox",
					"submenu"=>"Delivery Information",
					"url"=>"distdelinfo",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Inbox",
					"submenu"=>"Office Notice",
					"url"=>"#",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Inbox",
					"submenu"=>"Team Communication",
					"url"=>"#",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Inventory",
					"submenu"=>"Stock Transfer",
					"url"=>"diststocktransfer",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Inventory",
					"submenu"=>"Delivery Return",
					"url"=>"imreturn",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Inventory",
					"submenu"=>"Inventory Reports",
					"url"=>"imrpt",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Inventory",
					"submenu"=>"Stock",
					"url"=>"imstock",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Interface",
					"submenu"=>"GL Sales Interface",
					"url"=>"glinterface/index/GL Sales Interface",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Interface",
					"submenu"=>"Sales Separate Interface",
					"url"=>"glinterface/index/Sales Separate Interface",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Interface",
					"submenu"=>"GL GRN Interface",
					"url"=>"glinterface/index/GL GRN Interface",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Interface",
					"submenu"=>"GL DO Interface",
					"url"=>"glinterface/index/GL DO Interface",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Interface",
					"submenu"=>"DO Return Interface",
					"url"=>"glinterface/index/DO Return Interface",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Interface",
					"submenu"=>"PO Return Interface",
					"url"=>"glinterface/index/PO Return Interface",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Interface",
					"submenu"=>"Installment Interface",
					"url"=>"glinterface/index/Installment Interface",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Interface",
					"submenu"=>"Commission Interface",
					"url"=>"glinterface/index/Commission Interface",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Prelaunch",
					"submenu"=>"Pre Retailer Registration",
					"url"=>"distregtemp",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Prelaunch",
					"submenu"=>"Prelaunch Placement",
					"url"=>"distjointemp",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Team Operation",
					"submenu"=>"4 Retailer Registration",
					"url"=>"distreg",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Team Operation",
					"submenu"=>"7 Wallet",
					"url"=>"distwallet",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Team Operation",
					"submenu"=>"6 Placement",
					"url"=>"distjoin",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Team Operation",
					"submenu"=>"5 Retailer Tree",
					"url"=>"disttree",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Team Operation",
					"submenu"=>"3 Customer",
					"url"=>"customers",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Team Operation",
					"submenu"=>"1 Product List",
					"url"=>"itempicklist",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Team Operation",
					"submenu"=>"2 Customer From RIN",
					"url"=>"customertemp",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Team Operation",
					"submenu"=>"8 Withdrawal Request",
					"url"=>"distwithdraw",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Team Operation",
					"submenu"=>"9 Balance Transfer",
					"url"=>"distbaltransfer",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"Customer Master",
					"url"=>"customers",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"Agent Entry",
					"url"=>"agent",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"Releted Customer Entry",
					"url"=>"relcustomers",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"Supplier Master",
					"url"=>"suppliers",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Core Settings",
					"submenu"=>"BC Transfer",
					"url"=>"distbcchange",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Core Settings",
					"submenu"=>"Reference Update",
					"url"=>"distrefupdate",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Core Settings",
					"submenu"=>"Send Commission SMS",
					"url"=>"distcomsms",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Core Settings",
					"submenu"=>"Tax Setup",
					"url"=>"taxcode",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"Outlet Setup",
					"url"=>"supoutlet",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"Item Master",
					"url"=>"items",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"RIN Update",
					"url"=>"distregupdate",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"Sales Reports",
					"url"=>"salesrpt",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"Transfer",
					"url"=>"transfer",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"Customer Update",
					"url"=>"customerupdate",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Core Settings",
					"submenu"=>"Customer Separate",
					"url"=>"customerseparate",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Purchase",
					"submenu"=>"Confirm Delivery",
					"url"=>"supundel/confirmdel",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Purchase",
					"submenu"=>"Purchase Return",
					"url"=>"purchasereturn",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Purchase",
					"submenu"=>"Purchase Cost",
					"url"=>"purchasecost",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Purchase",
					"submenu"=>"International Purchase",
					"url"=>"purchaseint",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Purchase",
					"submenu"=>"Purchase Order",
					"url"=>"purchase",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Purchase",
					"submenu"=>"PO Requisition",
					"url"=>"distreq",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Purchase",
					"submenu"=>"Goods Receive Note",
					"url"=>"purchasegrn",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Purchase",
					"submenu"=>"PO Reports",
					"url"=>"porpt",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Production",
					"submenu"=>"Bill Of Material",
					"url"=>"pmbom",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Production",
					"submenu"=>"Finished Goods Receive",
					"url"=>"pmfgr",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Production",
					"submenu"=>"BOM Other Cost",
					"url"=>"pmbomcost",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Sales",
					"submenu"=>"Sales Order",
					"url"=>"sales",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Sales",
					"submenu"=>"OSP POS",
					"url"=>"posentry",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Sales",
					"submenu"=>"Corporate POS",
					"url"=>"posentrycorp",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Sales",
					"submenu"=>"Delivery Order",
					"url"=>"imreqdo",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Sales",
					"submenu"=>"Sales Quotation",
					"url"=>"salesquot",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Installment",
					"submenu"=>"Installment Schedule",
					"url"=>"installment",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Installment",
					"submenu"=>"Installment Collection",
					"url"=>"installmentcollection",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Installment",
					"submenu"=>"Salesman Target",
					"url"=>"salesmantarget",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Installment",
					"submenu"=>"Installment Reports",
					"url"=>"installmentreport",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Installment",
					"submenu"=>"Commission Paid",
					"url"=>"commissionpaid",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Installment",
					"submenu"=>"All Installment Reports",
					"url"=>"allinsrpt",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Reports",
					"submenu"=>"Sales Summary Report",
					"url"=>"salessumaryreport",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Reports",
					"submenu"=>"Sales Detail Report",
					"url"=>"salesdetail",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Reports",
					"submenu"=>"Business Analysis",
					"url"=>"chartsales",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Reports",
					"submenu"=>"Sales Report",
					"url"=>"salesreport",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Reports",
					"submenu"=>"Sales Return Report",
					"url"=>"salesreturnreport",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Salesman",
					"url"=>"code/index/Salesman",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Item Category",
					"url"=>"code/index/Item Category",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Project",
					"url"=>"code/index/Project",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"GL Prefix",
					"url"=>"code/index/GL Prefix",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Color",
					"url"=>"code/index/Color",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"BOM Cost Head",
					"url"=>"code/index/BOM Cost Head",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Customer Type",
					"url"=>"code/index/Customer Type",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Customer Prefix",
					"url"=>"code/index/Customer Prefix",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Currency",
					"url"=>"code/index/Currency",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"PO Cost Head",
					"url"=>"code/index/PO Cost Head",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Item Size",
					"url"=>"code/index/Item Size",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Item Prefix",
					"url"=>"code/index/Item Prefix",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Supplier Prefix",
					"url"=>"code/index/Supplier Prefix",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Item Brand",
					"url"=>"code/index/Item Brand",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Bank",
					"url"=>"code/index/Bank",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"UOM",
					"url"=>"code/index/UOM",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"IM Receive Prefix",
					"url"=>"code/index/IM Receive Prefix",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"IM Transfer Prefix",
					"url"=>"code/index/IM Transfer Prefix",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Purchase Prefix",
					"url"=>"code/index/Purchase Prefix",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Sales Prefix",
					"url"=>"code/index/Sales Prefix",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Warehouse",
					"url"=>"code/index/Warehouse",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Branch",
					"url"=>"code/index/Branch",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Month",
					"url"=>"code/index/Month",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Religion",
					"url"=>"code/index/Religion",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Code Settings",
					"submenu"=>"Commission Type",
					"url"=>"code/index/Commission Type",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"User Roles",
					"submenu"=>"User Management",
					"url"=>"user",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"User Roles",
					"submenu"=>"Role Management",
					"url"=>"role",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Settings",
					"submenu"=>"Chart Of Acc",
					"url"=>"glchart",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Settings",
					"submenu"=>"Sub Account",
					"url"=>"glchartsub",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"GL Settings",
					"submenu"=>"Acc Level1",
					"url"=>"code/index/Acc Level1",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"GL Settings",
					"submenu"=>"Acc Level2",
					"url"=>"code/index/Acc Level2",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"GL Settings",
					"submenu"=>"Acc Level3",
					"url"=>"code/index/Acc Level3",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"Balance Receive",
					"url"=>"distbal",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"JV Single Entry",
					"url"=>"gljvsingle",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"Cash Payment",
					"url"=>"distcashnbankpay",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"Cheque Register",
					"url"=>"glchequeregister",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"Journal Voucher",
					"url"=>"gljvvou",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"Payment Voucher",
					"url"=>"glpayvou",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"Trade Receipt",
					"url"=>"glrcptvoutrade",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"Trade Payment",
					"url"=>"glrpayvoutrade",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"Opening Balance",
					"url"=>"glopening",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"Receipt Voucher",
					"url"=>"glrcptvou",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Gneneral Ledger",
					"submenu"=>"GL Reports",
					"url"=>"glrpt",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"SMS",
					"submenu"=>"Send SMS",
					"url"=>"smsparents",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"SMS",
					"submenu"=>"Individual SMS",
					"url"=>"smsindividual",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"SMS",
					"submenu"=>"Class Wise SMS",
					"url"=>"smscls",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"SMS",
					"submenu"=>"Auto Message Entry",
					"url"=>"autosms",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Operation",
					"submenu"=>"Ordered List",
					"url"=>"supundel",
					"menutype"=>"Main Menu"
				),array(
					"menu"=>"Operation",
					"submenu"=>"Delivered List",
					"url"=>"supundel/undel",
					"menutype"=>"Main Menu"
				),
				array(
					"menu"=>"Reports",
					"submenu"=>"Reports",
					"url"=>"oglrpt",
					"menutype"=>"Main Menu"
				)
				
			);
		//add page related java scripts/jquery in array. Only rendered on this page load	
		$this->view->js = array('public/js/datatable.js','views/codes/js/codevalidator.js');
		}
		public function index(){
			
			$head=array("Menu","Submenu","URL","Menu Type");
			$table = new Datatable();
			
			$fields = array("zrole-Roles");
			
			$rows=$this->model->getRoles();
			
			$this->view->roles = $table->myTable($fields,$rows,"zrole", URL."role/editrole/", URL."role/roledelete/");
			
			$this->view->tblmenus = $table->arrayTable($head, $this->menus, "Create Role", URL."role/create");
			$this->view->message = "";
			$this->view->rendermainmenu('role/index');	
			
			//print_r($menus);
			//die;
		}
		
		public function create(){
			$menupost=array();
			$this->view->message = "";
			$role=$_POST['zrole'];
			$cols="`bizid`,`zrole`,`xmenu`,`xsubmenu`,`xurl`,`xmenutype`";
			
			if(isset($_POST["checkbox"])){
				
				
			foreach ($_POST["checkbox"] as $checkitem){
				
				foreach($this->menus as $menuarr){
					if($checkitem==$menuarr["submenu"]){
						$menupost[]=$menuarr;
					}
				}
			}
			
			$str="";
			
				for($i=0; $i<count($menupost); $i++){
					$query_parts[] = "('" . Session::get('sbizid') . "','" . $role . "','" . $menupost[$i]['menu'] . "', '" . $menupost[$i]['submenu'] . "', '" . $menupost[$i]['url'] . "', '" . $menupost[$i]['menutype'] . "'),";
					
				}
			
				foreach ($query_parts as $key=>$value){
					$str.=$value;
				}
				
				
				$form = new Form();
				$data = array();
				
				try{
				$form	->post('zrole')
						->val('minlength', 1)
						->val('maxlength', 50);
						
												
				$form	->submit();
				
				$data = $form->fetch();	
				
				$data['bizid'] = Session::get('sbizid');
								
				$success = $this->model->create($data,"pamenus",$cols,rtrim($str,','));
						
				
				}catch(Exception $e){
					
					$this->view->message = $e->getMessage();
					
				}
				
			}else{
				$this->view->message = "Please select menus bellow...";
			}
			
			//$this->editrole($role);
			$this->showRoleMenus();
		}
		
		public function showRoleMenus(){
			
			$table = new Datatable();
			
			$fields = array("zrole-Roles");
			
			$rows=$this->model->getRoles();
			
			$this->view->roles = $table->myTable($fields,$rows,"zrole", URL."role/editrole/", URL."role/roledelete/");
			
			$head=array("Menu","Submenu","URL","Menu Type");
			
			
			$this->view->tblmenus = $table->arrayTable($head, $this->menus, "Create Role", URL."role/create");
			
			
			
			$this->view->rendermainmenu('role/index');	
		}
		
		public function editrole($role){
			
			$usermenus = $this->model->getUserMenus($role);
			
			$head=array("Menu","Submenu","URL","Menu Type");
			$table = new Datatable();
			
			$fields = array("zrole-Roles");
			
			$rows=$this->model->getRoles();
			
			$this->view->roles = $table->myTable($fields,$rows,"zrole", URL."role/editrole/", URL."role/roledelete/");
			
			$this->view->tblmenus = $table->arrayTable($head, $this->menus,"Update Role", URL."role/edit/".$role,$role, $usermenus);
			$this->view->message = "";
			$this->view->roletoedit = $role;
			$this->view->rendermainmenu('role/index');	
						
		}
		
		public function edit($role=""){
			
			$menupost=array();
			$cols="`bizid`,`zrole`,`xmenu`,`xsubmenu`,`xurl`,`xmenutype`";
			
			if(isset($_POST["checkbox"]) && isset($_POST['zrole'])){
			foreach ($_POST["checkbox"] as $checkitem){
				
				foreach($this->menus as $menuarr){
					if($checkitem==$menuarr["submenu"]){
						$menupost[]=$menuarr;
					}
				}
			}
			$str="";
			
				for($i=0; $i<count($menupost); $i++){
					$query_parts[] = "('" . Session::get('sbizid') . "','" . $role . "','" . $menupost[$i]['menu'] . "', '" . $menupost[$i]['submenu'] . "', '" . $menupost[$i]['url'] . "', '" . $menupost[$i]['menutype'] . "'),";
					
				}
			
				foreach ($query_parts as $key=>$value){
					$str.=$value;
				}
			$where = " where bizid=".Session::get('sbizid')." and zrole='".$role."'";	
			$editresult=$this->model->edit("pamenus",$cols,rtrim($str,','),$where);
			}
			$this->editrole($role);
		}
		
		public function roledelete($role){
			$where = "bizid=".Session::get('sbizid')." and zrole='".$role."'";
			$this->model->delete($where);
			$this->view->message = "";
			$this->showRoleMenus();
		}
			
}