jQuery(document).ready(function(){
	jQuery("#zoneform").validationEngine();	
});
function AddMore_expenses_chk_vald(){
	var tbl = document.getElementById("fleupload_tab_expense_id");
	var lastRow = tbl.rows.length;
	var lastrow1= lastRow+1;
	var hiddtab="inner_hidden_id_expenses";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
	   var ins1=ins.split(",");
	   var temp=0;
	   if(ins1.length>1){
	   for( var j=0;j<ins1.length;j++){
		   if(ins1[j]>temp){
			   temp=ins1[j];
		   }
	   }
	   sub_iteration=parseInt(temp)+1;
	   for( var j=0;j<ins1.length;j++){
		   var i=ins1[j];
		   var exp_type=document.getElementById('role_type['+i+']').value;
			if(exp_type==''){
			   toastr.error("Please select State");
			   return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('role_type['+l+']').value;
					if(k!=j){
						if(k!=j){
						   if(exp_type==item_type2){
								toastr.error("Same State has been added already added");
								return false;
						   }
                       }
					}
				} 
			}
		}
	}
	}
	else{
	   sub_iteration=1;
	   ins1=1;
	   var ins1=Array(1);
	}
}
