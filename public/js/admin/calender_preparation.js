jQuery(document).ready(function(){
	jQuery("#calendar_preparation").validationEngine();
	
	$('.datepicker').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
});
$(document).ready(function(){
	var dates = $( "#from_date1, #to_date1" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	onSelect: function( selectedDate ) { 
		var option = this.id == "from_date1" ? "minDate" : "maxDate",
		instance = $( this ).data( "datepicker" ),
		date = $.datepicker.parseDate(
		instance.settings.dateFormat ||
		$.datepicker._defaults.dateFormat,
		selectedDate, instance.settings );
		dates.not( this ).datepicker( "option", option, date );
	}
	});

});
function addsource_details_programs(){
	var hiddtab="addgroup";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=parseInt(ins1[j]);
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j]; 
			var program_id=document.getElementById('program_id'+i).value;
			var category_id=document.getElementById('category_id'+i).value;
			if(category_id==''){
				alertify.alert("Please Select Category Name.");
				return false;
			}
			if(program_id==''){
				alertify.alert("Please select Program Name.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var program_id1=document.getElementById('program_id'+l).value;
				if(k!=j){
					if(program_id==program_id1){
						alertify.alert("Program name should be Unique");
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
    
	if(cat_detail!=''){
        var category_details=cat_detail.split(',');
        var cat_ids='';
        for(var i=0;i<category_details.length;i++){
            cat1=category_details[i];
            cat2=cat1.split('*');
            if(cat_ids==''){
                cat_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                cat_ids=cat_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        cat_ids='';
    }
	
	$("#source_table_programs").append("<tr id='subgrd"+sub_iteration+"'><td><input type='checkbox' id='chkbox"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='calendar_program_id"+sub_iteration+"' name='calendar_program_id[]' value=''></td><td><select name='category_id[]' id='category_id"+sub_iteration+"' onchange='open_programs("+sub_iteration+");' style='width:200px;'><option value=''>Select</option>"+cat_ids+"</select></td><td style='text-align:center'><select name='program_id[]' id='program_id"+sub_iteration+"' style='width:400px;'><option value=''>Select</option></select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}
function open_program_events(id,cal_id,cal_month_id,pro_id){
	document.getElementById("program_info_emp").innerHTML="";
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
			document.getElementById("program_info_emp").innerHTML=xmlhttp.responseText;
			var start_day=document.getElementById("hidden_start_day").value;
			var end_day=document.getElementById("hidden_end_day").value;
			var month_name=document.getElementById("hidden_month_name").value;
			var year_name=document.getElementById("hidden_year_name").value;
			jQuery("#calendar_preparation_event").validationEngine();
			var startDate = new Date(year_name, month_name, start_day);
			var endDate = new Date(year_name, month_name, end_day);
			var dates = $( "#start_date1, #end_date1" ).datepicker({dateFormat:"dd-mm-yy",
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			minDate: startDate,
			maxDate: endDate,
			onSelect: function( selectedDate ) { 
				var option = this.id == "start_date1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
				selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/calender_program_events_location_head?pro_id="+id+"&cal_id="+cal_id+"&cal_month_id="+cal_month_id+"&program_id="+pro_id,true);
	xmlhttp.send();

}


function activation_validation(){
	var hiddtab="addgroup";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=parseInt(ins1[j]);
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j]; 
			var code=document.getElementById('category_id'+i).value;
			var name=document.getElementById('program_id'+i).value;
			//var des=document.getElementById('status'+i).value;
			if(code==''){
				alertify.alert("Please select Category.");
				return false;
			}
			if(name==''){
				alertify.alert("Please select Program.");
				return false;
			}
			/* if(des==''){
				alertify.alert("Please select status.");
				return false;
			} */
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var name1=document.getElementById('program_id'+l).value;
				if(k!=j){
					if(name==name1){
						alertify.alert("Program Name should be Unique");
						return false;
					}
				}
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
}

function delete_sourcedetails_programs(){
	var hiddtab="addgroup";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('source_table_programs');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		var a="chkbox"+bb;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd"+bb+"";
			//alert(b);
			var calendar_act_id=document.getElementById("calendar_program_id"+bb).value;
			//alert(calendar_act_id);
			if(calendar_act_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_calendar_programs",
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
				if(parseInt(arr1[j])==bb) {
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


function checkUnieve(field, rules, i, options){
	var url = BASE_URL+"/index/eventname";
	var event_id=$("#event_id").val();
	var id=field.attr("id");
    var data = "fieldId="+field.attr("id")+"&fieldValue="+field.val()+"&event_id="+event_id;//field.attr("id") + "=" + field.val();
    var msg = undefined;
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        dataType: "json",
        data: data,
        async: false,
        success: function(json) {
            if(!json[1]) {
                msg = json[1];
            }
        }            
    });  
    if(msg != undefined) {
        return options.allrules.checkUnieve.alertText;
    }
}

function open_programs(id){
	var cat_id=document.getElementById('category_id'+id).value;
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
			document.getElementById("program_id"+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/open_view_program?cat_id="+cat_id+"&key="+id,true);
	xmlhttp.send();
			
}

function addsource_details(){
	var hiddtab="addgroup_event";
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
			var event_name=document.getElementById('event_name'+i).value;
			var start_date=document.getElementById('start_date'+i).value;
			var end_date=document.getElementById('end_date'+i).value;
			var duration=document.getElementById('duration'+i).value;
			var units=document.getElementById('units'+i).value;
			var nstatus=document.getElementById('status'+i).value;
			var res_trainer_id=document.getElementById('res_trainer_id'+i).value;
			var res_venue_id=document.getElementById('res_venue_id'+i).value;
			if(event_name==''){
				alertify.alert("Please Event name.");
				return false;
			}
			if(start_date=='' && end_date==''){
				alertify.alert("From Date and To Date Both can not be empty");
				return false;
			}
			if(start_date=='' && end_date!=''){
				alertify.alert("You can not give To Date without giving From Date");
				return false;
			}
			if(end_date==''){
				alertify.alert("You can not Add new program without giving To Date to the current program");
				return false;
			}
			if(duration==''){
				alertify.alert("Please enter Duration.");
				return false;
			}
			if(units==''){
				alertify.alert("Please select Units.");
				return false;
			}
			if(nstatus==''){
				alertify.alert("Please select Status.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var event_name1=document.getElementById('event_name'+l).value;
				var start_date1=document.getElementById('start_date'+l).value;
				var end_date1=document.getElementById('end_date'+l).value;
				var res_trainer_id1=document.getElementById('res_trainer_id'+l).value;
				var res_venue_id1=document.getElementById('res_venue_id'+l).value;
				if(k!=j){
					if(event_name==event_name1){
						alertify.alert("Event name should be Unique");
						return false;
					}
					if((start_date1==start_date) && (end_date1==end_date) && (res_trainer_id1==res_trainer_id) && (res_venue_id1==res_venue_id)){
						alertify.alert("Trainer and venue cannot be on the same dates");
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
    
	
	if(status_detail!=''){
        var status_detail_n=status_detail.split(',');
        var status_ids='';
        for(var i=0;i<status_detail_n.length;i++){
            status1=status_detail_n[i];
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
	if(unit_detail!=''){
        var unit_details=unit_detail.split(',');
        var unit_ids='';
        for(var i=0;i<unit_details.length;i++){
            unit1=unit_details[i];
            unit2=unit1.split('*');
            if(unit_ids==''){
                unit_ids="<option value='"+unit2[0]+"'>"+unit2[1]+"</option>";
            }else{
                unit_ids=unit_ids+"<option value='"+unit2[0]+"'>"+unit2[1]+"</option>";
            }
        }
    }else{
        unit_ids='';
    }
	if(trainer_detail!=''){
        var trainer_details=trainer_detail.split(',');
        var tra_ids='';
        for(var i=0;i<trainer_details.length;i++){
            tra1=trainer_details[i];
            tra2=tra1.split('*');
            if(tra_ids==''){
                tra_ids="<option value='"+tra2[0]+"'>"+tra2[1]+"</option>";
            }else{
                tra_ids=tra_ids+"<option value='"+tra2[0]+"'>"+tra2[1]+"</option>";
            }
        }
    }else{
        tra_ids='';
    }
	if(venue_detail!=''){
        var venue_details=venue_detail.split(',');
        var ven_ids='';
        for(var i=0;i<venue_details.length;i++){
            ven1=venue_details[i];
            ven2=ven1.split('*');
            if(ven_ids==''){
                ven_ids="<option value='"+ven2[0]+"'>"+ven2[1]+"</option>";
            }else{
                ven_ids=ven_ids+"<option value='"+ven2[0]+"'>"+ven2[1]+"</option>";
            }
        }
    }else{
        ven_ids='';
    }
	
	
	$("#source_table").append("<tr id='subgrd_event"+sub_iteration+"'><td><input type='checkbox' id='chkbox"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='calendar_event_id"+sub_iteration+"' name='calendar_event_id[]' value=''></td><td><input type='text' class='validate[required,minSize[2], maxSize[150] ,custom[alphanumericSp],funcCall[checkUnieve]] input-large' name='event_name[]' id='event_name"+sub_iteration+"' value='' style='width:200px'></td><td><div class='input-group'><input type='text' class='validate[required, custom[date2]] datepicker form-control date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' name='start_date[]' id='start_date"+sub_iteration+"' value=''  style='width:100px'><span class='input-group-addon'><i class='ace-icon fa fa-calendar'></i></span></div></td><td><div class='input-group'><input type='text' class='validate[custom[date2],future[#start_date1]] datepicker form-control date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' name='end_date[]' id='end_date"+sub_iteration+"' value=''  style='width:100px'><span class='input-group-addon'><i class='ace-icon fa fa-calendar'></i></span></div></td><td><input type='text' class='validate[required, custom[onlyNumberSp]] col-xs-4 col-sm-4' name='duration[]' id='duration"+sub_iteration+"' value='' maxlength='3'><select name='units[]' id='units"+sub_iteration+"' class='validate[required] col-xs-8 col-sm-8'><option value=''>Select</option>"+unit_ids+"</select></td><td><select name='res_trainer_id[]' id='res_trainer_id"+sub_iteration+"' class='input-small' style='width:200px'><option value=''>Select</option>"+tra_ids+"</select></td><td><select name='res_venue_id[]' id='res_venue_id"+sub_iteration+"' class='input-small' style='width:200px'><option value=''>Select</option>"+ven_ids+"</select></td><td><select name='status[]' id='status"+sub_iteration+"' class='input-small'><option value=''>Select</option>"+status_ids+"</select></td></tr>");
	var start_day=document.getElementById("hidden_start_day").value;
	var end_day=document.getElementById("hidden_end_day").value;
	var month_name=document.getElementById("hidden_month_name").value;
	var year_name=document.getElementById("hidden_year_name").value;
	var startDate = new Date(year_name, month_name, start_day);
	var endDate = new Date(year_name, month_name, end_day);
	$(document).ready(function(){
		var date1 = new Date();
		var date2 = new Date(2039,0,19);
		var timeDiff = Math.abs(date2.getTime() - date1.getTime());
		var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
		var dates = $( "#start_date"+sub_iteration+", #end_date"+sub_iteration+"" ).datepicker({
			dateFormat:"dd-mm-yy",
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			minDate: startDate,
			maxDate: endDate,
			/*minDate:0,
			maxDate:difDays,*/
			onSelect: function( selectedDate ) {
				var option = this.id === "start_date"+sub_iteration+"" ? "minDate" : "maxDate", instance = $( this ).data( "datepicker" ),date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat,selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
		if($("#end_date"+sub_iteration+"").val()!=""){
			$( "#start_date"+sub_iteration+"" ).datepicker("option", "maxDate", $("#end_date"+sub_iteration+"").val());
		}
		if($("#start_date"+sub_iteration+"").val()!=""){
			$( "#end_date"+sub_iteration+"" ).datepicker("option", "minDate", $("#start_date"+sub_iteration+"").val());
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

function delete_sourcedetails(){
	var hiddtab="addgroup_event";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('source_table');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="chkboxevent"+bb+"";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd_event"+bb;
			//alert(b);
			var calendar_act_id=document.getElementById("calendar_event_id"+bb).value;
			//alert(calendar_act_id);
			if(calendar_act_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_emp_event_activation",
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
				if(arr1[j]==bb) {
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


function event_activation_validation(){
	var hiddtab="addgroup_event";
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
			var event_name=document.getElementById('event_name'+i).value;
			var start_date=document.getElementById('start_date'+i).value;
			var end_date=document.getElementById('end_date'+i).value;
			var duration=document.getElementById('duration'+i).value;
			var units=document.getElementById('units'+i).value;
			var nstatus=document.getElementById('status'+i).value;
			
			if(event_name==''){
				alertify.alert("Please Event name.");
				return false;
			}
			if(start_date=='' && end_date==''){
				alertify.alert("From Date and To Date Both can not be empty");
				return false;
			}
			if(start_date=='' && end_date!=''){
				alertify.alert("You can not give To Date without giving From Date");
				return false;
			}
			if(end_date==''){
				alertify.alert("You can not Add new program without giving To Date to the current program");
				return false;
			}
			if(duration==''){
				alertify.alert("Please enter Duration.");
				return false;
			}
			if(units==''){
				alertify.alert("Please select Units.");
				return false;
			}
			if(nstatus==''){
				alertify.alert("Please select Status.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var event_name1=document.getElementById('event_name'+l).value;
				if(k!=j){
					if(event_name==event_name1){
						alertify.alert("Event name should be Unique");
						return false;
					}
				}
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
}
