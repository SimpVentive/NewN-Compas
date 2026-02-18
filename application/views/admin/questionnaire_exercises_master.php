
<script>
<?php
// To pass the Requested Status to empcreation.js File
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}

?>
</script>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-body">
					<?php
					$inbaskets=$this->session->flashdata('inbasket');
					if(!empty($inbaskets)){ echo "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'><i class='ace-icon fa fa-times'></i></button><p>".$this->session->flashdata('inbasket')."</p></div>"; $this->session->unset_userdata('inbasket');} ?>
					<ul class="nav nav-pills">
						<?php
						if(isset($_REQUEST['id'])){
						?>
							<li id='information_li'><a data-toggle="tab" href="#infomation-info">Step 1 - Creation</a></li>
							<li id='competency_li'><a data-toggle="tab" href="#competency-info">Step 2 - Adding Competencies</a></li>
							<li id='questions_li'><a data-toggle="tab" href="#questions-info">Step 3 - Selection of Elements</a></li>
							<li id='elements_li'><a data-toggle="tab" href="#elements-info">Step 4 - Editing Elements</a></li>
							<li id='final_li'><a data-toggle="tab" href="#final-info">Step 5 - Final Questionnaire</a></li>
						<?php }
						else{
						?>
							<li id='information_li' class="active"><a data-toggle="tab" href="#infomation-info">Step 1 - Creation</a></li>
							<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#competency-info">Step 2 - Adding Competencies</a></li>
							<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#questions-info">Step 3 - Selection of Elements</a></li>
							<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#elements-info">Step 4 - Editing Elements</a></li>
							<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#final-info">Step 5 - Final Questionnaire</a></li>
						<?php
						}
						?>
					<br/><br/><br/>
					</ul>
					<div class="tab-content">
						<div id="infomation-info" class="p-m tab-pane active">
							<div class="row">
								<div class="panel-body">
									<h6 class="txt-dark capitalize-font">Creation Questionnaire</h6>
									<hr class="light-grey-hr">
									<form id="questionnaire_master" action="<?php echo BASE_URL;?>/admin/questionnaire_insert" method="post" enctype="multipart/form-data" class="form-horizontal">
										<input type="hidden" name="ques_id" id="ques_id" value="<?php echo (isset($compdetails['ques_id']))?$compdetails['ques_id']:''?>">
										<div class="form-group"><label class="control-label mb-10 col-sm-2">Process Name<sup><font color="#FF0000">*</font></sup>:</label>
											<div class="col-sm-5"><input type="text" class="validate[required] form-control" name="ques_name" id="ques_name" value="<?php echo (isset($compdetails['ques_name']))?$compdetails['ques_name']:''?>"></div>
										</div>
										<div class="form-group"><label class="control-label mb-10 col-sm-2">Short Description:</label>
											<div class="col-sm-5">
												<textarea class="form-control m-b" name="ques_description" id="ques_description" ><?php echo (isset($compdetails['ques_description']))?$compdetails['ques_description']:''?></textarea>
											</div>
										</div>
										<div class="form-group"><label class="control-label mb-10 col-sm-2">Start Date<sup><font color="#FF0000">*</font></sup>:</label>
											<div class="col-sm-5">
												<div class="input-group date" id="datepicker">
													
													<input type="text" class="validate[required,custom[date2]]  form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="start_date" id="stdate" value="<?php if(!empty($compdetails['start_date'])){ if($compdetails['start_date']!='0000-00-00' || $compdetails['start_date']!=NULL){ echo  date('d-m-Y',strtotime($compdetails['start_date']));}}?>">
													<span class="input-group-addon">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group"><label class="control-label mb-10 col-sm-2">End Date<sup><font color="#FF0000">*</font></sup>:</label>
											<div class="col-sm-5">
												<div class="input-group date" id="datepicker">
													<input type="text" class="validate[required,custom[date2],future[#stdate]] form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="end_date" id="enddate" value="<?php if(!empty($compdetails['end_date'])){ if($compdetails['end_date']!='0000-00-00' || $compdetails['end_date']!=NULL){ echo  date('d-m-Y',strtotime($compdetails['end_date']));}}?>">
													<span class="input-group-addon">
														<span class="fa fa-calendar"></span>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group"><label class="control-label mb-10 col-sm-2">Position Name<sup><font color="#FF0000">*</font></sup>:</label>
											<div class="col-sm-5">
												<select class="form-control m-b validate[required]" name="position_id" id="position_id" data-prompt-position="topLeft:200">
													<option value="">Select</option>
													<?php
													foreach($positions as $position){
														$sel_sat=(isset($compdetails['position_id']))?($compdetails['position_id']==$position['position_id'])?"selected='selected'":'':''?>
														<option value="<?php echo $position['position_id']?>" <?php echo $sel_sat?>><?php echo $position['position_name']?></option>
													<?php
													}?>
												</select>
											</div>
										</div>
										<div class="form-group"><label class="control-label mb-10 col-sm-2">Rating Scale<sup><font color="#FF0000">*</font></sup>:</label>

											<div class="col-sm-5">
												<select class="validate[required] form-control m-b" name="rating_id" id="rating_id">
													<option value="">Select</option>
													<?php 	
													foreach($rating as $ratings){
														$rat_sat=(isset($compdetails['rating_id']))?($compdetails['rating_id']==$ratings['rating_id'])?"selected='selected'":'':''?>
														<option value="<?php echo $ratings['rating_id']?>" <?php echo $rat_sat?>><?php echo $ratings['rating_name']?></option>
													<?php 	
													}?>
												</select>
											</div>
										</div>
										<div class="form-group"><label class="control-label mb-10 col-sm-2">No of Elements Limit<sup><font color="#FF0000">*</font></sup>:</label>

											<div class="col-sm-5">
												<input type="text" class="validate[required] form-control" name="no_elements" id="no_elements"  value="<?php echo (isset($compdetails['no_elements']))?$compdetails['no_elements']:''?>">
											</div>
										</div>
										<div class="form-group"><label class="control-label mb-10 col-sm-2">Status<sup><font color="#FF0000">*</font></sup>:</label>

											<div class="col-sm-5">
												<select class="validate[required] form-control m-b" name="status" id="status">
													<option value="">Select</option>
													<?php 	
													foreach($orgstat as $orgstatus){
														$sel_sat=(isset($compdetails['status']))?($compdetails['status']==$orgstatus['code'])?"selected='selected'":'':''?>
														<option value="<?php echo $orgstatus['code']?>" <?php echo $sel_sat?>><?php echo $orgstatus['name']?></option>
													<?php 	
													}?>
												</select>
											</div>
										</div>
										<hr class="light-grey-hr">
										<div class="form-group">
											<div class="col-sm-offset-9">
											   <button class="btn btn-danger btn-sm" type="button" onclick="create_link('questionnaire_exercises_master_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
											   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div id="competency-info" class="p-m tab-pane">
							<form id="comp_master" action="<?php echo BASE_URL;?>/admin/questionnaire_competency_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="ques_id" id="ques_id" value="<?php echo (isset($compdetails['ques_id']))?$compdetails['ques_id']:''?>">
							<div class="panel-body">
								<div class="panel-heading hbuilt">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Add Competency Requirements</h6>
									</div>
									
									
								</div>
								<br style="clear:both">
								<div class="table-responsive">
									<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="competencyposTab" name="competencyposTab">
										<thead>
											<tr>
												<th style="width:5%;">select</th>
												<th style="width:35%;">Competency Name</th>
												<th style="width:20%;">Competency Scale</th>
											</tr>
										</thead>
										<tbody>
										<?php
										
										if(!empty($positiondetails)){
											$hide_val_c=array();
											foreach($positiondetails as $key=>$positiondetail){ 
												$key1=$key+1; $hide_val_c[]=$key1; ?> 
											<tr>
												<td style='padding-left: 18px;'>
												<?php $check=($positiondetail['ques_competency_id']==$positiondetail['comp_def_id'])?"checked=checked":""; ?>
													<input type="checkbox" name="chkbox_select[]" id="chkbox_<?php echo $key1; ?>" value="<?php echo $positiondetail['comp_def_id'] ?>" class="" <?php echo $check; ?>>
													<input type="hidden" name="ques_competency_id[]" id="ques_competency_id_<?php echo $key1; ?>" value="<?php echo $positiondetail['comp_def_id']; ?>">
													<input type="hidden" name="ques_level_scale_id[<?php echo $positiondetail['comp_def_id'] ?>]" id="ques_level_scale_id_<?php echo $key1; ?>" value="<?php echo $positiondetail['scale_id']; ?>">
													<input type="hidden" name="ques_comp_id[]" id="ques_comp_id_<?php echo $key1; ?>" value="<?php echo $positiondetail['ques_comp_id']; ?>">
												</td>
												<td><?php echo $positiondetail['comp_def_name']; ?></td>
												<td><?php echo $positiondetail['scale_name']; ?></td>
												
											</tr><?php }  $hidden=@implode(',',$hide_val_c); 
										}
										?>
										</tbody>
									</table>
									
								</div>
								
							</div>
							
							
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
								   <button class="btn btn-danger btn-sm" type="button" onclick="create_link('questionnaire_exercises_master_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
								   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
								</div>
							</div>
							</form>
						</div>
						<div id="questions-info" class="p-m tab-pane">
							<form id="comp_master" action="<?php echo BASE_URL;?>/admin/questionnaire_element_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="ques_id" id="ques_id" value="<?php echo (isset($compdetails['ques_id']))?$compdetails['ques_id']:''?>">
							<div class="panel-body">
								<div class="panel-heading hbuilt">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Selection Of Elements</h6>
									</div>
									
									
								</div>
								<br style="clear:both">
								<div class="table-responsive">
									<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="element_validation" name="element_validation">
										<thead>
											<tr>
												<th style="width:5%;">Select</th>
												<th style="width:60;">Elements</th>
												<th style="width:20%;">Competency Name</th>
												<th style="width:15%;">Competency Scale</th>
												
											</tr>
										</thead>
										<tbody>
										<?php
										
										if(!empty($elements)){
											$hide_val_c=array();
											$temp="";
											foreach($elements as $key=>$element){ 
												$key1=$key+1; 
												
												?> 
											<tr>
												<td style='padding-left: 18px;'>
												<?php $check=($element['element_ids']==$element['element_id'])?"checked=checked":""; ?>
													<input type="checkbox" name="chkbox_select_ele[]" id="chkbox_<?php echo $key1; ?>" value="<?php echo $element['element_id'] ?>" class="validate[required,maxCheckbox[<?php echo (isset($compdetails['no_elements']))?$compdetails['no_elements']:''?>]]" <?php echo $check; ?>>
													<input type="hidden" name="element_id_ele[]" id="element_id_<?php echo $key1; ?>" value="<?php echo $element['element_id']; ?>">
													<input type="hidden" name="element_competency_id_ele[<?php echo $element['element_id'] ?>]" id="element_competency_id_<?php echo $key1; ?>" value="<?php echo $element['comp_def_id']; ?>">
													<input type="hidden" name="element_level_scale_id_ele[<?php echo $element['element_id'] ?>]" id="element_level_scale_id_<?php echo $key1; ?>" value="<?php echo $element['scale_id']; ?>">
													<input type="hidden" name="ques_element_id_ele[<?php echo $element['element_id'] ?>]" id="ques_element_id_<?php echo $key1; ?>" value="<?php echo $element['ques_element_id']; ?>">
												</td>
												<td><?php echo $element['element_name']; ?></td>
												<td><?php echo $element['comp_def_name'];?></td>
												<td><?php echo $element['scale_name']; ?></td>
												
											</tr><?php }  $hidden=@implode(',',$hide_val_c); 
										}
										?>
										</tbody>
									</table>
									
								</div>
								
							</div>
							
							
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
								   <button class="btn btn-danger btn-sm" type="button" onclick="create_link('questionnaire_exercises_master_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
								   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
								</div>
							</div>
							</form>
						
						</div>
						<div id="elements-info" class="p-m tab-pane">
							<form id="comp_master" action="<?php echo BASE_URL;?>/admin/questionnaire_element_edit" method="post" enctype="multipart/form-data">
							<input type="hidden" name="ques_id" id="ques_id" value="<?php echo (isset($compdetails['ques_id']))?$compdetails['ques_id']:''?>">
							<div class="panel-body">
								<div class="panel-heading hbuilt">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Edit Of Elements</h6>
									</div>
									
									
								</div>
								<br style="clear:both">
								<div class="table-responsive">
									<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="element_validation" name="element_validation">
										<thead>
											<tr>
												<th style="width:5%;">S.No</th>
												<th style="width:55%;">Elements</th>
												<th style="width:40%;">Language</th>
											</tr>
										</thead>
										<tbody>
										<?php
										
										if(!empty($edit_elements)){
											$hide_val_c=array();
											$temp="";
											foreach($edit_elements as $key=>$edit_element){ 
												$key1=$key+1; 
												$element_name=!empty($edit_element['element_id_edit'])?$edit_element['element_id_edit']:$edit_element['element_name'];
												$element_language=!empty($edit_element['element_language'])?$edit_element['element_language']:"";
												?> 
											<tr>
												<td><?php echo $key1; ?></td>
												<td style='padding-left: 18px;'>
													<input type="hidden" name="ques_element_id[]" id="element_id_<?php echo $key1; ?>" value="<?php echo $edit_element['ques_element_id']; ?>">
													<input type="text" name="element_id_edit[]" id="element_id_edit[]" value="<?php echo $element_name; ?>" class="validate[required] form-control">
												</td>
												<td>
												<input type="text" name="element_language[]" id="element_language[]" value="<?php echo $element_language; ?>" class="validate[required] form-control">
												</td>
												
											</tr><?php }  $hidden=@implode(',',$hide_val_c); 
										}
										?>
										</tbody>
									</table>
									
								</div>
								
							</div>
							
							
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
								   <button class="btn btn-danger btn-sm" type="button" onclick="create_link('questionnaire_exercises_master_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
								   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
								</div>
							</div>
							</form>
						
						</div>
						<div id="final-info" class="p-m tab-pane">
							<form id="comp_master" action="<?php echo BASE_URL;?>/admin/questionnaire_element_edit" method="post" enctype="multipart/form-data">
							<input type="hidden" name="ques_id" id="ques_id" value="<?php echo (isset($compdetails['ques_id']))?$compdetails['ques_id']:''?>">
							<div class="panel-body">
								<div class="panel-heading hbuilt">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Final Of Elements</h6>
									</div>
									
									
								</div>
								<br style="clear:both">
								<div class="table-responsive">
									<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="element_validation" name="element_validation">
										<thead>
											<tr>
												<th style="width:5%;">S.No</th>
												<th style="width:95%;">Elements</th>
												
											</tr>
										</thead>
										<tbody>
										<?php
										
										if(!empty($edit_elements)){
											foreach($edit_elements as $key=>$edit_element){ 
												$key1=$key+1; 
												$element_name=!empty($edit_element['element_id_edit'])?$edit_element['element_id_edit']:$edit_element['element_name'];
												?> 
											<tr>
												<td><?php echo $key1; ?></td>
												<td style='padding-left: 18px;'><?php echo $element_name; ?></td>
											</tr>
											<?php 
											} 
										}
										?>
										</tbody>
									</table>
									
								</div>
								
							</div>
							
							
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
								   <button class="btn btn-primary btn-sm" type="button" onclick="create_link('questionnaire_exercises_master_search')"><i class="fa fa-check"></i> Submit</button>
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
<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Intray ?.
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		Selected Intray cannot be deleted. Ensure you delete all the usages of the Intray before you delete it.
	</div>

	<div class="space-6"></div>
	
</div>
<?php
if(!empty($inbasket['question_id'])){
	$question_view=UlsQuestionValues::get_allquestion_values_competency($inbasket['question_id']);
	foreach($question_view as $key=>$question_views){
	?>
	<div id="workinfoviewadd<?php echo $question_views['value_id'];?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="color-line"></div>
				<div class="modal-header">
					<h6 class="modal-title">Edit Intray</h6>
				</div>
				<div class="modal-body">
					<div id="questionbank_count<?php echo $question_views['value_id'];?>" class="modal-body no-padding">
					
					</div>
				</div>
				
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	<?php 
	}
}?>