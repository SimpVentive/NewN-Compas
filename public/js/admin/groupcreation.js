jQuery(document).ready(function(){
	jQuery("#learnergroupForm").validationEngine();
}); 

jQuery(document).ready(function() {
    jQuery('#inch').click(function() {
        if ($(this).is(':checked')) {
           document.getElementById('divheirarchy').style.visibility="visible";
        }
		else {
			 document.getElementById('divheirarchy').style.visibility="hidden";
		  }
    });
});

function validation(){
	  var group=document.getElementById('lgroup').value;
	 // alertify.alert(group);
	 //  var stdate=document.getElementById('startdate').value;	
	//    var enddate=document.getElementById('enddate').value;	
	//	 var des=document.getElementById('description').value;	
		 var gpopt=document.getElementById('groupoption').value;
		// var ch=document.getElementById('inch');
		
		var che=document.getElementsByName("chkbox[]");
		//var ccc=document.getElementByName("chkbox");
		var jjj=che.length;

			  if(gpopt==''){
				alertify.alert("Please select Group Option "); 
				  return false;	
				  }
		
			var flag=0;
			for(var jj=1; jj<=jjj; jj++){
			
			 var ccc='chkbox['+jj+']';
                         var eno='empno['+jj+']';
				// alertify.alert(ccc);
				if(document.getElementById(ccc).checked==true){
                                    //alertify.alert(document.getElementById(eno).value);
                                   if(document.getElementById(eno).value==''){
                                    alertify.alert('Please enter or search employee number.');
                                    document.getElementById(eno).focus();
                                    return false;
                                   }
					flag++;
				  }
			}
			// alertify.alert(flag);
                        
			if(flag==0){
				alertify.alert("Plese select the employees for grouping.");
				  return false;
			}
	 }
 
	$(function(){
		$('#startdate, #enddate').datepicker('destroy');
		var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate:"+1w" , //dd,
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		//minDate:'+0',
		//showOn: "button",
       //         buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "startdate" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
				selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
                                //$("#learnergroupForm").validationEngine();
			}
		});	
		document.getElementById("startdate").value="";
		document.getElementById("enddate").value="";
	});
  
function searchreasult(){
	var group=document.getElementById('groupoption').value;
	var loc=document.getElementById('location').value;
	var org=document.getElementById('orgname').value;
	var bus=document.getElementById('bus').value;
	var hierar=document.getElementById('heirarchy').value;
	var grad=document.getElementById('grade').value;
	var emptype=document.getElementById('emptype').value;
	var post=document.getElementById('position').value;
	if(group==''){
		alertify.alert("Please selectt Group Option"); 
		return false; 
	}
	if(org=='' && bus=='' && loc=='' && grad=='' && emptype=='' && post==''){
		alertify.alert("Please select anyone SBU, Organization, Location, Grade, Employee Type, Position.");
		return false;
	}
	/* if(document.getElementById('inch').checked==true){
            if(document.getElementById('hierarchytext').value==0){
                alertify.alert('You dont have Heirarchy please uncheck the check box.');
                return false;
            };
		if(document.getElementById('heirarchy').value==''){
			alertify.alert("Please select Hierarchy name");
			return false;
		}
	} */
	
	
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
			document.getElementById("emptablediv").innerHTML=xmlhttp2.responseText;
			document.getElementById('buttonstable').style.display="block";
			document.getElementById('formbuttondiv').style.display="block";
			if(group=='S'){
				document.getElementById('addbuttondiv').style.display="none";
			}
			if(group=='B'){
				document.getElementById('addbuttondiv').style.display="block";	
			}
			$("#checkall").change(function(){
				$(".chkall:enabled").prop('checked', $(this).prop("checked"));
			});
			$('.chkall').change(function(){
				if(false == $(this).prop("checked")){
					$("#checkall").prop('checked', $(this).prop("checked")); 
				}
			});
		}
	}
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/admin/getempdata?group="+group+"&loc="+loc+"&bus="+bus+"&org="+org+"&hierar="+hierar+"&grad="+grad+"&emptype="+emptype+"&post="+post,true);
	xmlhttp2.send();
}

function deletefun(){
	var table = document.getElementById('emptable');
	//alertify.alert(i);
	var s=document.getElementById("addgroup").value;
       // alertify.alert(s);
	var spli=s.split(",");
	// alertify.alert(spli); 
	flag=0;
		var len=spli.length;
                
		 for(var m=len;m >0; m--){
                        k=m+1;
                        // alertify.alert(m);
                         var fd=spli[m-1];
                        //  alertify.alert(fd);
                        var ddd="chkbox["+fd+"]";
                        // alertify.alert(ddd);
			if(document.getElementById(ddd).checked==true){
			flag++;
			}
		 }
		  if(flag>0){
			var jinit=parseInt(len)-1;
			for(var j=jinit; j>=0; j--){
				k=j+1;
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
              //  alertify.alert(spli);
		   document.getElementById("addgroup").value=spli;
	}
	
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
function addfun(){   
	var gp=document.getElementById('groupoption').value;
	 if(gp=='B'){ var val=gp; var name='Both'; }else if(gp=='I'){  var val=gp; var name='Individual';}
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
	
	var dd="addgroup";
	var s=document.getElementById(dd).value;
          //alertify.alert(s);
	 if(s!=''){  
	// if(s==''){ document.getElementById(dd).value=j; }
	s=s.split(",");
	// alertify.alert(s.length);
	for(var i=0;i<s.length;i++){
			b=s[i];
		var empno='empno['+b+']';  
		var empval='empval['+b+']';
		var emporg='emporg['+b+']';
		var emmpgrade='empgrade['+b+']';
		var group='empgroup['+b+']';
		
		if (document.getElementById(empno).value==''){
				alert ('Please Enter Employee Number');
				return false;
		  }
		  if (document.getElementById(emporg).value==''){
				//alert ('Please Enter Employee Number');
				return false;
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
	p=parseInt(temp2)+1;
	if(document.getElementById(dd).value==""){
		employeecount=1;
		p=1;
	}
	else{
		employeecount.push(p);		
			}
	 document.getElementById(dd).value=employeecount;
	 var rowcou=parseInt(iteration)+1;
         
	var row = table.insertRow(iteration);
     
	var cell1 = row.insertCell(0);
	    cell1.style.textAlign="center";
		var checkbox1 = document.createElement("input");
		checkbox1.type = 'checkbox';
		
		checkbox1.id='chkbox['+p+']';
		checkbox1.style.marginLeft='10px';
		checkbox1.name='chkbox[]';
                checkbox1.value="";
		cell1.appendChild(checkbox1);
		
	 
	
	var cell2 = row.insertCell(1);
	//cell2.style.textAlign="center";
	cell2.innerHTML="<input type='text' id='empno["+p+"]'  name='empno[]' style='width:75%;' onchange='getempdetails("+rowcou+")' /><a data-toggle='modal' href='#modalgroup'><img  src='"+BASE_URL+"/public/images/search-icon.png' onclick='searchemps()' width='18px' style='cursor:pointer;' /></a>";

	var cell3 = row.insertCell(2);
	//cell3.style.textAlign="center";
	var text3 = document.createElement("input");
	text3.type = "text";
	text3.style.width="90%";
	text3.id='empval['+p+']';
	text3.name='empval[]';
	text3.readOnly=true;
	cell3.appendChild(text3);
	
	var cell4 = row.insertCell(3);
	//cell4.style.textAlign="center";
	var text4 = document.createElement("input");
	text4.type = "text";
	text4.style.width="90%";
	text4.id='emporg['+p+']';
	text4.name='emporg[]';
	text4.readOnly=true;
	cell4.appendChild(text4);
	
	var cell5 = row.insertCell(4);
	//cell5.style.textAlign="center";
	var text5 = document.createElement("input");
	text5.type = "text";
	text5.style.width="85%";
	text5.id='empgrade['+p+']';
	text5.name='empgrade[]';
	text5.readOnly=true;
	cell5.appendChild(text5);
	
	  var cell6 = row.insertCell(5);
	  //cell6.style.textAlign="center";
		cell6.innerHTML="<select name='gpoption[]' class='inputList ' id='gpoption["+p+"]' disabled='disabled' style='width:85%;'><option value='"+val+"'>"+name+"</option></select>";
		document.getElementById("empno["+p+"]").focus();
	}
	

  function getempdetails(id){
	 // alertify.alert(id);
	 var dd=document.getElementById('empno['+id+']').value; 
	  
		var table = document.getElementById('emptable');
		var rowCount = table.rows.length;
		var iteration=rowCount;	
		 for(var i=1; i<rowCount; i++){
		 var ddd=document.getElementById('empno['+i+']').value;
		      var f=parseInt(i)+1;
		 var focu=document.getElementById('empno['+f+']');
			 if(dd==ddd){
				 alertify.alert("Emplyee Number already you have entered.Plese enter another one.");
			    focu.focus();
				document.getElementById('empno['+id+']').value="";
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
			 if(data==''){ alertify.alert("Plese enter Correct Employee Number or Click on Search.");
			 
			            document.getElementById('empno['+id+']').value="";
						document.getElementById('empval['+id+']').disabled="disabled";
						document.getElementById('emporg['+id+']').disabled="disabled";
						document.getElementById('empgrade['+id+']').disabled="disabled";
						document.getElementById('gpoption['+id+']').disabled="disabled";
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
						 document.getElementById('empval['+id+']').disabled="";
						 document.getElementById('emporg['+id+']').disabled="";
						 document.getElementById('empgrade['+id+']').disabled="";
						 document.getElementById('gpoption['+id+']').disabled="disabled";
						 document.getElementById('add').disabled="";
                                                 document.getElementById('chkbox['+id+']').value=en;
						 document.getElementById('empno['+id+']').value=en;
                                                 
						 //document.getElementById('empno['+id+']').readOnly=true;
					      document.getElementById('empval['+id+']').value=enam;
						   document.getElementById('empval['+id+']').readOnly=true;
						   document.getElementById('emporg['+id+']').value=org;
						    document.getElementById('emporg['+id+']').readOnly=true;
						    document.getElementById('empgrade['+id+']').value=grd;
							document.getElementById('empgrade['+id+']').readOnly=true;
							 document.getElementById('gpoption['+id+']').readonly=true;
                                                         
			       }
					
				}
			}  //?org="+org+"&grad="+grad+"&loc="+loc+"&post=
			xmlhttp2.open("GET",BASE_URL+"/admin/getempdetails?empnum="+dd,true);
			xmlhttp2.send();
 	 }
   
 function getdetails(){
		  var gpopt=document.getElementById('groupoption').value;
		  if(gpopt=='I'){
			document.getElementById('trsearch').style.display="none";  
			document.getElementById('formbuttondiv').style.display="block";
			
			document.getElementById('location').value="";
			document.getElementById('location').disabled="disabled";
			 
			document.getElementById('orgname').value="";
			document.getElementById('orgname').disabled="disabled";
			
			//document.getElementById('inch').value="";
			//document.getElementById('inch').disabled="disabled";
			
			document.getElementById('grade').value="";
			document.getElementById('grade').disabled="disabled";
			
			document.getElementById('emptype').value=""
			document.getElementById('emptype').disabled="disabled";
			
			document.getElementById('position').value=""
			document.getElementById('position').disabled="disabled";
			
			document.getElementById('heirarchy').value="";
			document.getElementById('heirarchy').disabled="disabled";
                        
			document.getElementById('emptablediv').innerHTML=" <div class='form-group'><div class='col-xs-12 col-sm-1'><input id='add' class='btn btn-sm btn-success' type='button' onClick='addfun()' value='Add' name='addrow'></div> <div class='col-xs-12 col-sm-1'><input id='delete' class='btn btn-sm btn-danger' type='button' onclick='deletefun()' value='Delete' name='delete'></div></div><table  class='table table-striped table-bordered table-hover' style='width:1082px;  margin-bottom:0px;' id='newtableid' ><thead><tr >\n\
<th style='width:25px;'>Select</th><th style='width:94px;'>Employee Number</th><th style='width:137px;'>Employee Name</th><th style='width:121px;'>Organization</th> <th   style='width:124px;'>Grade</th><th style='width:106px;'>Group Option</th></tr></thead></table><div style='overflow:auto; height:125px; width: 1100px;'><table id='emptable' class='table table-striped table-bordered table-hover' style='margin-top:0px; width: 1082px;'><tr><td style='text-align:center; width:52px;'><input type='checkbox' style='margin-left:5px;' name='chkbox[]'  id='chkbox[1]'  value='' /></td><td  style='width:88px;' ><input type='text' name='empno[]'  onchange='getempdetails(1)' id='empno[1]' style='width:75%;' value=''  /><a href='#modalgroup' data-toggle='modal'><img height='15px' style='cursor:pointer;' onclick='searchemps()' src='"+BASE_URL+"/public/images/search-icon.png'></a></td><td style='width:128px;'><input type='text' name='empval[]' id='empval[1]' style='width:90%;' value='' readonly /></td><td style='width:114px;'><input type='text' name='emporg[]' id='emporg[1]' value='' style='width:90%;' readonly /></td><td style='width:117px;'><input type='text' name='empgrade[]' id='empgrade[1]' style='width:85%;' value='' readonly  /></td><td style='width:99px;'><select style='width:85%;' disabled='disabled' id='gpoption[1]' name='gpoption[]'><option value='I'>Individual</option></select></td></tr></table> <input type='hidden' id='addgroup' name='addgroup' value='1' />";
			// document.getElementById("newtableid1").style.display="none";
		//	document.getElementById('buttonstable').style.display="block";
			document.getElementById('add').style.display="block";
		   }
		   else if(gpopt=='B'){
			     document.getElementById('trsearch').style.display="block";  
			///document.getElementById('buttonstable').style.display="block";
		document.getElementById('formbuttondiv').style.display="none";
                
			document.getElementById('location').disabled="";
			document.getElementById('location').value="";
			document.getElementById('orgname').disabled="";
			document.getElementById('orgname').value="";
			//document.getElementById('inch').disabled="";
			//document.getElementById('inch').checked="";
			document.getElementById('grade').disabled="";
			document.getElementById('grade').value="";
			document.getElementById('emptype').disabled="";
			document.getElementById('emptype').value="";
			document.getElementById('position').disabled="";
			document.getElementById('position').value="";
			document.getElementById('heirarchy').disabled="";
			document.getElementById('heirarchy').value="";
			//document.getElementById('heirarchy').style.display="none";
			
			// document.getElementById('newtableid1').style.display="block";
			//document.getElementById('buttonstable').style.display="none";
			document.getElementById('emptablediv').innerHTML="<table class='table table-striped table-bordered table-hover' id='newtableid1' ><thead><tr ><th>Select</th> <th>Employee Number</th><th>Employee Name</th> <th>Organization</th><th>Grade</th>   <th>Group Option</th></tr></thead><tbody id='tbody'><tr id='firstrow' ><td colspan='6' style='text-align:center;'>No  data found</td></tr></tbody></table>";
			
			//document.getElementById('add').style.direction="block";
			   }
		  else if(gpopt=='S'){
			  document.getElementById('trsearch').style.display="block";  
		//	document.getElementById('buttonstable').style.display="none"; 
			document.getElementById('formbuttondiv').style.display="none";
			document.getElementById('location').disabled="";
			document.getElementById('location').value="";
			document.getElementById('orgname').disabled="";
			document.getElementById('orgname').value="";
			//document.getElementById('inch').disabled="";
			//document.getElementById('inch').checked="";
			document.getElementById('grade').disabled="";
			document.getElementById('grade').value="";
			document.getElementById('emptype').disabled="";
			document.getElementById('emptype').value="";
			document.getElementById('position').disabled="";
			document.getElementById('position').value="";
			document.getElementById('heirarchy').disabled="";
			//document.getElementById('heirarchy').style.display="none";
			document.getElementById('heirarchy').value="";
			
		//	document.getElementById('emptable').style.display="none";
		//	document.getElementById('newtableid1').style.display="block";
				document.getElementById('emptablediv').innerHTML="<table class='table table-striped table-bordered table-hover' id='newtableid1' ><thead><tr ><th>Select</th> <th>Employee Number</th><th>Employee Name</th> <th>Organization</th><th>Grade</th>   <th>Group Option</th></tr></thead><tbody id='tbody'><tr id='firstrow' ><td colspan='6' style='text-align:center;'>No  data found</td></tr></tbody></table>";
			  
		  }
			
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
				{
					//document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
					//alert_msg();
					//alertify.alert(xmlhttp.responseText);
					document.getElementById("group_users").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET",BASE_URL+"/admin/allemployees?eid="+eid,true);
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
		
		var gop=document.getElementById('groupoption').value;
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
		
		if(emp==''){
				alertify.alert("Please Select Employees.");
				 return false;
				
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


function deleterows1(id,row){ 
      
 var con=window.confirm("Are you sure want to Delete the record.");
  if(con==true){
	   document.getElementById(row).style.display='none';
      if (window.XMLHttpRequest)                
		 {// code for IE7+, Firefox, Chrome, Opera, Safari
		 xmlhttp=new XMLHttpRequest();
		 }		
		  else{// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		 }
		xmlhttp.onreadystatechange=function()                                          
		{                                         
		if (xmlhttp.readyState==4 && xmlhttp.status==200)           
		{ 		//for(var j=0 j<table.length; j++){
			       //alertify.alert(dd);
			      //if(document.getElementById(dd).checked==true){  //alertify.alert(len);
					//spli.splice(row,1);
					/*alertify.alert(row);
					table.deleteRow(row);*/
					//ble.deleteRow();
					//len=spli.length;
					// alertify.alert(len);
					// break;
				 //  }
			 }
		
		} 
	 // ?id="+sel+"&id1="+comp_ten
	  xmlhttp.open("GET",BASE_URL+"/admin/group_deletion?group="+id,true);
	  xmlhttp.send();
		}
        else { return false;   }
	  
   }
   
    function gotosearch(){
	
	window.location = BASE_URL+"/admin/group_search";	
	
  }
  
  function givemessage(){ alertify.alert("haii");
      var dd=document.getElementById('grade').value;
       if(dd==''){ alertify.alert('No Grades found.') }
      
  }