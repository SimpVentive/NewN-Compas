<script>
<?php
$competency_id='';
foreach($competencies as $competency){
    if($competency_id==''){
        $competency_id=$competency['comp_def_id']."*".$competency['comp_def_name'];
    }
    else{
        $competency_id=$competency_id.",".$competency['comp_def_id']."*".$competency['comp_def_name'];
    }
}
echo "var comp_details='".$competency_id."';";
$status_id='';
foreach($status as $comp_status){
    if($status_id==''){
        $status_id=$comp_status['code']."*".$comp_status['name'];
    }
    else{
        $status_id=$status_id.",".$comp_status['code']."*".$comp_status['name'];
    }
}
echo "var status_details='".$status_id."';";
?>
</script>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-body">
					<form name="kra" id="kra" method="post" action="<?php echo BASE_URL;?>/admin/lms_migration_master" class="form-horizontal">
						<div id="error_div" class="message">
						<input type="hidden" id="course_id" name="course_id"  value="<?php echo (isset($migmaster['course_id']))?$migmaster['course_id']:''?>" />
						<?php
						$kra_msg=$this->session->flashdata('kra_msg');
						if(!empty($kra_msg)){ echo $this->session->flashdata('kra_msg'); $this->session->unset_userdata('kra_msg'); } ?></div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Migration Map<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" name="migration_type" id="migration_type">
									<option value="">Select</option>
									<?php 	
									foreach($migrations as $migration){
										$sel_sat=(isset($migmaster['migration_type']))?($migmaster['migration_type']==$migration['code'])?"selected='selected'":'':''?>
										<option value="<?php echo $migration['code']?>" <?php echo $sel_sat?>><?php echo $migration['name']?></option>
									<?php 	
									}?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Type<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" name="type" id="type">
								<?php $sel_sme=(isset($migmaster['type']))?($migmaster['type']=='SME')?"selected='selected'":'':''?>
								<?php $sel_et=(isset($migmaster['type']))?($migmaster['type']=='ET')?"selected='selected'":'':''?>
									<option value="">Select</option>
									<option value="SME" <?php echo $sel_sme;?>>SME</option>
									<option value="ET" <?php echo $sel_et;?>>External Program</option>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Migration Master Name<sup><font color="#FF0000">*</font></sup>:</label>
							
							<div class="col-sm-5"><textarea id="program_name" name="program_name" class="validate[required] form-control" data-prompt-position='topLeft'><?php echo (isset($migmaster['program_name']))?$migmaster['program_name']:''?></textarea></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Migration Objective:</label>
							
							<div class="col-sm-5"><textarea id="program_objective" name="program_objective" class="validate[] form-control" data-prompt-position='topLeft'><?php echo (isset($migmaster['program_objective']))?$migmaster['program_objective']:''?></textarea></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Migration URL:</label>
							
							<div class="col-sm-5"><input type="text" id="program_link" name="program_link" class="validate[] form-control" data-prompt-position='topLeft' value="<?php echo (isset($migmaster['program_link']))?$migmaster['program_link']:''?>"></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" name="status_mig" id="status_mig" data-prompt-position='topLeft'>
									<option value="">Select</option>
									<?php foreach($status as $statues){
										$gen_sel=(isset($migmaster['status']))?($migmaster['status']==$statues['code'])?"selected='selected'":'':''?>
									<option value="<?php echo $statues['code'];?>" <?php echo $gen_sel;?>><?php echo $statues['name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="panel-heading hbuilt">
							
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Add Competencies</h6>
							</div>
							<div class="pull-right">
								<a class="btn btn-xs btn-primary" onClick="return addsource_details_certified()">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
								<a class="btn btn-danger btn-xs" onClick="delete_certified()">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="table-responsive">
							<table id="source_table_certified" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>Select</th>
									<th>Competencies</th>
									<th>Scale</th>
									<th>Status</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if(!empty($migcompetencies)){
									$hide_val=array();
									foreach($migcompetencies as $key=>$migcompetency){ 
										$key1=$key+1; $hide_val[]=$key1;
										?>
										<tr id='subgrd_inst<?php echo $key1; ?>'>
											<td><label><input type="checkbox" id="chkbox_inst<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $migcompetency['pro_id'];?>" ></label>
											<input type="hidden" id="pro_id<?php echo $key1; ?>" name="pro_id[]" value="<?php echo $migcompetency['pro_id'];?>">
											</td>
											<td>
												<select class="form-control m-b" name="comp_def_id[]" id="comp_def_id<?php echo $key1; ?>" onchange="open_competency(<?php echo $key1; ?>);" >
													<option value="">Select</option>
													<?php 
													foreach($competencies as $competency){
														$cat_sel=isset($migcompetency['comp_def_id'])?($migcompetency['comp_def_id']==$competency['comp_def_id'])?"selected='selected'":"":"";
														?>
														<option value="<?php echo $competency['comp_def_id'];?>" <?php echo $cat_sel; ?>><?php echo $competency['comp_def_name'];?></option>
													<?php
													}
													?>
												</select>
											</td>
											<td>
												<div id="method_id_details_<?php echo $key1; ?>">
													<select name="scale_id[]" id="scale_id_<?php echo $key1; ?>" style="width:100%;" class="form-control m-b" >
														<option value="">Select</option>
														<?php
														$comp_detail=UlsCompetencyDefinition::competency_detail_single(isset($migcompetency['comp_def_id'])?$migcompetency['comp_def_id']:"");
														$scaledetails=UlsLevelMasterScale::levelscale(isset($comp_detail['comp_def_level'])?$comp_detail['comp_def_level']:"");
														foreach($scaledetails as $scaledetail){
															echo $method_sels=isset($migcompetency['scale_id'])?($migcompetency['scale_id']==$scaledetail['scale_id'])?"selected='selected'":"":"";?>
															<option value="<?php echo $scaledetail['scale_id']; ?>"  <?php echo $method_sels; ?>> <?php echo $scaledetail['scale_name'];?></option>
														<?php
														}
														?>
													</select>
												</div>	
											</td>
											<td>
												<select class="form-control m-b" name="status[]" id="status<?php echo $key1; ?>" >
													<option value="">Select</option>
													<?php 
													foreach($status as $comp_status){
														$cat_sel=isset($migcompetency['status'])?($migcompetency['status']==$comp_status['code'])?"selected='selected'":"":"";
														?>
														<option value="<?php echo $comp_status['code'];?>" <?php echo $cat_sel; ?>><?php echo $comp_status['name'];?></option>
													<?php
													}
													?>
												</select>
												
											</td>
										</tr>
									<?php 
									}
									$hidden_certified=@implode(',',$hide_val);
								}
								else{?>
									<tr id='subgrd_inst1'>
										<td><label><input type="checkbox" id="chkbox_inst1" name="chkbox[]" value=""></label>
										<input type="hidden" id="pro_id1" name="pro_id[]" value="">
										</td>
										<td>
											<select class="form-control m-b" name="comp_def_id[]" id="comp_def_id1" onchange="open_competency(1);">
												<option value="">Select</option>
												<?php 
												foreach($competencies as $competency){
													?>
													<option value="<?php echo $competency['comp_def_id'];?>" ><?php echo $competency['comp_def_name'];?></option>
												<?php
												}
												?>
											</select>
										</td>
										<td>
											<div id="method_id_details_1">
												<select name="scale_id[]" id="scale_id_1" style="width:100%;" class="form-control m-b">
													<option value="">Select</option> 
													
												</select> 
											</div>            
										</td>
										<td>
											<select class="form-control m-b" name="status[]" id="status1" >
												<option value="">Select</option>
												<?php 
												foreach($status as $comp_status){
													?>
													<option value="<?php echo $comp_status['code'];?>" ><?php echo $comp_status['name'];?></option>
												<?php
												}
												?>
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
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="save" id="save" onClick="return addsource_details_certified_validations();" >Save changes</button>
								<button class="btn btn-danger btn-sm" onclick="create_link('migration_master_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
