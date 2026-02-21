$(document).ready(function(){
	$('#quick').validationEngine();
	$('#org_master_check').validationEngine({validateNonVisibleFields: true, updatePromptsPosition:true});
    
	});

$('#cancel').click(function() {
    var selected = $('#pro').val();
	var path=BASE_URL+'/admin/event_creation?eve_stat&pro_id='+selected;	
	$(location).attr('href',path);
	//window.location=path;	
    alert("Redirecting.....");
});
 $('#cancel3').click(function(){
 var select=$('#enroll_program').val();
  var select1=$('#enroll_event').val();
 var path=BASE_URL+'/admin/event_creation?eve_stat=singleenroll&pro_id='+select+'&event_id='+select1;
 $(location).attr('href',path);
 alert("Redirecting.....");
  });

// function quicklinks(){
	// var progs=document.getElementById('pro').value;
	// window.location = BASE_URL+"/admin/event_creation?eve_stat&pro_id="+progs;	
	// alert("worked");
// }
function quick_create()
{
    if(document.getElementById('event').checked==true){
        document.getElementById('enrollment').style.display='none';
        document.getElementById('event_creation1').style.display='block';
    }
    else if(document.getElementById('enrollments').checked==true){
        document.getElementById('event_creation1').style.display='none';
        document.getElementById('enrollment').style.display='block';
    }
}

function change_category()
{
var catid=document.getElementById('enroll_category').value;
//alert(proid);
var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById('enroll_program').innerHTML=xmlhttp.responseText;
		}
		}
	
	xmlhttp.open("GET",BASE_URL+"/admin/change_cat?id="+catid,true);
	xmlhttp.send();	
}

function change_program()
{
var proid=document.getElementById('enroll_program').value;
//alert(proid);
var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById('enroll_event').innerHTML=xmlhttp.responseText;
		}
		}
	
	xmlhttp.open("GET",BASE_URL+"/admin/change_pro?id="+proid,true);
	xmlhttp.send();	
}

function change_event()
 {
    var event_id=document.getElementById('enroll_event').value;
	var proid=document.getElementById('enroll_program').value;
	//alert(event_id);
	//alert(proid);
    var xmlhttp;
	if (window.XMLHttpRequest){
		//code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		//code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('enrollmentinformation').innerHTML=xmlhttp.responseText;
			 $('#newtableid')
			.dataTable();	
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/quick_event_enrollment?eve_id="+event_id+"&pro_id="+proid,true);
	xmlhttp.send();	
 }
  
function enrolltype(){
	var enroll_type=document.getElementById('enroll_type').value;
	document.getElementById('enrollment_div').innerHTML="";
	if(enroll_type==1){
		single_enroll();
	}
	else if(enroll_type==2){
		bulk_enroll();
	}
	else if(enroll_type==3){
		tna_enroll();
	}
	else if(enroll_type==4){
		search_enroll();
	}
	else if(enroll_type==5){
		learnergroup_enroll();
	}
}


function learnergroup_enroll(){
	var eve_id=document.getElementById('eve_id').value;
	var pro_id=document.getElementById('pro_id').value;
	var evnt_cnt=document.getElementById('evnt_cnt').value;
	if(learner_grp!=''){
        var lnr_grp=learner_grp.split(',');
        var learner_groups='';
        for(var i=0;i<lnr_grp.length;i++){
            lnr_grp1=lnr_grp[i];
            lnr_grp2=lnr_grp1.split('*');
            if(learner_groups==''){
                learner_groups="<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }else{
                learner_groups=learner_groups+"<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }
        }
    }
    else{
        var learner_groups='';
    }
	document.getElementById('enrollment_div').innerHTML="<h4 class='header blue bolder smaller'>Learner Group</h4>\n\
	<div class='row'>\n\<input type='hidden' name='progid' id='progid' value='"+pro_id+"'>\n\
		<input type='hidden' name='evntid' id='evntid' value='"+eve_id+"'>\n\
		<input type='hidden' name='eve_max_cnt' id='eve_max_cnt' value='"+evnt_cnt+"'>&nbsp;&nbsp;\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Learner Group<sup><font color='#FF0000'>*</font></sup><br>\n\
			<input type='hidden' name='learner_id' id='learner_id' value=''>\n\
			<select name='learnersearchsel' id='learnersearchsel' class='validate[required]' onChange='learnersearchresult()'><option value=''>Select</option>"+learner_groups+"</select>\n\
		</div>\n\
	</div><br><div class='widget-box pricing-box-small widget-color-blue'><div class='widget-header'><h5 class='widget-title bigger lighter'>Search Results</h5></div></div><div id='learnersearchemptablediv'></div>";
}


function learnersearchresult(){
	var eve_id=document.getElementById('eve_id').value;
	var pro_id=document.getElementById('pro_id').value;
	var evnt_cnt=document.getElementById('evnt_cnt').value;
	var del_method=document.getElementById('del_met').value;
	var eve_stdate=document.getElementById('event_stdate').value;
	var eve_enddate=document.getElementById('event_enddate').value;
	var learnersearch=document.getElementById('learnersearchsel').value;
	document.getElementById("learnersearchemptablediv").innerHTML="Loading data ...";
	var  xmlhttp2;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp2=new XMLHttpRequest();
	}
	else{
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function(){
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById("learnersearchemptablediv").innerHTML=xmlhttp2.responseText;
			$("#learnersearchcheckall").change(function(){
				$(".learnersearchcheck:enabled").prop('checked', $(this).prop("checked"));
			});
			$('.learnersearchcheck').change(function(){
				if(false == $(this).prop("checked")){
					$("#learnersearchcheckall").prop('checked', $(this).prop("checked")); 
				}
			});
		}
	}
	xmlhttp2.open("GET",BASE_URL+"/admin/learnersearchempdetails?learner_id="+learnersearch+"&eventid="+eve_id+"&del_method="+del_method+"&stdate="+eve_stdate+"&endate="+eve_enddate,true);
	xmlhttp2.send();
}

function search_enroll(){
	var eve_id=document.getElementById('eve_id').value;
	var pro_id=document.getElementById('pro_id').value;
	var evnt_cnt=document.getElementById('evnt_cnt').value;
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
            document.getElementById('enrollment_div').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/searchform?pro_id="+pro_id+"&eve_id="+eve_id+"&evnt_cnt="+evnt_cnt,true);
	xmlhttp.send();
}

function searchreasult(){
	var eve_id=document.getElementById('eve_id').value;
	var pro_id=document.getElementById('pro_id').value;
	var evnt_cnt=document.getElementById('evnt_cnt').value;
	var del_method=document.getElementById('del_met').value;
	var eve_stdate=document.getElementById('event_stdate').value;
	var eve_enddate=document.getElementById('event_enddate').value;
	var loc=document.getElementById('searchlocation').value;
	var org=document.getElementById('searchorgname').value;
	var bus=document.getElementById('searchbus').value;
	var grad=document.getElementById('searchgrade').value;
	var emptype=document.getElementById('searchemptype').value;
	var post=document.getElementById('searchposition').value;
	if(org=='' && bus=='' && loc=='' && grad=='' && emptype=='' && post==''){
		alertify.alert("Please select anyone SBU, Organization, Location, Grade, Employee Type, Position.");
		return false;
	}
	document.getElementById("searchemptablediv").innerHTML="Loading data ...";
	var  xmlhttp2;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp2=new XMLHttpRequest();
	}
	else{
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function(){
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById("searchemptablediv").innerHTML=xmlhttp2.responseText;
			$("#searchcheckall").change(function(){
				$(".searchcheck:enabled").prop('checked', $(this).prop("checked"));
			});
			$('.searchcheck').change(function(){
				if(false == $(this).prop("checked")){
					$("#searchcheckall").prop('checked', $(this).prop("checked")); 
				}
			});
		}
	}
	xmlhttp2.open("GET",BASE_URL+"/admin/searchempdetails?group=B&loc="+loc+"&bus="+bus+"&org="+org+"&hierar=&grad="+grad+"&emptype="+emptype+"&post="+post+"&eventid="+eve_id+"&del_method="+del_method+"&stdate="+eve_stdate+"&endate="+eve_enddate,true);
	xmlhttp2.send();
}

function single_enroll(){ //alertify.alert(pro_id);
    var eve_id=document.getElementById('eve_id').value;
	var pro_id=document.getElementById('pro_id').value;
	var evnt_cnt=document.getElementById('evnt_cnt').value;
    // To fetch Employee Numbers from .php page
    if(emp_num!=''){
        var empnum=emp_num.split(',');
        var empdata='';
        for(var i=0;i<empnum.length;i++){
            emp1=empnum[i];
            emp2=emp1.split('*');
            if(empdata==''){
                empdata="<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }else{
                empdata=empdata+"<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }
        }
    }else{
        empdata='';
    }
	
     // To fetch Justifications from .php page
    if(justfication!=''){
        var justfic=justfication.split(',');
        var justdata='';
        for(var i=0;i<justfic.length;i++){
            just1=justfic[i];
            just2=just1.split('*');
            if(justdata==''){
                justdata="<option value='"+just2[0]+"'>"+just2[1]+"</option>";
            }else{
                justdata=justdata+"<option value='"+just2[0]+"'>"+just2[1]+"</option>";
            }
        }
    }
    else{
        justdata='';
    }
    // To fetch Enrollment Status from .php page
    if(enroll_stat!=''){
        var enrl=enroll_stat.split(',');
        var enroll_status='';
        for(var i=0;i<enrl.length;i++){
            ernl1=enrl[i];
            ernl2=ernl1.split('*');
            if(enroll_status==''){
                enroll_status="<option value='"+ernl2[0]+"'>"+ernl2[1]+"</option>";
            }else{
                enroll_status=enroll_status+"<option value='"+ernl2[0]+"'>"+ernl2[1]+"</option>";
            }
        }
    }else{
        enroll_status='';
    }
    // To fetch Enrollment Emp Numbers from .php page
    if(enroll_emp_asd!=''){
        var enrl_emp=enroll_emp_asd.split(',');
        var enroll_emp='';
        for(var i=0;i<enrl_emp.length;i++){
            ernlemp1=enrl_emp[i];
            ernlemp2=ernlemp1.split('*');
            if(enroll_emp==''){
                enroll_emp="<option value='"+ernlemp2[0]+"'>"+ernlemp2[1]+"</option>";
            }else{
                enroll_emp=enroll_emp+"<option value='"+ernlemp2[0]+"'>"+ernlemp2[1]+"</option>";
            }
        }
    }else{
        enroll_emp='';
    }
    //document.getElementById('single_enroll_div').style.display='block';
    //document.getElementById('bul  k_enroll_div').style.display='none';
    var param='"enrollment_div"';
    document.getElementById('enrollment_div').innerHTML="<h4 class='header blue bolder smaller'>Single Enrollment</h4>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Employee Number<sup><font color='#FF0000'>*</font></sup><br>\n\
			<select class='validate[required, ajax[ajaxEnrlEmp]] chosen-select' name='emp_no'  id='emp_no' onChange='fetch_empdata()'>\n\
			<option value='N/A'>Select</option>"+empdata+"</select>\n\
			<input type='hidden' name='progid' id='progid' value="+pro_id+">\n\
			<input type='hidden' name='evntid' id='evntid' value="+eve_id+">\n\
			<input type='hidden' name='enroll_id' id='enroll_id' value=''>&nbsp;&nbsp;\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Employee Name<br>\n\
			<input type='text' class='col-xs-12 col-sm-12' name='emp_name' id='emp_name' value='' readonly>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Department<br>\n\
			<input type='hidden' name='emp_org_id' id='emp_org_id' value=''>\n\
			<input type='text' class='col-xs-12 col-sm-12' name='department' id='department' value='' readonly>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Justification<br>\n\
			<select name='justification' class='col-xs-12 col-sm-12' id='justification'><option value=''>Select</option>"+justdata+"</select>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Enrollment Status<sup><font color='#FF0000'>*</font></sup><br>\n\<input type='hidden' name='eve_max_cnt' id='eve_max_cnt' value='"+evnt_cnt+"'>\n\
			<select onchange='enrl_status_validates()' class='validate[required] col-xs-12 col-sm-12' name='enroll_status' id='enroll_status'><option value=''>Select</option>"+enroll_status+"</select>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Approved By<br>\n\
			<select class='chosen-select' name='enrol_approver'  id='enrol_approver'><option value=''>Select</option>"+enroll_emp+"</select>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<!--<div class='col-xs-12 col-sm-3'>\n\
			Source<br>\n\
			<select name='enrol_source' class='col-xs-12 col-sm-12' id='enrol_source'><option value=''>Select</option></select>\n\
		</div>-->\n\
		<div class='col-xs-12 col-sm-6'>\n\
			Instruction<br>\n\
			<textarea class='validate[maxSize[150]] col-xs-12 col-sm-12' name='instruction' id='instruction' style='resize:none;'></textarea>\n\
		</div>\n\
	</div><br>\n\
	<h4 class='header blue bolder smaller'>Attachments</h4>\n\
	<div>\n\
	<input type='hidden' id='single_hidden_id' value='0' name='single_hidden_id' />\n\
	<input type='button' name='addrow' id='addrow' value='Add Row' class='btn btn-sm btn-success' onClick='AddEnrollRow()'/>\n\
    <input type='button' name='del' id='del' value='Delete Row'  class='btn btn-sm btn-danger' onClick='DelEnrollAttachment()'/></div>\n\
	<table id='single_enroll_tab' class='table table-striped table-bordered table-hover'>\n\
	    <thead>\n\
		    <tr>\n\
			    <td>Select</td>\n\
                <td>Attachment Name</td>\n\
                <td>Attachment Type</td>\n\
                <td>Display To Learner</td>\n\
                <td>File Name</td>\n\
                <td>Browse</td>\n\
			</tr>\n\
        </thead>\n\
		<tr id='single_enroll0'>\n\
		    <td style='padding-left:20px;'>\n\
			    <input type='checkbox'  name='single_enrl_chk[]' id='single_enrl_chk_0' value='0' /></td>\n\
			<td>\n\
                <input type='hidden' name='enroll_attach_id[]' id='enroll_attach_id[0]' value=''>\n\
                <input type='text' name='enrol_attach_name[]' id='enrol_attach_name[0]' style='width:150px;' class='validate[minSize[2],maxSize[150], custom[alphanumericSp]] mediumtext'/></td>\n\
			<td><input type='text' name='enrol_attach_type[]' id='enrol_attach_type[0]' style='width:95px;' class='validate[minSize[2],maxSize[30], custom[alphabets]] mediumtext'/></td>\n\
            <td style='padding-left:50px;'  >\n\
                <input type='checkbox' name='enrol_display_learn[]' id='enrol_display_learn[0]' value='Yes' /></td>\n\
			<td><input type='hidden' name='file_id_0' id='file_id_0' value=''></td>\n\
            <td><input class='validate[custom[file]]' type='file' name='enrol_attach_file[]' id='enrol_attach_file0' style='width:120px;' /></td>\n\
        </tr></table>\n\
<div class='form-actions center'>\n\
	<input type='submit' name='single_save'  id='single_save' value='Save' class='btn btn-sm btn-success'>\n\
</div>\n\
";
	$('#emp_no').ajaxChosen({
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});
	$('#enrol_approver').ajaxChosen({
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});
	//resize the chosen on window resize
	$(window).on('resize.chosen', function() {
	var w = $('.chosen-select').parent().width();
	if(w<=25){w=250;}
	$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');
	
	
}
function fetch_empdata(){ 
    var empno=document.getElementById('emp_no').value;
	var del_method=document.getElementById('del_met').value;
	var eve_stdate=document.getElementById('event_stdate').value;
	var eve_enddate=document.getElementById('event_enddate').value;
	var event_id=document.getElementById('eve_id').value;
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
				//alertify.alert($response[1]);
				//document.getElementById('emp_no').value='';
				$("#emp_no option[value='N/A']").attr("selected", true);
				return false;
			}else{
				if($response[0]!=""){//alertify.alert($response[4]);
					document.getElementById('emp_name').value=$response[1];
					document.getElementById('department').value=$response[2];
					document.getElementById('emp_org_id').value=$response[4];
				}
				else{
					alertify.alert("Employee details does not found with this Employee Number");
					document.getElementById('emp_no').value='';
					document.getElementById('emp_name').value='';
					document.getElementById('department').value='';
					document.getElementById('emp_org_id').value='';
					return false;
				}
			}
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_emp_data_id?empnum="+empno+"&eventid="+event_id+"&del_method="+del_method+"&stdate="+eve_stdate+"&endate="+eve_enddate,true);
    xmlhttp.send(); 
}

function bulk_enroll(){
	//alertify.alert(path);
	var eve_id=document.getElementById('eve_id').value;
	var pro_id=document.getElementById('pro_id').value;
	var evnt_cnt=document.getElementById('evnt_cnt').value;
    // To fetch Employee Numbers from .php page
    if(emp_num!=''){
        var empnum=emp_num.split(',');
        var empdata='';
        for(var i=0;i<empnum.length;i++){
            emp1=empnum[i];
            emp2=emp1.split('*');
            if(empdata==''){
                empdata="<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }else{
                empdata=empdata+"<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }
        }
    }
    else{
        empdata='';
    }
    
    // To fetch Emp Names from .php page
    if(enroll_emp_asd!=''){
        var enrl_emp=enroll_emp_asd.split(',');
        var emp_names='';
        for(var i=0;i<enrl_emp.length;i++){
            ernlemp1=enrl_emp[i];
            ernlemp2=ernlemp1.split('*');
            if(emp_names==''){
                emp_names="<option value='"+ernlemp2[0]+"'>"+ernlemp2[1]+"</option>";
            }else{
                emp_names=emp_names+"<option value='"+ernlemp2[0]+"'>"+ernlemp2[1]+"</option>";
            }
        }
    }
    else{
        emp_names='';
    }
    // To fetch Learner Groups from .php page
    if(learner_grp!=''){
        var lnr_grp=learner_grp.split(',');
        var learner_groups='';
        for(var i=0;i<lnr_grp.length;i++){
            lnr_grp1=lnr_grp[i];
            lnr_grp2=lnr_grp1.split('*');
            if(learner_groups==''){
                learner_groups="<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }else{
                learner_groups=learner_groups+"<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }
        }
    }
    else{
        learner_groups='';
    }
     //To fetch Manager Names from .php page
     if(manager){
        var mng=manager.split(',');
        var managers='';
        for(var i=0;i<mng.length;i++){
            mng1=mng[i];
            mng2=mng1.split('*');
            if(managers==''){
                managers="<option value='"+mng2[0]+"'>"+mng2[1]+"</option>";
            }else{
                managers=managers+"<option value='"+mng2[0]+"'>"+mng2[1]+"</option>";
            }
        }
    }
    else{
        managers='';
    }
    // To fetch Learner Org Names from .php page
    if(enrol_org!=''){
        var erl_org=enrol_org.split(',');
        var enrl_orgnames='';
        for(var i=0;i<erl_org.length;i++){
            erl_org2=erl_org[i].split('*');
            if(enrl_orgnames==''){
                enrl_orgnames="<option value='"+erl_org2[0]+"'>"+erl_org2[1]+"</option>";
            }else{
                enrl_orgnames=enrl_orgnames+"<option value='"+erl_org2[0]+"'>"+erl_org2[1]+"</option>";
            }
        }
    }else{
        enrl_orgnames='';
    }
    // To fetch Locations from .php page
    if(locate!=''){
        var locs=locate.split(',');
        var locations='';
        for(var i=0;i<locs.length;i++){
            locs2=locs[i].split('*');
            if(locations==''){
                locations="<option value='"+locs2[0]+"'>"+locs2[1]+"</option>";
            }else{
                locations=locations+"<option value='"+locs2[0]+"'>"+locs2[1]+"</option>";
            }
        }
    }else{
        locations='';
    }
    // To fetch Employee types from .php page
    if(emptype!=''){
        var type=emptype.split(',');
        var emp_type='';
        for(var i=0;i<type.length;i++){
            type2=type[i].split('*');
            if(emp_type==''){
                emp_type="<option value='"+type2[0]+"'>"+type2[1]+"</option>";
            }else{
                emp_type=emp_type+"<option value='"+type2[0]+"'>"+type2[1]+"</option>";
            }
        }
    }else{
        emp_type='';
    }
    
    //document.getElementById('single_enroll_div').style.display='block';
    //document.getElementById('bulk_enroll_div').style.display='none';
  
    document.getElementById('enrollment_div').innerHTML="<h4 class='header blue bolder smaller'>Bulk Enrollment</h4><div id='upload_empbulk_div' ><br>\n\
	<input type='hidden' name='progid' id='progid' value="+pro_id+">\n\
				<input type='hidden' name='evntid' id='evntid' value="+eve_id+">\n\
				<input type='hidden' name='eve_max_cnt' id='eve_max_cnt' value='"+evnt_cnt+"'>&nbsp;&nbsp;\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sl-3'>\n\
				<div class='form-group'>\n\
					<div class='col-xs-12'>\n\<!--href='"+download_page+"?id="+BASE_URL+"/public/templates/bulk_template.csv'-->\n\
						<a href='"+BASE_URL+"/public/templates/bulk_template.csv' style='text-decoration:underline;color:#00F' id='bulk_template'>Click here</a> to download sample template\n\
					</div>\n\
				</div>\n\
			</div><br>\n\
			<div class='col-xs-12 col-sl-3'>\n\
				<div class='form-group'>\n\
					<div class='col-xs-3'>\n\
						<input type='file' name='upload' id='bulkempupload'>&nbsp;&nbsp;<br>\n\
					</div>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sl-3'>\n\
				<input type='button' class='btn btn-sm btn-success' name='bulk_upload' id='bulk_upload' value='Upload'>\n\
			</div>\n\
			</div>\n\
		</div><br>\n\
	</div>\n\
<h4 class='header blue bolder smaller'>Employee Details</h4>\n\
<div id='bulk_search_data'>\n\
<table id='single_enroll_tab' class='table table-striped table-bordered table-hover'>\n\
<thead>\n\
<tr>\n\
<th>Select</th>\n\
<th>Employee Number</th>\n\
<th>Employee Name</th>\n\
<th>Organization</th>\n\
<th>Status</th>\n\
</tr>\n\
</thead>\n\
<tr id='single_enroll0'>\n\
<td style='padding-left:20px;'>\n\
No Search Data Found</td>\n\
<td align='left'>\n\
<input type='hidden' name='employee_id[]' id='employee_id[0]' value=''>\n\
<input type='hidden' name='employee_number[]' id='employee_number[0]' value=''/></td>\n\
<td align='left'><input type='hidden' name='employee_name[]' id='employee_name[0]' value=''/></td>\n\
<td align='center' style='padding-left:50px;'>\n\
<input type='hidden' name='organization_id[]' id='organization_id[0]' value=''/>\n\
<input type='hidden' name='org_name[]' id='org_name[0]' value=''/></td>\n\
<td align='left'>&nbsp;</td>\n\
</tr></table></div>";
$('#bulkempupload').ace_file_input({
		no_file:'No File ...',
		btn_choose:'Choose',
		btn_change:'Change',
		droppable:true,
		onchange:null,
		thumbnail:false //| true | large
		//whitelist:'gif|png|jpg|jpeg'
		//blacklist:'exe|php'
		//onchange:''
		//
	});
	//document.getElementById('enrol_learner_group').focus();
    $('.chosen-select').chosen({allow_single_deselect:true}); 
	//resize the chosen on window resize
	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=25){w=250;}
		$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');
	$(document).on('click', 'th input:checkbox' , function(){
		var that = this;
		$(this).closest('table').find('tr > td:first-child input:checkbox:enabled')
		.each(function(){
			this.checked = that.checked;
			$(this).closest('tr').toggleClass('selected');
		});
	});
	
    
    $(function(){
        // Variable to store your files
	var files;
	// Add events
	$('input[type=file]').on('change', prepareUpload);
	$('#bulk_upload').on('click', uploadFiles);

	// Grab the files and set them to our variable
	function prepareUpload(event){
            files = event.target.files;
        }
	// Catch the form submit and upload the files
	function uploadFiles(event){
		var browse=document.getElementById('bulkempupload').value;
		var del_method=document.getElementById('del_met').value;
		var eve_stdate=document.getElementById('event_stdate').value;
		var eve_enddate=document.getElementById('event_enddate').value;
		
		if(browse==''){
			alertify.alert("Please Select File");
			return false;
		}
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening
            // START A LOADING SPINNER HERE

            // Create a formdata object and add the files
            var data = new FormData();
            $.each(files, function(key, value){
                data.append(key, value);
            });   
            document.getElementById('bulk_search_data').innerHTML="Loading Data ......";
            $.ajax({
                url: BASE_URL+"/admin/upload_bulk_emp_new?files&eventid="+eve_id+"&del_method="+del_method+"&stdate="+eve_stdate+"&endate="+eve_enddate+"",
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                
                success: function(data, textStatus, jqXHR){
                    if(typeof data.error === 'undefined'){
                        // Success so call function to process the form
                        //alertify.alert(data);
                        document.getElementById('bulk_search_data').innerHTML=data;
						//document.getElementById('enrol_emp_no').value='';
            		//submitForm(event, data);
                    }
                    else{
                        // Handle errors here
            		console.log('ERRORS: ' + data.error);
                        //alertify.alert(data);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus);
                    alertify.alert(data);
                    // STOP LOADING SPINNER
                }
            });
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
                        alertify.alert(data);
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

    
}

function change_bulk_type(){
	var radio_checked1=document.getElementById('search_bulkemp');
	var radio_checked2=document.getElementById('upload_bulkemp');
	if(radio_checked1.checked==true){
		document.getElementById('search_bulkemp_data').style.display='block';
		document.getElementById('upload_empbulk_div').style.display='none';
	}
	else if(radio_checked2.checked==true){
		document.getElementById('search_bulkemp_data').style.display='none';
		document.getElementById('upload_empbulk_div').style.display='block';
	}
}
function bulk_emp(){ //alertify.alert(eve_id);
    var eve_id=document.getElementById('evntid').value;
    var empno=document.getElementById('enrol_emp_no').value;
    //var empname=document.getElementById('enrol_employee_name').value;
    var lrngrop=document.getElementById('enrol_learner_group').value;
    var dept=document.getElementById('enrol_department').value;
    var mngr=document.getElementById('enrol_manager').value;
    var emptyp=document.getElementById('enrol_employee_type').value;
    var location=document.getElementById('enrol_location').value;
	var del_method=document.getElementById('del_met').value;
	var eve_stdate=document.getElementById('event_stdate').value;
	var eve_enddate=document.getElementById('event_enddate').value;
    if(empno=='' && lrngrop=='' && dept=='' && mngr=='' && emptyp=='' && location==''){
        alertify.alert("Please select atleast one option");
        return false;
    }
    else{
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
//                var resdata=xmlhttp.responseText.split('*#');
//                document.getElementById('employee_number[0]').value=resdata[0];
//                document.getElementById('employee_number[0]').value=resdata[0];
//                document.getElementById('employee_number[0]').value=resdata[0];
                document.getElementById('bulk_search_data').innerHTML=xmlhttp.responseText;
				$(document).on('click', 'th input:checkbox' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox:enabled')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
				});
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/fetch_bulk_emp_data_new?empnum="+empno+"&lnrgrp="+lrngrop+"&depart="+dept+"&mngr="+mngr+"&emptype="+emptyp+"&locat="+location+"&eventid="+eve_id+"&del_method="+del_method+"&stdate="+eve_stdate+"&endate="+eve_enddate,true);
        xmlhttp.send();
    }
    
}
function cannot_enroll(){
    alertify.alert("You cannot enroll participants, because event has been end dated ");
}

function update_single_enroll(id){
    var prgid=document.getElementById('enrl_prg_id').value;
    var evntid=document.getElementById('enrl_evnt_id').value;
	var del_method=document.getElementById('del_met').value;
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
            document.getElementById('enrollment_div').innerHTML=xmlhttp.responseText;
			document.getElementById('emp_name').focus();
			$('#emp_no').ajaxChosen({
				   dataType: 'json',
				   type: 'POST',
				   url:BASE_URL+'/admin/autoemployee'
			},{
				   loadingImg: 'loading.gif'
			});
			$('#enrol_approver').ajaxChosen({
				   dataType: 'json',
				   type: 'POST',
				   url:BASE_URL+'/admin/autoemployee'
			},{
				   loadingImg: 'loading.gif'
			});
            $('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
				var w = $('.chosen-select').parent().width();
				if(w<=25){w=250;}
				$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/enroll_event_update1?enrl_id="+id+"&prog_id="+prgid+"&evntid="+evntid+"&eve_cnt="+evnt_cnt+"&del_met="+del_method,true);
    xmlhttp.send();
}
function cant_update_enroll(){
    alertify.alert("Can not update Enrollment when status is either Cancelled or Attended");
}
function enrl_status_validates(){//alertify.alert(evnt_cnt);
    var enrl_status=document.getElementById('enroll_status').value;
    var enrl_cnt=document.getElementById('enrl_evnt_count').value;
	var evnt_stdate=document.getElementById('event_stdate').value;
	var sysdate=document.getElementById('sys_date').value;
	if(sysdate<evnt_stdate){
		if(enrl_status=='ATT'){
			alertify.alert("Event status can not be changed to Attended before starting the event");
			document.getElementById('enroll_status').value='REQ';
			return false;
		}
	}
    if(evnt_cnt==''){
        if(enrl_status=='WAIT'){
            alertify.alert("Employee can not be waitlisted when there is no maximum count for the event");
            document.getElementById('enroll_status').value='REQ';
            return false;
        }
    }
    else{
        if(parseInt(enrl_cnt)>=parseInt(evnt_cnt)){
            if(enrl_status=='CON'){
                alertify.alert("You cannot update the enrollment status to Confirmed, if the enrollment count more than event maximum count");
                document.getElementById('enroll_status').value='WAIT';
                return false;
            }
        }
    }
}

  function AddEnrollRow(){
//      var tbl = document.getElementById("single_enroll_tab");
//      var lastRow = tbl.rows.length;
//      var lastrow1= lastRow+1;
      var hiddtab="single_hidden_id";
      var ins=document.getElementById(hiddtab).value;
      if(ins!=''){
          var ins1=ins.split(",");
          var temp=0;
          for( var j=0;j<ins1.length;j++){
              if(ins1[j]>temp){
                  temp=ins1[j];
              }
          }
          sub_iteration=parseInt(temp)+1;
          for( var j=0;j<ins1.length;j++){
              var i=ins1[j];
              var attatchment=document.getElementById('enrol_attach_name['+i+']').value;
              var att1=attatchment.toUpperCase();
              var type=document.getElementById('enrol_attach_type['+i+']').value;
              var att_typ1=type.toUpperCase();
			  var filename=document.getElementById('enrol_attach_file'+i+'').value;
			  var file_exist=document.getElementById('file_id_'+i+'').value;
              if(attatchment==''){
                  alertify.alert("Please Enter Attachment Name");
                  return false;
              }
			  if(filename==''){
				if(file_exist==''){
					alertify.alert("Please add File");
					return false;
				}
              }
              else{
                   for( var k=0;k<ins1.length;k++){
                       l=ins1[k];
                       var attatchment2=document.getElementById('enrol_attach_name['+l+']').value;
                       var att2=attatchment2.toUpperCase();
                       var type2=document.getElementById('enrol_attach_type['+l+']').value;
                       var att_typ2=type2.toUpperCase();
					   var filename2=document.getElementById('enrol_attach_file'+l+'').value;
					   var file_exist2=document.getElementById('file_id_'+l+'').value;
					   var files=filename.replace(" ","_");
                       if(k!=j){
                            if(att1.trim()==att2.trim() && att_typ1.trim()==att_typ2.trim()){
                               alertify.alert("Attachment with same type Already Exists");
                               return false;
							}
							if(filename==filename2 || files==file_exist2){
								alertify.alert("File Already Exists");
								return false;
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
      $("#single_enroll_tab").append("<tr id='single_enroll"+sub_iteration+"'><td style='padding-left:20px;'><input type='checkbox' name='single_enrl_chk[]' id='single_enrl_chk_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><input type='hidden' name='enroll_attach_id[]' id='enroll_attach_id["+sub_iteration+"]' value=''><input type='text' style='width:150px;' name='enrol_attach_name[]' id='enrol_attach_name["+sub_iteration+"]' value='' class='validate[minSize[2],maxSize[150], custom[alphanumericSp]] mediumtext' /></td><td><input type='text' style='width:95px;' name='enrol_attach_type[]' id='enrol_attach_type["+sub_iteration+"]' value='' class='validate[minSize[2],maxSize[150], custom[alphabets]] mediumtext'/></td><td style='padding-left:50px;'><input type='checkbox' name='enroll_display_learn[]' id='enroll_display_learn["+sub_iteration+"]' value='Yes' /></td><td><input type='hidden' name='file_id_"+sub_iteration+"' id='file_id_"+sub_iteration+"' value=''></a></td><td><input class='validate[custom[file]]' type='file' style='width:120px;' name='enrol_attach_file[]' id='enrol_attach_file"+sub_iteration+"' value='"+sub_iteration+"'  /></td><input type='hidden' id='hide_values["+sub_iteration+"]' name='hide_values[]' value='' /></td></tr>");
      if(document.getElementById(hiddtab).value!=''){
          var ins=document.getElementById(hiddtab).value;
          document.getElementById(hiddtab).value=ins+","+sub_iteration;
      }
      else{
          document.getElementById(hiddtab).value=sub_iteration;
      }
 }   
 
 function DelEnrollRow(){
	var ins=document.getElementById('single_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="select_bulk_chk_"+bb+"";
		//alertify.alert(a);
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			//alertify.alert(b);
			var c="bulk_enrol_del_"+b+"";
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
	document.getElementById('single_hidden_id').value=arr1;
}
function DelEnrollAttachment(){
	var ins=document.getElementById('single_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="single_enrl_chk_"+bb+"";
		//alertify.alert(a);
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			//alertify.alert(b);
			var c="single_enroll"+b+"";
			var code=document.getElementById("enroll_attach_id["+b+"]").value;
			if(code!=""){
				$.ajax({
					url: BASE_URL+"/admin/delete_enroll_attachment",
					global: false,
					type: "POST",
					data: ({val : code}),
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
	document.getElementById('single_hidden_id').value=arr1;
}

function enrol_attach_valid(){
    var hiddtab="single_hidden_id";
    var ins=document.getElementById(hiddtab).value;
    if(ins!=''){
        var ins1=ins.split(",");
        var temp=0;
        for( var j=0;j<ins1.length;j++){
            if(ins1[j]>temp){
                temp=ins1[j];
            }
        }
        sub_iteration=parseInt(temp)+1;
        for( var j=0;j<ins1.length;j++){
            var i=ins1[j];
            var attatchment=document.getElementById('enrol_attach_name['+i+']').value;
            var att1=attatchment.toUpperCase();
            var type=document.getElementById('enrol_attach_type['+i+']').value;
            var att_typ1=type.toUpperCase();
            if(attatchment!=''){
                for( var k=0;k<ins1.length;k++){
                     l=ins1[k];
                     var attatchment2=document.getElementById('enrol_attach_name['+l+']').value;
                     var att2=attatchment2.toUpperCase();
                     var type2=document.getElementById('enrol_attach_type['+l+']').value;
                     var att_typ2=type2.toUpperCase();
                     if(k!=j){
                         if(att1.trim()==att2.trim() && att_typ1.trim()==att_typ2.trim()){
                             alertify.alert("Attachment with same type Already Exists");
                             return false;
                         }
                     }
                 }
            }
        }
    }
 } 
 function Enroll_data_Delete(){
        var ins=document.getElementById('hidden_val').value;	
		var arr1=ins.split(",");
        var flag=0;
		var tbl = document.getElementById('newtableid');
		var lastRow = tbl.rows.length;
		for(var i=(arr1.length-1); i>=0; i--){
            var bb=arr1[i];
            var a="chck["+bb+"]";
            if(document.getElementById(a).checked){
                var b=document.getElementById(a).value;
                var c="innerdata["+b+"]";
                var code=document.getElementById("enroll_id["+b+"]").value;
				var empid=document.getElementById("enroll_emp_id["+b+"]").value;
				var eventid=document.getElementById("enrl_evnt_id").value;
                if(code!=""){
                    $.ajax({
                        url: BASE_URL+"/admin/delete_enroll_data",
                        global: false,
                        type: "POST",
                        data: ({enrol_id : code, emp_id: empid, eve_id: eventid}),
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
                //alertify.alert("#"+c);
                document.getElementById(c).style.display='none';
                document.getElementById('enrollment_div').innerHTML='';
               // $("#"+c).remove();                
            }
        }
        if(flag==0){
            alertify.alert("Please select the data to Delete");
            return false;
        }
        document.getElementById('hidden_val').value=arr1;
		if(lastRow<5){
			$('#enrolldivtab').css('height','auto');
		}
    }
	
	
function checkemroll(){
	var count = $("input.blkcheckall[type='checkbox']:checked").length;
	if(count==0){
		alertify.alert("Please Select the Employee");
		return false;		
	}
	else{
		$("#single_save").attr('disabled','disabled');
		document.getElementById('quick').submit();
	}
	
}

function checksearchemroll(){
	var count = $("input.searchcheck[type='checkbox']:checked").length;
	if(count==0){
		alertify.alert("Please Select the Employee");
		return false;		
	}
	else{
		$("#single_search_save").attr('disabled','disabled');
		document.getElementById("quick").submit();
	}
	
}

function checklearnersearchemroll(){
	var count = $("input.learnersearchcheck[type='checkbox']:checked").length;
	if(count==0){
		alertify.alert("Please Select the Employee");
		return false;		
	}
	else{
		$("#single_search_save").attr('disabled','disabled');
		document.getElementById("quick").submit();
	}
	
}

function tna_enroll(){
    var program_id=document.getElementById('pro_id').value;
	var eve_id=document.getElementById('eve_id').value;
	if(program_id!=''){
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
                document.getElementById("enrollment_div").innerHTML=xmlhttp.responseText;
                //alertify.alert(xmlhttp.responseText);
				$('#newtnatable').dataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null, null,
					  { "bSortable": false }
				]});
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/tna_employee?program_id="+program_id+"&eve_id="+eve_id,true);
        xmlhttp.send();
    }    
}