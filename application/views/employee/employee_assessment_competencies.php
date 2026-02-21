<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
				<!-- TEST HEAD SECTION :BEGIN -->
				<div class="test-head-section">
					<div class="test-head">
						<div class="icon material-icons">supervised_user_circle</div>
						<div class="test-info">
							<div class="test-name">Assessment Competencies</div>
							<p class="test-content red-text">Technical</p>
						</div>
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<!-- TEST BODY :BEGIN -->
				<div class="idp-process-review custom-scroll">
					
					<div class="tast-tab-nav">
						<div class="test-body">

							<div class="row">
								<?php 
								$ass_comp=UlsAssessmentCompetencies::getassessment_competencies($_REQUEST['ass_id'],$_REQUEST['pos_id']);
								foreach($ass_comp as $key=>$ass_comps){
									$query="SELECT count(*) as total_count,count(b.user_test_response_id) as rem_count FROM `uls_assessment_test_questions` a 
									left join(SELECT `user_test_response_id`,`utest_question_id`,`employee_id`,`user_test_question_id`,`assessment_test_id`,`assessment_id`,`event_id`,`competency_id` FROM `uls_utest_responses_assessment`) b on a.`assess_test_id`=event_id and a.assessment_id=b.assessment_id and a.competency_id=b.competency_id
									WHERE a.assessment_id=".$_REQUEST['ass_id']." and a.`assess_test_id`=".$_REQUEST['ass_test_id']." and a.competency_id=".$ass_comps['comp_def_id']." group by  a.competency_id";
									$compdef=UlsMenu::callpdorow($query);
									$testdetails_comp_count=UlsMenu::callpdorow("select count(a.answer) as ans_count from uls_utest_employee_question a where a.ass_test_id=".$_REQUEST['ass_test_id']." and a.competency_id=".$ass_comps['comp_def_id']." and a.assessment_id=".$_REQUEST['ass_id']." and a.employee_id=".$_SESSION['emp_id']);
									$test_status=UlsUtestAttemptsAssessment::getattempttest_comp_status($_REQUEST['ass_id'],$_REQUEST['ass_test_id'],$_SESSION['emp_id'],$ass_comps['comp_def_id']);
								?>
								<div class="col-4">
									<div class="case-question-box mb-3">
										<div class="number"><?php echo $key+1; ?></div>
										<div class="case-details">
											<div class="d-flex">
												<label class="name"><?php echo $ass_comps['comp_def_name'];?></label>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Status :</label>
												<span class="ans">
												<?php 
												if($test_status['attempt_status']=='COM' && ($testdetails_comp_count['ans_count']==$ass_comps['assessment_que_count'])){
													echo "Completed";
												}
												else{
													echo "Pending";
												}
												?>
												</span>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Total Question :</label>
												<span class="ans"><?php echo $ass_comps['assessment_que_count'];?></span>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Total Time :</label>
												<span class="ans"><?php echo $ass_comps['assessment_time_count'];?></span>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Remaining Question :</label>
												<span class="ans"><?php echo ($ass_comps['assessment_que_count']-$testdetails_comp_count['ans_count']);?></span>
											</div>
											
											<div class="d-flex mb-1">
												<?php 
												if($test_status['attempt_status']=='COM' && ($testdetails_comp_count['ans_count']==$ass_comps['assessment_que_count'])){
												?>
												<a href="#" class="btn btn-primary">Completed</a>
												<?php
												}
												else{
												?>
												<a href="<?php echo BASE_URL; ?>/employee/employee_test_detail_new?jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $_REQUEST['ass_test_id'];?>&comp_id=<?php echo $ass_comps['comp_def_id'];?>" class="btn btn-primary">Take Test</a>
												<?php	
												}
												?>
												
											</div>
										</div>
									</div>
								</div>
								<?php 
								}
								?>
							</div>
						</div>

					</div>
				</div>
				<!-- TEST BODY :END -->

				<div class="test-footer d-flex align-items-center justify-content-between">
					<a href="<?php echo BASE_URL; ?>/admin/profile" class="btn btn-light">Back</a>
					
				</div>
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>