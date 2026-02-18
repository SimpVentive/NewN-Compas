jQuery(document).ready(function(){
	jQuery("#calendar_preparation").validationEngine();
	$('.datepicker').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
});
$(document).ready(function(){
	var dates = $( "#from_date1, #to_date1" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	onSelect: function( selectedDate ) { 
		var option = this.id == "from_date1" ? "minDate" : "maxDate",
		instance = $( this ).data( "datepicker" ),
		date = $.datepicker.parseDate(
		instance.settings.dateFormat ||
		$.datepicker._defaults.dateFormat,
		selectedDate, instance.settings );
		dates.not( this ).datepicker( "option", option, date );
	}
	});

});

function open_publish(){
	$("#publish").show();
	$("#pdf").hide();
}

function search_data(){
	var location_id=document.getElementById('location_details').value;
	var employee_id=document.getElementById('employee_details').value;
	var calendar_month_id=document.getElementById('calendar_month_id').value;
	var calendar_id=document.getElementById('calendar_id').value;
	var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('source_table').innerHTML="loading..."
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('source_table').innerHTML=xmlhttp.responseText;
		}
	}
	
	xmlhttp.open("GET",BASE_URL+"/admin/calendar_program_publish?calendar_id="+calendar_id+"&calendar_month_id="+calendar_month_id+"&location_id="+location_id+"&employee_id="+employee_id,true);
	xmlhttp.send();
}

function open_program_events(id,cal_id,cal_month_id,pro_id){
	document.getElementById("program_info_emp").innerHTML="";
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
			document.getElementById("program_info_emp").innerHTML=xmlhttp.responseText;
			
			var dates = $( "#start_date1, #end_date1" ).datepicker({dateFormat:"dd-mm-yy",
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) { 
				var option = this.id == "start_date1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
				selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/calender_publish_events?pro_id="+id+"&cal_id="+cal_id+"&cal_month_id="+cal_month_id+"&program_id="+pro_id,true);
	xmlhttp.send();

}