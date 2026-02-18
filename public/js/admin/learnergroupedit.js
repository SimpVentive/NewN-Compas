jQuery(document).ready(function(){
	jQuery("#learnergroupeditForm").validationEngine();
}); 

$(function(){
    $('#startdate, #enddate').datepicker('destroy');
    var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
        defaultDate:"+1w" , //dd,
			changeMonth: true,
			numberOfMonths: 1,
		//	minDate:'+0',
		//	showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//	buttonImageOnly: true,
			onSelect: function( selectedDate ) {
				var option = this.id == "startdate" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(instance.settings.dateFormat ||$.datepicker._defaults.dateFormat,selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
															   });	
			/*document.getElementById("startdate").value="";
			document.getElementById("enddate").value="";*/
	});

function validation(){
    var group=document.getElementById('lgroup').value;	
    var stdate=document.getElementById('startdate').value;
    var enddate=document.getElementById('enddate').value;
    var des=document.getElementById('description').value;	
    var gpopt=document.getElementById('groupoption').value;
    // var ch=document.getElementById('inch');
    //if(stdate){
		 alertify.alert(stdate);
		//}
		if(group==''){
			  alertify.alert("Plese enter Group Name");
			  return false;
			  }
			  
			   if(stdate==''){
			  alertify.alert("Plese Enter Start Date");
			  return false;
			  }
			/*   if(enddate==''){
			  alertify.alert("Plese enter End Date");
			   return false;
			  }*/
			   if(des==''){
			  alertify.alert("Plese enter Description");
			  return false;
			  }
			  if(gpopt==''){
				alertify.alert("Please select Gropu Option "); 
				  return false;				  
				  
				  }
		 
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
                }
				var dt2= stdate;
			var arrDt2 = dt2.split('/')
			var date2=arrDt2[2] + "/" + arrDt2[1] + "/" + arrDt2[0];
			
			var dt= enddate;
			var arrDt = dt.split('/')
			var date1=arrDt[2] + "/" + arrDt[1] + "/" + arrDt[0];
			if(stdate!='' && enddate!=''){
				if (date2>date1){
					alertify.alert("End date should be greater than start date");
					return false;
				}
			}
		  
			  
		
	}
 
function deletefun(){ 
    var tab = document.getElementById('emptable'); 
    var s=document.getElementById("addgroup").value;
    var gid=document.getElementById('gid').value;
    var con=window.confirm("Do you want to delete the selected ?");
	   if(con==true){
                 var remove=Array();
                 var spli=s.split(","); 
                 var len=spli.length; 
		  // alertify.alert(len);
                      for(var i=len; i>=1; i--){ 
                        k=i; 
                        var row = tab.rows[k]; 
                      //  var chkbox = row.cells[0].childNodes[0];
                        var chs=document.getElementById('chkbox['+k+']');
                        if(null != chs.value && true == chs.checked) {  
			//alertify.alert(chs);
                        var cc=chs.value;
                        if(cc!=""){
                        $.ajax({			 //  alertify.alert(gid);
                             url: BASE_URL+"/admin/deletegroupemp",
                             global: false,
                             type: "POST",
                             data: ({id : cc,gid : gid}),
                             dataType: "html",
                             async:false,
                             success: function(msg){
								// alertify.alert(msg);
                             }
                         }).responseText;
                    }
                        var j=k-1; 
						
                        spli.splice(j,1);
                        tab.deleteRow(j); 
                        len=spli.length;
                
             }
          }        
         document.getElementById("addgroup").value=spli;
	   }
	    else {
	      return false;
	    
			
		}
    }
/*
function deletefun(){
	var table = document.getElementById('emptable');
	//alertify.alert(i);
	var s=document.getElementById("addgroup").value;
	 var spli=s.split(",");
	    // alertify.alert(spli); 
		flag=0;
		var len=spli.length;
		 for(var j=0;j<len;j++){
				k=j+1; 
				//alertify.alert(k);
				  
				var ddd="chkbox["+spli[j]+"]";
				  //  alertify.alert(ddd);
					//var chk=document.getElementById(ddd);
			if(document.getElementById(ddd).checked){
			flag++;
			}
		 }
		  if(flag>0){
			// alertify.alert("flag value="+flag);
			  //alertify.alert("j value="+len-1);
			  var jinit=parseInt(len)-1;
			  // alertify.alert(jinit);
			for(var j=jinit; j>=0; j--){
				k=j+1;
				//alertify.alert(k);
					var dd="chkbox["+spli[j]+"]";
				   //alertify.alert(dd);
			if(document.getElementById(dd).checked==true){  //alertify.alert(len);
				spli.splice(j,1);
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
		   document.getElementById("addgroup").value=spli;
	}
*/
function addfun(){
	//var gp=document.getElementById('groupoption').value;
	// if(gp=='B'){ var val=gp; var name='Both'; }else if(gp=='I'){  var val=gp; var name='Individual';}
	var val=document.getElementById('gpoptval').value;
	var name=document.getElementById('gpoptname').value;
	var table = document.getElementById('emptable');
	var rowCount = table.rows.length;
	var iteration=rowCount;	
	//alertify.alert(iteration);
	var iteration1 = rowCount-1;
	var numbers=/^[0-9]+$/;
	var alphanum=/^[0-9a-zA-Z., ]+$/;
	var alpha=/^[a-zA-Z., ]+$/;
	var alphaspecial=/^[A-Z a-z :.,;_@()!&-// ]+$/;
	var email12=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
	//var url2=/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(([0-9]{1,5})?\/.*)?$/i;
	//var dat=/^(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d+$/;
	
	//alertify.alert(rowCount);
	var dd="addgroup";
	var s=document.getElementById(dd).value;
	// if(s==''){ document.getElementById(dd).value=j; }
	s=s.split(",");
	
	for(var i=0;i<s.length;i++){
			b=s[i];
		var empno='empno['+b+']';  
		var empval='empval['+b+']';
		var emporg='emporg['+b+']';
		var emmpgrade='empgrade['+b+']';
		var group='empgroup['+b+']';
		
		//var mobile=document.getElementById(empno).value;
		//alertify.alert(mobile);
		//alertify.alert(document.getElementById(empno).value);
		
		if (document.getElementById(empno).value==''){
				alert ('Please Enter Employee Number');
				return false;
		 }
		 if (document.getElementById(emporg).value==''){
				//alert ('Please Enter Employee Number');
				return false;
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
	p=parseInt(temp2)+1;
	if(document.getElementById(dd).value==""){
		employeecount=1;
		p=1;
	}
	else{
		employeecount.push(p);		
			}
	 document.getElementById(dd).value=employeecount;
	 var rowcou=parseInt(iteration);
	var row = table.insertRow(iteration);	
	var cell1 = row.insertCell(0);
	 cell1.style.textAlign="center"; 
		var checkbox1 = document.createElement("input");
		checkbox1.type ='checkbox';
		checkbox1.id='chkbox['+p+']';
		checkbox1.name='chkbox[]';
		checkbox1.value='';
		//checkbox1.style.marginBottom="16px";
		cell1.appendChild(checkbox1);
		
	 	var cell2 = row.insertCell(1);
		 cell2.style.textAlign="center";
	    cell2.innerHTML="<input type='text' id='empno["+p+"]' name='empno[]' style='width:81px;' onchange='getempdetails("+rowcou+")' /><a data-toggle='modal' href='#modalgroup'><img  src='"+BASE_URL+"/public/images/search-icon.png' onclick='searchemps()' width='18px' style='cursor:pointer;' /></a>";

	var cell3 = row.insertCell(2);
	 cell3.style.textAlign="center";
	var text3 = document.createElement("input");
	text3.type = "text";
	text3.style.width="102px";
	text3.id='empval['+p+']';
	text3.name='empval[]';
	text3.readOnly=true;
	cell3.appendChild(text3);
	
	var cell4 = row.insertCell(3);
	 cell4.style.textAlign="center";
	var text4 = document.createElement("input");
	text4.type = "text";
	text4.style.width="102px";
	text4.id='emporg['+p+']';
	text4.name='emporg[]';
	text4.readOnly=true;
	cell4.appendChild(text4);
	
	var cell5 = row.insertCell(4);
	 cell5.style.textAlign="center";
	var text5 = document.createElement("input");
	text5.type = "text";
	text5.style.width="102px";
	text5.id='empgrade['+p+']';
	text5.name='empgrade[]';
	text5.readOnly=true;
	cell5.appendChild(text5);
	
	  var cell6 = row.insertCell(5);
	   cell6.style.textAlign="center";
		cell6.innerHTML="<select name='gpoption[]' class='inputList ' id='gpoption["+p+"]' style='width:96px' readonly='readonly'><option value='"+val+"'>"+name+"</option></select>";
		
		document.getElementById("empno["+p+"]").focus();
	
	}
	
	 function getempdetails(id){
	var idd=Number(id)+1;
	 var dd=document.getElementById('empno['+idd+']').value; 
	  
		var table = document.getElementById('emptable');
		var rowCount = table.rows.length;
		var iteration=rowCount;	
		// alertify.alert(iteration);
		  var cou=parseInt(rowCount)-2;
		 //  alertify.alert(cou);
		 for(var i=0; i<cou; i++){
			  j=i+1;
		 var ddd=document.getElementById('empno['+j+']').value;
		  /// alertify.alert("DDD value"+ddd+"dd value"+dd);
		      var f=j+1;
			
		 var focu=document.getElementById('empno['+f+']');
		  // alertify.alert(focu);
			 if(dd==ddd){
				 alertify.alert("Employee Number already you have entered.Plese enter another one.");
				// focu.value="";
				
				 document.getElementById('empno['+idd+']').value="";
				// document.getElementById('empno['+f+']').value="";
				  document.getElementById('empno['+f+']').focus();
			   // focu.focus();
				 return false;

			 }
			 
		 }
	  
	  	var  xmlhttp2;
			if (window.XMLHttpRequest){
				// code for IE7+, Firefox, Chrome, Opera, Safari
				  xmlhttp2=new XMLHttpRequest();
	          }
		else{
			// code for IE6, IE5
			xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
		   }
			xmlhttp2.onreadystatechange=function(){
				if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
					
			var data = xmlhttp2.responseText;
                        
			 if(data==''){  alertify.alert("Employee Number not available.");
			            document.getElementById('empno['+idd+']').value="";
						  document.getElementById('empval['+idd+']').disabled="disabled";
						   document.getElementById('emporg['+idd+']').disabled="disabled";
						    document.getElementById('empgrade['+idd+']').disabled="disabled";
							 document.getElementById('gpoption['+idd+']').disabled="disabled";
							// document.getElementById('add').disabled="disabled";
							
			                   return false;
			         }
					 
			 else {   
			          	var result =data.split('*');
						var en=$.trim(result[0]);
					    var enam=$.trim(result[1]);
						var org=$.trim(result[2]);
					    var grd=$.trim(result[3]);
						// document.getElementById('empno['+id+']').
						  document.getElementById('empval['+idd+']').disabled="";
						   document.getElementById('emporg['+idd+']').disabled="";
						    document.getElementById('empgrade['+idd+']').disabled="";
							 document.getElementById('gpoption['+idd+']').disabled="";
							  document.getElementById('add').disabled="";
						 document.getElementById('empno['+idd+']').value=en;
						 //document.getElementById('empno['+id+']').readOnly=true;
					      document.getElementById('empval['+idd+']').value=enam;
						   document.getElementById('empval['+idd+']').readOnly=true;
						   document.getElementById('emporg['+idd+']').value=org;
						    document.getElementById('emporg['+idd+']').readOnly=true;
						    document.getElementById('empgrade['+idd+']').value=grd;
							document.getElementById('empgrade['+idd+']').readOnly=true;
							 document.getElementById('gpoption['+idd+']').disabled="disabled";
			       }
					
				}
			}  //?org="+org+"&grad="+grad+"&loc="+loc+"&post=
			xmlhttp2.open("GET",BASE_URL+"/admin/getempdetails?empnum="+dd,true);
			xmlhttp2.send();
 	 }
	 
	 
    function searchemps(){
	  //document.getElementById('msg_box33').style.display='block';
        var table = document.getElementById('emptable');
        var rowCount = table.rows.length;
        
         var s=document.getElementById("addgroup").value;
	var spli=s.split(",");
	var len=spli.length;
         var eid='';
         for(var m=len;m >0; m--){
                        k=m+1;
                     var fd=spli[m-1];
                     var ddd="empno["+fd+"]";
                     var eno=document.getElementById(ddd).value;
                            if(eid==''){ eid=eno;  }
                            else{  eid=eid+','+eno;  }
                        }		
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
                        {    //  alertify.alert(xmlhttp.responseText);
                             //   document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
                               // alert_msg();
									document.getElementById("group_users").innerHTML=xmlhttp.responseText;
                        }
                }
                xmlhttp.open("GET",BASE_URL+"/admin/allemployees?eid="+eid+"&status='edit'",true);
                xmlhttp.send(); 

	}

function checkAll(){ 
	var tbl = document.getElementById('inner_data_emp');
	var lastRow = tbl.rows.length;
	if(lastRow>1){
		for(var i=0; i<=lastRow; i++){
			var row = tbl.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(document.getElementById('maincheck').checked==true){
				if(chkbox.disabled==false){
					chkbox.checked = true ;
				}
			}
			else{
				if(chkbox.disabled==false){
					chkbox.checked = false ;
				}
			}
		}
	}
    }

function getempids(ids){
	var gop=document.getElementById('gpoptval').value;
	var name=document.getElementById('gpoptname').value;
        var emp='';
        for(var i=1;i<=ids;i++){
                var checkid=document.getElementById('check['+i+']');
                if(checkid.checked==true){
                        var empid=checkid.value;
                        //var empid=document.getElementById('emp_id['+i+']').value;
                        if(emp==''){
                                emp=empid;
                        }
                        else{
                                emp=emp+","+empid;
                        }			
                }

    }
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

                            // alertify.alert(xmlhttp.responseText);
                            //document.getElementById('viewdataemp_div').style.display='block';
                             document.getElementById("emptablediv").innerHTML=xmlhttp.responseText;

                    }
            }
		xmlhttp.open("GET",BASE_URL+"/admin/group_selected_emp_list?empids="+emp+"&gop="+gop,true);
		xmlhttp.send();
		$('.lightbox_bg').hide()
		document.getElementById('msg_box33').style.display='none';
 }
function alert_msg(){
	$(document).ready(function(){
	   var lclose = $("<a class='lightbox_close_rel'>Close This</a>");
	   $('#msg_box33').append(lclose);
	   var myval = "msg_box33";
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
		$( "#msg_box33").draggable();
	   $("#" + myval+' .lightbox_close_rel').add();
	   $("#" + myval).animate({
							  opacity: 1,
							  left: "420px",
							  top: "90px"
			 }, 10);
	   });
	$('a.lightbox_close_rel').click(function(){
	 var myval2 =$(this).parent().attr('id');
	 $("#" + myval2).animate({
							 opacity: 0,
							 top: "-1200px"
							 },0,
							 function(){
								 $('.lightbox_bg').hide()
							 });
	 });
}
