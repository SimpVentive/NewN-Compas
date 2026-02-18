//Start of Script for TNA Setup
$(document).ready(function(){
	$('#tna').validationEngine();
	$('#tna_form').validationEngine();
	$('#tna_form_tni_controls').validationEngine();
	$('#tna_publish').validationEngine();
	$('#initiate_validation').validationEngine();
	
	
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeYear: true, changeMonth: true });
	/* getTnaDetails(); */
	
});
$(document).ready(function(){
	
	$('#tna_empees').modal({
		show: false,
		backdrop: 'static',
		keyboard: false  // to prevent closing with Esc button (if you want this too)
	});	
	$('#id-input-file-2').ace_file_input({
		no_file:'No File ...',
		btn_choose:'Choose',
		btn_change:'Change',
		droppable:false,
		onchange:null,
		thumbnail:false //| true | large
		//whitelist:'gif|png|jpg|jpeg'
		//blacklist:'exe|php'
		//onchange:''
		//
	});
	
	$('#emp_no').ajaxChosen({
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});
	
	$('#emp_no_manager').ajaxChosen({
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/autoemployee_manager'
	},{
		   loadingImg: 'loading.gif'
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
	
	var dates = $( "#date_start_emp, #date_end_emp" ).datepicker({
		dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		minDate:"",
		maxDate:difDays,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id === "date_start_emp" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
			instance.settings.dateFormat ||
			$.datepicker._defaults.dateFormat,
			selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});				   
});
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#dates_start_emp, #date_start_mngr" ).datepicker({
		dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		minDate:"",
		maxDate:difDays,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id === "dates_start_emp" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
			instance.settings.dateFormat ||
			$.datepicker._defaults.dateFormat,
			selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});				   
});
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#date_start" ).datepicker({
		dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		minDate:"",
		maxDate:difDays,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id === "date_start" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
			instance.settings.dateFormat ||
			$.datepicker._defaults.dateFormat,
			selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});				   
});
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#date_start_manager, #date_end_manager" ).datepicker({
		dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		minDate:"",
		maxDate:difDays,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id === "date_start_manager" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
			instance.settings.dateFormat ||
			$.datepicker._defaults.dateFormat,
			selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});				   
});
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#year_stdate, #year_enddate" ).datepicker({
		dateFormat:"dd-mm-yy",
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
			/* if(role==''){
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
			} */				
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
//var yr_stdt=document.getElementById('year_stdate').value();
		$("#role_table").append("<tr id='innertable"+sub_iteration+"'><td style='padding-left: 25px; width:46px;'><input type='checkbox' name='chck' id='chck["+sub_iteration+"]' value="+sub_iteration+" /></td><td style='width:115px;'><input type='hidden' name='id[]' id='id["+sub_iteration+"]' value='' /><select name='role[]' id='role["+sub_iteration+"]' style='width:160px;' class='mediumselect'><option value=''>Select</option>"+tnaroles+"</select></td><td style='width:76px;'><input type='text' name='stdate[]' id='stdate"+sub_iteration+"' value='' style='width:70%;' class='validate[custom[date2], future[#year_stdate], past[#year_enddate]] datepicker mediumtext' onfocus='date_funct(this.id)'></td><td style='width:76px;'><input type='text' name='enddate[]' id='enddate"+sub_iteration+"' value='' style='width:70%;' class='validate[custom[date2], future[#stdate"+sub_iteration+"], past[#year_enddate]] datepicker mediumtext'  onfocus='date_funct(this.id)' /></td><td style='width:76px;'><select name='pub[]' id='pub' style='width:85%;' class='mediumselect'>"+tnapublish+"</select></td></tr>");
		$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeYear: true, changeMonth: true });
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
	var ins=document.getElementById('tna_hidden_id_h').value;
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
	document.getElementById('tna_hidden_id_h').value=arr1
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
				$("#prgm_table").append("<tr id='prg_innertable"+sub_iteration+"'><td style='padding-left:15px;'><input type='checkbox' name='prgm_chk_' id='prgm_chk_"+sub_iteration+"' value="+sub_iteration+" /></td><td><select name='category[]' id='category"+sub_iteration+"' style='width:150px;' class='mediumselect'>"+response[0]+"</select></td><td><select name='program[]' id='program"+sub_iteration+"' style='width:150px;' class='mediumselect'>"+response[1]+"</select></td><td><select name='month[]' id='month"+sub_iteration+"' class='mediumselect'><option value=''>Select Month</option>"+months+"</select></td><td><select name='days[]' id='days"+sub_iteration+"' class='mediumselect' style='width:75px;'><option value=''>Select Days</option>"+days+"</select></td><td><input type='text' name='participants[]' id='participants"+sub_iteration+"' value='' style='width: 50px;' class='validate[custom[onlyNumberSp]] mediumtext' maxlength='3'></td><td><input type='text' name='budget[]' id='budget"+sub_iteration+"' value='' style='width: 80px;' class='validate[custom[amount]] mediumtext' maxlength='11'></td><td><select name='trainer_type[]' id='trainer_type"+sub_iteration+"' class='mediumselect'><option value=''>Select Type</option>"+trainer_type+"</select></td><td><input type='text' name='trainer[]' id='trainer"+sub_iteration+"' value='' style='width: 80px;' class='mediumtext'></td><td><select name='criticality[]' id='criticality"+sub_iteration+"' class='mediumselect'><option value=''>Select Criticality</option>"+criticality+"</select></td><td><input type='text' href='#tna_comments' data-toggle='modal' name='comments[]' id='comments"+sub_iteration+"' value='' style='width: 100px;' class='mediumtext' onclick='popup_box("+sub_iteration+")'></td><td><input type='hidden' name='hidden_emp_data[]' id='hidden_emp_data"+sub_iteration+"' value='' /><input type='button' href='#tna_empees' data-toggle='modal' name='emp' id='emp["+sub_iteration+"]' value='Add Employees' onclick='Add_Employee("+sub_iteration+")' class='btn btn-sm btn-success'/><input type='button' href='#tna_empees' data-toggle='modal' name='emp_view' id='emp_view["+sub_iteration+"]' value='View Employees' onclick='Add_Employee("+sub_iteration+")' class='btn btn-sm btn-success' style='display:none;'/></td></tr>");
				
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
function AddPrgmRow(key){
	var prg_valid=$('#tna_form').validationEngine('validate');
	if(prg_valid==false){
		$('#tna_form').validationEngine();
	}
	else{
		var keyid=key;
		if(key==''){
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
					/* var catid=document.getElementById('category'+i).value;
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
				   } */
									
				}
			}
			else{
				sub_iteration=1;
				ins1=1;
				var ins1=Array(1);
			}
			
					 
			//.before(),.insertBefore(), .prepend(). these can be used instead of .prepend()
						
			$("#prgm_table").append("<tr id='innertable"+sub_iteration+"'><td><input type='hidden' name='cat_id[]' id='cat_id"+sub_iteration+"' value=''><label for='cat_val"+sub_iteration+"'></label></td><td><input type='hidden' name='tna_prog_id[]' id='tna_prog_id["+sub_iteration+"]' value=''><input type='hidden' name='pro_id[]' id='pro_id"+sub_iteration+"' value=''><input type='hidden' name='other_pro[]' id='other_pro"+sub_iteration+"' value=''><label for='pro_val"+sub_iteration+"'></label></td><td><input type='hidden' name='mnth_id[]' id='mnth_id"+sub_iteration+"' value=''><label for='month_val"+sub_iteration+"'></label></td><td><input type='hidden' name='day_id[]' id='day_id"+sub_iteration+"' value=''><label for='day_val"+sub_iteration+"'></label></td><td><input type='hidden' name='participants[]' id='participants"+sub_iteration+"' value=''><label for='part_val"+sub_iteration+"'></label></td><td><input type='hidden' name='budget[]' id='budget"+sub_iteration+"' value=''><label for='bud_val"+sub_iteration+"'></label></td><td><input type='hidden' name='trainer_type[]' id='trainer_type"+sub_iteration+"' value=''><label for='ttype_val"+sub_iteration+"'></label></td><td><input type='hidden' name='trainer[]' id='trainer"+sub_iteration+"' value=''><label for='tra_val"+sub_iteration+"'></label></td><td><input type='hidden' name='cri_id[]' id='cri_id"+sub_iteration+"' value=''><label for='cri_val"+sub_iteration+"'></label></td><td><input type='hidden' name='com_data[]' id='com_data"+sub_iteration+"' value=''><label for='com_val"+sub_iteration+"'></label></td><td><input type='hidden' name='hidden_mngr_data[]' id='hidden_mngr_data"+sub_iteration+"' value='' /><label for='mngr_val"+sub_iteration+"'></label></td><td><label for='mngr_accept"+sub_iteration+"'></label></td><td class='centerside'><input type='hidden' name='hidden_emp_data[]' id='hidden_emp_data"+sub_iteration+"' value='' /><!--<label for='emp_val"+sub_iteration+"'></label>--><div class='hidden-sm hidden-xs btn-group'><a title='Employee List' data-rel='tooltip' class='btn btn-xs btn-info' href='#tna_empees' data-toggle='modal' onclick='Add_Employee("+sub_iteration+")'><i class='ace-icon fa fa-users bigger-120'></i></a></div></td><td class='centerside'><div class='hidden-sm hidden-xs btn-group'><a title='Update' data-rel='tooltip' class='btn btn-xs btn-info' href='#tna_data' data-toggle='modal' onclick='open_tnadata("+sub_iteration+")'><i class='ace-icon fa fa-pencil bigger-120'></i></a><a title='Delete' data-rel='tooltip' class='btn btn-xs btn-danger deleteclass' id='"+sub_iteration+"' name='delete_tnadetails' rel='tna_details' onclick='DelPrgmRow("+sub_iteration+")'><i class='ace-icon fa fa-trash-o bigger-120'></i></a></div><div class='hidden-md hidden-lg'><div class='inline position-relative'><button class='btn btn-minier btn-primary dropdown-toggle' data-toggle='dropdown' data-position='auto'><i class='ace-icon fa fa-cog icon-only bigger-110'></i></button><ul class='dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close'><li><a href='#' class='tooltip-info' data-rel='tooltip' title='View'><span class='blue'><i class='ace-icon fa fa-search-plus bigger-120'></i></span></a></li><li><a href='#' class='tooltip-success' data-rel='tooltip' title='Edit'><span class='green'><i class='ace-icon fa fa-pencil-square-o bigger-120'></i></span></a></li></ul></div></div></td></tr>");
			
			/* <input type='hidden' name='hidden_emp_data[]' id='hidden_emp_data["+sub_iteration+"]' value='' /><input type='button'  href='#tna_empees' data-toggle='modal' name='emp' id='emp["+sub_iteration+"]' value='Add Employees' onclick='Add_Employee("+sub_iteration+")' class='btn btn-sm btn-success'/><input type='button' href='#tna_empees' data-toggle='modal' name='emp_view' id='emp_view["+sub_iteration+"]' value='View Employees' onclick='View_Employee("+sub_iteration+")' class='btn btn-sm btn-success' style='display:none;'/> */
			
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
			keyid=sub_iteration;
		}
		var catid=$('#category').val();
		var prgid=$('#program').val();
		var mnt=$('#month').val();
		var dy=$('#days').val();
		var part=$('#participants').val();
		var bud=$('#budget').val();
		var ttyp=$('#trainer_type').val();
		var tra=$('#trainer').val();
		var cri=$('#criticality').val();
		var com=$('#text_id').val();		
		var empid=$('#empdetails').val();
		//var empspl=empid.split(/,/).length;
		
		var mngrid=$('#mngrdetails').val();
		//var emp_spi=empid.split(",");
		
		$("#cat_id"+keyid).val(catid);
		$("label[for='cat_val"+keyid+"']").text($('#category').children("option:selected").text());
		
		if(prgid!='o'){
			$("#pro_id"+keyid).val(prgid);
			$("label[for='pro_val"+keyid+"']").text($('#program').children("option:selected").text());
		}else{
			$("#pro_id"+keyid).val('');
			$("#other_pro"+keyid).val($('#other_program').val());
			$("label[for='pro_val"+keyid+"']").text($('#other_program').val());
		}
		
		if(mnt!=''){
			$("#mnth_id"+keyid).val(mnt);
			$("label[for='month_val"+keyid+"']").text($('#month').children("option:selected").text());
		}else{
			$("#mnth_id"+keyid).val('');
			$("label[for='month_val"+keyid+"']").text('');
		}
				
		if(dy!=''){
			$("#day_id"+keyid).val(dy);
			$("label[for='day_val"+keyid+"']").text($('#days').children("option:selected").text());
		}else{
			$("#day_id"+keyid).val('');
			$("label[for='day_val"+keyid+"']").text('');
		}
		if(part!=''){
			$("#participants"+keyid).val(part);
			$("label[for='part_val"+keyid+"']").text(part);
		}else{
			$("#participants"+keyid).val('');
			$("label[for='part_val"+keyid+"']").text('');
		}
		if(bud!=''){
			$("#budget"+keyid).val(bud);
			$("label[for='bud_val"+keyid+"']").text(bud);
		}else{
			$("#budget"+keyid).val('');
			$("label[for='bud_val"+keyid+"']").text('');
		}
		if(ttyp!=''){
			$("#trainer_type"+keyid).val(ttyp);
			$("label[for='ttype_val"+keyid+"']").text($('#trainer_type').children("option:selected").text());
		}
		else{
			$("#trainer_type"+keyid).val('');
			$("label[for='ttype_val"+keyid+"']").text('');
		}
		if(tra!=''){
			$("#trainer"+keyid).val(tra);
			$("label[for='tra_val"+keyid+"']").text(tra);
		}else{
			$("#trainer"+keyid).val('');
			$("label[for='tra_val"+keyid+"']").text('');
		}		
		if(cri!=''){
			$("#cri_id"+keyid).val(cri);
			$("label[for='cri_val"+keyid+"']").text($('#criticality').children("option:selected").text());
		}
		else{
			$("#cri_id"+keyid).val('');
			$("label[for='cri_val"+keyid+"']").text('');
		}
		$("#com_data"+keyid).val(com);
		$("label[for='com_val"+keyid+"']").text(com);
		if(mngrid!=''){
			$("#hidden_mngr_data"+keyid).val(mngrid);
			$("label[for='mngr_val"+keyid+"']").text($('#mngrdetails').children("option:selected").text());
		}
		else{
			$("#hidden_mngr_data"+keyid).val('');
			$("label[for='mngr_val"+keyid+"']").text('');
		}
		if(empid!=''){
			$("#hidden_emp_data"+keyid).val(empid);
			$("label[for='emp_val"+keyid+"']").text($('#empdetails').children("option:selected").text());
		}
		else{
			$("#hidden_emp_data"+keyid).val('');
			$("label[for='emp_val"+keyid+"']").text('');
		}
		
		$('#tna_data').modal('hide');		
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
function getPrograms(key=''){
	var category=document.getElementById('category').value;
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
				document.getElementById('program').innerHTML=xmlhttp.responseText;				
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/getPrograms?categoryid="+category,true);
		xmlhttp.send();
	}
}
function close_modal(key){
	var catid=$('#category').val();
	var prgid=$('#program').val();
	var mnt=$('#month').val();
	var dy=$('#days').val();
	var part=$('#participants').val();
	var bud=$('#budget').val();
	var ttyp=$('#trainer_type').val();
	var tra=$('#trainer').val();
	var cri=$('#criticality').val();
	var com=$('#text_id').val();
	var empid=$('#empdetails').val();
	var mngrid=$('#mngrdetails').val();
	if(catid!='' || prgid!='' || mnt!='' || dy!='' || part!='' || bud!='' || ttyp!='' || tra!='' || cri!='' || com!='' || mngrid!='' || empid!=''){
		//var conf=window.confirm('Do you want to save the data');
		alertify.confirm("Do you want to save the data", function (e) {	
			if(e){
				var keyid=key;
				if(key==''){
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
							var catid=document.getElementById('cat_id'+i).value;
							var category=document.getElementById('category').value;
							var prgid=document.getElementById('pro_id'+i).value;
							var program=document.getElementById('program').value;
							var othrprgid=document.getElementById('other_pro'+i).value;	
							if(catid==category && prgid==program){					
								alertify.alert("Category with same program already exists");
								return false;
							}										
						}
					}
					else{
						sub_iteration=1;
						ins1=1;
						var ins1=Array(1);
					}		
					
					$("#prgm_table").append("<tr id='innertable"+sub_iteration+"'><td><input type='hidden' name='cat_id[]' id='cat_id"+sub_iteration+"' value=''><label for='cat_val"+sub_iteration+"'></label></td><td><input type='hidden' name='tna_prog_id[]' id='tna_prog_id["+sub_iteration+"]' value=''><input type='hidden' name='pro_id[]' id='pro_id"+sub_iteration+"' value=''><input type='hidden' name='other_pro[]' id='other_pro"+sub_iteration+"' value=''><label for='pro_val"+sub_iteration+"'></label></td><td><input type='hidden' name='mnth_id[]' id='mnth_id"+sub_iteration+"' value=''><label for='month_val"+sub_iteration+"'></label></td><td><input type='hidden' name='day_id[]' id='day_id"+sub_iteration+"' value=''><label for='day_val"+sub_iteration+"'></label></td><td><input type='hidden' name='participants[]' id='participants"+sub_iteration+"' value=''><label for='part_val"+sub_iteration+"'></label></td><td><input type='hidden' name='budget[]' id='budget"+sub_iteration+"' value=''><label for='bud_val"+sub_iteration+"'></label></td><td><input type='hidden' name='trainer_type[]' id='trainer_type"+sub_iteration+"' value=''><label for='ttype_val"+sub_iteration+"'></label></td><td><input type='hidden' name='trainer[]' id='trainer"+sub_iteration+"' value=''><label for='tra_val"+sub_iteration+"'></label></td><td><input type='hidden' name='cri_id[]' id='cri_id"+sub_iteration+"' value=''><label for='cri_val"+sub_iteration+"'></label></td><td><input type='hidden' name='com_data[]' id='com_data"+sub_iteration+"' value=''><label for='com_val"+sub_iteration+"'></label></td><td><input type='hidden' name='hidden_mngr_data[]' id='hidden_mngr_data["+sub_iteration+"]' value='' /><label for='mngr_val"+sub_iteration+"'></label></td><td><input type='hidden' name='hidden_emp_data[]' id='hidden_emp_data"+sub_iteration+"' value='' /><label for='emp_val"+sub_iteration+"'></label></td><td class='centerside'><div class='hidden-sm hidden-xs btn-group'><a title='Update' data-rel='tooltip' class='btn btn-xs btn-info' href='#tna_data' data-toggle='modal' onclick='open_tnadata("+sub_iteration+")'><i class='ace-icon fa fa-pencil bigger-120'></i></a><a title='Delete' data-rel='tooltip' class='btn btn-xs btn-danger deleteclass' id='"+sub_iteration+"' name='delete_tnadetails' rel='tna_details' onclick='DelPrgmRow("+sub_iteration+")'><i class='ace-icon fa fa-trash-o bigger-120'></i></a></div><div class='hidden-md hidden-lg'><div class='inline position-relative'><button class='btn btn-minier btn-primary dropdown-toggle' data-toggle='dropdown' data-position='auto'><i class='ace-icon fa fa-cog icon-only bigger-110'></i></button><ul class='dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close'><li><a href='#' class='tooltip-info' data-rel='tooltip' title='View'><span class='blue'><i class='ace-icon fa fa-search-plus bigger-120'></i></span></a></li><li><a href='#' class='tooltip-success' data-rel='tooltip' title='Edit'><span class='green'><i class='ace-icon fa fa-pencil-square-o bigger-120'></i></span></a></li></ul></div></div></td></tr>");
							
					if(document.getElementById(hiddtab).value!=''){
						var ins=document.getElementById(hiddtab).value;
						document.getElementById(hiddtab).value=ins+","+sub_iteration;
					}
					else{
						document.getElementById(hiddtab).value=sub_iteration;
					}	
					keyid=sub_iteration;
				}
				
				$("#cat_id"+keyid).val(catid);
				$("label[for='cat_val"+keyid+"']").text($('#category').children("option:selected").text());
				
				if(prgid!='o'){
					$("#pro_id"+keyid).val(prgid);
					$("label[for='pro_val"+keyid+"']").text($('#program').children("option:selected").text());
				}else{
					$("#pro_id"+keyid).val('');
					$("#other_pro"+keyid).val($('#other_program').val());
					$("label[for='pro_val"+keyid+"']").text($('#other_program').val());
				}
				
				if(mnt!=''){
					$("#mnth_id"+keyid).val(mnt);
					$("label[for='month_val"+keyid+"']").text($('#month').children("option:selected").text());
				}else{
					$("#mnth_id"+keyid).val('');
					$("label[for='month_val"+keyid+"']").text('');
				}
						
				if(dy!=''){
					$("#day_id"+keyid).val(dy);
					$("label[for='day_val"+keyid+"']").text($('#days').children("option:selected").text());
				}else{
					$("#day_id"+keyid).val('');
					$("label[for='day_val"+keyid+"']").text('');
				}
				if(part!=''){
					$("#participants"+keyid).val(part);
					$("label[for='part_val"+keyid+"']").text(part);
				}else{
					$("#participants"+keyid).val('');
					$("label[for='part_val"+keyid+"']").text('');
				}
				if(bud!=''){
					$("#budget"+keyid).val(bud);
					$("label[for='bud_val"+keyid+"']").text(bud);
				}else{
					$("#budget"+keyid).val('');
					$("label[for='bud_val"+keyid+"']").text('');
				}
				if(ttyp!=''){
					$("#trainer_type"+keyid).val(ttyp);
					$("label[for='ttype_val"+keyid+"']").text($('#trainer_type').children("option:selected").text());
				}
				else{
					$("#trainer_type"+keyid).val('');
					$("label[for='ttype_val"+keyid+"']").text('');
				}
				if(tra!=''){
					$("#trainer"+keyid).val(tra);
					$("label[for='tra_val"+keyid+"']").text(tra);
				}else{
					$("#trainer"+keyid).val('');
					$("label[for='tra_val"+keyid+"']").text('');
				}		
				if(cri!=''){
					$("#cri_id"+keyid).val(cri);
					$("label[for='cri_val"+keyid+"']").text($('#criticality').children("option:selected").text());
				}
				else{
					$("#cri_id"+keyid).val('');
					$("label[for='cri_val"+keyid+"']").text('');
				}
				$("#com_data"+keyid).val(com);
				$("label[for='com_val"+keyid+"']").text(com);
				if(mngrid!=''){
					$("#hidden_mngr_data"+keyid).val(mngrid);
					$("label[for='mngr_val"+keyid+"']").text($('#mngrdetails').children("option:selected").text());
				}
				else{
					$("#hidden_mngr_data"+keyid).val('');
					$("label[for='mngr_val"+keyid+"']").text('');
				}
				if(empid!=''){
					$("#hidden_emp_data"+keyid).val(empid);
					$("label[for='emp_val"+keyid+"']").text($('#empdetails').children("option:selected").text());
				}
				else{
					$("#hidden_emp_data"+keyid).val('');
					$("label[for='emp_val"+keyid+"']").text('');
				}
				
				$('#tna_data').modal('hide');
			}
			else{
				$('#tna_data').modal('hide');
			}
		});
	}
	else{
		$('#tna_data').modal('hide');
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
			if(document.getElementById("admin_emp_id_"+b+"")){
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
	document.getElementById('hidden_emp_data'+keyid).value=idds;
	/* document.getElementById('emp['+keyid+']').style.display='none';
	document.getElementById('emp_view['+keyid+']').style.display='block'; */
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
	var compt=document.getElementById('select_radio_'+id);
	if(compt.checked==true){
		document.getElementById('select_radio_'+id).checked=false;
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
function Add_Manager(){
	var orgid=$('#org').val();
	var childorgid=$('#child_org').val();
	var orgids;
	if(childorgid!=''){
		orgids=childorgid;
	}else{
		orgids=orgid;
	}
	$.ajax({
		type: "GET",
		url: BASE_URL+"/admin/manager_list?orgid="+orgids,
		success: function(respons){
			$('#mngrdetails').html(respons);
		}
	});
}
function Add_Employee(keyid=''){
	var orgid=document.getElementById('org').value;
	var childorgid=document.getElementById('child_org').value;
	//document.getElementById('msg_box33').style.display='block';
	if(document.getElementById('hidden_emp_data'+keyid)){
		var empids=document.getElementById('hidden_emp_data'+keyid).value;
		if(empids!=''){
			employeeids=empids;
		}else{
			employeeids='';
		}
	}else{employeeids='';}
	if(orgid==''){
		$('#tna_data').modal('hide');
		$('#tna_empees').modal('hide');
		alertify.alert("Please select organization");
		return false;
	}
	else{
		/* var id="emp["+keyid+"]";
		$("#"+id).attr('href','tna_empees');
		$("#"+id).attr('data-toggle','modal'); */
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
		//alert(xmlhttp.responseText);
			document.getElementById("tna_employees_data").innerHTML=xmlhttp.responseText;
			
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=25){w=250;}
			$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');
			
			/* $(".modal-dialog").draggable();
			$(".modal-dialog").css('top','0px');
			$(".modal-dialog").css('width','60%'); */
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/employee_list?key_val="+keyid+"&employee_ids="+employeeids+"&orgid="+orgid+"&childid="+childorgid,true);
	xmlhttp.send(); 

}
function View_Employee(keyid){
	document.getElementById('msg_box33').style.display='block';
	var emp_ids=document.getElementById('hidden_emp_data'+keyid+'').value;
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
	for(var i=0;i<=cnt;i++){//alert(i);
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
	if(document.getElementById('year')){
		var tnaid=document.getElementById('year').value;
		if(tnaid==''){
			alertify.alert("Please select the TNA Name");
			return false;
		}else{
			/* var org_id='';
			if(document.getElementById('child_org')){
				org_id=document.getElementById('child_org').value;
			}else{ */
				var org_idd=document.getElementById('org').value;
			//}
			if(org_idd!='')org_id=org_idd; else org_id="";
			//if(org_id!=''){
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
						var resp=xmlhttp.responseText.split('@#');
						document.getElementById("child_org").innerHTML="<option value=''>Select</option>"+resp[0];
						document.getElementById("competency_based").innerHTML=resp[1];
						/* if(document.getElementById('select_radio_0')){
							document.getElementById('select_radio_0').checked=true;
							Add_Info(0);
						} */
						var config = {
						'.chosen-select': {}
						}
						for (var selector in config) {
							$(selector).chosen(config[selector]);
						}
					}
				}
				xmlhttp.open("GET",BASE_URL+"/admin/tna_details_type?tnaid="+tnaid+"&org_id="+org_id,true);
				xmlhttp.send();
			/* }else{
				
			} */
		}
	}
}
function getTnaDetails_Childorg(){
	var tnaid=document.getElementById('year').value;
	if(tnaid==''){
		alertify.alert("Please select the TNA Name");
		return false;
	}else{		
		var org_id=document.getElementById('child_org').value;
		if(org_id!=''){
			$.ajax({
				type: 'GET',
				url: BASE_URL+"/admin/tna_details_type?tnaid="+tnaid+"&org_id="+org_id,
				success: function(resp_data){
					var resp=resp_data.split('@#');
					//document.getElementById("child_org").innerHTML="<option value=''>Select</option>"+resp[0];
					document.getElementById("competency_based").innerHTML=resp[1];
					if(document.getElementById('select_radio_0')){
						document.getElementById('select_radio_0').checked=true;
						Add_Info(0);
					}
					var config = {
					'.chosen-select': {}
					}
					for (var selector in config) {
						$(selector).chosen(config[selector]);
					}
				}
			});			
		}
	}
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
//Code starts for TNA Modification
function empty_data(){
	$('#category').val('');
	$('#program').val('');
	$('#month').val('');
	$('#days').val('');
	$('#participants').val('');
	$('#budget').val('');
	$('#trainer_type').val('');
	$('#trainer').val('');
	$('#criticality').val('');
	$('#text_id').val('');
	$('#empdetails').val('');
	$('#mngrdetails').val('');
	document.getElementById('godiv').innerHTML="<div class='form-actions center'><input type='button' name='data_save' id='data_save' value='Save' class='btn btn-sm btn-info' onclick='AddPrgmRow(&quot;&quot;)' />&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' onclick='close_modal(&quot;&quot;)' value='Cancel' class='btn btn-sm btn-danger'/></div>";
	Add_Manager();
	//Add_Employee();
}
function open_tnadata(key){
	document.getElementById('godiv').innerHTML="<div class='form-actions center'><input type='button' name='data_save' id='data_save' value='Save' class='btn btn-sm btn-info' onclick='AddPrgmRow("+key+")' />&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' onclick='close_modal("+key+")' value='Cancel' class='btn btn-sm btn-danger'/></div>";
	$('#category').val($('#cat_id'+key).val());	
	$('#other_program').val($('#pro_id'+key).val());
	$('#month').val($('#mnth_id'+key).val());
	$('#days').val($('#day_id'+key).val());
	$('#participants').val($('#participants'+key).val());
	$('#budget').val($('#budget'+key).val());
	$('#trainer_type').val($('#trainer_type'+key).val());
	$('#trainer').val($('#trainer'+key).val());
	$('#criticality').val($('#cri_id'+key).val());
	$('#text_id').val($('#com_data'+key).val());
	//alert("before function call");
	//$('#empdetails').val($('#hidden_emp_data'+key).val());	
	getPrograms(key);
	Add_Manager();	
	//alert("after function call");
	$('#program').val($('#pro_id'+key).val());	
	$('#mngrdetails').val($('#hidden_mngr_data'+key).val());
	//Add_Employee();
	getOtherProgram();
}
function getOtherProgram(){
	var prg=$('#program').val();
	if(prg=='o'){
		$('#othr_org').css('display','block');
	}
	else{
		$('#othr_org').css('display','none');
	}
}
function getTnaDetails_manager(){
	var tnaid=$('#year').val();
	var mngrid=$('#managerlist').val();
	if(mngrid!=''){
		$.ajax({
			type: "GET",
			url: BASE_URL+"/admin/tnaDataManager?tnaid="+tnaid+"&mngrid="+mngrid,
			success:function(resp){
				$("#competency_based").html(resp);			
				var config = {
				'.chosen-select': {}
				}
				for (var selector in config) {
					$(selector).chosen(config[selector]);
				}
			}
		});
	}
}


function open_hierarchy(){
	var id=document.getElementById('hierarchy_names').value;
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
			document.getElementById("hierarchy_org").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/open_data_hierarchy?id="+id,true);
	xmlhttp.send();
			
}

$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="yes"){
            $(".org_yes").show();
			$(".org_no").hide();
        }
        if($(this).attr("value")=="no"){
            $(".org_no").show();
			 $(".org_yes").hide();
        }
		
        
    });
});

$(document).ready(function(){
    $('input[id="insert_cat"]').click(function(){
        if($(this).attr("value")==5){
            $("#view_categories").toggle();
        }
        
    });
	$('input[id="insert_org"]').click(function(){
        if($(this).attr("value")==4){
			$("#view_organisation").toggle();
        }
    });
	$('input[id="allow_emp_update"]').click(function(){
        if($(this).attr("value")==1){
			$("#dates_emp").toggle();
        }
    });
	$('input[id="allow_manager_update"]').click(function(){
        if($(this).attr("value")==2){
			$("#dates_manager").toggle();
        }
    });
	$('input[id="allow_views"]').click(function(){
        if($(this).attr("value")==3){
			$("#dates_view_par").toggle();
        }
    });
	
	$('input[id="emp_initiate"]').click(function(){
        if($(this).attr("value")=='yes'){
			$("#openinitiate_emp").toggle();
        }
    });
	
	$('input[id="mngr_initiate"]').click(function(){
        if($(this).attr("value")=='yes'){
			$("#openinitiate_mngr").toggle();
        }
    });
	
});

function AddOrgRow_h(id){
	
	var tbl = document.getElementById("tna_orgs_tab_h");
	var lastRow = tbl.rows.length;
	var lastrow1= lastRow+1;
	var hiddtab="tna_hidden_id_h";
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
	
	$.ajax({
		type: 'GET',
		url: BASE_URL+"/admin/tna_add_h?tnah="+id+"&sub_iteration="+sub_iteration,
		success: function(resp_data){
			$("#tna_orgs_tab_h tbody").append(resp_data);
		}
	});	
	
	
	
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
	
}

function get_category(){
	var cat_id=document.getElementById('categorylist').value;
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
			document.getElementById("prorgam_view").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/open_program_view?cat_id="+cat_id,true);
	xmlhttp.send();
			
}

function get_locations(){
	var zone_id=document.getElementById('zones_code').value;
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
			document.getElementById("location_view").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/open_zone_view?zone_id="+zone_id,true);
	xmlhttp.send();
			
}

function getTnafullDetails(){
	var orgid=document.getElementById('org').value;
	var orgdepart=document.getElementById('org_depart').value;
	var tnaid=document.getElementById('year').value;
	var zones_code=document.getElementById('zones_code').value;
	var locations=document.getElementById('locations').value;
	var grades=document.getElementById('grades').value;
	var categorylist=document.getElementById('categorylist').value;
	var programlist=document.getElementById('programlist').value;
	var criticality=document.getElementById('criticality').value;
	var emp_no=document.getElementById('emp_no').value;
	var emp_no_manager=document.getElementById('emp_no_manager').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('competency_based').innerHTML="<h3 class='header smaller lighter grey'><i class='ace-icon fa fa-spinner fa-spin orange bigger-125'></i>Please wait your data is loading...</h3>"
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("competency_based").innerHTML=xmlhttp.responseText;
			$('.show-details-btn').on('click', function(e) {
				e.preventDefault();
				$(this).closest('tr').next().toggleClass('open');
				$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
			});
			$(function($) {
				var oTable1 =$('#sample-table-4').dataTable({bAutoWidth: false,	"aoColumns": [ null, null, null,null,null, null, null,null, null,null ]	});				
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/tna_details_type?tna_id="+tnaid+"&org_id="+orgid+"&org_departs="+orgdepart+"&zones_id="+zones_code+"&location_id="+locations+"&grade_id="+grades+"&category_id="+categorylist+"&program_id="+programlist+"&criticality_id="+criticality+"&emp_no_id="+emp_no+"&emp_no_manager_id="+emp_no_manager,true);
	xmlhttp.send();
}

function open_comments(key1,id){ 
	var comp_id=document.getElementById('manager_approval'+id).value;
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
			var html =xmlhttp.responseText;
			$("#comments"+key1).remove(  );
			$("#sub_tr"+key1).closest('tr').next().addClass('open');
			$("#divsub_tr"+key1).html(html);
			//jQuery("#sub_tr"+key1).after(html);
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/tna_comments_add?co_id="+id+"&com_value="+comp_id+"&key1="+key1,true);
	xmlhttp.send();	
	
}

function open_program_comments(id){
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
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
			document.getElementById("comment_info").innerHTML=xmlhttp.responseText;
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/admin_comment_info?admin_prg_id="+id,true);
	xmlhttp.send();

}

function setValue(){
	document.getElementById('bbb').value="1";
}

function setValue_method(){
	document.getElementById('bbb_method').value="1";
}

function setValue_population(){
	document.getElementById('bbb_population').value="1";
	var org=document.tna_form_tni_controls.tna_org_population.checked;
	var cat=document.tna_form_tni_controls.tna_cat_population.checked;
	var chkd = (document.tna_form_tni_controls.tna_emp_population.checked || document.tna_form_tni_controls.tna_mang_population.checked||  document.tna_form_tni_controls.tna_view_population.checked) && document.tna_form_tni_controls.tna_org_population.checked && document.tna_form_tni_controls.tna_cat_population.checked;
	if (chkd) {
		if(org){
			var tbl = document.getElementById("tna_orgs_tab_h");
			var lastRow = tbl.rows.length;
			var lastrow1= lastRow+1;
			var hiddtab="tna_hidden_id_h";
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
		else{
			return true;
		}
      //Submit the form
    } else {
	alertify.alert("please check the checkbox if you want Allow Employee to Add/update or Allow Manager to Add/update or Allow Employee and Manager only to view and please add organisations and please add categories");
      return false; //Prevent it from being submitted
    }
}

function total_validation(){
	
	var chkd = document.tna_form_tni_controls.tna_emp_population.checked || document.tna_form_tni_controls.tna_mang_population.checked||  document.tna_form_tni_controls.tna_view_population.checked && document.tna_form_tni_controls.tna_org_population.checked && document.tna_form_tni_controls.tna_cat_population.checked;
	if (chkd) {
      return true; //Submit the form
    } else {
	alertify.alert("please check the checkbox if you want Allow Employee to Add/update or Allow Manager to Add/update or Allow Employee and Manager only to view and please add organisations and please add categories");
      return false; //Prevent it from being submitted
    }
}

function open_reload(){
	window.location.reload();
}

$('#bulkempupload').ace_file_input({
	no_file:'No File ...',
	btn_choose:'Choose',
	btn_change:'Change',
	droppable:true,
	onchange:null,
	thumbnail:false //| true | large
	//whitelist:'gif|png|jpg|jpeg'
	//blacklist:'exe|php'
	//onchange:''
	//
});
$(document).on('click', 'th input:checkbox' , function(){
	var that = this;
	$(this).closest('table').find('tr > td:first-child input:checkbox')
	.each(function(){
		this.checked = that.checked;
		$(this).closest('tr').toggleClass('selected');
	});
});

$(function(){
	var files;
	$('input[type=file]').on('change', prepareUpload);
	$('#bulk_upload').on('click', uploadFiles);
	// Grab the files and set them to our variable
	function prepareUpload(event){
		files = event.target.files;
	}
	// Catch the form submit and upload the files
	function uploadFiles(event){
		var browse=document.getElementById('bulkempupload').value;
		var tna_id=document.getElementById('tna_id').value;
		if(browse==''){
			alertify.alert("Please Select File");
			return false;
		}
		event.stopPropagation(); // Stop stuff happening
		event.preventDefault(); // Totally stop stuff happening
		// START A LOADING SPINNER HERE

		// Create a formdata object and add the files
		var data = new FormData();
		$.each(files, function(key, value){
			data.append(key, value);
		});   
		document.getElementById('bulk_search_data').innerHTML="Loading Data ......";
		$.ajax({
			url: BASE_URL+"/admin/upload_tnabulk_emp?files&tna_id="+tna_id,
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			
			success: function(data, textStatus, jqXHR){
				if(typeof data.error === 'undefined'){
					// Success so call function to process the form
					//alertify.alert(data);
					document.getElementById('bulk_search_data').innerHTML=data;
					//document.getElementById('enrol_emp_no').value='';
				//submitForm(event, data);
				}
				else{
					// Handle errors here
					console.log('ERRORS: ' + data.error);
					document.getElementById('bulk_search_data').innerHTML="Please Contact Admin Team.";
					//alertify.alert(data);
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				alertify.alert(data);
				document.getElementById('bulk_search_data').innerHTML="Please Contact Admin Team.";
				// STOP LOADING SPINNER
			}
		});
	}
        
	function submitForm(event, data){
		// Create a jQuery object from the form
		$form = $(event.target);

		// Serialize the form data
		var formData = $form.serialize();

		// You should sterilise the file names
		/*$.each(data.files, function(key, value){
			formData = formData + '&filenames[]=' + value;
		});*/
		formData=data;
		$.ajax({
			url: BASE_URL+"/admin/upload_tnabulk_emp",
			type: 'POST',
			data: formData,
			cache: false,
			dataType: 'json',
			success: function(data, textStatus, jqXHR){
				if(typeof data.error === 'undefined'){
					alertify.alert(data);
					// Success so call function to process the form
					console.log('SUCCESS: ' + data.success);
				}
				else{
					// Handle errors here                                
					console.log('ERRORS: ' + data.error);
			   }
		   },
		   error: function(jqXHR, textStatus, errorThrown){
			   // Handle errors here
				console.log('ERRORS: ' + textStatus);
			},
			complete: function(){
				// STOP LOADING SPINNER
			}
		});
	}
});


function reminder_mail_emp(id){
	var emp_rem=document.getElementById('emp_rem').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('tna_emp').innerHTML="<img style='height:150px;width:150px;' src='"+BASE_URL+"/public/images/outsell_loading.gif'/>";
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("tna_emp").innerHTML=xmlhttp.responseText;
			window.location.reload();
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/tna_emp_reminder?tna_id="+id+"&emp_type="+emp_rem,true);
	xmlhttp.send();

}

function reminder_mail_mngr(id){
	var mngr_rem=document.getElementById('mngr_rem').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('mngr_emp').innerHTML="<img style='height:150px;width:150px;' src='"+BASE_URL+"/public/images/outsell_loading.gif'/>";
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("mngr_emp").innerHTML=xmlhttp.responseText;
			window.location.reload();
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/tna_mngr_reminder?tna_id="+id+"&mngr_type="+mngr_rem,true);
	xmlhttp.send();

}

function open_max(id){
	if(document.getElementById('cat_id_'+id).checked){
		document.getElementById('cat'+id).style.display="block";
	}
	else{
		document.getElementById('cat'+id).style.display="none";
	} 
	
}




