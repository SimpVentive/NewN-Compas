function open_zones(){    
     var zone_id=document.getElementById('zones').value;
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
             $('#states').html(xmlhttp.responseText);
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/zone_states_tna?zone_id="+zone_id,true);
     xmlhttp.send();
}

function open_location_state(){  
	var zone_id=document.getElementById('zones').value;
     var state_id=document.getElementById('states').value;
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
             $('#location').html(xmlhttp.responseText);
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/states_emp_tna?zone_id="+zone_id+"&state_id="+state_id,true);
     xmlhttp.send();
}