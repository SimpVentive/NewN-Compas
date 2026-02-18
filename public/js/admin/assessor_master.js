$(document).ready(function(){
	
	$('#assessor_master').validationEngine();
	$('#assessor_comp').validationEngine();
	$('.datepicker').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
	$('#emp_no').ajaxChosen({
	   dataType: 'json',
	   type: 'POST',
	   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});
	
	$('input[id="assessor_type"]').click(function(){
        if($(this).attr("value")=='INT'){
			$("#employee").toggle();
        }
    });
});
if(checkuser){
	check_user();
}
function check_user(){
	var add=$('#add_role_int').val();
	if(add=='Y'){
		var empid=$('#emp_no').val();
		if(empid!=''){
			$.ajax({
				type:"GET",
				url: BASE_URL+"/admin/checkUser?empid="+empid,
				success:function(resp){
					var res=resp.split('#$');
					if(res[0]==0){
						
						$('#role_name_int').css('display','none');
						$('#add_role_int').val('');
						toastr.error("User does not exists for the selected employee");
						return false;
					}else{
						if(res[1]){
							if(res[1]=='asr'){
								$('#add_role_int').val('');
								toastr.error("Assessor Role exists for the employee");
								return false;
							}else{
								//alert(res[1]);
								$('#role_name_int').css('display','block');
								var men=res[1].split('_');
								$('#menu_id_int').val(men[0]);
								$('#rolename_int').html(men[1]);									
								var resdt=res[0].split(',');
								$('#user_id_int').val(resdt[0]);
								$('#user_start_date_int').val(resdt[1]);
								$('#user_end_date_int').val(resdt[2]);
								$('#start_date_int').val(resdt[3]);
								$('#end_date_int').val(resdt[4]);
							}
						}
					}
					$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
				}
			});
		}else{//toastr.error("Please select Employee");return false;
		}
	}else{
		$('#rolename_int').val('');
		$('#role_name_int').css('display','none');
	}
}

if(checkrole){	
	check_role();	
}
function check_role(){
	var restype=$('#retype').val();
	var add=$('#add_role_ext').val();
	if(add=='Y'){
		$.ajax({
			type:"GET",
			url: BASE_URL+"/admin/checkRoleAsr",
			success:function(resp){
				if(resp==0){
					$('#role_name_ext').css('display','none');
					alertify.alert("Trainer Role does not exists");
					return false;
				}else{
					var data=resp.split('&*');
					$('#role_name_ext').css('display','block');
					$('#rolename_ext').html(data[1]);
					$('#menu_id_ext').val(data[0]);
					$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
				}
			}
		});		
	}else{
		$('#rolename_ext').val('');
		$('#role_name_ext').css('display','none');
	}
}

function open_employee(){
	var id=document.getElementById("assessor_type").value;
	if(id==='INT'){
		document.getElementById("employee").style.display="block";
		document.getElementById("int_assessor").style.display="block";
		document.getElementById("ext_assessor").style.display="none";
	}
	if(id==='EXT'){
		document.getElementById("employee").style.display="none";
		document.getElementById("int_assessor").style.display="none";
		document.getElementById("ext_assessor").style.display="block";
	}
}

function fetch_empdata(){
    var empno=document.getElementById('emp_no').value;
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
				$("#emp_no option[value='N/A']").attr("selected", true);
				return false;
			}else{
				if($response[0]!=""){//toastr.error($response[4]);
					//document.getElementById('emp_no').value=$response[0];
					document.getElementById('assessor_name').value=$response[1];
					document.getElementById('assessor_email').value=$response[2];
					document.getElementById('assessor_mobile').value=$response[4];
				}
				else{
					toastr.error("Employee details does not found with this Employee Number");
					//document.getElementById('emp_no').value='';
					document.getElementById('assessor_name').value='';
					document.getElementById('assessor_email').value='';
					document.getElementById('assessor_mobile').value='';
					return false;
				}
			}
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_emp_data_id?empnum="+empno,true);
    xmlhttp.send(); 
}

function readURL(input) {
     if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
             $('#blah').attr('src', e.target.result);
         }
         reader.readAsDataURL(input.files[0]);
     }
}

 
 $(document).ready(function() {
     $("#content div").hide(); // Initially hide all content
     $("#tabs li:first").attr("id","current"); // Activate first tab
     $("#content div:first").fadeIn(); // Show first tab content
    
     $('#tabs a').click(function(e) {
         e.preventDefault();
         $("#content div").hide(); //Hide all content
         $("#tabs li").attr("id",""); //Reset id's
         $(this).parent().attr("id","current"); // Activate this
         $('#' + $(this).attr('title')).fadeIn(); // Show content for current tab
		 
		$(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=25){w=250;}
			$('.chosen-select').next().css({'width':w});
		}).trigger('resize.chosen');
     });
	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=25){w=250;}
		$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');
 });
 
 $(document).ready(function() {
	$('.nav-tabs li').click(function(event){
		if ($(this).hasClass('disabled')) {
			return false;
		}
	});
	if(status!=''){
		if(status=='competency'){
			
			$('#competency_li').addClass('active');
			$('#infomation-info').removeClass('active');
			$('#competency-info').addClass('active');
			$('#questions-info').removeClass('active');
		}else if(status=='questions'){
			$('#questions_li').addClass('active');
			$('#infomation-info').removeClass('active');
			$('#competency-info').removeClass('active');
			$('#questions-info').addClass('active');
		}
	}
	else{
		$("#information_li").addClass('active');
		$('#infomation-info').addClass('active');
		$('#competency-info').removeClass('active');
		$('#questions-info').removeClass('active');
	} 
});



function open_level(id){
    var comp_id=document.getElementById('assessor_competencies'+id).value;
	if(comp_id!=''){
        var xmlhttp;
        if (window.XMLHttpRequest)
        { // code for IE7+, Firefox, Chrome, Opera, Safari
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
                document.getElementById("assessor_levels"+id).innerHTML=xmlhttp.responseText;
                //toastr.error(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/change_level_assessor?comp_id="+comp_id+"&row="+id,true);
        xmlhttp.send();
    }    
}

function open_scale(id){
    var level_id=document.getElementById('assessor_levels'+id).value;
	if(level_id!=''){
        var xmlhttp;
        if (window.XMLHttpRequest)
        { // code for IE7+, Firefox, Chrome, Opera, Safari
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
                document.getElementById("assessor_scale"+id).innerHTML=xmlhttp.responseText;
                //toastr.error(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/change_scale_assessor?level_id="+level_id+"&row="+id,true);
        xmlhttp.send();
    }    
}

function addsource_details_assessor(){
	var hiddtab="addgroup";
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
			var assessor_competencies=document.getElementById('assessor_competencies'+i).value;
			var assessor_levels=document.getElementById('assessor_levels'+i).value;
			var assessor_scale=document.getElementById('assessor_scale'+i).value;
			if(assessor_competencies==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			if(assessor_levels==''){
				toastr.error("Please select Level Name.");
				return false;
			}
			if(assessor_scale==''){
				toastr.error("Please select Scale.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
			var assessor_competencies1=document.getElementById('assessor_competencies'+l).value;
			var assessor_levels1=document.getElementById('assessor_levels'+l).value;
			var assessor_scale1=document.getElementById('assessor_scale'+l).value;
				if(k!=j){
					if(assessor_competencies==assessor_competencies1 && assessor_levels==assessor_levels1 && assessor_scale==assessor_scale1){
						toastr.error("All Ready Exists");
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
        var com_details=comp_details.split(',');
        var cam_ids='';
        for(var i=0;i<com_details.length;i++){
            cat1=com_details[i];
            cat2=cat1.split('*');
            if(cam_ids==''){
                cam_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                cam_ids=cam_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        cam_ids='';
    }
	
	$("#source_table_programs").append("<tr id='subgrd"+sub_iteration+"'><td><input type='checkbox' id='chkbox"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='assessor_comp_id"+sub_iteration+"' name='assessor_comp_id[]' value=''></td><td><select name='assessor_competencies[]' id='assessor_competencies"+sub_iteration+"' onchange='open_level("+sub_iteration+");' class='form-control m-b'><option value=''>Select</option>"+cam_ids+"</select></td><td><select name='assessor_levels[]' id='assessor_levels"+sub_iteration+"' onchange='open_scale("+sub_iteration+");'  class='form-control m-b'><option value=''>Select</option></select></td><td><select name='assessor_scale[]' id='assessor_scale"+sub_iteration+"'  class='form-control m-b'><option value=''>Select</option></select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}


function delete_casestudy(){
	var hiddtab="addgroup";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('source_table_programs');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		var a="chkbox"+bb;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd"+bb+"";
			//alert(b);
			var assessor_comp_id=document.getElementById("assessor_comp_id"+bb).value;
			//alert(calendar_act_id);
			if(assessor_comp_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_assessor_competency",
					global: false,
					type: "POST",
					data: ({val : assessor_comp_id}),
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
			var assessor_instrument_name=document.getElementById('assessor_instrument_name'+i).value;
			if(assessor_instrument_name==''){
				toastr.error("Please Select Assessor Instrument Name.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var assessor_instrument_name1=document.getElementById('assessor_instrument_name'+l).value;
				if(k!=j){
					if(assessor_instrument_name==assessor_instrument_name1){
						toastr.error("Instrument name should be Unique");
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
    
	if(inst_detail!=''){
        var inst_details=inst_detail.split(',');
        var inst_ids='';
        for(var i=0;i<inst_details.length;i++){
            cat1=inst_details[i];
            cat2=cat1.split('*');
            if(inst_ids==''){
                inst_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                inst_ids=inst_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        inst_ids='';
    }
	
	if(status_detail!=''){
        var status_details=status_detail.split(',');
        var status_ids='';
        for(var i=0;i<status_details.length;i++){
            cat1=status_details[i];
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
	
	$("#source_table_certified").append("<tr id='subgrd_inst"+sub_iteration+"'><td><input type='checkbox' id='chkbox_inst"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='assessor_instrument_id"+sub_iteration+"' name='assessor_instrument_id[]' value=''></td><td><select name='assessor_instrument_name[]' id='assessor_instrument_name"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+inst_ids+"</select></td><td><div class='input-group date'><input type='text' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' name='assessor_instrument_expiry[]' id='assessor_instrument_expiry"+sub_iteration+"' value='' class='validate[custom[date2]] datepicker form-control'><span class='input-group-addon'><span class='fa fa-calendar'></span></span></td><td><select name='assessor_instrument_status[]' id='assessor_instrument_status"+sub_iteration+"'  class='form-control m-b'><option value=''>Select</option>"+status_ids+"</select></td></tr>");
	$('.datepicker').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
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
			var assessor_instrument_id=document.getElementById("assessor_instrument_id"+bb).value;
			//alert(calendar_act_id);
			if(assessor_instrument_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_assessor_instrument",
					global: false,
					type: "POST",
					data: ({val : assessor_instrument_id}),
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


function addsource_details_assessor_validation(n){
	if(n==2){
	var hiddtab="addgroup";
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
			var assessor_competencies=document.getElementById('assessor_competencies'+i).value;
			var assessor_levels=document.getElementById('assessor_levels'+i).value;
			var assessor_scale=document.getElementById('assessor_scale'+i).value;
			if(assessor_competencies==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			if(assessor_levels==''){
				toastr.error("Please select Level Name.");
				return false;
			}
			if(assessor_scale==''){
				toastr.error("Please select Scale.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
			var assessor_competencies1=document.getElementById('assessor_competencies'+l).value;
			var assessor_levels1=document.getElementById('assessor_levels'+l).value;
			var assessor_scale1=document.getElementById('assessor_scale'+l).value;
				if(k!=j){
					if(assessor_competencies==assessor_competencies1 && assessor_levels==assessor_levels1 && assessor_scale==assessor_scale1){
						toastr.error("All Ready Exists");
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
    }
	
	if(n==3){
	var hiddtab="addgroup_certified";
	var ins_c=document.getElementById(hiddtab).value;
	if(ins_c!=''){
		var ins1_c=ins_c.split(",");
		var temp_c=0;
		for( var j=0;j<ins1_c.length;j++){
			if(ins1_c[j]>temp_c){
				temp_c=parseInt(ins1_c[j]);
			}
		}
		var maxa=Math.max(ins1_c);
		sub_iteration_c=parseInt(temp_c)+1;
		for( var j=0;j<ins1_c.length;j++){
			var i=ins1_c[j]; 
			var assessor_instrument_name=document.getElementById('assessor_instrument_name'+i).value;
			if(assessor_instrument_name==''){
				toastr.error("Please Select Assessor Instrument Name.");
				return false;
			}
			for( var k=0;k<ins1_c.length;k++){
				l=ins1_c[k];
				var assessor_instrument_name1=document.getElementById('assessor_instrument_name'+l).value;
				if(k!=j){
					if(assessor_instrument_name==assessor_instrument_name1){
						toastr.error("Instrument name should be Unique");
						return false;
					}
				}
			}
		}	
		sub_iteration_c=parseInt(temp_c)+1; 
	}
	else{
		sub_iteration=1;
		ins1_c=1;
		var ins1_c=Array(1);
	}	
    }
}
