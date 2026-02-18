
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
					<?php 
					$langmsg=$this->session->flashdata('langmsg');
					if(!empty($langmsg)){ echo $this->session->flashdata('langmsg'); $this->session->unset_userdata('langmsg'); } ?>
				</div>
                <div class="panel-body">
					<form class="form-horizontal"  name="languageform" id="languageform" method="post" action="<?php echo BASE_URL;?>/admin/lms_language">
					<input type="hidden" name="lang_id" id="lang_id" value="<?php if(isset($langdetail['lang_id'])){ echo $langdetail['lang_id']; }?>">
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Language Name<sup><font color="#FF0000">*</font></sup></label>
							<div class="col-sm-5"><input type="text"  id="lang_name" name="lang_name" class="validate[required,funcCall[checknotinteger],minSize[4],maxSize[80],ajax[ajaxlanguage]] form-control" value="<?php echo !empty($langdetail['lang_name'])?$langdetail['lang_name']:"";?>"></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup></label>

							<div class="col-sm-5">
								<select id="lang_status" name="lang_status" class="validate[required] form-control m-b">
									<option value="">Select</option>
									<?php foreach($locstatusss as $locstatus){ 
										if($locstatus['code']==$langdetail['lang_status']){?>
									<option value="<?php echo $locstatus['code'];?>" selected='selected'><?php echo $locstatus['name'];?></option>
									<?php }else{?>
									<option value="<?php echo $locstatus['code'];?>"><?php echo $locstatus['name'];?></option>
									<?php }} ?>
								</select>
							</div>
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit"  name="update">Save changes</button>
								<button class="btn btn-danger btn-sm" type="button" onClick="create_link('language_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
