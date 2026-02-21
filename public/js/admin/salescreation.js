jQuery(document).ready(function(){
	jQuery("#salesform").validationEngine();
}); 

function open_cite(){
    var state_id=document.getElementById('state').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
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
			document.getElementById("cities").innerHTML=xmlhttp.responseText;
			//alertify.alert(xmlhttp.responseText);
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/city_list_vendor?state_id="+state_id,true);
	xmlhttp.send();
    
}

function open_sales_sheet(id){
    var sales_year=document.getElementById('sales_year_'+id).value;
	var sales_id=document.getElementById('sales_id_'+id).value;
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
			var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
			var sheet="";
			if(xmlhttp.responseText!=='null'){
				var myArr = JSON.parse(xmlhttp.responseText);
				for (var i in myArr) {
					
					sheet+="<input type='hidden'  name='sal_budget_id' id='sal_budget_id' class='col-xs-12 col-sm-12' value='"+ myArr[i].sal_budget_id + "'><tr><td><input type='hidden'  name='sales_bud_detail_id[]' id='sales_bud_detail_id' class='col-xs-12 col-sm-12' value='"+ myArr[i].sales_bud_detail_id + "'><input type='hidden'  name='month_id[]' id='month_id' class='col-xs-12 col-sm-12' value='"+ myArr[i].month + "'><input type='text' class='col-xs-12 col-sm-12' value='"+months[myArr[i].month-1] + "' readonly></td><td><input type='text'  name='sales_target[]' id='sales_target' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120' value='"+ myArr[i].sales_target + "'></td><td><input type='text'  name='actual_sales[]' id='actual_sales' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120' value='"+ myArr[i].actual_sales + "'></td></tr>";
				}
			}
			else{
				
				for (var i in months) {
					var aa=i+1;
					sheet+="<input type='hidden'  name='sal_budget_id' id='sal_budget_id' class='col-xs-12 col-sm-12' value=''><tr><td><input type='hidden'  name='sales_bud_detail_id[]' id='sales_bud_detail_id' class='col-xs-12 col-sm-12' value=''><input type='hidden'  name='month_id[]' id='month_id' class='col-xs-12 col-sm-12' value='"+aa+ "'><input type='text' class='col-xs-12 col-sm-12' value='"+months[i]+ "' readonly></td><td><input type='text'  name='sales_target[]' id='sales_target' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120'></td><td><input type='text'  name='actual_sales[]' id='actual_sales' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120'></td></tr>";
				}
			}
			//alert(sheet);
			$("#sales_sheet"+id).html(sheet);
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_sales_emp_data_details?sales_year="+sales_year+"&sales_id="+sales_id,true);
    xmlhttp.send(); 
}