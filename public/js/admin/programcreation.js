$(document).ready(function(){
	
	$("#programs_form").validationEngine();
	$("#learner_competency").validationEngine({validateNonVisibleFields: true, updatePromptsPosition:true}); 
	$("#material_validation").validationEngine();
	$("#learner_restrict").validationEngine();
	var comp_width=$('#competency_level_id').css('width');
	$('#competency_id_chosen').css('width',comp_width);
	$('#editor1').ace_wysiwyg();
	$('#objective_editor1').ace_wysiwyg();
	$('#description_editor1').ace_wysiwyg();
	$('#save').on('click', function() {
		var hidden_input =
		$('<input type="hidden" name="topics_covered" />')
		.appendTo('#programs_form');
		var html_content = $('#editor1').html();
		hidden_input.val( html_content );
		
		var hidden_input_o =
		$('<input type="hidden" name="objective" />')
		.appendTo('#programs_form');
		var html_content_o = $('#objective_editor1').html();
		hidden_input_o.val( html_content_o );
		
		var hidden_input_description =
		$('<input type="hidden" name="description" />')
		.appendTo('#programs_form');
		var html_content_description = $('#description_editor1').html();
		hidden_input_description.val( html_content_description );
	  //put the editor's HTML into hidden_input and it will be sent to server
	});
	
});
/* $("input[type=submit]").click(function(){
	$("input[type=submit]").attr('disabled','disabled');
}); */
$(document).ready(function(){
	/* var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); */
	
	var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	minDate:"",
	maxDate:"",
	//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
	//buttonImageOnly: true,
	onSelect: function( selectedDate ) { 
	var option = this.id === "startdate" ? "minDate" : "maxDate",
	instance = $( this ).data( "datepicker" ),
	date = $.datepicker.parseDate(
	instance.settings.dateFormat ||
	$.datepicker._defaults.dateFormat,
	selectedDate, instance.settings );
	dates.not( this ).datepicker( "option", option, date );
	}
	});
	
	var flg=1;
	//code for disable submit button after click once		
	$("#save").click(function(e){
		e.preventDefault();
		var def=$('#programs_form').validationEngine('validate');
		if(def==false){
			//$('#resource_form_data').validationEngine();
			$("#programs_form").validationEngine({promptPosition: 'inline'});
		}
		else{
			$("#save").attr('disabled','disabled');
			if(flg==1){document.getElementById("programs_form").submit();}
			flg++;
		}
	});
});

 $(document).ready(function() {
	$('.nav-tabs li').click(function(event){
		if ($(this).hasClass('disabled')) {
			return false;
		}
	});
	
	if(status=='pro_creation'){
		$('#learner_li').addClass('active');
		$('#learner_access').addClass('active');
		$('#prog_creation_li').removeClass('active');
		$('#newprog_creation').removeClass('active');
		$('#newlearner_li').removeClass('active');
		$('#newlearner').removeClass('active');
		$('#newattach_li').removeClass('active');
		$('#newattach').removeClass('active');
	}
	else if(status=='learn_access'){
		$('#newlearner_li').addClass('active');
		$('#newlearner').addClass('active');
		$('#prog_creation_li').removeClass('active');
		$('#newprog_creation').removeClass('active');
		$('#learner_li').removeClass('active');
		$('#learner_access').removeClass('active');
		$('#newattach_li').removeClass('active');
		$('#newattach').removeClass('active');
	}
	else if(status=='pro_material'){
		$('#newattach_li').addClass('active');
		$('#newattach').addClass('active');
		$('#prog_creation_li').removeClass('active');
		$('#newprog_creation').removeClass('active');
		$('#learner_li').removeClass('active');
		$('#learner_access').removeClass('active');
		$('#newlearner_li').removeClass('active');
		$('#newlearner').removeClass('active');
	}
	else{
		$("#prog_creation_li").addClass('active');
		$('#newprog_creation').addClass('active');
		$('#learner_li').removeClass('active');
		$('#learner_access').removeClass('active');
		$('#newlearner_li').removeClass('active');
		$('#newlearner').removeClass('active');
		$('#newattach_li').removeClass('active');
		$('#newattach').removeClass('active');
	} 
});

function back_seach(link){
     window.location=BASE_URL+"/admin/"+link; 
 }
function check_eventdates(){
	var prg_enddate=document.getElementById('enddate').value;
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
			if(xmlhttp.responseText==1){
				alertify.alert("There are some events of which end date is greater than or equal to program end date");
				document.getElementById('enddate').value='';
				//location.reload();
				return false;
			}
			//document.getElementById('competency_level_id').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/check_prg_eventdates?progid="+id+"&prgenddate="+prg_enddate,true);
	xmlhttp.send();
}
function getcomp_levels(){
    var comp_id=document.getElementById('competency_id').value;
	if(comp_id!=''){
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
                document.getElementById('competency_level_id').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/get_comp_level?compid="+comp_id,true);
        xmlhttp.send();
    }    
}
function edit_comp(id,key){
	var prgrmid=document.getElementById('program_id').value;
	var compid=document.getElementById('comp_id['+key+']').value;
	var levelid=document.getElementById('level_id['+key+']').value;
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
			document.getElementById('competency_level_new').innerHTML=xmlhttp.responseText;
			var config = {
			'.chosen-select': {}
			}
			for (var selector in config) {
			$(selector).chosen(config[selector]);
			}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/learner_competency_edit?comp_id="+compid+"&levelid="+levelid+"&progid="+prgrmid+"&learnerid="+id,true);
	xmlhttp.send();    
}
function category_details(){
	var catid=document.getElementById('category').value;
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
			if($response[0]==''){
				document.getElementById('category_stdate').value="";
				document.getElementById('category_enddate').value="";
			}else{
				document.getElementById('category_stdate').value=$response[0];
				document.getElementById('category_enddate').value=$response[1];								
			}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/get_cat_date?categoryid="+catid,true);
	xmlhttp.send();    
}

$('.chosen-toggle').each(function(index) {
    $(this).on('click', function(){
         $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
    });
});
//Function to show learner access details
function get_details(){
	var rest=document.getElementById('restrict').value;
	if(rest=='W' || rest=='LOC'){   
		document.getElementById('work_details_div').style.display='block';
		document.getElementById('Learner_Group_div').style.display='none';
		/* $("#location_select_chosen").width('650');
		$("#location_zones_chosen").width('650');
		$("#bu_select_chosen").width('650');
		$("#depart_select_chosen").width('650');
		$("#grade_select_chosen").width('650');
		$("#division_select_chosen").width('650');
		$("#employee_type_select_chosen").width('650');
		$("#employee_cat_select_chosen").width('650'); */
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
				if(w<=100){w=250;}
				$('.chosen-select').next().css({'width':w});
			}).trigger('resize.chosen');
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/learner_event_update?learner_id="+lernid,true);
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


//added by sravanthi for getting image based on image id

function getimage()
{
    var id=document.getElementById('program_image').value;
	
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
             document.getElementById('progimage').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/show_image?image_id="+id,true);
    xmlhttp.send();
	
}

$('#program_admin').ajaxChosen({
	   dataType: 'json',
	   type: 'POST',
	   url:BASE_URL+'/admin/autoemployee'
},{
	   loadingImg: 'loading.gif'
});

$(window).on('resize.chosen', function() {
	var w = $('.chosen-select').parent().width();
	if(w<=100){w=250;}
	$('.chosen-select').next().css({'width':w});
}).trigger('resize.chosen');


function checkUnipro(field, rules, i, options){
	var url = BASE_URL+"/index/checkprogram_name_exist";
	var pro_id=$("#pro_id").val();
	var category=$("#category").val();
	var id=field.attr("id");
    var data = "fieldId="+field.attr("id")+"&fieldValue="+field.val()+"&category="+category+"&pro_id="+pro_id;//field.attr("id") + "=" + field.val();
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
        return options.allrules.checkUnipro.alertText;
    }
}

function restrict_failed(){
	alertify.alert("Learner Access can not be Delete after event creation");
	return false;
}
/*Program materials*/
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
    //alert(mat_id);
    if(mat_id=='SCORM'){
        document.getElementById('online_material').innerHTML="<h4 class='header blue bolder smaller'>e-learning Material</h4><table class='table table-striped table-bordered table-hover' id='mat_upload_tab' style='width:1000px;'><thead><tr><th>Select</th><th>Material Name</th><th>Material Type</th><th>Display to Learner</th><th>Display to Trainer</th></tr></thead><tr id='mat_innertable0'><td style='padding-left:20px;'><input type='hidden' name='elearn_mat_id[]' id='elearn_mat_id[0]' value=''><input type='checkbox'  name='mat_chk[]' id='mat_chk[0]' value='0' /></td><td><select style='width:200px;' name='learning_material_id[]' id='learning_material_id[0]' onchange='getmaterialdata(0)'/><option value=''>Select</option>"+learning_material+"</select></td><td><select id='material_details[0]' name='material_details[]' style='width: 200px;'></select></td><td style='padding-left:90px;'><input type='checkbox' name='display_learn[]' id='display_learn[0]' value='Yes' /></td><td style='padding-left:90px;'><input type='checkbox' name='display_trainer[]' id='display_trainer[0]' value='Yes' /></td></tr></table><input type='hidden' id='mat_hidden_id' value='0' name='mat_hidden_id' />";
    }
    else if(mat_id=='NON-SCORM'){
        document.getElementById('online_material').innerHTML="<h4 class='header blue bolder smaller'>e-learning Material</h4><div><input type='button' name='addrow' id='addrow' value='Add Row' class='btn btn-sm btn-success' onClick='AddMaterial()'/><input type='button' name='del' id='del' value='Delete Row'  class='btn btn-sm btn-danger' onClick='DelMaterial()'/></div><table class='table table-striped table-bordered table-hover' id='mat_upload_tab' style='width:1000px;'><thead><tr><th>Select</th><th>Material Name</th><th>Material Type</th><th>Display to Learner</th><th>Display to Trainer</th></tr></thead><tr id='mat_innertable0'><td style='padding-left:20px;'><input type='hidden' name='elearn_mat_id[]' id='elearn_mat_id[0]' value=''><input type='checkbox'  name='mat_chk[]' id='mat_chk[0]' value='0' /></td><td><select style='width:200px;' name='learning_material_id[]' id='learning_material_id[0]' onchange='getmaterialdata(0)'/><option value=''>Select</option>"+nonscorm_material+"</select></td><td><select id='material_details[0]' name='material_details[]' style='width: 200px;'></select></td><td style='padding-left:90px;'><input type='checkbox' name='display_learn[]' id='display_learn[0]' value='Yes' /></td><td style='padding-left:90px;'><input type='checkbox' name='display_trainer[]' id='display_trainer[0]' value='Yes' /></td></tr><input type='hidden' id='mat_hidden_id' value='0' name='mat_hidden_id' /></table>";
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
   $("#mat_upload_tab").append("<tr id='mat_innertable"+sub_iteration+"'><td style='padding-left:20px;'><input type='hidden' name='elearn_mat_id[]' id='elearn_mat_id["+sub_iteration+"]' value=''><input type='checkbox'  name='mat_chk[]' id='mat_chk["+sub_iteration+"]' value="+sub_iteration+" /></td><td><select name='learning_material_id[]' id='learning_material_id["+sub_iteration+"]' onchange='getmaterialdata("+sub_iteration+")' style='width:200px;'><option value=''>Select</option>"+nonscorm_material+"</select></td><td><select id='material_details["+sub_iteration+"]' name='material_details[]' style='width: 200px;'></select></td><td style='padding-left:90px;'><input type='checkbox' name='display_learn[]' id='display_learn["+sub_iteration+"]' value='Yes' /></td><td style='padding-left:90px;'><input type='checkbox' name='display_trainer[]' id='display_trainer["+sub_iteration+"]' value='Yes' /></td></tr>");
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