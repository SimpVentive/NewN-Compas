jQuery(document).ready(function(){
	jQuery("#budget_period_edit").validationEngine();	
	
});
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
    var valid=$('#item_pop_up').validationEngine('validate');
    if(valid==false){
        $('#item_pop_up').validationEngine();
    }
    else{
	var tbl = document.getElementById('item_amount_table');
	var lastRow = tbl.rows.length; 
	var lastRow1=lastRow-1;
        var adduser=document.getElementById('addusers').value;
        var expl1=adduser.split(',');
	var p='';
	var m='';
	var n='';
        var c='';
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
		var y=document.getElementById('total_amount_'+t).value; 
		if(y==''){
			alertify.alert("Please Enter Amount");
			return false;
		}
		if(document.getElementById('auto_item_wise_id_'+t).value!=''){
		var u=document.getElementById('auto_item_wise_id_'+t).value;
		}
		else{
			var u=0;
		}
		if(p=='' && m==''){
			p=u+'+'+x+'#*'+parseFloat(y.replace(/,/g, ''));
		}
		else{
			p=p+','+u+'+'+x+'#*'+parseFloat(y.replace(/,/g, ''));
		}
		if(n==''){
			n=u;
		}
		else{
			n=n+','+u;
		}
                if(c==''){
                    c=parseFloat(y.replace(/,/g, ''));
                }
                else{
                    c=parseFloat(c)+parseFloat(y.replace(/,/g, ''));
                }
		document.getElementById("itemdetails_"+period_id+"_"+id).innerHTML="<input type='hidden' name='auto_item_wise_id"+period_id+"[]' id='auto_item_wise_id_"+id+"_"+period_id+"' value="+n+"><input class='validate[funcCall[checkitemsamount]]' style='color:#FFFFFF;border:0px;height:0px;width:0px;' type='text' name='item_det"+period_id+"[]' id='item_det"+id+"_"+period_id+"' value="+p+">";
                document.getElementById("tot_amount_"+period_id+"_"+id).innerHTML="Total Item Amount:&emsp;"+parseFloat(c)+"";
	}
	document.getElementById("budgetAddpopup").style.display='none';
	/* $('#budgetpopup').modal({
		data-dismiss: true
	}); */
	//$('.lightbox_bg').hide();
    }
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
		cell3.innerHTML="<input type='text' name='participants1[]' id='participants"+lastRow1+"_"+id+"' class='validate[maxSize[5]] smalltext'>";
		var cell4= row.insertCell(3);
		cell4.innerHTML="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><a onClick='additional_details("+lastRow1+")' style='font-size:12px;color:#03C;'>Details</a></u><div id='itemdetails_"+lastRow1+"'><input type='hidden' id='auto_item_wise_id_1' name='auto_item_wise_id[]' value=''><input type='hidden' name='auto_item_id"+id+"[]' id='auto_item_id"+id+"' value=''/><input class='validate[funcCall[checkitemsamount]]' style='color:#FFFFFF;border:0px;height:0px;width:0px;' type='text' name='item_det"+id+"[]' id='item_det' value=''/></div>";		
		var cell5= row.insertCell(4);
	}
	
function add_depart1(id,bud_id,period_id){
    var tb2 = document.getElementById('budget_table_'+id);
    var adduser=document.getElementById('org_addusers_'+id).value;
    adduser=$.trim(adduser); 
    if(adduser!=""){
    var expl1=adduser.split(',');
        if(expl1.length>=1){
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
    }
}
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
                        cell1.innerHTML="<input type='checkbox' name='org_chk_"+period_id+"[]' id='org_chk_"+lastRow1+"_"+period_id+"' value=''>";
			var cell2= row.insertCell(1); 
			cell2.innerHTML="<input type='hidden' name='auto_dept_id"+period_id+"[]' id='auto_dept_id"+period_id+"' value=''/><select name='dept_name"+period_id+"[]' id='dept_name"+lastRow1+"_"+period_id+"' class='validate[required] mediumselect'><option value=''>Select</option>"+xmlhttp.responseText+"</select>";
			var cell3= row.insertCell(2);
			cell3.innerHTML="<input type='text' name='dept_amount"+period_id+"[]' id='dept_amount"+lastRow1+"_"+period_id+"' value='' class='validate[required,minSize[2],maxSize[17]] mediumtext'>";
			var cell4= row.insertCell(3);
			cell4.innerHTML="<input type='text' name='participants"+period_id+"[]' id='participants"+lastRow1+"_"+period_id+"' onkeyup='jm_phonemask(this)' class='validate[maxSize[10]] smalltext'>";
			var cell5= row.insertCell(4);
			cell5.innerHTML="&emsp;<u><a onClick='additional_details("+lastRow1+","+period_id+")' style='color:#03C; cursor: pointer;' href='#budgetpopup' role='button'  data-toggle='modal'>Details</a></u>&emsp;&emsp;&nbsp;Total item Amount:0<div id='itemdetails_"+period_id+"_"+lastRow1+"'><input type='hidden' id='auto_item_wise_id_1' name='auto_item_wise_id[]' value=''><input type='hidden' name='auto_item_id"+period_id+"[]' id='auto_item_id"+period_id+"' value=''/><input type='text' class='validate[funcCall[checkitemsamount]]' style='color:#FFFFFF;border:0px;height:0px;width:0px;' name='item_det"+period_id+"[]' id='item_det"+lastRow1+"_"+period_id+"' value=''/></div><label id='tot_amount_"+period_id+"_"+lastRow1+"'></label>";
			var cell6= row.insertCell(5); 
                        var hidid=document.getElementById('org_addusers_'+id).value; 
                        if(hidid!=''){
                            var hidid=hidid+','+lastRow1;
                        }
                        else{
                            var hidid=lastRow1;
                        }
                        document.getElementById('org_addusers_'+id).value=hidid;
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/retrive_butype_name?budget_id="+budget_id,true);
		xmlhttp.send();
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
				 }
		 }
		 xmlhttp.open("GET",BASE_URL+"/admin/budgeting_type?budget_id="+id,true);
		 xmlhttp.send();	
}

function additional_details(id,period_id){
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
            document.getElementById('budgetAddpopup').style.display='block';
            document.getElementById("budgetAddpopup").innerHTML=xmlhttp.responseText;
           // popup_text();
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/additional_budgetdetails_up?id="+id+"&period_id="+period_id+"&items="+encodeURIComponent(items),true);
    xmlhttp.send();
}
	
function additional_details_update(id,period_id,dept_id){
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
            document.getElementById("budgetAddpopup").style.display='block';
            document.getElementById("budgetAddpopup").innerHTML=xmlhttp.responseText;
            //popup_text();
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/additional_budgetdetails_update?id="+id+"&dept_id="+dept_id+"&period_id="+period_id+"&items="+encodeURIComponent(items),true);
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

function checkbalancebudget(field, rules, i, options){
    var balance_amount=field.val();
    var amount=document.getElementById('budget_amount').value;
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
        var period_amounts1=document.getElementById('period_amount1_'+period_id).value;
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
}
else{*/
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
                        c=Number(m);
                    }
                    else{
                        c=Number(c)+Number(m);
                    }
                }
                if(Number(c)>Number(d)){
                   //if('item_det'+j+'_'+period_id==field.attr('id')){
                        return options.allrules.checkitemsamount.alertText;
                    //}
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

function validation(key){
    for(var i=1;i<=key;i++){
        var period_id=document.getElementById('period_id'+i).value;
        var period_name=document.getElementById('period_name'+i).value; 
        var tb2 = document.getElementById('budget_table_'+i);
        var lastRow1 = tb2.rows.length; 
        var lastRow=lastRow1-1; 
        var period_amounts1=document.getElementById('period_amount1_'+period_id).value;	
        for(var j=1;j<=lastRow;j++){
            var org_name=document.getElementById('dept_name'+j+'_'+period_id).value;
            for(k=1;k<=lastRow;k++ ){
                var valid_org_name=document.getElementById('dept_name'+k+'_'+period_id).value;
                if(j!=k){
                    if(org_name.trim()==valid_org_name.trim()){
                        alertify.alert("Please Change Organization Name for"+" "+period_name+",before continuing");
                        return false;
                    }
                }
            }
        }
    }
}

function jm_phonemask(t){
    var patt1 = /(\d{3}).*(\d{3}).*(\d{4})/;
    var patt2 = /^\((\d{3})\).(\d{3})-(\d{4})$/;
    var str = t.value;
    var result;
    if (!str.match(patt2)){
        result = str.match(patt1);
        if (result!= null){
            
        }
        else{
            if (t.value.match(/[^\d]/gi))
                t.value = t.value.replace(/[^\d]/gi,'');
        }
    }
}

function delete_itemdetails1(){
    var tab = document.getElementById('item_amount_table'); 
    var s=document.getElementById("addusers").value;
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

function delete_itemdetails1_update(){
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
				    	if(cc!=""){
						$.ajax({
							 url: BASE_URL+"/admin/deleteitem",
							 global: false,
							 type: "POST",
							 data: ({id : cc}),
							 dataType: "html",
							 async:false,
							 success: function(msg){
							 }
						 }).responseText;
					}
					var j=k-1; 
					spli.splice(j,1);
                    tab.deleteRow(k); 
					len=spli.length;
				
			 }
					  }
		 
		
		 document.getElementById("addusers").value=spli;

}

function delete_depart1(key,id,period_id){
		var tab = document.getElementById('budget_table_'+key);
                var s=document.getElementById('org_addusers_'+key).value;
                var remove=Array();
                var spli=s.split(",");
                var leng=spli.length;
                var len=leng;
                for(var i=len; i>=1; i--){
                    k=i;
                    var row = tab.rows[k];
                    var chkbox = row.cells[0].childNodes[0];
                    if(null != chkbox && true == chkbox.checked) { 
                        var cc=chkbox.value;
                        if(cc!=""){
                            $.ajax({
                                url: BASE_URL+"/admin/delete_budget_organization",
                                global: false,
                                type: "POST",
                                data: ({id : cc}),
                                dataType: "html",
                                async:false,
                                success: function(msg){
                                    
                                }
                            }).responseText;
                        }
                        var j=k-1;
                        spli.splice(j,1);
                        tab.deleteRow(k);
                        len=spli.length;
                    }
                }
                document.getElementById('org_addusers_'+key).value=spli;
 }
 
 function delete_depart(key,id,period_id){
     var tab = document.getElementById('budget_table_'+key);
     var s=document.getElementById('org_addusers_'+key).value;
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
     document.getElementById('org_addusers_'+key).value=spli;
 }

function cancel_bud_update(){
    window.location=BASE_URL+"/admin/budget_search";
}