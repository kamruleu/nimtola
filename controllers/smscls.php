<?php
class Smscls extends Controller{
	
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
				if($menus["xsubmenu"]=="Class Wise SMS")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/studentmst/js/codevalidator.js');
		$dt = date("Y/m/d");
		$this->values = array(
			"xmessage"=>"",
			"xsmscls"=>"",
			"xsmsfor"=>0,
			"xdate"=>$dt
			);
			
			$this->fields = array(
						array(
							"xdate-datepicker" => 'Date_""'	
							),
						array(
							"Message Send To-div"=>''													
							),
						array(
							"xsmscls-select_Class"=>'Class_"'
							),
						array(
							"Message Send For-div"=>''													
							),
						array(
							"xsmsfor-radio_Present_Absent_Exam Schedule_Late_Others"=>'_readonly'
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
			
			$this->view->rendermainmenu('smscls/index');
			
		}
		
		public function sendmessage(){
								
				$form = new Form();
				$data = array();
				$success=0;
				$result = "";
				
				try{				
								
				$form	->post('xmessage')
						->val('minlength', 1)
						->val('maxlength', 160)
						
						->post('xsmscls')
						
						->post('xsmsfor')
						
						->post('xdate');
						
				$form	->submit();
				
				$data = $form->fetch();

				$tdt = str_replace('/', '-', $data['xdate']);
				$tdate = date('Y-m-d', strtotime($tdt));

				$allnumberarr = array();
				$teacherdata=array();
				$employeedata=array();
				$parentsdata=array();				
				$parentsdatafor=array();				
				//print_r($data);die;

				if($data['xsmsfor']=="Present"){
					$ParentsNumberForPA = $this->model->getParentsNumberForPA($data['xsmsfor'],$tdate);
					if($data['smsparents']==1){
						if(!empty($ParentsNumberForPA))
							foreach ($ParentsNumberForPA as $key => $value) {
								array_push($parentsdatafor, array('xmobile' => $value['xfmobile']));
								array_push($parentsdatafor, array('xmobile' => $value['xmmobile']));
							}
					}
					//print_r($parentsdatafor);die;
				}else if($data['xsmsfor']=="Absent"){
					$ParentsNumberForPA = $this->model->getParentsNumberForPA($data['xsmsfor'],$tdate);
					if($data['smsparents']==1){
						if(!empty($ParentsNumberForPA))
							foreach ($ParentsNumberForPA as $key => $value) {
								array_push($parentsdatafor, array('xmobile' => $value['xfmobile']));
								array_push($parentsdatafor, array('xmobile' => $value['xmmobile']));
							}
					}
					//print_r($parentsdatafor);die;
				}else if($data['xsmsfor']=="Late"){
					$ParentsNumberForPA = $this->model->getParentsNumberForPA($data['xsmsfor'],$tdate);
					if($data['smsparents']==1){
						if(!empty($ParentsNumberForPA))
							foreach ($ParentsNumberForPA as $key => $value) {
								array_push($parentsdatafor, array('xmobile' => $value['xfmobile']));
								array_push($parentsdatafor, array('xmobile' => $value['xmmobile']));
							}
					}
					//print_r($parentsdatafor);die;
				}else if($data['xsmsfor']=="Others" || $data['xsmsfor']=="Exam Schedule"){
					if($data['smsteachers']==1)
						$teacherdata = $this->model->getTeacherNumber();
					//print_r($teacherdata);
					if($data['smsemployee']==1)
						$employeedata = $this->model->getEmployeeNumber();
					if($data['smsparents']==1){
						if(!empty($this->model->getParentsNumber()))
							foreach ($this->model->getParentsNumber() as $key => $value) {
								array_push($parentsdata, array('xmobile' => $value['xfmobile']));
								array_push($parentsdata, array('xmobile' => $value['xmmobile']));
							}
						//print_r($parentsdata);die;
					}
				}
				
				$allnumberarr = array_merge($teacherdata, $employeedata, $parentsdata, $parentsdatafor);
				//print_r($allnumberarr);die;
				$numbers="";
				foreach($allnumberarr as $ke=>$val){
					if($val['xmobile']!=null)
						$numbers .= $val['xmobile'].",";
				}
				$numbers = rtrim($numbers, ',');
				//echo $numbers;die;
				
				$sendsms = new Sendsms();
				$smsresult = "";
				//$smsresult = $sendsms->send_ayub_sms($data['xmessage'],$numbers);
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
				
				 $this->smsentry($this->result);			
		}
		
		public function showentry($data, $result=""){
		
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."smscls/smsentry"
		);
		
		$tblvalues = $data;
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=$tblvalues;
			
		
			$dynamicForm = new Dynamicform("Message", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."smscls/sendmessage", "Send Message",$tblvalues);
						
			$this->view->renderpage('smscls/smsentry');
		}
		
		
		function smsentry($result=""){
				
		$btn = array(
			"Clear" => URL."smscls/smsentry"
		);

		//  form data
		
			$dynamicForm = new Dynamicform("Message", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."smscls/sendmessage", "Send Message",$this->values);
						
			$this->view->renderpage('smscls/smsentry', false);
		}
		
}