jQuery(document).ready(function(){
	jQuery("#event_restrictionform").validationEngine();	
});

function getevents(){ 
	var program=document.getElementById('program').value;
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
			document.getElementById('eventdiv').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/getprgevents?id="+program,true);
	xmlhttp.send();	
}

function getbus(){ 
	var program=$('#location').val();//document.getElementById('location').value;
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
			document.getElementById('busdiv').innerHTML=xmlhttp.responseText;
			document.getElementById('adminsdiv').innerHTML="<select id='admins' name='admins[]' multiple class='validate[required] input-xlarge'></select>";
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/getbus?id="+program,true);
	xmlhttp.send();	
}

function getadmins(){
	var loc=$('#location').val();
	var program=$('#bus').val();//document.getElementById('bus').value;
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
			document.getElementById('adminsdiv').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/getadminbus?loc="+loc+"&id="+program,true);
	xmlhttp.send();	
}