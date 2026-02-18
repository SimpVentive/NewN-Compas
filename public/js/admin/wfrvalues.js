jQuery(document).ready(function(){
	jQuery("#rolevaluesForm").validationEngine();
	$('.datepicker').datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
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

function getvalidation(){
		var rol=$('#roles').val();  
		var pid=$('#porg').val();
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
		             var data=xmlhttp.responseText;
					 if(data==1){ alertify.alert('This role values already created for this organization.');
								document.getElementById('roles').value="";
					  } else { 
					  
					   }
                   
		}
	};
	xmlhttp.open("GET",BASE_URL+"/admin/get_role_validation?rid="+rol+"&pid="+pid,true);
	xmlhttp.send();
				
     				}
					
function ReplaceAll(Source, stringToFind, stringToReplace) {
    var temp = Source;
    var index = -1;

    if (temp) {
        index = temp.indexOf(stringToFind);
        while (index != -1) {
            temp = temp.replace(stringToFind, stringToReplace);
            index = temp.indexOf(stringToFind);
        }
    }
    return temp;
}


function addfun(){
      var sd=jQuery("#rolevaluesForm").validationEngine();
	   var val=$('#rolevaluesForm').validationEngine('validate');
		  if(val==false){
			  $('#reportForm').validationEngine();
		   }
	   else {    
               var emps=document.getElementById("empvals").value
				var table = document.getElementById('roleTable');
				var rowCount = table.rows.length;
				var dd="addgroup";
				var s=document.getElementById(dd).value;
				  if(s!=''){  
					   s=s.split(","); 
					 for(var i=0;i<s.length;i++){var b=s[i];
								var num=jQuery('#number_'+b).val();
								var stdate=jQuery('#stdate'+b).val();
								var endate=jQuery('#enddate'+b).val(); 
								 startdate=stdate.split("-");
								 enddates=endate.split("-"); 
								 var st1 = new Date(startdate[2],(startdate[1]-1),startdate[0]);
								 var en1 = new Date(enddates[2],(enddates[1]-1),enddates[0]);
								// alertify.alert(s.length);
					for(var j=i;j<s.length; j++){
								if(i!=j){
							var bb=s[j];
							var num2=jQuery('#number_'+bb).val(); //alertify.alert( num2);
							var stdate2=jQuery('#stdate'+bb).val();
							var endate2=jQuery('#enddate'+bb).val(); 
							 startdate2=stdate2.split("-");
							 enddates2=endate2.split("-"); 
							 var st2 = new Date(startdate2[2],(startdate2[1]-1),startdate2[0]);
							 var en2 = new Date(enddates2[2],(enddates2[1]-1),enddates2[0]);
								
							  if( endate2==''){
								   alertify.alert("Please enter End Date"); return false;
							   }
							 //  var dsd=new Date(endate).getTime() ; alertify.alert(dsd);   var dsd1=new Date(stdate2).getTime() ; alertify.alert(dsd1);
							// alertify.alert('start date-'+st2);
							    if( en1 >= st2 ){  //alertify.alert('end date --'+en1);
								   alertify.alert("Please enter Start Date is greater than End Date of above User"); 
								  // document.getElementById('stdate'+bb).value='';
								   return false;
							   }
								/* if( stdate<=stdate2 &&  endate>=stdate2){
									alertify.alert("Same Dates not Allowed"); return false;
								}  */
								
								if( (st1>=st2 &&  en1<=st2) || ( st1>=en2 &&  en1<=en2)){
									alertify.alert("Same Dates not Allowed"); return false;
								} 
							 } 
						   }
						   
						   if( endate==''){
								   alertify.alert("Please enter End Date"); return false;
							   }
					   }
				   } 
				var temp2=0;	
				var rolecount=document.getElementById(dd).value;
				rolecount=rolecount.split(",");
				var asdf=rolecount.length-1;
				for(var k=0; k<rolecount.length; k++){	
					if(parseInt(temp2)<parseInt(rolecount[k])){
						temp2=rolecount[k];
					}
				}
			var p=parseInt(temp2)+1;
				if(document.getElementById(dd).value==""){
					rolecount=1;
					p=1;  }
			else{rolecount.push(p);}
	      document.getElementById(dd).value=rolecount;
		 var row = table.insertRow(rowCount);
		 row.id="row"+rowCount;
		 var cell1 = row.insertCell(0); 
         cell1.innerHTML="<input type='checkbox' name='chk' id='chk"+p+"' value='' />   <input type='hidden' name='users[]' id='users' value='' />";  
		 var cell2=row.insertCell(1);
         cell2.innerHTML="<select class='validate[required] col-xs-12 col-sm-9' name='number[]' id='number_"+p+"' >"+emps+"</select>";
        var cell3=row.insertCell(2);
        cell3.innerHTML="<div align='center'><div style='width:250px; float:right;' align='center'><input type='text' class='validate[required] col-xs-12 col-sm-6 datepicker' onfocus='date_funct(this.id)'   id='stdate"+p+"' name='stdate[]' /><span class='input-group-addon' style='width:50px; float:left; height: 33px;'><i class='ace-icon fa fa-calendar'></i>'</span></div> </div>";
       var cell4=row.insertCell(3);
        cell4.innerHTML="<div style='width:250px; float:right;'><input type='text' onfocus='date_funct(this.id)'  id='enddate"+p+"' class='datepicker col-xs-12 col-sm-6' name='enddate[]' /><span class='input-group-addon' style='width:50px; float:left; height: 33px;'><i class='ace-icon fa fa-calendar'></i>'</span> </div>";
		$('.datepicker').datepicker({dateFormat:'dd-mm-yy', changeYear:true, changeMonth:true});
		$("#number_"+p).ajaxChosen({
			dataType: 'json',
			type: 'POST',
			url:BASE_URL+'/admin/autoemployeenumber'
		},{
			   loadingImg: 'loading.gif'
		});

		$(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=25){w=250;}
			$('.chosen-select').next().css({'width':w});
		}).trigger('resize.chosen');
     }
  }

  
  function validations(){  
     var sd=jQuery("#rolevaluesForm").validationEngine();
	   var val=$('#rolevaluesForm').validationEngine('validate');
		  if(val==false){
			  $('#reportForm').validationEngine();
		   }
	   else {    
               var emps=document.getElementById("empvals").value
				var table = document.getElementById('roleTable');
				var rowCount = table.rows.length;
				var dd="addgroup";
				var s=document.getElementById(dd).value;
				  if(s!=''){  
					   s=s.split(","); 
					 for(var i=0;i<s.length;i++){
								var b=s[i];
								var num=jQuery('#number_'+b).val();
								var stdate=jQuery('#stdate'+b).val();
								var endate=jQuery('#enddate'+b).val(); 
								 startdate=stdate.split("-");
								 enddates=endate.split("-"); 
								 var st1 = new Date(startdate[2],(startdate[1]-1),startdate[0]);
								 var en1 = new Date(enddates[2],(enddates[1]-1),enddates[0]);
								// alertify.alert(s.length);
					for(var j=i;j<s.length; j++){
								if(i!=j){
							var bb=s[j];
							var num2=jQuery('#number_'+bb).val(); //alertify.alert( num2);
							var stdate2=jQuery('#stdate'+bb).val();
							var endate2=jQuery('#enddate'+bb).val(); 
							 startdate2=stdate2.split("-");
							 enddates2=endate2.split("-"); 
							 var st2 = new Date(startdate2[2],(startdate2[1]-1),startdate2[0]);
							 var en2 = new Date(enddates2[2],(enddates2[1]-1),enddates2[0]);
								
							  /* if( endate2==''){
								   alertify.alert("Please enter End Date"); return false;
							   } */
							 //  var dsd=new Date(endate).getTime() ; alertify.alert(dsd);   var dsd1=new Date(stdate2).getTime() ; alertify.alert(dsd1);
							// alertify.alert('start date-'+st2);
							    if( en1 >= st2 ){  //alertify.alert('end date --'+en1);
								   alertify.alert("Time period should be Unique. "); 
								  // document.getElementById('stdate'+bb).value='';
								   return false;
							   }
								/* if( stdate<=stdate2 &&  endate>=stdate2){
									alertify.alert("Same Dates not Allowed"); return false;
								}  */
								
								if( (st1>=st2 &&  en1<=st2) || ( st1>=en2 &&  en1<=en2)){
									alertify.alert("Same Dates not Allowed"); return false;
								} 
							 } 
						   }
						   
						  /*  if( endate==''){
								   alertify.alert("Please enter End Date"); return false;
							   } */
					   }
				   } 
				var temp2=0;	
				var rolecount=document.getElementById(dd).value;
				rolecount=rolecount.split(",");
				var asdf=rolecount.length-1;
				for(var k=0; k<rolecount.length; k++){	
					if(parseInt(temp2)<parseInt(rolecount[k])){
						temp2=rolecount[k];
					}
				}
			var p=parseInt(temp2)+1;
				if(document.getElementById(dd).value==""){
					rolecount=1;
					p=1;  }
			else{rolecount.push(p);}
	      document.getElementById(dd).value=rolecount;
		}
   }
  
  function deletefun(){ 
       var pid=document.getElementById('porg').value;
	   var rid=document.getElementById('roles').value;
	   var tab = document.getElementById('roleTable');  
	   var s=document.getElementById('addgroup').value;
       var s=s.split(',');
		  ll=s.length; 
         len=parseInt(ll); 
		var bs=0; 
		   for(var i=0; i<len; i++){
			   var dd='chk'+s[i]; 
			   var chkbox=$('#chk'+s[i]).is(':checked'); 
              if(true == chkbox) { 
                      bs++;
  						} 
					} 
   if(bs>0){
	 var con=window.confirm("Are you sure want to Delete the record.");
	   if(con===true){           
                for(var i=len; i>=0; i--){ 
                       var dd="chk"+s[i];
					  // alertify.alert(dd);
                       var chkbox=document.getElementById(dd);
                        if($('#chk'+s[i]).is(':checked')) { 
                                var cc=$('#chk'+s[i]).val(); 
                               // alertify.alert(cc);
                                if(cc!==""){
									$.ajax({						 //  alertify.alert(gid);
										 url: BASE_URL+"/admin/deleteterolevalue",
										 global: false,
										 type: "POST",
										 data: ({id : cc }),
										 dataType: "html",
										 async:false,
										 success: function(msg){
																			// alertify.alert(msg);
										 }
									 }).responseText;
								}
							j=i+1; 
							s.splice(i,1);
							tab.deleteRow(j);
							}
						}  
				   document.getElementById("addgroup").value=s;
				} 
            else {   return false;	}
		  }
	 else {   alertify.alert('Please select the record.');  return false; }
    }

  
  
  
 function getrolvalus(){
            var dd=document.getElementById('porg').value;
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
		             var data=xmlhttp.responseText;
		    	    var result =data.split('####');
					var role=$.trim(result[0]);
					var emps=$.trim(result[1]);
			  document.getElementById("roles").innerHTML=role;
			  //document.getElementById("number_1").innerHTML="";//emps;
			  document.getElementById("empvals").value=emps;
                      /*   jQuery(document).ready(function(){
                                jQuery("#rolevaluesForm").validationEngine();
                        }); */
		}
	};
	xmlhttp.open("GET",BASE_URL+"/admin/get_role_values_data?id="+dd,true);
	xmlhttp.send();    
 }
$("#number_1").ajaxChosen({
	   dataType: 'json',
	   type: 'POST',
	   url:BASE_URL+'/admin/autoemployeenumber'
},{
	   loadingImg: 'loading.gif'
});

$(window).on('resize.chosen', function() {
	var w = $('.chosen-select').parent().width();
	if(w<=25){w=250;}
	$('.chosen-select').next().css({'width':w});
}).trigger('resize.chosen');