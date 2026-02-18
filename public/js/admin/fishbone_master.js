$(document).ready(function(){
	$('#case_master').validationEngine();
	$('#work_info').validationEngine();
	$('.datepicker').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
	$('.summernote').summernote({
		height: 230,
		minHeight: null,
		maxHeight: null,
		focus: true,
		callbacks: {
			onImageUpload: function(files, editor, welEditable) {
				for (var i = files.length - 1; i >= 0; i--) {
					sendFile(files[i], this);
				}
			},
		},
		dialogsFade: true,
		fontNames: ['Roboto Light', 'Roboto Regular', 'Roboto Bold'],
		toolbar: [
		['fontname', ['fontname']],
		['fontsize', ['fontsize']],
		['font', ['style','bold', 'italic', 'underline', 'clear']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['height', ['height']],
		['table', ['table']],
		['insert', ['picture','link']],
		['view', ['fullscreen', 'codeview']],
		['misc', ['undo','redo']]
		]
	});	
});
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
 
function addsource_details_casestudy(){
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
			var casestudy_competencies=document.getElementById('casestudy_competencies'+i).value;
			var casestudy_level=document.getElementById('casestudy_level'+i).value;
			var casestudy_scale=document.getElementById('casestudy_scale'+i).value;
			if(casestudy_competencies==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			if(casestudy_level==''){
				toastr.error("Please select Level Name.");
				return false;
			}
			if(casestudy_scale==''){
				toastr.error("Please select Scale.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
			var casestudy_competencies1=document.getElementById('casestudy_competencies'+l).value;
			var casestudy_level1=document.getElementById('casestudy_level'+l).value;
			var casestudy_scale1=document.getElementById('casestudy_scale'+l).value;
				if(k!=j){
					if(casestudy_competencies==casestudy_competencies1 &&  casestudy_level==casestudy_level1 &&  casestudy_scale==casestudy_scale1){
						toastr.error("All Ready Existed");
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
    
	/* if(comp_details!=''){
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
    } */
	
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
	
	$("#source_table_programs").append("<tr id='subgrd"+sub_iteration+"'><td><input type='checkbox' id='chkbox"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='casestudy_comp_id"+sub_iteration+"' name='casestudy_comp_id[]' value=''></td><td><select name='casestudy_competencies[]' id='casestudy_competencies"+sub_iteration+"' onchange='open_level("+sub_iteration+");' class='form-control m-b'><option value=''>Select</option>"+competency_details_status_n+"</select></td><td><select name='casestudy_level[]' id='casestudy_level"+sub_iteration+"' onchange='open_scale("+sub_iteration+");'  class='form-control m-b'><option value=''>Select</option></select></td><td><select name='casestudy_scale[]' id='casestudy_scale"+sub_iteration+"'  class='form-control m-b'><option value=''>Select</option></select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}

function delete_casestudy(){
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
			var casestudy_comp_id=document.getElementById("casestudy_comp_id"+bb).value;
			//alert(calendar_act_id);
			if(casestudy_comp_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_case_competency",
					global: false,
					type: "POST",
					data: ({val : casestudy_comp_id}),
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


function open_level(id){
    var comp_id=document.getElementById('casestudy_competencies'+id).value;
	alert(comp_id);
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
                document.getElementById("casestudy_level"+id).innerHTML=xmlhttp.responseText;
                //toastr.error(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/change_level_casestudy?comp_id="+comp_id+"&row="+id,true);
        xmlhttp.send();
    }    
}

function open_scale(id){
    var level_id=document.getElementById('casestudy_level'+id).value;
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
                document.getElementById("casestudy_scale"+id).innerHTML=xmlhttp.responseText;
                //toastr.error(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/change_scale_casestudy?level_id="+level_id+"&row="+id,true);
        xmlhttp.send();
    }    
}

function addsource_details_casestudy_test(){
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
			var casestudy_quest=document.getElementById('casestudy_quest'+i).value;
			if(casestudy_quest==''){
				toastr.error("Please Select Question Name.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var program_id1=document.getElementById('casestudy_quest'+l).value;
				if(k!=j){
					if(casestudy_quest==program_id1){
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
        var test_detail=test_details.split(',');
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
	
	$("#case_study_test").append("<tr id='subgrd_test"+sub_iteration+"'><td><input type='checkbox' id='chkbox_text"+sub_iteration+"' name='chkbox_text[]' value='"+sub_iteration+"'><input type='hidden' id='casestudy_quest_id"+sub_iteration+"' name='casestudy_quest_id[]' value=''></td><td><select name='casestudy_quest[]' id='casestudy_quest"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+test_ids+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}

function delete_casestudy_test(){
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
			var casestudy_quest_id=document.getElementById("casestudy_quest_id"+bb).value;
			//alert(calendar_act_id);
			if(casestudy_quest_id!=''){
				$.ajax({
					url: BASE_URL+"/admin/delete_casetest_competency",
					global: false,
					type: "POST",
					data: ({val : casestudy_quest_id}),
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

function addsource_details_casestudy_validation(n){
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
			var casestudy_competencies=document.getElementById('casestudy_competencies'+i).value;
			var casestudy_level=document.getElementById('casestudy_level'+i).value;
			var casestudy_scale=document.getElementById('casestudy_scale'+i).value;
			if(casestudy_competencies==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			if(casestudy_level==''){
				toastr.error("Please select Level Name.");
				return false;
			}
			if(casestudy_scale==''){
				toastr.error("Please select Scale.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
			var casestudy_competencies1=document.getElementById('casestudy_competencies'+l).value;
			var casestudy_level1=document.getElementById('casestudy_level'+l).value;
			var casestudy_scale1=document.getElementById('casestudy_scale'+l).value;
				if(k!=j){
					if(casestudy_competencies==casestudy_competencies1 &&  casestudy_level==casestudy_level1 &&  casestudy_scale==casestudy_scale1){
						toastr.error("All Ready Existed");
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
			var casestudy_quest=document.getElementById('casestudy_quest'+i).value;
			if(casestudy_quest==''){
				toastr.error("Please Select Question Name.");
				return false;
			}
			 for( var k=0;k<ins1_c.length;k++){
				l=ins1_c[k];
				var program_id1=document.getElementById('casestudy_quest'+l).value;
				if(k!=j){
					if(casestudy_quest==program_id1){
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

function open_question_count(id,case_id){
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
			$("#case_master"+id).validationEngine();
			$('.summernote').summernote({
				height: 230,
				minHeight: null,
				maxHeight: null,
				focus: true,
				callbacks: {
					onImageUpload: function(files, editor, welEditable) {
						for (var i = files.length - 1; i >= 0; i--) {
							sendFile(files[i], this);
						}
					},
				},
				dialogsFade: true,
				fontNames: ['Roboto Light', 'Roboto Regular', 'Roboto Bold'],
				toolbar: [
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['font', ['style','bold', 'italic', 'underline', 'clear']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['table', ['table']],
				['insert', ['picture','link']],
				['view', ['fullscreen', 'codeview']],
				['misc', ['undo','redo']]
				]
			});
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/casestudy_question_edit?q_id="+id+"&case_id="+case_id,true);
    xmlhttp.send();
}

function open_level_edit(id){
    var comp_id=document.getElementById('casestudy_competencies_'+id).value;
	alert(comp_id);
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
                document.getElementById("casestudy_level_"+id).innerHTML=xmlhttp.responseText;
                //toastr.error(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/change_level_casestudy_edit?comp_id="+comp_id+"&row="+id,true);
        xmlhttp.send();
    }    
}

function open_scale_edit(id){
    var level_id=document.getElementById('casestudy_level_'+id).value;
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
                document.getElementById("casestudy_scale_"+id).innerHTML=xmlhttp.responseText;
                //toastr.error(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/change_scale_casestudy_edit?level_id="+level_id+"&row="+id,true);
        xmlhttp.send();
    }    
}

function addsource_details_casestudy_edit(){
	var hiddtab="addgroup_n";
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
			var casestudy_competencies=document.getElementById('casestudy_competencies_'+i).value;
			var casestudy_level=document.getElementById('casestudy_level_'+i).value;
			var casestudy_scale=document.getElementById('casestudy_scale_'+i).value;
			if(casestudy_competencies==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			if(casestudy_level==''){
				toastr.error("Please select Level Name.");
				return false;
			}
			if(casestudy_scale==''){
				toastr.error("Please select Scale.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
			var casestudy_competencies1=document.getElementById('casestudy_competencies_'+l).value;
			var casestudy_level1=document.getElementById('casestudy_level_'+l).value;
			var casestudy_scale1=document.getElementById('casestudy_scale_'+l).value;
				if(k!=j){
					if(casestudy_competencies==casestudy_competencies1 &&  casestudy_level==casestudy_level1 &&  casestudy_scale==casestudy_scale1){
						toastr.error("All Ready Existed");
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
    
	/* if(comp_details!=''){
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
    } */
	
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
	
	$("#source_table_program_s").append("<tr id='subgrd_"+sub_iteration+"'><td><input type='checkbox' id='chkbox_inst"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='case_map_id"+sub_iteration+"' name='case_map_id[]' value=''></td><td><select name='casestudy_competencies[]' id='casestudy_competencies_"+sub_iteration+"' onchange='open_level("+sub_iteration+");' class='form-control m-b'><option value=''>Select</option>"+competency_details_status_n+"</select></td><td><select name='casestudy_level[]' id='casestudy_level_"+sub_iteration+"' onchange='open_scale("+sub_iteration+");'  class='form-control m-b'><option value=''>Select</option></select></td><td><select name='casestudy_scale[]' id='casestudy_scale_"+sub_iteration+"'  class='form-control m-b'><option value=''>Select</option></select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}


function delete_casestudy_edit(){
	var hiddtab="addgroup_n";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('source_table_program_s');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		var a="chkbox_inst"+bb;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd_"+bb+"";
			//alert(b);
			var case_map_id=document.getElementById("case_map_id"+bb).value;
			//alert(calendar_act_id);
			if(case_map_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_case_competency",
					global: false,
					type: "POST",
					data: ({val : case_map_id}),
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

function addsource_details_casestudy_validation_edit(n){
	if(n==2){
	var hiddtab="addgroup_n";
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
			var casestudy_competencies=document.getElementById('casestudy_competencies_'+i).value;
			var casestudy_level=document.getElementById('casestudy_level_'+i).value;
			var casestudy_scale=document.getElementById('casestudy_scale_'+i).value;
			if(casestudy_competencies==''){
				toastr.error("Please Select Competency Name.");
				return false;
			}
			if(casestudy_level==''){
				toastr.error("Please select Level Name.");
				return false;
			}
			if(casestudy_scale==''){
				toastr.error("Please select Scale.");
				return false;
			}
			 for( var k=0;k<ins1.length;k++){
				l=ins1[k];
			var casestudy_competencies1=document.getElementById('casestudy_competencies_'+l).value;
			var casestudy_level1=document.getElementById('casestudy_level_'+l).value;
			var casestudy_scale1=document.getElementById('casestudy_scale_'+l).value;
				if(k!=j){
					if(casestudy_competencies==casestudy_competencies1 &&  casestudy_level==casestudy_level1 &&  casestudy_scale==casestudy_scale1){
						toastr.error("All Ready Existed");
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
	
}


function addsource_details_fishbone(){
	var hiddtab="fishbone_addgroup";
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
			var probable_causes=document.getElementById('probable_causes'+i).value;
			var head_list=document.getElementById('head_list'+i).value;
			if(probable_causes==''){
				toastr.error("Please enter probable cause.");
				return false;
			}
			if(head_list==''){
				toastr.error("Please select head list.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var probable_causes1=document.getElementById('probable_causes'+l).value;
				var head_list1=document.getElementById('head_list'+l).value;
				if(k!=j){
					if(probable_causes==probable_causes1 &&  head_list==head_list1){
						toastr.error("All Ready Existed");
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
	if(fish_details!=''){
        var fish_detail=fish_details.split(',');
        var fish_ids='';
        for(var i=0;i<fish_detail.length;i++){
            cat1=fish_detail[i];
            cat2=cat1.split('*');
            if(fish_ids==''){
                fish_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                fish_ids=fish_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        fish_ids='';
    }
	
	if(yes_details!=''){
        var yes_detail=yes_details.split(',');
        var yes_ids='';
        for(var i=0;i<yes_detail.length;i++){
            cat1=yes_detail[i];
            cat2=cat1.split('*');
            if(yes_ids==''){
                yes_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                yes_ids=yes_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        yes_ids='';
    }
	
	$("#fish_source_table_programs").append("<tr id='fish_subgrd"+sub_iteration+"'><td><input type='checkbox' id='fish_chkbox"+sub_iteration+"' name='fish_chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='fishbone_list_id"+sub_iteration+"' name='fishbone_list_id[]' value=''></td><td><input type='text' value='' class='form-control' name='probable_causes[]' id='probable_causes"+sub_iteration+"'></td><td><select name='head_list[]' id='head_list"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+fish_ids+"</select></td><td><select name='top_reason[]' id='top_reason"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+yes_ids+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}

