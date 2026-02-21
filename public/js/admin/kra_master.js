$(document).ready(function(){
	$('#kra').validationEngine();
	
});



function addsource_details_certified(){
	var hiddtab="addgroup_certified";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=parseInt(ins1[j]);
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j]; 
			var comp_def_id=document.getElementById('comp_def_id'+i).value;
			if(comp_def_id==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var comp_def_id1=document.getElementById('comp_def_id'+l).value;
				if(k!=j){
					if(comp_def_id==comp_def_id1){
						toastr.error("Competency name should be Unique");
						return false;
					}
				}
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}	
    
	if(comp_details!=''){
        var comp_detail=comp_details.split(',');
        var comp_ids='';
        for(var i=0;i<comp_detail.length;i++){
            cat1=comp_detail[i];
            cat2=cat1.split('*');
            if(comp_ids==''){
                comp_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                comp_ids=comp_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        comp_ids='';
    }
	
	if(status_details!=''){
        var status_detail=status_details.split(',');
        var status_ids='';
        for(var i=0;i<status_detail.length;i++){
            sat1=status_detail[i];
            sat2=sat1.split('*');
            if(status_ids==''){
                status_ids="<option value='"+sat2[0]+"'>"+sat2[1]+"</option>";
            }else{
                status_ids=status_ids+"<option value='"+sat2[0]+"'>"+sat2[1]+"</option>";
            }
        }
    }else{
        status_ids='';
    }
	
	$("#source_table_certified").append("<tr id='subgrd_inst"+sub_iteration+"'><td><input type='checkbox' id='chkbox_inst"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='kra_comp_master_id"+sub_iteration+"' name='kra_comp_master_id[]' value=''></td><td><select name='comp_def_id[]' id='comp_def_id"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+comp_ids+"</select></td><td><select name='status[]' id='status"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+status_ids+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}


function delete_certified(){
	var hiddtab="addgroup_certified";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('source_table_certified');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		var a="chkbox_inst"+bb;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd_inst"+bb+"";
			//alert(b);
			var kra_comp_master_id=document.getElementById("kra_comp_master_id"+bb).value;
			//alert(calendar_act_id);
			if(kra_comp_master_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_comp_kra",
					global: false,
					type: "POST",
					data: ({val : kra_comp_master_id}),
					dataType: "html",
					async:false,
					success: function(msg){
					}
				}).responseText;
			} 
			for(var j=(arr1.length-1); j>=0; j--) {
				if(parseInt(arr1[j])==bb) {
					arr1.splice(j, 1);
					break;
				}  
			}
			flag++;
			$("#"+c).remove();
		}
	}
	if(flag==0){
		toastr.error("Please select the Value to Delete");
		return false;
	}
	document.getElementById(hiddtab).value=arr1;
}


function addsource_details_certified_validations(){
	var hiddtab="addgroup_certified";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		if(ins1.length>1){
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=parseInt(ins1[j]);
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j]; 
			var comp_def_id=document.getElementById('comp_def_id'+i).value;
			if(comp_def_id==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var comp_def_id1=document.getElementById('comp_def_id'+l).value;
				if(k!=j){
					if(comp_def_id==comp_def_id1){
						toastr.error("Competency name should be Unique");
						return false;
					}
				}
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}	
    
}
