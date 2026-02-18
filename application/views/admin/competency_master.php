<style>
.form-horizontal .control-label1 {
    margin-bottom: 0;
    padding-top: 7px;
    text-align: left;
}
</style>
<script>
<?php 
// To pass the Requested Status to empcreation.js File
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}
$ques_details='';
foreach($comp_ques as $comp_que){
    if($ques_details==''){
        $ques_details=$comp_que['question_bank_id']."*".$comp_que['name'];
    }
    else{
        $ques_details=$ques_details."@".$comp_que['question_bank_id']."*".$comp_que['name'];
    }
}
echo "var ques_detail='".$ques_details."';";

$int_details='';
foreach($comp_interview as $comp_interviews){
    if($int_details==''){
        $int_details=$comp_interviews['question_bank_id']."*".$comp_interviews['name'];
    }
    else{
        $int_details=$int_details.",".$comp_interviews['question_bank_id']."*".$comp_interviews['name'];
    }
}
echo "var int_detail='".$int_details."';";
?>
</script>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<ul class="nav nav-pills">
						<?php 	
						if(isset($_REQUEST['id'])){
						?>
							<li id='information_li' ><a data-toggle="tab" href="#infomation-info">Step 1 - Competency Information</a></li>
							<li id='competency_li'><a data-toggle="tab" href="#competency-info">Step 2 - Add Question Banks</a></li>
							<li id='questions_li'><a data-toggle="tab" href="#questions-info">Step 3 - Add Interview Questions</a></li>
						<?php }
						else{
						?>
							<li id='information_li' class="active"><a data-toggle="tab" href="#infomation-info">Step 1 - Competency Information</a></li>
							<li class="disabled" style='pointer-events:none;'><a data-toggle="tab" href="#competency-info">Step 2 - Add Question Banks</a></li>
							<li class="disabled" style='pointer-events:none;'><a data-toggle="tab" href="#questions-info">Step 3 -Add Interview Questions</a></li>
						<?php
						}
						?>
					</ul>
					<div class="tab-content">
						<div id="infomation-info" class="p-m tab-pane active">
							<form id="comp_master" action="<?php echo BASE_URL;?>/admin/competency_insert" method="post" enctype="multipart/form-data" class="form-horizontal"><sub><font color="#FF0000">* Indicated are Mandatory </font></sub>
								<h5 class="m-t-none m-b-sm">
								<?php 
								if(isset($_REQUEST['id'])){
								?>
								<div class="pull-right">
									<a href="<?php echo BASE_URL;?>/admin/competency_levels?status&id=<?php echo @$comp_def['comp_def_id'];?>&hash=<?php echo md5(SECRET.$comp_def['comp_def_id']);?>" class="btn w-xs btn-primary">Competency Details</a>
									<a href="<?php echo BASE_URL;?>/admin/questionbank_search" target="_blank"  class="btn w-xs btn-primary">Question Banks</a>
								</div>
								<div class="clearfix"></div>
								<?php } ?>
								</h5>
								<div class="hr-line-dashed"></div>
								<input type="hidden" name="comp_def_id" id="comp_def_id" value="<?php echo (isset($comp_def['comp_def_id']))?$comp_def['comp_def_id']:''?>">
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Competency Name<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5"><input type="text" name="comp_def_name" id="comp_def_name" class="validate[required] form-control" value="<?php echo (isset($comp_def['comp_def_name']))?$comp_def['comp_def_name']:''?>"></div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Competency Alter Name<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5"><input type="text" name="comp_def_name_alt" id="comp_def_name_alt" class="form-control" value="<?php echo (isset($comp_def['comp_def_name_alt']))?$comp_def['comp_def_name_alt']:''?>"></div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Competency Type<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5">
										<select class="validate[required] form-control m-b" id="competency_type" name="competency_type" style="width: 100%">
											<option value="">Select</option>
											<?php 
											foreach($comp_types as $comp_type){
												$dep_sel=isset($comp_def['competency_type'])?($comp_def['competency_type']==$comp_type['code'])?"selected='selected'":"":"";
												?>
													<option value="<?php echo $comp_type['code'];?>" <?php echo $dep_sel; ?>><?php echo $comp_type['name'];?></option>
												<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Competency Structure<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5">
										<select class="validate[required] form-control m-b" id="comp_structure" name="comp_structure" style="width: 100%">
											<option value="">Select</option>
											<?php 
											foreach($comp_str as $comp_strs){
												$dep_sel=isset($comp_def['comp_structure'])?($comp_def['comp_structure']==$comp_strs['code'])?"selected='selected'":"":"";
												?>
													<option value="<?php echo $comp_strs['code'];?>" <?php echo $dep_sel; ?>><?php echo $comp_strs['name'];?></option>
												<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Business:</label>
									<div class="col-sm-5">
										<select class=" form-control m-b" id="bu_id" name="bu_id" style="width: 100%">
											<option value="">Select</option>
											<?php 
											foreach($pos_bu_name as $orgname){
												$dep_sel=isset($comp_def['bu_id'])?($comp_def['bu_id']==$orgname->id)?"selected='selected'":"":"";
												?>
													<option value="<?php echo $orgname->id;?>" <?php echo $dep_sel; ?>><?php echo $orgname->name;?></option>
												<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Category<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5">
										<select class="validate[required] form-control m-b" name="comp_def_category" id="comp_def_category" onchange="open_subcategory();">
											<option value="">Select</option>
											<?php 	
											foreach($cat_details as $cat_detail){
												$sel_sat=(isset($comp_def['comp_def_category']))?($comp_def['comp_def_category']==$cat_detail['category_id'])?"selected='selected'":'':''?>
												<option value="<?php echo $cat_detail['category_id']?>" <?php echo $sel_sat?>><?php echo $cat_detail['name']?></option>
											<?php 	
											}?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Area</label>
									<div class="col-sm-5">
										<select class="form-control m-b" name="comp_def_sub_category" id="comp_def_sub_category" onchange="open_addcategory();">
											<option value="">Select</option>
											<?php 	
											foreach($subcat_details as $subcat_detail){
												$sel_sat=(isset($comp_def['comp_def_sub_category']))?($comp_def['comp_def_sub_category']==$subcat_detail['category_id'])?"selected='selected'":'':''?>
												<option value="<?php echo $subcat_detail['category_id']?>" <?php echo $sel_sat?>><?php echo $subcat_detail['name']?></option>
											<?php 	
											}?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Additional Category</label>
									<div class="col-sm-5">
										<select class="form-control m-b" name="comp_def_add_category" id="comp_def_add_category">
											<option value="">Select</option>
											<?php 	
											foreach($addcat_details as $addcat_detail){
												$sel_sat=(isset($comp_def['comp_def_add_category']))?($comp_def['comp_def_add_category']==$addcat_detail['category_id'])?"selected='selected'":'':''?>
												<option value="<?php echo $addcat_detail['category_id']?>" <?php echo $sel_sat?>><?php echo $addcat_detail['name']?></option>
											<?php 	
											}?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Level<sup><font color="#FF0000">*</font></sup>:</label>
									<div class="col-sm-5">
									<!--onchange="open_levels();"-->
										<select class="validate[required] form-control m-b" name="comp_def_level" id="comp_def_level" >
											<option value="">Select</option>
											<?php 	
											foreach($levels as $level){
												$sel_sat=(isset($comp_def['comp_def_level']))?($comp_def['comp_def_level']==$level['level_id'])?"selected='selected'":'':''?>
												<option value="<?php echo $level['level_id']?>" <?php echo $sel_sat?>><?php echo $level['level_name']?></option>
											<?php 	
											}?>
										</select>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Short Description</label>
									<div class="col-sm-8">
										<textarea class="summernote form-control m-b" name="comp_def_short_desc" id="comp_def_short_desc"><?php echo (isset($comp_def['comp_def_short_desc']))?$comp_def['comp_def_short_desc']:''?></textarea>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Key Coverage</label>
									<div class="col-sm-8">
										<textarea class="summernote form-control m-b" name="comp_def_key_coverage" id="comp_def_key_coverage"><?php echo (isset($comp_def['comp_def_key_coverage']))?$comp_def['comp_def_key_coverage']:''?></textarea>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Key Indicators</label>
									<div class="col-sm-8">
										<textarea class="summernote form-control m-b" name="comp_def_key_indicator" id="comp_def_key_indicator"><?php echo (isset($comp_def['comp_def_key_indicator']))?$comp_def['comp_def_key_indicator']:''?></textarea>
									</div>
								</div>
								<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>

									<div class="col-sm-5">
										<select class="validate[required] form-control m-b" name="comp_def_status" id="comp_def_status">
											<option value="">Select</option>
											<?php 	
											foreach($status as $statuss){
												$sel_sat=(isset($comp_def['comp_def_status']))?($comp_def['comp_def_status']==$statuss['code'])?"selected='selected'":'':''?>
												<option value="<?php echo $statuss['code']?>" <?php echo $sel_sat?>><?php echo $statuss['name']?></option>
											<?php 	
											}?>
										</select>
									</div>
								</div>
								<div id="open_level"></div>
								<hr class="light-grey-hr">
								<div class="form-group">
									<div class="col-sm-offset-0">
										<button class="btn btn-primary btn-sm" type="submit" name="submit">Save changes</button>
										<button class="btn btn-danger btn-sm" type="button" onClick="create_link('competency_master_search')">Cancel</button>
										
									</div>
								</div>
							</form>
						</div>
						<div id="competency-info" class="p-m tab-pane">
							<form id="assessor_comp" action="<?php echo BASE_URL;?>/admin/comp_questionbank_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="comp_def_id" id="comp_def_id" value="<?php echo (isset($comp_def['comp_def_id']))?$comp_def['comp_def_id']:''?>">
								<?php 
								if(isset($_REQUEST['id'])){
								?>
								
								<div class="pull-right">
									<a href="<?php echo BASE_URL;?>/admin/competency_levels?status&id=<?php echo (isset($comp_def['comp_def_id']))?@$comp_def['comp_def_id']."&hash=".md5(SECRET.$comp_def['comp_def_id']):'';?>" class="btn w-xs btn-primary">Competency Details</a>
									<a href="<?php echo BASE_URL;?>/admin/questionbank_search" target="_blank"  class="btn w-xs btn-primary">Question Banks</a>
								</div>
								<?php } ?>
								<br style="clear:both">
								<div class="hr-line-dashed"></div>
								
								<div class="panel-heading hbuilt">
									
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Add Question Bank</h6>
									</div>
									<div class="pull-right">
										<a class="btn btn-xs btn-primary" onClick="return addsource_details_certified()">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
										<a class="btn btn-danger btn-xs" onClick="delete_certified()">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
									</div>
								</div>
								<br style="clear:both">
								<div class="table-responsive">
									<table id="source_table_certified" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
										<thead>
										<tr>
											<th>Select</th>
											<th>Question Banks</th>
										</tr>
										</thead>
										<tbody>
										<?php
										if(!empty($quesbanks)){
											$hide_val=array();
											foreach($quesbanks as $key=>$quesbank){ 
												$key1=$key+1; $hide_val[]=$key1;
												?>
												<tr id='subgrd_inst<?php echo $key1; ?>'>
													<td><label><input type="checkbox" id="chkbox_inst<?php echo $key1; ?>" name="chkbox[]" value="<?php echo $quesbank['comp_def_que_bank_id'];?>" ></label>
													<input type="hidden" id="comp_def_que_bank_id<?php echo $key1; ?>" name="comp_def_que_bank_id[]" value="<?php echo $quesbank['comp_def_que_bank_id'];?>">
													</td>
													<td>
														<select class="form-control m-b" name="master_ques_bank_id[]" id="master_ques_bank_id<?php echo $key1; ?>" >
															<option value="">Select</option>
															<?php 
															foreach($comp_ques as $comp_que){
																$cat_sel=isset($quesbank['master_ques_bank_id'])?($quesbank['master_ques_bank_id']==$comp_que['question_bank_id'])?"selected='selected'":"":"";
																?>
																<option value="<?php echo $comp_que['question_bank_id'];?>" <?php echo $cat_sel; ?>><?php echo $comp_que['name'];?></option>
															<?php
															}
															?>
														</select>
													</td>
												</tr>
											<?php 
											}
											$hidden_certified=@implode(',',$hide_val);
										}
										else{?>
											<tr id='subgrd_inst1'>
												<td><label><input type="checkbox" id="chkbox_inst1" name="chkbox[]" value=""></label>
												<input type="hidden" id="comp_def_que_bank_id1" name="comp_def_que_bank_id[]" value="">
												</td>
												<td>
													<select class="form-control m-b" name="master_ques_bank_id[]" id="master_ques_bank_id1">
														<option value="">Select</option>
														<?php 
														foreach($comp_ques as $comp_que){
															?>
															<option value="<?php echo $comp_que['question_bank_id'];?>" ><?php echo $comp_que['name'];?></option>
														<?php
														}
														?>
													</select>
												</td>
											</tr>
										<?php 
											$hidden_certified=1;
										} ?>
										</tbody>
										<input type="hidden" name="addgroup_certified" id="addgroup_certified" value="<?php echo $hidden_certified; ?>" />
									</table>
								</div>
								<hr class="light-grey-hr">
								<div class="form-group">
									<div class="col-sm-offset-0">
										
										<button class="btn btn-primary btn-sm" type="submit" name="submit" onclick="return addsource_details_casestudy_validation(1);">Save changes</button>
										<button class="btn btn-danger btn-sm" type="button" onClick="create_link('competency_master_search')">Cancel</button>
									</div>
								</div>
							</form>
						</div>
						<div id="questions-info" class="p-m tab-pane">
							<form id="assessor_comp" action="<?php echo BASE_URL;?>/admin/comp_interview_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="comp_def_id" id="comp_def_id" value="<?php echo (isset($comp_def['comp_def_id']))?$comp_def['comp_def_id']:''?>">
								<div class="panel-heading hbuilt">
									
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Add Interview Questions</h6>
									</div>
									<div class="pull-right">
										<a class="btn btn-xs btn-primary" onClick="return addsource_details_interview()">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
										<a class="btn btn-danger btn-xs" onClick="delete_interview()">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
									</div>
								</div>
								<br style="clear:both">
								<div class="table-responsive">
									<table id="source_table_interview" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
										<thead>
										<tr>
											<th>Select</th>
											<th>Interview Question Banks</th>
										</tr>
										</thead>
										<tbody>
										<?php
										if(!empty($intquestions)){
											$hide_val=array();
											foreach($intquestions as $key=>$intquestion){ 
												$key1=$key+1; $hide_val[]=$key1;
												?>
												<tr id='subgrd_interview<?php echo $key1; ?>'>
													<td><label><input type="checkbox" id="chkbox_int<?php echo $key1; ?>" name="chkbox_int[]" value="<?php echo $intquestion['comp_def_inter_ques_id'];?>" ></label>
													<input type="hidden" id="comp_def_inter_ques_id<?php echo $key1; ?>" name="comp_def_inter_ques_id[]" value="<?php echo $intquestion['comp_def_inter_ques_id'];?>">
													</td>
													<td>
														<select class="form-control m-b" name="master_int_ques_bank_id[]" id="master_int_ques_bank_id<?php echo $key1; ?>" >
															<option value="">Select</option>
															<?php 
															foreach($comp_interview as $comp_interviews){
																$cat_sel=isset($intquestion['master_int_ques_bank_id'])?($intquestion['master_int_ques_bank_id']==$comp_interviews['question_bank_id'])?"selected='selected'":"":"";
																?>
																<option value="<?php echo $comp_interviews['question_bank_id'];?>" <?php echo $cat_sel; ?>><?php echo $comp_interviews['name'];?></option>
															<?php
															}
															?>
														</select>
													</td>
												</tr>
											<?php 
											}
											$hidden_interview=@implode(',',$hide_val);
										}
										else{?>
											<tr id='subgrd_interview1'>
												<td><label><input type="checkbox" id="chkbox_int1" name="chkbox_int[]" value=""></label>
												<input type="hidden" id="comp_def_inter_ques_id1" name="comp_def_inter_ques_id[]" value="">
												</td>
												<td>
													<select class="form-control m-b" name="master_int_ques_bank_id[]" id="master_int_ques_bank_id1">
														<option value="">Select</option>
														<?php 
														foreach($comp_interview as $comp_interviews){
															?>
															<option value="<?php echo $comp_interviews['question_bank_id'];?>" ><?php echo $comp_interviews['name'];?></option>
														<?php
														}
														?>
													</select>
												</td>
											</tr>
										<?php 
											$hidden_interview=1;
										} ?>
										</tbody>
										<input type="hidden" name="addgroup_interview" id="addgroup_interview" value="<?php echo $hidden_interview; ?>" />
									</table>
								</div>
								<hr class="light-grey-hr">
								<div class="form-group">
									<div class=" col-sm-offset-0">
										<button class="btn btn-primary btn-sm" type="submit" name="submit" onclick="return addsource_details_casestudy_validation(2);">Save changes</button>
											<button class="btn btn-danger btn-sm" type="button" onClick="create_link('competency_master_search')">Cancel</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
