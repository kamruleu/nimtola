
function showitem(post)	{
	var xpost=post;		
		$.get(xpost, function(o){
				if(o[0].xbal>0){
					$('#xitemcode').val(o[0].xitemcode);
					$('#xdesc').val(o[0].xitemdesc);
					$('#xqty').val(o[0].xbal);
					$('#xratepur').val(o[0].xratepur);
					$('#xrow').val(o[0].xrow);
					
					//$('#xwh').append($('<option>', {value: o[0].xwh, text: o[0].xwh}));
				}
			}, 'json');
			
	
}