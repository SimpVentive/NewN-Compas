jQuery(document).ready(function(){
	jQuery("#testForm").validationEngine();
        
});

/* function getattempsdiv(){
    
     if($('#resum').attr('checked')) {
             $("#attemptsdiv").show();
         } 
         else {
             $("#attemptsdiv").hide();
           }
    
}
 */

     function jm_phonemask(t){
			var patt1 = /(\d{3}).*(\d{3}).*(\d{4})/;
			var patt2 = /^\((\d{3})\).(\d{3})-(\d{4})$/;
			var str = t.value;
			var result;
			if (!str.match(patt2)){
			    result = str.match(patt1);
					if (result!= null){
					//alertify.alert(result);
					//t.value = t.value.replace(/[^\d]/gi,'');
					//str = '(' + result[1] + ') ' + result[2] + '-' + result[3];
					//t.value = str;
					}
			else{
				if (t.value.match(/[^\d]/gi))
				t.value = t.value.replace(/[^\d]/gi,'');
				}
			}
	}
   
    function getresumedetails(){
		var  testype=document.getElementById('testtype').value;
        //alertify.alert(testype); 
        if(testype=='T' || testype=='E_LEARNING' || testype=='COMP_TEST' || testype=='COMP_INTERVIEW' || testype=='COMP_CASESTUDY' || testype=='COMP_INBASKET'){
         document.getElementById('scoring').disabled="";
         document.getElementById('totalscore').disabled="";
         document.getElementById('perpage').disabled=""
         document.getElementById('sectionorder').disabled="";
        // document.getElementById('resumediv').style.display="none";
         document.getElementById('durationdiv').style.display="block";
		 document.getElementById('ratingscale').style.display='none';
         
       }else if(testype=='PROG_EVAL'){
			document.getElementById('ratingscale').style.display='block';
			document.getElementById('scoring').disabled="disabled";  
			document.getElementById('totalscore').disabled="disabled";
			document.getElementById('perpage').disabled="disabled"
			document.getElementById('sectionorder').disabled="disabled";
			// document.getElementById('resumediv').style.display="block";
			document.getElementById('durationdiv').style.display="none";
		}
		else if(testype=='S'){
			document.getElementById('scoring').disabled="disabled";  
			document.getElementById('totalscore').disabled="disabled";
			document.getElementById('perpage').disabled="disabled"
			document.getElementById('sectionorder').disabled="disabled";
			// document.getElementById('resumediv').style.display="block";
			document.getElementById('durationdiv').style.display="none";
			document.getElementById('ratingscale').style.display='none';
		}
		else {
           document.getElementById('scoring').disabled="disabled";  
           document.getElementById('totalscore').disabled="disabled";
           document.getElementById('perpage').disabled="disabled"
           document.getElementById('sectionorder').disabled="disabled";
			// document.getElementById('resumediv').style.display="block";
			document.getElementById('durationdiv').style.display="none";
			document.getElementById('ratingscale').style.display='none';
           
		}
    }
    
    
    
//    function getscore(){  
//      var scr=document.getElementById('scoring').value;
//      if(scr=='N'){
//       document.getElementById('totalscore').disabled='disabled';    
//      }
//      else {
//         document.getElementById('totalscore').disabled='';    
//      }
//      }
  function validation(){
        
            var testtyp=document.getElementById('testtype').value;
            var scor=document.getElementById('scoring').value; 
          //   var timealert=document.getElementById('ralert').value; 
        //    var ress=document.getElementById('resum');
//           var duration=document.getElementById('timeinm').value;
//         
//            if(tname==''){                
//                alertify.alert("Please Enter Test Name.");
//                return false;
//            }
//            
//           if(stdate==''){
//                alertify.alert("Please Enter Start Date");
//                return false;
//            }
//            if(pub==''){
//                alertify.alert("Please select Published status.");
//                return false;
//            }
//             if(testtyp==''){
//                alertify.alert("Please select Assessment Type.");
//                return false;
//            }
//            if(perpage==''){
//               alertify.alert("Please Enter Total Questions for the Test.");
//                
//                return false;  
//            }
//             if(scor==''){
//                alertify.alert("Please select Scoring Opton.");
//                return false;
//            }
            
      /*   if(ress.checked==true){
                var maxetp=document.getElementById('maxattempts').value;
               //  var timemaxetp=document.getElementById('durationattem').value;
               //alertify.alert(maxetp);
             if(maxetp==''){
                    alertify.alert("Please enter Maximum Number of Attempts. ");
                     return false;
                }
//                 if(timemaxetp==''){
//                    alertify.alert("Please enter Time between of Attempts. ");
//                     return false;
//               } 
           } */
//           if(duration==''){
//               alertify.alert("Plese enter time allowed in minutes");
//               return false;               
//            }
//        if(timealert==''){
//         alertify.alert("Please select Time Remaining Alert.");
//         return false;
//           } 
	
    }
/*     $(document).ready(function(){
		$('#startdate, #enddate').datepicker('destroy');
		var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate:"+1w" , //dd,
		changeMonth: true,
		numberOfMonths: 1,
		//minDate:'+0',
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "startdate" ? "minDate" : "maxDate",
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
	}); */
	
	
	 $(document).ready(function(){
	var dates = $( "#startdate, #enddate" ).datepicker({
		dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "startdate" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});
  
        
        function getpassscore(){
            var ss=document.getElementById('scoring').value;
     if(ss=='N'){
             // document.getElementById('passper').style.display='none';
              document.getElementById('totalscore').disabled="disbled";
            }
            else {
                   document.getElementById('totalscore').disabled="";
            //  document.getElementById().innerHTML="<td class='rightside'>Pass Percentage(%)<sup><font color='#FF0000' >*</font></sup></td><td><input type='text' class='validate[required,min[0],max[100],mediumtext]' onkeyup='jm_phonemask(this)'  name='totalscore' id='totalscore' maxlength='3' /></td>";
        // document.getElementById('passper').style.display="block";
            }
        }
   
