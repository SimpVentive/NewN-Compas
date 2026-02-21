<script>    
<?php
foreach($_REQUEST as $key=>$val){
    echo "var ".$key."='".$val."';";
}


//To send competency  name  to .js file
$competency_name='';
foreach($competencydetails as $competencydetail){
    if($competency_name==''){
        $competency_name=$competencydetail['comp_def_id']."*".$competencydetail['comp_def_name'];
    }
    else{
        $competency_name=$competency_name.",".$competencydetail['comp_def_id']."*".$competencydetail['comp_def_name'];
    }
}
echo "var competency_details='".$competency_name."';"; 

//To send criticality  to .js file
$criticality_name='';
foreach($criticalities as $criticalitie){
    if($criticality_name==''){
        $criticality_name=$criticalitie['code']."*".$criticalitie['name'];
    }
    else{
        $criticality_name=$criticality_name.",".$criticalitie['code']."*".$criticalitie['name'];
    }
}
echo "var criticality_details='".$criticality_name."';"; 

$comp_kra='';
foreach($kra_comp_master as $kra_comp_masters){
    if($comp_kra==''){
        $comp_kra=$kra_comp_masters['kra_master_id']."*".$kra_comp_masters['kra_master_name'];
    }
    else{
        $comp_kra=$comp_kra.",".$kra_comp_masters['kra_master_id']."*".$kra_comp_masters['kra_master_name'];
    }
}
echo "var kra_details='".$comp_kra."';"; 
?>
</script>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					
					<form name="positionform" id="positionform" method="post" action="<?php echo BASE_URL;?>/admin/lms_position" class="form-horizontal">
						<input type="hidden" id="pos_id" name="pos_id" value="" />
						<input type="hidden" id="parent_date" name="parent_date" value=""  />
						<div id="error_div" class="alert-error"><?php 
						if(!empty($this->session->flashdata('pos_message'))){ echo $this->session->flashdata('pos_message'); $this->session->unset_userdata('pos_message'); } ?></div>
						<div class="form-group"><label class="col-sm-3 control-label">Position Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" id="pos_name" name="position_name"  class="validate[required,minSize[4],maxSize[80],funcCall[checknotinteger],ajax[ajaxPosition]] form-control" value=""></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Position Code:</label>
							<div class="col-sm-5"><input type="text"  id="pos_code" name="position_code"  class="validate[maxSize[80],funcCall[checknotint]] form-control" value="" ></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Department:</label>
							<div class="col-sm-5">
								<select class=" form-control m-b" id="position_org_id" name="position_org_id" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($pos_org_name as $orgname){
										?>
										<option value="<?php echo $orgname->id;?>"><?php echo $orgname->name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Location:</label>
							<div class="col-sm-5">
								<select class=" form-control m-b" id="location_id" name="location_id" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($pos_locations as $location){
										?>
										<option value="<?php echo $location['location_id'];?>"><?php echo $location['location_name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Status<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" id="status" name="status" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($posstatusss as $pocstatus){
										?>
											<option value="<?php echo $pocstatus['code'];?>"><?php echo $pocstatus['name'];?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<legend>Reporting Relationships</legend>
						<div class="form-group"><label class="col-sm-3 control-label">Reports to:</label>
							<div class="col-sm-5">	
								<select class="form-control js-source-states" id="reports_to" name="reports_to" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($positions as $position){
										?>
										<option value="<?php echo $position->position_id;?>" ><?php echo $position->position_name;?></option>
									<?php
									} ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Reportees:</label>
							<div class="col-sm-5">
								<select class="form-control m-b js-source-states-2" multiple="multiple" id="reportees[]" name="reportees[]" style="width: 100%">
									
									<?php 
									foreach($positions as $position){
										?>
										<option value="<?php echo $position->position_id;?>" ><?php echo $position->position_name;?></option>
									<?php
									} ?>
								</select>
							</div>
						</div>
						<legend>Position Requirements</legend>
						<div class="form-group"><label class="col-sm-3 control-label">Education Background:</label>
							<div class="col-sm-9">
								
								<textarea id="education" name="education"  class="summernote form-control"></textarea>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Experience:</label>
							<div class="col-sm-9">
								<textarea id="experience" name="experience"  class="summernote form-control"></textarea>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Industry Specific Experience:</label>
							<div class="col-sm-9">
								<textarea id="specific_experience" name="specific_experience"  class="summernote form-control"></textarea>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Other Requirements:</label>
							<div class="col-sm-9">
								<textarea id="other_requirement" name="other_requirement"  class="summernote form-control"><?php echo (isset($posdetails->other_requirement))?$posdetails->other_requirement:''?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Purpose:</label>
							<div class="col-sm-9">
								<textarea id="position_desc" name="position_desc"  class="summernote form-control"><?php echo (isset($posdetails->position_desc))?$posdetails->position_desc:''?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Accountabilities:</label>
							<div class="col-sm-9">
								<textarea id="accountablities" name="accountablities"  class="summernote form-control"><?php echo (isset($posdetails->accountablities))?$posdetails->accountablities:''?></textarea>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<ul class="nav nav-pills">
							<?php 	
							if(isset($_REQUEST['posid'])){
							?>
								<li id='event_li' class="active"><a data-toggle="tab" href="#event_def">Step 1 - Competency Requirements</a></li>
								<li id='competency_li'><a data-toggle="tab" href="#evaluate_def">Step 2 -Key Result Areas</a></li>
							<?php }
							else{
							?>
								<li id='event_li' class="active"><a data-toggle="tab" href="#event_def">Step 1 - Competency Requirements</a></li>
								<li class="disabled"><a data-toggle="tab" href="#evaluate_def">Step 2 -Key Result Areas</a></li>
							<?php
							}
							?>
						</ul>
						<div class="tab-content">
							<div id="event_def" class="tab-pane active">
								<div class="panel-body">
									<div class="panel-heading hbuilt">
										Add Competency Requirements
										<div class="pull-right">
											<a class="btn btn-xs btn-primary" onclick="addcompetencyposition();">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp; </a>
											<a class="btn btn-primary btn-xs" onclick="deletecompetencyposition();">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp; </a>
										</div>
									</div>
									<div class="table-responsive">
										<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="competencyposTab" name="competencyposTab">
											<thead>
												<tr>
													<th style="width:5%;">select</th>
													<th style="width:35%;">Competency Name</th>
													<th style="width:20%;">Competency Level</th>
													<th style="width:20%;">Competency Scale</th>
													<th style="width:20%;">Criticality</th>
												</tr>
											</thead>
											<tbody>
											<?php
											if(count($positiondetails)>0){
												$hide_val=array();
												foreach($positiondetails as $key=>$positiondetail){ 
													$key1=$key+1; $hide_val[]=$key1; ?> 
												<tr>
													<td style='padding-left: 18px;'>
														<input type="checkbox" name="chkbox[]" id="chkbox_<?php echo $key1; ?>" value="<?php echo $positiondetail['comp_position_req_id'] ?>" >
													</td>
													<td>
														<input type="hidden" id="comp_position_req_id_<?php echo $key1; ?>" name="comp_position_req_id[]" maxlength="10" value="<?php echo $positiondetail['comp_position_req_id'] ?>">
														<select name="comp_position_competency_id[]" id="comp_position_competency_id_<?php echo $key1; ?>"  style="width:100%;" class="form-control m-b" onchange="open_competency(<?php echo $key1; ?>);">
															<option value="">Select</option> 
															<?php
															foreach($competencydetails as $competencydetail){
																$migration_sel=isset($positiondetail['comp_position_competency_id'])?(trim($positiondetail['comp_position_competency_id'])==$competencydetail['comp_def_id'])?"selected='selected'":"":""?>
																<option value="<?php echo $competencydetail['comp_def_id']; ?>" <?php echo $migration_sel;?> ><?php echo $competencydetail['comp_def_name'];?></option>
															<?php
															}
															?>
														</select>             
													</td>
													
													<td>
														<div id="method_id_details_<?php echo $key1; ?>">
															<select name="comp_position_level_id[]" id="comp_position_level_id_<?php echo $key1; ?>" style="width:100%;" class="form-control m-b" onchange='pos_scale_details(<?php echo $key1; ?>)'>
																<option value="">Select</option>
																<?php
																$leveldetail=UlsCompetencyDefinition::viewcompetency(isset($positiondetail['comp_position_competency_id'])?$positiondetail['comp_position_competency_id']:"");
																$method_sel=isset($positiondetail['comp_position_level_id'])?(trim($positiondetail['comp_position_level_id'])==$leveldetail['comp_def_level'])?"selected='selected'":"":""?>
																<option value="<?php echo $leveldetail['comp_def_level']; ?>" <?php echo $method_sel; ?>> <?php echo $leveldetail['level'];?></option>
															</select>
														</div>	
													</td>
													<td>
														<div id="scale_id_details_<?php echo $key1; ?>">
															<select name="comp_position_level_scale_id[]" id="comp_position_level_scale_id_<?php echo $key1; ?>" style="width:100%;" class="form-control m-b" >
																<option value="">Select</option>
																<?php
																$scaledetails=UlsLevelMasterScale::levelscale(isset($positiondetail['comp_position_level_id'])?$positiondetail['comp_position_level_id']:"");
																foreach($scaledetails as $scaledetail){
																	echo $method_sels=isset($positiondetail['comp_position_level_scale_id'])?($positiondetail['comp_position_level_scale_id']==$scaledetail['scale_id'])?"selected='selected'":"":"";?>
																	<option value="<?php echo $scaledetail['scale_id']; ?>"  <?php echo $method_sels; ?>> <?php echo $scaledetail['scale_name'];?></option>
																<?php
																}
																?>
															</select>
														</div>	
													</td>
													<td>
														<select name="comp_position_criticality_id[]" id="comp_position_criticality_id_<?php echo $key1; ?>" style="width:85%;" class="form-control m-b">
															<option value="">Select</option>
															<?php
															foreach($criticalities as $criticalitie){
																$method_sel=isset($positiondetail['comp_position_criticality_id'])?(trim($positiondetail['comp_position_criticality_id'])==$criticalitie['code'])?"selected='selected'":"":""?>
																<option value="<?php echo $criticalitie['code']; ?>" <?php echo $method_sel;?> ><?php echo $criticalitie['name'];?></option>
															<?php
															}
															?>
															
														</select>             
													</td>
												</tr><?php }  $hidden=@implode(',',$hide_val); 
											}
											else {?>
											<tr>
												<td style='padding-left: 18px;'>
														<input type="checkbox" name="chkbox[]" id="chkbox_1" value="1">
													</td>
													<td>
														<input type="hidden" maxlength="10" id="comp_position_req_id" name="comp_position_req_id" value="">
														<select name="comp_position_competency_id[]" id="comp_position_competency_id_1"  style="width:100%;" onchange="open_competency(1);" class="form-control m-b">
															<option value="">Select</option> 
															<?php
															foreach($competencydetails as $competencydetail){
															?>
																<option value="<?php echo $competencydetail['comp_def_id']; ?>" ><?php echo $competencydetail['comp_def_name'];?></option>
															<?php
															}
															?>
														</select>             
													</td>
													<td>
														<div id="method_id_details_1">
															<select name="comp_position_level_id[]" id="comp_position_level_id_1" style="width:100%;" class="form-control m-b" onchange='pos_scale_details(<?php echo $key1; ?>)'>
																<option value="">Select</option> 
																
															</select> 
														</div>            
													</td>
													<td>
														<div id="scale_id_details_1">
															<select name="comp_position_level_scale_id[]" id="comp_position_level_scale_id_1" style="width:100%;" class="form-control m-b">
																<option value="">Select</option> 
																
															</select> 
														</div>            
													</td>
													<td>
														<select name="comp_position_criticality_id[]" id="comp_position_criticality_id_1" style="width:100%;" class="form-control m-b">
															<option value="">Select</option> 
															<?php 
															foreach($criticalities as $criticalitie){
															?>
																<option value="<?php echo $criticalitie['code'];?>"><?php echo $criticalitie['name'];?></option>
															<?php
															}
															?>
														</select>             
													</td>
													
											</tr>
											<?php $hidden=1; }  ?>
											</tbody>
										</table>
										<input type="hidden" name="addgroup_position" id="addgroup_position" value="<?php echo $hidden; ?>" />
									</div>
									
								</div>
							</div>
							<div id="evaluate_def" class="tab-pane">
								<div class="panel-body">
									<div class="panel-heading hbuilt">
										KRA
										<div class="pull-right">
											<a class="btn btn-xs btn-primary" onclick="addkraposition();" id="kra_add">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
											<a class="btn btn-primary btn-xs" onclick="deletecompetencyposition();">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
										</div>
									</div>
									
									<div class="table-responsive">
											<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="competencyposTab_kra" name="competencyposTab_kra">
											<thead>
												<tr>
													<th style="width:10%;">select</th>
													<th style="width:45%;">KRA</th>
												</tr>
											</thead>
											<tbody>
											<?php
											if(count($kra_comp)>0){
												$hide_val=array();
												foreach($kra_comp as $key=>$kra_comps){ 
													$key1=$key+1; $hide_val_kra[]=$key1; ?> 
												<tr id='subgrd_kra_<?php echo $key1; ?>'>
													<td style='padding-left: 18px;'>
														<input type="checkbox" name="chkbox_kra[]" id="chkbox_kra_<?php echo $key1; ?>" value="<?php echo $kra_comps['comp_kra_id'] ?>" >
													</td>
													<td>
														<input type="hidden" id="comp_kra_id_<?php echo $key1; ?>" name="comp_kra_id[]" value="<?php echo $kra_comps['comp_kra_id'] ?>">
														
														<select name="comp_kra_steps[]" id="comp_kra_steps_<?php echo $key1; ?>" style="width:100%;" class="form-control m-b">
															<option value="">Select</option>
															<?php 
															foreach($kra_comp_master as $kra_comp_masters){
																$kra_sel=isset($kra_comps['comp_kra_steps'])?(trim($kra_comps['comp_kra_steps'])==$kra_comp_masters['kra_master_id'])?"selected='selected'":"":""
															?>
																<option value="<?php echo $kra_comp_masters['kra_master_id'];?>" <?php echo $kra_sel; ?>><?php echo $kra_comp_masters['kra_master_name'];?></option>
															<?php
															}
															?>
														</select> 
													</td>
													
												</tr><?php }  $hidden_kra=@implode(',',$hide_val); 
											}
											else {?>
											<tr id='subgrd_kra_1'>
												<td style='padding-left: 18px;'>
													<input type="checkbox" name="chkbox_kra[]" id="chkbox_kra_1" value="1">
												</td>
												<td>
													<input type="hidden" id="comp_kra_id_1" name="comp_kra_id[]" value="">
													<select name="comp_kra_steps[]" id="comp_kra_steps_1" style="width:100%;" class="form-control m-b">
														<option value="">Select</option>
														<?php 
														foreach($kra_comp_master as $kra_comp_masters){
														?>
															<option value="<?php echo $kra_comp_masters['kra_master_id'];?>"><?php echo $kra_comp_masters['kra_master_name'];?></option>
														<?php
														}
														?>
													</select> 
												</td>
												
											</tr>
											<?php $hidden_kra=1; } ?>
											</tbody>
										</table>
										<input type="hidden" name="addgroup_kra" id="addgroup_kra" value="<?php echo $hidden_kra; ?>" />
									</div>
								</div>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-offset-9">
								<button class="btn btn-primary btn-sm" type="button" name="update" id="update" onClick="create_link('position_search')">Cancel</button>
								<button class="btn btn-primary btn-sm" type="submit" name="update">Save changes</button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>

