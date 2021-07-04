<?php

class ReportingTable{
	
	private $decimals="";
	
	public function __construct(){
		$this->decimals = Session::get("sbizdecimals");
	}
	/*
		Sample parameters for reportingtbl();
		
		$tblsettings = array(
							"columns"=>array("0"=>"ID",1=>"Address",2=>"Phone",3=>"Fees",4=>"Count"),
							"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
							"urlvals"=>array("id","phone"),
							"sumfields"=>array("fees","count"),
							);
							
		$rows = array(0=>array("id"=>"1001","add"=>"Abdul Wahab","phone"=>"01827366502","fees"=>350,"count"=>2),
					  1=>array("id"=>"1002","add"=>"Shamsun Nahar","phone"=>"01826579376","fees"=>435,"count"=>4));
		
	**/
	public function reportingtbl($tblsettings,$rows){
		
		$columncount = 0;
		$colexist = false;
		$buttonexist = false;
		if(array_key_exists("columns",$tblsettings)){
			$columncount = count($tblsettings["columns"]);
			$colexist = true;
		}
		if(array_key_exists("buttons",$tblsettings)){
			$columncount = $columncount+count($tblsettings["buttons"]);
			$buttonexist = true;
		}
		$table="";
		
		$table.= '<table class="table table-bordered table-striped">';
			$table.='<thead>';
				$table.='<tr>';
				for($i=0; $i<$columncount; $i++){
					if($colexist){
					if(array_key_exists($i,$tblsettings["columns"]))
						$table.='<th>'.$tblsettings["columns"][$i].'</th>';
					else
						$table.='<th></th>';
					}
				}			
				$table.='</tr>';
			$table.='</thead>';
			$table.='<tbody>';
			if(count($rows)>0){	
				for($j=0; $j<count($rows); $j++){
				$table.='<tr>';					
						foreach($rows[$j] as $key=>$value){
							$table.='<td>'."$value".'</td>';
						}
						if($buttonexist){
							foreach($tblsettings["buttons"] as $key=>$value){
								$urlval = "";
								if(array_key_exists("urlvals",$tblsettings)){
									foreach($tblsettings["urlvals"] as $vals){
										$urlval .= $rows[$j][$vals]."/"; 
									}
								}
								$urlval=rtrim($urlval,"/");
								$table.='<td><a class="btn btn-info" href="'.$value.$urlval.'" role="button">'.$key.'</a></td>';
							}
						}
				$table.='</tr>';		
				}
			}
			$table.='</tbody>';
			if(array_key_exists("sumfields",$tblsettings)){
			$table.='<tfoot>';
				$table.='<tr>';
					
						$i=0;
					if(!empty($rows)){	
						foreach($rows[0] as $k=>$v){
							if($i==0)
								$table.='<td><strong>'."Total".'</strong></td>';							
							elseif(in_array($k,$tblsettings["sumfields"])){
									$table.='<td><strong>'.number_format(array_sum(array_column($rows,$k)), $this->decimals, '.', '').'</strong></td>';								
							}else
								$table.='<td></td>';
							$i++;
						}
					}
						if(array_key_exists("buttons",$tblsettings))
							for($b=0; $b<count($tblsettings["buttons"]); $b++)
								$table.='<td></td>';
				
				$table.='</tr>';
			$table.='</tfoot>';
			}			
		$table.= '</table>';
		return $table;	
	}
	
	/*$tblsettings = array(
	"columns"=>array("0"=>"ID",1=>"Address",2=>"Phone",3=>"Fees",4=>"Count"), //column names
	"groupfield"=>"Account~xacc",
	"grouprecords"=>array("Description~xaccdesc","Date~xdate"), //database records columns to show in group
	"detailsection"=>array("xitemcode","xitemdesc","xqty","xratepor","xunitpur","xtotal"),
	"buttons"=>array("Show"=>URL."test/","Delete"=>URL."test/"),
	"urlvals"=>array("id","phone"),
	"sumfields"=>array("fees","count"),
	);*/
				

	public function SingleGroupReportingtbl($tblsettings,$rows){
		
		$grouprec = [];

		$groupby = explode("~", $tblsettings["groupfield"]); 
		
		foreach($rows as $key=>$value){
			$keyval = $value[$groupby[1]];
			$grouprec[$keyval][]=$value;
		}

		$columncount = 0;
		$colexist = false;
		$buttonexist = false;
		if(array_key_exists("columns",$tblsettings)){
			if(!empty($tblsettings["columns"])){
				$columncount = count($tblsettings["columns"]);
				$colexist = true;
			}
		}
		if(array_key_exists("buttons",$tblsettings)){
			if(!empty($tblsettings["buttons"])){
				$columncount = $columncount+count($tblsettings["buttons"]);
				$buttonexist = true;
			}
		}
		$table="";
		
		$table.= '<div class=""><table id="grouptable" border="1" class="table table-bordered table-striped">';
			$table.='<thead>';
				$table.='<tr>';
				for($i=0; $i<$columncount; $i++){
					if($colexist){
					if(array_key_exists($i,$tblsettings["columns"]))
						$table.='<th>'.$tblsettings["columns"][$i].'</th>';
					else
						$table.='<th></th>';
					}
				}			
				$table.='</tr>';
			$table.='</thead>';
			$table.='<tbody>';
			foreach($grouprec as $gkey=>$gval){
				
				

				if(!empty($tblsettings["grouprecords"])){					
					for($i=0; $i<count($tblsettings["grouprecords"]); $i++){
						$groupbynext=explode("~",$tblsettings["grouprecords"][$i]);
						$table .= '<tr><td colspan='.$columncount.'><strong>'.$groupbynext[0].' :</strong>'.$gval[0][$groupbynext[1]].'</td>';
						
						$table.='</tr>';
					}
				}

				if(count($gval)>0){	
					for($j=0; $j<count($gval); $j++){
					$table.='<tr>';					
							
							foreach($tblsettings["detailsection"] as $details){
								if($details=="xmobile")
									$table.='<td>'.$gval[$j][$details].'</td>';
								else if(is_numeric($gval[$j][$details]) && $details!="xqty" && $details!="xqtypo" && $details!="xqtyso")
									$table.='<td>'.number_format(floatval($gval[$j][$details]), $this->decimals, '.', '').'</td>';
								else
									$table.='<td>'.$gval[$j][$details].'</td>';
								
							}
							if($buttonexist){
								foreach($tblsettings["buttons"] as $key=>$value){
									$urlval = "";
									if(array_key_exists("urlvals",$tblsettings)){
										foreach($tblsettings["urlvals"] as $vals){
											$urlval .= $rows[$j][$vals]."/"; 
										}
									}
									$urlval=rtrim($urlval,"/");
									$table.='<td><a class="btn btn-info" href="'.$value.$urlval.'" role="button">'.$key.'</a></td>';
								}
							}
					$table.='</tr>';		
					}
				}

				$table.='<tr>';
					
						$i=0;
						if(!empty($tblsettings["sumfields"]) && !empty($gval)){
							
							foreach($tblsettings["detailsection"] as $details){
								
								if($i==0)
									$table.='<td><strong>'."Total".'</strong></td>';
								elseif(in_array($details,$tblsettings["sumfields"])){
										$table.='<td><strong>'.array_sum(array_column($gval,$details)).'</strong></td>';
									}else{										
										$table.='<td></td>';
									}
									$i++;
								}
							
						}
						if(array_key_exists("buttons",$tblsettings))
							for($b=0; $b<count($tblsettings["buttons"]); $b++)
								$table.='<td></td>';
				
				$table.='</tr>';
			}
			$table.='</tbody>';
			if(array_key_exists("sumfields",$tblsettings)){
			$table.='<tfoot style="display: table-row-group;">';
				$table.='<tr>';
					
						$i=0;
						if(!empty($tblsettings["sumfields"]) && !empty($gval)){
							
							foreach($tblsettings["detailsection"] as $details){
								if($i==0)
									$table.='<td><strong>'."Report Total".'</strong></td>';
								elseif(in_array($details,$tblsettings["sumfields"])){
										$total = 0;
										foreach($grouprec as $kkey=>$kval){
											$total+=array_sum(array_column($kval,$details));
										}
										$table.='<td><strong>'.$total.'</strong></td>';
									}else{										
										$table.='<td></td>';
									}
									$i++;
							}
						}
						if(array_key_exists("buttons",$tblsettings))
							for($b=0; $b<count($tblsettings["buttons"]); $b++)
								$table.='<td></td>';
				
				$table.='</tr>';
			$table.='</tfoot>';
			}			
		$table.= '</table></div>';
		return  $table;	
	}

	public function SingleGroupReportingtblTar($tblsettings,$rows, $saltarbal="", $salcolbal="",$saltarpre="",$saltarrod="",$saltarsc="",$cusareabal=""){
		
		$grouprec = [];

		$groupby = explode("~", $tblsettings["groupfield"]); 
		
		foreach($rows as $key=>$value){
			$keyval = $value[$groupby[1]];
			$grouprec[$keyval][]=$value;
		}

		$columncount = 0;
		$colexist = false;
		$buttonexist = false;
		if(array_key_exists("columns",$tblsettings)){
			if(!empty($tblsettings["columns"])){
				$columncount = count($tblsettings["columns"]);
				$colexist = true;
			}
		}
		if(array_key_exists("buttons",$tblsettings)){
			if(!empty($tblsettings["buttons"])){
				$columncount = $columncount+count($tblsettings["buttons"]);
				$buttonexist = true;
			}
		}
		$table="";
		
		$table.= '<div class=""><table id="grouptable" border="1" class="table table-bordered table-striped">';
			$table.='<thead>';
				$table.='<tr>';
				for($i=0; $i<$columncount; $i++){
					if($colexist){
					if(array_key_exists($i,$tblsettings["columns"]))
						$table.='<th>'.$tblsettings["columns"][$i].'</th>';
					else
						$table.='<th></th>';
					}
				}			
				$table.='</tr>';
			$table.='</thead>';
			$table.='<tbody>';
			foreach($grouprec as $gkey=>$gval){
				
				

				if(!empty($tblsettings["grouprecords"])){					
					for($i=0; $i<count($tblsettings["grouprecords"]); $i++){
						$groupbynext=explode("~",$tblsettings["grouprecords"][$i]);
						$table .= '<tr><td colspan='.$columncount.'><strong>'.$groupbynext[0].' :</strong>'.$gval[0][$groupbynext[1]].'</td>';
						
						$table.='</tr>';
					}
				}

				if(count($gval)>0){	
					for($j=0; $j<count($gval); $j++){
					$table.='<tr>';					
							
							foreach($tblsettings["detailsection"] as $details){

								if($details=="xmobile")
									$table.='<td>'.$gval[$j][$details].'</td>';
								else if(is_numeric($gval[$j][$details]) && $details!="xqty" && $details!="xqtypo" && $details!="xqtyso")
									$table.='<td>'.number_format(floatval($gval[$j][$details]), $this->decimals, '.', '').'</td>';
								else
									$table.='<td>'.$gval[$j][$details].'</td>';

								if ($gval[$j][$details]=='Premier Cement') {
									$aa='0.00';
									if ($saltarpre!="") {
										$aa=number_format(floatval($gval[$j]['xqty']*100/$saltarpre), $this->decimals, '.', '');
									}
									$table.='<td>'.$aa.'%'.'</td>';
									$table.='<td>'.$saltarpre.'</td>';
									
								}
								if ($gval[$j][$details]=='Rod') {
									$bb='0.00';
									if ($saltarrod!="") {
										$bb=number_format(floatval($gval[$j]['xqty']*100/$saltarrod), $this->decimals, '.', '');
									}
									$table.='<td>'.$bb.'%'.'</td>';
									$table.='<td>'.$saltarrod.'</td>';
								}
								if ($gval[$j][$details]=='Scan Cement') {
									$cc='0.00';
									if ($saltarsc!="") {
										$cc=number_format(floatval($gval[$j]['xqty']*100/$saltarsc), $this->decimals, '.', '');
									}
									$table.='<td>'.$cc.'%'.'</td>';
									$table.='<td>'.$saltarsc.'</td>';
								}

							}
							if($buttonexist){
								foreach($tblsettings["buttons"] as $key=>$value){
									$urlval = "";
									if(array_key_exists("urlvals",$tblsettings)){
										foreach($tblsettings["urlvals"] as $vals){
											$urlval .= $rows[$j][$vals]."/"; 
										}
									}
									$urlval=rtrim($urlval,"/");
									$table.='<td><a class="btn btn-info" href="'.$value.$urlval.'" role="button">'.$key.'</a></td>';
								}
							}

					$table.='</tr>';		
					}
				}

				$table.='<tr>';
					
						$i=0;
						if(!empty($tblsettings["sumfields"]) && !empty($gval)){
							
							foreach($tblsettings["detailsection"] as $details){
								
								if($i==0)
									$table.='<td><strong>'."Total".'</strong></td>';
								elseif(in_array($details,$tblsettings["sumfields"])){
									$table.='<td></td><td></td>';
										$table.='<td><strong>'.array_sum(array_column($gval,$details)).'</strong></td>';
									}else{										
										$table.='<td></td>';
									}
									$i++;
								}
							
						}
						if(array_key_exists("buttons",$tblsettings))
							for($b=0; $b<count($tblsettings["buttons"]); $b++)
								$table.='<td></td>';
				
				$table.='</tr>';
			}
			$table.='</tbody>';
			$table.='<tfoot style="display: table-row-group;">';
				
			$reptotal= array_sum(array_column($gval,$details))+$cusareabal;
			
				$table.='<tr>';
					$table.='<td><strong>Due Amount</strong></td>';
					$table.='<td></td><td></td><td></td><td></td>';
					$table.='<td><strong>'.$cusareabal.'</strong></td>';
				$table.='</tr>';

				$table.='<tr>';
					$table.='<td><strong>Report Total</strong></td>';
					$table.='<td></td><td></td><td></td><td></td>';
					$table.='<td><strong>'.$reptotal.'</strong></td>';
				$table.='</tr>';
			
				$table.='<tr>';
					$table.='<td><strong>Target Amount</strong></td>';
					$table.='<td></td><td></td><td></td><td></td>';
					$table.='<td><strong>'.$saltarbal.'</strong></td>';
				$table.='</tr>';
			
				$table.='<tr>';
					$table.='<td><strong>Collection Amount</strong></td>';
					$table.='<td></td><td></td><td></td><td></td>';
					$table.='<td><strong>'.$salcolbal.'</strong></td>';
				$table.='</tr>';
			
			$perc="";
			if ($saltarbal!="" && $salcolbal!="") {
				$perc = $salcolbal*100/$saltarbal;
			}
				$table.='<tr>';
					$table.='<td><strong>Collection Percent (%)</strong></td>';
					$table.='<td></td><td></td><td></td><td></td>';
					$table.='<td><strong>'.number_format(floatval($perc), $this->decimals, '.', '').'%'.'</strong></td>';
				$table.='</tr>';
			
			$table.='</tfoot>';
			
		$table.= '</table></div>';
		return  $table;	
	}

	public function CusSingleGroupReportingtbl($tblsettings,$rows){
		
		$grouprec = [];

		$groupby = explode("~", $tblsettings["groupfield"]);
		
		foreach($rows as $key=>$value){
			$keyval = $value[$groupby[1]];
			$grouprec[$keyval][]=$value;
		}

		$columncount = 0;
		$colexist = false;
		$buttonexist = false;
		if(array_key_exists("columns",$tblsettings)){
			if(!empty($tblsettings["columns"])){
				$columncount = count($tblsettings["columns"]);
				$colexist = true;
			}
		}
		if(array_key_exists("buttons",$tblsettings)){
			if(!empty($tblsettings["buttons"])){
				$columncount = $columncount+count($tblsettings["buttons"]);
				$buttonexist = true;
			}
		}
		$table="";
		
		$table.= '<div class=""><table id="grouptable" border="1" class="table table-bordered table-striped">';
			$table.='<thead>';
				$table.='<tr>';
				for($i=0; $i<$columncount; $i++){
					if($colexist){
					if(array_key_exists($i,$tblsettings["columns"]))
						$table.='<th>'.$tblsettings["columns"][$i].'</th>';
					else
						$table.='<th></th>';
					}
				}			
				$table.='</tr>';
			$table.='</thead>';
			$table.='<tbody>';
			$trod=0;
			$tcement=0;
			$tseramt=0;
			foreach($grouprec as $gkey=>$gval){
				
				$table.='<tr><td colspan='.$columncount.'><strong>'.$groupby[0].' :</strong>'.$gkey.'</td>';
				
				
				
				$table.='</tr>';

				if(!empty($tblsettings["grouprecords"])){
					for($i=0; $i<count($tblsettings["grouprecords"]); $i++){
						$groupbynext=explode("~",$tblsettings["grouprecords"][$i]);
						$table .= '<tr><td colspan='.$columncount.'><strong>'.$groupbynext[0].' :</strong>'.$gval[0][$groupbynext[1]].'</td>';
						
						$table.='</tr>';
					}
				}
				
				if(count($gval)>0){	

					for($j=0; $j<count($gval); $j++){
						
					$table.='<tr>'; 
								
							foreach($tblsettings["detailsection"] as $details){
							
								if($details=="xmobile")
									$table.='<td>'.$gval[$j][$details].'</td>';
								else if(is_numeric($gval[$j][$details]) && $details!="xqty" && $details!="xqtypo" && $details!="xqtyso")
									$table.='<td>'.number_format(floatval($gval[$j][$details]), $this->decimals, '.', '').'</td>';
								else
									$table.='<td>'.$gval[$j][$details].'</td>';
							}
							
							if($buttonexist){
								foreach($tblsettings["buttons"] as $key=>$value){
									$urlval = "";
									if(array_key_exists("urlvals",$tblsettings)){
										foreach($tblsettings["urlvals"] as $vals){
											$urlval .= $rows[$j][$vals]."/"; 
										}
									}
									$urlval=rtrim($urlval,"/");
									$table.='<td><a class="btn btn-info" href="'.$value.$urlval.'" role="button">'.$key.'</a></td>';
								}
							}
					$table.='</tr>';
					
					}

				}

				
				
				
		

				$table.='<tr>';
						$rod=0;
						$cement=0;
						$seramt=0;
						$i=0;
						if(!empty($tblsettings["sumfields"]) && !empty($gval)){
							//print_r($gval);
							foreach($tblsettings["detailsection"] as $details){
								
								if ($gval[$i]['xunitsale']=='KG') {
									$rod += $gval[$i]['xqty'];
									
								}
								if ($gval[$i]['xunitsale']=='BAG') {
									$cement += $gval[$i]['xqty'];
									
								}
								if ($gval[$i]['xunitsale']=='Service') {
									$seramt += $gval[$i]['xsubtotal'];
									//echo $seramt;
								}
								
								if($i==0)
									$table.='<td><strong>'."Total".'</strong></td>';

								elseif(in_array($details,$tblsettings["sumfields"])){
										$ggg = array_sum(array_column($gval,$details));
										$ddd = $ggg-$seramt;
										//print_r($dd);
										$table.='<td><strong>'.$ddd.'</strong></td>';
									}else{
										$table.='<td></td>';
									}

									$i++;

								}

							
						}


						if(array_key_exists("buttons",$tblsettings))
							for($b=0; $b<count($tblsettings["buttons"]); $b++)
								$table.='<td></td>';

				$table.='</tr>';
				$table.='<tr>';
					
								$table.='<td colspan="7" style="text-align:center"><strong>Rod: '.$rod.' KG &nbsp; &nbsp; Cement:'.$cement.' BAG</strong></td>';
							

				$table.='</tr>';
				$trod +=$rod;
				$tcement +=$cement;
				$tseramt +=$seramt;
		}
						
			$table.='</tbody>';
			if(array_key_exists("sumfields",$tblsettings)){
			$table.='<tfoot style="display: table-row-group;">';
				$table.='<tr>';
					
						$i=0;
						if(!empty($tblsettings["sumfields"]) && !empty($gval)){
							
							foreach($tblsettings["detailsection"] as $details){
								if($i==0)
									$table.='<td><strong>'."Report Total".'</strong></td>';
								elseif(in_array($details,$tblsettings["sumfields"])){
										$total = 0;
										foreach($grouprec as $kkey=>$kval){
											$total+=array_sum(array_column($kval,$details));
										}
											$ttotal=$total-$tseramt;
										$table.='<td><strong>'.$ttotal.'</strong></td>';
									}else{										
										$table.='<td></td>';
									}
									$i++;
							}
						}
						if(array_key_exists("buttons",$tblsettings))
							for($b=0; $b<count($tblsettings["buttons"]); $b++)
								$table.='<td></td>';
				
				$table.='</tr>';

				$table.='<tr>';
					
								$table.='<td colspan="7" style="text-align:center"><strong>Total Rod: '.$trod.' KG &nbsp; &nbsp; Cement:'.$tcement.' BAG</strong></td>';
							

				$table.='</tr>';

			$table.='</tfoot>';
			}			
		$table.= '</table></div>';
		return  $table;	
	}


	public function SupSingleGroupReportingtbl($tblsettings,$rows){
		
		$grouprec = [];

		$groupby = explode("~", $tblsettings["groupfield"]); 
		
		foreach($rows as $key=>$value){
			$keyval = $value[$groupby[1]];
			$grouprec[$keyval][]=$value;
		}

		$columncount = 0;
		$colexist = false;
		$buttonexist = false;
		if(array_key_exists("columns",$tblsettings)){
			if(!empty($tblsettings["columns"])){
				$columncount = count($tblsettings["columns"]);
				$colexist = true;
			}
		}
		if(array_key_exists("buttons",$tblsettings)){
			if(!empty($tblsettings["buttons"])){
				$columncount = $columncount+count($tblsettings["buttons"]);
				$buttonexist = true;
			}
		}
		$table="";
		
		$table.= '<div class=""><table id="grouptable" border="1" class="table table-bordered table-striped">';
			$table.='<thead>';
				$table.='<tr>';
				for($i=0; $i<$columncount; $i++){
					if($colexist){
					if(array_key_exists($i,$tblsettings["columns"]))
						$table.='<th>'.$tblsettings["columns"][$i].'</th>';
					else
						$table.='<th></th>';
					}
				}			
				$table.='</tr>';
			$table.='</thead>';
			$table.='<tbody>';
			$trod=0;
			$tcement=0;
			foreach($grouprec as $gkey=>$gval){
				
				$table.='<tr><td colspan='.$columncount.'><strong>'.$groupby[0].' :</strong>'.$gkey.'</td>';
				
				
				
				$table.='</tr>';

				if(!empty($tblsettings["grouprecords"])){					
					for($i=0; $i<count($tblsettings["grouprecords"]); $i++){
						$groupbynext=explode("~",$tblsettings["grouprecords"][$i]);
						$table .= '<tr><td colspan='.$columncount.'><strong>'.$groupbynext[0].' :</strong>'.$gval[0][$groupbynext[1]].'</td>';
						
						$table.='</tr>';
					}
				}

				if(count($gval)>0){	
					for($j=0; $j<count($gval); $j++){
					$table.='<tr>';					
							
							foreach($tblsettings["detailsection"] as $details){
								if($details=="xmobile")
									$table.='<td>'.$gval[$j][$details].'</td>';
								else if(is_numeric($gval[$j][$details]) && $details!="xqty" && $details!="xqtypo" && $details!="xqtyso")
									$table.='<td>'.number_format(floatval($gval[$j][$details]), $this->decimals, '.', '').'</td>';
								else
									$table.='<td>'.$gval[$j][$details].'</td>';
							}
							if($buttonexist){
								foreach($tblsettings["buttons"] as $key=>$value){
									$urlval = "";
									if(array_key_exists("urlvals",$tblsettings)){
										foreach($tblsettings["urlvals"] as $vals){
											$urlval .= $rows[$j][$vals]."/"; 
										}
									}
									$urlval=rtrim($urlval,"/");
									$table.='<td><a class="btn btn-info" href="'.$value.$urlval.'" role="button">'.$key.'</a></td>';
								}
							}
					$table.='</tr>';		
					}
				}

				$table.='<tr>';
						
						$rod=0;
						$cement=0;
						$i=0;
						if(!empty($tblsettings["sumfields"]) && !empty($gval)){
							
							foreach($tblsettings["detailsection"] as $details){
										
									if ($gval[$i]['xunitpur']=='KG') {
									$rod += $gval[$i]['xqty'];
									
									}
									if ($gval[$i]['xunitpur']=='BAG') {
										$cement += $gval[$i]['xqty'];
										
									}

								if($i==0)
									$table.='<td><strong>'."Total".'</strong></td>';
								elseif(in_array($details,$tblsettings["sumfields"])){
										$table.='<td><strong>'.array_sum(array_column($gval,$details)).'</strong></td>';
									}else{										
										$table.='<td></td>';
									}
									$i++;
								}
							
						}
						if(array_key_exists("buttons",$tblsettings))
							for($b=0; $b<count($tblsettings["buttons"]); $b++)
								$table.='<td></td>';
				
				$table.='</tr>';
				$table.='<tr>';
					
								$table.='<td colspan="8" style="text-align:center"><strong>Rod: '.$rod.' KG &nbsp; &nbsp; Cement:'.$cement.' BAG</strong></td>';
							

				$table.='</tr>';
				$trod +=$rod;
				$tcement +=$cement;
			}
			$table.='</tbody>';
			if(array_key_exists("sumfields",$tblsettings)){
			$table.='<tfoot style="display: table-row-group;">';
				$table.='<tr>';
					
						$i=0;
						if(!empty($tblsettings["sumfields"]) && !empty($gval)){
							
							foreach($tblsettings["detailsection"] as $details){
								if($i==0)
									$table.='<td><strong>'."Report Total".'</strong></td>';
								elseif(in_array($details,$tblsettings["sumfields"])){
										$total = 0;
										foreach($grouprec as $kkey=>$kval){
											$total+=array_sum(array_column($kval,$details));
										}
										$table.='<td><strong>'.$total.'</strong></td>';
									}else{										
										$table.='<td></td>';
									}
									$i++;
							}
						}
						if(array_key_exists("buttons",$tblsettings))
							for($b=0; $b<count($tblsettings["buttons"]); $b++)
								$table.='<td></td>';
				
				$table.='</tr>';
				$table.='<tr>';
					
								$table.='<td colspan="8" style="text-align:center"><strong>Total Rod: '.$trod.' KG &nbsp; &nbsp; Cement:'.$tcement.' BAG</strong></td>';
							

				$table.='</tr>';
			$table.='</tfoot>';
			}			
		$table.= '</table></div>';
		return  $table;	
	}


	public function itemledgerTable($fields, $row, $keyval, $opbal, $item, $itemdesc){
		
				
		$head = array();
		foreach($fields as $str){
			$st=explode('-',$str);
			
			$head[] = $st[1];
		}
		$table = '<table id="grouptable" class="table table-striped table-bordered" cellspacing="0" width="100%">';
		$table.='<thead>';
		$table.='<tr>';
		foreach($head as $hd){
			$table.='<th>'.$hd.'</th>';
		}
		$table.='<th>Balance</th>';
		$baldr = 0;
		$balcr = 0;
		$bal = $opbal;
		$table.='</tr>';
		$table.='</thead>';
		$table.='<tbody>';
		$table.='<tr>';
			$table.='<td><strong>'.$item.'</strong></td><td><strong>'.$itemdesc.'</strong></td><td></td><td></td><td></td><td></td><td></td>';
		$table.='</tr>';
		$table.='<tr>';
			
			$xcol = 0;
			foreach($head as $hd){
				if($hd=="Receive"){
					if($bal>=0)
						$table.='<td><strong>'.$bal.'</strong></td>';
					else
						$table.='<td><strong>0</strong></td>';
				}
				else if($hd=="Issue"){
					if($bal<0)
						$table.='<td><strong>'.$bal.'</strong></td>';
					else
						$table.='<td><strong>0</strong></td>';
				}
				else{
					
					if($xcol==3)
						$table.='<td><strong>Opening Balance</strong></td>';
					else
						$table.='<td></td>';
				}
				$xcol++;	
			}
			
			$table.='<td></td></tr>';
		
		foreach($row as $key=>$value){
						
			$table.='<tr>';
			
			foreach($value as $str){
				$keyofval =  array_search($str, $value); 
					switch ($keyofval){						
						case "xbal":
							$str = number_format(floatval($str), 0, '.', '');
							break;
						case "xtotcost":
							$str = number_format(floatval($str), $this->decimals, '.', '');
							break;						
						case "xqtydr":							
							$bal+=$str;
							$baldr+=$str;
							break;	
						case "xqtycr":
							//$str = number_format(floatval($str), $this->decimals, '.', '');
							$bal-=$str;
							$balcr+=$str;
							break;		
						default:
							$str = $str;
				}
				$table.='<td>'.htmlentities($str).'</td>';
			}
			
				if($bal>=0)
					$table.='<td>'.$bal.'</td>';
				
			
				if($bal<0)
					$table.='<td>'.$bal.'</td>';
				
			$table.='</tr>';
		}
		$table.='</tbody>';
		$table.='<tfoot><tr>';
			$xcol = 0;
			foreach($head as $hd){
				if($hd=="Receive")
					$table.='<td><strong>'.$baldr.'</strong></td>';
				else if($hd=="Issue")
					$table.='<td><strong>'.$balcr.'</strong></td>';
				else{
					
					if($xcol==3)
						$table.='<td><strong>Total</strong></td>';
					else
						$table.='<td></td>';
				}
				$xcol++;	
			}
		$table.='</tr></tfoot>';
		$table.='</table>';
		
		return $table;	
	}

	public function multiGroupTable($rows, $groupval){
		
		$grouprec = [];
		$bal = 0;

		$finalbal = 0;
		$finaldr = 0;
		$finalcr = 0;
		foreach($rows as $key=>$value){
			$keyval = $value[$groupval];
			$grouprec[$keyval][]=$value;
		}
		$grandbal = 0;
		$grandtotaldr = 0;
		$grandtotalcr = 0;
		//print_r($grouprec); die;
		// $table = '<table id="grouptable" class="table table-striped table-bordered" cellspacing="0" width="100%">';
		// $table .= "<tr>";
		// $table .= '<td><strong>Account</strong></td><td><strong>Date</strong></td><td><strong>Voucher</strong></td><td><strong>Narration</strong></td><td><strong>Debit</strong></td><td><strong>Credit</strong></td><td><strong>Balance</strong></td></tr>';

		// $obalrec = [];
		
		// foreach($obal as $key=>$value){
		// 	$keyval = $value[$groupval];
		// 	$obalrec[$keyval][]=$value;
		// }

		//$arrdif = array_diff_key($obalrec, $grouprec);
		
		if(!empty($arrdif)){

			foreach($arrdif as $k=>$v){
				$opbal = $v[0]['xprime'];
				$table .= '<tr><td>'.$v[0]['xacc'].'</td><td>'.$v[0]['xdesc'].'</td><td></td><td></td><td></td><td></td><td></td></tr>';
				$table .= "<tr>";
				$table.='<td></td><td></td><td></td><td><strong>Opening Balance</strong></td>';
				if($opbal>=0){
						$table.='<td><strong>'.number_format(floatval($opbal), $this->decimals, '.', '').'</strong></td>';
						$finaldr+=$opbal;
					}else
						$table.='<td><strong>0</strong></td>';
				if($opbal<0){
						$table.='<td><strong>'.number_format(floatval(abs($opbal)), $this->decimals, '.', '').'</strong></td>';
						$finalcr+=$opbal;
					}else
						$table.='<td><strong>0</strong></td><td></td>';

				$table.='<td></td>';			
				$table .= "</tr>";

				$finalbal+=$opbal;
				
			}

		}	
		foreach($grouprec as $key=>$val){
			// $opbal=0;

			// foreach($obal as $k=>$v){
			// 	if($key==$v["xacc"])
			// 		$opbal=$v["xprime"];
			// }

			// $bal = $opbal;
			
			$totaldr = 0;
			$totalcr = 0;

			// if($opbal>0){
			// 	$totaldr = $opbal;
			// }else{
			// 	$totalcr = $opbal;
			// }
			
				$table .= '<tr><td>'.$key.'</td><td>'.$val[0]["xaccdesc"].'</td><td></td><td></td><td></td><td></td><td></td></tr>';
				$table .= "<tr>";
				$table.='<td></td><td></td><td></td><td><strong>Opening Balance</strong></td>';
				if($opbal>=0)
						$table.='<td><strong>'.number_format(floatval($opbal), $this->decimals, '.', '').'</strong></td>';
					else
						$table.='<td><strong>0</strong></td>';
				if($opbal<0)
						$table.='<td><strong>'.number_format(floatval(abs($opbal)), $this->decimals, '.', '').'</strong></td>';
					else
						$table.='<td><strong>0</strong></td><td></td>';

				$table.='<td></td>';			
				$table .= "</tr>";	
				foreach($val as $k=>$values){
					$bal += $values["xprime"];
					$table .= "<tr>";
						if($values["xprime"]>=0){
							$totaldr += $values["xprime"];
							$table .= '<td></td><td>'.$values["xdate"].'</td><td>'.$values["xvoucher"].'</td><td>'.$values["xnarration"].'</td><td>'.$values["xprime"].'</td><td>0</td>';
							if ($bal>=0)
								$table .= '<td>'.$bal.'</td>';
							else
								$table .= '<td>('.abs($bal).')</td>';
						}
						else{
							$totalcr += $values["xprime"];
							$table .= '<td></td><td>'.$values["xdate"].'</td><td>'.$values["xvoucher"].'</td><td>'.$values["xnarration"].'</td><td>0</td><td>'.abs($values["xprime"]).'</td>';
							if ($bal>=0)
								$table .= '<td>'.$bal.'</td>';
							else
								$table .= '<td>('.abs($bal).')</td>';
						}
					$table .= "</tr>";
					
				}
				$grandbal += $bal;

				$grandtotaldr += $totaldr;
				$grandtotalcr += $totalcr;
				$table .= '<tr><td></td><td></td><td></td><td><strong>Total</strong></td><td><strong>'.$totaldr.'</strong></td><td><strong>'.abs($totalcr).'</strong></td><td></td></tr>';	

		}
		$grandbal += $finalbal;
		$grandtotaldr += $finaldr;
		$grandtotaldr += $finalcr;
		// if($grandbal>=0){
		// 	$table .= '<tr><td></td><td></td><td></td><td><strong>All Accounts Total</strong></td><td><strong>'.$grandtotaldr.'</strong></td><td><strong>'.abs($grandtotalcr).'</strong></td><td><strong>'.$grandbal.'</td></tr></strong>';
		// }
		// else{
		// 	$table .= '<tr><td></td><td></td><td></td><td><strong>All Accounts Total</strong></td><td><strong>'.$grandtotaldr.'</strong></td><td><strong>'.abs($grandtotalcr).'</strong></td><td><strong>('.abs($grandbal).')</strong></td></tr>';
		// }

		//$table .= "</table>";

		return $table;

	}
	
}
