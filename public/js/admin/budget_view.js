jQuery(document).ready(function() {
	$('#tab_1').addClass('active'); 	
});

$(document).ready(function() {
//$( "#msg_box33" ).draggable();
});
function tab_fun(id,counts){  
	var id=id;
	var counts=counts;
	for(var i=1;i<=counts;i++){ 
		if(i==id){
			document.getElementById('link_'+id).style.display='block';
		}
		else{
			document.getElementById('link_'+i).style.display='none';
		}
		}
	
}
function add_itemdetails1(id,period_id){ 
	var tbl = document.getElementById('item_amount_table');
	var lastRow = tbl.rows.length; 
	var lastRow1=lastRow-1;
	var p='';
	var m='';
	var n='';
	for(var i=1;i<=lastRow1;i++){
		var x=document.getElementById('item_name_'+i).value;
		for(var z=1;z<=lastRow1;z++){
			var valid_x=document.getElementById('item_name_'+z).value;
			if(i!=z){
				if(x.trim()==valid_x.trim()){
				alertify.alert("Please Select Different Item Name");
				return false;
				}
			}
		}
		var y=document.getElementById('total_amount_'+i).value; 
		if(y==''){
			alertify.alert("Please Enter Amount");
			return false;
		}
		if(document.getElementById('auto_item_wise_id_'+i).value!=''){
		var u=document.getElementById('auto_item_wise_id_'+i).value;
		}
		else{
			var u=0;
		}
		if(p=='' && m==''){
			p=x+'#*'+y;
		}
		else{
			p=p+','+x+'#*'+y;
		}
		if(n==''){
			n=u;
		}
		else{
			n=n+','+u;
		}
		document.getElementById("itemdetails_"+period_id+"_"+id).innerHTML="<input type='hidden' name='auto_item_wise_id"+period_id+"[]' id='auto_item_wise_id_"+id+"_"+period_id+"' value="+n+"><input type='hidden' name='item_det"+period_id+"[]' id='item_det"+id+"_"+period_id+"' value="+p+">";
	}
	document.getElementById("budgetAddpopup").style.display='none';
	$('.lightbox_bg').hide();
}

	
function add_depart(id,bud_id){	
	var tb2 = document.getElementById('budget_table_'+id);
	var lastRow1 = tb2.rows.length; 
	var lastRow=lastRow1-1;
	 var row = tb2.insertRow(lastRow1);
		var cell1= row.insertCell(0); 
		cell1.innerHTML="<input type='hidden' name='auto_dept_id"+id+"[]' id='auto_dept_id"+id+"' value=''/><select name='dept_name1[]' id='dept_name"+lastRow1+"_"+id+"' style='width:160px;'><option value=''>Select</option><option value='1'>Unitol Learning System</option></select>";
		var cell2= row.insertCell(1);
		cell2.innerHTML="<input type='text' name='dept_amount1[]' id='dept_amount"+lastRow1+"_"+id+"' value=''>";
		var cell3= row.insertCell(2);
		cell3.innerHTML="<input type='text' name='participants1[]' id='participants"+lastRow1+"_"+id+"'>";
		var cell4= row.insertCell(3);
		cell4.innerHTML="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><a onClick='additional_details("+lastRow1+")' style='font-size:12px;color:#03C;'>Details</a></u><div id='itemdetails_"+lastRow1+"'><input type='hidden' id='auto_item_wise_id_1' name='auto_item_wise_id[]' value=''><input type='hidden' name='auto_item_id"+id+"[]' id='auto_item_id"+id+"' value=''/><input type='hidden' name='item_det"+id+"[]' id='item_det' value=''/></div>";		
		var cell5= row.insertCell(4);
	}
	
function add_depart1(id,bud_id,period_id){
	var tb2 = document.getElementById('budget_table_'+id);
	var lastRow1 = tb2.rows.length; 
	var lastRow=lastRow1-1;
	var row = tb2.insertRow(lastRow1);
	var budget_id=document.getElementById('bud_name').value;//alertify.alert(role_id);
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
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var cell1= row.insertCell(0); 
			cell1.innerHTML="<input type='hidden' name='auto_dept_id"+period_id+"[]' id='auto_dept_id"+period_id+"' value=''/><select name='dept_name"+period_id+"[]' id='dept_name"+lastRow1+"_"+period_id+"' style='width:160px;'><option value=''>Select</option>"+xmlhttp.responseText+"</select>";
			var cell2= row.insertCell(1);
			cell2.innerHTML="<input type='text' name='dept_amount"+period_id+"[]' id='dept_amount"+lastRow1+"_"+period_id+"' value=''>";
			var cell3= row.insertCell(2);
			cell3.innerHTML="<input type='text' name='participants"+period_id+"[]' id='participants"+lastRow1+"_"+period_id+"'>";
			var cell4= row.insertCell(3);
			cell4.innerHTML="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><a onClick='additional_details("+lastRow1+","+period_id+")' style='font-size:12px;color:#03C;'>Details</a></u><div id='itemdetails_"+period_id+"_"+lastRow1+"'><input type='hidden' id='auto_item_wise_id_1' name='auto_item_wise_id[]' value=''><input type='hidden' name='auto_item_id"+period_id+"[]' id='auto_item_id"+period_id+"' value=''/><input type='hidden' name='item_det"+period_id+"[]' id='item_det"+lastRow1+"_"+period_id+"' value=''/></div>";
			var cell5= row.insertCell(4);
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/retrive_org_name?budget_id="+budget_id,true);
		xmlhttp.send();
	}

	
function search_budget(){
	window.location=BASE_URL+"/admin/budget_search";		
	}

function select_Quater(){
	var id=document.getElementById("bud_name").value;
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
			 if (xmlhttp.readyState==4 && xmlhttp.status==200){
				 document.getElementById('search1').style.display='none';
				 document.getElementById('tabs').style.display='block';
				 document.getElementById('tabs').innerHTML=xmlhttp.responseText;
				 }
		 }
		 xmlhttp.open("GET",BASE_URL+"/admin/budgeting_type?budget_id="+id,true);
		 xmlhttp.send();	
}
function additional_details(id,period_id){
	 var xmlhttp;
	   if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
			}else{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){			
					document.getElementById('budgetAddpopup').style.display='block';
					document.getElementById("budgetAddpopup").innerHTML=xmlhttp.responseText;					
					//popup_text();					
				}
			}
			
			xmlhttp.open("GET",BASE_URL+"/admin/additional_budgetdetails_views_none?id="+id+"&period_id="+period_id,true);
			xmlhttp.send(); 
	
	}
	
function additional_details_update(id,period_id,dept_id){
	 var xmlhttp;
	   if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
			}else{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){			
					document.getElementById('budgetAddpopup').style.display='block';
					document.getElementById("budgetAddpopup").innerHTML=xmlhttp.responseText;					
					//popup_text();					
				}
			}
			
			xmlhttp.open("GET",BASE_URL+"/admin/additional_budgetdetails_view?id="+id+"&dept_id="+dept_id+"&period_id="+period_id,true);
			xmlhttp.send(); 
	
	}
	
function additional_details1(id,period_id){
	 var xmlhttp;
	   if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
			}else{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){			
					document.getElementById('budgetAddpopup').style.display='block';
					document.getElementById("budgetAddpopup").innerHTML=xmlhttp.responseText;					
					//popup_text();					
				}
			}
			
			xmlhttp.open("GET",BASE_URL+"/admin/additional_budgetdetails1?id="+id+"&period_id="+period_id,true);
			xmlhttp.send(); 
	
	}

	
function popup_text(){
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
							   $("#" + myval+' .lightbox_close_rel').add();
							   $("#" + myval).animate({
													  opacity: 1,
													  //left: "180px",
													  top: "180px"
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