

jQuery(document).ready(function(){
	jQuery("#certificationForm").validationEngine();
});
function getevents(){
    var prog=document.getElementById('progname').value;
    if(prog==''){ 
	 document.getElementById("searchresult").innerHTML="<table class='table table-striped table-bordered table-hover' id='newtableid'><thead> <tr><th>Employee Number</th><th> Employee Name</th><th>Event Name</th><th>Start Date</th><th>End Date</th><th>View Report</th></tr></thead> <tbody><tr><td colspan='6'>&emsp; No data found.</td></tr></tbody></table>";
	 document.getElementById('pagination1').style.display="none";
	 document.getElementById('pagination2').style.display="none";
	 document.getElementById('eveid').innerHTML="<option value=''>Select</option></select>";
	    }
	else {	
      var xmlhttp;
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
                    {  // alertify.alert(xmlhttp.responseText);
                      document.getElementById("eveid").innerHTML=xmlhttp.responseText;
                                        
                      }
                    } 
		 // ?id="+sel+"&id1="+comp_ten
		  xmlhttp.open("GET",BASE_URL+"/admin/getevents?pid="+prog,true);
		  xmlhttp.send();    
      }
  }

function resetdata(){
    
    window.location=BASE_URL+"/admin/certification";
}
function getsearchdata(){
     var prog=document.getElementById('progname').value;
     var evdid=document.getElementById('eveid').value;
   //  var empnum=document.getElementById('enumber').value;
   
    if(prog==''){
        alertify.alert('Please select Program ');
        return false;
      }
    else {
             var xmlhttp;
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
		  document.getElementById("searchresult").innerHTML=xmlhttp.responseText;
                 // document.getElementById("eveidrow").style.display='block';
		   // document.getElementById('firstrow').style.display="none";                          
		  }
		} 
		 // ?id="+sel+"&id1="+comp_ten
		  xmlhttp.open("GET",BASE_URL+"/admin/getsearemps?pid="+prog+"&eveid="+evdid,true);
		  xmlhttp.send();    
      }
        
  }