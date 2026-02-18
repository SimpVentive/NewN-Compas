//Start of Script for TNA Setup
$(document).ready(function(){
	$('#tna').validationEngine();
	$('#tna_form').validationEngine();
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeYear: true, changeMonth: true });
	
});


$(document).ready(function(){
	
    $('input[id="department_source"]').click(function(){
        if($(this).attr("value")=="dep"){
            $("#departments").show();
			$("#grades").hide();
			$("#location").hide();
        }
        
    });
	$('input[id="grade_source"]').click(function(){
        if($(this).attr("value")=="gra"){
			$("#departments").hide();
			$("#grades").show();
			$("#location").hide();
        }
    });
	$('input[id="location_source"]').click(function(){
        if($(this).attr("value")=="loc"){
			$("#departments").hide();
			$("#grades").hide();
			$("#location").show();
        }
    });
	
});

function AddGrade(){
	var hiddtab="subgradecount";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=ins1[j];
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j]; 
			var item_type=document.getElementById('program_id['+i+']').value;
			var status_p=document.getElementById('status_program['+i+']').value;
			
			if(item_type==''){
				alertify.alert("Please select Program Name");
				return false;
			}else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('program_id['+l+']').value;
					if(k!=j){
						if(item_type==item_type2){
							alertify.alert("Program Name already selected");
							return false;
						}
					}
				}
			}
			if(status_p==''){
				alertify.alert("Please select Status");
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
	if(programs!=''){
        var program=programs.split(',');
        var program_view='';
        for(var i=0;i<program.length;i++){
            program1=program[i];
            program2=program1.split('*');
            if(program_view==''){
                program_view="<option value='"+program2[0]+"'>"+program2[1]+"</option>";
            }else{
                program_view=program_view+"<option value='"+program2[0]+"'>"+program2[1]+"</option>";
            }
        }
    }else{
        program_view='';
    }
	if(status_view!=''){
        var status_v=status_view.split(',');
        var status_check='';
        for(var i=0;i<status_v.length;i++){
            status_v1=status_v[i];
            status_v2=status_v1.split('*');
            if(status_check==''){
                status_check="<option value='"+status_v2[0]+"'>"+status_v2[1]+"</option>";
            }else{
                status_check=status_check+"<option value='"+status_v2[0]+"'>"+status_v2[1]+"</option>";
            }
        }
    }else{
        status_check='';
    }
	$("#sub_grade_table").append("<tr id='subgrd"+sub_iteration+"'><td><input type='checkbox' id='tna_pro_id"+sub_iteration+"' name='tna_pro_id' value='"+sub_iteration+"'></td><td><select name='program_id[]' id='program_id["+sub_iteration+"]' class='input-large'><option value=''>Select</option>"+program_view+"</select></td><td><select name='status[]' id='status_program["+sub_iteration+"]' class='input-large'><option value=''>Select</option>"+status_check+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
		
}
function DelGrade(){
	var ins=document.getElementById('subgradecount').value;
	//alert(ins);
	var arr1=ins.split(",");
	var flag=0;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="subgrade"+bb+"";
		//alert(a);
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd"+b+"";
			var seclocid=document.getElementById("sub_grade_id"+b+"").value;
			if(seclocid!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_subgrade",
					global: false,
					type: "POST",
					data: ({val : seclocid}),
					dataType: "html",
					async:false,
					success: function(msg){
					}
				}).responseText;
			}
			for(var j=(arr1.length-1); j>=0; j--) {
				if(arr1[j]==b) {
					arr1.splice(j, 1);
					break;
				}  
			}
			flag++;
			$("#"+c).remove();
		}
	}
	if(flag==0){
		alertify.alert("Please select the Value to Delete");
		return false;
	}
	document.getElementById('subgradecount').value=arr1;
}

function work_info_view(id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('workinfodetails').innerHTML="loading..."
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById('workinfodetails').innerHTML=xmlhttp.responseText;
		$("#supervisor_1").ajaxChosen({
				   dataType: 'json',
				   type: 'POST',
				   url:BASE_URL+'/admin/autoemployee'
			},{
				   loadingImg: 'loading.gif'
			});
			
		}
	}
	
	xmlhttp.open("GET",BASE_URL+"/admin/mandatory_details?tna_source_id="+id,true);
	xmlhttp.send();
}

function checkcategory(){
	var id=document.getElementById('category').value;
	var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('workinfodetails').innerHTML="loading..."
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('program').innerHTML=xmlhttp.responseText;
			$("#program").chosen().trigger('chosen:updated');
		}
	}
	
	xmlhttp.open("GET",BASE_URL+"/admin/mandatoryprogram?id="+id,true);
	xmlhttp.send();
}


$('.chosen-toggle').each(function(index) {
    $(this).on('click', function(){
         $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
    });
});

function checkzones(){
	var id=document.getElementById('location_zones').value;
	var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//document.getElementById('workinfodetails').innerHTML="loading..."
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('location_select').innerHTML=xmlhttp.responseText;
			$("#location_select").chosen().trigger('chosen:updated');
		}
	}
	
	xmlhttp.open("GET",BASE_URL+"/admin/mandatorylocation?id="+id,true);
	xmlhttp.send();
}