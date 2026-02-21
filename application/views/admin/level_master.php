
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-body">
					<form name="levelform" id="levelform" method="post" action="<?php echo BASE_URL;?>/admin/lms_level_master" class="form-horizontal">
						<div id="error_div" class="message">
						<input type="hidden" id="level_id" name="level_id"  value="<?php echo (isset($level['level_id']))?$level['level_id']:''?>" />
						<?php 
						$level_msg=$this->session->flashdata('level_msg');
						if(!empty($level_msg)){ echo $this->session->flashdata('level_msg'); $this->session->unset_userdata('level_msg'); } ?></div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Level Name<sup><font color="#FF0000">*</font></sup>:</label>
							
							<div class="col-sm-5"><input type="text" id="level_name" name="level_name" class="validate[required,funcCall[checknotinteger],minSize[2],maxSize[30],ajax[ajaxLevel]] form-control" data-prompt-position='topLeft' value="<?php echo (isset($level['level_name']))?$level['level_name']:''?>" ></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" name="status" id="status" data-prompt-position='topLeft'>
									<option value="">Select</option>
									<?php foreach($status as $statues){
										$gen_sel=(isset($level['status']))?($level['status']==$statues['code'])?"selected='selected'":'':''?>
									<option value="<?php echo $statues['code'];?>" <?php echo $gen_sel;?>><?php echo $statues['name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Scale Number<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5"><input type="text" name="scale_number" id="scale_number" data-prompt-position='topLeft' onchange="open_table()"  maxlength="2" class="validate[required,custom[onlyNumberSp]] form-control" value="<?php echo (isset($level['level_scale']))?$level['level_scale']:''?>"></div>
						</div>
						<div class="hr-line-dashed"></div>
						<?php 
						$table=isset($_REQUEST['level_id'])?"block":"none";
						?>
						<div id="ra_table" style="display:<?php echo $table; ?>;">
						<div class="panel-heading hbuilt">
							
							<h6 class="txt-dark capitalize-font">Scale Definition</h6>
						</div>
						
						<div class="table-responsive">
							<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="table">
								<thead>
								<tr>
									<th>Number</th>
									<th>Level Name</th>
									<th>Description</th>
								</tr>
								</thead>
								<?php
								if(count($level_scale)>0){
									$var=array();
									foreach($level_scale as $key=>$level_scales){
										$var[]=$key;
								?>
								<tr>
									<td>
									<input type="hidden" name="scale_id[]" id="scale_id<?php echo $key;?>" value="<?php echo (isset($level_scales['scale_id']))?$level_scales['scale_id']:''?>">
									<input type="hidden" name='val[]' value="<?php echo (isset($level_scales['scale_number']))?$level_scales['scale_number']:''?>">
									<label><?php echo (isset($level_scales['scale_number']))?$level_scales['scale_number']:''?></label></td>
									<td>
										<input type='text' class='validate[required] form-control' name='scale_name[]' id='scale_name<?php echo $key;?>' data-prompt-position='topLeft' value="<?php echo (isset($level_scales['scale_name']))?$level_scales['scale_name']:''?>"/>
									</td>
									<td>
										<input type='text' class='form-control' name='description[]' id='description<?php echo $key;?>' data-prompt-position='topLeft' value="<?php echo (isset($level_scales['description']))?$level_scales['description']:''?>"/>
									</td>
								</tr>
								<?php 
								$val=@implode(',',$var);
								}
								}	else{
													$val='';
								}?>
								<input type='hidden' id='exp_hidden_id' value='<?php echo $val;?>' name="exp_hidden_id" />
							</table>
						</div>
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="save" id="save"  onclick="return AddExpenses_validation()" >Save changes</button>
								<button class="btn btn-danger btn-sm" onclick="create_link('level_master_search')">Cancel</button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
