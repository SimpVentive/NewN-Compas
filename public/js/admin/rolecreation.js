jQuery(document).ready(function(){
	jQuery("#roleform").validationEngine();	
});
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#start_date, #end_date" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	//minDate:0,
	maxDate:difDays,
	//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
	//buttonImageOnly: true,
	onSelect: function( selectedDate ) { 
	var option = this.id === "start_date" ? "minDate" : "maxDate",
	instance = $( this ).data( "datepicker" ),
	date = $.datepicker.parseDate(
	instance.settings.dateFormat ||
	$.datepicker._defaults.dateFormat,
	selectedDate, instance.settings );
	dates.not( this ).datepicker( "option", option, date );
	}
	});				   
});

function orgtype(){
	var org_id=document.getElementById("parent_org_id").value;
	//alertify.alert(org_id);
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState===4 && xmlhttp.status===200){
			//alertify.alert(xmlhttp.responseText);
			var data = xmlhttp.responseText;
			var result =data.split('#$%UNITOL#$%');
			var hierarchy=$.trim(result[0]);
			var report=$.trim(result[1]);
			var orgdata=$.trim(result[2]);
			// alertify.alert(hierarchy); //alertify.alert(report);
			//document.getElementById("statediv").style.display='block';
			//document.getElementById("org_hoerarchy").innerHTML=hierarchy;
			document.getElementById('report_group').innerHTML=report;
			//document.getElementById('security_organization').innerHTML=orgdata;			
			//alertify.alert(xmlhttp.responseText)
		}
	};
	xmlhttp.open("GET",BASE_URL+"/admin/lms_hierarchy?id="+org_id,true);
	xmlhttp.send();
}

/*$(function() {
         var date1 = new Date();
         var date2 = new Date(2039,0,19);
         var timeDiff = Math.abs(date2.getTime() - date1.getTime());
         var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
		 
		var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		minDate:0,
		maxDate:difDays,
		showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		buttonImageOnly: true,
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


$(document).ready(function(){
	var aa=$('#role').validate({
		rules:{
			role_name:{
				required:true,
				checkrolename:"#role_id"
			},
			role_code:{
                            required:true,
                            checkrolecode:"#role_id"                                
			},
			menu_name:{
				required:true
			},
			orga:{
				required:true
			},
			startdate:{
				required:true
			}
		},
		showErrors: function (errorMap, errorList) {

        // summary of number of errors on form
        //var msg = "Your form contains " + this.numberOfInvalids() + " errors, see details below.<br/>"
         var msg = "* Indicate Are Mandatory Fields.<br/>";
        // loop through the errorMap to display the name of the field and the error
        $.each(errorMap, function(key, value) {
            if(value!=="This field is required."){
                msg += value + "<br/>";
            }
        });

        // place error text inside box
        $("div.error").html(msg);

        // also show default labels from errorPlacement callback
        this.defaultShowErrors(); 

        // toggle the error summary box
        if (this.numberOfInvalids() > 0) {
            $("div.error").show();
        } else {
            $("div.error").hide();
        }

    } 
	});	
	$("#submit_r").click(function() {
		$("label .error").remove();
	});
						   });


	
    function dateformat(){
        var stdate=document.getElementById('startdate').value;
        var enddate=document.getElementById('enddate').value;
        var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
        if(stdate!==''){
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
                if (mm===1 || mm>2){
                    if (dd>ListofDays[mm-1]){
                        alertify.alert('Invalid date format!');
                        return false;
                    }
                }
                if (mm===2){
                    var lyear = false;
                    if ( (!(yy % 4) && yy % 100) || !(yy % 400)){
                        lyear = true;
                    }
                    if ((lyear===false) && (dd>=29)){
                        alertify.alert('Invalid date format!');
                        return false;
                    }
                    if ((lyear===true) && (dd>29)){
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
        
        if(enddate!==''){
            // Match the date format through regular expression
            if(enddate.match(dateformat)){
                //document.form1.text1.focus();
                //Test which seperator is used '/' or '-'
                var opera1 = enddate.split('/');
                var opera2 = enddate.split('-');
                lopera1 = opera1.length;
                lopera2 = opera2.length;
                // Extract the string into month, date and year
                if (lopera1>1){
                    var pdate = enddate.split('/');
                }
                else if (lopera2>1){
                    var pdate = enddate.split('-');
                }
                var dd = parseInt(pdate[0]);
                var mm  = parseInt(pdate[1]);
                var yy = parseInt(pdate[2]);
                // Create list of days of a month [assume there is no leap year by default]
                var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
                if (mm===1 || mm>2){
                    if (dd>ListofDays[mm-1]){
                        alertify.alert('Invalid date format!');
                        return false;
                    }
                }
                if (mm===2){
                    var lyear = false;
                    if ( (!(yy % 4) && yy % 100) || !(yy % 400)){
                        lyear = true;
                    }
                    if ((lyear===false) && (dd>=29)){
                        alertify.alert('Invalid date format!');
                        return false;
                    }
                    if ((lyear===true) && (dd>29)){
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
        var dt2= stdate;
        var arrDt2 = dt2.split('-');
        var date2=arrDt2[2] + "/" + arrDt2[1] + "/" + arrDt2[0];
        var dt= enddate;
        var arrDt = dt.split('-');
        var date1=arrDt[2] + "/" + arrDt[1] + "/" + arrDt[0];
        if(stdate!=='' && enddate!==''){
            if (date2>date1){
                alertify.alert("End date should be greater than start date");
                return false;
            }
        }
    }
*/