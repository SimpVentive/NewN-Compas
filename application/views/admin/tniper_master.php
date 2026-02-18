
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-body">
					<form name="levelform" id="levelform" method="post" action="<?php echo BASE_URL;?>/admin/tni_per_master" class="form-horizontal">
						<div id="error_div" class="message">
						<input type="hidden" id="tni_per_id" name="tni_per_id"  value="<?php echo (isset($tniper['tni_per_id']))?$tniper['tni_per_id']:''?>" />
						<?php 
						$rating_msg=$this->session->flashdata('rating_msg');
						if(!empty($rating_msg)){ echo $this->session->flashdata('rating_msg'); $this->session->unset_userdata('rating_msg'); } ?></div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Percentage<sup><font color="#FF0000">*</font></sup>:</label>
							
							<div class="col-sm-5"><input type="text" id="tni_percentage" name="tni_percentage" class="validate[required,custom[number],minSize[1],maxSize[3]] form-control" data-prompt-position='topLeft' value="<?php echo (isset($tniper['tni_percentage']))?$tniper['tni_percentage']:''?>" ></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" name="status" id="status" data-prompt-position='topLeft'>
									<option value="">Select</option>
									<?php foreach($status as $statues){
										$gen_sel=(isset($tniper['status']))?($tniper['status']==$statues['code'])?"selected='selected'":'':''?>
									<option value="<?php echo $statues['code'];?>" <?php echo $gen_sel;?>><?php echo $statues['name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="save" id="save" >Save changes</button>
								<button class="btn btn-danger btn-sm" onclick="create_link('tniper_master_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
