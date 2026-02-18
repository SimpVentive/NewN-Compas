jQuery(document).ready(function(){
	jQuery("#questionForm").validationEngine();
}); 
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
    
    function multiple_single_choice(){
            table=document.getElementById('radio4Tab');
            len=table.rows.length;
			if(Number(len)==Number(5)){ alertify.alert("Maximum Number of Options are 5 Only."); return false;  }
          var dd="addgroup_single";
	var s=document.getElementById(dd).value;
        var temp2=0;	
	var employeecount=document.getElementById(dd).value;
	employeecount=employeecount.split(",");
	var asdf=employeecount.length-1;
	for(var k=0; k<employeecount.length; k++){	
		if(parseInt(temp2)<parseInt(employeecount[k])){
			temp2=employeecount[k];
		}
	}
	p=parseInt(temp2)+1;
	if(document.getElementById(dd).value===""){
		employeecount=1;
		p=1;
	}
	else{
		employeecount.push(p);		
	   }
	 var gg=document.getElementById(dd).value=employeecount;
         var rowcou=len;
   if(rowcou < Number(5)){
            var row = table.insertRow(rowcou);
            var cell1 = row.insertCell(0);
			 cell1.style.styleFloat = 'right';
             cell1.style.cssFloat = 'right';
	    cell1.innerHTML="<input type='radio' name='rad_multiple' value='answer_rad_"+p+"' id='qar"+p+"'><input type='hidden' value='' name='value_id_"+p+"' >Correct Answer";	
	
	    var cell2 = row.insertCell(1);
		$(cell2).addClass("ae_answerDefinition");
	    cell2.innerHTML="<table style='padding-left:30px;'><tbody><tr style='line-height:60px;'><td>Answer Text<sup><font color='#FF0000' style='height:32px'>*</font></sup>:</td><td><input type='text' class='mediumtext' name='answer_rad_"+p+"' id='qart"+p+"'  value=''></td></tr><tr style='line-height:60px;'><td>Explanation Text:</td><td><input type='text' class='mediumtext' name='expla_rad_"+p+"'id='qert"+p+"' value=''></td></tr></tbody></table>";
	
            var cell3 = row.insertCell(2);
            cell3.innerHTML="<input id='multiple_single"+p+"' class='btn btn-sm btn-danger' type='button' value='Delete' name='multiple_single' onclick='deletemultiple_single("+p+")'>";
       }  // else{ alertify.alert('Maximum Number of Options are 5 Only'); return false; }
   }
     function deletemultiple_single1(id){ 
	var tab = document.getElementById('radio4Tab'); 
       var s=document.getElementById("addgroup_single").value;
	var spli=s.split(",");
        var len=spli.length;
	 var con=window.confirm("Are you sure want to Delete the Option.");
	   if(con===true){
                for(var i=len; i>=1; i--){
                      var vs=Number(spli[i]);
                         if(vs===id){
                          var cc=document.getElementById('hqar'+id).value; 
                                if(cc!==""){
                                $.ajax({                       //  alertify.alert(gid);
                                     url: BASE_URL+"/admin/deletequestionvalus",
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
                         var j=parseInt(i);
                   document.getElementById('radio4Tab').deleteRow(j);
                    spli.splice(j,1); 
                    }
          }        
       document.getElementById("addgroup_single").value=spli;
	   }
    else {
      return false;
        }
    }

    function deletemultiple_single(id){
	var table = document.getElementById('radio4Tab');
	var s=document.getElementById("addgroup_single").value;
	var spli=s.split(",");
        len=spli.length;
            for(var i=0;i<len; i++){
                var vs=Number(spli[i]);
               if(vs===id){
                spli.splice(i,1);
              document.getElementById('radio4Tab').deleteRow(i);
               }
            }
      document.getElementById("addgroup_single").value=spli;
	}
   function deletemultiple_multple1(id){ 
	var tab = document.getElementById('radio5Tab'); 
       var s=document.getElementById("addgroup_multiple").value;
	  
	var spli=s.split(",");
        var len=spli.length;
	 var con=window.confirm("Are you sure want to Delete the Option.");
	   if(con===true){
                for(var i=len; i>=1; i--){ 
                      var vs=Number(spli[i]);
                         if(vs===id){
                          var cc=document.getElementById('chk_mul_'+id).value; 
                          if(cc!==""){
                                $.ajax({
                                                                 //  alertify.alert(gid);
                                     url: BASE_URL+"/admin/deletequestionvalus",
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
                         var j=parseInt(i);
                   document.getElementById('radio5Tab').deleteRow(j);
                     spli.splice(j,1);
					
                    }
          }        
       document.getElementById("addgroup_multiple").value=spli;
	   }
	    else {
	      return false;
		}
    }

   function deletemultiple_multple(id){
	var table = document.getElementById('radio5Tab');
	var s=document.getElementById("addgroup_multiple").value;
	var spli=s.split(",");
        len=spli.length;
            for(var i=0;i<len; i++){
                var vs=Number(spli[i]);
               if(vs===id){
                spli.splice(i,1);
              document.getElementById('radio5Tab').deleteRow(i);
               }
            }
      document.getElementById("addgroup_multiple").value=spli;
	}
   function multiple_multple_choice(){
       table=document.getElementById('radio5Tab');
        len=table.rows.length;
			if(Number(len)==Number(5)){ alertify.alert("Maximum Number of Options are 5 Only."); return false;  }
          var dd="addgroup_multiple";
	var s=document.getElementById(dd).value;
        var temp2=0;	
	var employeecount=document.getElementById(dd).value;
	employeecount=employeecount.split(",");
	var asdf=employeecount.length-1;
	for(var k=0; k<employeecount.length; k++){	
		if(parseInt(temp2)<parseInt(employeecount[k])){
			temp2=employeecount[k];
		}
	}
	p=parseInt(temp2)+1;
	if(document.getElementById(dd).value===""){
		employeecount=1;
		p=1;
	}
	else{
		employeecount.push(p);		
			}
	 document.getElementById(dd).value=employeecount;
         var rowcou=len;
          if(rowcou<Number(5)){
	var row = table.insertRow(rowcou);
	var cell1 = row.insertCell(0);
	   cell1.style.styleFloat = 'right';
       cell1.style.cssFloat = 'right';
	   cell1.style.paddingRight="20px" ;
	   $(cell1).addClass("ae_answerCorrect");	
	cell1.innerHTML="<input type='checkbox' value='"+p+"' name='chkbox_"+p+"' id='chk_mul_"+p+"'><input type='hidden' name='value_id_"+p+"' value='' />Correct Answer";	
	var cell2 = row.insertCell(1);
	    $(cell2).addClass("ae_answerCorrect");
	    cell2.innerHTML="<table><tbody><tr style='line-height:60px;'><td >Answer Text<sup><font color='#FF0000' style='height:32px'>*</font></sup></td><td><input type='text' class='mediumtext' name='answer_chk_"+p+"' id='q6a"+p+"'  value=''></td></tr><tr style='line-height:60px;'><td>Explanation Text</td><td><input type='text' class='mediumtext' name='expla_chk_"+p+"'id='qe"+p+"'  value='' ></td></tr></tbody></table>";
        var cell3 = row.insertCell(2);
        cell3.innerHTML="<input id='multiple_single"+p+"' class='btn btn-sm btn-danger' type='button' value='Delete' name='multiple_single' onclick='deletemultiple_multple("+p+")'>";
          }
         // else{ alertify.alert("Maximum Number of Options are 5 Only."); return false;  }
    }
    
   function gettypedata(id){
            var dd=document.getElementById("questtype_"+id).value;
           // alertify.alert(dd);
          //  var lab=document.getElementById("label_"+id).innerText;
         var lab=$("#label_"+id).text();
          document.getElementById('selectedtype').innerHTML=lab; 
          for(var i=1;i<7;i++){
              if(i===id){
        document.getElementById('radio'+id).style.display="block";
          }
          else {
         document.getElementById('radio'+i).style.display="none";  
          }
         }
     }  
     
    function validation(){
	    var stdate=document.getElementById('startdate').value;	
	    var enddate=document.getElementById('enddate').value;	
            var quest=document.getElementById('question_name').value;	
            var publish=document.getElementById('pstatus').value;
            var points=document.getElementById('points').value;
            var isChecked = jQuery("input[name=questtype]:checked").val();

              if(isChecked==='FT'){
                  var q=document.getElementById('freetext').value;
                  if(q===''){
                   alertify.alert("Please enter Free text.");
                   return false;
                 }
             }
             
             if(isChecked==='B'){
                  var n=document.getElementById('qan1').value;
                   //alertify.alert("hellol");
                  if(n==='Type your answer text here'){
                   alertify.alert("Please enter Answer text.");
                   return false;
                 }
             } 
            if(isChecked==='T'){
                  var t=document.getElementById('qat1').value;
                  var f=document.getElementById('qat2').value;
                  if(t==='Type your answer text here'){
                   alertify.alert("Please enter Answer text.");
                   return false;
                 }
               if(f==='Type your answer text here'){
                   alertify.alert("Please enter Answer text.");
                   return false;
                 }
             } 
         if(isChecked==='S'){
                 var len=$('input[name=rad_multiple]').length
                  for(var i=1; i<=len;i++){
                     // alertify.alert("haii");
                var dd=document.getElementById('qart'+i).value;
                // alertify.alert(dd);
                   if(dd===''){
                         alertify.alert("Please enter Answer text");
                       return false;
                       }
                      for(var j=1; j<=len; j++){
                         var ddd=document.getElementById('qart'+j).value; 
                          if(j!=i){
                              var ss=dd.trim(); var sss=ddd.trim();
                              if(ss===sss){
                                  alertify.alert("Please dont enter duplicate Answers.");
                                  return false;
                              }
                          }
                       }  
                  }
                  var chs=1;
                  for(var j=1; j<=len;j++){
                    if(document.getElementById('qar'+j).checked==true){
                        chs=2;
                        }
                  }
                  if(chs==1){
                        alertify.alert("Please check the Correct Answer");
                         return false;
                    }
                 } 
          
      if(isChecked==='M'){
                var ord=document.getElementById('order').value;
                var tab=document.getElementById('radio5Tab');
                len=tab.rows.length;
                 if(len<2){
                      alertify.alert("Please Add another Answer");
                      return false;
                  }
                  var chec=0;
                 // alertify.alert(len); return false;
              for(var i=1; i<=len;i++){
                  var dd=document.getElementById('q6a'+i).value;
                  var ss=document.getElementById('chk_mul_'+i);
                 // alertify.alert(ss.value);
                        if(ss.checked===true){
                            chec=Number(chec)+1;
                        }
                        if(dd===''){
                            alertify.alert("Please enter Answer text");
                             return false;
                            }
							
							
                    for(var j=1; j<=len; j++){
                         var ddd=document.getElementById('q6a'+j).value;
                        // alertify.alert(ddd); alertify.alert(len);
                          if(j!=i){
                              var sm=dd.trim(); 
							  var ssm=ddd.trim();
                              if(sm===ssm){
                                  alertify.alert("Please dont enter duplicate Answers.");
                                  return false;
                              }
                          }                         
                       }                            
                  } // alertify.alert(chec); alertify.alert(len);
                    if(Number(chec)==0){ alertify.alert("Please select Correct options."); return false; }
                    //alertify.alert(chec);
                    if(Number(chec)===Number(len)){
                        if(chec<5){
                         alertify.alert("Please Add another Unchecked Answer");
                          return false;
                        }
                        else {
                            alertify.alert("Please dont check all options");
                            return false;
                        }
                     }
                 }
                  
	       }
  
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
  