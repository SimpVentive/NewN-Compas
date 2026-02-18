$(document).ready(function(){
	$("#tab_summary_sumbit").validationEngine();
	$("#tab_strengths_sumbit").validationEngine();
});

$(document).ready(function() {
	$('.test-nav-panel li').click(function(event){
		if ($(this).hasClass('disabled')) {
			return false;
		}
	});
	if(status!=''){
		if(status=='self'){
			$('#compentencies_li').addClass('active');
			$('#self-assessment').addClass('active');
			$('#career-planning').removeClass('active');
			$('#strengths-tab').removeClass('active');
			$('#development-planning').removeClass('active');
		}
		else if(status=='career'){
			$('#employees_li').addClass('active');
			$('#career-planning').css("display", "block");
			$('#compentencies_li').addClass('active');
			$('#strengths_li').removeClass('active');
			$('#development_li').removeClass('active');
			$('#strengths-tab').css("display", "none");
			$('#self-assessment').css("display", "none");
			$('#development-planning').css("display", "none");
		}
		else if(status=='strength'){
			$('#strengths_li').addClass('active');
			$('#strengths-tab').css("display", "block");
			$('#compentencies_li').addClass('active');
			$('#employees_li').addClass('active');
			$('#development_li').removeClass('active');
			$('#career-planning').css("display", "none");
			$('#self-assessment').css("display", "none");
			$('#development-planning').css("display", "none");
		}
		else if(status=='development'){
			$('#development_li').addClass('active');
			$('#development-planning').css("display", "block");
			$('#compentencies_li').addClass('active');
			$('#employees_li').addClass('active');
			$('#strengths_li').addClass('active');
			$('#career-planning').css("display", "none");
			$('#self-assessment').css("display", "none");
			$('#strengths-tab').css("display", "none");
		}
	}
	else{
		$("#compentencies_li").addClass('active');
		$('#self-assessment').addClass('active');
		$('#career-planning').removeClass('active');
		$('#strengths-tab').removeClass('active');
		$('#development-planning').removeClass('active');
	} 
});
function getassessmentjd(position_id,assessment_id){
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
	xmlhttp.open("GET",BASE_URL+"/employee/getassessmentjd?assessment_id="+assessment_id+"&position_id="+position_id,true);
	xmlhttp.send();
}

function getassessmentprofiling(position_id,assessment_id){
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
	xmlhttp.open("GET",BASE_URL+"/employee/getassessmentprofiling?assessment_id="+assessment_id+"&position_id="+position_id,true);
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
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getemployeeassessment?position_id="+position_id+"&employee_id="+employee_id+"&assessment_id="+assessment_id,true);
	xmlhttp.send();
}


function open_ass_test(ass_id,emp_id){
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
	xmlhttp.open("GET",BASE_URL+"/assessor/assessmenttest_details?ass_id="+ass_id+"&emp_id="+emp_id,true);
	xmlhttp.send();     
}

function mytest_details(assess_test_id,assessment_id,test_id,emp_id,testtype,inbasket=""){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('testdiv').innerHTML=xmlhttp.responseText;
			/* if(testtype=='INBASKET'){
				$(".list-group li").sort(sort_li) // sort elements
					.appendTo('.list-group'); // append again to the list
					// sort function callback
					function sort_li(a, b){
					return ($(b).data('position')) < ($(a).data('position')) ? 1 : -1;    
					}
			} */
			$('#casestudy_form_'+inbasket).validationEngine();
			$("#casestudy_submit_"+inbasket).click(function(){   
				$.ajax({    
					type: "POST",
					url: BASE_URL+'/assessor/casestudy_result_insert',
					data: $("#casestudy_form_"+inbasket).serialize(),
					cache: false,
					success: function(response){
						$("#myModal5").modal('toggle');	
						if(response == "done"){    
							alert("Form submitted successfully!");    
						}
						else{    
							alert("Form submission failed!");   
						}
					},
					error:function(response){    
						alert(response);    
					}
				});
			});
			
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/assessor/getemp_test_view?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&emp_id="+emp_id+"&ins_id="+inbasket,true);
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
   toastr.error("Test Completed");
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
							toastr.error("Form submitted successfully!");    
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
							toastr.error("Form submitted successfully!");    
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

function test_score_info(attempt_id,test_id,emp_id){
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
				$.ajax({    
					type: "POST",
					url: BASE_URL+'/assessor/casestudy_result_insert',
					data: $("#test_form_"+attempt_id).serialize(),
					cache: false,
					success: function(response){
						$("#test_score_details"+attempt_id+"_"+test_id).modal('toggle');	
						if(response == "done"){    
							toastr.error("Form submitted successfully!");    
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
	xmlhttp.open("GET",BASE_URL+"/assessor/test_info_view?attempt_id="+attempt_id+"&test_id="+test_id+"&emp_id="+emp_id,true);
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

function test_score_interview(attempt_id,test_id,emp_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('interview_score_detail'+attempt_id+'_'+test_id).innerHTML=xmlhttp.responseText;
			$('#interview_form').validationEngine();
			$("#interview_submit").click(function(){   
				$.ajax({    
					type: "POST",
					url: BASE_URL+'/assessor/casestudy_result_insert',
					data: $("#interview_form").serialize(),
					cache: false,
					success: function(response){
						$("#interview_score_details"+attempt_id+"_"+test_id).modal('toggle');	
						if(response == "done"){    
							toastr.error("Form submitted successfully!");    
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
	xmlhttp.open("GET",BASE_URL+"/assessor/interview_test_view?attempt_id="+attempt_id+"&test_id="+test_id+"&emp_id="+emp_id,true);
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
				$( "#sortable" ).sortable();
			 }
		 }
	 xmlhttp.open("GET",BASE_URL+"/assessor/getemp_test?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&emp_id="+emp_id,true);
	 xmlhttp.send();    
}

function open_summary_sheet(ass_id,emp_id,pos_id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('assessmentdetails').innerHTML=xmlhttp.responseText;
			
			//jQuery("#summary_sumbit").validationEngine();
			
			$("#summary_info_submit").click(function(){
				if($("#summary_sumbit").validationEngine('validate')){
				$.ajax({    
					type: "POST",
					url: BASE_URL+'/employee/self_summary_result_insert',
					data: $("#summary_sumbit").serialize(),
					cache: false,
					success: function(response){
						if(response == "done"){    
							toastr.error("Form submitted successfully!");  
							open_summary_sheet(ass_id,emp_id,pos_id);
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
				});
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/employee/self_ass_summary_details?ass_id="+ass_id+"&emp_id="+emp_id+"&pos_id="+pos_id,true);
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
	xmlhttp.open("GET",BASE_URL+"/employee/getcomp_indicator?comp_id="+comp_id+"&scale_id="+scale_id,true);
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


