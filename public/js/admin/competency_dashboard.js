$(document).ready(function(){
    $('#dashboard').validationEngine();
	$('.daterangepicker.dropdown-menu').css('display','none');
	$('#datable_2').DataTable();
});


function getasesspos(comp_id,scale_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Mapped Positions";
	document.getElementById("followdes").innerHTML ="Following are the Positions";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_comp_pos?comp_id="+comp_id+"&scale_id="+scale_id, true);
	xmlhttp.send();
}

function getasessemp(comp_id,scale_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Mapped Employees";
	document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_comp_employees?comp_id="+comp_id+"&scale_id="+scale_id, true);
	xmlhttp.send();
}

function getasessanalysis(comp_id,scale_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Competency Analysis";
	document.getElementById("followdes").innerHTML ="Following are the Analysis";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_comp_analysis?comp_id="+comp_id+"&scale_id="+scale_id, true);
	xmlhttp.send();
}



