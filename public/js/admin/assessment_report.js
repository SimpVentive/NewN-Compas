
function getemployees(position_id,assessment_id){
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
			document.getElementById('assessmentdetails').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/getemployees?assessment_id="+assessment_id+"&position_id="+position_id,true);
	xmlhttp.send();
}

function getselfemployees(position_id,assessment_id){
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
			document.getElementById('assessmentdetails').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/self_getemployees?assessment_id="+assessment_id+"&position_id="+position_id,true);
	xmlhttp.send();
}

function self_getemployeeassessment(position_id,employee_id,assessment_id){
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
			document.getElementById('employeedetails').innerHTML=xmlhttp.responseText;
			$('#admin_summary_sumbit').validationEngine();
			$("#summary_info_submit").click(function(){
				$.ajax({    
					type: "POST",
					url: BASE_URL+'/admin/self_summary_result_insert',
					data: $("#admin_summary_sumbit").serialize(),
					cache: false,
					success: function(response){
						if(response == "done"){    
							toastr.success("Form submitted successfully!");    
						}
						else{    
							toastr.error("Form submission failed!");   
						}
					},
					error:function(response){    
						toastr.error(response);    
					}
				});
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/getselfemployeeassessment?position_id="+position_id+"&employee_id="+employee_id+"&assessment_id="+assessment_id,true);
	xmlhttp.send();
}

function getemployeeassessment(position_id,employee_id,assessment_id){
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
			document.getElementById('employeedetails').innerHTML=xmlhttp.responseText;
			$('#admin_summary_sumbit').validationEngine();
			$("#summary_info_submit").click(function(){
				$.ajax({    
					type: "POST",
					url: BASE_URL+'/admin/summary_result_insert',
					data: $("#admin_summary_sumbit").serialize(),
					cache: false,
					success: function(response){
						if(response == "done"){    
							toastr.success("Form submitted successfully!");    
						}
						else{    
							toastr.error("Form submission failed!");   
						}
					},
					error:function(response){    
						toastr.error(response);    
					}
				});
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/getemployeeassessment?position_id="+position_id+"&employee_id="+employee_id+"&assessment_id="+assessment_id,true);
	xmlhttp.send();
}

function ass_info_view(assessment_id,position_id,employee_id,assessor_id){
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
			document.getElementById('assessorviewdetails'+assessor_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/getassessorsummary?position_id="+position_id+"&employee_id="+employee_id+"&assessment_id="+assessment_id+"&assessor_id="+assessor_id,true);
	xmlhttp.send();
}

function getassessmentjd(position_id,assessor_id,assessment_id){
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
			document.getElementById('assessmentdetails').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getassessmentjd?assessment_id="+assessment_id+"&assessor_id="+assessor_id+"&position_id="+position_id,true);
	xmlhttp.send();
}

function getassessmentprofiling(position_id,assessor_id,assessment_id){
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
			document.getElementById('assessmentdetails').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getassessmentprofiling?assessment_id="+assessment_id+"&assessor_id="+assessor_id+"&position_id="+position_id,true);
	xmlhttp.send();
}

function getemployeedetails(employee_id,assessment_id){
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
			document.getElementById('employeedetails').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getemployeedetails?employee_id="+employee_id+"&assessment_id="+assessment_id,true);
	xmlhttp.send();
}

function mytest_details_bei(assess_test_id,assessment_id,test_id,emp_id,testtype,instrument){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('testdiv_bei').innerHTML=xmlhttp.responseText;	
			$('#bei_master').validationEngine();	
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/beireport?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&emp_id="+emp_id+"&ins_id="+instrument,true);
	 xmlhttp.send();    
}