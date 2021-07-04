<?php
class Autosms extends Controller{
	
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
				if($menus["xsubmenu"]=="Auto Message Entry")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/studentmst/js/codevalidator.js');
		$dt = date("Y/m/d");
		$this->values = array(
			"smsbody"=>"",
			"xsmsfor"=>"",
			"xactive"=>"1",
			"xsl"=>"0"
			);
			
			$this->fields = array(	
						array(
							"smsbody-textarea"=>'Message_maxlength="1000"'
							),
						array(
							"xsmsfor-select_Message For"=>'Message For_maxlength="50"',
							"xactive-checkbox_1"=>'Active?_""'
							),
						array(
							"xsl-hidden"=>'_""'
							)
						);
		
		}
		
		public function index(){
			
			$this->view->rendermainmenu('autosms/index');
			
		}
		
		public function savesms(){
								
				$form = new Form();
				$data = array();
				$success=0;
				$result = "";
				
				try{				
								
				$form	->post('smsbody')
						->val('minlength', 1)
						->val('maxlength', 500)

						->post('xsmsfor')
						->val('minlength', 1)
						->val('maxlength', 50)

						->post('xactive');
												
						
				$form	->submit();
				
				$data = $form->fetch();
				
				$data['bizid'] = Session::get('sbizid');
				$data['zemail'] = Session::get('suser');
				$data['xbranch'] = Session::get('sbranch');
				//print_r($data);die;				
				$success = $this->model->create($data);
				
				if(empty($success))
					$success=0;
				
				
				}catch(Exception $e){
					
					$this->result = $e->getMessage();
					
				}
				
				if($success>0){
					$this->result = "Message saved successfully";			
					
				}
				
				if($success == 0 && empty($this->result))
					$this->result = "Failed to save Message!";
				
				 $this->showentry($success, $this->result);				 
				
		}
		
		public function showentry($sl, $result=""){
		
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."autosms/smsentry"
		);
		
		$tblvalues = $this->model->getSingleSms($sl);
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=$tblvalues[0];
			
		
			$dynamicForm = new Dynamicform("Message", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."autosms/editsms", "Update",$tblvalues);
			
			$this->view->table = $this->renderTable();
			
			$this->view->renderpage('autosms/smsentry');
		}
		
		
		
		
		function renderTable(){
			$fields = array(
						"xsl-Serial",
						"smsbody-Message",
						"xsmsfor-Message For",
						"xactive-Active"
						);
			$table = new Datatable();
			$row = $this->model->getSmsByLimit(" LIMIT 5");
			
			return $table->myTable($fields, $row, "xsl", URL."autosms/showentry/");
			
			
		}
		
		
		function smsentry(){
				
		$btn = array(
			"Clear" => URL."autosms/smsentry"
		);

		//  form data
		
			$dynamicForm = new Dynamicform("Message",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."autosms/savesms", "Save",$this->values);
			
			$this->view->table = $this->renderTable();
			
			$this->view->renderpage('autosms/smsentry', false);
		}
		
		public function editsms(){
			
			$sl = $_POST['xsl'];
			$result = "";
			
			$success=false;
			$form = new Form();
				$data = array();
				
				try{
			
				$form	->post('smsbody')
						->val('minlength', 1)
						->val('maxlength', 500)

						->post('xsmsfor')
						->val('minlength', 1)
						->val('maxlength', 50)

						->post('xactive');
						
				$form	->submit();
				
				$data = $form->fetch();	
				//print_r($data);die;
				
				$data['bizid'] = Session::get('sbizid');
				$data['zemail'] = Session::get('suser');
				$data['zutime'] = date("Y-m-d H:i:s");
				$success = $this->model->editSms($data, $sl);
				
				
				}catch(Exception $e){
					//echo $e->getMessage();die;
					$result = $e->getMessage();
					
				}
				if($result==""){
				if($success){
					$result = "Edited successfully";
				}
				else
					$result = "Edit failed!";
				
				}
				 $this->showentry($sl, $result);
				
		
		}
		function smslist(){
			$this->view->table = $this->SmsTable();
			
			$this->view->renderpage('autosms/smslist', false);
		}
		
		function SmsTable(){
			$fields = array(
						"xsl-SMS ID",
						"smsbody-Message",
						"xsmsfor-Message For",
						"xactive-Active?"
						);
			$table = new Datatable();
			$row = $this->model->getSmsByLimit();
			
			return $table->picklistTable($fields, $row, "xsl",URL."autosms/showentry/",URL."autosms/deletesms/");
		}
		public function deletesms($sl){
			$where = "bizid=".Session::get('sbizid')." and xsl='".$sl."'";
			$this->model->delete($where);
			$this->view->message = "";
			$this->smslist();
		}
		
}