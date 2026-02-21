function create_calendar(){
	window.location=BASE_URL+"/admin/calender";
}

function open_button(id){
	var check_id=id.value;
	if(id.checked == false){
		$("#active"+check_id).attr("disabled", "disabled");
	}
	else {
		$('#active'+check_id).removeAttr('disabled');
	} 
}

function open_source_id(id){
    var s_id=document.getElementById('source_type'+id).value;
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
            document.getElementById('source_id'+id).innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/calendar_source_type?s_id="+s_id,true);
    xmlhttp.send(); 
}
    
function search_calender(){
    var cal_name=document.getElementById('cal_name').value;
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
    xmlhttp.open("GET",BASE_URL+"/admin/search_calender?cal_name="+cal_name,true);
    xmlhttp.send(); 
}

function calender_dlete(calendar_id){
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
                if (xmlhttp.readyState==4 && xmlhttp.status==200){//alertify.alert(xmlhttp.responseText);
                    document.getElementById('calendar_'+calendar_id).style.display='none';
                }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/calender_details_delete?calendar_id="+calendar_id,true);
        xmlhttp.send();	
}

function addsource_details(){
	var hiddtab="addgroup";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=ins1[j];
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j]; 
			var code=document.getElementById('source_type'+i).value;
			var name=document.getElementById('source_id'+i).value;
			var des=document.getElementById('status'+i).value;
			if(code==''){
				alertify.alert("Please select source type.");
				return false;
			}
			if(name==''){
				alertify.alert("Please select source id.");
				return false;
			}
			if(des==''){
				alertify.alert("Please select status.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var name1=document.getElementById('source_id'+l).value;
				if(k!=j){
					if(name==name1){
						alertify.alert("Source Id should be Unique");
						return false;
					}
				}
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}	
    
	if(sourcetype_details!=''){
        var source_details=sourcetype_details.split(',');
        var source_ids='';
        for(var i=0;i<source_details.length;i++){
            source1=source_details[i];
            source2=source1.split('*');
            if(source_ids==''){
                source_ids="<option value='"+source2[0]+"'>"+source2[1]+"</option>";
            }else{
                source_ids=source_ids+"<option value='"+source2[0]+"'>"+source2[1]+"</option>";
            }
        }
    }else{
        source_ids='';
    }
	if(status_details!=''){
        var status_detail=status_details.split(',');
        var status_ids='';
        for(var i=0;i<status_detail.length;i++){
            status1=status_detail[i];
            status2=status1.split('*');
            if(status_ids==''){
                status_ids="<option value='"+status2[0]+"'>"+status2[1]+"</option>";
            }else{
                status_ids=status_ids+"<option value='"+status2[0]+"'>"+status2[1]+"</option>";
            }
        }
    }else{
        status_ids='';
    }
	$("#source_table").append("<tr id='subgrd"+sub_iteration+"'><td><input  type='checkbox' name='chkbox[]' id='chkbox"+sub_iteration+"'  value='"+sub_iteration+"' /><input type='hidden' id='calendar_act_id"+sub_iteration+"' name='calendar_act_id[]' value=''></td><td><select name='source_type[]' id='source_type"+sub_iteration+"' class='input-large' onchange='open_source_id("+sub_iteration+");'><option value=''>Select</option>"+source_ids+"</select></td><td><select name='source_id[]' id='source_id"+sub_iteration+"'  class='input-large'><option value=''>Select</option></select></td><td><select name='status[]' id='status"+sub_iteration+"' class='input-large'><option value=''>Select</option>"+status_ids+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
}

function activation_validation(){
	var hiddtab="addgroup";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=ins1[j];
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j]; 
			var code=document.getElementById('source_type'+i).value;
			var name=document.getElementById('source_id'+i).value;
			var des=document.getElementById('status'+i).value;
			if(code==''){
				alertify.alert("Please select source type.");
				return false;
			}
			if(name==''){
				alertify.alert("Please select source id.");
				return false;
			}
			if(des==''){
				alertify.alert("Please select status.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var name1=document.getElementById('source_id'+l).value;
				if(k!=j){
					if(name==name1){
						alertify.alert("Source Id should be Unique");
						return false;
					}
				}
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
}

function delete_sourcedetails(){
	var hiddtab="addgroup";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('source_table');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="chkbox"+bb+"";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd"+b+"";
			alert(b);
			var calendar_act_id=document.getElementById("calendar_act_id"+b+"").value;
			alert(calendar_act_id);
			if(calendar_act_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_emp_activation",
					global: false,
					type: "POST",
					data: ({val : calendar_act_id}),
					dataType: "html",
					async:false,
					success: function(msg){
					}
				}).responseText;
			} 
			for(var j=(arr1.length-1); j>=0; j--) {
				if(arr1[j]==b) {
					arr1.splice(j, 1);
					break;
				}  
			}
			flag++;
			$("#"+c).remove();
		}
	}
	if(flag==0){
		alertify.alert("Please select the Value to Delete");
		return false;
	}
	document.getElementById(hiddtab).value=arr1;
}