$(document).ready(function(){
    $('#dashboard').validationEngine();
	$('.daterangepicker.dropdown-menu').css('display','none');
	$('#datable_2').DataTable();
});

function pcc_graph(){
	var from_date=document.getElementById('from_date').value;
	var to_date=document.getElementById('to_date').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	//alert(xmlhttp.responseText);			
			var output="<img src='"+BASE_URL+"/public/dashboard_graphs/graph_pcc.png'>";
			document.getElementById("graphs").innerHTML=output;
			//location.reload();
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/dashboard_graph?fromdate="+from_date+"&todate="+to_date,true);
	xmlhttp.send();
	
}

function OI_graph(){
	var online=document.getElementById('online').value;
	var classroom=document.getElementById('classroom').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	xmlhttp.responseText;
			document.getElementById("OIgraph").value=xmlhttp.responseText;
			var dashboard_chart = new FusionCharts(BASE_URL+"/public/charts/Pie3D.swf", "graphs", "700", "260", "0", "0");
			dashboard_chart.setDataXML(document.getElementById('OIgraph').value);
			dashboard_chart.render("graphs");
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/dashboard_OI_graph?online="+online+"&classroom="+classroom,true);
	xmlhttp.send();
}

function getlocassesspos(emptype,bu,loc){
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
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
			if(loc==""){
				document.getElementById("updateddiv").innerHTML=xmlhttp.responseText;
			}
			else{
				document.getElementById("updateddivloc").innerHTML=xmlhttp.responseText;
			}
			$('#datable_1').DataTable({"aaSorting": [  [2,'desc'], [6,'desc'], [0,'asc'] ]});
			$('#datable_2').DataTable();
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/getlocassesspos?emptype="+emptype+"&bu="+bu+"&loc="+loc,true);
	xmlhttp.send();
}

function getassessyr(emptype,bu,loc){
	var year=document.getElementById("year").value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
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
			document.getElementById("assesstable").innerHTML=xmlhttp.responseText;
			$('#datable_2').DataTable();
			$('[data-toggle="tooltip"]').tooltip();
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/getassesspos?emptype="+emptype+"&bu="+bu+"&loc="+loc+"&year="+year,true);
	xmlhttp.send();
}

function getasesspos(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Assessed Positions";
	document.getElementById("followdes").innerHTML ="Following are the Positions";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/getasesspos?id=" + id, true);
	xmlhttp.send();
}

function getasessposemp(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Assessed Employees";
	document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/getasessposemp?id=" + id, true);
	xmlhttp.send();
}

function getposdet(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Positions";
	document.getElementById("followdes").innerHTML ="Following are the position details";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/getposdet?id=" + id, true);
	xmlhttp.send();
}

function loc_prog_graph(){
	var from_date=document.getElementById('from_date').value;
	var to_date=document.getElementById('to_date').value;
	var location=document.getElementById('location').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	//alert(xmlhttp.responseText);
			var output="<img src='"+BASE_URL+"/public/dashboard_graphs/graph_lp.png'>";
			document.getElementById("graphs").innerHTML=output;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/dashboard_LP_graph?fromdate="+from_date+"&todate="+to_date+"&location="+location,true);
	xmlhttp.send();
	
}
function getemployeetype(){
	var id=document.getElementById("employeetype").value;
	location.href=BASE_URL+"/admin/dashboard?emp_type="+id;
}
function getassementques(){
	var id=document.getElementById("employeetype").value;
	var competencies=document.getElementById('competencies').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
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
			document.getElementById("dashboarddata").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/dashboarddata?id="+id+"&competencies="+competencies,true);
	xmlhttp.send();
}


/**
 * Options for Bar chart
 */
var barOptions = {
	responsive:true
};
var ctx = document.getElementById("barOptions").getContext("2d");
new Chart(ctx, {type: 'bar', data: barData, options:barOptions});

var barOption_position = {
	responsive:true
};
var ctx = document.getElementById("barOption_position").getContext("2d");
new Chart(ctx, {type: 'bar', data: barData_position, options:barOption_position});