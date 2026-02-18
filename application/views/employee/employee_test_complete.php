<section class="main-section">
	<div class="test-complete">
		<div class="table-cell">
			<div class="icon">
				<img src="<?php echo BASE_URL;?>/public/new_layout/images/document-success.png" alt="">
			</div>
			<?php 
			if($_REQUEST['pro']=='TEST'){
				$ass_name='Test';
			}
			elseif($_REQUEST['pro']=='INBASKET'){
				$ass_name='Inbasket';
			}
			elseif($_REQUEST['pro']=='CASE_STUDY'){
				$ass_name='Case Study';
			}
			elseif($_REQUEST['pro']=='FISHBONE'){
				$ass_name='FIshbone';
			}
			/* elseif($_REQUEST['pro']=='FEEDBACK'){
				$ass_name='360 Degree Feedback Process';
			} */
			elseif($_REQUEST['pro']=='BEHAVORIAL_INSTRUMENT'){
				$ass_name='Instrument Process';
			}
			/* elseif($_REQUEST['pro']=='RISK'){
				$ass_name='Risk Management';
			} */
			elseif($_REQUEST['pro']=='DEFECT'){
				$ass_name='Defect Identification Skill';
			}
			$test_beh=UlsAssessmentTestBehavorialInst::viewbehavorial_count($_REQUEST['assessment_id'],$_REQUEST['position_id']);
			$test_casestudy=UlsAssessmentTestCasestudy::viewcasestudy_count_report($_REQUEST['assessment_id'],$_REQUEST['position_id']);
			$test_inbasket=UlsAssessmentTestInbasket::viewinbasket_count_report($_REQUEST['assessment_id'],$_REQUEST['position_id']);
			//$test_feedback=UlsAssessmentTestFeedback::viewfeedback_count_report($_REQUEST['assessment_id'],$_REQUEST['position_id']);
			$test_fishbone=UlsAssessmentTestFishbone::viewfishbone_count_report($_REQUEST['assessment_id'],$_REQUEST['position_id']);
			//$test_risk=UlsAssessmentTestRisk::viewrisk_count_report($_REQUEST['assessment_id'],$_REQUEST['position_id']);
			$ass_test=UlsAssessmentTest::assessment_test_report($_REQUEST['assessment_id'],$_REQUEST['position_id']);
			$count_case=$count_in=$count_beh=$count_test=$count_fish=$count_risk="";
			$status_test=$status_inb=$status_case=$status_beh=$status_fish=$status_feed=$status_risk="";
			foreach($ass_test as $ass_tests){
				$ass_type[]=$ass_tests['assessment_type'];
				if($ass_tests['assessment_type']=='CASE_STUDY'){
					
					$count_case=count($test_casestudy);
					$status_case=0;
					foreach($test_casestudy as $key=>$test_casestudys){
						
						$case_emp=UlsMenu::callpdorow("SELECT count(*) as case_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$ass_tests['assessment_id']." and test_type='CASE_STUDY' and `employee_id`=".$_SESSION['emp_id']." and event_id=".$test_casestudys['assess_test_id']." and status='A' and test_id=".$test_casestudys['test_id']);
						$status_case+=!empty($case_emp['case_test'])?$case_emp['case_test']:0;
					}
				}
				elseif($ass_tests['assessment_type']=='INBASKET'){
					
					$count_in=count($test_inbasket);
					$status_inb=0;
					foreach($test_inbasket as $key=>$test_inbaskets){
						$inb_emp=UlsMenu::callpdorow("SELECT count(*) as inbasket_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$ass_tests['assessment_id']." and test_type='INBASKET' and `employee_id`=".$_SESSION['emp_id']." and event_id=".$test_inbaskets['assess_test_id']." and status='A' and test_id=".$test_inbaskets['test_id']);
						$status_inb+=!empty($inb_emp['inbasket_test'])?$inb_emp['inbasket_test']:0;
					}
				}
				/* elseif($ass_tests['assessment_type']=='RISK'){
					
					$count_risk=count($test_risk);
					$status_risk=0;
					foreach($test_risk as $key=>$test_risks){
						$risk_emp=UlsMenu::callpdorow("SELECT count(*) as risk_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$ass_tests['assessment_id']." and test_type='INBASKET' and `employee_id`=".$_SESSION['emp_id']." and event_id=".$test_risks['assess_test_id']." and status='A' and test_id=".$test_risks['test_id']);
						$status_risk+=!empty($risk_emp['risk_test'])?$risk_emp['risk_test']:0;
					}
				} */
				
				elseif($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
					$count_beh=count($test_beh);
					$status_beh=0;
					foreach($test_beh as $key=>$test_behs){
						//echo $test_behs['assess_test_id'];
						$beh_emp=UlsMenu::callpdorow("SELECT count(*) as beh_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_bei_attempts_assessment` where `assessment_id`=".$ass_tests['assessment_id']." and test_type='BEHAVORIAL_INSTRUMENT' and `employee_id`=".$_SESSION['emp_id']." and status='A' and event_id=".$test_behs['assess_test_id']." and instrument_id=".$test_behs['instrument_id']);
						$status_beh+=!empty($beh_emp['beh_test'])?$beh_emp['beh_test']:0;
					}
				}
				/* elseif($ass_tests['assessment_type']=='FEEDBACK'){
					$count_feed=count($test_feedback);
					$status_feed=0;
					foreach($test_feedback as $key=>$test_feedbacks){
						//echo $test_behs['assess_test_id'];
						$feedback_emp=UlsMenu::callpdorow("SELECT count(distinct(employee_id)) as feed_test FROM `uls_feedback_employee_rating` where `assessment_id`=".$ass_tests['assessment_id']." and `employee_id`=".$_SESSION['emp_id']." and ass_test_id=".$test_feedbacks['assess_test_id']);
						$status_feed+=!empty($feedback_emp['feed_test'])?$feedback_emp['feed_test']:0;
					}
					
				} */
				elseif($ass_tests['assessment_type']=='FISHBONE'){
					$count_fish=count($test_fishbone);
					$status_fish=0;
					foreach($test_fishbone as $key=>$test_fishbones){
						$fish_emp=UlsMenu::callpdorow("SELECT count(*) as fishbone_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$ass_tests['assessment_id']." and test_type='FISHBONE' and status='A' and `employee_id`=".$_SESSION['emp_id']." and event_id=".$test_fishbones['assess_test_id']." and test_id=".$test_fishbones['test_id']);
						$status_fish+=!empty($fish_emp['fishbone_test'])?$fish_emp['fishbone_test']:0;
					}
				}
				elseif($ass_tests['assessment_type']=='DEFECT'){
					$count_defect=1;
					
					
					$defect_emp=UlsMenu::callpdorow("SELECT count(*) as ass_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$ass_tests['assessment_id']." and status='A' and test_type='DEFECT' and `employee_id`=".$_SESSION['emp_id']." and event_id=".$ass_tests['assess_test_id']." and test_id=".$ass_tests['test_id']);
					$status_defect=!empty($defect_emp['ass_test'])?$defect_emp['ass_test']:0;
				}
				elseif($ass_tests['assessment_type']=='TEST'){
					$count_test=1;
					
					
					$test_emp=UlsMenu::callpdorow("SELECT count(*) as ass_test,`status`,`employee_id`,`event_id`,`assessment_id`,`attempt_status` FROM `uls_utest_attempts_assessment` where `assessment_id`=".$ass_tests['assessment_id']." and status='A' and test_type='TEST' and `employee_id`=".$_SESSION['emp_id']." and event_id=".$ass_tests['assess_test_id']." and test_id=".$ass_tests['test_id']);
					$status_test=!empty($test_emp['ass_test'])?$test_emp['ass_test']:0;
				}
			}
			$count_td=@($count_test+$count_case+$count_in+$count_beh+$count_fish+$count_defect);
			$count_comp=@($status_test+$status_inb+$status_case+$status_beh+$status_fish+$status_defect);
			//echo $count_td."-".$count_comp;
			//echo $status_test."-".$status_inb."-".$status_case."-".$status_beh."-".$status_fish;
			?>
			<div class="title"><?php echo $ass_name; ?> has been submitted successfully</div>
			<?php
			if($count_td==$count_comp){
				
			?>
			<p class="go-back-text"><a href="<?php echo BASE_URL;?>/employee/employee_feedback_details?jid=<?php echo $_REQUEST['jid'];?>&pro=<?php echo $_REQUEST['pro'];?>&asstype=<?php echo $_REQUEST['asstype'];?>&assessment_id=<?php echo $_REQUEST['assessment_id'];?>&position_id=<?php echo $_REQUEST['position_id'];?>&assessment_pos_id=<?php echo $_REQUEST['assessment_pos_id'];?>">Click here to give feedback</a></p>
			<?php
			}
			else{
			?>
			<p class="go-back-text"><a href="<?php echo BASE_URL;?>/employee/employee_assessment_details?jid=<?php echo $_REQUEST['jid'];?>&pro=<?php echo $_REQUEST['pro'];?>&asstype=<?php echo $_REQUEST['asstype'];?>&assessment_id=<?php echo $_REQUEST['assessment_id'];?>&position_id=<?php echo $_REQUEST['position_id'];?>&assessment_pos_id=<?php echo $_REQUEST['assessment_pos_id'];?>">Click here to go back to homepage</a></p>
			<?php	
			}
			?>
			<p class="redirect-text">Automatically redirecting in <span id="count-down">5</span> seconds</p>
		</div>
	</div>
</section>

<script type="text/javascript">
	
	let counter = 5;
	var interval = setInterval(function() {
		counter--;
		document.getElementById('count-down').innerHTML = counter;
		if (counter == 0) {
			clearInterval(interval);
			<?php
			if($count_td==$count_comp){
					
			?>
			window.location.href ="<?php echo BASE_URL;?>/employee/employee_feedback_details?jid=<?php echo $_REQUEST['jid'];?>&pro=<?php echo $_REQUEST['pro'];?>&asstype=<?php echo $_REQUEST['asstype'];?>&assessment_id=<?php echo $_REQUEST['assessment_id'];?>&position_id=<?php echo $_REQUEST['position_id'];?>&assessment_pos_id=<?php echo $_REQUEST['assessment_pos_id'];?>";
			<?php 
			}
			else{
				
			?>
			window.location.href ="<?php echo BASE_URL;?>/employee/employee_assessment_details?jid=<?php echo $_REQUEST['jid'];?>&pro=<?php echo $_REQUEST['pro'];?>&asstype=<?php echo $_REQUEST['asstype'];?>&assessment_id=<?php echo $_REQUEST['assessment_id'];?>&position_id=<?php echo $_REQUEST['position_id'];?>&assessment_pos_id=<?php echo $_REQUEST['assessment_pos_id'];?>";
			<?php
			}
			?>
		}
	}, 1000);
</script>
