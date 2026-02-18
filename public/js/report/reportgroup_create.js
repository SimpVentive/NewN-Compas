      jQuery(document).ready(function(){
               jQuery("#reportForm").validationEngine();
               //toastr.error('haiii');
       });
       
         function deletefun(){
	var table = document.getElementById('reportTable');
	var s=document.getElementById("addgroup").value;
       // var comid=document.getElementById('comp_id').value;
	var spli=s.split(",");
	var flag=0; //toastr.error(spli);
	var len=spli.length;
               // toastr.error(len);
      for(var m=len;m >0; m--){
                      var kk=m-1;
                     //  toastr.error(m);
                         var fd=spli[kk];
                        //  toastr.error(fd);
                        var ddd="chkbox_"+fd;
                        // toastr.error(ddd);
			if(document.getElementById(ddd).checked==true){
			flag++;
			}
		   }
	if(flag>0){
                        // toastr.error(len);
			var jinit=parseInt(len);
                        // toastr.error(jinit);
			for(var j=jinit; j>0; j--){
				var k=j-1; //toastr.error(k); toastr.error(spli[k]);
				var dd="chkbox_"+spli[k];
				   //toastr.error(dd);
			if(document.getElementById(dd).checked==true){ // toastr.error(j);
                             var cc=document.getElementById(dd).value; 
                               // toastr.error(cc);
                           if(cc!==""){
                                $.ajax({      //  toastr.error(gid);
                                     url: BASE_URL+"/admin/deletetecompetencylevels",
                                     global: false,
                                     type: "POST",
                                     data: ({id : cc ,cid:comid }),
                                     dataType: "html",
                                     async:false,
                                     success: function(msg){         // toastr.error(msg);
                                     }
                                 }).responseText;
                             
                              }
                            
				var hh=j-1;  //toastr.error(j);
                                spli.splice(hh,1);
				table.deleteRow(j);
				len=spli.length;
				// toastr.error(len);
				// break;
			   }
			 }
		  }
		else if(flag==0){
			toastr.error("Please select the record");
				return false;
			
		}
              //  toastr.error(spli);
		   document.getElementById("addgroup").value=spli;
	}
        
     
      function getreportdetails(id){
         
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
                       //  document.getElementById('div_reports1').style.display='block';
                         document.getElementById('div_data').innerHTML=xmlhttp2.responseText;;
                     }
             }
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post= 
        // var prog,eve,enrol,enumber,orgname,fromdate,todate;
	xmlhttp2.open("GET",BASE_URL+"/report/getreportrtdetails?id="+id,true);
	xmlhttp2.send();          
      }
      
   
      
      function validation(){
        var valid=$('#reportForm').validationEngine('validate');
        if(valid==false){
            $('#reportForm').validationEngine();
        }
    else{    var dd="addgroup";
             var s=document.getElementById(dd).value;  
            if(s!=''){  
                    s=s.split(",");
                    for(var i=0;i<s.length;i++){var b=s[i];
                        if(s.length==8){ toastr.error("The maximum number of reports are 8 Only."); return false;}
                             var param=document.getElementById('reportname'+b).value;
                             var visible=document.getElementById('visible'+b).value;
                             var regex= /^[0-9]+$/;  
                              if(param==''){
                                 toastr.error("Please select Report Name .");
                                 return false;
                               }

                               if(visible==''){
                                   toastr.error("Please select Visible option.");
                                   return false;
                               }


                             for(var j=0;j<s.length;j++){var bb=s[j];
                                 if(j!=i){
                                         var param1=document.getElementById('reportname'+bb).value;
                                         var visible1=document.getElementById('visible'+bb).value;

                                     if(param==param1){
                                         toastr.error("Report already you have selected.");
                                          document.getElementById('reportname'+bb).value='';
                                          document.getElementById('visible'+bb).focus();
                                         return false;

                                        }                        
                                 }
                         }
                     }
                   }
         }     
      }
      
      

//function addfun(){  
//     var cou=document.getElementById('countreports').value;
//     if(cou==0){ toastr.error('You have Only one Report.Please Create Report.') ; return false; }
//      var table = document.getElementById('reportTable');
//      var rowCount = table.rows.length;
//       var dd="addgroup";
//       var s=document.getElementById(dd).value;  
//       
//       
//       	 if(s!=''){  
//	         s=s.split(",");
//	  // toastr.error(s.length);
//       for(var i=0;i<s.length;i++){var b=s[i];
//           if(s.length==8){ toastr.error("The maximum number of reports are 8 Only."); return false;}
//                var param=document.getElementById('reportname'+b).value;
//                var visible=document.getElementById('visible'+b).value;
//                var regex= /^[0-9]+$/;  
//                 if(param==''){
//                    toastr.error("Please select Report Name .");
//                    return false;
//                  }
//                
//                  if(visible==''){
//                      toastr.error("Please select Visible option.");
//                      return false;
//                  }
//                   
//           
//                for(var j=0;j<s.length;j++){var bb=s[j];
//                    if(j!=i){
//                            var param1=document.getElementById('reportname'+bb).value;
//                            var visible1=document.getElementById('visible'+bb).value;
//                            
//                        if(param==param1){
//                            toastr.error("Report already you have selected.");
//                             document.getElementById('reportname'+bb).value='';
//                             document.getElementById('visible'+bb).focus();
//                            return false;
//
//                           }                        
//                    }
//            }
//        }
//      }
//      
//       
//       
//       
//       
//         if(status!=''){
//             var statusvals=status.split(',');
//             var competencies='';
//             for(var i=0;i<statusvals.length;i++){
//                 comp2=statusvals[i].split('*');
//                 if(competencies==''){
//                     competencies="<option value='"+comp2[0]+"'>"+comp2[1]+"</option>";
//                 }else{
//                     competencies=competencies+"<option value='"+comp2[0]+"'>"+comp2[1]+"</option>";
//                 }
//             }
//         }
//        else{
//          competencies='';  
//        }  
//       if(gprs!=''){
//             var statusvals=gprs.split(',');
//             var reports='';
//             for(var i=0;i<statusvals.length;i++){
//                 comp2=statusvals[i].split('*');
//                 if(reports==''){
//                     reports="<option value='"+comp2[0]+"'>"+comp2[1]+"</option>";
//                 }else{
//                     reports=reports+"<option value='"+comp2[0]+"'>"+comp2[1]+"</option>";
//                 }
//             }
//         }
//        else{
//          reports='';  
//        }  
//      
//         var temp2=0;	
//	var parametercount=document.getElementById(dd).value;
//	parametercount=parametercount.split(",");
//	var asdf=parametercount.length-1;
//	for(var k=0; k<parametercount.length; k++){	
//		if(parseInt(temp2)<parseInt(parametercount[k])){
//			temp2=parametercount[k];
//		}
//	}
//	var p=parseInt(temp2)+1;
//	if(document.getElementById(dd).value==""){
//		parametercount=1;
//		p=1;
//	}
//	else{parametercount.push(p);}
//	 document.getElementById(dd).value=parametercount;
//	// var rowcou=parseInt(iteration)+1;
//	var row = table.insertRow(rowCount);
//                
//           var cell1 = row.insertCell(0);      
//          cell1.innerHTML="<div style='text-align:center;'><input  type='checkbox' name='chkbox[]' id='chkbox_"+p+"'  value='' /></div>";     
//                
//       var cell2 = row.insertCell(1);
//      cell2.innerHTML="<div style='text-align:left;'><select class='validate[required] mediumselect' id='reportname"+p+"' name='reportname[]'><option value=''>select</option>"+reports+"</select></div>";  
//       
//       var cell3=row.insertCell(2);
//        cell3.innerHTML="<div style='text-align:left;'><select class='validate[required] mediumselect' id='visible"+p+"' name='visible[]' class='validate[required,minSize[3],maxSize[15]] mediumselect'>"+status+"</select></div>";      
//    
//    }
        