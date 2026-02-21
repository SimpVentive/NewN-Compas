<div class="body-section">
	<div class="assessment-scroll-block">
		<div class="assessment-section">

			<div class="assessment-head">
				<div class="d-flex align-items-center justify-content-between">
					<div class="assessment-head-title"><?php echo $ass_details['assessment_name']; ?></div>
					<a href="javascript:;" class="assessment-profile-btn" data-toggle="modal" data-target="#competency-profile-modal-<?php echo $_REQUEST['assessment_id']; ?>-<?php echo $_REQUEST['position_id']; ?>" onclick="open_comp_details(<?php echo $_REQUEST['assessment_id']; ?>,<?php echo $_REQUEST['position_id']; ?>);">View Competency Profile</a>
				</div>
				<ul class="assessment-info-list">
					<li class="assessment-item">
						<i class="icon material-icons">assignment_turned_in</i>
						<span class="align-middle"><?php echo $ass_type=$_REQUEST['asstype']=='ASS'?'Assessment':'';?></span>
						<i class="info-icon material-icons">info</i>
					</li>
					<li class="assessment-item">
						<span>Received: <?php echo date('dS F Y',strtotime($jour_details['created_date']));?></span>
					</li>
					<li class="assessment-item">
						<span class="align-middle">Assessor : </span>
						<a href="javascript:;" class="assessor-icon material-icons">perm_identity</a>
						<a href="javascript:;" class="assessor-icon material-icons">perm_identity</a>
						<a href="javascript:;" class="assessor-icon material-icons">perm_identity</a>
						<a href="javascript:;" class="add-new">New</a>
					</li>
				</ul>
				<ul class="assessment-info-list">
					<li class="assessment-item">
						<i class="icon material-icons bg-none">business_center</i>
						<span>Position: <?php 
						if($posdetails['position_structure']=='A'){
							$pos_name=UlsPosition::pos_details($posdetails['position_structure_id']);
							$posname=$pos_name['position_name'];
						}
						else{
							$posname=$posdetails['position_name'];
						}
						echo $posname; ?></span>
					</li>
					<li class="assessment-item">
						<i class="icon material-icons bg-none">date_range</i>
						<span>Start Date: <?php echo date('dS F Y',strtotime($ass_details['start_date']));?></span>
					</li>
					<li class="assessment-item">
						<i class="icon material-icons bg-none">date_range</i>
						<span>End Date: <?php echo date('dS F Y',strtotime($ass_details['end_date']));?></span>
					</li>
				</ul>
			</div>

			<div class="assessment-body">
				<div class="space-40"></div>
				<div class="assessment-text">Description</div>
				<p class="assessment-content"><?php echo $ass_details['assessment_desc']; ?></p>

				<div class="space-20"></div>

				<div class="row">
					<?php 
					/* if($ass_details['ass_comp_selection']=='N'){ */
					?>
					<div class="col-4">
						<div class="assessment-info">
							<div class="icon">
								<i class="icon material-icons">list_alt</i>
							</div>
							<div class="info">
								<div class="name">Assessment Rules</div>
								<p class="content">Your position is mapped to a certain set of assessments… <a href="javascript:;" data-toggle="modal" data-target="#ass-rules-modal">Read more</a></p>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="assessment-info">
							<div class="icon">
								<i class="icon material-icons">assignment</i>
							</div>
							<div class="info">
								<div class="name">Assessment Reports</div>
								<p class="content">Once you complete the assessment process, you will get… <a href="javascript:;" data-toggle="modal" data-target="#ass-report-modal-<?php echo $_REQUEST['assessment_id']; ?>-<?php echo $_REQUEST['position_id']; ?>-<?php echo $_SESSION['emp_id']; ?>">Read more</a></p>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="assessment-info">
							<div class="icon">
								<i class="icon material-icons">map</i>
							</div>
							<div class="info">
								<div class="name">Development Roadmap</div>
								<p class="content">The purpose of assessment is to help in development… <a href="javascript:;" data-toggle="modal" data-target="#ass-dev-modal-<?php echo $_REQUEST['assessment_id']; ?>-<?php echo $_REQUEST['position_id']; ?>-<?php echo $_SESSION['emp_id']; ?>">Read more</a></p>
							</div>
						</div>
					</div>
					<?php 
					/* } 
					else{
					?>
					<div class="col-4">
						<div class="assessment-info">
							<div class="icon">
								<i class="icon material-icons">map</i>
							</div>
							<div class="info">
								<div class="name">Development Roadmap</div>
								<p class="content">The purpose of assessment is to help in development… <a href="javascript:;" data-toggle="modal" data-target="#ass-dev-modal-<?php echo $_REQUEST['assessment_id']; ?>-<?php echo $_REQUEST['position_id']; ?>-<?php echo $_SESSION['emp_id']; ?>">Read more</a></p>
							</div>
						</div>
					</div>
					<?php
					} */
					?>
				</div>

				<div class="space-60"></div>

				<div class="row">
				<?php
				
				foreach($ass_test as $ass_tests){
					if($ass_tests['assessment_type']!='INTERVIEW'){
						$test_name=($ass_tests['assessment_type']=='TEST')?"MCQ":"";
						$case_name=($ass_tests['assessment_type']=='CASE_STUDY')?"Case Study":"";
						$inbasket_name=($ass_tests['assessment_type']=='INBASKET')?"Inbasket":"";
						$beh_name=($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT')?"Behavioural Instrument":"";
						$fish_name=($ass_tests['assessment_type']=='FISHBONE')?"Fishbone":"";
						$feed_name=($ass_tests['assessment_type']=='FEEDBACK')?"360° Feedback":"";
						$test=($ass_tests['assessment_type']=='TEST')?"assignment_turned_in":"";
						$case=($ass_tests['assessment_type']=='CASE_STUDY')?"desktop_mac":"";
						$inbasket=($ass_tests['assessment_type']=='INBASKET')?"search":"";
						$beh=($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT')?"library_music":"";
						$feed=($ass_tests['assessment_type']=='FEEDBACK')?"library_music":"";
						$fishbone=($ass_tests['assessment_type']=='FISHBONE')?"library_music":"";
						$test_url=($ass_tests['assessment_type']=='TEST')?"employee_test_details":"";
						$case_url=($ass_tests['assessment_type']=='CASE_STUDY')?"employee_case_details":"";
						$inbasket_url=($ass_tests['assessment_type']=='INBASKET')?"employee_inbasket_details":"";
						$beh_url=($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT')?"employee_ins_details":"";
						$behurl=($ass_tests['assessment_type']=='FEEDBACK')?"employee_feed_details":"";
						$test_per=($ass_tests['assessment_type']==$_REQUEST['pro'])?"70":"0";
						$getpretest=UlsUtestAttemptsAssessment::getattemptvalus($ass_details['assessment_id'],$_SESSION['emp_id'],$ass_tests['assess_test_id'],$ass_tests['assessment_type']);
						
					?>
					
					<div class="col-4">
						<div class="assessment-info assessment-box">
							<div class="icon">
								<i class="icon material-icons"><?php echo $test; ?><?php echo $case; ?><?php echo $inbasket; ?><?php echo $beh; ?><?php echo $fishbone; ?><?php echo $feed; ?></i>
							</div>
							<div class="info">
								<div class="name"><?php echo $test_name;?><?php echo $case_name;?><?php echo $inbasket_name;?><?php echo $beh_name;?><?php echo $fish_name;?><?php echo $feed_name;?></div>
								<p class="content"><?php echo $ass_details['assessment_name']; ?></p>
								<div class="content">
									<?php 
									if($ass_details['ass_emp_comp']=='Y'){
										$total_que=UlsAssessmentTestQuestions::get_emp_question_count_test($ass_tests['assessment_id'],$ass_tests['position_id'],$ass_tests['assess_test_id'],$emp_comp_map['comp_ids']);
										?>
										<span><?php echo $total_que['que_count']; ?> Question</span>
										<span>|</span>
										<?php
									}
									else{
										if(!empty($ass_tests['no_questions'])){ ?>
										<span><?php echo $ass_tests['no_questions']; ?> Question</span>
											<span>|</span>
										<?php 
										} 
									}
									?>
									<span><?php echo $ass_tests['time_details']; ?> Minutes</span>
								</div>
								<?php
								if($ass_tests['assessment_type']=='INBASKET'){
									$ass_detail_inbasket=UlsAssessmentTestInbasket::getinbasketassessment($ass_tests['assess_test_id']);
									$status=0;
									foreach($ass_detail_inbasket as $key=>$ass_detail_inbaskets){
										$getpretest_inbasket=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$_SESSION['emp_id'],$ass_tests['assess_test_id'],$ass_tests['assessment_type'],$ass_detail_inbaskets['test_id']);
										if(!empty($getpretest_inbasket['attempt_status'])){
											$status+=1; 
										}
									}
									$inbasket_button=(count($ass_detail_inbasket)==$status)?"Completed":"Start";
									if($inbasket_button=='Start'){
										if($ass_details['end_date']>=date('Y-m-d')){
											if($ass_tests['ass_start_date']<=date('Y-m-d') && $ass_tests['ass_end_date']>=date('Y-m-d')){
											?>
												<a href="javascript:;" class="btn btn-primary inbasket-exam-btn<?php echo $ass_tests['assess_test_id'];?>"><?php echo $inbasket_button; ?></a>
											<?php
											}
											else{
											?>
											<a href="#" class="btn btn-primary">Locked</a>
											<?php
											}
										}
										else{
										?>
										<a href="#" class="btn btn-primary">Locked</a>
										<?php
										}
									}
									else{
									?>
									<a href="#" class="btn btn-primary">Completed</a>
									<?php
									}
								}
								elseif($ass_tests['assessment_type']=='CASE_STUDY'){
									
									$ass_detail_casestudy=UlsAssessmentTestCasestudy::getcasestudyassessment($ass_tests['assess_test_id']);
									$stat=0;
									foreach($ass_detail_casestudy as $key=>$ass_detail_casestudys){
										$getpretest_case=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$_SESSION['emp_id'],$ass_tests['assess_test_id'],$ass_tests['assessment_type'],$ass_detail_casestudys['test_id']);
										if(!empty($getpretest_case['attempt_status'])){
											$stat+=1; 
										}
									}
									$case_button=(count($ass_detail_casestudy)==$stat)?"Completed":"Start";
									if($case_button=='Start'){
										if($ass_details['end_date']>=date('Y-m-d')){
											if($ass_tests['ass_start_date']<=date('Y-m-d') && $ass_tests['ass_end_date']>=date('Y-m-d')){
											?>
											<a href="javascript:;" class="btn btn-primary case-exam-btn<?php echo $ass_tests['assess_test_id'];?>"><?php echo $case_button; ?></a>
											<?php
											}
											else{
											?>
											<a href="#" class="btn btn-primary">Locked</a>
											<?php
											}
										}
										else{
										?>
										<a href="#" class="btn btn-primary">Locked</a>
										<?php
										}
									}
									else{
									?>
									<a href="#" class="btn btn-primary">Completed</a>
									<?php
									}
								}
								elseif($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
									$ass_detail_instrument=UlsAssessmentTestBehavorialInst::getbeiassessment($ass_tests['assess_test_id']);
									$status_int=0;
									foreach($ass_detail_instrument as $key=>$ass_detail_instruments){
										$getpretest_beh=UlsBeiAttemptsAssessment::getattemptvalus_beh($ass_details['assessment_id'],$_SESSION['emp_id'],$ass_tests['assessment_type'],$ass_tests['assess_test_id'],$ass_detail_instruments['instrument_id']);
										if(!empty($getpretest_beh['attempt_status'])){
											$status_int+=1; 
										}
									}
									$int_button=(count($ass_detail_instrument)==$status_int)?"Completed":"Start";
									if($int_button=='Start'){
										if($ass_details['end_date']>=date('Y-m-d')){
											if($ass_tests['ass_start_date']<=date('Y-m-d') && $ass_tests['ass_end_date']>=date('Y-m-d')){
											?>
												<a href="javascript:;" class="btn btn-primary instrument-exam-btn<?php echo $ass_tests['assess_test_id'];?>"><?php echo $int_button; ?></a>
											<?php
											}
											else{
											?>
											<a href="#" class="btn btn-primary">Locked</a>
											<?php
											}
										}
										else{
										?>
										<a href="#" class="btn btn-primary">Locked</a>
										<?php
										}
									}
									else{
									?>
									<a href="#" class="btn btn-primary">Completed</a>
									<?php
									}
								}
								elseif($ass_tests['assessment_type']=='FISHBONE'){
								?>
									<a href="javascript:;" class="btn btn-primary fish-exam-btn<?php echo $ass_tests['assess_test_id'];?>">Start</a>
								<?php
								}
								elseif($ass_tests['assessment_type']=='FEEDBACK'){
									$rating_status=UlsFeedbackEmployeeRating::get_rating_status($ass_tests['assess_test_id'],$_SESSION['emp_id']);
									if(empty($rating_status['status'])){
										if($ass_details['end_date']>=date('Y-m-d')){
											if($ass_tests['ass_start_date']<=date('Y-m-d') && $ass_tests['ass_end_date']>=date('Y-m-d')){
											?>
											<a href="<?php echo BASE_URL; ?>/employee/<?php echo $test_url; ?><?php echo $behurl; ?>?jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $ass_tests['assess_test_id'];?>" class="btn btn-primary">Start</a>
											<?php
											}
											else{
												?>
												<a href="#" class="btn btn-primary">Locked</a>
												<?php
											}
											?>
											
											<?php
										}
										else{
											?>
											<a href="#" class="btn btn-primary">Locked</a>
											<?php
										}
									}
									elseif($rating_status['status']=='C'){
									?>
										<a href="#" class="btn btn-primary">Completed</a>
									<?php
									}
									elseif($rating_status['status']=='W'){
										if($ass_details['end_date']>=date('Y-m-d')){
											if($ass_tests['ass_start_date']<=date('Y-m-d') && $ass_tests['ass_end_date']>=date('Y-m-d')){
											?>
											<a href="<?php echo BASE_URL; ?>/employee/<?php echo $test_url; ?><?php echo $behurl; ?>?jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $ass_tests['assess_test_id'];?>" class="btn btn-primary">In-Process</a>
											<?php 
											}
											else{
											?>
											<a href="#" class="btn btn-primary">Locked</a>
											<?php
											}
										}
										else{
											?>
											<a href="#" class="btn btn-primary">Locked</a>
											<?php
										}
										
									}
								}
								else{
									if(empty($getpretest['attempt_status'])){
										if($ass_details['end_date']>=date('Y-m-d')){
											if($ass_tests['ass_start_date']<=date('Y-m-d') && $ass_tests['ass_end_date']>=date('Y-m-d')){
												?>
												<a href="<?php echo BASE_URL; ?>/employee/<?php echo $test_url; ?><?php echo $behurl; ?>?jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $ass_tests['assess_test_id'];?>" class="btn btn-primary">Start</a>
											<?php
											}
											else{
											?>
											<a href="#" class="btn btn-primary">Locked</a>
											<?php
											}
										}
										else{
										?>
											<a href="#" class="btn btn-primary">Locked</a>
											<?php
										}
									}
									else{
										?>
										<a href="#" class="btn btn-primary">Completed</a>
										<?php
									}
								}
								?>
							</div>
							<div class="progress-bar">
								<span class="progress" style="width: <?php echo $test_per; ?>%;"></span>
							</div>
						</div>
					</div>
					
					<?php
					}
				}?>
				</div>
				<?php
				foreach($ass_test as $ass_tests){
					if($ass_tests['assessment_type']='INBASKET'){
						$ass_detail_inbasket=UlsAssessmentTestInbasket::getinbasketassessment($ass_tests['assess_test_id']);
					?>
					<script>
					
					$('.inbasket-exam-btn<?php echo $ass_tests['assess_test_id'];?>').on('click', function (e){
						$('#case-exam-option<?php echo $ass_tests['assess_test_id'];?>').css("display", "none");
						$('#fish-exam-option<?php echo $ass_tests['assess_test_id'];?>').css("display", "none");
						$('#inbasket-exam-option<?php echo $ass_tests['assess_test_id'];?>').slideToggle();
						$(this).parents('.assessment-box').toggleClass('active');
						$('#inbasket-exam-option<?php echo $ass_tests['assess_test_id'];?>').focus();
					});
					
					</script>
					<div id="inbasket-exam-option<?php echo $ass_tests['assess_test_id'];?>" class="display-none">
						<div class="row">
							<div class="col-12">
								<div class="test-list-item">
									<?php
									foreach($ass_detail_inbasket as $key=>$ass_detail_inbaskets){
										$getpretest_inbasket=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$_SESSION['emp_id'],$ass_tests['assess_test_id'],$ass_tests['assessment_type'],$ass_detail_inbaskets['test_id']);
									?>
									<div class="test-options">
										<div class="float-left">
											<div class="test-name">Inbasket <?php echo ($key+1); ?> - <?php echo $ass_detail_inbaskets['inbasket_name']; ?></div>
											<div class="test-content">
												<span>Time: <?php echo $ass_tests['time_details']; ?> Minutes</span>
											</div>
										</div>
										<?php 
										if(empty($getpretest_inbasket['attempt_status'])){
										?>
										<a href="<?php echo BASE_URL; ?>/employee/employee_inbasket_details?status=int&jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $ass_tests['assess_test_id'];?>&in_id=<?php echo $ass_detail_inbaskets['inbasket_id'] ?>&test_id=<?php echo $ass_detail_inbaskets['test_id']; ?>" class="btn btn-primary float-right">Start Now</a>
										<?php	
										}
										else{
										?>
										<a class="btn btn-primary float-right">Completed</a>
										<?php
										}
										?>
									</div>
									<?php } ?>
									
								</div>
							</div>
						</div>
					</div>
				<?php 
					}
					if($ass_tests['assessment_type']='CASE_STUDY'){
						$ass_detail_casestudy=UlsAssessmentTestCasestudy::getcasestudyassessment($ass_tests['assess_test_id']);
						
					?>
					<script>
					
					$('.case-exam-btn<?php echo $ass_tests['assess_test_id'];?>').on('click', function (e){
						$('#case-exam-option<?php echo $ass_tests['assess_test_id'];?>').slideToggle();
						$('#inbasket-exam-option<?php echo $ass_tests['assess_test_id'];?>').css("display", "none");
						$('#fish-exam-option<?php echo $ass_tests['assess_test_id'];?>').css("display", "none");
						$(this).parents('.assessment-box').toggleClass('active');
						$(this).parents('.assessment-box').focus();
					});
					
					</script>
					<div id="case-exam-option<?php echo $ass_tests['assess_test_id'];?>" class="display-none">
						<div class="row">
							<div class="col-12">
								<div class="test-list-item">
									<?php
									foreach($ass_detail_casestudy as $key=>$ass_detail_casestudys){
										$getpretest_case=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$_SESSION['emp_id'],$ass_tests['assess_test_id'],$ass_tests['assessment_type'],$ass_detail_casestudys['test_id']);
									?>
									<div class="test-options">
										<div class="float-left">
											<div class="test-name">Case Study <?php echo ($key+1); ?> - <?php echo $ass_detail_casestudys['casestudy_name']; ?></div>
											<div class="test-content">
												<span>Time: <?php echo $ass_tests['time_details']; ?> Minutes</span>
											</div>
										</div>
										<?php 
										if(empty($getpretest_case['attempt_status'])){
										?>
										<a href="<?php echo BASE_URL; ?>/employee/employee_case_details?jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $ass_tests['assess_test_id'];?>&case_id=<?php echo $ass_detail_casestudys['casestudy_id'] ?>&test_id=<?php echo $ass_detail_casestudys['test_id']; ?>" class="btn btn-primary float-right">Start Now</a>
										<?php	
										}
										else{
										?>
										<a class="btn btn-primary float-right">Completed</a>
										<?php
										}
										?>
									</div>
									<?php } ?>
									
								</div>
							</div>
						</div>
					</div>
				<?php 
					}
					if($ass_tests['assessment_type']='FISHBONE'){
						$ass_detail_fishbone=UlsAssessmentTestFishbone::getfishboneassessment($ass_tests['assess_test_id']);
						
					?>
					<script>
					
					$('.fish-exam-btn<?php echo $ass_tests['assess_test_id'];?>').on('click', function (e){
						$('#fish-exam-option<?php echo $ass_tests['assess_test_id'];?>').slideToggle();
						$('#inbasket-exam-option<?php echo $ass_tests['assess_test_id'];?>').css("display", "none");
						$('#case-exam-option<?php echo $ass_tests['assess_test_id'];?>').css("display", "none");
						$(this).parents('.assessment-box').toggleClass('active');
						$(this).parents('.assessment-box').focus();
					});
					
					</script>
					<div id="fish-exam-option<?php echo $ass_tests['assess_test_id'];?>" class="display-none">
						<div class="row">
							<div class="col-12">
								<div class="test-list-item">
									<?php
									foreach($ass_detail_fishbone as $key=>$ass_detail_casestudys){
										$getpretest_case=UlsUtestAttemptsAssessment::getattemptvalus_inbasket($ass_details['assessment_id'],$_SESSION['emp_id'],$ass_tests['assess_test_id'],$ass_tests['assessment_type'],$ass_detail_casestudys['test_id']);
									?>
									<div class="test-options">
										<div class="float-left">
											<div class="test-name">Fishbone <?php echo ($key+1); ?> - <?php echo $ass_detail_casestudys['fishbone_name']; ?></div>
											<div class="test-content">
												<span>Time: <?php echo $ass_tests['time_details']; ?> Minutes</span>
											</div>
										</div>
										<?php 
										if(empty($getpretest_case['attempt_status'])){
										?>
										<a href="<?php echo BASE_URL; ?>/employee/employee_fishbone_details?status=int&jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $ass_tests['assess_test_id'];?>&fish_id=<?php echo $ass_detail_casestudys['fishbone_id'] ?>&test_id=<?php echo $ass_detail_casestudys['test_id']; ?>" class="btn btn-primary float-right">Start Now</a>
										
										<?php	
										}
										else{
										?>
										<a class="btn btn-primary float-right">Completed</a>
										<?php
										}
										?>
									</div>
									<?php } ?>
									
								</div>
							</div>
						</div>
					</div>
				<?php 
					}
					if($ass_tests['assessment_type']='BEHAVORIAL_INSTRUMENT'){
						$ass_detail_instrument=UlsAssessmentTestBehavorialInst::getbeiassessment($ass_tests['assess_test_id']);
						
					?>
					<script>
					
					$('.instrument-exam-btn<?php echo $ass_tests['assess_test_id'];?>').on('click', function (e){
						$('#instrument-exam-option<?php echo $ass_tests['assess_test_id'];?>').slideToggle();
						$('#inbasket-exam-option<?php echo $ass_tests['assess_test_id'];?>').css("display", "none");
						$(this).parents('.assessment-box').toggleClass('active');
						$(this).parents('.assessment-box').focus();
					});
					
					</script>
					<div id="instrument-exam-option<?php echo $ass_tests['assess_test_id'];?>" class="display-none">
						<div class="row">
							<div class="col-12">
								<div class="test-list-item">
									<?php
									foreach($ass_detail_instrument as $key=>$ass_detail_instruments){
										$getpretest_beh=UlsBeiAttemptsAssessment::getattemptvalus_beh($ass_details['assessment_id'],$_SESSION['emp_id'],$ass_tests['assessment_type'],$ass_tests['assess_test_id'],$ass_detail_instruments['instrument_id']);
									?>
									<div class="test-options">
										<div class="float-left">
											<div class="test-name">Instrument <?php echo ($key+1); ?></div>
											<div class="test-content">
												<!--<span>Time: <?php echo $ass_tests['time_details']; ?> Minutes</span>-->
											</div>
										</div>
										<?php 
										if(empty($getpretest_beh['attempt_status'])){
										?>
										<a href="<?php echo BASE_URL; ?>/employee/employee_ins_details?jid=<?php echo $_REQUEST['jid'];?>&assess_test_id=<?php echo $ass_tests['assess_test_id'];?>&instrument_id=<?php echo $ass_detail_instruments['instrument_id']; ?>" class="btn btn-primary float-right">Start Now</a>
										<?php	
										}
										else{
										?>
										<a class="btn btn-primary float-right">Completed</a>
										<?php
										}
										?>
									</div>
									<?php } ?>
									
								</div>
							</div>
						</div>
					</div>
				<?php 
					}
				}?>
				
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade case-modal" id="competency-profile-modal-<?php echo $_REQUEST['assessment_id']; ?>-<?php echo $_REQUEST['position_id']; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Competency Profile for this Assessment</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			
			<div class="modal-body" >
				<div id="comp_details_<?php echo $_REQUEST['assessment_id']; ?>_<?php echo $_REQUEST['position_id']; ?>"></div>
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade case-modal" id="ass-rules-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Assessment Rules</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			<div class="modal-body" >
				
					<p>Your position is mapped to a certain set of assessments, which are listed below.  The time for competition of each of them are mentioned within.</p>
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade case-modal" id="ass-report-modal-<?php echo $_REQUEST['assessment_id']; ?>-<?php echo $_REQUEST['position_id']; ?>-<?php echo $_SESSION['emp_id']; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Assessment Reports</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			<div class="modal-body" >
				
				<?php 
				$assessor=UlsAssessmentReportFinal::assessment_report_final($_REQUEST['assessment_id'],$_REQUEST['position_id'],$_SESSION['emp_id']);
				$emp_j=UlsAssessmentEmployeeJourney::get_employees_details($_REQUEST['jid']);
				if((count($assessor)>0) && ($emp_j['status']=='C')){
				?>
				<p>Your Assessment Report has been generated.  Please click below to Download the report.  </p>
				<a href="<?php echo BASE_URL; ?>/index/ass_position_emp?ass_type=ASS&ass_id=<?php echo $_REQUEST['assessment_id']; ?>&pos_id=<?php echo $_REQUEST['position_id']; ?>&emp_id=<?php echo $_SESSION['emp_id']; ?>" class="btn btn-primary" target="_blank">Download Report</a>
				<?php
				}
				else{
				?>
				<p>Once you complete the assessment process, you will get a detailed assessment report which details your knowledge and skill in various identified competencies.</p>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade case-modal" id="ass-dev-modal-<?php echo $_REQUEST['assessment_id']; ?>-<?php echo $_REQUEST['position_id']; ?>-<?php echo $_SESSION['emp_id']; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Development Roadmap</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			<div class="modal-body" >
				
				<?php 
				$assessor=UlsAssessmentReportFinal::assessment_report_final($_REQUEST['assessment_id'],$_REQUEST['position_id'],$_SESSION['emp_id']);
				$emp_j=UlsAssessmentEmployeeJourney::get_employees_details($_REQUEST['jid']);
				if($ass_details['ass_comp_selection']=='N'){
					if((count($assessor)>0) && ($emp_j['status']=='C')){
						
						$assresults=UlsAssessmentTest::assessment_results_avg($_REQUEST['assessment_id'],$_REQUEST['position_id'],$_SESSION['emp_id']);
						$results=$ass_comname=$ass_req_sid=$ass_given_sid=array();
						foreach($assresults as $assresult){
							$compid=$assresult['comp_def_id'];
							$finalval=!empty($assresult['assessor_val'])?round(($assresult['ass_scale_number']*$assresult['assessor_val']),2):$assresult['ass_scale_number'];
							$results[$assresult['comp_def_id']]['comp_id']=$compid;
							$results[$assresult['comp_def_id']]['comp_name']=$assresult['comp_def_name'];
							$results[$assresult['comp_def_id']]['req_val']=$assresult['req_number'];
							$results[$assresult['comp_def_id']]['require_scale_id']=$assresult['require_scale_id'];
							$results[$assresult['comp_def_id']]['assessor'][$assresult['assessor_id']]=$finalval;
							$results[$assresult['comp_def_id']]['dev_area'][$assresult['assessor_id']]=$assresult['development_area'];
						}
						$req_sid=$ass_sid=$comname=$compid=array();
						if(count($results)>0){
							foreach($results as $key1=>$result){
								$flag=0;
								$comp_id=$result['comp_id'];
								$comname=$result['comp_name'];
								$req_sid=$result['req_val'];
								$require_scale_id=$result['require_scale_id'];
								$final=0;
								foreach($result['assessor'] as $key2=>$ass_id){
									$final=$final+$results[$key1]['assessor'][$key2];
								}
								$final=round($final/count($results[$key1]['assessor']),2);
								$ass_sid=$final;
								
								foreach($result['dev_area'] as $key2=>$assid){
									$dev[$comp_id]=$results[$key1]['dev_area'][$key2];
								}
								if($ass_sid<$req_sid){
									$flag=1;
								}
								/* $method_check=UlsAssessmentReportBytype::summary_detail_info_report($_REQUEST['assessment_id'],$_REQUEST['position_id'],$_SESSION['emp_id'],$comp_id);
								
								foreach($method_check as $method_checks){
									if($method_checks['assessment_type']=='INBASKET'){
										$req_level_bycomp=$method_checks['req_number'];
										$ass_level_bycomp=round($method_checks['ass_scale_number'],1);
										if($req_level_bycomp>$ass_level_bycomp){
											$flag=1;
										}
									}
									if($method_checks['assessment_type']=='CASE_STUDY'){
										$req_level_bycomp=$method_checks['req_number'];
										$ass_level_bycomp=round($method_checks['ass_scale_number'],1);
										$case_check=UlsAssessmentAssessorRating::get_ass_rating_report($_REQUEST['assessment_id'],$_REQUEST['position_id'],$_SESSION['emp_id'],'CASE_STUDY');
										if($req_level_bycomp>$ass_level_bycomp){
											$flag=1;
										}
										if($case_check['ass_rat']<3){
											$flag=1;
										}
									}
								} */
								if($flag==1){
									if(!in_array($result['comp_id'],$compid)){
										$compid[]=$result['comp_id']."-".$require_scale_id;
									}
								}
							}
						}
						$para_data="";
						if(!empty($compid)){
							foreach($compid as $compids){
								$comp_d=explode("-",$compids);
								$comp_per=UlsAssessmentCompetencies::get_casestudy_competencies($_REQUEST['assessment_id'],$_REQUEST['position_id'],$comp_d[0],$comp_d[1]);
								if($comp_per['comp_per']=='Y'){
								$development=UlsCompetencyDefLevelTraining::getcompdeftraining($comp_d[0],$comp_d[1]);
									if(!empty($development)){
									$comp_name=UlsCompetencyDefinition::competency_detail_single($comp_d[0]);
									$para_data.='
									<div class="assessment-head-title">
										<span style="color: #007bff;font-size:21px;">'.$comp_name['comp_def_name'].'</span>
									</div>
									<p class="content">'.$development['program_obj'].'</p>
									<b>Assessor Comments:</b>
									<p class="content">'.$dev[$comp_d[0]].'</p>';
									}
									else{
										$para_data.='';
									}
								}
								else{
									$para_data.='';
								}
							}
						}
						else{
							$para_data.='';
						}
						?>
						<p>Based on the assessment carried out, and the findings therein, certain development areas have been identified for you, by the assessors.  These have been captured across the different competencies on which the assessment was done. </p>
						<div class="assessment-head-title"><b>Competency Based Development Road Map</b></div>
						<div class="space-20"></div>
						<?php 
						$no_par_data="";
						if($jour_details['tni_status']!=1){ 
							$no_par_data.="<p>It is observed that the Assessed Level is equal to, or greater than the required level of competency.Hence, no training needs are being recommended.</p>
							<p>As per the Competency process that was done, you have been found to be having NO observable gap, between the required level of competencies for the job versus your assessed level.  However, in order to help your development, the org. has initiated a process which will help you further strengthen your skills & knowledge.  </p>";
							$no_par_data.="<a href='".BASE_URL."/employee/employee_assessment_competency?ass_type=ASS&tna=1&jid=".$_REQUEST['jid']."&ass_id=".$_REQUEST['assessment_id']."&pos_id=".$_REQUEST['position_id']."&emp_id=".$_SESSION['emp_id']."' class='btn btn-primary'>Identify Training Areas </a>";
						}
						else{
							$no_par_data.="<div class='assessment-head-title'><b>Identification of Competencies for Development</b></div>
							<a href='".BASE_URL."/employee/employee_assessment_rating_final?ass_type=ASS&tna=1&jid=".$_REQUEST['jid']."&ass_id=".$_REQUEST['assessment_id']."&pos_id=".$_REQUEST['position_id']."&emp_id=".$_SESSION['emp_id']."' class='btn btn-primary'>View Programs </a>";
						}
						echo empty($para_data)?$no_par_data:$para_data;?>
						<?php 
						if(!empty($para_data)){
						$training_area=UlsAssessmentEmployeeDevRating::get_emp_rating($_REQUEST['assessment_id'],$_REQUEST['position_id'],$_SESSION['emp_id']);
						if(count($training_area)==0){
						?>
						<div class="assessment-head-title"><b>Identifying Specific Training Areas</b></div>
						<div class="space-20"></div>
						<p>Identify the specific Training requirements  that you have in each of the competencies. </p>
						
						<a href="<?php echo BASE_URL; ?>/employee/employee_assessment_competency?ass_type=ASS&jid=<?php echo $_REQUEST['jid']; ?>&ass_id=<?php echo $_REQUEST['assessment_id']; ?>&pos_id=<?php echo $_REQUEST['position_id']; ?>&emp_id=<?php echo $_SESSION['emp_id']; ?>" class="btn btn-primary">Identify Training Areas </a>
					<?php
						}
						else{
						?>
						<div class="assessment-head-title"><b>View Identified Specific Training Areas</b></div>
						<a href="<?php echo BASE_URL; ?>/employee/employee_assessment_rating_final?ass_type=ASS&jid=<?php echo $_REQUEST['jid']; ?>&ass_id=<?php echo $_REQUEST['assessment_id']; ?>&pos_id=<?php echo $_REQUEST['position_id']; ?>&emp_id=<?php echo $_SESSION['emp_id']; ?>" class="btn btn-primary">View Programs </a>
						<?php
						}
						}
					} 
					else{
					?>
					
						<?php 
						if($ass_details['ass_pro_selection']=='Y'){
							if($jour_details['tni_status']!=1){
								
							?>
							<p>Citing the fact that the assessment couldn't be completed, the following methodology has been devised to capture the learning needs.</p>
							<a href='<?php echo BASE_URL;?>/employee/employee_assessment_competency?ass_type=ASS&tna=1&jid=<?php echo $_REQUEST['jid'];?>&ass_id=<?php echo $_REQUEST['assessment_id'];?>&pos_id=<?php echo $_REQUEST['position_id'];?>&emp_id=<?php echo $_SESSION['emp_id'];?>' class='btn btn-primary'>Identify Training Areas </a>
							<?php
							}
							else{
							?>
							<div class="assessment-head-title"><b>Identification of Competencies for Development</b></div>
							<a href="<?php echo BASE_URL; ?>/employee/employee_assessment_rating_final?ass_type=ASS&jid=<?php echo $_REQUEST['jid']; ?>&ass_id=<?php echo $_REQUEST['assessment_id']; ?>&pos_id=<?php echo $_REQUEST['position_id']; ?>&emp_id=<?php echo $_SESSION['emp_id']; ?>" class="btn btn-primary">View Programs </a>
							<?php
							}
						}
						else{
						?>
						<p>The purpose of assessment is to help in development.  Once the report is generated, you will get a complete development road map.</p>
						<?php
						}
					}
				}
				else{
					
				?>
				<div class="assessment-head-title"><b>Identification of Competencies for Development </b></div>
				<div class="space-20"></div>
				<p>This is Competency framework based Training Needs Identification process.  Based on the Competency Profile of your position, a set of competencies along with the indicators for the same will be shown to you in the ensuing screens. You will have to Select the Competencies and/or the Indicators, to identify your specific Training Needs. </p>
				<?php 
				/* if($jour_details['tni_status']!=1){
				?>
				<a href="<?php echo BASE_URL; ?>/employee/employee_assessment_competency?ass_type=ASS&jid=<?php echo $_REQUEST['jid']; ?>&ass_id=<?php echo $_REQUEST['assessment_id']; ?>&pos_id=<?php echo $_REQUEST['position_id']; ?>&emp_id=<?php echo $_SESSION['emp_id']; ?>" class="btn btn-primary">Identify Training Areas </a>
				<?php
				}
				else{
				?>
				<div class="assessment-head-title"><b>Identification of Competencies for Development</b></div>
					<a href="<?php echo BASE_URL; ?>/employee/employee_assessment_rating_final?ass_type=ASS&jid=<?php echo $_REQUEST['jid']; ?>&ass_id=<?php echo $_REQUEST['assessment_id']; ?>&pos_id=<?php echo $_REQUEST['position_id']; ?>&emp_id=<?php echo $_SESSION['emp_id']; ?>" class="btn btn-primary">View Programs </a>
				<?php
				} */
				}
				?>
			</div>
		</div>
	</div>
</div>
		