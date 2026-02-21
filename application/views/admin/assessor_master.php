<script>
<?php 
// To pass the Requested Status to empcreation.js File
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}
$competency_details='';
foreach($competency as $competencys){
    if($competency_details==''){
        $competency_details=$competencys['comp_def_id']."*".$competencys['comp_def_name'];
    }
    else{
        $competency_details=$competency_details.",".$competencys['comp_def_id']."*".$competencys['comp_def_name'];
    }
}
echo "var comp_details='".$competency_details."';";

$inst_details='';
foreach($instruments as $instrument){
    if($inst_details==''){
        $inst_details=$instrument['code']."*".$instrument['name'];
    }
    else{
        $inst_details=$inst_details.",".$instrument['code']."*".$instrument['name'];
    }
}
echo "var inst_detail='".$inst_details."';";  

$status_details='';
foreach($orgstat as $orgs){
    if($status_details==''){
        $status_details=$orgs['code']."*".$orgs['name'];
    }
    else{
        $status_details=$status_details.",".$orgs['code']."*".$orgs['name'];
    }
}
echo "var status_detail='".$status_details."';";  
?>
</script>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<ul class="nav nav-pills">
						<?php 	
						if(isset($_REQUEST['id'])){
						?>
							<li id='information_li' ><a data-toggle="tab" href="#infomation-info">Step 1 - Information</a></li>
							<li id='competency_li'><a data-toggle="tab" href="#competency-info">Step 2 - Add Eligible Competencies for Assessment</a></li>
							<li id='questions_li'><a data-toggle="tab" href="#questions-info">Step 3 - Add Certified Instruments</a></li>
						<?php }
						else{
						?>
							<li id='information_li' class="active"><a data-toggle="tab" href="#infomation-info">Step 1 - Information</a></li>
							<li class="disabled"  style="pointer-events:none;"><a data-toggle="tab" href="#competency-info">Step 2 - Add Eligible Competencies for Assessment</a></li>
							<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#questions-info">Step 3 -Add Certified Instruments</a></li>
						<?php
						}
						?>
						<br/><br/><br/>
					</ul>
					<div class="tab-content">
						<div id="infomation-info" class="p-m tab-pane active">
							<form id="assessor_master" action="<?php echo BASE_URL;?>/admin/assessor_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="assessor_id" id="assessor_id" value="<?php echo (isset($compdetails['assessor_id']))?$compdetails['assessor_id']:''?>">
							<div class="row">
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Assessor Type<sup><font color="#FF0000">*</font></sup>:</label>
									<select class="form-control m-b validate[required]" name="assessor_type" id="assessor_type" onchange="open_employee();">
										<option value="">Select</option>
										<?php 	
										foreach($assessor as $assessors){
											$sel_sat=(isset($compdetails['assessor_type']))?($compdetails['assessor_type']==$assessors['code'])?"selected='selected'":'':''?>
											<option value="<?php echo $assessors['code']?>" <?php echo $sel_sat?>><?php echo $assessors['name']?></option>
										<?php 	
										}?>
									</select>
								</div>
								<div class="form-group col-lg-6">
								<label class="control-label mb-10 text-left">&nbsp;</label>
								</div>
							</div>
							<div class="row">
								<?php 
								$type=(isset($compdetails['assessor_type']))?($compdetails['assessor_type']=='INT')?"block":'none':'none';
								?>
								<div class="form-group col-lg-6" id="employee" style="display:<?php echo $type; ?>;">
									<label class="control-label mb-10 text-left">Employee Code:</label>
									<select class="form-control m-b chosen-select" name='employee_id' id='emp_no' onchange="fetch_empdata()">
										<option value="">Select</option>
										<?php
										if(!empty($compdetails['employee_id'])){
											$emp_data=UlsEmployeeMaster::getempdetails($compdetails['employee_id']);
										?>
											<option value="<?php echo $emp_data['employee_id'] ?>" selected><?php echo $emp_data['employee_number']."-".$emp_data['full_name']; ?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="form-group col-lg-6">
									
									<label class="control-label mb-10 text-left">Assessor Name:<sup><font color="#FF0000">*</font></sup>:</label>
									<input type="text" value="<?php echo (isset($compdetails['assessor_name']))?$compdetails['assessor_name']:''?>" id="assessor_name" class="validate[required,minSize[2],maxSize[200], funcCall[checknotinteger]] form-control" name="assessor_name" data-prompt-position="topLeft:200">
								</div>
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Linkedin Profile(URL):</label>
									<input type="text" value="<?php echo (isset($compdetails['assessor_linkedin_profile']))?$compdetails['assessor_linkedin_profile']:''?>" id="assessor_linkedin_profile" class="form-control" name="assessor_linkedin_profile">
								</div>
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Profile in Brief:</label>
									<input type="text" value="<?php echo (isset($compdetails['assessor_brief']))?$compdetails['assessor_brief']:''?>" id="assessor_brief" class="form-control" name="assessor_brief">
								</div>
								
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Email:</label>
									<input type="text" value="<?php echo (isset($compdetails['assessor_email']))?$compdetails['assessor_email']:''?>" id="assessor_email" name="assessor_email" class="form-control">
								</div>
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Contact Number:</label>
									<input type="text" value="<?php echo (isset($compdetails['assessor_mobile']))?$compdetails['assessor_mobile']:''?>" id="assessor_mobile" name="assessor_mobile" class="form-control">
								</div>
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Experience in Assessing:</label>
									<input type="text" value="<?php echo (isset($compdetails['assessor_experience']))?$compdetails['assessor_experience']:''?>" id="assessor_experience" class="form-control" name="assessor_experience">
								</div>
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Previous Organization (As Assessor):</label>
									<input type="text" value="<?php echo (isset($compdetails['assessor_prev_org_name']))?$compdetails['assessor_prev_org_name']:''?>" id="assessor_prev_org_name" class="form-control" name="assessor_prev_org_name">
								</div>
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Permit to add questions:</label>
									<select class="form-control m-b" name="premission_to_add_quest" id="premission_to_add_quest">
										<option value="">Select</option>
										<?php 	
										foreach($permit as $permits){
											$sel_sat=(isset($compdetails['premission_to_add_quest']))?($compdetails['premission_to_add_quest']==$permits['code'])?"selected='selected'":'':''?>
											<option value="<?php echo $permits['code']?>" <?php echo $sel_sat?>><?php echo $permits['name']?></option>
										<?php 	
										}?>
									</select>
								</div>
								
								
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Status<sup><font color="#FF0000">*</font></sup>:</label>
									<select class="form-control m-b  validate[required]" name="assessor_status" id="assessor_status" data-prompt-position="topLeft:200">
										<option value="">Select</option>
										<?php 	
										foreach($orgstat as $orgstatus){
											$sel_sat=(isset($compdetails['assessor_status']))?($compdetails['assessor_status']==$orgstatus['code'])?"selected='selected'":'':''?>
											<option value="<?php echo $orgstatus['code']?>" <?php echo $sel_sat?>><?php echo $orgstatus['name']?></option>
										<?php 	
										}?>
									</select>
								</div>
								<div class="form-group col-lg-6">
									<label class="control-label mb-10 text-left">Image:</label>
									<?php $path=(!empty($compdetails['assessor_photo']))?BASE_URL.'/public/uploads/assessor_pic/'.$compdetails['assessor_id'].'/'.$compdetails['assessor_photo']:BASE_URL.'/public/images/male_user.jpg;'?>
									<input type="file" name="assessor_photo" id="assessor_photo" class="validate[custom[picture]]" src="<?php echo $path;?>">
									<label><?php echo (!empty($compdetails['assessor_photo']))?$compdetails['assessor_photo']:""; ?><label>
								</div>
								<div class="form-group col-lg-6">
									&nbsp;
								</div>
								
							</div>
							<?php 
							$type_ext=(isset($compdetails['assessor_type']))?($compdetails['assessor_type']=='EXT')?"block":'none':'none';
							?>
							<div class="row" id="ext_assessor" style="display:<?php echo $type_ext; ?>;">
								<h6 class="txt-dark capitalize-font">Add External Assessor Roles</h6>
								<hr class="light-grey-hr">
								<div class="form-group col-lg-3">
									<label class="control-label mb-10 text-left">Create User:</label>
									<input type='hidden' name='resr_type_ext' id='resr_type_ext' value='E'>
									<input type='hidden' name='user_start_date_ext' id='user_start_date_ext' value=''>
									<input type='hidden' name='user_end_date_ext' id='user_end_date_ext' value=''>
									<select class="form-control m-b" name="add_role_ext" id="add_role_ext" onchange='check_role()'>
										<option value="">Select</option>
										<?php 	
										foreach($permit as $yns){
											$check_ext=isset($compdetails['assessor_add_role'])?($yns['code']==$compdetails['assessor_add_role'])?"selected='selected'":"":""; 
											?>
											<option value="<?php echo $yns['code']?>" <?php echo $check_ext; ?>><?php echo $yns['name']?></option>
										<?php 	
										}?>
									</select>
								</div>
								<div id='role_name_ext' style='display:none;'>
									<div class="form-group col-lg-3">
										<label class="control-label mb-10 text-left">Username<sup><font color="#FF0000">*</font></sup>:</label>
										<input type='hidden' name='user_id_ext' id='user_id_ext' value='<?php echo @$compdetails['user_id'];?>'>
										<input type="text" value="<?php echo @$traineruserdetail['user_name']; ?>" id="user_name" class="validate[required,minSize[4],maxSize[80],funcCall[checkUserhet]] form-control" name="user_name" >
									</div>
									<div class="form-group col-lg-3">
										<label class="control-label mb-10 text-left">Password<sup><font color="#FF0000">*</font></sup>:</label>
										<input type="password" name="password" id="password" value="<?php echo @$traineruserdetail['password']; ?>" class="validate[required,minSize[4],maxSize[80]]  form-control">
									</div>
									<div class="form-group col-lg-3">
										<label class="control-label mb-10 text-left">Confirm Password:</label>
										<input type="password" name="con_password" id="con_password" value="<?php echo @$traineruserdetail['password']; ?>"  class="validate[required,minSize[4],maxSize[80],equals[password]] form-control">
									</div>
									<div class="form-group col-lg-3">
										<label class="control-label mb-10 text-left">Role Name:</label>
										<input type='hidden' name='menu_id_ext' id='menu_id_ext' value=''>
										<select id="rolename_ext" name="rolename_ext" class="validate[required] form-control f-b">
											<option value=""></option>
										</select>
									</div>
									<div class="form-group col-lg-3">
										<label class="control-label mb-10 text-left">Start date:</label>
										<div class="input-group date">
											<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="start_date_ext" id="start_date_ext" value="<?php echo @$traineruserdetail['start_date']; ?>" class="validate[custom[date2]] datepicker form-control">
											<span class="input-group-addon">
												<span class="fa fa-calendar"></span>
											</span>	
										</div>
									</div>
									<div class="form-group col-lg-3">
										<label class="control-label mb-10 text-left">End date:</label>
										<div class="input-group date">
											<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="end_date_ext" id="end_date_ext" value="<?php echo @$traineruserdetail['end_date']; ?>" class="validate[custom[date2],future[#start_date_ext]] datepicker form-control">
											<span class="input-group-addon">
												<span class="fa fa-calendar"></span>
											</span>	
										</div>
									</div>
								</div>
							</div>
							<?php 
							$type_int=(isset($compdetails['assessor_type']))?($compdetails['assessor_type']=='INT')?"block":'none':'none';
							?>
							<div class="row"  id="int_assessor" style="display:<?php echo $type_int; ?>;">
								<h6 class="txt-dark capitalize-font">Add Internal Assessor Roles</h6>
								<hr class="light-grey-hr">
								<input type='hidden' name='resr_type_int' id='resr_type_int' value='I'>
								<input type='hidden' name='user_id_int' id='user_id_int' value=''>
								<input type='hidden' name='user_start_date_int' id='user_start_date_int' value=''>
								<input type='hidden' name='user_end_date_int' id='user_end_date_int' value=''>
								<div class="form-group col-lg-3">
									<label class="control-label mb-10 text-left">Add Role:</label>
									<select class="form-control m-b" name="add_role_int" id="add_role_int" onchange="check_user();">
										<option value="">Select</option>
										<?php 	
										foreach($permit as $yn){
											$check=isset($compdetails['assessor_add_role'])?($yn['code']==$compdetails['assessor_add_role'])?"selected='selected'":"":"";
											if(empty($check) && !isset($compdetails['assessor_add_role']) && $yn['code']=="N"){$check="selected='selected'";}
											?>
											<option value="<?php echo $yn['code']?>" <?php echo $check; ?>><?php echo $yn['name']?></option>
										<?php 	
										}?>
									</select>
								</div>
								<div id="role_name_int" style="display: none;">
									<div class="form-group col-lg-3">
										<label class="control-label mb-10 text-left">Role Name<sup><font color="#FF0000">*</font></sup>:</label>
										<input type='hidden' name='menu_id_int' id='menu_id_int' value=''>
										<select id="rolename_int" name="rolename_int" class="validate[required] form-control m-b">
										</select>
									</div>
								
									<div class="form-group col-lg-3">
										<label class="control-label mb-10 text-left">Start date<sup><font color="#FF0000">*</font></sup>:</label>
										<div class="input-group date">
											<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="start_date_int" id="start_date_int" value="" class="validate[custom[date2], future[#user_start_date_int], past[#user_start_date_int]] datepicker form-control">
											<span class="input-group-addon">
												<span class="fa fa-calendar"></span>
											</span>	
										</div>
									</div>
									<div class="form-group col-lg-3">
										<label class="control-label mb-10 text-left">End date<sup><font color="#FF0000">*</font></sup>:</label>
										<div class="input-group date">
											<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="end_date_int" id="end_date_int" value="" class="validate[custom[date2], custom[date2], future[#start_date_int], past[#user_end_date_int]] datepicker form-control">
											<span class="input-group-addon">
												<span class="fa fa-calendar"></span>
											</span>	
										</div>
									</div>
								</div>
							</div>
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
									<button class="btn btn-danger btn-sm" type="button" onclick="create_link('assessor_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
									<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
								</div>
							</div>
							</form>
						</div>
						<div id="competency-info" class="p-m tab-pane">
							<form id="assessor_comp" action="<?php echo BASE_URL;?>/admin/assessor_competency_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="assessor_id" id="assessor_id" value="<?php echo (isset($compdetails['assessor_id']))?$compdetails['assessor_id']:''?>">
							<div class="row">
								<div class="col-lg-12">
									<div class="row">
										<div class="panel-heading hbuilt">
											
											<div class="pull-left">
												<h6 class="panel-title txt-dark">Add Competencies</h6>
											</div>
											<div class="pull-right">
												<a class="btn btn-xs btn-primary" onClick="return addsource_details_assessor()">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
												<a class="btn btn-danger btn-xs" onClick="delete_casestudy()">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
											</div>
											<div class="clearfix"></div>
										</div>
										
										<div class="table-responsive">
											<table id="source_table_programs"  cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
												<thead>
												<tr>
													<th class="col-md-1">Select</th>
													<th class="col-md-6">Competency Name</th>
													<th class="col-md-2">Level Name</th>
													<th class="col-md-3">Level Scale</th>
												</tr>
												</thead>
												<tbody>
												<?php
												if(!empty($assessor_comp)){
													$hide_val=array();
													foreach($assessor_comp as $key=>$assessor_comps){ 
														$key1=$key+1; $hide_val[]=$key1;
														?>
														<tr id='subgrd<?php echo $key1; ?>'>
															<td><label><input type="checkbox" id="chkbox<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $assessor_comps['assessor_comp_id'];?>" ></label>
															<input type="hidden" id="assessor_comp_id<?php echo $key1; ?>" name="assessor_comp_id[]" value="<?php echo $assessor_comps['assessor_comp_id'];?>">
															</td>
															<td>
																<select class="form-control m-b" name="assessor_competencies[]" id="assessor_competencies<?php echo $key1; ?>" onchange="open_level(<?php echo $key1; ?>);">
																	<option value="">Select</option>
																	<?php 
																	foreach($competency as $competencys){
																		$cat_sel=isset($assessor_comps['assessor_competencies'])?($assessor_comps['assessor_competencies']==$competencys['comp_def_id'])?"selected='selected'":"":"";
																		?>
																		<option value="<?php echo $competencys['comp_def_id'];?>" <?php echo $cat_sel; ?>><?php echo $competencys['comp_def_name'];?></option>
																	<?php
																	}
																	?>
																</select>
															</td>
															<td>
																<select class="form-control m-b" name="assessor_levels[]" id="assessor_levels<?php echo $key1; ?>" onchange="open_scale(<?php echo $key1; ?>);">
																	<option value="">Select</option>
																	<?php 
																	$comp_def=UlsCompetencyDefinition::viewcompetency($assessor_comps['assessor_competencies']);
																	$cat_sel=isset($assessor_comps['assessor_levels'])?($assessor_comps['assessor_levels']==$comp_def['comp_def_level'])?"selected='selected'":"":"";
																	?>
																	<option value="<?php echo $comp_def['comp_def_level'];?>" <?php echo $cat_sel; ?>><?php echo $comp_def['level'];?></option>
																</select>
															</td>
															<td>
																<select class="form-control m-b" name="assessor_scale[]" id="assessor_scale<?php echo $key1; ?>">
																	<option value="">Select</option>
																	<?php 
																	$comp_level=UlsLevelMasterScale::levelscale($assessor_comps['assessor_levels']);
																	foreach($comp_level as $comp_levels){
																		$cat_sels=isset($assessor_comps['assessor_scale'])?($assessor_comps['assessor_scale']==$comp_levels['scale_id'])?"selected='selected'":"":"";
																		?>
																		<option value="<?php echo $comp_levels['scale_id'];?>" <?php echo $cat_sels; ?>><?php echo $comp_levels['scale_name'];?></option>
																	<?php
																	}
																	?>
																</select>
															</td>
														</tr>
													<?php 
													}
													$hidden=@implode(',',$hide_val);
												}
												else{?>
													<tr id='subgrd1'>
														<td><label><input type="checkbox" value=""></label>
														<input type="hidden" id="assessor_comp_id1" name="assessor_comp_id[]" value="">
														</td>
														<td>
															<select class="form-control m-b" name="assessor_competencies[]" id="assessor_competencies1"  onchange="open_level(1);">
																<option value="">Select</option>
																<?php 
																foreach($competency as $competencys){
																	?>
																	<option value="<?php echo $competencys['comp_def_id'];?>"><?php echo $competencys['comp_def_name'];?></option>
																<?php
																}
																?>
															</select>
														</td>
														<td>
															<select class="form-control m-b" name="assessor_levels[]" id="assessor_levels1" onchange="open_scale(1);">
																<option value="">Select</option>
															</select>
														</td>
														<td>
															<select class="form-control m-b" name="assessor_scale[]" id="assessor_scale1">
																<option value="">Select</option>
																
															</select>
														</td>
													</tr>
												<?php 
													$hidden=1;
												} ?>
												</tbody>
												<input type="hidden" name="addgroup" id="addgroup" value="<?php echo $hidden; ?>" />
											</table>
										</div>
									</div>
								</div>
							</div>
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
									<button class="btn btn-danger btn-sm" type="button" onclick="create_link('assessor_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
									<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit" onClick="return addsource_details_assessor_validation(2);"><i class="fa fa-check"></i> Submit</button>
								</div>
							</div>
							</form>
						</div>
						<div id="questions-info" class="p-m tab-pane">
							<form id="assessor_comp" action="<?php echo BASE_URL;?>/admin/assessor_instrument_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="assessor_id" id="assessor_id" value="<?php echo (isset($compdetails['assessor_id']))?$compdetails['assessor_id']:''?>">
							<div class="row">
								<div class="col-lg-12">
									<div class="row">
										<div class="panel-heading hbuilt">
											
											<div class="pull-left">
												<h6 class="panel-title txt-dark">Add Certified Instruments</h6>
											</div>
											<div class="pull-right">
												<a class="btn btn-xs btn-primary" onClick="return addsource_details_certified()">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
												<a class="btn btn-danger btn-xs" onClick="delete_certified()">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="table-responsive">
											<table id="source_table_certified"  cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
												<thead>
												<tr>
													<th>Select</th>
													<th>Instrument Name</th>
													<th>Expiry Date</th>
												</tr>
												</thead>
												<tbody>
												<?php
												if(!empty($assessor_int)){
													$hide_val=array();
													foreach($assessor_int as $key=>$assessor_ints){ 
														$key1=$key+1; $hide_val[]=$key1;
														?>
														<tr id='subgrd_inst<?php echo $key1; ?>'>
															<td><label><input type="checkbox" id="chkbox_inst<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $assessor_ints['assessor_instrument_id'];?>" ></label>
															<input type="hidden" id="assessor_instrument_id<?php echo $key1; ?>" name="assessor_instrument_id[]" value="<?php echo $assessor_ints['assessor_instrument_id'];?>">
															</td>
															<td>
																<select class="form-control m-b" name="assessor_instrument_name[]" id="assessor_instrument_name<?php echo $key1; ?>" onchange="open_level(<?php echo $key1; ?>);">
																	<option value="">Select</option>
																	<?php 
																	foreach($instruments as $instrument){
																		$cat_sel=isset($assessor_ints['assessor_instrument_name'])?($assessor_ints['assessor_instrument_name']==$instrument['code'])?"selected='selected'":"":"";
																		?>
																		<option value="<?php echo $instrument['code'];?>" <?php echo $cat_sel; ?>><?php echo $instrument['name'];?></option>
																	<?php
																	}
																	?>
																</select>
															</td>
															<td>
																<div class="input-group date">
																	<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="assessor_instrument_expiry[]" id="assessor_instrument_expiry<?php echo $key1; ?>" value="<?php echo (isset($assessor_ints['assessor_instrument_expiry']))?(date('d-m-Y',strtotime($assessor_ints['assessor_instrument_expiry']))):''?>" class="validate[custom[date2]] datepicker form-control">
																	<span class="input-group-addon">
																		<span class="fa fa-calendar"></span>
																	</span>	
																</div>
															</td>
															<td>
																<select class="form-control m-b" name="assessor_instrument_status[]" id="assessor_instrument_status<?php echo $key1; ?>">
																	<option value="">Select</option>
																	<?php 	
																	foreach($orgstat as $orgs){
																		$sel_sat=(isset($assessor_ints['assessor_instrument_status']))?($assessor_ints['assessor_instrument_status']==$orgs['code'])?"selected='selected'":'':''?>
																		<option value="<?php echo $orgs['code']?>" <?php echo $sel_sat?>><?php echo $orgs['name']?></option>
																	<?php 	
																	}?>
																</select>
															</td>
														</tr>
													<?php 
													}
													$hidden_certified=@implode(',',$hide_val);
												}
												else{?>
													<tr id='subgrd_inst1'>
														<td><label><input type="checkbox" value=""></label>
														<input type="hidden" id="assessor_instrument_id1" name="assessor_instrument_id[]" value="">
														</td>
														<td>
															<select class="form-control m-b" name="assessor_instrument_name[]" id="assessor_instrument_name1">
																<option value="">Select</option>
																<?php
																foreach($instruments as $instrument){
																?>
																<option value="<?php echo $instrument['code'];?>" ><?php echo $instrument['name'];?></option>
																<?php
																}
																?>
															</select>
														</td>
														<td>
															<div class="input-group date">
																<input type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="assessor_instrument_expiry[]" id="assessor_instrument_expiry1" value="<?php echo (isset($assessor_ints['assessor_instrument_expiry']))?$assessor_ints['assessor_instrument_expiry']:''?>" class="validate[custom[date2]] datepicker form-control">
																<span class="input-group-addon">
																	<span class="fa fa-calendar"></span>
																</span>	
															</div>
														</td>
														<td>
															<select class="form-control m-b" name="assessor_instrument_status[]" id="assessor_instrument_status1">
																<option value="">Select</option>
																<?php 	
																foreach($orgstat as $orgs){
																	?>
																	<option value="<?php echo $orgs['code']?>" ><?php echo $orgs['name']?></option>
																<?php 	
																}?>
															</select>
														</td>
													</tr>
												<?php 
													$hidden_certified=1;
												} ?>
												</tbody>
												<input type="hidden" name="addgroup_certified" id="addgroup_certified" value="<?php echo $hidden_certified; ?>" />
											</table>
										</div>
										
									</div>
								</div>
							</div>
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
									<button class="btn btn-danger btn-sm" type="button" onclick="create_link('assessor_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
									<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit" onClick="return addsource_details_assessor_validation(3);"><i class="fa fa-check"></i> Submit</button>
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
<script>
var checkuser=false;
<?php if(isset($compdetails['assessor_add_role'])){
	if($compdetails['assessor_add_role']=="Y"){
		echo "checkuser=true;";
	}
} ?>

var checkrole=false;
<?php if(isset($compdetails['assessor_add_role'])){
	if($compdetails['assessor_add_role']=="Y"){
		echo "checkrole=true;";
	}
} ?>
</script>
