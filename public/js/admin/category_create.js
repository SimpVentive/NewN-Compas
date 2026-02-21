jQuery(document).ready(function(){
	jQuery("#category_creation").validationEngine();	
	$('.datepicker').datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
		$('#stdate').datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
		$('#enddate1').datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
});

jQuery(document).ready(function(){
	jQuery("#edit_category").validationEngine();
});
                                                
$(document).ready(function(){
		   var dates = $( "#stdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeYear: true,		
		//minDate:0,		
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "stdate" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
											}
									});

});
function cat_name(){
	var catid=document.getElementById('cattype').value;
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
			document.getElementById('parent_cat').style.display='block';
			document.getElementById('parent_cat').innerHTML=xmlhttp.responseText;
			var cat_start=document.getElementById('cat_startdate').value;
			var cat_end=document.getElementById('cat_enddate').value;
			//alert(cat_start+" "+cat_end);
			//alert(xmlhttp.responseText);
			$("#startdate").datepicker("destroy");
			$("#enddate").datepicker("destroy");
			var dates = $( "#startdate, #enddate" ).datepicker({
				dateFormat:"dd-mm-yy",
				defaultDate: "+1w",
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				minDate:cat_start,
				maxDate:cat_end,
				//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg",
				//buttonImageOnly: true,
				onSelect: function( selectedDate ) {
					var option = this.id == "startdate" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(instance.settings.dateFormat ||$.datepicker._defaults.dateFormat, selectedDate, instance.settings );
					dates.not( this ).datepicker( "option", option, date );
				}
															   });
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/change_category?id="+catid,true);
	xmlhttp.send();	
}

function subcatdate(){ 
	var catid=document.getElementById('category').value; 
        //var catid=document.getElementById('sub_category').value;
	//alert(catid);
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
			document.getElementById('parent_cat').style.display='block';
			document.getElementById('parent_cat').innerHTML=xmlhttp.responseText;
			var cat_start=document.getElementById('cat_startdate').value;
			var cat_end=document.getElementById('cat_enddate').value;
			//alert(cat_start+" "+cat_end);
			//alert(xmlhttp.responseText);
			$("#startdate").datepicker("destroy");
			$("#enddate").datepicker("destroy");
			var dates = $( "#startdate, #enddate" ).datepicker({
				dateFormat:"dd-mm-yy",
				defaultDate: "+1w",
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				minDate:cat_start,
				maxDate:cat_end,
				//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg",
				//buttonImageOnly: true,
				onSelect: function( selectedDate ) {
					var option = this.id == "startdate" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(instance.settings.dateFormat ||$.datepicker._defaults.dateFormat, selectedDate, instance.settings );
					dates.not( this ).datepicker( "option", option, date );
				}
															   });				
															  
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/sub_category?id="+catid,true);
	xmlhttp.send();	
	
}

function Addcatdate(){ 
	var catid=document.getElementById('category').value; 
	//alert(catid);
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
			document.getElementById('parent_cat').style.display='block';
			document.getElementById('parent_cat').innerHTML=xmlhttp.responseText;
			var cat_start=document.getElementById('cat_startdate').value;
			var cat_end=document.getElementById('cat_enddate').value;
			//alert(cat_start+" "+cat_end);
			//alert(xmlhttp.responseText);
			$("#startdate").datepicker("destroy");
			$("#enddate").datepicker("destroy");
			var dates = $( "#startdate, #enddate" ).datepicker({
				dateFormat:"dd-mm-yy",
				defaultDate: "+1w",
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				minDate:cat_start,
				maxDate:cat_end,
				//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg",
				//buttonImageOnly: true,
				onSelect: function( selectedDate ) {
					var option = this.id == "startdate" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(instance.settings.dateFormat ||$.datepicker._defaults.dateFormat, selectedDate, instance.settings );
					dates.not( this ).datepicker( "option", option, date );
				}
															   });				
															  
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/add_category?id="+catid,true);
	xmlhttp.send();	
	
}	

function viewanniuncement(){
	window.location=BASE_URL+"/admin/category";
        }                                 
		
  function clear_category(){
	  window.location=BASE_URL+"/admin/create_category";
	  }


