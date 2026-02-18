
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					
					<form name="roleform" id="roleform" action="<?php echo BASE_URL;?>/admin/lms_role" method="post" class="form-horizontal">
					<div id="error_div" class="message">
					<?php 
					$message=$this->session->flashdata('message');
					if(!empty($message)){ echo $this->session->flashdata('message'); $this->session->unset_userdata('message'); } ?></div>
					<input type="hidden" id="Role_Id" name="role_id" value="<?php echo isset($rolecreate->role_id)? $rolecreate->role_id:""; ?>" >
						<div class="form-group"><label class="col-sm-3 control-label">Role Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" name="role_name" id="role_name" value="<?php echo isset($rolecreate->role_name)? $rolecreate->role_name:""; ?>"  class="validate[required,minSize[3],maxSize[80],ajax[ajaxRoleName]]  form-control"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Role Code<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" name="role_code" id="role_code" value="<?php echo isset($rolecreate->role_code)? $rolecreate->role_code:""; ?>" class="validate[required,minSize[3],maxSize[30],funcCall[checknotint],ajax[ajaxRoleCode]] form-control"></div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Menu Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="menu_id" id="menu_id" class="validate[required] form-control m-b" >
									<option value="">Select</option>
									<?php foreach($menu as $menus){ $sel=isset($rolecreate->menu_id)?($menus->menu_creation_id==$rolecreate->menu_id ? "selected=selected":""):""; ?>
									<option <?php echo $sel; ?> value="<?php echo $menus->menu_creation_id; ?>,<?php echo $menus->system_menu_type; ?>"><?php echo $menus->menu_name; ?></option><?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Organization<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="parent_org_id" id="parent_org_id"  class="validate[required]  form-control m-b" onChange="orgtype()" >
									<option value="">Select</option>
									<?php  foreach($orga as $orgas){ $sel=isset($rolecreate->parent_org_id)?($orgas->organization_id==$rolecreate->parent_org_id ? "selected=selected":""):""; ?>
									<option <?php echo $sel; ?> value="<?php echo $orgas->organization_id;?>"><?php echo $orgas->org_name;?></option><?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Security Profile<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="secure_profile_id" id="secure_profile_id"  class="validate[required]  form-control m-b" >
									<option value="">Select</option>
									<?php 
									foreach($secure as $secure_pro){ 
									$sel=isset($rolecreate->secure_profile_id)?($secure_pro['secure_profile_id']==$rolecreate->secure_profile_id ? "selected=selected":""):""; ?>
									<option <?php echo $sel; ?> value="<?php echo $secure_pro['secure_profile_id'];?>"><?php echo $secure_pro['profile_name'];?></option><?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Report Group:</label>
							<div class="col-sm-5">
								<select name="report_group_id" id="report_group_id" class="form-control m-b" >
									<option value="">Select</option>
									<?php 
									foreach($report as $reports){ 
									$sel=isset($rolecreate->report_group_id)?(($rolecreate->report_group_id==$reports->report_group_id)? "selected=selected":""):""; ?>
									<option <?php echo $sel; ?> value="<?php echo $reports->report_group_id ?>"> <?php echo $reports->report_group_name ;?>  </option> <?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Start Date<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<div class="input-group date" id="datepicker">
									<input type="text" class="validate[required,custom[date2]]  form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="start_date" id="start_date" value="<?php echo isset($rolecreate->start_date)? date("d-m-Y",strtotime($rolecreate->start_date)):""; ?>" >
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">End Date:</label>
							<div class="col-sm-5">
								<div class="input-group date" id="datepicker">
									<input type="text" class="validate[custom[date2],future[#start_date]]  form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="end_date" id="end_date" value="<?php echo isset($rolecreate->end_date)?  (($rolecreate->end_date!=NULL)? date("d-m-Y",strtotime($rolecreate->end_date)):""):""; ?>" >
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Comment:</label>
							<div class="col-sm-5">
								<textarea name="comment" id="comment" class="form-control" style="overflow:hidden"><?php echo isset($rolecreate->comment)? $rolecreate->comment:""; ?></textarea>
							</div>
						</div>
						
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-offset-9">
								<button class="btn btn-danger" type="button" onclick="create_link('role')">Cancel</button>
								<button class="btn btn-success" type="submit" name="submit_r">Save changes</button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
