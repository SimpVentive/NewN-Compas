jQuery(document).ready(function(){
	jQuery("#budget_period_edit").validationEngine();
	
	
});
function validation(){
	var tb1=document.getElementById('period_tabless');
	var lastRow=tb1.rows.length;
	var lastRow1=lastRow-1;
	for(var i=0;i<lastRow1;i++){
		var name=document.getElementById('period_name_'+i).value;
		if(name==''){
			alertify.alert("Please Enter Period Name");
			return false;
		}
		var month_from=document.getElementById('month_'+i).value; 
		if(month_from==''){
			alertify.alert("Please Enter Period From");
			return false;
		}
		var month_to=document.getElementById('month_to_'+i).value; 
		if(month_to==''){
			alertify.alert("Please Enter Period To");
			return false;
		}
	}
}

function cancel_update(){
	window.location=BASE_URL+"/admin/period_details";
}