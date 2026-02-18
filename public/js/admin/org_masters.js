jQuery(document).ready(function(){
    $('#org_master').validationEngine();
	$('.datepicker').datepicker();
});

/* $(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#stdatediv, #enddatediv" ).datepicker({dateFormat:"yy-mm-dd",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	minDate:"",
	maxDate:difDays,
	//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
	//buttonImageOnly: true,
	onSelect: function( selectedDate ) { 
	var option = this.id === "stdatediv" ? "minDate" : "maxDate",
	instance = $( this ).data( "datepicker" ),
	date = $.datepicker.parseDate(
	instance.settings.dateFormat ||
	$.datepicker._defaults.dateFormat,
	selectedDate, instance.settings );
	dates.not( this ).datepicker( "option", option, date );
	}
	});				   
}); */

 function show_fields(){
	var org_type=document.getElementById('org_type').value;
	if(orgtype=='PO'){
		if(org_type!='PO'){
			alertify.alert("You can not change Parent Organization to child");
			document.getElementById('org_type').value=orgtype;
			return false;
		}
	}
	else{
	    if(org_type=='PO'){
		   $("#urldiv").show();
		   $("#dividiv").hide();
		}
		else if(org_type=='BU'){
			$("#dividiv").show();
			$("#urldiv").hide();	
		}
		else {
		    $("#urldiv").hide();	
			$("#dividiv").hide();
		}
	}
 }

function move_back(link){
    window.location=BASE_URL+'/admin/'+link;
}

function Create_new(link){
    window.location=BASE_URL+'/admin/'+link;
}

function Update_org(link,id,hash){
    window.location=BASE_URL+'/admin/'+link+'?orgid='+id+'&hash='+hash;
}

$('#org_manager').ajaxChosen({
	   dataType: 'json',
	   type: 'POST',
	   url:BASE_URL+'/admin/autoemployee'
},{
	   loadingImg: 'loading.gif'
});
