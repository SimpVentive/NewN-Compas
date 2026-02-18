<script>
<?php 
// To pass the Requested Status to empcreation.js File
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}
$positiondetails='';
foreach($positions as $position){
    if($positiondetails==''){
        $positiondetails=$position->position_id."*".$position->position_name;
    }
    else{
        $positiondetails=$positiondetails.",".$position->position_id."*".$position->position_name;
    }
}
echo "var pos_details='".$positiondetails."';"; 
$ass_status='';
foreach($orgstat as $orgstatus){
    if($ass_status==''){
        $ass_status=$orgstatus['code']."*".$orgstatus['name'];
    }
    else{
        $ass_status=$ass_status.",".$orgstatus['code']."*".$orgstatus['name'];
    }
}
echo "var status_details='".$ass_status."';";  
?>
</script>

<div class="content">
    <div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<ul class="nav nav-pills">
					<?php 	
					if(isset($_REQUEST['id'])){
					?>
						<li id='information_li'><a data-toggle="tab" href="#infomation-info">Step 1 - Position Validation</a></li>
						<li id='competency_li'><a data-toggle="tab" href="#competency-info">Step 2 - Add Position for Correction</a></li>
						<li id='enrol_li'><a data-toggle="tab" href="#enrol-info">Step 3 - Employee Enrollment</a></li>
					<?php }
					else{
					?>
						<li id='information_li' class="active"><a data-toggle="tab" href="#infomation-info">Step 1 - Position Validation</a></li>
						<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#competency-info">Step 2 -Add Position for Correction</a></li>
						<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#enrol-info">Step 3 -Employee Enrollment</a></li>
					<?php
					}
					?>
				</ul>
				<div class="tab-content">
					<div id="infomation-info" class="p-m tab-pane active">
						<div class="">
							<div class="panel-body">
								<h6 class="txt-dark capitalize-font">Position Validation Definition</h6>
								<hr class="light-grey-hr">
								<form id="assessment_master" action="<?php echo BASE_URL;?>/admin/position_validation_insert" method="post" enctype="multipart/form-data" class="form-horizontal">
									<input type="hidden" name="val_id" id="val_id" value="<?php echo (isset($compdetails['val_id']))?$compdetails['val_id']:''?>">
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Position Validation Name<sup><font color="#FF0000">*</font></sup>:</label>
										<div class="col-sm-5"><input type="text" class="validate[required] form-control" name="position_validation_name" id="position_validation_name" value="<?php echo (isset($compdetails['position_validation_name']))?$compdetails['position_validation_name']:''?>"></div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Short Description:</label>
										<div class="col-sm-5">
											<textarea class="form-control m-b" name="position_validation_desc" id="position_validation_desc" ><?php echo (isset($compdetails['position_validation_desc']))?$compdetails['position_validation_desc']:''?></textarea>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Start Date<sup><font color="#FF0000">*</font></sup>:</label>
										<div class="col-sm-5">
											<div class="input-group date" id="datepicker">
												
												<input type="text" class="validate[required,custom[date2]]  form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="stdate" id="stdate" value="<?php if(!empty($compdetails['start_date'])){ if($compdetails['start_date']!='0000-00-00' || $compdetails['start_date']!=NULL){ echo  date('d-m-Y',strtotime($compdetails['start_date']));}}?>">
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">End Date<sup><font color="#FF0000">*</font></sup>:</label>
										<div class="col-sm-5">
											<div class="input-group date" id="datepicker">
												<input type="text" class="validate[required,custom[date2],future[#stdate]] form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="enddate" id="enddate" value="<?php if(!empty($compdetails['end_date'])){ if($compdetails['end_date']!='0000-00-00' || $compdetails['end_date']!=NULL){ echo  date('d-m-Y',strtotime($compdetails['end_date']));}}?>">
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" name="status" id="status">
												<option value="">Select</option>
												<?php 	
												foreach($orgstat as $orgstatus){
													$sel_sat=(isset($compdetails['status']))?($compdetails['status']==$orgstatus['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $orgstatus['code']?>" <?php echo $sel_sat?>><?php echo $orgstatus['name']?></option>
												<?php 	
												}?>
											</select>
										</div>
									</div>
									<hr class="light-grey-hr">
									<div class="form-group">
										<div class="col-sm-offset-9">
										   <button class="btn btn-danger btn-sm" type="button" onclick="create_link('position_validation_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
										   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div id="competency-info" class="p-m tab-pane">
						<div class="row">
							<div class="panel-body">
								<h6 class="txt-dark capitalize-font">Assessment Positions</h6>
								<hr class="light-grey-hr">
								<form id="case_master" action="<?php echo BASE_URL;?>/admin/validation_position_insert" method="post" enctype="multipart/form-data">
								<input type="hidden" name="val_id" id="val_id" value="<?php echo (isset($compdetails['val_id']))?$compdetails['val_id']:''?>">
								
									<div class="panel-heading hbuilt">
										
										<div class="pull-left">
											<h6 class="panel-title txt-dark">Add Positions</h6>
										</div>
										<div class="pull-right">
											<a class="btn btn-xs btn-primary" onclick="addsource_details_position();">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
											<a class="btn btn-danger btn-xs" onclick="delete_position();">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="table-responsive">
										<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="assessement_position">
											<thead>
											<tr>
												<th>Select</th>
												<th>Position</th>
												<th>Version</th>
												<th>status</th>
											</tr>
											</thead>
											<tbody>
											<?php
											if(!empty($position_details)){
												$hide_val=array();
												foreach($position_details as $key=>$position_detail){ 
													$key1=$key+1; $hide_val[]=$key1;
													?>
													<tr id='subgrd_position<?php echo $key1; ?>'>
														<td><label><input type="checkbox" id="chkbox<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $position_detail['val_pos_id'];?>" ></label>
														<input type="hidden" id="val_pos_id<?php echo $key1; ?>" name="val_pos_id[]" value="<?php echo $position_detail['val_pos_id'];?>">
														</td>
														<td>
															<select class="form-control m-b" name="position_id[]" id="position_id<?php echo $key1; ?>" onchange="position_version(<?php echo $key1; ?>);">
																<option value="">Select</option>
																<?php 
																foreach($positions as $position){
																	$cat_sel=isset($position_detail['position_id'])?($position_detail['position_id']==$position->position_id)?"selected='selected'":"":"";
																	?>
																	<option value="<?php echo $position->position_id;?>" <?php echo $cat_sel; ?>><?php echo $position->position_name;?></option>
																<?php
																}
																?>
															</select>
														</td>
														<td>
															<select class="form-control m-b" name="version_id[]" id="version_id<?php echo $key1; ?>">
																<option value="">Select</option>
																<?php
																$pos_id=isset($position_detail['position_id'])?$position_detail['position_id']:"";
																$pos_details=UlsPosition::pos_details($pos_id);
																$version=$pos_details['version_id'];
																for($n = $version; $n >= 1; $n--) {
																	$ver_sel=isset($position_detail['version_id'])?($position_detail['version_id']==$n)?"selected='selected'":"":"";
																	?>
																	<option value='<?php echo $n;?>' <?php echo $ver_sel;?>>Version <?php echo $n;?></option>
																<?php
																}
																?>
															</select>
														</td>
														<td>
															<select class="form-control m-b" name="assessment_pos_status[]" id="assessment_pos_status<?php echo $key1; ?>">
																<option value="">Select</option>
																<?php 	
																foreach($orgstat as $orgstatus){
																	$sel_sat=(isset($position_detail['status']))?($position_detail['status']==$orgstatus['code'])?"selected='selected'":'':''?>
																	<option value="<?php echo $orgstatus['code']?>" <?php echo $sel_sat?>><?php echo $orgstatus['name']?></option>
																<?php 	
																}?>
															</select>
														</td>
													</tr>
												<?php 
												}
												$hidden_position=@implode(',',$hide_val);
											}
											else{?>
												<tr id='subgrd_position1'>
													<td><label><input type="checkbox" id="chkbox1" name="chkbox[]" value=""></label>
													<input type="hidden" id="val_pos_id1" name="val_pos_id[]" value="">
													</td>
													<td>
														<select class="form-control m-b" name="position_id[]" id="position_id1" onchange="position_version(1);">
															<option value="">Select</option>
															<?php 
															foreach($positions as $position){
																?>
																<option value="<?php echo $position->position_id;?>"><?php echo $position->position_name;?></option>
															<?php
															}
															?>
														</select>
													</td>
													<td>
														<select class="form-control m-b" name="version_id[]" id="version_id1">
															<option value=''>Select</option>
														</select>
													</td>
													<td>
														<select class="form-control m-b" name="assessment_pos_status[]" id="assessment_pos_status1">
															<option value="">Select</option>
															<?php 	
															foreach($orgstat as $orgstatus){
																?>
																<option value="<?php echo $orgstatus['code']?>" ><?php echo $orgstatus['name']?></option>
															<?php 	
															}?>
														</select>
													</td>
												</tr>
											<?php 
												$hidden_position=1;
											} ?>
											</tbody>
											<input type="hidden" name="addgroup_position" id="addgroup_position" value="<?php echo $hidden_position; ?>" />
										</table>
									</div>
									<hr class="light-grey-hr">
									<div class="form-group">
										<div class="col-sm-offset-0">
											<button class="btn btn-danger btn-sm" type="button" onclick="create_link('position_validation_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
											<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit" onclick="return addsource_details_position_validation();"><i class="fa fa-check"></i> Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div id="enrol-info" class="p-m tab-pane">
						<div class="">
							<div class="panel-body">
								<h6 class="txt-dark capitalize-font">Assessment Positions</h6>
								<hr class="light-grey-hr">
								<?php
								if(!empty($position_details)){
								?>
								<ul class="nav nav-pills">
									<?php $j=0;
									
										foreach($position_details as $position){ 
										$class=($j==0)?"active":""; $j++;
										
										?>
										<li class="<?php echo $class; ?>"><a data-toggle="tab" href="#tab-<?php echo $position['position_id']; ?>"> <?php echo $position['position_name']; ?></a></li>
									<?php }
									
									?>
								</ul>
								<div class="tab-content">
									<?php $i=0; 
									foreach($position_details as $position){ 
										$classs=($i==0)?"active":""; $i++;
										$val_id=(isset($compdetails['val_id']))?$compdetails['val_id']:'';
										$emp_details=UlsEmployeeMaster::fetch_emp_position($position['position_id'],$val_id);
									?>
									<div id="tab-<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $classs; ?>">
										<div class="panel-body">
											
											<form id="case_master" action="<?php echo BASE_URL;?>/admin/validation_position_employee_insert" method="post" enctype="multipart/form-data">
												<div class="table-responsive">
													<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
														<thead>
														<tr>
															<th class="col-sm-1">Select</th>
															<th class="col-sm-1">Emp Number</th>
															<th class="col-sm-3">Name</th>
															<th class="col-sm-3">Department</th>
															<th class="col-sm-2">Position</th>
															<th class="col-sm-2">Location</th>
														</tr>
														</thead>
														<tbody>
														<?php 
														foreach($emp_details as $key1=>$emp_detail){
															$key=$key1+1;
															$check=!empty($emp_detail['val_pos_empid'])?"checked='checked'":"";
														?>
														<tr>
															<td>
															<input type='checkbox' name='check_position[<?php echo $emp_detail['master_employee_id']; ?>]' id='check_position_<?php echo $position['position_id'].'_'.$key;?>' value='<?php echo $emp_detail['master_employee_id']; ?>' <?php echo $check; ?>>
															<input type="hidden" name="val_id" id="val_id" value="<?php echo $_REQUEST['id']; ?>">
															<input type="hidden" name="val_pos_id[<?php echo $emp_detail['master_employee_id']; ?>]" id="val_pos_id" value="<?php echo $position['val_pos_id']; ?>">
															<input type="hidden" name="position_id[<?php echo $emp_detail['master_employee_id']; ?>]" id="position_id[]" value="<?php echo $position['position_id']; ?>">
															<input type="hidden" name="val_pos_empid[<?php echo $emp_detail['master_employee_id']; ?>]" id="val_pos_empid[]" value="<?php echo $emp_detail['val_pos_empid'];?>">
															
															</td>
															<td><?php echo $emp_detail['employee_number']; ?></td>
															<td><?php echo $emp_detail['full_name']; ?></td>
															<td><?php echo $emp_detail['org_name']; ?></td>
															<td><?php echo $emp_detail['position_name']; ?></td>
															<td><?php echo $emp_detail['location_name']; ?></td>
														</tr>
														<?php
														}
														?>
														</tbody>
													</table>
												</div>
												
												<div class="form-group">
													<div class="col-sm-offset-9">
														<button class="btn btn-danger btn-sm" type="button" onclick="create_link('position_validation_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
														<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit" ><i class="fa fa-check"></i> Submit</button>
													</div>
												</div>
											</form>
											<hr class="light-grey-hr">
											<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Adding Employees from different position to validate this position <a class="label label-info capitalize-font inline-block ml-10" data-target="#workinfoview<?php echo $position['position_id']; ?>" onclick='work_info_view(<?php echo $val_id;?>,<?php echo $position['position_id']; ?>,<?php echo $position['val_pos_id']; ?>)' data-toggle='modal' href='#workinfoview<?php echo $position['position_id']; ?>'>Click</a></h6>
											<hr class="light-grey-hr">
											<div class="table-responsive">
												<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
													<thead>
														<tr>
															<th class="col-sm-1">Emp Number</th>
															<th class="col-sm-3">Name</th>
															<th class="col-sm-2">Department</th>
															<th class="col-sm-3">Position</th>
															<th class="col-sm-2">Location</th>
															<th class="col-sm-1">Action</th>
														</tr>
													</thead>
													<tbody>
													<?php 
													$pos_emp=UlsValidationPositionEmployees::get_employees_position($val_id,$position['position_id'],$position['val_pos_id']);
													foreach($pos_emp as $pos_emps){
													?>
														<tr id="assessmentdel_<?php echo $pos_emps['val_pos_empid']; ?>">
															<td><?php echo $pos_emps['employee_number']; ?></td>
															<td><?php echo $pos_emps['full_name']; ?></td>
															<td><?php echo $pos_emps['org_name']; ?></td>
															<td><?php echo $pos_emps['position_name']; ?></td>
															<td><?php echo $pos_emps['location_name']; ?></td>
															<td><a class="mr-10" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $pos_emps['val_pos_empid']; ?>" name="deleteposition_validation_employee" rel="assessmentdel_<?php echo $pos_emps['val_pos_empid']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a></td>
														</tr>
													<?php } ?>
													</tbody>
												</table>
											</div>
											<div class="clearfix mt-40"></div>
										</div>
									</div>
									<div id="workinfoview<?php echo $position['position_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="color-line"></div>
												<div class="modal-header">
													<h6 class="modal-title">Add Employees</h6>
													<button type="button" class="btn btn-default pull-right" data-dismiss="modal">X</button>
												</div>
												<div class="modal-body">
													<div id="workinfodetails<?php echo $position['position_id']; ?>" class="modal-body no-padding">
													
													</div>
												</div>
												
											</div><!-- /.modal-content -->
										</div><!-- /.modal-dialog -->
									</div>
									<?php } ?>
								</div>
								<?php
								} ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
