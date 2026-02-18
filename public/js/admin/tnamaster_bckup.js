//Start of Script for TNA Setup
$(document).ready(function(){
	$('#tna').validationEngine();
	$('#tna_form').validationEngine();
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });	
});
$(document).ready(function(){
	$('#tna_empees').modal({
		show: false,
		backdrop: 'static',
		keyboard: false  // to prevent closing with Esc button (if you want this too)
	});	
});
$(document).ready(function(){
	var catdatadiv=$('#catdiv').height();
	if(catdatadiv>=200){
		$('#catdiv').css('height',catdatadiv+'px');
		$('#catdiv').css('overflow','auto');
	}
	$('#tna_orgs_0__chosen').css('width','70%');	
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#approved_date" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	minDate:"",
	maxDate:difDays
	});				   
});
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#year_stdate, #year_enddate" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	minDate:"",
	maxDate:difDays,
	//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
	//buttonImageOnly: true,
	onSelect: function( selectedDate ) { 
	var option = this.id === "year_stdate" ? "minDate" : "maxDate",
	instance = $( this ).data( "datepicker" ),
	date = $.datepicker.parseDate(
	instance.settings.dateFormat ||
	$.datepicker._defaults.dateFormat,
	selectedDate, instance.settings );
	dates.not( this ).datepicker( "option", option, date );
	}
	});				   
});

function validate_tna(){
	var tna_stdate=document.getElementById('year_stdate').value;
	var tna_enddate=document.getElementById('year_enddate').value;
	if(tna_stdate=='' && tna_enddate!=''){
		alertify.alert("End date can not be given without giving the start date");
		return false;
	}
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
		for(var j=0;j<ins1.length;j++){
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
			var stdate=document.getElementById('stdate'+i+'').value;
			if(stdate==''){
				alertify.alert("Please Enter Start Date");
				return false;
			}
			var enddate=document.getElementById('enddate'+i+'').value;
			if(enddate==''){
				alertify.alert("Please Enter End Date");
				return false;
			}
		}
	}
	
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
}
function validate_tna_details(){
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
				var compname=document.getElementById('group_comp['+i+']').value;
				if(compname==''){
					alertify.alert("Please Select Competency");
					return false;
				}
				// var complevel=document.getElementById('level['+i+']').value;
				// if(complevel==''){
					// alertify.alert("Please Select Competency Level");
					// return false;
				// }
			}
		}
	
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
			   var month=document.getElementById('month'+i).value;
			   if(month==''){
					alertify.alert("Please Select Months");
					return false;
			   }
			   var days=document.getElementById('days'+i).value;
			   if(days==''){
					alertify.alert("Please Select Days");
					return false;
			   }
			   var part=document.getElementById('participants'+i).value;
			   if(part==''){
					alertify.alert("Please Enter No of Participants");
					return false;
			   }
			}
		}
}
function AddRow(){
	// var valid=$('#tna').validationEngine('validate');
	// if(valid==false){
	// $('#tna').validationEngine();
	// }else{
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
				var stdate=document.getElementById('stdate'+i+'').value;
				if(stdate==''){
					alertify.alert("Please Enter Role Start Date");
					return false;
				}
				var enddate=document.getElementById('enddate'+i+'').value;
				if(enddate==''){
					alertify.alert("Please Enter Role End Date");
					return false;
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
		
		$("#role_table").append("<tr id='innertable"+sub_iteration+"'><td style='padding-left: 25px; width:46px;'><input type='checkbox' name='chck' id='chck["+sub_iteration+"]' value="+sub_iteration+" /></td><td style='width:115px;'><input type='hidden' name='id[]' id='id["+sub_iteration+"]' value='' /><select name='role[]' id='role["+sub_iteration+"]' style='width:160px;' class='mediumselect'><option value=''>Select</option>"+tnaroles+"</select></td><td style='width:76px;'><input type='text' name='stdate[]' id='stdate"+sub_iteration+"' value='' style='width:70%;' class='validate[custom[date2]] datepicker mediumtext' onfocus='date_funct(this.id)'></td><td style='width:76px;'><input type='text' name='enddate[]' id='enddate"+sub_iteration+"' value='' style='width:70%;' class='validate[custom[date2], future[#stdate"+sub_iteration+"]] datepicker mediumtext'  onfocus='date_funct(this.id)' /></td><td style='width:76px;'><select name='pub[]' id='pub' style='width:85%;' class='mediumselect'>"+tnapublish+"</select></td></tr>");
		$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });
		var datadiv=$('#role_id').height();
		if(datadiv>=200){
			$('#role_id').css('height',datadiv+'px');
			$('#role_id').css('overflow','auto');
		}
		if(document.getElementById(hiddtab).value!=''){
			var ins=document.getElementById(hiddtab).value;
			document.getElementById(hiddtab).value=ins+","+sub_iteration;
		}
		else{
			document.getElementById(hiddtab).value=sub_iteration;
		}
	//}
}
function DeleteRow(){
	var ins=document.getElementById('hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;	
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="chck["+bb+"]";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="innertable"+b+"";
			var code=document.getElementById("id["+b+"]").value;
			if(code!=""){
				$.ajax({
					url: BASE_URL+"/admin/delete_tnarole",
					global: false,
					type: "POST",
					data: ({val : code}),
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
	var tbl = document.getElementById('role_table');
	var lastRow = tbl.rows.length;
	if(lastRow<=4){
		$('#role_id').css('height','auto');
		//$('#role_id').css('overflow','none');
	}
}

function AddOrgRow(){
	// var org_valid=$('#tna').validationEngine('validate');
	// if(org_valid==false){
		// $('#tna').validationEngine();
	// }
	// else{
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
		
		
		$("#tna_orgs_tab").append("<tr id='tna_org_row"+sub_iteration+"'><td style='padding-left: 25px; width:44px;'><input type='checkbox' name='sel_org' id='sel_org["+sub_iteration+"]' value="+sub_iteration+" /></td><td style='width: 210px;'><input type='hidden' name='tna_org_id[]' id='tna_org_id["+sub_iteration+"]' value='' /><select name='tna_orgs[]' id='tna_orgs["+sub_iteration+"]'  class='chosen-select' style='width: 200px;' onchange='getOrgtypes("+sub_iteration+")'><option value=''>Select</option>"+organizations+"</select></td><td style='width: 120px;'><div id='tna_org_type["+sub_iteration+"]'></div></td></tr>");
		
		var orgdatadiv=$('#orgtabdiv').height();
		if(orgdatadiv>=200){
			$('#orgtabdiv').css('height',orgdatadiv+'px');
			$('#orgtabdiv').css('overflow','auto');
		}
		//$('#tna_orgs_'+sub_iteration+'__chosen').css('width','70%');
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
	//}
}
function DeleteOrgRow(){
	var ins=document.getElementById('tna_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="sel_org["+bb+"]";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="tna_org_row"+b+"";
			var code=document.getElementById("tna_org_id["+b+"]").value;
			if(code!=""){
				$.ajax({
					url: BASE_URL+"/admin/delete_tnaorg",
					global: false,
					type: "POST",
					data: ({val : code}),
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
	document.getElementById('tna_hidden_id').value=arr1
	var tbl = document.getElementById('tna_orgs_tab');
	var lastRow = tbl.rows.length;
	if(lastRow<=4){
		$('#orgtabdiv').css('height','auto');
	}
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
	// var comp_valid=$('#tna_form').validationEngine('validate');
	// if(comp_valid==false){
		// $('#tna_form').validationEngine();
	// }
	// else{
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
				var compname=document.getElementById('group_comp['+i+']').value;
				var complevel=document.getElementById('level['+i+']').value;
				if(compname==''){
					alertify.alert("Please Select Competency");
					return false;
				}
				else{
					for( var k=0;k<ins1.length;k++){
						l=ins1[k];
						var compname1=document.getElementById('group_comp['+l+']').value;
						var complevel1=document.getElementById('level['+l+']').value;
						if(k!=j){
							if(compname==compname1 && complevel==complevel1){
								alertify.alert("Competency with same level Already Exists");
								return false;
							}
						}
					}
				}
				// var complevel=document.getElementById('level['+i+']').value;
				// if(complevel==''){
					// alertify.alert("Please Select Competency Level");
					// return false;
				// }
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

		$("#tna_table").append("<tr id='innertable"+sub_iteration+"'><td style='padding-left: 20px; width:73px;'><input type='radio' name='select_radio' id='select_radio_"+sub_iteration+"' value="+sub_iteration+" onclick='Add_Info("+sub_iteration+")' /></td><td style='width:339px;'><input type='hidden' name='admin_comp_id["+sub_iteration+"]' id='admin_comp_id["+sub_iteration+"]' value=''><select name='group_comp[]' id='group_comp["+sub_iteration+"]' style='width:180px;' onchange='comp_level("+sub_iteration+")' class='chosen-select'><option value=''>Select</option>"+competencies+"</select></td><td style='width:197px;'><select name='level[]' id='level["+sub_iteration+"]' style='width:180px;' class='mediumselect'><option value=''>Select</option></select></td></tr>");
		
		var divheight=$('#tna_table_id').height();
		if(divheight>=200){
			$('#tna_table_id').css('height',divheight+'px');
			$('#tna_table_id').css('overflow','auto');
		}
		
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
	//}
}
function DelRow(){
	var ins=document.getElementById('inner_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
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
	var tbl = document.getElementById('tna_table');
	var lastRow = tbl.rows.length;
	if(lastRow<=4){
		$('#tna_table_id').css('height','none');
		$('#tna_table_id').css('overflow','none');
	}

}
function AddCompPrgmRow(){
	// var prg_valid=$('#tna_form').validationEngine('validate');
	// if(prg_valid==false){
		// $('#tna_form').validationEngine();
	// }
	// else{
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
			   var month=document.getElementById('month'+i).value;
			   if(month==''){
					alertify.alert("Please Select Months");
					return false;
			   }
			   var days=document.getElementById('days'+i).value;
			   if(days==''){
					alertify.alert("Please Select Days");
					return false;
			   }
			   var part=document.getElementById('participants'+i).value;
			   if(part==''){
					alertify.alert("Please Enter No of Participants");
					return false;
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
				$("#prgm_table").append("<tr id='prg_innertable"+sub_iteration+"'><td style='padding-left:15px;'><input type='checkbox' name='prgm_chk_' id='prgm_chk_"+sub_iteration+"' value="+sub_iteration+" /></td><td><select name='category[]' id='category"+sub_iteration+"' style='width:150px;' class='mediumselect'>"+response[0]+"</select></td><td><select name='program[]' id='program"+sub_iteration+"' style='width:150px;' class='mediumselect'>"+response[1]+"</select></td><td><select name='month[]' id='month"+sub_iteration+"' class='mediumselect'><option value=''>Select Month</option>"+months+"</select></td><td><select name='days[]' id='days"+sub_iteration+"' class='mediumselect' style='width:75px;'><option value=''>Select Days</option>"+days+"</select></td><td><input type='text' name='participants[]' id='participants"+sub_iteration+"' value='' style='width: 50px;' class='validate[custom[onlyNumberSp]] mediumtext' maxlength='3'></td><td><input type='text' name='budget[]' id='budget"+sub_iteration+"' value='' style='width: 80px;' class='validate[custom[amount]] mediumtext' maxlength='11'></td><td><select name='trainer_type[]' id='trainer_type"+sub_iteration+"' class='mediumselect'><option value=''>Select Type</option>"+trainer_type+"</select></td><td><input type='text' name='trainer[]' id='trainer"+sub_iteration+"' value='' style='width: 80px;' class='mediumtext'></td><td><select name='criticality[]' id='criticality"+sub_iteration+"' class='mediumselect'><option value=''>Select Criticality</option>"+criticality+"</select></td><td><input type='text' href='#tna_comments' data-toggle='modal' name='comments[]' id='comments"+sub_iteration+"' value='' style='width: 100px;' class='mediumtext' onclick='popup_box("+sub_iteration+")'></td><td><input type='hidden' name='hidden_emp_data[]' id='hidden_emp_data["+sub_iteration+"]' value='' /><input type='button' href='#tna_empees' data-toggle='modal' name='emp' id='emp["+sub_iteration+"]' value='Add Employees' onclick='Add_Employee("+sub_iteration+")' class='btn btn-sm btn-success'/><input type='button' href='#tna_empees' data-toggle='modal' name='emp_view' id='emp_view["+sub_iteration+"]' value='View Employees' onclick='Add_Employee("+sub_iteration+")' class='btn btn-sm btn-success' style='display:none;'/></td></tr>");
				
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
	//}
}
function AddPrgmRow(){
	// var prg_valid=$('#tna_form').validationEngine('validate');
	// if(prg_valid==false){
		// $('#tna_form').validationEngine();
	// }
	// else{alertify.alert("in else");
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
			   var month=document.getElementById('month'+i).value;
			   if(month==''){
					alertify.alert("Please Select Month");
					return false;
			   }
			   var day=document.getElementById('days'+i).value;
			   if(day==''){
					alertify.alert("Please Select Days");
					return false;
			   }
			   var part=document.getElementById('participants'+i).value;
			   if(part==''){
					alertify.alert("Please Enter Participants");
					return false;
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
		
		$("#prgm_table").append("<tr id='innertable"+sub_iteration+"'><td style='padding-left:15px;'><input type='checkbox' name='prgm_chk_' id='prgm_chk_"+sub_iteration+"' value="+sub_iteration+" /></td><td><select name='category[]' id='category"+sub_iteration+"' style='width:150px;' class='validate[required] mediumselect' onchange='getPrograms("+sub_iteration+")'><option value=''>Select </option>"+categories+"</select></td><td><select name='program[]' id='program"+sub_iteration+"' style='width:150px;' class='validate[required] mediumselect'><option value=''>Select</option></select></td><td><select name='month[]' id='month"+sub_iteration+"' class='validate[required] mediumselect'><option value=''>Select Month</option>"+months+"</select></td><td><select name='days[]' id='days"+sub_iteration+"' class='validate[required] mediumselect' style='width:75px;'><option value=''>Select Days</option>"+days+"</select></td><td><input type='text' name='participants[]' id='participants"+sub_iteration+"' value='' style='width: 50px;' class='validate[required, custom[onlyNumberSp]] mediumtext' maxlength='3'></td><td><input type='text' name='budget[]' id='budget"+sub_iteration+"' value='' style='width: 80px;' class='validate[custom[amount]] mediumtext' maxlength='11'></td><td><select name='trainer_type[]' id='trainer_type"+sub_iteration+"' class='mediumselect'><option value=''>Select Type</option>"+trainer_type+"</select></td><td><input type='text' name='trainer[]' id='trainer"+sub_iteration+"' value='' style='width: 80px;' class='mediumtext'></td><td><select name='criticality[]' id='criticality"+sub_iteration+"' class='mediumselect'><option value=''>Select Criticality</option>"+criticality+"</select></td><td><input type='text' href='#tna_comments' data-toggle='modal' name='comments[]' id='comments"+sub_iteration+"' value='' style='width: 100px;' class='mediumtext' onclick='popup_box("+sub_iteration+")'></td><td><input type='hidden' name='hidden_emp_data[]' id='hidden_emp_data["+sub_iteration+"]' value='' /><input type='button'  href='#tna_empees' data-toggle='modal' name='emp' id='emp["+sub_iteration+"]' value='Add Employees' onclick='Add_Employee("+sub_iteration+")' class='btn btn-sm btn-success'/><input type='button' href='#tna_empees' data-toggle='modal' name='emp_view' id='emp_view["+sub_iteration+"]' value='View Employees' onclick='View_Employee("+sub_iteration+")' class='btn btn-sm btn-success' style='display:none;'/></td></tr>");
				
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
	//}
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
			var c="innertable"+b+"";
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
				var empnum=document.getElementById('emp_number['+i+']').value;	
				if(empnum=='undefined' || empnum==''){
					alertify.alert("Please Enter Employee Number");
					return false;
				}
				else{
					for( var k=0;k<ins1.length;k++){
                       l=ins1[k];
                       var empnum2=document.getElementById('emp_number['+l+']').value;               
                       if(k!=j){                           
                           if(empnum==empnum2){
                               alertify.alert("Employee Number Already Exists");
                               return false;
                           }
                       }
                   }
				}
				var empname=document.getElementById('emp_name['+i+']').value;
				if(empname==''){
					alertify.alert("Please provide existing employee number");
					return false;
				}
			}
		}
		else{
			sub_iteration=1;
			ins1=1;
			var ins1=Array(1);
		}
		//alertify.alert($("#asdasd").html());
		$("#viewdataemp").append("<tr id='emp_innertable"+sub_iteration+"'><td><input type='checkbox' name='check' id='check"+sub_iteration+"' value="+sub_iteration+"></td><td><input id='sel_emp_id["+sub_iteration+"]' type='hidden' value='' name='sel_emp_id'><!--<input type='text' name='emp_number' id='emp_number["+sub_iteration+"]' value='' onchange='fetch_empdata("+sub_iteration+",this)'>--><select class='chosen-select' name='emp_number' id='emp_number["+sub_iteration+"]' onchange='fetch_empdata("+sub_iteration+",this)'>"+$("#tna_empdata").html()+"</select></td><td><input type='text' name='emp_name' id='emp_name["+sub_iteration+"]' value='' readonly></td><td><input type='text' name='emp_org' id='emp_org["+sub_iteration+"]' value='' readonly></td></tr>");
		
		$('.chosen-select').chosen({allow_single_deselect:true}); 
		//resize the chosen on window resize
		$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=25){w=220;}
		$('.chosen-select').next().css({'width':w});
		}).trigger('resize.chosen');
		
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
			var code=document.getElementById("admin_emp_id_"+b+"").value;
			if(code!=""){
				$.ajax({
					url: BASE_URL+"/admin/delete_tnaemployee",
					global: false,
					type: "POST",
					data: ({val : code}),
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
	document.getElementById('emp_hidden_id').value=arr1;

}
function fetch_empdata(num,present){
	empnumvalue=present.value;
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
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];
			var empnum=document.getElementById('emp_number['+i+']').value;
			if(empnum==''){
				alertify.alert("Please enter Employee Number");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var empnum2=document.getElementById('emp_number['+l+']').value;
					if(k!=j){
						if(empnum==empnum2){
							alertify.alert("Employee Number Already Exists");
							return false;
						}
					}
				}
			}
			// if(empnumvalue==empnum){
				// alertify.alert("Employee Number Already Exists");
				// document.getElementById('emp_number['+num+']').value='';
				// return false;
			// }
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
			$response=xmlhttp.responseText.split('@');
			//alertify.alert($response[0]);
			if($response[0]!=""){
				document.getElementById('sel_emp_id['+num+']').value=$response[0];
				document.getElementById('emp_name['+num+']').value=$response[1];
				document.getElementById('emp_org['+num+']').value=$response[2];
				document.getElementById('emp_number['+num+']').readOnly=true;
			}
			else{
				//alertify.alert(xmlhttp.responseText);
				alertify.alert("No Employee Found with this Number");
				document.getElementById('emp_number['+num+']').readOnly=false;
				return false;
			}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/fetch_emp_data?empnum="+empnumvalue,true);
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
		var idds='';
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];	
			var empids='sel_emp_id['+i+']';
			var empp_ids=document.getElementById(empids).value;
			var empnum=document.getElementById('emp_number['+i+']').value;	
			if(empnum=='undefined' || empnum==''){
				alertify.alert("Please Enter Employee Number");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
				   l=ins1[k];
				   var empnum2=document.getElementById('emp_number['+l+']').value;               
				   if(k!=j){                           
					   if(empnum==empnum2){
						   alertify.alert("Employee Number Already Exists");
						   return false;
					   }
				   }
			   }
			}
			var empname=document.getElementById('emp_name['+i+']').value;
			if(empname==''){
				alertify.alert("Please provide existing employee number");
				return false;
			} 
			if(document.getElementById(empids)){
				if(idds==''){
					idds='0_'+empp_ids;	
				}
				else{
					idds=idds+",0_"+empp_ids;
				}
			}
			else{
				idds='';
			}			
		}
	}else{
		idds='';
	}
	//$('.lightbox_bg').hide();
	//document.getElementById('msg_box33').style.display='none';
	document.getElementById('hidden_emp_data['+keyid+']').value=idds;
	document.getElementById('emp['+keyid+']').style.display='none';
	document.getElementById('emp_view['+keyid+']').style.display='block';
}
$(document).ready(function(){
	if(status=='competency'){
		document.getElementById('select_radio_0').checked=true;
		 Add_Info(0);
	 }
});
function Add_Info(id){
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
	xmlhttp.open("GET",BASE_URL+"/admin/additional_info?levelid="+levelid+"&compid="+compid+"&tna_admin_id="+tnaadminid+"&autocompid="+autocompid+"&tna_id="+tnaid,true);
	xmlhttp.send(); 
}
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
	//document.getElementById('msg_box33').style.display='block';
	var empids=document.getElementById('hidden_emp_data['+keyid+']').value;
	if(empids!=''){
		employeeids=empids;
	}else{
		employeeids='';
	}
	if(orgid==''){
		$('#tna_empees').modal('hide');
		alertify.alert("Please select organization");
		return false;
	}
	else{
		var id="emp["+keyid+"]";
		$("#"+id).attr('href','tna_empees');
		$("#"+id).attr('data-toggle','modal');
		//alertify.alert(id);
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
			document.getElementById("tna_employees_data").innerHTML=xmlhttp.responseText;
			//alert_msg('msg_box33');
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=25){w=250;}
			$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');
			
			$(".modal-dialog").draggable();
			$(".modal-dialog").css('top','0px');
			$(".modal-dialog").css('width','60%');
			
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
			document.getElementById("tna_employees_data").innerHTML=xmlhttp.responseText;
			//alert_msg('msg_box33');
			$(".modal-dialog").draggable();
			$(".modal-dialog").css('top','0px');
			$(".modal-dialog").css('width','60%');
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
	for(var i=0;i<=cnt;i++){//alertify.alert(i);
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
function popup_box(id){	
	//document.getElementById('comments_div').style.display='block';
	var comtext=document.getElementById('comments'+id+'').value;
	//alert_msg('comments_div');	
	document.getElementById('godiv').innerHTML="<input type='button' name='done_comm' id='done_comm' class='btn btn-xs btn-success' data-dismiss='modal' value='Done' onclick='capture_comm("+id+")' style='margin:-10px 15px 15px;'>";
	document.getElementById('text_id').value=comtext;	
	$(".modal-dialog").draggable();
	$(".modal-dialog").css('top','0px');
}

function  capture_comm(id){
	var comment=document.getElementById('text_id').value;
	document.getElementById('comments'+id+'').value=comment;
	//$('.lightbox_bg').hide();
	// document.getElementById('tna_comments').style.display='none';
	
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