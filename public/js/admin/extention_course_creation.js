jQuery(document).ready(function(){ //alertify.alert('haii');
	jQuery("#ExetentionForm").validationEngine();
	
});

function getdates(){
  var eveid=document.getElementById('eventid').value;
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
        {   // alertify.alert(xmlhttp.responseText)
            var data=xmlhttp.responseText
            var result =data.split('***');
             document.getElementById('startdate').value=result[0];
             document.getElementById('enddate').value=result[1];
             document.getElementById('courseend').value=result[2];
             document.getElementById('maxdate').value=result[3];
	     document.getElementById('usersdiv').innerHTML=result[4];
             document.getElementById('status').value=result[5];
             
           // document.getElementById('chat_data').innerHTML=xmlhttp.responseText;
          
        }
   
    }
    xmlhttp.open("GET",BASE_URL+"/admin/get_extention_event_dates?id="+eveid,true);
	xmlhttp.send();
}

function getdatevalidate(){
   var max=document.getElementById('maxdate').value;
   var date_stat=document.getElementById('period').value;
   var dat=document.getElementById('eperiod').value;
   var courseend=document.getElementById('courseend').value;
   
   if(date_stat=='W'){
        var weaks=max/7;
        var ff=Math.floor(weaks)
        // alertify.alert(ff); alertify.alert(dat);
          if( ff < dat){
              alertify.alert('Please enter Extention Period less than '+courseend);
              document.getElementById('eperiod').value='';
             return false;
          }
    }
    if(date_stat=='D'){
        if(Number(max) < Number(dat)){
             alertify.alert('Please enter Extention Period less than '+courseend);
              document.getElementById('eperiod').value='';
             return false;
        }
    }
    
  }
 
 function getdatevalidation(){
    
      var max=document.getElementById('maxdate').value;  //alertify.alert(max);
	  var eveend=document.getElementById('enddate').value;
	  // alertify.alert(max);
	  if(max==0){  alertify.alert('You cant extend event.Event is Closed on '+eveend);  document.getElementById('eperiod').value=''; return false;}
	  
   var date_stat=document.getElementById('period').value;
   var dat=document.getElementById('eperiod').value;
   var courseend=document.getElementById('courseend').value;
   if(date_stat=='W'){
        var weaks=max/7;
        var ff=Math.floor(weaks)
        // alertify.alert(ff); alertify.alert(dat);
          if( ff < dat){
              alertify.alert('Please enter Extention Period less than '+courseend);
              document.getElementById('eperiod').value='';
             return false;
          }
    }
    if(date_stat=='D'){
        // alertify.alert(max);
       //  alertify.alert(dat);
        if(Number(max) < Number(dat)){
             alertify.alert('Please enter Extention Period less than '+courseend);
              document.getElementById('eperiod').value='';
             return false;
        }
    }
}

function validation(){
      var dd=document.getElementById('applist1').value;
      var ds=document.getElementById('status').value;
       if(dd=='') { alertify.alert("You dont have Approvers. So you cant send Request."); return false; }
        if(ds==1){ alertify.alert('Extension Request already sent to Approvers.You cant create new one.'); return false;  }
       
    }

    
 //sravanthi code start here
function extention_request(eveid,eveenddate,currentdate){
   
	if(eveenddate > currentdate)
	{
	   window.location=BASE_URL+"/admin/extention_course_creation?eve_id="+eveid;   
	}
    else{	
	 alertify.alert("You cannot request an extension for a program which has been closed.Please contact Learning Department for Assistance");
	}
}
 function extention_course(evenid)
{
 window.location=BASE_URL+"/admin/extention_course_creation1?eve_id="+evenid;  
 
 } 
function history_popup(eventid){
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
        {   // alertify.alert(xmlhttp.responseText)
            document.getElementById('extension_history').innerHTML=xmlhttp.responseText; 
			//alert_msg('extension_history');	
			$(".modal-dialog").draggable();
			$(".modal-dialog").css('top','0px');
        }   
    }
    xmlhttp.open("GET",BASE_URL+"/admin/course_extention_history?eveid="+eventid,true);
	xmlhttp.send();
}
function Approval_deatils(extid,eventid){
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
        {   // alertify.alert(xmlhttp.responseText)
            document.getElementById('approvalstatus').innerHTML=xmlhttp.responseText; 
			//alert_msg('Approvalstatus');	
			$(".modal-dialog").draggable();
			$(".modal-dialog").css('top','0px');
        }   
    }
    xmlhttp.open("GET",BASE_URL+"/admin/get_extention_approval_details?extid="+extid+"&eid="+eventid,true);
	xmlhttp.send();
}
function alert_msg(divid){
	$(document).ready(function(){
							   var lclose = $("<a class='lightbox_close_rel'>Close This</a>");
							   $('#'+divid+'').append(lclose);
							   var myval = ""+divid+"";
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
							   //$('#header_div').draggable();
							   $("#" + myval+' .lightbox_close_rel').add();
							   $("#" + myval).animate({
													  opacity: 1,
													  left: "420px",
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
