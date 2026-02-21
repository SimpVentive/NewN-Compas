<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<?php 
					$security_location_id=$this->session->userdata('security_location_id');
					$loc_name=UlsLocation::getloc($security_location_id);
					?>
					<form action="#" id="loginForm" class="form-horizontal">
						<div class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);"><label class="control-label mb-10 col-sm-2">Location Name:</label>
							<div class="col-sm-5">
							<input type="hidden" name="loc_id" id="loc_id" value="<?php echo $security_location_id; ?>">
							<label class="control-label mb-10"><b><?php echo $loc_name['location_name']; ?></b></label></div>
						</div>
						<div class="form-group" aria-expanded="true" style="color: rgb(15, 197, 187);"><label class="control-label mb-10 col-sm-2">Department Name:</label>
							<div class="col-sm-5">
							<?php 
							$org_names=UlsMenu::callpdo("SELECT b.`organization_id`,b.`org_name` FROM `uls_assessment_employees` a 
							left join(SELECT `organization_id`,`org_name` FROM `uls_organization_master`) b on a.org_id=b.organization_id
							WHERE a.`parent_org_id`=".$_SESSION['parent_org_id']." and a.location_id=".$security_location_id." group by a.org_id");
							?>
							<select id="organization_id" name="organization_id" class="validate[required] form-control m-b" data-prompt-position="topLeft">
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
function get_organisation(){
	
	var loc_id=document.getElementById("loc_id").value;
	var org_id=document.getElementById("organization_id").value;
	var data="";
	if(org_id!=''){
		data+="&org_id="+org_id;
	}
	else{
		data+="&org_id=";
	}
	 window.open(BASE_URL+"/admin/location_emp_status_report?typeid=34&loc_id="+loc_id+data, '_blank');
}
</script>
