<?php
class Smsindividual extends Controller{
	
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
				if($menus["xsubmenu"]=="Individual SMS")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/studentmst/js/codevalidator.js');
		$dt = date("Y/m/d");
		$this->values = array(
			"xmessage"=>"",
			"xsmsnumber"=>""
			);
			
			$this->fields = array(
						array(
							"Message Send To-div"=>''													
							),
						array(
							"xsmsnumber-textarea"=>'Number(s)_maxlength="1000"'
							),
						array(
							"Message Body-div"=>''													
							),
						array(
							"xmessage-textarea"=>'Message_maxlength="160"'
							)
						);
		
		}
		
		public function index(){
			
			$this->view->rendermainmenu('smsindividual/index');
			
		}
		
		public function sendmessage(){
							
				$form = new Form();
				$data = array();
				$success=0;
				$result = "";
				
				try{				
								
				$form	->post('xsmsnumber')
						->val('minlength', 5)
						->val('maxlength', 1000)
						
						->post('xmessage')
						->val('minlength', 1)
						->val('maxlength', 160);
												
						
				$form	->submit();
				
				$data = $form->fetch();
				//print_r($data);die;
				/* $numbers = $data['xsmsnumber'];
				$pieces = explode(",", $numbers);
				print_r($pieces);die; */
				
				$sendsms = new Sendsms();
				$smsresult = $sendsms->send_ayub_sms($data['xmessage'],$data['xsmsnumber']);
				$success = substr($smsresult, 0, 2);
				
				if($success == "OK")
					$success=1;
				
				
				}catch(Exception $e){					
					$this->result = $e->getMessage();
				}				
				if($success>0){
					$this->result = "Message send successfully";						
				}				
				if($success == 0 && empty($this->result))
					$this->result = "Failed to send Message! Please Contact Dot BD Solutions";
				
				 $this->showentry($data, $this->result);				
		}
		
		public function showentry($data, $result=""){
		
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."smsindividual/smsentry"
		);
		
		$tblvalues = $data;
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=$tblvalues;
			
		
			$dynamicForm = new Dynamicform("Message", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."smsindividual/sendmessage", "Send Message",$tblvalues);
						
			$this->view->renderpage('smsindividual/smsentry');
		}
		
		
		function smsentry(){
				
		$btn = array(
			"Clear" => URL."smsindividual/smsentry"
		);

		//  form data
		
			$dynamicForm = new Dynamicform("Message", $btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."smsindividual/sendmessage", "Send Message",$this->values);
						
			$this->view->renderpage('smsindividual/smsentry', false);
		}
		
}