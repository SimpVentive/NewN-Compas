$(document).ready(function(){
	$('#comp_master').validationEngine();
});

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
		}
		else if(status=='questions'){
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


function open_subcategory(){
	var cat_id=document.getElementById('comp_def_category').value;
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
			document.getElementById('comp_def_sub_category').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/change_subcat?id="+cat_id,true);
	xmlhttp.send();	
}

function open_addcategory(){
	var sub_id=document.getElementById('comp_def_sub_category').value;
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
			document.getElementById('comp_def_add_category').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/change_addcat?id="+sub_id,true);
	xmlhttp.send();	
}

function open_levels(){
	var level_id=document.getElementById('comp_def_level').value;
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
			document.getElementById('open_level').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/change_level_scale?id="+level_id,true);
	xmlhttp.send();	
}



function open_sub_assessment($id){
    $('input[id="value'+$id+'"]').click(function(){
        if($(this).attr("value")==$id){
            $("#open_sub"+$id).toggle();
        }
    });
}

function addsource_details_certified(){
	var hiddtab="addgroup_certified";
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
			var ques_bank_id=document.getElementById('master_ques_bank_id'+i).value;
			if(ques_bank_id==''){
				toastr.error("Please Select Question Bank Name.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var ques_bank_id1=document.getElementById('master_ques_bank_id'+l).value;
				if(k!=j){
					if(ques_bank_id==ques_bank_id1){
						toastr.error("Question bank name should be Unique");
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
    
	if(ques_detail!=''){
        var ques_details=ques_detail.split('@');
        var ques_ids='';
        for(var i=0;i<ques_details.length;i++){
            cat1=ques_details[i];
            cat2=cat1.split('*');
            if(ques_ids==''){
                ques_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                ques_ids=ques_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        ques_ids='';
    }
	$("#source_table_certified").append("<tr id='subgrd_inst"+sub_iteration+"'><td><input type='checkbox' id='chkbox_inst"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='comp_def_que_bank_id"+sub_iteration+"' name='comp_def_que_bank_id[]' value=''></td><td><select name='master_ques_bank_id[]' id='master_ques_bank_id"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+ques_ids+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}


function delete_certified(){
	var hiddtab="addgroup_certified";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('source_table_certified');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		var a="chkbox_inst"+bb;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd_inst"+bb+"";
			var master_ques_bank_id=document.getElementById("comp_def_que_bank_id"+bb).value;
			//alert(calendar_act_id);
			if(master_ques_bank_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_comp_questionbank",
					global: false,
					type: "POST",
					data: ({val : master_ques_bank_id}),
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

function addsource_details_interview(){
	var hiddtab="addgroup_interview";
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
			var int_ques_bank_id=document.getElementById('master_int_ques_bank_id'+i).value;
			if(int_ques_bank_id==''){
				toastr.error("Please Select Interview Question Bank Name.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var int_ques_bank_id1=document.getElementById('master_int_ques_bank_id'+l).value;
				if(k!=j){
					if(int_ques_bank_id==int_ques_bank_id1){
						toastr.error("Question bank name should be Unique");
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
    
	if(int_detail!=''){
        var int_details=int_detail.split(',');
        var int_ids='';
        for(var i=0;i<int_details.length;i++){
            cat1=int_details[i];
            cat2=cat1.split('*');
            if(int_ids==''){
                int_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                int_ids=int_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        int_ids='';
    }
	$("#source_table_interview").append("<tr id='subgrd_interview"+sub_iteration+"'><td><input type='checkbox' id='chkbox_int"+sub_iteration+"' name='chkbox_int[]' value='"+sub_iteration+"'><input type='hidden' id='comp_def_inter_ques_id"+sub_iteration+"' name='comp_def_inter_ques_id[]' value=''></td><td><select name='master_int_ques_bank_id[]' id='master_int_ques_bank_id"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+int_ids+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}


function delete_interview(){
	var hiddtab="addgroup_interview";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('source_table_interview');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		var a="chkbox_int"+bb;
		
		if(document.getElementById(a).checked){
			//alert(a);
			var b=document.getElementById(a).value;
			var c="subgrd_interview"+bb+"";
			//alert(b);
			var comp_def_inter_ques_id=document.getElementById("comp_def_inter_ques_id"+bb).value;
			//alert(calendar_act_id);
			if(comp_def_inter_ques_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_comp_interview",
					global: false,
					type: "POST",
					data: ({val : comp_def_inter_ques_id}),
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
		
	var hiddtab="addgroup_interview";
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
			var int_ques_bank_id=document.getElementById('master_int_ques_bank_id'+i).value;
			if(int_ques_bank_id==''){
				toastr.error("Please Select Interview Question Bank Name.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var int_ques_bank_id1=document.getElementById('master_int_ques_bank_id'+l).value;
				if(k!=j){
					if(int_ques_bank_id==int_ques_bank_id1){
						toastr.error("Question bank name should be Unique");
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
	if(n==1){
		var hiddtab="addgroup_certified";
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
			var ques_bank_id=document.getElementById('master_ques_bank_id'+i).value;
			if(ques_bank_id==''){
				toastr.error("Please Select Question Bank Name.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var ques_bank_id1=document.getElementById('master_ques_bank_id'+l).value;
				if(k!=j){
					if(ques_bank_id==ques_bank_id1){
						toastr.error("Question bank name should be Unique");
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

