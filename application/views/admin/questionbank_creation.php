<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
                <div class="panel-body">
					
					<form id="questionbankFrom" action="<?php echo BASE_URL;?>/admin/insert_questionbank" method="post" name="questionbankFrom" class="form-horizontal">
						<?php 
						$msg=$this->session->flashdata('msg');
						if(!empty($msg)){ echo $this->session->flashdata('msg'); $this->session->unset_userdata('msg'); } ?>
						<input type="hidden" id="parent_date" name="parent_date" value="<?php echo date('d-m-Y',strtotime($_SESSION['org_start_date'])); ?>"   />
						<input type="hidden" name="questionbank_id" id="questionbank_id" value="<?php echo isset($questionbank->question_bank_id)? $questionbank->question_bank_id:""; ?>" />
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Question Bank Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" name="questname" id="questname"  value="<?php echo isset($questionbank->name)? $questionbank->name:""; ?>"  class="validate[required,minSize[3],maxSize[80],ajax[ajaxQuestionbankNameEdit]] form-control"></div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Question Bank Type<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5">
								<select name="type" class="validate[required] form-control m-b" name="type">
									<option value="">Select</option> 
									<?php 
									foreach($assesment as $assesments){
										if($assesments['code']=='COMP_TEST' || $assesments['code']=='COMP_INTERVIEW'){
										$type_sel=(isset($questionbank->type))?($questionbank->type==$assesments['code'])?"selected='selected'":'':''?>
										<option value="<?php echo $assesments['code']; ?>" <?php echo $type_sel;?>><?php echo $assesments['name']; ?></option>
									<?php
										}									
									} ?>	
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Competency Master<sup><font color="#FF0000">*</font></sup>:</label>

							<div class="col-sm-5">
								<select name="comp_def_id" class="validate[required] form-control m-b" name="comp_def_id">
									<option value="">Select</option>
									<optgroup label="MS">
									<?php 
									foreach($competencymsdetails as $competencys){
										$type_sel=(isset($questionbank->comp_def_id))?($questionbank->comp_def_id==$competencys['comp_def_id'])?"selected='selected'":'':''?>
										<option value="<?php echo $competencys['comp_def_id']; ?>" <?php echo $type_sel;?>><?php echo $competencys['comp_def_name']; ?></option>
									<?php 	
									} ?>
									</optgroup>
									<optgroup label="NMS">
									<?php 
									foreach($competencynmsdetails as $competencys){
										$type_sel=(isset($questionbank->comp_def_id))?($questionbank->comp_def_id==$competencys['comp_def_id'])?"selected='selected'":'':''?>
										<option value="<?php echo $competencys['comp_def_id']; ?>" <?php echo $type_sel;?>><?php echo $competencys['comp_def_name']; ?></option>
									<?php 	
									} ?>
									</optgroup>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Published status<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="pstatus"  id="pstatus" class="validate[required] form-control m-b">
									<option value="">Select</option> 
									<?php 
									foreach($publish as $publishs ){
										$sel=isset($questionbank->active_flag)?(($questionbank->active_flag==$publishs['code'])? "selected=selected":""):"";
									   ?>
										<option <?php echo $sel; ?> value="<?php echo $publishs['code']; ?>"><?php echo $publishs['name'] ; ?></option>
									<?php 
									} ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Description:</label>
							<div class="col-sm-5">
								<textarea id="description" class="form-control" maxlength="2000" style='resize:none;' name="description" ><?php echo isset($questionbank->description) ? $questionbank->description:""; ?></textarea>
							</div>
						</div>
						
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="submit_r">Save changes</button>
								<button class="btn btn-danger btn-sm" type="submit" onclick="create_link('questionbank_search')">Cancel</button>
								
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
