 jQuery(document).ready(function(){
	jQuery("#ask_expert").validationEngine();
});



function add_prgfeed(){
	window.location=BASE_URL+"/admin/pre_programfeedback";	
	}
	
 function opentext(){
    document.getElementById('textareaid').style.display='block';
 }
 
  function viewmore(){
	document.getElementById('view').style.display='block';
	document.getElementById('knw').style.display='none';
    }	
   function collapse(){
	document.getElementById('view').style.display='none';
	document.getElementById('knw').style.display='block';
   }
   function view_list(){
       document.getElementById('view_date').style.display='block';  
   }
   function alertmsg(){
       alertify.alert("Test Completed");
       return false;
   }
  function  alertmsg_testholddays(dat){
      alertify.alert("Your Test will be enabled on or after "+dat+" .");
       return false;	
   }
   
   function alertmsg_testholddaysbefore(dat){
         alertify.alert("Your Test will be ended on "+dat+".");
       return false;	
   
    }
	function alertmsg_attempts(){
	     alertify.alert("you have reached maximum number of Test attempts .");
       return false;
	 }
   
   function classroom_condition(dat){
       //alertify.alert("Test will be enable after-"+dat+" Only.");
	          alertify.alert("You cannot launch the assessment untill the event is completed");
       return false;	
    }
   function alertmsgfeed(){
     alertify.alert('Feedback Completed.'); return false;
    }
	function eventcompletedalert(){
	 alertify.alert('You cannot launch the feedback untill the event is completed.');
	
	 }
	function alertpost(){
	  alertify.alert('Please Take Post Test.');
	 }
   function alertmsg_dates(st_date,end_date){
       alertify.alert("Test Open from "+st_date+" to "+end_date);
   }
   function alertmsg_feed(st_date,end_date){
       alertify.alert("Feed Open from "+st_date+" to "+end_date);
   }
   function complete_pdf_dates(st_date,end_date){
       alertify.alert("e-Learning Details Open from "+st_date+" to "+end_date);
   }
   
   function enable_condition(){
      alertify.alert('Material enable after complete the event.') 
     }
   function testinactive(){
     alertify.alert('Test Inactiveted. ');
     }
	 function feedinactive(){
	  alertify.alert('Feedback Inactiveted. ');	 
	  }
   function alertpost(){
     alertify.alert('Feedback enable after completion of Post Test.');
   }
  function testcomplete(){
    alertify.alert('you have successfully completed the Test.');  
     }	 
	 
   function create_topic(f_id,eve_id){
       var xmlhttp;
       if (window.XMLHttpRequest){
            xmlhttp=new XMLHttpRequest();
            }else{
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function(){
                    if (xmlhttp.readyState==4 && xmlhttp.status==200){			
                        alertify.alert(xmlhttp.responseText);
                    }
            }

            xmlhttp.open("GET",BASE_URL+"/admin/create_topic?f_id="+f_id+"&eve_id="+eve_id,true);
            xmlhttp.send(); 
        }
        
    function Cancel_topic(){
        window.location=BASE_URL+"/admin/mylearn_new";
    }

    function complete_pre(){
        alertify.alert("Post test will be enabled upon completion of Course");
    }
    function pretest_enable_condition(){
        alertify.alert("Material will be enabled upon completion of Pre test");
    }
    
    function offline_pre(){
        alertify.alert("You cannot take the Pre-Test as program already started.");
    }
	function alertmsgforpost(){
	   alertify.alert("Feedback will be enable after completion of Post Test.");	
	 }
	
	function takepretest(){
	  alertify.alert('Post Test assessment will get enabled upon completion of Pre Test');
	 
	  }
	  
	  function alertondate(){
	   alertify.alert('Feedback enable between Start Date and End Date Only.');
	 
	   }
	  function alertondatetest(){
	   alertify.alert('Test enable between Start Date and End Date Only.');
	 
	   }
	   function alert_eventclosed(){
	     alertify.alert("Event Closed.");
	    }
    
    
    
    function search_query(){
        document.getElementById('search_result').style.display='none';
        document.getElementById('search_expert').style.display='block';
    }
    
    
$(document).ready(function() {
    $( "#accordion" ).accordion({
        collapsible: true,
        heightStyle: "content"
    });
    
});

function popup_text(){
	$(document).ready(function(){
							   var lclose = $("<a class='lightbox_close_rel'>Close This</a>");
							   $('#msg_box33').append(lclose);
							   var myval = "msg_box33";
							   var moniter_wdith = screen.width;
							   var moniter_height = screen.height;
							   var lightboxinfo_wdith = $("#" + myval).width();	
							   var lightboxinfo_height= $("#" + myval).height();
							   var remain_wdith =  moniter_wdith - lightboxinfo_wdith;		
							   var remain_height =  moniter_height - lightboxinfo_height;		
							   var byremain_wdith = remain_wdith/2;
							   var byremain_height = remain_height/2;
							   var byremain_height2 = byremain_height-10;
							   $("#" + myval).css({left:byremain_wdith});
							   $("#" + myval).css({top:byremain_height2});
							   $('.lightbox_bg').show();
//                                                           $('.lightbox_bg').css('position','fixed');
							   $("#" + myval+' .lightbox_close_rel').add();
							   $("#" + myval).animate({
													  opacity: 1,
													  //left: "180px",
													  top: "180px"
													  }, 10);
							   });
	$('a.lightbox_close_rel').click(function(){
											 var myval2 =$(this).parent().attr('id');
											 $("#" + myval2).animate({
																	 opacity: 0,
																	 top: "-1200px"
																	 },0,
																	 function(){
																		 $('.lightbox_bg').hide()
																	 });
											 });
	
}	



function mytest_details(evalid,eveid,testtype){
                    if(testtype=='PRE' || testtype=='POST')
					{
					    $("#closebutton").css("display","none");
					}
					else{
					   $("#closebutton").css("display","block");
					}
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
										$.ajax({type: "GET",url: BASE_URL+"/admin/insert_question_answers?question_id="+question+"&eveid="+eveid+"&type="+testtype+"&evalid="+evalid+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v=C",
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
									$.ajax({type: "GET",url: BASE_URL+"/admin/insert_question_answers?question_id="+question+"&eveid="+eveid+"&type="+testtype+"&evalid="+evalid+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v="+skip_value,
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
												    $(question_id).addClass('badge-danger');
													$(question_ids).attr('onclick','openskipdiv('+ne+')');
												}
												else
												{
												    $(question_id).addClass('badge-success');
												} 
											}
		                                });
										
								});	
								
								$(function(){
								   var testtype=document.getElementById('ttype').value;
								   
								   /* if(testtype!='FEED'){
								   var minu=document.getElementById('testtime').innerHTML;
									//alertify.alert(minu);
									var tim=minu.trim()
									//if(tim!=0 || tim!=''){
									$("#m_timer").countdowntimer({
										minutes : tim.trim(),
										size : "sm",
										timeUp : timeisUp,
										 timerEnd: function() { alertify.alert('end!!'); }

									}); } */ //}
									
									function timeisUp() { 
									   var divid=document.getElementById("TestDetails").style.display;
									   var timecon=document.getElementById('timeconsume').value;
									   if(divid=="block" && timecon=='Y'){
									       document.getElementById("employeeTest").submit();
											//document.forms["employeeTest"].submit(); 
											}
											 
											}
									
								});
                             }
                         }
                     xmlhttp.open("GET",BASE_URL+"/admin/getemp_test?id="+eveid+"&type="+testtype+"&evalid="+evalid,true);
                     xmlhttp.send();    
	  }
	  
function click_submit() { 
	document.getElementById("employeeTest").submit();
}
	  
function openskipdiv(id){
	var pre=parseInt(id)+1;
	$(".open_question_div").hide();
	$("#question_list"+id).show();
	
} 
	  
    
function mytest_details_session(evelid,eveid,sessid){
                    
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
								$(function(){
								   var testtype=document.getElementById('ttype').value;
								    if(testtype=='PRE' || testtype=='POST')
										{
											$("#closebutton").css("display","none");
										}
										else{
										   $("#closebutton").css("display","block");
									}
								   if(testtype!='FEED'){
									   var minu=document.getElementById('testtime').innerHTML;
										$("#m_timer").countdowntimer({
											minutes : minu.trim(),
											size : "lg",
											timeUp : timeisUp,
											 timerEnd: function() { alertify.alert('end!!'); }

										}); 
									}
									$(".next_question").click(function(){
									    var def=$('#employeeTest').validationEngine('validate');
										if(def==false){
											$('#employeeTest').validationEngine();
											return false;
										}
										else {
									    var $pre = $( this ).attr("data");
										var qtype=document.getElementById("qtype").value;
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
									
										var testid=document.getElementById("testid").value;
									    var qtype=document.getElementById("qtype").value;
									    var question=document.getElementById("question_"+$pre).value;
										var $p=parseInt($pre)+1;
								        $("#question_list"+$pre).hide();
								        $("#question_list"+$p).show();
										$("#question_button"+$p).show();
										$("#question_grid"+$pre).hide();
										$("#question_grid"+$p).show();
										$.ajax({type: "GET",url: BASE_URL+"/admin/insert_session_question_answers?question_id="+question+"&type="+testtype+"&evalid="+evelid+"&ans="+ans+"&testid="+testid+"&qtype="+qtype+"&eveid="+eveid+"&sessid="+sessid,
											success: function(result){
											//alert(result);
											var colors=result;
												
												var question_id=".question_color"+question;
												if(colors=='C'){
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
									
									function timeisUp() { 
									   //var divid=document.getElementById("TestDetails").style.display;divid=="block" && 
									   var timecon=document.getElementById('timeconsume').value;
									   if(timecon=='Y'){
									       document.getElementById("employeeTest").submit();
											//document.forms["employeeTest"].submit(); 
											}
											 
									}
									
								});
								

                            }
                         }
                     xmlhttp.open("GET",BASE_URL+"/admin/getemp_test_session?id="+evelid,true);
                     xmlhttp.send();    
	}
    




    
