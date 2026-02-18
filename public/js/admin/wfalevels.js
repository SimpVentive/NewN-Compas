jQuery(document).ready(function(){
	jQuery("#wfaForm").validationEngine();
	$('.datepicker').datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
});

$(document).ready(function(){
	var dates = $( "#start_date_active, #end_date_active" ).datepicker({
		dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "start_date_active" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});


function getgroups(){
    var pid=document.getElementById('porg').value;
	var rid=document.getElementById('rule_id').value;
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
        if (xmlhttp.readyState===4 && xmlhttp.status===200){
            document.getElementById("groupsdiv").innerHTML=xmlhttp.responseText;
            document.getElementById("groupsdiv").style.display="block";
			$('.datepicker').datepicker({dateFormat:'dd-mm-yy', changeYear: true, changeMonth: true});
            $(".rowUp").click(function () {
                    var row = $(this).closest("tr");
                    // Get the previous element in the DOM
                    var previous = row.prev();
                    // Check to see if it is a row
                    if (previous.is("tr")) {
                        // Move row above previous
                        row.detach();
                        previous.before(row);
                        // draw the user's attention to it
                        row.fadeOut();
                        row.fadeIn();
                    }
                    // else - already at the top
                });
            // Setup the "Up" links
            $(".rowDown").click(function () {
                var row = $(this).closest("tr");
                // Get the previous element in the DOM
                var next = row.next();
                // Check to see if it is a row
                if (next.is("tr")) {
                    // Move row above previous
                    row.detach();
                    next.after(row);
                    // draw the user's attention to it
                    row.fadeOut();
                    row.fadeIn();
                }
                // else - already at the bottom
            });
            
        }
    };
    xmlhttp.open("GET",BASE_URL+"/admin/getallgroupsdata?id="+pid+"&rid="+rid,true);
    xmlhttp.send();
}

function getrulelist(){
    var pid=document.getElementById('process_id').value;
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
        if (xmlhttp.readyState===4 && xmlhttp.status===200){
            document.getElementById("rulediv").innerHTML=xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET",BASE_URL+"/admin/getallruledata?id="+pid,true);
    xmlhttp.send();
}

 function getvalidate(){
 
   var app=document.getElementById('noapprovals').value;
   if(app==1){ alertify.alert('Please Create Approval Groups.'); return false; }
   if(app==1){ alertify.alert('Please Create Approval Groups.'); return false; }
       
    var val=$('#wfaForm').validationEngine('validate');
      if(val==false){
          $('#wfaForm').validationEngine();
      }
      else{ 
          var len=document.getElementById("tab2").rows.length;
		 // alertify.alert('number of rows-'+numrows);  return false;
        // var len = $("input[type='checkbox']:checked").length;
		 // alertify.alert(len); return false;
       //  if(len==0){ alertify.alert('Please check Levels '); return false; }
            var sds=0;
			
            for(var i=1;i<=Number(len); i++){ //alertify.alert('hello'); alertify.alert(len);  alertify.alert('bala'); return false;
                 if(document.getElementById('chkbox'+i).checked==true){ sds=sds+1; 
                    if(document.getElementById('level'+i).value==''){
                        alertify.alert('Please enter Level Name');
                        return false;
                    }
                     if(document.getElementById('stdate'+i).value==''){
                        alertify.alert('Please enter Level start date');
                        return false;
                    }
//                     if(document.getElementById('enddate'+i).value==''){
//                        alertify.alert('Please enter Level Name');
//                        return false;
//                    }
                 }
            }
			
			if(sds==0){ alertify.alert('Please select Levels');return false;}
        }
       }