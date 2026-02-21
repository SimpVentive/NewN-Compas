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
							<div class="test-name">IDP Process</div>
							<p class="test-content red-text">Technical</p>
						</div>
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<!-- TEST BODY :BEGIN -->
				<div class="idp-process-review custom-scroll">
					<div class="tast-tab-nav">
						<div class="test-body">
							<div class="idp-review-title">Self Assessment</div>

							<div class="row">
							<?php 
							foreach($self_assessment as $key=>$self_assessments){
							?>
								<div class="col-6">
									<div class="case-question-box mb-3">
										<div class="number"><?php echo $key+1; ?></div>
										<div class="case-details mt-2">
											<div class="d-flex align-items-center">
												<label class="name mb-0 mr-4"><?php echo $self_assessments['comp_def_name']; ?></label>
												<span class="ans flex"><?php echo $self_assessments['scale_name']; ?></span>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>	
							</div>
						</div>
					</div>
					<hr>
					<div class="tast-tab-nav">
						<div class="test-body">
							<div class="idp-review-title">Career Planning</div>

							<div class="form-group">
								<label class="label">Short Term Goals:</label>
								<p class="value"><?php echo $career_planning['short_term_goals']; ?></p>
							</div>

							<div class="form-group">
								<label class="label">Medium Term Goals:</label>
								<p class="value"><?php echo $career_planning['medium_term_goals']; ?></p>
							</div>

							<div class="form-group">
								<label class="label">Long Term Goals:</label>
								<p class="value"><?php echo $career_planning['long_term_goals']; ?></p>
							</div>

						</div>
					</div>
					<hr>
					<div class="tast-tab-nav">
						<div class="test-body">
							<div class="idp-review-title">Strengths</div>

							<div class="row">
							<?php 
							foreach($self_assessment as $key=>$self_assessments){
							?>
								<div class="col-6">
									<div class="case-question-box mb-3">
										<div class="number"><?php echo $key+1; ?></div>
										<div class="case-details mt-2">
											<div class="d-flex align-items-center">
												<label class="name mb-0 mr-4"><?php echo $self_assessments['comp_def_name']; ?></label>
												<span class="ans flex"><?php echo $self_assessments['strength_value_name']; ?></span>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>	
							</div>
						</div>
					</div>
					<hr>
					<div class="tast-tab-nav">
						<div class="test-body">
							<div class="idp-review-title">Development Planning</div>

							<div class="row">
							<?php 
							foreach($self_assessment as $key=>$self_assessments){
							?>
								<div class="col-4">
									<div class="case-question-box mb-3">
										<div class="number"><?php echo $key+1; ?></div>
										<div class="case-details">
											<div class="d-flex">
												<label class="name"><?php echo $self_assessments['comp_def_name']; ?></label>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Knowledge/Skill :</label>
												<span class="ans"><?php echo $self_assessments['knowledge_skill']; ?></span>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Method :</label>
												<span class="ans"><?php echo $self_assessments['method_value_name']; ?></span>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Org Support Req :</label>
												<span class="ans"><?php echo $self_assessments['org_support']; ?></span>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Target Date:</label>
												<span class="ans"><?php echo date('d F Y',strtotime($self_assessments['target_date'])); ?></span>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Completion Evidence:</label>
												<span class="ans"><a href="javascript:;">attachment.pdf</a></span>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
							</div>
						</div>

					</div>
				</div>
				<!-- TEST BODY :END -->
				<form action="<?php echo BASE_URL;?>/employee/self_assessment_final" method="post"  id="tab_strengths_sumbit">
				<input type="hidden" name="assessment_id" value="<?php echo $_REQUEST['assessment_id'];?>" >
				<input type="hidden" name="position_id" value="<?php echo $_REQUEST['position_id'];?>" >
				<input type="hidden" name="employee_id" value="<?php echo $_REQUEST['emp_id'];?>" >
				<input type="hidden" name="ass_type" value="<?php echo $_REQUEST['ass_type'];?>" >
				<input type="hidden" name="ass_pos_id" value="<?php echo $_REQUEST['assessment_pos_id'];?>" >
				<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
				<div class="test-footer d-flex align-items-center justify-content-between">
					<a href="<?php echo BASE_URL;?>/employee/self_ass_summary_details?status=development&jid=<?php echo $_REQUEST['jid']; ?>&ass_type=<?php echo $_REQUEST['ass_type']; ?>&assessment_id=<?php echo $_REQUEST['assessment_id']; ?>&position_id=<?php echo $_REQUEST['position_id']; ?>&emp_id=<?php echo $_REQUEST['emp_id']; ?>&assessment_pos_id=<?php echo $_REQUEST['assessment_pos_id']; ?>" class="btn btn-light">Back</a>
					<button type="submit" name="final_submit" class="btn btn-primary">Submit</button>
				</div>
				</form>
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>