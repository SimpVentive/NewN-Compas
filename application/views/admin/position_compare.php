<style>
.col-sm-2 {
    width: 13.667%;
}
</style>
<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Compare Position</h6>
					</div>
					<div class="pull-right">
						<a href="#" onClick="create_link('position_search')" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Position Search</a>&nbsp; <a href="#" onClick="create_link('position_update?eve_stat')" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create Position </a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
						
						<div class="row">							
							<div class="col-md-4">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="control-label mb-10 text-left">Business</label>
											<select class=" form-control m-b" id="business1" name="business1" onchange="getbusiness(1)" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($business as $bus){
													$bus_sel=isset($buss)?($bus==$bus['organization_id'])?"selected='selected'":"":"";
													?>
														<option value="<?php echo $bus['organization_id'];?>" <?php echo $bus_sel; ?>><?php echo $bus['org_name'];?></option>
													<?php } ?>
											</select>
										</div>
										<div class="form-group" id="divdepartment1">
											<label class="control-label mb-10 text-left">Department</label>
											<select class=" form-control m-b" id="department1" name="department1" onchange="getposition(1)" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($departments as $department){
													$dep_sel=isset($depart)?($depart==$department['id'])?"selected='selected'":"":"";
													?>
														<option value="<?php echo $department['id'];?>" <?php echo $dep_sel; ?>><?php echo $department['name'];?></option>
													<?php } ?>
											</select>
										</div>
										<div class="form-group" id="divposition1">
											<label class="control-label mb-10 text-left">Position</label>
											<select class=" form-control m-b" id="position1" name="position1" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($pos_locations as $pos_location){
													$dep_sel=isset($location)?($location==$pos_location['location_id'])?"selected='selected'":"":"";
													?>
														<option value="<?php echo $pos_location['location_id'];?>" <?php echo $dep_sel; ?>><?php echo $pos_location['location_name'];?></option>
													<?php } ?>
											</select>
										</div>
										<div id="positiondetail1">
										
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">								
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="control-label mb-10 text-left">Business</label>
											<select class=" form-control m-b" id="business2" name="business2" onchange="getbusiness(2)" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($business as $bus){
													$bus_sel=isset($buss)?($bus==$bus['organization_id'])?"selected='selected'":"":"";
													?>
														<option value="<?php echo $bus['organization_id'];?>" <?php echo $bus_sel; ?>><?php echo $bus['org_name'];?></option>
													<?php } ?>
											</select>
										</div>
										<div class="form-group" id="divdepartment2">
											<label class="control-label mb-10 text-left">Department</label>
											<select class=" form-control m-b" id="department2" name="department2" onchange="getposition(2)" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($departments as $department){
													$dep_sel=isset($depart)?($depart==$department['id'])?"selected='selected'":"":"";
													?>
														<option value="<?php echo $department['id'];?>" <?php echo $dep_sel; ?>><?php echo $department['name'];?></option>
													<?php } ?>
											</select>
										</div>
										<div class="form-group" id="divposition2">
											<label class="control-label mb-10 text-left">Position</label>
											<select class=" form-control m-b" id="position2" name="position2" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($pos_locations as $pos_location){
													$dep_sel=isset($location)?($location==$pos_location['location_id'])?"selected='selected'":"":"";
													?>
														<option value="<?php echo $pos_location['location_id'];?>" <?php echo $dep_sel; ?>><?php echo $pos_location['location_name'];?></option>
													<?php } ?>
											</select>
										</div>
										<div id="positiondetail2">
										
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">								
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="control-label mb-10 text-left">Business</label>
											<select class=" form-control m-b" id="business3" name="business3" onchange="getbusiness(3)" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($business as $bus){
													$bus_sel=isset($buss)?($bus==$bus['organization_id'])?"selected='selected'":"":"";
													?>
														<option value="<?php echo $bus['organization_id'];?>" <?php echo $dep_sel; ?>><?php echo $bus['org_name'];?></option>
													<?php } ?>
											</select>
										</div>
										<div class="form-group" id="divdepartment3">
											<label class="control-label mb-10 text-left">Department</label>
											<select class=" form-control m-b" id="department3" name="department3" onchange="getposition(3)" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($departments as $department){
													$dep_sel=isset($depart)?($depart==$department['id'])?"selected='selected'":"":"";
													?>
														<option value="<?php echo $department['id'];?>" <?php echo $dep_sel; ?>><?php echo $department['name'];?></option>
													<?php } ?>
											</select>
										</div>
										<div class="form-group" id="divposition3">
											<label class="control-label mb-10 text-left">Position</label>
											<select class=" form-control m-b" id="position3" name="position3" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($pos_locations as $pos_location){
													$dep_sel=isset($location)?($location==$pos_location['location_id'])?"selected='selected'":"":"";
													?>
														<option value="<?php echo $pos_location['location_id'];?>" <?php echo $dep_sel; ?>><?php echo $pos_location['location_name'];?></option>
													<?php } ?>
											</select>
										</div>
										<div id="positiondetail3">
										
										</div>
									</div>
								</div>
							</div>
						</div>
					
				</div>

			</div>
		</div>
	</div>
</div>
<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Position ?.
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>	
<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		Selected Position cannot be deleted. Ensure you delete all the usages of the Position before you delete it.
	</div>
	<div class="space-6"></div>	
</div>
<script>
function getbusiness(val) {
	var business=document.getElementById("business"+val).value;
	document.getElementById("divdepartment"+val).innerHTML = "";
	document.getElementById("positiondetail"+val).innerHTML = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divdepartment"+val).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", "<?php echo BASE_URL;?>/admin/getbudepart?bus=" + business+"&id="+val, true);
	xmlhttp.send();
}

function getposition(val) {
	var department=document.getElementById("department"+val).value;
	document.getElementById("divposition"+val).innerHTML = "";
	document.getElementById("positiondetail"+val).innerHTML = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divposition"+val).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", "<?php echo BASE_URL;?>/admin/getdepposition?department=" + department+"&id="+val, true);
	xmlhttp.send();
}

function getpositiondetails(val) {
	var id=document.getElementById("position"+val).value;
	document.getElementById("positiondetail"+val).innerHTML = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("positiondetail"+val).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", "<?php echo BASE_URL;?>/admin/getdeppositiondet?id="+id, true);
	xmlhttp.send();
}
</script>