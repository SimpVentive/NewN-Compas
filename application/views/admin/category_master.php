<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-body">
					<?php 
					$msg=$this->session->flashdata('msg');
					if(!empty($msg)){ echo "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'><i class='ace-icon fa fa-times'></i></button><p>".$this->session->flashdata('msg')."</p></div>"; $this->session->unset_userdata('msg');} ?>
					<div id="error_div" class="message"><font color="#FF0000">* Indicated are Mandatory <br />
					</font></div>
					<form name="category_creation" id="category_creation" class="form-horizontal" method="post" action="<?php echo BASE_URL; ?>/admin/parent_category">
						<input type='hidden' name='org_strt_dt' id='org_strt_dt' value='<?php echo date('d-m-Y',strtotime($this->session->flashdata('org_start_date'))) ?>'>
						<?php 
						$org_end_date=$this->session->flashdata('org_end_date');
						if(!empty($org_end_date)){ ?>
							<input type='hidden' name='org_end_dt' id='org_end_dt' value='<?php echo date('d-m-Y',strtotime($this->session->flashdata('org_end_date'))) ?>'>
						<?php 
						}
						else{ ?>
							<input type='hidden' name='org_end_dt' id='org_end_dt' value=''>
						<?php 
						}
						if(isset($_REQUEST['id'])){
						?>
						<?php 
						if($cat_update->category_type!='PC'){
							foreach($dates as $dates1){
								if($dates1->end_date=='2037-01-19' || $dates1->end_date==NULL){
									$enddate="";
								}
								else{
									$enddate=date('d-m-Y',strtotime($dates1->end_date));
								}?>
								<input type="hidden" name="cat_startdatetext" id="cat_startdatetext" value="<?php echo date('d-m-Y',strtotime($dates1->start_date));?>">
								<input type="hidden" name="cat_enddatetext" id="cat_enddatetext" value="<?php echo $enddate;?>">
							<?php 
							}
						}?>
						<input type="hidden" id="ids" name="ids" value="<?php echo $_REQUEST['id']; ?>"/>
						
						
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Category Type<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="category_type" id="cattype" class="validate[required] form-control m-b" >
									<option value="<?php echo $cat_update->category_type;?>"><?php echo $categort_type->value_name; ?></option>
								</select>
							</div>
						</div>
						
						<?php 
						if($cat_update->category_type=='PC'){
							$catdispaly='style="display:none;"';
						}
						else if($cat_update->category_type=='C'){
							$categories_type='PC';
							$catdispaly='style="display:block;"';
						}
						else if($cat_update->category_type=='SC'){
							$categories_type='C';
							$catdispaly='style="display:block;"';
						}
						else if($cat_update->category_type=='AC'){
							$categories_type='SC';
							$catdispaly='style="display:block;"';
						}?> 
						<div <?php echo $catdispaly; ?>>
							<div class="form-group"><label class="control-label mb-10 col-sm-2">Parent Category<sup><font color="#FF0000">*</font></sup>:</label>
								<div class="col-sm-5">
									<select name="primary_category" id="category" class="validate[required] form-control m-b">
										<option value="">select</option>
										<?php 
										foreach($category as $category1){
											$status=(isset($cat_update['primary_category']))?($cat_update['primary_category']==$category1['category_id'])?"selected='selected'":'':''?>
											<option value="<?php echo $category1->category_id;?>"<?php echo $status;?>><?php echo $category1->name; ?></option>
										<?php
										} ?>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Category Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" class="validate[required,minSize[3],maxSize[50],ajax[ajaxCategoryName]] form-control" id="subject" name="name" value="<?php echo $cat_update->name; ?>"></div>
						</div>
						
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Start Date<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<div class="input-group date" id="datepicker">
									<input type="text" placeholder="dd-mm-yyyy" name="start_date" id="stdate" value="<?php echo date('d-m-Y',strtotime($cat_update->start_date)); ?>" class="validate[required,custom[date2],future[#org_strt_dt],future[#cat_startdatetext],past[#cat_enddatetext]] form-control">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>	
								</div>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">End Date<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
							<?php if($cat_update->end_date!=NULL){?>
								<div class="input-group date" id="datepicker">
									<input type="text" id="enddate1" name="end_date" class="validate[required,custom[date2],future[#stdate],future[#cat_startdatetext],past[#cat_enddatetext],past[#org_end_dt]] form-control"  placeholder="dd-mm-yyyy"  value="<?php echo date('d-m-Y',strtotime($cat_update->end_date)); ?>" >
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>	
								</div>
							<?php 
							}
							else{ ?>
								<div class="input-group date" id="datepicker">
									<input type="text" id="enddate1" name="end_date" class="validate[required,custom[date2],future[#stdate],future[#cat_startdatetext],past[#cat_enddatetext],past[#org_end_dt]] form-control" placeholder="dd-mm-yyyy" value="" >
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>	
								</div>
							<?php } ?>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Level Scale:</label>
							<div class="col-sm-5">
								<select class="form-control m-b" name="level_id" id="level_id">
									<option value="">Select</option>
									<?php									
									foreach($levels as $level){
										$status=(isset($cat_update['level_id']))?($cat_update['level_id']==$level['level_id'])?"selected='selected'":'':''; ?>
										<option value="<?php echo $level['level_id'];?>"<?php echo @$status;?>><?php echo $level['level_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Description</label>
							<div class="col-sm-5">
								<textarea name="description" id="description" class="form-control"><?php echo $cat_update->description; ?></textarea>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status</label>

							<div class="col-sm-5">
								<select id="status" name="status" class="validate[required] form-control m-b">
									<option value="">Select</option>
									<?php foreach($statusss as $status){
										 $stat=(isset($cat_update['status']))?($cat_update['status']==$status['code'])?"selected='selected'":'':''?>
									<option value="<?php echo $status['code'];?>" <?php echo $stat;?>><?php echo $status['name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-9">
								<button class="btn btn-primary btn-sm" type="submit" name="submit_c" id="submit_c" >Save changes</button>
								<button class="btn btn-danger btn-sm" type="button" onClick="create_link('category_master_search')">Cancel</button>
							</div>
						</div>
						<?php }
						else{
						?>
						
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Category Type<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select name="category_type" id="cattype" onChange="cat_name()" class="validate[required] form-control m-b" >
									<?php 
									if(count($catcount)>0){?>                                
									<option value="">Select</option>
										<?php  foreach($category_primary as $org_value){?>
									<option value=<?php echo $org_value['value_code']; ?>><?php echo $org_value['value_name']; ?></option>
										<?php }}else{                                   
											foreach($category as $org_values1){?>
									<option value=<?php echo $org_values1['value_code']; ?>><?php echo $org_values1['value_name']; ?></option>
										<?php }}?>
								</select>

							</div>
						</div>
						<div id="parent_cat" style="display:none;"></div> 
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Category Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" class="validate[required,minSize[3],maxSize[50],ajax[ajaxCategoryName]] form-control" id="subject" name="name"></div>
						</div>
						
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Start Date<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<div class="input-group">
									<input type="text"  placeholder="dd-mm-yyyy" name="start_date" id="stdate" class="validate[required,custom[date2],future[#org_strt_dt],future[#cat_startdatetext],past[#cat_enddatetext]] form-control">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>	
								</div>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">End Date<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<div class="input-group ">
									<input type="text" id="enddate1" name="end_date" class="validate[required,custom[date2],future[#stdate],future[#cat_startdatetext],past[#cat_enddatetext],past[#org_end_dt]] form-control"  placeholder="dd-mm-yyyy" value="" >
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>	
								</div>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Level Scale</label>
							<div class="col-sm-5">
								<select class="form-control m-b" name="account">
									<option value="">Select</option>
									<?php									
									foreach($levels as $level){
										//$status=(isset($cat_update['level_id']))?($cat_update['level_id']==$level['level_id'])?"selected='selected'":'':''; ?>
										<option value="<?php echo $level['level_id'];?>"<?php echo @$status;?>><?php echo $level['level_name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Description</label>
							<div class="col-sm-5">
								<textarea name="description" id="description" class="form-control"></textarea>
							</div>
						</div>
						<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup></label>

							<div class="col-sm-5">
								<select id="status" name="status" class="validate[required] form-control m-b">
									<option value="">Select</option>
									<?php foreach($statusss as $status){
										?>
									<option value="<?php echo $status['code'];?>" ><?php echo $status['name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>	
						<hr class="light-grey-hr">
						<div class="form-group">
							<div class="col-sm-offset-0">
								<button class="btn btn-primary btn-sm" type="submit" name="submit_c" id="submit_c" >Save changes</button>
								<button class="btn btn-danger btn-sm" type="button" onClick="create_link('category_master_search')">Cancel</button>
							</div>
						</div>
						<?php
						}
						?>
						
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
