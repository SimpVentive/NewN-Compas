jQuery(document).ready(function(){
	jQuery("#positionform").validationEngine({validateNonVisibleFields: true, updatePromptsPosition:true});
	/* $('#editor1').ace_wysiwyg(); */
	
	
});
$(function () {
	$(".js-source-states-2").select2();
});
$(document).ready(function(){
	var dates = $( "#start_date_active, #end_date_active" ).datepicker({
		dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "start_date_active" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});

function open_competency(id){ 
	var comp_id=document.getElementById('comp_position_competency_id_'+id).value;
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
			
			document.getElementById('method_id_details_'+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/position_competency_scale?com_id="+comp_id+"&r_id="+id,true);
	xmlhttp.send();	
	
}

function pos_scale_details(id){ 
	var level_id=document.getElementById('comp_position_level_id_'+id).value;
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
			
			document.getElementById('scale_id_details_'+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/position_scale_competency?level_id="+level_id+"&r_id="+id,true);
	xmlhttp.send();	
	
}
$(document).ready(function() {
    $("#content div").hide(); // Initially hide all content
    $("#tabs li:first").attr("id","current"); // Activate first tab
    // $("#content div:first").fadeIn(); // Show first tab content
    
    $('#tabs a').click(function(e) {
        e.preventDefault();        
        $("#content div").hide(); //Hide all content
        $("#tabs li").attr("id",""); //Reset id's
        $(this).parent().attr("id","current"); // Activate this
       $('#' + $(this).attr('id')).show();
       //alertify.alert($('#' + $(this).attr('id')).css('height'));
        if($('#' + $(this).attr('id')).css('display')=='block'){
        
        var aaheight=$(".right_content").css("height");
	aaheight=aaheight.replace("px","");
	aaheight=parseInt(aaheight);
	if(aaheight>475){
		$( '#menu' ).css("height",(aaheight+10)+"px");
		$( '#menu_multilevelpushmenu' ).css("height",(aaheight+10)+"px");
		$( '.multilevelpushmenu_wrapper .levelHolderClass').css("minHeight",(aaheight+10)+"px");
	}
	else{
		$( '#menu' ).css("height","475px");
		$( '#menu_multilevelpushmenu' ).css("height","475px");
                $( '#menu' ).css("minHeight","475px");
		$( '#menu_multilevelpushmenu' ).css("minHeight","475px");
	}
    }

    });
});

$(document).ready(function() {
	$('.nav-tabs li').click(function(event){
		if ($(this).hasClass('disabled')) {
			return false;
		}
	});
	if(eve_stat!=''){
		if(eve_stat=='evaluation'){
			$('#evaluate_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#evaluate_def').addClass('active');
		}
	}
	else{
		$("#event_li").addClass('active');
		$("#event_def").addClass('active');
		$('#evaluate_def').removeClass('active');
	} 
});

function addcompetencyposition(){
    var table = document.getElementById('competencyposTab');
    var rowCount = table.rows.length;
	var dd="addgroup_position";
	var s=document.getElementById(dd).value;
	//toastr.error(s);
	if(s!=''){ 
		s=s.split(",");
		// toastr.error(s.length);
		for(var i=0;i<s.length;i++){var b=s[i];
			var competency_id=document.getElementById('comp_position_competency_id_'+b).value;
			//var level_id=document.getElementById('comp_position_level_id_'+b).value;
			var scale_id=document.getElementById('comp_position_level_scale_id_'+b).value;
			var criticality_id=document.getElementById('comp_position_criticality_id_'+b).value;
			if(competency_id==''){
				toastr.error("Please select competency name.");
				return false;
			}
			/* if(level_id==''){
				toastr.error("Please select Level To.");
				return false;
			} */
			if(scale_id==''){
				toastr.error("Same select Scale name.");
				return false;
			}
			if(criticality_id==''){
				toastr.error("Same select Criticality.");
				return false;
			}
            
			for(var j=0;j<s.length;j++){
				var bb=s[j];
				if(j!=i){
					var competency_id1=document.getElementById('comp_position_competency_id_'+bb).value;
					if(competency_id1==competency_id){
						toastr.error("Competency Name should be Unique.");
						document.getElementById('comp_position_competency_id_'+bb).value='';
						document.getElementById('comp_position_competency_id_'+bb).focus();
						return false;
					}
                }
            }
        }
    }
	var temp2=0;	
	var employeecount=document.getElementById(dd).value;
	employeecount=employeecount.split(",");
	var asdf=employeecount.length-1;
	for(var k=0; k<employeecount.length; k++){	
		if(parseInt(temp2)<parseInt(employeecount[k])){
			temp2=employeecount[k];
		}
	}
	var p=parseInt(temp2)+1;
	if(document.getElementById(dd).value==""){
		employeecount=1;
		p=1;
	}
	else{employeecount.push(p);}
	document.getElementById(dd).value=employeecount;
	// var rowcou=parseInt(iteration)+1;
	// To fetch method type option from .php page
	var competency_details_status_n="";
    if(competency_detailsms!=''){
        var competency_details_n=competency_detailsms.split(',');
        competency_details_status_n=competency_details_status_n+"<optgroup label='MS'>";
        for(var i=0;i<competency_details_n.length;i++){
            competency_details_n1=competency_details_n[i];
            competency_details_n2=competency_details_n1.split('*');
            if(competency_details_status_n==''){
                competency_details_status_n="<option value='"+competency_details_n2[0]+"'>"+competency_details_n2[1]+"</option>";
            }else{
                competency_details_status_n=competency_details_status_n+"<option value='"+competency_details_n2[0]+"'>"+competency_details_n2[1]+"</option>";
            }
        }
		competency_details_status_n=competency_details_status_n+"</opgroup>";
    }
	
	if(competency_detailsnms!=''){
        var competency_details_n=competency_detailsnms.split(',');
        competency_details_status_n=competency_details_status_n+"<optgroup label='NMS'>";
        for(var i=0;i<competency_details_n.length;i++){
            competency_details_n1=competency_details_n[i];
            competency_details_n2=competency_details_n1.split('*');
            if(competency_details_status_n==''){
                competency_details_status_n="<option value='"+competency_details_n2[0]+"'>"+competency_details_n2[1]+"</option>";
            }else{
                competency_details_status_n=competency_details_status_n+"<option value='"+competency_details_n2[0]+"'>"+competency_details_n2[1]+"</option>";
            }
        }
		competency_details_status_n=competency_details_status_n+"</opgroup>";
    }
	
	
	
	// To fetch method type option from .php page
    if(criticality_details!=''){
        var criticality_details_n=criticality_details.split(',');
        var criticality_details_status_n='';
        for(var i=0;i<criticality_details_n.length;i++){
            criticality_details_n1=criticality_details_n[i];
            criticality_details_n2=criticality_details_n1.split('*');
            if(criticality_details_status_n==''){
                criticality_details_status_n="<option value='"+criticality_details_n2[0]+"'>"+criticality_details_n2[1]+"</option>";
            }else{
                criticality_details_status_n=criticality_details_status_n+"<option value='"+criticality_details_n2[0]+"'>"+criticality_details_n2[1]+"</option>";
            }
        }
    }else{
        criticality_details_status_n='';
    }
	
	var row = table.insertRow(rowCount);
	var cell1 = row.insertCell(0);
	cell1.style.valign="middle";
	//cell1.style.textAlign="center";
	cell1.innerHTML="<div style='padding-left:18px;'><input  type='checkbox' name='chkbox[]' id='chkbox_"+p+"'  value='' /></div>";
	var cell2 = row.insertCell(1);
	cell2.style.valign="middle";
	cell2.style.textAlign="center";
	cell2.innerHTML="<select name='comp_position_competency_id[]' id='comp_position_competency_id_"+p+"'  style='width:100%;' class='form-control m-b' onchange='open_competency("+p+");'><option value=''>Select</option>"+competency_details_status_n+"</select>";
	var cell3 = row.insertCell(2);
	cell3.style.valign="middle";
	//cell2.style.textAlign="center";
	cell3.innerHTML="<div id='method_id_details_"+p+"'><select name='comp_position_level_scale_id[]' id='comp_position_level_scale_id_"+p+"'  style='width:100%;' class='form-control m-b'><option value=''>Select</option></select></div>";
	
	var cell4=row.insertCell(3);
	cell4.style.valign="middle";
	//cell3.style.textAlign="center";
	cell4.innerHTML="<select name='comp_position_criticality_id[]' id='comp_position_criticality_id_"+p+"' style='width:100%;' class='form-control m-b'><option value=''>Select</option>"+criticality_details_status_n+"</select>";
	
}

function deletecompetencyposition(){
	var table = document.getElementById('competencyposTab');
	var s=document.getElementById("addgroup_position").value;
	var spli=s.split(",");
	var flag=0; //toastr.error(spli);
	var len=spli.length;
	// toastr.error(len);
	for(var m=len;m >0; m--){
		var kk=m-1;
		//  toastr.error(m);
		var fd=spli[kk]
		//  toastr.error(fd);
		var ddd="chkbox_"+fd;
		// toastr.error(ddd);
		if(document.getElementById(ddd).checked==true){
			flag++;
		}
	}
	if(flag>0){
		// toastr.error(len);
		var jinit=parseInt(len);
		// toastr.error(jinit);
		for(var j=jinit; j>0; j--){
			var k=j-1;
			var dd="chkbox_"+spli[k];
			//toastr.error(dd);
			if(document.getElementById(dd).checked==true){ // toastr.error(j);
				var cc=document.getElementById(dd).value; 
				// toastr.error(cc);
				if(cc!==""){
					$.ajax({      //  toastr.error(gid);
						url: BASE_URL+"/admin/deletetecompetencylevels",
						global: false,
						type: "POST",
						data: ({id : cc}),
						dataType: "html",
						async:false,
						success: function(msg){         // toastr.error(msg);
						}
					}).responseText;
				}
				var hh=j-1;
				spli.splice(hh,1);
				table.deleteRow(j);
				len=spli.length;
				// toastr.error(len);
				// break;
			}
		}
	}
	else if(flag==0){
		toastr.error("Please select the record");
		return false;
	}
	//  toastr.error(spli);
	document.getElementById("addgroup_position").value=spli;
}

function addcompetencykra(id){
    var table = document.getElementById('competencykraTab_'+id);
    var rowCount = table.rows.length;
	var dd="addgroup_kra_"+id;
	var s=document.getElementById(dd).value;
	//alertify.alert(s);
	if(s!=''){ 
		s=s.split(",");
		// alertify.alert(s.length);
		for(var i=0;i<s.length;i++){var b=s[i];
			var comp_kra_steps=document.getElementById("comp_kra_steps_"+b+"_"+id).value;
			if(comp_kra_steps==''){
				toastr.error("Please enter KRA Steps.");
				return false;
			}
        }
    }
	var temp2=0;	
	var employeecount=document.getElementById(dd).value;
	employeecount=employeecount.split(",");
	var asdf=employeecount.length-1;
	for(var k=0; k<employeecount.length; k++){	
		if(parseInt(temp2)<parseInt(employeecount[k])){
			temp2=employeecount[k];
		}
	}
	var p=parseInt(temp2)+1;
	if(document.getElementById(dd).value==""){
		employeecount=1;
		p=1;
	}
	else{employeecount.push(p);}
	document.getElementById(dd).value=employeecount;
	
	var row = table.insertRow(rowCount);
	var cell1 = row.insertCell(0);
	cell1.style.valign="middle";
	//cell1.style.textAlign="center";
	cell1.innerHTML="<div style='padding-left:18px;'><input  type='checkbox' name='chkbox[]' id='chkbox_"+p+"'  value='' /></div>";
	var cell2 = row.insertCell(1);
	cell2.style.valign="middle";
	//cell2.style.textAlign="center";
	cell2.innerHTML="<input type='hidden' id='comp_kra_id_"+p+"_"+id+"' name='comp_kra_id[]' maxlength='10' value=''><textarea style='resize:none; width: 90%;' name='comp_kra_steps[]' id='comp_kra_steps_"+p+"' ></textarea>";
	
}

function deletecompetencykra(id){
	var table = document.getElementById('competencykraTab_'+id);
	var s=document.getElementById("addgroup_kra_"+id).value;
	var spli=s.split(",");
	var flag=0; //alertify.alert(spli);
	var len=spli.length;
	// alertify.alert(len);
	for(var m=len;m >0; m--){
		var kk=m-1;
		//  alertify.alert(m);
		var fd=spli[kk]
		//  alertify.alert(fd);
		var ddd="chkbox_"+fd;
		// alertify.alert(ddd);
		if(document.getElementById(ddd).checked==true){
			flag++;
		}
	}
	if(flag>0){
		// alertify.alert(len);
		var jinit=parseInt(len);
		// alertify.alert(jinit);
		for(var j=jinit; j>0; j--){
			var k=j-1;
			var dd="chkbox_"+spli[k];
			//alertify.alert(dd);
			if(document.getElementById(dd).checked==true){ // alertify.alert(j);
				var cc=document.getElementById(dd).value; 
				// alertify.alert(cc);
				if(cc!==""){
					$.ajax({      //  alertify.alert(gid);
						url: BASE_URL+"/admin/delete_kra",
						global: false,
						type: "POST",
						data: ({id : cc}),
						dataType: "html",
						async:false,
						success: function(msg){         // alertify.alert(msg);
						}
					}).responseText;
				}
				var hh=j-1;
				spli.splice(hh,1);
				table.deleteRow(j);
				len=spli.length;
				// alertify.alert(len);
				// break;
			}
		}
	}
	else if(flag==0){
		toastr.error("Please select the record");
		return false;
	}
	//  alertify.alert(spli);
	document.getElementById("addgroup_kra_"+id).value=spli;
}

function validation_kra(id){
	var table = document.getElementById('competencykraTab_'+id);
	var rowCount = table.rows.length;
	var dd="addgroup_kra_"+id;
	var s=document.getElementById(dd).value;
	if(s!=''){ 
		s=s.split(",");
		// alertify.alert(s.length);
		for(var i=0;i<s.length;i++){var b=s[i];
			var comp_kra_steps=document.getElementById('comp_kra_steps_'+b).value;
			if(comp_kra_steps==''){
				toastr.error("Please enter KRA Steps.");
				return false;
			}
        }
    }
}



function addkraposition(){
	var hiddtab="addgroup_kra";
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
			var comp_kra_steps=document.getElementById('comp_kra_steps_'+i).value;
			//var comp_kra_id=document.getElementById('comp_position_competency_id_'+i).value;
			if(comp_kra_steps==''){
				toastr.error("Please enter Kra Steps.");
				return false;
			}
			/*if(comp_kra_id==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var comp_kra_steps1=document.getElementById('comp_kra_steps_'+l).value;
				if(k!=j){
					if(comp_kra_steps==comp_kra_steps1){
						toastr.error("KRA should be Unique");
						return false;
					}
				}
			} */
		}	
		sub_iteration=parseInt(temp)+1; 
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}	
   
	/* if(kra_details!=''){
        var kra_detail=kra_details.split(',');
        var kra_ids='';
        for(var i=0;i<kra_detail.length;i++){
            cat1=kra_detail[i];
            cat2=cat1.split('*');
            if(kra_ids==''){
                kra_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                kra_ids=kra_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        kra_ids='';
    } */
	$("#competencyposTab_kra").append("<tr id='subgrd_kra_"+sub_iteration+"'><td><input type='checkbox' id='chkbox_kra_"+sub_iteration+"' name='chkbox_kra[]' value='"+sub_iteration+"'></td><td><input type='hidden' id='comp_kra_id_"+sub_iteration+"' name='comp_kra_id[]' value=''><select name='comp_kra_steps[]' id='comp_kra_steps_"+sub_iteration+"' class='form-control m-b js-source-states-2'>"+kra_details+"</select></td><td><input type='text' id='comp_kri_"+sub_iteration+"' class='form-control' name='kra_kri[]' value=''></td><td><input type='text' id='comp_uom_"+sub_iteration+"' class='form-control' name='kra_uom[]' value=''></td></tr>");
	
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}

function deletecompetencykra(){
	var table = document.getElementById('competencyposTab_kra');
	var s=document.getElementById("addgroup_kra").value;
	var spli=s.split(",");
	var flag=0; //toastr.error(spli);
	var len=spli.length;
	// toastr.error(len);
	for(var m=len;m >0; m--){
		var kk=m-1;
		//  toastr.error(m);
		var fd=spli[kk]
		//  toastr.error(fd);
		var ddd="chkbox_kra_"+fd;
		// toastr.error(ddd);
		if(document.getElementById(ddd).checked==true){
			flag++;
		}
	}
	if(flag>0){
		// toastr.error(len);
		var jinit=parseInt(len);
		// toastr.error(jinit);
		for(var j=jinit; j>0; j--){
			var k=j-1;
			var dd="chkbox_kra_"+spli[k];
			//toastr.error(dd);
			if(document.getElementById(dd).checked==true){ // toastr.error(j);
				var cc=document.getElementById(dd).value; 
				// toastr.error(cc);
				if(cc!==""){
					$.ajax({      //  toastr.error(gid);
						url: BASE_URL+"/admin/delete_kra",
						global: false,
						type: "POST",
						data: ({id : cc}),
						dataType: "html",
						async:false,
						success: function(msg){         // toastr.error(msg);
						}
					}).responseText;
				}
				var hh=j-1;
				spli.splice(hh,1);
				table.deleteRow(j);
				len=spli.length;
				// toastr.error(len);
				// break;
			}
		}
	}
	else if(flag==0){
		toastr.error("Please select the record");
		return false;
	}
	//  toastr.error(spli);
	document.getElementById("addgroup_position").value=spli;
}
