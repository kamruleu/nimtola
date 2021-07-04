$(function(){
	$('#row4').hide();
	if($('#xacccrusage').val()=="Bank"){
		$('#row4').show();
	}else if($('#xacccrusage').val()!="Bank"){
		$('#row4').hide();
	}
	var acccr = "";		
	$('#xacccr').blur(function(){ 	
	
		acccr = $(this).val();
		var url = baseuri+"gljvvou/getaccdt/"+acccr;
		//$('#xitemdesc').val(url);
		
		$.get(url, function(o){ 
					$('#xacccrdesc').val(o[0].xdesc);
					$('#xacccrtype').val(o[0].xacctype);
					$('#xacccrusage').val(o[0].xaccusage);
					$('#xacccrsource').val(o[0].xaccsource);
					if(o[0].xaccusage=="Bank"){
						$('#row4').show();					
					}
					
			}, 'json');
	});
	

});