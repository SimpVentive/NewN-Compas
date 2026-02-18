function assessement_year(){ 
	var ass_id=document.getElementById('ass_year').value;
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
			
			document.getElementById('assessement_name').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessement_year_details?year_id="+ass_id,true);
	xmlhttp.send();	
	
}

function assessment_details(){
	var selMulti = $.map($("#assessement_name option:selected"), function (el, i) {
         return $(el).val();
    });
	var ass_select_ids=selMulti.join(",");
	if(ass_select_ids!=''){
		var ass_year_id=document.getElementById("ass_year").value;
		location.href=BASE_URL+"/admin/assessment_dashboard?year_id="+ass_year_id+"&ass_id="+ass_select_ids;
	}
	
}

function get_organisation_type(){
	
	var year_id=document.getElementById("year_id").value;
	var ass_id=document.getElementById("ass_id").value;
	var org_id=document.getElementById("organization_id").value;
	var grade_id=document.getElementById("grade_id").value;
	var position_id=document.getElementById("position_id").value;
	var location_id=document.getElementById("location_id").value;
	var data="";
	if(org_id!=''){
		data+="&org_id="+org_id;
	}
	if(grade_id!=''){
		data+="&grade_id="+grade_id;
	}
	if(position_id!=''){
		data+="&position_id="+position_id;
	}
	if(location_id!=''){
		data+="&location_id="+location_id;
	}
	location.href=BASE_URL+"/admin/assessment_dashboard?year_id="+year_id+"&ass_id="+ass_id+data;
}

