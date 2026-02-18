<script>
<?php
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}
?>
</script>
<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
				<!-- TEST HEAD SECTION :BEGIN -->
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">supervised_user_circle</div>
							<div class="test-info">
								<div class="test-name">IDP Process</div>
								<p class="test-content red-text">Technical</p>
							</div>
						</div>
						<div class="time-head">
							<div class="time-icon material-icons">done</div>
							<div class="time-info">
								<p class="time"><span class="minute"><span id="taskID"><?php echo $_REQUEST['id']; ?></span>/4 Task</span></p>
							</div>
						</div>
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<div class="space-40"></div>

				<ul class="test-nav-panel d-flex align-items-center">
					<?php
					if(count($rating_count)>0){
					?>
					<li class="flex active" data-tab-id="self-assessment" id='compentencies_li'>
						<span class="num">1</span>
						<span class="txt">Self Assessment</span>
					</li>
					<li class="flex" data-tab-id="career-planning" id='employees_li'>
						<span class="num">2</span>
						<span class="txt">Career Planning</span>
					</li>
					<li class="flex" data-tab-id="strengths-tab" id='strengths_li'>
						<span class="num">3</span>
						<span class="txt">Strengths</span>
					</li>
					<li class="flex" data-tab-id="development-planning" id='development_li'>
						<span class="num">4</span>
						<span class="txt">Development Planning</span>
					</li>
					<?php }
					else{
					?>
					<li class="flex active" data-tab-id="self-assessment" id='compentencies_li'>
						<span class="num">1</span>
						<span class="txt">Self Assessment</span>
					</li>
					<li class="flex">
						<span class="num">2</span>
						<span class="txt">Career Planning</span>
					</li>
					<li class="flex">
						<span class="num">3</span>
						<span class="txt">Strengths</span>
					</li>
					<li class="flex">
						<span class="num">4</span>
						<span class="txt">Development Planning</span>
					</li>
					<?php
					}
					?>
				</ul>

				<!-- TEST BODY :BEGIN -->
				
					<div id="self-assessment" class="tast-tab-nav">
						<form action="<?php echo BASE_URL;?>/employee/self_summary_result_insert" method="post"  id="tab_summary_sumbit">
						<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
						<input type="hidden" name="assessment_id" value="<?php echo $id;?>" >
						<input type="hidden" name="position_id" value="<?php echo $pos_id;?>" >
						<input type="hidden" name="employee_id" value="<?php echo $emp_id;?>" >
						<input type="hidden" name="ass_type" value="<?php echo $ass_type;?>" >
						<input type="hidden" name="ass_pos_id" value="<?php echo $ass_pos_id;?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<div class="test-nav-scoll custom-scroll">
							<div class="test-body">
							
								<?php 
								foreach($comp_details as $comp_detail){
								?>
								<h5><?php echo $comp_detail['name']; ?></h5>
								<hr/>
								<?php 
								$competency=UlsSelfAssessmentReport::getselfassessment_competencies_summary($id,$pos_id,$emp_id,$comp_detail['category_id']);
									foreach($competency as $key=>$competencys){
									?>
									<input type="hidden" name="self_report_id[]" value="<?php echo !empty($competencys['self_report_id'])?$competencys['self_report_id']:"";?>">
									<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
									<input type="hidden" name="requiredlevel_<?php echo $competencys['comp_def_id'];?>" value="<?php echo $competencys['scale_id'];?>" >
									<div class="case-question-box">
										<div class="number"><?php echo $key+1; ?></div>
										<div class="case-details">
											<div class="d-flex align-items-center justify-content-between">
												<label class="name"><?php echo $competencys['comp_def_name'];?></label>
												<span class="note">* Required level:<?php echo $competencys['scale_name'];?></span>
											</div>
											<div class="d-flex align-items-center justify-content-between">
												<label class="label">Self Assessed  level:</label>
												<?php
												$level_id=UlsCompetencyDefinition::viewcompetency($competencys['comp_def_id']);
												$scale_overall=UlsLevelMasterScale::levelscale($level_id['comp_def_level']);
												foreach($scale_overall as $scales){
													$final_scale=!empty($competencys['assessed_scale_id'])?$competencys['assessed_scale_id']==$scales['scale_id']?"checked='checked''":"":"";
												?>
												<div class="radio-group">
													<input type="radio" name='OVERALL_<?php echo $competencys['comp_def_id'];?>' id='OVERALL_<?php echo $competencys['comp_def_id'];?>_<?php echo $scales['scale_id']; ?>' class="radio-control validate[required]" value="<?php echo $scales['scale_id']; ?>" <?php echo $final_scale; ?>>
													<label for="OVERALL_<?php echo $competencys['comp_def_id'];?>_<?php echo $scales['scale_id']; ?>" class="radio-label"><a href="javascript:;" data-toggle="modal" data-target="#ass-rules-modal<?php echo $competencys['comp_def_id']; ?>" onclick="open_comp_level(<?php echo $competencys['comp_def_id']; ?>);"><?php echo $scales['scale_name']; ?></a></label>
												</div>
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="modal fade case-modal" id="ass-rules-modal<?php echo $competencys['comp_def_id']; ?>" tabindex="-1" role="dialog">
										<div class="modal-dialog" role="document" >
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title flex">Level Details</h5>
													<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
														<i class="material-icons">close</i> Close
													</a>
												</div>
												<div class="case-info">
													
												</div>
												<div class="modal-body" >
													<div class='custom-scroll'>
													<div id="level_comp<?php echo $competencys['comp_def_id']; ?>">
													</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
									} 
								} ?>
							</div>
						</div>
						<?php
						if(count($competency)>0){ ?>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="<?php echo BASE_URL;?>/employee/employee_self_assessment?jid=<?php echo $_REQUEST['jid']; ?>&ass_type=<?php echo $_REQUEST['ass_type']; ?>&assessment_id=<?php echo $_REQUEST['assessment_id']; ?>&position_id=<?php echo $_REQUEST['position_id']; ?>&emp_id=<?php echo $_REQUEST['emp_id']; ?>&assessment_pos_id=<?php echo $_REQUEST['assessment_pos_id']; ?>" class="btn btn-light idp-nav-back-btn">Back</a>
							<button class="btn btn-primary" type="submit" name="summary_info_submit" id="summary_info_submit" >Next</button>
						</div>
						<?php } ?>
						</form>
					</div>
					<div id="career-planning" class="tast-tab-nav display-none">
						<form action="<?php echo BASE_URL;?>/employee/self_summary_result_insert_career" method="post" id="tab_summary_sumbit">
						<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
						<input type="hidden" name="assessment_id" value="<?php echo $id;?>" >
						<input type="hidden" name="position_id" value="<?php echo $pos_id;?>" >
						<input type="hidden" name="employee_id" value="<?php echo $emp_id;?>" >
						<input type="hidden" name="ass_type" value="<?php echo $ass_type;?>" >
						<input type="hidden" name="ass_pos_id" value="<?php echo $ass_pos_id;?>" >
						<input type="hidden" name="self_dev_report_id" value="<?php echo !empty($competency_dev['self_dev_report_id'])?$competency_dev['self_dev_report_id']:"";?>">
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<div class="test-nav-scoll custom-scroll">
							<div class="test-body">
								
								<div class="form-group">
									<label class="label">Short Term Goals:</label>
									<textarea class="textarea-control" rows="4" name="short_term_goals" id="short_term_goals"><?php echo !empty($competency_dev['short_term_goals'])?$competency_dev['short_term_goals']:"";?></textarea>
								</div>

								<div class="form-group">
									<label class="label">Medium Term Goals:</label>
									<textarea class="textarea-control" rows="4" name="medium_term_goals" id="medium_term_goals"><?php echo !empty($competency_dev['medium_term_goals'])?$competency_dev['medium_term_goals']:"";?></textarea>
								</div>

								<div class="form-group">
									<label class="label">Long Term Goals:</label>
									<textarea class="textarea-control" rows="4" name="long_term_goals" id="long_term_goals"><?php echo !empty($competency_dev['long_term_goals'])?$competency_dev['long_term_goals']:"";?></textarea>
								</div>

							</div>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light idp-nav-back-btn">Back</a>
							<button class="btn btn-primary" type="submit" name="summary_info_submit" id="summary_info_submit" >Next</button>
						</div>
						</form>
					</div>
					<div id="strengths-tab" class="tast-tab-nav display-none">
						<form action="<?php echo BASE_URL;?>/employee/self_summary_result_insert_strength" method="post"  id="tab_strengths_sumbit">
						<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
						<input type="hidden" name="assessment_id" value="<?php echo $id;?>" >
						<input type="hidden" name="position_id" value="<?php echo $pos_id;?>" >
						<input type="hidden" name="employee_id" value="<?php echo $emp_id;?>" >
						<input type="hidden" name="ass_type" value="<?php echo $ass_type;?>" >
						<input type="hidden" name="ass_pos_id" value="<?php echo $ass_pos_id;?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<div class="test-nav-scoll custom-scroll">
							<div class="test-body">
							<?php 
							foreach($comp_details as $comp_detail){
							?>
								<h5><?php echo $comp_detail['name']; ?></h5>
								<hr/>
								<?php
								$competency=UlsSelfAssessmentReport::getselfassessment_competencies_summary($id,$pos_id,$emp_id,$comp_detail['category_id']);
								foreach($competency as $key=>$competencys){
								?>
								<div class="case-question-box">
									<div class="number"><?php echo $key+1; ?></div>
									<div class="case-details mt-2">
										<div class="d-flex align-items-center">
										<input type="hidden" name="self_report_id[]" value="<?php echo !empty($competencys['self_report_id'])?$competencys['self_report_id']:"";?>">
										<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
											<label class="name flex mb-0"><?php echo $competencys['comp_def_name'];?></label>
											<div class="flex d-flex align-items-center">
											<?php 
											foreach($yesstat as $yesstats){
												$final_scale=!empty($competencys['strengths'])?$competencys['strengths']==$yesstats['code']?"checked='checked'":"":"";
												?>
												<div class="radio-group mr-4">
													<input type="radio" name='strengths_<?php echo $competencys['comp_def_id'];?>' id='strengths_<?php echo $competencys['comp_def_id'];?>_<?php echo $yesstats['code']; ?>' class="radio-control" value="<?php echo $yesstats['code']; ?>" <?php echo $final_scale;?>>
													<label for="strengths_<?php echo $competencys['comp_def_id'];?>_<?php echo $yesstats['code']; ?>" class="radio-label"><?php echo $yesstats['name']; ?></label>
												</div>
											<?php } ?>	
											</div>
											
										</div>
									</div>
								</div>
								<?php 
								}
							}
							?>
							</div>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light idp-nav-back-btn">Back</a>
							<button class="btn btn-primary" type="submit" name="summary_info_submit" id="summary_info_submit" >Next</button>
						</div>
						</form>
					</div>
					<div id="development-planning" class="tast-tab-nav display-none">
						<form action="<?php echo BASE_URL;?>/employee/self_summary_result_insert_development" method="post"  id="tab_strengths_sumbit">
						<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
						<input type="hidden" name="assessment_id" value="<?php echo $id;?>" >
						<input type="hidden" name="position_id" value="<?php echo $pos_id;?>" >
						<input type="hidden" name="employee_id" value="<?php echo $emp_id;?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<input type="hidden" name="ass_type" value="<?php echo $ass_type;?>" >
						<input type="hidden" name="ass_pos_id" value="<?php echo $ass_pos_id;?>" >
						<div class="test-nav-scoll custom-scroll">
						<?php 
						foreach($comp_details as $comp_detail){
						?>
						<div class="test-body">
						<h5><?php echo $comp_detail['name']; ?></h5>
						<hr/>
						<?php
						$competency=UlsSelfAssessmentReport::getselfassessment_competencies_summary($id,$pos_id,$emp_id,$comp_detail['category_id']);
						foreach($competency as $key=>$competencys){
						?>
						<div class="case-question-box">
							<input type="hidden" name="self_report_id[]" value="<?php echo !empty($competencys['self_report_id'])?$competencys['self_report_id']:"";?>">
							<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
							<div class="number"><?php echo ($key+1); ?></div>
							<div class="case-details">
								<div class="d-flex">
									<label class="name"><?php echo $competencys['comp_def_name'];?></label>
								</div>
								<div class="d-flex mb-3">
									<label class="label min-width">Knowledge/Skill :</label>
									<?php
									$array=array("Knowledge","Skill");
									foreach($array as $key_n=>$dev_methods){
										$method_dev=!empty($competencys['knowledge_skill'])?$competencys['knowledge_skill']==$dev_methods?"checked='checked'":"":"";
									?>
									<div class="radio-group mr-4">
										<input name='knowledge_skill_<?php echo $competencys['comp_def_id'];?>' id='knowledge_skill_<?php echo $competencys['comp_def_id'];?>_<?php echo $key_n; ?>' type="radio" class="radio-control" value="<?php echo $dev_methods; ?>" <?php echo $method_dev; ?>>
										<label for="knowledge_skill_<?php echo $competencys['comp_def_id'];?>_<?php echo $key_n; ?>" class="radio-label"><?php echo $dev_methods; ?></label>
									</div>
									<?php
									}
									?>
								</div>
								<div class="d-flex mb-3">
									<label class="label min-width">Method :</label>
									<div class="row">
										<?php
										foreach($dev_method as $n=>$devmethods){
											$method_dev=!empty($competencys['method'])?$competencys['method']==$devmethods['code']?"checked='checked'":"":"";
										?>
										<div class="col-4">
											<div class="radio-group mb-2">
												<input name='method_<?php echo $competencys['comp_def_id'];?>' id='method_<?php echo $competencys['comp_def_id'];?>_<?php echo $devmethods['code']; ?>' type="radio"  class="radio-control" value="<?php echo $devmethods['code']; ?>" <?php echo $method_dev; ?>>
												<label for="method_<?php echo $competencys['comp_def_id'];?>_<?php echo $devmethods['code']; ?>" class="radio-label"><?php echo $devmethods['name']; ?></label>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="d-flex align-items-center mb-3">
									<label class="label min-width">Org Support Req:</label>
									<div class="row flex">
										<div class="col-3">
											<input type="text" class="form-control" name='org_support_<?php echo $competencys['comp_def_id'];?>' id='org_support_<?php echo $competencys['comp_def_id'];?>' value="<?php echo !empty($competencys['org_support'])?$competencys['org_support']:"";?>">
										</div>
										<div class="col-3">
											<label class="label text-right">Target Date:</label>
										</div>
										<div class="col-3">
											<input type="text" class="form-control" name="target_date_<?php echo $competencys['comp_def_id'];?>" id="target_date_<?php echo $competencys['comp_def_id'];?>" value="<?php echo ($competencys['target_date']!='1970-01-01')?!empty($competencys['target_date'])?date("d-m-Y",strtotime($competencys['target_date'])):"":"";?>">
										</div>
									</div>
								</div>
								<div class="d-flex">
									<label class="label min-width">Completion Evidence:</label>
									<div class="row flex">
										<div class="col-7">
											<div class="form-group">
												<textarea class="textarea-control" rows="4" name="comp_evidence_<?php echo $competencys['comp_def_id'];?>" id="comp_evidence_<?php echo $competencys['comp_def_id'];?>"><?php echo !empty($competencys['comp_evidence'])?$competencys['comp_evidence']:"";?></textarea>
											</div>
										</div>
										<div class="col-1">
											<label class="label text-center">or</label>
										</div>
										<div class="col-2">
											<input type="file" class="file-upload">
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
						}
						?>
						
						
						<div class="row">
							<div class="col-7">
								<div class="form-group">
									<label class="label">Overall Evidence</label>
									<textarea class="textarea-control" rows="4"></textarea>
								</div>
							</div>
							<div class="col-1">or</div>
							<div class="col-2">
								<input type="file" name="" value="" placeholder="">
							</div>
						</div>
						<input type="hidden" name="self_dev_report_id" value="<?php echo !empty($competency_dev['self_dev_report_id'])?$competency_dev['self_dev_report_id']:"";?>">
						<div class="form-group">
							<label class="label">How Would Want To Leverage On Your Strengths. Examples Of Leveraging On Your Strength Could Include, Coaching Some One, Taking Up Special Projects, Becoming A Team Member To Help Groups/Others, Etc*:</label>
							<textarea class="textarea-control validate[required,minSize[3]" rows="4" name="leverage" id="leverage"  data-prompt-position="topLeft"><?php echo !empty($competency_dev['leverage'])?$competency_dev['leverage']:"";?></textarea>
						</div>

						<div class="case-question-box">
							<div class="case-details">
								<div class="row">
									<div class="col-4">
										<label class="label">Review: When Do You Want To Review This Development Plan* :</label>
									</div>
									<?php
									foreach($review_method as $review_methods){
										$review_plan=!empty($competency_dev['review'])?$competency_dev['review']==$review_methods['code']?"checked='checked'":"":"";
									?>
									<div class="col-2">
										<div class="radio-group">
											<input id="review-every-month_<?php echo $review_methods['code']; ?>" type="radio" name="review" class="validate[required] radio-control" value="<?php echo $review_methods['code']; ?>" <?php echo $review_plan; ?>>
											<label for="review-every-month_<?php echo $review_methods['code']; ?>" class="radio-label"><?php echo $review_methods['name']; ?></label>
										</div>
									</div>
									<?php } ?>
								</div>

								<div class="row">
									<div class="col-4">
										<label class="label">Have You Discussed This Development Plan With Your Reporting*:</label>
									</div>
									<?php
									foreach($yesstat as $yesstat_s){
										$review_plan=!empty($competency_dev['reporting'])?$competency_dev['reporting']==$yesstat_s['code']?"checked='checked'":"":"";
									?>
									<div class="col-2">
										<div class="radio-group">
											<input id="have-you-discussed-yes_<?php echo $yesstat_s['code']; ?>" type="radio" name="reporting" class="radio-control" value="<?php echo $yesstat_s['code']; ?>" <?php echo $review_plan; ?>>
											<label for="have-you-discussed-yes_<?php echo $yesstat_s['code']; ?>" class="radio-label"><?php echo $yesstat_s['name']; ?></label>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>

							<div class="case-question-box">
								<?php
								if(count($training_needs)>0){
									$hide_val=array();
									foreach($training_needs as $key=>$viewmas){
										$hide_val[]=$key;
								?>
								<div class="row">
									<div class="col-1">
										<div class="checkbox-group">
											<input type="checkbox" class="checkbox-control" name="select_chk" id="select_chk[<?php echo $key;?>]" value="<?php echo $key;?>">
											<label for="select_chk[<?php echo $key;?>]" class="label"> </label>
										</div>
									</div>
									<div class="col-5">
										<div class="form-group row d-flex align-items-center">
											<input type="hidden" name="self_training_id[]" id="self_training_id[<?php echo $key;?>]" value="<?php echo $viewmas['self_training_id'];?>">
											<label class="col-5 label">Technical Training:</label>
											<input type="text" class="col-6 form-control validate[required,minSize[4]]" name="training_desc[]" id="training_desc[<?php echo $key;?>]" value="<?php echo $viewmas['training_desc'];?>">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group row d-flex align-items-center">
											<label class="col-3 label">Remarks:</label>
											<input type="text" class="col-6 form-control validate[required,minSize[4]]" name="remarks[]" id="remarks[<?php echo $key;?>]" value="<?php echo $viewmas['remark'];?>">
										</div>
									</div>
								</div>
								<?php }
								$hidden=@implode(',',$hide_val);
								}
								else{
									$hidden="";
									for($i=0;$i<5;$i++){
										if(empty($hidden)){
											$hidden=$i;
										}
										else{
											$hidden=$hidden.",".$i;
										}
										?>
										<div class="row">
											<div class="col-1">
												<div class="checkbox-group">
													<input type="checkbox" class="checkbox-control" name="select_chk" id="select_chk[<?php echo $i;?>]" value="<?php echo $i;?>">
													<label for="select_chk[<?php echo $i;?>]" class="label"> </label>
												</div>
											</div>
											<div class="col-5">
												<div class="form-group row d-flex align-items-center">
													<input type="hidden" name="self_training_id[]" id="self_training_id[<?php echo $i;?>]" value="">
													<label class="col-5 label">Technical Training:</label>
													<input type="text" class="col-6 form-control validate[required,minSize[4]]" name="training_desc[]" id="training_desc[<?php echo $i;?>]" value="">
												</div>
											</div>
											<div class="col-6">
												<div class="form-group row d-flex align-items-center">
													<label class="col-3 label">Remarks:</label>
													<input type="text" class="col-6 form-control validate[required,minSize[4]]" name="remarks[]" id="remarks[<?php echo $i;?>]" value="">
												</div>
											</div>
										</div>
										<?php
									}
								}
								?>
								<input type='hidden' id='inner_hidden_id' value='<?php echo $hidden;?>' name="inner_hidden_id" />
							</div>
						</div>

						
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light idp-nav-back-btn">Back</a>
							
							<button class="btn btn-primary" type="submit" name="summary_info_submit" id="summary_info_submit" >Next</button>
							
						</div>
						</form>
					</div>
				
				<!-- TEST BODY :END -->

				
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>
