<div class="body-section">
	<div class="assessment-scroll-block custom-scroll">
		<div class="assessment-section">
			<div style="text-align:center"><img src="<?php echo BASE_URL;?>/public/images/acat.png"/><br><h2>ACAT</h2></div>
			<div class="assessment-head">
				<div class="d-flex align-items-center justify-content-between">
					<div class="assessment-head-title">Dear <?php echo trim($userdetails['full_name']); ?>,</div>
				</div>
				
			</div>
			<?php 
			$emp_journey=UlsMenu::callpdorow("select * from uls_assessment_employee_journey where employee_id='".$userdetails['employee_id']."'");
			if(!empty($emp_journey['assessment_id']) && !empty($emp_journey['position_id'])){
			$ass_total_time=UlsAssessmentCompetencies::get_assessment_time($emp_journey['assessment_id'],$emp_journey['position_id']);
			$ass_test=UlsAssessmentTest::get_ass_position($emp_journey['assessment_id'],$emp_journey['position_id'],'TEST');
			$ass_comp=UlsAssessmentCompetencies::getassessment_competencies($emp_journey['assessment_id'],$emp_journey['position_id']);
			$ass_emp_status=UlsAssessmentEmployees::get_assessment_employees_check($userdetails['employee_id'],$emp_journey['assessment_id'],$emp_journey['position_id']);
			?>
			<div class="assessment-body custom-scroll">
				<div class="space-20"></div>
				
				<p class="assessment-content">Welcome to Alok's Virtual Assessment Centre. ACAT is the first step towards your professional journey with Alok Industries.</p>
				<p class="assessment-content">Please read the following instructions carefully before you take the assessment.</p>
				<p class="assessment-content"><ol type="1">
				  <li>The total duration of the assessment is <?php echo $ass_total_time['total_time']; ?> min.</li>
				  <li>The total number of multiple-choice questions you are supposed to attempt are <?php echo $ass_test['no_questions'];?>.</li>
				  <li>Once you start the assessment, a timer would be visible at the top of your screen.</li>
				  <li>After the completion of the assessment, you would be redirected to a page to fill your basic details.</li>
				</ol></p> 
				<p class="assessment-content">For your understanding, you may refer the following time allocation table to ensure you must attempt all the segments of assessment.</p>
				<table class="idp-report-table table-bordered table">
					<tr>
						<th class="report-sub-title">S.No</th>
						<th class="report-sub-title">Quiz Segments</th>
						<th class="report-sub-title">No of Questions</th>
						<th class="report-sub-title">Ideal Time to Spend(In Min)</th>
					</tr>
					<?php
					foreach($ass_comp as $key=>$ass_comps){
					?>
					<tr>
						<td><span class="number"><?php echo $key+1; ?></span></td>
						<td>							
							<span class="name"><?php echo $ass_comps['comp_def_name'];?></span>
						</td>
						<td><?php echo $ass_comps['assessment_que_count'];?></td>
						<td><?php echo $ass_comps['assessment_time_count'];?></td>
					</tr>
					
					<?php 
					}
					?>
					
				</table>
				<div class="row">
					<div class="col-12">
					All The Best,<br>
					<img src="<?php echo BASE_URL;?>/public/home/images/Alok_Logo.gif"><br>
					Team HR, Alok Industries
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="assessment-info assessment-box">
							<div class="icon">
								<i class="icon material-icons">supervised_user_circle</i>
							</div>
							<div class="info">
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<div class="name">Test</div>
										<p class="content">Total Questions: <?php echo $ass_test['no_questions'];?></p>
										<p class="content">Total Time: <?php echo $ass_total_time['total_time']; ?> Mins</p>
									</div>
									<?php 
									if($ass_emp_status['status']=='A'){
									?>
									<a href="#" class="btn btn-primary">Completed</a>
									<?php
									}
									else{
									?>
									<a href="<?php echo BASE_URL; ?>/employee/employee_assessment_competencies?jid=<?php echo $emp_journey['id'];?>&ass_id=<?php echo $emp_journey['assessment_id'];?>&ass_test_id=<?php echo $ass_test['assess_test_id'];?>&pos_id=<?php echo  $emp_journey['position_id'];?>" class="btn btn-primary">Start</a>
									<?php
									}
									?>
									
								</div>
							</div>
							<div class="progress-bar">
								<span class="progress" style="width: 70%;"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
		