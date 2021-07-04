<?php
class Jsondata extends Controller{
	
	
	
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
		
			if(empty($usersessionmenu)){
				header('location: '.URL.'mainmenu');
			}
		$this->view->js = array('public/js/datatable.js','views/suppliers/js/codevalidator.js');	
		}
		
		function getItemNamePrice($xitemcode){
			$this->model->getItemInfoForSale("xitemcode",$xitemcode);
		}
		
		function getpoint($cus){
			if ($this->model->isMyCus($cus)){
				$this->model->getPoint($cus);
			}
			
		}
		
		function getStock($itemcode,$wh){
			$this->model->getItemStock($itemcode, $wh);
		}
		
		function getcustomer($cus){
			$this->model->getCustomer($cus);
		}
		function getcustomerbal($cus){
			$this->model->getCustomerBal($cus);
		}
		function getagent($agent){
			$this->model->getagent($agent);
		}
		function getitemdt($item){
			$this->model->getitemdt($item);
		}
		function getsupplier($sup){
			$this->model->getSupplier($sup);
		}
		function inforindt($rin){
			$this->model->getInfoRinDetail($rin);
		}
		
		function customerpicklist(){
			$this->view->table = $this->customerPickTable();
			
			$this->view->renderpage('customers/customerpicklist', false);
		}
		
		function customerPickTable(){
			$fields = array(
						"xcus-Supplier Code",
						"xorg-Organization/Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xcusemail-Email"
						);
			$table = new Datatable();
			$row = $this->model->getCustomersByLimit();
			
			return $table->picklistTable($fields, $row, "xcus");
		}

		function agentpicklist(){
			$this->view->table = $this->agentPickTable();
			
			$this->view->renderpage('agent/customerpicklist', false);
		}
		
		function agentPickTable(){
			$fields = array(
						"xagent-Agent Code",
						"xshort-Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xcusemail-Email"
						);
			$table = new Datatable();
			$row = $this->model->getAgentByLimit();
			
			return $table->picklistTable($fields, $row, "xagent");
		}
		
		function customercrpicklist(){
			$this->view->table = $this->customercrPickTable();
			
			$this->view->renderpage('customers/customerpicklist', false);
		}
		
		function customercrPickTable(){
			$fields = array(
						"xcuscr-Supplier Code",
						"xorg-Organization/Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xcusemail-Email"
						);
			$table = new Datatable();
			$row = $this->model->getcrCustomersByLimit();
			
			return $table->picklistTable($fields, $row, "xcuscr");
		}
		
		function supplierpicklist(){
			$this->view->table = $this->supplierPickTable();
			
			$this->view->renderpage('suppliers/supplierpicklist', false);
		}
		
		function supplierPickTable(){
			$fields = array(
						"xsup-Supplier Code",
						"xorg-Organization/Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xsupemail-Email"
						);
			$table = new Datatable();
			$row = $this->model->getSuppliersByLimit();
			
			return $table->picklistTable($fields, $row, "xsup");
		}
		
		function suppliercrpicklist(){
			$this->view->table = $this->suppliercrPickTable();
			
			$this->view->renderpage('suppliers/supplierpicklist', false);
		}
		
		function suppliercrPickTable(){
			$fields = array(
						"xsupcr-Supplier Code",
						"xorg-Organization/Name",
						"xadd1-Address",
						"xmobile-Mobile",
						"xsupemail-Email"
						);
			$table = new Datatable();
			$row = $this->model->getcrSuppliersByLimit();
			
			return $table->picklistTable($fields, $row, "xsupcr");
		}
		
		function purchasepicklist(){
			$this->view->table = $this->purchasePickTable();
			
			$this->view->renderpage('customers/customerpicklist', false);
		}
		
		function purchasePickTable(){
			$fields = array(
						"xdate-Date",
						"xponum-PO",
						"xsup-Supplier",
						"xsupname-Org/Name",
						"xsupdoc-Document"
						);
			$table = new Datatable();
			$row = $this->model->getPurchaseList();
			
			return $table->picklistTable($fields, $row, "xponum");
		}
		
		function outletbysuppick($sup){
			
			$this->view->table = $this->outletSupPickTable($sup);
			$this->view->caption = "Outlet List";
			$this->view->renderpage('items/itempicklist', false);
		}
		
		function outletSupPickTable($sup){			
			$fields = array(
						"xoutlet-Outlet Code",
						"xdesc-Description",
						"xadd1-Address"
						);
			$table = new Datatable();
			$row = $this->model->getoutletbysup($sup);
			
			return $table->picklistTable($fields, $row, "xoutlet");
		}

		//GL List Area

		function glchartpicklistcr(){
			$this->view->table = $this->glchartPickTablecr();
			
			$this->view->renderpage('glchart/glchartpicklistcr', false);
		}
		
		
		function glchartpicklist(){
			$this->view->table = $this->glchartPickTable();
			
			$this->view->renderpage('glchart/glchartpicklist', false);
		}

		function glchartpicklistsub(){
			$this->view->table = $this->glchartPickTableSub();
			
			$this->view->renderpage('glchart/glchartpicklist', false);
		}
		
		function glchartpicklistexp(){
			$this->view->table = $this->glchartPickTableexp();
			
			$this->view->renderpage('glchart/glchartpicklist', false);
		}
		
		function glchartpicklistinc(){
			$this->view->table = $this->glchartPickTableinc();
			
			$this->view->renderpage('glchart/glchartpicklist', false);
		}
		
		function glchartPickTablecr(){
			$fields = array(
						"xacccr-Account Code",
						"xdesc-Account Description",
						"xacctype-Account Type",
						"xaccusage-Use Of The Account",
						"xaccsource-Account Source"
						);
			$table = new Datatable();
			$row = $this->model->getGlchartcrByLimit();
			
			return $table->picklistTable($fields, $row, "xacccr");
		}
		
		function glchartPickTable(){
			$fields = array(
						"xacc-Account Code",
						"xdesc-Account Description",
						"xacctype-Account Type",
						"xaccusage-Use Of The Account",
						"xaccsource-Account Source"
						);
			$table = new Datatable();
			$row = $this->model->getGlchartByLimit();
			
			return $table->picklistTable($fields, $row, "xacc");
		}
		function glchartPickTableSub(){
			$fields = array(
						"xacc-Account Code",
						"xdesc-Account Description",
						"xacctype-Account Type",
						"xaccusage-Use Of The Account",
						"xaccsource-Account Source"
						);
			$table = new Datatable();
			$row = $this->model->getGlchartsubByLimit();
			
			return $table->picklistTable($fields, $row, "xacc");
		}
		function glchartPickTableexp(){
			$fields = array(
						"xacc-Account Code",
						"xdesc-Account Description",
						"xacctype-Account Type",
						"xaccusage-Use Of The Account",
						"xaccsource-Account Source"
						);
			$table = new Datatable();
			$row = $this->model->getGlchartexpByLimit();
			
			return $table->picklistTable($fields, $row, "xacc");
		}
		
		function glchartPickTableinc(){
			$fields = array(
						"xacc-Account Code",
						"xdesc-Account Description",
						"xacctype-Account Type",
						"xaccusage-Use Of The Account",
						"xaccsource-Account Source"
						);
			$table = new Datatable();
			$row = $this->model->getGlchartincByLimit();
			
			return $table->picklistTable($fields, $row, "xacc");
		}
}