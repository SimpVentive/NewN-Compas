$(document).ready(function(){
	$("#programs").validationEngine();
	$("#learner_competency").validationEngine({validateNonVisibleFields: true, updatePromptsPosition:true}); 
	
	var comp_width=$('#competency_level_id').css('width');
	$('#competency_id_chosen').css('width',comp_width);
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
		var def=$('#programs').validationEngine('validate');
		if(def==false){
			//$('#resource_form_data').validationEngine();
			$("#programs").validationEngine({promptPosition: 'inline'});
		}
		else{
			$("#save").attr('disabled','disabled');
			if(flg==1){document.getElementById("programs").submit();}
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
	}
	else if(status=='learn_access'){
		$('#newlearner_li').addClass('active');
		$('#newlearner').addClass('active');
		$('#prog_creation_li').removeClass('active');
		$('#newprog_creation').removeClass('active');
		$('#learner_li').removeClass('active');
		$('#learner_access').removeClass('active');
	}
	else{
		$("#prog_creation_li").addClass('active');
		$('#newprog_creation').addClass('active');
		$('#learner_li').removeClass('active');
		$('#learner_access').removeClass('active');
		$('#newlearner_li').removeClass('active');
		$('#newlearner').removeClass('active');
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
//Function to show learner access details
function get_details(){
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
				<select class='validate[required,ajax[ajaxProgOrgName]]' name='learner_org' id='learner_org' onchange='get_positions()'><option value=''>Select</option>"+learner_orgnames+"</select>\n\
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
		<h4 class='header blue bolder smaller'>Enrollment Type</h4>\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sm-3'><br>\n\
				<input type='checkbox' name='learner_self' id='learner_self' value='S'>&nbsp;No Approval Required\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'><br>\n\
				<input type='checkbox' name='learner_mandatory' id='learner_mandatory' value='M'>&nbsp;Mandatory Enrollment\n\
			</div>\n\
		</div><br>\n\
		<div class='form-actions center' >\n\
		<input type='submit' name='learner_save'  id='learner_save' value='Save' class='btn btn-sm btn-success' >&nbsp;&nbsp;&nbsp;\n\
		<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div>";
            document.getElementById('Learner_Group_div').style.display='none';
			document.getElementById('Location_div').style.display='none';
			$('.chosen-select').chosen({allow_single_deselect:true}); 
			//resize the chosen on window resize
			$(window).on('resize.chosen', function() {
				var w = $('.chosen-select').parent().width();
				if(w<=100){w=250;}
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
				<select name='restrict' id='learn_restrict' class='validate[required,ajax[ajaxProglearnergroup]] chosen-select'><option value=''>Select</option>"+learner_groups+"</select>\n\
			</div>\n\
		</div><br>\n\
		<h4 class='header blue bolder smaller'>Enrollment Type</h4>\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				<br>\n\
				<input type='checkbox' name='learner_self' id='learner_self' value='S'>&nbsp;No Approval Required\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				<br>\n\
				<input type='checkbox' name='learner_mandatory' id='learner_mandatory' value='M'>&nbsp;Mandatory Enrollment\n\
			</div>\n\
		</div><br>\n\
		<div class='form-actions center' >\n\
		<input type='submit' name='learner_save'  id='learner_save' value='Save' class='btn btn-sm btn-success' >&nbsp;&nbsp;&nbsp;\n\
		<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div>";
		document.getElementById('work_details_div').style.display='none';
		document.getElementById('Location_div').style.display='none';
		$('.chosen-select').chosen({allow_single_deselect:true}); 
		//resize the chosen on window resize
		$(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=100){w=250;}
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
				<select name='loc_restrict' id='loc_restrict' class='validate[required,ajax[ajaxProgLocation]] chosen-select'><option value=''>Select</option>"+location+"</select>\n\
			</div>\n\
		</div><br>\n\
		<h4 class='header blue bolder smaller'>Enrollment Type</h4>\n\
		<div class='row'>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				<br>\n\
				<input type='checkbox' name='learner_self' id='learner_self' value='S'>&nbsp;No Approval Required\n\
			</div>\n\
			<div class='col-xs-12 col-sm-3'>\n\
				<br>\n\
				<input type='checkbox' name='learner_mandatory' id='learner_mandatory' value='M'>&nbsp;Mandatory Enrollment\n\
			</div>\n\
		</div><br>\n\
		<div class='form-actions center' >\n\
		<input type='submit' name='learner_save'  id='learner_save' value='Save' class='btn btn-sm btn-success' >&nbsp;&nbsp;&nbsp;\n\
		<input type='button' class='btn btn-sm btn-danger' name='cancel' id='cancel' value='cancel' onClick='cancel_funct("+param+")'/></div>";
		document.getElementById('work_details_div').style.display='none';
		document.getElementById('Learner_Group_div').style.display='none';
		$('.chosen-select').chosen({allow_single_deselect:true}); 
		//resize the chosen on window resize
		$(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=100){w=250;}
			$('.chosen-select').next().css({'width':w});
		}).trigger('resize.chosen');
		return false;
	}
	if(rest==''){
		document.getElementById('work_details_div').style.display='none';
		document.getElementById('Learner_Group_div').style.display='none';
		document.getElementById('Location_div').style.display='none';
	} 		
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

function AddInfo(){
    var tbl = document.getElementById("workinfo_tab");
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
        //var maxa=Math.max(ins1);
        sub_iteration=parseInt(temp)+1;
        for( var j=0;j<ins1.length;j++){
            var i=ins1[j];
            var material_name=document.getElementById("material_name["+i+"]").value;
			var language=document.getElementById("language["+i+"]").value;
			var url=document.getElementById("url["+i+"]").value;
			var product_status=document.getElementById("status["+i+"]").value;
            if(material_name==''){
                alertify.alert("Please enter Material name");
                return false;
            }
			if(language==''){
                alertify.alert("Please Select language");
                return false;
            }
			if(url==''){
                alertify.alert("Please enter url");
                return false;
            }
			if(product_status==''){
                alertify.alert("Please select product status");
                return false;
            }
        }
    }
    else{
        sub_iteration=1;
        ins1=1;
        var ins1=Array(1);
    }
	if(org_status!=''){
        var orgst=org_status.split(',');
        var orgnztn_status='';
		orgnztn_status="<option value=''>Select</option>";
        for(var i=0;i<orgst.length;i++){
            orgst2=orgst[i].split('*');
            if(orgnztn_status==''){
                orgnztn_status="<option value='"+orgst2[0]+"'>"+orgst2[1]+"</option>";
            }else{
                if(orgst2[0]=='I'){var sel="selected='selected'";}else{var sel='';}
                orgnztn_status=orgnztn_status+"<option value='"+orgst2[0]+"' "+sel+">"+orgst2[1]+"</option>";
            }
        }
    }else{
        orgnztn_status='';
    }
	if(org_material!=''){
        var orgmaterial=org_material.split(',');
        var orgmaterial_status='';
		orgmaterial_status="<option value=''>Select</option>";
        for(var i=0;i<orgmaterial.length;i++){
            orgmaterial2=orgmaterial[i].split('*');
            if(orgmaterial_status==''){
                orgmaterial_status="<option value='"+orgmaterial2[0]+"_"+orgmaterial2[1]+"'>"+orgmaterial2[1]+"</option>";
            }else{
                if(orgmaterial2[0]=='I'){var sel="selected='selected'";}else{var sel='';}
                orgmaterial_status=orgmaterial_status+"<option value='"+orgmaterial2[0]+"_"+orgmaterial2[1]+"' "+sel+">"+orgmaterial2[1]+"</option>";
            }
        }
    }else{
        orgmaterial_status='';
    }
    var super_sub_iteration=sub_iteration-1;
    $("#workinfo_tab").append("<tr id='worktab"+sub_iteration+"'><input type='hidden' name='attach_id[]' id='attach_id["+sub_iteration+"]' value=''><td style='padding-left:15px;'><input type='checkbox' name='select_chk' id='select_chk["+sub_iteration+"]' value="+sub_iteration+"></td><td><input class='validate[required]' type='text' name='material_name[]' id='material_name["+sub_iteration+"]' value='' style='width:200px;'></td><td><select class='validate[required]' name='language[]' id='language["+sub_iteration+"]' style='width:200px;'><option value=''>Select</option><option value='1'>English</option><option value='2'>Telugu</option><option value='3'>HIndi</option><option value='4'>Tamil</option></select></td><td><select name='url[]' id='url["+sub_iteration+"]' style='width:230px;'>"+orgmaterial_status+"</select></td><td><input type='hidden' name='stat_hidden' id='stat_hidden["+sub_iteration+"]'><select name='status[]' id='status["+sub_iteration+"]' style='width:200px;'>"+orgnztn_status+"</select></td></tr>");
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
}

function DelInfo(){
    var ins=document.getElementById('inner_hidden_id').value;
    //alert(ins);
	var arr1=ins.split(",");
    var flag=0;
    var tbl = document.getElementById('workinfo_tab');
    var lastRow = tbl.rows.length;
    for(var i=(arr1.length-1); i>=0; i--){
        var bb=arr1[i];
        var a="select_chk["+bb+"]";	
        	
		if(document.getElementById(a).checked){
			var stat=document.getElementById("stat_hidden["+bb+"]").value;
			if(stat=='A'){
				alertify.alert('You cannot delete an employee work information record, which is active');
				return false;
			}else{
				var del_confirm=window.confirm("Do you want to delete this record?");
				if(del_confirm==true){
					var b=document.getElementById(a).value;
					var c="worktab"+b+"";
					var wrkid=document.getElementById("work_id["+b+"]").value;
					if(wrkid!=""){
						$.ajax({
							url: BASE_URL+"/admin/DeleteEmpInfo",
							global: false,
							type: "POST",
							data: ({val : wrkid}),
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
				}else{
					return false;
				}
			}
		}
    }
    if(flag==0){
        alertify.alert("Please select the Value to Delete");
        return false;
    }
    document.getElementById('inner_hidden_id').value=arr1;
    
}

function orgname_valid(){
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
        //var maxa=Math.max(ins1);
        sub_iteration=parseInt(temp)+1;
        for( var j=0;j<ins1.length;j++){
            var i=ins1[j];
             var material_name=document.getElementById("material_name["+i+"]").value;
			var language=document.getElementById("language["+i+"]").value;
			var url=document.getElementById("url["+i+"]").value;
			var product_status=document.getElementById("status["+i+"]").value;
            if(material_name==''){
                alertify.alert("Please enter Material name");
                return false;
            }
			if(language==''){
                alertify.alert("Please Select language");
                return false;
            }
			if(url==''){
                alertify.alert("Please enter url");
                return false;
            }
			if(product_status==''){
                alertify.alert("Please select product status");
                return false;
            }
        }
    }
}

function open_cite(){
    var state_id=document.getElementById('state').value;
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
			document.getElementById("cities").innerHTML=xmlhttp.responseText;
			//alertify.alert(xmlhttp.responseText);
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/city_list_att?state_id="+state_id,true);
	xmlhttp.send();
    
}

function open_dealers(){
    var city_id=document.getElementById('cities_a').value;
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
			document.getElementById("dealer").innerHTML=xmlhttp.responseText;
			//alertify.alert(xmlhttp.responseText);
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/dealer_details?city_id="+city_id,true);
	xmlhttp.send();
    
}

function mason_details(venid,pro_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
    }else{
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){   
		    document.getElementById('Approvaldiv').innerHTML=xmlhttp.responseText;
			//$('#employeeresults').validationEngine();
		}
    }
	xmlhttp.open("GET",BASE_URL+"/admin/vendor_request_details?venid="+venid+"&pro_id="+pro_id,true);
    xmlhttp.send()
	
}
