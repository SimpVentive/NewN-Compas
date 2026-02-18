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
					<form name="kra" id="kra" method="post" action="<?php echo BASE_URL;?>/admin/lms_kra_master" class="form-horizontal">
						<div id="error_div" class="message">
						<input type="hidden" id="kra_master_id" name="kra_master_id"  value="<?php echo (isset($kramaster['kra_master_id']))?$kramaster['kra_master_id']:''?>" />
						<?php
						$kra_msg=$this->session->flashdata('kra_msg');
						if(!empty($kra_msg)){ echo $this->session->flashdata('kra_msg'); $this->session->unset_userdata('kra_msg'); } ?></div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">KRA Master Name<sup><font color="#FF0000">*</font></sup>:</label>
							
							<div class="col-sm-5"><textarea id="kra_master_name" name="kra_master_name" class="validate[required] form-control" data-prompt-position='topLeft'><?php echo (isset($kramaster['kra_master_name']))?$kramaster['kra_master_name']:''?></textarea></div>
						</div>
						
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" name="kra_status" id="kra_status" data-prompt-position='topLeft'>
									<option value="">Select</option>
									<?php foreach($status as $statues){
										$gen_sel=(isset($kramaster['kra_status']))?($kramaster['kra_status']==$statues['code'])?"selected='selected'":'':''?>
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
									<th>Status</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if(!empty($kracompetencies)){
									$hide_val=array();
									foreach($kracompetencies as $key=>$kracompetency){ 
										$key1=$key+1; $hide_val[]=$key1;
										?>
										<tr id='subgrd_inst<?php echo $key1; ?>'>
											<td><label><input type="checkbox" id="chkbox_inst<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $kracompetency['kra_comp_master_id'];?>" ></label>
											<input type="hidden" id="kra_comp_master_id<?php echo $key1; ?>" name="kra_comp_master_id[]" value="<?php echo $kracompetency['kra_comp_master_id'];?>">
											</td>
											<td>
												<select class="form-control m-b" name="comp_def_id[]" id="comp_def_id<?php echo $key1; ?>" >
													<option value="">Select</option>
													<?php 
													foreach($competencies as $competency){
														$cat_sel=isset($kracompetency['comp_def_id'])?($kracompetency['comp_def_id']==$competency['comp_def_id'])?"selected='selected'":"":"";
														?>
														<option value="<?php echo $competency['comp_def_id'];?>" <?php echo $cat_sel; ?>><?php echo $competency['comp_def_name'];?></option>
													<?php
													}
													?>
												</select>
											</td>
											<td>
												<select class="form-control m-b" name="status[]" id="status<?php echo $key1; ?>" >
													<option value="">Select</option>
													<?php 
													foreach($status as $comp_status){
														$cat_sel=isset($kracompetency['status'])?($kracompetency['status']==$comp_status['code'])?"selected='selected'":"":"";
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
										<input type="hidden" id="kra_comp_master_id1" name="kra_comp_master_id[]" value="">
										</td>
										<td>
											<select class="form-control m-b" name="comp_def_id[]" id="comp_def_id1">
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
								<button class="btn btn-danger btn-sm" onclick="create_link('kra_master_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
