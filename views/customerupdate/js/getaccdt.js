$(function(){

	$('#xcus').blur(function(){
		var cus = $(this).val();
		var url = baseuri+"jsondata/getcustomer/"+cus;
				
		$.get(url, function(o){ 
					$('#xshort').val(o[0].xshort);
					$('#xadd1').val(o[0].xadd1);
					
			}, 'json');
		});

	$('#xagent').blur(function(){
		var agent = $(this).val();
		var url = baseuri+"jsondata/getagent/"+agent;
				
		$.get(url, function(o){ 
					$('#xagname').val(o[0].xshort);
					$('#xagadd1').val(o[0].xadd1);
					
			}, 'json');
		});
	
	$('#xitemcode').blur(function(){
		var item = $(this).val();
		var url = baseuri+"jsondata/getitemdt/"+item;
				
		$.get(url, function(o){ 
					$('#xitemdesc').val(o[0].xdesc);
					
			}, 'json');
		});
	
});