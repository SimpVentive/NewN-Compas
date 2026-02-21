$(document).ready(function(){
    //$('#definition_form').validationEngine();	
    $('#resource_form_data').validationEngine();
    $('#evaluate_form').validationEngine(); 
	$('#expenses_data').validationEngine();	
});
/* $("input[type=submit]").click(function(){
	var def=$('#definition_form').validationEngine('validate');
	if(def==false){
		$('#definition_form').validationEngine();
	}else{
		$("input[type=submit]").attr('disabled','disabled');
	}
});  */

$(document).ready(function(){
	//$('#starttime').timepicker();
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
	$('.bootstrap-timepicker-widget').css({'z-index':'9999'});
	/* $('#communicationDetails').modal({
		show: false,
		backdrop: 'static',
		keyboard: false  // to prevent closing with Esc button (if you want this too)
	}); */
	var flg=1;
	//code for disable submit button after click once
    $("#save").click(function(e){
		e.preventDefault();
		var def=$('#definition_form').validationEngine('validate');
			if(def==false){
				//$('#resource_form_data').validationEngine();
				$("#definition_form").validationEngine({promptPosition: 'inline'});
			}
			else{
				$("#save").attr('disabled','disabled');
				if(flg==1){document.getElementById("definition_form").submit();}
				flg++;
			}
	}); 
});

function goback(id){
     window.location=BASE_URL+'/admin/program_event_details?id='+id;
 } 
 function check_status(){
	var eve_stdt=document.getElementById('sess_start_date').value;
	var eve_endt=document.getElementById('sess_end_date').value;	
	var sttime=document.getElementById('sess_start_time').value;
    var endtime=document.getElementById('sess_end_time').value;
	if(eve_stdt==eve_endt){
		if(parseInt(endtime)<parseInt(sttime)){
			alertify.alert("End Time can not be less than Start Time for the same day");
			return false;
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
	*/
	if(document.getElementById('resource_id')){
		var res_stdate=document.getElementById('res_required_date_from').value.trim();
		var res_enddate=document.getElementById('res_required_date_to').value.trim();
		var res_sttime=document.getElementById('res_required_start_time').value.trim();
		var res_endtime=document.getElementById('res_required_end_time').value.trim();
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
		}
		else{
			if(res_sttime!='' || res_endtime!=''){
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
							document.getElementById('resource_form_data').submit();
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
		document.getElementById('resource_form_data').submit();
	}
		
	 
	/* if(document.getElementById('resource_id')){
		var res_id=$('#resource_id').val();
		if(res_id!=''){ 
			$("#bootbox-confirm").on(ace.click_event, function() {
				bootbox.confirm("Are you sure?", function(result) {
					if(result) {
						//
					}
				});
			});
		 }
	} */
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
	if(sess_stat!=''){
		if(sess_stat=='resource'){
			$('#resource_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#resource_def').addClass('active');
			$('#evaluate_def').removeClass('active');
			$('#expenses_def').removeClass('active');
		}else if(sess_stat=='evaluation'){
			$('#evaluate_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#resource_def').removeClass('active');
			$('#evaluate_def').addClass('active');
			$('#expenses_def').removeClass('active');
		}
		else if(sess_stat=='expenses'){
			$('#expenses_li').addClass('active');
			$('#event_def').removeClass('active');
			$('#resource_def').removeClass('active');
			$('#evaluate_def').removeClass('active');
			$('#expenses_def').addClass('active');
		}
	}
	else{
		$("#event_li").addClass('active');
		$("#event_def").addClass('active');
		$('#resource_def').removeClass('active');
		$('#evaluate_def').removeClass('active');
	} 
});



function open_resource_details(){
    var data=document.getElementById("resource_create").value;
    var prgid=document.getElementById("program_id").value;
    var eveid=document.getElementById("event_id").value;
	var sessid=document.getElementById("res_event_sess_id").value;
	var eve_end_date=document.getElementById("eve_hid_end_date").value;
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
				$('#resource_form_data').validationEngine();
            }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/get_resource_names_sess?res_id="+data+"&prgid="+prgid+"&evntid="+eveid+"&sessid="+sessid+"&eve_enddt="+eve_end_date,true);
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
	var sesstdat=document.getElementById('res_required_date_from').value;
	var sesendat=document.getElementById('res_required_date_to').value;
	var sessststarttime=document.getElementById('res_required_start_time').value;
	var sessenendtime=document.getElementById('res_required_end_time').value;
    var def_id=document.getElementById('resource_id').value;
	var sessid=document.getElementById('event_sess_id').value;
	var res_buk_id=document.getElementById('resource_booking_id').value;
	var structure_id=document.getElementById('structure_id').value;
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
				//document.getElementById('tra_details').innerHTML=resp[1];
				if(resp[0]==1){
					alertify.alert("Resource has already booked for some event in this duration");
					$(".chosen-select").val('').trigger("chosen:updated");
					return false;
				}
				
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/resource_additionalinfo_sess?res_def_id="+def_id+"&sessid="+sessid+"&resbuk_id="+res_buk_id+"&structure_id="+structure_id+"&sesstdt="+sesstdat+"&sesendt="+sesendat+"&sessststarttime="+sessststarttime+"&sessenendtime="+sessenendtime,true);
		xmlhttp.send();
    }else{
		document.getElementById('tra_details').innerHTML='';
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
			$('#resource_form_data').validationEngine();
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/resource_update_sess?res_id="+res_id+"&res_book_id="+bookid+"&prgid="+pro_id+"&evntid="+eve_id+"&eveendt="+eve_end_date,true);
    xmlhttp.send();
}

function get_testnames(){
    var test_type=document.getElementById('sess_evaluation_type').value;
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
	var eve_start_date=$('#eve_enrl_strt_date').val();
	var eve_end_date=$('#eve_end_date').val();
    var param='"evaluate_data"';
    document.getElementById('evaluate_data').innerHTML="<h4 class='header blue bolder smaller'>Evaluation Details</h4>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Test Type<sup><font color='#FF0000'>*</font></sup><br>\n\
			<select name='sess_evaluation_type' id='sess_evaluation_type' class='validate[required] col-xs-12 col-sm-12' onchange='get_testnames()'><option value=''>Select</option>"+test_type+"</select>\n\
			<input type='hidden' name='enroll_end_date' id='enroll_end_date' value=''>\n\
			<input type='hidden' name='enroll_start_date' id='enroll_start_date' value="+eve_start_date+">\n\
			<input type='hidden' name='event_end_date' id='event_end_date' value="+eve_end_date+">\n\
			<input type='hidden' name='event_start_date' id='event_start_date' value=''>\n\
			<input type='hidden' name='delivery_method' id='delivery_method' value=''>\n\
			<input type='hidden' name='program_date' id='program_date' value=''>\n\
			<input type='hidden' name='eval_eventid' id='eval_eventid' value="+eve_id+">\n\
			<input type='hidden' name='sess_id' id='sess_id' value="+sess_id+">\n\
			<input type='hidden' name='prg_id' id='prg_id' value="+pro_id+">\n\
			<input type='hidden' name='sess_evaluation_id' id='sess_evaluation_id' value=''>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Test Name<sup><font color='#FF0000'>*</font></sup><br>\n\
			<select name='test_id' class='validate[required, ajax[ajaxEventSessEvaluation]] col-xs-12 col-sm-12' id='test_id'><option value=''>Select</option></select>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Start Date<br>\n\
			<div class='input-large'>\n\
				<div class='input-group'>\n\
					<input type='text' name='start_date_active' id='evalu_start_date' class='validate[custom[date2],future[#enroll_start_date]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' value='' onfocus='date_funct(this.id)'>\n\
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
					<input type='text'  name='end_date_active' id='evalu_end_date' class='validate[custom[date2],future[#evalu_start_date]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy'  value='' onfocus='date_funct(this.id)'>\n\
					<span class='input-group-addon'>\n\
						<i class='ace-icon fa fa-calendar'></i>\n\
					</span>\n\
				</div>\n\
			</div>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Start Time<br>\n\
			<div class='input-group bootstrap-timepicker'>\n\
				<input type='text'  name='eval_start_time' id='eval_start_time' class='form-control'  value='' onfocus='time_funct(this.id)' >\n\
				<span class='input-group-addon'>\n\
					<i class='fa fa-clock-o bigger-110'></i>\n\
				</span>\n\
			</div>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			End Time<br>\n\
			<div class='input-group bootstrap-timepicker'>\n\
				<input type='text'  name='eval_end_time' id='eval_end_time' class='form-control'  value='' onfocus='time_funct(this.id)' >\n\
				<span class='input-group-addon'>\n\
					<i class='fa fa-clock-o bigger-110'></i>\n\
				</span>\n\
			</div>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Mandatory<sup><font color='#FF0000'>*</font></sup><br>\n\
			<select name='sess_eval_mandatory_flag' id='sess_eval_mandatory_flag' class='validate[required] col-xs-12 col-sm-12'><option value=''>Select</option>"+test_mandatory+"</select>\n\
		</div>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Test Status<sup><font color='#FF0000'>*</font></sup><br>\n\
			<select name='eval_status' id='eval_status' class='validate[required] col-xs-12 col-sm-12'><option value=''>Select</option>"+status_eval+"</select>\n\
		</div>\n\
	</div><br>\n\
	<div class='row'>\n\
		<div class='col-xs-12 col-sm-3'>\n\
			Test Hold On Days<br>\n\
			<input type='text'  name='test_hold_days' id='test_hold_days' class='validate[custom[onlyNumberSp]] col-xs-12 col-sm-12' value='' maxlength=2>\n\
		</div>\n\
	</div><br>\n\
	<div class='form-actions center' >\n\
		<input type='submit' name='eval_save'  id='eval_save' value='Save' class='btn btn-sm btn-success' onclick='return evaluate_validate()' >&nbsp;&nbsp;&nbsp;\n\
		<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div> ";
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });


}
function evaluation_edit(id,proid){
	var enrl_stdate=$('#eve_enrl_strt_date').val();
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
	xmlhttp.open("GET",BASE_URL+"/admin/sess_evaluation_update?eval_id="+id+"&proid="+proid+"&enrlstdate="+enrl_stdate,true);
	xmlhttp.send();
}
function evaluate_validate(){
    //var delivery_method=document.getElementById('del_met').value;
    var test_type=document.getElementById('sess_evaluation_type').value;
    var enrl_stdate=document.getElementById('enroll_start_date').value;
	var sess_stdate=document.getElementById('sess_start_date').value;
    var sess_endate=document.getElementById('sess_end_date').value;
    var eval_stdate=document.getElementById('evalu_start_date').value;
    var eval_enddate=document.getElementById('evalu_end_date').value;
	var event_enddate=document.getElementById('eve_end_date').value;
	var sess_sttime=$('#sess_start_time').val();
	var sess_endtime=$('#sess_end_time').val();
	var eval_sttime=$('#eval_start_time').val();
	var eval_endtime=$('#eval_end_time').val();
	if(eval_stdate=='' && eval_enddate!=''){
		alertify.alert("End date can not be given with out giving the start date");
		return false;
	}
	if(eval_stdate==eval_enddate){
		if(parseInt(eval_endtime)<parseInt(eval_sttime)){
			alertify.alert("End time should not be less than start time for the same day");
			return false;
		}
	}
	eval_stdates=eval_stdate.split("-");
	eval_enddates=eval_enddate.split("-");
	enrl_stdates=enrl_stdate.split("-");
	sess_stdates=sess_stdate.split("-");
	sess_endates=sess_endate.split("-");
	evnt_endates=event_enddate.split("-");
	stdate_eval= new Date(eval_stdates[2],(eval_stdates[1]-1),eval_stdates[0]);
	enddate_eval= new Date(eval_enddates[2],(eval_enddates[1]-1),eval_enddates[0]);
	stdate_enrl= new Date(enrl_stdates[2],(enrl_stdates[1]-1),enrl_stdates[0]);
	stdate_sess= new Date(sess_stdates[2],(sess_stdates[1]-1),sess_stdates[0]);
	enddate_sess= new Date(sess_endates[2],(sess_endates[1]-1),sess_endates[0]);
	enddate_evnt= new Date(evnt_endates[2],(evnt_endates[1]-1),evnt_endates[0]);
	if(test_type=='PRE'){
		if(stdate_eval=='' || eval_enddate==''){
			alertify.alert("Please give start date and end date for PRE Test");
			return false;
		}
		if(stdate_eval<stdate_enrl || stdate_eval>stdate_sess){
			alertify.alert("Evaluation Start date should be between Event Enrolment Start Date and Session Start Date");
			return false;
		}
		if(enddate_eval<stdate_enrl || enddate_eval>stdate_sess){
			alertify.alert("Evaluation End date should be between  Event Enrolment Start Date and Session Start Date");
			return false;
		}
		if(sess_stdate==eval_enddate){
			if(eval_sttime!='' && sess_sttime!='' && eval_endtime!=''){
				if(eval_sttime>=sess_sttime){
					alertify.alert("Pre test Start Time "+eval_sttime +" should be less than Session Start Time "+sess_sttime);
					return false;
				}
				if(eval_endtime>=sess_sttime){
					alertify.alert("Pre test end time "+eval_endtime+" should be less than session start time "+sess_sttime);
					return false;
				}
			}
		}
	}
	else if(test_type=='POST'){
		if(stdate_eval<enddate_sess || stdate_eval>enddate_evnt){
			alertify.alert("Evaluation Start date should be between Session End Date and Event End Date");
			return false;
		}
		if(enddate_eval<enddate_sess || enddate_eval>enddate_evnt){
			alertify.alert("Evaluation End date should be between Session End Date and Event End Date");
			return false;
		}
		if(sess_endate==eval_stdate){
			if(eval_sttime!='' && sess_endtime!='' && eval_endtime!=''){
				if(eval_sttime<=sess_endtime){
					alertify.alert("Pre test Start Time "+eval_sttime +" should be greater than Session End Time "+sess_endtime);
					return false;
				}
				if(eval_endtime<=sess_endtime){
					alertify.alert("Pre test end time "+eval_endtime+" should be greater than session End time "+sess_endtime);
					return false;
				}
			}
		}
	}
    
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
					<input type='text' class='validate[custom[date2]] datepicker input-large date-picker' data-date-format='dd-mm-yyyy' placeholder='dd-mm-yyyy' name='start_date_active' id='start_date_active' value='' onfocus='date_funct(this.id)'>\n\
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

function fetchResource(id){
	var itemtype=document.getElementById('item_type['+id+']').value;
	$.ajax({
		type: "GET",
		url: BASE_URL+"/admin/fetch_resource?item="+itemtype+"&eve_id="+eve_id+"&sess_id="+sess_id,
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
			if(item_type!=''){
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

function cancel_funct(div_id){
    document.getElementById(div_id).innerHTML='';
	side_menu();
}
function cancel_funct_select(div_id,sel_id){
	document.getElementById(sel_id).value='';
	document.getElementById(div_id).innerHTML='';
	side_menu();
}
function resourcedet(id,type){
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
		document.getElementById('resourcedetid').innerHTML="loading..."
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

function checkUnisess(field, rules, i, options){
	var url = BASE_URL+"/index/eventsessname/";
	var event_id=$("#event_id").val();
	var event_sess_id=$("#event_sess_id").val();
	var id=field.attr("id");
    var data = "fieldId="+field.attr("id")+"&fieldValue="+field.val()+"&event_sess_id="+event_sess_id+"&event_id="+event_id;//field.attr("id") + "=" + field.val();
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
        return options.allrules.checkUnisess.alertText;
    }
}

function on_loads_expenses(id,exp_id){
    var program_id=document.getElementById('program_id').value;
	var eve_id=document.getElementById('event_id').value;
	var sess_id=document.getElementById('sess_id').value;
	var key_id=id;

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
                document.getElementById("expences_details"+id).innerHTML=xmlhttp.responseText;
                $('#expenses_data').validationEngine();
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/session_expenses_attach?sess_id="+sess_id+"&program_id="+program_id+"&eve_id="+eve_id+"&key_value="+id+"&expid="+exp_id,true);
        xmlhttp.send();

}
						