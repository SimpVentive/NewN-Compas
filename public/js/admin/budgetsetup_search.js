
function create_budget_setup(){
	window.location=BASE_URL+"/admin/budget_setup";	
	}

function search_budgetsetup(){
	var name=document.getElementById('bud_name').value;
	var status=document.getElementById('status').value;
	var type=document.getElementById('bud_type').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('search').style.display='block';
			document.getElementById('search').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/search_bud_setup?name="+name+"&status="+status+"&type="+type,true);
	xmlhttp.send(); 
}

function delete_period(budget_id){
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
			 document.getElementById('budgetrow_'+budget_id).style.display='none';
				 }
		 }
		 xmlhttp.open("GET",BASE_URL+"/admin/delete_setup_budget?budget_id="+budget_id,true);
		 xmlhttp.send();	
}

function update_period(budget_id){
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
				 }
		 }
		 xmlhttp.open("GET",BASE_URL+"/admin/update_setup_budget?budget_id="+budget_id,true);
		 xmlhttp.send();	
}