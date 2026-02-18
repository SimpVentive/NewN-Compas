$(document).ready(function(){
	$('#assessment_master').validationEngine();
	$('#case_master').validationEngine();
    $("#case_master").bind("jqv.form.validating", function(event){
        var fieldsWithValue = $('input[id^="1check_position_"]').filter(function(){
           if($(this).prop("checked")){
                return true;
            }
        });
        if(fieldsWithValue.length<1){
            $('input[id^="1check_position_"]').addClass('validate[required,funcCall[requiredOneOfGroup]]');
        }
        var fieldsWithValue1 = $('input[id^="assessment_type"]').filter(function(){
           if($(this).prop("checked")){
                return true;
            }
        });
        if(fieldsWithValue1.length<1){
            $('input[id^="assessment_type"]').addClass('validate[required,funcCall[requiredOneOfGroup1]]');
        }
    });

    $("#case_master").bind("jqv.form.result", function(event, errorFound){
        $('input[id^="1check_position_"]').removeClass('validate[required,funcCall[requiredOneOfGroup]]');
        $('input[id^="assessment_type"]').removeClass('validate[required,funcCall[requiredOneOfGroup1]]');
    });
});

function requiredOneOfGroup(field, rules, i, options){
    var fieldsWithValue = $('input[id^="1check_position_"]').filter(function(){
           if($(this).prop("checked")){
                return true;
            }
    });
    if(fieldsWithValue.length<1){
        return "Please select At least one option.";
    }
}
/*
function requiredOneOfGroup1(field, rules, i, options){
    var fieldsWithValue1 = $('input[id^="assessment_type"]').filter(function(){
           if($(this).prop("checked")){
                return true;
            }
    });
    if(fieldsWithValue1.length<1){
        return "Please select At least one option.";
    }
}*/

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
		}
	}
	else{
		$("#information_li").addClass('active');
		$('#infomation-info').addClass('active');
		$('#competency-info').removeClass('active');
	} 
});



function addsource_details_position(){
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
	}	
    
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

}


function delete_position(){
	var hiddtab="addgroup_position";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('assessement_position');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		var a="chkbox"+bb;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd_position"+bb+"";
			//alert(b);
			var assessment_pos_id=document.getElementById("assessment_pos_id"+bb).value;
			//alert(calendar_act_id);
			if(assessment_pos_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_assessment_position",
					global: false,
					type: "POST",
					data: ({val : assessment_pos_id}),
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

function open_assessment_weightage(id,a_id){
	var type_id=document.getElementById('ass_type_'+id).value;
	var xmlhttp;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('assessment_type_details').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/ass_select_weightage?id="+type_id+"&a_id="+a_id,true);
	xmlhttp.send();	
}

function enrolltype(id,type){
	var enroll_type=document.getElementById('enroll_type_'+id).value;
	document.getElementById('enrollment_div_'+id).innerHTML="";
	if(enroll_type==1){
		single_enroll(id,type);
	}
	else if(enroll_type==2){
		$('#enrollment_div_'+id).hide();
		$('#bulk_enrollment_div_'+id).show();
	}
	$('#self_emp_enroll'+id).validationEngine({
           validateNonVisibleFields: true/*, 
           prettySelect : true,
           useSuffix: "_chosen"*/
  });
}

function single_enroll(id,type){
		$('#enrollment_div_'+id).show();
		$('#bulk_enrollment_div_'+id).hide();
	var param='"enrollment_div_'+id+'"';
	var typ='"'+type+'"';
    document.getElementById('enrollment_div_'+id).innerHTML="<h4 class='header blue bolder smaller'>Single Enrollment</h4>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Employee Number<sup><font color='#FF0000'>*</font></sup>:</label>\n\
			<div class='col-sm-5'>\n\
			<div id='idElem_chosen'></div>\n\
				<select name='emp_no'  id='emp_no_"+id+"' onChange='fetch_empdata("+id+","+typ+")'  class='validate[required] form-control m-b'  data-prompt-position='inline' data-prompt-target='idElem_chosen'>\n\
					<option value=''>Select</option></select>\n\
			</div>\n\
		</div>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Employee Name:</label>\n\
			<div class='col-sm-5'>\n\
				<input type='text' class='form-control' name='emp_name' id='emp_name_"+id+"' value='' readonly>\n\
			</div>\n\
		</div>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Department:</label>\n\
			<div class='col-sm-5'>\n\
				<input type='text' class='form-control' name='department' id='department_"+id+"' value='' readonly>\n\
			</div>\n\
		</div>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Position:</label>\n\
			<div class='col-sm-5'>\n\
				<input type='text' class='form-control' name='position' id='position_"+id+"' value='' readonly>\n\
			</div>\n\
		</div>\n\
		<div class='hr-line-dashed'></div>\n\
		<div class='form-group'>\n\
		<div class=' col-sm-offset-9'>\n\
			<input type='submit' name='single_save'  id='single_save' value='Save' class='btn btn-success' >&nbsp;&nbsp;&nbsp;\n\
			<input type='button' class='btn btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div>\n\
		</div>";
    document.getElementById('emp_name_'+id).focus();
	$('#emp_no_'+id).ajaxChosen({
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});	
}

function fetch_empdata(id,type){
    var empno=document.getElementById('emp_no_'+id).value;
	var assessment_id=document.getElementById('assessment_id_employee_'+id).value;
	var position_id=document.getElementById('position_id_employee_'+id).value;
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
				$('#emp_no_'+id).val('').trigger("chosen:updated");
			//	$("#emp_no option[value='N/A']").attr("selected", true);
				return false;
			}else{
				if($response[0]!=""){//toastr.error($response[4]);
					document.getElementById('emp_name_'+id).value=$response[1];
					document.getElementById('department_'+id).value=$response[2];
					document.getElementById('position_'+id).value=$response[4];
				}
				else{
					toastr.error("Employee details does not found with this Employee Number");
					document.getElementById('emp_no_'+id).value='';
					document.getElementById('emp_name_'+id).value='';
					document.getElementById('department_'+id).value='';
					document.getElementById('position_'+id).value='';
					return false;
				}
			}
			
	$('#self_emp_enroll'+id).validationEngine({
           validateNonVisibleFields: true, 
           prettySelect : true,
           useSuffix: "_chosen"
  });
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_emp_data_id_assessment?empnum="+empno+"&assessment_id="+assessment_id+"&position_id="+position_id+"&type="+type,true);
    xmlhttp.send(); 
}

function enrolltype_assessor(id){
	var enroll_type_id=document.getElementById('enroll_type_assessor_'+id).value;
	document.getElementById('enrollment_div_assessor_'+id).innerHTML="";
	if(enroll_type_id==1){
		single_enroll_assessor(id);
	}
}

function single_enroll_assessor(id){
	$('#self_emp_assessor_single'+id).validationEngine({
           validateNonVisibleFields: true, 
           prettySelect : true,
           useSuffix: "_chosen"
  });
	// To fetch Location Details from lms_admin_emp_creation.php page
    if(status_val!=''){
        var locid=status_val.split(',');
        var locations='';
        for(var i=0;i<locid.length;i++){
            loc1=locid[i];
            loc2=loc1.split('*');
            if(locations==''){
                locations="<option value='"+loc2[0]+"'>"+loc2[1]+"</option>";
            }else{
                locations=locations+"<option value='"+loc2[0]+"'>"+loc2[1]+"</option>";
            }
        }
    }
    else{
        locations='';
    }
	var param='"enrollment_div_assessor_'+id+'"';
    document.getElementById('enrollment_div_assessor_'+id).innerHTML="<div class='modal-body'>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Assessor Name<sup><font color='#FF0000'>*</font></sup>:</label>\n\
		<input type='hidden' name='assessment_pos_assessor_id' id='assessment_pos_assessor_id' value=''>\n\
			<div class='col-sm-8'>\n\
				<select name='emp_no_assessor'  id='emp_no_assessor_"+id+"' onChange='fetch_empdata_assessor("+id+")'  class='validate[required, ajax[ajaxAssessorEmpsp]] form-control m-b' >\n\
					<option value=''>Select</option></select>\n\
			</div>\n\
		</div>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Assessor Name:</label>\n\
			<div class='col-sm-8'>\n\
				<input type='text' class='form-control' name='assessor_name' id='assessor_name_"+id+"' value='' readonly>\n\
			</div>\n\
		</div>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Assessor Email-id:</label>\n\
			<div class='col-sm-8'>\n\
				<input type='text' class='form-control' name='assessor_email' id='assessor_email_"+id+"' value='' readonly>\n\
			</div>\n\
		</div>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Assessor Mobile NO:</label>\n\
			<div class='col-sm-8'>\n\
				<input type='text' class='form-control' name='assessor_mobile' id='assessor_mobile_"+id+"' value='' readonly>\n\
			</div>\n\
		</div>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Assessor Employee Views:</label>\n\
			<div class='col-sm-8'>\n\
				<select id='emp_display_"+id+"' name='emp_display' class='validate[required] form-control m-b'>\n\
						<option value=''>Select</option>"+locations+"\n\
				</select>\n\
			</div>\n\
		</div>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Assessor Permission:</label>\n\
			<div class='col-sm-8'>\n\
				<select id='assessor_per_"+id+"' name='assessor_per' class='validate[required] form-control m-b'>\n\
						<option value=''>Select</option>"+locations+"\n\
				</select>\n\
			</div>\n\
		</div>\n\
		<div class='form-group'><label class='col-sm-3 control-label'>Assessor Cut off value:</label>\n\
			<div class='col-sm-8'>\n\
				<input type='text' class='form-control' name='assessor_val' id='assessor_val_"+id+"' class='validate[required,custom[number]] form-control'>\n\
			</div>\n\
		</div>\n\
		</div>\n\
		<div class='modal-footer'>\n\
			<input type='submit' name='single_save'  id='single_save' value='Save' class='btn btn-primary' onclick='return enrol_attach_valid()' >&nbsp;&nbsp;&nbsp;\n\
			<input type='button' class='btn btn-danger'  data-dismiss='modal' value='cancel'/>\n\
		</div>";
    document.getElementById('assessor_name_'+id).focus();
	$('#emp_no_assessor_'+id).ajaxChosen({
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/assessor_autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});
	//resize the chosen on window resize
	$(window).on('resize.chosen', function() {
	var w = $('#emp_no_assessor_'+id).parent().width();
	if(w<=66.6667){
		w=350;
	}
	$('#emp_no_assessor_'+id).next().css({'width':w});
	}).trigger('resize.chosen');
	
}

function fetch_empdata_assessor(id){
    var empno=document.getElementById('emp_no_assessor_'+id).value;
	var ass_id=document.getElementById('assessment_id_assessor').value;
	//var pos_id=document.getElementById('position_id_assessor').value;
	var pos_id=id;
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
			
            $response=xmlhttp.responseText.split('%');
			
			if($response[0]==0){
				toastr.error($response[1]);
				//document.getElementById('emp_no').value='';
				//$("#emp_no_assessor_"+id+" option[value='']").attr("selected", true);
				$("#emp_no_assessor_"+id).val('').trigger("chosen:updated");
				return false;
			}else{
				if($response[0]!=""){//toastr.error($response[4]);
					document.getElementById('assessor_name_'+id).value=$response[1];
					document.getElementById('assessor_email_'+id).value=$response[2];
					document.getElementById('assessor_mobile_'+id).value=$response[3]; 
				}
				else{
					toastr.error("Employee details does not found with this Employee Number");
					document.getElementById('emp_no_assessor_'+id).value='';
					document.getElementById('assessor_name_'+id).value='';
					document.getElementById('assessor_email_'+id).value='';
					document.getElementById('assessor_mobile_'+id).value=''; 
					return false;
				}
			}
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_emp_data_id_assessor?empnum="+empno+"&ass_id="+ass_id+"&pos_id="+pos_id,true);
    xmlhttp.send(); 
}

function open_position(ass_id,ids,ass_type){
	//alert(ids);
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
			document.getElementById("position_details"+ids).innerHTML=xmlhttp.responseText;
			$('#ass_test_validation'+ids).validationEngine();
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/comp_position_details?assessment_id="+ass_id+"&position_id="+ids+"&ass_type="+ass_type,true);
	xmlhttp.send();
}

function open_cri(id){
	var res_val=document.getElementById('critical'+id).value;
	if(res_val==='yes'){
		document.getElementById('cri_info'+id).style.display='block';
	}else{
		document.getElementById('cri_info'+id).style.display='none';
	}
}

function open_cri_no(id){
	var res_val=document.getElementById('none'+id).value;
	if(res_val==='no'){
		document.getElementById('cri_info'+id).style.display='none';
	}else{
		document.getElementById('cri_info'+id).style.display='block';
	}
}

function open_percentage(id){
	/* var res_val=id.value; */
	var res_val=document.getElementById(id).value;
	var ass_count=document.getElementById('ass_'+id).value;
	var disp_question=document.getElementById('no_questions').value;
	var per_value=(Math.round((res_val/disp_question)*100,1));
	//alert(res_val+"++"+ass_count);
	if(parseInt(ass_count)<parseInt(res_val)){
		toastr.error("You cannot add value more then "+disp_question+"");
	}
	/* else{
		if(id=='C1'){
			var c2=(disp_question-res_val);
			document.getElementById('C2').value=parseInt(c2);
			per_value_c2=(100-per_value);
			var total_c2=(per_value_c2+"%");
			document.getElementById('per_C2').value =total_c2;
		}
		if(id=='C2'){
			var c1=(disp_question-res_val);
			document.getElementById('C1').value=parseInt(c1);
			per_value_c1=(100-per_value);
			var total_c1=(per_value_c1+"%");
			document.getElementById('per_C1').value =total_c1;
		}
		if(id=='C3'){
			var c3=(disp_question-res_val);
			document.getElementById('C3').value=parseInt(c3);
			per_value_c3=(100-per_value);
			var total_c3=(per_value_c3+"%");
			document.getElementById('per_C3').value =total_c3;
		}
		if(id=='C4'){
			var c4=(disp_question-res_val);
			document.getElementById('C4').value=parseInt(c4);
			per_value_c4=(100-per_value);
			var total_c4=(per_value_c4+"%");
			document.getElementById('per_C4').value =total_c4;
		}
		if(id=='C5'){
			var c5=(disp_question-res_val);
			document.getElementById('C5').value=parseInt(c5);
			per_value_c5=(100-per_value);
			var total_c5=(per_value_c5+"%");
			document.getElementById('per_C5').value =total_c5;
		}
		var total=(per_value+"%");
		document.getElementById('per_'+id).value =total;
	} */
	
}


function addass_details_inbasket($ass_id,ids,ass_type){
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
			document.getElementById("inbasket_model"+ids).innerHTML=xmlhttp.responseText;
			$('#compinbasket').validationEngine();
			$('#inbasket_form').validationEngine();
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/position_inbasket_details?assessment_id="+$ass_id+"&position_id="+ids+"&ass_type="+ass_type,true);
	xmlhttp.send();
}


function addass_details_behavorial($ass_id,ids,ass_type){
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
			document.getElementById("behavorial_model"+ids).innerHTML=xmlhttp.responseText;
			$('#behavorial_form').validationEngine();
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/position_behavorial_details?assessment_id="+$ass_id+"&position_id="+ids+"&ass_type="+ass_type,true);
	xmlhttp.send();
}

function addass_details_casestudy($ass_id,ids,ass_type){
	
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
			document.getElementById("casestudy_model"+ids).innerHTML=xmlhttp.responseText;
			$('#compinbasket').validationEngine();
			$('#case_study_form').validationEngine();
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/position_casestudy_details?assessment_id="+$ass_id+"&position_id="+ids+"&ass_type="+ass_type,true);
	xmlhttp.send();
}

function addass_details_fishbone($ass_id,ids,ass_type){
	
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
			document.getElementById("fishbone_model"+ids).innerHTML=xmlhttp.responseText;
			$('#compinbasket').validationEngine();
			$('#fishbone_form').validationEngine();
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/position_fishbone_details?assessment_id="+$ass_id+"&position_id="+ids+"&ass_type="+ass_type,true);
	xmlhttp.send();
}


function delete_assessor(id){
	var ins=document.getElementById('hidden_val_'+id).value;	
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('newtableid_'+id);
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="checkbox_assessor_"+id+"["+bb+"]";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			//alert(b);
			var c="innerdata_"+id+"_"+b;
			var ass_id=document.getElementById("assessment_pos_assessor_id_"+id+"["+b+"]").value;
			if(ass_id!=""){
				$.ajax({
					url: BASE_URL+"/admin/delete_assessor_data",
					global: false,
					type: "POST",
					data: ({assessment_pos_assessor_id : ass_id}),
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
		toastr.error("Please select the data to Delete");
		return false;
	}
	document.getElementById('hidden_val_'+id).value=arr1;
}

function work_info_view_inbasket(id,assess_test_id,test_id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('workinfodetails_inbasket'+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/inbasket_test_details?inbasket_id="+id+"&assess_test_id="+assess_test_id+"&test_id="+test_id,true);
	xmlhttp.send();     
}

function work_info_view_casestudy(id,assess_test_id,test_id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('workinfodetails'+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/casestudy_test_details?casestudy_id="+id+"&assess_test_id="+assess_test_id+"&test_id="+test_id,true);
	xmlhttp.send();     
}

function work_info_view(ass_id,id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('workinfodetails'+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessment_info_details?ass_id="+ass_id+"&pos_id="+id,true);
	xmlhttp.send();     
}

function openpdf(){
	$('#casedesc').hide();
	$('#casepdf').show();
}

function opendesc(){
	$('#casepdf').hide();
	$('#casedesc').show();
}
function enrol_attach_valid(){
}

function cancel_funct(div_id){
    document.getElementById(div_id).innerHTML='';
}
function cancel_funct_bulk(div_id){
    $('#'+div_id).hide();
}
 
    $(function(){
        // Variable to store your files
	var files;
	// Add events
	$('input[type=file]').on('change', prepareUpload);
	$('.bulk_upload').on('click', uploadFiles);

	// Grab the files and set them to our variable
	function prepareUpload(event){
            files = event.target.files;
        }
	// Catch the form submit and upload the files
	function uploadFiles(event){
		var id=this.id;
	if($("#self_emp_enroll"+id).validationEngine('validate')){
		var type=$(this).attr('dat');
		var browse=document.getElementById('bulkempupload'+id).value;
		var assmtid=$("#assessment_id_employee_"+id).val();
		var posid=$("#position_id_employee_"+id).val();
		
		if(browse==''){
			toastr.error( "Please Select File");
			return false;
		}
            event.stopPropagation(); 
            event.preventDefault(); 
			
            var data = new FormData();
            $.each(files, function(key, value){
                data.append(key, value);
            });   
            document.getElementById('bulk_search_data'+id).innerHTML="Loading Data ......";
            $.ajax({
                url: BASE_URL+"/admin/upload_bulk_emp?posid="+posid+"&assmtid="+assmtid+"&type="+type+"&files",
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, 
                contentType: false, 
                success: function(data, textStatus, jqXHR){
                    if(typeof data.error === 'undefined'){
                        document.getElementById('bulk_search_data'+id).innerHTML=data;
						$("#blkcheckall").change(function(){
							$(".blkcheck:enabled").prop('checked', $(this).prop("checked"));
						});
						$('.blkcheck').change(function(){
							if(false == $(this).prop("checked")){
								$("#blkcheckall").prop('checked', $(this).prop("checked")); 
							}
						});
                    }
                    else{
						console.log('ERRORS: ' + data.error);
						document.getElementById('bulk_search_data'+id).innerHTML="Please Contact Admin Team.";
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log('ERRORS: ' + textStatus);
					document.getElementById('bulk_search_data'+id).innerHTML="Please Contact Admin Team.";
                }
            });
	}
        }
        
        function submitForm(event, data){
            // Create a jQuery object from the form
            $form = $(event.target);

            // Serialize the form data
            var formData = $form.serialize();

            // You should sterilise the file names
            /*$.each(data.files, function(key, value){
                formData = formData + '&filenames[]=' + value;
            });*/
            formData=data;
            $.ajax({
                url: BASE_URL+"/admin/upload_bulk_emp",
                type: 'POST',
                data: formData,
                cache: false,
                dataType: 'json',
                success: function(data, textStatus, jqXHR){
                    if(typeof data.error === 'undefined'){
                        toastr.error( data);
                        // Success so call function to process the form
                        console.log('SUCCESS: ' + data.success);
                    }
                    else{
                        // Handle errors here                                
                        console.log('ERRORS: ' + data.error);
                   }
               },
               error: function(jqXHR, textStatus, errorThrown){
                   // Handle errors here
                    console.log('ERRORS: ' + textStatus);
                },
                complete: function(){
                    // STOP LOADING SPINNER
                }
            });
        }
    });
	
function getposdet(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Positions";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/ass_get_posdet?id=" + id, true);
	xmlhttp.send();
}

function work_info_view_inbasket_comp(id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('workinfodetails_inbasket_comp'+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/inbasket_competency_details?inbasket_id="+id,true);
	xmlhttp.send();     
}

function open_questioncount(pos_id,comp_id){
	var s_id=document.getElementById('assessment_scale_id_'+pos_id+'_'+comp_id).value;
	if(s_id!=''){
		document.getElementById("scale_count_"+pos_id+"_"+comp_id).innerHTML = "";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("scale_count_"+pos_id+"_"+comp_id).innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET",BASE_URL+"/admin/scale_question_values?cid="+comp_id+"&s_id="+s_id,true);
		xmlhttp.send();
	}
	
}

function enroll_employees(pos_id,asser_id){
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
			document.getElementById("employee_div_assessor_"+pos_id+"_"+asser_id).innerHTML=xmlhttp.responseText;
			$('#feedback_form').validationEngine();
			CountSelectedCB = [];
			$(".selected_check").change(function() {          
				selectedCB = [];
				notSelectedCB = [];
				
				CountSelectedCB.length = 0; // clear selected cb count
				$(".selected_check").each(function() {
					if ($(this).is(":checked")) {
						CountSelectedCB.push($(this).attr("value"));
					}
				});
				
				$('input[name=emp_ids]').val(CountSelectedCB); 
			});
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessor_employee_selection?pos_id="+pos_id+"&asser_id="+asser_id,true);
	xmlhttp.send();
}

function addass_details_feedback($ass_id,ids,ass_type){
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
			document.getElementById("feedback_model_"+ids).innerHTML=xmlhttp.responseText;
			$('#compinbasket').validationEngine();
			$('#feedback_form').validationEngine();
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/position_feedback_details?assessment_id="+$ass_id+"&position_id="+ids+"&ass_type="+ass_type,true);
	xmlhttp.send();
}

$(function(){
	var files;
	// Add events
	$('input[type=file]').on('change', prepareUpload_feedback);
	$('.bulk_upload_feedback').on('click', uploadFiles_Feedback);
	// Grab the files and set them to our variable
	function prepareUpload_feedback(event){
		files = event.target.files;
	}
	// Catch the form submit and upload the files
	function uploadFiles_Feedback(event){
		var id=this.id;
		if($("#self_emp_enroll"+id).validationEngine('validate')){
			var type=$(this).attr('dat');
			var browse=document.getElementById('bulkempupload_feedback'+id).value;
			var assmtid=$("#assessment_id_employee_"+id).val();
			var posid=$("#position_id_employee_"+id).val();
			var feed='FEEDBACK';
			if(browse==''){
				toastr.error( "Please Select File");
				return false;
			}
            event.stopPropagation(); 
            event.preventDefault(); 
			
            var data = new FormData();
            $.each(files, function(key, value){
                data.append(key, value);
            });   
            document.getElementById('bulk_search_data_feedback'+id).innerHTML="Loading Data ......";
            $.ajax({
                url: BASE_URL+"/admin/upload_bulk_emp_feedback?posid="+posid+"&assmtid="+assmtid+"&feed="+feed+"&type="+type+"&files",
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, 
                contentType: false, 
                success: function(data, textStatus, jqXHR){
                    if(typeof data.error === 'undefined'){
                        document.getElementById('bulk_search_data_feedback'+id).innerHTML=data;
						$("#blkcheckall").change(function(){
							$(".blkcheck:enabled").prop('checked', $(this).prop("checked"));
						});
						$('.blkcheck').change(function(){
							if(false == $(this).prop("checked")){
								$("#blkcheckall").prop('checked', $(this).prop("checked")); 
							}
						});
                    }
                    else{
						console.log('ERRORS: ' + data.error);
						document.getElementById('bulk_search_data_feedback'+id).innerHTML="Please Contact Admin Team.";
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log('ERRORS: ' + textStatus);
					document.getElementById('bulk_search_data_feedback'+id).innerHTML="Please Contact Admin Team.";
                }
            });
		}
    }
	
	function submitForm(event, data){
		// Create a jQuery object from the form
		$form = $(event.target);
		// Serialize the form data
		var formData = $form.serialize();

		// You should sterilise the file names
		/*$.each(data.files, function(key, value){
			formData = formData + '&filenames[]=' + value;
		});*/
		formData=data;
		$.ajax({
			url: BASE_URL+"/admin/upload_bulk_emp_feedback",
			type: 'POST',
			data: formData,
			cache: false,
			dataType: 'json',
			success: function(data, textStatus, jqXHR){
				if(typeof data.error === 'undefined'){
					toastr.error( data);
					// Success so call function to process the form
					console.log('SUCCESS: ' + data.success);
				}
				else{
					// Handle errors here                                
					console.log('ERRORS: ' + data.error);
			   }
		   },
		   error: function(jqXHR, textStatus, errorThrown){
			   // Handle errors here
				console.log('ERRORS: ' + textStatus);
			},
			complete: function(){
				// STOP LOADING SPINNER
			}
		});
	}
});

function details(seeker,ass_id,pos_id,group_id,pid,type){
	 //alert(pid);
	var xmlhttp;
	if (window.XMLHttpRequest){
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
	}
	else{
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
					// alert(xmlhttp.responseText);
					document.getElementById("modal_user_"+pos_id).innerHTML=xmlhttp.responseText;
					//document.getElementById("usertype").innerHTML=type;

			}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessement_feedback_details?seekerid="+seeker+"&ass_id="+ass_id+"&pos_id="+pos_id+"&group_id="+group_id+"&catid="+pid,true);
	xmlhttp.send();
}

function enroll_employee_competency(pos_id,emp_id){
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
			document.getElementById("employee_div_competency_"+pos_id+"_"+emp_id).innerHTML=xmlhttp.responseText;
			$('#feedback_form').validationEngine();
			CountSelectedCB = [];
			$(".selected_check_comp").change(function() {          
				selectedCB = [];
				notSelectedCB = [];
				
				CountSelectedCB.length = 0; // clear selected cb count
				$(".selected_check_comp").each(function() {
					if ($(this).is(":checked")) {
						CountSelectedCB.push($(this).attr("value"));
					}
				});
				
				$('input[name=comp_ids]').val(CountSelectedCB); 
			});
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/competency_employee_selection?pos_id="+pos_id+"&emp_id="+emp_id,true);
	xmlhttp.send();
}