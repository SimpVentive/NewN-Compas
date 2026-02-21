var totansweredquest=""
function openpdf(){
	$('#casedesc').hide();
	$('#casepdf').show();
	$('#intray').hide();
}

function opendesc(){
	$('#casepdf').hide();
	$('#casedesc').show();
	$('#intray').hide();
	$('#intray_elements').hide();
	$('#intray_elementss').hide();
	$('#casenarration').show();
	$('#casenarrations').show();
}

function openintray(){
	$('#intray').show();
	$('#casepdf').hide();
	$('#casedesc').hide();
	$('#intray_elements').show();
	$('#intray_elementss').show();
	$('#casenarration').hide();
	$('#casenarrations').hide();
    $('#myModal2').modal('show');
	
}
function open_ass_test(ass_id){
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
	xmlhttp.open("GET",BASE_URL+"/employee/assessment_test_details?ass_id="+ass_id,true);
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
	xmlhttp.open("GET",BASE_URL+"/employee/inbasket_test_details?inbasket_id="+id,true);
	xmlhttp.send();     
}

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
				  placeholder: "portlet-placeholder ui-corner-all",
				  stop: function(event, ui) {
						$( ".intray_position" ).each(function( i ) {
							//alert(i);
							var intray_val="Your Selected intray position is " + parseInt((i+1));
							$(this).html(intray_val);
						});
					}
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
				
$("#close_window").click(function(){				
//$(function(){
	// Number of seconds in every time division
	var days	= 24*60*60,
		hours	= 60*60,
		minutes	= 60;
	
	// Creating the plugin
	$.fn.countup = function(prop){
		
		var options = $.extend({
			callback	: function(){},
			start		: new Date()
		},prop);
		
		var passed = 0, d, h, m, s, 
			positions;

		// Initialize the plugin
		init(this, options);
		
		positions = this.find('.position');
		
		(function tick(){
			
			passed = Math.floor((new Date() - options.start) / 1000);
			
			// Number of days passed
			/* d = Math.floor(passed / days);
			updateDuo(0, 1, d);
			passed -= d*days; */
			
			// Number of hours left
			h = Math.floor(passed / hours);
			updateDuo(0, 1, h);
			passed -= h*hours;
			
			// Number of minutes left
			m = Math.floor(passed / minutes);
			updateDuo(2, 3, m);
			passed -= m*minutes;
			
			// Number of seconds left
			s = passed;
			updateDuo(4, 5, s);
			
			// Calling an optional user supplied callback
			options.callback(h, m, s);
			
			// Scheduling another call of this function in 1s
			setTimeout(tick, 1000);
		})();
		
		// This function updates two digit positions at once
		function updateDuo(minor,major,value){
			switchDigit(positions.eq(minor),Math.floor(value/10)%10);
			switchDigit(positions.eq(major),value%10);
		}
		
		return this;
	};


	function init(elem, options){
		elem.addClass('countdownHolder');

		// Creating the markup inside the container
		$.each(['Hours','Minutes','Seconds'],function(i){
			$('<span class="count'+this+'">').html(
				'<span class="position">\
					<span class="digit static">0</span>\
				</span>\
				<span class="position">\
					<span class="digit static">0</span>\
				</span>'
			).appendTo(elem);
			
			if(this!="Seconds"){
				elem.append('<span class="countDiv countDiv'+i+'"></span>');
			}
		});

	}

	// Creates an animated transition between the two numbers
	function switchDigit(position,number){
		
		var digit = position.find('.digit')
		
		if(digit.is(':animated')){
			return false;
		}
		
		if(position.data('digit') == number){
			// We are already showing this number
			return false;
		}
		
		position.data('digit', number);
		
		var replacement = $('<span>',{
			'class':'digit',
			css:{
				top:'-2.1em',
				opacity:0
			},
			html:number
		});
		
		// The .static class is added when the animation
		// completes. This makes it run smoother.
		
		digit
			.before(replacement)
			.removeClass('static')
			.animate({top:'2.5em',opacity:0},'fast',function(){
				digit.remove();
			})

		replacement
			.delay(100)
			.animate({top:0,opacity:1},'fast',function(){
				replacement.addClass('static');
			});
	}
	$('#countdown').countup();
});
			
			
				
			 }
		 }
	 xmlhttp.open("GET",BASE_URL+"/employee/getemp_test_inbasket?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&ins_id="+inbasket,true);
	 xmlhttp.send();    
}

function mytest_details(assess_test_id,assessment_id,test_id,testtype,inbasket=""){
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
				 jQuery("#employeeTest").validationEngine();
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
							//var question_list="#question_list"+$pre+" .radiocheck:checked";
							//var ans=($(question_list).val());
							var ans=$("input[name='answer_"+$pre+"[]']:checked"). val();
							//alert(ans);
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
						totansweredquest=document.getElementById('totansweredquest').value;
						if(totansweredquest==""){
							totansweredquest= $pre;
						}
						else{
							var res=totansweredquest.split(',');
							if(res.indexOf($pre)==-1){
								totansweredquest= totansweredquest+","+$pre;
							}
						}
						//alert(ans);
						$("#totansweredquest").val(totansweredquest);
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
									$(question_ids).attr('onclick','openskipdiv('+$pre+')');
								}
								else
								{
									$(question_id).addClass('btn-danger');
								} 
							}
						});
						
					}
					return false;
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
					var ans="";
					var next = $( this ).attr("data");
					var qtype=document.getElementById("qtype_"+next).value;
					if(qtype=='T'|| qtype=='S'){
						ans=$("input[name='answer_"+next+"[]']:checked"). val();
					}
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
					//var ans="";
					//var qtype="";
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
							//alert("***"+ans+"***"+colors+"***");
							if(colors=="SKIP" && (ans=="" || typeof ans==="undefined")){
								$(question_id).addClass('btn-danger');
								$(question_ids).attr('onclick','openskipdiv('+ne+')');
							}
							else
							{
								$(question_id).addClass('btn-success');
								$(question_ids).attr('onclick','openskipdiv('+ne+')');
							} 
						}
					});
					return false;
						
				});	
				/*
				$(function(){
				   var testtype=document.getElementById('ttype').value;	  
				   var minu=document.getElementById('testtime').innerHTML;
					var tim=minu.trim()
					function timeisUp() { 
					   var divid=document.getElementById("TestDetails").style.display;
					   var timecon=document.getElementById('timeconsume').value;
					   if(divid=="block" && timecon=='Y'){
						   document.getElementById("employeeTest").submit();
							}
					}
				});*/
				
		$(function(){
		   var minu=document.getElementById('testtime').innerHTML;
			//alert(minu);
			var tim=minu.trim()
			//if(tim!=0 || tim!=''){
			$("#m_timer").countdowntimer({
				minutes : tim.trim(),
				size : "sm",
				timeUp : timeisUp,
				 timerEnd: function() { alert('end!!'); }

			}); 
			
			function timeisUp() { 
			   //var divid=document.getElementById("TestDetails").style.display;
			   var timecon=document.getElementById('timeconsume').value;
			   if(timecon=='Y'){
				//var x = document.getElementsByClassName("form-horizontal");
				//x[0].submit();
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
				$( "#sortable" ).disableSelection();
				$(document).ready(function() {
					window.history.pushState(null, "", window.location.href);
					window.onpopstate = function() {
						window.history.pushState(null, "", window.location.href);
					};
				});
			 }
		 }
	 xmlhttp.open("GET",BASE_URL+"/employee/getemp_test?id="+assess_test_id+"&type="+testtype+"&ass_id="+assessment_id+"&test_id="+test_id+"&ins_id="+inbasket,true);
	 xmlhttp.send();    
}

function click_submit() {
	totansweredquest=$("#totansweredquest").val();
	var res=totansweredquest.split(",");
	var res=totansweredquest.split(",");	
	var totquestion=document.getElementById('totquest').value;
	totquestion=parseInt(totquestion)-1;
	$("#employeeTest").validationEngine({validateNonVisibleFields: true,updatePromptsPosition:true});
	//$("#employeeTest").validationEngine('detach');
	//$("#employeeTest").validationEngine('attach');
	var vv=$("#employeeTest").validationEngine('validate');
	//alert(res.length + " " + totquestion +" "+ vv);
	if(vv && totquestion==res.length){
		document.getElementById("employeeTest").submit();
	}
	else{
		toastr.error("Please give answers to all questions.");
		return false;
	}
}
function openskipdiv(id){
	var pre=parseInt(id)+1;
	$(".open_question_div").hide();
	$("#question_list"+id).show();
	$("#question_button"+id).show();
	
}

function alertmsg(){
   toastr.error("Test Completed");
   return false;
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


function open_comp_details(ass_id,pos_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('comp_details_'+ass_id+'_'+pos_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/employee/competency_profile_details?ass_id="+ass_id+"&pos_id="+pos_id,true);
	 xmlhttp.send();    
}




    
