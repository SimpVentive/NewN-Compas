<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					
					<form action="#" id="loginForm" class="form-horizontal">
						<div class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);"><label class="control-label mb-10 col-sm-2">Location Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
							<?php
							$security_location_id=@$this->session->userdata('security_location_id');
							if(!empty($security_location_id)){
								$loc_name=UlsLocation::getloc($security_location_id);
							?>
							<input type="hidden" name="location_id" id="location_id" value="<?php echo $security_location_id; ?>">
							<label class="control-label mb-10"><b><?php echo $loc_name['location_name']; ?></b></label>
							<?php
							}
							else{
							$loc_names=UlsMenu::callpdo("SELECT b.`location_id`,b.`location_name` FROM `uls_assessment_employee_dev_rating` a 
							left join(SELECT `location_id`,`location_name` FROM `uls_location`) b on a.location_id=b.location_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.location_id is not NULL group by a.location_id order by b.location_name ASC");
							?>
							<select id="location_id" name="location_id" class="validate[required] form-control m-b" data-prompt-position="topLeft" onchange="open_data_report();">
								<option value="">Select</option>
								<?php 
								foreach($loc_names as $loc_name){
									$select=!empty($security_location_id)?(($loc_name['location_id']==$security_location_id)?"selected=selected":""):"";
								?>
								<option value="<?php echo $loc_name['location_id'];?>" <?php echo $select; ?>><?php echo $loc_name['location_name'];?></option>
								<?php
								}
								?>
							</select>
							<?php 
							}
							?>
							</div>
						</div>
						<div class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);"><label class="control-label mb-10 col-sm-2">Department Name:</label>
							<div class="col-sm-5">
							<?php 
							$dap_name=!empty($security_location_id)?" and a.location_id=".$security_location_id:"";
							$org_names=UlsMenu::callpdo("SELECT b.`organization_id`,b.`org_name` FROM `uls_assessment_employee_dev_rating` a 
							left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.org_id=b.organization_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$dap_name."  group by a.org_id order by b.`org_name` ASC");
							?>
							<select id="orgid" name="orgid" class="form-control m-b" data-prompt-position="topLeft" onchange="open_employees();">
								<option value="">Select</option>
								<?php 
								foreach($org_names as $org_name){
								?>
								<option value="<?php echo $org_name['organization_id'];?>"><?php echo $org_name['org_name'];?></option>
								<?php
								}
								?>
							</select>
							</div>
						</div>
						<!--<div class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);"><label class="control-label mb-10 col-sm-2">Employee Name:</label>
							<div class="col-sm-5">
							<?php 
							$emp_name=!empty($security_location_id)?" and a.location_id=".$security_location_id:"";
							$org_names=UlsMenu::callpdo("SELECT b.`employee_id`,b.`employee_number`,b.`full_name` FROM `uls_assessment_employee_dev_rating` a 
							left join(SELECT `employee_id`,`employee_number`,`full_name` FROM `employee_data` ) b on a.employee_id=b.employee_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." ".$emp_name."  group by a.employee_id");
							?>
							<select id="employee_id" name="employee_id" class="form-control m-b" data-prompt-position="topLeft">
								<option value="">Select</option>
								<?php 
								foreach($org_names as $org_name){
								?>
								<option value="<?php echo $org_name['employee_id'];?>"><?php echo $org_name['full_name'];?></option>
								<?php
								}
								?>
							</select>
							</div>
						</div>-->
						<div id="tna_details" class="form-group" aria-expanded="true">
							<label class="control-label mb-10 col-sm-2">Employee Name:</label>
							<div class="col-sm-5">
							
							<select id="employee_id" name="employee_id" class="form-control m-b" data-prompt-position="topLeft">
								<option value="">Select</option>
								
							</select>
							</div>
						</div>
						<div class="col-sm-offset-6">
							
								<label class="control-label mb-10 text-left">&nbsp;</label>
								
								<a href="#" class="btn btn-primary btn-sm" onclick="get_organisation();" >Generate Report</a>
							

						</div>
						<div class="form-group col-sm-offset-0">
						
						</div>
					</form>
				</div>
				<div class="hpanel">
					
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function open_data_report(){ 
	var loc_id=document.getElementById('location_id').value;
	
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
			
			document.getElementById('orgid').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/employee_tna_report_search_details?loc_id="+loc_id,true);
	xmlhttp.send();	
	
}
function get_organisation(){
	var def=$('#loginForm').validationEngine('validate');
	if(def==false){
		$('#loginForm').validationEngine();
		return false;
	}
	else {
		var loc_id=document.getElementById("location_id").value;
		var org_id=document.getElementById("orgid").value;
		var emp_id=document.getElementById("employee_id").value;
		var data="";
		if(org_id!=''){
			data+="&org_id="+org_id;
		}
		if(emp_id!=''){
			data+="&emp_id="+emp_id;
		}
		window.open(BASE_URL+"/admin/location_emp_traning_status_report?typeid=35&loc_id="+loc_id+data, '_blank');
	}
}

function open_employees(){ 
	var location_id=document.getElementById('location_id').value;
	var organization_id=document.getElementById('orgid').value;
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
			
			document.getElementById('tna_details').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/employee_tna_details?location_id="+location_id+"&organization_id="+organization_id,true);
	xmlhttp.send();	
	
}
</script>
