<?php
class Items extends Controller{
	
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
				if($menus["xsubmenu"]=="Item Master")
					$iscode=1;							
		}
		if($iscode==0)
			header('location: '.URL.'mainmenu');
			
		$this->view->js = array('public/js/datatable.js','public/js/imageshow.js','views/items/js/codevalidator.js');
		
		$this->values = array(
			"prefix"=>"",
			"xsource"=>"",
			"xitemcode"=>"",
			"xitemcodealt"=>"",
			"xdesc"=>"",
			"xcat"=>"",
			"xlongdesc"=>"",
			"xbrand"=>"",
			"xgitem"=>"",
			"xcitem"=>"",
			"xtaxcodepo"=>"",
			"xtaxcodesales"=>"",
			"xcountryoforig"=>"",
			"xunitpur"=>"",
			"xunitsale"=>"",
			"xunitstk"=>"",
			"xsup"=>"",
			"xconversion"=>"1",
			"xreorder"=>"0",
			"xmandatorybatch"=>"No",
			"xserialconf"=>"None",
			"xpricepur"=>"0",
			"xstdcost"=>"0",
			"xmrp"=>"0",
			"xcp"=>"0",
			"xdp"=>"0",
			"xstdprice"=>"0",
			"xtypestk"=>"Stocking",
			"zactive"=>"1",
			"xcolor"=>"",
			"xsize"=>""
			);
			
		$this->fields = array(array(
							"prefix-select_Item Prefix"=>'Plot Prefix_maxlength="4"',
							"xsource-hidden"=>'_""'
							),
						array(
							"xitemcode-group_".URL."items/picklist"=>'Plot Code*~star_maxlength="20"',
							"xdesc-text"=>'Description*~star_maxlength="500"'
							),
						array(
							"xlongdesc-textarea"=>'Long Description_maxlength="500"'
							),
						array(
							"xcat-select_Item Category"=>'Block No_maxlength="50"',
							"xcolor-select_Color"=>'Road No_maxlength="50"'
							),
						array(
							"xsize-text"=>'Plot No_maxlength="50"',
							"xcitem-text"=>'Katha_maxlength="50"'
							),
							array(
							"xpricepur-text_number"=>'Purchase Price*~star_number="true" minlength="1" maxlength="18"',
							"xmrp-text_number"=>'MRP*~star_number="true" minlength="1" maxlength="18"'
							),		
						array(
							"zactive-checkbox_1"=>'Active?_""'
							),
						array(
						"xitemcodealt-hidden"=>'',
						"xbrand-hidden"=>'',
						"xgitem-hidden"=>'',
						"xtaxcodepo-hidden"=>'',
						"xtaxcodesales-hidden"=>'',
						"xcountryoforig-hidden"=>'',
						"xunitpur-hidden"=>'',
						"xunitsale-hidden"=>'',
						"xunitstk-hidden"=>'',
						"xsup-hidden"=>'',
						"xconversion-hidden"=>'',
						"xreorder-hidden"=>'',
						"xmandatorybatch-hidden"=>'',
						"xserialconf-hidden"=>'',
						"xcp-hidden"=>'',
						"xdp-hidden"=>'',
						"xstdprice-hidden"=>'',
						"xtypestk-hidden"=>'',
						"xstdcost-hidden"=>''
					)
						);	
		}
		
		public function index(){
		
		
		$btn = array(
			"Clear" => URL."items/itementry",
		);	
		
		
		// form data
		
			$dynamicForm = new Dynamicform("Item",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."items/saveitems", "Save",$this->values,URL."items/showpost");
			
			$this->view->table = $this->renderTable();
			
			$this->view->rendermainmenu('items/index');
			
		}
		
		public function saveitems(){
			$itemauto =	Session::get('sbizitemauto');
			//print_r($itemauto);die;
				
				if (empty($_POST['xitemcode']) && $itemauto=="NO"){
					header ('location: '.URL.'items/itementry');
					exit;
				}

				$prefix = $_POST['prefix'];	
				$keyfieldval = $this->model->getKeyValue("seitem","xitemcode",$prefix,"6");	
		//print_r($keyfieldval);die;		
				$form = new Form();
				$data = array();
				$success=0;
				$result = "";
				try{
					
				if($itemauto=="NO"){
				$form	->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20);
				}						
				
				$form	->post('xitemcodealt')
						->val('maxlength', 20)
						
						->post('xsource')
					
				
						->post('xdesc')
						->val('minlength', 4)
						->val('maxlength', 500)
						
						->post('xcat')
						
						->post('xlongdesc')
						->val('maxlength', 250)
						
						->post('xbrand')
						
						->post('xgitem')
						
						->post('xcitem')
						
						->post('xtaxcodepo')
						
						->post('xtaxcodesales')
						
						->post('xcountryoforig')
						
						->post('xunitpur')
						
						->post('xunitsale')
						
						->post('xunitstk')
						
						->post('xsup')
						
						->post('xconversion')
						//->val('digit')
						->val('checkdouble')
						
						->post('xreorder')
						//->val('digit')
						->val('checkdouble')
						
						->post('xmandatorybatch')
						
						->post('xserialconf')
						
						->post('xpricepur')
						//->val('digit')
						->val('checkdouble')
						
						->post('xstdcost')
						//->val('digit')
						->val('checkdouble')
						
						->post('xmrp')
						//->val('digit')
						->val('checkdouble')
						
						->post('xcp')
						//->val('digit')
						->val('checkdouble')
						
						->post('xdp')
						//->val('digit')
						->val('checkdouble')
						
						->post('xstdprice')
						//->val('digit')
						->val('checkdouble')
						
						->post('xtypestk')
						
						->post('zactive')
						
						->post('xcolor')
						->val('maxlength', 100)
						
						->post('xsize')
						->val('maxlength', 100);
						
				$form	->submit();
				
				$data = $form->fetch();
				
				
				if($itemauto=="YES")
					$data['xitemcode'] = $keyfieldval;	
				$data['bizid'] = Session::get('sbizid');
				$data['zemail'] = Session::get('suser');
				//print_r($data);die;				
				$success = $this->model->create($data);
				
				if(empty($success))
					$success=0;
				
				
				
				}catch(Exception $e){
					
					$this->result = $e->getMessage();
					
				}
				
				
				
				if($success>0){
					$this->result = "Item saved successfully";
					
					if ($_FILES['imagefield']["name"]){
						$imgupload = new ImageUpload();
						$imgupload->store_uploaded_image('images/products/prodlg/','imagefield', 400, 400, $data['xitemcode']);
						$imgupload->store_uploaded_image('images/products/prodsm/','imagefield', 171, 181, $data['xitemcode']);
					}
				}
				
				if($success == 0 && empty($this->result))
					$this->result = "Failed to save item!";
				
				 $this->showentry($data['xitemcode'], $this->result);
				 
				 
				
		}
		
		public function edititem($id){
			
			if (empty($_POST['xitemcode'])){
					header ('location: '.URL.'items/itementry');
					exit;
				}
				
			$result = "";
			
			$success=false;
			$form = new Form();
				$data = array();
				
				try{
					
					
				
				$form	->post('xitemcode')
						->val('minlength', 1)
						->val('maxlength', 20)	
				
				
				
						->post('xitemcodealt')
						->val('maxlength', 20)
				
						->post('xdesc')
						->val('minlength', 4)
						->val('maxlength', 500)
						
						->post('xcat')
						
						->post('xlongdesc')
						->val('maxlength', 250)
						
						->post('xbrand')
						
						->post('xsource')
						
						->post('xgitem')
						
						->post('xcitem')
						
						->post('xtaxcodepo')
						
						->post('xtaxcodesales')
						
						->post('xcountryoforig')
						
						->post('xunitpur')
						
						->post('xunitsale')
						
						->post('xunitstk')
						
						->post('xsup')
						
						->post('xconversion')
						//->val('digit')
						->val('checkdouble')
						
						->post('xreorder')
						//->val('digit')
						->val('checkdouble')
						
						->post('xmandatorybatch')
						
						->post('xserialconf')
						
						->post('xpricepur')
						//->val('digit')
						->val('checkdouble')
						
						->post('xstdcost')
						//->val('digit')
						->val('checkdouble')
						
						->post('xmrp')
						//->val('digit')
						->val('checkdouble')
						
						->post('xcp')
						//->val('digit')
						->val('checkdouble')
						
						->post('xdp')
						//->val('digit')
						->val('checkdouble')
						
						->post('xstdprice')
						//->val('digit')
						->val('checkdouble')
						
						->post('xtypestk')
						
						->post('zactive')
						
						->post('xcolor')
						->val('maxlength', 100)
						
						->post('xsize')
						->val('maxlength', 10);
						
				$form	->submit();
				
				$data = $form->fetch();	
				//print_r($data);die;
				
				$data['bizid'] = Session::get('sbizid');
				$data['xemail'] = Session::get('suser');
				$data['zutime'] = date("Y-m-d H:i:s");
				$success = $this->model->editItem($data, $id);
				
				
				}catch(Exception $e){
					//echo $e->getMessage();die;
					$result = $e->getMessage();
					
				}
				//var_dump($_POST); die;
				if($result==""){
				if($success){
					$result = "Edited successfully";
					$file = 'images/products/prodsm/'.$id.'.jpg';
					if ($_FILES['imagefield']["name"]){
						if(file_exists($file))
							unlink($file); 
						
						$imgupload = new ImageUpload();
						$imgupload->store_uploaded_image('images/products/prodlg/','imagefield', 400, 400, $id);
						$imgupload->store_uploaded_image('images/products/prodsm/','imagefield', 171, 181, $id);
						
					}
				}
				else
					$result = "Edit failed!";
				
				}
				 $this->showitemdata($id, $result);
				
		
		}
		
		public function showitemdata($id="", $result=""){
		if($id==""){
			header ('location: '.URL.'items');
			exit;
		}
		$tblvalues=array();
		$btn = array(
			"New" => URL."items/itementry"
		);
		
		$tblvalues = $this->model->getSingleItem($id);
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=$tblvalues[0];
			
		$file = 'images/products/prodsm/'.$id.'.jpg';
		
		$imagename = "";	
		if(file_exists($file))
			$imagename = '../../'.$file;
		else
			$imagename = '../../images/products/noimage.jpg';
		
		$this->view->filename = $imagename;
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Item", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."items/edititem/".$id, "Edit",$tblvalues, URL."items/showpost","","imagefield");
			
			$this->view->table = $this->renderTable();
			
			$this->view->renderpage('items/itementry');
		}
		
		public function showitem($id="", $result=""){
		if($id==""){
			header ('location: '.URL.'items');
			exit;
		}
		$tblvalues=array();
		$btn = array(
			"New" => URL."items/itementry"
		);
		
		$tblvalues = $this->model->getSingleItem($id);
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=$tblvalues[0];
			
		$file = 'images/products/prodsm/'.$id.'.jpg';
		
		$imagename = "";	
		if(file_exists($file))
			$imagename = '../../../'.$file;
		else
			$imagename = '../../../images/products/noimage.jpg';
		
		$this->view->filename = $imagename;
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Item", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."items/edititem/".$id, "Edit",$tblvalues, URL."items/showpost","","imagefield");
			
			$this->view->table = $this->renderTable();
			
			$this->view->renderpage('items/itementry');
		}
		
		
		public function showentry($id, $result=""){
		
		$tblvalues=array();
		$btn = array(
			"Clear" => URL."items/itementry"
		);
		
		$tblvalues = $this->model->getSingleItem($id);
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=$tblvalues[0];
			
		$file = 'images/products/prodsm/'.$id.'.jpg';
		
		$imagename = "";
		
		if(file_exists($file))
			$imagename = '../'.$file;
		else
			$imagename = '../images/products/noimage.jpg';
		
		$this->view->filename = $imagename;
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Item", $btn, $result);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."items/edititem/".$id, "Edit",$tblvalues ,URL."items/showpost","","imagefield");
			
			$this->view->table = $this->renderTable();
			
			$this->view->renderpage('items/itementry');
		}
		
		function renderTable(){
			$fields = array(
						"xitemcode-Item Code",
						"xdesc-Description",
						"xcat-Block No",
						"xcolor-Road No",
						"xsize-Plot No",
						"xcitem-Katha"
						);
			$table = new Datatable();
			$row = $this->model->getItemsByLimit(" LIMIT 5");
			
			return $table->myTable($fields, $row, "xitemcode", URL."items/showitemdata/");
			
			
		}
		
		function itemlist(){
			$btn = '<div>
				<a href="'.URL.'items/allitems" class="btn btn-primary">Print Item List</a>
				</div>
				<div>
				<hr/>
				</div>  ';
			$this->view->table = $btn.$this->itemTable();
			
			$this->view->renderpage('items/itemlist', false);
		}
		
		function picklist(){
			$this->view->table = $this->itemPickTable();
			
			$this->view->renderpage('items/itempicklist', false);
		}
		
		function itemPickTable(){
			$fields = array(
						"xitemcode-Item Code",
						"xitemcodealt-Alternate Code",
						"xdesc-Description",
						"xstdprice-Price",
						"xsource-Item Source"	
						);
			$table = new Datatable();
			$row = $this->model->getItemsByLimit();
			
			return $table->picklistTable($fields, $row, "xitemcode");
		}
		
		function itemTable(){
			$fields = array(
						"xitemcode-Item Code",
						"xdesc-Description",
						"xcat-Block No",
						"xcolor-Road No",
						"xsize-Plot No",
						"xcitem-Katha"
						);
			$table = new Datatable();
			$row = $this->model->getItemsByLimit();
			
			return $table->createTable($fields, $row, "xitemcode", URL."items/showitem/", URL."items/deleteitem/");
		}
		
		function allitems(){
			$fields = array(
						"xitemcode-Item Code",
						"xdesc-Description",
						"xstdprice-Price",
						"xmrp-MRP",
						"xsource-Item Source",
						"xdp-point"
						);
			$table = new Datatable();
			$row = $this->model->getItemsByLimit();
			$btn = '<div><a class="btn btn-primary" href="javascript:void(0);" onclick="window.print();" role="button">
			<span class="glyphicon glyphicon-print"></span>&nbsp;Print</a>
			</div><div id="printdiv"><div style="text-align:center">'.Session::get('sbizlong').'<br/>Item List</div><hr/>';
			$this->view->table=$btn.$table->myTable($fields, $row, "xitemcode")."</div>";
			$this->view->renderpage('items/itemlist', false);
		}
		
		function itementry(){
				
		$btn = array(
			"Clear" => URL."items/itementry"
		);

		// form data
		
			$dynamicForm = new Dynamicform("Item",$btn);		
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."items/saveitems	", "Save",$this->values, URL."items/showpost","","imagefield");
			
			$imagename = '../images/products/noimage.jpg';
			
			$this->view->filename = $imagename;
			
			$this->view->table = $this->renderTable();
			
			$this->view->renderpage('items/itementry', false);
		}
		
		public function deleteitem($id){
			$where = "bizid=".Session::get('sbizid')." and xitemcode='".$id."'";
			$this->model->delete($where);
			$this->view->message = "";
			$this->itemlist();
		}
		
		public function showpost(){
			$id = $_POST['xitemcode'];
			
		$tblvalues=array();
		$btn = array(
			"New" => URL."items/itementry"
		);
		
		$tblvalues = $this->model->getSingleItem($id);
		
		if(empty($tblvalues))
			$tblvalues=$this->values;
		else
			$tblvalues=$tblvalues[0];
			
		
			
		// form data
		
			
			$dynamicForm = new Dynamicform("Item", $btn);	
			
			$file = 'images/products/prodsm/'.$id.'.jpg';
		
		$imagename = "";
		
		if(file_exists($file))
			$imagename = '../'.$file;
		else
			$imagename = '../images/products/noimage.jpg';
		
		$this->view->filename = $imagename;
			
			$this->view->dynform = $dynamicForm->createForm($this->fields, URL."items/edititem/".$id, "Edit",$tblvalues, URL."items/showpost","","imagefield");
			
			$this->view->table = $this->renderTable();
			
			$this->view->renderpage('items/itementry');
		}
}