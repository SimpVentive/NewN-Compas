<div class="body-section">
	<div class="assessment-scroll-block custom-scroll">
		<div class="assessment-section">

			<div class="assessment-head">
				<div class="d-flex align-items-center justify-content-between">
					<div class="assessment-head-title">360 degree feedback process </div>
					
				</div>
				<ul class="assessment-info-list">
					<li class="assessment-item">
						<i class="icon material-icons">assignment_turned_in</i>
						<span class="align-middle">Feedback</span>
						<i class="info-icon material-icons">info</i>
					</li>
					
					
				</ul>
				
			</div>

			<div class="assessment-body">
				<div class="space-40"></div>
				<div class="assessment-text">Description</div>
				<p class="assessment-content"></p>

				<!--<div class="space-20"></div>

				<div class="row">
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
								<p class="content">Once you complete the assessment process, you will get… <a href="javascript:;" data-toggle="modal" data-target="#ass-report-modal">Read more</a></p>
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
								<p class="content">The purpose of assessment is to help in development… <a href="javascript:;" data-toggle="modal" data-target="#ass-dev-modal">Read more</a></p>
							</div>
						</div>
					</div>
				</div>

				<div class="space-60"></div>-->

				<div class="row">
				<?php 
				foreach($feed_others_details as $feed_others_detail){
					$date_parts1=date('Y-m-d');
					$date_parts2=date($feed_others_detail['end_date']);
					//$date=($date_parts2-$date_parts1)/(60*60*24);
					//echo "<br>".$feed_others_detail['group_id'];
					$group=UlsAssessmentFeedEmployees::fetch_group($feed_others_detail['group_id']);
					$manager=$peer=$sub=$cus=$intcus=0;
					$ss='';
					$a1=0;
					$a2='';
					if(!empty($group['manager_id'])){
						if(empty($ss)){
							$ss=$group['manager_id'];
						}
						else{
							$ss=$ss.','.$group['manager_id'];
						}
					}
					if(!empty($group['peer_id'])){
						if(empty($ss)){
							$ss=$group['peer_id'];
						}
						else{
							$ss=$ss.','.$group['peer_id'];
						}
					}
					if(!empty($group['sub_ordinates_id'])){
						if(empty($ss)){
							$ss=$group['sub_ordinates_id'];
						}
						else{
							$ss=$ss.','.$group['sub_ordinates_id'];
						}
					}
					if(!empty($group['m_m_id'])){
						if(empty($ss)){
							$ss=$group['m_m_id'];
						}
						else{
							$ss=$ss.','.$group['m_m_id'];
						}
					}
					if(!empty($group['s_s_id'])){
						if(empty($ss)){
							$ss=$group['s_s_id'];
						}
						else{
							$ss=$ss.','.$group['s_s_id'];
						}
					}
					if(!empty($group['customer_id'])){
						if(empty($ss)){
							$ss=$group['customer_id'];
						}
						else{
							$ss=$ss.','.$group['customer_id'];
						}
					}
					//echo $ss;
					$a=explode(',',$ss);
					if(in_array($_SESSION['emp_id'],$a)){
						if(empty($a2)){
							 $a2=$group['employee_id'];
						}
						else{
							 $a2=$a2.",".$group['employee_id'];
						}
						$a1=$a1+1;
					}
					//print_r($a2);
					$user_n=UlsEmployeeMaster::get_emp_group($a2);
					foreach($user_n as $key=>$view){
						$ass_name=UlsAssessmentTestFeedback::get_feedback_group($feed_others_detail['feed_assess_test_id']);
				?>
					<div class="col-4">
						<div class="assessment-info assessment-box">
							<div class="icon">
								<i class="icon material-icons">assignment_turned_in</i>
							</div>
							<div class="info">
								<div class="name"><?php echo $ass_name['assessment_name']; ?></div>
								<p class="content"><?php echo $ass_name['position_name']; ?></p>
								<div class="content">
									<span><?php echo $view['employee_number']."-".$view['full_name']; ?></span>
								</div>
								<div class="content">
									<span>End Date</span>
									<span>|</span>
									<span><?php echo $date_parts2; ?></span>
								</div>
								<?php 
								$rating_status=UlsFeedbackEmployeeRating::get_rating_status($ass_name['assess_test_id'],$view['employee_id']);
								if(empty($rating_status['status'])){
									if($feed_others_detail['end_date']>=date('Y-m-d')){
										if($feed_others_detail['ass_start_date']<=date('Y-m-d') && $feed_others_detail['ass_end_date']>=date('Y-m-d')){
										?>
										<a href="<?php echo BASE_URL; ?>/employee/employee_feed_other_rating?sid=<?php echo $view['employee_id'];?>&assess_test_id=<?php echo $ass_name['assess_test_id'];?>" class="btn btn-primary inbasket-exam-btn">Start</a>
										<?php 
										}
										else{
										?>
										<a href="#" class="btn btn-primary inbasket-exam-btn">Locked</a>
										<?php 
										}
									}
									else{
										?>
										<a href="#" class="btn btn-primary inbasket-exam-btn">Locked</a>
										<?php
									}
								}
								elseif($rating_status['status']=='C'){
								?>
								<a href="#" class="btn btn-primary inbasket-exam-btn">Completed</a>
								<?php
								}
								elseif($rating_status['status']=='W'){
									if($feed_others_detail['end_date']>=date('Y-m-d')){
										?>
										<a href="<?php echo BASE_URL; ?>/employee/employee_feed_other_rating?sid=<?php echo $view['employee_id'];?>&assess_test_id=<?php echo $ass_name['assess_test_id'];?>" class="btn btn-primary inbasket-exam-btn">Inprocess</a>
										<?php 
									}
									else{
										?>
										<a href="#" class="btn btn-primary inbasket-exam-btn">Locked</a>
										<?php
									}
									
								}
								?>
							</div>
							<div class="progress-bar">
								<span class="progress" style="width: 100%;"></span>
							</div>
						</div>
					</div>
				<?php } 
				}
				?>
				</div>
				
				
				
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

<div class="modal fade case-modal" id="ass-report-modal" tabindex="-1" role="dialog">
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
				
					<p>Once you complete the assessment process, you will get a detailed assessment report which details your knowledge and skill in various identified competencies.</p>
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade case-modal" id="ass-dev-modal" tabindex="-1" role="dialog">
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
				
					<p>The purpose of assessment is to help in development.  Once the report is generated, you will get a complete development road map.</p>
				
			</div>
		</div>
	</div>
</div>
		