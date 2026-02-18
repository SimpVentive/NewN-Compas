jQuery(document).ready(function(){
	jQuery("#announcements_creation").validationEngine();
	jQuery("#bulletin_validation").validationEngine();
	$('#newtableid').DataTable();
	$('#newtableids').DataTable();
	
});
$(document).ready(function(){
		   var dates = $( "#open_date, #close_date" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		/*minDate:" date('d-m-Y');",
		maxDate:"<?php //echo $futureDate;?>",*/
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "open_date" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
											}
									});

});

function publishtype(){
	if(document.getElementById('public').checked==true){
                document.getElementById('add_secorg').style.display='none';
                document.getElementById('org_info').style.display='none';	
                document.getElementById('add_organization').style.display='none';
                document.getElementById('add_organization_hierarchy').style.display='none';
                document.getElementById('update_org').style.display='none';
                document.getElementById('update_learner').style.display='none';                
                document.getElementById('inner_head').style.display='none';
		}else if(document.getElementById('secure').checked==true){
                        document.getElementById('add_secorg').style.display='block';
                        document.getElementById('org_info').style.display='block';
                        //document.getElementById('update_org').style.display='none';
                        //document.getElementById('update_learner').style.display='none';                          
			}
	}
        
function publishtype_create(){
    if(document.getElementById('public').checked==true){
                document.getElementById('add_secorg').style.display='none';	
                document.getElementById('add_organization').style.display='none';
                document.getElementById('add_organization_hierarchy').style.display='none';
                document.getElementById('org_info').innerHTML="";
                document.getElementById('inner_head').style.display='none';     
		}else if(document.getElementById('secure').checked==true){
                        document.getElementById('add_secorg').style.display='block';
                        document.getElementById('org_info').style.display='block';
                        document.getElementById('org_info').innerHTML="<table class='table table-striped table-bordered table-hover'><thead><tr><th>Organization Name</th><thcclass='hidden-480'>Learner Group</th><th ></th></tr></thead><tbody><tr><td>No data found.</td></tr></tbody></table>";
			}
    
}
function viewanniuncement(){
	window.location=BASE_URL+"/admin/announcements";
        }
 function dateformat(){
		var stdate=document.getElementById('open_date').value;
		var enddate=document.getElementById('close_date').value;
		var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
                if(stdate!=''){
                // Match the date format through regular expression
                if(stdate.match(dateformat)){
                    //document.form1.text1.focus();
                    //Test which seperator is used '/' or '-'
                    var opera1 = stdate.split('/');
                    var opera2 = stdate.split('-');
                    lopera1 = opera1.length;
                    lopera2 = opera2.length;
                    // Extract the string into month, date and year
                    if (lopera1>1){
                        var pdate = stdate.split('/');
                    }
                    else if (lopera2>1){
                        var pdate = stdate.split('-');
                    }
                    var dd = parseInt(pdate[0]);
                    var mm  = parseInt(pdate[1]);
                    var yy = parseInt(pdate[2]); 
                    // Create list of days of a month [assume there is no leap year by default]
                    var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
                    if (mm==1 || mm>2){
                        if (dd>ListofDays[mm-1]){
                            alertify.alert('Invalid date format!');
                            return false;
                        }
                    }
                    if (mm==2){
                        var lyear = false;
                        if ( (!(yy % 4) && yy % 100) || !(yy % 400)){
                            lyear = true;
                        }
                        if ((lyear==false) && (dd>=29)){
                            alertify.alert('Invalid date format!');
                            return false;
                        }
                        if ((lyear==true) && (dd>29)){
                            alertify.alert('Invalid date format!');
                            return false;
                        }
                    }
                }
                else{
                    alertify.alert("Invalid date format!");
                    //document.form1.text1.focus();
                    return false;
                }
				if(yy<1900){
					alertify.alert("Invalid date format!");
                    return false;
					}
                }
				
			 if(enddate!=''){
                // Match the date format through regular expression
                if(enddate.match(dateformat)){
                    //document.form1.text1.focus();
                    //Test which seperator is used '/' or '-'
                    var opera1 = enddate.split('/');
                    var opera2 = enddate.split('-');
                    lopera1 = opera1.length;
                    lopera2 = opera2.length;
                    // Extract the string into month, date and year
                    if (lopera1>1){
                        var pdate = enddate.split('/');
                    }
                    else if (lopera2>1){
                        var pdate = enddate.split('-');
                    }
                    var dd = parseInt(pdate[0]);
                    var mm  = parseInt(pdate[1]);
                    var yy = parseInt(pdate[2]);
                    // Create list of days of a month [assume there is no leap year by default]
                    var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
                    if (mm==1 || mm>2){
                        if (dd>ListofDays[mm-1]){
                            alertify.alert('Invalid date format!');
                            return false;
                        }
                    }
                    if (mm==2){
                        var lyear = false;
                        if ( (!(yy % 4) && yy % 100) || !(yy % 400)){
                            lyear = true;
                        }
                        if ((lyear==false) && (dd>=29)){
                            alertify.alert('Invalid date format!');
                            return false;
                        }
                        if ((lyear==true) && (dd>29)){
                            alertify.alert('Invalid date format!');
                            return false;
                        }
                    }
                }
                else{
                    alertify.alert("Invalid date format!");
                    //document.form1.text1.focus();
                    return false;
                }
				if(yy<1900){
					alertify.alert("Invalid date format!");
                    return false;
					}
                }
				var dt2= stdate;
			var arrDt2 = dt2.split('-')
			var date2=arrDt2[2] + "-" + arrDt2[1] + "-" + arrDt2[0];
			
			var dt= enddate;
			var arrDt = dt.split('-')
			var date1=arrDt[2] + "-" + arrDt[1] + "-" + arrDt[0];
			if(stdate!='' && enddate!=''){
				if (date2>date1){
					alertify.alert("End date should be greater than start date");
					return false;
				}
			}
	}
        
function change_secure_create(){
     // To fetch organization details from .php page
     var organization=organiz.split(',');
     var org='';
     for(var i=0;i<organization.length;i++){     
         organization1=organization[i];
         organization2=organization1.split('*');
         if(org==''){
         org="<option value='"+organization2[0]+"'>"+organization2[1]+"</option>";
     }
     else{
         org=org+"<option value='"+organization2[0]+"'>"+organization2[1]+"</option>";
     }
     }
      // To fetch Learner Groups from .php page
        var lnr_grp=learner_grp.split(',');
        var learner_groups='';
        for(var i=0;i<lnr_grp.length;i++){
            lnr_grp1=lnr_grp[i];
            lnr_grp2=lnr_grp1.split('*');
            if(lnr_grp2[0]!=0){
            if(learner_groups==''){
                learner_groups="<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }else{
                learner_groups=learner_groups+"<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }
        }
        }
     var secure=document.getElementById('inclusion_type').value;
     if(secure=='W'){
         document.getElementById('add_organization').style.display='block';
         document.getElementById('inner_head').style.display='block';
         document.getElementById('inner_head').innerHTML="<div class='Innerhead' style='margin-top:3px;display: block;'><font color='#2679b5'><b>Work Details</b></font></div>";
         document.getElementById('organization').innerHTML="<input type='hidden' name='child_ids' id='child_ids' value=''>Organization:<select name='organization_id' id='organization_id' class='validate[required] mediumselect'><option value=''>Select</option>"+org+"</select><select name='learner_group_id' id='learner_group_id' style='display:none;'><option value=''>Select</option></select>&nbsp;&nbsp;&nbsp;<input type='checkbox'  name='chk' id='chk'  value='' onclick='include_hierarchy()'>&nbsp;Include Child Hierarchy";
     }
     else if(secure=='L'){
         document.getElementById('add_organization').style.display='block';
         document.getElementById('inner_head').style.display='block';
         document.getElementById('inner_head').innerHTML="<div class='Innerhead' style='margin-top:3px;display: block;'><font color='#2679b5'><b>Learner Group Details</b></font></div>";
         document.getElementById('organization').innerHTML="Learner Group:<select name='learner_group_id' id='learner_group_id' class='validate[required] mediumselect'><option value=''>Select</option>"+learner_groups+"</select>";
         document.getElementById('organization_hierarchy_name').style.display='none';
         document.getElementById('organization_hierarchy').style.display='none';
     }
     else{
         document.getElementById('add_organization').style.display='none'; 
         document.getElementById('add_organization_hierarchy').style.display='none';
         document.getElementById('inner_head').style.display='none';      
     }

}
        
 function change_secure(){     
      // To fetch organization details from .php page
     var organization=organiz.split(',');
     var org='';
     for(var i=0;i<organization.length;i++){     
         organization1=organization[i];
         organization2=organization1.split('*');
         if(org==''){
         org="<option value='"+organization2[0]+"'>"+organization2[1]+"</option>";
     }
     else{
         org=org+"<option value='"+organization2[0]+"'>"+organization2[1]+"</option>";
     }
     }
      // To fetch Learner Groups from .php page
        var lnr_grp=learner_grp.split(',');
        var learner_groups='';
        for(var i=0;i<lnr_grp.length;i++){
            lnr_grp1=lnr_grp[i];
            lnr_grp2=lnr_grp1.split('*');
            if(lnr_grp2[0]!=0){
            if(learner_groups==''){
                learner_groups="<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }else{
                learner_groups=learner_groups+"<option value='"+lnr_grp2[0]+"'>"+lnr_grp2[1]+"</option>";
            }
        }
        }
     var secure=document.getElementById('inclusion_type').value;
     if(secure=='W'){
         document.getElementById('add_organization').style.display='block';
         document.getElementById('inner_head').style.display='block';
         document.getElementById('inner_head').innerHTML="<div class='Innerhead' style='margin-top:3px;display: block;'><font color='#2679b5'><b>Work Details</b></font></div>";
         document.getElementById('organization').innerHTML="<input type='hidden' name='child_ids' id='child_ids' value=''>Organization:<select name='organization_id' id='organization_id' class='validate[required, ajax[ajaxAnnouncementOrg]] mediumselect'><option value=''>Select</option>"+org+"</select>&nbsp;&nbsp;&nbsp;<input type='checkbox'  name='chk' id='chk'  value='' onclick='include_hierarchy()'>&nbsp;Include Child Hierarchy";
         document.getElementById('update_inclusions').style.display='none';
     }
     else if(secure=='L'){
         document.getElementById('add_organization').style.display='block';
         document.getElementById('inner_head').style.display='block';
         document.getElementById('inner_head').innerHTML="<div class='Innerhead' style='margin-top:3px;display: block;'><font color='#2679b5'><b>Learner Group Details</b></font></div>";
         document.getElementById('organization').innerHTML="Learner Group:<select name='learner_group_id' id='learner_group_id' class='validate[required, ajax[ajaxAnnouncementLearnerGroup]] mediumselect'><option value=''>Select</option>"+learner_groups+"</select><select name='organization_id' id='organization_id' style='display:none;'><option value=''>Select</option></select><select name='org_structure_id' id='org_structure_id' style='display:none;'><option value=''>Select</option></select>";
         document.getElementById('organization_hierarchy_name').style.display='none';
         document.getElementById('organization_hierarchy').style.display='none';
         document.getElementById('update_inclusions').style.display='none';
     }
     else{
          document.getElementById('add_organization').style.display='none'; 
          document.getElementById('add_organization_hierarchy').style.display='none';
          document.getElementById('inner_head').style.display='none';
          document.getElementById('update_learner').style.display='none';
          document.getElementById('update_inclusions').style.display='none';
         //
         //document.getElementById('organization').style.display='none';
         //document.getElementById('organization_hierarchy_name').style.display='none';
         // document.getElementById('organization_hierarchy').style.display='none';         
     }
 }
 
 function include_hierarchy(){
    var child=document.getElementById('chk');
    var orgid=document.getElementById('organization_id').value;
    if(orgid==''){
        alertify.alert("Please Select Organization to include all Reporting Organizations for the announcement");
        document.getElementById('chk').checked=false;
        return false;
    }
    if(child.checked===true){
         // To fetch organization Hierarchy details from .php page
    var lnr_dat=learner_hier.split(',');
    var learner_heirarchy='';
    for(var i=0;i<lnr_dat.length;i++){
        learn1=lnr_dat[i];
        learn2=learn1.split('*');
        if(learn2[0]!=''){
        if(learner_heirarchy==''){
            learner_heirarchy="<option value='"+learn2[0]+"'>"+learn2[1]+"</option>";
        }else{
            learner_heirarchy=learner_heirarchy+"<option value='"+learn2[0]+"'>"+learn2[1]+"</option>";
        }
    }
    }
        document.getElementById('add_organization_hierarchy').style.display='block';
        document.getElementById('organization_hierarchy_name').innerHTML="Hierarchy Name&nbsp;&nbsp;&nbsp;&nbsp;";
        document.getElementById('organization_hierarchy').innerHTML="<select name='org_structure_id' id='org_structure_id' class='validate[required] mediumselect' onchange='include_childs()'><option value=''>Select</option>"+learner_heirarchy+"</select><br />";
    }
    else{
         document.getElementById('add_organization_hierarchy').style.display='none';
		document.getElementById('organization_hierarchy_name').innerHTML="";
        document.getElementById('organization_hierarchy').innerHTML="";
        document.getElementById('child_ids').value="";
    }
 }
 
 function include_hierarchy_update(){
     var child=document.getElementById('chk');
     if(child.checked==true){
         document.getElementById('update_hierarchy').style.display='block';
     }else{
         document.getElementById('update_hierarchy').style.display='none';
     }
 }
 
 function include_childs(){    
     var org_id=document.getElementById('organization_id').value;
     var hier_id=document.getElementById('org_structure_id').value;
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

function delete_announ_inclusion(id){
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
             document.getElementById('announ_inclu_'+id).style.display='none';
             document.getElementById('update_inclusions').style.display='none';
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/delete_announcement_inclusion?id="+id,true);
     xmlhttp.send();
}

function update_announ_inclusion(in_id){
     // To fetch organization details from .php page
     var restriction=sec.split(',');
     var secu='';
     for(var i=0;i<restriction.length;i++){     
         restriction1=restriction[i];
         restriction2=restriction1.split('*');
         if(secu==''){
         secu="<option value='"+restriction2[0]+"'>"+restriction2[1]+"</option>";
     }
     else{
         secu=secu+"<option value='"+restriction2[0]+"'>"+restriction2[1]+"</option>";
     }
     }
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
             document.getElementById('add_secorg').innerHTML="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Restriction Type:<select name='inclusion_type' id='inclusion_type' onchange='change_secure()'><option value=''>Select</option>"+secu+"</select>";
             document.getElementById('inner_head').style.display='none'; 
             document.getElementById('add_organization').style.display='none';
             document.getElementById('add_organization_hierarchy').style.display='none';
             document.getElementById('update_inclusions').style.display='block';
             document.getElementById('update_inclusions').innerHTML=xmlhttp.responseText;
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/update_announcement_inclusion?in_id="+in_id,true);
     xmlhttp.send();
}

	
function addnew(){
	window.location=BASE_URL+"/admin/createannouncements";
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
			var code=document.getElementById("bulletin_topic_id["+b+"]").value;
			if(code!=""){
				$.ajax({
					url: BASE_URL+"/admin/delete_bulletin_data",
					global: false,
					type: "POST",
					data: ({bulletin_topic_id : code}),
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
	
}

function open_quiz(){
	if(document.getElementById('test_yes').checked==true){
		document.getElementById('quiz').style.display='block';
	}
	else if(document.getElementById('test_no').checked==true){
		document.getElementById('quiz').style.display='none';
	}
	
}

function open_price(){
	if(document.getElementById('price_avail_yes').checked==true){
		document.getElementById('price').style.display='block';
	}
	else if(document.getElementById('price_avail_no').checked==true){
		document.getElementById('price').style.display='none';
	}
	
}


