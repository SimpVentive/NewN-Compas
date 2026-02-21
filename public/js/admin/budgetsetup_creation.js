jQuery(document).ready(function(){
	jQuery("#budget_period").validationEngine();
	
	
});

$(document).ready(function(){
    $('.date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
    $("#budget_type").change(function(){
  var x=0;
    var val=document.getElementById('budget_type').value;	
	if(val == 'M'){ 
		var x=11;
	}
	else if(val == 'Q'){
		var x=3;
    }
	else if(val == 'H'){
		var x=1;
    }
	else if(val == 'A'){
		var x=0;
    }
	
	var tbl = document.getElementById("budget_table").innerHTML="<table class='table table-striped table-bordered table-hover' name='period_table' id='period_table' ><thead><tr><th>Period Name</th><th>From</th><th>To</th></tr></thead></table>";

	for(var y=0; y<=x; y++){
		$("#period_table").append("<tr id='innertable"+y+"'><td><input type='text' name='period_name[]' id='period_name_"+y+"' value='' class='validate[required,funcCall[checknotinteger]] mediumtext' /></td><td><input type='text' name='month[]' id='month_"+y+"' class='validate[required] date-picker2 mediumtext' readonly='readonly'/></td><td><div id='monthto["+y+"]'><input type='text' name='month_to[]' id='month_to_"+y+"' class='validate[required] date-picker2 mediumtext' readonly='readonly'/></div></td></tr>");
		if(val == 'M'){ 
		$(function() {
		 $('.date-picker2').datepicker( {
        changeMonth: true,
        changeYear: true,
		yearRange: '2013:2023',
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) {
			var tb1=document.getElementById('period_table'); 
			var lastRow=tb1.rows.length; 
			var lastRow1=lastRow-2; 
			var id=$(this).attr('id');
			id=id.split("_");
			//alertify.alert(id);
			for(i=0;i<=lastRow1;i++){ 	
			
			if(i==0){
			var from="#month_"+i;
			var month="month_"+i;
			var year="year_"+i;			
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();  
			$(from).datepicker('setDate', new Date(year, month, 1)); 
			}
			else if(i>=1){
				k=i-1;
				var from="#month_"+i;
				var month="month_"+i;
				var year="year_"+i;				
				var months1="month_"+k;
				var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				var jj=parseInt(months1);
				month=parseInt(months1)+1;
				if(month>11){
					month=month-12;
					year=parseInt(year)+1;
				}
				else{
					month=month; year=year;
				}				
				$(from).datepicker('setDate', new Date(year, month, 1));
			}
			var to="#month_to_"+i;
			var month_to="month_to_"+i;
			var year_to="year_to_"+i; 
			month_to=parseInt(month)+0;
			if(month_to>11){
				month_to=month_to-12;
				year_to=parseInt(year)+1;
			}
			else{
				month_to=month_to; year_to=year;
			}
			//alertify.alert(month+" "+year+" "+id+" "+to+" "+month2);
			$(to).datepicker('setDate', new Date(year_to, month_to, 1));
			}
		}
								  });
				   });
		}
		else if(val == 'Q'){
				$(function() {
		 $('.date-picker2').datepicker( {
        changeMonth: true,
        changeYear: true,
		yearRange: '2013:2023',
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) {
			var tb1=document.getElementById('period_table'); 
			var lastRow=tb1.rows.length; 
			var lastRow1=lastRow-2; 
			var id=$(this).attr('id');
			id=id.split("_");
			//alertify.alert(id);
			for(i=0;i<=lastRow1;i++){ 	
			
			if(i==0){
			var from="#month_"+i;
			var month="month_"+i;
			var year="year_"+i;			
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();  
			$(from).datepicker('setDate', new Date(year, month, 1)); 
			}
			else if(i>=1){
				k=i-1;
				var from="#month_"+i;
				var month="month_"+i;
				var year="year_"+i;				
				var months1="month_"+k;
				var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				var jj=parseInt(months1);
				month=parseInt(months1)+1;
				if(month>11){
					month=month-12;
					year=parseInt(year)+1;
				}
				else{
					month=month; year=year;
				}				
				$(from).datepicker('setDate', new Date(year, month, 1));
			}
			var to="#month_to_"+i;
			var month_to="month_to_"+i;
			var year_to="year_to_"+i; 
			month_to=parseInt(month)+2;
			if(month_to>11){
				month_to=month_to-12;
				year_to=parseInt(year)+1;
			}
			else{
				month_to=month_to; year_to=year;
			}
			//alertify.alert(month+" "+year+" "+id+" "+to+" "+month2);
			$(to).datepicker('setDate', new Date(year_to, month_to, 1));
			}
		}
								  });
				   });	
		}
		else if(val == 'H'){
					$(function() {
		 $('.date-picker2').datepicker( {
        changeMonth: true,
        changeYear: true,
		yearRange: '2013:2023',
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) {
			var tb1=document.getElementById('period_table'); 
			var lastRow=tb1.rows.length; 
			var lastRow1=lastRow-2; 
			var id=$(this).attr('id');
			id=id.split("_");
			//alertify.alert(id);
			for(i=0;i<=lastRow1;i++){ 	
			
			if(i==0){
			var from="#month_"+i;
			var month="month_"+i;
			var year="year_"+i;			
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();  
			$(from).datepicker('setDate', new Date(year, month, 1)); 
			}
			else if(i>=1){
				k=i-1;
				var from="#month_"+i;
				var month="month_"+i;
				var year="year_"+i;				
				var months1="month_"+k;
				var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				var jj=parseInt(months1);
				month=parseInt(months1)+1;
				if(month>11){
					month=month-12;
					year=parseInt(year)+1;
				}
				else{
					month=month; year=year;
				}				
				$(from).datepicker('setDate', new Date(year, month, 1));
			}
			var to="#month_to_"+i;
			var month_to="month_to_"+i;
			var year_to="year_to_"+i; 
			month_to=parseInt(month)+5;
			if(month_to>11){
				month_to=month_to-12;
				year_to=parseInt(year)+1;
			}
			else{
				month_to=month_to; year_to=year;
			}
			//alertify.alert(month+" "+year+" "+id+" "+to+" "+month2);
			$(to).datepicker('setDate', new Date(year_to, month_to, 1));
			}
		}
								  });
				   });
		}
		else if(val == 'A'){
					$(function() {
		 $('.date-picker2').datepicker( {
        changeMonth: true,
        changeYear: true,
		yearRange: '2013:2023',
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) {
			var tb1=document.getElementById('period_table'); 
			var lastRow=tb1.rows.length; 
			var lastRow1=lastRow-2; 
			var id=$(this).attr('id');
			id=id.split("_");
			//alertify.alert(id);
			for(i=0;i<=lastRow1;i++){ 	
			
			if(i==0){
			var from="#month_"+i;
			var month="month_"+i;
			var year="year_"+i;			
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();  
			$(from).datepicker('setDate', new Date(year, month, 1)); 
			}
			else if(i>=1){
				k=i-1;
				var from="#month_"+i;
				var month="month_"+i;
				var year="year_"+i;				
				var months1="month_"+k;
				var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				var jj=parseInt(months1);
				month=parseInt(months1)+1;
				if(month>11){
					month=month-12;
					year=parseInt(year)+1;
				}
				else{
					month=month; year=year;
				}				
				$(from).datepicker('setDate', new Date(year, month, 1));
			}
			var to="#month_to_"+i;
			var month_to="month_to_"+i;
			var year_to="year_to_"+i; 
			month_to=parseInt(month)+11;
			if(month_to>11){
				month_to=month_to-12;
				year_to=parseInt(year)+1;
			}
			else{
				month_to=month_to; year_to=year;
			}
			//alertify.alert(month+" "+year+" "+id+" "+to+" "+month2);
			$(to).datepicker('setDate', new Date(year_to, month_to, 1));
			}
		}
								  });
				   });
		}
	}
    });
    
});

function change_value(){
  var x=0;
    var val=document.getElementById('budget_type').value;	
	if(val == 'M'){ 
		var x=11;
	}
	else if(val == 'Q'){
		var x=3;
    }
	else if(val == 'H'){
		var x=1;
    }
	else if(val == 'A'){
		var x=0;
    }
	
	var tbl = document.getElementById("budget_table").innerHTML="<table class='table table-striped table-bordered table-hover' name='period_table' id='period_table' ><thead><tr><th>Period Name</th><th>From</th><th>To</th></tr></thead></table>";

	for(var y=0; y<=x; y++){
		$("#period_table").append("<tbody><tr id='innertable"+y+"'><td><input type='text' name='period_name[]' id='period_name_"+y+"' value='' class='validate[required,funcCall[checknotinteger]] mediumtext'/></td><td><input type='text' name='month[]' id='month_"+y+"' class='validate[required] date-picker2 mediumtext' readonly='readonly'/></td><td><div id='monthto["+y+"]'><input type='text' name='month_to[]' id='month_to_"+y+"' class='validate[required] date-picker2 mediumtext' readonly='readonly'/></div></td></tr></tbody>");
		if(val == 'M'){ 
		$(function() {
		 $('.date-picker2').datepicker( {
        changeMonth: true,
        changeYear: true,
		yearRange: '2013:2023',
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) {
			var tb1=document.getElementById('period_table'); 
			var lastRow=tb1.rows.length; 
			var lastRow1=lastRow-2; 
			var id=$(this).attr('id');
			id=id.split("_");
			//alertify.alert(id);
			for(i=0;i<=lastRow1;i++){ 	
			
			if(i==0){
			var from="#month_"+i;
			var month="month_"+i;
			var year="year_"+i;			
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();  
			$(from).datepicker('setDate', new Date(year, month, 1)); 
			}
			else if(i>=1){
				k=i-1;
				var from="#month_"+i;
				var month="month_"+i;
				var year="year_"+i;				
				var months1="month_"+k;
				var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				var jj=parseInt(months1);
				month=parseInt(months1)+1;
				if(month>11){
					month=month-12;
					year=parseInt(year)+1;
				}
				else{
					month=month; year=year;
				}				
				$(from).datepicker('setDate', new Date(year, month, 1));
			}
			var to="#month_to_"+i;
			var month_to="month_to_"+i;
			var year_to="year_to_"+i; 
			month_to=parseInt(month)+0;
			if(month_to>11){
				month_to=month_to-12;
				year_to=parseInt(year)+1;
			}
			else{
				month_to=month_to; year_to=year;
			}
			//alertify.alert(month+" "+year+" "+id+" "+to+" "+month2);
			$(to).datepicker('setDate', new Date(year_to, month_to, 1));
			}
		}
								  });
				   });
		}
		else if(val == 'Q'){
				$(function() {
		 $('.date-picker2').datepicker( {
        changeMonth: true,
        changeYear: true,
		yearRange: '2013:2023',
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) {
			var tb1=document.getElementById('period_table'); 
			var lastRow=tb1.rows.length; 
			var lastRow1=lastRow-2; 
			var id=$(this).attr('id');
			id=id.split("_");
			//alertify.alert(id);
			for(i=0;i<=lastRow1;i++){ 	
			
			if(i==0){
			var from="#month_"+i;
			var month="month_"+i;
			var year="year_"+i;			
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();  
			$(from).datepicker('setDate', new Date(year, month, 1)); 
			}
			else if(i>=1){
				k=i-1;
				var from="#month_"+i;
				var month="month_"+i;
				var year="year_"+i;				
				var months1="month_"+k;
				var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				var jj=parseInt(months1);
				month=parseInt(months1)+1;
				if(month>11){
					month=month-12;
					year=parseInt(year)+1;
				}
				else{
					month=month; year=year;
				}				
				$(from).datepicker('setDate', new Date(year, month, 1));
			}
			var to="#month_to_"+i;
			var month_to="month_to_"+i;
			var year_to="year_to_"+i; 
			month_to=parseInt(month)+2;
			if(month_to>11){
				month_to=month_to-12;
				year_to=parseInt(year)+1;
			}
			else{
				month_to=month_to; year_to=year;
			}
			//alertify.alert(month+" "+year+" "+id+" "+to+" "+month2);
			$(to).datepicker('setDate', new Date(year_to, month_to, 1));
			}
		}
								  });
				   });	
		}
		else if(val == 'H'){
					$(function() {
		 $('.date-picker2').datepicker( {
        changeMonth: true,
        changeYear: true,
		yearRange: '2013:2023',
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) {
			var tb1=document.getElementById('period_table'); 
			var lastRow=tb1.rows.length; 
			var lastRow1=lastRow-2; 
			var id=$(this).attr('id');
			id=id.split("_");
			//alertify.alert(id);
			for(i=0;i<=lastRow1;i++){ 	
			
			if(i==0){
			var from="#month_"+i;
			var month="month_"+i;
			var year="year_"+i;			
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();  
			$(from).datepicker('setDate', new Date(year, month, 1)); 
			}
			else if(i>=1){
				k=i-1;
				var from="#month_"+i;
				var month="month_"+i;
				var year="year_"+i;				
				var months1="month_"+k;
				var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				var jj=parseInt(months1);
				month=parseInt(months1)+1;
				if(month>11){
					month=month-12;
					year=parseInt(year)+1;
				}
				else{
					month=month; year=year;
				}				
				$(from).datepicker('setDate', new Date(year, month, 1));
			}
			var to="#month_to_"+i;
			var month_to="month_to_"+i;
			var year_to="year_to_"+i; 
			month_to=parseInt(month)+5;
			if(month_to>11){
				month_to=month_to-12;
				year_to=parseInt(year)+1;
			}
			else{
				month_to=month_to; year_to=year;
			}
			//alertify.alert(month+" "+year+" "+id+" "+to+" "+month2);
			$(to).datepicker('setDate', new Date(year_to, month_to, 1));
			}
		}
								  });
				   });
		}
		else if(val == 'A'){
					$(function() {
		 $('.date-picker2').datepicker( {
        changeMonth: true,
        changeYear: true,
		yearRange: '2013:2023',
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) {
			var tb1=document.getElementById('period_table'); 
			var lastRow=tb1.rows.length; 
			var lastRow1=lastRow-2; 
			var id=$(this).attr('id');
			id=id.split("_");
			//alertify.alert(id);
			for(i=0;i<=lastRow1;i++){ 	
			
			if(i==0){
			var from="#month_"+i;
			var month="month_"+i;
			var year="year_"+i;			
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();  
			$(from).datepicker('setDate', new Date(year, month, 1)); 
			}
			else if(i>=1){
				k=i-1;
				var from="#month_"+i;
				var month="month_"+i;
				var year="year_"+i;				
				var months1="month_"+k;
				var months1 = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				var jj=parseInt(months1);
				month=parseInt(months1)+1;
				if(month>11){
					month=month-12;
					year=parseInt(year)+1;
				}
				else{
					month=month; year=year;
				}				
				$(from).datepicker('setDate', new Date(year, month, 1));
			}
			var to="#month_to_"+i;
			var month_to="month_to_"+i;
			var year_to="year_to_"+i; 
			month_to=parseInt(month)+11;
			if(month_to>11){
				month_to=month_to-12;
				year_to=parseInt(year)+1;
			}
			else{
				month_to=month_to; year_to=year;
			}
			//alertify.alert(month+" "+year+" "+id+" "+to+" "+month2);
			$(to).datepicker('setDate', new Date(year_to, month_to, 1));
			}
		}
								  });
				   });
		}
	}
}
function cancel_update(){
	window.location=BASE_URL+"/admin/period_details";
}

function delete_period(bud_id){
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
                            document.getElementById('name_'+bud_id).style.display="none";
				 }
		 }
		 xmlhttp.open("GET",BASE_URL+"/admin/delete_period?bud_id="+bud_id,true);
		 xmlhttp.send();
}