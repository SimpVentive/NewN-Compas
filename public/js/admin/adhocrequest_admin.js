
$(document).ready(function(){
	$('#usercreationform_step1').validationEngine();
	$('#usercreationform_step2').validationEngine();
	$('#usercreationform_step3').validationEngine();
	$('#usercreationform_step4').validationEngine();
	$('.datepicker').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});	
});

function diffdate(){
     var startdate=document.getElementById("startdate").value;
	 alert(startdate);
     var enddates=document.getElementById("enddate").value;
     if(startdate!=="" && enddates!==""){
         startdate=startdate.split("-");
         enddates=enddates.split("-");
         var date1 = new Date(startdate[2],(startdate[1]-1),startdate[0]);
         var date2 = new Date(enddates[2],(enddates[1]-1),enddates[0]);
         var timeDiff = Math.abs(date2.getTime() - date1.getTime());
         var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
         document.getElementById("password_validity_days").value=diffDays+1;
     }
     else{
         document.getElementById("password_validity_days").value="";
     }

    //alert("diffDays")​;
}
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		minDate:org_start_date,
		maxDate:difDays,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id === "startdate" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
			instance.settings.dateFormat ||
			$.datepicker._defaults.dateFormat,
			selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});				   
});

    function search_program(){
        var catg=document.getElementById('catg').value;
        var program_type=document.getElementById('prg_type').value;
        var stdate=document.getElementById('startdate').value;
        var enddate=document.getElementById('enddate').value;
        
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
			document.getElementById('search1').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/search_learning_corner?catg="+catg+"&program_type="+program_type+"&stdate="+stdate+"&enddate="+enddate,true);
	xmlhttp.send(); 
    }
    
    function program_event(p_id){ //alert(p_id);
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
			//document.getElementById('search1').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/event_learning_corner?p_id="+p_id,true);
	xmlhttp.send(); 
    }
    
	

