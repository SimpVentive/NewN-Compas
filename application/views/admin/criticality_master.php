<div class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
					<?php if(!empty($this->session->flashdata('langmsg'))){ echo $this->session->flashdata('langmsg'); $this->session->unset_userdata('langmsg'); } ?>
				</div>
                <div class="panel-body">
					<form class="form-horizontal"  name="languageform" id="languageform" method="post" action="<?php echo BASE_URL;?>/admin/lms_criticality">
					<input type="hidden" name="comp_cri_id" id="comp_cri_id" value="<?php if(isset($langdetail['comp_cri_id'])){ echo $langdetail['comp_cri_id']; }?>">
						<div class="form-group"><label class="col-sm-3 control-label">Criticality Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text"  id="comp_cri_name" name="comp_cri_name" class="validate[required,funcCall[checknotinteger],minSize[4],maxSize[80],ajax[ajaxcriticality]] form-control" value="<?php echo !empty($langdetail['comp_cri_name'])?$langdetail['comp_cri_name']:"";?>"></div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Status</label>

							<div class="col-sm-5">
								<select id="status" name="status" class="validate[required] form-control m-b">
									<option value="">Select</option>
									<?php foreach($locstatusss as $locstatus){ 
										if($locstatus['code']==$langdetail['status']){?>
									<option value="<?php echo $locstatus['code'];?>" selected='selected'><?php echo $locstatus['name'];?></option>
									<?php }else{?>
									<option value="<?php echo $locstatus['code'];?>"><?php echo $locstatus['name'];?></option>
									<?php }} ?>
								</select>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-offset-9">
								<button class="btn btn-primary btn-sm" type="button" onClick="create_link('language_search')">Cancel</button>
								<button class="btn btn-primary btn-sm" type="submit"  name="update">Save changes</button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>