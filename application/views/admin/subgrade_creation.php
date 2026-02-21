<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">					
					<form name="subgradeform" id="subgradeform" method="post" action="<?php echo BASE_URL;?>/admin/lms_subgrade" class="form-horizontal">
						<input type="hidden" id="subgrade_id" name="subgrade_id"  class="floatingvalue" value="<?php echo @$subgradedet['subgrade_id'];?>" />
						<div id="error_div" class="message">
						<?php
						$subgrade_msg=$this->session->flashdata('subgrade_msg');
						if(!empty($subgrade_msg)){ echo $this->session->flashdata('subgrade_msg'); $this->session->unset_userdata('subgrade_msg'); } ?></div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Sub Grade Name:<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" id="subgrade_name" name="subgrade_name" class="validate[required,funcCall[checknotinteger],minSize[1],maxSize[30],ajax[ajaxSubgrade]] form-control" value="<?php echo @$subgradedet['subgrade_name'];?>" ></div>
						</div>						
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select  id="status" class="validate[required] form-control m-b" name="status">
									<option value="">Select</option>
									<?php foreach($posstatusss as $pocstatus){
									if($pocstatus['code']==$subgradedet['subgrade_status']){?>
									<option value="<?php echo $pocstatus['code'];?>" selected='selected'><?php echo $pocstatus['name'];?></option>
									<?php }else{?>
									<option value="<?php echo $pocstatus['code'];?>"><?php echo $pocstatus['name'];?></option>
									<?php }} ?>
								</select>
							</div>
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="save" id="save" onClick="return validation()">Save changes</button>
								<button class="btn btn-danger btn-sm" type="button" onClick="create_link('subgrade_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
