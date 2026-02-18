$(document).ready(function(){
    $('#definition_form').validationEngine();	
	/* $('#empatt').ace_scroll({
		size:300,
		mouseWheelLock: true,
		alwaysVisible : true
	}); */
});
$(document).ready(function(){
    $('#participants_form').validationEngine();
	$('#attachments_form').validationEngine();
    $('#atctivity_form').validationEngine();
    $('#photos_form').validationEngine();
});

jQuery(document).ready(function() {
	$('#partcipants_li').click(function(){
		$('#partcipants_li').addClass('active');
		$('#attachments_li').removeClass('active');
		$('#activities_li').removeClass('active');
		$('#photos_li').removeClass('active');
		$('#participants').show();
		$('#attachments').hide();
		$('#activities').hide();
		$('#photos').hide();
	});
	$('#attachments_li').click(function(){
		$('#attachments_li').addClass('active');
		$('#partcipants_li').removeClass('active');
		$('#activities_li').removeClass('active');
		$('#photos_li').removeClass('active');
		$('#attachments').show();
		$('#participants').hide();
		$('#activities').hide();
		$('#photos').hide();
	});
	$('#activities_li').click(function(){
		$('#activities_li').addClass('active');
		$('#partcipants_li').removeClass('active');
		$('#attachments_li').removeClass('active');
		$('#photos_li').removeClass('active');
		$('#activities').show();
		$('#participants').hide();
		$('#attachments').hide();
		$('#photos').hide();
	});
	$('#photos_li').click(function(){
		$('#photos_li').addClass('active');
		$('#attachments_li').removeClass('active');
		$('#partcipants_li').removeClass('active');
		$('#activities_li').removeClass('active');
		$('#photos').show();
		$('#attachments').hide();
		$('#participants').hide();
		$('#activities').hide();
		
	});
	
});

$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		
		maxDate:difDays,
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
});


function add_participants()
{
	
	// To fetch emp Details from lms_admin_eee.php page
    if(super_val!=''){
        var superid=super_val.split(',');
        var supervisors='';
        for(var i=0;i<superid.length;i++){
            sup1=superid[i];
            sup2=sup1.split('*');
            if(supervisors==''){
                supervisors="<option value='"+sup2[0]+"'>"+sup2[1]+"</option>";
            }else{
                supervisors=supervisors+"<option value='"+sup2[0]+"'>"+sup2[1]+"</option>";
            }
        }
    }
    else{
        supervisors='';
    } 
	
	var tbl = document.getElementById("partcipant_table");
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
				var par_number=document.getElementById('participant_number_'+i).value;
				var number=par_number.toUpperCase();
				if(par_number==''){
                   alertify.alert("Please Enter Number");
                   return false;
                }
				
					// for( var k=0;k<ins1.length;k++){
                        // l=ins1[k];
						// var par_number1=document.getElementById('participant_number_'+i).value;
                        // var number2=par_number1.toUpperCase();
                        // if(k!=j){
                            // if(number.trim()==number2.trim()){
                               // alertify.alert("Number already used");
                               // return false;
                            // }
						// }
				    // }
				
			}
			sub_iteration=parseInt(temp)+1;
	}
	else {
        sub_iteration=1;
        ins1=1;
        var ins1=Array(1);
    }
	
	$("#partcipant_table").append("<tr id='innertable"+sub_iteration+"'><td style='padding-left:20px;'><input type='hidden' name='participant_id[]' id='participant_id["+sub_iteration+"]' value=''><input type='checkbox' name='select_check[]' id='select_check_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><select class='supervisor mediumselect chosen-select' name='participant_number[]' id='participant_number_"+sub_iteration+"' onchange='employee_details(this,"+sub_iteration+")' style='width:40px'><option value=''>Select</option>"+supervisors+"</select></td><td><input class='mediumtext' type='text' name='remarks[]' id='remarks["+sub_iteration+"]' value='' style='width:200px;' maxlength='20'/></td><td><input type='hidden' id='empid_"+sub_iteration+"' name='empid[]' value=''><a href='#empdetails' data-toggle='modal' onclick='get_employee("+sub_iteration+")'>Employee Details</a></td></tr>");
	var config = {
        '.chosen-select': {}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
	$("#participant_number_"+sub_iteration).ajaxChosen({
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});

	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=40){w=40;}
		$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');
	
    if(document.getElementById(hiddtab).value!=''){
        var ins=document.getElementById(hiddtab).value;
        document.getElementById(hiddtab).value=ins+","+sub_iteration;
    }
    else{
        document.getElementById(hiddtab).value=sub_iteration;
    }
}

function delete_participants()
{
	var ins=document.getElementById('inner_hidden_id').value;
	var arr1=ins.split(",");
    var flag=0;
    var tbl = document.getElementById('partcipant_table');
       var lastRow = tbl.rows.length;
       for(var i=(arr1.length-1); i>=0; i--){
           var bb=arr1[i];
           var a="select_check_"+bb+"";
           if(document.getElementById(a).checked){
               var b=document.getElementById(a).value;
               var c="innertable"+b+"";
			   //alert(b);
                var partcipantid=document.getElementById("participant_id["+b+"]").value;
                if(partcipantid!=' '){
                    $.ajax({
                        url: BASE_URL+"/admin/delete_eee_participant",
                        global: false,
                        type: "POST",
                        data: ({val : partcipantid}),
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

function add_attachments()
{
	var tbl = document.getElementById("attachment_table");
	var lastRow = tbl.rows.length;
    var lastrow1= lastRow+1;
    var hiddtab="inner_hidden_id_a";
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
				var attach_mat=document.getElementById('attachment_name['+i+']').value;
				var att1=attach_mat.toUpperCase();
				var type=document.getElementById('attachment_type['+i+']').value;
				var att_typ1=type.toUpperCase();
			    var filename=document.getElementById('fileupload['+i+']').value;
				if(attach_mat==''){
                   alertify.alert("Please Enter AttachMent Name");
                   return false;
                }
				
					for( var k=0;k<ins1.length;k++){
                        l=ins1[k];
						var attach_mat2=document.getElementById('attachment_name['+l+']').value;
                        var att2=attach_mat2.toUpperCase();
                        var type2=document.getElementById('attachment_type['+l+']').value;
                        var att_typ2=type2.toUpperCase();
						var filename2=document.getElementById('fileupload['+l+']').value;
						var files=filename.replace(" ","_");
						if(k!=j){
                            if(att1.trim()==att2.trim() && att_typ1.trim()==att_typ2.trim()){
                               alertify.alert("Attachment Name with same Type Already Exists");
                               return false;
                            }
						}
				    }
				
			}
			sub_iteration=parseInt(temp)+1;
	}
	else {
        sub_iteration=1;
        ins1=1;
        var ins1=Array(1);
    }
	$("#attachment_table").append("<tr id='innertablea"+sub_iteration+"'><td style='padding-left:20px;'><input type='hidden' name='attachment_id[]' id='attachment_id["+sub_iteration+"]' value=''><input type='checkbox' name='select_check_a[]' id='select_check_a_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><input class='mediumtext' type='text' name='attachment_name[]' id='attachment_name["+sub_iteration+"]' value='' maxlength='80' /></td><td><input type='hidden' name='attachment_id[]' id='attachment_id["+sub_iteration+"]' value='0' /><input class='mediumtext' type='text' name='attachment_type[]' id='attachment_type["+sub_iteration+"]' value='' style='width:92px;' maxlength='20'/></td><td><input class='validate[custom[allfiles]]' type='file' name='fileupload[]' id='fileupload["+sub_iteration+"]' value='"+sub_iteration+"' style='width:175px;' /></td><td></td></tr>");
    if(document.getElementById(hiddtab).value!=''){
        var ins=document.getElementById(hiddtab).value;
        document.getElementById(hiddtab).value=ins+","+sub_iteration;
    }
    else{
        document.getElementById(hiddtab).value=sub_iteration;
    }
}

function delete_attachments()
{
	var ins=document.getElementById('inner_hidden_id_a').value;
	var arr1=ins.split(",");
       var flag=0;
       var tbl = document.getElementById('attachment_table');
       var lastRow = tbl.rows.length;
       for(var i=(arr1.length-1); i>=0; i--){
           var bb=arr1[i];
           var a="select_check_a_"+bb+"";
           if(document.getElementById(a).checked){
               var b=document.getElementById(a).value;
               var c="innertablea"+b+"";
                var attachmentid=document.getElementById("attachment_id["+b+"]").value;
                if(attachmentid!=' '){
                    $.ajax({
                        url: BASE_URL+"/admin/delete_eee_attachment",
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
       document.getElementById('inner_hidden_id_a').value=arr1;
}

function add_activities()
{
	var tbl = document.getElementById("activity_table");
	var lastRow = tbl.rows.length;
    var lastrow1= lastRow+1;
    var hiddtab="inner_hidden_id_ac";
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
				var activity=document.getElementById('activity_name['+i+']').value;
				var att1=activity.toUpperCase();
				var number=document.getElementById('no_participants['+i+']').value;
				var numbers=number.toUpperCase();
			    
				if(activity==''){
                   alertify.alert("Please Enter Activity Name");
                   return false;
                }
				
					for( var k=0;k<ins1.length;k++){
                        l=ins1[k];
						var activity1=document.getElementById('activity_name['+l+']').value;
                        var att2=activity1.toUpperCase();
                        var number2=document.getElementById('no_participants['+l+']').value;
                        var numbers2=number2.toUpperCase();
					}
				
			}
			sub_iteration=parseInt(temp)+1;
	}
	else {
        sub_iteration=1;
        ins1=1;
        var ins1=Array(1);
    }
	$("#activity_table").append("<tr id='innertableac"+sub_iteration+"'><td style='padding-left:20px;'><input type='hidden' name='activity_id[]' id='activity_id["+sub_iteration+"]' value=''><input type='checkbox' name='select_check_ac[]' id='select_check_ac_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><input class='mediumtext' type='text' name='activity_name[]' id='activity_name["+sub_iteration+"]' value=''  maxlength='80' /></td><td><input class='mediumtext' type='text' name='no_participants[]' id='no_participants["+sub_iteration+"]' value='' style='width:92px;' maxlength='20'/></td><td><input class='mediumtext' type='text' name='winner[]' id='winner["+sub_iteration+"]' value='' style='width:175px;' /></td><td><input class='mediumtext' type='text' name='status[]' id='status["+sub_iteration+"]' value='' style='width:175px;' /></td><td><input class='mediumtext' type='text' name='comment[]' id='comment["+sub_iteration+"]' value='' style='width:175px;'/></td></tr>");
    if(document.getElementById(hiddtab).value!=''){
        var ins=document.getElementById(hiddtab).value;
        document.getElementById(hiddtab).value=ins+","+sub_iteration;
    }
    else{
        document.getElementById(hiddtab).value=sub_iteration;
    }
}

function delete_activities()
{
	var ins=document.getElementById('inner_hidden_id_ac').value;
	var arr1=ins.split(",");
       var flag=0;
       var tbl = document.getElementById('activity_table');
       var lastRow = tbl.rows.length;
       for(var i=(arr1.length-1); i>=0; i--){
           var bb=arr1[i];
           var a="select_check_ac_"+bb+"";
           if(document.getElementById(a).checked){
               var b=document.getElementById(a).value;
               var c="innertableac"+b+"";
                var attachmentid=document.getElementById("activity_id["+b+"]").value;
                if(attachmentid!=' '){
                    $.ajax({
                        url: BASE_URL+"/admin/delete_eee_activities",
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
       document.getElementById('inner_hidden_id_ac').value=arr1;

}


function add_photos()
{
	
	var tbl = document.getElementById("photoupload_tab");
	var lastRow = tbl.rows.length;
    var lastrow1= lastRow+1;
    var hiddtab="inner_hidden_id_p";
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
				var photo=document.getElementById('photo_name['+i+']').value;
				var number=photo.toUpperCase();
				
					for( var k=0;k<ins1.length;k++){
                        l=ins1[k];
						var par_number1=document.getElementById('photo_name['+i+']').value;
                        var number2=par_number1.toUpperCase();
                        if(k!=j){
                            if(number.trim()==number2.trim()){
                               alertify.alert("Photo Name already used");
                               return false;
                            }
						}
				    }
				
			}
			sub_iteration=parseInt(temp)+1;
	}
	else {
        sub_iteration=1;
        ins1=1;
        var ins1=Array(1);
    }
	
	$("#photoupload_tab").append("<tr id='innertablep"+sub_iteration+"'><td style='padding-left:20px;'><input type='hidden' name='photo_id[]' id='photo_id["+sub_iteration+"]' value=''><input type='checkbox' name='select_check_p[]' id='select_check_p_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><input class='mediumtext' type='text' name='photo_name[]' id='photo_name["+sub_iteration+"]' value='' /></td><td><input type='file' class='validate[required,custom[picture]]' style='width:175px;' id='photoupload["+sub_iteration+"]' name='photoupload[]' value=''></td><td></td><td></td></tr>");
	
    if(document.getElementById(hiddtab).value!=''){
        var ins=document.getElementById(hiddtab).value;
        document.getElementById(hiddtab).value=ins+","+sub_iteration;
    }
    else{
        document.getElementById(hiddtab).value=sub_iteration;
    }
}

function delete_photos()
{
	var ins=document.getElementById('inner_hidden_id_p').value;
	var arr1=ins.split(",");
    var flag=0;
    var tbl = document.getElementById('photoupload_tab');
       var lastRow = tbl.rows.length;
       for(var i=(arr1.length-1); i>=0; i--){
           var bb=arr1[i];
           var a="select_check_p_"+bb+"";
           if(document.getElementById(a).checked){
               var b=document.getElementById(a).value;
               var c="innertablep"+b+"";
			   //alert(b);
                var photoid=document.getElementById("photo_id["+b+"]").value;
                if(photoid!=' '){
                    $.ajax({
                        url: BASE_URL+"/admin/delete_eee_photos",
                        global: false,
                        type: "POST",
                        data: ({val : photoid}),
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
       document.getElementById('inner_hidden_id_p').value=arr1;
}

function employee_details(sel,id)
{
	var emp_id=sel.value;
	//alert(emp_id);
	document.getElementById('empid_'+id).value=emp_id;
}


function get_employee(id)
{
	var empid=document.getElementById('empid_'+id).value;
	var xmlhttp;
	if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
    }else{
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){                                
			document.getElementById('empdiv').innerHTML=xmlhttp.responseText;								
			
        }
    }
        xmlhttp.open("GET",BASE_URL+"/admin/get_emp_details?id="+empid,true);
        xmlhttp.send();
}

function get_photo(pid)
{
	//alert(pid);
	var xmlhttp;
	if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
    }else{
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){                                
			document.getElementById('imagediv').innerHTML=xmlhttp.responseText;								
			
        }
    }
        xmlhttp.open("GET",BASE_URL+"/admin/get_image?pid="+pid,true);
        xmlhttp.send();
}

$("#participant_number_0").ajaxChosen({
	   dataType: 'json',
	   type: 'POST',
	   url:BASE_URL+'/admin/autoemployee'
},{
	   loadingImg: 'loading.gif'
});

$(window).on('resize.chosen', function() {
	var w = $('.chosen-select').parent().width();
	if(w<=40){w=40;}
	$('.chosen-select').next().css({'width':w});
}).trigger('resize.chosen');
