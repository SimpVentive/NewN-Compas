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
	var count=document.getElementById('scale_number').value;
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
			cell0.innerHTML= "<label name='val[]'>"+(iteration)+"</label><input type='hidden' name='scale_id[]' id='scale_id"+(iteration-1)+"'><input type='hidden' name='val[]' id='val' value='"+(iteration)+"'/>";
			var year = row.insertCell(1);
			year.innerHTML="<input type='text' class='validate[required] form-control' name='scale_name[]' id='scale_name"+(iteration)+"' data-prompt-position='topLeft'/>";	
		}
	
	var hiddtab="exp_hidden_id";
	var ins=document.getElementById(hiddtab).value;
		var ins1=ins.split(",");
		var temp=new Array();
		var maxa=Math.max(ins1);
		for( var j=0;j<count;j++){
				temp.push(j);
		}
		sub_iteration=temp;
		document.getElementById(hiddtab).value=sub_iteration;
	}
	else{
		alert("No more records will be added");
		return false;
	}
}

function AddExpenses_validation(){
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
			var item_type=document.getElementById('scale_name'+i+'').value;
			if(item_type==''){
				toastr.error("Please Enter Level Name");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('scale_name'+l+'').value;
					if(k!=j){
						if(item_type==item_type2){
							toastr.error("Level Name already Exists");
							return false;
						}
					}
				}
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
}



 