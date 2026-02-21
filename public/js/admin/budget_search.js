function create_budget(){
	window.location=BASE_URL+"/admin/budget";	
	}
	
function search_budgeting(){
	var name=document.getElementById('bud_name').value;
	//alertify.alert(id);
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
			document.getElementById('search1').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/search_budgeting?name="+name,true);
	xmlhttp.send();
}

function budget_search(){
	window.location=BASE_URL+"/admin/budget_search";	
}