jQuery(document).ready(function(){
	jQuery("#org_master").validationEngine();	
});
$("input[type=submit]").click(function(){
	$("input[type=submit]").attr('disabled','disabled');
});
$(document).ready(function(){
		var dates = $( "#startdate_edit, #enddate_edit" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		minDate:"<?php //echo date('d-m-Y');?>",
		/*maxDate:"<?php //echo $futureDate;?>",*/
		showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "startdate_edit" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
											}
									});

});


$(document).ready(function(){
		 $('#startdate, #enddate').datepicker('destroy');
		 var date11=document.getElementById('cat_date').value;	
		// var arrdate11 = date11.split('/')
		// var date23 = arrdate11[0] + "/" + arrdate11[1] + "/" + arrdate11[2];
		  var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			if(dd<10){dd='0'+dd}
			if(mm<10){mm='0'+mm} 
			var date22 = yyyy+'-'+mm+'-'+dd;
   			var one_day=1000*60*60*24;
			var date1 = new Date(date22);
			var date2 = new Date(date11);
      // Convert both dates to milliseconds
			  var date1_ms = date1.getTime();
			  var date2_ms = date2.getTime();
     		 var difference_ms = date2_ms - date1_ms;
      // Convert back to days and return
       var diffDays =  Math.round(difference_ms/one_day); 
	  /* if(diffDays<0){ diffDays=0;}*/
			var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
			defaultDate:"+1w" , //dd,
			changeMonth: true,
			numberOfMonths: 1,
			minDate:diffDays,
			showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
			buttonImageOnly: true,
			onSelect: function( selectedDate ) { 
				var option = this.id == "startdate" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
							dates.not( this ).datepicker( "option", option, date );
											}
									});	
			//document.getElementById("startdate").value="";
			//document.getElementById("enddate").value="";
	 });

$(document).ready(function(){
		var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		minDate:"<?php //echo date('d-m-Y');?>",
		/*maxDate:"<?php //echo $futureDate;?>",*/
		showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "startdate" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
											}
									});

});
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
    });
});

function validate_bc(){
	//alertify.alert('hello');
	var str=document.getElementById('category').value;
	var str1=document.getElementById('pro_name').value;
	var str2=document.getElementById('profile_upd').value;
	var stdate=document.getElementById('startdate').value;
	var cat_dat=document.getElementById('cat_date').value;
	var todate=document.getElementById('enddate').value;
	//alertify.alert(todate);
	//var stdate=document.getElementById('stdate').value;
    //var enddate=document.getElementById('enddate').value;
    var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    if(stdate!=''){
		
    // Match the date format through regular expression
    if(stdate.match(dateformat)){
        //document.form1.text1.focus();
        //Test which seperator is used '/' or '-'
        var opera1 = stdate.split('/');
        var opera2 = stdate.split('-');
        lopera1 = opera1.length;
        lopera2 = opera2.length;
        // Extract the string into month, date and year
        if (lopera1>1){
            var pdate = stdate.split('/');
        }
        else if (lopera2>1){
            var pdate = stdate.split('-');
        }
        var dd = parseInt(pdate[0]);
        var mm  = parseInt(pdate[1]);
        var yy = parseInt(pdate[2]);
        // Create list of days of a month [assume there is no leap year by default]
        var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
        if (mm==1 || mm>2){
            if (dd>ListofDays[mm-1]){
                alertify.alert('Invalid date format!');
                return false;
            }
        }
        if (mm==2){
            var lyear = false;
            if ( (!(yy % 4) && yy % 100) || !(yy % 400)){
                lyear = true;
            }
            if ((lyear==false) && (dd>=29)){
                alertify.alert('Invalid date format!');
                return false;
            }
            if ((lyear==true) && (dd>29)){
                alertify.alert('Invalid date format!');
                return false;
            }
        }
    }
    else{
        alertify.alert("Invalid date format!");
        //document.form1.text1.focus();
        return false;
    }
    }
    if(todate!=''){
    if(todate.match(dateformat)){
        //document.form1.text1.focus();
        //Test which seperator is used '/' or '-'
        var opera1 = stdate.split('/');
        var opera2 = stdate.split('-');
        lopera1 = opera1.length;
        lopera2 = opera2.length;
        // Extract the string into month, date and year
        if (lopera1>1){
            var pdate = stdate.split('/');
        }
        else if (lopera2>1){
            var pdate = stdate.split('-');
        }
        var dd = parseInt(pdate[0]);
        var mm  = parseInt(pdate[1]);
        var yy = parseInt(pdate[2]);
        // Create list of days of a month [assume there is no leap year by default]
        var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
        if (mm==1 || mm>2){
            if (dd>ListofDays[mm-1]){
                alertify.alert('Invalid date format!');
                return false;
            }
        }
        if (mm==2){
            var lyear = false;
            if ( (!(yy % 4) && yy % 100) || !(yy % 400)){
                lyear = true;
            }
            if ((lyear==false) && (dd>=29)){
                alertify.alert('Invalid date format!');
                return false;
            }
            if ((lyear==true) && (dd>29)){
                alertify.alert('Invalid date format!');
                return false;
            }
        }
    }
    else{
        alertify.alert("Invalid date format!");
        //document.form1.text1.focus();
        return false;
    }
    }
	
	if(str==''){
	   alertify.alert('Please Select Category');
	   return false;
	}
	if(str1==''){
	   alertify.alert('Please Enter Program Name');
	   return false;
	}
	if(str2==''){
	   alertify.alert('Please Select Competency Profile Update');
	   return false;
	}
	if(stdate==''){
	   alertify.alert('Please Select Start Date');
	   return false;
	}
	
	    var dt2= todate;
	    var arrDt2 = dt2.split('-')
	    var date2=arrDt2[0] + "-" + arrDt2[1] + "-" + arrDt2[2];
	    var dt= stdate;
	    var arrDt = dt.split('-')
	    var date1=arrDt[0] + "-" + arrDt[1] + "-" + arrDt[2];
	    if(date2 < date1 ){
		   alertify.alert("Please select start date is less than End date is "+date2);
		  return false;
	    }
		
  }
	
function getcatdate() {
	$caid=document.getElementById('category').value; 
       
	 	var xmlhttp;
			 if (window.XMLHttpRequest)                
			 {// code for IE7+, Firefox, Chrome, Opera, Safari
			 xmlhttp=new XMLHttpRequest();
			 }
		
			  else{// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			 }
			xmlhttp.onreadystatechange=function()                                          
			{                                         
			if (xmlhttp.readyState==4 && xmlhttp.status==200)           
			{ 
			
			document.getElementById('cat_date').value=xmlhttp.responseText;
		    
			 $('#startdate, #enddate').datepicker('destroy');
			   
			  
		 var date11=document.getElementById('cat_date').value;	
		  var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
			var date22 = yyyy+'-'+mm+'-'+dd;
   			var one_day=1000*60*60*24;
			var date1 = new Date(date22);
			var date2 = new Date(date11);
      // Convert both dates to milliseconds
			  var date1_ms = date1.getTime();
			  var date2_ms = date2.getTime();
     		 var difference_ms = date2_ms - date1_ms;
      // Convert back to days and return
       var diffDays =  Math.round(difference_ms/one_day); 
	   if(diffDays<0){ diffDays=0;}
			var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
			defaultDate:"+1w" , //dd,
			changeMonth: true,
			numberOfMonths: 1,
			minDate:diffDays,
			showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
			buttonImageOnly: true,
			onSelect: function( selectedDate ) { 
				var option = this.id == "startdate" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
							dates.not( this ).datepicker( "option", option, date );
											}
									});	
			document.getElementById("startdate").value="";
			document.getElementById("enddate").value="";
			
			}
		  } 
		  
		  xmlhttp.open("GET",BASE_URL+"/admin/get_cat_date?id="+$caid,true);
		  xmlhttp.send();
   }
   
   function checkdate(){
	var dd1=document.getElementById('cat_date').value;
	var dd2=document.getElementById('startdate').value;
	  alertify.alert(dd1);
	 if(dd1>dd2){
		 alertify.alert("Please select program date after "+dd1);
		 return false;
		 }
   }  
 
 
  function cleardata() {
	document.getElementById('category').value='';
	document.getElementById('pro_code').value=''; 
	document.getElementById('pro_name').value='';
	document.getElementById('description').value='';
	document.getElementById('kwords').value='';
	document.getElementById('profile_upd').value='';
	document.getElementById('program_admin').value='';
	document.getElementById('startdate').value='';
	document.getElementById('enddate').value='';
	
  }	

function clearall(){
	document.getElementById('program_type').value='';
	document.getElementById('program_name').value='';
 }
 function clearall_com(){   
	document.getElementById('comp_name').value='';
	document.getElementById('comp_level').value='';
	document.getElementById('program_type').value='';
 }
 
 function edit_pre(id){
	 var xmlhttp;
			 if (window.XMLHttpRequest)                
			 {// code for IE7+, Firefox, Chrome, Opera, Safari
			 xmlhttp=new XMLHttpRequest();
			 }
			  else{// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			 }
			xmlhttp.onreadystatechange=function()                                          
			{                                         
			if (xmlhttp.readyState==4 && xmlhttp.status==200)           
			{ 
			/*$("#dialogform1").dialog({width:600}); 
			$("#dialogform1").dialog('open');*/
			document.getElementById("competency_level").innerHTML=xmlhttp.responseText;
		  }
		  } 
		  xmlhttp.open("GET",BASE_URL+"/admin/pre_comp_edit_details?id="+id,true);
		  xmlhttp.send();
 }
 
 function edit_pre_new(id){
	 var xmlhttp;
			 if (window.XMLHttpRequest)                
			 {// code for IE7+, Firefox, Chrome, Opera, Safari
			 xmlhttp=new XMLHttpRequest();
			 }
			  else{// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			 }
			xmlhttp.onreadystatechange=function()                                          
			{                                         
			if (xmlhttp.readyState==4 && xmlhttp.status==200)           
			{ 
			/*$("#dialogform1").dialog({width:600}); 
			$("#dialogform1").dialog('open');*/
			document.getElementById("competency_level_new").innerHTML=xmlhttp.responseText;
		  }
		  } 
		  xmlhttp.open("GET",BASE_URL+"/admin/pre_comp_edit_details_new?id="+id,true);
		  xmlhttp.send();
 }
 
 function edit_pre1(id){
	 var xmlhttp;
			 if (window.XMLHttpRequest)                
			 {// code for IE7+, Firefox, Chrome, Opera, Safari
			 xmlhttp=new XMLHttpRequest();
			 }
			  else{// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			 }
			xmlhttp.onreadystatechange=function()                                          
			{                                         
			if (xmlhttp.readyState==4 && xmlhttp.status==200)           
			{ 
			/*$("#dialogform1").dialog({width:600}); 
			$("#dialogform1").dialog('open');*/
			document.getElementById("competency_level1").innerHTML=xmlhttp.responseText;
		  }
		  } 
		  xmlhttp.open("GET",BASE_URL+"/admin/pre_pro_edit_details?id="+id,true);
		  xmlhttp.send();
 }
 function deleteparticipant(id){
	 var xmlhttp;
	 document.getElementById('deleting').style.display='none';
			 if (window.XMLHttpRequest)                
			 {// code for IE7+, Firefox, Chrome, Opera, Safari
			 xmlhttp=new XMLHttpRequest();
			 }
			  else{// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			 }
			xmlhttp.onreadystatechange=function()                                          
			{                                         
			if (xmlhttp.readyState==4 && xmlhttp.status==200)           
			{ 
			/*$("#dialogform1").dialog({width:600}); 
			$("#dialogform1").dialog('open');*/
			document.getElementById("competency_level1").innerHTML=xmlhttp.responseText;
		  }
		  } 
		  xmlhttp.open("GET",BASE_URL+"/admin/deleteepre_pro?id="+id,true);
		  xmlhttp.send();
 }
 
 function deleteparticipant1(id){
	 var xmlhttp;
	 document.getElementById('deleted').style.display='none';
			 if (window.XMLHttpRequest)                
			 {// code for IE7+, Firefox, Chrome, Opera, Safari
			 xmlhttp=new XMLHttpRequest();
			 }
			  else{// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			 }
			xmlhttp.onreadystatechange=function()                                          
			{                                         
			if (xmlhttp.readyState==4 && xmlhttp.status==200)           
			{ 
			/*$("#dialogform1").dialog({width:600}); 
			$("#dialogform1").dialog('open');*/
			document.getElementById("competency_level1").innerHTML=xmlhttp.responseText;
		  }
		  } 
		  xmlhttp.open("GET",BASE_URL+"/admin/deleteepre_ceo?id="+id,true);
		  xmlhttp.send();
 }
 
 function checkpname(){
	 var field=document.getElementById('program_name').value;
	 var exist=document.getElementById('prg_id').value;
	 if(field == exist){
		 alertify.alert('Program Title Already Exists, it should be unique');
		 return false;
		 }
	 }
 
 function checkcname(){
	 var field=document.getElementById('comp_name').value;
	 var exist=document.getElementById('prg_id1').value;
	 var field1=document.getElementById('comp_level').value;
	 var exist1=document.getElementById('prg_id2').value;
	 if(field == exist){
		 alertify.alert('Competency Name Already Exists, it should be unique');
		 return false;
	 }
	 /*if(field1 == exist1){
		 alertify.alert('Competency Level Already Exists, it should be unique');
		 return false;
	 } */
 }

function deleteparticipant2(id){
	 var xmlhttp;
	 document.getElementById('deleted').style.display='none';
			 if (window.XMLHttpRequest)                
			 {// code for IE7+, Firefox, Chrome, Opera, Safari
			 xmlhttp=new XMLHttpRequest();
			 }
			  else{// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			 }
			xmlhttp.onreadystatechange=function()                                          
			{                                         
			if (xmlhttp.readyState==4 && xmlhttp.status==200)           
			{ 
			/*$("#dialogform1").dialog({width:600}); 
			$("#dialogform1").dialog('open');*/
			//document.getElementById("competency_level1").innerHTML=xmlhttp.responseText;
		  }
		  } 
		  xmlhttp.open("GET",BASE_URL+"/admin/deleteepre_ceo_new_pre?id="+id,true);
		  xmlhttp.send();
 }
 
function search_titles(){
	var title=document.getElementById('program_name').value;
	var pro_id=document.getElementById('proid_id').value;
	//alertify.alert(id);
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
			//var n=xmlhttp.responseText.split(","); 
		//document.getElementById("listofvalues").innerHTML=n[0];
		//if(n[1]==1){
			document.getElementById('msg_box33').style.display='block';
			
			document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
			alert_msg();
			$(function(){$('#master_titles_table1').dataTable({ 'bJQueryUI': true, 'sPaginationType': 'full_numbers', "sScrollY": "150px", "bPaginate": false,"aoColumnDefs": [
      { 'bSortable': false, 'aTargets': [ 0 ] }
   ]});});
			//}
		}
	}
	//xmlhttp.open("GET",BASE_URL+"/admin/get_program_titles?title="+title,true);
	xmlhttp.open("GET",BASE_URL+"/admin/get_program_titles?title="+title+"&pro_id="+pro_id,true);
	xmlhttp.send(); 
	
} 

function mastervalue(id){
	for(var i=0;i<=id;i++){
		var title=document.getElementById('title_'+i).checked;
		if(title==true){
			var code=document.getElementById('title_'+i).value;
			var value=document.getElementById('Program_Name'+i).value;
			
		}
	}
	document.getElementById('program_id').value=code;
	document.getElementById('program_name').value=value;
	document.getElementById('msg_box33').style.display='none';
	$('.lightbox_bg').hide();
}

function mastervalue_comp(id){
	//alertify.alert(id);
	for(var i=0;i<=id;i++){
		var title=document.getElementById('title_'+i).checked;
		if(title==true){
			var prgid=document.getElementById('Competency_id'+i).value;
			var value=document.getElementById('comp_name'+i).value;
			//alertify.alert(prgid);
		}
	}
	//alertify.alert(prgid);
	document.getElementById('fetched_id').value=prgid;
	document.getElementById('comp_name').value=value;
	document.getElementById('msg_box33').style.display='none';
	$('.lightbox_bg').hide();
	
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
			//var n=xmlhttp.responseText.split(","); 
		//document.getElementById("listofvalues").innerHTML=n[0];
		//if(n[1]==1){
			//document.getElementById('msg_box33').style.display='block';
			
			document.getElementById("comp_level").innerHTML=xmlhttp.responseText;
			//alert_msg();

			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/get_program_titles_comp_level?prgid="+prgid,true);
	xmlhttp.send(); 
	
}

function alert_msg(){
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
 
 
 function search_titles_comp(){
	var title=document.getElementById('comp_name').value;
	//alertify.alert(title);
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
			//var n=xmlhttp.responseText.split(","); 
		//document.getElementById("listofvalues").innerHTML=n[0];
		//if(n[1]==1){
			document.getElementById('msg_box33').style.display='block';
			
			document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
			alert_msg();
			$(function(){$('#master_titles_table2').dataTable({ 'bJQueryUI': true, 'sPaginationType': 'full_numbers', "sScrollY": "150px", "bPaginate": false,"aoColumnDefs": [
      { 'bSortable': false, 'aTargets': [ 0 ] }
   ]});});
			//}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/get_program_titles_comp?title="+title,true);
	xmlhttp.send(); 
	
} 
function search_titles_comp_pre(){
	var title=document.getElementById('comp_name_new').value;
	//alertify.alert(title);
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
			//var n=xmlhttp.responseText.split(","); 
		//document.getElementById("listofvalues").innerHTML=n[0];
		//if(n[1]==1){
			document.getElementById('msg_box33').style.display='block';
			
			document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
			alert_msg();
			$(function(){$('#master_titles_table2').dataTable({ 'bJQueryUI': true, 'sPaginationType': 'full_numbers', "sScrollY": "150px", "bPaginate": false,"aoColumnDefs": [
      { 'bSortable': false, 'aTargets': [ 0 ] }
   ]});});
			//}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/get_program_titles_comp_pre?title="+title,true);
	xmlhttp.send(); 
	
} 

function mastervalue_comp_pre(id){
	//alertify.alert(id);
	for(var i=0;i<=id;i++){
		var title=document.getElementById('title_'+i).checked;
		if(title==true){
			var prgid=document.getElementById('Competency_id'+i).value;
			var value=document.getElementById('comp_name'+i).value;
			
		}
	}
	//alertify.alert(prgid);
	document.getElementById('fetched_id_comp').value=prgid;
	document.getElementById('comp_name_new').value=value;
	document.getElementById('msg_box33').style.display='none';
	$('.lightbox_bg').hide();
	
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
			//var n=xmlhttp.responseText.split(","); 
		//document.getElementById("listofvalues").innerHTML=n[0];
		//if(n[1]==1){
			//document.getElementById('msg_box33').style.display='block';
			
			document.getElementById("comp_level_new").innerHTML=xmlhttp.responseText;
			//alert_msg();

			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/get_program_titles_comp_level_pre?prgid="+prgid,true);
	xmlhttp.send(); 
	
}


function getlevel_name(){ 
	var str1=document.getElementById('comp_name').value;
	//alertify.alert(str1);
	if (str1.length==0){
		document.getElementById("statediv1").innerHTML="<select name='comp_level' id='comp_level' class='inputList'> <option value=''> Select </option> </select>";
		return false;
	}
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp2=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function(){
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			//
			//alertify.alert(xmlhttp2.responseText);
			document.getElementById("statediv1").innerHTML=xmlhttp2.responseText;
		}
	}
	xmlhttp2.open("GET",BASE_URL+"/admin/get_level_name_edit?comp_name="+str1,true);
	xmlhttp2.send();
}

function getlevel_name1(){
	 var id=document.getElementById("comp_name").value;
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
			
				document.getElementById("table_menu1").innerHTML=xmlhttp.responseText;
				//alertify.alert(xmlhttp.responseText)
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/get_level_name?id="+id,true);
		xmlhttp.send();
	 }


function getlevel_name_com(){ 
	var str1=document.getElementById('comp_name').value;
	if (str1.length==0){
		document.getElementById("statediv1").innerHTML="<select name='comp_level' id='comp_level' class='inputList'> <option value=''> Select </option> </select>";
		return false;
	}
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp2=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function(){
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			//
			//alertify.alert(xmlhttp2.responseText);
			document.getElementById("statediv1").innerHTML=xmlhttp2.responseText;
		}
	}
	xmlhttp2.open("GET",BASE_URL+"/admin/get_level_name?comp_name="+str1,true);
	xmlhttp2.send();
}