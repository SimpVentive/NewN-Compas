
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-body">
					<form name="levelform" id="levelform" method="post" action="<?php echo BASE_URL;?>/admin/lms_rating_master" class="form-horizontal">
						<div id="error_div" class="message">
						<input type="hidden" id="rating_id" name="rating_id"  value="<?php echo (isset($rating['rating_id']))?$rating['rating_id']:''?>" />
						<?php 
						$rating_msg=$this->session->flashdata('rating_msg');
						if(!empty($rating_msg)){ echo $this->session->flashdata('rating_msg'); $this->session->unset_userdata('rating_msg'); } ?></div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Rating Name<sup><font color="#FF0000">*</font></sup>:</label>
							
							<div class="col-sm-5"><input type="text" id="rating_name" name="rating_name" class="validate[required,funcCall[checknotinteger],minSize[2],maxSize[30],ajax[ajaxLevel]] form-control" data-prompt-position='topLeft' value="<?php echo (isset($rating['rating_name']))?$rating['rating_name']:''?>" ></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" name="status" id="status" data-prompt-position='topLeft'>
									<option value="">Select</option>
									<?php foreach($status as $statues){
										$gen_sel=(isset($rating['status']))?($rating['status']==$statues['code'])?"selected='selected'":'':''?>
									<option value="<?php echo $statues['code'];?>" <?php echo $gen_sel;?>><?php echo $statues['name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Scale Number<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5"><input type="text" name="rating_scale" id="rating_scale" data-prompt-position='topLeft' onchange="open_table()"  maxlength="2" class="validate[required] form-control" value="<?php echo (isset($rating['rating_scale']))?$rating['rating_scale']:''?>"></div>
						</div>
						<hr class="light-grey-hr">
						<?php 
						$table=isset($_REQUEST['rating_id'])?"block":"none";
						?>
						<div id="ra_table" style="display:<?php echo $table; ?>;">
						<div class="panel-heading hbuilt">
							
							<h6 class="txt-dark capitalize-font">Scale Definition</h6>
						</div>
						
						<div class="table-responsive">
							<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="table">
								<thead>
								<tr>
									<th class="col-sm-2">Number</th>
									<th class="col-sm-10">Rating Name</th>
								</tr>
								</thead>
								<?php
								if(count($rating_scale)>0){
									$var=array();
									foreach($rating_scale as $key=>$rating_scales){
										$var[]=$key;
								?>
								<tr>
									<td>
									<input type="hidden" name="scale_id[]" id="scale_id<?php echo $key;?>" value="<?php echo (isset($rating_scales['scale_id']))?$rating_scales['scale_id']:''?>">
									<input type="hidden" name='val[]' value="<?php echo (isset($rating_scales['rating_number']))?$rating_scales['rating_number']:''?>">
									<label><?php echo (isset($rating_scales['rating_number']))?$rating_scales['rating_number']:''?></label></td>
									<td>
										<input type='text' class='validate[required] form-control' name='rating_name_scale[]' id='rating_name_scale<?php echo $key;?>' data-prompt-position='topLeft' value="<?php echo (isset($rating_scales['rating_name_scale']))?$rating_scales['rating_name_scale']:''?>"/>
									</td>
								</tr>
								<?php }
								}?>
							</table>
						</div>
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="save" id="save" >Save changes</button>
								<button class="btn btn-danger btn-sm" onclick="create_link('rating_master_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
