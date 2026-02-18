jQuery(document).ready(function(){
	jQuery("#usercreationform").validationEngine({prettySelect : true,
    useSuffix: "_chosen"});	
	$('#datepicker').datepicker();
});

function diffdate(){
     var startdate=document.getElementById("start_date").value;
     var enddates=document.getElementById("end_date").value;
     if(startdate!=="" && enddates!==""){
         startdate=startdate.split("-");
         enddates=enddates.split("-");
         var date1 = new Date(startdate[2],(startdate[1]-1),startdate[0]);
         var date2 = new Date(enddates[2],(enddates[1]-1),enddates[0]);
         var timeDiff = Math.abs(date2.getTime() - date1.getTime());
         var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
         document.getElementById("password_validity_days").value=diffDays;
     }
     else{
         document.getElementById("password_validity_days").value="";
     }

    //alertify.alert("diffDays")​;
}
function getenddate(){
    var startdate=document.getElementById("start_date").value;
    var days=document.getElementById("password_validity_days").value;
    if(startdate!=="" && days!=""){
        startdate=startdate.split("-");
        var currentDate = new Date(startdate[2],startdate[1]-1,startdate[0]);
        currentDate.setTime(currentDate.getTime() + days*86400000);
        document.getElementById("end_date").value=currentDate.getDate()+"-"+(currentDate.getMonth()+1)+"-"+currentDate.getFullYear();
    }
}

$(function() {
         var date1 = new Date();
         var date2 = new Date(2039,0,19);
         var timeDiff = Math.abs(date2.getTime() - date1.getTime());
         var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

    var dates = $( "#start_date, #end_date" ).datepicker({
        dateFormat:"dd-mm-yy",
        /*defaultDate: "+1w",*/
        changeMonth: true,
		changeYear: true,
        numberOfMonths: 1,
        /*minDate:0,
        maxDate:difDays,*/
        //showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
        //buttonImageOnly: true,
        onSelect: function( selectedDate ) { 
            var option = this.id == "start_date" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate( instance.settings.dateFormat ||$.datepicker._defaults.dateFormat,selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
			diffdate();
			getenddate();
        }
    });
});
$(document).ready(function(){
	$('#thetable').tableScroll({height:150});
	if($("#end_date").val()!=""){
		$( "#start_date" ).datepicker("option", "maxDate", $("#end_date").val());
	}
	if($("#start_date").val()!=""){
		$( "#end_date" ).datepicker("option", "minDate", $("#start_date").val());
	}
	
});

function canceluser(){
    window.location=BASE_URL+"/admin/user_creation";			
}

function empid(){
    var id=document.getElementById("employee_id").value;
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
            document.getElementById("table_menu1").innerHTML=xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET",BASE_URL+"/admin/empmail?id="+id,true);
    xmlhttp.send();
}

function exclusion(type,key){
	var id=type;
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
			document.getElementById("msg"+id).style.display='block';
			document.getElementById("msg"+id).innerHTML=xmlhttp.responseText;
		}
	};
	xmlhttp.open("GET",BASE_URL+"/admin/execlusion?id="+id+"&key="+key,true);
	xmlhttp.send();
}

    function cancelmenu(id){
        document.getElementById("msg"+id).style.display='none';
    }

    function viewexclusive(id){
        if(document.getElementById('chk_['+id+']').checked==true){
            document.getElementById('checks'+id).style.display='block';
        }
        else if(document.getElementById('chk_['+id+']').checked==false){
            document.getElementById('checks'+id).style.display='none';
        }
    }

    function alert_msg(){
        $(document).ready(function(){
            var lclose = $("<a class='lightbox_close_rel'>Close This</a>");
            $('#msg_box').append(lclose);
            var myval = "msg_box";
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
            $("#" + myval).animate({  opacity: 1, top: "167px"}, 10);
        });
        $('a.lightbox_close_rel').click(function(){
            var myval2 =$(this).parent().attr('id');
            $("#" + myval2).animate({opacity: 0,top: "-1200px"},0, function(){
                $('.lightbox_bg').hide()
            });
        });
    }

    function role_creationid(id){
        var role_id=document.getElementById('role_id'+id).value;
		if(document.getElementById('rollid_'+id).checked){
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
					$('#startdate_'+id).removeAttr('disabled');
					$('#enddate_'+id).removeAttr('disabled');
					$('#menuids_'+id).removeAttr('disabled');
					$('#exclusion'+id).removeAttr('disabled');
					$('#description'+id).removeAttr('disabled');
					$('#role_id'+id).removeAttr('disabled');
					$('#exclusion'+id).addClass('bigbutton');
					$('#user_role_id'+id).removeAttr('disabled');
					document.getElementById('menu_execlusions'+id).style.display='block';
					document.getElementById('menu_execlusions'+id).innerHTML=xmlhttp.responseText;
					$('#datepicker_start'+id).datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
					$('#datepicker_end'+id).datepicker({
	format: 'dd-mm-yyyy',
	orientation: "top",
	autoclose: true,
	todayHighlight: true});
				}
			}
			xmlhttp.open("GET",BASE_URL+"/admin/menu_execlusion?id="+id+"&role_id="+role_id,true);
			xmlhttp.send();
		}
		else{
			$('#msg'+role_id).css('display','none');
			$('#exclusion'+id).removeClass('bigbutton');
			$('#startdate_'+id).attr('disabled','disabled');
			$('#enddate_'+id).attr('disabled','disabled');
			$('#menuids_'+id).val('');
			$('#user_role_id'+id).attr('disabled','disabled');
			$('#menuids_'+id).attr('disabled','disabled');
			$('#exclusion'+id).attr('disabled','disabled');
			$('#description'+id).attr('disabled','disabled');
			$('#role_id'+id).attr('disabled','disabled');
		}
    }

$('#employee_id').ajaxChosen({
	   dataType: 'json',
	   type: 'POST',
	   url:BASE_URL+'/admin/autoemployee'
},{
	   loadingImg: 'loading.gif'
});

    /*function dateformats(){
        var stdate=document.getElementById('startdates').value;
        var enddate=document.getElementById('enddates').value;
        var doj=document.getElementById('doj').value; 
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
                return false;
            }
        }
        var pdate = stdate.split('-');
        var dd = parseInt(pdate[0]);
        var mm  = parseInt(pdate[1]);
        var yy = parseInt(pdate[2]);
        var dojdate = doj.split('-');
        var dd1 = parseInt(dojdate[0]);
        var mm1  = parseInt(dojdate[1]);
        var yy1 = parseInt(dojdate[2]);
        if(dd1>dd || mm1>mm || yy1>yy){
            alertify.alert("Start Date should be Lessthan Employee Joining Date");
            return false;
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
                if (mm===2){
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
                return false;
            }
        }
        var dt2= stdate;
        var arrDt2 = dt2.split('/');
        var date2=new date(arrDt2[2] + "/" + arrDt2[1] + "/" + arrDt2[0]);
        var dt= enddate;
        var arrDt = dt.split('/');
        var date1=new date(arrDt[2] + "/" + arrDt[1] + "/" + arrDt[0]);
        if(stdate!='' && enddate!=''){           
            if (date2>date1){
                alertify.alert("End date should be greater than start date");
                return false;
            }
        }
    }*/