jQuery(document).ready(function(){
	jQuery("#reportForm").validationEngine({validateNonVisibleFields: true, updatePromptsPosition:true});
});
function open_level(){ 
	var comp_def_id=document.getElementById('comp_def_id').value;
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
			
			document.getElementById('scale_details').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/training_scale_details?comp_def_id="+comp_def_id,true);
	xmlhttp.send();	
	
}

function assessment_details(){
	var scale_id=document.getElementById("scale_id").value;
	if(scale_id!=''){
		var comp_def_id=document.getElementById("comp_def_id").value;
		location.href=BASE_URL+"/admin/employee_training_need_report?comp_def_id="+comp_def_id+"&scale_id="+scale_id;
	}
	
}

function get_employee_details(comp_id,scale_id,ele_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Employee Details";
	document.getElementById("followdes").innerHTML ="Following are the Employee Details";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_training_employee_details?comp_id="+comp_id+"&scale_id="+scale_id+"&ele_id="+ele_id, true);
	xmlhttp.send();
}

