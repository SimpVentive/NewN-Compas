<style>
.col-lg-21 {
    width: 20%;
}
</style>
<div class="content">

	
	<div class="row">
		<?php
		$anchorcom="onclick='getasesstotal(\"\")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'";
		?>
		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" <?php echo $anchorcom; ?>>
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class=""><?php echo $total_emp['total_emp']; ?></span></span>
										<span class="weight-500 uppercase-font block font-13">Total Employees</span>
									</div>
									
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getasesscompt("")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class=""><?php echo $total_cemp['total_cemp']; ?></span></span>
										<span class="weight-500 uppercase-font block font-13"># Completed Employees</span>
									</div>
									
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-12" onclick='getasesspend("")'  style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'>
			<div class="panel panel-default card-view pa-0">
				<div class="panel-wrapper collapse in">
					<div class="panel-body pa-0">
						<div class="sm-data-box">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
										<span class="txt-dark block counter"><span class=""><?php echo ($total_emp['total_emp'])-($total_cemp['total_cemp']); ?></span></span>
										<span class="weight-500 uppercase-font block font-13"># Pending Employees</span>
									</div>
									
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						
						<h6 class="panel-title txt-dark">Assessment information Location wise </h6>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div  class="panel-body">
						<div class='table-responsive'>
							<table class='table table-hover table-bordered mb-0' cellspacing='1' cellpadding='1' id='thetable'>
								<thead>
									<tr>
										<th style='width:10px;'>S.No</th>
										<th style='width:150px;'>Location Name </th>
										<th style='width:150px;'>Emp mapped</th>
										<th style='width:150px;'>Emp Completed</th>
										<th style='width:150px;'>Pending Employees</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$total_emp=$total_cemp=0;
								foreach($loc_names as $s=>$loc_name){
									$total_emp_loc=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as loc_total_emp FROM `uls_assessment_employees` a left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and b.assessment_status='A' and a.location_id=".$loc_name['location_id']);
									$total_emp+=$total_emp_loc['loc_total_emp'];
									
									$comp_emp_loc=UlsMenu::callpdorow("SELECT count(distinct(a.employee_id)) as loc_total_emp FROM `uls_utest_attempts_assessment` a 
									left join(SELECT `assessment_id`,`position_id`,`employee_id`,`location_id` FROM `uls_assessment_employees`) e on e.assessment_id=a.assessment_id and a.employee_id=e.employee_id
									left join(SELECT `assessment_id`,`ass_methods`,assessment_status FROM `uls_assessment_definition`) b on a.assessment_id=b.assessment_id WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and b.ass_methods='Y' and a.status='A' and b.assessment_status='A' and e.location_id=".$loc_name['location_id']);
									$total_cemp+=$comp_emp_loc['loc_total_emp'];
								?>
									<tr>
										<td><?php echo $s+1; ?></td>
										<td><?php echo $loc_name['location_name'];?></td>
										<td><a href="#" onclick="getasesstotal(<?php echo $loc_name['location_id'];?>);" style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'><?php echo $total_emp_loc['loc_total_emp']; ?></a></td>
										<td><a href="#" onclick="getasesscompt(<?php echo $loc_name['location_id'];?>);" style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'><?php echo $comp_emp_loc['loc_total_emp']; ?></a></td>
										<td><a href="#" onclick="getasesspend(<?php echo $loc_name['location_id'];?>);" style='color:blue;cursor: pointer;' data-toggle='modal' data-target='.bs-example-modal-lg'><?php echo $total_emp_loc['loc_total_emp']-$comp_emp_loc['loc_total_emp']; ?></a></td>
									</tr>
								<?php 
								}
								?>
								<tr>
									<td></td>
									<td></td>
									<td style="background-color:green;"><b style="color:white"><?php echo $total_emp; ?></b></td>
									<td style="background-color:green;"><b style="color:white"><?php echo $total_cemp; ?></b></td>
									<td style="background-color:green;"><b style="color:white"><?php echo $total_emp-$total_cemp; ?></b></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg" style="width:1400px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabel">Competency attached Positions</h5>
			</div>
			<div class="modal-body">
				<div id="txtHint" style="margin: 15px;">
				
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>



<script>
function assessement_sector(){
	var id=document.getElementById('ass_sector').value;
	if(id!=''){
		location.href=BASE_URL+"/admin/agel_dashboard?id="+id;
	}
	
}

function assessement_area(){
	var id=document.getElementById('ass_sector').value;
	var aid=document.getElementById('ass_area').value;
	if(id==''){
		toastr.error("Please Select Cluster.");
		return false;
	}
	if(id!=''){
		var aid=document.getElementById('ass_area').value;
		location.href=BASE_URL+"/admin/agel_dashboard?id="+id+"&aid="+aid;
	}
}
function open_location_assessor(id){
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
			document.getElementById('result_data').innerHTML=xmlhttp.responseText;
			$('#owl_demo_4').owlCarousel({
				margin:20,
				nav:true,
				autoplay:true,
				responsive:{
					0:{
						items:1
					},
					280:{
						items:2
					},
					480:{
						items:4
					},
					800:{
						items:6
					},
					
					
				}
			});
			$('#owl_demo_5').owlCarousel({
				margin:20,
				nav:true,
				autoplay:true,
				responsive:{
					0:{
						items:1
					},
					280:{
						items:2
					},
					480:{
						items:4
					},
					800:{
						items:8
					},
					
				}
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessor_location_details?loc_id="+id,true);
	xmlhttp.send();	
	
}

function open_assessor_assessment(loc_id,id){
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
			document.getElementById('result_ass_data').innerHTML=xmlhttp.responseText;
			
			$('#owl_demo_5').owlCarousel({
				margin:20,
				nav:true,
				autoplay:true,
				responsive:{
					0:{
						items:1
					},
					280:{
						items:2
					},
					480:{
						items:4
					},
					800:{
						items:8
					},
					
				}
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessment_assessor_details?loc_id="+loc_id+"&ass_id="+id,true);
	xmlhttp.send();	
	
}

function open_assessor_assessment_employees(loc_id,assr_id,aloc_id,as_id){
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
			document.getElementById('result_assessment_data').innerHTML=xmlhttp.responseText;
			let button = document.querySelector("#ass_download_excel");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#assessor_data");
			  TableToExcel.convert(table);
			});
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/assessor_mapped_assessment_details?loc_id="+loc_id+"&ass_id="+assr_id+"&assl_id="+aloc_id+"&sec_id="+as_id,true);
	xmlhttp.send();	
	
}

function open_tobeassessed(id){
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
			
			document.getElementById('result_data').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/agel_tobe_assessement?loc_id="+id,true);
	xmlhttp.send();	
	
}
function open_assessed(id){
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
			
			document.getElementById('result_data').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/agel_assessed_assessement?loc_id="+id,true);
	xmlhttp.send();	
	
}
function open_report(id){
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
			
			document.getElementById('result_data').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/report_assessement?loc_id="+id,true);
	xmlhttp.send();	
	
}
function getasesstotal(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Total employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_total_employees?id="+id, true);
	xmlhttp.send();
}
function getasesstotalcluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Total employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_total_employees?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}
function getasesscompt(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Completed employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_comp");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_comp");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_completed_employees?id="+id, true);
	xmlhttp.send();
}
function getasesscomptcluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Completed employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_comp");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_comp");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_completed_employees?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}
function getasesspend(id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Pending employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_pen");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_pen");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_pending_employees_new?id="+id, true);
	xmlhttp.send();
}
function getasesspendcluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Pending employees";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_pen");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_pen");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_pending_employees?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}
function getassessor_details(){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Assessor Details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_ass");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_ass");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_assessor_details", true);
	xmlhttp.send();
}
function getassessor_details_cluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Assessor Details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_ass");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_ass");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_assessor_details?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}
function getassessor_assessed(){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Employee Assessed Details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_assd");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_assd");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_emp_assessed_details", true);
	xmlhttp.send();
}
function getassessor_assessed_cluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Employee Assessed Details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_assd");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_assd");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_emp_assessed_details?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}
function getassessor_pen_assessed(){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Assessed pending employees details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_passd");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_passd");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_emp_pending_assessed_details", true);
	xmlhttp.send();
}
function getassessor_pen_assessed_cluster(id,bu_id){
	document.getElementById("txtHint").innerHTML ="";
	document.getElementById("myLargeModalLabel").innerHTML ="Assessed pending employees details";
	//document.getElementById("followdes").innerHTML ="Following are the Employees";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint").innerHTML = this.responseText;
			let button = document.querySelector("#download_excel_passd");
			button.addEventListener("click", e => {
			  let table = document.querySelector("#edit_datable_2_passd");
			  TableToExcel.convert(table);
			});
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/get_agel_cluster_emp_pending_assessed_details?id="+id+"&b_id="+bu_id, true);
	xmlhttp.send();
}



</script>
