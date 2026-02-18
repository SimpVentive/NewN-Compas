jQuery(function($) {
	var oTable1 =$('#newtableid').dataTable({
		bAutoWidth: false,
		"aoColumns": [
		{ "bSortable": false },
		null, null,null, null, null,null,
		{ "bSortable": false }
	]});
})
$(document).ready(function(){
    $('#definition_form').validationEngine();
	//$('#resourcebooking_data').validationEngine();
	$('#expenses_data').validationEngine();
	$('#expenses_data_tab').validationEngine();
    $('#evaluate_form').validationEngine();
    $('#org_master_check').validationEngine({validateNonVisibleFields: true, updatePromptsPosition:true});
    $('#communication_form').validationEngine({validateNonVisibleFields: true, updatePromptsPosition:true});
    $('#single_enrollment_data').validationEngine({validateNonVisibleFields: true, updatePromptsPosition:true});
	$('#learner_restrict').validationEngine();	
	//$('input.timepicker').timepicker({ timeFormat: 'h:mm:ss p' });
	
	
	//code for disable submit button after click once	
	var flg=1;
	
	$("#save").click(function(e){
		e.preventDefault();
		var def=$('#definition_form').validationEngine('validate');
		if(def==false){
			//$('#resource_form_data').validationEngine();
			$("#definition_form").validationEngine({promptPosition: 'inline'});
		}
		else{
			if(flg==1 && check_status()!=false){
				$("#save").attr('disabled','disabled');
				document.getElementById("definition_form").submit();
				flg++;
			}
		}
	}); 
	
	$('#inherit').change(function() {
	   if($(this).is(":checked")) {
			if(eve_stat=='inherit'){
				alertify.alert("Learner Access already inherited from program");
				$(this).attr('checked', false);
				return false;
			}
			$('#access_herit').css('display','block');
			return;
		}
		$('#access_herit').css('display','none');
	});
});
/* $("input[type=submit]").click(function(){
	$("input[type=submit]").attr('disabled','disabled');
}); */
$(document).ready(function(){
	//$('#starttime').timepicker();
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
	$('.bootstrap-timepicker-widget').css({'z-index':'9999'});
	$('#communicationDetails').modal({
		show: false,
		backdrop: 'static',
		keyboard: false  // to prevent closing with Esc button (if you want this too)
	});
});

function goback(id){
     window.location=BASE_URL+'/admin/program_event_details?id='+id;
} 
 function check_status(){
	var eve_status=document.getElementById('status').value;
	var eve_stdt=document.getElementById('startdate').value;
	var eve_endt=document.getElementById('enddate').value;
	var eve_min_cnt=document.getElementById('min_cou').value;
	var eve_max_cnt=document.getElementById('max_cou').value;
	
	if(eve_endt!='' && eve_stdt==''){
		alertify.alert("You cannot enter End Date without Start Date");
		return false;
	 }
	 if(eve_status=='P'){
         if(eve_stdt==''){
             alertify.alert("You must enter tentative start date for a planned event");
             return false;
         }         
     }
     if(eve_status=='S'){
         if(eve_stdt==''){
             alertify.alert("You must enter tentative start date for scheduled event");
             return false;
         }
         if(eve_endt==''){
             alertify.alert("You cannot change a class status to 'Scheduled' until you have entered the start and end dates.");
             return false;
         }
     }
     if(eve_status=='F'){
         if(eve_max_cnt==''){
             alertify.alert("Please provide Maximum Count for full status");
             return false;
         }
     }
     if(parseInt(eve_max_cnt)<parseInt(eve_min_cnt)){
         alertify.alert("Maximum count should be greater than minimum count");
         return false;
     }
     var sttime=document.getElementById('starttime').value;
     var endtime=document.getElementById('endtime').value;
	 
     if(eve_stdt==eve_endt){
		 var re = /:/gi;
		 var sttime=sttime.replace(re, '');
		 var endtime=endtime.replace(re, '');
         if(parseInt(endtime)<=parseInt(sttime)){
             alertify.alert("Event End Time can not be greater than Event Start Time for the same day");
             return false;
         }
     }
     
	var hiddtab="mat_hidden_id";
	if(document.getElementById(hiddtab)){
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
				var mater1='learning_material_id['+i+']';
				var material=document.getElementById(mater1).value;
				var mattype=document.getElementById('material_details['+i+']').value;
				mattp1=mattype.split('_');
				if(material==''){
					alertify.alert("Please Select Material");
					return false;
				}else{
					for( var k=0;k<ins1.length;k++){
						l=ins1[k];
						var material2='learning_material_id['+l+']';
						var mattype2=document.getElementById('material_details['+l+']').value;
						mattp2=mattype2.split('_');
						if(k!=j){
							var ss1=document.getElementById(mater1).value;
							var ss3=ss1.toUpperCase();
							var ss2=document.getElementById(material2).value;
							var ss4=ss2.toUpperCase();
							if(ss3.trim()==ss4.trim() && mattp1[0]==mattp2[0]){
								alertify.alert("Material Already Exists");
								return false;
							}
						}
					}
				}
			   
			}	
		}
	}
	var hiddtab2="inner_hidden_id";
	if(document.getElementById(hiddtab2)){
		var ins=document.getElementById(hiddtab2).value;
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
				//alertify.alert(i);
				if(i>0){
					var attach_mat=document.getElementById('filename['+i+']').value;
					var att1=attach_mat.toUpperCase();
					var type=document.getElementById('filetype['+i+']').value;
					var att_typ1=type.toUpperCase();
					var filename=document.getElementById('fileupload['+i+']').value;
					var file_exist=document.getElementById('eve_attach_'+i+'').value;
					if(attach_mat==''){
						alertify.alert("Please Enter AttachMent Name");
						return false;
					}
					if(filename==''){					
						if(file_exist==''){
							alertify.alert("Please add File");
							return false;
						}
					}
					else{
						for( var k=0;k<ins1.length;k++){
							l=ins1[k];
							var attach_mat2=document.getElementById('filename['+l+']').value;
							var att2=attach_mat2.toUpperCase();
							var type2=document.getElementById('filetype['+l+']').value;
							var att_typ2=type2.toUpperCase();
							var filename2=document.getElementById('fileupload['+l+']').value;
							var file_exist2=document.getElementById('eve_attach_'+l+'').value;
							var files=filename.replace(" ","_");
							if(k!=j){
								if(att1.trim()==att2.trim() && att_typ1.trim()==att_typ2.trim()){
									alertify.alert("Attachment Name with same Type Already Exists");
									return false;
								}
								if(filename==filename2 || files==file_exist2){
									alertify.alert("File Name Already Exists");
									return false;
								}
							}
						}
					}
				}
			}	
		}
	}
 }   

function check_res_time(){
	var chk_vald=$('#resourcebooking_data').validationEngine('validate');
	//alert(chk_vald);
	if(chk_vald==false){
		$('#resourcebooking_data').validationEngine();
	} 
	else{
		 /*var hiddtab="exp_hidden_id";
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
				var item_type=document.getElementById('item_type['+i+']').value;
				var item_resource=document.getElementById('exp_resource_booking_id['+i+']').value;
				
				if(item_type!=''){
					for( var k=0;k<ins1.length;k++){
						l=ins1[k];
						var item_type2=document.getElementById('item_type['+l+']').value;
						var item_resource2=document.getElementById('exp_resource_booking_id['+l+']').value;
						if(k!=j){
							if(item_type==item_type2 && item_resource==item_resource2){
								alertify.alert("Item type with the same resource already exists");
								document.getElementById('exp_resource_booking_id['+l+']').value='';
								return false;
							}
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
		} */
		var checkresource=resource_details();
		if(checkresource==false){
			return false;
		}
		if(document.getElementById('resource_id')){
			var res_stdate=document.getElementById('res_required_date_from').value.trim();
			var res_enddate=document.getElementById('res_required_date_to').value.trim();
			var res_sttime=document.getElementById('res_required_start_time').value.trim();
			var res_endtime=document.getElementById('res_required_end_time').value.trim();
			//alert(res_stdate+" "+res_enddate);
			if(res_stdate=='' && res_enddate!=''){
				alertify.alert("End date can not be given without giving the start date");
				return false;
			}
			if(res_stdate!='' && res_enddate!=''){
				if(res_stdate==res_enddate){
					var re = /:/gi;
					res_endtime=res_endtime.replace(re,"");
					res_sttime=res_sttime.replace(re,"");
					//alert(res_endtime+" "+res_sttime);
					if(parseInt(res_endtime)<parseInt(res_sttime)){
						alertify.alert("Resource End Time can not be less than Resource Start Time for the same day");
						return false;
					}
				}
				else{
					if(res_sttime=='' || res_endtime==''){
						alertify.alert("Time can not be given without giving both the dates");
						return false;
					}
			}
			var res_id=$('#resource_id').val();
			if(res_id!=''){ 	
				$( "#resource-confirm" ).removeClass('hide').dialog({
					resizable: false,
					modal: true,			
					title_html: true,
					buttons: [
						{
							html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Save",
							"class" : "btn btn-primary btn-xs",
							click: function() {
								//$( this ).dialog( "close" );
								document.resourcebooking_data.submit();
							}
						}
						,
						{
							html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
							"class" : "btn btn-xs",
							click: function() {
								$( this ).dialog( "close" );
							}
						}
					]
				});
			}
		}else{
			document.resourcebooking_data.submit();
		}
	}
	else{
			document.resourcebooking_data.submit();
		}
	
	} 
}
 
function status_change(){
    var eve_status=document.getElementById('status').value;
	if(eve_status=='S'){
		document.getElementById('sch_enddate').style.display='block';
		/*$(document).ready(function(){
			$('#enddate').addClass('required');
		});*/
	}
    if(status_typ=='S'){
        if(eve_status=='P'){
            document.getElementById('status').value=status_typ;
            alertify.alert("You cannot modify the event from Scheduled to planned , once the event starts");
            return false;
        }
    }//alertify.alert(evnt_cnt);
    var enrl_cnt=document.getElementById('enrl_evnt_count').value;
    if(evnt_cnt!='' && enrl_cnt>=evnt_cnt){
        if(eve_status!='F'){
            document.getElementById('status').value='F';
            alertify.alert("Event Status can not be changed as Enrolment count exceeds Event Maximum count");
            return false;
        }
    }
	var maxcnt=document.getElementById('max_cou').value;
	if(maxcnt=='' && eve_status=='F'){
		alertify.alert("Event Status can not be changed to full when maximum count is empty");
		document.getElementById('status').value='P';
		//location.reload();
		return false;		
	}
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
		if(eve_stat=='resource'){
			$('#resource_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#resource_def').addClass('active');
			$('#evaluate_def').removeClass('active');
			$('#enroll_def').removeClass('active');
			$('#communication_def').removeClass('active');
			$('#learner_def').removeClass('active');
			$('#expenses_def').removeClass('active');
		}
		else if(eve_stat=='expenses'){
			$('#expenses_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#expenses_def').addClass('active');
			$('#evaluate_def').removeClass('active');
			$('#enroll_def').removeClass('active');
			$('#communication_def').removeClass('active');
			$('#learner_def').removeClass('active');
			$('#resource_def').removeClass('active');
		}
		else if(eve_stat=='evaluation'){
			$('#evaluate_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#resource_def').removeClass('active');
			$('#evaluate_def').addClass('active');
			$('#enroll_def').removeClass('active');
			$('#communication_def').removeClass('active');
			$('#learner_def').removeClass('active');
			$('#expenses_def').removeClass('active');
		}else if(eve_stat=='singleenroll'){
			$('#enroll_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#resource_def').removeClass('active');
			$('#evaluate_def').removeClass('active');
			$('#enroll_def').addClass('active');
			$('#communication_def').removeClass('active');
			$('#learner_def').removeClass('active');
			$('#expenses_def').removeClass('active');
		}
		else if(eve_stat=='tnaenroll'){
			$('#enroll_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#resource_def').removeClass('active');
			$('#evaluate_def').removeClass('active');
			$('#enroll_def').addClass('active');
			$('#communication_def').removeClass('active');
			$('#learner_def').removeClass('active');
			$('#expenses_def').removeClass('active');
		}
		else if(eve_stat=='communication'){ 
			$('#communication_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#resource_def').removeClass('active');
			$('#evaluate_def').removeClass('active');
			$('#enroll_def').removeClass('active');
			$('#communication_def').addClass('active');
			$('#learner_def').removeClass('active');
			$('#expenses_def').removeClass('active');
		}else if(eve_stat=='learner' || eve_stat=='inherit'){
			$('#learner_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#resource_def').removeClass('active');
			$('#evaluate_def').removeClass('active');
			$('#enroll_def').removeClass('active');
			$('#communication_def').removeClass('active');
			$('#learner_def').addClass('active');
			$('#expenses_def').removeClass('active');
		}
	}
	else{
		$("#event_li").addClass('active');
		$("#event_def").addClass('active');
		$('#resource_def').removeClass('active');
		$('#evaluate_def').removeClass('active');
		$('#enroll_def').removeClass('active');
		$('#communication_def').removeClass('active');
		$('#learner_def').removeClass('active');
		$('#expenses_def').removeClass('active');
	} 
});

 function eval_enrolled(){
     alertify.alert("You can not perform any action after Enrollment");
     return false;
 }
function attachment_valid(){
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
            var attatchment=document.getElementById('filename['+l+']').value;
            var att1=attatchment.toUpperCase();
            var type=document.getElementById('filetype['+l+']').value;
            var att_typ1=type.toUpperCase();
            if(attatchment!=''){
                for( var k=0;k<ins1.length;k++){
                    l=ins1[k];
                    var attatchment2=document.getElementById('filename['+l+']').value;
                     var att2=attatchment2.toUpperCase();
                     var type2=document.getElementById('filetype['+l+']').value;
                      var att_typ2=type2.toUpperCase();
                     if(k!=j){
                        if(att1.trim()==att2.trim() && att_typ1.trim()==att_typ2.trim()){
                             alertify.alert("Attachment Name with same Type Already Exists");
                             return false;
                         }
                     }
                 }
            }
        }
    }
}
function fetchResource(id){
	var itemtype=document.getElementById('item_type['+id+']').value;
	$.ajax({
		type: "GET",
		url: BASE_URL+"/admin/fetch_resource?item="+itemtype+"&eve_id="+eve_id,
		success: function(data){
			//alertify.alert(data);
			//$('#exp_resource_booking_id['+id+']').html(data);
			document.getElementById('exp_resource_booking_id['+id+']').innerHTML=data;
		}
	});
}
function AddExpenses(){
	var hiddtab="exp_hidden_id";
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
			var item_type=document.getElementById('item_type['+i+']').value;
			var item_resource=document.getElementById('exp_resource_booking_id['+i+']').value;
			if(item_type==''){
				alertify.alert("Please Select Item Type");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('item_type['+l+']').value;
					var item_resource2=document.getElementById('exp_resource_booking_id['+l+']').value;
					if(k!=j){
						if(item_type==item_type2 && item_resource==item_resource2){
							alertify.alert("Item type with same resource already exists");
							document.getElementById('exp_resource_booking_id['+l+']').value='';
							return false;
						}
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
	// To fetch Expenses type from .php page
    if(exptype!=''){
        var expt=exptype.split(',');
        var item_type='';
        for(var i=0;i<expt.length;i++){
            emp1=expt[i];
            emp2=emp1.split('*');
            if(item_type==''){
                item_type="<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }else{
                item_type=item_type+"<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }
        }
    }else{
        item_type='';
    }
	// To fetch Expenses Status from .php page
    if(exp_status!=''){
        var expst=exp_status.split(',');
        var status_type='';
        for(var i=0;i<expst.length;i++){
            expst1=expst[i];
            expst2=expst1.split('*');
            if(status_type==''){
                status_type="<option value='"+expst2[0]+"'>"+expst2[1]+"</option>";
            }else{
                status_type=status_type+"<option value='"+expst2[0]+"'>"+expst2[1]+"</option>";
            }
        }
    }else{
        status_type='';
    }
	$("#expense_details").append("<tr id='expenses"+sub_iteration+"'><td style='padding-left:20px;' class='hidden-480'><input type='hidden' name='event_expenses_id[]' id='event_expenses_id["+sub_iteration+"]' value=''><input type='checkbox' name='expenses_chk_[]' id='expenses_chk_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><select class='mediumtext' name='item_type[]' id='item_type["+sub_iteration+"]' onchange='fetchResource("+sub_iteration+")'><option value=''>Select</option>"+item_type+"</select></td><td><select class='mediumtext' name='exp_resource_booking_id[]' id='exp_resource_booking_id["+sub_iteration+"]' style='width: 150px;'><option value=''>Select</option></select></td><td><input class='validate[custom[amount]] mediumtext' type='text' name='amount[]' id='amount["+sub_iteration+"]'style='width: 100px;' /></td><td><select class='mediumtext' name='exp_status[]' id='exp_status["+sub_iteration+"]'><option value=''>Select</option>"+status_type+"</select></td><td class='hidden-480'><input type='hidden' name='exp_attachement[]' id='exp_attachement["+sub_iteration+"]' /></td><td class='hidden-480'><input class='validate[custom[file]]' type='file' style='width:175px;' name='exp_attachement[]' id='exp_attachement["+sub_iteration+"]' /></td><td class='hidden-480'><textarea name='comments[]' id='comments["+sub_iteration+"]' style='resize: none; height: 55px; width: 100%;'/></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
}
function DelExpenses(){
	var ins=document.getElementById('exp_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('expense_details');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="expenses_chk_"+bb+"";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="expenses"+b+"";
			var expensesid=document.getElementById("event_expenses_id["+b+"]").value;
			if(expensesid!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_event_expenses",
					global: false,
					type: "POST",
					data: ({val : expensesid}),
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
	document.getElementById('exp_hidden_id').value=arr1;
}
function AddMore(){
       var tbl = document.getElementById("fleupload_tab");
       var lastRow = tbl.rows.length;
       var lastrow1= lastRow+1;
       var hiddtab="inner_hidden_id";
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
               var attach_mat=document.getElementById('filename['+i+']').value;
               var att1=attach_mat.toUpperCase();
               var type=document.getElementById('filetype['+i+']').value;
               var att_typ1=type.toUpperCase();
			   var filename=document.getElementById('fileupload['+i+']').value;
			   var file_exist=document.getElementById('eve_attach_'+i+'').value;
               if(attach_mat==''){
                   alertify.alert("Please Enter AttachMent Name");
                   return false;
               }
				if(filename==''){					
					if(file_exist==''){
						alertify.alert("Please add File");
						return false;
					}
				}
               else{
                   for( var k=0;k<ins1.length;k++){
                       l=ins1[k];
                       var attach_mat2=document.getElementById('filename['+l+']').value;
                       var att2=attach_mat2.toUpperCase();
                       var type2=document.getElementById('filetype['+l+']').value;
                       var att_typ2=type2.toUpperCase();
					   var filename2=document.getElementById('fileupload['+l+']').value;
					   var file_exist2=document.getElementById('eve_attach_'+l+'').value;
					   var files=filename.replace(" ","_");
                       if(k!=j){
                           if(att1.trim()==att2.trim() && att_typ1.trim()==att_typ2.trim()){
                               alertify.alert("Attachment Name with same Type Already Exists");
                               return false;
                           }
						   if(filename==filename2 || files==file_exist2){
								alertify.alert("File Name Already Exists");
								return false;
						   }
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
       $("#fleupload_tab").append("<tr id='innertable"+sub_iteration+"'><td style='padding-left:20px;'><input type='hidden' name='attach_id[]' id='attach_id["+sub_iteration+"]' value=''><input type='checkbox' name='select_chk[]' id='select_chk_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><input class='mediumtext' type='text' name='filename[]' id='filename["+sub_iteration+"]' value='' style='width:120px;' maxlength='80' /></td><td><input type='hidden' name='aatchment_id[]' id='aatchment_id["+sub_iteration+"]' value='0' /><input class='mediumtext' type='text' name='filetype[]' id='filetype["+sub_iteration+"]' value='' style='width:92px;' maxlength='20'/></td><td style='padding-left:25px;'><input type='checkbox' name='display_learn[]' id='display_learn["+sub_iteration+"]' value='Yes' /></td><td style='padding-left:25px;'><input type='checkbox' name='display_trainer[]' id='display_trainer["+sub_iteration+"]' value='Yes' /></td><td><input type='hidden' name='eve_attach' id='eve_attach_"+sub_iteration+"' value=''></td><td><input class='validate[custom[file]]' type='file' name='fileupload[]' id='fileupload["+sub_iteration+"]' value='"+sub_iteration+"' style='width:175px;' /></td><!--<input type='hidden' id='hide_values["+sub_iteration+"]' name='hide_values[]' value='' />--></td></tr>");
       if(document.getElementById(hiddtab).value!=''){
           var ins=document.getElementById(hiddtab).value;
           document.getElementById(hiddtab).value=ins+","+sub_iteration;
       }
       else{
           document.getElementById(hiddtab).value=sub_iteration;
       }
   }
   
   function DelPrgmRow(){
       var ins=document.getElementById('inner_hidden_id').value;
       var arr1=ins.split(",");
       var flag=0;
       var tbl = document.getElementById('fleupload_tab');
       var lastRow = tbl.rows.length;
       for(var i=(arr1.length-1); i>=0; i--){
           var bb=arr1[i];
           var a="select_chk_"+bb+"";
           if(document.getElementById(a).checked){
               var b=document.getElementById(a).value;
               var c="innertable"+b+"";
                var attachmentid=document.getElementById("attach_id["+b+"]").value;
                if(attachmentid!=' '){
                    $.ajax({
                        url: BASE_URL+"/admin/delete_event_attachments",
                        global: false,
                        type: "POST",
                        data: ({val : attachmentid}),
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
       document.getElementById('inner_hidden_id').value=arr1;
}

function AddMaterial(){
       var tbl = document.getElementById("mat_upload_tab");
       var lastRow = tbl.rows.length;
       var lastrow1= lastRow+1;
       var hiddtab="mat_hidden_id";
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
               var mater1='learning_material_id['+i+']';
               var material=document.getElementById(mater1).value;
               var mattype=document.getElementById('material_details['+i+']').value;
               mattp1=mattype.split('_');
               //alertify.alert(mattp1[0]);
               if(material==''){
                   alertify.alert("Please Select Material");
                   return false;
               }else{
                   for( var k=0;k<ins1.length;k++){
                       l=ins1[k];
                       var material2='learning_material_id['+l+']';
                       var mattype2=document.getElementById('material_details['+l+']').value;
                       mattp2=mattype2.split('_');
                       //alertify.alert(mattp2[0]);
                       if(k!=j){
                           var ss1=document.getElementById(mater1).value;
                           var ss3=ss1.toUpperCase();
                           var ss2=document.getElementById(material2).value;
                           var ss4=ss2.toUpperCase();
                           if(ss3.trim()==ss4.trim() && mattp1[0]==mattp2[0]){
                               alertify.alert("Material Already Exists");
                               return false;
                           }
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
       //To get the e-learning non scorm data from .php page
	   if(elearn_nonscorm!=''){
       var nonscrmemat=elearn_nonscorm.split(',');
       var nonscorm_material='';
       for(var i=0;i<nonscrmemat.length;i++){
           nonscrmemat1=nonscrmemat[i];
           nonscrmemat2=nonscrmemat1.split('*');
           if(nonscorm_material==''){
               nonscorm_material="<option value='"+nonscrmemat2[0]+"'>"+nonscrmemat2[1]+"</option>";
           }else{
               nonscorm_material=nonscorm_material+"<option value='"+nonscrmemat2[0]+"'>"+nonscrmemat2[1]+"</option>";
           }
       }
	   }
	   else{
	   nonscorm_material='';
	   }
       $("#mat_upload_tab").append("<tr id='mat_innertable"+sub_iteration+"'><td style='padding-left:20px;'><input type='hidden' name='elearn_mat_id[]' id='elearn_mat_id["+sub_iteration+"]' value=''><input type='checkbox'  name='mat_chk[]' id='mat_chk["+sub_iteration+"]' value="+sub_iteration+" /></td><td><select name='learning_material_id[]' id='learning_material_id["+sub_iteration+"]' onchange='getmaterialdata("+sub_iteration+")' style='width:150px;'><option value=''>Select</option>"+nonscorm_material+"</select></td><td><select id='material_details["+sub_iteration+"]' name='material_details[]' style='width: 150px;'></select></td></tr>");
       if(document.getElementById(hiddtab).value!=''){
           var ins=document.getElementById(hiddtab).value;
           document.getElementById(hiddtab).value=ins+","+sub_iteration;
       }
       else{
           document.getElementById(hiddtab).value=sub_iteration;
       }
   }
   function DelMaterial(){
       var ins=document.getElementById('mat_hidden_id').value;
       var arr1=ins.split(",");
       var flag=0;
       var tbl = document.getElementById('mat_upload_tab');
       var lastRow = tbl.rows.length;
       for(var i=(arr1.length-1); i>=0; i--){
           var bb=arr1[i];
           var a="mat_chk["+bb+"]";
           if(document.getElementById(a).checked){
               var b=document.getElementById(a).value;
               var c="mat_innertable"+b+"";
               var code=document.getElementById("elearn_mat_id["+b+"]").value;
                if(code!=""){
                    $.ajax({
                        url: BASE_URL+"/admin/delete_singlematerial",
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
       document.getElementById('mat_hidden_id').value=arr1;
}
function cat_name(){
    var delivery_method=document.getElementById('del_met').value;
    if(delivery_method=='O'){
        document.getElementById('deliver_material_td1').style.display='block';
        document.getElementById('deliver_material_td2').style.display='block';
    }
    else{
        document.getElementById('deliver_material_td1').style.display='none';
        document.getElementById('deliver_material_td2').style.display='none';
        document.getElementById('online_material').style.display='none';
		document.getElementById('online_material').innerHTML='';
        document.getElementById('material').value='';
    }
}
function check_scorm(){
    if(materail_count>0){
        var confm=window.confirm("Do you wish to replace the existing material");
        if(confm){
            scorm_table();
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
                    document.getElementById('expert_data').innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET",BASE_URL+"/admin/delete_playmaterial?eventid="+eve_id,true);
            xmlhttp.send();
        }
        else{
            document.getElementById('material').value='';
            return false;
        }
    }
    else{
        scorm_table();
    }
}
function scorm_table(){
    //To get the e-learning scorm data from .php page
    if(elearn!=''){
        var emat=elearn.split(',');
        var learning_material='';
        for(var i=0;i<emat.length;i++){
            emat1=emat[i];
            emat2=emat1.split('*');
            if(learning_material==''){
                learning_material="<option value='"+emat2[0]+"'>"+emat2[1]+"</option>";
            }else{
                learning_material=learning_material+"<option value='"+emat2[0]+"'>"+emat2[1]+"</option>";
            }
        }
    }
    else{
        learning_material='';
    }

    //To get the e-learning non scorm data from .php page
    if(elearn_nonscorm!=''){
        var nonscrmemat=elearn_nonscorm.split(',');
        var nonscorm_material='';
        for(var i=0;i<nonscrmemat.length;i++){
            nonscrmemat1=nonscrmemat[i];
            nonscrmemat2=nonscrmemat1.split('*');
            if(nonscorm_material==''){
                nonscorm_material="<option value='"+nonscrmemat2[0]+"'>"+nonscrmemat2[1]+"</option>";
            }else{
                nonscorm_material=nonscorm_material+"<option value='"+nonscrmemat2[0]+"'>"+nonscrmemat2[1]+"</option>";
            }
        }
    }
    else{
        nonscorm_material='';
    }
    var mat_id=document.getElementById('material').value;
    document.getElementById('online_material').style.display='block';
    //alertify.alert(mat_id);
    if(mat_id=='SCORM'){
        document.getElementById('online_material').innerHTML="<h4 class='header blue bolder smaller'>e-learning Material</h4><table class='table table-striped table-bordered table-hover' id='mat_upload_tab' style='width:750px;'><thead><tr><th>Select</th><th>Material Name</th><th>Material Type</th></tr></thead><tr id='mat_innertable0'><td style='padding-left:20px;'><input type='hidden' name='elearn_mat_id[]' id='elearn_mat_id[0]' value=''><input type='checkbox'  name='mat_chk[]' id='mat_chk[0]' value='0' /></td><td><select style='width:150px;' name='learning_material_id[]' id='learning_material_id[0]' onchange='getmaterialdata(0)'/><option value=''>Select</option>"+learning_material+"</select></td><td><select id='material_details[0]' name='material_details[]' style='width: 150px;'></select></td></tr></table><input type='hidden' id='mat_hidden_id' value='0' name='mat_hidden_id' />";
    }
    else if(mat_id=='NON-SCORM'){
        document.getElementById('online_material').innerHTML="<h4 class='header blue bolder smaller'>e-learning Material</h4><div><input type='button' name='addrow' id='addrow' value='Add Row' class='btn btn-sm btn-success' onClick='AddMaterial()'/><input type='button' name='del' id='del' value='Delete Row'  class='btn btn-sm btn-danger' onClick='DelMaterial()'/></div><table class='table table-striped table-bordered table-hover' id='mat_upload_tab' style='width:750px;'><thead><tr><th>Select</th><th>Material Name</th><th>Material Type</th></tr></thead><tr id='mat_innertable0'><td style='padding-left:20px;'><input type='hidden' name='elearn_mat_id[]' id='elearn_mat_id[0]' value=''><input type='checkbox'  name='mat_chk[]' id='mat_chk[0]' value='0' /></td><td><select style='width:150px;' name='learning_material_id[]' id='learning_material_id[0]' onchange='getmaterialdata(0)'/><option value=''>Select</option>"+nonscorm_material+"</select></td><td><select id='material_details[0]' name='material_details[]' style='width: 150px;'></select></td></tr><input type='hidden' id='mat_hidden_id' value='0' name='mat_hidden_id' /></table>";
    }
    else{
        document.getElementById('online_material').innerHTML="";
    }
}
function getmaterialdata(key){
	var mat_type=document.getElementById('material').value;
    var attachid=document.getElementById('learning_material_id['+key+']').value;
	if(attachid==''){	
		document.getElementById('material_details['+key+']').innerHTML='';
		//document.getElementById('material_name['+key+']').value='';
	}
	else{
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
				//var resp=xmlhttp.responseText.split('*$');
				document.getElementById('material_details['+key+']').innerHTML=xmlhttp.responseText;
				//document.getElementById('material_name['+key+']').value=resp[1];
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/elearning_data?learning_id="+attachid+"&material_type="+mat_type,true);
		xmlhttp.send();
	}
}
function cant_update_enroll(){
    alertify.alert("Can not update Enrollment when status is either Cancelled or Attended");
}
function cannot_enroll(){
    alertify.alert("You cannot enroll participants, because enrollment end date has been end dated ");
}
function enrl_status_validates(){//alertify.alert(evnt_cnt);
    var enrl_status=document.getElementById('enroll_status').value;
    var enrl_cnt=document.getElementById('enrl_evnt_count').value;
	var evnt_stdate=document.getElementById('startdate').value;
	var sysdate=document.getElementById('sys_date').value;
	if(sysdate<evnt_stdate){
		if(enrl_status=='ATT'){
			alertify.alert("Event status can not be changed to Attended before starting the event");
			document.getElementById('enroll_status').value='REQ';
			return false;
		}
	}
    if(evnt_cnt==''){
        if(enrl_status=='WAIT'){
            alertify.alert("Employee can not be waitlisted when there is no maximum count for the event");
            document.getElementById('enroll_status').value='REQ';
            return false;
        }
    }
    else{
        if(parseInt(enrl_cnt)>=parseInt(evnt_cnt)){
            if(enrl_status=='CON'){
                alertify.alert("You cannot update the enrollment status to Confirmed, if the enrollment count more than event maximum count");
                document.getElementById('enroll_status').value='WAIT';
                return false;
            }
        }
    }
}

function enrolltype(){
	var enroll_type=document.getElementById('enroll_type').value;
	document.getElementById('enrollment_div').innerHTML="";
	if(enroll_type==1){
		single_enroll();
	}
	else if(enroll_type==2){
		bulk_enroll();
	}
	else if(enroll_type==3){
		tna_enroll();
	}
	else if(enroll_type==4){
		search_enroll();
	}
	else if(enroll_type==5){
		learnergroup_enroll();
	}
}


function learnergroup_enroll(){
	if(learner_grp!=''){
        var lnr_grp=learner_grp.split(',');
        var learner_groups='';
        for(var i=0;i<lnr_grp.length;i++){
            lnr_grp1=lnr_grp[i];
            lnr_grp2=lnr_grp1.split('*');
            if(learner_groups==''){
                learner_groups="<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }else{
                learner_groups=learner_groups+"<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }
        }
    }
    else{
        var learner_groups='';
    }
	document.getElementById('enrollment_div').innerHTML="<h4 class='header blue bolder smaller'>Learner Group</h4>\n\
	<div class='row'>\n\<input type='hidden' name='progid' id='progid' value='"+pro_id+"'>\n\
		<input type='hidden' name='evntid' id='evntid' value='"+eve_id+"'>\n\
		<input type='hidden' name='eve_max_cnt' id='eve_max_cnt' value='"+evnt_cnt+"'>&nbsp;&nbsp;\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Learner Group<sup><font color='#FF0000'>*</font></sup><br>\n\
			<input type='hidden' name='learner_id' id='learner_id' value=''>\n\
			<select name='learnersearchsel' id='learnersearchsel' class='validate[required]' onChange='learnersearchresult()'><option value=''>Select</option>"+learner_groups+"</select>\n\
		</div>\n\
	</div><br><div class='widget-box pricing-box-small widget-color-blue'><div class='widget-header'><h5 class='widget-title bigger lighter'>Search Results</h5></div></div><div id='learnersearchemptablediv'></div>";
}


function learnersearchresult(){	
	var del_method=document.getElementById('delivery_method').value;
	var eve_stdate=document.getElementById('event_stdate').value;
	var eve_enddate=document.getElementById('event_enddate').value;
	var learnersearch=document.getElementById('learnersearchsel').value;
	document.getElementById("learnersearchemptablediv").innerHTML="Loading data ...";
	var  xmlhttp2;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp2=new XMLHttpRequest();
	}
	else{
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function(){
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById("learnersearchemptablediv").innerHTML=xmlhttp2.responseText;
			$("#learnersearchcheckall").change(function(){
				$(".learnersearchcheck:enabled").prop('checked', $(this).prop("checked"));
			});
			$('.learnersearchcheck').change(function(){
				if(false == $(this).prop("checked")){
					$("#learnersearchcheckall").prop('checked', $(this).prop("checked")); 
				}
			});
		}
	}
	xmlhttp2.open("GET",BASE_URL+"/admin/learnersearchempdetails?learner_id="+learnersearch+"&eventid="+eve_id+"&del_method="+del_method+"&stdate="+eve_stdate+"&endate="+eve_enddate,true);
	xmlhttp2.send();
}

function search_enroll(){
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
            document.getElementById('enrollment_div').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/searchform?pro_id="+pro_id+"&eve_id="+eve_id+"&evnt_cnt="+evnt_cnt,true);
	xmlhttp.send();
}

function searchreasult(){	
	var del_method=document.getElementById('delivery_method').value;
	var eve_stdate=document.getElementById('event_stdate').value;
	var eve_enddate=document.getElementById('event_enddate').value;
	var loc=document.getElementById('searchlocation').value;
	var org=document.getElementById('searchorgname').value;
	var bus=document.getElementById('searchbus').value;
	var grad=document.getElementById('searchgrade').value;
	var emptype=document.getElementById('searchemptype').value;
	var post=document.getElementById('searchposition').value;
	if(org=='' && bus=='' && loc=='' && grad=='' && emptype=='' && post==''){
		alertify.alert("Please select anyone SBU, Organization, Location, Grade, Employee Type, Position.");
		return false;
	}
	document.getElementById("searchemptablediv").innerHTML="Loading data ...";
	var  xmlhttp2;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp2=new XMLHttpRequest();
	}
	else{
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function(){
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById("searchemptablediv").innerHTML=xmlhttp2.responseText;
			$("#searchcheckall").change(function(){
				$(".searchcheck:enabled").prop('checked', $(this).prop("checked"));
			});
			$('.searchcheck').change(function(){
				if(false == $(this).prop("checked")){
					$("#searchcheckall").prop('checked', $(this).prop("checked")); 
				}
			});
		}
	}
	xmlhttp2.open("GET",BASE_URL+"/admin/searchempdetails?group=B&loc="+loc+"&bus="+bus+"&org="+org+"&hierar=&grad="+grad+"&emptype="+emptype+"&post="+post+"&eventid="+eve_id+"&del_method="+del_method+"&stdate="+eve_stdate+"&endate="+eve_enddate,true);
	xmlhttp2.send();
}

function single_enroll(){
	// To fetch Employee Numbers from .php page
	if(emp_num!=''){
		var empnum=emp_num.split(',');
        var empdata='';
        for(var i=0;i<empnum.length;i++){
            emp1=empnum[i];
            emp2=emp1.split('*');
            if(empdata==''){
                empdata="<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }else{
                empdata=empdata+"<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }
        }
    }else{
        empdata='';
    }
     // To fetch Justifications from .php page
     if(justfication!=''){
        var justfic=justfication.split(',');
        var justdata='';
        for(var i=0;i<justfic.length;i++){
            just1=justfic[i];
            just2=just1.split('*');
            if(justdata==''){
                justdata="<option value='"+just2[0]+"'>"+just2[1]+"</option>";
            }else{
                justdata=justdata+"<option value='"+just2[0]+"'>"+just2[1]+"</option>";
            }
        }
    }
    else{
        justdata='';
    }
    // To fetch Enrollment Status from .php page
    if(enroll_stat!=''){
        var enrl=enroll_stat.split(',');
        var enroll_status='';
        for(var i=0;i<enrl.length;i++){
            ernl1=enrl[i];
            ernl2=ernl1.split('*');
            if(enroll_status==''){
                enroll_status="<option value='"+ernl2[0]+"'>"+ernl2[1]+"</option>";
            }else{
                enroll_status=enroll_status+"<option value='"+ernl2[0]+"'>"+ernl2[1]+"</option>";
            }
        }
    }else{
        enroll_status='';
    }
    // To fetch Enrollment Emp Numbers from .php page
    if(enroll_emp_asd!=''){
        var enrl_emp=enroll_emp_asd.split(',');
        var enroll_emp='';
        for(var i=0;i<enrl_emp.length;i++){
            ernlemp1=enrl_emp[i];
            ernlemp2=ernlemp1.split('*');
            if(enroll_emp==''){
                enroll_emp="<option value='"+ernlemp2[0]+"'>"+ernlemp2[1]+"</option>";
            }else{
                enroll_emp=enroll_emp+"<option value='"+ernlemp2[0]+"'>"+ernlemp2[1]+"</option>";
            }
        }
    }else{
        enroll_emp='';
    }
    //document.getElementById('single_enroll_div').style.display='block';
    //document.getElementById('bulk_enroll_div').style.display='none';
   var param='"enrollment_div"';
    document.getElementById('enrollment_div').innerHTML="<h4 class='header blue bolder smaller'>Single Enrollment</h4>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Employee Number<sup><font color='#FF0000'>*</font></sup><br>\n\
			<select class='validate[required, ajax[ajaxEnrlEmp]] chosen-select' name='emp_no'  id='emp_no' onChange='fetch_empdata()'>\n\
			<option value='N/A'>Select</option>"+empdata+"</select>\n\
			<input type='hidden' name='progid' id='progid' value="+pro_id+">\n\
			<input type='hidden' name='evntid' id='evntid' value="+eve_id+">\n\
			<input type='hidden' name='enroll_id' id='enroll_id' value=''>&nbsp;&nbsp;\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Employee Name<br>\n\
			<input type='text' class='col-xs-12 col-sm-12' name='emp_name' id='emp_name' value='' readonly>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Department<br>\n\
			<input type='hidden' name='emp_org_id' id='emp_org_id' value=''>\n\
			<input type='text' class='col-xs-12 col-sm-12' name='department' id='department' value='' readonly>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Justification<br>\n\
			<select name='justification' class='col-xs-12 col-sm-12' id='justification'><option value=''>Select</option>"+justdata+"</select>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Enrollment Status<sup><font color='#FF0000'>*</font></sup><br>\n\
			<input type='hidden' name='eve_max_cnt' id='eve_max_cnt' value='"+evnt_cnt+"'><select onchange='enrl_status_validates()' class='validate[required] col-xs-12 col-sm-12' name='enroll_status' id='enroll_status'><option value=''>Select</option>"+enroll_status+"</select>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Approved By<br>\n\
			<select class='chosen-select' name='enrol_approver'  id='enrol_approver'><option value=''>Select</option>"+enroll_emp+"</select>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<!--<div class='col-xs-12 col-sm-3'>\n\
			Source<br>\n\
			<select name='enrol_source' class='col-xs-12 col-sm-12' id='enrol_source'><option value=''>Select</option></select>\n\
		</div>-->\n\
		<div class='col-xs-12 col-sm-6'>\n\
			Instruction<br>\n\
			<textarea class='validate[maxSize[150]] col-xs-12 col-sm-12' name='instruction' id='instruction' style='resize:none;'></textarea>\n\
		</div>\n\
	</div><br>\n\
<!--<h4 class='header blue bolder smaller'>Evaluations</h4>\n\
<table class='table table-striped table-bordered table-hover'><thead><tr><th>Evaluation Type</th><th>Status</th><th>Correct Answers</th><th>Wrong Answers</th><th>Total Questions</th><th>Action</th></tr></thead>\n\
<tr><td>No data found </td></tr></table>-->\n\
<h4 class='header blue bolder smaller'>Attachments</h4>\n\
<div>\n\
<input type='hidden' id='single_hidden_id' value='0' name='single_hidden_id' />\n\
<input type='button' name='addrow' id='addrow' value='Add Row' class='btn btn-sm btn-success' onClick='AddEnrollRow()'/>\n\
<input type='button' name='del' id='del' value='Delete Row'  class='btn btn-sm btn-danger' onClick='DelEnrollAttachment()'/></div>\n\
<table id='single_enroll_tab' class='table table-striped table-bordered table-hover'>\n\
<thead>\n\
<tr>\n\
<td>Select</td>\n\
<td>Attachment Name</td>\n\
<td>Attachment Type</td>\n\
<td>Display To Learner</td>\n\
<td>File Name</td>\n\
<td>Browse</td>\n\
</tr>\n\
</thead>\n\
<tr id='single_enroll0'>\n\
<td style='padding-left:20px;'>\n\
<input type='checkbox'  name='single_enrl_chk[]' id='single_enrl_chk_0' value='0' /></td>\n\
<td>\n\
<input type='hidden' name='enroll_attach_id[]' id='enroll_attach_id[0]' value=''>\n\
<input type='text' name='enrol_attach_name[]' id='enrol_attach_name[0]' style='width:150px;' class='validate[minSize[2],maxSize[150], custom[alphanumericSp]] mediumtext'/></td>\n\
<td><input type='text' name='enrol_attach_type[]' id='enrol_attach_type[0]' style='width:95px;' class='validate[minSize[2],maxSize[30], custom[alphabets]] mediumtext'/></td>\n\
<td style='padding-left:50px;'  >\n\
<input type='checkbox' name='enrol_display_learn[]' id='enrol_display_learn[0]' value='Yes' /></td>\n\
<td><input type='hidden' name='file_id_0' id='file_id_0' value=''></td>\n\
<td><input class='validate[custom[file]]' type='file' name='enrol_attach_file[]' id='enrol_attach_file0' style='width:120px;' /></td>\n\
</tr></table>\n\
<div class='form-actions center'>\n\
<input type='submit' name='single_save'  id='single_save' value='Save' class='btn btn-sm btn-success' onclick='return enrol_attach_valid()' >&nbsp;&nbsp;&nbsp;\n\
<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div>";
    document.getElementById('emp_name').focus();
	//$('.chosen-select').chosen({allow_single_deselect:true}); 
	$('#emp_no').ajaxChosen({
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});
	$('#enrol_approver').ajaxChosen({
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});
	//resize the chosen on window resize
	$(window).on('resize.chosen', function() {
	var w = $('.chosen-select').parent().width();
	if(w<=25){w=250;}
	$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');
	
	/*$("#emp_no").css("float","right");
	$("#emp_no").css("display","block");
	$("#emp_no").css("height","1px");
	$("#emp_no").css("width","1px");*/
}
function change_bulk_type(){
	var radio_checked1=document.getElementById('search_bulkemp');
	var radio_checked2=document.getElementById('upload_bulkemp');
	if(radio_checked1.checked==true){
		document.getElementById('search_bulkemp_data').style.display='block';
		document.getElementById('upload_empbulk_div').style.display='none';
	}
	else if(radio_checked2.checked==true){
		document.getElementById('search_bulkemp_data').style.display='none';
		document.getElementById('upload_empbulk_div').style.display='block';
	}
}
function bulk_enroll(){
	//alertify.alert(path);
    // To fetch Employee Numbers from .php page
    if(emp_num!=''){
        var empnum=emp_num.split(',');
        var empdata='';
        for(var i=0;i<empnum.length;i++){
            emp1=empnum[i];
            emp2=emp1.split('*');
            if(empdata==''){
                empdata="<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }else{
                empdata=empdata+"<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }
        }
    }
    else{
        empdata='';
    }
    
    // To fetch Emp Names from .php page
    if(enroll_emp_asd!=''){
        var enrl_emp=enroll_emp_asd.split(',');
        var emp_names='';
        for(var i=0;i<enrl_emp.length;i++){
            ernlemp1=enrl_emp[i];
            ernlemp2=ernlemp1.split('*');
            if(emp_names==''){
                emp_names="<option value='"+ernlemp2[0]+"'>"+ernlemp2[1]+"</option>";
            }else{
                emp_names=emp_names+"<option value='"+ernlemp2[0]+"'>"+ernlemp2[1]+"</option>";
            }
        }
    }
    else{
        emp_names='';
    }
    // To fetch Learner Groups from .php page
    if(learner_grp!=''){
        var lnr_grp=learner_grp.split(',');
        var learner_groups='';
        for(var i=0;i<lnr_grp.length;i++){
            lnr_grp1=lnr_grp[i];
            lnr_grp2=lnr_grp1.split('*');
            if(learner_groups==''){
                learner_groups="<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }else{
                learner_groups=learner_groups+"<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }
        }
    }
    else{
        learner_groups='';
    }
     //To fetch Manager Names from .php page
     if(manager){
        var mng=manager.split(',');
        var managers='';
        for(var i=0;i<mng.length;i++){
            mng1=mng[i];
            mng2=mng1.split('*');
            if(managers==''){
                managers="<option value='"+mng2[0]+"'>"+mng2[1]+"</option>";
            }else{
                managers=managers+"<option value='"+mng2[0]+"'>"+mng2[1]+"</option>";
            }
        }
    }
    else{
        managers='';
    }
    // To fetch Learner Org Names from .php page
    if(enrol_org!=''){
        var erl_org=enrol_org.split(',');
        var enrl_orgnames='';
        for(var i=0;i<erl_org.length;i++){
            erl_org2=erl_org[i].split('*');
            if(enrl_orgnames==''){
                enrl_orgnames="<option value='"+erl_org2[0]+"'>"+erl_org2[1]+"</option>";
            }else{
                enrl_orgnames=enrl_orgnames+"<option value='"+erl_org2[0]+"'>"+erl_org2[1]+"</option>";
            }
        }
    }else{
        enrl_orgnames='';
    }
    // To fetch Locations from .php page
    if(locate!=''){
        var locs=locate.split(',');
        var locations='';
        for(var i=0;i<locs.length;i++){
            locs2=locs[i].split('*');
            if(locations==''){
                locations="<option value='"+locs2[0]+"'>"+locs2[1]+"</option>";
            }else{
                locations=locations+"<option value='"+locs2[0]+"'>"+locs2[1]+"</option>";
            }
        }
    }else{
        locations='';
    }
    // To fetch Employee types from .php page
    if(emptype!=''){
        var type=emptype.split(',');
        var emp_type='';
        for(var i=0;i<type.length;i++){
            type2=type[i].split('*');
            if(emp_type==''){
                emp_type="<option value='"+type2[0]+"'>"+type2[1]+"</option>";
            }else{
                emp_type=emp_type+"<option value='"+type2[0]+"'>"+type2[1]+"</option>";
            }
        }
    }else{
        emp_type='';
    }
    
    //document.getElementById('single_enroll_div').style.display='block';
    //document.getElementById('bulk_enroll_div').style.display='none';
  
    document.getElementById('enrollment_div').innerHTML="<h4 class='header blue bolder smaller'>Bulk Enrollment</h4><div id='upload_empbulk_div' ><br>\n\
		<input type='hidden' name='progid' id='progid' value="+pro_id+">\n\
		<input type='hidden' name='evntid' id='evntid' value="+eve_id+">\n\
		<input type='hidden' name='eve_max_cnt' id='eve_max_cnt' value='"+evnt_cnt+"'>&nbsp;&nbsp;\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sl-3'>\n\
				<div class='form-group'>\n\
					<div class='col-xs-12'>\n\<!--href='"+download_page+"?id="+BASE_URL+"/public/templates/bulk_template.csv'-->\n\
						<a href='"+BASE_URL+"/public/templates/bulk_template.csv' style='text-decoration:underline;color:#00F' id='bulk_template'>Click here</a> to download sample template\n\
					</div>\n\
				</div>\n\
			</div><br>\n\
			<div class='col-xs-12 col-sl-3'>\n\
				<div class='form-group'>\n\
					<div class='col-xs-3'>\n\
						<input type='file' name='upload' id='bulkempupload'>&nbsp;&nbsp;<br>\n\
					</div>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sl-3'>\n\
				<input type='button' class='btn btn-sm btn-success' name='bulk_upload' id='bulk_upload' value='Upload'>\n\
			</div>\n\
			</div>\n\
		</div><br>\n\
	</div>\n\
<h4 class='header blue bolder smaller'>Employee Details</h4>\n\
<div id='bulk_search_data'>\n\
<table id='single_enroll_tab' class='table table-striped table-bordered table-hover'>\n\
<thead>\n\
<tr>\n\
<th>Select</th>\n\
<th>Employee Number</th>\n\
<th>Employee Name</th>\n\
<th>Organization</th>\n\
<th>Status</th>\n\
</tr>\n\
</thead>\n\
<tr id='single_enroll0'>\n\
<td style='padding-left:20px;'>\n\
No Search Data Found</td>\n\
<td align='left'>\n\
<input type='hidden' name='employee_id[]' id='employee_id[0]' value=''>\n\
<input type='hidden' name='employee_number[]' id='employee_number[0]' value=''/></td>\n\
<td align='left'><input type='hidden' name='employee_name[]' id='employee_name[0]' value=''/></td>\n\
<td align='center' style='padding-left:50px;'>\n\
<input type='hidden' name='organization_id[]' id='organization_id[0]' value=''/>\n\
<input type='hidden' name='org_name[]' id='org_name[0]' value=''/></td>\n\
<td align='left'>&nbsp;</td>\n\
</tr></table></div>";
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
/* document.getElementById('enrol_learner_group').focus();
    $('.chosen-select').chosen({allow_single_deselect:true}); 
	//resize the chosen on window resize
	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=25){w=250;}
		$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');
	$('#enrol_emp_no').ajaxChosen({
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	}); */

	$(document).on('click', 'th input:checkbox' , function(){
		var that = this;
		$(this).closest('table').find('tr > td:first-child input:checkbox:enabled')
		.each(function(){
			this.checked = that.checked;
			$(this).closest('tr').toggleClass('selected');
		});
	});
	
    
    $(function(){
        // Variable to store your files
	var files;
	// Add events
	$('input[type=file]').on('change', prepareUpload);
	$('#bulk_upload').on('click', uploadFiles);

	// Grab the files and set them to our variable
	function prepareUpload(event){
            files = event.target.files;
        }
	// Catch the form submit and upload the files
	function uploadFiles(event){
		var browse=document.getElementById('bulkempupload').value;
		var del_method=document.getElementById('delivery_method').value;
		var eve_stdate=document.getElementById('event_stdate').value;
		var eve_enddate=document.getElementById('event_enddate').value;
		
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
                url: BASE_URL+"/admin/upload_bulk_emp?files&eventid="+eve_id+"&del_method="+del_method+"&stdate="+eve_stdate+"&endate="+eve_enddate+"",
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
						$("#blkcheckall").change(function(){
							$(".blkcheck:enabled").prop('checked', $(this).prop("checked"));
						});
						$('.blkcheck').change(function(){
							if(false == $(this).prop("checked")){
								$("#blkcheckall").prop('checked', $(this).prop("checked")); 
							}
						});
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
                url: BASE_URL+"/admin/upload_bulk_emp",
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

    
}

/*function upload_emps(){
    var filename=document.getElementById('upload').value;
    if(filename!=''){
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
                alertify.alert(xmlhttp.responseText);
                //document.getElementById('bulk_search_data').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/upload_bulk_emp?file_name="+filename,true);
        xmlhttp.send();
    }
    else{
        alertify.alert("Please Upload a File");
        return false;
    }
}*/







function bulk_emp(){//alertify.alert(eve_id);
    var empno=document.getElementById('enrol_emp_no').value;
    //var empname=document.getElementById('enrol_employee_name').value;
    var lrngrop=document.getElementById('enrol_learner_group').value;
    var dept=document.getElementById('enrol_department').value;
    var mngr=document.getElementById('enrol_manager').value;
    var emptyp=document.getElementById('enrol_employee_type').value;
    var location=document.getElementById('enrol_location').value;
	var del_method=document.getElementById('delivery_method').value;
	var eve_stdate=document.getElementById('event_stdate').value;
	var eve_enddate=document.getElementById('event_enddate').value;
    if(empno=='' && lrngrop=='' && dept=='' && mngr=='' && emptyp=='' && location==''){
        alertify.alert("Please select atleast one option");
        return false;
    }
    else{
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
//                var resdata=xmlhttp.responseText.split('*#');
//                document.getElementById('employee_number[0]').value=resdata[0];
//                document.getElementById('employee_number[0]').value=resdata[0];
//                document.getElementById('employee_number[0]').value=resdata[0];
                document.getElementById('bulk_search_data').innerHTML=xmlhttp.responseText;
				$(document).on('click', 'th input:checkbox' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox:enabled')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
				});
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/fetch_bulk_emp_data?empnum="+empno+"&lnrgrp="+lrngrop+"&depart="+dept+"&mngr="+mngr+"&emptype="+emptyp+"&locat="+location+"&eventid="+eve_id+"&del_method="+del_method+"&stdate="+eve_stdate+"&endate="+eve_enddate,true);
        xmlhttp.send();
    }
    
}
function fetch_empdata(){
    var empno=document.getElementById('emp_no').value;
	var del_method=document.getElementById('delivery_method').value;
	var eve_stdate=document.getElementById('event_stdate').value;
	var eve_enddate=document.getElementById('event_enddate').value;
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
			if($response[0]==0){
				alertify.alert($response[1]);
				//document.getElementById('emp_no').value='';
				$("#emp_no option[value='N/A']").attr("selected", true);
				return false;
			}else{
				if($response[0]!=""){//alertify.alert($response[4]);
					document.getElementById('emp_name').value=$response[1];
					document.getElementById('department').value=$response[2];
					document.getElementById('emp_org_id').value=$response[4];
				}
				else{
					alertify.alert("Employee details does not found with this Employee Number");
					document.getElementById('emp_no').value='';
					document.getElementById('emp_name').value='';
					document.getElementById('department').value='';
					document.getElementById('emp_org_id').value='';
					return false;
				}
			}
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_emp_data_id?empnum="+empno+"&eventid="+eve_id+"&del_method="+del_method+"&stdate="+eve_stdate+"&endate="+eve_enddate,true);
    xmlhttp.send(); 
}
  function Enroll_data_Delete(){
        var ins=document.getElementById('hidden_val').value;	
		var arr1=ins.split(",");
        var flag=0;
		var tbl = document.getElementById('newtableid');
		var lastRow = tbl.rows.length;
		for(var i=(arr1.length-1); i>=0; i--){
            var bb=arr1[i];
            var a="chck["+bb+"]";
            if(document.getElementById(a).checked){
                var b=document.getElementById(a).value;
                var c="innerdata["+b+"]";
                var code=document.getElementById("enroll_id["+b+"]").value;
				var empid=document.getElementById("enroll_emp_id["+b+"]").value;
				var eventid=document.getElementById("enrl_evnt_id").value;
                if(code!=""){
                    $.ajax({
                        url: BASE_URL+"/admin/delete_enroll_data",
                        global: false,
                        type: "POST",
                        data: ({enrol_id : code, emp_id: empid, eve_id: eventid}),
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
                //alertify.alert("#"+c);
                document.getElementById(c).style.display='none';
                document.getElementById('enrollment_div').innerHTML='';
               // $("#"+c).remove();                
            }
        }
        if(flag==0){
            alertify.alert("Please select the data to Delete");
            return false;
        }
        document.getElementById('hidden_val').value=arr1;
		if(lastRow<5){
			$('#enrolldivtab').css('height','auto');
		}
    }
    
function enrol_attach_valid(){
    var hiddtab="single_hidden_id";
    var ins=document.getElementById(hiddtab).value;
    if(ins!=''){
        var ins1=ins.split(",");
        var temp=0;
        for( var j=0;j<ins1.length;j++){
            if(ins1[j]>temp){
                temp=ins1[j];
            }
        }
        sub_iteration=parseInt(temp)+1;
        for( var j=0;j<ins1.length;j++){
            var i=ins1[j];
            var attatchment=document.getElementById('enrol_attach_name['+i+']').value;
            var att1=attatchment.toUpperCase();
            var type=document.getElementById('enrol_attach_type['+i+']').value;
            var att_typ1=type.toUpperCase();
            if(attatchment!=''){
                for( var k=0;k<ins1.length;k++){
                     l=ins1[k];
                     var attatchment2=document.getElementById('enrol_attach_name['+l+']').value;
                     var att2=attatchment2.toUpperCase();
                     var type2=document.getElementById('enrol_attach_type['+l+']').value;
                     var att_typ2=type2.toUpperCase();
                     if(k!=j){
                         if(att1.trim()==att2.trim() && att_typ1.trim()==att_typ2.trim()){
                             alertify.alert("Attachment with same type Already Exists");
                             return false;
                         }
                     }
                 }
            }
        }
    }
 }       
   function AddEnrollRow(){
//      var tbl = document.getElementById("single_enroll_tab");
//      var lastRow = tbl.rows.length;
//      var lastrow1= lastRow+1;
      var hiddtab="single_hidden_id";
      var ins=document.getElementById(hiddtab).value;
      if(ins!=''){
          var ins1=ins.split(",");
          var temp=0;
          for( var j=0;j<ins1.length;j++){
              if(ins1[j]>temp){
                  temp=ins1[j];
              }
          }
          sub_iteration=parseInt(temp)+1;
          for( var j=0;j<ins1.length;j++){
              var i=ins1[j];
              var attatchment=document.getElementById('enrol_attach_name['+i+']').value;
              var att1=attatchment.toUpperCase();
              var type=document.getElementById('enrol_attach_type['+i+']').value;
              var att_typ1=type.toUpperCase();
			  var filename=document.getElementById('enrol_attach_file'+i+'').value;
			  var file_exist=document.getElementById('file_id_'+i+'').value;
              if(attatchment==''){
                  alertify.alert("Please Enter Attachment Name");
                  return false;
              }
			  if(filename==''){
				if(file_exist==''){
					alertify.alert("Please add File");
					return false;
				}
              }
              else{
                   for( var k=0;k<ins1.length;k++){
                       l=ins1[k];
                       var attatchment2=document.getElementById('enrol_attach_name['+l+']').value;
                       var att2=attatchment2.toUpperCase();
                       var type2=document.getElementById('enrol_attach_type['+l+']').value;
                       var att_typ2=type2.toUpperCase();
					   var filename2=document.getElementById('enrol_attach_file'+l+'').value;
					   var file_exist2=document.getElementById('file_id_'+l+'').value;
					   var files=filename.replace(" ","_");
                       if(k!=j){
                            if(att1.trim()==att2.trim() && att_typ1.trim()==att_typ2.trim()){
                               alertify.alert("Attachment with same type Already Exists");
                               return false;
							}
							if(filename==filename2 || files==file_exist2){
								alertify.alert("File Already Exists");
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
      $("#single_enroll_tab").append("<tr id='single_enroll"+sub_iteration+"'><td style='padding-left:20px;'><input type='checkbox' name='single_enrl_chk[]' id='single_enrl_chk_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><input type='hidden' name='enroll_attach_id[]' id='enroll_attach_id["+sub_iteration+"]' value=''><input type='text' style='width:150px;' name='enrol_attach_name[]' id='enrol_attach_name["+sub_iteration+"]' value='' class='validate[minSize[2],maxSize[150], custom[alphanumericSp]] mediumtext' /></td><td><input type='text' style='width:95px;' name='enrol_attach_type[]' id='enrol_attach_type["+sub_iteration+"]' value='' class='validate[minSize[2],maxSize[150], custom[alphabets]] mediumtext'/></td><td style='padding-left:50px;'><input type='checkbox' name='enroll_display_learn[]' id='enroll_display_learn["+sub_iteration+"]' value='Yes' /></td><td><input type='hidden' name='file_id_"+sub_iteration+"' id='file_id_"+sub_iteration+"' value=''></a></td><td><input class='validate[custom[file]]' type='file' style='width:120px;' name='enrol_attach_file[]' id='enrol_attach_file"+sub_iteration+"' value='"+sub_iteration+"'  /></td><input type='hidden' id='hide_values["+sub_iteration+"]' name='hide_values[]' value='' /></td></tr>");
      if(document.getElementById(hiddtab).value!=''){
          var ins=document.getElementById(hiddtab).value;
          document.getElementById(hiddtab).value=ins+","+sub_iteration;
      }
      else{
          document.getElementById(hiddtab).value=sub_iteration;
      }
 }   
 
 function DelEnrollRow(){
	var ins=document.getElementById('single_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="select_bulk_chk_"+bb+"";
		//alertify.alert(a);
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			//alertify.alert(b);
			var c="bulk_enrol_del_"+b+"";
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
	document.getElementById('single_hidden_id').value=arr1;
}
function DelEnrollAttachment(){
	var ins=document.getElementById('single_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="single_enrl_chk_"+bb+"";
		//alertify.alert(a);
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			//alertify.alert(b);
			var c="single_enroll"+b+"";
			var code=document.getElementById("enroll_attach_id["+b+"]").value;
			if(code!=""){
				$.ajax({
					url: BASE_URL+"/admin/delete_enroll_attachment",
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
	document.getElementById('single_hidden_id').value=arr1;
}
function update_single_enroll(id){
    var prgid=document.getElementById('enrl_prg_id').value;
    var evntid=document.getElementById('enrl_evnt_id').value;
	var del_method=document.getElementById('del_met').value;
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
            document.getElementById('enrollment_div').innerHTML=xmlhttp.responseText;
			document.getElementById('emp_name').focus();
			$('#emp_no').ajaxChosen({
				   dataType: 'json',
				   type: 'POST',
				   url:BASE_URL+'/admin/autoemployee'
			},{
				   loadingImg: 'loading.gif'
			});
			$('#enrol_approver').ajaxChosen({
				   dataType: 'json',
				   type: 'POST',
				   url:BASE_URL+'/admin/autoemployee'
			},{
				   loadingImg: 'loading.gif'
			});
            $('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
				var w = $('.chosen-select').parent().width();
				if(w<=25){w=250;}
				$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/enroll_event_update?enrl_id="+id+"&prog_id="+prgid+"&evntid="+evntid+"&eve_cnt="+evnt_cnt+"&del_met="+del_method,true);
    xmlhttp.send();
}
function get_positions(){
    var orgid=document.getElementById('learner_org').value;
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
            //alertify.alert(xmlhttp.responseText);
            document.getElementById("learner_pos").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/ChangePosition?org_id="+orgid,true);
    xmlhttp.send();
}
function cannot_restrict(){
	alertify.alert("Learner Access can not be done after Enrollment");
	document.getElementById('restrict').value='';
	return false;
}
function restrict_failed(){
	alertify.alert("Learner Access can not be done after Enrollment");
	return false;
}

$('.chosen-toggle').each(function(index) {
    $(this).on('click', function(){
         $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
    });
});

function get_details(){
	var rest=document.getElementById('restrict').value;
	if(rest=='W' || rest=='LOC'){   
		document.getElementById('work_details_div').style.display='block';
		document.getElementById('Learner_Group_div').style.display='none';
		$("#select_button_zones").width('16');
		$("#select_button_loc").width('16');
		$("#select_button_bu").width('16');
		$("#select_button_div").width('16');
		$("#select_button_dep").width('16');
		$("#select_button_grade").width('16');
		$("#select_button_emptype").width('16');
		$("#select_button_cat").width('16');
		$(".default").width('650');
	}
	if(rest=='L'){
		document.getElementById('Learner_Group_div').style.display='block';
		document.getElementById('work_details_div').style.display='none';
		$('.chosen-select').chosen({allow_single_deselect:true}); 
		//resize the chosen on window resize
		/* $(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=25){w=250;}
			$('.chosen-select').next().css({'width':w});
		}).trigger('resize.chosen'); */
	}
}

/* function get_details(){
    // To fetch Learner Org Names from .php page
    if(enrol_org!=''){
        var lnr_org=enrol_org.split(',');
        var learner_orgnames='';
        for(var i=0;i<lnr_org.length;i++){
            lnr_org1=lnr_org[i];
            lnr_org2=lnr_org1.split('*');
            if(learner_orgnames==''){
                learner_orgnames="<option value='"+lnr_org2[0]+"'>"+lnr_org2[1]+"</option>";
            }else{
                learner_orgnames=learner_orgnames+"<option value='"+lnr_org2[0]+"'>"+lnr_org2[1]+"</option>";
            }
        }
    }else{
        learner_orgnames='';
    }    

     // To fetch Learner Groups from .php page
     if(learner_grp!=''){
        var lnr_grp=learner_grp.split(',');
        var learner_groups='';
        for(var i=0;i<lnr_grp.length;i++){
            lnr_grp1=lnr_grp[i];
            lnr_grp2=lnr_grp1.split('*');
            if(learner_groups==''){
                learner_groups="<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }else{
                learner_groups=learner_groups+"<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }
        }
    }else{
        learner_groups='';
    }
	// To fetch Learner Groups from .php page
	if(locate!=''){
        var locs=locate.split(',');
        var location='';
        for(var i=0;i<locs.length;i++){
            loc1=locs[i];
            loc2=loc1.split('*');
            if(location==''){
                location="<option value='"+loc2[0]+"'>"+loc2[1]+"</option>";
            }else{
                location=location+"<option value='"+loc2[0]+"'>"+loc2[1]+"</option>";
            }
        }
    }else{
        location='';
    }
    
    var rest=document.getElementById('restrict').value;
	 
    if(rest=='W'){   
		var param='"work_details_div"'; 
        document.getElementById('work_details_div').style.display='block';
        document.getElementById('work_details_div').innerHTML="<h4 class='header blue bolder smaller'>Work Details</h4>\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Organization<sup><font color='#FF0000'>*</font></sup><br>\n\
				<input type='hidden' name='learner_id' id='learner_id' value=''>\n\
				<select class='validate[required,ajax[ajaxEventOrgName]] chosen-select' name='learner_org' id='learner_org' onchange='get_positions()'><option value=''>Select</option>"+learner_orgnames+"</select>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Position<br>\n\
				<select name='learner_pos' id='learner_pos' class='col-xs-12 col-sm-12' onclick='include_hierarchy()' ><option value=''>Select</option></select>\n\
			</div>\n\
		</div><br>\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				<input type='hidden' name='child_ids' id='child_ids' value=''>\n\
				<input type='checkbox'  name='learner_child' id='learner_child'  value='' onclick='include_hierarchy()'>&nbsp;Include Child Hierarchy\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				<div id='learn_hier_name'></div>\n\
				<div id='learn_hier_select'></div>\n\
			</div>\n\
		</div><br>\n\
		<!--<h4 class='header blue bolder smaller'>Enrollment Type</h4>\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sm-3'><br>\n\
				<input type='checkbox' name='learner_self' id='learner_self' value='S'>&nbsp;No Approval Required\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'><br>\n\
				<input type='checkbox' name='learner_mandatory' id='learner_mandatory' value='M'>&nbsp;Mandatory Enrollment\n\
			</div>\n\
		</div><br>-->\n\
		<div class='form-actions center' >\n\
		<input type='submit' name='learner_save'  id='learner_save' value='Save' class='btn btn-sm btn-success' >&nbsp;&nbsp;&nbsp;\n\
		<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div>";
            document.getElementById('Learner_Group_div').style.display='none';
			document.getElementById('Location_div').style.display='none';
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
				var w = $('.chosen-select').parent().width();
				if(w<=25){w=250;}
				$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');
            return false;
	}
	if(rest=='L'){
		var param='"Learner_Group_div"';
		document.getElementById('Learner_Group_div').style.display='block';
		document.getElementById('Learner_Group_div').innerHTML="<h4 class='header blue bolder smaller'>Learner Group</h4>\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Learner Group<sup><font color='#FF0000'>*</font></sup><br>\n\
				<input type='hidden' name='learner_id' id='learner_id' value=''>\n\
				<select name='restrict' id='learn_restrict' class='validate[required,ajax[ajaxEventlearnergroup]] chosen-select'><option value=''>Select</option>"+learner_groups+"</select>\n\
			</div>\n\
		</div><br>\n\
		<!--<h4 class='header blue bolder smaller'>Enrollment Type</h4>\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				<br>\n\
				<input type='checkbox' name='learner_self' id='learner_self' value='S'>&nbsp;No Approval Required\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				<br>\n\
				<input type='checkbox' name='learner_mandatory' id='learner_mandatory' value='M'>&nbsp;Mandatory Enrollment\n\
			</div>\n\
		</div><br>-->\n\
		<div class='form-actions center' >\n\
		<input type='submit' name='learner_save'  id='learner_save' value='Save' class='btn btn-sm btn-success' >&nbsp;&nbsp;&nbsp;\n\
		<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div>";
		document.getElementById('work_details_div').style.display='none';
		document.getElementById('Location_div').style.display='none';
		$('.chosen-select').chosen({allow_single_deselect:true}); 
		//resize the chosen on window resize
		$(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=25){w=250;}
			$('.chosen-select').next().css({'width':w});
		}).trigger('resize.chosen');
		return false;
	}
	if(rest=='LOC'){
		var param='"Location_div"';
		document.getElementById('Location_div').style.display='block';
		document.getElementById('Location_div').innerHTML="<h4 class='header blue bolder smaller'>Location</h4>\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Location<sup><font color='#FF0000'>*</font></sup><br>\n\
				<input type='hidden' name='learner_id' id='learner_id' value=''>\n\
				<select name='loc_restrict' id='loc_restrict' class='validate[required,ajax[ajaxEventLocation]] chosen-select'><option value=''>Select</option>"+location+"</select>\n\
			</div>\n\
		</div><br>\n\
		<!--<h4 class='header blue bolder smaller'>Enrollment Type</h4>\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				<br>\n\
				<input type='checkbox' name='learner_self' id='learner_self' value='S'>&nbsp;No Approval Required\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				<br>\n\
				<input type='checkbox' name='learner_mandatory' id='learner_mandatory' value='M'>&nbsp;Mandatory Enrollment\n\
			</div>\n\
		</div><br>-->\n\
		<div class='form-actions center' >\n\
		<input type='submit' name='learner_save'  id='learner_save' value='Save' class='btn btn-sm btn-success' >&nbsp;&nbsp;&nbsp;\n\
		<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div>";
		document.getElementById('work_details_div').style.display='none';
		document.getElementById('Learner_Group_div').style.display='none';
		$('.chosen-select').chosen({allow_single_deselect:true}); 
		//resize the chosen on window resize
		$(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=25){w=250;}
			$('.chosen-select').next().css({'width':w});
		}).trigger('resize.chosen');
		return false;
	}
	if(rest==''){
		document.getElementById('work_details_div').style.display='none';
		document.getElementById('Learner_Group_div').style.display='none';
		document.getElementById('Location_div').style.display='none';
	} 		
} */
function include_hierarchy(){
    var child=document.getElementById('learner_child');
    var orgid=document.getElementById('learner_org').value;
    if(orgid==''){
        alertify.alert("Please Select Organization");
        document.getElementById('learner_child').checked=false;
        return false;
    }
    if(child.checked===true){        
        // To fetch learner Hierarchy details from .php page
        if(learner_hier!=''){
            var lnr_dat=learner_hier.split(',');
            var learner_heirarchy='';
            for(var i=0;i<lnr_dat.length;i++){
                learn1=lnr_dat[i];
                learn2=learn1.split('*');
                if(learner_heirarchy==''){
                    learner_heirarchy="<option value='"+learn2[0]+"'>"+learn2[1]+"</option>";
                }else{
                    learner_heirarchy=learner_heirarchy+"<option value='"+learn2[0]+"'>"+learn2[1]+"</option>";
                }
            }
        }
        else{
            learner_heirarchy='';
        }
        document.getElementById('learn_hier_name').innerHTML="Hierarchy Name&nbsp;&nbsp;&nbsp;&nbsp;";
        document.getElementById('learn_hier_select').innerHTML="<select name='learner_hier' id='learner_hier' class='col-xs-12 col-sm-12' onchange='include_childs()'><option value=''>Select</option>"+learner_heirarchy+"</select><br />";
    }
    else{
        document.getElementById('learn_hier_name').innerHTML="";
        document.getElementById('learn_hier_select').innerHTML="";
        document.getElementById('child_ids').value="";
    }
 }
 function include_childs(){
     var org_id=document.getElementById('learner_org').value;
     var hier_id=document.getElementById('learner_hier').value;
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
             document.getElementById('child_ids').value=xmlhttp.responseText;
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/include_child_org?org_id="+org_id+"&hier_id="+hier_id,true);
     xmlhttp.send();
}

function open_resource_details(){
    var data=document.getElementById("resource_create").value;
    var prgid=document.getElementById("program_id").value;
    var eveid=document.getElementById("event_id").value;
	var eve_end_date=document.getElementById("eve_hid_end_date").value;
	//alertify.alert(eve_end_date);
    if(data!=''){
        document.getElementById('resource_data').style.display='block';
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
                document.getElementById('resource_data').innerHTML=xmlhttp.responseText;
				
				$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });				
				$('.chosen-select').chosen({allow_single_deselect:true}); 
				$('#booking_person_id').ajaxChosen({
					   dataType: 'json',
					   type: 'POST',
					   url:BASE_URL+'/admin/autoemployee'
				},{
					   loadingImg: 'loading.gif'
				});
				//resize the chosen on window resize
				$(window).on('resize.chosen', function() {
					var w = $('.chosen-select').parent().width();
					if(w<=25){w=250;}
					$('.chosen-select').next().css({'width':w});
				}).trigger('resize.chosen');	
				//$("#resourcebooking_data").validationEngine();
				$("#resourcebooking_data").validationEngine({
					ajaxFormValidation: false,
					ajaxFormValidationMethod: 'post',
					onAjaxFormComplete: check_res_time
				});
				$('#resource_data2').show();
            }
		}
		xmlhttp.open("GET",BASE_URL+"/admin/get_resource_names?res_id="+data+"&prgid="+prgid+"&evntid="+eveid+"&eve_enddt="+eve_end_date,true);
		xmlhttp.send();
	}
	else{
		document.getElementById('resource_data').style.display='none';
	}
}

function resource_details(){
    /* document.getElementById('supply').style.display='block';
    document.getElementById('supply_input').style.display='block';
    document.getElementById('locat').style.display='block';
    document.getElementById('locat_input').style.display='block'; */
	var evestdat=document.getElementById('startdate').value;
	var eveendat=document.getElementById('enddate').value;
	var eveststarttime=document.getElementById('res_required_start_time').value;
	var eveenendtime=document.getElementById('res_required_end_time').value;
    var def_id=document.getElementById('resource_id').value;
	var evntid=document.getElementById('event_id').value;
	var structure_id=document.getElementById('structure_id').value;
	var res_buk_id=document.getElementById('resource_booking_id').value;
	if(def_id!=''){
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
				var resp=xmlhttp.responseText.split('#*');
				if(resp[0]==1){
					alertify.alert("Resource has already booked for some event in this duration");
					$(".chosen-select").val('').trigger("chosen:updated");
					$('#tra_details').css('display','none');
					return false;
				}
				
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/resource_additionalinfo?res_def_id="+def_id+"&evntid="+evntid+"&resbuk_id="+res_buk_id+"&evstdt="+evestdat+"&evendt="+eveendat+"&structure_id="+structure_id+"&eveststarttime="+eveststarttime+"&eveenendtime="+eveenendtime,true);
		xmlhttp.send();
    }else{
		//document.getElementById('tra_details').innerHTML='';
	}
}

function update_booking(res_id,bookid){
	var eve_end_date=document.getElementById("eve_hid_end_date").value;
    //var structid=document.getElementById('resource_book_id['+id+']').value;
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
            document.getElementById('resource_data').style.display='block';
            document.getElementById('resource_data').innerHTML=xmlhttp.responseText;
			$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
            $('.chosen-select').chosen({allow_single_deselect:true});
				$('#booking_person_id').ajaxChosen({
					   dataType: 'json',
					   type: 'POST',
					   url:BASE_URL+'/admin/autoemployee'
				},{
					   loadingImg: 'loading.gif'
				});
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
				var w = $('.chosen-select').parent().width();
				if(w<=25){w=250;}
				$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');
			
			$("#resourcebooking_data").validationEngine({
				ajaxFormValidation: false,
				ajaxFormValidationMethod: 'post',
				onAjaxFormComplete: check_res_time
			});
			$('#resource_data2').show();
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/resource_update?res_id="+res_id+"&res_book_id="+bookid+"&prgid="+pro_id+"&evntid="+eve_id+"&eveendt="+eve_end_date,true);
    xmlhttp.send();
}
function cannot_evaluate(){
    alertify.alert("Evaluation can not be done after Enrollment");
}
function cannot_change(){
    alertify.alert("Cannot change to Public once the Enrollment is done");
	document.getElementById('restricted').checked=true;
}
function get_testnames(){
    var test_type=document.getElementById('evaluation_type').value;
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
            document.getElementById('test_id').innerHTML=xmlhttp.responseText;            
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/evaluation_test_details?test_type="+test_type,true);
    xmlhttp.send();
}
function create_evaluation(){//alertify.alert(testmand);
    // To fetch Test Type from .php page
    if(testtype!=''){
        var tst_typ=testtype.split(',');
        var test_type='';
        for(var i=0;i<tst_typ.length;i++){
            tst_typ1=tst_typ[i];
            tst_typ2=tst_typ1.split('*');
            if(test_type==''){
                test_type="<option value='"+tst_typ2[0]+"'>"+tst_typ2[1]+"</option>";
            }else{
                test_type=test_type+"<option value='"+tst_typ2[0]+"'>"+tst_typ2[1]+"</option>";
            }
        }
    }else{
        test_type='';
    }
    // To fetch Test Details from .php page
    if(testdetails!=''){
        var tst_det=testdetails.split(',');
        var test_details='';
        for(var i=0;i<tst_det.length;i++){
            tst_det1=tst_det[i];
            tst_det2=tst_det1.split('*');
            if(test_details==''){
                test_details="<option value='"+tst_det2[0]+"'>"+tst_det2[1]+"</option>";
            }else{
                test_details=test_details+"<option value='"+tst_det2[0]+"'>"+tst_det2[1]+"</option>";
            }
        }
    }
    else{
        test_details='';
    }
    // To fetch Test Mandatory from .php page
    if(testmand!=''){
        var tst_mand=testmand.split(',');
        var test_mandatory='';
        for(var i=0;i<tst_mand.length;i++){
            tst_mand1=tst_mand[i];
            tst_mand2=tst_mand1.split('*');
            if(test_mandatory==''){
                test_mandatory="<option value='"+tst_mand2[0]+"'>"+tst_mand2[1]+"</option>";
            }else{
                test_mandatory=test_mandatory+"<option value='"+tst_mand2[0]+"'>"+tst_mand2[1]+"</option>";
            }
        }
    }
    else{
        test_mandatory='';
    }
	 // To fetch Test Mandatory from .php page
    if(testmand!=''){
        var tst_mand=testmand.split(',');
        var test_mandatory_skip='';
        for(var i=0;i<tst_mand.length;i++){
            tst_mand1=tst_mand[i];
            tst_mand2=tst_mand1.split('*');
			var skip=(tst_mand2[0]=='Y')?'selected="selected"':'';
            if(test_mandatory_skip==''){
				
                test_mandatory_skip="<option value='"+tst_mand2[0]+"' "+skip+">"+tst_mand2[1]+"</option>";
            }else{
                test_mandatory_skip=test_mandatory_skip+"<option value='"+tst_mand2[0]+"' "+skip+">"+tst_mand2[1]+"</option>";
            }
        }
    }
    else{
        test_mandatory_skip='';
    }
	// To fetch evaluation status from .php page
    if(eval_status!=''){
        var evalst=eval_status.split(',');
        var status_eval='';
        for(var i=0;i<evalst.length;i++){
            eval1=evalst[i];
            eval2=eval1.split('*');
            if(status_eval==''){
                status_eval="<option value='"+eval2[0]+"'>"+eval2[1]+"</option>";
            }else{
                status_eval=status_eval+"<option value='"+eval2[0]+"'>"+eval2[1]+"</option>";
            }
        }
    }
    else{
        status_eval='';
    }
	var startdate=document.getElementById('startdate').value;
	var enddate=document.getElementById('enddate').value;
	//alert(startdate+" "+enddate);
    var param='"evaluate_data"';
    document.getElementById('evaluate_data').innerHTML="<h4 class='header blue bolder smaller'>Evaluation Details</h4>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Test Type<sup><font color='#FF0000'>*</font></sup><br>\n\
			<select name='evaluation_type' id='evaluation_type' class='validate[required] col-xs-12 col-sm-12' onchange='get_testnames()'><option value=''>Select</option>"+test_type+"</select>\n\
			<input type='hidden' name='enroll_end_date' id='enroll_end_date' value=''>\n\
			<input type='hidden' name='enroll_start_date' id='enroll_start_date' value=''>\n\
			<input type='hidden' name='event_end_date' id='event_end_date' value='"+enddate+"'>\n\
			<input type='hidden' name='event_start_date' id='event_start_date' value='"+startdate+"'>\n\
			<input type='hidden' name='delivery_method' id='delivery_method' value=''>\n\
			<input type='hidden' name='program_date' id='program_date' value=''>\n\
			<input type='hidden' name='eval_eventid' id='eval_eventid' value="+eve_id+">\n\
			<input type='hidden' name='prg_id' id='prg_id' value="+pro_id+">\n\
			<input type='hidden' name='evaluation_id' id='evaluation_id' value=''>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Test Name<sup><font color='#FF0000'>*</font></sup><br>\n\
			<select name='test_id' class='validate[required, ajax[ajaxEventEvaluation]] col-xs-12 col-sm-12' id='test_id'><option value=''>Select</option></select>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Start Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group'>\n\
					<input type='text' name='start_date_active' id='evalu_start_date' class='validate[custom[date2],future[#evalu_start_date]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' value='"+startdate+"' onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			End Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group'>\n\
					<input type='text'  name='end_date_active' id='evalu_end_date' class='validate[custom[date2],future[#evalu_start_date]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy'  value='"+enddate+"' onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Mandatory<sup><font color='#FF0000'>*</font></sup><br>\n\
			<select name='eval_mandatory_flag' id='eval_mandatory_flag' class='validate[required] col-xs-12 col-sm-12'><option value=''>Select</option>"+test_mandatory+"</select>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Test Status<sup><font color='#FF0000'>*</font></sup><br>\n\
			<select name='eval_status' id='eval_status' class='validate[required] col-xs-12 col-sm-12'><option value=''>Select</option>"+status_eval+"</select>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Multiple Attempts<br>\n\
			<select name='multiple_attempts' id='multiple_attempts' class='col-xs-12 col-sm-12'><option value=''>Select</option>"+test_mandatory+"</select>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Test Hold On Days<br>\n\
			<input type='text'  name='test_days' id='test_days' class='validate[custom[onlyNumberSp]] col-xs-12 col-sm-12' value='' maxlength=2>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Skip Questions<br>\n\
			<select name='eval_skip_flag' id='eval_skip_flag' class='validate[required] col-xs-12 col-sm-12'><option value=''>Select</option>"+test_mandatory_skip+"</select>\n\
		</div>\n\
	</div><br>\n\
	<div class='form-actions center' >\n\
	<input type='submit' name='eval_save'  id='eval_save' value='Save' class='btn btn-sm btn-success' onclick='return evaluate_validate()' >&nbsp;&nbsp;&nbsp;\n\
	<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div> ";
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });

}
function evaluation_edit(id,proid){
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
            document.getElementById('evaluate_data').innerHTML=xmlhttp.responseText;
			$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
    }
}
xmlhttp.open("GET",BASE_URL+"/admin/evaluation_update?eval_id="+id+"&proid="+proid,true);
xmlhttp.send();
}
function evaluate_validate(){
    var delivery_method=document.getElementById('del_met').value;
    var test_type=document.getElementById('evaluation_type').value;
    var enrol_stdate=document.getElementById('enor_strt_date').value;
    var evnt_stdate=document.getElementById('startdate').value;
    var evnt_endate=document.getElementById('enddate').value;
    var eval_stdate=document.getElementById('evalu_start_date').value;
    var eval_enddate=document.getElementById('evalu_end_date').value;
    var prgm_stdate=document.getElementById('event_start_date').value;
    var prgm_enddate=document.getElementById('event_end_date').value;
	if(eval_stdate=='' && eval_enddate!=''){
		alertify.alert("End date can not be given with out giving the start date");
		return false;
	}
	eval_stdates=eval_stdate.split("-");
	eval_enddates=eval_enddate.split("-");
	enrol_stdates=enrol_stdate.split("-");
	evnt_stdates=evnt_stdate.split("-");
	evnt_endates=evnt_endate.split("-");
	stdate_eval= new Date(eval_stdates[2],(eval_stdates[1]-1),eval_stdates[0]);
	enddate_eval= new Date(eval_enddates[2],(eval_enddates[1]-1),eval_enddates[0]);
	stdate_enrol = new Date(enrol_stdates[2],(enrol_stdates[1]-1),enrol_stdates[0]);
	stdate_evnt= new Date(evnt_stdates[2],(evnt_stdates[1]-1),evnt_stdates[0]);
	enddate_evnt= new Date(evnt_endates[2],(evnt_endates[1]-1),evnt_endates[0]);
    if(delivery_method=='C'){
        if(test_type=='PRE'){
			if(stdate_eval=='' || eval_enddate==''){
				alertify.alert("Please give start date and end date for PRE Test");
				return false;
			}
            if(stdate_eval<stdate_enrol || stdate_eval>stdate_evnt){
                alertify.alert("Evaluation Start date should be between Enrolment Start Date and Event Start Date");
                return false;
            }
        }
    }
    else if(delivery_method=='O'){
        if(test_type=='PRE' || test_type=='POST'){
            if(stdate_eval<stdate_enrol || stdate_eval>enddate_evnt){
                alertify.alert("Evaluation Start date should be between Enrolment Start Date and Event End Date");
                return false;
            }
            if(enddate_eval>enddate_evnt){
                alertify.alert("Evaluation End date should be Less than or Equal to Event End Date");
                return false;
            }
        }
    }
    
}
function forum_create(){
	 // To fetch Resource Structures from .php page
    if(res_struct!=''){
        var resour_struct=res_struct.split(',');
        var resource_structure='';
        var struct_id='';
        for(var i=0;i<resour_struct.length;i++){
            resour_struct1=resour_struct[i];
            resour_struct2=resour_struct1.split('*');
            //resour_struct3=resour_struct2[0].split('#');
            if(resource_structure==''){
                resource_structure="<option value='"+resour_struct2[0]+"'>"+resour_struct2[1]+"</option>";
            }else{
                resource_structure=resource_structure+"<option value='"+resour_struct2[0]+"'>"+resour_struct2[1]+"</option>";
            }//alertify.alert(resour_struct3[0]);
           // struct_id="<input type='text' id='struct_id' name='struct_id' value='"+resour_struct3[0]+"'>";
        }
    }else{
        resource_structure='';
    }
    // To fetch Booking Status from .php page
    if(book_status!=''){
        var book_struct=book_status.split(',');
        var booking_status='';
        for(var i=0;i<book_struct.length;i++){
            book_struct1=book_struct[i];
            book_struct2=book_struct1.split('*');
            if(booking_status==''){
                booking_status="<option value='"+book_struct2[0]+"'>"+book_struct2[1]+"</option>";
            }else{
                booking_status=booking_status+"<option value='"+book_struct2[0]+"'>"+book_struct2[1]+"</option>";
            }
        }
    }else{
        booking_status='';
    }
    // To fetch Booked By from .php page
    if(booked_by!=''){
        var book_by=booked_by.split(',');
        var bookedby='';
        for(var i=0;i<book_by.length;i++){
            book_by1=book_by[i];
            book_by2=book_by1.split('*');
            if(bookedby==''){
                bookedby="<option value='"+book_by2[0]+"'>"+book_by2[1]+"</option>";
            }else{
                bookedby=bookedby+"<option value='"+book_by2[0]+"'>"+book_by2[1]+"</option>";
            }
        }
    }else{
        bookedby='';
    }
    // To fetch Trainer Role from .php page
    if(role_play!=''){
        var role=role_play.split(',');
        var trainer_role='';
        for(var i=0;i<role.length;i++){
            role1=role[i];
            role2=role1.split('*');
            if(trainer_role==''){
                trainer_role="<option value='"+role2[0]+"'>"+role2[1]+"</option>";
            }else{
                trainer_role=trainer_role+"<option value='"+role2[0]+"'>"+role2[1]+"</option>";
            }
        }
    }else{
        trainer_role='';
    }
    // To fetch Visible to Learner from .php page
    if(testmand!=''){
        var visib=testmand.split(',');
        var visible_learner='';
        for(var i=0;i<visib.length;i++){
            visib1=visib[i];
            visib2=visib1.split('*');
            if(visible_learner==''){
                visible_learner="<option value='"+visib2[0]+"'>"+visib2[1]+"</option>";
            }else{
                visible_learner=visible_learner+"<option value='"+visib2[0]+"'>"+visib2[1]+"</option>";
            }
        }
    }
    else{
        visible_learner='';
    }
    var param='"forums_hidediv"';
    document.getElementById('chatdiv').innerHTML="<div id='forumdatadiv' style='height: 500px; overflow:auto;'><h4 class='header blue bolder smaller' align='left'>Forum Details</h4>\n\
	<div class='row' style='width: 100%;'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Forum Name<sup><font color='#FF0000'>*</font></sup><br>\n\
			<input type='text' name='forum_name' id='forum_name' value='' class='validate[required, ajax[ajaxeveforumname], minSize[2], maxSize[150], custom[alphanumericSp]] col-xs-12 col-sm-12'>\n\
			<input type='hidden' name='frm_prg_id' id='frm_prg_id' value="+pro_id+">\n\
			<input type='hidden' name='gen_event_id' id='gen_event_id' value="+eve_id+">\n\
			<input type='hidden' name='forum_id' id='forum_id' value=''>\n\
			<input type='hidden' name='forum_inclusion_id' id='forum_inclusion_id' value=''>\n\
			<input type='hidden' name='forum_thread_id' id='forum_thread_id' value=''>\n\
			<input type='hidden' name='forum_message_id' id='forum_message_id' value=''>\n\
			<input type='hidden' name='forum_notification_id' id='forum_notification_id' value=''>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Start Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group' style='margin-left: -13px;'>\n\
					<input type='text' name='start_date_active' id='forum_start_date' class='validate[custom[date2], future[#startdate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' value='' onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			End Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group' style='margin-left: -13px;'>\n\
					<input type='text' name='end_date_active' id='forum_end_date' value='' class='validate[custom[date2], future[#forum_start_date]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
	</div><br>\n\
	<div class='row' style='width: 100%;'>\n\
		<div class='col-xs-12 col-sm-6'>\n\
			Subject<br>\n\
			<textarea style='resize: none;' class='col-xs-12 col-sm-12' name='subject' id='subject' ></textarea>\n\
		</div>\n\
	</div><br>\n\
	<div class='row' style='width: 100%;'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			<input type='checkbox' name='allow_attachment_flag' id='allow_attachment_flag' value='Y'>&nbsp;&nbsp;Allow Attachments\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			<input type='checkbox' name='auto_notification_flag' id='auto_notification_flag' value='Y'>&nbsp;&nbsp;Send Notifications\n\
		</div>\n\
	</div><br>\n\
	<h4 class='header blue bolder smaller' align='left'>Moderator Details</h4>\n\
	<div class='space-2'></div>\n\
	<div class='form-group'>\n\
		<label class='control-label col-xs-12 col-sm-2 no-padding-right' for='resource_id'>Resource Name</label>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			<div class='clearfix' style='width:268px;'>\n\
				<select name='resource_id' id='resource_id' class='chosen-select' onchange='forum_resource_data()'><option value=''>Select</option>"+resource_structure+"</select>\n\
			</div>\n\
		</div>\n\
	</div>\n\
	<div class='space-2'></div>\n\
	<!--<div class='row' style='width: 100%;'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Resource Name<!--<sup><font color='#FF0000'>*</font></sup>validate[required]<br>\n\
			<select name='resource_id' id='resource_id' class='chosen-select'><option value=''>Select</option>"+resource_structure+"</select>\n\
		</div>\n\
	</div>--><br><br>\n\
	<div id='forum_resdata' style='display:none;'>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Start Date<br>\n\
				<div class='input-large'>\n\
					<div class='input-group' style='margin-left: -13px;'>\n\
						<input type='text' name='required_date_from' id='forum_required_date_from' value='' class='validate[custom[date2], future[#startdate], past[#enddate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
						<input type='hidden' name='resource_booking_id' id='resource_booking_id' value=''>\n\
						<input type='hidden' name='program_id' id='program_id' value=''>\n\
						<input type='hidden' name='event_id' id='event_id' value=''>\n\
						<span class='input-group-addon'>\n\
							<i class='ace-icon fa fa-calendar'></i>\n\
						</span>\n\
					</div>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				End Date<br>\n\
				<div class='input-large'>\n\
					<div class='input-group' style='margin-left: -13px;'>\n\
						<input type='text' name='required_date_to' id='forum_required_date_to' value='' class='validate[custom[date2], future[#required_date_from], past[#enddate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
						<span class='input-group-addon'>\n\
							<i class='ace-icon fa fa-calendar'></i>\n\
						</span>\n\
					</div>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Start Time<br>\n\
				<div class='input-group bootstrap-timepicker'>\n\
					<input type='text' name='required_start_time' id='forum_required_start_time' value='' class='form-control' onfocus='time_funct(this.id)' >\n\
					<span class='input-group-addon'>\n\
						<i class='fa fa-clock-o bigger-110'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				End Time<br>\n\
				<div class='input-group bootstrap-timepicker'>\n\
					<input type='text' name='required_end_time' id='forum_required_end_time' value='' class='form-control' onfocus='time_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='fa fa-clock-o bigger-110'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Trainer Role<br>\n\
				<select name='role_to_play' id='role_to_play' class='col-xs-12 col-sm-12'><option value=''>Select</option>"+trainer_role+"</select>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Visibility to Learner<br>\n\
				<select name='display_to_learner_flag' id='display_to_learner_flag' class='col-xs-12 col-sm-12'><option value=''>Select</option>"+visible_learner+"</select>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Booking Status<br>\n\
				<select name='status' id='status' class='col-xs-12 col-sm-12'><option value=''>Select</option>"+booking_status+"</select>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Booked By<br>\n\
				<select class='chosen-select' name='booking_person_id' id='booking_person_id'><option value=''>Select</option>"+bookedby+"</select>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Date Booked<br>\n\
				<div class='input-large'>\n\
					<div class='input-group' style='margin-left: -13px;'>\n\
						<input type='text' name='date_booking_placed' id='date_booking_placed' value='' class='validate[custom[date2],future[#startdate],past[#enddate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
						<span class='input-group-addon'>\n\
							<i class='ace-icon fa fa-calendar'></i>\n\
						</span>\n\
					</div>\n\
				</div>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Quantity<br>\n\
				<input type='text' name='quantity' id='quantity' value='' class='validate[custom[onlyNumberSp] col-xs-12 col-sm-12]' maxlength='3'>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Actual Price<br>\n\
				<input type='text' name='absolute_price' id='absolute_price' value='' class='validate[custom[amount]] col-xs-12 col-sm-12' maxlength='11' >\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Contact Person<br>\n\
				<input type='text' name='contact_name' id='contact_name' value='' class='validate[maxSize[80], custom[onlyLetterSomeSp]] col-xs-12 col-sm-12'>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Contact Phone<br>\n\
				<input type='text' name='contact_phone_no' id='contact_phone_no' value='' class='validate[custom[phone]] col-xs-12 col-sm-12' maxlength='10'>\n\
			</div>\n\
		</div><br>\n\
	</div>\n\
	<div class='form-actions center' >\n\
	<input type='submit' name='forum_save'  id='forum_save' value='Save' class='btn btn-sm btn-success' onclick='return forumtime_validate()' >&nbsp;&nbsp;&nbsp;<!-- onClick='cancel_funct("+param+")'-->\n\
	<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' data-dismiss='modal'/></div></div><br> ";
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
	document.getElementById('forum_name').focus();
	$('.chosen-select').chosen({allow_single_deselect:true}); 
	//resize the chosen on window resize
	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=25){w=250;}
		$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');

}
function edit_forums(incid,prgid,eveid){
	var eve_end_date=document.getElementById("eve_hid_end_date").value;
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
            document.getElementById('chatdiv').innerHTML=xmlhttp.responseText;
			$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
			//document.getElementById('forum_name').focus();
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
				var w = $('.chosen-select').parent().width();
				if(w<=25){w=250;}
				$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');

    }
}
xmlhttp.open("GET",BASE_URL+"/admin/forums_update?envtid="+eveid+"&inclid="+incid+"&prgid="+prgid+"&evendt="+eve_end_date,true);
xmlhttp.send();
}
function update_learner(lernid){
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
            $response=xmlhttp.responseText.split('*_*');
			//document.getElementById('details_div').innerHTML=xmlhttp.responseText;
            //alertify.alert($response[0]);
            if($response[0].trim()=='W'){
                document.getElementById('Learner_Group_div').style.display='none';
                document.getElementById('work_details_div').style.display='block';
				document.getElementById('Location_div').style.display='none';
                document.getElementById('work_details_div').innerHTML=$response[1];
            }
            if($response[0].trim()=='L'){
                document.getElementById('work_details_div').style.display='none';
                document.getElementById('Learner_Group_div').style.display='block';
				document.getElementById('Location_div').style.display='none';
                document.getElementById('Learner_Group_div').innerHTML=$response[1];				
            }
			if($response[0].trim()=='LOC'){
                document.getElementById('work_details_div').style.display='none';
                document.getElementById('Learner_Group_div').style.display='none';
				document.getElementById('Location_div').style.display='block';
                document.getElementById('Location_div').innerHTML=$response[1];				
            }
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
				var w = $('.chosen-select').parent().width();
				if(w<=25){w=250;}
				$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/learner_event_update?learner_id="+lernid,true);
    xmlhttp.send();
}
function reference_create(){
    var param='"reference_data"';
    document.getElementById('reference_data').innerHTML="<h4 class='header blue bolder smaller'>Reference Details</h4>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Reference Name<sup><font color='#FF0000'>*</font></sup><br>\n\
			<input type='text' name='reference_name' id='reference_name' value='' class='validate[required, minSize[2], maxSize[150], custom[alphanumericSp], ajax[ajaxReferenceName]] col-xs-12 col-sm-12' maxlength='80'>\n\
			<input type='hidden' name='ref_prg_id' id='ref_prg_id' value="+pro_id+">\n\
			<input type='hidden' name='event_id' id='event_id' value="+eve_id+">\n\
			<input type='hidden' name='reference_id' id='reference_id' value=''>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Reference URL<sup><font color='#FF0000'>*</font></sup><br>\n\
			<input type='text' placeholder='http://www.abc.com' name='reference_url' id='reference_url' value='' class='validate[required,custom[url]] col-xs-12 col-sm-12'>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Start Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group'>\n\
					<input type='text' class='validate[custom[date2], future[#startdate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' name='start_date_active' id='start_date_active' value='' onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			End Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group'>\n\
					<input type='text' class='validate[custom[date2], future[#start_date_active]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' name='end_date_active' id='end_date_active' value='' onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
				Subject<br>\n\
				<textarea style='resize: none;' name='remarks' id='remarks' class='col-xs-12 col-sm-12' maxlength:'2000'></textarea>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'><br>\n\
				<input type='checkbox' name='display_to_learner' id='display_to_learner' value='Yes'>&nbsp;&nbsp;Display to Learner\n\
		</div>\n\
	</div><br>\n\
<div class='form-actions center' >\n\
<input type='submit' name='ref_save'  id='ref_save' value='Save' class='btn btn-sm btn-success' onclick='return reference_valid()'>&nbsp;&nbsp;&nbsp;\n\
<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div> ";
$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });

}
function reference_valid(){
	var stdate=document.getElementById('start_date_active').value;
	var enddate=document.getElementById('end_date_active').value;
	if(stdate=='' && enddate!=''){
		alertify.alert("End date can not be given without giving the start date");
		return false;
	}
}
function update_reference(ref_id,prgid,eveid){
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
            document.getElementById('reference_data').innerHTML=xmlhttp.responseText;
			$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
    }
}
xmlhttp.open("GET",BASE_URL+"/admin/reference_update?ref_id="+ref_id+"&prgid="+prgid+"&evntid="+eveid,true);
xmlhttp.send();
}

function chat_create(){
    // To fetch Resource Structures from .php page
    if(res_struct!=''){
        var resour_struct=res_struct.split(',');
        var resource_structure='';
        var struct_id='';
        for(var i=0;i<resour_struct.length;i++){
            resour_struct1=resour_struct[i];
            resour_struct2=resour_struct1.split('*');
            //resour_struct3=resour_struct2[0].split('#');
            if(resource_structure==''){
                resource_structure="<option value='"+resour_struct2[0]+"'>"+resour_struct2[1]+"</option>";
            }else{
                resource_structure=resource_structure+"<option value='"+resour_struct2[0]+"'>"+resour_struct2[1]+"</option>";
            }//alertify.alert(resour_struct3[0]);
           // struct_id="<input type='text' id='struct_id' name='struct_id' value='"+resour_struct3[0]+"'>";
        }
    }else{
        resource_structure='';
    }
    // To fetch Booking Status from .php page
    if(book_status!=''){
        var book_struct=book_status.split(',');
        var booking_status='';
        for(var i=0;i<book_struct.length;i++){
            book_struct1=book_struct[i];
            book_struct2=book_struct1.split('*');
            if(booking_status==''){
                booking_status="<option value='"+book_struct2[0]+"'>"+book_struct2[1]+"</option>";
            }else{
                booking_status=booking_status+"<option value='"+book_struct2[0]+"'>"+book_struct2[1]+"</option>";
            }
        }
    }else{
        booking_status='';
    }
    // To fetch Booked By from .php page
    if(booked_by!=''){
        var book_by=booked_by.split(',');
        var bookedby='';
        for(var i=0;i<book_by.length;i++){
            book_by1=book_by[i];
            book_by2=book_by1.split('*');
            if(bookedby==''){
                bookedby="<option value='"+book_by2[0]+"'>"+book_by2[1]+"</option>";
            }else{
                bookedby=bookedby+"<option value='"+book_by2[0]+"'>"+book_by2[1]+"</option>";
            }
        }
    }else{
        bookedby='';
    }
    // To fetch Trainer Role from .php page
    if(role_play!=''){
        var role=role_play.split(',');
        var trainer_role='';
        for(var i=0;i<role.length;i++){
            role1=role[i];
            role2=role1.split('*');
            if(trainer_role==''){
                trainer_role="<option value='"+role2[0]+"'>"+role2[1]+"</option>";
            }else{
                trainer_role=trainer_role+"<option value='"+role2[0]+"'>"+role2[1]+"</option>";
            }
        }
    }else{
        trainer_role='';
    }
    // To fetch Visible to Learner from .php page
    if(testmand!=''){
        var visib=testmand.split(',');
        var visible_learner='';
        for(var i=0;i<visib.length;i++){
            visib1=visib[i];
            visib2=visib1.split('*');
            if(visible_learner==''){
                visible_learner="<option value='"+visib2[0]+"'>"+visib2[1]+"</option>";
            }else{
                visible_learner=visible_learner+"<option value='"+visib2[0]+"'>"+visib2[1]+"</option>";
            }
        }
    }
    else{
        visible_learner='';
    }
    var param='"chat_data"';
	//past[#enddate]
    document.getElementById('chatdiv').innerHTML="<div id='chatdatadiv' style='height: 525px; overflow:auto;'><h4 class='header blue bolder smaller' align='left'>Chat Details</h4>\n\
	<div class='row' style='width: 100%;'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Chat Name<sup><font color='#FF0000'>*</font></sup><br>\n\
			<input type='hidden' name='chat_eventid' id='chat_eventid' value="+eve_id+">\n\
			<input type='hidden' name='chat_prg_id' id='chat_prg_id' value="+pro_id+">\n\
			<input type='hidden' name='chat_id' id='chat_id' value=''>\n\
			<input type='hidden' name='chat_inclusion_id' id='chat_inclusion_id' value=''>\n\
			<input type='text' name='chat_name' id='chat_name' value='' class='validate[required, ajax[ajaxevechatname], minSize[2], maxSize[150], custom[alphanumericSp]] col-xs-12 col-sm-12'>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Start Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group' style='margin-left: -13px;'>\n\
					<input type='text' name='start_date_active' id='start_date_active' value='' class='validate[custom[date2], future[#startdate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy'  onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			End Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group' style='margin-left: -13px;'>\n\
					<input type='text' name='end_date_active' id='end_date_active' value='' class='validate[custom[date2],future[#start_date_active]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
	</div><br>\n\
	<div class='row' style='width: 100%;'>\n\
		<div class='col-xs-12 col-sm-6'>\n\
			Description<br>\n\
			<textarea name='description' id='description' class='col-xs-12 col-sm-12' style='resize:none;'></textarea>\n\
		</div>\n\
	</div><br>\n\
	<h4 class='header blue bolder smaller' align='left'>Moderator Details</h4>\n\
	<div class='space-2'></div>\n\
	<div class='form-group'>\n\
		<label class='control-label col-xs-12 col-sm-2 no-padding-right' for='resource_id'>Resource Name</label>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			<div class='clearfix' style='width:268px;'>\n\
				<select name='resource_id' id='resource_id' class='chosen-select' onchange='chat_resource_data()'><option value=''>Select</option>"+resource_structure+"</select>\n\
			</div>\n\
		</div>\n\
	</div>\n\
	<div class='space-2'></div>\n\
	<!--<div class='row' style='width: 100%;'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Resource Name<!--<sup><font color='#FF0000'>*</font></sup>validate[required]<br>\n\
			<select name='resource_id' id='resource_id' class='chosen-select' onchange='resource_data()'><option value=''>Select</option>"+resource_structure+"</select>\n\
		</div>\n\
	</div>--><br><br>\n\
	<div id='resdata' style='display:none;'>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Start Date<br>\n\
				<div class='input-large'>\n\
					<div class='input-group' style='margin-left: -13px;'>\n\
						<input type='text' name='required_date_from' id='required_date_from' value='' class='validate[custom[date2], future[#startdate], past[#enddate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
						<input type='hidden' name='resource_booking_id' id='resource_booking_id' value=''>\n\
						<input type='hidden' name='program_id' id='program_id' value=''>\n\
						<input type='hidden' name='event_id' id='event_id' value=''>\n\
						<span class='input-group-addon'>\n\
							<i class='ace-icon fa fa-calendar'></i>\n\
						</span>\n\
					</div>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				End Date<br>\n\
				<div class='input-large'>\n\
					<div class='input-group' style='margin-left: -13px;'>\n\
						<input type='text' name='required_date_to' id='required_date_to' value='' class='validate[custom[date2], future[#required_date_from], past[#enddate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
						<span class='input-group-addon'>\n\
							<i class='ace-icon fa fa-calendar'></i>\n\
						</span>\n\
					</div>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Start Time<br>\n\
				<div class='input-group bootstrap-timepicker'>\n\
					<input type='text' name='required_start_time' id='required_start_time' value='' class='form-control' onfocus='time_funct(this.id)' >\n\
					<span class='input-group-addon'>\n\
						<i class='fa fa-clock-o bigger-110'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				End Time<br>\n\
				<div class='input-group bootstrap-timepicker'>\n\
					<input type='text' name='required_end_time' id='required_end_time' value='' class='form-control' onfocus='time_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='fa fa-clock-o bigger-110'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Trainer Role<br>\n\
				<select name='role_to_play' id='role_to_play' class='col-xs-12 col-sm-12'><option value=''>Select</option>"+trainer_role+"</select>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Visibility to Learner<br>\n\
				<select name='display_to_learner_flag' id='display_to_learner_flag' class='col-xs-12 col-sm-12'><option value=''>Select</option>"+visible_learner+"</select>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Booking Status<br>\n\
				<select name='status' id='status' class='col-xs-12 col-sm-12'><option value=''>Select</option>"+booking_status+"</select>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Booked By<br>\n\
				<select class='chosen-select' name='booking_person_id' id='booking_person_id'><option value=''>Select</option>"+bookedby+"</select>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Date Booked<br>\n\
				<div class='input-large'>\n\
					<div class='input-group' style='margin-left: -13px;'>\n\
						<input type='text' name='date_booking_placed' id='date_booking_placed' value='' class='validate[custom[date2],future[#startdate],past[#enddate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
						<span class='input-group-addon'>\n\
							<i class='ace-icon fa fa-calendar'></i>\n\
						</span>\n\
					</div>\n\
				</div>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Quantity<br>\n\
				<input type='text' name='quantity' id='quantity' value='' class='validate[custom[onlyNumberSp] col-xs-12 col-sm-12]' maxlength='3'>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Actual Price<br>\n\
				<input type='text' name='absolute_price' id='absolute_price' value='' class='validate[custom[amount]] col-xs-12 col-sm-12' maxlength='11' >\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Contact Person<br>\n\
				<input type='text' name='contact_name' id='contact_name' value='' class='validate[maxSize[80], custom[onlyLetterSomeSp]] col-xs-12 col-sm-12'>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Contact Phone<br>\n\
				<input type='text' name='contact_phone_no' id='contact_phone_no' value='' class='validate[custom[phone]] col-xs-12 col-sm-12' maxlength='10'>\n\
			</div>\n\
		</div><br>\n\
	</div>\n\
<div class='form-actions center'>\n\
<input type='submit' name='chat_save'  id='chat_save' value='Save' class='btn btn-sm btn-success' onclick='return chattime_validate()' >&nbsp;&nbsp;&nbsp;<!--onClick='cancel_funct("+param+")'-->\n\
<input type='button' class='btn btn-sm btn-danger' data-dismiss='modal' name='cancel' id='cancel' value='cancel' /></div><br>";	
	
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
	//$('input.timepicker').timepicker({ timeFormat: 'h:mm:ss p' });
	document.getElementById('chat_name').focus();
    $('.chosen-select').chosen({allow_single_deselect:true}); 
	//resize the chosen on window resize
	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=25){w=250;}
		$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');
	//$('.form-control').timepicker();
}
function chat_resource_data(){
	var res_val=document.getElementById('resource_id').value;
	if(res_val!=''){
		document.getElementById('resdata').style.display='block';
	}else{
		document.getElementById('resdata').style.display='none';
	}
}
function forum_resource_data(){
	var res_val=document.getElementById('resource_id').value;
	if(res_val!=''){
		document.getElementById('forum_resdata').style.display='block';
	}else{
		document.getElementById('forum_resdata').style.display='none';
	}
}
function topic_resource_data(){
	var res_val=document.getElementById('resource_id').value;
	if(res_val!=''){
		document.getElementById('topic_resdata').style.display='block';
	}else{
		document.getElementById('topic_resdata').style.display='none';
	}
}
function chattime_validate(){
    var stdate=document.getElementById('required_date_from').value.trim();
    var enddate=document.getElementById('required_date_to').value.trim();
    var sttime=document.getElementById('required_start_time').value.trim();
    var endtime=document.getElementById('required_end_time').value.trim();
	var stdate_active=document.getElementById('start_date_active').value.trim();
	var enddate_active=document.getElementById('end_date_active').value.trim();	
	if(stdate_active=='' && enddate_active!=''){
		alertify.alert("End date can not be given without giving the start date");
		return false;
	}
	if(enddate_active!='' && enddate_active<stdate_active){
		alertify.alert("End date should be greater than the start date");
		return false;
	}
	if(stdate=='' && enddate!=''){
		alertify.alert("End date can not be given for Moderator without giving the start date");
		return false;
	}
	if(enddate!='' && Number(enddate)<Number(stdate)){
		alertify.alert("End date for Moderator should be greater than the start date");
		return false;
	}
    if(stdate!='' && enddate!=''){
        if(stdate==enddate){
            if(endtime<=sttime){
                alertify.alert("End time can not be less than start time for the same day");
                return false;
            }
        }
    }else{
		if(stdate=='' && enddate==''){
			if(sttime!='' || endtime!=''){
				if(sttime!='0:00:00' || endtime!='0:00:00'){
					alertify.alert("Time can not be given without giving both the dates");
					return false;
				}
			}
		}
    }
}
function forumtime_validate(){
    var stdate=document.getElementById('forum_required_date_from').value.trim();
    var enddate=document.getElementById('forum_required_date_to').value.trim();
    var sttime=document.getElementById('forum_required_start_time').value.trim();
    var endtime=document.getElementById('forum_required_end_time').value.trim();
	var stdate_active=document.getElementById('forum_start_date').value.trim();
    var enddate_active=document.getElementById('forum_end_date').value.trim();
	
	if(stdate_active=='' && enddate_active!=''){
		alertify.alert("End date can not be given without giving the start date");
		return false;
	}
	if(enddate_active!='' && enddate_active<stdate_active){
		alertify.alert("End date should be greater than the start date");
		return false;
	}	
	if(stdate=='' && enddate!=''){
		alertify.alert("End date can not be given for Moderator without giving the start date");
		return false;
	}
	if(enddate!='' && enddate<stdate){
		alertify.alert("End date for Moderator should be greater than the start date");
		return false;
	}
    if(stdate!='' && enddate!=''){
        if(stdate==enddate){
            if(endtime<=sttime){
                alertify.alert("End time can not be less than start time for the same day");
                return false;
            }
        }
    }else{
        if(stdate=='' && enddate==''){
			if(sttime!='' || endtime!=''){
				if(sttime!='0:00:00' || endtime!='0:00:00'){
					alertify.alert("Time can not be given without giving both the dates");
					return false;
				}
			}
		}
    }
}
function experttime_validate(){
    var stdate=document.getElementById('expert_required_date_from').value.trim();
    var enddate=document.getElementById('expert_required_date_to').value.trim();
    var sttime=document.getElementById('expert_required_start_time').value.trim();
    var endtime=document.getElementById('expert_required_end_time').value.trim();
	var stdate_active=document.getElementById('topic_stdate').value.trim();
    var enddate_active=document.getElementById('topic_enddate').value.trim();
	if(stdate_active=='' && enddate_active!=''){
		alertify.alert("End date can not be given without giving the start date");
		return false;
	}
	if(enddate_active!='' && enddate_active<stdate_active){
		alertify.alert("End date should be greater than the start date");
		return false;
	}
	if(stdate=='' && enddate!=''){
		alertify.alert("End date can not be given for Moderator without giving the start date");
		return false;
	}
	if(enddate!='' && enddate<stdate){
		alertify.alert("End date for Moderator should be greater than the start date");
		return false;
	}
    if(stdate!='' && enddate!=''){
        if(stdate==enddate){
            if(endtime<=sttime){
                alertify.alert("End time can not be less than start time for the same day");
                return false;
            }
        }
    }else{
        if(stdate=='' && enddate==''){
			if(sttime!='' || endtime!=''){
				if(sttime!='0:00:00' || endtime!='0:00:00'){
					alertify.alert("Time can not be given without giving both the dates");
					return false;
				}
			}
		}
    }
}
function cancel_funct(div_id){
    document.getElementById(div_id).innerHTML='';
	side_menu();
}
function cancel_funct_select(div_id,sel_id){
	document.getElementById(sel_id).value='';
	document.getElementById(div_id).innerHTML='';
	side_menu();
	$('#resource_data2').hide();
}
function update_chat(chat_id,incluid,prgid,eveid){
	var eve_end_date=document.getElementById("eve_hid_end_date").value;
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
            document.getElementById('chatdiv').innerHTML=xmlhttp.responseText;
			$('.bootstrap-timepicker-widget').css({'z-index':'9999'});
			$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
			//document.getElementById('chat_name').focus();
            $('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
				var w = $('.chosen-select').parent().width();
				if(w<=25){w=250;}
				$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');
        }
}
xmlhttp.open("GET",BASE_URL+"/admin/chat_update?chat_idds="+chat_id+"&chat_inclu_id="+incluid+"&prgid="+prgid+"&evntid="+eveid+"&eveendt="+eve_end_date,true);
xmlhttp.send();
}

function Topic_create(){
    // To fetch Resource Structures from .php page
    if(res_struct!=''){
        var resour_struct=res_struct.split(',');
        var resource_structure='';
        for(var i=0;i<resour_struct.length;i++){
            resour_struct1=resour_struct[i];
            resour_struct2=resour_struct1.split('*');
            if(resource_structure==''){
                resource_structure="<option value='"+resour_struct2[0]+"'>"+resour_struct2[1]+"</option>";
            }else{
                resource_structure=resource_structure+"<option value='"+resour_struct2[0]+"'>"+resour_struct2[1]+"</option>";
            }
        }
    }else{
        resource_structure
    }
    // To fetch Booking Status from .php page
    if(book_status!=''){
        var book_struct=book_status.split(',');
        var booking_status='';
        for(var i=0;i<book_struct.length;i++){
            book_struct1=book_struct[i];
            book_struct2=book_struct1.split('*');
            if(booking_status==''){
                booking_status="<option value='"+book_struct2[0]+"'>"+book_struct2[1]+"</option>";
            }else{
                booking_status=booking_status+"<option value='"+book_struct2[0]+"'>"+book_struct2[1]+"</option>";
            }
        }
    }
    else{
        booking_status='';
    }
    // To fetch Booked By from .php page
    if(booked_by!=''){
        var book_by=booked_by.split(',');
        var bookedby='';
        for(var i=0;i<book_by.length;i++){
            book_by1=book_by[i];
            book_by2=book_by1.split('*');
            if(bookedby==''){
                bookedby="<option value='"+book_by2[0]+"'>"+book_by2[1]+"</option>";
            }else{
                bookedby=bookedby+"<option value='"+book_by2[0]+"'>"+book_by2[1]+"</option>";
            }
        }
    }else{
        bookedby='';
    }
    // To fetch Trainer Role from .php page
    if(role_play!=''){
        var role=role_play.split(',');
        var trainer_role='';
        for(var i=0;i<role.length;i++){
            role1=role[i];
            role2=role1.split('*');
            if(trainer_role==''){
                trainer_role="<option value='"+role2[0]+"'>"+role2[1]+"</option>";
            }else{
                trainer_role=trainer_role+"<option value='"+role2[0]+"'>"+role2[1]+"</option>";
            }
        }
    }
    else{
        trainer_role='';
    }
    // To fetch Visible to Learner from .php page
    if(testmand!=''){
        var visib=testmand.split(',');
        var visible_learner='';
        for(var i=0;i<visib.length;i++){
            visib1=visib[i];
            visib2=visib1.split('*');
            if(visible_learner==''){
                visible_learner="<option value='"+visib2[0]+"'>"+visib2[1]+"</option>";
            }else{
                visible_learner=visible_learner+"<option value='"+visib2[0]+"'>"+visib2[1]+"</option>";
            }
        }
    }else{
        visible_learner='';
    }
    var param='"expert_data"';
    document.getElementById('chatdiv').innerHTML="<div style='height: 525px; overflow:auto;' id='topicdatadiv'><h4 class='header blue bolder smaller' align='left'>Topic Details</h4>\n\
	<div class='row' style='width: 100%;'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Topic Name<sup><font color='#FF0000'>*</font></sup><br>\n\
			<input type='text' name='expert_topic_name' id='expert_topic_name' value='' class='validate[required, ajax[ajaxevetopicname], minSize[2], maxSize[150], custom[alphanumericSp]] col-xs-12 col-sm-12'>\n\
			<input type='hidden' name='expert_eventid' id='expert_eventid' value="+eve_id+">\n\
			<input type='hidden' name='expert_prg_id' id='expert_prg_id' value="+pro_id+">\n\
			<input type='hidden' name='expert_topic_id' id='expert_topic_id' value=''>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Start Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group' style='margin-left: -13px;'>\n\
					<input type='text' name='topic_stdate' id='topic_stdate' value='' class='validate[custom[date2], future[#startdate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			End Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group' style='margin-left: -13px;'>\n\
					<input type='text' name='topic_enddate' id='topic_enddate' value='' class='validate[custom[date2], future[#topic_stdate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
	</div><br>\n\
	<div class='row' style='width: 100%;'>\n\
		<div class='col-xs-12 col-sm-6'>\n\
			Description<br>\n\
			<textarea name='description' id='description' style='resize:none;' class='col-xs-12 col-sm-12'></textarea>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Notifications on update<br>\n\
			<select name='initiate_notifications' id='initiate_notifications' class='col-xs-12 col-sm-12'>\n\
            <option value=''>Select</option>"+visible_learner+"</select>\n\
		</div>\n\
	</div><br>\n\
    <h4 class='header blue bolder smaller' align='left'>Expert Details</h4>\n\
	<div class='space-2'></div>\n\
	<div class='form-group'>\n\
		<label class='control-label col-xs-12 col-sm-2 no-padding-right' for='resource_id'>Resource Name</label>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			<div class='clearfix' style='width:268px;'>\n\
				<select name='resource_id' id='resource_id' class='chosen-select' onchange='topic_resource_data()'><option value=''>Select</option>"+resource_structure+"</select>\n\
			</div>\n\
		</div>\n\
	</div>\n\
	<div class='space-2'></div>\n\
	<!--<div class='col-xs-12 col-sm-3'>\n\
		Resource Name<sup><font color='#FF0000'>*</font></sup><br>\n\
		<select name='resource_id' id='resource_id' class='validate[required] chosen-select'><option value=''>Select</option>"+resource_structure+"</select>\n\
	</div>--><br><br>\n\
	<div id='topic_resdata' style='display:none;'>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Start Date<br>\n\
				<div class='input-large'>\n\
					<div class='input-group' style='margin-left: -13px;'>\n\
						<input type='text' name='required_date_from' id='expert_required_date_from' value='' class='validate[custom[date2], future[#startdate], past[#enddate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
						<input type='hidden' name='resource_booking_id' id='expert_resource_booking_id' value=''>\n\
						<input type='hidden' name='program_id' id='program_id' value=''>\n\
						<input type='hidden' name='event_id' id='event_id' value=''>\n\
						<span class='input-group-addon'>\n\
							<i class='ace-icon fa fa-calendar'></i>\n\
						</span>\n\
					</div>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				End Date<br>\n\
				<div class='input-large'>\n\
					<div class='input-group' style='margin-left: -13px;'>\n\
						<input type='text' name='required_date_to' id='expert_required_date_to' value='' class='validate[custom[date2], future[#required_date_from], past[#enddate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
						<span class='input-group-addon'>\n\
							<i class='ace-icon fa fa-calendar'></i>\n\
						</span>\n\
					</div>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Start Time<br>\n\
				<div class='input-group bootstrap-timepicker'>\n\
					<input type='text' name='required_start_time' id='expert_required_start_time' value='' class='form-control' onfocus='time_funct(this.id)' >\n\
					<span class='input-group-addon'>\n\
						<i class='fa fa-clock-o bigger-110'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				End Time<br>\n\
				<div class='input-group bootstrap-timepicker'>\n\
					<input type='text' name='required_end_time' id='expert_required_end_time' value='' class='form-control' onfocus='time_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='fa fa-clock-o bigger-110'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Trainer Role<br>\n\
				<select name='role_to_play' id='role_to_play' class='col-xs-12 col-sm-12'><option value=''>Select</option>"+trainer_role+"</select>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Visibility to Learner<br>\n\
				<select name='display_to_learner_flag' id='display_to_learner_flag' class='col-xs-12 col-sm-12'><option value=''>Select</option>"+visible_learner+"</select>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Booking Status<br>\n\
				<select name='status' id='status' class='col-xs-12 col-sm-12'><option value=''>Select</option>"+booking_status+"</select>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Booked By<br>\n\
				<select class='chosen-select' name='booking_person_id' id='booking_person_id'><option value=''>Select</option>"+bookedby+"</select>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Date Booked<br>\n\
				<div class='input-large'>\n\
					<div class='input-group' style='margin-left: -13px;'>\n\
						<input type='text' name='date_booking_placed' id='date_booking_placed' value='' class='validate[custom[date2],future[#startdate],past[#enddate]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' onfocus='date_funct(this.id)'>\n\
						<span class='input-group-addon'>\n\
							<i class='ace-icon fa fa-calendar'></i>\n\
						</span>\n\
					</div>\n\
				</div>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Quantity<br>\n\
				<input type='text' name='quantity' id='quantity' value='' class='validate[custom[onlyNumberSp] col-xs-12 col-sm-12]' maxlength='3'>\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Actual Price<br>\n\
				<input type='text' name='absolute_price' id='absolute_price' value='' class='validate[custom[amount]] col-xs-12 col-sm-12' maxlength='11' >\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Contact Person<br>\n\
				<input type='text' name='contact_name' id='contact_name' value='' class='validate[maxSize[80], custom[onlyLetterSomeSp]] col-xs-12 col-sm-12'>\n\
			</div>\n\
		</div><br>\n\
		<div class='row' style='width: 100%;'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				Contact Phone<br>\n\
				<input type='text' name='contact_phone_no' id='contact_phone_no' value='' class='validate[custom[phone]] col-xs-12 col-sm-12' maxlength='10'>\n\
			</div>\n\
		</div><br>\n\
	</div>\n\
<div class='form-actions center'>\n\
<input type='submit' name='expert_save'  id='expert_save' value='Save' class='btn btn-sm btn-success' onclick='return experttime_validate()'>&nbsp;&nbsp;&nbsp;<!-- onClick='cancel_funct("+param+")'-->\n\
<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' data-dismiss='modal'/></div></div><br>";
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
	document.getElementById('expert_topic_name').focus();
   $('.chosen-select').chosen({allow_single_deselect:true}); 
	//resize the chosen on window resize
	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=25){w=250;}
		$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');

}

function update_expert(topic_id,prgid,eveid){
	var eve_end_date=document.getElementById("eve_hid_end_date").value;
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
            document.getElementById('chatdiv').innerHTML=xmlhttp.responseText;
			$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
			//document.getElementById('expert_topic_name').focus();
            $('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
				var w = $('.chosen-select').parent().width();
				if(w<=25){w=250;}
				$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/expert_update?topicid="+topic_id+"&prgid="+prgid+"&evntid="+eveid+"&evenddt="+eve_end_date,true);
    xmlhttp.send();
}
function check_overlap_emp(){
	var evstdate=document.getElementById('startdate').value;
	var evendate=document.getElementById('enddate').value;
	var eventid=document.getElementById('event_id').value;
	var delivery_method=document.getElementById('del_met').value;
	var evendate_hidden=document.getElementById('eve_hid_end_date').value;
	
	if(evstdate==''){
		alertify.alert("End date can not be given without start date");
		return false;
	}
	if(evendate!='' && evstdate!=''){
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
				var spli=xmlhttp.responseText.split('@*');
				//if(delivery_method=='O' && evendate<evendate_hidden){
				if(delivery_method=='C'){
					if(spli[0]==1){
						alertify.alert("Employees Enrolled for this event has also been enrolled for other event on the same dates");
						document.getElementById('enddate').value=evendate_hidden;
						//location.reload();
					}
				}
				if(spli[2]==2){
					alertify.alert("End dates of "+spli[1]+" are greater than Event end date");
					document.getElementById('enddate').value=evendate_hidden;
					//alertify.alert("Employee has under gone pretest for this event, so date can not be pre ponded");
					//location.reload();
				}
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/check_overlap_employee?evntstdate="+evstdate+"&evntenddate="+evendate+"&evntid="+eventid,true);
		xmlhttp.send();
	}
}
function clone_event(){
	alertify.confirm("Do you want to duplicate the event details", function (e) {
		if (e) {
			var val_frm=$('#dup_event').validationEngine('validate');
			if(val_frm==false){
				$('#dup_event').validationEngine();
			}else{
				$('#chk_event').removeAttr("disabled");
				var action=BASE_URL+'/admin/event_details_clone';
				$("#dup_event").attr("action", action).submit();
			}
		} 
	});
	
}
$('#adminstrator').ajaxChosen({
	   dataType: 'json',
	   type: 'POST',
	   url:BASE_URL+'/admin/autoemployee'
},{
	   loadingImg: 'loading.gif'
});

function resourcedet(id,type){
	document.getElementById('resourcedetid').innerHTML="loading...";
	if(id==""){
		id=$("#resource_id").val();
	}
	if(id==''){
		alertify.alert("Please select the Resource");		
		return false;
	}
	else{
		var xmlhttp;
		if (window.XMLHttpRequest){
			 //code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{
			 //code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('resourcedetid').innerHTML=xmlhttp.responseText;
			}
			}
		if(type=="TRA"){
			xmlhttp.open("GET",BASE_URL+"/resource/res_tra_det?res_def_id="+id,true);
		}
		else{
			xmlhttp.open("GET",BASE_URL+"/resource/res_ven_det?res_def_id="+id,true);
		}
		xmlhttp.send();
	}
}
function side_menu(){    
   /* var aaheight=$(".right_content").css("height");
    aaheight=aaheight.replace("px","");
    aaheight=parseInt(aaheight);
    if(aaheight>560){
            $( '#menu' ).css("height",(aaheight+10)+"px");
            $( '#menu_multilevelpushmenu' ).css("height",(aaheight+10)+"px");
            $( '.multilevelpushmenu_wrapper .levelHolderClass').css("minHeight",(aaheight+10)+"px");
    }
    else{
            $( '#menu' ).css("height","560px");
            $( '#menu_multilevelpushmenu' ).css("height","560px");
    }
    $('.levelHolderClass').css("width",'210px');
    $('.multilevelpushmenu_wrapper h2').css("textAlign",'center');*/
}

/* $("#table_data").ace_scroll({
	height: '250px',
	width: '650px',
	size: 250,
	mouseWheelLock: true,
	alwaysVisible : true
}); */
 

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

function checkemroll(){
	var count = $("input.blkcheck[type='checkbox']:checked").length;
	if(count==0){
		alertify.alert("Please Select the Employee");
		return false;		
	}
	else{
		$("#single_save").attr('disabled','disabled');
		document.getElementById("org_master_check").submit();
	}
	
}

function checksearchemroll(){
	var count = $("input.searchcheck[type='checkbox']:checked").length;
	if(count==0){
		alertify.alert("Please Select the Employee");
		return false;		
	}
	else{
		$("#single_search_save").attr('disabled','disabled');
		document.getElementById("org_master_check").submit();
	}
	
}

function checklearnersearchemroll(){
	var count = $("input.learnersearchcheck[type='checkbox']:checked").length;
	if(count==0){
		alertify.alert("Please Select the Employee");
		return false;		
	}
	else{
		$("#single_search_save").attr('disabled','disabled');
		document.getElementById("org_master_check").submit();
	}
	
}

function tna_enroll(){
    var program_id=document.getElementById('program_id').value;
	var eve_id=document.getElementById('eve_id').value;
	if(program_id!=''){
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
				document.getElementById("enrollment_div").innerHTML=xmlhttp.responseText;
				$('#newtnatable').dataTable({
					bAutoWidth: false,
					"aoColumns": [
						{ "bSortable": false },
						null, null,null, null,
						{ "bSortable": false }
					]
				});
			}
        }
		xmlhttp.open("GET",BASE_URL+"/admin/tna_employee?program_id="+program_id+"&eve_id="+eve_id,true);
		xmlhttp.send();
	}
}

function on_loads_expenses(id,exp_id){
	var program_id=document.getElementById('program_id').value;
	var eve_id=document.getElementById('event_id').value;
	var key_id=id;
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
			document.getElementById("expences_details"+id).innerHTML=xmlhttp.responseText;
			$('#expenses_data').validationEngine();
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/event_expenses_attach?program_id="+program_id+"&eve_id="+eve_id+"&key_value="+id+"&expid="+exp_id,true);
	xmlhttp.send();
}


function checkzones(){
	var id = $('#location_zones').val();
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
			document.getElementById('location_select').innerHTML=xmlhttp.responseText;
			$("#location_select").chosen().trigger('chosen:updated');
		}
	}
	
	xmlhttp.open("GET",BASE_URL+"/admin/learner_secure_location?id="+id,true);
	xmlhttp.send();
}