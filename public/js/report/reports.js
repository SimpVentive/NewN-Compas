 jQuery(document).ready(function(){
               jQuery("#reportForm").validationEngine();
               //alertify.alert('haiii');
       });
       
   function getreportparams(){
       var type=document.getElementById('reptype').value;
      // alertify.alert(type);
        var  xmlhttp2;
            if (window.XMLHttpRequest){
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp2=new XMLHttpRequest();
            }
            else{
                    xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp2.onreadystatechange=function(){
                    if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
					     //  alertify.alert(xmlhttp2.responseText);
                         document.getElementById('div_syscode').innerHTML=xmlhttp2.responseText;
                        // document.getElementById('div_reports').innerHTML=xmlhttp2.responseText;;
                     }
             }
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post= 
        // var prog,eve,enrol,enumber,orgname,fromdate,todate;
	xmlhttp2.open("GET",BASE_URL+"/report/getreporttypes?id="+type,true);
	xmlhttp2.send();
     
 }
   function deletefun_new(){
        var s=document.getElementById("addgroup").value;
	var spli=s.split(",");
	var flag=0; 
	var len=spli.length;
      for(var m=len;m >0; m--){
                      var kk=m-1;
                         var fd=spli[kk];
                         var ddd="chkbox_"+fd;
			if(document.getElementById(ddd).checked==true){
                          if(document.getElementById('report_paramid_'+fd).value!="") {     
			   flag++;
			}
                     }
		   }
        if(flag>0){
       jQuery(document).ready(function(){  
        var footer="<a id='confirms' name='confirms' onclick=\"deletefun()\" ><button>YES</button></a>&nbsp;&nbsp;&nbsp;<a id='confirm' name='confirm'><button>NO</button></a>";
                        $.uilightbox({
                            'title'	 : "<p align='center'>Confirmation</p>",
                            'body'	 : "<p align='center' >Do you want to delete Parametes ?</p>",
                            'footer'	: footer,
                            'triggerClose' 	: "#ui-lightbox a"
                });
              
                });
            }
            else {  deletefun();  }
   }
   function deletefun(){
	var table = document.getElementById('parametersTable');
	var s=document.getElementById("addgroup").value;
	var spli=s.split(",");
	var flag=0; 
	var len=spli.length;
      for(var m=len;m >0; m--){
                      var kk=m-1;
                         var fd=spli[kk];
                         var ddd="chkbox_"+fd;
			if(document.getElementById(ddd).checked==true){
			flag++;
			}
		   }
	if(flag>0){   var jinit=parseInt(len);
			for(var j=jinit; j>0; j--){
				var k=j-1;
				var dd="chkbox_"+spli[k];
			if(document.getElementById(dd).checked==true){ // alertify.alert(j);
                             var cc=document.getElementById('report_paramid_'+spli[k]).value; 
                           if(cc!==""){
                                $.ajax({      //  alertify.alert(gid);
                                     url: BASE_URL+"/report/deletetereportvals",
                                     global: false,
                                     type: "POST",
                                     data: ({id : cc }),
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
			   }
			 }
		  }
		else if(flag==0){
			toastr.error("Please select the record");
				return false;
		}
            document.getElementById("addgroup").value=spli;
	}
     
     function validation(){
        var table = document.getElementById('parametersTable');
        var ds=document.getElementById('reptype').value;
        if(ds==''){ alertify.alert('Please select Report Type.') ; return false; }
        var rowCount = table.rows.length;
        var dd="addgroup";
        var s=document.getElementById(dd).value;
       	 if(s!=''){  
	         s=s.split(",");
           for(var i=0;i<s.length;i++){var b=s[i];
                    var param=document.getElementById('param'+b).value;
                    var syscode=document.getElementById('syscode'+b).value;
                    var visible=document.getElementById('visible'+b).value;
                    var regex= /^[0-9]+$/;  
                    if(param==''){
                       toastr.error("Please enter Parameter Name .");
                       return false;
                     }
                    if(syscode==''){toastr.error('Please select System Code'); return false; }
                    if(visible==''){
                        toastr.error("Please select Visible option.");
                        return false;
                    }           
              for(var j=0;j<s.length;j++){var bb=s[j];
                    if(j!=i){
                            var param1=document.getElementById('param'+bb).value;
                            var syscode1=document.getElementById('syscode'+bb).value;                            
                            if(param==param1){
                                toastr.error("This Parameter Name already exists. Ensure you create a unique code..");
                                 document.getElementById('param'+bb).value='';
                                 document.getElementById('visible'+bb).focus();
                                return false;
                               } 
                           if(syscode==syscode1){
                               toastr.error("This Code already exists. Ensure you create a unique code.");
                             document.getElementById('syscode'+bb).value='';
                             document.getElementById('syscode'+bb).focus();
                            return false;
                           }
                    }
                 }
            }
          }
       
     }
    
 
function addfun(){  
      var reptypeid=document.getElementById('reptype').value;
	  //alertify.alert(reptypeid);
      
      if(reptypeid==''){ toastr.error('Please select report type.'); return false;  }
      var table = document.getElementById('parametersTable');
	  var rowCount = table.rows.length;
      var reportvalues='';
	  if(document.getElementById('typevalues')){
      var reportvalues=document.getElementById('typevalues').value;
	  }
      //alertify.alert(reportvalues);
      var data=reportvalues;
     if(data!=''){
           var reportparms =data.split('***');
            var params='';
            for(var i=0;i<reportparms.length;i++){
               var comp2=reportparms[i].split('###');
                if(params==''){
                    params="<option value='"+comp2[0]+"'>"+comp2[1]+"</option>";
                }else{
                    params=params+"<option value='"+comp2[0]+"'>"+comp2[1]+"</option>";
                }
            }
          }
        else{
          params='';  
        }
     /// code for visible and Invisible values   
       //alertify.alert(status);
         if(status!=''){
             var statusvals=status.split(',');
             var competencies='';
             for(var i=0;i<statusvals.length;i++){
                 comp2=statusvals[i].split('*');
                 if(competencies==''){
                     competencies="<option value='"+comp2[0]+"'>"+comp2[1]+"</option>";
                 }else{
                     competencies=competencies+"<option value='"+comp2[0]+"'>"+comp2[1]+"</option>";
                 }
             }
         }
        else{
          competencies='';  
        }        
      
      var rowCount = table.rows.length;
       var dd="addgroup";
       var s=document.getElementById(dd).value;
       
       	 if(s!=''){  
	         s=s.split(",");
	  // alertify.alert(s.length);
       for(var i=0;i<s.length;i++){var b=s[i];
           if(s.length==8){ alertify.alert("The maximum levels of Parameters are 8 Only."); return false;}
                var param=document.getElementById('param'+b).value;
                 var syscode=document.getElementById('syscode'+b).value;
                var visible=document.getElementById('visible'+b).value;
                var regex= /^[0-9]+$/;  
                 if(param==''){
                    toastr.error("Please enter Parameter Name .");
                    return false;
                  }
                
                  if(visible==''){
                      toastr.error("Please select Visible option.");
                      return false;
                  }
                   
           
                for(var j=0;j<s.length;j++){var bb=s[j];
                    if(j!=i){
                            var param1=document.getElementById('param'+bb).value;
                            var syscode1=document.getElementById('syscode'+bb).value;
                            var visible1=document.getElementById('visible'+bb).value;
                            
                        if(param==param1){
                            toastr.error("Parameter Name should be Unique.");
                             document.getElementById('param'+bb).value='';
                             document.getElementById('visible'+bb).focus();
                            return false;
                           } 
                           if(syscode==syscode1){
                                toastr.error("System Code should be Unique.");
                             document.getElementById('syscode'+bb).value='';
                             document.getElementById('syscode'+bb).focus();
                            return false;
                           }
                    }
            }
        }
      }
         var temp2=0;	
	var parametercount=document.getElementById(dd).value;
	parametercount=parametercount.split(",");
	var asdf=parametercount.length-1;
	for(var k=0; k<parametercount.length; k++){	
		if(parseInt(temp2)<parseInt(parametercount[k])){
			temp2=parametercount[k];
		}
	}
	var p=parseInt(temp2)+1;
	if(document.getElementById(dd).value==""){
		parametercount=1;
		p=1;
	}
	else{parametercount.push(p);}
	 document.getElementById(dd).value=parametercount;
	// var rowcou=parseInt(iteration)+1;
	var row = table.insertRow(rowCount);
        
         
                
           var cell1 = row.insertCell(0);      
          cell1.innerHTML="<div style='text-align:center;'><input  type='checkbox' name='chkbox[]' id='chkbox_"+p+"'  value='' />  <input type='hidden' name='report_paramid[]' id='report_paramid_"+p+"' value='' /></div>";     
                
       var cell2 = row.insertCell(1);
      cell2.innerHTML="<div style='text-align:left;'><input type='text' class='validate[required,minSize[3],maxSize[50]] form-control' name='param[]' id='param"+p+"'  value='' /></div>";  
       
        var cell3=row.insertCell(2);
        cell3.innerHTML="<div style='text-align:left;'><select id='syscode"+p+"' name='syscode[]' class='validate[required] form-control m-b'><option value=''>Select</option>"+params+"</select></div>";      
    
       
       var cell4=row.insertCell(3);
        cell4.innerHTML="<div style='text-align:left;'><select id='visible"+p+"' name='visible[]' class='validate[required] form-control m-b'>"+competencies+"</select></div>";      
     }
     
    
 