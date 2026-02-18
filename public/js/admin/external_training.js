$(document).ready(function(){
    $('#external_training').validationEngine();	
    	
	$('#empatt').ace_scroll({
		size:300,
		mouseWheelLock: true,
		alwaysVisible : true
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

function AddRow()
{
	var tbl = document.getElementById("attachment_table");
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
	$("#attachment_table").append("<tr id='innertable"+sub_iteration+"'><td style='padding-left:20px;'><input type='hidden' name='attachment_id[]' id='attachment_id["+sub_iteration+"]' value=''><input type='checkbox' name='select_check[]' id='select_check_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><input class='mediumtext' type='text' name='attachment_name[]' id='attachment_name["+sub_iteration+"]' value='' style='width:192px;' maxlength='80' /></td><td><input type='hidden' name='attachment_id[]' id='attachment_id["+sub_iteration+"]' value='0' /><input class='mediumtext' type='text' name='attachment_type[]' id='attachment_type["+sub_iteration+"]' value='' style='width:92px;' maxlength='20'/></td><td><input class='validate[custom[allfiles]]' type='file' name='fileupload[]' id='fileupload["+sub_iteration+"]' value='"+sub_iteration+"' style='width:175px;' /></td><td></td></tr>");
    if(document.getElementById(hiddtab).value!=''){
        var ins=document.getElementById(hiddtab).value;
        document.getElementById(hiddtab).value=ins+","+sub_iteration;
    }
    else{
        document.getElementById(hiddtab).value=sub_iteration;
    }
}

function DeleteRow()
{
	var ins=document.getElementById('inner_hidden_id').value;
	var arr1=ins.split(",");
       var flag=0;
       var tbl = document.getElementById('attachment_table');
       var lastRow = tbl.rows.length;
       for(var i=(arr1.length-1); i>=0; i--){
           var bb=arr1[i];
           var a="select_check_"+bb+"";
           if(document.getElementById(a).checked){
               var b=document.getElementById(a).value;
               var c="innertable"+b+"";
                var attachmentid=document.getElementById("attachment_id["+b+"]").value;
                if(attachmentid!=' '){
                    $.ajax({
                        url: BASE_URL+"/admin/delete_program_attachments",
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