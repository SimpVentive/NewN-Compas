 $(document).ready(function(){
        $('#org_hierarchy').validationEngine({prettySelect : true,
    useSuffix: "_chosen",validateNonVisibleFields: true, updatePromptsPosition:true});
		var config = {
				'.chosen-select': {}
				}
				for (var selector in config) {
				$(selector).chosen(config[selector]);
				}
 });

 $(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#start_date, #end_date" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	minDate:"",
	maxDate:difDays,
	//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
	//buttonImageOnly: true,
	onSelect: function( selectedDate ) { 
	var option = this.id === "start_date" ? "minDate" : "maxDate",
	instance = $( this ).data( "datepicker" ),
	date = $.datepicker.parseDate(
	instance.settings.dateFormat ||
	$.datepicker._defaults.dateFormat,
	selectedDate, instance.settings );
	dates.not( this ).datepicker( "option", option, date );
	}
	});				   
});
 
 function validate(){
	var hier=document.getElementById('heirarchy_name').value;
        var parent=document.getElementById('parent_org_name').value;
	var tbl = document.getElementById("org_data");
	var lastRow = tbl.rows.length;
	var lastrow1= lastRow+1;
	var hiddtab="inner_hidden_id";
	var ins=document.getElementById(hiddtab).value;
	//var childid=document.getElementById('childids').value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		if(ins1.length>1){
		for( var j=0;j<ins1.length;j++){
			if(parseInt(ins1[j])>parseInt(temp)){
				temp=ins1[j];
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];
			var chars=/^[A-E]+$/i;
			var child_org1='org_list['+i+']';
			var child_org=document.getElementById(child_org1).value;
			if(child_org==''){
				toastr.error("Please Select Organization Name");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var child_org2='org_list['+l+']';
					if(k!=j){
						var ss1=document.getElementById(child_org1).value;
						var ss2=document.getElementById(child_org2).value;
						if(ss1==ss2){
							toastr.error("Child Organization Already Selected");
							return false;
						}
					}
				}
			}
		}
	}
 }
}
function Add_Row(){
        var chk_parent=document.getElementById('parent_org_name').value;
        if(chk_parent==''){
            toastr.error("Please Select Parent Organization");
            return false;
        }
	// var sel_val=document.getElementById('org_list[0]').value;
	// if(sel_val==''){
		// document.getElementById("error_div").innerHTML="<font color='red'>Please select the Value</font>";
		// return false;
	// }
		//document.getElementById('del').style.display='block';
		var tbl = document.getElementById("org_data");
		var lastRow = tbl.rows.length;
		var lastrow1= lastRow+1;
		var hiddtab="inner_hidden_id";
		var ins=document.getElementById(hiddtab).value;
		if(ins!=''){
			var ins1=ins.split(",");
			var temp=0;
			for( var j=0;j<ins1.length;j++){
				if(parseInt(ins1[j])>parseInt(temp)){
					temp=ins1[j];
				}
			}
			var maxa=Math.max(ins1);
			sub_iteration=parseInt(temp)+1;
			for( var j=0;j<ins1.length;j++){
				var i=ins1[j];
				var chars=/^[A-E]+$/i;
				//var child_org1='org_list['+i+']';
			var child_org=document.getElementById('org_list['+i+']').value;
			if(child_org==''){
				toastr.error("Please Select Child Organization Name");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					//var child_org2='org_list['+l+']';
					if(k!=j){
						var ss1=document.getElementById('org_list['+i+']').value;
						var ss2=document.getElementById('org_list['+l+']').value;
						if(ss1==ss2){
							toastr.error("Child Organization Already Selected");
							return false;
						}
					}
				}
			}
			}
		}
		else{
			sub_iteration=1;
			ins1=1;
			var ins1=Array(1);
		}
		//To get the Organization data from .php page
	   // if(orgdata!=''){
       // var orgnam=orgdata.split(',');
       // var organizations='';
       // for(var i=0;i<orgnam.length;i++){
           // orgnam2=orgnam[i].split('*');
           // if(organizations==''){
               // organizations="<option value='"+orgnam2[0]+"'>"+orgnam2[1]+"</option>";
           // }else{
               // organizations=organizations+"<option value='"+orgnam2[0]+"'>"+orgnam2[1]+"</option>";
           // }
       // }
	   // }
	   // else{
	   // organizations='';
	   // }
		
		var xmlhttp;
		var parentorgid=document.getElementById('parent_org_name').value;
		var heirarchyid=document.getElementById('hierarchy_id').value;
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
				$("#org_data").append("<tr id='hier_row_"+sub_iteration+"'><td style='padding-left:15px; width: 55px;'><input type='hidden' name='id[]' id='id["+sub_iteration+"]' value=''><input type='checkbox' name='hier_chk_[]' id='hier_chk_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td style='width: 315px;'><select name='org_list[]' id='org_list["+sub_iteration+"]' style='width:250px;' onchange='getOrg_type("+sub_iteration+")' class='chosen-select'><option value=''>Select</option>"+xmlhttp.responseText+"</select></td><td style='width: 208px;'><div id='input_type["+sub_iteration+"]'></div><input type='hidden' id='hide_values["+sub_iteration+"]' name='hide_values[]' value='' /></td><td style='width: 65px;'><p align='center'><img id='select_child["+sub_iteration+"]' src='"+BASE_URL+"/public/images/up_arrow.png' onclick='upgrade_child()' /></p></td></tr>");
				
				var config = {
				'.chosen-select': {}
				}
				for (var selector in config) {
				$(selector).chosen(config[selector]);
				}
				//document.getElementById("input_type["+id+"]").innerHTML=xmlhttp.responseText;
				//alert_msg();
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/hierarchy_child_orgs?heirarchyid="+heirarchyid+"&parentorgid="+parentorgid,true);
		xmlhttp.send();		
		
		if(document.getElementById(hiddtab).value!=''){
			var ins=document.getElementById(hiddtab).value;
			document.getElementById(hiddtab).value=ins+","+sub_iteration;
		}
		else{
			document.getElementById(hiddtab).value=sub_iteration;
		}
}
function Delete_Row(){
	var ins=document.getElementById('inner_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('org_data');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="hier_chk_"+bb+"";		  
		if(document.getElementById(a).checked){		    
			var b=document.getElementById(a).value;			   
			var c="hier_row_"+b+""; 
			var hiercid=document.getElementById("hierarchy_id").value;
			var hier_orgid=document.getElementById("id["+b+"]").value;
			if(hiercid!=''){
				$.ajax({
					url: BASE_URL+"/admin/delete_hierarchy_orgid",
					global: false,
					type: "POST",
					data: ({hierid : hiercid, orgid : hier_orgid}),
					dataType: "html",
					async:false,
					success: function(msg){
					}
				}).responseText;
			}
			for(var j=(arr1.length-1); j>=0; j--){
				if(arr1[j]==b) {
					arr1.splice(j, 1);
					break;
				}  
			}
			flag++;
			$("#"+c).remove();
		}
	}
	if(flag==0){
		toastr.error("Please select the Value to Delete");
		return false;
	}
	document.getElementById('inner_hidden_id').value=arr1;
}

function check_hierarchy(){
    var hier_id=document.getElementById('heirarchy_name').value;
    if(hier_id==''){
        toastr.error("Please enter Hierarchy Name");
        return false;
    }
}

function getOrg_type(id){
	//document.getElementById("error_div").innerHTML="";
	var org_id=document.getElementById('org_list['+id+']').value;
	if(org_id!=''){
		//toastr.error(id);
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
				document.getElementById("input_type["+id+"]").innerHTML=xmlhttp.responseText;
				//alert_msg();
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/Org_Type?orgid="+org_id,true);
		xmlhttp.send(); 
	}
	else{
		document.getElementById("input_type").innerHTML='';
	}
}
function upgrade_child(){
    toastr.error("You can not make parent as child before creating hierarchy");
    return false;
	 
}
function getchildorgs(){
	var parentid=document.getElementById('parent_org_name').value;
	var heirarchyid=document.getElementById('hierarchy_id').value;
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
			var data=xmlhttp.responseText.split("@_");
			document.getElementById('parent_org').innerHTML=data[0];
			document.getElementById('table_id').innerHTML=data[1];
			var config = {
			'.chosen-select': {}
			}
			for (var selector in config) {
			$(selector).chosen(config[selector]);
			}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/get_childorg?parentid="+parentid+"&heirarchyid="+heirarchyid,true);
	xmlhttp.send(); 
}

function Ajax_upgrade_child(id){
	var hie_id=document.getElementById('hierarchy_id').value;	
	var child_id=document.getElementById("org_list["+id+"]").value;
	if(child_id==''){
		toastr.error("Please select Organization");
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
			var data=xmlhttp.responseText.split("@_");
			document.getElementById('parent_org').innerHTML=data[0];
			document.getElementById('table_id').innerHTML=data[1];
			var config = {
			'.chosen-select': {}
			}
			for (var selector in config) {
			$(selector).chosen(config[selector]);
			}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/Change_parentorg?childid="+child_id+"&hie_id="+hie_id,true);
	xmlhttp.send(); 
}
