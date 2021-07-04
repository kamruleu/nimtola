<?php
class Imstock extends Controller{
	
	private $values = array();
	private $fields = array();
	private $valuesdt = array();
	private $fieldsdt = array();
	
	
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
				if($menus["xsubmenu"]=="Stock")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
		
		
			
		$this->view->js = array('public/js/datatable.js');
		
		
		}
		
		public function index(){
			
			$this->view->table = $this->renderTable();
			
			$this->view->rendermainmenu('imstock/index');	
		}
		
		
		function renderTable($branch=""){
			$fields = array(
						"xwh-Warehouse",
						"xitemcode-Item Code",
						"xdesc-Item Description",						
						"xqtypo-PO",
						"xqty-Stock",
						"xqtyso-Sales Order"
						);
			$table = new Datatable();
			$row = $this->model->getImStock($branch);
			//print_r($row); die;
			return $table->createTable($fields, $row, "xitemcode");
			
			
		}
		
		
		function picklist(){
			$this->view->table = $this->imstockPickTable();
			
			$this->view->renderpage('imstock/picklist', false);
		}
		
		function imstockPickTable(){
			
			$fields = array(
						"xwh-Warehouse",
						"xitemcode-Item Code",
						"xdesc-Item Description",						
						"xqtypo-PO",
						"xqty-Stock",
						"xqtyreq-Demand"
						);
			$table = new Datatable();
			$row = $this->model->getItemList(" and xbranch = '". Session::get('sbranch') ."'");
			
			return $table->picklistTable($fields, $row, "xitemcode");
		}
		
				
}