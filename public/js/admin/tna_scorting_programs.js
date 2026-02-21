//Start of Script for TNA Setup
$(document).ready(function(){
	$('#tna').validationEngine();
	$('#tna_form').validationEngine();
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeYear: true, changeMonth: true });
	$('.scrollable_table').each(function () {
		var $this = $(this);
		$(this).ace_scroll({
			size: $this.data('height') || 300,
			//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
		});
	});
});


function open_other_programs(tna_id,id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('other_programs').innerHTML="<img style='padding-left:250px;' src='"+BASE_URL+"/public/images/outsell_loading.gif'/>";
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('other_programs').innerHTML=xmlhttp.responseText;
			$('.scrollable_table_other').each(function () {
				var $this = $(this);
				$(this).ace_scroll({
					size: $this.data('height') || 300,
					//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
				});
			});
			$('.scrollable_table_programs').each(function () {
				var $this = $(this);
				$(this).ace_scroll({
					size: $this.data('height') || 300,
					//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
				});
			});
		}
	}
	
	xmlhttp.open("GET",BASE_URL+"/admin/scorting_program_details?tna_id="+tna_id+"&c_id="+id,true);
	xmlhttp.send();
}

function open_category_program(){
	var cat_id=document.getElementById('cat_id').value;
	var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('cat_program').innerHTML="loading..."
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('cat_program').innerHTML=xmlhttp.responseText;
		}
	}
	
	xmlhttp.open("GET",BASE_URL+"/admin/scorting_program_category_new?cat_id="+cat_id,true);
	xmlhttp.send();
}

function tna_program_validation(){
	
}

