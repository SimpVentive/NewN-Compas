jQuery(document).ready(function(){
	jQuery("#announcements_creation").validationEngine();
	jQuery("#bulletin_validation").validationEngine();
	/* $('.chosen-toggle').each(function(index) {
		$(this).on('click', function(){
			 $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
		});
	}); */

	
});

$(document).ready(function(){
		   var dates = $( "#open_date, #close_date" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		/*minDate:" date('d-m-Y');",
		maxDate:"<?php //echo $futureDate;?>",*/
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "open_date" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
											}
									});

});

function publishtype(){
	if(document.getElementById('public_s').checked==true){
		document.getElementById('publish').style.display='block';
		document.getElementById('location_select').style.width=(400) + "px";
		$('.chosen-select').chosen().trigger('chosen:updated');
		$('.chosen-container').css('width','400px');
	}
	else if(document.getElementById('public_p').checked==true){
		document.getElementById('publish').style.display='none';
	}
	else{
		document.getElementById('publish').style.display='none';
	}
}
        
function publishtype_create(){
    if(document.getElementById('public').checked==true){
                document.getElementById('add_secorg').style.display='none';	
                document.getElementById('add_organization').style.display='none';
                document.getElementById('add_organization_hierarchy').style.display='none';
                document.getElementById('org_info').innerHTML="";
                document.getElementById('inner_head').style.display='none';     
		}else if(document.getElementById('secure').checked==true){
                        document.getElementById('add_secorg').style.display='block';
                        document.getElementById('org_info').style.display='block';
                        document.getElementById('org_info').innerHTML="<table class='table table-striped table-bordered table-hover'><thead><tr><th>Organization Name</th><thcclass='hidden-480'>Learner Group</th><th ></th></tr></thead><tbody><tr><td>No data found.</td></tr></tbody></table>";
			}
    
}
function viewanniuncement(){
	window.location=BASE_URL+"/admin/announcements";
        }
 function dateformat(){
		var stdate=document.getElementById('open_date').value;
		var enddate=document.getElementById('close_date').value;
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
				if(yy<1900){
					alertify.alert("Invalid date format!");
                    return false;
					}
                }
				
			 if(enddate!=''){
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
				if(yy<1900){
					alertify.alert("Invalid date format!");
                    return false;
					}
                }
				var dt2= stdate;
			var arrDt2 = dt2.split('-')
			var date2=arrDt2[2] + "-" + arrDt2[1] + "-" + arrDt2[0];
			
			var dt= enddate;
			var arrDt = dt.split('-')
			var date1=arrDt[2] + "-" + arrDt[1] + "-" + arrDt[0];
			if(stdate!='' && enddate!=''){
				if (date2>date1){
					alertify.alert("End date should be greater than start date");
					return false;
				}
			}
	}


function open_quiz(){
	if(document.getElementById('test_yes').checked==true){
		document.getElementById('quiz').style.display='block';
	}
	else if(document.getElementById('test_no').checked==true){
		document.getElementById('quiz').style.display='none';
	}
	
}

function open_price(){
	if(document.getElementById('price_avail_yes').checked==true){
		document.getElementById('price').style.display='block';
	}
	else if(document.getElementById('price_avail_no').checked==true){
		document.getElementById('price').style.display='none';
	}
	
}

function checkzones(){
	var id=document.getElementById('location_zones').value;
	var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//document.getElementById('workinfodetails').innerHTML="loading..."
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('location_select').innerHTML=xmlhttp.responseText;
			$("#location_select").chosen().trigger('chosen:updated');
		}
	}
	
	xmlhttp.open("GET",BASE_URL+"/admin/mandatorylocation?id="+id,true);
	xmlhttp.send();
}


