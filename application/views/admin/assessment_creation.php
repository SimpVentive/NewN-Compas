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
						<li id='information_li'><a data-toggle="tab" href="#infomation-info">Step 1 - Assessment Information</a></li>
						<li id='competency_li'><a data-toggle="tab" href="#competency-info">Step 2 - Add Position to Assessment</a></li>
					<?php }
					else{
					?>
						<li id='information_li' class="active"><a data-toggle="tab" href="#infomation-info">Step 1 - Assessment Information</a></li>
						<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#competency-info">Step 2 -Add Position to Assessment</a></li>
					<?php
					}
					?>
				</ul>
				<div class="tab-content">
					<div id="infomation-info" class="p-m tab-pane active">
						<div class="row">
							<div class="panel-body">
								<h6 class="txt-dark capitalize-font">Assessment Definition</h6>
								<hr class="light-grey-hr">
								<form id="assessment_master" action="<?php echo BASE_URL;?>/admin/assessment_insert" method="post" enctype="multipart/form-data" class="form-horizontal">
									<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo (isset($compdetails['assessment_id']))?$compdetails['assessment_id']:''?>">
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Assessment Name<sup><font color="#FF0000">*</font></sup>:</label>
										<div class="col-sm-5"><input type="text" class="validate[required] form-control" name="assessment_name" id="assessment_name" value="<?php echo (isset($compdetails['assessment_name']))?$compdetails['assessment_name']:''?>"></div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Short Description:</label>
										<div class="col-sm-5">
											<textarea class="form-control m-b" name="assessment_desc" id="assessment_desc" ><?php echo (isset($compdetails['assessment_desc']))?$compdetails['assessment_desc']:''?></textarea>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Start Date<sup><font color="#FF0000">*</font></sup>:</label>
										<div class="col-sm-5">
											<div class="input-group date" id="datepicker">
												
												<input type="text" class="validate[required]  form-control" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="stdate" id="stdate" value="<?php if(!empty($compdetails['start_date'])){ if($compdetails['start_date']!='0000-00-00' || $compdetails['start_date']!=NULL){ echo  date('d-m-Y',strtotime($compdetails['start_date']));}}?>">
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">End Date<sup><font color="#FF0000">*</font></sup>:</label>
										<div class="col-sm-5">
											<div class="input-group date" id="datepicker">
												<input type="text" class="validate[required] form-control" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="enddate" id="enddate" value="<?php if(!empty($compdetails['end_date'])){ if($compdetails['end_date']!='0000-00-00' || $compdetails['end_date']!=NULL){ echo  date('d-m-Y',strtotime($compdetails['end_date']));}}?>">
												<span class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Location<sup><font color="#FF0000">*</font></sup>:</label>
										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" id="location_id" name="location_id" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($locations as $location){
													$dep_sel=isset($compdetails['location_id'])?($compdetails['location_id']==$location->location_id)?"selected='selected'":"":"";
													?>
														<option value="<?php echo $location->location_id;?>" <?php echo $dep_sel; ?>><?php echo $location->location_name;?></option>
													<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Assessment Cycle Type<sup><font color="#FF0000">*</font></sup>:</label>
										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" id="assessment_cycle_type" name="assessment_cycle_type" style="width: 100%">
												<option value="">Select</option>
												<?php 
												foreach($pos_types as $pos_type){
													$dep_sel=isset($compdetails['assessment_cycle_type'])?($compdetails['assessment_cycle_type']==$pos_type['code'])?"selected='selected'":"":"";
													?>
														<option value="<?php echo $pos_type['code'];?>" <?php echo $dep_sel; ?>><?php echo $pos_type['name'];?></option>
													<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Assessment Type<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" name="assessment_type" id="assessment_type">
												<option value="">Select</option>
												<?php 	
												foreach($asstype as $asstypes){
													$rat_sat=(isset($compdetails['assessment_type']))?($compdetails['assessment_type']==$asstypes['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $asstypes['code']?>" <?php echo $rat_sat?>><?php echo $asstypes['name']?></option>
												<?php 	
												}?>
											</select>
										</div>
									</div>
									<div class="form-group" id="self_div"><label class="control-label mb-10 col-sm-2">Self Assessement Type<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" name="self_ass_type" id="self_ass_type">
												<option value="">Select</option>
												<?php 	
												foreach($self_types as $self_type){
													$sel_sat=(isset($compdetails['self_ass_type']))?($compdetails['self_ass_type']==$self_type['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $self_type['code']?>" <?php echo $sel_sat?>><?php echo $self_type['name']?></option>
												<?php 	
												}?>
											</select>
										</div>
									</div>
									<div class="form-group" id="rating_div"><label class="control-label mb-10 col-sm-2">Rating Scale<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" name="rating_id" id="rating_id">
												<option value="">Select</option>
												<?php 	
												foreach($rating as $ratings){
													$rat_sat=(isset($compdetails['rating_id']))?($compdetails['rating_id']==$ratings['rating_id'])?"selected='selected'":'':''?>
													<option value="<?php echo $ratings['rating_id']?>" <?php echo $rat_sat?>><?php echo $ratings['rating_name']?></option>
												<?php 	
												}?>
											</select>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Feedback<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" name="feedback" id="feedback">
												<option value="">Select</option>
												<?php 	
												foreach($feed_types as $feed_type){
													$feed_sat=(isset($compdetails['feedback']))?($compdetails['feedback']==$feed_type['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $feed_type['code']?>" <?php echo $feed_sat?>><?php echo $feed_type['name']?></option>
												<?php 	
												}?>
											</select>
										</div>
									</div>
									<!--<div class="form-group"><label class="control-label mb-10 col-sm-2">Assessment Methods<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" name="ass_methods" id="ass_methods">
												<option value="">Select</option>
												<?php 	
												foreach($feed_types as $feed_type_ass){
													$feed_sat_ass=(isset($compdetails['ass_methods']))?($compdetails['ass_methods']==$feed_type_ass['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $feed_type_ass['code']?>" <?php echo $feed_sat_ass?>><?php echo $feed_type_ass['name']?></option>
												<?php 	
												}?>
											</select>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Competency Selection<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" name="ass_comp_selection" id="ass_comp_selection">
												<option value="">Select</option>
												<?php 	
												foreach($feed_types as $feed_type_com){
													$feed_sat_com=(isset($compdetails['ass_comp_selection']))?($compdetails['ass_comp_selection']==$feed_type_com['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $feed_type_com['code']?>" <?php echo $feed_sat_com?>><?php echo $feed_type_com['name']?></option>
												<?php 	
												}?>
											</select>
										</div>
									</div>
									<?php $comp_sel=(!empty($compdetails['ass_comp_count']))?'style=display:block':'style=display:none'?>
									<div class="form-group" id="comp_div" <?php echo $comp_sel; ?>><label class="control-label mb-10 col-sm-2">Competency Count<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<input type="text" class="validate[required] form-control" name="ass_comp_count" id="ass_comp_count" value="<?php echo (isset($compdetails['ass_comp_count']))?$compdetails['ass_comp_count']:''?>">
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Program Selection<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" name="ass_pro_selection" id="ass_pro_selection">
												<option value="">Select</option>
												<?php 	
												foreach($feed_types as $feed_type_com){
													$feed_sat_com=(isset($compdetails['ass_pro_selection']))?($compdetails['ass_pro_selection']==$feed_type_com['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $feed_type_com['code']?>" <?php echo $feed_sat_com?>><?php echo $feed_type_com['name']?></option>
												<?php 	
												}?>
											</select>
										</div>
									</div>-->
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Employee Competency Selection<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" name="ass_emp_comp" id="ass_emp_comp">
												<option value="">Select</option>
												<?php 	
												foreach($feed_types as $feed_type_com){
													$feed_sat_com=(isset($compdetails['ass_emp_comp']))?($compdetails['ass_emp_comp']==$feed_type_com['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $feed_type_com['code']?>" <?php echo $feed_sat_com?>><?php echo $feed_type_com['name']?></option>
												<?php 	
												}?>
											</select>
										</div>
									</div>
									<?php $pro_sel=(!empty($compdetails['ass_pro_count']))?'style=display:block':'style=display:none'?>
									<div class="form-group" id="pro_div" <?php echo $pro_sel; ?>><label class="control-label mb-10 col-sm-2">Program Count<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<input type="text" class="validate[required] form-control" name="ass_pro_count" id="ass_pro_count" value="<?php echo (isset($compdetails['ass_pro_count']))?$compdetails['ass_pro_count']:''?>">
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>

										<div class="col-sm-5">
											<select class="validate[required] form-control m-b" name="assessment_status" id="assessment_status">
												<option value="">Select</option>
												<?php 	
												foreach($orgstat as $orgstatus){
													$sel_sat=(isset($compdetails['assessment_status']))?($compdetails['assessment_status']==$orgstatus['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $orgstatus['code']?>" <?php echo $sel_sat?>><?php echo $orgstatus['name']?></option>
												<?php 	
												}?>
											</select>
										</div>
									</div>
									<hr class="light-grey-hr">
									<div class="form-group">
										<div class="col-sm-offset-9">
										   <button class="btn btn-danger btn-sm" type="button" onclick="create_link('assessment_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
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
								<form id="case_master" action="<?php echo BASE_URL;?>/admin/assessment_position_insert" method="post" enctype="multipart/form-data">
								<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo (isset($compdetails['assessment_id']))?$compdetails['assessment_id']:''?>">
								<input type="hidden" name="assessment_type" id="assessment_type" value="<?php echo (isset($compdetails['assessment_type']))?$compdetails['assessment_type']:''?>">
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
														<td><label><input type="checkbox" id="chkbox<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $position_detail['assessment_pos_id'];?>" ></label>
														<input type="hidden" id="assessment_pos_id<?php echo $key1; ?>" name="assessment_pos_id[]" value="<?php echo $position_detail['assessment_pos_id'];?>">
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
															<select class="form-control m-b" name="assessment_pos_status[]" id="assessment_pos_status<?php echo $key1; ?>" onchange="open_scale(<?php echo $key1; ?>);">
																<option value="">Select</option>
																<?php 	
																foreach($orgstat as $orgstatus){
																	$sel_sat=(isset($position_detail['assessment_pos_status']))?($position_detail['assessment_pos_status']==$orgstatus['code'])?"selected='selected'":'':''?>
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
													<input type="hidden" id="assessment_pos_id1" name="assessment_pos_id[]" value="">
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
														<select class="form-control m-b" name="assessment_pos_status[]" id="assessment_pos_status1" onchange="open_scale(1);">
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
											<button class="btn btn-danger btn-sm" type="button" onclick="create_link('assessment_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
											<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit" onclick="return addsource_details_position_validation();"><i class="fa fa-check"></i> Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
