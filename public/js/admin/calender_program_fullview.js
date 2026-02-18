jQuery(document).ready(function(){
	jQuery("#calendar_preparation").validationEngine();
	$('.datepicker').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
});
$('.chosen-toggle').each(function(index) {
    $(this).on('click', function(){
         $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
    });
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
function addsource_details(id){
	var hiddtab="addgroup"+id;
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
		//alert(sub_iteration);
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];
			var category_id=document.getElementById('category_id_'+i+'_'+id).value;
			var program_id=document.getElementById('program_id_'+i+'_'+id).value;
			var zone_id=document.getElementById('zone_id_'+i+'_'+id).value;
			var loc_id=document.getElementById('location_id_'+i+'_'+id).value;
			if(category_id==''){
				alertify.alert("Please Select Category name.");
				return false;
			}
			if(program_id==''){
				alertify.alert("Please select Program Name.");
				return false;
			}
			if(zone_id==''){
				alertify.alert("Please select Zones.");
				return false;
			}
			if(loc_id==''){
				alertify.alert("Please select Location.");
				return false;
			}
			
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var program_id1=document.getElementById('program_id_'+l+'_'+id).value;
				var zone_id1=document.getElementById('zone_id_'+l+'_'+id).value;
				if(k!=j){
					if((program_id==program_id1) && (zone_id==zone_id1)){
						alertify.alert("Zones Selection should be Unique");
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
	
	if(zone_detail!=''){
        var zones_details=zone_detail.split(',');
        var zone_ids='';
        for(var i=0;i<zones_details.length;i++){
            zone1=zones_details[i];
            zone2=zone1.split('*');
            if(zone_ids==''){
                zone_ids="<option value='"+zone2[0]+"'>"+zone2[1]+"</option>";
            }else{
                zone_ids=zone_ids+"<option value='"+zone2[0]+"'>"+zone2[1]+"</option>";
            }
        }
    }else{
        zone_ids='';
    }
	
	$("#source_table"+id).append("<tr id='subgrd"+sub_iteration+"_"+id+"'><td><input type='checkbox' id='chkbox"+sub_iteration+"_"+id+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='calendar_program_id"+sub_iteration+"' name='calendar_program_id["+id+"][]' value=''></td><td><select name='category_id["+id+"][]' id='category_id_"+sub_iteration+"_"+id+"' onchange='open_programs("+sub_iteration+","+id+");' style='width:200px;'><option value=''>Select</option>"+cat_ids+"</select></td><td style='text-align:center'><select name='program_id["+id+"][]' id='program_id_"+sub_iteration+"_"+id+"' style='width:350px;'><option value=''>Select</option></select></td><td ><select  name='zone_id["+id+"][]' id='zone_id_"+sub_iteration+"_"+id+"' style='width:120px;' onchange='open_locations("+sub_iteration+","+id+");'><option value=''>Select</option>"+zone_ids+"</select></td><td><select name='location_id["+id+"]["+sub_iteration+"][]' id='location_id_"+sub_iteration+"_"+id+"' style='width:250px;' multiple class='chosen-select input-xlarge'><option value=''>Select</option></select></td></tr>");
	$(".chosen-select").chosen();
	/* <select  multiple class='chosen-select input-xlarge' name='zone_id["+id+"]["+sub_iteration+"][]' id='zone_id_"+sub_iteration+"_"+id+"' style='width:300px;'>"+zone_ids+"</select> */
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

function delete_sourcedetails(id){
	var hiddtab="addgroup"+id;
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('source_table'+id);
	var lastRow = tbl.rows.length;
	
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="chkbox"+bb+"_"+id;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd"+bb+"_"+id;
			//alert(b);
			var calendar_act_id=document.getElementById("calendar_program_id"+b+"").value;
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


function search_data(){
	var location_id=document.getElementById('location_details').value;
	var employee_id=document.getElementById('employee_details').value;
	var calendar_month_id=document.getElementById('calendar_month_id').value;
	var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('source_table').innerHTML="loading..."
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('source_table').innerHTML=xmlhttp.responseText;
		}
	}
	
	xmlhttp.open("GET",BASE_URL+"/admin/program_preparation_view_source?calendar_month_id="+calendar_month_id+"&location_id="+location_id+"&employee_id="+employee_id,true);
	xmlhttp.send();
}

function open_programs(id,mid){
	var cat_id=document.getElementById('category_id_'+id+'_'+mid).value;
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
			document.getElementById("program_id_"+id+"_"+mid).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/open_program_view_calender?cat_id="+cat_id+"&key="+id+"&month_id="+mid,true);
	xmlhttp.send();
			
}

function open_publish(){
	$("#publish").show();
}

function calendar_publish(){
	var cal_id=document.getElementById('calendar_id_submit').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('mail_calendar').innerHTML="<img style='height:150px;width:150px;' src='"+BASE_URL+"/public/images/outsell_loading.gif'/>";
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("mail_calendar").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/calendar_full_publish?cal_id="+cal_id,true);
	xmlhttp.send();
			
}

function open_locations(id,mid){
	var zid=document.getElementById('zone_id_'+id+'_'+mid).value;
	var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//document.getElementById('workinfodetails').innerHTML="loading..."
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('location_id_'+id+'_'+mid).innerHTML=xmlhttp.responseText;
			$('#location_id_'+id+'_'+mid).chosen().trigger('chosen:updated');
		}
	}
	
	xmlhttp.open("GET",BASE_URL+"/admin/open_location_view_calender?z_id="+zid+"&key="+id+"&month_id="+mid,true);
	xmlhttp.send();
}
