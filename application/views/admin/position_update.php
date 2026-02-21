<script>    
<?php
foreach($_REQUEST as $key=>$val){
    echo "var ".$key."='".$val."';";
}


//To send competency  name  to .js file
$competencyms_name='';
foreach($competencymsdetails as $competencydetail){
    if($competencyms_name==''){
        $competencyms_name=$competencydetail['comp_def_id']."*".str_replace(array(",","'"),array("",""),$competencydetail['comp_def_name']);
    }
    else{
        $competencyms_name=$competencyms_name.",".$competencydetail['comp_def_id']."*".str_replace(array(",","'"),array("",""),$competencydetail['comp_def_name']);
    }
}
$competencynms_name='';
foreach($competencynmsdetails as $competencydetail){
    if($competencynms_name==''){
        $competencynms_name=$competencydetail['comp_def_id']."*".str_replace(array(",","'"),array("",""),$competencydetail['comp_def_name']);
    }
    else{
        $competencynms_name=$competencynms_name.",".$competencydetail['comp_def_id']."*".str_replace(array(",","'"),array("",""),$competencydetail['comp_def_name']);
    }
}
echo "var competency_detailsms='".$competencyms_name."';";
echo "var competency_detailsnms='".$competencynms_name."';";

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
$comp_kra="<option value=''>Select</option>";
if(isset($kra_comp_master)){
	foreach($kra_comp_master as $kra_comp_masters){
		if(!empty($kra_comp_masters['kra_master_name'])){
			if($comp_kra==''){
				//$comp_kra=$kra_comp_masters['kra_master_id']."*".$kra_comp_masters['kra_master_name'];
				$comp_kra="<option value='".$kra_comp_masters['kra_master_id']."'>".$kra_comp_masters['kra_master_name']."</option>";
			}
			else{
				$comp_kra=$comp_kra."<option value='".$kra_comp_masters['kra_master_id']."'>".str_replace("'","",$kra_comp_masters['kra_master_name'])."</option>";
			}
		}
	}
}
echo "var kra_details=\"$comp_kra\";"; 

?>
</script>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					<?php 
					$version=isset($_REQUEST['var'])?(($_REQUEST['var']==1)?"lms_position_archive":"lms_position"):"lms_position";
					?>
					<form name="positionform" id="positionform" method="post" action="<?php echo BASE_URL;?>/admin/<?php echo $version; ?>" class="form-horizontal">
						<input type="hidden" id="pos_id" name="pos_id" value="<?php echo !empty($posdetails->position_id)?$posdetails->position_id:"";?>" />
						<input type="hidden" id="parent_date" name="parent_date" value="<?php echo date('d-m-Y',strtotime($_SESSION['org_start_date'])); ?>"  />
						<div id="error_div" class="alert-error"><?php 
						$pos_message=$this->session->flashdata('pos_message');
						if(!empty($pos_message)){ echo $this->session->flashdata('pos_message'); $this->session->unset_userdata('pos_message'); } ?></div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Position Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" id="position_name" name="position_name"  class="validate[required,minSize[2],maxSize[80],ajax[ajaxPosition]] form-control" value="<?php echo !empty($posdetails->position_name)?$posdetails->position_name:"";?>"></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Position Code:</label>
							<div class="col-sm-5"><input type="text"  id="pos_code" name="position_code"  class="validate[maxSize[80],funcCall[checknotint]] form-control" value="<?php echo !empty($posdetails->position_code)?$posdetails->position_code:"";?>" ></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Position Type:</label>
							<div class="col-sm-5">
								<select class="form-control m-b" id="position_type" name="position_type" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($pos_types as $pos_type){
										$dep_sel=isset($posdetails->position_type)?($posdetails->position_type==$pos_type['code'])?"selected='selected'":"":"";
										?>
											<option value="<?php echo $pos_type['code'];?>" <?php echo $dep_sel; ?>><?php echo $pos_type['name'];?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label mb-10 col-sm-2">Position Structure<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" id="position_structure" name="position_structure" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($pos_str as $pos_strs){
										$dep_sel=isset($posdetails->position_structure)?($posdetails->position_structure==$pos_strs['code'])?"selected='selected'":"":"";
										?>
											<option value="<?php echo $pos_strs['code'];?>" <?php echo $dep_sel; ?>><?php echo $pos_strs['name'];?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<?php 
						$psel=!empty($posdetails->position_structure)?(($posdetails->position_structure)=='A')?"style='display:block;'":"style='display:none;'":"";
						?>
						<div class="form-group" id='mapped_id'  <?php echo $psel; ?>>
							<label class="control-label mb-10 col-sm-2">Position Mapped<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select class="form-control m-b" id="position_structure_id" name="position_structure_id" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($str_positions as $str_position){
										$pos_sel=isset($posdetails->position_structure_id)?($posdetails->position_structure_id==$str_position['position_id'])?"selected='selected'":"":"";
										?>
											<option value="<?php echo $str_position['position_id'];?>" <?php echo $pos_sel; ?>><?php echo $str_position['position_name'];?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Grade:</label>
							<div class="col-sm-5">
								<select class=" form-control m-b" id="grade_id" name="grade_id" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($grades as $grade){
										$dep_sel=isset($posdetails->grade_id)?($posdetails->grade_id==$grade->grade_id)?"selected='selected'":"":"";
										?>
											<option value="<?php echo $grade->grade_id;?>" <?php echo $dep_sel; ?>><?php echo $grade->grade_name;?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Business:</label>
							<div class="col-sm-5">
								<select class=" form-control m-b" id="bu_id" name="bu_id" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($pos_bu_name as $orgname){
										$dep_sel=isset($posdetails->bu_id)?($posdetails->bu_id==$orgname->id)?"selected='selected'":"":"";
										?>
											<option value="<?php echo $orgname->id;?>" <?php echo $dep_sel; ?>><?php echo $orgname->name;?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Department:</label>
							<div class="col-sm-5">
								<select class=" form-control m-b" id="position_org_id" name="position_org_id" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($pos_org_name as $orgname){
										$dep_sel=isset($posdetails->position_org_id)?($posdetails->position_org_id==$orgname->id)?"selected='selected'":"":"";
										?>
											<option value="<?php echo $orgname->id;?>" <?php echo $dep_sel; ?>><?php echo $orgname->name;?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Location:</label>
							<div class="col-sm-5">
								<select class=" form-control m-b js-source-states-2" multiple="multiple" id="location_id[]" name="location_id[]" style="width: 100%">
									<option value="">Select</option>
									<?php
									foreach($pos_locations as $location){
										//$loc_sel=isset($posdetails->location_id)?($posdetails->location_id==$location['location_id'])?"selected='selected'":"":"";
										$locs=isset($posdetails->location_id)?explode(",",$posdetails->location_id):array();
										$loc_sel=in_array($location['location_id'],$locs)?"selected='selected'":"";
									?>
									<option value="<?php echo $location['location_id'];?>" <?php echo $loc_sel; ?>><?php echo $location['location_name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" id="status" name="status" style="width: 100%">
									<option value="">Select</option>
									<?php foreach($posstatusss as $pocstatus){
									$status_sel=isset($posdetails->status)?($posdetails->status==$pocstatus['code'])?"selected='selected'":"":"";
									?>
									<option value="<?php echo $pocstatus['code'];?>" <?php echo $status_sel; ?>><?php echo $pocstatus['name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<h6 class="txt-dark capitalize-font">Reporting Relationships</h6>
						<hr class="light-grey-hr">
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Reports to:</label>
							<div class="col-sm-5">	
								<select class="form-control  js-source-states-2" multiple="multiple" id="reports_to[]" name="reports_to[]" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($positions as $position){
										//$program_sel=isset($posdetails->reports_to)?($posdetails->reports_to==$position->position_id)?"selected='selected'":"":"";
										$reports=isset($posdetails->reports_to)?explode(",",$posdetails->reports_to):array();
										$program_sel=in_array($position->position_id,$reports)?"selected='selected'":"";
										
										?>
										<option value="<?php echo $position->position_id;?>" <?php echo $program_sel; ?>><?php echo $position->position_name;?></option>
									<?php
									} ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Reportees:</label>
							<div class="col-sm-5">
								<select class="form-control m-b js-source-states-2" multiple="multiple" id="reportees[]" name="reportees[]" style="width: 100%">
									
									<?php 
									foreach($positions as $position){
										$reportess=isset($posdetails->reportees)?explode(",",$posdetails->reportees):array();
										$programsel=in_array($position->position_id,$reportess)?"selected='selected'":"";
										?>
										<option value="<?php echo $position->position_id;?>" <?php echo $programsel; ?>><?php echo $position->position_name;?></option>
									<?php
									} ?>
								</select>
							</div>
						</div>
						<h6 class="txt-dark capitalize-font">Position Requirements</h6>
						<hr class="light-grey-hr">
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Education Background:</label>
							<div class="col-sm-9">
								
								<textarea id="education" name="education"  class="summernote form-control"><?php echo (isset($posdetails->education))?$posdetails->education:''?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Experience:</label>
							<div class="col-sm-9">
								<textarea id="experience" name="experience"  class="summernote form-control"><?php echo (isset($posdetails->experience))?$posdetails->experience:''?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Industry Specific Experience:</label>
							<div class="col-sm-9">
								<textarea id="specific_experience" name="specific_experience"  class="summernote form-control"><?php echo (isset($posdetails->specific_experience))?$posdetails->specific_experience:''?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Other Requirements:</label>
							<div class="col-sm-9">
								<textarea id="other_requirement" name="other_requirement"  class="summernote form-control"><?php echo (isset($posdetails->other_requirement))?$posdetails->other_requirement:''?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Purpose:</label>
							<div class="col-sm-9">
								<textarea id="position_desc" name="position_desc"  class="summernote form-control"><?php echo (isset($posdetails->position_desc))?$posdetails->position_desc:''?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Accountabilities:</label>
							<div class="col-sm-9">
								<textarea id="accountablities" name="accountablities"  class="summernote form-control"><?php echo (isset($posdetails->accountablities))?$posdetails->accountablities:''?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Responsibilities:</label>
							<div class="col-sm-9">
								<textarea id="responsibilities" name="responsibilities"  class="summernote form-control"><?php echo (isset($posdetails->responsibilities))?$posdetails->responsibilities:''?></textarea>
							</div>
						</div>
						<hr class="light-grey-hr">
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
										<div class="pull-left">
											<h6 class="panel-title txt-dark">Add Competency Requirements</h6>
										</div>
										
										
									</div>
									<br style="clear:both">
									<div class="table-responsive">
										<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="competencyposTab" name="competencyposTab">
											<thead>
												<tr>
													<th style="width:5%;">select</th>
													<th style="width:35%;">Competency Name</th>
													<!--<th style="width:20%;">Competency Level</th>-->
													<th style="width:20%;">Competency Scale</th>
													<th style="width:20%;">Criticality</th>
												</tr>
											</thead>
											<tbody>
											<?php
											
											if(!empty($positiondetails)){
												$hide_val_c=array();
												foreach($positiondetails as $key=>$positiondetail){ 
													$key1=$key+1; $hide_val_c[]=$key1; ?> 
												<tr>
													<td style='padding-left: 18px;'>
														<input type="checkbox" name="chkbox[]" id="chkbox_<?php echo $key1; ?>" value="<?php echo $positiondetail['comp_position_req_id'] ?>" >
														<input type="hidden" name="comp_position_level_id[]" id="comp_position_level_id_<?php echo $key1; ?>" value="<?php echo $positiondetail['comp_position_level_id']; ?>">
													</td>
													<td>
														<input type="hidden" id="comp_position_req_id_<?php echo $key1; ?>" name="comp_position_req_id[]" maxlength="10" value="<?php echo $positiondetail['comp_position_req_id'] ?>">
														<select name="comp_position_competency_id[]" id="comp_position_competency_id_<?php echo $key1; ?>"  style="width:100%;" class="form-control m-b" onchange="open_competency(<?php echo $key1; ?>);">
															<option value="">Select</option>
															<optgroup label="MS">
															<?php
															foreach($competencymsdetails as $competencydetail){
																$migration_sel=isset($positiondetail['comp_position_competency_id'])?(trim($positiondetail['comp_position_competency_id'])==$competencydetail['comp_def_id'])?"selected='selected'":"":""?>
																<option value="<?php echo $competencydetail['comp_def_id']; ?>" <?php echo $migration_sel;?> ><?php echo $competencydetail['comp_def_name'];?></option>
															<?php
															}
															?>
															</optgroup>
															<optgroup label="NMS">
															<?php
															foreach($competencynmsdetails as $competencydetail){
																$migration_sel=isset($positiondetail['comp_position_competency_id'])?(trim($positiondetail['comp_position_competency_id'])==$competencydetail['comp_def_id'])?"selected='selected'":"":""?>
																<option value="<?php echo $competencydetail['comp_def_id']; ?>" <?php echo $migration_sel;?> ><?php echo $competencydetail['comp_def_name'];?></option>
															<?php
															}
															?>
															</optgroup>
														</select>             
													</td>
													
													<!--<td>
														<div id="method_id_details_<?php echo $key1; ?>">
															<select name="comp_position_level_id[]" id="comp_position_level_id_<?php echo $key1; ?>" style="width:100%;" class="form-control m-b" onchange='pos_scale_details(<?php echo $key1; ?>)'>
																<option value="">Select</option>
																<?php
																$leveldetail=UlsCompetencyDefinition::viewcompetency(isset($positiondetail['comp_position_competency_id'])?$positiondetail['comp_position_competency_id']:"");
																$method_sel=isset($positiondetail['comp_position_level_id'])?(trim($positiondetail['comp_position_level_id'])==$leveldetail['comp_def_level'])?"selected='selected'":"":""?>
																<option value="<?php echo $leveldetail['comp_def_level']; ?>" <?php echo $method_sel; ?>> <?php echo $leveldetail['level'];?></option>
															</select>
														</div>	
													</td>-->
													<td>
														<div id="method_id_details_<?php echo $key1; ?>">
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
												</tr><?php }  $hidden=@implode(',',$hide_val_c); 
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
															<optgroup label="MS">
															<?php
															foreach($competencymsdetails as $competencydetail){
															?>
																<option value="<?php echo $competencydetail['comp_def_id']; ?>" ><?php echo $competencydetail['comp_def_name'];?></option>
															<?php
															}
															?>
															</optgroup>
															<optgroup label="NMS">
															<?php
															foreach($competencynmsdetails as $competencydetail){
															?>
																<option value="<?php echo $competencydetail['comp_def_id']; ?>" ><?php echo $competencydetail['comp_def_name'];?></option>
															<?php
															}
															?>
															</optgroup>
														</select>             
													</td>
													<td>
														<div id="method_id_details_1">
															<select name="comp_position_level_id[]" id="comp_position_level_id_1" style="width:100%;" class="form-control m-b" onchange='pos_scale_details(<?php echo $key1; ?>)'>
																<option value="">Select</option> 
																
															</select> 
														</div>            
													</td>
													<!--<td>
														<div id="scale_id_details_1">
															<select name="comp_position_level_scale_id[]" id="comp_position_level_scale_id_1" style="width:100%;" class="form-control m-b">
																<option value="">Select</option> 
																
															</select> 
														</div>            
													</td>-->
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
									<div class="pull-right">
											<a class="btn btn-xs btn-primary" onclick="addcompetencyposition();">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
											<a class="btn btn-danger btn-xs" onclick="deletecompetencyposition();">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
										</div>
								</div>
							</div>
							<div id="evaluate_def" class="tab-pane">
								<div class="panel-body">
									<div class="panel-heading hbuilt">
										
										<div class="pull-left">
											<h6 class="panel-title txt-dark">KRA</h6>
										</div>
										<div class="pull-right">
											<a class="btn btn-xs btn-primary" onclick="addkraposition();" id="kra_add">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
											<a class="btn btn-danger btn-xs" onclick="deletecompetencykra();">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
										</div>
									</div>
									<br style="clear:both">
									<div class="table-responsive">
											<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="competencyposTab_kra" name="competencyposTab_kra">
											<thead>
												<tr>
													<th style="width:10%;">select</th>
													<th style="width:30%;">KRA</th>
													<th style="width:30%;">KPI</th>
													<th style="width:30%;">Unit of Measurement(UOM)</th>
												</tr>
											</thead>
											<tbody>
											<?php
											if(!empty($kra_comp)>0){
												$hide_val_kra=array();
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
																$kra_sel=isset($kra_comps['comp_kra_steps'])?(trim($kra_comps['comp_kra_steps'])==$kra_comp_masters['kra_master_id'])?"selected='selected'":"":"";
																if(!empty($kra_comp_masters['kra_master_name'])){
															?>
																<option value="<?php echo $kra_comp_masters['kra_master_id'];?>" <?php echo $kra_sel; ?>><?php echo $kra_comp_masters['kra_master_name'];?></option>
															<?php
															} }
															?>
														</select> 
													</td>
													<td>
														<input type="text" id="comp_kri_<?php echo $key1; ?>" class="form-control" name="kra_kri[]" value="<?php echo @$kra_comps['kra_kri'] ?>">
													</td>
													<td>
														<input type="text" id="comp_uom_<?php echo $key1; ?>" class="form-control" name="kra_uom[]" value="<?php echo @$kra_comps['kra_uom'] ?>">
													</td>
												</tr><?php }  $hidden_kra=@implode(',',$hide_val_kra); 
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
												<td>
													<input type="text" id="comp_kri_1" class="form-control" name="kra_kri[]" value="">
												</td>
												<td>
													<input type="text" id="comp_uom_1" class="form-control" name="kra_uom[]" value="">
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
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="update">Save changes</button>
								<button class="btn btn-danger btn-sm" type="button" name="update" id="update" onClick="create_link('position_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
	<?php 
	if(!empty($posdetails->position_structure)){
		if(($posdetails->position_structure)=='A'){
		?>
		$('#mapped_id').show();
		<?php
		}
		else{
		?>
		$('#mapped_id').hide();
		<?php
		}
	}
	else{
	?>
		$('#mapped_id').hide();
		<?php	
	}
	?>
    
    $('#position_structure').change(function(){
        if($('#position_structure').val() == 'A') {
            $('#mapped_id').show(); 
        } else {
            $('#mapped_id').hide();
        } 
    });
});
</script>
