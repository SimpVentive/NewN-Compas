<script>
<?php
// To pass the Requested Status to empcreation.js File
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}

$competencyms_name='';
foreach($competencymsdetails as $competencydetail){
    if($competencyms_name==''){
        $competencyms_name=$competencydetail['comp_def_id']."*".str_replace(array(",","'"),array("",""),$competencydetail['comp_def_name']);
    }
    else{
        $competencyms_name=$competencyms_name.",".$competencydetail['comp_def_id']."*".str_replace(array(",","'"),array("",""),$competencydetail['comp_def_name']);
    }
}
$competencynms_name='';
foreach($competencynmsdetails as $competencydetail){
    if($competencynms_name==''){
        $competencynms_name=$competencydetail['comp_def_id']."*".str_replace(array(",","'"),array("",""),$competencydetail['comp_def_name']);
    }
    else{
        $competencynms_name=$competencynms_name.",".$competencydetail['comp_def_id']."*".str_replace(array(",","'"),array("",""),$competencydetail['comp_def_name']);
    }
}
echo "var competency_detailsms='".$competencyms_name."';";
echo "var competency_detailsnms='".$competencynms_name."';";

$competency_test='';
foreach($case_study_test as $case_study_tests){
    if($competency_test==''){
        $competency_test=$case_study_tests['question_bank_id']."*".$case_study_tests['name'];
    }
    else{
        $competency_test=$competency_test.",".$case_study_tests['question_bank_id']."*".$case_study_tests['name'];
    }
}
echo "var test_details='".$competency_test."';";
?>
</script>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-body">
					<?php
					$casestudy_admin=$this->session->flashdata('casestudy_admin');
					if(!empty($casestudy_admin)){ echo "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'><i class='ace-icon fa fa-times'></i></button><p>".$this->session->flashdata('casestudy_admin')."</p></div>"; $this->session->unset_userdata('casestudy_admin');} ?>
					<ul class="nav nav-pills">
						<?php
						if(isset($_REQUEST['id'])){
						?>
							<li id='information_li'><a data-toggle="tab" href="#infomation-info">Step 1 - Case Information</a></li>
							<li id='competency_li'><a data-toggle="tab" href="#competency-info">Step 2 - Case Questions</a></li>
							<li id='questions_li'><a data-toggle="tab" href="#questions-info">Step 3 - Preview And Publish</a></li>
						<?php }
						else{
						?>
							<li id='information_li' class="active"><a data-toggle="tab" href="#infomation-info">Step 1 - Case Information</a></li>
							<li class="disabled" style='pointer-events:none;'><a data-toggle="tab" href="#competency-info">Step 2 - Case Questions</a></li>
							<li class="disabled" style='pointer-events:none;'><a data-toggle="tab" href="#questions-info">Step 3 - Preview And Publish</a></li>
						<?php
						}
						?>
					<br/><br/><br/>
					</ul>

					<div class="tab-content">
						<div id="infomation-info" class="p-m tab-pane active">
							<form id="case_master" action="<?php echo BASE_URL;?>/admin/case_master_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="casestudy_id" id="casestudy_id" value="<?php echo (isset($case_study['casestudy_id']))?$case_study['casestudy_id']:''?>">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group col-lg-6">
										<label class="control-label mb-10 text-left">Type<sup><font color="#FF0000">*</font></sup>:</label>
										<select class="validate[required] form-control m-b" name="casestudy_type" id="casestudy_type">
											<option value="">Select</option>
											<?php
											foreach($casestat as $casestats){
												$sel_sat=(isset($case_study['casestudy_type']))?($case_study['casestudy_type']==$casestats['code'])?"selected='selected'":'':''?>
												<option value="<?php echo $casestats['code']?>" <?php echo $sel_sat?>><?php echo $casestats['name']?></option>
											<?php
											}?>
										</select>
									</div>
									<div class="form-group col-lg-6">
										<label class="control-label mb-10 text-left">Case Study Name<sup><font color="#FF0000">*</font></sup>:</label>
										<input type="text" value="<?php echo (isset($case_study['casestudy_name']))?$case_study['casestudy_name']:''?>" class="validate[required,ajax[ajaxcasestudy]] form-control" name="casestudy_name" id="casestudy_name" data-prompt-position="topLeft:200" >
									</div>
									<div class="form-group col-lg-12">
										<label class="control-label mb-10 text-left">Description</label>
										<textarea type="text" name='casestudy_description' class="validate[minSize[3]]  form-control summernote" id="casestudy_description" data-prompt-target="prompt-req-summary" data-prompt-position="inline"><?php echo (isset($case_study['casestudy_description']))?$case_study['casestudy_description']:''?></textarea>
									</div>
									<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Time Intervel(Mins)<sup><font color="#FF0000">*</font></sup>:</label>
											<select class="form-control m-b validate[required]" name="casestudy_time_period" id="casestudy_time_period" data-prompt-position="topLeft:200">
												<option value="">Select</option>
												<?php 
												for($i=10; $i<=300; $i+=10){
												$sel_time=(isset($case_study['casestudy_time_period']))?($case_study['casestudy_time_period']==$i)?"selected='selected'":'':''?>
												<option value='<?php echo $i;?>' <?php echo $sel_time; ?>><?php echo $i;?></option>
												<?php
												}
												?>
											
											</select>
										</div>
									<div class="form-group col-lg-6">
										<label class="control-label mb-10 text-left">Link</label>
										<input type="text" class="form-control"  value="<?php echo (isset($case_study['casestudy_link']))?$case_study['casestudy_link']:''?>" name="casestudy_link" id="casestudy_link">
									</div>
									<div class="form-group col-lg-6">
										<label class="control-label mb-10 text-left">Source</label>
										<input type="file" id="casestudy_source" name="casestudy_source" >
										<label><?php echo @$case_study['casestudy_source']; ?></label>
									</div>


									<div class="form-group col-lg-6">
										<label class="control-label mb-10 text-left">Status<sup><font color="#FF0000">*</font></sup>:</label>
										<select class="validate[required] form-control m-b" name="casestudy_status" id="casestudy_status"  data-prompt-position="topLeft:200" >
											<option value="">Select</option>
											<?php
											foreach($orgstat as $orgstatus){
												$sel_sat=(isset($case_study['casestudy_status']))?($case_study['casestudy_status']==$orgstatus['code'])?"selected='selected'":'':'';
												$sel_sat=!isset($case_study['casestudy_status'])?('A'==$orgstatus['code'])?"selected='selected'":$sel_sat:$sel_sat;
												?>
												<option value="<?php echo $orgstatus['code']?>" <?php echo $sel_sat?>><?php echo $orgstatus['name']?></option>
											<?php
											}?>
										</select>
									</div>
								</div>
							</div>

							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
								   <button class="btn btn-danger btn-sm" type="button" onclick="create_link('case_study_master_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
								   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
								</div>
							</div>
							</form>
						</div>
						<div id="competency-info" class="p-m tab-pane">
							<form id="case_master" action="<?php echo BASE_URL;?>/admin/casestudy_competency_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="casestudy_id" id="casestudy_id" value="<?php echo (isset($case_study['casestudy_id']))?$case_study['casestudy_id']:''?>">
							<input type="hidden" name="casestudy_quest_id" id="casestudy_quest_id" value="">
							
							<div class="row">
								<div class="col-lg-12">
									<div class="row">
										<div class="form-group col-lg-12">
											<label class="control-label mb-10 text-left">Question Name<sup><font color="#FF0000">*</font></sup>:</label>
											<textarea type="text" name='casestudy_quest' class="validate[required,minSize[3]]  form-control summernote" id="casestudy_quest" style="resize:none;"  data-prompt-target="prompt-req-summary" data-prompt-position="inline"></textarea>
										</div>
										<div class="form-group col-lg-12">
											<label class="control-label mb-10 text-left">Suggested Answer:</label>
											<textarea type="text" name='casestudy_quest_answer' class="validate[minSize[3]]  form-control summernote" id="casestudy_quest_answer" style="resize:none;"  data-prompt-target="prompt-req-summary" data-prompt-position="inline"></textarea>
										</div>
										<div class="panel-heading hbuilt">
											
											<div class="pull-left">
												<h6 class="panel-title txt-dark">Add Competencies</h6>
											</div>
											<div class="pull-right">
												<a class="btn btn-xs btn-primary" onClick="return addsource_details_casestudy()">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
												<a class="btn btn-danger btn-xs" onClick="delete_casestudy()">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="table-responsive">
											<table id="source_table_programs" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
												<thead>
												<tr>
													<th>Select</th>
													<th>Competency Name</th>
													<th>Level Name</th>
													<th>Level Scale</th>
												</tr>
												</thead>
												<tbody>
												
												
													<tr id='subgrd1'>
														<td><label><input type="checkbox" value=""></label>
														<input type="hidden" id="casestudy_comp_id1" name="casestudy_comp_id[]" value="">
														</td>
														<td>
															<select class="form-control m-b" name="casestudy_competencies[]" id="casestudy_competencies1"  onchange="open_level(1);">
																<option value="">Select</option>
																<optgroup label="MS">
																<?php
																foreach($competencymsdetails as $competencydetail){ ?>
																	<option value="<?php echo $competencydetail['comp_def_id']; ?>"  ><?php echo $competencydetail['comp_def_name'];?></option>
																<?php
																}
																?>
																</optgroup>
																<optgroup label="NMS">
																<?php
																foreach($competencynmsdetails as $competencydetail){?>
																	<option value="<?php echo $competencydetail['comp_def_id']; ?>" ><?php echo $competencydetail['comp_def_name'];?></option>
																<?php
																}
																?>
																</optgroup>
															</select>
														</td>
														<td>
															<select class="form-control m-b" name="casestudy_level[]" id="casestudy_level1" onchange="open_scale(1);">
																<option value="">Select</option>
															</select>
														</td>
														<td>
															<select class="form-control m-b" name="casestudy_scale[]" id="casestudy_scale1">
																<option value="">Select</option>

															</select>
														</td>
													</tr>
												<?php
													$hidden=1;
												 ?>
												</tbody>
												<input type="hidden" name="addgroup" id="addgroup" value="<?php echo $hidden; ?>" />
											</table>
										</div>
									</div>
								</div>
							</div>
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
									<button class="btn btn-danger btn-sm" type="button" onclick="create_link('case_study_master_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
									<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit" onclick="return addsource_details_casestudy_validation(2);"><i class="fa fa-check"></i> Add Questions</button>
								</div>
							</div>
							</form>
						</div>
						<div id="questions-info" class="p-m tab-pane">
							<form id="case_master" action="<?php echo BASE_URL;?>/admin/casestudy_test_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="casestudy_id" id="casestudy_id" value="<?php echo (isset($case_study['casestudy_id']))?$case_study['casestudy_id']:''?>">
							<div class="row mt-40">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label mb-10">Case Name</label>
										<div class="input-group"><?php echo (isset($case_study['casestudy_name']))?$case_study['casestudy_name']:''?></div>
									</div>
									<div class="form-group">
										<label class="control-label mb-10">Video Link</label>
										<?php if(isset($case_study['casestudy_link'])){ ?>
										<iframe width="100%" height="350" src="<?php echo (isset($case_study['casestudy_link']))?$case_study['casestudy_link']:''?>?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
										<?php } 
										?>
									</div>
									
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label mb-10">Description</label>
										<div style="height:410px;overflow:scroll">
											<?php echo (isset($case_study['casestudy_description']))?$case_study['casestudy_description']:''?>
										</div>
									</div>
								</div>
							</div>
							<label class="control-label mb-10">Questions</label>
							<div class="panel-group accordion-struct accordion-style-1" id="accordion_2" role="tablist" aria-multiselectable="true">
							<?php 
							foreach($case_study_questions as $case_study_question){
							?>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="heading_10">
										<a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_<?php echo $case_study_question['casestudy_quest_id']; ?>" aria-expanded="true" ><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i class="ti-plus"></i></span><span class="minus-ac"><i class="ti-minus"></i></span></div><?php echo $case_study_question['casestudy_quest']; ?></a> 
									</div>
									<div id="collapse_<?php echo $case_study_question['casestudy_quest_id']; ?>" class="panel-collapse collapse" role="tabpanel">
										<div class="panel-body pa-15"> 
											<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
												<thead>
													<tr>
														<th class="col-sm-6">Competency Name</th>
														<th class="col-sm-4">Level Name</th>
														<th class="col-sm-2">Action</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$comp_details=UlsCaseStudyCompMap::getcasestudycompetencies($case_study_question['casestudy_quest_id']);
												foreach($comp_details as $comp_detail){
												?>
													<tr>
														<td><?php echo $comp_detail['competencies_name']; ?></td>
														<td><?php echo $comp_detail['level_name']; ?></td>
														<td>
														<a onclick="open_question_count(<?php echo $case_study_question['casestudy_quest_id']; ?>,<?php echo (isset($case_study['casestudy_id']))?$case_study['casestudy_id']:''?>);" href="#workinfoviewadd<?php echo $case_study_question['casestudy_quest_id']; ?>" data-toggle="modal" data-target="#workinfoviewadd<?php echo $case_study_question['casestudy_quest_id']; ?>" class="mr-10"><i class="fa fa-pencil text-primary"></i><span class="bold"></span></a>
														<a onclick="deletefunction(this)" rel="intraydelete_<?php echo $case_study_question['casestudy_quest_id']; ?>" name="delete_casestudy" id="<?php echo $case_study_question['casestudy_quest_id']; ?>" data-original-title="Delete" title="" data-placement="top" data-toggle="tooltip"  class="mr-10"><i class="fa fa-trash text-danger"></i> <span class="bold"></span></a>
														</td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							<?php 
							} ?>
							</div>
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-0">
									<?php if(isset($case_study['casestudy_id'])){ ?>
									<a href="<?php echo BASE_URL;?>/admin/casestudypdf?id=<?php echo $case_study['casestudy_id'];?>" class="btn btn-primary btn-xs pull-left mr-15">Generate Pdf</a>
									<?php } ?>
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
<?php
if(!empty($_REQUEST['id'])){
if(count($case_study_questions)>0){
	foreach($case_study_questions as $case_study_question){
	?>
	<div id="workinfoviewadd<?php echo $case_study_question['casestudy_quest_id'];?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="color-line"></div>
				<div class="modal-header">
					<h6 class="modal-title">Edit CaseStudy</h6>
				</div>
				<div class="modal-body">
					<div id="questionbank_count<?php echo $case_study_question['casestudy_quest_id'];?>" class="modal-body no-padding">
					
					</div>
				</div>
				
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	<?php 
	}
}
}
?>