<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">					
					<form name="emptypeform" id="emptypeform" method="post" action="<?php echo BASE_URL;?>/admin/lms_emptype" class="form-horizontal">
						<input type="hidden" id="emp_type_id" name="emp_type_id"  class="floatingvalue" value="<?php echo @$subgradedet['emp_type_id'];?>" />
						<div id="error_div" class="message">
						<?php
						$emptype_msg=$this->session->flashdata('emptype_msg');
						if(!empty($emptype_msg)){ echo $this->session->flashdata('emptype_msg'); $this->session->unset_userdata('emptype_msg'); } ?></div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Employee Type Name:<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" id="emp_type_name" name="emp_type_name" class="validate[required,funcCall[checknotinteger],minSize[1],maxSize[30],ajax[ajaxEmptype]] form-control" value="<?php echo @$subgradedet['emp_type_name'];?>" ></div>
						</div>						
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select  id="status" class="validate[required] form-control m-b" name="status">
									<option value="">Select</option>
									<?php foreach($posstatusss as $pocstatus){
									if($pocstatus['code']==$subgradedet['emp_type_status']){?>
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
								<button class="btn btn-danger btn-sm" type="button" onClick="create_link('emptype_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
