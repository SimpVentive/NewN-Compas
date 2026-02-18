
function getemployees(position_id,assessor_id,assessment_id){
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
	xmlhttp.open("GET",BASE_URL+"/assessor/getassessoremployees?assessment_id="+assessment_id+"&assessor_id="+assessor_id+"&position_id="+position_id,true);
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
			document.getElementById("jd_details_views"+position_id+"_"+assessor_id+"_"+assessment_id).innerHTML=xmlhttp.responseText;
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
			document.getElementById("profile_details_views"+position_id+"_"+assessor_id+"_"+assessment_id).innerHTML=xmlhttp.responseText;
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

function getemployeeassessment(position_id,employee_id,assessment_id,emp_name){
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
	xmlhttp.open("GET",BASE_URL+"/assessor/getemployeeassessment?position_id="+position_id+"&employee_id="+employee_id+"&assessment_id="+assessment_id+"&emp_name="+emp_name,true);
	xmlhttp.send();
}


function open_ass_test(ass_id,emp_id,pos_id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('open_assessment').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/assessmenttest_details?ass_id="+ass_id+"&emp_id="+emp_id+"&pos_id="+pos_id,true);
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
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/beireport?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&emp_id="+emp_id+"&ins_id="+instrument,true);
	 xmlhttp.send();    
}

function mytest_details_feedback(ass_id,emp_id,pos_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('testdiv_feedback').innerHTML=xmlhttp.responseText;			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/feedbackreport?ass_id="+ass_id+"&emp_id="+emp_id+"&pos_id="+pos_id,true);
	 xmlhttp.send();    
}

function mytest_details(assess_test_id,assessment_id,test_id,emp_id,testtype,inbasket="",pos_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('testdiv').innerHTML=xmlhttp.responseText;
			 if(testtype=='INBASKET'){
				
				$(".portlet")
				  .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
				  .find( ".portlet-header" )
					.addClass( "ui-widget-header ui-corner-all" )
					.prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'>&nbsp;--&nbsp;&nbsp;&nbsp;</span>");
			 
				$( ".portlet-toggle" ).on( "click", function() {
				  var icon = $( this );
				  icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
				  icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
				});
				$('#close_window_'+assess_test_id).click(function(){				
					$('#myModal_in_'+assess_test_id).modal('show');
				});
				
				$('#close_'+assess_test_id).click(function(){				
					$('#myModal_in_'+assess_test_id).modal('hide');
				});
			}
			
			$('#casestudy_form_'+inbasket).validationEngine();
			$("#casestudy_submit_"+inbasket).click(function(){
				
				var valid = $('#casestudy_form_'+inbasket).validationEngine('validate');
				if (valid == true) {
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/assessor/inbasket_interview_result_insert',
						data: $("#casestudy_form_"+inbasket).serialize(),
						cache: false,
						success: function(response){
							$("#myModal5").modal('toggle');	
							var splitted = response.split("@");
							if(splitted[0] == "done"){    
								//toastr.success("Form submitted successfully!"); 
								swal({   
									title: "Thank You!",   
									type: "success", 
									text: "In-basket evaluation is complete",
									confirmButtonColor: "#8BC34A",   
								});
								return false;	
							}
							else{    
								toastr.error("Form submission failed!");   
							}
							if(splitted[1] == "yes"){
								$("#finalbtn").removeClass("btn-default");
								$("#finalbtn").addClass("btn-primary");
							}							
							
						},
						error:function(response){    
							toastr.error(response);    
						}
					});
				}
				else{
					$('#casestudy_form_'+inbasket).validationEngine();
				}
			});
			$("#casestudy_save_"+inbasket).click(function(){
				
				$.ajax({    
					type: "POST",
					url: BASE_URL+'/assessor/inbasket_interview_result_insert',
					data: $("#casestudy_form_"+inbasket).serialize(),
					cache: false,
					success: function(response){
						$("#myModal5").modal('toggle');	
						var splitted = response.split("@");
						if(splitted[0] == "done"){    
							//toastr.success("Form submitted successfully!"); 
							swal({   
								title: "Thank You!",   
								type: "success", 
								text: "In-basket evaluation is save successfully",
								confirmButtonColor: "#8BC34A",   
							});
							return false;	
						}
						else{    
							toastr.error("Form submission failed!");   
						}
						if(splitted[1] == "yes"){
							$("#finalbtn").removeClass("btn-default");
							$("#finalbtn").addClass("btn-primary");
						}							
						
					},
					error:function(response){    
						toastr.error(response);    
					}
				});
				
			});
			
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getemp_test_view?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&emp_id="+emp_id+"&ins_id="+inbasket+"&pos_id="+pos_id,true);
	 xmlhttp.send();    
}

function mytest_details_casestudy(assess_test_id,assessment_id,test_id,emp_id,testtype,casestudy="",pos_id,case_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('testdiv').innerHTML=xmlhttp.responseText;
			$('#openinbasketview_'+case_id+'_'+pos_id+'_'+emp_id).click(function(){
					
				//$("#myModalin_"+case_id+"_"+pos_id+"_"+emp_id).modal('toggle');
				//$('#myModalin_'+case_id+'_'+pos_id+'_'+emp_id).css('display','block');
			});
			$('#close_'+case_id+'_'+pos_id+'_'+emp_id).click(function(){				
				$('#myModalin_'+case_id+'_'+pos_id+'_'+emp_id).modal('hide');
			});
			$('#casestudy_form_'+casestudy).validationEngine();
			$("#casestudy_submit_"+casestudy).click(function(){
				var valid = $('#casestudy_form_'+casestudy).validationEngine('validate');
				if (valid == true) {
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/assessor/casestudy_interview_result_insert',
						data: $("#casestudy_form_"+casestudy).serialize(),
						cache: false,
						success: function(response){
							$("#myModal5").modal('toggle');	
							var splitted = response.split("@");
							if(splitted[0] == "done"){   
								//toastr.success("Form submitted successfully!");  
								swal({   
									title: "Thank You!",   
									type: "success", 
									text: "Casestudy evaluation is complete",
									confirmButtonColor: "#8BC34A",   
								});
								return false;
							}
							else{    
								toastr.error("Form submission failed!");   
							}
							if(splitted[1] == "yes"){
								$("#finalbtn").removeClass("btn-default");
								$("#finalbtn").addClass("btn-primary");
							}
						},
						error:function(response){    
							toastr.error(response);    
						}
					});
				}
				else{
					$('#casestudy_form_'+casestudy).validationEngine();
				}
			});
			
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getemp_test_casestudy_view?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&emp_id="+emp_id+"&ins_id="+casestudy+"&pos_id="+pos_id+"&case_id="+case_id,true);
	 xmlhttp.send();    
}

function work_info_view(id){
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
	xmlhttp.open("GET",BASE_URL+"/assessor/inbasket_test_details?inbasket_id="+id,true);
	xmlhttp.send();     
}

function work_info_view_casestudy(id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('workinfodetails_casestudy'+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/casestudy_test_details?casestudy_id="+id,true);
	xmlhttp.send();     
}
function alertmsg(){
   toastr.error("Rating can be done once this is completed");
   return false;
}

function inbasket_test(assess_test_id,assessment_id,test_id,emp_id,testtype,inbasket=""){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('test_details'+inbasket).innerHTML=xmlhttp.responseText;
			$('#inbasket_form_'+inbasket).validationEngine();
			$("#inbasket_submit_"+inbasket).click(function(){   
				$.ajax({    
					type: "POST",
					url: BASE_URL+'/assessor/inbasket_result_insert',
					data: $("#inbasket_form_"+inbasket).serialize(),
					cache: false,
					success: function(response){
						$("#workinfoview_test"+inbasket).modal('toggle');	
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
	xmlhttp.open("GET",BASE_URL+"/assessor/inbasket_test_view?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&emp_id="+emp_id+"&ins_id="+inbasket,true);
	 xmlhttp.send();    
}

function casestudy_test(assess_test_id,assessment_id,test_id,emp_id,testtype,casestudy_id=""){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('casestudy_details'+casestudy_id).innerHTML=xmlhttp.responseText;
			$('#casestudy_form_'+casestudy_id).validationEngine();
			$("#casestudy_submit_"+casestudy_id).click(function(){   
				$.ajax({    
					type: "POST",
					url: BASE_URL+'/assessor/casestudy_result_insert',
					data: $("#casestudy_form_"+casestudy_id).serialize(),
					cache: false,
					success: function(response){
						$("#workinfoview_casetest"+casestudy_id).modal('toggle');	
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
	xmlhttp.open("GET",BASE_URL+"/assessor/casestudy_test_view?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&emp_id="+emp_id+"&case_id="+casestudy_id,true);
	 xmlhttp.send();    
}

function test_score_info(attempt_id,test_id,emp_id,pos_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('test_score_detail'+attempt_id+'_'+test_id).innerHTML=xmlhttp.responseText;
			$('#test_form_'+attempt_id).validationEngine();
			$("#test_submit_"+attempt_id).click(function(){
				var valid = $('#test_form_'+attempt_id).validationEngine('validate');
				if (valid == true) {
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/assessor/test_result_insert',
						data: $("#test_form_"+attempt_id).serialize(),
						cache: false,
						success: function(response){
							$("#test_score_details"+attempt_id+"_"+test_id).modal('toggle');
							var splitted = response.split("@");
							if(splitted[0] == "done"){    
								//toastr.success("Form submitted successfully!");
								swal({   
									title: "Thank You!",   
									type: "success", 
									text: "Test evaluation is complete",
									confirmButtonColor: "#8BC34A",   
								});
								return false;	
							}
							else{    
								toastr.error("Form submission failed!");   
							}
							if(splitted[1] == "yes"){
								$("#finalbtn").removeClass("btn-default");
								$("#finalbtn").addClass("btn-primary");
							}
						},
						error:function(response){    
							toastr.error(response);    
						}
					});
				}
				else{
					$('#test_form_'+attempt_id).validationEngine();
				}
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/test_info_view?attempt_id="+attempt_id+"&test_id="+test_id+"&emp_id="+emp_id+"&pos_id="+pos_id,true);
	 xmlhttp.send();    
}

function mytest_detail_view(event_id,ass_id,test_id,emp_id,ass_type){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('test_details_views'+event_id+'_'+test_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getemp_test_readonly?event_id="+event_id+"&ass_id="+ass_id+"&test_id="+test_id+"&emp_id="+emp_id+"&ass_type="+ass_type,true);
	 xmlhttp.send();    
}

function interview_detail_view(event_id,ass_id,test_id,emp_id,ass_type){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('interview_details_views'+event_id+'_'+test_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getemp_test_readonly?event_id="+event_id+"&ass_id="+ass_id+"&test_id="+test_id+"&emp_id="+emp_id+"&ass_type="+ass_type,true);
	 xmlhttp.send();    
}

/* function test_score_interview(assess_test_id,position_id,rating_id,emp_id,tab_id=""){
	
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('interview_score_detail'+assess_test_id+'_'+position_id+'_'+rating_id).innerHTML=xmlhttp.responseText;
			if(tab_id!=''){
				$('.main').removeClass('active');
				$('.main').removeClass('in');
				$('#'+tab_id).addClass('active in');
				$('#tab'+tab_id).addClass('active');
				
			}	
			$('#inbasket_interview_form_'+rating_id).validationEngine();
			$("#inbasket_interview_submit_"+rating_id).click(function(){
				var valid = $('#inbasket_interview_form_'+rating_id).validationEngine('validate');
				if (valid == true) {
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/assessor/inbasket_interview_result_insert',
						data: $('#inbasket_interview_form_'+rating_id).serialize(),
						cache: false,
						success: function(response){
							$("#interview_score_details"+assess_test_id+"_"+position_id+'_'+rating_id).modal();
							
							
													
							var splitted = response.split("@");
							if(splitted[0] == "done"){
								
								//toastr.success("Form submitted successfully!");  
								swal({   
									title: "Thank You!",   
									type: "success", 
									text: "Inbasket evaluation is complete",
									confirmButtonColor: "#8BC34A",   
								});
							}
							else{    
								toastr.error("Form submission failed!");   
							}
							
							if(splitted[1] == "yes"){
								$("#finalbtn").removeClass("btn-default");
								$("#finalbtn").addClass("btn-primary");
							}
							
						},
						error:function(response){    
							toastr.error(response);    
						}
					});
				}
				else{
					$('#inbasket_interview_form_'+rating_id).validationEngine();
				}
			});
			$('#casestudy_interview_form_'+rating_id).validationEngine();
			$("#casestudy_interview_submit_"+rating_id).click(function(){
				var valid = $('#casestudy_interview_form_'+rating_id).validationEngine('validate');
				if (valid == true) {
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/assessor/casestudy_interview_result_insert',
						data: $('#casestudy_interview_form_'+rating_id).serialize(),
						cache: false,
						success: function(response){
							$("#interview_score_details"+assess_test_id+"_"+position_id+'_'+rating_id).modal();	
							
							var splitted = response.split("@");
							if(splitted[0] == "done"){
								
								
								//toastr.success("Form submitted successfully!");  
								swal({   
									title: "Thank You!",   
									type: "success", 
									text: "Casestudy evaluation is complete",
									confirmButtonColor: "#8BC34A",   
								});
							}
							else{    
								toastr.error("Form submission failed!");   
							}
							
							if(splitted[1] == "yes"){
								$("#finalbtn").removeClass("btn-default");
								$("#finalbtn").addClass("btn-primary");
							}
							
						},
						error:function(response){    
							toastr.error(response);    
						}
					});
				}
				else{
					$('#casestudy_interview_form_'+rating_id).validationEngine();
				}
			});
			$('#interview_form_'+rating_id).validationEngine();
			$("#interview_submit_"+rating_id).click(function(){
				
				var valid = $('#interview_form_'+rating_id).validationEngine('validate');
				if (valid == true) {
					
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/assessor/casestudy_result_insert',
						data: $('#interview_form_'+rating_id).serialize(),
						cache: false,
						success: function(response){
							$("#interview_score_details"+assess_test_id+"_"+position_id+'_'+rating_id).modal();	
							
							var splitted = response.split("@");
							if(splitted[0] == "done"){   
								//toastr.success("Form submitted successfully!");  
								swal({   
									title: "Thank You!",   
									type: "success", 
									text: "Interview evaluation is complete",
									confirmButtonColor: "#8BC34A",   
								});
							}
							else{    
								toastr.error("Form submission failed!");   
							}
							
							if(splitted[1] == "yes"){
								$("#finalbtn").removeClass("btn-default");
								$("#finalbtn").addClass("btn-primary");
							}
							
						},
						error:function(response){    
							toastr.error(response);    
						}
					});
				}
				else{
					$('#interview_form_'+rating_id).validationEngine();
				}
			});
			
			$('#interview_over_form_'+rating_id).validationEngine();
			$("#interview_over_submit_"+rating_id).click(function(){
				var valid = $('#interview_over_form_'+rating_id).validationEngine('validate');
				if (valid == true) {
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/assessor/interview_overall_result_insert',
						data: $('#interview_over_form_'+rating_id).serialize(),
						cache: false,
						success: function(response){
							$("#interview_score_details"+assess_test_id+"_"+position_id+'_'+rating_id).modal('toggle');	
							
							var splitted = response.split("@");
							if(splitted[0] == "done"){   
								//toastr.success("Form submitted successfully!");  
								swal({   
									title: "Thank You!",   
									type: "success", 
									text: "Interview Over All evaluation is complete",
									confirmButtonColor: "#8BC34A",   
								});
							}
							else{    
								toastr.error("Form submission failed!");   
							}
							
							if(splitted[1] == "yes"){
								$("#finalbtn").removeClass("btn-default");
								$("#finalbtn").addClass("btn-primary");
							}
							
						},
						error:function(response){    
							toastr.error(response);    
						}
					});
				}
				else{
					$('#interview_over_form_'+rating_id).validationEngine();
				}
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/interview_comp_test_view?assess_test_id="+assess_test_id+"&position_id="+position_id+"&rating_id="+rating_id+"&emp_id="+emp_id,true);
	 xmlhttp.send();    
} */

function test_score_interview(assess_test_id,position_id,rating_id,emp_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('interview_score_detail'+assess_test_id+'_'+position_id+'_'+rating_id).innerHTML=xmlhttp.responseText;
			$('#interview_form_'+rating_id).validationEngine();
			$("#interview_submit_"+rating_id).click(function(){
				var valid = $('#interview_form_'+rating_id).validationEngine('validate');
				if (valid == true) {
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/assessor/casestudy_result_insert',
						data: $('#interview_form_'+rating_id).serialize(),
						cache: false,
						success: function(response){
							$("#interview_score_details"+assess_test_id+"_"+position_id+'_'+rating_id).modal('toggle');	
							var splitted = response.split("@");
							if(splitted[0] == "done"){   
								//toastr.success("Form submitted successfully!");  
								swal({   
									title: "Thank You!",   
									type: "success", 
									text: "Interview evaluation is complete",
									confirmButtonColor: "#8BC34A",   
								});
							}
							else{    
								toastr.error("Form submission failed!");   
							}
							
							if(splitted[1] == "yes"){
								$("#finalbtn").removeClass("btn-default");
								$("#finalbtn").addClass("btn-primary");
							}
							
						},
						error:function(response){    
							toastr.error(response);    
						}
					});
				}
				else{
					$('#interview_form_'+rating_id).validationEngine();
				}
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/interview_test_view?assess_test_id="+assess_test_id+"&position_id="+position_id+"&rating_id="+rating_id+"&emp_id="+emp_id,true);
	 xmlhttp.send();    
}


function mytest_details_interview(assess_test_id,assessment_id,test_id,emp_id,testtype){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('testdiv_interview').innerHTML=xmlhttp.responseText;								
				 jQuery(document).ready(function(){
				 jQuery("#employeeTest").validationEngine({promptPosition: 'inline'});
				 });
				

				$(".next_question").click(function(){
					var def=$('#employeeTest').validationEngine('validate');
					if(def==false){
						$('#employeeTest').validationEngine();
						return false;
					}
					else {
					var $pre = $( this ).attr("data");
					var qtype=document.getElementById("qtype_"+$pre).value;
					if(qtype=='T'|| qtype=='S'){
						var question_list="#question_list"+$pre+" .radiocheck:checked";
						var ans=($(question_list).val());
					}
					else if(qtype=='F'|| qtype=='B' || qtype=='FT'){
						var ans=$("#answer_"+$pre+"_0").val();
						//alert(ans);
					}
					else if(qtype=='M'){
						var ans = [];
						var question_list="#question_list"+$pre;
						$('.check:checked').each(function() {
						   ans.push($(this).val());
						});
						//alert(ans);
					}
					//alert(ans);
					var testid=document.getElementById("testid").value;
					//var qtype=document.getElementById("qtype").value;
					var question=document.getElementById("question_"+$pre).value;
					var $p=parseInt($pre)+1;
						$("#question_list"+$pre).hide();
						$("#question_list"+$p).show();
						$("#question_button"+$p).show();
						$("#question_grid"+$pre).hide();
						$("#question_grid"+$p).show();
						$.ajax({type: "GET",url: BASE_URL+"/assessor/insert_question_answers?question_id="+question+"&assess_test_id="+assess_test_id+"&type="+testtype+"&assessment_id="+assessment_id+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v=C"+"&emp_id="+emp_id,
							success: function(result){
							//alert(result);
							var colors=result;
								/* var question_id=".question_color"+question;
								if(colors=='C'){
									$(question_id).addClass('badge-success');
								}
								else
								{
									$(question_id).addClass('badge-danger');
								} */
								var que_id=question;
								var question_id=".question_color"+question;
								var question_ids="#open_skip_question"+question;
								
								if(colors=='C'){
									$(question_id).removeClass('btn-danger');
									$(question_id).addClass('btn-success');
								}
								else
								{
									$(question_id).addClass('btn-danger');
								} 
							}
						});
					}
				});
				$( ".pre_question").click(function() {
					var $next = $( this ).attr("data");
					var $p=parseInt($next)-1;
						$("#question_list"+$next).hide();
						$("#question_list"+$p).show();
						$("#question_button"+$p).show();
						$("#question_grid"+$next).hide();
						$("#question_grid"+$p).show();
				});
				$( ".skip_question").click(function() {
					var next = $( this ).attr("data");
					var p=parseInt(next)+1;
					var ne=parseInt(next);
					$("#skipvalue"+ne).val("SKIP");
					$("#question_list"+next).hide();
					$("#question_list"+p).show();
					$("#question_button"+p).show();
					$("#question_grid"+next).hide();
					$("#question_grid"+p).show();
					var testid=document.getElementById("testid").value;
					var question=document.getElementById("question_"+next).value;
					var skip_value=document.getElementById("skipvalue"+ne).value;
					var ans="";
					var qtype="";
					$.ajax({type: "GET",url: BASE_URL+"/assessor/insert_question_answers?question_id="+question+"&assess_test_id="+assess_test_id+"&type="+testtype+"&assessment_id="+assessment_id+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v="+skip_value+"&emp_id="+emp_id,
						success: function(result){
						//alert(result);
						var colors=result;
							var question_id=".question_color"+question;
							/*if(colors=='C'){
								$(question_id).addClass('badge-success');
							}
							else
							{
								$(question_id).addClass('badge-danger');
							} */
							var question_ids="#open_skip_question"+question;
							var que_id=question;
							if(colors=='SKIP'){
								$(question_id).addClass('btn-danger');
								$(question_ids).attr('onclick','openskipdiv('+ne+')');
							}
							else
							{
								$(question_id).addClass('btn-success');
							} 
						}
					});
						
				});	
				
				$(function(){
				   var testtype=document.getElementById('ttype').value;
				   
				   
				   var minu=document.getElementById('testtime').innerHTML;
					//alertify.alert(minu);
					var tim=minu.trim()
					//if(tim!=0 || tim!=''){
					/* $("#m_timer").countdowntimer({
						minutes : tim.trim(),
						size : "sm",
						timeUp : timeisUp,
						 timerEnd: function() { alertify.alert('end!!'); }

					});  */
					
					function timeisUp() { 
					   var divid=document.getElementById("TestDetails").style.display;
					   var timecon=document.getElementById('timeconsume').value;
					   if(divid=="block" && timecon=='Y'){
						   document.getElementById("employeeTest").submit();
							//document.forms["employeeTest"].submit(); 
							}
							 
					}
				});
				$( "#sortable" ).sortable({
				  connectWith: ".column",
				  handle: ".portlet-header",
				  cancel: ".portlet-toggle",
				  placeholder: "portlet-placeholder ui-corner-all"
				}); 
				$(".portlet")
				  .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
				  .find( ".portlet-header" )
					.addClass( "ui-widget-header ui-corner-all" )
					.prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'>&nbsp;--&nbsp;&nbsp;&nbsp;</span>");
			 
				$( ".portlet-toggle" ).on( "click", function() {
				  var icon = $( this );
				  icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
				  icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
				});
				$( "#sortable" ).disableSelection();
			 }
		 }
	 xmlhttp.open("GET",BASE_URL+"/assessor/getemp_test?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&emp_id="+emp_id,true);
	 xmlhttp.send();    
}

function open_summary_sheet(ass_id,emp_id,pos_id,assor_id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('open_assessment').innerHTML=xmlhttp.responseText;
			$('#summary_sumbit').validationEngine();
			$("#summary_info_submit").click(function(){
				
				var valid = $('#summary_sumbit').validationEngine('validate');
				if (valid == true) {
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/assessor/summary_result_insert',
						data: $("#summary_sumbit").serialize(),
						cache: false,
						success: function(response){
							if(response == "done"){    
								//toastr.success("Form submitted successfully!"); 
								swal({   
									title: "Thank You!",   
									type: "success", 
									text: "Final Assessment has been completed",
									confirmButtonColor: "#8BC34A",   
								}, function() {
									window.location =BASE_URL+"/assessor/getassessoremployees?assessment_id="+ass_id+"&assessor_id="+assor_id+"&position_id="+pos_id;
								});
								return false;
							}
							else{    
								toastr.error("Form submission failed!");   
							}
						},
						error:function(response){    
							toastr.error(response);    
						}
					});
				}
				else{
					$('#summary_sumbit').validationEngine();
				}
			});
			$("#summary_info_save").click(function(){
				$.ajax({    
					type: "POST",
					url: BASE_URL+'/assessor/summary_result_insert_save',
					data: $("#summary_sumbit").serialize(),
					cache: false,
					success: function(response){
						if(response == "done"){    
							//toastr.success("Form submitted successfully!"); 
							swal({   
								title: "Thank You!",   
								type: "success", 
								text: "Final Assessment has been Saved",
								confirmButtonColor: "#8BC34A",   
							}, function() {
								window.location =BASE_URL+"/assessor/getassessoremployees?assessment_id="+ass_id+"&assessor_id="+assor_id+"&position_id="+pos_id;
							});
							return false;
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
	xmlhttp.open("GET",BASE_URL+"/assessor/ass_summary_details?ass_id="+ass_id+"&emp_id="+emp_id+"&pos_id="+pos_id,true);
	xmlhttp.send();     
}

function open_alert(comp_id){
	toastr.warning("The assessed level has been computed by the system.  PLEASE make sure, you are certain as to why you would like to change the same."); 
}


function open_migration_maps(comp_id,scale_id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('workinfodetails'+comp_id).innerHTML=xmlhttp.responseText;
			$('[data-toggle="popover"]').popover();
			
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/migration_map_details?comp_id="+comp_id+"&scale_id="+scale_id,true);
	xmlhttp.send();     
}

function open_comp_indicator(comp_id,scale_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('indicator_comp'+comp_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getcomp_indicator?comp_id="+comp_id+"&scale_id="+scale_id,true);
	 xmlhttp.send();    
}

function get_level_indicator(com_id){
	var scale_id=document.getElementById("scale_id_select_"+com_id).value;
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
			//alert(xmlhttp.responseText);
			document.getElementById('scaledetail_info'+com_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getindicator_details?comp_id="+com_id+"&scale_id="+scale_id,true);
	xmlhttp.send();
}

function open_alert_summary(comp_id){
	var req_id=document.getElementById("requiredlevel_"+comp_id).value;
	var ass_id=document.getElementById("OVERALL_"+comp_id).value;
	if(req_id>=ass_id){
		//alert();
		swal({   
			title: "Development Raod Map Alert!",   
			type: "success", 
			text: "Assessed level <=Required level.Please construct a development roadmap listing the learning needs.",
			confirmButtonColor: "#8BC34A",   
		});
		$('#development_'+comp_id).addClass('validate[required,minSize[100]]');
		return false;
		
		/* toastr.warning("The assessed level has been computed by the system.  PLEASE make sure, you are certain as to why you would like to change the same.");  */
	}
	else{
		swal({   
			title: "Alert!",   
			type: "success", 
			text: "Assessed level >Required level.Please justify.",
			confirmButtonColor: "#8BC34A",   
		});
		$('#development_'+comp_id).removeClass('validate[required,minSize[100]]');
	}
	
}

function gettestquestion(comp_def_id,event_id,emp_id,assessment_id,q_id){
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
			document.getElementById('testques'+comp_def_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/comp_test_view?comp_id="+comp_def_id+"&event_id="+event_id+"&emp_id="+emp_id+"&ass_id="+assessment_id+"&q_id="+q_id,true);
	xmlhttp.send();
}

function getoveralldevelop(ass_id,pos_id,emp_id){
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
			document.getElementById('overalldevdet').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/overalldet?ass_id="+ass_id+"&pos_id="+pos_id+"&emp_id="+emp_id,true);
	xmlhttp.send();
}

function open_secound_model(comp_def_id,scale_id,emp_id,type,report_id,assess_test_id,rot_in,pos_id,rating_id){
	
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('interview_question_detail'+comp_def_id+'_'+scale_id+'_'+emp_id+'_'+type).innerHTML=xmlhttp.responseText;
			$('#interview_questions'+comp_def_id+'_'+scale_id+'_'+emp_id+'_'+type).modal('toggle');
			$('#interview_form_'+comp_def_id+'_'+scale_id+'_'+emp_id+'_'+type).validationEngine();
			$('#interview_submit_'+comp_def_id+'_'+scale_id+'_'+emp_id+'_'+type).click(function(){
				var valid = $('#interview_form_'+comp_def_id+'_'+scale_id+'_'+emp_id+'_'+type).validationEngine('validate');
				if (valid == true) {
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/assessor/interview_process_result_insert',
						data: $('#interview_form_'+comp_def_id+'_'+scale_id+'_'+emp_id+'_'+type).serialize(),
						cache: false,
						success: function(response){
							
							test_score_interview(assess_test_id,pos_id,rating_id,emp_id,'open_7');
							$('#interview_questions'+comp_def_id+'_'+scale_id+'_'+emp_id+'_'+type).modal('toggle');
							
							
							var splitted = response.split("@");
							if(splitted[0] == "done"){   
								//toastr.success("Form submitted successfully!");  
								swal({   
									title: "Thank You!",   
									type: "success", 
									text: "Interview evaluation is complete",
									confirmButtonColor: "#8BC34A",   
								});
							}
							else{    
								toastr.error("Form submission failed!");   
							}
							
							if(splitted[1] == "yes"){
								$("#finalbtn").removeClass("btn-default");
								$("#finalbtn").addClass("btn-primary");
							}
							
						},
						error:function(response){    
							toastr.error(response);    
						}
					});
				}
				else{
					$('#interview_form_'+comp_def_id+'_'+scale_id+'_'+emp_id+'_'+type).validationEngine();
				}
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getemp_comp_int_questions?comp_def_id="+comp_def_id+"&scale_id="+scale_id+"&emp_id="+emp_id+"&type="+type+"&report_id="+report_id+"&assess_test_id="+assess_test_id+"&rot_in="+rot_in+"&pos_id="+pos_id+"&rating_id="+rating_id,true);
	 xmlhttp.send();    
}

function close_mode(comp_def_id,scale_id,emp_id,type){
	$('#interview_questions'+comp_def_id+'_'+scale_id+'_'+emp_id+'_'+type).modal('hide');
}

function open_generate_questions(comp_def_id,scale_id,emp_id,type,count_n){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var cc=document.getElementById('intrandom_'+comp_def_id+'_'+scale_id).value;
	cc=parseInt(cc)+1;
	if(cc>count_n){
		cc=1;
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('interview_question_generate_detail_'+comp_def_id+'_'+scale_id+'_'+emp_id+'_'+type).innerHTML=xmlhttp.responseText;
			document.getElementById('intrandom_'+comp_def_id+'_'+scale_id).value=cc;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getemp_comp_int_generate_questions?comp_def_id="+comp_def_id+"&scale_id="+scale_id+"&emp_id="+emp_id+"&type="+type+"&rot_in="+cc,true);
	 xmlhttp.send();
	
}





