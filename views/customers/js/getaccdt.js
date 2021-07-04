$(function(){

	$('#xrate').change(function(){
		getTotalSalesAmount();
	});
	$('#xqty').change(function(){
		getTotalSalesAmount();
	});

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
					$('#xrate').val(o[0].xmrp/o[0].xcitem);
					$('#xqty').val(o[0].xcitem);

					var total = $('#xrate').val()*$('#xqty').val();

					$('#xtotalamt').val(total);
					
			}, 'json');
		});

	
});

function getTotalSalesAmount(){
	var rate = 0;
	var qty = 0;
	var totalamt = 0;
	if($('#xrate').val() != ""){
		rate = parseFloat($('#xrate').val());
	}
	if($('#xqty').val() != ""){
		qty = parseFloat($('#xqty').val());
	}
	totalamt = rate*qty;

	$('#xtotalamt').val(totalamt);
}

document.getElementById('xsepcus').style.display = 'none';
document.querySelectorAll(".input-group-btn")[4].style.display = 'none';
document.querySelectorAll(".control-label")[49].style.display = 'none';

function changeValue() {
	
	if (document.getElementById('xcustype').checked == true) {
		document.querySelectorAll(".input-group-btn")[4].style.display = 'none';
        document.getElementById('xsepcus').style.display = 'none';
        document.querySelectorAll(".control-label")[49].style.display = 'none';
    }else{
    	document.querySelectorAll(".input-group-btn")[4].style.display = 'block';
		document.getElementById('xsepcus').style.display = 'block';
		document.querySelectorAll(".control-label")[49].style.display = 'block';
	}
  }