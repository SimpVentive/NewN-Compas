function getcompetencytest(assessment_id){
	var position_id=document.getElementById('ass_position_id').value;
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
			document.getElementById('competencydetails').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/get_position_comeptencies?assessment_id="+assessment_id+"&position_id="+position_id,true);
	xmlhttp.send();
}

function getcompetencyquestion(){
	var comp_def_id=document.getElementById('comp_def_id').value;
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
			document.getElementById('competencybank').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/get_position_comeptency_bank?comp_def_id="+comp_def_id,true);
	xmlhttp.send();
}


function delete_question_test(assessment_test_id,assess_test_id){
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
			document.getElementById('questionbank_count'+assessment_test_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/get_position_question_validation?assessment_test_id="+assessment_test_id+"&assess_test_id="+assess_test_id,true);
	xmlhttp.send();
}

