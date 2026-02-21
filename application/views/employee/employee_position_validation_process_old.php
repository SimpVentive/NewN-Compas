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
					if(isset($_REQUEST['val_id'])){
						
					?>
						<li id='profile_li'><a data-toggle="tab" href="#profile-info">Step 1 - Position JD</a></li>
						<li id='information_li'><a data-toggle="tab" href="#information-info">Step 2 - JD Validation</a></li>
						<li id='competency_li'><a data-toggle="tab" href="#competency-info">Step 3 - Competency Profile Validation</a></li>
						<li id='enrol_li'><a data-toggle="tab" href="#enrol-info">Step 4 - KRA's Validation</a></li>
					<?php }
					else{
					?>
						<li id='profile_li' class="active"><a data-toggle="tab" href="#profile-info">Step 1 - Position JD</a></li>
						<li id='information_li' style="pointer-events:none;"><a data-toggle="tab" href="#information-info">Step 2 - JD Validation</a></li>
						<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#competency-info">Step 3 - Competency Profile Validation</a></li>
						<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#enrol-info">Step 4 - KRA's Validation</a></li>
					<?php
					}
					?>
				</ul>
				<div class="tab-content">
					<div id="profile-info" class="p-m tab-pane active">
						<div class="">
							<div class="panel-body">
								<h6 class="txt-dark capitalize-font"><?php echo @$posdetails['position_name']; ?> <small>(<?php echo @$posdetails['value_name']; ?>)</small></h6>
								<hr class="light-grey-hr">
								<form id="assessment_master_new" action="<?php echo BASE_URL;?>/admin/position_validation_insert" method="post" enctype="multipart/form-data" class="form-horizontal">
									<h5>Role Profile</h5>
									<div class="col-lg-12">
										<p>
											<strong>Reports to</strong>:<?php echo @$posdetails['reportsto']; ?>
										</p>
										<p>
											<strong>Reportees</strong>:<?php echo @$posdetails['reportees_name']; ?>
										</p>
										<p>
											<strong>Grade</strong>:<?php echo @$posdetails['grade_name']; ?>
										</p>
										<p>
											<strong>Business</strong>:<?php echo @$posdetails['bu_name']; ?>
										</p>
										<p>
											<strong>Function</strong>:<?php echo @$posdetails['position_org_name']; ?>
										</p>
										<p>
											<strong>Location</strong>:<?php echo @$posdetails['location_name']; ?>
										</p>
									</div>
									<h6>Purpose</h6>
									<div class="col-lg-12">
										<p>
											<?php echo @$posdetails['position_desc']; ?>
										</p>
									</div>
									<h6>Accountabilities</h6>
									<div class="col-lg-12">
										<?php echo @$posdetails['accountablities']; ?>
									</div>
									<h6>Responsibilities</h6>
									<div class="col-lg-12">
										<?php echo @$posdetails['responsibilities']; ?>
									</div>

									<h6>Position Requirements</h6>
									<div class="col-lg-12">
										<p>
											<strong>Education Background</strong>:<?php echo @$posdetails['education']; ?>
										</p>
										<p>
											<strong>Experience</strong>:<?php echo @$posdetails['experience']; ?>
										</p>
										<p>
											<strong>Industry Specific Experience</strong>:<?php echo @$posdetails['specific_experience']; ?>
										</p>
									</div>
									<?php if(!empty($posdetails['other_requirement'])){ ?>
									<h6>Other Requirements</h6>
									<div class="col-lg-12">
										<p>
											<?php echo @$posdetails['other_requirement']; ?>
										</p>
									</div>
									<?php } ?>
									<ul class="nav nav-pills">
										<li class="active"><a data-toggle="tab" href="#tab-compentencies<?php echo $posdetails['position_id']; ?>"> Competency Requirements</a></li>
										<li class=""><a data-toggle="tab" href="#tab-employees<?php echo $posdetails['position_id']; ?>"> Key Result Areas</a></li>
									</ul>
									<div class="tab-content ">
										<div id="tab-compentencies<?php echo $posdetails['position_id']; ?>" class="tab-pane active">
										
											<div class="panel-body">
												<div class="table-responsive">
													<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
														<thead>
														<tr>
															<th>Competencies</th>
															<!--<th>Level</th>-->
															<th>Required Level</th>
															<th>Criticality</th>
														</tr>
														</thead>
														<tbody>
														<?php //<td>".$competency['level_name']."</td>
														foreach($competencies as $competency){
															if($competency['comp_position_id']==$posdetails['position_id']){
																$hash=SECRET.$competency['comp_def_id'];
																echo "<tr><td>".$competency['comp_def_name']."</td>
																<td>".$competency['scale_name']."</td>
																<td>".$competency['comp_cri_name']."</td></tr>";
															}
														} ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div id="tab-employees<?php echo $posdetails['position_id']; ?>" class="tab-pane">
											<div class="panel-body">
												<div class="table-responsive">
													<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
														<thead>
														<tr>
															<th>KRA</th>
															<th>KPI</th>
															<th>UOM</th>
														</tr>
														</thead>
														<tbody>
														<?php
														$temp="";
														foreach($kras as $kra){
															if($kra['comp_position_id']==$posdetails['position_id']){
																echo "<tr><td>";
																if($temp!=$kra['kra_master_name']){
																	echo $kra['kra_master_name'];
																	$temp=$kra['kra_master_name'];
																}
																echo "</td><td>".$kra['kra_kri']."</td><td>".$kra['kra_uom']."</td></tr>";
															}
														} ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<hr class="light-grey-hr">
									<div class="form-group">
										<div class="col-sm-offset-9">
										   <button class="btn btn-danger btn-sm" type="button" onclick="createmp_link('employee_pos_validation')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
										   <a class="btn btn-primary btn-sm" href="<?php echo BASE_URL; ?>/employee/employee_validation_details?status=information&val_id=<?php echo $_REQUEST['val_id']; ?>&position_id=<?php echo $_REQUEST['position_id']; ?>&val_pos_id=<?php echo $_REQUEST['val_pos_id']; ?>"><i class="fa fa-check"></i> Next</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div id="information-info" class="p-m tab-pane">
						<div class="">
							<div class="panel-body">
								<div class="alert alert-info alert-dismissable alert-style-1">
									<i class="zmdi zmdi-info-outline"></i>Please edit the Accountabilities and Responsibilities as required.
								</div>
								<h6 class="txt-dark capitalize-font">Position Validation</h6>
								
								<hr class="light-grey-hr">
								<form id="assessment_master" action="<?php echo BASE_URL;?>/employee/employee_position_validation_insert" method="post" enctype="multipart/form-data" class="form-horizontal">
									<input type="hidden" name="val_id" id="val_id" value="<?php echo $_REQUEST['val_id']?>">
									<input type="hidden" name="position_id" id="position_id" value="<?php echo $_REQUEST['position_id'];?>">
									<input type="hidden" name="val_pos_id" id="val_pos_id" value="<?php echo $_REQUEST['val_pos_id'];?>">
									<input type="hidden" name="pos_temp_id" id="pos_temp_id" value="<?php echo (isset($emp_validation_details['pos_temp_id']))?$emp_validation_details['pos_temp_id']:''?>">
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Accountabilities:</label>
										<div class="col-sm-10">
											<textarea class="summernote form-control m-b" name="accountabilities" id="accountabilities" ><?php echo (isset($emp_validation_details['accountabilities']))?$emp_validation_details['accountabilities']:"";?></textarea>
										</div>
									</div>
									<div class="form-group"><label class="control-label mb-10 col-sm-2">Responsibilities:</label>
										<div class="col-sm-10">
											<textarea class="summernote form-control m-b" name="responsibilities" id="responsibilities" ><?php echo (isset($emp_validation_details['responsibilities']))?$emp_validation_details['responsibilities']:"";?></textarea>
										</div>
									</div>
									<hr class="light-grey-hr">
									<div class="form-group">
										<div class="col-sm-offset-9">
										   <button class="btn btn-danger btn-sm" type="button" onclick="createmp_link('employee_pos_validation')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
										   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Next</button>
										</div>
									</div>
								</form>
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
								<form id="case_master" action="<?php echo BASE_URL;?>/employee/validation_position_competency_insert" method="post" enctype="multipart/form-data">
								<input type="hidden" name="val_id" id="val_id" value="<?php echo $_REQUEST['val_id']?>">
								<input type="hidden" name="position_id" id="position_id" value="<?php echo $_REQUEST['position_id'];?>">
								<input type="hidden" name="val_pos_id" id="val_pos_id" value="<?php echo $_REQUEST['val_pos_id'];?>">
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
												<th style="width:25%">Competency name</th>
												<th style="width:18%">Required Level</th>
												<th style="width:15%">Require</th>
												<th style="width:20%">Suggested Level</th>
												<th style="width:22%">Reason</th>
											</tr>
											</thead>
											<tbody>
											<?php
											$competency=UlsPositionTemp::get_self_validation_competencies_summary($_REQUEST['val_id'],$_REQUEST['position_id'],$_REQUEST['val_pos_id'],$comp_detail['category_id']);
											foreach($competency as $competencys){
											?>
											<tr>
												
												<td scope='row'>
												<input type="hidden" name="pos_comp_temp_id[]" value="<?php echo !empty($competencys['pos_comp_temp_id'])?$competencys['pos_comp_temp_id']:"";?>">
												<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
												<?php echo $competencys['comp_def_name'];?></td>
												<td><input type="hidden" name="requiredlevel_<?php echo $competencys['comp_def_id'];?>" value="<?php echo $competencys['scale_id'];?>" >
												<?php echo $competencys['scale_name'];?></td>
												<td>
												<select name='required_process_<?php echo $competencys['comp_def_id'];?>' id='required_process_<?php echo $competencys['comp_def_id'];?>' class='validate[required] form-control m-b'>
												<option value=''>Select</option>
												<?php 
												foreach($require as $requires){
													$final_req=!empty($competencys['required_process'])?$competencys['required_process']==$requires['code']?"selected='selected'":"":"";
												?>
												<option value="<?php echo $requires['code']; ?>" <?php echo $final_req; ?>><?php echo $requires['name']; ?></option>
												<?php
												}
												?>
												</select>
												</td>
												<td>
												<?php $data="";
												$data="
												<select name='OVERALL_".$competencys['comp_def_id']."' id='OVERALL_".$competencys['comp_def_id']."' class='validate[required] form-control m-b' style='width:170px;'>
												<option value=''>Select</option>";
												$level_id=UlsCompetencyDefinition::viewcompetency($competencys['comp_def_id']);
												$scale_overall=UlsLevelMasterScale::levelscale($level_id['comp_def_level']);
												foreach($scale_overall as $scales){
													$final_scale=!empty($competencys['assessed_scale_id'])?$competencys['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
													$data.="<option value='".$scales['scale_id']."' ".$final_scale.">".$scales['scale_name']."</option>";
												}
												$data.="</select>";
												echo $data; ?>
												</td>
												<td>
													<input type="text" name="reason_<?php echo $competencys['comp_def_id'];?>" value="<?php echo !empty($competencys['reason'])?$competencys['reason']:"";?>" class='validate[required] form-control'>
												</td>
											</tr>
											<?php
											}
											?>
										</table>
									</div>
									<div class="panel-heading hbuilt">
										<div class="pull-left">
											<h6 class="panel-title txt-dark">Add New Competency required in this <?php echo $comp_detail['name']; ?></h6>
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
											$position_details=UlsPositionCompetencyTempTray::get_self_validation_competencies($_REQUEST['val_id'],$_REQUEST['position_id'],$comp_detail['category_id']);
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
								<form id="case_master" action="<?php echo BASE_URL;?>/employee/validation_position_kra_insert" method="post" enctype="multipart/form-data">
								<input type="hidden" name="val_id" id="val_id" value="<?php echo $_REQUEST['val_id']?>">
								<input type="hidden" name="position_id" id="position_id" value="<?php echo $_REQUEST['position_id'];?>">
								<input type="hidden" name="val_pos_id" id="val_pos_id" value="<?php echo $_REQUEST['val_pos_id'];?>">
								<div class="table-responsive">
									<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
										<thead>
										<tr>
											<th style="width:15%">Require</th>
											<th style="width:25%">KRA</th>
											<th style="width:18%">KPI</th>
											<th style="width:20%">UOM</th>
											<th style="width:22%">Reason</th>
										</tr>
										</thead>
										<tbody>
										<?php
										foreach($emp_kra_validation_details as $emp_kra_validation_detail){
											$datas=trim($emp_kra_validation_detail['kra_master_name']);
											if(!empty($datas)){
										?>
										<tr>
											<td>
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
											</td>
											<td scope='row'>
											<input type="hidden" name="pos_kra_temp_id[]" value="<?php echo !empty($emp_kra_validation_detail['pos_kra_temp_id'])?$emp_kra_validation_detail['pos_kra_temp_id']:"";?>">
											<input type="hidden" name="comp_kra_id[]" value="<?php echo $emp_kra_validation_detail['kra_id'];?>" ><?php echo $emp_kra_validation_detail['kra_master_name'];?></td>
											<td><?php echo $emp_kra_validation_detail['kra_kri'];?></td>
											<td><?php echo $emp_kra_validation_detail['kra_uom'];?>
											</td>
											<td>
												<input type="text" name="reason[]" value="<?php echo !empty($emp_kra_validation_detail['reason'])?$emp_kra_validation_detail['reason']:"";?>" class='validate[required] form-control'>
											</td>
										</tr>
										<?php
											} }
										?>
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
										if(!empty($emp_kra_details)){
											$hide_val=array();
											foreach($emp_kra_details as $key=>$emp_kra_detail){ 
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
				</div>
			</div>
		</div>
	</div>
</div>


