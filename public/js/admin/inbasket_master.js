$(document).ready(function(){
	$('#inbasket_master').validationEngine();
	$('#comp_master').validationEngine();
	$('#work_info').validationEngine();
	$('.datepicker').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
	/* $('#datetimepicker2').datetimepicker({
		format: 'LT',
		useCurrent: false,
		icons: {
			time: "fa fa-clock-o",
			date: "fa fa-calendar",
			up: "fa fa-arrow-up",
			down: "fa fa-arrow-down"
		},
	}); */
	$( "#sortable" ).sortable({
	  connectWith: "#sortable",
	  handle: ".portlet-header",
	  cancel: ".portlet-toggle",
	  placeholder: "portlet-placeholder ui-corner-all"
	}); 
	$(".portlet")
	  .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
	  .find( ".portlet-header" )
		.addClass( "ui-widget-header ui-corner-all" )
		.prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'>&nbsp;--&nbsp;&nbsp;&nbsp;</span>");
 
	$( ".portlet-toggle" ).on( "click", function() {
	  var icon = $( this );
	  icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
	  icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
	});
	$( "#sortable" ).disableSelection();
});

function open_question_count(id,inb_id){
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
			
            document.getElementById('questionbank_count'+id).innerHTML=xmlhttp.responseText;
			
			$("#inbasketform"+id).validationEngine();
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/inbasket_question_edit?q_id="+id+"&inbasket_id="+inb_id,true);
    xmlhttp.send();
}
function readURL(input) {
     if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
             $('#blah').attr('src', e.target.result);
         }
         reader.readAsDataURL(input.files[0]);
     }
}

 
 $(document).ready(function() {
     $("#content div").hide(); // Initially hide all content
     $("#tabs li:first").attr("id","current"); // Activate first tab
     $("#content div:first").fadeIn(); // Show first tab content
    
     $('#tabs a').click(function(e) {
         e.preventDefault();
         $("#content div").hide(); //Hide all content
         $("#tabs li").attr("id",""); //Reset id's
         $(this).parent().attr("id","current"); // Activate this
         $('#' + $(this).attr('title')).fadeIn(); // Show content for current tab
		 
		$(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=25){w=250;}
			$('.chosen-select').next().css({'width':w});
		}).trigger('resize.chosen');
     });
	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=25){w=250;}
		$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');
 });
 
 $(document).ready(function() {
	
	$('.nav-tabs li').click(function(event){
		if ($(this).hasClass('disabled')) {
			return false;
		}
	});
	if(status!=''){
		if(status=='competency'){
			$('#competency_li').addClass('active');
			$('#infomation-info').removeClass('active');
			$('#competency-info').addClass('active');
			$('#questions-info').removeClass('active');
		}else if(status=='questions'){
			$('#questions_li').addClass('active');
			$('#infomation-info').removeClass('active');
			$('#competency-info').removeClass('active');
			$('#questions-info').addClass('active');
		}
	}
	else{
		$("#information_li").addClass('active');
		$('#infomation-info').addClass('active');
		$('#competency-info').removeClass('active');
		$('#questions-info').removeClass('active');
	} 
});


function open_level(id){
    var comp_id=document.getElementById('inbasket_competencies'+id).value;
	if(comp_id!=''){
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
                document.getElementById("inbasket_scale_div"+id).innerHTML=xmlhttp.responseText;
                //toastr.error(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/change_level_inbasket?comp_id="+comp_id+"&row="+id,true);
        xmlhttp.send();
    }    
}

/* function open_scale(id){
    var level_id=document.getElementById('inbasket_levels'+id).value;
	if(level_id!=''){
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
                document.getElementById("inbasket_scale"+id).innerHTML=xmlhttp.responseText;
                //toastr.error(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/change_scale_inbasket?level_id="+level_id+"&row="+id,true);
        xmlhttp.send();
    }    
} */

function addsource_details_inbasket(){
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
			var inbasket_competencies=document.getElementById('inbasket_competencies'+i).value;
			var inbasket_scale=document.getElementById('inbasket_scale'+i).value;
			if(inbasket_competencies==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			if(inbasket_scale==''){
				toastr.error("Please select Scale.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
			var inbasket_competencies1=document.getElementById('inbasket_competencies'+l).value;
			var inbasket_scale1=document.getElementById('inbasket_scale'+l).value;
				if(k!=j){
					if(inbasket_competencies==inbasket_competencies1 && inbasket_scale==inbasket_scale1){
						toastr.error("All ready exists");
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
    
	if(comp_details!=''){
        var com_details=comp_details.split(',');
        var cam_ids='';
        for(var i=0;i<com_details.length;i++){
            cat1=com_details[i];
            cat2=cat1.split('*');
            if(cam_ids==''){
                cam_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                cam_ids=cam_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        cam_ids='';
    }
	
	$("#source_table_programs").append("<tr id='subgrd"+sub_iteration+"'><td><input type='checkbox' id='chkbox"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='inbasket_comp_id"+sub_iteration+"' name='inbasket_comp_id[]' value=''></td><td><select name='inbasket_competencies[]' id='inbasket_competencies"+sub_iteration+"' onchange='open_level("+sub_iteration+");' class='form-control m-b'><option value=''>Select</option>"+cam_ids+"</select></td><td><div id='inbasket_scale_div"+sub_iteration+"'><select name='inbasket_scale[]' id='inbasket_scale"+sub_iteration+"'  class='form-control m-b'><option value=''>Select</option></select></div></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}

function delete_inbasket(){
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
			var inbasket_comp_id=document.getElementById("inbasket_comp_id"+bb).value;
			//alert(calendar_act_id);
			if(inbasket_comp_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_inbasket_competency",
					global: false,
					type: "POST",
					data: ({val : inbasket_comp_id}),
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
		toastr.error("Please select the Value to Delete");
		return false;
	}
	document.getElementById(hiddtab).value=arr1;
}

function addsource_details_inbasket_test(){
	var hiddtab="test_addgroup";
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
			var inbasket_element_name=document.getElementById('inbasket_element_name'+i).value;
			if(inbasket_element_name==''){
				toastr.error("Please Select Question Name.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var inbasket_element_name1=document.getElementById('inbasket_element_name'+l).value;
				if(k!=j){
					if(inbasket_element_name==inbasket_element_name1){
						toastr.error("Question name should be Unique");
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
    
	if(test_details!=''){
        var test_detail=test_details.split(',@_');
        var test_ids='';
        for(var i=0;i<test_detail.length;i++){
            cat1=test_detail[i];
            cat2=cat1.split('*');
            if(test_ids==''){
                test_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                test_ids=test_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        test_ids='';
    }
	
	$("#case_study_test").append("<tr id='subgrd_test"+sub_iteration+"'><td><input type='checkbox' id='chkbox_text"+sub_iteration+"' name='chkbox_text[]' value='"+sub_iteration+"'><input type='hidden' id='inbasket_element_id"+sub_iteration+"' name='inbasket_element_id[]' value=''></td><td><select name='inbasket_element_name[]' id='inbasket_element_name"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+test_ids+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}

function delete_inbasket_test(){
	var hiddtab="test_addgroup";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('case_study_test');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		var a="chkbox_text"+bb;
		
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd_test"+bb;
			//alert(b);
			var inbasket_element_id=document.getElementById("inbasket_element_id"+bb).value;
			//alert(calendar_act_id);
			if(inbasket_element_id!=''){
				$.ajax({
					url: BASE_URL+"/admin/delete_inbasket_test",
					global: false,
					type: "POST",
					data: ({val : inbasket_element_id}),
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
		toastr.error("Please select the Value to Delete");
		return false;
	}
	document.getElementById(hiddtab).value=arr1;
}

 
function addsource_details_inbasket_validations(n){
	if(n==2){
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
			var inbasket_competencies=document.getElementById('inbasket_competencies'+i).value;
			var inbasket_scale=document.getElementById('inbasket_scale'+i).value;
			if(inbasket_competencies==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			if(inbasket_scale==''){
				toastr.error("Please select Scale.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
			var inbasket_competencies1=document.getElementById('inbasket_competencies'+l).value;
			var inbasket_scale1=document.getElementById('inbasket_scale'+l).value;
				if(k!=j){
					if(inbasket_competencies==inbasket_competencies1 && inbasket_scale==inbasket_scale1){
						toastr.error("All ready exists");
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
}
	if(n==3){
	var hiddtab_c="test_addgroup";
	var ins_c=document.getElementById(hiddtab_c).value;
	if(ins_c!=''){
		var ins1_c=ins_c.split(",");
		var temp_c=0;
		for( var j=0;j<ins1_c.length;j++){
			if(ins1_c[j]>temp_c){
				temp_c=parseInt(ins1_c[j]);
			}
		}
		var maxa=Math.max(ins1_c);
		sub_iteration_c=parseInt(temp_c)+1;
		for( var j=0;j<ins1_c.length;j++){
			var i=ins1_c[j]; 
			var inbasket_element_name=document.getElementById('inbasket_element_name'+i).value;
			if(inbasket_element_name==''){
				toastr.error("Please Select Question Name.");
				return false;
			}
			 for( var k=0;k<ins1_c.length;k++){
				l=ins1_c[k];
				var inbasket_element_name1=document.getElementById('inbasket_element_name'+l).value;
				if(k!=j){
					if(inbasket_element_name==inbasket_element_name1){
						toastr.error("Question name should be Unique");
						return false;
					}
				}
			} 
		}	
		sub_iteration_c=parseInt(temp_c)+1; 
	}
	else{
		sub_iteration_c=1;
		ins1_c=1;
		var ins1_c=Array(1);
	}	
    }
}

function addsource_details_inbasket_val(){
	var competency_id=document.getElementById('competency_id').value;
	if(competency_id==''){	
		toastr.error("Please select Competency");
		return false;
	}
}

function open_competency(){
	var competency_id=document.getElementById('competency_id').value;
	if(competency_id==''){	
		toastr.error("Please select Competency");
		return false;
	}
	else{
		var comp_id=competency_id.split("-");
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
				document.getElementById('data_competency').innerHTML=xmlhttp.responseText;
				/* $('#data_competency').html(xmlhttp.responseText); */
				/* $('#datetimepicker2').datetimepicker({
					format: 'LT',
					useCurrent: false,
					icons: {
						time: "fa fa-clock-o",
						date: "fa fa-calendar",
						up: "fa fa-arrow-up",
						down: "fa fa-arrow-down"
					},
				}); */
				$('#pre-selected-options').multiSelect();      
				$('#optgroup').multiSelect({ selectableOptgroup: true });
				$('#public-methods').multiSelect();
				$('#select-all').click(function(){
				$('#public-methods').multiSelect('select_all');
				return false;
				});
				$('#deselect-all').click(function(){
				$('#public-methods').multiSelect('deselect_all');
				return false;
				});
				$('#refresh').on('click', function(){
				$('#public-methods').multiSelect('refresh');
				return false;
				});
				$('#add-option').on('click', function(){
				$('#public-methods').multiSelect('addOption', { value: 42, text: 'test 42', index: 0 });
				return false;
				});
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/competency_indicator_data?comp_id="+comp_id[0]+"&scale_id="+comp_id[1],true);
		xmlhttp.send();
	}
}

function work_info_view(comp_id,scale_id){
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
			document.getElementById("workinfodetails").innerHTML=xmlhttp.responseText;
			//toastr.error(xmlhttp.responseText);
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/comptency_view_intray?comp_id="+comp_id+"&scale_id="+scale_id,true);
	xmlhttp.send();
      
}
