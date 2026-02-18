jQuery(document).ready(function(){
	jQuery("#budgeting_creation").validationEngine();
});
jQuery(document).ready(function() {
	$('#tab_1').addClass('active'); 	
});
$(document).ready(function() {
$( "#msg_box33" ).draggable();
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
function add_itemdetails(id){
	var tbl = document.getElementById('item_amount_table');
	var lastRow = tbl.rows.length; 
	var lastRow1=lastRow-1;
	var p='';
	var m='';
	for(var i=1;i<=lastRow1;i++){
		var x=document.getElementById('item_name_'+i).value;
		var y=document.getElementById('total_amount_'+i).value; //alertify.alert(x+" "+y);
		if(p=='' && m==''){
			p=x+'#*'+y;
		}
		else{
			p=p+','+x+'#*'+y;
		}
		/*if(m==''){
			m=y;
		}
		else{
			m=m+','+y;
		}*/
		document.getElementById("itemdetails_"+id).innerHTML="<input type='text' name='item_det"+id+"[]' id='item_det"+id+"' value="+p+">";
		document.getElementById("msg_box33").style.display='none';
		
		$('.lightbox_bg').hide()
		
	}
}

function add_itemdetails1(id,period_id){
    var valid=$('#item_popup').validationEngine('validate');
    if(valid==false){
        $('#item_popup').validationEngine();
    }
    else{
		var tbl = document.getElementById('item_amount_table');
		var lastRow = tbl.rows.length; 
		var lastRow1=lastRow-1;
			var adduser=document.getElementById('addusers').value;
			var expl1=adduser.split(',');
		var p='';
		var m='';
			var n=''
		//for(var i=1;i<=lastRow1;i++){
			for(var i=0;i<expl1.length;i++){
				var t=expl1[i];
			var x=document.getElementById('item_name_'+t).value;
					for(var z=0;z<expl1.length;z++){
						var r=expl1[z];
				var valid_x=document.getElementById('item_name_'+r).value;
				if(t!=r){
					if(x.trim()==valid_x.trim()){
					alertify.alert("Please Select Different Item Name");
					return false;
					}
				}
			}
			var y=document.getElementById('total_amount_'+t).value; //alertify.alert(x+" "+y);
					if(y==''){
				alertify.alert("Please Enter Amount");
				return false;
			}
			if(p=='' && m==''){
				p='0+'+x+'#*'+parseFloat(y.replace(/,/g, ''));
			}
			else{
				p=p+',0+'+x+'#*'+parseFloat(y.replace(/,/g, ''));
			}
			if(n==''){
						n=parseFloat(y.replace(/,/g, ''));
					}
					else{
						n=parseFloat(n)+parseFloat(y.replace(/,/g, ''));
					}
			document.getElementById("itemdetails_"+period_id+"_"+id).innerHTML="<input type='text' style='color:#FFFFFF;border:0px;height:0px;' name='item_det"+period_id+"[]' id='item_det"+id+"_"+period_id+"' value="+p+" class='validate[funcCall[checkitemsamount]]'>";
			document.getElementById("tot_amount_"+period_id+"_"+id).innerHTML="Total item Amount:&emsp;"+parseFloat(n)+"";
			//document.getElementById("msg_box33").style.display='none';
			
			$("#item_det"+id+"_"+period_id+"").css("display","block");
			$("#item_det"+id+"_"+period_id+"").css("width","0px");
			$("#item_det"+id+"_"+period_id+"").css("visibility","hidden");
			$("#budpopup").modal('hide');		
			//$('.lightbox_bg').hide();		
		}
    }
}
	
function add_depart(id,bud_id){	
   
	var tb2 = document.getElementById('budget_table_'+id);
	var lastRow1 = tb2.rows.length; 
	var lastRow=lastRow1-1;
	 var row = tb2.insertRow(lastRow1);
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
		// alertify.alert(xmlhttp.responseText);
		 var cell1= row.insertCell(0); 
		cell1.innerHTML="<input type='hidden' name='auto_dept_id"+id+"[]' id='auto_dept_id"+id+"' value=''><select name='dept_name1[]' id='dept_name"+lastRow1+"_"+id+"' class='validate[required] mediumselect'><option value=''>Select</option>"+xmlhttp.responseText+"</select>";
		var cell2= row.insertCell(1);
		cell2.innerHTML="<input type='text' name='dept_amount1[]' id='dept_amount"+lastRow1+"_"+id+"' class='validate[required] mediumtext'>";
		var cell3= row.insertCell(2);
		cell3.innerHTML="<input type='text' name='participants1[]' id='participants"+lastRow1+"_"+id+"' class='validate[maxSize[5]] smalltext'>";
		var cell4= row.insertCell(3);
		cell4.innerHTML="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><a onClick='additional_details("+lastRow1+")' style='font-size:12px;color:#03C;'>Details</a></u><div id='itemdetails_"+lastRow1+"'><input type='text' name='item_det"+id+"[]' id='item_det' value=''/></div>";		
		var cell5= row.insertCell(4);
				}
			}
			xmlhttp.open("GET",BASE_URL+"/admin/retrive_butype_name?budget_id="+budget_id,true);
			xmlhttp.send();

	}
	
function add_depart1(id,bud_id,period_id){
    var tb2 = document.getElementById('budget_table_'+id);
    var adduser=document.getElementById('org_addusers_'+id).value;
    var expl1=adduser.split(',');
    for(var i=0;i<expl1.length;i++){
        var t=expl1[i];
        var x=document.getElementById('dept_name'+t+'_'+period_id).value;
        for(var z=0;z<expl1.length;z++){
            var r=expl1[z];
            var valid_x=document.getElementById('dept_name'+r+'_'+period_id).value;
            if(i!=z){
                if(x.trim()==valid_x.trim()){
                    alertify.alert("Please Change Organization Name");
                    return false;
                }
            }
        }
        var y=document.getElementById('dept_name'+t+'_'+period_id).value;
        if(y==''){
            alertify.alert("Please Select Organization Name");
            return false;
        }
    }
    var temp=0;
    for(var i=0;i<expl1.length;i++){
        if(temp<expl1[i]){
            temp=parseInt(expl1[i]);
        }
    }
    lastRow2=parseInt(temp)+1;
    var lastRow1 = tb2.rows.length;
    var lastRow=lastRow1-1;
    var row = tb2.insertRow(lastRow1);
    var budget_id=document.getElementById('budget_name_id').value;   
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
                                cell1.innerHTML="<input type='checkbox' name='org_chk_"+period_id+"[]' id='org_chk_"+lastRow2+"_"+period_id+"' value=''>";
				var cell2= row.insertCell(1);
				cell2.innerHTML="<input type='hidden' name='auto_dept_id"+period_id+"[]' id='auto_dept_id"+period_id+"' value=''><select name='dept_name"+period_id+"[]' id='dept_name"+lastRow2+"_"+period_id+"' class='validate[required] mediumselect'><option value=''>Select</option>"+xmlhttp.responseText+"</select>";
				var cell3= row.insertCell(2);
				cell3.innerHTML="<input type='text' name='dept_amount"+period_id+"[]' id='dept_amount"+lastRow2+"_"+period_id+"' class='validate[required] mediumtext'>";
				var cell4= row.insertCell(3);
				cell4.innerHTML="<input type='text' name='participants"+period_id+"[]' id='participants"+lastRow2+"_"+period_id+"' class='validate[maxSize[5]] smalltext'>";
				var cell5= row.insertCell(4);
				cell5.innerHTML="<div onClick='additional_details1("+lastRow2+","+period_id+")' style='color:#03C;cursor: pointer;' href='#budpopup' role='button'  data-toggle='modal'><u><label>Details</label> </u><div id='itemdetails_"+period_id+"_"+lastRow2+"' style='height:0px;margin-top: -29px;'><br>&emsp;&emsp;&emsp;&emsp;&emsp;<label style='color: #000000;'>Total item Amount:0</label><input type='hidden' name='item_det"+period_id+"[]' id='item_det"+lastRow2+"_"+period_id+"' value=''/></div></div><br><label id='tot_amount_"+period_id+"_"+lastRow2+"'></label>";
				var cell6= row.insertCell(5);
				var hidid=document.getElementById('org_addusers_'+id).value; 
				if(hidid!=''){
					var hidid=hidid+','+lastRow2;
				}
				else{
					var hidid=lastRow2;
				}
				document.getElementById('org_addusers_'+id).value=hidid;			
								
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/retrive_butype_name?budget_id="+budget_id,true);
		xmlhttp.send();
	}
        
function delete_depart1(id,bud_id,period_id){
    var tab = document.getElementById('budget_table_'+id); 
        var s=document.getElementById('org_addusers_'+id).value;
        //var flag=0;
        var remove=Array();
        var spli=s.split(",");
        var len=spli.length;
        for(var i=len; i>=1; i--){
            k=i;
            var row = tab.rows[k];
            var chkbox = row.cells[0].childNodes[0];
            if(null != chkbox && true == chkbox.checked) { 
                var cc=chkbox.value; 
                var j=k-1;
                spli.splice(j,1);
                tab.deleteRow(k);
                len=spli.length;
            }
        }
        document.getElementById('org_addusers_'+id).value=spli;
}
function validation(key){
    var a='';
    var b='';
    var c='';
    var d='';
	var amount='';
    for(var i=1;i<=key;i++){
        var period_id=document.getElementById('period_id'+i).value;
        var period_name=document.getElementById('period_name'+i).value;
        var tb2 = document.getElementById('budget_table_'+i);
        var lastRow1 = tb2.rows.length; 
        var lastRow=lastRow1-1; 
		var budget_amount=document.getElementById('budget_amount').value;	
		var bud_amt=budget_amount.replace(/,/g,'');
		//alertify.alert(bud_amt);
        var period_amounts12=document.getElementById('period_amount1_'+period_id).value;
		var period_amounts1=period_amounts12.replace(/,/g,'');
		if(amount==''){
			amount=period_amounts1;
		}else{
			if(period_amounts1!=''){
				amount=parseInt(amount,10)+parseInt(period_amounts1,10);
			}
		}
		//alertify.alert(amount);
		var bal_amount=bud_amt-amount;
        for(var j=1;j<=lastRow;j++){
            var org_name=document.getElementById('dept_name'+j+'_'+period_id).value;
            for(k=1;k<=lastRow;k++ ){
                var valid_org_name=document.getElementById('dept_name'+k+'_'+period_id).value;
                if(j!=k){
                    if(org_name.trim()==valid_org_name.trim()){
                        alertify.alert("Please Change Organization Name for"+" "+period_name);
                        return false;
                    }
                }
            }
            var c='';
            var d='';
        }
        var b='';
        var c='';
    }	
	document.getElementById('balance_budget').value=bal_amount;
}
	
function search_budget(){
	window.location=BASE_URL+"/admin/budget_search";		
	}

function select_budget_name(){
	var id=document.getElementById("budget_name_id").value;
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
                                 $(document).ready(function() {
                                     $("#content div").hide(); // Initially hide all content
                                     $("#tabs li:first").attr("id","current"); // Activate first tab
                                     $("#content div:first").fadeIn(); // Show first tab content
                                     $('#tabs a').click(function(e) {
                                         e.preventDefault();
                                         $("#content div").hide(); //Hide all content
                                         $("#tabs li").attr("id",""); //Reset id's
                                         $(this).parent().attr("id","current"); // Activate this
                                         $('#' + $(this).attr('title')).fadeIn(); // Show content for current tab
                                     });
                                 });
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
					document.getElementById('budgetpopup').style.display='block';
					document.getElementById("budgetpopup").innerHTML=xmlhttp.responseText;					
					//popup_text();					
				}
			}
			
			xmlhttp.open("GET",BASE_URL+"/admin/additional_budgetdetails?id="+id+"&period_id="+period_id,true);
			xmlhttp.send(); 
	
	}
	
function additional_details1(id,period_id){
    var items=document.getElementById("item_det"+id+"_"+period_id).value;
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
    }
    else{
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById('budgetpopup').style.display='block';
            document.getElementById("budgetpopup").innerHTML=xmlhttp.responseText;			
            //popup_text();$('#budpopup').modal('hide')
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/additional_budgetdetails1?id="+id+"&period_id="+period_id+"&items="+encodeURIComponent(items),true);
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
function checkbalancebudget(field, rules, i, options){
    var balance_amount1=document.getElementById('balance_budget').value;
    var balance_amount=balance_amount1.replace(/,/g,"");
    var amount1=document.getElementById('budget_amount').value;
    var amount=amount1.replace(/,/g,"");
	//alertify.alert(amount+""+balance_amount);
	
    if(Number(balance_amount)>Number(amount)){ 
        return options.allrules.checkbalancebudget.alertText;
    }
}

function checkbudgetamount(field, rules, i, options){
    var balance_amount1=document.getElementById('balance_budget').value;
    var balance_amount=balance_amount1.replace(/,/g,"");
    var count=document.getElementById('tabcount').value;
	 var amount=document.getElementById('budget_amount').value;
    var a=0;
    for(var i=1;i<=count;i++){
        var period_id=document.getElementById('period_id'+i).value;
		//alert(period_id);
        var period_amounts1=document.getElementById('period_amount1_'+period_id).value;
		//alert(period_amounts1);
        var period_amounts=period_amounts1.replace(/,/g,"");
        a=Number(a)+Number(period_amounts);
    }
    /*if(Number(balance_amount)!='' && Number(balance_amount)!=0.00){
        if(Number(a)>Number(balance_amount)){
        return options.allrules.checkbudgetamount.alertText;
    }
    else{
        for(var i=1;i<=count;i++){
            var period_id=document.getElementById('period_id'+i).value;
            var tb2 = document.getElementById('budget_table_'+i);
            var lastRow1 = tb2.rows.length;
            var lastRow=lastRow1-1;
            var a=0;
            for(var j=1;j<=lastRow;j++){
                var period_amounts11=document.getElementById('period_amount1_'+period_id).value;
                var period_amounts1=period_amounts11.replace(/,/g,"");
                var org_amount1=document.getElementById('dept_amount'+j+'_'+period_id).value;
                var org_amount=org_amount1.replace(/,/g,"");
                a=Number(a)+Number(org_amount);
            }
            if(Number(a)>Number(period_amounts1)){
                if('period_amount1_'+period_id==field.attr('id')){
                    return options.allrules.checkdeptamount.alertText;
                }
            }
        }
    }
}else{*/
   if(Number(a)>Number(amount)){
		return options.allrules.checkbudgetamount.alertText;
	}
    for(var i=1;i<=count;i++){
            var period_id=document.getElementById('period_id'+i).value;
            var tb2 = document.getElementById('budget_table_'+i);
            var lastRow1 = tb2.rows.length;
            var lastRow=lastRow1-1;
            var a=0;
            for(var j=1;j<=lastRow;j++){
                var period_amounts11=document.getElementById('period_amount1_'+period_id).value;
                var period_amounts1=period_amounts11.replace(/,/g,"");
                var org_amount1=document.getElementById('dept_amount'+j+'_'+period_id).value;
                var org_amount=org_amount1.replace(/,/g,"");
                a=Number(a)+Number(org_amount);
            }
            if(Number(a)>Number(period_amounts1)){
                if('period_amount1_'+period_id==field.attr('id')){
                    return options.allrules.checkdeptamount.alertText;
                }
            }
        }
/*}*/
}

function checkitemsamount(field, rules, i, options){    
    var count=document.getElementById('tabcount').value;
    var a='';
    var b='';
    var c='';
    var d='';
    for(var i=1;i<=count;i++){
        var period_id=document.getElementById('period_id'+i).value;
        var period_name=document.getElementById('period_name'+i).value;
        var tb2 = document.getElementById('budget_table_'+i);
        var lastRow1 = tb2.rows.length; 
        var lastRow=lastRow1-1; 
        var period_amounts11=document.getElementById('period_amount1_'+period_id).value;
        var period_amounts1=period_amounts11.replace(/,/g,"");
        for(var j=1;j<=lastRow;j++){
            var org_name=document.getElementById('dept_name'+j+'_'+period_id).value;
            var org_amount1=document.getElementById('dept_amount'+j+'_'+period_id).value;
            var org_amount=org_amount1.replace(/,/g,"");
            var item_amount=document.getElementById('item_det'+j+'_'+period_id).value;
            if(d==''){
                d=Number(org_amount);
            }
            else{
                d=Number(d)+Number(org_amount);
            }
            if(item_amount!=''){
                var aaa=item_amount.split(','); 
                var a_length=aaa.length;
                for(var k=0;k<a_length;k++){
                    var p=aaa[k];
                    var z=p.split('+');
                    var p1=z[1].split('#*');
                    var m1=p1[1];
                    var m=m1.replace(/,/g,"");
                    if(c==''){
                        c=m;
                    }
                    else{
                        c=Number(c)+Number(m);
                    }
                }
                if(Number(c)>Number(d)){
                   if('item_det'+j+'_'+period_id==field.attr('id')){
                        return options.allrules.checkitemsamount.alertText;
                    }
                }
            }
            var c='';
            var d='';
        }
        if(a==''){
            a=Number(period_amounts1);
        }
        else{
            a=Number(a)+Number(period_amounts1);
        }
        var c='';
    }
}


function delete_itemdetails1(){
	var tab = document.getElementById('item_amount_table'); 
        var s=document.getElementById("addusers").value;
        //var flag=0;
        var remove=Array();
        var spli=s.split(",");
        var len=spli.length;
        for(var i=len; i>1; i--){
            k=i;
            var row = tab.rows[k];
            var chkbox = row.cells[0].childNodes[0];
            if(null != chkbox && true == chkbox.checked) { 
                var cc=chkbox.value; 
                var j=k-1;
                spli.splice(j,1);
                tab.deleteRow(k);
                len=spli.length;
            }
        }
        document.getElementById("addusers").value=spli;
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

function add_details(){
    // To fetch Item details from .php page
    var details=itemdetails.split(',');
    var item='';
    for(var i=0;i<details.length;i++){     
        details1=details[i];
        details2=details1.split('*');
        if(item==''){
            item="<option value='"+details2[0]+"'>"+details2[1]+"</option>";
        }
        else{
            item=item+"<option value='"+details2[0]+"'>"+details2[1]+"</option>";
        }
    }
    var adduser=document.getElementById('addusers').value;
    var expl1=adduser.split(',');
    var tbl = document.getElementById('item_amount_table');
    var lastRow = tbl.rows.length;
    for(var i=0;i<expl1.length;i++){
        var x=document.getElementById('item_name_'+expl1[i]).value;
        for(var z=0;z<expl1.length;z++){
            var valid_x=document.getElementById('item_name_'+expl1[z]).value;
            if(i!=z){
                if(x.trim()==valid_x.trim()){
                    alertify.alert("Please Select Different Item Name");
                    return false;
                }
            }
        }
        var y=document.getElementById('total_amount_'+expl1[i]).value;
        if(y==''){
            alertify.alert("Please Enter Amount");
            return false;
        }
    }
    var temp=0;
    for(var i=0;i<expl1.length;i++){
        if(temp<expl1[i]){
            temp=parseInt(expl1[i]);
        }
    }
    lastRow2=parseInt(temp)+1;
    var row = tbl.insertRow(lastRow);
    var cell1= row.insertCell(0);
    var cell2= row.insertCell(1);
    cell1.innerHTML="<input type='checkbox' name='chk_item' id='chk_item_"+lastRow2+"' align='middle'/>";
    var cell3= row.insertCell(2);
    cell2.innerHTML="<input type='hidden' id='auto_item_wise_id_"+lastRow2+"' name='auto_item_wise_id[]' value=''><select name='item_name[]' id='item_name_"+lastRow2+"' class='validate[required] mediumselect'>"+item+"</select>";
    var cell4= row.insertCell(3);
    cell3.innerHTML="<input type='text'  name='total_amount[]' id='total_amount_"+lastRow2+"'  class='validate[required,custom[floating]] mediumtext'/>";
    var hidid=document.getElementById('addusers').value; 
    if(hidid!=''){
        var hidid=hidid+','+lastRow2;
    }
    else{
        var hidid=lastRow2;
    }
    document.getElementById('addusers').value=hidid;
}

function cancel_budget(){
    window.location=BASE_URL+"/admin/budget_search";
}
	
