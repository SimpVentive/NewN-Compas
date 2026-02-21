jQuery(document).ready(function(){
	jQuery("#competencyForm").validationEngine();
});

$(document).ready(function(){
    var dates = $( "#start_date, #end_date" ).datepicker({
        dateFormat:"dd-mm-yy",
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        //showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
       // buttonImageOnly: true,
        onSelect: function( selectedDate ) { 
            var option = this.id == "start_date" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(
            instance.settings.dateFormat ||
            $.datepicker._defaults.dateFormat,
            selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });
});

jQuery(document).ready(function(){
		$('#startdate, #enddate').datepicker('destroy');
		var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate:"+1w" , //dd,
		changeMonth: true,
                 changeYear: true,
		numberOfMonths: 1,
		//minDate:'+0',
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
		//document.getElementById("startdate").value="";
		//document.getElementById("enddate").value="";
	});



function back_edit(){
    window.location=BASE_URL+"/admin/competency_search";
}

function addcompetency(){
    var table = document.getElementById('competencyTab');
    var rowCount = table.rows.length;
        var dd="addgroup";
	var s=document.getElementById(dd).value;
          //alertify.alert(s);
	 if(s!=''){  
	  s=s.split(",");
	  // alertify.alert(s.length);
     for(var i=0;i<s.length;i++){var b=s[i];
         if(s.length==5){ alertify.alert("The maximum levels of competency is 5 Only."); return false;}
                var code=document.getElementById('level_value_'+b).value;
                var name=document.getElementById('level_name_'+b).value;
                var des=document.getElementById('behavioural_indicator_'+b).value;
                var regex= /^[0-9]+$/;  
                 if(code==''){
                    alertify.alert("Please enter Level code.");
                    return false;
                  }
                  if(!code.match(/^\d+/))
                    {
                    alertify.alert("Numbers Only allowed for Level code");
                    document.getElementById('level_value_'+b).value='';
                    document.getElementById('level_value_'+b).focus();
                    return false;
                    }
                  if(name==''){
                      alertify.alert("Please enter Level Name.");
                      return false;
                  }
                   if( /[^-/,a-zA-Z0-9 ]/.test( name ) ) {
                        alertify.alert('Level Name is allowed alphanumaric and -,/ Only.');
                          document.getElementById('level_name_'+b).value='';
                        document.getElementById('level_name_'+b).focus();
                        return false;
                     }
//                if(des==''){
//                    alertify.alert("Please enter Description of the Level");
//                    return false;
//                }
                
                for(var j=0;j<s.length;j++){var bb=s[j];
                    if(j!=i){
                            var code1=document.getElementById('level_value_'+bb).value;
                            var name1=document.getElementById('level_name_'+bb).value;
                            var des1=document.getElementById('behavioural_indicator_'+bb).value;
                        if(code==code1){
                            alertify.alert("Level Value should be Unique.");
                             document.getElementById('level_value_'+bb).value='';
                             document.getElementById('level_value_'+bb).focus();
                            return false;

                           }
                         if(name==name1)
                           { alertify.alert("Level Name should be Unique.");
                             document.getElementById('level_name_'+bb).value;
                             document.getElementById('level_name_'+bb).focus();
                               return false;}
                    }
            }
        }
      }
      
       var temp2=0;	
	var employeecount=document.getElementById(dd).value;
	employeecount=employeecount.split(",");
	var asdf=employeecount.length-1;
	for(var k=0; k<employeecount.length; k++){	
		if(parseInt(temp2)<parseInt(employeecount[k])){
			temp2=employeecount[k];
		}
	}
	var p=parseInt(temp2)+1;
	if(document.getElementById(dd).value==""){
		employeecount=1;
		p=1;
	}
	else{employeecount.push(p);}
	 document.getElementById(dd).value=employeecount;
	// var rowcou=parseInt(iteration)+1;
	var row = table.insertRow(rowCount);
                
           var cell1 = row.insertCell(0);  
           cell1.style.valign="middle";
           //cell1.style.textAlign="center";			  
          cell1.innerHTML="<div style='padding-left:18px;'><input  type='checkbox' name='chkbox[]' id='chkbox_"+p+"'  value='' /></div>";     
                
       var cell2 = row.insertCell(1);
        cell2.style.valign="middle";
        //cell2.style.textAlign="center";		
      cell2.innerHTML="<input type='text' class='smalltext' name='level_value[]' id='level_value_"+p+"' maxlength='20'  value='' style='width:85%;' />";  
       
       var cell3=row.insertCell(2);
	     cell3.style.valign="middle";
         //cell3.style.textAlign="center";		
        cell3.innerHTML="<input type='text' class='mediumtext' name='level_name[]' id='level_name_"+p+"' maxlength='20'  value='' style='width:85%;' />";
            
	  var cell4=row.insertCell(3);
	    cell4.style.valign="middle";
        //cell4.style.textAlign="center";		
        cell4.innerHTML="<textarea style='resize:none; width: 90%;' id='behavioural_indicator_"+p+"' maxlength='200' class='largetexta' name='behavioural_indicator[]'></textarea>";
   }

function deletecompetency(){
	var table = document.getElementById('competencyTab');
	var s=document.getElementById("addgroup").value;
        var comid=document.getElementById('comp_id').value;
	var spli=s.split(",");
	var flag=0; //alertify.alert(spli);
		var len=spli.length;
               // alertify.alert(len);
      for(var m=len;m >0; m--){
                      var kk=m-1;
                     //  alertify.alert(m);
                         var fd=spli[kk];
                        //  alertify.alert(fd);
                        var ddd="chkbox_"+fd;
                        // alertify.alert(ddd);
			if(document.getElementById(ddd).checked==true){
			flag++;
			}
		   }
	if(flag>0){
                        // alertify.alert(len);
			var jinit=parseInt(len);
                        // alertify.alert(jinit);
			for(var j=jinit; j>0; j--){
				var k=j-1;
				var dd="chkbox_"+spli[k];
				   //alertify.alert(dd);
			if(document.getElementById(dd).checked==true){ // alertify.alert(j);
                            
                             
                              var cc=document.getElementById(dd).value; 
                               // alertify.alert(cc);
                           if(cc!==""){
                                $.ajax({      //  alertify.alert(gid);
                                     url: BASE_URL+"/admin/deletetecompetencylevels",
                                     global: false,
                                     type: "POST",
                                     data: ({id : cc ,cid:comid }),
                                     dataType: "html",
                                     async:false,
                                     success: function(msg){         // alertify.alert(msg);
                                     }
                                 }).responseText;
                             
                              }
                            
				var hh=j-1;
               spli.splice(hh,1);
				table.deleteRow(j);
				len=spli.length;
				// alertify.alert(len);
				// break;
			   }
			 }
		  }
		else if(flag==0){
			alertify.alert("Please select the record");
				return false;
			
		}
              //  alertify.alert(spli);
		   document.getElementById("addgroup").value=spli;
	}
        
        
 function validation(){
    //alertify.alert("haiiii");
  var table = document.getElementById('competencyTab');
   var rowCount = table.rows.length;
        var dd="addgroup";
	var s=document.getElementById(dd).value;
          //alertify.alert(s);
	 if(s!=''){  
	     s=s.split(",");
	  // alertify.alert(s.length);
     for(var i=0;i<s.length;i++){var b=s[i];
       //  if(s.length==5){ alertify.alert("The maximum levels of competency is 5 Only."); return false;}
                var code=document.getElementById('level_value_'+b).value;
                var name=document.getElementById('level_name_'+b).value;
				//alertify.alert(name);
                var des=document.getElementById('behavioural_indicator_'+b).value;
                 if(code==''){
                    alertify.alert("Please enter Level code.");
                    return false;
                  }
                  if(!code.match(/^\d+/))
                    {
                    alertify.alert("Numbers Only allowed for Level code");
                     document.getElementById('level_value_'+b).value='';
                    document.getElementById('level_value_'+b).focus();
                    return false;
                    }
                  if(name==''){
                      alertify.alert("Please enter Level Name.");
                      return false;
                  }
                   if( /[^-/,a-zA-Z0-9 ]/.test( name ) ) {
                        alertify.alert('Level Name is allowed alphanumaric and -,/ Only.');
                          document.getElementById('level_name_'+b).value='';
                        document.getElementById('level_name_'+b).focus();
                        return false;
                     }
//                if(des==''){
//                    alertify.alert("Please enter Description of the Level");
//                    return false;
//                }
                
                for(var j=0;j<s.length;j++){var bb=s[j];
                    if(j!=i){
                            var code1=document.getElementById('level_value_'+bb).value;
                            var name1=document.getElementById('level_name_'+bb).value;
                            var des1=document.getElementById('behavioural_indicator_'+bb).value;
                        if(code==code1){
                            alertify.alert("Level Value should be Unique.");
                            return false;

                           }
                         if(name==name1){ alertify.alert("Level Name should be Unique."); return false;}
                    }
            }
        }
      }
   }
   