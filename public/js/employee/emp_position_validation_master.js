$(document).ready(function(){
	$('#assessment_master').validationEngine();
	$("#cloneButton1").click(function () {
		$('#accountabilities').clone().insertAfter(".smallBox");
    });
});

$(document).ready(function() {
	$('.test-nav-panel li').click(function(event){
		if ($(this).hasClass('disabled')) {
			return false;
		}
	});
	if(status!=''){
		if(status=='profile'){
			$('#compentencies_li').addClass('active');
			$('#self-assessment').addClass('active');
			$('#career-planning').removeClass('active');
			$('#strengths-tab').removeClass('active');
		}
		else if(status=='career'){
			$('#employees_li').addClass('active');
			$('#career-planning').css("display", "block");
			$('#compentencies_li').addClass('active');
			$('#strengths_li').removeClass('active');
			$('#strengths-tab').css("display", "none");
			$('#self-assessment').css("display", "none");
		}
		else if(status=='strength'){
			$('#strengths_li').addClass('active');
			$('#strengths-tab').css("display", "block");
			$('#compentencies_li').addClass('active');
			$('#employees_li').addClass('active');
			$('#career-planning').css("display", "none");
			$('#self-assessment').css("display", "none");
		}
		
	}
	else{
		$("#compentencies_li").addClass('active');
		$('#self-assessment').addClass('active');
		$('#career-planning').removeClass('active');
		$('#strengths-tab').removeClass('active');
	} 
});



function addsource_details_kra(){
	var hiddtab="addgroup_kra";
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
			var kra_des=document.getElementById('kra_des_'+i).value;
			var kra_kri=document.getElementById('kra_kri_'+i).value;
			var kra_uom=document.getElementById('kra_uom_'+i).value;
			if(kra_des==''){
				toastr.error("Please Enter KRA.");
				return false;
			}
			if(kra_kri==''){
				toastr.error("Please Enter KPI.");
				return false;
			}
			if(kra_uom==''){
				toastr.error("Please Enter UOM.");
				return false;
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}
	
	$("#assessement_kra").append("<tr id='subgrd_kra_"+sub_iteration+"'><td><input type='checkbox' id='chkbox_"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='pos_kra_tray_id_"+sub_iteration+"' name='pos_kra_tray_id[]' value=''></td><td><input type='text' name='kra_des[]' id='kra_des_"+sub_iteration+"' class='form-control'></td><td><input type='text' name='kra_kri[]' id='kra_kri_"+sub_iteration+"' class='form-control'></td><td><input type='text' name='kra_uom[]' id='kra_uom_"+sub_iteration+"' class='form-control'></td><td><input type='text' name='reason_kra[]' id='reason_kra_"+sub_iteration+"' class='form-control'></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}


function delete_kra(){
	var hiddtab="addgroup_kra";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('assessement_kra');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		var a="chkbox_"+bb;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd_kra_"+bb+"";
			//alert(b);
			var pos_kra_tray_id=document.getElementById("pos_kra_tray_id_"+bb).value;
			//alert(calendar_act_id);
			if(pos_kra_tray_id!=' '){
				$.ajax({
					url: BASE_URL+"/employee/delete_validation_kra",
					global: false,
					type: "POST",
					data: ({val : pos_kra_tray_id}),
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

function addsource_details_position_validation(){
	var hiddtab="addgroup_position";
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
			var position_id=document.getElementById('position_id'+i).value;
			var pos_status=document.getElementById('assessment_pos_status'+i).value;
			if(position_id==''){
				toastr.error("Please Select Position Name.");
				return false;
			}
			if(pos_status==''){
				toastr.error("Please Select Position Status.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var position_id1=document.getElementById('position_id'+l).value;
				if(k!=j){
					if(position_id==position_id1){
						toastr.error("Position name should be Unique");
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
	if(pos_details!=''){
        var pos_detail=pos_details.split(',');
        var pos_ids='';
        for(var i=0;i<pos_detail.length;i++){
            cat1=pos_detail[i];
            cat2=cat1.split('*');
            if(pos_ids==''){
                pos_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                pos_ids=pos_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        pos_ids='';
    }
	
	if(status_details!=''){
        var status_detail=status_details.split(',');
        var status_ids='';
        for(var i=0;i<status_detail.length;i++){
            cat1=status_detail[i];
            cat2=cat1.split('*');
            if(status_ids==''){
                status_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                status_ids=status_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        status_ids='';
    }
	$("#assessement_position").append("<tr id='subgrd_position"+sub_iteration+"'><td><input type='checkbox' id='chkbox"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='assessment_pos_id"+sub_iteration+"' name='assessment_pos_id[]' value=''></td><td><select name='position_id[]' id='position_id"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+pos_ids+"</select></td><td><select name='assessment_pos_status[]' id='assessment_pos_status"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+status_ids+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
	
						return false;
	}	
    
}


function work_info_view(val_id,id,val_pos_id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('workinfodetails'+id).innerHTML=xmlhttp.responseText;
			$('#emp_no_'+id).ajaxChosen({
				   dataType: 'json',
				   type: 'POST',
				   url:BASE_URL+'/admin/autoemployee'
			},{
				   loadingImg: 'loading.gif'
			});	
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/validation_employee_details?val_id="+val_id+"&pos_id="+id+"&val_pos_id="+val_pos_id,true);
	xmlhttp.send();     
}

function fetch_empdata(val_id,pos_id){
    var empno=document.getElementById('emp_no_'+pos_id).value;
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            $response=xmlhttp.responseText.split('@');
			if($response[0]==0){
				toastr.error($response[1]);
				//document.getElementById('emp_no').value='';
				$('#emp_no_'+pos_id).val('').trigger("chosen:updated");
			//	$("#emp_no option[value='N/A']").attr("selected", true);
				return false;
			}else{
				if($response[0]!=""){//toastr.error($response[4]);
					document.getElementById('emp_name_'+pos_id).value=$response[1];
					document.getElementById('department_'+pos_id).value=$response[2];
					document.getElementById('position_'+pos_id).value=$response[4];
					document.getElementById('location_'+pos_id).value=$response[5];
				}
				else{
					toastr.error("Employee details does not found with this Employee Number");
					document.getElementById('emp_no_'+pos_id).value='';
					document.getElementById('emp_name_'+pos_id).value='';
					document.getElementById('department_'+pos_id).value='';
					document.getElementById('position_'+pos_id).value='';
					document.getElementById('location_'+pos_id).value='';
					return false;
				}
			}
	
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_emp_data_id_validation?empnum="+empno+"&val_id="+val_id+"&pos_id="+pos_id,true);
    xmlhttp.send(); 
}

function open_comp_level(comp_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('level_comp'+comp_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/employee/getcomp_level?comp_id="+comp_id,true);
	 xmlhttp.send();    
}

