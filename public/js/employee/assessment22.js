


function mytest_details_casestudy(assess_test_id,assessment_id,test_id,testtype,inbasket=""){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('testdiv').innerHTML=xmlhttp.responseText;								
				 jQuery(document).ready(function(){
				 jQuery("#employeeTest").validationEngine({promptPosition: 'inline'});
				 });
				 //alert("asdasd");

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
						$("#question_upload"+$p).show();
						$("#question_grid"+$pre).hide();
						$("#question_grid"+$p).show();
						$.ajax({type: "GET",url: BASE_URL+"/employee/insert_question_answers?question_id="+question+"&assess_test_id="+assess_test_id+"&type="+testtype+"&assessment_id="+assessment_id+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v=C",
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
					$.ajax({type: "GET",url: BASE_URL+"/employee/insert_question_answers?question_id="+question+"&assess_test_id="+assess_test_id+"&type="+testtype+"&assessment_id="+assessment_id+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v="+skip_value,
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
				
				/* $(function(){
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

					});
					
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
				  connectWith: "#sortable",
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
				$( "#sortable" ).disableSelection();*/
			 }
		 }
	 xmlhttp.open("GET",BASE_URL+"/employee/getemp_test_casestudy?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&ins_id="+inbasket,true);
	 xmlhttp.send();    
}


function mytest_details_inbasket(assess_test_id,assessment_id,test_id,testtype,inbasket=""){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('testdiv').innerHTML=xmlhttp.responseText;								
				 jQuery(document).ready(function(){
				 jQuery("#employeeTest").validationEngine({promptPosition: 'inline'});
				 });
				 //alert("asdasd");
	
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
						$.ajax({type: "GET",url: BASE_URL+"/employee/insert_question_answers?question_id="+question+"&assess_test_id="+assess_test_id+"&type="+testtype+"&assessment_id="+assessment_id+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v=C",
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
					$.ajax({type: "GET",url: BASE_URL+"/employee/insert_question_answers?question_id="+question+"&assess_test_id="+assess_test_id+"&type="+testtype+"&assessment_id="+assessment_id+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v="+skip_value,
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
				
				/* $(function(){
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

					});
					
					function timeisUp() { 
					   var divid=document.getElementById("TestDetails").style.display;
					   var timecon=document.getElementById('timeconsume').value;
					   if(divid=="block" && timecon=='Y'){
						   document.getElementById("employeeTest").submit();
							//document.forms["employeeTest"].submit(); 
							}
							 
					}
				}); */
				$( "#sortable" ).sortable({
				  connectWith: "#sortable",
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
				var d =new Date();
				var curr_day = d.getDate();var
				curr_month =
				d.getMonth();var
				curr_year =
				d.getFullYear();var curr_hour = d.getHours();var
				curr_min = d.getMinutes();var
				curr_sec = d.getSeconds();

				curr_month++;// In js, first month is 0, not
				1
				year_2d =
				curr_year.toString().substring(2,4)
				var start_period=curr_year+"-"+curr_month+"-"+curr_day+" "+curr_hour+":"+curr_min+":"+curr_sec;
				$("#start_period").val(start_period);
			 }
		 }
	 xmlhttp.open("GET",BASE_URL+"/employee/getemp_test_inbasket?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&ins_id="+inbasket,true);
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
	xmlhttp.open("GET",BASE_URL+"/employee/casestudy_test_details?casestudy_id="+id,true);
	xmlhttp.send();     
}

function mytest_details_beh(assess_test_id,assessment_id,testtype,instrument_id=""){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('testdiv').innerHTML=xmlhttp.responseText;								
				 jQuery(document).ready(function(){
				 jQuery("#employeeTest").validationEngine({promptPosition: 'inline'});
				 });
				 //alert("asdasd");

				$(".next_question").click(function(){
					var def=$('#employeeTest').validationEngine('validate');
					if(def==false){
						$('#employeeTest').validationEngine();
						return false;
					}
					else {
					var $pre = $( this ).attr("data");
					
					var qtype=document.getElementById("qtype_"+$pre).value;
					var question_list="#question_list"+$pre+".radiocheck:checked";
					var ans=($(question_list).val());
					//alert(ans);
					var testid=document.getElementById("testid").value;
					//var qtype=document.getElementById("qtype").value;
					var question=document.getElementById("question_"+$pre).value;
					var par_question=document.getElementById("par_question_"+$pre).value;
					var $p=parseInt($pre)+1;
						$("#question_list"+$pre).hide();
						$("#question_list"+$p).show();
						$("#question_button"+$p).show();
						$("#question_grid"+$pre).hide();
						$("#question_grid"+$p).show();
						$.ajax({type: "GET",url: BASE_URL+"/employee/insert_question_beh_answers?ins_subpara_id="+question+"&ins_para_id="+par_question+"&assess_test_id="+assess_test_id+"&assessment_id="+assessment_id+"&instrument_id="+instrument_id+"&ans="+ans+"&qtype="+qtype,
							success: function(result){
							//alert(result);
							var colors=result;
							var que_id=question;
							var question_id=".question_color"+question;
							var question_ids="#open_skip_question"+question;
								
								
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
				
			 }
		 }
	 xmlhttp.open("GET",BASE_URL+"/employee/getemp_test_beh?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&instrument_id="+instrument_id,true);
	 xmlhttp.send();    
}

function open_self_summary_sheet(ass_id,emp_id,pos_id){
	
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('open_assessment').innerHTML=xmlhttp.responseText;
			$("#summary_info_submit").click(function(){
				if($("#summary_sumbit").validationEngine('validate')){
					$.ajax({    
						type: "POST",
						url: BASE_URL+'/employee/self_full_summary_result_insert',
						data: $("#summary_sumbit").serialize(),
						cache: false,
						success: function(response){
							if(response == "done"){    
								toastr.success("Form submitted successfully!");  
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
	xmlhttp.open("GET",BASE_URL+"/employee/self_ass_full_summary_details?ass_id="+ass_id+"&emp_id="+emp_id+"&pos_id="+pos_id,true);
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




    
