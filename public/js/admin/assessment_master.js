$(document).ready(function(){
	$('#assessment_master').validationEngine();
	$('#datepicker').datepicker();
});


$(document).ready(function(){
    $('#rating_div').hide();
	$('#self_div').hide(); 	
    $('#assessment_type').change(function(){
        if($('#assessment_type').val() == 'ASS') {
            $('#rating_div').show(); 
			$('#self_div').hide();
        } else {
            $('#rating_div').hide();
			$('#self_div').show();	
        } 
    });
	$('#ass_comp_selection').change(function(){
        if($('#ass_comp_selection').val() == 'Y') {
            $('#comp_div').show(); 
        } else {
            $('#comp_div').hide();
        } 
    });
	$('#ass_pro_selection').change(function(){
        if($('#ass_pro_selection').val() == 'Y') {
            $('#pro_div').show(); 
        } else {
            $('#pro_div').hide();
        } 
    });
});


$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#stdate, #enddate" ).datepicker({dateFormat:"yy-mm-dd",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	minDate:"",
	maxDate:difDays,
	//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
	//buttonImageOnly: true,
	onSelect: function( selectedDate ) { 
	var option = this.id === "stdate" ? "minDate" : "maxDate",
	instance = $( this ).data( "datepicker" ),
	date = $.datepicker.parseDate(
	instance.settings.dateFormat ||
	$.datepicker._defaults.dateFormat,
	selectedDate, instance.settings );
	dates.not( this ).datepicker( "option", option, date );
	}
	});				   
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
		}
	}
	else{
		$("#information_li").addClass('active');
		$('#infomation-info').addClass('active');
		$('#competency-info').removeClass('active');
	} 
});



function addsource_details_position(){
	var hiddtab="addgroup_position";
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
			var position_id=document.getElementById('position_id'+i).value;
			var pos_status=document.getElementById('assessment_pos_status'+i).value;
			if(position_id==''){
				toastr.error("Please Select Position Name.");
				return false;
			}
			if(pos_status==''){
				toastr.error("Please Select Position Status.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var position_id1=document.getElementById('position_id'+l).value;
				if(k!=j){
					if(position_id==position_id1){
						toastr.error("Position name should be Unique");
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
    
	if(pos_details!=''){
        var pos_detail=pos_details.split(',');
        var pos_ids='';
        for(var i=0;i<pos_detail.length;i++){
            cat1=pos_detail[i];
            cat2=cat1.split('*');
            if(pos_ids==''){
                pos_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                pos_ids=pos_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        pos_ids='';
    }
	
	if(status_details!=''){
        var status_detail=status_details.split(',');
        var status_ids='';
        for(var i=0;i<status_detail.length;i++){
            cat1=status_detail[i];
            cat2=cat1.split('*');
            if(status_ids==''){
                status_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                status_ids=status_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        status_ids='';
    }
	
	$("#assessement_position").append("<tr id='subgrd_position"+sub_iteration+"'><td><input type='checkbox' id='chkbox"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='assessment_pos_id"+sub_iteration+"' name='assessment_pos_id[]' value=''></td><td><select name='position_id[]' id='position_id"+sub_iteration+"' class='form-control m-b' onchange='position_version("+sub_iteration+");'><option value=''>Select</option>"+pos_ids+"</select></td><td><select class='form-control m-b' name='version_id[]' id='version_id"+sub_iteration+"'><option value=''>Select</option></select></td><td><select name='assessment_pos_status[]' id='assessment_pos_status"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+status_ids+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}

}

function position_version(id){ 
	var pos_id=document.getElementById('position_id'+id).value;
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
			
			document.getElementById('version_id'+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/position_version_details?pos_id="+pos_id,true);
	xmlhttp.send();	
	
}
function delete_position(){
	var hiddtab="addgroup_position";
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('assessement_position');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		var a="chkbox"+bb;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd_position"+bb+"";
			//alert(b);
			var assessment_pos_id=document.getElementById("assessment_pos_id"+bb).value;
			//alert(calendar_act_id);
			if(assessment_pos_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_assessment_position",
					global: false,
					type: "POST",
					data: ({val : assessment_pos_id}),
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

function addsource_details_position_validation(){
	var hiddtab="addgroup_position";
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
			var position_id=document.getElementById('position_id'+i).value;
			var pos_status=document.getElementById('assessment_pos_status'+i).value;
			if(position_id==''){
				toastr.error("Please Select Position Name.");
				return false;
			}
			if(pos_status==''){
				toastr.error("Please Select Position Status.");
				return false;
			}
			for( var k=0;k<ins1.length;k++){
				l=ins1[k];
				var position_id1=document.getElementById('position_id'+l).value;
				if(k!=j){
					if(position_id==position_id1){
						toastr.error("Position name should be Unique");
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
	if(pos_details!=''){
        var pos_detail=pos_details.split(',');
        var pos_ids='';
        for(var i=0;i<pos_detail.length;i++){
            cat1=pos_detail[i];
            cat2=cat1.split('*');
            if(pos_ids==''){
                pos_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                pos_ids=pos_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        pos_ids='';
    }
	
	if(status_details!=''){
        var status_detail=status_details.split(',');
        var status_ids='';
        for(var i=0;i<status_detail.length;i++){
            cat1=status_detail[i];
            cat2=cat1.split('*');
            if(status_ids==''){
                status_ids="<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }else{
                status_ids=status_ids+"<option value='"+cat2[0]+"'>"+cat2[1]+"</option>";
            }
        }
    }else{
        status_ids='';
    }
	$("#assessement_position").append("<tr id='subgrd_position"+sub_iteration+"'><td><input type='checkbox' id='chkbox"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='assessment_pos_id"+sub_iteration+"' name='assessment_pos_id[]' value=''></td><td><select name='position_id[]' id='position_id"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+pos_ids+"</select></td><td><select name='assessment_pos_status[]' id='assessment_pos_status"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option>"+status_ids+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
	
						return false;
	}	
    
}

