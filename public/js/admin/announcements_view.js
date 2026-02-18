	
function addnew(){
	window.location=BASE_URL+"/admin/createannouncements";
    }    

function event_delete(){ 
	var tab = document.getElementById('newtableid'); 
				var s=document.getElementById("addusers").value;
				//var flag=0;
			     var remove=Array();
	              var spli=s.split(","); 
	                 var len=spli.length; 
                      for(var i=len; i>=1; i--){ 
				        k=i; 
				        var row = tab.rows[k]; 
						var chkbox = row.cells[0].childNodes[0];  
                        if(null != chkbox && true == chkbox.checked) {  
				    	var cc=chkbox.value; 
				    	if(cc!=""){
						$.ajax({
							 url: BASE_URL+"/admin/deleteannouncement",
							 global: false,
							 type: "POST",
							 data: ({id : cc}),
							 dataType: "html",
							 async:false,
							 success: function(msg){
							 }
						 }).responseText;
					}
					var j=k-1; 
					spli.splice(j,1);
                    tab.deleteRow(k); 
					len=spli.length;
				
			 }
					  }
		 
		
		 document.getElementById("addusers").value=spli;
	}
	
function viewanniuncement(){
window.location=BASE_URL+"/admin/announcements";
}

function delete_announcement(id,key){
    var id=id; 
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
                 document.getElementById('announ_'+key).style.display='none';
                 //window.location=BASE_URL+"/admin/category";
                        //alertify.alert(xmlhttp.responseText);

                         }
         }
         xmlhttp.open("GET",BASE_URL+"/admin/deleteannouncement?id="+id,true);
         xmlhttp.send();		
}


function annoucement_publish(id){
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('mail_calendar'+id).innerHTML="<img style='height:150px;width:150px;' src='"+BASE_URL+"/public/images/outsell_loading.gif'/>";
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("mail_calendar"+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/annoucementpublish?ano_id="+id,true);
	xmlhttp.send();
			
}

