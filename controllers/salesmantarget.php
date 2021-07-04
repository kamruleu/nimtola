<?php  
class Salesmantarget extends Controller{
	
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
				if($menus["xsubmenu"]=="Salesman Target")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/salesmantarget/js/codevalidator.js','views/salesmantarget/js/printinvoice.js','views/salesmantarget/js/getaccdt.js');
		$dt = date("Y/m/d");
		$date = date('Y-m-d', strtotime($dt));
		$year = date('Y',strtotime($date));
		$per = date('M',strtotime($date));
		$this->values = array(			
			"xagent"=>"",
			"xamount"=>"0.00",
			"xprecement"=>"",			
			"xscancement"=>"",
			"xrod"=>"",
			"xfdate"=>$dt,		
			"xtdate"=>$dt,
			"xsl"=>""
			);
			
			$this->fields = array(array(
							"xagent-select_Salesman"=>'Salesman*~star_maxlength="200"',
							"xamount-text"=>'Amount_number="true" minlength="1" maxlength="18"'
							),
						array(
							"xprecement-text"=>'Premier Cement_maxlength="160"',
							"xscancement-text"=>'Scan Cement_maxlength="160"'
							),
						array(
							"xrod-text"=>'Rod_maxlength="20"',
							"xsl-hidden"=>''
							),
						array(
							"xfdate-datepicker"=>'From Date',
							"xtdate-datepicker"=>'To Date'
							)
						);
		}
		 
		public function index(){
		
		
		$btn = array(
			"Clear" => URL."salesmantarget/collectionentry",
		);	


			$dynamicForm = new Dynamicform("Salesman Target",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."salesmantarget/savetarget", "Save",$this->values,URL."salesmantarget/showpost");
		
			$this->view->rendermainmenu('salesmantarget/index');
			
		}
		
		public function savetarget(){

				$dt = date("Y/m/d");
				$dat = str_replace('/', '-', $dt);
				$date = date('Y-m-d', strtotime($dat));
				
				$fdate = $_POST['xfdate'];
				$fdat = str_replace('/', '-', $fdate);
				$fdt = date('Y-m-d', strtotime($fdat));

				$tdate = $_POST['xtdate'];
				$tdat = str_replace('/', '-', $tdate);
				$tdt = date('Y-m-d', strtotime($tdat));
				$keyfieldval="0";
				$form = new Form();
				$data = array();
				$success=0;
				$result = "";
				
				//print_r($amount); die;
				
				//echo $studentid." ".$year." ".$feesamt; die;
				

				try{
				
				
									
				if($_POST["xagent"]==""){
					throw new Excpetion("Select Salesman!"); 
				}

				$form	->post('xagent')
						->val('maxlength', 20)
						
						->post('xamount')
						->val('minlength', 1)
						->val('maxlength', 20)
				
						->post('xprecement')
						
						->post('xscancement')

						->post('xrod')
						
						->post('xfdate')
						
						->post('xtdate');
						
				$form	->submit();
				
				$data = $form->fetch();

				$data['xfdate']= $fdt;				
				$data['xtdate']= $tdt;
				$data['xdate']= $date;
				$data['bizid'] = Session::get('sbizid');
				$data['zemail'] = Session::get('suser');
				$data['xbranch'] = Session::get('sbranch');

				$success = $this->model->create($data);

				
				if(empty($success))
					$success=0;
				
				
				}catch(Exception $e){
					
					$this->result = $e->getMessage();
					
				}
				
				
				
				if($success>0)
					$xsl = $this->model->getsl()[0]['xsl'];
					$this->result = "Salesman Target Created";
				
				if($success == 0 && empty($this->result))
					$this->result = "Failed to Created!";
				
				 $this->showentry($xsl, $this->result);
				 
				 
				
		}


		public function edittarget(){

				$dt = date("Y/m/d");
				$dat = str_replace('/', '-', $dt);
				$date = date('Y-m-d', strtotime($dat));
				
				$fdate = $_POST['xfdate'];
				$fdat = str_replace('/', '-', $fdate);
				$fdt = date('Y-m-d', strtotime($fdat));

				$tdate = $_POST['xtdate'];
				$tdat = str_replace('/', '-', $tdate);
				$tdt = date('Y-m-d', strtotime($tdat));
				$xsl = $_POST['xsl'];
				$keyfieldval="0";
				$form = new Form();
				$data = array();
				$success=0;
				$result = "";
				
				//print_r($amount); die;
				
				//echo $studentid." ".$year." ".$feesamt; die;
				

				try{
				
				
									
				if($_POST["xagent"]==""){
					throw new Excpetion("Select Salesman!"); 
				}

				$form	->post('xagent')
						->val('maxlength', 20)
						
						->post('xamount')
						->val('minlength', 1)
						->val('maxlength', 20)
				
						->post('xprecement')
						
						->post('xscancement')

						->post('xrod')
						
						->post('xfdate')
						
						->post('xtdate');
						
				$form	->submit();
				
				$data = $form->fetch();

				$data['xfdate']= $fdt;				
				$data['xtdate']= $tdt;
				$data['xdate']= $date;
				$data['bizid'] = Session::get('sbizid');
				$data['zemail'] = Session::get('suser');
				$data['xbranch'] = Session::get('sbranch');

				$success = $this->model->edit($data, $xsl);

				
				if(empty($success))
					$success=0;
				
				
				}catch(Exception $e){
					
					$this->result = $e->getMessage();
					
				}
				
				
				
				if($success>0)
					$this->result = "Target Edit Successfully";
				
				if($success == 0 && empty($this->result))
					$this->result = "Failed to Edit Target!";
				
				 $this->showentry($xsl, $this->result);
				 
				 
				
		}


		public function showentry($xsl, $result){
		$dt = date("Y/m/d");
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."salesmantarget/collectionentry"
		);
		
		$tblvalues = $this->model->getSingleTarget($xsl);
		

		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					"xagent"=>$tblvalues[0]['xagent'],
					"xamount"=>$tblvalues[0]['xamount'],
					"xprecement"=>$tblvalues[0]['xprecement'],
					"xscancement"=>$tblvalues[0]['xscancement'],
					"xrod"=>$tblvalues[0]['xrod'],
					"xfdate"=>$tblvalues[0]['xfdate'],
					"xtdate"=>$tblvalues[0]['xtdate'],
					"xsl"=>$xsl
					);
			
		
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Salesman Target", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, "", "",$tblvalues ,URL."salesmantarget/showpost");
			
			$this->view->renderpage('salesmantarget/collectionentry');
		}

		public function editshow($xsl, $result=""){
		$dt = date("Y/m/d");
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."salesmantarget/collectionentry"
		);

		$tblvalues = $this->model->getSingleTarget($xsl);

		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					"xagent"=>$tblvalues[0]['xagent'],
					"xamount"=>$tblvalues[0]['xamount'],
					"xprecement"=>$tblvalues[0]['xprecement'],
					"xscancement"=>$tblvalues[0]['xscancement'],
					"xrod"=>$tblvalues[0]['xrod'],
					"xfdate"=>$tblvalues[0]['xfdate'],
					"xtdate"=>$tblvalues[0]['xtdate'],
					"xsl"=>$xsl
					);
			
		
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Salesman Target", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields,URL."salesmantarget/edittarget", "Edit",$tblvalues ,URL."salesmantarget/showpost");
			
			$this->view->renderpage('salesmantarget/collectionentry');
		}


		function collectionentry(){
				
		$btn = array(
			"Clear" => URL."salesmantarget/collectionentry"
		);

		// form data
		
			$dynamicForm = new Dynamicform("Salesman Target",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."salesmantarget/savetarget", "Save",$this->values,URL."salesmantarget/showpost");
			
			$this->view->table = "";
			
			$this->view->renderpage('salesmantarget/collectionentry', false);
		}
		
		
		public function showpost(){
			$enid = $_POST['xcus'];
			$dt = date("Y/m/d");
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."salesmantarget/collectionentry"
		);
		
		$tblvalues = $this->model->getSingleTarget($enid);
		//print_r($tblvalues);
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=array(
					"xcus"=>$tblvalues[0]['xcus'],
					"xorg"=>$tblvalues[0]['xorg'],
					"xadd1"=>$tblvalues[0]['xadd1'],
					"xmobile"=>$tblvalues[0]['xmobile'],
					"xacccr"=>"",
					"xacccrdesc"=>"",
					"xacccrtype"=>"",
					"xacccrusage"=>"",
					"xacccrsource"=>"",
					"xnarration"=>"",
					"xacc"=>"1010",
					"xaccdesc"=>"Trade Receivable",
					"xacctype"=>"Asset",
					"xaccusage"=>"AR",
					"xaccsource"=>"Customer",
					"xchequeno"=>"",		
					"xchequedate"=>$dt,
					"xcollectionno"=>"",
					"xprime"=>"0"
					);

			$dynamicForm = new Dynamicform("Salesman Target", $btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, "", "",$tblvalues,URL."salesmantarget/showpost");
			
			$this->view->table = $this->renderTable($enid);
			
			$this->view->renderpage('salesmantarget/collectionentry');
		}

		function targetlist(){
			$rows = $this->model->getTargetList();
			$cols = array("xsl-SL","xagent-Salesman","xfdate-From Date","xtdate-From Date","xamount-Amount","xprecement-Pre. Cement","xscancement-Sc. Cement","xrod-Rod");
			$table = new Datatable();
			$this->view->table = $table->createTable($cols, $rows, "xsl",URL."salesmantarget/editshow/");
			$this->view->renderpage('salesmantarget/collectionlist', false);
		}
		
		function getstudentfees($cus, $xdate){
			$this->model->getheadcollection($cus, $xdate);
		}
}