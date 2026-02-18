jQuery(document).ready(function(){
	jQuery("#locationform").validationEngine();	
});

$(document).ready(function(){
	var dates = $( "#start_date_active, #end_date_active" ).datepicker({
		dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "start_date_active" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});

function open_zones(){    
     var zone_id=document.getElementById('location_zones').value;
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
             $('#zonestate').html(xmlhttp.responseText);
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/zone_states?zone_id="+zone_id,true);
     xmlhttp.send();
}

function open_zones_add(){    
     var zone_id=document.getElementById('location_zones').value;
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
             $('#zonestateadd').html(xmlhttp.responseText);
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/zone_states?zone_id="+zone_id,true);
     xmlhttp.send();
}
function AddMore_expenses_chk_vald(){
	var tbl = document.getElementById("fleupload_tab_expense_id");
	var lastRow = tbl.rows.length;
	var lastrow1= lastRow+1;
	var hiddtab="inner_hidden_id_expenses";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
	   var ins1=ins.split(",");
	   var temp=0;
	   if(ins1.length>1){
	   for( var j=0;j<ins1.length;j++){
		   if(ins1[j]>temp){
			   temp=ins1[j];
		   }
	   }
	   //var maxa=Math.max(ins1);
	   sub_iteration=parseInt(temp)+1;
	   for( var j=0;j<ins1.length;j++){
		   var i=ins1[j];
		   var exp_type=document.getElementById('role_type['+i+']').value;
		   var amount=document.getElementById('employee_number_'+i).value;
		   
			if(exp_type==''){
			   toastr.error("Please select Role type");
			   return false;
			}
			if(amount==''){
			   toastr.error("Please Enter Employee Number");
			   return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('employee_number_'+l).value;
					var item_resource2=document.getElementById('role_employee_number_'+l).value;
					if(k!=j){
						if(k!=j){
						   if(amount==item_type2 || amount==item_resource2){
								toastr.error("Same employee has been added to the role");
								return false;
						   }
                       }
					}
				}
			}
		}
	   }
	}
	else{
	   sub_iteration=1;
	   ins1=1;
	   var ins1=Array(1);
	}
}
