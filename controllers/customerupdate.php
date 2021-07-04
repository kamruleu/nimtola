<?php
class Customerupdate extends Controller{
	
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
				if($menus["xsubmenu"]=="Customer Update")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','views/customers/js/codevalidator.js','views/stuenroll/js/studentenroll.js','views/customerupdate/js/getaccdt.js');
		$dt = date("Y/m/d");
		$date = date('Y-m-d', strtotime($dt));
		$year = date('Y',strtotime($date));
		$this->values = array(
			"xcus"=>"",
			"xshort"=>"",		
			"xorg"=>"",
			"xbillingadd"=>"",
			"xdeliveryadd"=>"",
			"xadd1"=>"",
			"xadd2"=>"",
			"xoccupation"=>"",
			"xcountry"=>"",
			"xdob"=>$dt,
			"xreligion"=>"",
			"xcontact"=>"",
			"xcity"=>"",
			"xprovince"=>"",
			"xmobile"=>"",
			"xphone"=>"",
			"xcusemail"=>"",
			"xnid"=>"",
			"xnoname"=>"",
			"xnorelation"=>"",
			"xnoage"=>$dt,
			"nofather"=>"",
			"xnoadd"=>""
			);
			
			$this->fields = array(					
						array(
							"xcus-group_".URL."customers/picklist"=>'Customer Code*~star_maxlength="20"',
							"xshort-text"=>'Name_maxlength="160"',	
							),
						array(
							"xorg-text"=>'Description_maxlength="100"',
							"xbillingadd-text"=>'Father/Husband_maxlength="160"'
							),
						array(
							"xdeliveryadd-text"=>'Mother Name_maxlength="160"',
							"xadd1-text"=>'Present Address_maxlength="160"'
							),
						array(
							"xadd2-text"=>'Parmanent Address_maxlength="160"',
							"xoccupation-select_Occupation"=>'Occupation_maxlength="160"'
							),
						array(
							"xcountry-select_Country"=>'Nationality_maxlength="160"',
							"xdob-datepicker"=>'Date Of Birth_""',
							),
						array(
							"xreligion-select_Religion"=>'Religion_maxlength="160"',
							"xcontact-text"=>'Contact_maxlength="50"'
							),
						array(
							"xcity-text"=>'PS_maxlength="50"',
							"xprovince-text"=>'District_maxlength="100"'
							),
						array(
							"xmobile-text"=>'Phone_maxlength="50"',
							"xphone-text"=>'Mobile_maxlength="50"'
							),
						array(
							"xcusemail-text"=>'Email_maxlength="50" email="true"',
							"xnid-text"=>'NID/PP/BIRTH_maxlength="50"'
							),
						array(
							"Nominee Detail-div"=>''		
							),
						array(
							"xnoname-text"=>'Nominee Name_maxlength="160"',
							"xnorelation-text"=>'Relation_maxlength="100"'
							),
						array(
							"xnoage-datepicker"=>'Date Of Birth_""',
							"nofather-text"=>'Father/Husband_maxlength="160"'
							),
						array(
							"xnoadd-text"=>'Nominee Address_maxlength="160"'
							)
						);
		}
		
		public function index(){
		
		
		$btn = array(
			"Clear" => URL."customerupdate/cusupdateentry",
		);	
		
		
		// form data
		
			$dynamicForm = new Dynamicform("Customer Update",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields,"","", $this->values, URL."customerupdate/showpost");
			
			//$this->view->table = $this->renderTable();
			
			$this->view->rendermainmenu('customerupdate/index');
			
		}
		
		public function editcustomer(){
			
			$result = "";
			$cus = $_POST['xcus'];

			$xdob = $_POST['xdob'];
			$cdob = str_replace('/', '-', $xdob);
			$dob = date('Y-m-d', strtotime($cdob));

			$xnodob = $_POST['xnoage'];
			$nodob = str_replace('/', '-', $xnodob);
			$dobno = date('Y-m-d', strtotime($nodob));
			
			$success=false;
			$form = new Form();
				$data = array();
				
				try{
					if(empty($_POST['xcus'])){
						throw new Exception("Select Customer!");
					}

			
				$form	->post('xshort')
						->val('maxlength', 160)

						->post('xorg')
						->val('maxlength', 160)

						->post('xbillingadd')
						->val('maxlength', 160)

						->post('xdeliveryadd')
						->val('maxlength', 160)

						->post('xadd1')
						->val('maxlength', 160)

						->post('xadd2')
						->val('maxlength', 160)

						->post('xoccupation')
						->val('maxlength', 50)

						->post('xcountry')
						->val('maxlength', 50)

						->post('xreligion')
						->val('maxlength', 150)

						->post('xcontact')
						->val('maxlength', 50)

						->post('xcity')
						->val('maxlength', 100)

						->post('xprovince')

						->post('xmobile')
						->val('maxlength', 20)

						->post('xphone')
						->val('maxlength', 20)

						->post('xcusemail')
						->val('maxlength', 100)

						->post('xnid')
						->val('maxlength', 20)

						->post('xnoname')
						->val('maxlength', 160)

						->post('xnorelation')
						->val('maxlength', 100)

						->post('nofather')
						->val('maxlength', 160)

						->post('xnoadd')
						->val('maxlength', 160);
						
						 
				$form	->submit();
				
				$data = $form->fetch();	
				
				$data['xdob'] = $dob;
				$data['xnoage'] = $dobno;
				$data['xemail'] = Session::get('suser');
				$data['zutime'] = date("Y-m-d H:i:s");
				
				$success = $this->model->editCustomer($data, $cus);
				
				}catch(Exception $e){
					//echo $e->getMessage();die;
					$result = $e->getMessage();
					//echo $result;
				}
				if($result==""){
				if($success)
					$result = "Customer Edited successfully";
				else
					$result = "Edit failed!";
				
				}
				 $this->showpost($cus,$result);
				
		
		}
		

		function cusupdateentry(){
				
		$btn = array(
			"Clear" => URL."customerupdate/cusupdateentry"
		);

		// form data
		
			$dynamicForm = new Dynamicform("Customer Update",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields,"","", $this->values, URL."customerupdate/showpost");
			
			$this->view->table ="";
			
			$this->view->renderpage('customerupdate/stuextraentry', false);
		}
		

		public function showpost($cus="",$result=""){
			$cus = $_POST['xcus'];
			
		$tblvalues=array();
		$btn = array(
			"New" => URL."customerupdate/cusupdateentry"
		);
		
		$tblvalues = $this->model->getCustomer($cus);
		//print_r($tblvalues);die;
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=$tblvalues[0];
		// form data

			$dynamicForm = new Dynamicform("Customer Update", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."customerupdate/editcustomer", "Update",$tblvalues, URL."customerupdate/showpost");
			
			$this->view->table = "";
			
			$this->view->renderpage('customerupdate/stuextraentry');
		}

}