jQuery(document).ready(function(){
	jQuery("#gradeform").validationEngine();	
});

$(document).ready(function(){
	var dates = $( "#start_date_active, #end_date_active" ).datepicker({
		dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "start_date_active" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
/* 	$('.date-picker0').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '2013:2023',
		showButtonPanel: true,
		dateFormat: 'MM yy',
		onClose: function(selectedDate){
			var tb1=document.getElementById('training_table'); 
			var lastRow=tb1.rows.length; 
			var lastRow1=lastRow-2;
			var id=$(this).attr('id');
			id=id.split("_");

			var from="#month_0"; 
			var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val(); 
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val(); 
			month=parseInt(months1); 
			//var d=new Date(year, month+1, 12);
			//var m=d.getMonth();
			$(from).datepicker('setDate', new Date(year, month, 1));
			
			$("#month_to_0").datepicker("option", "minDate", selectedDate);
			var date = $(this).datepicker('getDate');
            alert(date);
			var maxDate = new Date(date.getFullYear(), date.getMonth() + 1, -0);
            $("#month_to_0").datepicker("option", "maxDate", maxDate);
			//$( "#month_to_0" ).datepicker( 'setDate', 'minDate' ,new Date(year, month+1, 1));

		}
	});
	
	$('.date-picker_0').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '2013:2023',
		showButtonPanel: true,
		dateFormat: 'MM yy',
		onClose: function(dateText, inst){
			var tb1=document.getElementById('training_table'); 
			var lastRow=tb1.rows.length; 
			var lastRow1=lastRow-2; 
			var id=$(this).attr('id');
			id=id.split("_");

			var to="#month_to_0";
			var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			month=parseInt(months1);
			$(to).datepicker('setDate', new Date(year, month, 1));

		}
	});	 */
	
	
	$.datepicker.setDefaults({
		changeMonth: true,
		changeYear: true,
		yearRange: '2013:2023',
		showButtonPanel: true,
		//dateFormat: 'dd-MM-yy',
		dateFormat: 'dd-MM-yy',
    });
    $('#month_0').datepicker({
			format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true,
        onClose: function(selectedDate) {
			var from="#month_0"; 
			var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val(); 
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val(); 
			month=parseInt(months1);
			
			/* var d=new Date(year, month);
			var m=d.getMonth();
			var y=d.getFullYear();
			alert(m);
			alert(y); */
			
			$(from).datepicker('setDate', new Date(year, month, 1));
			//$('#month_0').val('hi');
			
			var date = $(from).val();
            $('#month_to_0').datepicker('option', 'minDate', date);
        }
    });
    $('#month_to_0').datepicker({
		stepMonths: 0,
		format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true,
        onClose: function(selectedDate) {
			var to="#month_to_0";
			var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			month=parseInt(months1);
			$(to).datepicker('setDate', new Date(year, month, 1));
			
			var date = $(to).val();
            $('#month_0').datepicker('option', 'maxDate', date);
        }
    });
	
	
	$("#delete_row").on("click", function (){
		var ins=document.getElementById('trainingcount').value;
		var arr1=ins.split(",");
		var flag=0;
		var tbl = document.getElementById('training_table');
		var lastRow = tbl.rows.length;
		for(var i=(arr1.length-1); i>=0; i--){
			var bb=arr1[i];
			var a="checkgrade"+bb+"";
			if(document.getElementById(a).checked){
				var b=document.getElementById(a).value;
				//var c="expenses"+b+"";
				var expensesid=document.getElementById("gradeyearid"+b+"").value;
				if(expensesid!=' '){
					$.ajax({
						url: BASE_URL+"/admin/delete_grade_year",
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
				//$("#"+c).remove();
				$('#training_table tr').has('input[name="checkgrade"]:checked').remove();
			}
		}
		if(flag==0){
			toastr.error("Please select the Value to Delete");
			return false;
		}
		document.getElementById('trainingcount').value=arr1;
    });
	
});

function AddRow(){
	var table = document.getElementById('training_table');
	var rowCount = table.rows.length;
	var iteration=rowCount;
	var notecount=document.getElementById('trainingcount').value;
	inct=notecount.split(",");
	if(notecount!=""){
		for(var j=0;j<inct.length;j++){
			itw=inct[j];
			var from_month=document.getElementById('month_'+itw);		
			var to_month=document.getElementById('month_to_'+itw);
			var category=document.getElementById('category['+itw+']');
			var days=document.getElementById('tra_days['+itw+']');
			var numbers = /^[0-9]+$/;
			if(from_month.value==''){
				toastr.error("Please enter the Training year (from)");
				from_month.focus();
				return false;
			}
			else if(to_month.value==''){
				toastr.error("Please enter the Training year (to)");
				to_month.focus();
				return false;
			}
			else if(category.value==''){
				toastr.error("Please select category");
				category.focus();
				return false;
			}
			else if(days.value==''){
				toastr.error("Please enter the Training days");
				days.focus();
				return false;
			}	
			else if(!days.value.match(numbers)){
				toastr.error("Please enter only digits");
				days.focus();
				return false;
			}	
			
			for( var k=0;k<inct.length;k++){
				l=inct[k];
				var cat='category['+l+']';
				var month_f='month_'+l;
				var month_t='month_to_'+l;
				if(k!=j){
					var cats=category.value;
					var months_f=from_month.value;
					var months_t=to_month.value;
					var cats1=document.getElementById(cat).value;
					var months_f1=document.getElementById(month_f).value;
					var months_t2=document.getElementById(month_t).value;
					if(cats==cats1){
						if(months_f==months_f1 && months_t==months_t2){
							toastr.error("Category should not be same for the same selected time period");
							return false;
						}/* else if(months_f>=ss1 && session1<=ss2){
							document.getElementById('error_session').innerHTML="<div class='alert alert-dismissable alert-danger'><strong>Session details should not be same for the same selected day...!</strong></div>";
							document.getElementById(sess1).focus();
							return false;
						}else if(session2>=ss1 && session2<=ss2){
							document.getElementById('error_session').innerHTML="<div class='alert alert-dismissable alert-danger'><strong>Session details should not be same for the same selected day...!</strong></div>";
							document.getElementById(sess2).focus();
							return false;
						} */
					}
				}
			}
			
		}
	}
	var temp=0;
	for(var j=0;j<inct.length;j++){
		if(temp<parseInt(inct[j])){
			temp=parseInt(inct[j]);
		}
	}
	
	inct=parseInt(temp)+1;	
	
	if(notecount!=""){
		notecount=notecount+','+inct;
	}else{
		notecount=+inct;
	}
	document.getElementById('trainingcount').value=notecount;
	var row = table.insertRow(rowCount);
	notecount=notecount+','+inct;
	var cell0 = row.insertCell(0);
	var checkbox = document.createElement("input");
	checkbox.type = "checkbox";
	checkbox.id="checkgrade"+inct+"";
	checkbox.name="checkgrade";
	checkbox.value=""+inct+"";
	var textbox = document.createElement("input");
	textbox.type = "hidden";
	textbox.id="gradeyearid"+inct+"";
	textbox.name="gradeyearid[]";
	textbox.value="";
	cell0.appendChild(checkbox);
	cell0.appendChild(textbox);

	var cell1 = row.insertCell(1);
	var year_from = document.createElement("input");
	year_from.type = "text";
	year_from.className='date-picker'+inct+' form-control validate[custom[date2]]';
	year_from.readOnly=true;
	year_from.id="month_"+inct;
	year_from.name='month[]';
	cell1.appendChild(year_from);
	
	$(document).ready(function(){
		/* $('.date-picker'+inct+'').datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '2013:2023',
			showButtonPanel: true,
			dateFormat: 'MM yy',
			onClose: function(dateText, inst){
				var id=$(this).attr('id');
				id1=id.split("_");
				var from="#month_"+id1[1];
				var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				month=parseInt(months1);
				if(month>11){
					month=month-12;
					year=parseInt(year);
				}
				else{
					month=month; year=year;
				}
				$(from).datepicker('setDate', new Date(year, month, 1));
			}
		}); */
		
		
			$.datepicker.setDefaults({
				changeMonth: true,
				changeYear: true,
				yearRange: '2013:2023',
				showButtonPanel: true,
				dateFormat: 'dd-MM-yy',
			});
			$('#month_'+inct).datepicker({
				format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true,
				onClose: function(selectedDate) {
					var id=$(this).attr('id');
					id1=id.split("_");
					var from="#month_"+id1[1];
					//var from="#month_"+inct;
					var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val(); 
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val(); 
					month=parseInt(months1);
					$(from).datepicker('setDate', new Date(year, month, 1));
					
					var date = $(from).val();
					$('#month_to_'+inct).datepicker('option', 'minDate', date);
				}
			});
		
		
	});
	
	var cell2 = row.insertCell(2);
	var year_to = document.createElement("input");
	year_to.type = "text";
	year_to.className='date-picker_'+inct+' form-control validate[custom[date2],future[#month_'+inct+']]';
	year_to.readOnly=true;
	year_to.id="month_to_"+inct;
	year_to.name='month_to[]';
	cell2.appendChild(year_to);
	
	$(document).ready(function(){
		/* $('.date-picker_'+inct+'').datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '2013:2023',
			showButtonPanel: true,
			dateFormat: 'MM yy',
			onClose: function(dateText, inst){
				var id=$(this).attr('id');
				id1=id.split("_");
				var to="#month_to_"+id1[2];
				var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				month=parseInt(months1);
				if(month>11){
					month=month-12;
					year=parseInt(year);
				}
				else{
					month=month; year=year;
				}				
				$(to).datepicker('setDate', new Date(year, month, 1));
			}
		});	 */
		
		
		
			$.datepicker.setDefaults({
				changeMonth: true,
				changeYear: true,
				yearRange: '2013:2023',
				showButtonPanel: true,
				dateFormat: 'dd-MM-yy',
			});
			$('#month_to_'+inct).datepicker({
				format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true,
				stepMonths: 0,
				onClose: function(selectedDate) {
					var id=$(this).attr('id');
					id1=id.split("_");
					var to="#month_to_"+id1[2];
					//var to="#month_to_"+inct;
					var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					month=parseInt(months1);
					$(to).datepicker('setDate', new Date(year, month, 1));
					
					var date = $(to).val();
					$('#month_'+inct).datepicker('option', 'maxDate', date);
				}
			});
		
	});
	
	var cell3 = row.insertCell(3);
	var select = document.createElement("select");
	select.id="category["+inct+"]";
	select.name="category[]";
	select.className='form-control';
	// To fetch Expenses Status from .php page
    if(justfication!=''){
        var expst=justfication.split(',');
        for(var i=0;i<expst.length;i++){
            expst1=expst[i];
            expst2=expst1.split('*');
			select.options[i]=new Option(expst2[1],expst2[0]);
        }
    }	
	cell3.appendChild(select); 
	
	var cell4 = row.insertCell(4);
	var text = document.createElement("input");
	text.type="text";
	text.className='form-control';
	text.name = "tra_days[]";
	text.maxLength="2";
	text.id ="tra_days["+inct+"]";
	cell4.appendChild(text);	
}

function deleterow(){
	var tab=document.getElementById('trainingcount').value;
	var spli=tab.split(",");
	var len=spli.length;
	var flag=0;
	var table = document.getElementById('training_table');
	var rowCount = table.rows.length;
	for(var j=1; j<rowCount; j++){
		var row1 = table.rows[j];
		var chkbox2 = row1.cells[0].childNodes[0];
		if(null != chkbox2 && true == chkbox2.checked){
			flag++;
		}
	}
	
	if(rowCount>2){
		for(var i=0; i<=len; i++){
			itw=spli[i];
			var row = table.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(flag>0){
				if(null != chkbox && true == chkbox.checked){
					table.deleteRow(i);
					rowCount--;
					i--;
					flag++;spli.splice(i,1);
					len=spli.length;
				}
			}
			else if( flag == 0 ){
				toastr.error("Please Check Atleast One...!");
				return false;
			}
		}
	}
	document.getElementById("trainingcount").value=spli;
}

function validation(){	
	var hiddtab="subgradecount";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		if(ins1.length>1){
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=ins1[j];
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j]; 
			 var item_type=document.getElementById('sub_grade_name['+i+']').value;
			if(item_type==''){
				toastr.error("Please select Sub Grade Name");
				return false;
			}else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('sub_grade_name['+l+']').value;
					if(k!=j){
						if(item_type==item_type2){
							toastr.error("Sub Grade Name already selected");
							return false;
						}
					}
				}
			} 
		}	
		sub_iteration=parseInt(temp)+1; 
	}
}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}	
	var table = document.getElementById('training_table');
	var rowCount = table.rows.length;
	var iteration=rowCount;
	var notecount=document.getElementById('trainingcount').value;
	inct=notecount.split(",");
	if(notecount!=""){
		if(inct.length>1){
		for(var j=0;j<inct.length;j++){
			itw=inct[j];
			var from_month=document.getElementById('month_'+itw);		
			var to_month=document.getElementById('month_to_'+itw);
			var category=document.getElementById('category['+itw+']');
			var days=document.getElementById('tra_days['+itw+']');
			var numbers = /^[0-9]+$/;
			if(from_month.value!=''){
				if(to_month.value==''){
					toastr.error("Please enter the Training year (to)");
					to_month.focus();
					return false;
				}
				else if(category.value==''){
					toastr.error("Please select category");
					category.focus();
					return false;
				}
				else if(days.value==''){
					toastr.error("Please enter the Training days");
					days.focus();
					return false;
				}	
				else if(!days.value.match(numbers)){
					toastr.error("Please enter only digits");
					days.focus();
					return false;
				}
			}
			if(to_month.value!=''){
				if(from_month.value==''){
					toastr.error("Please enter the Training year (from)");
					from_month.focus();
					return false;
				}
				else if(category.value==''){
					toastr.error("Please select category");
					category.focus();
					return false;
				}
				else if(days.value==''){
					toastr.error("Please enter the Training days");
					days.focus();
					return false;
				}	
				else if(!days.value.match(numbers)){
					toastr.error("Please enter only digits");
					days.focus();
					return false;
				}
			}
			if(category.value!=''){
				if(from_month.value==''){
					toastr.error("Please enter the Training year (from)");
					from_month.focus();
					return false;
				}
				else if(to_month.value==''){
					toastr.error("Please enter the Training year (to)");
					to_month.focus();
					return false;
				}
				else if(days.value==''){
					toastr.error("Please enter the Training days");
					days.focus();
					return false;
				}	
				else if(!days.value.match(numbers)){
					toastr.error("Please enter only digits");
					days.focus();
					return false;
				}
			}	
			if(days.value!=''){
				if(!days.value.match(numbers)){
					toastr.error("Please enter only digits");
					days.focus();
					return false;
				}
				else if(from_month.value==''){
					toastr.error("Please enter the Training year (from)");
					from_month.focus();
					return false;
				}
				else if(to_month.value==''){
					toastr.error("Please enter the Training year (to)");
					to_month.focus();
					return false;
				}
				else if(category.value==''){
					toastr.error("Please select category");
					category.focus();
					return false;
				}
			}
			for( var k=0;k<inct.length;k++){
				l=inct[k];
				var cat='category['+l+']';
				var month_f='month_'+l;
				var month_t='month_to_'+l;
				if(k!=j){
					var cats=category.value;
					var months_f=from_month.value;
					var months_t=to_month.value;
					var cats1=document.getElementById(cat).value;
					var months_f1=document.getElementById(month_f).value;
					var months_t2=document.getElementById(month_t).value;
					if(cats==cats1){
						if(months_f==months_f1 && months_t==months_t2){
							toastr.error("Category should not be same for the same selected time period");
							return false;
						}/* else if(months_f>=ss1 && session1<=ss2){
							document.getElementById('error_session').innerHTML="<div class='alert alert-dismissable alert-danger'><strong>Session details should not be same for the same selected day...!</strong></div>";
							document.getElementById(sess1).focus();
							return false;
						}else if(session2>=ss1 && session2<=ss2){
							document.getElementById('error_session').innerHTML="<div class='alert alert-dismissable alert-danger'><strong>Session details should not be same for the same selected day...!</strong></div>";
							document.getElementById(sess2).focus();
							return false;
						} */
					}
				}
			}	
		}
	}
}
}

function AddGrade(){
	var hiddtab="subgradecount";
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
			 var item_type=document.getElementById('sub_grade_name['+i+']').value;
			if(item_type==''){
				toastr.error("Please select Sub Grade Name");
				return false;
			}else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('sub_grade_name['+l+']').value;
					if(k!=j){
						if(item_type==item_type2){
							toastr.error("Sub Grade Name already selected");
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
	// To fetch sub grade names from .php page
    if(grades!=''){
        var expst=grades.split(',');
        var subgrad='';
        for(var i=0;i<expst.length;i++){
            expst1=expst[i];
            expst2=expst1.split('*');
            if(subgrad==''){
                subgrad="<option value='"+expst2[0]+"'>"+expst2[1]+"</option>";
            }else{
                subgrad=subgrad+"<option value='"+expst2[0]+"'>"+expst2[1]+"</option>";
            }
        }
    }else{
        subgrad='';
    }
	// To fetch sub grade Status from .php page
    if(grade_staus!=''){
        var grdst=grade_staus.split(',');
        var subgradst='';
        for(var i=0;i<grdst.length;i++){
            expst1=grdst[i];
            expst2=expst1.split('*');
            if(subgradst==''){
                subgradst="<option value='"+expst2[0]+"'>"+expst2[1]+"</option>";
            }else{
                subgradst=subgradst+"<option value='"+expst2[0]+"'>"+expst2[1]+"</option>";
            }
        }
    }else{
        subgradst='';
    }
	
	$("#sub_grade_table").append("<tr id='subgrd"+sub_iteration+"'><td><input type='checkbox' id='subgrade"+sub_iteration+"' name='subgrade' value='"+sub_iteration+"'><input type='hidden' id='sub_grade_id"+sub_iteration+"' name='sub_grade_id[]' value=''></td><td><select name='sub_grade_name[]' id='sub_grade_name["+sub_iteration+"]' class='form-control m-b'><option value=''>Select</option>"+subgrad+"</select></td><td><select name='grade_status[]' id='grade_status["+sub_iteration+"]' class='form-control m-b'><option value=''>Select</option>"+subgradst+"</select></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
		
}
function DelGrade(){
	var ins=document.getElementById('subgradecount').value;
	//alert(ins);
	var arr1=ins.split(",");
	var flag=0;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="subgrade"+bb+"";
		//alert(a);
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd"+b+"";
			var seclocid=document.getElementById("sub_grade_id"+b+"").value;
			if(seclocid!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_subgrade",
					global: false,
					type: "POST",
					data: ({val : seclocid}),
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
		toastr.error("Please select the Value to Delete");
		return false;
	}
	document.getElementById('subgradecount').value=arr1;
}