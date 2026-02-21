//Start of Script for TNA Setup
$(document).ready(function(){
	$('#tna').validationEngine();
	$('#tna_form').validationEngine();
});
function AddRow(){
	var tbl = document.getElementById("role_table");
	var lastRow = tbl.rows.length;
	var lastrow1= lastRow+1;
	var hiddtab="hidden_id";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(parseInt(ins1[j])>parseInt(temp)){
				temp=ins1[j];
			}
		}
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];			
			var role=document.getElementById('role['+i+']').value;
			if(role==''){
				alertify.alert("Please Select Role");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var role1=document.getElementById('role['+l+']').value;
					if(k!=j){
						if(role==role1){
							alertify.alert("Role Already Exists");
							return false;
						}
					}
				}
			}				
		}
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}
	// To fetch Role Names from lms_admin_tna.php page
    if(tnarole!=''){
        var tnarol=tnarole.split(',');
        var tnaroles='';
        for(var i=0;i<tnarol.length;i++){
            tna2=tnarol[i].split('*');
            if(tnaroles==''){
                tnaroles="<option value='"+tna2[0]+"'>"+tna2[1]+"</option>";
            }else{
                tnaroles=tnaroles+"<option value='"+tna2[0]+"'>"+tna2[1]+"</option>";
            }
        }
    }
    else{
      tnaroles='';  
    }
	
	// To fetch Publish Types from lms_admin_tna.php page
    if(tnapub!=''){
        var tnapb=tnapub.split(',');
        var tnapublish='';
        for(var i=0;i<tnapb.length;i++){
            pub2=tnapb[i].split('*');
            if(tnapublish==''){
                tnapublish="<option value='"+pub2[0]+"'>"+pub2[1]+"</option>";
            }else{
                tnapublish=tnapublish+"<option value='"+pub2[0]+"'>"+pub2[1]+"</option>";
            }
        }
    }
    else{
      tnapublish='';  
    }
	
	$("#role_table").append("<tr id='innertable"+sub_iteration+"'><td style='padding-left: 15px;'><input type='checkbox' name='chck' id='chck["+sub_iteration+"]' value="+sub_iteration+" /></td><td><input type='hidden' name='id[]' id='id["+sub_iteration+"]' value='' /><select name='role[]' id='role["+sub_iteration+"]' style='width:160px;' class='validate[required] mediumselect'><option value=''>Select</option>"+tnaroles+"</select></td><td><input type='text' name='stdate[]' id='stdate"+sub_iteration+"' value='' style='width:70%;' class='validate[custom[date2]] mediumtext' onfocus='date_funct(this.id)'></td><td><input type='text' name='enddate[]' id='enddate"+sub_iteration+"' value='' style='width:70%;' class='validate[custom[date2], future[#stdate"+sub_iteration+"]] mediumtext'  onfocus='date_funct(this.id)' /></td><td><select name='pub[]' id='pub' style='width:85%;' class='mediumselect'>"+tnapublish+"</select></td></tr>");
	
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
}
function DeleteRow(){
	var ins=document.getElementById('hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('role_table');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="chck["+bb+"]";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="innertable"+b+"";
			for(var j=(arr1.length-1); j>=0; j--) {
				if(arr1[j]==b) {
					arr1.splice(j, 1);
					break;
				}
				
			}
			flag++;
			$("#"+c).remove();
			/*if(arr1==''){
				document.getElementById('del').style.display='none';
				//document.getElementById('top_del').style.display='none';
			}*/
		}
	}
	if(flag==0){
		alertify.alert("Please select the Value to Delete");
		return false;
	}
	document.getElementById('hidden_id').value=arr1;

}

function AddOrgRow(){
	var tbl = document.getElementById("tna_orgs_tab");
	var lastRow = tbl.rows.length;
	var lastrow1= lastRow+1;
	var hiddtab="tna_hidden_id";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(parseInt(ins1[j])>parseInt(temp)){
				temp=ins1[j];
			}
		}
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];			
			var role=document.getElementById('tna_orgs['+i+']').value;
			if(role==''){
				alertify.alert("Please Select Organization");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var role1=document.getElementById('tna_orgs['+l+']').value;
					if(k!=j){
						if(role==role1){
							alertify.alert("Organization Already Exists");
							return false;
						}
					}
				}
			}				
		}
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}
	// To fetch Role Names from lms_admin_tna.php page
    if(tnaorg!=''){
        var tnaogs=tnaorg.split(',');
        var organizations='';
        for(var i=0;i<tnaogs.length;i++){
            org2=tnaogs[i].split('*');
            if(organizations==''){
                organizations="<option value='"+org2[0]+"'>"+org2[1]+"</option>";
            }else{
                organizations=organizations+"<option value='"+org2[0]+"'>"+org2[1]+"</option>";
            }
        }
    }
    else{
      organizations='';  
    }
	
	
	$("#tna_orgs_tab").append("<tr id='tna_org_row"+sub_iteration+"'><td style='padding-left: 15px;'><input type='checkbox' name='sel_org' id='sel_org["+sub_iteration+"]' value="+sub_iteration+" /></td><td><input type='hidden' name='tna_org_id[]' id='tna_org_id["+sub_iteration+"]' value='' /><select name='tna_orgs[]' id='tna_orgs["+sub_iteration+"]' style='width:200px;' class='chosen-select' onchange='getOrgtypes("+sub_iteration+")'><option value=''>Select</option>"+organizations+"</select></td><td><div id='tna_org_type["+sub_iteration+"]'></div></td></tr>");
	
	var config = {
		'.chosen-select': {}
	}
	for (var selector in config) {
		$(selector).chosen(config[selector]);
	}
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
}
function DeleteOrgRow(){
	var ins=document.getElementById('tna_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('tna_orgs_tab');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="sel_org["+bb+"]";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="tna_org_row"+b+"";
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
	document.getElementById('tna_hidden_id').value=arr1;

}
function getOrgtypes(id){
	var org_id=document.getElementById('tna_orgs['+id+']').value;
	if(org_id!=''){
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
				document.getElementById("tna_org_type["+id+"]").innerHTML=xmlhttp.responseText;				
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/Org_Type?orgid="+org_id,true);
		xmlhttp.send(); 
	}
	else{
		document.getElementById("tna_org_type["+id+"]").innerHTML='';
	}
}
//End of Script for TNA Setup

//Start of Script for TNA Details

$(document).ready(function(){
		 $('#msg_box33').draggable();
});

function CompRow(){
	/*var comp=document.getElementById('group_comp').value;
	if(comp==''){
		alertify.alert("Please select Competency to group programs");
		return false;
	}else{
		alertify.alert("Please save the data for this competency before adding another competency");
		return false;
	}*/
	
	var tbl = document.getElementById("tna_table");
		var lastRow = tbl.rows.length;
		var lastrow1= lastRow+1;
		var hiddtab="inner_hidden_id";
		var ins=document.getElementById(hiddtab).value;
		if(ins!=''){
			var ins1=ins.split(",");
			var temp=0;
			for( var j=0;j<ins1.length;j++){
				if(parseInt(ins1[j])>parseInt(temp)){
					temp=ins1[j];
				}
			}
			var maxa=Math.max(ins1);
			sub_iteration=parseInt(temp)+1;
			for( var j=0;j<ins1.length;j++){
				var i=ins1[j];
				var chars=/^[-a-zA-Z0-9_ ]+$/i;			
			}
		}
		else{
			sub_iteration=1;
			ins1=1;
			var ins1=Array(1);
		}
		
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnacomp!=''){
			var tnacmp=tnacomp.split(',');
			var competencies='';
			for(var i=0;i<tnacmp.length;i++){
				comp2=tnacmp[i].split('*');
				if(competencies==''){
					competencies="<option value='"+comp2[0]+"'>"+comp2[1]+"</option>";
				}else{
					competencies=competencies+"<option value='"+comp2[0]+"'>"+comp2[1]+"</option>";
				}
			}
		}
		else{
		  competencies='';  
		}

		$("#tna_table").append("<tr id='innertable"+sub_iteration+"'><td style='padding-left: 15px;'><input type='radio' name='select_radio' id='select_radio_"+sub_iteration+"' value="+sub_iteration+" onclick='Add_Info("+sub_iteration+")' /></td><td><input type='hidden' name='admin_comp_id["+sub_iteration+"]' id='admin_comp_id["+sub_iteration+"]' value=''><select name='group_comp[]' id='group_comp["+sub_iteration+"]' style='width:180px;' onchange='comp_level("+sub_iteration+")' class='chosen-select'><option value=''>Select</option>"+competencies+"</select></td><td><select name='level[]' id='level["+sub_iteration+"]' style='width:180px;' class='mediumselect'><option value=''>Select</option></select></td></tr>");
		
		var config = {
			'.chosen-select': {}
		}
		for (var selector in config) {
			$(selector).chosen(config[selector]);
		}
		
		if(document.getElementById(hiddtab).value!=''){
			var ins=document.getElementById(hiddtab).value;
			document.getElementById(hiddtab).value=ins+","+sub_iteration;
		}
		else{
			document.getElementById(hiddtab).value=sub_iteration;
		}
		
}
function DelRow(){
	var ins=document.getElementById('inner_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('tna_table');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="select_radio_"+bb+"";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="innertable"+b+"";
			/*var code=document.getElementById("code["+b+"]").value;
			if(code!=""){
				$.ajax({
					   url: BASE_URL+"/admin/deletemastervalue",
					   global: false,
					   type: "POST",
					   data: ({val : code}),
					   dataType: "html",
					   async:false,
					   success: function(msg){
					   }
					   }).responseText;
			}*/
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
	document.getElementById('inner_hidden_id').value=arr1;

}
function AddCompPrgmRow(){
		var hiddtab="hidden_id";
		var ins=document.getElementById(hiddtab).value;
		if(ins!=''){
			var ins1=ins.split(",");
			var temp=0;
			for( var j=0;j<ins1.length;j++){
				if(parseInt(ins1[j])>parseInt(temp)){
					temp=ins1[j];
				}
			}
			var maxa=Math.max(ins1);
			sub_iteration=parseInt(temp)+1;
			for( var j=0;j<ins1.length;j++){
				var i=ins1[j];				
				var catid=document.getElementById('category'+i).value;
				var prgid=document.getElementById('program'+i).value;				
				if(catid=='' || catid=='Select'){
                   alertify.alert("Please Select Category");
                   return false;
				}else{
					if(prgid=='' || prgid=='Select'){
						alertify.alert("Please Select Program");
						return false;
					}
                   for( var k=0;k<ins1.length;k++){
                       l=ins1[k];
                       var catid2=document.getElementById('category'+l+'').value;
                       var prgid2=document.getElementById('program'+l+'').value;                       
                       if(k!=j){                           
                           if(catid==catid2 && prgid==prgid2){
                               alertify.alert("Category with same Program Name Already Exists");
                               return false;
                           }
                       }
                   }
               }
			}
		}
		else{
			sub_iteration=1;
			ins1=1;
			var ins1=Array(1);
		}
		
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnamnth!=''){
			var tnamnt=tnamnth.split(',');
			var months='';
			for(var i=0;i<tnamnt.length;i++){
				mnth2=tnamnt[i].split('*');
				if(months==''){
					months="<option value='"+mnth2[0]+"'>"+mnth2[1]+"</option>";
				}else{
					months=months+"<option value='"+mnth2[0]+"'>"+mnth2[1]+"</option>";
				}
			}
		}
		else{
		  months='';  
		}
		
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnadys!=''){
			var tnadays=tnadys.split(',');
			var days='';
			for(var i=0;i<tnadays.length;i++){
				day2=tnadays[i].split('*');
				if(days==''){
					days="<option value='"+day2[0]+"'>"+day2[1]+"</option>";
				}else{
					days=days+"<option value='"+day2[0]+"'>"+day2[1]+"</option>";
				}
			}
		}
		else{
		  days='';  
		}
		
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnacrict!=''){
			var tnacrit=tnacrict.split(',');
			var criticality='';
			for(var i=0;i<tnacrit.length;i++){
				critic2=tnacrit[i].split('*');
				if(criticality==''){
					criticality="<option value='"+critic2[0]+"'>"+critic2[1]+"</option>";
				}else{
					criticality=criticality+"<option value='"+critic2[0]+"'>"+critic2[1]+"</option>";
				}
			}
		}
		else{
		  criticality='';  
		}
		
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnatrainer!=''){
			var tnatrain=tnatrainer.split(',');
			var trainer_type='';
			for(var i=0;i<tnatrain.length;i++){
				type2=tnatrain[i].split('*');
				if(trainer_type==''){
					trainer_type="<option value='"+type2[0]+"'>"+type2[1]+"</option>";
				}else{
					trainer_type=trainer_type+"<option value='"+type2[0]+"'>"+type2[1]+"</option>";
				}
			}
		}
		else{
		  trainer_type='';  
		}
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnacatgry!=''){
			var tnacat=tnacatgry.split(',');
			var categories='';
			for(var i=0;i<tnacat.length;i++){
				cat2=tnacat[i].split('*');
				if(categories==''){
					categories="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
				}else{
					categories=categories+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
				}
			}
		}
		else{
		  categories='';  
		}
		
		var compval=document.getElementById('competency_id').value;
		var compid=document.getElementById('group_comp['+compval+']').value;
		var levelid=document.getElementById('level['+compval+']').value;
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
				var response=xmlhttp.responseText.split('@_');
				$("#prgm_table").append("<tr id='prg_innertable"+sub_iteration+"'><td style='padding-left:15px;'><input type='checkbox' name='prgm_chk_' id='prgm_chk_"+sub_iteration+"' value="+sub_iteration+" /></td><td><select name='category[]' id='category"+sub_iteration+"' style='width:150px;' class='mediumselect'>"+response[0]+"</select></td><td><select name='program[]' id='program"+sub_iteration+"' style='width:150px;' class='mediumselect'>"+response[1]+"</select></td><td><select name='month[]' id='month"+sub_iteration+"' class='mediumselect'><option value=''>Select Month</option>"+months+"</select></td><td><select name='days[]' id='days"+sub_iteration+"' class='mediumselect' style='width:75px;'><option value=''>Select Days</option>"+days+"</select></td><td><input type='text' name='participants[]' id='participants0' value='' style='width: 50px;' class='mediumtext'></td><td><input type='text' name='budget[]' id='budget0' value='' style='width: 80px;' class='mediumtext'></td><td><select name='trainer_type[]' id='trainer_type"+sub_iteration+"' class='mediumselect'><option value=''>Select Type</option>"+trainer_type+"</select></td><td><input type='text' name='trainer[]' id='trainer0' value='' style='width: 80px;' class='mediumtext'></td><td><select name='criticality[]' id='criticality"+sub_iteration+"' class='mediumselect'><option value=''>Select Criticality</option>"+criticality+"</select></td><td><input type='text' name='comments[]' id='comments0' value='' style='width: 100px;' class='mediumtext'></td><td><input type='hidden' name='hidden_emp_data[]' id='hidden_emp_data["+sub_iteration+"]' value='' /><input type='button' name='emp' id='emp["+sub_iteration+"]' value='Add Employees' onclick='Add_Employee("+sub_iteration+")' class='bigbutton'/><input type='button' name='emp_view' id='emp_view["+sub_iteration+"]' value='View Employees' onclick='View_Employee("+sub_iteration+")' class='bigbutton' style='display:none;'/></td></tr>");
				
				var config = {
					'.chosen-select': {}
				}
				for (var selector in config) {
					$(selector).chosen(config[selector]);
				}
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/additional_info_addrow?levelid="+levelid+"&compid="+compid,true);
		xmlhttp.send();
	
		if(document.getElementById(hiddtab).value!=''){
			var ins=document.getElementById(hiddtab).value;
			document.getElementById(hiddtab).value=ins+","+sub_iteration;
		}
		else{
			document.getElementById(hiddtab).value=sub_iteration;
		}
}
function AddPrgmRow(){
	//document.getElementById('del').style.display='block';
		var tbl = document.getElementById("prgm_table");
		var lastRow = tbl.rows.length;
		var lastrow1= lastRow+1;
		var hiddtab="hidden_id";
		var ins=document.getElementById(hiddtab).value;
		if(ins!=''){
			var ins1=ins.split(",");
			var temp=0;
			for( var j=0;j<ins1.length;j++){
				if(parseInt(ins1[j])>parseInt(temp)){
					temp=ins1[j];
				}
			}
			var maxa=Math.max(ins1);
			sub_iteration=parseInt(temp)+1;
			for( var j=0;j<ins1.length;j++){
				var i=ins1[j];
								
			}
		}
		else{
			sub_iteration=1;
			ins1=1;
			var ins1=Array(1);
		}
		
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnamnth!=''){
			var tnamnt=tnamnth.split(',');
			var months='';
			for(var i=0;i<tnamnt.length;i++){
				mnth2=tnamnt[i].split('*');
				if(months==''){
					months="<option value='"+mnth2[0]+"'>"+mnth2[1]+"</option>";
				}else{
					months=months+"<option value='"+mnth2[0]+"'>"+mnth2[1]+"</option>";
				}
			}
		}
		else{
		  months='';  
		}
		
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnadys!=''){
			var tnadays=tnadys.split(',');
			var days='';
			for(var i=0;i<tnadays.length;i++){
				day2=tnadays[i].split('*');
				if(days==''){
					days="<option value='"+day2[0]+"'>"+day2[1]+"</option>";
				}else{
					days=days+"<option value='"+day2[0]+"'>"+day2[1]+"</option>";
				}
			}
		}
		else{
		  days='';  
		}
		
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnacrict!=''){
			var tnacrit=tnacrict.split(',');
			var criticality='';
			for(var i=0;i<tnacrit.length;i++){
				critic2=tnacrit[i].split('*');
				if(criticality==''){
					criticality="<option value='"+critic2[0]+"'>"+critic2[1]+"</option>";
				}else{
					criticality=criticality+"<option value='"+critic2[0]+"'>"+critic2[1]+"</option>";
				}
			}
		}
		else{
		  criticality='';  
		}
		
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnatrainer!=''){
			var tnatrain=tnatrainer.split(',');
			var trainer_type='';
			for(var i=0;i<tnatrain.length;i++){
				type2=tnatrain[i].split('*');
				if(trainer_type==''){
					trainer_type="<option value='"+type2[0]+"'>"+type2[1]+"</option>";
				}else{
					trainer_type=trainer_type+"<option value='"+type2[0]+"'>"+type2[1]+"</option>";
				}
			}
		}
		else{
		  trainer_type='';  
		}
		// To fetch Publish Types from lms_admin_tna.php page
		if(tnacatgry!=''){
			var tnacat=tnacatgry.split(',');
			var categories='';
			for(var i=0;i<tnacat.length;i++){
				cat2=tnacat[i].split('*');
				if(categories==''){
					categories="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
				}else{
					categories=categories+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
				}
			}
		}
		else{
		  categories='';  
		}
		
		$("#prgm_table").append("<tr id='innertable"+sub_iteration+"'><td style='padding-left:15px;'><input type='checkbox' name='prgm_chk_' id='prgm_chk_"+sub_iteration+"' value="+sub_iteration+" /></td><td><select name='category[]' id='category"+sub_iteration+"' style='width:150px;' class='chosen-select' onchange='getPrograms("+sub_iteration+")'><option value=''>Select </option>"+categories+"</select></td><td><select name='program[]' id='program"+sub_iteration+"' style='width:150px;' class='mediumselect'><option value=''>Select</option></select></td><td><select name='month[]' id='month"+sub_iteration+"' class='mediumselect'><option value=''>Select Month</option>"+months+"</select></td><td><select name='days[]' id='days"+sub_iteration+"' class='mediumselect' style='width:75px;'><option value=''>Select Days</option>"+days+"</select></td><td><input type='text' name='participants[]' id='participants0' value='' style='width: 50px;' class='mediumtext'></td><td><input type='text' name='budget[]' id='budget0' value='' style='width: 80px;' class='mediumtext'></td><td><select name='trainer_type[]' id='trainer_type"+sub_iteration+"' class='mediumselect'><option value=''>Select Type</option>"+trainer_type+"</select></td><td><input type='text' name='trainer[]' id='trainer0' value='' style='width: 80px;' class='mediumtext'></td><td><select name='criticality[]' id='criticality"+sub_iteration+"' class='mediumselect'><option value=''>Select Criticality</option>"+criticality+"</select></td><td><input type='text' name='comments[]' id='comments0' value='' style='width: 100px;' class='mediumtext'></td><td><input type='hidden' name='hidden_emp_data[]' id='hidden_emp_data["+sub_iteration+"]' value='' /><input type='button' name='emp' id='emp["+sub_iteration+"]' value='Add Employees' onclick='Add_Employee("+sub_iteration+")' class='bigbutton'/><input type='button' name='emp_view' id='emp_view["+sub_iteration+"]' value='View Employees' onclick='View_Employee("+sub_iteration+")' class='bigbutton' style='display:none;'/></td></tr>");
				
		var config = {
			'.chosen-select': {}
		}
		for (var selector in config) {
			$(selector).chosen(config[selector]);
		}
	
		if(document.getElementById(hiddtab).value!=''){
			var ins=document.getElementById(hiddtab).value;
			document.getElementById(hiddtab).value=ins+","+sub_iteration;
		}
		else{
			document.getElementById(hiddtab).value=sub_iteration;
		}
}
function DelPrgmRow(){
	var ins=document.getElementById('hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('prgm_table');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="prgm_chk_"+bb+"";		
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="prg_innertable"+b+"";
			for(var j=(arr1.length-1); j>=0; j--){
				if(arr1[j]==b) {
					arr1.splice(j, 1);
					break;
				}
				
			}
			flag++;
			//document.getElementById().style.display='none';
			$("#"+c).remove();
		}
	}
	if(flag==0){
		alertify.alert("Please select the Value to Delete");
		return false;
	}
	document.getElementById('hidden_id').value=arr1;

}
function getPrograms(key){
	var category=document.getElementById('category'+key+'').value;
	if(category!=''){
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
				document.getElementById('program'+key+'').innerHTML=xmlhttp.responseText;				
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/getPrograms?categoryid="+category,true);
		xmlhttp.send();
	}
}
function AddEmpData(){
		var hiddtab="emp_hidden_id";
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
				var chars=/^[-a-zA-Z0-9_ ]+$/i;				
			}
		}
		else{
			sub_iteration=1;
			ins1=1;
			var ins1=Array(1);
		}
		$("#viewdataemp").append("<tr id='emp_innertable"+sub_iteration+"'><td><input type='checkbox' name='check' id='check"+sub_iteration+"' value="+sub_iteration+"></td><td><input id='sel_emp_id["+sub_iteration+"]' type='hidden' value='' name='sel_emp_id'><input type='text' name='emp_number' id='emp_number["+sub_iteration+"]' value='' onchange='fetch_empdata("+sub_iteration+",this)'></td><td><input type='text' name='emp_name' id='emp_name["+sub_iteration+"]' value='' readonly></td><td><input type='text' name='emp_org' id='emp_org["+sub_iteration+"]' value='' readonly style='width:85%;'></td></tr>");
		if(document.getElementById(hiddtab).value!=''){
			var ins=document.getElementById(hiddtab).value;
			document.getElementById(hiddtab).value=ins+","+sub_iteration;
		}
		else{
			document.getElementById(hiddtab).value=sub_iteration;
		}
}

function DelEmpRow(){
	var ins=document.getElementById('emp_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('viewdataemp');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="check"+bb+"";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="emp_innertable"+b+"";
			/*var code=document.getElementById("code["+b+"]").value;
			if(code!=""){
				$.ajax({
					   url: BASE_URL+"/admin/deletemastervalue",
					   global: false,
					   type: "POST",
					   data: ({val : code}),
					   dataType: "html",
					   async:false,
					   success: function(msg){
					   }
					   }).responseText;
			}*/
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
	document.getElementById('emp_hidden_id').value=arr1;

}
function fetch_empdata(num,present){
	value=present.value;
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
			$response=xmlhttp.responseText.split('@');
			if($response[0]!=""){
			//alertify.alert($response[0]);
			//$response=split('@',$res);
			document.getElementById('sel_emp_id['+num+']').value=$response[0];
			document.getElementById('emp_name['+num+']').value=$response[1];
			document.getElementById('emp_org['+num+']').value=$response[2];
			document.getElementById('emp_number['+num+']').readOnly=true;
			}
			else{
				alertify.alert(xmlhttp.responseText);
				document.getElementById('emp_number['+num+']').readOnly=false;
				return false;
			}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/fetch_emp_data?empnum="+value,true);
	xmlhttp.send(); 
}

function Sel_emp_list(){
	var keyid=document.getElementById('key_param').value;
	// var ex_empid=document.getElementById('existing_emps').value;
	// var exempids='';
	// if(ex_empid!=''){
		// var exempids=ex_empid;
	// }
	var hiddtab="emp_hidden_id";
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
		var idds='';
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];	
			var empids='sel_emp_id['+i+']';
			var empp_ids=document.getElementById(empids).value;			
			if(idds==''){
				
					idds='0_'+empp_ids;
				
			}
			else{
				idds=idds+",0_"+empp_ids;
			}
			
		}
	}
	$('.lightbox_bg').hide();
	document.getElementById('msg_box33').style.display='none';
	document.getElementById('hidden_emp_data['+keyid+']').value=idds;
	document.getElementById('emp['+keyid+']').style.display='none';
	document.getElementById('emp_view['+keyid+']').style.display='block';
}
$(document).ready(function(){
	if(status=='competency'){
		document.getElementById('select_radio_0').checked=true;
		 Add_Info_view(0);
	 }
});

function Add_Info_view(id){
	var tnaid=document.getElementById('year').value;	
	var tnaadminid=document.getElementById('tna_admin_id').value;	
	var autocompid=document.getElementById('admin_comp_id['+id+']').value;	
	var compid=document.getElementById('group_comp['+id+']').value;
	var levelid=document.getElementById('level['+id+']').value;
	
	if(compid==''){
		alertify.alert("Please select Competency");
		document.getElementById('select_radio_'+id+'').checked=false;
		return false;
	}
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
			document.getElementById("programs_div").innerHTML=xmlhttp.responseText;
			document.getElementById('competency_id').value=id;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/additional_info_view?levelid="+levelid+"&compid="+compid+"&tna_admin_id="+tnaadminid+"&autocompid="+autocompid+"&tna_id="+tnaid,true);
	xmlhttp.send(); 
}
function cancel_group(){
	document.getElementById('group_comp').style.display='none';
}
function comp_level(id){
	var compid=document.getElementById('group_comp['+id+']').value;
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
			document.getElementById("level["+id+"]").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/comp_level?compid="+compid,true);
	xmlhttp.send(); 
}
function Child_Org(){
	var tnayear=document.getElementById('year').value;
	if(tnayear==''){
		alertify.alert("Please Select Year");
		document.getElementById('org_chosen').value='';
		return false;
	}
	var orgid=document.getElementById('org').value;
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
			document.getElementById("child_org").innerHTML="<option value=''>Select</option>"+xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/child_org_data?orgid="+orgid,true);
	xmlhttp.send(); 
}
function Add_Employee(keyid){
	var orgid=document.getElementById('org').value;
	var childorgid=document.getElementById('child_org').value;
	document.getElementById('msg_box33').style.display='block';
	var empids=document.getElementById('hidden_emp_data['+keyid+']').value;
	if(empids!=''){
		employeeids=empids;
	}else{
		employeeids='';
	}
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
			//var n=xmlhttp.responseText.split(","); 
		//document.getElementById("listofvalues").innerHTML=n[0];
		//if(n[1]==1){
		//alertify.alert(xmlhttp.responseText);
			document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
			alert_msg('msg_box33');
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/employee_list?key_val="+keyid+"&employee_ids="+employeeids+"&orgid="+orgid+"&childid="+childorgid,true);
	xmlhttp.send(); 

}
function View_Employee(keyid){
	document.getElementById('msg_box33').style.display='block';
	var emp_ids=document.getElementById('hidden_emp_data['+keyid+']').value;
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
			//var n=xmlhttp.responseText.split(","); 
		//document.getElementById("listofvalues").innerHTML=n[0];
		//if(n[1]==1){
			document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
			alert_msg('msg_box33');
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/view_tnaemployee_list?key_val="+keyid+"&empid="+emp_ids,true);
	xmlhttp.send(); 

}
function view_emp_list(){
	document.getElementById('main_table_div').style.display='block';
	document.getElementById('viewdataemp_div').style.display='none';
}
function emp_list(cnt){
	var emp='';
	for(var i=0;i<=cnt;i++){alertify.alert(i);
		var checkid=document.getElementById('check['+i+']');
		if(checkid.checked==true){
			var empid=checkid.value;
			//var empid=document.getElementById('emp_id['+i+']').value;
			if(emp==''){
				emp=empid;
			}
			else{
				emp=emp+","+empid;
			}			
		}
		
	}
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
			document.getElementById('viewdataemp_div').style.display='block';
			document.getElementById("viewdataemp_div").innerHTML=xmlhttp.responseText;
			//alert_msg();
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/selected_emp_list?empids="+emp,true);
	xmlhttp.send();
	document.getElementById('main_table_div').style.display='none';
}
function checkAll(){ 
	var tbl = document.getElementById('inner_data_emp');
	var lastRow = tbl.rows.length;
	if(lastRow>1){
		for(var i=0; i<=lastRow; i++){
			var row = tbl.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(document.getElementById('maincheck').checked==true){
				if(chkbox.disabled==false){
					chkbox.checked = true ;
				}
			}
			else{
				if(chkbox.disabled==false){
					chkbox.checked = false ;
				}
			}
		}
	}
	//checkvalu();
}
function check_tnayear(){
	var tnayear=document.getElementById('year').value;
	if(tnayear==''){
		alertify.alert("Please Select TNA Name");
		return false;
	}
}
function  popup_box(id){
	$('#comments_div')
		.bind('dragstart',function( event ){alertify.alert("sdgsdag");
			if ( !$(event.target).is('.popup_header') ) return false;
			$( this ).addClass('active');
			})
		.bind('drag',function( event ){
			$( this ).css({
				top: event.offsetY,
				left: event.offsetX
				});
			})
		.bind('dragend',function( event ){
			$( this ).removeClass('active');
			});
	document.getElementById('comments_div').style.display='block';
	var comtext=document.getElementById('comments'+id+'').value;
	alert_msg('comments_div');
	document.getElementById('godiv').innerHTML="<input type='button' name='done_comm' id='done_comm' class='bigbutton' value='Done' onclick='capture_comm("+id+")'>";
	document.getElementById('text_id').value=comtext;	
}
function  capture_comm(id){
	var comment=document.getElementById('text_id').value;
	document.getElementById('comments'+id+'').value=comment;
	$('.lightbox_bg').hide();
	document.getElementById('comments_div').style.display='none';
}
function getTnaDetails(){
	var tnaid=document.getElementById('year').value;
	// var tnadiv=document.getElementById('competency_based').value;
	// if(tnadiv!=''){
		// var cnfrm=window.confirm("Do you want to save the data");
		// if(cnfrm){
		// }else{
			// return false;
		// }
	// }
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
			document.getElementById("competency_based").innerHTML=xmlhttp.responseText;
			var config = {
			'.chosen-select': {}
			}
			for (var selector in config) {
				$(selector).chosen(config[selector]);
			}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/tna_details_type?tnaid="+tnaid,true);
	xmlhttp.send();
}
function check_basedon(){
	var comp=document.getElementById('competency').checked;
	var non_comp=document.getElementById('organization').checked;
	if(comp==true){
		var type='comp';
	}
	else if(non_comp==true){
		var type='noncomp';
	}
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
			document.getElementById("competency_based").innerHTML=xmlhttp.responseText;
			var config = {
			'.chosen-select': {}
			}
			for (var selector in config) {
				$(selector).chosen(config[selector]);
			}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/tna_programs?comptype="+type,true);
	xmlhttp.send();
}
function alert_msg(divid){
	$(document).ready(function(){
							   var lclose = $("<a class='lightbox_close_rel'>Close This</a>");
							   $('#'+divid+'').append(lclose);
							   var myval = ""+divid+"";
							   var moniter_wdith = screen.width;
							   var moniter_height = screen.height;
							   var lightboxinfo_wdith = $("#" + myval).width();	
							   var lightboxinfo_height= $("#" + myval).height();
							   var remain_wdith =  moniter_wdith - lightboxinfo_wdith;		
							   var remain_height =  moniter_height - lightboxinfo_height;		
							   var byremain_wdith = remain_wdith/2;
							   var byremain_height = remain_height/2;
							   var byremain_height2 = byremain_height-10;
							   $("#" + myval).css({left:byremain_wdith});
							   $("#" + myval).css({top:byremain_height2});
							   $('.lightbox_bg').show();
							   //$('#header_div').draggable();
							   $("#" + myval+' .lightbox_close_rel').add();
							   $("#" + myval).animate({
													  opacity: 1,
													  left: "420px",
													  top: "180px"
													  }, 10);
							   });
	$('a.lightbox_close_rel').click(function(){
											 var myval2 =$(this).parent().attr('id');
											 $("#" + myval2).animate({
																	 opacity: 0,
																	 top: "-1200px"
																	 },0,
																	 function(){
																		 $('.lightbox_bg').hide()
																	 });
											 });											 
		  
}
//End of Script for TNA Details