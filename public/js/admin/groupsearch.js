jQuery(document).ready(function(){
	jQuery("#GroupSearch").validationEngine();
}); 



	
   function searchreasult(){
	var group=document.getElementById('group').value; 
	 //alertify.alert(group);
	var orgname=document.getElementById('orgname').value;
	var emptype=document.getElementById('emptype').value;
	var gpopt=document.getElementById('gpopt').value;
	var grade=document.getElementById('grade').value;
	var loation=document.getElementById('loation').value;
	var xmlhttp;
	  if(group=='' && orgname=='' && emptype=='' &&  gpopt=='' &&  grade=='' && grade=='' && loation==''){
		  alertify.alert("Please select atleast one option ");
		   return false;
		  
		   }
	  
		 if (window.XMLHttpRequest)                
		 {// code for IE7+, Firefox, Chrome, Opera, Safari
		 xmlhttp=new XMLHttpRequest();
		 }		
		  else{// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		 }
		xmlhttp.onreadystatechange=function()                                          
		{                                         
		if (xmlhttp.readyState==4 && xmlhttp.status==200)           
		{ 
		/*$("#dialogform1").dialog({width:600}); 
		$("#dialogform1").dialog('open');*/
		 //alertify.alert(xmlhttp.responseText);
		document.getElementById("tbody").innerHTML=xmlhttp.responseText;
		// document.getElementById('firstrow').style.display="none";                          
		  }
		} 
		 // ?id="+sel+"&id1="+comp_ten
		  xmlhttp.open("GET",BASE_URL+"/admin/group_search_data?group="+group+"&orgname="+orgname+"&emptype="+emptype+"&gpopt="+gpopt+"&grade="+grade+"&loation="+loation,true);
		  xmlhttp.send();
   }
   
    