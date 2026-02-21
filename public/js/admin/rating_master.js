$(document).ready(function(){
        $('#levelform').validationEngine();
		$('.datepicker').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
 });
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));	
	var dates = $( "#dob" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	minDate:"",
	maxDate:difDays
	});				   
}); 

 function readURL(input) {
     if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
             $('#blah').attr('src', e.target.result);
         }
         reader.readAsDataURL(input.files[0]);
     }
 }
 $(document).ready(function(){
     $("#imgInp").change(function(){
         readURL(this);
     });
 });
 
function open_table(){
	var count=document.getElementById('rating_scale').value;
	if(count==''){
		 alert("Please enter rating scale value");
		 return false;
	}
	if(count>10){
		
		/* document.getElementById("alertmsgnew").innerHTML="<div class='bs-example'><div class='alert alert-danger fade in'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button><strong>Attention!</strong>Please enter value between 2 to 10.</div></div>";
		document.getElementById("alertmsgnew").focus();
		 */ return false;
	}
	document.getElementById('ra_table').style.display="block";
		var table = document.getElementById('table');
		var rowCount = table.rows.length;
		var iteration = 0;
		var alpha=/^[A-Z][a-z ]+$/i;
		for(i=1;i<rowCount;i++){
			table.deleteRow(i);
				rowCount--;
				i--;
		}

	if(count>1 && rowCount<count){
		for(i=0;i<count;i++){
			iteration=i+1;
			var row = table.insertRow(iteration);
			var cell0=row.insertCell(0);
			cell0.innerHTML= "<label name='val[]'>"+iteration+"</label><input type='hidden' name='scale_id[]' id='scale_id"+iteration+"'><input type='hidden' name='val[]' id='val' value='"+iteration+"'/>";
			var year = row.insertCell(1);
			year.innerHTML="<input type='text' class='validate[required] form-control' name='rating_name_scale[]' id='rating_name_scale"+iteration+"' data-prompt-position='topLeft'/>";	
		}
	}
	else{
		alert("No more records will be added");
		return false;
	}
}


 