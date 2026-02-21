<script>
<?php 
// To pass the Requested Status to empcreation.js File
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}

?>
</script>

<div class="content">
    <div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<ul class="nav nav-pills">
					<?php 	
					if(isset($_REQUEST['val_id']) && isset($_REQUEST['val_pos_id'])){
						
					?>
						
						<li id='information_li'><a data-toggle="tab" href="#information-info">Step 1 - JD Validation</a></li>
						<li id='competency_li'><a data-toggle="tab" href="#competency-info">Step 2 - Competency Profile Validation</a></li>
						<li id='enrol_li'><a data-toggle="tab" href="#enrol-info">Step 3 - KRA's Validation</a></li>
						<li id='final_li'><a data-toggle="tab" href="#final-info">Step 4 - Final View</a></li>
					<?php }
					else{
					?>
						
						<li id='information_li' style="pointer-events:none;"><a data-toggle="tab" href="#information-info">Step 1 - JD Validation</a></li>
						<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#competency-info">Step 2 - Competency Profile Validation</a></li>
						<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#enrol-info">Step 3 - KRA's Validation</a></li>
						<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#final-info">Step 4 - Final View</a></li>
					<?php
					}
					?>
				</ul>
				<div class="tab-content">
					<div id="information-info" class="p-m tab-pane active">
						<div class="">
							<div class="panel-body">
								<div class="alert alert-info alert-dismissable alert-style-1">
									<i class="zmdi zmdi-info-outline"></i>Please Give your responce the Accountabilities and Responsibilities as required.
								</div>
								<h6 class="txt-dark capitalize-font">Position Validation</h6>
								<hr class="light-grey-hr">
								<div class="col-sm-6">
									<h6 class="mb-15">Employee Details</h6>
									<hr class="light-grey-hr">
									<div class="panel-group accordion-struct accordion-style-1" id="accordion_2" role="tablist" aria-multiselectable="true">
										<?php 
										foreach($emp_val_details as $emp_val_detail){
											$emp_acc=UlsPositionTemp::employee_view_position_validation($_REQUEST['val_id'],$_REQUEST['pos_id'],$emp_val_detail['employee_id'])
											
										?>
										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="heading_10">
												<a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_<?php echo $emp_val_detail['employee_id'];?>" aria-expanded="false" class="collapsed"><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i class="ti-plus"></i></span><span class="minus-ac"><i class="ti-minus"></i></span></div><?php echo $emp_val_detail['employee_number']."-".$emp_val_detail['full_name'];?></a> 
											</div>
											<div id="collapse_<?php echo $emp_val_detail['employee_id'];?>" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" style="height: 0px;">
												<div class="panel-body pa-15"> 
													<h6 class="mb-15">Accountablity</h6>
													<p><?php echo $emp_acc['accountabilities']; ?></p>
													<hr class="light-grey-hr">
													<h6 class="mb-15">Responsibility</h6>
													<p><?php echo $emp_acc['responsibilities']; ?></p>
													
												</div>
											</div>
										</div>
										<?php 
										}
										?>
									</div>
								</div>
								<div class="col-sm-6">
									<h6 class="mb-15">Manager Responce</h6>
									<hr class="light-grey-hr">
									<form id="assessment_master" action="<?php echo BASE_URL;?>/manager/manager_position_validation_insert" method="post" enctype="multipart/form-data" class="form-horizontal">
										<input type="hidden" name="val_id" id="val_id" value="<?php echo $_REQUEST['val_id']?>">
										<input type="hidden" name="position_id" id="position_id" value="<?php echo $_REQUEST['pos_id'];?>">
										<input type="hidden" name="val_pos_id" id="val_pos_id" value="<?php echo (isset($pos_details['val_pos_id']))?$pos_details['val_pos_id']:''?>">
										<input type="hidden" name="pos_temp_id" id="pos_temp_id" value="<?php echo (isset($man_validation_details['pos_temp_id']))?$man_validation_details['pos_temp_id']:''?>">
										<div class="panel-heading">
											<div class="pull-left">
												<h6 class="panel-title inline-block txt-dark">Default Accountabilities</h6>
											</div>
											<div class="pull-right">
												<span class="label label-info capitalize-font inline-block ml-10" data-target="#workinfoviewadd_acc" data-toggle='modal' href='#workinfoviewadd_acc'>View</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div id="workinfoviewadd_acc"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="color-line"></div>
													<div class="modal-header">
														<h6 class="modal-title">Default Accountabilities</h6>
													</div>
													<div class="modal-body">
														<div class="panel-body">
															<div class="col-lg-12"><?php echo (isset($pos_details['accountablities']))?$pos_details['accountablities']:''?></div>
														</div>
													</div>
													
												</div><!-- /.modal-content -->
											</div><!-- /.modal-dialog -->
										</div>
										<div class="clearfix"><br></div>
										<div class="form-group"><label class="control-label mb-10 col-sm-2">Accountabilities:</label>
											<div class="col-sm-10">
												<textarea class="summernote form-control m-b" name="accountabilities" id="accountabilities" ><?php echo (isset($man_validation_details['accountabilities']))?$man_validation_details['accountabilities']:"";?></textarea>
											</div>
										</div>
										<div class="panel-heading">
											<div class="pull-left">
												<h6 class="panel-title inline-block txt-dark">Default Responsibilities</h6>
											</div>
											<div class="pull-right">
												<span class="label label-info capitalize-font inline-block ml-10" data-target="#workinfoviewadd_res" data-toggle='modal' href='#workinfoviewadd_res'>View</span>
											</div>
											<div class="clearfix"></div>
										</div>
										<div id="workinfoviewadd_res"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="color-line"></div>
													<div class="modal-header">
														<h6 class="modal-title">Default Responsibilities</h6>
													</div>
													<div class="modal-body">
														<div class="panel-body">
															<div class="col-lg-12"><?php echo (isset($pos_details['responsibilities']))?$pos_details['responsibilities']:''?></div>
														</div>
													</div>
													
												</div><!-- /.modal-content -->
											</div><!-- /.modal-dialog -->
										</div>
										<div class="clearfix"><br></div>
										<div class="form-group"><label class="control-label mb-10 col-sm-2">Responsibilities:</label>
											<div class="col-sm-10">
												<textarea class="summernote form-control m-b" name="responsibilities" id="responsibilities" ><?php echo (isset($man_validation_details['responsibilities']))?$man_validation_details['responsibilities']:"";?></textarea>
											</div>
										</div>
										<hr class="light-grey-hr">
										<div class="form-group">
											<div class="col-sm-offset-8">
											   <button class="btn btn-danger btn-sm" type="button" onclick="createmp_link('employee_pos_validation')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
											   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Next</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div id="competency-info" class="p-m tab-pane">
						<div class="">
							<div class="panel-body">
								<div class="alert alert-info alert-dismissable alert-style-1">
									<i class="zmdi zmdi-info-outline"></i>Given under are the competencies required for your job.<br>
									You are<br>
									A. Required to edit the competencies as prescribed by HR/Consultant.<br>
									B. Add any additional competencies that you may think are required for your carry out your job.
								</div>
								<h6 class="txt-dark capitalize-font">Profile Validation</h6>
								<hr class="light-grey-hr">
								
								<div class="col-sm-12">
									<h6 class="mb-15">Employee Details</h6>
									<form id="case_master" action="<?php echo BASE_URL;?>/manager/validation_position_competency_insert" method="post" enctype="multipart/form-data">
									<input type="hidden" name="val_id" id="val_id" value="<?php echo $_REQUEST['val_id']?>">
									<input type="hidden" name="position_id" id="position_id" value="<?php echo $_REQUEST['pos_id'];?>">
									<input type="hidden" name="val_pos_id" id="val_pos_id" value="<?php echo !empty($_REQUEST['val_pos_id'])?$_REQUEST['val_pos_id']:'';?>">
									<?php 
									foreach($comp_details as $comp_detail){
									?>
									<div class="panel-heading hbuilt">
										<input type="hidden" id="category_id<?php echo $comp_detail['category_id']; ?>" name="category_id[]" value="<?php echo $comp_detail['category_id']; ?>">
										<div class="pull-left">
											<h6 class="panel-title txt-dark"><?php echo $comp_detail['name']; ?></h6>
										</div>
										
										<div class="clearfix"></div>
									</div>
									<div class="table-responsive">
										<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="assessement_position">
											<thead>
											<tr>
												<th>Competency name</th>
												<th>Required Level</th>
												<th>View</th>
											</tr>
											</thead>
											<tbody>
												<?php
												if(!empty($_REQUEST['val_pos_id'])){
												$competency=UlsPositionCompetencyTemp::get_validation_competencies_summary($_REQUEST['val_id'],$_REQUEST['pos_id'],$_REQUEST['val_pos_id'],$comp_detail['category_id']);
												foreach($competency as $competencys){
												?>
												<tr id='innertable<?php echo $competencys['comp_def_id'];?>'>
													<td><?php echo $competencys['comp_def_name'];?></td>
													<td><?php echo $competencys['scale_name'];?></td>
													<td><a role='button' data-toggle='collapse' data-parent='#accordion_<?php echo $competencys['comp_def_id'];?>' href='#collapse_<?php echo $competencys['comp_def_id'];?>' aria-expanded='true'><i class='fa fa-plus'></i></a> </td>
												</tr>
												<tr id='innertable<?php echo $competencys['comp_def_id'];?>'>
													<td colspan='3'>
														<div id='collapse_<?php echo $competencys['comp_def_id'];?>' class='panel-collapse collapse' role='tabpanel'>
															<div class='panel-body pa-15'>
																<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="assessement_position">
																	<thead>
																	<tr>
																		<th>Employee Name</th>
																		<th>Require</th>
																		<th>Suggested Level</th>
																		<th>Reason</th>
																	</tr>
																	</thead>
																	<?php 
																	$emp_comp=UlsPositionCompetencyTemp::get_employee_competency($_REQUEST['val_id'],$_REQUEST['pos_id'],$competencys['comp_def_id']);
																	?>
																	<tbody>
																	<?php 
																	foreach($emp_comp as $emp_comps){
																	?>
																		<td><?php echo $emp_comps['employee_number']."-".$emp_comps['full_name'];?></td>
																		<td><?php echo $emp_comps['req_process'];?></td>
																		<td><?php echo $emp_comps['ass_scale_name'];?></td>
																		<td><?php echo $emp_comps['reason'];?></td>
																	<?php
																	}
																	?>
																	</tbody>
																</table>
																<h6 class="mb-15">Manager Responce</h6>
																<?php
																$man_competency=UlsPositionCompetencyTemp::get_manager_validation_competencies_summary($_REQUEST['val_id'],$_REQUEST['pos_id'],$competencys['comp_def_id']);
																?>
																
																	<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
																	<input type="hidden" name="requiredlevel_<?php echo $competencys['comp_def_id'];?>" value="<?php echo $competencys['scale_id'];?>" >
																	<input type="hidden" name="pos_comp_temp_id_<?php echo $competencys['comp_def_id'];?>" value="<?php echo (isset($man_competency['pos_comp_temp_id']))?$man_competency['pos_comp_temp_id']:''?>">
																	<div class="row">
																		<div class="col-sm-4">
																			<div class="col-sm-12">
																				<label class="control-label mb-10">Require</label>
																				<select name='required_process_<?php echo $competencys['comp_def_id'];?>' id='required_process_<?php echo $competencys['comp_def_id'];?>' class='validate[required] form-control m-b' onchange="open_suggestion(<?php echo $competencys['comp_def_id'];?>);">
																					<option value=''>Select</option>
																					<?php 
																					foreach($require as $requires){
																						$final_req=!empty($man_competency['required_process'])?$man_competency['required_process']==$requires['code']?"selected='selected'":"":"";
																					?>
																					<option value="<?php echo $requires['code']; ?>" <?php echo $final_req; ?>><?php echo $requires['name']; ?></option>
																					<?php
																					}
																					?>
																				</select>
																			</div>
																			<?php 
																			$sugg_level=!empty($man_competency['assessed_scale_id'])?'block':'none';
																			?>
																			<div class="col-sm-12 mb-15" id="open_sugg_<?php echo $competencys['comp_def_id'];?>" style="display:<?php echo $sugg_level; ?>;">
																				<label class="control-label mb-10">Suggested Level</label>
																				<?php 
																				$data="";
																				$data="
																				<select name='OVERALL_".$competencys['comp_def_id']."' id='OVERALL_".$competencys['comp_def_id']."' class='validate[required] form-control m-b'>
																				<option value=''>Select</option>";
																				$level_id=UlsCompetencyDefinition::viewcompetency($competencys['comp_def_id']);
																				$scale_overall=UlsLevelMasterScale::levelscale($level_id['comp_def_level']);
																				foreach($scale_overall as $scales){
																					$final_scale=!empty($man_competency['assessed_scale_id'])?$man_competency['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
																					$data.="<option value='".$scales['scale_id']."' ".$final_scale.">".$scales['scale_name']."</option>";
																				}
																				$data.="</select>";
																				echo $data; ?>
																			</div>
																		</div>
																		<div class="col-sm-8">
																			<div class="col-sm-12">
																				<label class="control-label mb-10">Reason</label>
																				<textarea rows="3" class="form-control" name="reason_<?php echo $competencys['comp_def_id'];?>"><?php echo !empty($man_competency['reason'])?$man_competency['reason']:"";?></textarea>
																			</div>
																			
																		</div>
																	</div>
															</div>
														</div>
													</td>
												</tr>
												<?php }
												}												
												?>
											</tbody>
										</table>
									</div>
									<div class="panel-heading hbuilt">
										<div class="pull-left">
											<h6 class="panel-title txt-dark">Employees New Competencies added in this <?php echo $comp_detail['name']; ?></h6>
										</div>
										
										<div class="clearfix"></div>
									</div>
									<div class="table-responsive">
										
										<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
											<thead>
											<tr>
												<th>Employee Number</th>
												<th>Employee Name</th>
												<th>View</th>
											</tr>
											</thead>
											<tbody>
											<?php 
											foreach($emp_val_details as $emp_val_detail){
											?>
												<tr>
													<td><?php echo $emp_val_detail['employee_number'];?></td>
													<td><?php echo $emp_val_detail['full_name'];?></td>
													<td><a role='button' data-toggle='collapse' data-parent='#accordion_<?php echo $emp_val_detail['employee_id']; ?>_<?php echo $comp_detail['category_id'];?>' href='#collapse_emp_<?php echo $emp_val_detail['employee_id']; ?>_<?php echo $comp_detail['category_id'];?>' aria-expanded='true'><i class='fa fa-plus'></i></a></td>
												</tr>
												<tr>
													<td colspan='3'>
														<div id='collapse_emp_<?php echo $emp_val_detail['employee_id']; ?>_<?php echo $comp_detail['category_id'];?>' class='panel-collapse collapse' role='tabpanel'>
															<div class='panel-body pa-15'>
																<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="assessement_position">
																	<thead>
																	<tr>
																		<th>Competency Name</th>
																		<th>Suggested Level</th>
																		<th>Reason</th>
																	</tr>
																	</thead>
																	<tbody>
																	<?php 
																	$emp_add_comp=UlsPositionCompetencyTempTray::get_emp_validation_competencies($_REQUEST['val_id'],$_REQUEST['pos_id'],$comp_detail['category_id'],$emp_val_detail['employee_id']);
																	foreach($emp_add_comp as $emp_add_comps){
																	?>
																		<tr>
																			<td><?php echo $emp_add_comps['competency_name'];?></td>
																			<td><?php echo $emp_add_comps['scale_name'];?></td>
																			<td><?php echo $emp_add_comps['reason'];?></td>
																		</tr>
																	<?php
																	}
																	?>
																	</tbody>
																</table>
															</div>
														</div>
													</td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
									<div class="panel-heading hbuilt">
										<div class="pull-left">
											<h6 class="panel-title txt-dark">Manager Responce on New Competency required in this <?php echo $comp_detail['name']; ?></h6>
										</div>
										<div class="pull-right">
											<a class="btn btn-xs btn-primary" onclick="addsource_details_position(<?php echo $comp_detail['category_id']; ?>);">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
											<a class="btn btn-danger btn-xs" onclick="delete_position(<?php echo $comp_detail['category_id']; ?>);">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="table-responsive">
										
										<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="assessement_position<?php echo $comp_detail['category_id']; ?>">
											<thead>
											<tr>
												<th style="width:5%">Select</th>
												<th style="width:35%">Competency Name</th>
												<th style="width:20%">Suggested Level</th>
												<th style="width:20%">Reason</th>
											</tr>
											</thead>
											<tbody>
											<?php
											$cat_level=UlsCategory::get_cat_name($comp_detail['category_id']);
											$level_scale=UlsLevelMasterScale::levelscale($cat_level['level_id']);
											$position_details=UlsPositionCompetencyTempTray::get_manager_validation_competencies($_REQUEST['val_id'],$_REQUEST['pos_id'],$comp_detail['category_id']);
											if(!empty($position_details)){
												$hide_val=array();
												foreach($position_details as $key=>$position_detail){ 
													$key1=$key+1; $hide_val[]=$key1;
													?>
													<tr id='subgrd_position_<?php echo $comp_detail['category_id']; ?>_<?php echo $key1; ?>'>
														<td><label><input type="checkbox" id="chkbox_<?php echo $comp_detail['category_id']; ?>_<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $position_detail['pos_comp_tray_id'];?>" ></label>
														<input type="hidden" id="pos_comp_tray_id_<?php echo $comp_detail['category_id']; ?>_<?php echo $key1; ?>" name="pos_comp_tray_id_<?php echo $comp_detail['category_id']; ?>[]" value="<?php echo $position_detail['pos_comp_tray_id'];?>">
														</td>
														<td>
															<input type="text" name="competency_name_<?php echo $comp_detail['category_id']; ?>[]" id="competency_name<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($position_detail['competency_name']))?$position_detail['competency_name']:''?>">
														</td>
														<td>
															<select class="form-control m-b" name="require_scale_id_<?php echo $comp_detail['category_id']; ?>[]" id="require_scale_id_<?php echo $comp_detail['category_id']; ?>_<?php echo $key1; ?>">
																<option value="">Select</option>
																<?php 
																foreach($level_scale as $scales){
																	$levelscale=!empty($position_detail['require_scale_id'])?$position_detail['require_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
																	?>
																	<option value='<?php echo $scales['scale_id'];?>' <?php echo $levelscale;?>><?php echo $scales['scale_name'];?></option>
																<?php
																}
																?>
															</select>
														</td>
														<td>
															<input type="text" name="reason_<?php echo $comp_detail['category_id']; ?>[]" id="reason_<?php echo $comp_detail['category_id']; ?>_<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($position_detail['reason']))?$position_detail['reason']:''?>" >
														</td>
													</tr>
												<?php 
												}
												$hidden_position=@implode(',',$hide_val);
											}
											else{?>
												<tr id='subgrd_position_<?php echo $comp_detail['category_id']; ?>_1'>
													<td><label><input type="checkbox" id="chkbox_<?php echo $comp_detail['category_id']; ?>_1" name="chkbox[]" value=""></label>
													<input type="hidden" id="pos_comp_tray_id_<?php echo $comp_detail['category_id']; ?>_1" name="pos_comp_tray_id_<?php echo $comp_detail['category_id']; ?>[]" value="">
													</td>
													<td>
														<input type="text" name="competency_name_<?php echo $comp_detail['category_id']; ?>[]" id="competency_name_<?php echo $comp_detail['category_id']; ?>_1" class='form-control'>
													</td>
													<td>
														<select class="form-control m-b" name="require_scale_id_<?php echo $comp_detail['category_id']; ?>[]" id="require_scale_id_<?php echo $comp_detail['category_id']; ?>_1">
															<option value="">Select</option>
															<?php 
															foreach($level_scale as $scales){
																?>
																<option value='<?php echo $scales['scale_id'];?>'><?php echo $scales['scale_name'];?></option>
															<?php
															}
															?>
														</select>
													</td>
													<td>
														<input type="text" name="reason_<?php echo $comp_detail['category_id']; ?>[]" id="reason_<?php echo $comp_detail['category_id']; ?>_1" class='form-control'>
													</td>
												</tr>
											<?php 
												$hidden_position=1;
											} ?>
											</tbody>
											<input type="hidden" name="addgroup_position_<?php echo $comp_detail['category_id']; ?>" id="addgroup_position_<?php echo $comp_detail['category_id']; ?>" value="<?php echo $hidden_position; ?>" />
										</table>
									</div>
									<script>
									function addsource_details_position(cat_id){
										var hiddtab="addgroup_position_"+cat_id;
										var ins=document.getElementById(hiddtab).value;
										if(ins!=''){
											var ins1=ins.split(",");
											var temp=0;
											for( var j=0;j<ins1.length;j++){
												if(ins1[j]>temp){
													temp=parseInt(ins1[j]);
												}
											}
											var maxa=Math.max(ins1);
											sub_iteration=parseInt(temp)+1;
											for( var j=0;j<ins1.length;j++){
												var i=ins1[j]; 
												var competency_name=document.getElementById('competency_name_'+cat_id+'_'+i).value;
												var require_scale_id=document.getElementById('require_scale_id_'+cat_id+'_'+i).value;
												if(competency_name==''){
													toastr.error("Please Enter Competency Name.");
													return false;
												}
												if(require_scale_id==''){
													toastr.error("Please Select Scale name.");
													return false;
												}
												for( var k=0;k<ins1.length;k++){
													l=ins1[k];
													var competency_name1=document.getElementById('competency_name_'+cat_id+'_'+l).value;
													if(k!=j){
														if(competency_name==competency_name1){
															toastr.error("Competency name should be Unique");
															return false;
														}
													}
												}
											}	
											sub_iteration=parseInt(temp)+1; 
										}
										else{
											sub_iteration=1;
											ins1=1;
											var ins1=Array(1);
										}
										
										$("#assessement_position"+cat_id).append("<tr id='subgrd_position_"+cat_id+"_"+sub_iteration+"'><td><input type='checkbox' id='chkbox_"+cat_id+"_"+sub_iteration+"' name='chkbox[]' value='"+sub_iteration+"'><input type='hidden' id='pos_comp_tray_id_"+cat_id+"_"+sub_iteration+"' name='pos_comp_tray_id_"+cat_id+"[]' value=''></td><td><input type='text' name='competency_name_"+cat_id+"[]' id='competency_name_"+cat_id+"_"+sub_iteration+"' class='form-control'></td><td><select name='require_scale_id_"+cat_id+"[]' id='require_scale_id_"+cat_id+"_"+sub_iteration+"' class='form-control m-b'><option value=''>Select</option><?php foreach($level_scale as $scales){?><option value='<?php echo $scales['scale_id'];?>'><?php echo $scales['scale_name'];?></option><?php } ?></select></td><td><input type='text' name='reason_"+cat_id+"[]' id='reason_"+cat_id+"_"+sub_iteration+"' class='form-control'></td></tr>");
										if(document.getElementById(hiddtab).value!=''){
											var ins=document.getElementById(hiddtab).value;
											document.getElementById(hiddtab).value=ins+","+sub_iteration;
										}
										else{
											document.getElementById(hiddtab).value=sub_iteration;
										}

									}
									
									function delete_position(cat_id){
										var hiddtab="addgroup_position_"+cat_id;
										var ins=document.getElementById(hiddtab).value;
										var arr1=ins.split(",");
										var flag=0;
										var tbl = document.getElementById('assessement_position'+cat_id);
										var lastRow = tbl.rows.length;
										for(var i=(arr1.length-1); i>=0; i--){
											var bb=parseInt(arr1[i]);
											var a="chkbox_"+cat_id+"_"+bb;
											if(document.getElementById(a).checked){
												var b=document.getElementById(a).value;
												var c="subgrd_position_"+cat_id+"_"+bb+"";
												//alert(b);
												var pos_comp_tray_id=document.getElementById("pos_comp_tray_id_"+cat_id+"_"+bb).value;
												//alert(calendar_act_id);
												if(pos_comp_tray_id!=' '){
													$.ajax({
														url: BASE_URL+"/employee/delete_validation_competency",
														global: false,
														type: "POST",
														data: ({val : pos_comp_tray_id}),
														dataType: "html",
														async:false,
														success: function(msg){
														}
													}).responseText;
												} 
												for(var j=(arr1.length-1); j>=0; j--) {
													if(parseInt(arr1[j])==bb) {
														arr1.splice(j, 1);
														break;
													}  
												}
												flag++;
												$("#"+c).remove();
											}
										}
										if(flag==0){
											toastr.error("Please select the Value to Delete");
											return false;
										}
										document.getElementById(hiddtab).value=arr1;
									}
									</script>
									<?php } ?>
									<hr class="light-grey-hr">
									<div class="form-group">
										<div class="col-sm-offset-9">
											<button class="btn btn-danger btn-sm" type="button" onclick="createmp_link('employee_pos_validation')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
											<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit" onclick="return addsource_details_position_validation();"><i class="fa fa-check"></i> Next</button>
										</div>
									</div>
									</form>
								</div>
								
							</div>
						</div>
					</div>
					<div id="enrol-info" class="p-m tab-pane">
						<div class="">
							<div class="panel-body">
								<div class="alert alert-info alert-dismissable alert-style-1">
									<i class="zmdi zmdi-info-outline"></i>Given under are the KRA's required for your job.<br>
									You are<br>
									A. Required to edit the KRS's as prescribed by HR/Consultant.<br>
									B. Add any additional KRA's that you may think are required for your carry out your job.
								</div>
								<h6 class="txt-dark capitalize-font">KRA Validation</h6>
								<hr class="light-grey-hr">
								<form id="case_master" action="<?php echo BASE_URL;?>/manager/validation_position_kra_insert" method="post" enctype="multipart/form-data">
								<input type="hidden" name="val_id" id="val_id" value="<?php echo $_REQUEST['val_id']?>">
								<input type="hidden" name="position_id" id="position_id" value="<?php echo $_REQUEST['pos_id'];?>">
								<input type="hidden" name="val_pos_id" id="val_pos_id" value="<?php echo !empty($_REQUEST['val_pos_id'])?$_REQUEST['val_pos_id']:'';?>">
								<div class="table-responsive">
									<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
										<thead>
										<tr>
											<th>KRA</th>
											<th>KPI</th>
											<th>UOM</th>
											<th>View</th>
										</tr>
										</thead>
										<tbody>
										<tbody>
										<?php
										if(isset($emp_kra_validation_details)){
										foreach($emp_kra_validation_details as $emp_kra_validation_detail){
											$datas=trim($emp_kra_validation_detail['kra_master_name']);
											if(!empty($datas)){
										?>
										<tr>
											<td>
											
											<?php echo $emp_kra_validation_detail['kra_master_name'];?></td>
											<td><?php echo $emp_kra_validation_detail['kra_kri'];?></td>
											<td><?php echo $emp_kra_validation_detail['kra_uom'];?>
											</td>
											<td>
												<a role='button' data-toggle='collapse' data-parent='#accordion_<?php echo $emp_kra_validation_detail['kra_id']; ?>' href='#collapse_kra_<?php echo $emp_kra_validation_detail['kra_id']; ?>' aria-expanded='true'><i class='fa fa-plus'></i></a>
											</td>
										</tr>
										<tr>
											<td colspan='3'>
												<div id='collapse_kra_<?php echo $emp_kra_validation_detail['kra_id']; ?>' class='panel-collapse collapse' role='tabpanel'>
													<div class='panel-body'>
														<div class="col-sm-8">
															<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="assessement_position">
																<thead>
																<tr>
																	<th class="col-md-4">Employee Name</th>
																	<th class="col-md-3">Require</th>
																	<th class="col-md-5">Reason</th>
																</tr>
																</thead>
																<tbody>
																<?php 
																$emp_add_kra=UlsPositionKraTemp::get_employee_kra($_REQUEST['val_id'],$_REQUEST['pos_id'],$emp_kra_validation_detail['kra_id']);
																foreach($emp_add_kra as $emp_add_kras){
																?>
																	<tr>
																		<td><?php echo $emp_add_kras['employee_number']."-".$emp_add_kras['full_name'];?></td>
																		<td><?php echo $emp_add_kras['req_process'];?></td>
																		<td><?php echo $emp_add_kras['reason'];?></td>
																	</tr>
																<?php
																}
																?>
																</tbody>
															</table>
														</div>
														<div class="col-sm-4">
															<div class="form-wrap">
																<input type="hidden" name="pos_kra_temp_id[]" value="<?php echo !empty($emp_kra_validation_detail['pos_kra_temp_id'])?$emp_kra_validation_detail['pos_kra_temp_id']:"";?>">
																<input type="hidden" name="comp_kra_id[]" value="<?php echo $emp_kra_validation_detail['kra_id'];?>" >
																<div class="form-group">
																	<label for="email_de" class="control-label mb-10">Require:</label>
																	<select name='required_process[]' id='required_process[]' class='validate[required] form-control m-b'>
																		<option value=''>Select</option>
																		<?php 
																		foreach($require as $requires){
																			if($requires['code']!='M'){
																				$final_req=!empty($emp_kra_validation_detail['required_process'])?$emp_kra_validation_detail['required_process']==$requires['code']?"selected='selected'":"":"";
																			?>
																			<option value="<?php echo $requires['code']; ?>" <?php echo $final_req; ?>><?php echo $requires['name']; ?></option>
																		<?php
																			}
																		}
																		?>
																	</select>
																</div>
																<div class="form-group">
																	<label for="pwd_de" class="control-label mb-10">Reason:</label>
																	<textarea rows="3" class="form-control" name="reason[]"><?php echo !empty($emp_kra_validation_detail['reason'])?$emp_kra_validation_detail['reason']:"";?></textarea>
																</div>
																
															</div>
														</div>
													</div>
												</div>
											</td>
										</tr>
										<?php
											} 
										}
										}
										?>
										</tbody>
									</table>
								</div>
								<div class="panel-heading hbuilt">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Employee Added New KRA's</h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="table-responsive">
									<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
										<thead>
										<tr>
											<th>Employee Number</th>
											<th>Employee Name</th>
											<th>View</th>
										</tr>
										</thead>
										<tbody>
										<?php 
										foreach($emp_val_details as $emp_val_kradetail){
										?>
											<tr>
												<td><?php echo $emp_val_kradetail['employee_number'];?></td>
												<td><?php echo $emp_val_kradetail['full_name'];?></td>
												<td><a role='button' data-toggle='collapse' data-parent='#accordion_<?php echo $emp_val_kradetail['employee_id']; ?>' href='#collapse_emp_kra_<?php echo $emp_val_kradetail['employee_id']; ?>' aria-expanded='true'><i class='fa fa-plus'></i></a></td>
											</tr>
											<tr>
												<td colspan='3'>
													<div id='collapse_emp_kra_<?php echo $emp_val_kradetail['employee_id']; ?>' class='panel-collapse collapse' role='tabpanel'>
														<div class='panel-body pa-15'>
															<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="assessement_position">
																<thead>
																<tr>
																	<th>KRA</th>
																	<th>KPI</th>
																	<th>UOM</th>
																	<th>Reason</th>
																</tr>
																</thead>
																<tbody>
																<?php 	
																$emp_add_kra=UlsPositionKraTempTray::get_admin_validation_kra($_REQUEST['val_id'],$_REQUEST['pos_id'],$emp_val_detail['employee_id']);
																foreach($emp_add_kra as $emp_add_kras){
																?>
																	<tr>
																		<td><?php echo $emp_add_kras['kra_des'];?></td>
																		<td><?php echo $emp_add_kras['kra_kri'];?></td>
																		<td><?php echo $emp_add_kras['kra_uom'];?></td>
																		<td><?php echo $emp_add_kras['reason'];?></td>
																	</tr>
																<?php
																}
																?>
																</tbody>
															</table>
														</div>
													</div>
												</td>
											</tr>
										<?php } ?>
										</tbody>
									</table>
								</div>
								<div class="panel-heading hbuilt">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Add New KRA's</h6>
									</div>
									<div class="pull-right">
										<a class="btn btn-xs btn-primary" onclick="addsource_details_kra();">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
										<a class="btn btn-danger btn-xs" onclick="delete_kra();">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="table-responsive">
									<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="assessement_kra">
										<thead>
										<tr>
											<th style="width:5%">Select</th>
											<th style="width:35%">KRA</th>
											<th style="width:20%">KPI</th>
											<th style="width:20%">UOM</th>
											<th style="width:20%">Reason</th>
										</tr>
										</thead>
										<tbody>
										<?php
										if(!empty($man_kra_details)){
											$hide_val=array();
											foreach($man_kra_details as $key=>$emp_kra_detail){ 
												$key1=$key+1; $hide_val[]=$key1;
												?>
												<tr id='subgrd_kra_<?php echo $key1; ?>'>
													<td><label><input type="checkbox" id="chkbox_<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $emp_kra_detail['pos_kra_tray_id'];?>" ></label>
													<input type="hidden" id="pos_kra_tray_id_<?php echo $key1; ?>" name="pos_kra_tray_id[]" value="<?php echo $emp_kra_detail['pos_kra_tray_id'];?>">
													</td>
													<td>
														<input type="text" name="kra_des[]" id="kra_des_<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($emp_kra_detail['kra_des']))?$emp_kra_detail['kra_des']:''?>">
													</td>
													<td>
														<input type="text" name="kra_kri[]" id="kra_kri_<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($emp_kra_detail['kra_kri']))?$emp_kra_detail['kra_kri']:''?>">
													</td>
													<td>
														<input type="text" name="kra_uom[]" id="kra_uom_<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($emp_kra_detail['kra_uom']))?$emp_kra_detail['kra_uom']:''?>">
													</td>
													<td>
														<input type="text" name="reason_kra[]" id="reason_kra_<?php echo $key1; ?>" class='form-control' value="<?php echo (isset($emp_kra_detail['reason']))?$emp_kra_detail['reason']:''?>" >
													</td>
												</tr>
											<?php 
											}
											$hidden_position=@implode(',',$hide_val);
										}
										else{?>
											<tr id='subgrd_kra_1'>
												<td><label><input type="checkbox" id="chkbox_1" name="chkbox[]" value=""></label>
												<input type="hidden" id="pos_kra_tray_id_1" name="pos_kra_tray_id[]" value="">
												</td>
												<td>
													<input type="text" name="kra_des[]" id="kra_des_1" class='form-control'>
												</td>
												<td>
													<input type="text" name="kra_kri[]" id="kra_kri_1" class='form-control' value="">
												</td>
												<td>
													<input type="text" name="kra_uom[]" id="kra_uom_1" class='form-control' value="">
												</td>
												<td>
													<input type="text" name="reason_kra[]" id="reason_kra_1" class='form-control'>
												</td>
											</tr>
										<?php 
											$hidden_position=1;
										} ?>
										</tbody>
										<input type="hidden" name="addgroup_kra" id="addgroup_kra" value="<?php echo $hidden_position; ?>" />
									</table>
								</div>
								<hr class="light-grey-hr">
								<div class="form-group">
									<div class="col-sm-offset-9">
										<button class="btn btn-danger btn-sm" type="button" onclick="createmp_link('employee_pos_validation')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
										<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit" onclick="return addsource_details_position_validation();"><i class="fa fa-check"></i> Submit</button>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
					<div id="final-info" class="p-m tab-pane">
						<div class="">
							<div class="panel-body">
								<div class="alert alert-info alert-dismissable alert-style-1">
									<i class="zmdi zmdi-info-outline"></i>Given under are the KRA's required for your job.<br>
									You are<br>
									A. Required to edit the KRS's as prescribed by HR/Consultant.<br>
									B. Add any additional KRA's that you may think are required for your carry out your job.
								</div>
								<h6 class="txt-dark capitalize-font">KRA Validation</h6>
								<hr class="light-grey-hr">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


