$(function(){

	var dcls = "2";		
	$('#xitemcode').blur(function(){
		var itemcode = $(this).val();
		var url = baseuri+"jsondata/getItemNamePrice/"+itemcode;
		
		$.get(url, function(o){ 
					$('#xitemdesc').val(o[0].xdesc);					
			}, 'json');
							
	});
});