
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					
					<form name="indicatorform" id="indicatorform" method="post" action="<?php echo BASE_URL;?>/admin/lms_indicator" class="form-horizontal">
						<input type="hidden" id="ind_master_id" name="ind_master_id" value="<?php echo !empty($indicatordetails->ind_master_id)?$indicatordetails->ind_master_id:"";?>" />
						<div id="error_div" class="alert-error"><?php 
						$pos_message=$this->session->flashdata('pos_message');
						if(!empty($pos_message)){ echo $this->session->flashdata('pos_message'); $this->session->unset_userdata('pos_message'); } ?></div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Competency Name<sup><font color="#FF0000">*</font></sup>:</label>
						<div class="col-sm-5">
						<select name="comp_def_id" id="comp_def_id"  style="width:100%;" class="form-control m-b validate[required]" >
							<option value="">Select</option>
							<optgroup label="MS">
							<?php
							foreach($competencymsdetails as $competencydetail){
								$migration_sel=isset($indicatordetails['comp_def_id'])?(trim($indicatordetails['comp_def_id'])==$competencydetail['comp_def_id'])?"selected='selected'":"":""?>
								<option value="<?php echo $competencydetail['comp_def_id']; ?>" <?php echo $migration_sel;?> ><?php echo $competencydetail['comp_def_name'];?></option>
							<?php
							}
							?>
							</optgroup>
							<optgroup label="NMS">
							<?php
							foreach($competencynmsdetails as $competencydetail){
								$migration_sel=isset($indicatordetails['comp_def_id'])?(trim($indicatordetails['comp_def_id'])==$competencydetail['comp_def_id'])?"selected='selected'":"":""?>
								<option value="<?php echo $competencydetail['comp_def_id']; ?>" <?php echo $migration_sel;?> ><?php echo $competencydetail['comp_def_name'];?></option>
							<?php
							}
							?>
							</optgroup>
						</select>  
						</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Indicator Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" id="ind_master_name" name="ind_master_name"  class="validate[required,minSize[2],maxSize[500],ajax[ajaxIndicator]] form-control" value="<?php echo !empty($indicatordetails->ind_master_name)?$indicatordetails->ind_master_name:"";?>"></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" id="status" name="status" style="width: 100%">
									<option value="">Select</option>
									<?php 
									foreach($posstatusss as $pocstatus){
										$status_sel=isset($indicatordetails->status)?($indicatordetails->status==$pocstatus['code'])?"selected='selected'":"":"";
										?>
											<option value="<?php echo $pocstatus['code'];?>" <?php echo $status_sel; ?>><?php echo $pocstatus['name'];?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="update">Save changes</button>
								<button class="btn btn-danger btn-sm" type="button" name="update" id="update" onClick="create_link('indicator_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>

